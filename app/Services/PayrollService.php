<?php

namespace App\Services;

use App\Models\HR\Employee;
use App\Models\HR\Payroll;
use App\Models\HR\Attendance;
use App\Models\HR\Penalty;
use App\Models\HR\Advance;
use App\Models\Setting\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PayrollService
{
    protected int $year;
    protected int $month;
    protected int $workingDaysPerMonth;
    protected int $workingHoursPerDay;
    protected float $overtimeMultiplier;
    protected float $weekendOvertimeMultiplier;
    protected int $overtimeAfterHours;
    protected array $weekendDays;

    public function __construct()
    {
        $this->loadSettings();
    }

    protected function loadSettings(): void
    {
        $this->workingDaysPerMonth = (int) Setting::get('attendance.working_days_per_month', 22);
        $this->workingHoursPerDay = (int) Setting::get('attendance.working_hours_per_day', 8);
        $this->overtimeMultiplier = (float) Setting::get('attendance.overtime_multiplier', 1.5);
        $this->weekendOvertimeMultiplier = (float) Setting::get('attendance.weekend_overtime_multiplier', 2);
        $this->overtimeAfterHours = (int) Setting::get('attendance.overtime_after_hours', 8);
        
        $weekendDaysStr = Setting::get('attendance.weekend_days', '5,6');
        $this->weekendDays = array_map('intval', explode(',', $weekendDaysStr));
    }

    /**
     * Generate payroll for a specific month
     */
    public function generatePayroll(int $year, int $month, ?array $employeeIds = null): array
    {
        $this->year = $year;
        $this->month = $month;

        $query = Employee::where('is_active', true)->with(['department', 'company']);
        
        if ($employeeIds) {
            $query->whereIn('id', $employeeIds);
        }

        $employees = $query->get();
        $results = ['success' => 0, 'failed' => 0, 'skipped' => 0, 'errors' => []];

        foreach ($employees as $employee) {
            try {
                // Check if payroll already exists
                $existing = Payroll::where('employee_id', $employee->id)
                    ->where('year', $year)
                    ->where('month', $month)
                    ->first();

                if ($existing && $existing->status !== 'pending') {
                    $results['skipped']++;
                    continue;
                }

                $payrollData = $this->calculatePayroll($employee);
                
                if ($existing) {
                    $existing->update($payrollData);
                } else {
                    $payrollData['code'] = $this->generateCode();
                    $payrollData['employee_id'] = $employee->id;
                    $payrollData['month'] = $month;
                    $payrollData['year'] = $year;
                    $payrollData['generated_by'] = auth()->id();
                    
                    Payroll::create($payrollData);
                }

                $results['success']++;
            } catch (\Exception $e) {
                $results['failed']++;
                $results['errors'][] = [
                    'employee' => $employee->full_name,
                    'error' => $e->getMessage()
                ];
            }
        }

        return $results;
    }

    /**
     * Calculate payroll for a single employee
     * 
     * Logic:
     * 1. Daily Rate = Monthly Salary / Required Working Days
     * 2. Hourly Rate = Daily Rate / Working Hours Per Day
     * 3. Earned Salary = Daily Rate × Actual Working Days (present + half_days×0.5)
     * 4. Overtime Amount = OT Hours × Hourly Rate × OT Multiplier
     * 5. Net Salary = Earned Salary + Overtime + Bonuses - Deductions (Penalties + Advances)
     */
    public function calculatePayroll(Employee $employee): array
    {
        $monthlySalary = (float) $employee->salary;
        
        // Calculate daily and hourly rates
        $dailyRate = $monthlySalary / $this->workingDaysPerMonth;
        $hourlyRate = $dailyRate / $this->workingHoursPerDay;

        // Get attendance data for the month
        $attendanceData = $this->getAttendanceData($employee->id);

        // Calculate actual working days (present days + half days as 0.5)
        $actualWorkingDays = $attendanceData['present_days'] + ($attendanceData['half_days'] * 0.5);
        
        // Calculate earned salary based on actual working days
        $earnedSalary = $dailyRate * $actualWorkingDays;

        // Calculate overtime (separate from basic salary)
        $overtimeAmount = $attendanceData['overtime_hours'] * $hourlyRate * $this->overtimeMultiplier;
        $weekendOvertimeAmount = $attendanceData['weekend_overtime_hours'] * $hourlyRate * $this->weekendOvertimeMultiplier;
        $totalOvertimeAmount = $overtimeAmount + $weekendOvertimeAmount;

        // Calculate late deduction
        $lateDeduction = $this->calculateLateDeduction($attendanceData['late_minutes'], $hourlyRate);

        // Get pending penalties (financial, approved, not yet deducted)
        $penaltiesData = $this->getPendingPenalties($employee->id);
        
        // Get pending advance installments
        $advancesData = $this->getPendingAdvanceInstallments($employee->id);

        // Calculate total deductions
        $totalDeductions = $lateDeduction + $penaltiesData['total'] + $advancesData['total'];

        // Gross salary = Earned salary + Overtime
        $grossSalary = $earnedSalary + $totalOvertimeAmount;
        
        // Net salary = Gross - All Deductions
        $netSalary = $grossSalary - $totalDeductions;

        return [
            'basic_salary' => $monthlySalary,
            'working_days' => $this->workingDaysPerMonth,
            'actual_working_days' => $actualWorkingDays,
            'working_hours_per_day' => $this->workingHoursPerDay,
            'hourly_rate' => round($hourlyRate, 2),
            
            'earned_salary' => round($earnedSalary, 2),
            
            'overtime_hours' => $attendanceData['overtime_hours'],
            'overtime_multiplier' => $this->overtimeMultiplier,
            'overtime_amount' => round($overtimeAmount, 2),
            
            'weekend_overtime_hours' => $attendanceData['weekend_overtime_hours'],
            'weekend_overtime_multiplier' => $this->weekendOvertimeMultiplier,
            'weekend_overtime_amount' => round($weekendOvertimeAmount, 2),
            
            'total_overtime_amount' => round($totalOvertimeAmount, 2),
            
            'absent_days' => $attendanceData['absent_days'],
            'absent_deduction' => 0,
            
            'half_days' => $attendanceData['half_days'],
            'half_day_deduction' => 0,
            
            'late_minutes' => $attendanceData['late_minutes'],
            'late_deduction' => round($lateDeduction, 2),
            
            // Deduction details
            'deductions' => round($totalDeductions, 2),
            'deduction_details' => [
                'late' => round($lateDeduction, 2),
                'penalties' => $penaltiesData['total'],
                'penalty_ids' => $penaltiesData['ids'],
                'advances' => $advancesData['total'],
                'advance_ids' => $advancesData['ids'],
            ],
            
            'bonuses' => 0,
            
            'gross_salary' => round($grossSalary, 2),
            'net_salary' => round($netSalary, 2),
            
            'status' => 'pending',
        ];
    }

    /**
     * Get pending financial penalties for an employee
     */
    protected function getPendingPenalties(int $employeeId): array
    {
        $penalties = Penalty::where('employee_id', $employeeId)
            ->where('type', 'financial')
            ->where('status', 'approved')
            ->where('deduct_from_salary', true)
            ->where('deducted', false)
            ->get();

        return [
            'total' => round($penalties->sum('amount'), 2),
            'ids' => $penalties->pluck('id')->toArray(),
            'count' => $penalties->count(),
        ];
    }

    /**
     * Get pending advance installments for an employee
     */
    protected function getPendingAdvanceInstallments(int $employeeId): array
    {
        $advances = Advance::where('employee_id', $employeeId)
            ->where('status', 'disbursed')
            ->where('remaining_amount', '>', 0)
            ->where('start_deduction_date', '<=', Carbon::create($this->year, $this->month, 1)->endOfMonth())
            ->get();

        $total = 0;
        $ids = [];

        foreach ($advances as $advance) {
            $total += $advance->installment_amount;
            $ids[] = $advance->id;
        }

        return [
            'total' => round($total, 2),
            'ids' => $ids,
            'count' => count($ids),
        ];
    }

    /**
     * Apply deductions after payroll is approved/paid
     */
    public function applyDeductions(Payroll $payroll): void
    {
        $details = $payroll->deduction_details;
        
        if (!$details) return;

        // Mark penalties as deducted
        if (!empty($details['penalty_ids'])) {
            Penalty::whereIn('id', $details['penalty_ids'])->update([
                'deducted' => true,
                'deducted_in_payroll_id' => $payroll->id,
                'status' => 'applied',
            ]);
        }

        // Record advance deductions
        if (!empty($details['advance_ids'])) {
            foreach ($details['advance_ids'] as $advanceId) {
                $advance = Advance::find($advanceId);
                if ($advance) {
                    $advance->recordDeduction($advance->installment_amount, $payroll->id);
                }
            }
        }
    }

    /**
     * Get attendance data for an employee
     */
    protected function getAttendanceData(int $employeeId): array
    {
        $startDate = Carbon::create($this->year, $this->month, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $attendances = Attendance::where('employee_id', $employeeId)
            ->whereBetween('attendance_date', [$startDate, $endDate])
            ->get();

        $data = [
            'present_days' => 0,
            'absent_days' => 0,
            'half_days' => 0,
            'vacation_days' => 0,
            'overtime_hours' => 0,
            'weekend_overtime_hours' => 0,
            'late_minutes' => 0,
            'total_working_hours' => 0,
        ];

        foreach ($attendances as $attendance) {
            $dayOfWeek = Carbon::parse($attendance->attendance_date)->dayOfWeek;
            $isWeekend = in_array($dayOfWeek, $this->weekendDays);

            switch ($attendance->status) {
                case 'present':
                    $data['present_days']++;
                    $data['total_working_hours'] += (float) $attendance->working_hours;
                    
                    // Calculate overtime
                    $overtime = (float) ($attendance->overtime_hours ?? 0);
                    if ($overtime > 0) {
                        if ($isWeekend) {
                            $data['weekend_overtime_hours'] += $overtime;
                        } else {
                            $data['overtime_hours'] += $overtime;
                        }
                    }
                    break;
                    
                case 'absent':
                    $data['absent_days']++;
                    break;
                    
                case 'half_day':
                    $data['half_days']++;
                    $data['total_working_hours'] += (float) $attendance->working_hours;
                    break;
                    
                case 'vacation':
                case 'travel':
                    $data['vacation_days']++;
                    break;
            }

            // Calculate late minutes (if check_in is after shift start)
            // This would need shift data - simplified for now
        }

        return $data;
    }

    /**
     * Calculate late deduction
     */
    protected function calculateLateDeduction(int $lateMinutes, float $hourlyRate): float
    {
        // Deduct based on late hours
        $lateHours = $lateMinutes / 60;
        return $lateHours * $hourlyRate;
    }

    /**
     * Generate unique payroll code
     */
    protected function generateCode(): string
    {
        $prefix = 'PAY';
        $yearMonth = date('Ym');
        
        $lastPayroll = Payroll::where('code', 'like', "{$prefix}-{$yearMonth}-%")
            ->orderBy('code', 'desc')
            ->first();

        if ($lastPayroll) {
            $lastNumber = (int) substr($lastPayroll->code, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return sprintf('%s-%s-%04d', $prefix, $yearMonth, $newNumber);
    }

    /**
     * Approve payroll
     */
    public function approvePayroll(Payroll $payroll): bool
    {
        if ($payroll->status !== 'pending') {
            return false;
        }

        $payroll->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return true;
    }

    /**
     * Mark payroll as paid
     */
    public function markAsPaid(Payroll $payroll, ?string $paymentMethod = null, ?string $paymentDate = null): bool
    {
        if ($payroll->status !== 'approved') {
            return false;
        }

        $payroll->update([
            'status' => 'paid',
            'payment_method' => $paymentMethod,
            'payment_date' => $paymentDate ?? now(),
        ]);

        return true;
    }

    /**
     * Get payroll summary for a month
     */
    public function getMonthSummary(int $year, int $month): array
    {
        $payrolls = Payroll::forMonth($year, $month)->get();

        return [
            'total_employees' => $payrolls->count(),
            'total_basic_salary' => $payrolls->sum('basic_salary'),
            'total_overtime' => $payrolls->sum('total_overtime_amount'),
            'total_deductions' => $payrolls->sum('deductions'),
            'total_bonuses' => $payrolls->sum('bonuses'),
            'total_gross' => $payrolls->sum('gross_salary'),
            'total_net' => $payrolls->sum('net_salary'),
            'pending_count' => $payrolls->where('status', 'pending')->count(),
            'approved_count' => $payrolls->where('status', 'approved')->count(),
            'paid_count' => $payrolls->where('status', 'paid')->count(),
        ];
    }
}

<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\HR\Payroll;
use App\Models\HR\Employee;
use App\Models\HR\Department;
use App\Services\PayrollService;
use App\Helpers\Reply;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PayrollController extends Controller
{
    protected PayrollService $payrollService;

    public function __construct(PayrollService $payrollService)
    {
        $this->payrollService = $payrollService;
    }

    /**
     * Display payroll listing
     */
    public function index(Request $request)
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        $departments = Department::orderBy('name')->get();
        $employees = Employee::where('is_active', true)->orderBy('first_name')->get();
        
        // Get summary for the month
        $summary = $this->payrollService->getMonthSummary($year, $month);

        return view('hr.payroll.index', compact('year', 'month', 'departments', 'employees', 'summary'));
    }

    /**
     * Get payroll data for DataTable (AJAX)
     */
    public function getData(Request $request): JsonResponse
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);
        $departmentId = $request->get('department_id');
        $status = $request->get('status');
        $searchTerm = $request->get('search_term');

        $query = Payroll::with(['employee.department', 'employee.company'])
            ->where('year', $year)
            ->where('month', $month);

        if ($departmentId) {
            $query->whereHas('employee', function ($q) use ($departmentId) {
                $q->where('department_id', $departmentId);
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($searchTerm) {
            $query->whereHas('employee', function ($q) use ($searchTerm) {
                $q->where('first_name', 'like', "%{$searchTerm}%")
                  ->orWhere('last_name', 'like', "%{$searchTerm}%")
                  ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }

        $payrolls = $query->orderBy('created_at', 'desc')->get();

        $data = $payrolls->map(function ($payroll) {
            return [
                'id' => $payroll->id,
                'code' => $payroll->code,
                'employee' => [
                    'id' => $payroll->employee->id,
                    'name' => $payroll->employee->full_name,
                    'position' => $payroll->employee->position,
                    'department' => $payroll->employee->department->name ?? 'N/A',
                    'photo' => $payroll->employee->profile_picture_url ?? null,
                ],
                'basic_salary' => number_format($payroll->basic_salary, 2),
                'overtime_hours' => $payroll->overtime_hours + $payroll->weekend_overtime_hours,
                'overtime_amount' => number_format($payroll->total_overtime_amount, 2),
                'deductions' => number_format($payroll->deductions, 2),
                'bonuses' => number_format($payroll->bonuses, 2),
                'net_salary' => number_format($payroll->net_salary, 2),
                'status' => $payroll->status,
                'status_color' => $payroll->status_color,
                'status_label' => $payroll->status_label,
            ];
        });

        // Calculate summary
        $summary = [
            'total_employees' => $payrolls->count(),
            'total_basic' => number_format($payrolls->sum('basic_salary'), 2),
            'total_overtime' => number_format($payrolls->sum('total_overtime_amount'), 2),
            'total_deductions' => number_format($payrolls->sum('deductions'), 2),
            'total_net' => number_format($payrolls->sum('net_salary'), 2),
            'pending' => $payrolls->where('status', 'pending')->count(),
            'approved' => $payrolls->where('status', 'approved')->count(),
            'paid' => $payrolls->where('status', 'paid')->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $data,
            'summary' => $summary,
        ]);
    }

    /**
     * Generate payroll for employees
     */
    public function generate(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'year' => 'required|integer|min:2020|max:2100',
            'month' => 'required|integer|min:1|max:12',
            'employee_ids' => 'nullable|array',
            'employee_ids.*' => 'exists:employees,id',
        ]);

        if ($validator->fails()) {
            return Reply::error('Validation error', ['errors' => $validator->errors()], 422);
        }

        try {
            $results = $this->payrollService->generatePayroll(
                $request->year,
                $request->month,
                $request->employee_ids
            );

            $message = "Payroll generated: {$results['success']} success, {$results['failed']} failed, {$results['skipped']} skipped";
            
            return Reply::success($message, ['results' => $results]);
        } catch (\Exception $e) {
            return Reply::error('Failed to generate payroll: ' . $e->getMessage(), [], 500);
        }
    }

    /**
     * Show payroll details
     */
    public function show(Payroll $payroll): JsonResponse
    {
        $payroll->load(['employee.department', 'employee.company', 'generatedBy', 'approvedBy']);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $payroll->id,
                'code' => $payroll->code,
                'period' => $payroll->period,
                'employee' => [
                    'id' => $payroll->employee->id,
                    'name' => $payroll->employee->full_name,
                    'position' => $payroll->employee->position,
                    'department' => $payroll->employee->department->name ?? 'N/A',
                    'company' => $payroll->employee->company->name ?? 'N/A',
                ],
                'basic_salary' => $payroll->basic_salary,
                'working_days' => $payroll->working_days,
                'actual_working_days' => $payroll->actual_working_days,
                'hourly_rate' => $payroll->hourly_rate,
                
                'overtime_hours' => $payroll->overtime_hours,
                'overtime_multiplier' => $payroll->overtime_multiplier,
                'overtime_amount' => $payroll->overtime_amount,
                
                'weekend_overtime_hours' => $payroll->weekend_overtime_hours,
                'weekend_overtime_multiplier' => $payroll->weekend_overtime_multiplier,
                'weekend_overtime_amount' => $payroll->weekend_overtime_amount,
                
                'total_overtime_amount' => $payroll->total_overtime_amount,
                
                'absent_days' => $payroll->absent_days,
                'absent_deduction' => $payroll->absent_deduction,
                'half_days' => $payroll->half_days,
                'half_day_deduction' => $payroll->half_day_deduction,
                'late_minutes' => $payroll->late_minutes,
                'late_deduction' => $payroll->late_deduction,
                
                'deductions' => $payroll->deductions,
                'bonuses' => $payroll->bonuses,
                'gross_salary' => $payroll->gross_salary,
                'net_salary' => $payroll->net_salary,
                
                'status' => $payroll->status,
                'status_label' => $payroll->status_label,
                'status_color' => $payroll->status_color,
                
                'payment_date' => $payroll->payment_date?->format('Y-m-d'),
                'payment_method' => $payroll->payment_method,
                'notes' => $payroll->notes,
                
                'generated_by' => $payroll->generatedBy?->name,
                'approved_by' => $payroll->approvedBy?->name,
                'approved_at' => $payroll->approved_at?->format('Y-m-d H:i'),
                'created_at' => $payroll->created_at->format('Y-m-d H:i'),
            ],
        ]);
    }

    /**
     * Update payroll (add bonuses/deductions)
     */
    public function update(Request $request, Payroll $payroll): JsonResponse
    {
        if ($payroll->status === 'paid') {
            return Reply::error('Cannot update paid payroll', [], 400);
        }

        $validator = Validator::make($request->all(), [
            'bonuses' => 'nullable|numeric|min:0',
            'bonus_details' => 'nullable|array',
            'deductions' => 'nullable|numeric|min:0',
            'deduction_details' => 'nullable|array',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return Reply::error('Validation error', ['errors' => $validator->errors()], 422);
        }

        try {
            $bonuses = (float) ($request->bonuses ?? $payroll->bonuses);
            $deductions = (float) ($request->deductions ?? $payroll->deductions);
            
            // Recalculate net salary
            $grossSalary = $payroll->basic_salary + $payroll->total_overtime_amount + $bonuses;
            $totalDeductions = $payroll->absent_deduction + $payroll->half_day_deduction + $payroll->late_deduction + $deductions;
            $netSalary = $grossSalary - $totalDeductions;

            $payroll->update([
                'bonuses' => $bonuses,
                'bonus_details' => $request->bonus_details,
                'deductions' => $deductions,
                'deduction_details' => $request->deduction_details,
                'gross_salary' => $grossSalary,
                'net_salary' => $netSalary,
                'notes' => $request->notes ?? $payroll->notes,
            ]);

            return Reply::success('Payroll updated successfully');
        } catch (\Exception $e) {
            return Reply::error('Failed to update payroll: ' . $e->getMessage(), [], 500);
        }
    }

    /**
     * Approve payroll
     */
    public function approve(Payroll $payroll): JsonResponse
    {
        if ($payroll->status !== 'pending') {
            return Reply::error('Only pending payrolls can be approved', [], 400);
        }

        try {
            $this->payrollService->approvePayroll($payroll);
            return Reply::success('Payroll approved successfully');
        } catch (\Exception $e) {
            return Reply::error('Failed to approve payroll: ' . $e->getMessage(), [], 500);
        }
    }

    /**
     * Bulk approve payrolls
     */
    public function bulkApprove(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'payroll_ids' => 'required|array|min:1',
            'payroll_ids.*' => 'exists:payrolls,id',
        ]);

        if ($validator->fails()) {
            return Reply::error('Validation error', ['errors' => $validator->errors()], 422);
        }

        $approved = 0;
        $failed = 0;

        foreach ($request->payroll_ids as $id) {
            $payroll = Payroll::find($id);
            if ($payroll && $payroll->status === 'pending') {
                $this->payrollService->approvePayroll($payroll);
                $approved++;
            } else {
                $failed++;
            }
        }

        return Reply::success("Approved: {$approved}, Failed: {$failed}");
    }

    /**
     * Mark payroll as paid
     */
    public function markPaid(Request $request, Payroll $payroll): JsonResponse
    {
        if ($payroll->status !== 'approved') {
            return Reply::error('Only approved payrolls can be marked as paid', [], 400);
        }

        $validator = Validator::make($request->all(), [
            'payment_method' => 'nullable|string|max:100',
            'payment_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return Reply::error('Validation error', ['errors' => $validator->errors()], 422);
        }

        try {
            $this->payrollService->markAsPaid($payroll, $request->payment_method, $request->payment_date);
            return Reply::success('Payroll marked as paid');
        } catch (\Exception $e) {
            return Reply::error('Failed to mark payroll as paid: ' . $e->getMessage(), [], 500);
        }
    }

    /**
     * Bulk mark as paid
     */
    public function bulkPaid(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'payroll_ids' => 'required|array|min:1',
            'payroll_ids.*' => 'exists:payrolls,id',
            'payment_method' => 'nullable|string|max:100',
            'payment_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return Reply::error('Validation error', ['errors' => $validator->errors()], 422);
        }

        $paid = 0;
        $failed = 0;

        foreach ($request->payroll_ids as $id) {
            $payroll = Payroll::find($id);
            if ($payroll && $payroll->status === 'approved') {
                $this->payrollService->markAsPaid($payroll, $request->payment_method, $request->payment_date);
                $paid++;
            } else {
                $failed++;
            }
        }

        return Reply::success("Paid: {$paid}, Failed: {$failed}");
    }

    /**
     * Delete payroll
     */
    public function destroy(Payroll $payroll): JsonResponse
    {
        if ($payroll->status === 'paid') {
            return Reply::error('Cannot delete paid payroll', [], 400);
        }

        try {
            $payroll->delete();
            return Reply::success('Payroll deleted successfully');
        } catch (\Exception $e) {
            return Reply::error('Failed to delete payroll: ' . $e->getMessage(), [], 500);
        }
    }

    /**
     * Export payroll to Excel/PDF
     */
    public function export(Request $request)
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);
        $format = $request->get('format', 'excel');

        // TODO: Implement export functionality
        return response()->json(['message' => 'Export functionality coming soon']);
    }

    /**
     * Print payslip
     */
    public function printPayslip(Payroll $payroll)
    {
        $payroll->load(['employee.department', 'employee.company']);
        
        return view('hr.payroll.payslip', compact('payroll'));
    }
}

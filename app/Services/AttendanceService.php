<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AttendanceService
{
    /**
     * معالجة تسجيل الحضور
     */
    public function processCheckIn($employeeId, $shiftId = null, $location = null, $notes = null)
    {
        try {
            $employee = Employee::findOrFail($employeeId);
            $today = Carbon::today();

            // البحث عن سجل الحضور لليوم الحالي
            $attendance = Attendance::where('employee_id', $employeeId)
                ->where('attendance_date', $today->format('Y-m-d'))
                ->first();

            if (!$attendance) {
                // إنشاء سجل حضور جديد
                $attendance = new Attendance([
                    'employee_id' => $employeeId,
                    'shift_id' => $shiftId,
                    'attendance_date' => $today,
                    'check_in' => Carbon::now(),
                ]);
            } else {
                // تحديث وقت الدخول إذا لم يكن موجوداً
                if (!$attendance->check_in) {
                    $attendance->check_in = Carbon::now();
                }
            }

            // حفظ البيانات الإضافية
            if ($location) {
                $attendance->notes = ($attendance->notes ? $attendance->notes . ' | ' : '') . "Location: {$location}";
            }

            if ($notes) {
                $attendance->notes = ($attendance->notes ? $attendance->notes . ' | ' : '') . $notes;
            }

            // التحقق من التأخير
            if ($attendance->isLate() && setting('attendance.notify_late_arrival', true)) {
                Log::info("Employee {$employee->full_name} is late for work", [
                    'employee_id' => $employeeId,
                    'check_in_time' => $attendance->check_in,
                    'shift_time' => $attendance->shift ? $attendance->shift->start_time : 'No shift'
                ]);
                // يمكن إضافة إشعار هنا
            }

            $attendance->save();

            return [
                'success' => true,
                'attendance' => $attendance,
                'message' => 'تم تسجيل الدخول بنجاح'
            ];

        } catch (\Exception $e) {
            Log::error('Error processing check-in', [
                'employee_id' => $employeeId,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'حدث خطأ أثناء تسجيل الدخول',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * معالجة تسجيل الخروج
     */
    public function processCheckOut($employeeId, $location = null, $notes = null)
    {
        try {
            $employee = Employee::findOrFail($employeeId);
            $today = Carbon::today();

            // البحث عن سجل الحضور لليوم الحالي
            $attendance = Attendance::where('employee_id', $employeeId)
                ->where('attendance_date', $today->format('Y-m-d'))
                ->first();

            if (!$attendance) {
                return [
                    'success' => false,
                    'message' => 'لا يوجد سجل حضور لليوم الحالي'
                ];
            }

            // تحديث وقت الخروج
            $attendance->check_out = Carbon::now();

            // حساب ساعات العمل
            $attendance->working_hours = $attendance->calculateWorkingHours();

            // تحديث حالة الحضور تلقائياً
            $attendance->status = $attendance->calculateAttendanceStatus();

            // حفظ البيانات الإضافية
            if ($location) {
                $attendance->notes = ($attendance->notes ? $attendance->notes . ' | ' : '') . "Checkout Location: {$location}";
            }

            if ($notes) {
                $attendance->notes = ($attendance->notes ? $attendance->notes . ' | ' : '') . $notes;
            }

            // التحقق من المغادرة المبكرة
            if ($attendance->isEarlyDeparture() && setting('attendance.notify_early_departure', true)) {
                Log::info("Employee {$employee->full_name} left early", [
                    'employee_id' => $employeeId,
                    'check_out_time' => $attendance->check_out,
                    'shift_time' => $attendance->shift ? $attendance->shift->end_time : 'No shift'
                ]);
                // يمكن إضافة إشعار هنا
            }

            $attendance->save();

            return [
                'success' => true,
                'attendance' => $attendance,
                'message' => 'تم تسجيل الخروج بنجاح',
                'working_hours' => $attendance->working_hours,
                'status' => $attendance->status
            ];

        } catch (\Exception $e) {
            Log::error('Error processing check-out', [
                'employee_id' => $employeeId,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'حدث خطأ أثناء تسجيل الخروج',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * إنشاء سجلات الحضور التلقائية
     */
    public function generateAutoAttendance($date = null)
    {
        $date = $date ? Carbon::parse($date) : Carbon::today();
        $employees = Employee::active()->get();

        $created = 0;
        $skipped = 0;

        foreach ($employees as $employee) {
            try {
                $attendance = Attendance::createAutoAttendance(
                    $employee->id,
                    $date->format('Y-m-d'),
                    $employee->shift_id ?? null
                );

                if ($attendance->wasRecentlyCreated) {
                    $created++;
                } else {
                    $skipped++;
                }
            } catch (\Exception $e) {
                Log::error('Error creating auto attendance', [
                    'employee_id' => $employee->id,
                    'date' => $date->format('Y-m-d'),
                    'error' => $e->getMessage()
                ]);
            }
        }

        return [
            'created' => $created,
            'skipped' => $skipped,
            'total' => $employees->count(),
            'date' => $date->format('Y-m-d')
        ];
    }

    /**
     * حساب الخروج التلقائي
     */
    public function processAutoCheckout()
    {
        $autoCheckoutTime = setting('attendance.auto_checkout_time', '18:00');

        // البحث عن سجلات الحضور المفتوحة (بدون خروج)
        $openAttendances = Attendance::whereNull('check_out')
            ->where('attendance_date', Carbon::today()->format('Y-m-d'))
            ->where('status', '!=', 'absent')
            ->get();

        $processed = 0;

        foreach ($openAttendances as $attendance) {
            try {
                // إذا تجاوز الوقت المحدد للخروج التلقائي
                if (Carbon::now()->format('H:i') >= $autoCheckoutTime) {
                    $result = $this->processCheckOut(
                        $attendance->employee_id,
                        'Auto checkout at ' . $autoCheckoutTime,
                        'System auto checkout'
                    );

                    if ($result['success']) {
                        $processed++;
                    }
                }
            } catch (\Exception $e) {
                Log::error('Error processing auto checkout', [
                    'attendance_id' => $attendance->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return [
            'processed' => $processed,
            'total_open' => $openAttendances->count(),
            'auto_checkout_time' => $autoCheckoutTime
        ];
    }

    /**
     * التحقق من صحة البيانات المرسلة
     */
    public function validateAttendanceData($data)
    {
        $errors = [];

        // التحقق من الموظف
        if (!isset($data['employee_id']) || !Employee::find($data['employee_id'])) {
            $errors[] = 'الموظف غير موجود';
        }

        // التحقق من الوردية
        if (isset($data['shift_id']) && $data['shift_id'] && !Shift::find($data['shift_id'])) {
            $errors[] = 'الوردية غير موجودة';
        }

        // التحقق من التاريخ
        if (isset($data['attendance_date'])) {
            try {
                Carbon::parse($data['attendance_date']);
            } catch (\Exception $e) {
                $errors[] = 'تاريخ الحضور غير صحيح';
            }
        }

        return $errors;
    }

    /**
     * الحصول على إحصائيات الحضور
     */
    public function getAttendanceStats($employeeId = null, $startDate = null, $endDate = null)
    {
        $query = Attendance::query();

        if ($employeeId) {
            $query->where('employee_id', $employeeId);
        }

        if ($startDate && $endDate) {
            $query->whereBetween('attendance_date', [$startDate, $endDate]);
        }

        $stats = [
            'total_records' => $query->count(),
            'present_count' => (clone $query)->where('status', 'present')->count(),
            'absent_count' => (clone $query)->where('status', 'absent')->count(),
            'half_day_count' => (clone $query)->where('status', 'half_day')->count(),
            'vacation_count' => (clone $query)->where('status', 'vacation')->count(),
            'holiday_count' => (clone $query)->where('status', 'holiday')->count(),
            'late_count' => (clone $query)->whereHas('shift')->get()->filter(function($attendance) {
                return $attendance->isLate();
            })->count(),
            'early_departure_count' => (clone $query)->whereHas('shift')->get()->filter(function($attendance) {
                return $attendance->isEarlyDeparture();
            })->count(),
        ];

        // حساب النسب المئوية
        if ($stats['total_records'] > 0) {
            $stats['attendance_percentage'] = round(($stats['present_count'] / $stats['total_records']) * 100, 2);
            $stats['absent_percentage'] = round(($stats['absent_count'] / $stats['total_records']) * 100, 2);
        }

        return $stats;
    }
}

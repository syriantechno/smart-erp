<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        $employees = Employee::where('is_active', true)
            ->with(['department', 'company'])
            ->orderBy('first_name')
            ->get();

        // Get attendance data for the month
        $attendances = Attendance::with('employee')
            ->forMonth($year, $month)
            ->get()
            ->keyBy(function ($attendance) {
                return $attendance->employee_id . '_' . $attendance->attendance_date->format('Y-m-d');
            });

        return view('hr.attendance.index', compact('employees', 'attendances', 'year', 'month'));
    }

    public function store(Request $request): JsonResponse
    {
        // Custom validation based on entry type
        $rules = [
            'entry_type' => 'required|in:individual,department',
            'attendance_date' => 'required|date',
            'status' => 'required|in:present,absent,vacation,travel,half_day,holiday',
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i',
            'shift_id' => 'nullable|exists:shifts,id',
            'notes' => 'nullable|string|max:500',
        ];

        // Add conditional validation based on entry_type
        if ($request->entry_type === 'individual') {
            $rules['employee_id'] = 'required|exists:employees,id';
        } elseif ($request->entry_type === 'department') {
            $rules['department_id'] = 'required|exists:departments,id';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $employeeIds = [];

            if ($request->entry_type === 'individual') {
                $employeeIds = [$request->employee_id];
            } else {
                // Get all active employees in the department
                $employeeIds = Employee::where('department_id', $request->department_id)
                    ->where('is_active', true)
                    ->pluck('id')
                    ->toArray();
            }

            $savedRecords = 0;
            $requiredHours = (float) setting('attendance.working_hours_per_day', 8.0); // يمكن ضبطها من إعدادات الحضور

            foreach ($employeeIds as $employeeId) {
                // If no shift is specified, try to find the employee's assigned shift
                $shiftId = $request->shift_id;
                if (!$shiftId) {
                    $shiftId = $this->findEmployeeShift($employeeId, $request->attendance_date);
                }

                // Get working hours from shift or use default from attendance settings
                $shift = $shiftId ? \App\Models\Shift::find($shiftId) : null;
                $requiredHours = $shift ? (float) $shift->working_hours : (float) setting('attendance.working_hours_per_day', 8.0);

                $workingHours = $this->calculateWorkingHours($request->check_in, $request->check_out, $request->status);
                $status = $request->status;

                // Auto-determine half-day if worked hours are less than required and status is present
                if ($status === 'present' && $workingHours > 0 && $workingHours < $requiredHours) {
                    $status = 'half_day';
                }

                $attendance = Attendance::updateOrCreate(
                    [
                        'employee_id' => $employeeId,
                        'attendance_date' => $request->attendance_date,
                    ],
                    [
                        'status' => $status,
                        'check_in' => $request->check_in,
                        'check_out' => $request->check_out,
                        'shift_id' => $shiftId,
                        'notes' => $request->notes,
                        'working_hours' => $workingHours,
                        'overtime_hours' => max(0, $workingHours - $requiredHours),
                    ]
                );
                $savedRecords++;
            }

            return response()->json([
                'success' => true,
                'message' => "تم حفظ الحضور لـ {$savedRecords} موظف بنجاح",
                'data' => $savedRecords
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save attendance record',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        $attendance = Attendance::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:present,absent,vacation,travel,half_day,holiday',
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i',
            'notes' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $workingHours = $this->calculateWorkingHours($request->check_in, $request->check_out, $request->status);
            $requiredHours = (float) setting('attendance.working_hours_per_day', 8.0);

            $attendance->update([
                'status' => $request->status,
                'check_in' => $request->check_in,
                'check_out' => $request->check_out,
                'notes' => $request->notes,
                'working_hours' => $workingHours,
                'overtime_hours' => max(0, $workingHours - $requiredHours),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Attendance record updated successfully',
                'data' => $attendance
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update attendance record',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function bulkUpdate(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'attendances' => 'required|array',
            'attendances.*.employee_id' => 'required|exists:employees,id',
            'attendances.*.date' => 'required|date',
            'attendances.*.status' => 'required|in:present,absent,vacation,travel,half_day,holiday',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            foreach ($request->attendances as $attendanceData) {
                Attendance::updateOrCreate(
                    [
                        'employee_id' => $attendanceData['employee_id'],
                        'attendance_date' => $attendanceData['date'],
                    ],
                    [
                        'status' => $attendanceData['status'],
                        'notes' => $attendanceData['notes'] ?? null,
                    ]
                );
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Attendance records updated successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update attendance records',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getMonthlyStats(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required|exists:employees,id',
            'year' => 'required|integer|min:2020|max:' . (now()->year + 1),
            'month' => 'required|integer|min:1|max:12',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $stats = Attendance::getMonthlyStats(
            $request->employee_id,
            $request->year,
            $request->month
        );

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    public function destroy($id): JsonResponse
    {
        try {
            $attendance = Attendance::findOrFail($id);
            $attendance->delete();

            return response()->json([
                'success' => true,
                'message' => 'Attendance record deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete attendance record',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function findEmployeeShift($employeeId, $date)
    {
        $employee = Employee::with(['department.company'])->find($employeeId);
        if (!$employee) {
            return null;
        }

        $dayOfWeek = Carbon::parse($date)->dayOfWeek;

        // Find shifts that apply to this employee on this day
        $shifts = Shift::active()
            ->where(function ($query) use ($employee, $dayOfWeek) {
                // Employee-specific shifts
                $query->where('applicable_to', 'employee')
                      ->where('employee_id', $employee->id)
                      ->where(function ($q) use ($dayOfWeek) {
                          $q->whereNull('work_days')
                            ->orWhereRaw('JSON_CONTAINS(work_days, ?)', [json_encode([$this->getDayName($dayOfWeek)])]);
                      });
            })
            ->orWhere(function ($query) use ($employee, $dayOfWeek) {
                // Department-specific shifts
                $query->where('applicable_to', 'department')
                      ->where('department_id', $employee->department_id)
                      ->where(function ($q) use ($dayOfWeek) {
                          $q->whereNull('work_days')
                            ->orWhereRaw('JSON_CONTAINS(work_days, ?)', [json_encode([$this->getDayName($dayOfWeek)])]);
                      });
            })
            ->orWhere(function ($query) use ($employee, $dayOfWeek) {
                // Company-wide shifts
                $query->where('applicable_to', 'company')
                      ->where('company_id', $employee->department?->company_id)
                      ->where(function ($q) use ($dayOfWeek) {
                          $q->whereNull('work_days')
                            ->orWhereRaw('JSON_CONTAINS(work_days, ?)', [json_encode([$this->getDayName($dayOfWeek)])]);
                      });
            })
            ->orderBy('applicable_to', 'desc') // employee > department > company
            ->first();

        return $shifts ? $shifts->id : null;
    }

    private function getDayName($dayOfWeek)
    {
        $days = [
            0 => 'sunday',
            1 => 'monday',
            2 => 'tuesday',
            3 => 'wednesday',
            4 => 'thursday',
            5 => 'friday',
            6 => 'saturday',
        ];

        return $days[$dayOfWeek] ?? 'monday';
    }
}

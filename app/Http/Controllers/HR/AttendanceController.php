<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\HR\Attendance;
use App\Models\HR\Employee;
use App\Models\HR\Shift;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Helpers\Reply;
use App\Services\Notifications\NotificationDispatcher;

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

        // Get companies for filter
        $companies = \App\Models\Company::where('is_active', true)
            ->orderBy('name')
            ->get();

        // Get departments for filter
        $departments = \App\Models\HR\Department::where('is_active', true)
            ->orderBy('name')
            ->get();

        // Get shifts
        $shifts = Shift::active()->orderBy('name')->get();

        // Get attendance data for the month
        $attendances = Attendance::with('employee')
            ->forMonth($year, $month)
            ->get()
            ->keyBy(function ($attendance) {
                return $attendance->employee_id . '_' . $attendance->attendance_date->format('Y-m-d');
            });

        return view('hr.attendance.index', compact('employees', 'attendances', 'year', 'month', 'companies', 'departments', 'shifts'));
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
            $errors = $validator->errors()->all();
            return Reply::error('Validation error: ' . implode(', ', $errors), ['errors' => $validator->errors()], 422);
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

            $employees = Employee::whereIn('id', $employeeIds)->get(['id', 'user_id', 'first_name', 'last_name']);

            $savedRecords = 0;
            $requiredHours = (float) setting('attendance.working_hours_per_day', 8.0); // يمكن ضبطها من إعدادات الحضور

            foreach ($employeeIds as $employeeId) {
                // If no shift is specified, try to find the employee's assigned shift
                $shiftId = $request->shift_id;
                if (!$shiftId) {
                    $shiftId = $this->findEmployeeShift($employeeId, $request->attendance_date);
                }

                // Get working hours from shift or use default from attendance settings
                $shift = $shiftId ? Shift::find($shiftId) : null;
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

            return Reply::success("تم حفظ الحضور لـ {$savedRecords} موظف بنجاح", [
                'data' => $savedRecords,
            ]);
        } catch (\Exception $e) {
            Log::error('Attendance save error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            return Reply::error('Failed to save attendance record: ' . $e->getMessage(), ['error' => $e->getMessage()], 500);
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

            $attendance->loadMissing('employee');
            $this->notifyEmployees(
                collect([$attendance->employee]),
                'attendance.updated',
                'Attendance Updated',
                'Your attendance record has been updated.',
                [
                    'attendance_date' => $attendance->attendance_date?->format('Y-m-d'),
                    'actor_id' => auth()->id(),
                ]
            );

            return Reply::success('Attendance record updated successfully', [
                'data' => $attendance,
            ]);
        } catch (\Exception $e) {
            return Reply::error('Failed to update attendance record', ['error' => $e->getMessage()], 500);
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

            $employees = Employee::whereIn('id', collect($request->attendances)->pluck('employee_id'))
                ->get(['id', 'user_id', 'first_name', 'last_name']);

            $this->notifyEmployees(
                $employees,
                'attendance.bulk_updated',
                'Attendance Updated',
                'Your attendance records have been updated in bulk.',
                ['actor_id' => auth()->id()]
            );

            return Reply::success('Attendance records updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return Reply::error('Failed to update attendance records', ['error' => $e->getMessage()], 500);
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

        return Reply::successWithData('', [
            'data' => $stats,
        ]);
    }

    public function destroy($id): JsonResponse
    {
        try {
            $attendance = Attendance::findOrFail($id);
            $attendance->delete();

            $attendance->loadMissing('employee');
            $this->notifyEmployees(
                collect([$attendance->employee]),
                'attendance.deleted',
                'Attendance Deleted',
                'An attendance record was deleted.',
                [
                    'attendance_date' => $attendance->attendance_date?->format('Y-m-d'),
                    'actor_id' => auth()->id(),
                ]
            );

            return Reply::success('Attendance record deleted successfully');
        } catch (\Exception $e) {
            return Reply::error('Failed to delete attendance record', ['error' => $e->getMessage()], 500);
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

    /**
     * Calculate working hours from check-in and check-out times
     */
    private function calculateWorkingHours($checkIn, $checkOut, $status): float
    {
        // If status is not present or half_day, return 0
        if (!in_array($status, ['present', 'half_day'])) {
            return 0.0;
        }

        // If no check-in or check-out, return default based on status
        if (!$checkIn || !$checkOut) {
            if ($status === 'present') {
                return (float) setting('attendance.working_hours_per_day', 8.0);
            } elseif ($status === 'half_day') {
                return (float) setting('attendance.working_hours_per_day', 8.0) / 2;
            }
            return 0.0;
        }

        try {
            $in = Carbon::createFromFormat('H:i', $checkIn);
            $out = Carbon::createFromFormat('H:i', $checkOut);

            // If check-out is before check-in, assume next day
            if ($out->lessThanOrEqualTo($in)) {
                $out->addDay();
            }

            $diffMinutes = $in->diffInMinutes($out);
            return round($diffMinutes / 60, 2);
        } catch (\Exception $e) {
            return 0.0;
        }
    }

    private function notifyEmployees($employees, string $eventKey, string $title, string $message, array $data = []): void
    {
        $recipientIds = collect($employees)
            ->filter(fn ($employee) => $employee && $employee->user_id)
            ->pluck('user_id')
            ->unique()
            ->all();

        if (empty($recipientIds)) {
            return;
        }

        NotificationDispatcher::toUsers(
            $recipientIds,
            $eventKey,
            $title,
            $message,
            route('hr.attendance.index'),
            'CalendarCheck',
            $data
        );
    }

    /**
     * Get attendance data for DataTable (AJAX)
     */
    public function getData(Request $request): JsonResponse
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);
        $companyId = $request->get('company_id');
        $departmentId = $request->get('department_id');
        $shiftId = $request->get('shift_id');
        $searchTerm = $request->get('search_term');

        $daysInMonth = 31; // Always show 31 days
        $actualDaysInMonth = Carbon::create($year, $month)->daysInMonth;

        // Get employees with filters
        $employeesQuery = Employee::where('is_active', true)
            ->with(['department', 'company']);

        if ($companyId) {
            $employeesQuery->where('company_id', $companyId);
        }

        if ($departmentId) {
            $employeesQuery->where('department_id', $departmentId);
        }

        if ($searchTerm) {
            $employeesQuery->where(function ($q) use ($searchTerm) {
                $q->where('first_name', 'like', "%{$searchTerm}%")
                  ->orWhere('last_name', 'like', "%{$searchTerm}%")
                  ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }

        // Filter by default shift
        if ($shiftId) {
            $employeesQuery->where('default_shift_id', $shiftId);
        }

        $employees = $employeesQuery->orderBy('first_name')->get();

        // Get attendance data for the month with shift relation
        $attendanceQuery = Attendance::with('shift')
            ->forMonth($year, $month)
            ->whereIn('employee_id', $employees->pluck('id'));

        // Also filter attendance by shift if specified
        if ($shiftId) {
            $attendanceQuery->where('shift_id', $shiftId);
        }

        $attendances = $attendanceQuery->get()->groupBy('employee_id');

        // Build response data
        $data = [];
        $stats = ['present' => 0, 'absent' => 0, 'vacation' => 0, 'total' => $employees->count()];

        foreach ($employees as $employee) {
            $employeeAttendances = $attendances->get($employee->id, collect());
            $days = [];
            $summary = ['present' => 0, 'absent' => 0, 'vacation' => 0, 'half_day' => 0, 'overtime' => 0];

            for ($day = 1; $day <= $daysInMonth; $day++) {
                // Skip invalid days for the month
                if ($day > $actualDaysInMonth) {
                    $days[$day] = null;
                    continue;
                }
                
                $date = Carbon::create($year, $month, $day)->format('Y-m-d');
                $attendance = $employeeAttendances->first(function ($att) use ($date) {
                    return $att->attendance_date->format('Y-m-d') === $date;
                });

                if ($attendance) {
                    // Get required hours from shift or default (8 hours)
                    $requiredHours = 8;
                    if ($attendance->shift) {
                        $requiredHours = (float) ($attendance->shift->working_hours ?? 8);
                    }
                    
                    $workingHours = (float) ($attendance->working_hours ?? 0);
                    $overtimeHours = (float) ($attendance->overtime_hours ?? 0);
                    
                    // Calculate overtime if not stored
                    if ($overtimeHours == 0 && $workingHours > $requiredHours) {
                        $overtimeHours = $workingHours - $requiredHours;
                    }
                    
                    $days[$day] = [
                        'status' => $attendance->status,
                        'check_in' => $attendance->check_in ? Carbon::parse($attendance->check_in)->format('H:i') : null,
                        'check_out' => $attendance->check_out ? Carbon::parse($attendance->check_out)->format('H:i') : null,
                        'working_hours' => $workingHours,
                        'overtime_hours' => $overtimeHours,
                    ];

                    // Update summary
                    if (isset($summary[$attendance->status])) {
                        $summary[$attendance->status]++;
                    }
                    
                    // Add overtime to summary
                    $summary['overtime'] += $overtimeHours;
                } else {
                    $days[$day] = null;
                }
            }

            $data[] = [
                'id' => $employee->id,
                'employee' => [
                    'name' => mb_convert_encoding($employee->full_name ?? '', 'UTF-8', 'UTF-8'),
                    'position' => mb_convert_encoding($employee->position ?? '', 'UTF-8', 'UTF-8'),
                    'department' => mb_convert_encoding($employee->department->name ?? 'N/A', 'UTF-8', 'UTF-8'),
                    'photo' => $employee->profile_picture_url,
                    'initials' => strtoupper(mb_substr($employee->first_name ?? 'X', 0, 1) . mb_substr($employee->last_name ?? 'X', 0, 1)),
                ],
                'days' => $days,
                'summary' => $summary,
            ];

            // Update global stats (for today)
            $todayDate = now()->format('Y-m-d');
            $todayAttendance = $employeeAttendances->first(function ($att) use ($todayDate) {
                return $att->attendance_date->format('Y-m-d') === $todayDate;
            });
            if ($todayAttendance) {
                if ($todayAttendance->status === 'present') $stats['present']++;
                elseif ($todayAttendance->status === 'absent') $stats['absent']++;
                elseif (in_array($todayAttendance->status, ['vacation', 'travel'])) $stats['vacation']++;
            }
        }

        return response()->json([
            'success' => true,
            'data' => $data,
            'stats' => $stats,
            'meta' => [
                'year' => (int) $year,
                'month' => (int) $month,
                'days_in_month' => $daysInMonth,
            ]
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Bulk store attendance records
     */
    public function bulkStore(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'bulk_date' => 'required|date',
            'employees' => 'required|array|min:1',
            'employees.*' => 'exists:employees,id',
        ]);

        if ($validator->fails()) {
            return Reply::error('Validation error', ['errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();

            $date = $request->bulk_date;
            $savedCount = 0;

            foreach ($request->employees as $employeeId) {
                $status = $request->input("status_{$employeeId}", 'present');
                $checkIn = $request->input("check_in_{$employeeId}");
                $checkOut = $request->input("check_out_{$employeeId}");

                $workingHours = $this->calculateWorkingHours($checkIn, $checkOut, $status);

                Attendance::updateOrCreate(
                    [
                        'employee_id' => $employeeId,
                        'attendance_date' => $date,
                    ],
                    [
                        'status' => $status,
                        'check_in' => $checkIn,
                        'check_out' => $checkOut,
                        'working_hours' => $workingHours,
                        'overtime_hours' => max(0, $workingHours - 8),
                    ]
                );

                $savedCount++;
            }

            DB::commit();

            return Reply::success("تم حفظ الحضور لـ {$savedCount} موظف بنجاح");
        } catch (\Exception $e) {
            DB::rollBack();
            return Reply::error('Failed to save attendance records', ['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Export attendance data
     */
    public function export(Request $request)
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        // This would typically generate an Excel file
        // For now, return JSON data
        $employees = Employee::where('is_active', true)->with('department')->get();
        $attendances = Attendance::forMonth($year, $month)->get()->groupBy('employee_id');

        $exportData = [];
        foreach ($employees as $employee) {
            $employeeAttendances = $attendances->get($employee->id, collect());
            $row = [
                'Employee' => $employee->full_name,
                'Department' => $employee->department->name ?? 'N/A',
                'Position' => $employee->position,
            ];

            $daysInMonth = Carbon::create($year, $month)->daysInMonth;
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $date = Carbon::create($year, $month, $day)->format('Y-m-d');
                $attendance = $employeeAttendances->firstWhere('attendance_date', $date);
                $row["Day {$day}"] = $attendance ? strtoupper(substr($attendance->status, 0, 1)) : '-';
            }

            $exportData[] = $row;
        }

        return response()->json([
            'success' => true,
            'data' => $exportData,
            'filename' => "attendance_{$year}_{$month}.xlsx"
        ]);
    }
}

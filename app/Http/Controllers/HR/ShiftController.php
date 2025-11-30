<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\HR\Shift;
use App\Models\Setting\Company;
use App\Models\HR\Department;
use App\Models\HR\Employee;
use App\Repositories\ShiftRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Services\Notifications\NotificationDispatcher;

class ShiftController extends Controller
{
    protected $shiftRepository;

    public function __construct(ShiftRepository $shiftRepository)
    {
        $this->shiftRepository = $shiftRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $companies = Company::active()->get();

        // Get statistics for the royal theme header
        $totalShifts = Shift::count();
        $activeShifts = Shift::where('is_active', true)->count();
        $inactiveShifts = Shift::where('is_active', false)->count();

        return view('hr.shifts.index', compact('companies', 'totalShifts', 'activeShifts', 'inactiveShifts'));
    }

    /**
     * Get shifts data for DataTables
     */
    public function datatable(Request $request): JsonResponse
    {
        try {
            $baseQuery = $this->shiftRepository->getForDataTable();

            // Search filter
            $filterValue = $request->get('filter_value');
            if ($filterValue !== null && $filterValue !== '') {
                $baseQuery->where(function ($query) use ($filterValue) {
                    $query->where('code', 'like', "%{$filterValue}%")
                          ->orWhere('name', 'like', "%{$filterValue}%")
                          ->orWhereHas('company', function ($q) use ($filterValue) {
                              $q->where('name', 'like', "%{$filterValue}%");
                          });
                });
            }

            // Company filter
            $companyId = $request->get('company_id');
            if ($companyId !== null && $companyId !== '') {
                $baseQuery->where('company_id', $companyId);
            }

            // Status filter
            $status = $request->get('status');
            if ($status !== null && $status !== '') {
                $baseQuery->where('is_active', $status == '1');
            }

            return \Yajra\DataTables\Facades\DataTables::of($baseQuery)
                ->addIndexColumn()
                ->orderColumn('DT_RowIndex', 'id $1')
                ->addColumn('formatted_time', function ($shift) {
                    return $shift->formatted_time;
                })
                ->addColumn('applicable_text', function ($shift) {
                    return $shift->applicable_text;
                })
                ->addColumn('status', function ($shift) {
                    return $shift->is_active ?
                        '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>' :
                        '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Inactive</span>';
                })
                ->addColumn('actions', function ($shift) {
                    try {
                        return view('hr.shifts.partials.actions', compact('shift'))->render();
                    } catch (\Exception $e) {
                        Log::info('Error rendering actions view:', [
                            'shift_id' => $shift->id,
                            'error' => $e->getMessage(),
                        ]);
                        return 'Error: ' . $e->getMessage();
                    }
                })
                ->rawColumns(['status', 'actions'])
                ->toJson();
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Database error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::active()->get();
        $departments = Department::active()->get();
        $employees = Employee::active()->get();

        return view('hr.shifts.create', compact('companies', 'departments', 'employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'working_hours' => 'required|numeric|min:0|max:24',
            'color' => 'required|string|regex:/^#[a-fA-F0-9]{6}$/',
            'is_active' => 'boolean',
            'applicable_to' => 'required|in:company,department,employee',
            // IDs are validated for existence; required combinations are enforced on the frontend
            'company_id' => 'nullable|exists:companies,id',
            'department_id' => 'nullable|exists:departments,id',
            'employee_id' => 'nullable|exists:employees,id',
            'work_days' => 'nullable|array',
            'work_days.*' => 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'break_start' => 'nullable|date_format:H:i',
            'break_end' => 'nullable|date_format:H:i',
            'break_hours' => 'nullable|numeric|min:0|max:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $shift = Shift::create([
                'code' => Shift::generateUniqueCode(),
                'name' => $request->name,
                'description' => $request->description,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'working_hours' => $request->working_hours,
                'color' => $request->color,
                'is_active' => $request->boolean('is_active', true),
                'applicable_to' => $request->applicable_to,
                'company_id' => in_array($request->applicable_to, ['company', 'department', 'employee']) ? $request->company_id : null,
                'department_id' => in_array($request->applicable_to, ['department', 'employee']) ? $request->department_id : null,
                'employee_id' => $request->applicable_to === 'employee' ? $request->employee_id : null,
                'work_days' => $request->work_days,
                'break_start' => $request->break_start,
                'break_end' => $request->break_end,
                'break_hours' => $request->break_hours ?: 1.00,
            ]);

            $actor = auth()->user()?->name ?? 'System';
            NotificationDispatcher::toAllUsers(
                'shift.created',
                'Shift Created',
                "User {$actor} created shift '{$shift->name}'.",
                route('hr.shifts.index'),
                'CalendarClock',
                ['shift_id' => $shift->id, 'actor_id' => auth()->id()]
            );

            return response()->json([
                'success' => true,
                'message' => 'Shift created successfully',
                'data' => $shift
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create shift',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Shift $shift)
    {
        $shift->load(['company', 'department', 'employee']);
        return response()->json([
            'success' => true,
            'data' => $shift
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shift $shift)
    {
        $companies = Company::active()->get();
        $departments = Department::active()->get();
        $employees = Employee::active()->get();

        return view('hr.shifts.edit', compact('shift', 'companies', 'departments', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shift $shift): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'start_time' => 'required',
            'end_time' => 'required',
            'working_hours' => 'nullable|numeric|min:0|max:24',
            'color' => 'required|string',
            'is_active' => 'nullable',
            'applicable_to' => 'required|in:company,department,employee',
            'company_id' => 'nullable',
            'department_id' => 'nullable',
            'employee_id' => 'nullable',
            'work_days' => 'nullable|array',
            'work_days.*' => 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'break_start' => 'nullable',
            'break_end' => 'nullable',
            'break_hours' => 'nullable|numeric|min:0|max:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Handle is_active - can be boolean, string 'true'/'false', or 1/0
            $isActive = $request->is_active;
            if (is_string($isActive)) {
                $isActive = in_array(strtolower($isActive), ['true', '1', 'yes']);
            } else {
                $isActive = (bool) $isActive;
            }

            $shift->update([
                'name' => $request->name,
                'description' => $request->description,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'working_hours' => $request->working_hours ?: 8,
                'color' => $request->color,
                'is_active' => $isActive,
                'applicable_to' => $request->applicable_to,
                'company_id' => in_array($request->applicable_to, ['company', 'department', 'employee']) ? $request->company_id : null,
                'department_id' => in_array($request->applicable_to, ['department', 'employee']) ? $request->department_id : null,
                'employee_id' => $request->applicable_to === 'employee' ? $request->employee_id : null,
                'work_days' => $request->work_days ?? [],
                'break_start' => $request->break_start ?: null,
                'break_end' => $request->break_end ?: null,
                'break_hours' => $request->break_hours ?: 1.00,
            ]);

            $actor = auth()->user()?->name ?? 'System';
            NotificationDispatcher::toAllUsers(
                'shift.updated',
                'Shift Updated',
                "User {$actor} updated shift '{$shift->name}'.",
                route('hr.shifts.index'),
                'CalendarClock',
                ['shift_id' => $shift->id, 'actor_id' => auth()->id()]
            );

            return response()->json([
                'success' => true,
                'message' => 'Shift updated successfully',
                'data' => $shift
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update shift',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shift $shift): JsonResponse
    {
        try {
            // Check if shift is being used
            if ($shift->attendances()->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete shift because it is linked to attendance records'
                ], 422);
            }

            $shiftName = $shift->name;
            $shiftId = $shift->id;
            $shift->delete();

            $actor = auth()->user()?->name ?? 'System';
            NotificationDispatcher::toAllUsers(
                'shift.deleted',
                'Shift Deleted',
                "User {$actor} deleted shift '{$shiftName}'.",
                route('hr.shifts.index'),
                'Trash2',
                ['shift_id' => $shiftId, 'actor_id' => auth()->id()]
            );

            return response()->json([
                'success' => true,
                'message' => 'Shift deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete shift',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle shift status
     */
    public function toggleStatus(Shift $shift): JsonResponse
    {
        try {
            $shift->update(['is_active' => !$shift->is_active]);

            $actor = auth()->user()?->name ?? 'System';
            $eventKey = $shift->is_active ? 'shift.activated' : 'shift.deactivated';
            $title = $shift->is_active ? 'Shift Activated' : 'Shift Deactivated';
            $message = "User {$actor} toggled shift '{$shift->name}' status.";

            NotificationDispatcher::toAllUsers(
                $eventKey,
                $title,
                $message,
                route('hr.shifts.index'),
                $shift->is_active ? 'Play' : 'Pause',
                ['shift_id' => $shift->id, 'actor_id' => auth()->id()]
            );

            return response()->json([
                'success' => true,
                'message' => $shift->is_active ? 'Shift activated' : 'Shift deactivated',
                'is_active' => $shift->is_active
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update shift status',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get departments for company
     */
    public function getDepartments(Request $request): JsonResponse
    {
        $departments = Department::where('company_id', $request->company_id)
            ->active()
            ->select('id', 'name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $departments
        ]);
    }

    /**
     * Get employees for department
     */
    public function getEmployees(Request $request): JsonResponse
    {
        try {
            $employees = Employee::where('department_id', $request->department_id)
                ->active()
                ->selectRaw(
                    "id, first_name, middle_name, last_name, CONCAT(IFNULL(first_name, ''), ' ', IFNULL(middle_name, ''), ' ', IFNULL(last_name, '')) as full_name"
                )
                ->get();

            return response()->json([
                'success' => true,
                'data' => $employees
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load employees',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate unique code preview
     */
    public function previewCode(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'code' => Shift::generateUniqueCode()
        ]);
    }

    /**
     * Display shift reports page
     */
    public function reports()
    {
        $shifts = Shift::active()->orderBy('name')->get();
        
        return view('hr.shifts.reports', compact('shifts'));
    }

    /**
     * Get shift report data
     */
    public function reportData(Request $request): JsonResponse
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);
        $shiftId = $request->get('shift_id');

        // Get employees with shifts
        $employeesQuery = Employee::where('is_active', true)
            ->with(['department', 'defaultShift']);

        if ($shiftId) {
            $employeesQuery->where('default_shift_id', $shiftId);
        }

        $employees = $employeesQuery->get();
        $employeeIds = $employees->pluck('id');

        // Get attendance data
        $attendanceQuery = \App\Models\HR\Attendance::with('shift')
            ->whereYear('attendance_date', $year)
            ->whereMonth('attendance_date', $month)
            ->whereIn('employee_id', $employeeIds);

        if ($shiftId) {
            $attendanceQuery->where('shift_id', $shiftId);
        }

        $attendances = $attendanceQuery->get();

        // Calculate stats
        $totalEmployees = $employees->count();
        $totalAttendances = $attendances->where('status', 'present')->count();
        $totalWorkDays = \Carbon\Carbon::create($year, $month)->daysInMonth;
        $expectedAttendances = $totalEmployees * $totalWorkDays * 0.7; // Assuming 70% are work days
        $complianceRate = $expectedAttendances > 0 ? round(($totalAttendances / $expectedAttendances) * 100, 1) : 0;
        $complianceRate = min(100, $complianceRate);

        // Late arrivals (check_in after shift start_time)
        $lateArrivals = 0;
        foreach ($attendances as $att) {
            if ($att->check_in && $att->shift) {
                $checkIn = \Carbon\Carbon::parse($att->check_in);
                $shiftStart = \Carbon\Carbon::parse($att->shift->start_time);
                if ($checkIn->gt($shiftStart->addMinutes(15))) { // 15 min grace period
                    $lateArrivals++;
                }
            }
        }

        // Total overtime
        $totalOvertime = $attendances->sum('overtime_hours');

        // Shift distribution
        $distribution = Shift::active()
            ->withCount(['attendances' => function ($q) use ($year, $month) {
                $q->whereYear('attendance_date', $year)
                  ->whereMonth('attendance_date', $month);
            }])
            ->get()
            ->map(function ($shift) {
                return [
                    'name' => $shift->name,
                    'count' => Employee::where('default_shift_id', $shift->id)->count(),
                    'color' => $shift->color
                ];
            })
            ->filter(fn($s) => $s['count'] > 0)
            ->values();

        // Top overtime employees
        $topOvertime = $attendances
            ->groupBy('employee_id')
            ->map(function ($group) use ($employees) {
                $employee = $employees->firstWhere('id', $group->first()->employee_id);
                return [
                    'name' => $employee?->full_name ?? 'Unknown',
                    'department' => $employee?->department?->name ?? 'N/A',
                    'overtime' => round($group->sum('overtime_hours'), 1)
                ];
            })
            ->filter(fn($e) => $e['overtime'] > 0)
            ->sortByDesc('overtime')
            ->take(5)
            ->values();

        // Late by shift
        $lateByShift = Shift::active()->get()->map(function ($shift) use ($attendances) {
            $shiftAttendances = $attendances->where('shift_id', $shift->id);
            $lateCount = 0;
            foreach ($shiftAttendances as $att) {
                if ($att->check_in) {
                    $checkIn = \Carbon\Carbon::parse($att->check_in);
                    $shiftStart = \Carbon\Carbon::parse($shift->start_time);
                    if ($checkIn->gt($shiftStart->addMinutes(15))) {
                        $lateCount++;
                    }
                }
            }
            return [
                'name' => $shift->name,
                'color' => $shift->color,
                'count' => $lateCount
            ];
        })->filter(fn($s) => $s['count'] > 0)->values();

        // Attendance summary
        $attendanceSummary = [
            'present' => $attendances->where('status', 'present')->count(),
            'absent' => $attendances->where('status', 'absent')->count(),
            'vacation' => $attendances->where('status', 'vacation')->count(),
            'half_day' => $attendances->where('status', 'half_day')->count(),
        ];

        return response()->json([
            'success' => true,
            'stats' => [
                'totalEmployees' => $totalEmployees,
                'complianceRate' => $complianceRate,
                'lateArrivals' => $lateArrivals,
                'totalOvertime' => round($totalOvertime, 1)
            ],
            'distribution' => $distribution,
            'topOvertime' => $topOvertime,
            'lateByShift' => $lateByShift,
            'attendanceSummary' => $attendanceSummary
        ]);
    }
}

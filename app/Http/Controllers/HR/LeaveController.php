<?php

namespace App\Http\Controllers\HR;

use App\Helpers\Reply;
use App\Http\Controllers\Controller;
use App\Models\HR\Employee;
use App\Models\HR\Leave;
use App\Models\User;
use App\Services\DocumentCodeGenerator;
use App\Services\Notifications\NotificationDispatcher;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class LeaveController extends Controller
{
    public function __construct(private DocumentCodeGenerator $codeGenerator)
    {
    }

    public function index()
    {
        $employees = Employee::with(['department', 'company'])
            ->active()
            ->orderBy('first_name')
            ->get();

        return view('hr.leave.index', [
            'leaveTypes' => $this->leaveTypeOptions(),
            'leaveReasons' => $this->leaveReasonOptions(),
            'leaveStatuses' => $this->leaveStatusOptions(),
            'employees' => $employees,
        ]);
    }

    public function datatable(Request $request): JsonResponse
    {
        $draw = intval($request->input('draw'));
        $length = intval($request->input('length', 10));
        $start = intval($request->input('start', 0));

        $baseQuery = Leave::query()
            ->with(['employee.department', 'employee.company'])
            ->orderByDesc('created_at');

        $recordsTotal = (clone $baseQuery)->count();

        $this->applyFilters($request, $baseQuery);

        $recordsFiltered = (clone $baseQuery)->count();

        $leaves = $baseQuery
            ->skip($start)
            ->take($length)
            ->get();

        $data = $leaves->map(function (Leave $leave, $index) use ($start) {
            return [
                'DT_RowIndex' => $start + $index + 1,
                'request' => $this->renderRequestColumn($leave),
                'employee' => $this->renderEmployeeColumn($leave),
                'period' => $this->renderPeriodColumn($leave),
                'reason' => $this->renderReasonColumn($leave),
                'status' => $this->renderStatusBadge($leave->status),
                'actions' => view('hr.leave.partials.actions', compact('leave'))->render(),
            ];
        })->values();

        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        // Convert is_paid checkbox value to boolean
        $request->merge([
            'is_paid' => $request->has('is_paid') ? true : false
        ]);
        
        $validated = $this->validateLeave($request);

        $employee = Employee::findOrFail($validated['employee_id']);
        $validated['department_id'] = $validated['department_id'] ?? $employee->department_id;
        $validated['company_id'] = $validated['company_id'] ?? $employee->company_id;
        $validated['code'] = $this->codeGenerator->generate('leave');
        $validated['days_count'] = $this->calculateDays($validated['start_date'], $validated['end_date']);

        $leave = Leave::create($validated);

        // Notify HR managers about new leave request
        $hrManagers = User::whereHas('roles', fn($q) => $q->whereIn('name', ['admin', 'hr_manager']))->pluck('id')->toArray();
        if (!empty($hrManagers)) {
            $typeLabel = $this->leaveTypeOptions()[$validated['leave_type']] ?? ucfirst($validated['leave_type']);
            NotificationDispatcher::toUsers(
                $hrManagers,
                'leave.requested',
                'New Leave Request',
                "{$employee->full_name} has requested {$typeLabel} from {$validated['start_date']} to {$validated['end_date']}",
                route('hr.leave.index'),
                'calendar-off',
                ['type' => 'info', 'actor_id' => auth()->id()]
            );
        }

        return Reply::success('Leave request created successfully.');
    }

    public function show(Leave $leave): JsonResponse
    {
        $leave->load(['employee.department', 'employee.company']);

        return response()->json([
            'success' => true,
            'data' => $leave,
        ]);
    }

    public function update(Request $request, Leave $leave): JsonResponse
    {
        $oldStatus = $leave->status;

        // Quick status update (approve/reject)
        if ($request->has('status') && count($request->all()) <= 2) {
            $status = $request->input('status');
            if (in_array($status, ['approved', 'rejected', 'pending'])) {
                $leave->update(['status' => $status]);
                
                // Notify employee
                if ($leave->employee && $leave->employee->user_id && $oldStatus !== $status) {
                    $typeLabel = $this->leaveTypeOptions()[$leave->leave_type] ?? ucfirst($leave->leave_type);
                    
                    if ($status === 'approved') {
                        NotificationDispatcher::toUser(
                            $leave->employee->user_id,
                            'leave.approved',
                            'Leave Approved',
                            "Your {$typeLabel} request has been approved.",
                            route('hr.leave.index'),
                            'check-circle',
                            ['type' => 'success', 'actor_id' => auth()->id()]
                        );
                    } elseif ($status === 'rejected') {
                        NotificationDispatcher::toUser(
                            $leave->employee->user_id,
                            'leave.rejected',
                            'Leave Rejected',
                            "Your {$typeLabel} request has been rejected.",
                            route('hr.leave.index'),
                            'x-circle',
                            ['type' => 'error', 'actor_id' => auth()->id()]
                        );
                    }
                }
                
                return Reply::success('Leave status updated successfully.');
            }
        }

        // Convert is_paid checkbox value to boolean
        $request->merge([
            'is_paid' => $request->has('is_paid') ? true : false
        ]);
        
        $validated = $this->validateLeave($request, $leave->id);

        $employee = Employee::findOrFail($validated['employee_id']);
        $validated['department_id'] = $validated['department_id'] ?? $employee->department_id;
        $validated['company_id'] = $validated['company_id'] ?? $employee->company_id;
        $validated['days_count'] = $this->calculateDays($validated['start_date'], $validated['end_date']);

        $leave->update($validated);

        // Notify employee if status changed
        if (isset($validated['status']) && $oldStatus !== $validated['status'] && $leave->employee && $leave->employee->user_id) {
            $typeLabel = $this->leaveTypeOptions()[$leave->leave_type] ?? ucfirst($leave->leave_type);
            
            if ($validated['status'] === 'approved') {
                NotificationDispatcher::toUser(
                    $leave->employee->user_id,
                    'leave.approved',
                    'Leave Approved',
                    "Your {$typeLabel} request from {$leave->start_date->format('M d')} to {$leave->end_date->format('M d')} has been approved.",
                    route('hr.leave.index'),
                    'check-circle',
                    ['type' => 'success', 'actor_id' => auth()->id()]
                );
            } elseif ($validated['status'] === 'rejected') {
                NotificationDispatcher::toUser(
                    $leave->employee->user_id,
                    'leave.rejected',
                    'Leave Rejected',
                    "Your {$typeLabel} request from {$leave->start_date->format('M d')} to {$leave->end_date->format('M d')} has been rejected.",
                    route('hr.leave.index'),
                    'x-circle',
                    ['type' => 'error', 'actor_id' => auth()->id()]
                );
            }
        }

        return Reply::success('Leave request updated successfully.');
    }

    public function destroy(Leave $leave): JsonResponse
    {
        $leave->delete();

        return Reply::success('Leave request deleted successfully.');
    }

    public function previewCode(): JsonResponse
    {
        return response()->json([
            'code' => $this->codeGenerator->preview('leave'),
        ]);
    }

    public function summary(): JsonResponse
    {
        $counts = [
            'total' => Leave::count(),
            'approved' => Leave::where('status', 'approved')->count(),
            'pending' => Leave::where('status', 'pending')->count(),
            'rejected' => Leave::where('status', 'rejected')->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $counts,
        ]);
    }

    protected function validateLeave(Request $request, ?int $leaveId = null): array
    {
        $rules = [
            'employee_id' => ['required', 'exists:employees,id'],
            'leave_type' => ['required', Rule::in(array_keys($this->leaveTypeOptions()))],
            'reason_category' => ['nullable', Rule::in(array_keys($this->leaveReasonOptions()))],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'status' => ['required', Rule::in(array_keys($this->leaveStatusOptions()))],
            'reason_details' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
            'is_paid' => ['nullable', 'boolean'],
        ];

        return $request->validate($rules);
    }

    protected function applyFilters(Request $request, $query): void
    {
        // Text search filter
        $filterValue = trim((string) $request->input('filter_value', ''));
        
        if ($filterValue !== '') {
            $filterField = $request->input('filter_field', 'all');
            $filterType = $request->input('filter_type', 'contains');
            $value = $filterType === 'equals' ? $filterValue : "%{$filterValue}%";
            $likeComparison = $filterType === 'equals' ? '=' : 'like';

            $query->where(function ($q) use ($filterField, $likeComparison, $value, $filterType) {
                switch ($filterField) {
                    case 'code':
                        $q->where('code', $likeComparison, $value);
                        break;
                    case 'employee':
                        $q->whereHas('employee', function ($employeeQuery) use ($value, $filterType) {
                            $comparison = $filterType === 'equals' ? '=' : 'like';
                            $employeeQuery->whereRaw("CONCAT(IFNULL(first_name,''),' ',IFNULL(middle_name,''),' ',IFNULL(last_name,'')) {$comparison} ?", [$value]);
                        });
                        break;
                    case 'department':
                        $q->whereHas('employee.department', function ($departmentQuery) use ($likeComparison, $value) {
                            $departmentQuery->where('name', $likeComparison, $value);
                        });
                        break;
                    case 'type':
                        $q->where('leave_type', $likeComparison, $value);
                        break;
                    default: // 'all'
                        $q->where(function ($subQ) use ($likeComparison, $value, $filterType) {
                            $subQ->where('code', $likeComparison, $value)
                                ->orWhere('leave_type', $likeComparison, $value)
                                ->orWhereHas('employee', function ($employeeQuery) use ($value, $filterType) {
                                    $comparison = $filterType === 'equals' ? '=' : 'like';
                                    $employeeQuery->whereRaw("CONCAT(IFNULL(first_name,''),' ',IFNULL(middle_name,''),' ',IFNULL(last_name,'')) {$comparison} ?", [$value]);
                                });
                        });
                }
            });
        }

        // Leave type filter
        $leaveType = $request->input('filter_leave_type');
        if ($leaveType !== null && $leaveType !== '') {
            $query->where('leave_type', $leaveType);
        }

        // Status filter
        $status = $request->input('filter_status');
        if ($status !== null && $status !== '') {
            $query->where('status', $status);
        }

        // Date range filters - validate date format
        $from = $request->input('filter_from');
        if ($from !== null && $from !== '' && preg_match('/^\d{4}-\d{2}-\d{2}$/', $from)) {
            $query->whereDate('start_date', '>=', $from);
        }

        $to = $request->input('filter_to');
        if ($to !== null && $to !== '' && preg_match('/^\d{4}-\d{2}-\d{2}$/', $to)) {
            $query->whereDate('end_date', '<=', $to);
        }
    }

    protected function renderRequestColumn(Leave $leave): string
    {
        $typeLabel = $this->leaveTypeOptions()[$leave->leave_type] ?? ucfirst($leave->leave_type);

        return <<<HTML
            <div class="leading-tight">
                <p class="font-semibold text-slate-800">{$leave->code}</p>
                <p class="text-xs text-slate-500">{$typeLabel}</p>
            </div>
        HTML;
    }

    protected function renderEmployeeColumn(Leave $leave): string
    {
        $employee = $leave->employee;
        $avatar = $employee?->profile_picture_url ?? asset('images/default-avatar.jpg');
        $name = $employee?->full_name ?? '—';
        $position = $employee?->position ?? '—';
        $department = $employee?->department?->name ?? '—';

        return <<<HTML
            <div class="flex items-center gap-3">
                <img src="{$avatar}" alt="{$name}" class="h-10 w-10 rounded-full object-cover border border-slate-200"/>
                <div class="leading-tight">
                    <p class="font-semibold text-slate-800">{$name}</p>
                    <p class="text-xs text-slate-500">{$position} • {$department}</p>
                </div>
            </div>
        HTML;
    }

    protected function renderPeriodColumn(Leave $leave): string
    {
        $start = $leave->start_date ? Carbon::parse($leave->start_date)->format('d M Y') : '—';
        $end = $leave->end_date ? Carbon::parse($leave->end_date)->format('d M Y') : '—';
        $days = $leave->days_count ?? $this->calculateDays($leave->start_date, $leave->end_date);

        return <<<HTML
            <div class="leading-tight">
                <p class="font-semibold text-slate-800">{$start} → {$end}</p>
                <p class="text-xs text-slate-500">{$days} days</p>
            </div>
        HTML;
    }

    protected function renderReasonColumn(Leave $leave): string
    {
        $reasonLabel = $leave->reason_category
            ? ($this->leaveReasonOptions()[$leave->reason_category] ?? ucfirst($leave->reason_category))
            : 'Not specified';
        $details = $leave->reason_details ? '<p class="mt-1 text-xs text-slate-500">' . e($leave->reason_details) . '</p>' : '';

        return <<<HTML
            <div>
                <span class="leave-reason-chip">{$reasonLabel}</span>
                {$details}
            </div>
        HTML;
    }

    protected function renderStatusBadge(string $status): string
    {
        $label = $this->leaveStatusOptions()[$status] ?? ucfirst($status);
        
        // Use unified badge styling like Positions
        $colorClasses = match($status) {
            'approved' => 'text-lime-600',
            'pending' => 'text-amber-600',
            'rejected' => 'text-rose-500',
            default => 'text-slate-500',
        };

        $iconSvg = match($status) {
            'approved' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>',
            'pending' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',
            'rejected' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6L6 18"/><path d="M6 6l12 12"/></svg>',
            default => '',
        };

        return <<<HTML
            <span class="inline-flex items-center text-base font-semibold {$colorClasses}">
                {$iconSvg}
                {$label}
            </span>
        HTML;
    }

    protected function calculateDays(string $start, string $end): int
    {
        $startDate = Carbon::parse($start);
        $endDate = Carbon::parse($end);

        return max($startDate->diffInDays($endDate) + 1, 1);
    }

    protected function leaveTypeOptions(): array
    {
        return [
            'annual' => 'Annual Leave',
            'sick' => 'Sick Leave',
            'unpaid' => 'Unpaid Leave',
            'emergency' => 'Emergency Leave',
            'maternity' => 'Maternity / Paternity',
        ];
    }

    protected function leaveReasonOptions(): array
    {
        return [
            'vacation' => 'Vacation & Travel',
            'medical' => 'Medical Appointment',
            'family' => 'Family Obligation',
            'remote' => 'Remote Work Request',
            'other' => 'Other Reason',
        ];
    }

    protected function leaveStatusOptions(): array
    {
        return [
            'pending' => 'Pending Review',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
        ];
    }
}

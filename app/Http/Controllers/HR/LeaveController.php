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
        $query = Leave::query()
            ->with(['employee.department', 'employee.company'])
            ->orderByDesc('created_at');

        $this->applyFilters($request, $query);

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('request', fn (Leave $leave) => $this->renderRequestColumn($leave))
            ->addColumn('employee', fn (Leave $leave) => $this->renderEmployeeColumn($leave))
            ->addColumn('period', fn (Leave $leave) => $this->renderPeriodColumn($leave))
            ->addColumn('reason', fn (Leave $leave) => $this->renderReasonColumn($leave))
            ->addColumn('status', fn (Leave $leave) => $this->renderStatusBadge($leave->status))
            ->addColumn('actions', fn (Leave $leave) => view('hr.leave.partials.actions', compact('leave'))->render())
            ->rawColumns(['request', 'employee', 'period', 'reason', 'status', 'actions'])
            ->toJson();
    }

    public function store(Request $request): JsonResponse
    {
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
        $validated = $this->validateLeave($request, $leave->id);
        $oldStatus = $leave->status;

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
        $filterField = $request->input('filter_field', 'all');
        $filterType = $request->input('filter_type', 'contains');
        $filterValue = trim((string) $request->input('filter_value'));

        if ($filterValue !== '') {
            $query->where(function ($q) use ($filterField, $filterType, $filterValue) {
                $value = $filterType === 'equals' ? $filterValue : "%{$filterValue}%";

                $likeComparison = $filterType === 'equals' ? '=' : 'like';

                $apply = function ($builder, $column) use ($likeComparison, $value) {
                    $builder->where($column, $likeComparison, $value);
                };

                switch ($filterField) {
                    case 'code':
                        $apply($q, 'code');
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
                        $apply($q, 'leave_type');
                        break;
                    default:
                        $q->where('code', $likeComparison, $value)
                            ->orWhere('leave_type', $likeComparison, $value)
                            ->orWhereHas('employee', function ($employeeQuery) use ($value, $filterType) {
                                $comparison = $filterType === 'equals' ? '=' : 'like';
                                $employeeQuery->whereRaw("CONCAT(IFNULL(first_name,''),' ',IFNULL(middle_name,''),' ',IFNULL(last_name,'')) {$comparison} ?", [$value]);
                            });
                }
            });
        }

        if ($type = $request->input('filter_leave_type')) {
            $query->where('leave_type', $type);
        }

        if ($status = $request->input('filter_status')) {
            $query->where('status', $status);
        }

        if ($from = $request->input('filter_from')) {
            $query->whereDate('start_date', '>=', $from);
        }

        if ($to = $request->input('filter_to')) {
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
        $classMap = [
            'pending' => 'leave-status-badge leave-status-badge--pending',
            'approved' => 'leave-status-badge leave-status-badge--approved',
            'rejected' => 'leave-status-badge leave-status-badge--rejected',
        ];

        $classes = $classMap[$status] ?? 'leave-status-badge';

        return "<span class=\"{$classes}\">{$label}</span>";
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

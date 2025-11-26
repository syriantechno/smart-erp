<?php

namespace App\Http\Controllers\Work;

use App\Http\Controllers\Controller;
use App\Models\Work\Task;
use App\Models\Work\TaskExtensionRequest;
use App\Models\Work\TaskActivity;
use App\Models\User;
use App\Services\DocumentCodeGenerator;
use App\Services\Notifications\NotificationDispatcher;
use App\Helpers\Reply;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class TaskExtensionRequestController extends Controller
{
    public function __construct(
        private DocumentCodeGenerator $codeGenerator
    ) {}

    /**
     * Display a listing of extension requests.
     */
    public function index(Request $request)
    {
        $pendingCount = TaskExtensionRequest::pending()->count();
        $approvedCount = TaskExtensionRequest::approved()->count();
        $rejectedCount = TaskExtensionRequest::rejected()->count();

        return view('tasks.extension-requests.index', compact('pendingCount', 'approvedCount', 'rejectedCount'));
    }

    /**
     * Get datatable data.
     */
    public function datatable(Request $request): JsonResponse
    {
        $query = TaskExtensionRequest::with(['task', 'requester', 'reviewer']);

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        Log::info('Extension Requests Datatable', ['count' => $query->count()]);

        return DataTables::of($query)
            ->addColumn('task_info', function ($row) {
                return $row->task ? "{$row->task->code} - {$row->task->title}" : '-';
            })
            ->addColumn('requester_name', function ($row) {
                return $row->requester->name ?? '-';
            })
            ->addColumn('reviewer_name', function ($row) {
                return $row->reviewer->name ?? '-';
            })
            ->addColumn('current_due_date_formatted', function ($row) {
                return $row->current_due_date ? $row->current_due_date->format('d M, Y') : '-';
            })
            ->addColumn('requested_due_date_formatted', function ($row) {
                return $row->requested_due_date ? $row->requested_due_date->format('d M, Y') : '-';
            })
            ->addColumn('status_badge', function ($row) {
                return '<span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ' . $row->status_badge_class . '">' . $row->status_label . '</span>';
            })
            ->addColumn('actions', function ($row) {
                $actions = '<div class="flex items-center gap-2">';
                
                if ($row->isPending()) {
                    $actions .= '<button type="button" class="btn-royal btn-royal--sm btn-royal--gold approve-btn" data-id="' . $row->id . '">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        موافقة
                    </button>';
                    $actions .= '<button type="button" class="btn-royal btn-royal--sm btn-royal--outline reject-btn" data-id="' . $row->id . '">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        رفض
                    </button>';
                }
                
                $actions .= '<button type="button" class="btn-royal btn-royal--sm btn-royal--outline view-btn" data-id="' . $row->id . '">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </button>';
                
                $actions .= '</div>';
                return $actions;
            })
            ->rawColumns(['status_badge', 'actions'])
            ->make(true);
    }

    /**
     * Store a new extension request.
     */
    public function store(Request $request, Task $task): JsonResponse
    {
        $validated = $request->validate([
            'requested_due_date' => 'required|date|after:today',
            'reason' => 'required|string|min:10|max:1000',
        ], [
            'requested_due_date.required' => 'يرجى تحديد تاريخ الاستحقاق المطلوب',
            'requested_due_date.after' => 'يجب أن يكون التاريخ المطلوب بعد اليوم',
            'reason.required' => 'يرجى إدخال سبب طلب التمديد',
            'reason.min' => 'يجب أن يكون السبب 10 أحرف على الأقل',
        ]);

        try {
            DB::beginTransaction();

            // Check if task already has pending extension request
            if ($task->hasPendingExtensionRequest()) {
                return Reply::error('يوجد طلب تمديد قيد الانتظار لهذه المهمة');
            }

            // Check if task has due date
            if (!$task->due_date) {
                return Reply::error('لا يمكن طلب تمديد لمهمة بدون تاريخ استحقاق');
            }

            // Parse requested date
            $requestedDueDate = Carbon::parse($validated['requested_due_date']);
            $currentDueDate = $task->due_date;

            // Calculate extension days
            $extensionDays = $currentDueDate->diffInDays($requestedDueDate);

            // Generate code
            $code = $this->codeGenerator->generate('task_extension_requests');

            // Create extension request
            $extensionRequest = TaskExtensionRequest::create([
                'code' => $code,
                'task_id' => $task->id,
                'requested_by' => auth()->id(),
                'current_due_date' => $currentDueDate,
                'requested_due_date' => $requestedDueDate,
                'extension_days' => $extensionDays,
                'reason' => $validated['reason'],
                'status' => TaskExtensionRequest::STATUS_PENDING,
            ]);

            // Log activity
            $task->logActivity(
                'extension_requested',
                'due_date',
                $currentDueDate->format('Y-m-d'),
                $requestedDueDate->format('Y-m-d'),
                'تم طلب تمديد تاريخ الاستحقاق'
            );

            // Send notification to managers/admins
            $this->notifyExtensionRequested($extensionRequest);

            DB::commit();

            return Reply::success('تم إرسال طلب التمديد بنجاح', [
                'extension_request' => $extensionRequest
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating extension request: ' . $e->getMessage());
            return Reply::error('حدث خطأ أثناء إرسال الطلب: ' . $e->getMessage());
        }
    }

    /**
     * Show extension request details.
     */
    public function show(TaskExtensionRequest $extensionRequest): JsonResponse
    {
        $extensionRequest->load(['task', 'requester', 'reviewer']);

        return Reply::success('', [
            'extension_request' => [
                'id' => $extensionRequest->id,
                'code' => $extensionRequest->code,
                'task' => [
                    'id' => $extensionRequest->task->id,
                    'code' => $extensionRequest->task->code,
                    'title' => $extensionRequest->task->title,
                ],
                'requester' => $extensionRequest->requester->name ?? '-',
                'reviewer' => $extensionRequest->reviewer->name ?? '-',
                'current_due_date' => $extensionRequest->current_due_date->format('d M, Y'),
                'requested_due_date' => $extensionRequest->requested_due_date->format('d M, Y'),
                'extension_days' => $extensionRequest->extension_days,
                'reason' => $extensionRequest->reason,
                'review_notes' => $extensionRequest->review_notes,
                'status' => $extensionRequest->status,
                'status_label' => $extensionRequest->status_label,
                'status_badge_class' => $extensionRequest->status_badge_class,
                'reviewed_at' => $extensionRequest->reviewed_at?->format('d M, Y H:i'),
                'created_at' => $extensionRequest->created_at->format('d M, Y H:i'),
            ]
        ]);
    }

    /**
     * Approve extension request.
     */
    public function approve(Request $request, TaskExtensionRequest $extensionRequest): JsonResponse
    {
        $validated = $request->validate([
            'review_notes' => 'nullable|string|max:500',
        ]);

        if (!$extensionRequest->isPending()) {
            return Reply::error('لا يمكن الموافقة على هذا الطلب');
        }

        try {
            DB::beginTransaction();

            $extensionRequest->approve(auth()->id(), $validated['review_notes'] ?? null);

            // Send notification to requester
            $this->notifyExtensionApproved($extensionRequest);

            DB::commit();

            return Reply::success('تمت الموافقة على طلب التمديد وتم تحديث تاريخ استحقاق المهمة');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error approving extension request: ' . $e->getMessage());
            return Reply::error('حدث خطأ أثناء الموافقة على الطلب');
        }
    }

    /**
     * Reject extension request.
     */
    public function reject(Request $request, TaskExtensionRequest $extensionRequest): JsonResponse
    {
        $validated = $request->validate([
            'review_notes' => 'required|string|min:5|max:500',
        ], [
            'review_notes.required' => 'يرجى إدخال سبب الرفض',
            'review_notes.min' => 'يجب أن يكون سبب الرفض 5 أحرف على الأقل',
        ]);

        if (!$extensionRequest->isPending()) {
            return Reply::error('لا يمكن رفض هذا الطلب');
        }

        try {
            DB::beginTransaction();

            $extensionRequest->reject(auth()->id(), $validated['review_notes']);

            // Log activity
            $extensionRequest->task->logActivity(
                'extension_rejected',
                'due_date',
                null,
                null,
                'تم رفض طلب تمديد تاريخ الاستحقاق'
            );

            // Send notification to requester
            $this->notifyExtensionRejected($extensionRequest);

            DB::commit();

            return Reply::success('تم رفض طلب التمديد');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error rejecting extension request: ' . $e->getMessage());
            return Reply::error('حدث خطأ أثناء رفض الطلب');
        }
    }

    /**
     * Get pending requests count for notifications.
     */
    public function pendingCount(): JsonResponse
    {
        $count = TaskExtensionRequest::pending()->count();
        return Reply::success('', ['count' => $count]);
    }

    /**
     * Get extension requests for a specific task.
     */
    public function taskRequests(Task $task): JsonResponse
    {
        $requests = $task->extensionRequests()
            ->with(['requester:id,name', 'reviewer:id,name'])
            ->get()
            ->map(function ($request) {
                return [
                    'id' => $request->id,
                    'code' => $request->code,
                    'current_due_date' => $request->current_due_date->format('d M, Y'),
                    'requested_due_date' => $request->requested_due_date->format('d M, Y'),
                    'extension_days' => $request->extension_days,
                    'reason' => $request->reason,
                    'review_notes' => $request->review_notes,
                    'status' => $request->status,
                    'status_label' => $request->status_label,
                    'status_badge_class' => $request->status_badge_class,
                    'requester' => $request->requester->name ?? '-',
                    'reviewer' => $request->reviewer->name ?? '-',
                    'reviewed_at' => $request->reviewed_at?->format('d M, Y H:i'),
                    'created_at' => $request->created_at->format('d M, Y H:i'),
                ];
            });

        return Reply::success('', ['requests' => $requests]);
    }

    /**
     * Send notification when extension is requested.
     */
    protected function notifyExtensionRequested(TaskExtensionRequest $extensionRequest): void
    {
        try {
            // Get managers/admins to notify
            $managerIds = User::whereHas('roles', function ($query) {
                $query->whereIn('name', ['admin', 'manager', 'super-admin']);
            })->pluck('id')->toArray();

            // Also notify task assignedBy if exists
            if ($extensionRequest->task->assigned_by) {
                $managerIds[] = $extensionRequest->task->assigned_by;
            }

            $managerIds = array_unique(array_filter($managerIds));

            if (empty($managerIds)) {
                return;
            }

            $requesterName = $extensionRequest->requester->name ?? 'موظف';
            $taskTitle = $extensionRequest->task->title;

            NotificationDispatcher::toUsers(
                $managerIds,
                'task_extension.requested',
                'طلب تمديد مهمة جديد',
                "{$requesterName} طلب تمديد وقت للمهمة: {$taskTitle}",
                route('tasks.extension-requests.index'),
                'clock',
                [
                    'type' => 'task_extension_request',
                    'extension_request_id' => $extensionRequest->id,
                    'task_id' => $extensionRequest->task_id,
                    'actor_id' => auth()->id(),
                ]
            );
        } catch (\Exception $e) {
            Log::error('Failed to send extension request notification: ' . $e->getMessage());
        }
    }

    /**
     * Send notification when extension is approved.
     */
    protected function notifyExtensionApproved(TaskExtensionRequest $extensionRequest): void
    {
        try {
            $reviewerName = auth()->user()->name ?? 'المدير';
            $taskTitle = $extensionRequest->task->title;
            $newDueDate = $extensionRequest->requested_due_date->format('d M, Y');

            NotificationDispatcher::toUser(
                $extensionRequest->requested_by,
                'task_extension.approved',
                'تمت الموافقة على طلب التمديد',
                "تمت الموافقة على طلب تمديد المهمة: {$taskTitle}. التاريخ الجديد: {$newDueDate}",
                route('tasks.show', $extensionRequest->task_id),
                'check-circle',
                [
                    'type' => 'task_extension_approved',
                    'extension_request_id' => $extensionRequest->id,
                    'task_id' => $extensionRequest->task_id,
                    'actor_id' => auth()->id(),
                ]
            );
        } catch (\Exception $e) {
            Log::error('Failed to send extension approved notification: ' . $e->getMessage());
        }
    }

    /**
     * Send notification when extension is rejected.
     */
    protected function notifyExtensionRejected(TaskExtensionRequest $extensionRequest): void
    {
        try {
            $reviewerName = auth()->user()->name ?? 'المدير';
            $taskTitle = $extensionRequest->task->title;

            NotificationDispatcher::toUser(
                $extensionRequest->requested_by,
                'task_extension.rejected',
                'تم رفض طلب التمديد',
                "تم رفض طلب تمديد المهمة: {$taskTitle}. السبب: {$extensionRequest->review_notes}",
                route('tasks.show', $extensionRequest->task_id),
                'x-circle',
                [
                    'type' => 'task_extension_rejected',
                    'extension_request_id' => $extensionRequest->id,
                    'task_id' => $extensionRequest->task_id,
                    'actor_id' => auth()->id(),
                ]
            );
        } catch (\Exception $e) {
            Log::error('Failed to send extension rejected notification: ' . $e->getMessage());
        }
    }
}

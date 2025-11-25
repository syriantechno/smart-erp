<?php

namespace App\Http\Controllers\Work;

use App\Http\Controllers\Controller;
use App\Models\Work\Task;
use App\Models\Work\TaskStep;
use App\Models\Work\TaskComment;
use App\Models\Work\TaskAttachment;
use App\Models\Work\TaskTimeLog;
use App\Models\Work\TaskChecklist;
use App\Models\Work\TaskLabel;
use App\Models\Work\Project;
use App\Models\HR\Employee;
use App\Models\HR\Department;
use App\Models\Setting\Company;
use App\Services\DocumentCodeGenerator;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Exports\TasksExport;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\Reply;
use Carbon\Carbon;

class TaskController extends Controller
{
    protected TaskService $taskService;

    public function __construct(
        private DocumentCodeGenerator $codeGenerator,
        TaskService $taskService
    ) {
        $this->taskService = $taskService;
    }

    public function index()
    {
        $companies = Company::where('is_active', true)->select('id', 'name')->get();
        $departments = Department::where('is_active', true)->select('id', 'name')->get();
        $employees = Employee::where('is_active', true)->select('id', 'first_name', 'last_name')->get();

        return view('tasks.index', compact('companies', 'departments', 'employees'));
    }

    public function previewCode()
    {
        $code = $this->codeGenerator->preview('tasks');
        return Reply::success('', ['code' => $code]);
    }

    public function datatable(Request $request): JsonResponse
    {
        $baseQuery = Task::query()
            ->with(['employee:id,first_name,last_name', 'department:id,name', 'company:id,name']);

        // Apply filters
        if ($request->filled('filter_field') && $request->filled('filter_value')) {
            $field = $request->filter_field;
            $type = $request->filter_type ?? 'contains';
            $value = $request->filter_value;

            if ($field === 'all') {
                $baseQuery->where(function ($query) use ($value, $type) {
                    $query->where('code', $type === 'equals' ? '=' : 'like', $type === 'equals' ? $value : "%{$value}%")
                          ->orWhere('title', $type === 'equals' ? '=' : 'like', $type === 'equals' ? $value : "%{$value}%")
                          ->orWhere('description', $type === 'equals' ? '=' : 'like', $type === 'equals' ? $value : "%{$value}%");
                });
            } else {
                $operator = $type === 'equals' ? '=' : 'like';
                $searchValue = $type === 'equals' ? $value : "%{$value}%";
                $baseQuery->where($field, $operator, $searchValue);
            }
        }

        // Apply advanced filters
        if ($request->filled('company_id') && $request->company_id !== '') {
            $baseQuery->where('company_id', $request->company_id);
        }

        if ($request->filled('department_id') && $request->department_id !== '') {
            $baseQuery->where('department_id', $request->department_id);
        }

        if ($request->filled('employee_id') && $request->employee_id !== '') {
            $baseQuery->where('employee_id', $request->employee_id);
        }

        if ($request->filled('status_filter') && $request->status_filter !== '') {
            $baseQuery->where('status', '=', $request->status_filter);
        }

        if ($request->filled('priority_filter') && $request->priority_filter !== '') {
            $baseQuery->where('priority', '=', $request->priority_filter);
        }

        return DataTables::of($baseQuery)
            ->addIndexColumn()
            ->addColumn('code', function ($task) {
                return $task->code ?? '-';
            })
            ->addColumn('title', function ($task) {
                return $task->title;
            })
            ->addColumn('employee_name', function ($task) {
                return $task->employee ? $task->employee->full_name : '-';
            })
            ->addColumn('department_name', function ($task) {
                return $task->department ? $task->department->name : '-';
            })
            ->addColumn('priority', function ($task) {
                $priorityClass = $task->getPriorityBadgeClass();
                return "<span class=\"inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {$priorityClass}\">{$task->priority}</span>";
            })
            ->addColumn('status', function ($task) {
                $statusClass = $task->getStatusBadgeClass();
                $statusLabel = ucfirst(str_replace('_', ' ', $task->status));
                return "<span class=\"inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {$statusClass}\">{$statusLabel}</span>";
            })
            ->addColumn('due_date_formatted', function ($task) {
                return $task->due_date ? $task->due_date->format('M d, Y') : '-';
            })
            ->addColumn('actions', function ($task) {
                return view('tasks.partials.actions', ['task' => $task])->render();
            })
            ->rawColumns(['status', 'priority', 'actions'])
            ->make(true);
    }

    public function create()
    {
        $departments = Department::where('is_active', true)->get();
        $companies = Company::where('is_active', true)->get();
        $employees = Employee::where('is_active', true)->get();
        return view('tasks.create', compact('departments', 'companies', 'employees'));
    }

    public function store(Request $request)
    {
        Log::info('TASK_STORE_ENTER', [
            'url' => $request->fullUrl(),
            'method' => $request->method(),
        ]);

        Log::info('TASK_STORE_RAW', $request->all());

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'color' => 'nullable|string|max:32',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'due_date' => 'nullable|date',
            'employee_id' => 'nullable|exists:employees,id',
            'project_id' => 'nullable|exists:projects,id',
            'estimated_hours' => 'nullable|numeric|min:0|max:999.99',
            'tags' => 'nullable|string|max:1000',
            'is_active' => 'nullable|boolean',
            'steps' => 'nullable|array',
            'steps.*.title' => 'required|string|max:255',
            'steps.*.description' => 'nullable|string|max:1000',
            'steps.*.step_order' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            // Convert due_date to proper format if provided
            if (!empty($validated['due_date'])) {
                try {
                    $validated['due_date'] = Carbon::parse($validated['due_date'])->format('Y-m-d');
                } catch (\Exception $e) {
                    Log::warning('Invalid due_date format', ['due_date' => $validated['due_date']]);
                    $validated['due_date'] = null;
                }
            }

            $validated['code'] = $this->codeGenerator->generate('tasks');
            $validated['assigned_by'] = auth()->id();
            $validated['is_active'] = $request->boolean('is_active', true);

            // Auto-assign department and company from selected employee
            if (!empty($validated['employee_id'])) {
                $employee = Employee::find($validated['employee_id']);
                if ($employee) {
                    $validated['department_id'] = $employee->department_id;
                    $validated['company_id'] = $employee->company_id;
                }
            }

            // Extract steps data before creating task
            $stepsData = $validated['steps'] ?? [];
            unset($validated['steps']);

            Log::info('TASK_STORE_ATTEMPT', $validated);

            $task = Task::create($validated);
            
            Log::info('TASK_CREATED_SUCCESS', [
                'task_id' => $task->id,
                'task_code' => $task->code,
                'task_title' => $task->title
            ]);

            // Create task steps if provided
            if (!empty($stepsData)) {
                foreach ($stepsData as $stepData) {
                    $task->steps()->create([
                        'title' => $stepData['title'],
                        'description' => $stepData['description'] ?? null,
                        'step_order' => $stepData['step_order'],
                        'is_completed' => false,
                    ]);
                }
                Log::info('TASK_STEPS_CREATED', [
                    'task_id' => $task->id,
                    'steps_count' => count($stepsData)
                ]);
            }

            DB::commit();

            if ($request->ajax()) {
                return Reply::success('Task created successfully');
            }

            return redirect()->route('tasks.index')
                ->with('success', 'تم إضافة المهمة بنجاح');
        } catch (\Exception $e) {
            Log::error('TASK_STORE_EXCEPTION', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            DB::rollBack();

            if ($request->ajax()) {
                return Reply::error('Error creating task: ' . $e->getMessage(), [], 500);
            }

            return back()->with('error', 'Error creating task: ' . $e->getMessage());
        }
    }

    public function show(Task $task)
    {
        $task->load(['steps', 'employee', 'project', 'assignedBy', 'taskComments']);
        return view('tasks.show', compact('task'));
    }

    public function addComment(Request $request, Task $task)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
            'is_internal' => 'boolean',
            'step_id' => 'nullable|exists:task_steps,id'
        ]);

        try {
            $comment = TaskComment::create([
                'task_id' => $task->id,
                'user_id' => auth()->id(),
                'comment' => $request->comment,
                'type' => $request->step_id ? 'step' : 'task',
                'step_id' => $request->step_id,
                'is_internal' => $request->boolean('is_internal', false),
            ]);

            $comment->load('user');

            Log::info('TASK_COMMENT_ADDED', [
                'task_id' => $task->id,
                'comment_id' => $comment->id,
                'user_id' => auth()->id(),
                'type' => $comment->type
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Comment added successfully',
                'comment' => [
                    'id' => $comment->id,
                    'comment' => $comment->comment,
                    'is_internal' => $comment->is_internal,
                    'time_ago' => $comment->time_ago,
                    'user' => [
                        'name' => $comment->user->name,
                        'initial' => strtoupper(substr($comment->user->name, 0, 1)),
                    ],
                    'likes_count' => 0,
                    'dislikes_count' => 0,
                    'user_reaction' => null,
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('TASK_COMMENT_ERROR', [
                'task_id' => $task->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to add comment'
            ], 500);
        }
    }

    /**
     * Toggle reaction on a comment.
     */
    public function toggleCommentReaction(Request $request, TaskComment $comment): JsonResponse
    {
        $request->validate([
            'type' => 'required|in:like,dislike'
        ]);

        try {
            $result = $comment->toggleReaction($request->type);

            return Reply::success('Reaction updated', [
                'action' => $result['action'],
                'user_reaction' => $result['type'],
                'likes_count' => $comment->fresh()->likes_count,
                'dislikes_count' => $comment->fresh()->dislikes_count,
            ]);
        } catch (\Exception $e) {
            return Reply::error('Failed to update reaction', [], 500);
        }
    }

    /**
     * Delete a comment.
     */
    public function deleteComment(TaskComment $comment): JsonResponse
    {
        try {
            // Check if user owns the comment or is admin
            if ($comment->user_id !== auth()->id()) {
                return Reply::error('Unauthorized', [], 403);
            }

            $comment->delete();

            return Reply::success('Comment deleted successfully');
        } catch (\Exception $e) {
            return Reply::error('Failed to delete comment', [], 500);
        }
    }

    /**
     * Toggle like on a task.
     */
    public function toggleLike(Task $task): JsonResponse
    {
        try {
            $result = $task->toggleLike();

            return Reply::success('Like updated', [
                'action' => $result['action'],
                'likes_count' => $result['likes_count'],
                'is_liked' => $result['action'] === 'liked',
            ]);
        } catch (\Exception $e) {
            return Reply::error('Failed to update like', [], 500);
        }
    }

    public function completeStep(TaskStep $step)
    {
        try {
            $step->markAsCompleted();
            
            // Check if all steps are completed
            $task = $step->task;
            $allStepsCompleted = $task->steps()->where('is_completed', false)->count() === 0;
            
            $message = 'Step marked as completed successfully';
            
            if ($allStepsCompleted && $task->status !== 'completed') {
                // Auto-complete the task when all steps are done
                $task->update(['status' => 'completed']);
                $message .= ' All steps completed! Task automatically marked as completed.';
                
                Log::info('TASK_AUTO_COMPLETED', [
                    'task_id' => $task->id,
                    'task_code' => $task->code,
                    'completed_by_step' => $step->id
                ]);
            }
            
            return response()->json([
                'success' => true,
                'message' => $message,
                'all_completed' => $allStepsCompleted
            ]);
            
        } catch (\Exception $e) {
            Log::error('STEP_COMPLETE_ERROR', [
                'step_id' => $step->id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to complete step'
            ], 500);
        }
    }

    public function uncompleteStep(TaskStep $step)
    {
        try {
            $step->markAsPending();
            
            return response()->json([
                'success' => true,
                'message' => 'Step marked as pending successfully'
            ]);
            
        } catch (\Exception $e) {
            Log::error('STEP_UNCOMPLETE_ERROR', [
                'step_id' => $step->id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to uncomplete step'
            ], 500);
        }
    }

    public function edit(Task $task)
    {
        $departments = Department::where('is_active', true)->get();
        $companies = Company::where('is_active', true)->get();
        $employees = Employee::where('is_active', true)->get();
        return view('tasks.edit', compact('task', 'departments', 'companies', 'employees'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'due_date' => 'nullable|date_format:d M, Y',
            'employee_id' => 'nullable|exists:employees,id',
            'department_id' => 'nullable|exists:departments,id',
            'company_id' => 'nullable|exists:companies,id',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            DB::beginTransaction();

            if (!empty($validated['due_date'])) {
                $validated['due_date'] = Carbon::createFromFormat('d M, Y', $validated['due_date'])->format('Y-m-d');
            }

            $validated['is_active'] = $request->boolean('is_active', true);

            $task->update($validated);

            DB::commit();

            if ($request->ajax()) {
                return Reply::success('Task updated successfully');
            }

            return redirect()->route('tasks.index')
                ->with('success', 'تم تحديث المهمة بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return Reply::error('Error updating task: ' . $e->getMessage(), [], 500);
            }

            return back()->with('error', 'Error updating task: ' . $e->getMessage());
        }
    }

    public function destroy(Task $task, Request $request)
    {
        try {
            DB::beginTransaction();

            $task->delete();

            DB::commit();

            if ($request->ajax()) {
                return Reply::success('Task deleted successfully');
            }

            return redirect()->route('tasks.index')
                ->with('success', 'تم حذف المهمة بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return Reply::error('Error deleting task: ' . $e->getMessage(), [], 500);
            }

            return back()->with('error', 'Error deleting task: ' . $e->getMessage());
        }
    }

    public function kanbanData(Request $request): JsonResponse
    {
        $query = Task::query()
            ->with(['employee:id,first_name,last_name', 'department:id,name', 'company:id,name']);

        if ($request->filled('company_id') && $request->company_id !== '') {
            $query->where('company_id', $request->company_id);
        }

        if ($request->filled('department_id') && $request->department_id !== '') {
            $query->where('department_id', $request->department_id);
        }

        if ($request->filled('employee_id') && $request->employee_id !== '') {
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->filled('status_filter') && $request->status_filter !== '') {
            $query->where('status', $request->status_filter);
        }

        $tasks = $query
            ->orderByRaw("FIELD(status, 'pending', 'in_progress', 'completed', 'cancelled')")
            ->orderBy('priority', 'desc')
            ->orderBy('due_date', 'asc')
            ->get();

        $grouped = [
            'pending' => [],
            'in_progress' => [],
            'completed' => [],
            'cancelled' => [],
        ];

        foreach ($tasks as $task) {
            $status = $task->status ?? 'pending';
            if (! isset($grouped[$status])) {
                $grouped[$status] = [];
            }

            $grouped[$status][] = [
                'id' => $task->id,
                'code' => $task->code,
                'title' => $task->title,
                'description' => $task->description,
                'priority' => $task->priority,
                'status' => $task->status,
                'color' => $task->color,
                'due_date' => $task->due_date ? $task->due_date->format('Y-m-d') : null,
                'due_date_formatted' => $task->due_date ? $task->due_date->format('M d, Y') : null,
                'employee_name' => $task->employee ? $task->employee->full_name : null,
                'department_name' => $task->department ? $task->department->name : null,
                'company_name' => $task->company ? $task->company->name : null,
            ];
        }

        return Reply::success('', ['data' => $grouped]);
    }

    public function updateStatus(Request $request, Task $task): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'status' => ['required', Rule::in(['pending', 'in_progress', 'completed', 'cancelled'])],
        ]);

        if ($validator->fails()) {
            return Reply::error('Invalid status value', ['errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();

            $task->status = $request->input('status');
            $task->save();

            DB::commit();

            return Reply::success('Task status updated successfully', [
                'task' => [
                    'id' => $task->id,
                    'status' => $task->status,
                ],
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return Reply::error('Error updating task status: ' . $e->getMessage(), [], 500);
        }
    }

    // ============================================
    // NEW ENHANCED TASK METHODS
    // ============================================

    /**
     * Get task statistics for dashboard.
     */
    public function statistics(Request $request): JsonResponse
    {
        $employeeId = $request->employee_id;
        $projectId = $request->project_id;

        if ($employeeId) {
            $stats = $this->taskService->getEmployeeTaskStats($employeeId);
        } elseif ($projectId) {
            $stats = $this->taskService->getProjectTaskStats($projectId);
        } else {
            // Global stats
            $tasks = Task::query();
            $stats = [
                'total' => $tasks->count(),
                'completed' => (clone $tasks)->where('status', 'completed')->count(),
                'in_progress' => (clone $tasks)->where('status', 'in_progress')->count(),
                'pending' => (clone $tasks)->where('status', 'pending')->count(),
                'overdue' => (clone $tasks)->overdue()->count(),
                'due_today' => (clone $tasks)->dueToday()->count(),
            ];
        }

        return Reply::success('', ['stats' => $stats]);
    }

    /**
     * Create a subtask.
     */
    public function createSubtask(Request $request, Task $task): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
            'employee_id' => 'nullable|exists:employees,id',
        ]);

        try {
            $validated['code'] = $this->codeGenerator->generate('tasks');
            $validated['assigned_by'] = auth()->id();
            $validated['status'] = 'pending';

            $subtask = $this->taskService->createSubtask($task, $validated);

            return Reply::success('Subtask created successfully', ['subtask' => $subtask]);
        } catch (\Exception $e) {
            return Reply::error('Error creating subtask: ' . $e->getMessage(), [], 500);
        }
    }

    /**
     * Get subtasks for a task.
     */
    public function subtasks(Task $task): JsonResponse
    {
        $subtasks = $task->subtasks()
            ->with(['employee:id,first_name,last_name'])
            ->orderBy('created_at', 'desc')
            ->get();

        return Reply::success('', ['subtasks' => $subtasks]);
    }

    /**
     * Upload attachment to task.
     */
    public function uploadAttachment(Request $request, Task $task): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
            'description' => 'nullable|string|max:500',
        ]);

        try {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('task-attachments/' . $task->id, $filename, 'public');

            $attachment = $task->attachments()->create([
                'uploaded_by' => auth()->id(),
                'filename' => $filename,
                'original_filename' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
                'description' => $request->description,
            ]);

            $task->logActivity('attachment_added', null, null, $file->getClientOriginalName());

            return Reply::success('Attachment uploaded successfully', ['attachment' => $attachment]);
        } catch (\Exception $e) {
            return Reply::error('Error uploading attachment: ' . $e->getMessage(), [], 500);
        }
    }

    /**
     * Delete attachment.
     */
    public function deleteAttachment(Task $task, TaskAttachment $attachment): JsonResponse
    {
        try {
            Storage::disk('public')->delete($attachment->file_path);
            $filename = $attachment->original_filename;
            $attachment->delete();

            $task->logActivity('attachment_removed', null, $filename, null);

            return Reply::success('Attachment deleted successfully');
        } catch (\Exception $e) {
            return Reply::error('Error deleting attachment: ' . $e->getMessage(), [], 500);
        }
    }

    /**
     * Start time tracking.
     */
    public function startTimer(Request $request, Task $task): JsonResponse
    {
        try {
            $timeLog = $this->taskService->startTimer($task, $request->description);

            return Reply::success('Timer started', ['time_log' => $timeLog]);
        } catch (\Exception $e) {
            return Reply::error('Error starting timer: ' . $e->getMessage(), [], 500);
        }
    }

    /**
     * Stop time tracking.
     */
    public function stopTimer(Task $task, TaskTimeLog $timeLog): JsonResponse
    {
        try {
            $timeLog = $this->taskService->stopTimer($timeLog);

            return Reply::success('Timer stopped', [
                'time_log' => $timeLog,
                'total_hours' => $task->fresh()->actual_hours,
            ]);
        } catch (\Exception $e) {
            return Reply::error('Error stopping timer: ' . $e->getMessage(), [], 500);
        }
    }

    /**
     * Get time logs for a task.
     */
    public function timeLogs(Task $task): JsonResponse
    {
        $timeLogs = $task->timeLogs()
            ->with('user:id,name')
            ->orderBy('started_at', 'desc')
            ->get();

        return Reply::success('', [
            'time_logs' => $timeLogs,
            'total_hours' => $task->actual_hours,
            'estimated_hours' => $task->estimated_hours,
        ]);
    }

    /**
     * Add checklist to task.
     */
    public function addChecklist(Request $request, Task $task): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'items' => 'nullable|array',
            'items.*.title' => 'required|string|max:255',
        ]);

        try {
            $checklist = $task->checklists()->create([
                'title' => $validated['title'],
                'sort_order' => $task->checklists()->count(),
            ]);

            if (!empty($validated['items'])) {
                foreach ($validated['items'] as $index => $item) {
                    $checklist->items()->create([
                        'title' => $item['title'],
                        'sort_order' => $index,
                    ]);
                }
            }

            $task->logActivity('checklist_added', null, null, $validated['title']);

            return Reply::success('Checklist added', ['checklist' => $checklist->load('items')]);
        } catch (\Exception $e) {
            return Reply::error('Error adding checklist: ' . $e->getMessage(), [], 500);
        }
    }

    /**
     * Toggle checklist item.
     */
    public function toggleChecklistItem(Request $request, Task $task, $itemId): JsonResponse
    {
        try {
            $item = \App\Models\Work\TaskChecklistItem::findOrFail($itemId);
            $item->toggle();

            $task->updateProgress();

            return Reply::success('Item updated', [
                'item' => $item->fresh(),
                'progress' => $task->fresh()->progress_percentage,
            ]);
        } catch (\Exception $e) {
            return Reply::error('Error updating item: ' . $e->getMessage(), [], 500);
        }
    }

    /**
     * Get task activity log.
     */
    public function activities(Task $task): JsonResponse
    {
        $activities = $task->activities()
            ->with('user:id,name')
            ->limit(50)
            ->get();

        return Reply::success('', ['activities' => $activities]);
    }

    /**
     * Add/remove watcher.
     */
    public function toggleWatcher(Request $request, Task $task): JsonResponse
    {
        $userId = $request->user_id ?? auth()->id();
        $watchers = $task->watchers ?? [];

        if (in_array($userId, $watchers)) {
            $watchers = array_values(array_diff($watchers, [$userId]));
            $message = 'Removed from watchers';
        } else {
            $watchers[] = $userId;
            $message = 'Added to watchers';
        }

        $task->update(['watchers' => $watchers]);

        return Reply::success($message, ['watchers' => $watchers]);
    }

    /**
     * Get available labels.
     */
    public function labels(Request $request): JsonResponse
    {
        $labels = TaskLabel::forCompany($request->company_id)->get();

        return Reply::success('', ['labels' => $labels]);
    }

    /**
     * Add label to task.
     */
    public function addLabel(Request $request, Task $task): JsonResponse
    {
        $labelId = $request->validate(['label_id' => 'required|exists:task_labels,id'])['label_id'];

        $task->labels()->syncWithoutDetaching([$labelId]);
        $label = TaskLabel::find($labelId);

        $task->logActivity('label_added', null, null, $label->name);

        return Reply::success('Label added', ['labels' => $task->labels]);
    }

    /**
     * Remove label from task.
     */
    public function removeLabel(Task $task, TaskLabel $label): JsonResponse
    {
        $task->labels()->detach($label->id);

        $task->logActivity('label_removed', null, $label->name, null);

        return Reply::success('Label removed', ['labels' => $task->labels]);
    }

    // ============================================
    // STEP DELEGATION METHODS
    // ============================================

    /**
     * Delegate a step to another employee by creating a subtask.
     */
    public function delegateStep(Request $request, Task $task, TaskStep $step): JsonResponse
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'due_date' => 'nullable|date',
            'priority' => 'nullable|in:low,medium,high',
            'description' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $employee = Employee::findOrFail($validated['employee_id']);

            // Create a subtask from the step
            $subtaskData = [
                'code' => $this->codeGenerator->generate('tasks'),
                'title' => $step->title,
                'description' => $validated['description'] ?? $step->description ?? "Delegated from: {$task->title}",
                'priority' => $validated['priority'] ?? $task->priority,
                'status' => 'pending',
                'due_date' => $validated['due_date'] ?? $task->due_date,
                'employee_id' => $employee->id,
                'department_id' => $employee->department_id,
                'company_id' => $employee->company_id,
                'project_id' => $task->project_id,
                'parent_id' => $task->id,
                'assigned_by' => auth()->id(),
            ];

            $subtask = Task::create($subtaskData);

            // Link the step to the subtask
            $step->update([
                'delegated_task_id' => $subtask->id,
                'assigned_to' => $employee->id,
            ]);

            // Log activity
            $task->logActivity(
                'step_delegated',
                'step',
                null,
                "{$step->title} → {$employee->full_name}",
                "Step delegated to {$employee->full_name}"
            );

            DB::commit();

            // Notify the employee
            $this->taskService->notifyAssignee($subtask);

            return Reply::success('Step delegated successfully', [
                'step' => $step->fresh()->load('delegatedTask', 'assignee'),
                'subtask' => $subtask,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error delegating step', ['error' => $e->getMessage()]);
            return Reply::error('Error delegating step: ' . $e->getMessage(), [], 500);
        }
    }

    /**
     * Get step details with delegation info.
     */
    public function getStep(Task $task, TaskStep $step): JsonResponse
    {
        $step->load(['delegatedTask.employee', 'assignee', 'completedBy']);

        return Reply::success('', ['step' => $step]);
    }

    /**
     * Sync step completion with delegated task.
     * This is called when a delegated subtask is completed.
     */
    public function syncStepFromSubtask(Task $subtask): void
    {
        // Find the step that has this subtask as delegated
        $step = TaskStep::where('delegated_task_id', $subtask->id)->first();

        if ($step && $subtask->status === 'completed') {
            $step->markAsCompleted($subtask->employee?->user_id);
            
            // Update parent task progress
            $step->task->updateProgress();
        }
    }

    /**
     * Get employees for delegation dropdown.
     */
    public function getEmployeesForDelegation(Request $request): JsonResponse
    {
        $employees = Employee::where('is_active', true)
            ->with(['department:id,name', 'company:id,name'])
            ->select('id', 'first_name', 'last_name', 'department_id', 'company_id', 'position')
            ->get()
            ->map(function ($employee) {
                return [
                    'id' => $employee->id,
                    'name' => $employee->full_name,
                    'position' => $employee->position,
                    'department' => $employee->department?->name,
                    'company' => $employee->company?->name,
                ];
            });

        return Reply::success('', ['employees' => $employees]);
    }
}

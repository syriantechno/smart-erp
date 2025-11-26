<?php

namespace App\Services;

use App\Models\Work\Task;
use App\Models\Work\TaskActivity;
use App\Models\Work\TaskTimeLog;
use App\Models\HR\Employee;
use App\Models\User;
use App\Services\Notifications\NotificationDispatcher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TaskService
{
    /**
     * Create a new task with all related data.
     */
    public function createTask(array $data, ?array $steps = null, ?array $checklists = null): Task
    {
        return DB::transaction(function () use ($data, $steps, $checklists) {
            // Create the task
            $task = Task::create($data);

            // Create steps if provided
            if ($steps) {
                foreach ($steps as $step) {
                    $task->steps()->create($step);
                }
            }

            // Create checklists if provided
            if ($checklists) {
                foreach ($checklists as $checklist) {
                    $taskChecklist = $task->checklists()->create([
                        'title' => $checklist['title'],
                        'sort_order' => $checklist['sort_order'] ?? 0,
                    ]);

                    if (!empty($checklist['items'])) {
                        foreach ($checklist['items'] as $item) {
                            $taskChecklist->items()->create($item);
                        }
                    }
                }
            }

            // Log activity
            $task->logActivity(TaskActivity::ACTION_CREATED, null, null, null, 'Task created');

            // Notify assigned employee
            $this->notifyAssignee($task);

            return $task;
        });
    }

    /**
     * Update task and log changes.
     */
    public function updateTask(Task $task, array $data): Task
    {
        return DB::transaction(function () use ($task, $data) {
            $oldValues = $task->getAttributes();

            // Check for status change
            $statusChanged = isset($data['status']) && $task->status !== $data['status'];
            $oldStatus = $task->status;

            // Check for assignee change
            $assigneeChanged = isset($data['employee_id']) && $task->employee_id !== $data['employee_id'];
            $oldAssignee = $task->employee_id;

            // Update the task
            $task->update($data);

            // Log status change
            if ($statusChanged) {
                $task->logActivity(
                    TaskActivity::ACTION_STATUS_CHANGED,
                    'status',
                    $oldStatus,
                    $data['status']
                );

                // Auto-set timestamps
                if ($data['status'] === 'in_progress' && !$task->started_at) {
                    $task->update(['started_at' => now()]);
                } elseif ($data['status'] === 'completed' && !$task->completed_at) {
                    $task->update(['completed_at' => now(), 'progress_percentage' => 100]);
                }

                // Notify watchers
                $this->notifyStatusChange($task, $oldStatus, $data['status']);
            }

            // Log assignee change
            if ($assigneeChanged) {
                $task->logActivity(
                    TaskActivity::ACTION_ASSIGNED,
                    'employee_id',
                    $oldAssignee,
                    $data['employee_id']
                );

                // Notify new assignee
                $this->notifyAssignee($task);
            }

            // Log other changes
            $fieldsToTrack = ['title', 'description', 'priority', 'due_date', 'estimated_hours'];
            foreach ($fieldsToTrack as $field) {
                if (isset($data[$field]) && $oldValues[$field] != $data[$field]) {
                    $task->logActivity(
                        TaskActivity::ACTION_UPDATED,
                        $field,
                        $oldValues[$field],
                        $data[$field]
                    );
                }
            }

            return $task->fresh();
        });
    }

    /**
     * Assign task to employee.
     */
    public function assignTask(Task $task, int $employeeId): Task
    {
        $employee = Employee::findOrFail($employeeId);
        
        $oldAssignee = $task->employee_id;
        
        $task->update([
            'employee_id' => $employeeId,
            'department_id' => $employee->department_id,
            'company_id' => $employee->company_id,
        ]);

        $task->logActivity(
            TaskActivity::ACTION_ASSIGNED,
            'employee_id',
            $oldAssignee,
            $employeeId,
            "Assigned to {$employee->full_name}"
        );

        $this->notifyAssignee($task);

        return $task;
    }

    /**
     * Start time tracking for a task.
     */
    public function startTimer(Task $task, ?string $description = null): TaskTimeLog
    {
        // Stop any running timers for this user
        TaskTimeLog::where('user_id', auth()->id())
            ->running()
            ->each(fn($log) => $log->stop());

        // Start new timer
        $timeLog = TaskTimeLog::startTimer($task->id, $description);

        // Update task status if pending
        if ($task->status === 'pending') {
            $task->start();
        }

        return $timeLog;
    }

    /**
     * Stop time tracking.
     */
    public function stopTimer(TaskTimeLog $timeLog): TaskTimeLog
    {
        $timeLog->stop();

        // Update task actual hours
        $task = $timeLog->task;
        $totalHours = $task->timeLogs()->sum('hours');
        $task->update(['actual_hours' => $totalHours]);

        $task->logActivity(
            TaskActivity::ACTION_TIME_LOGGED,
            'actual_hours',
            null,
            $timeLog->hours,
            "Logged {$timeLog->formatted_duration}"
        );

        return $timeLog;
    }

    /**
     * Create a subtask.
     */
    public function createSubtask(Task $parentTask, array $data): Task
    {
        $data['parent_id'] = $parentTask->id;
        $data['project_id'] = $parentTask->project_id;
        $data['company_id'] = $parentTask->company_id;
        $data['department_id'] = $parentTask->department_id;

        $subtask = Task::create($data);

        $parentTask->logActivity(
            TaskActivity::ACTION_SUBTASK_ADDED,
            null,
            null,
            $subtask->title
        );

        // Update parent progress
        $parentTask->updateProgress();

        return $subtask;
    }

    /**
     * Complete a subtask and update parent progress.
     */
    public function completeSubtask(Task $subtask): Task
    {
        $subtask->complete();

        if ($subtask->parent) {
            $subtask->parent->logActivity(
                TaskActivity::ACTION_SUBTASK_COMPLETED,
                null,
                null,
                $subtask->title
            );

            $subtask->parent->updateProgress();
        }

        return $subtask;
    }

    /**
     * Get task statistics for an employee.
     */
    public function getEmployeeTaskStats(int $employeeId): array
    {
        $tasks = Task::where('employee_id', $employeeId);

        return [
            'total' => $tasks->count(),
            'completed' => (clone $tasks)->where('status', 'completed')->count(),
            'in_progress' => (clone $tasks)->where('status', 'in_progress')->count(),
            'pending' => (clone $tasks)->where('status', 'pending')->count(),
            'overdue' => (clone $tasks)->overdue()->count(),
            'due_today' => (clone $tasks)->dueToday()->count(),
            'due_this_week' => (clone $tasks)->dueThisWeek()->count(),
            'high_priority' => (clone $tasks)->highPriority()->whereNotIn('status', ['completed', 'cancelled'])->count(),
            'total_hours_logged' => (clone $tasks)->with('timeLogs')->get()->sum('total_logged_hours'),
            'completion_rate' => $tasks->count() > 0 
                ? round(((clone $tasks)->where('status', 'completed')->count() / $tasks->count()) * 100, 1)
                : 0,
        ];
    }

    /**
     * Get task statistics for a project.
     */
    public function getProjectTaskStats(int $projectId): array
    {
        $tasks = Task::where('project_id', $projectId);

        return [
            'total' => $tasks->count(),
            'completed' => (clone $tasks)->where('status', 'completed')->count(),
            'in_progress' => (clone $tasks)->where('status', 'in_progress')->count(),
            'pending' => (clone $tasks)->where('status', 'pending')->count(),
            'cancelled' => (clone $tasks)->where('status', 'cancelled')->count(),
            'overdue' => (clone $tasks)->overdue()->count(),
            'by_priority' => [
                'high' => (clone $tasks)->where('priority', 'high')->count(),
                'medium' => (clone $tasks)->where('priority', 'medium')->count(),
                'low' => (clone $tasks)->where('priority', 'low')->count(),
            ],
            'by_type' => [
                'task' => (clone $tasks)->where('task_type', 'task')->count(),
                'bug' => (clone $tasks)->where('task_type', 'bug')->count(),
                'feature' => (clone $tasks)->where('task_type', 'feature')->count(),
                'improvement' => (clone $tasks)->where('task_type', 'improvement')->count(),
            ],
            'total_estimated_hours' => $tasks->sum('estimated_hours'),
            'total_actual_hours' => $tasks->sum('actual_hours'),
            'progress' => $tasks->count() > 0
                ? round(((clone $tasks)->where('status', 'completed')->count() / $tasks->count()) * 100, 1)
                : 0,
        ];
    }

    /**
     * Notify assignee about new task.
     */
    public function notifyAssignee(Task $task): void
    {
        if (!$task->employee_id) return;

        $employee = $task->employee;
        if (!$employee || !$employee->user_id) return;

        $assignedByName = auth()->user()?->name ?? 'النظام';

        try {
            NotificationDispatcher::toUser(
                $employee->user_id,
                'task.assigned',
                'مهمة جديدة مسندة إليك',
                "{$assignedByName} أسند إليك مهمة: {$task->title}",
                route('tasks.show', $task->id),
                'clipboard-list',
                [
                    'type' => 'task_assigned',
                    'task_id' => $task->id,
                    'task_code' => $task->code,
                    'actor_id' => auth()->id(),
                ]
            );
        } catch (\Exception $e) {
            Log::error('Failed to send task assignment notification', [
                'task_id' => $task->id,
                'employee_id' => $employee->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Notify task creator about status change.
     */
    protected function notifyStatusChange(Task $task, string $oldStatus, string $newStatus): void
    {
        $changedByName = auth()->user()?->name ?? 'النظام';
        
        // Get status labels in Arabic
        $statusLabels = [
            'pending' => 'قيد الانتظار',
            'in_progress' => 'قيد التنفيذ',
            'completed' => 'مكتملة',
            'cancelled' => 'ملغية',
        ];
        
        $newStatusLabel = $statusLabels[$newStatus] ?? $newStatus;
        
        // Determine notification type and message based on status
        $eventKey = 'task.updated';
        $title = 'تحديث حالة المهمة';
        $icon = 'refresh-cw';
        
        if ($newStatus === 'in_progress') {
            $eventKey = 'task.started';
            $title = 'بدء العمل على المهمة';
            $icon = 'play-circle';
        } elseif ($newStatus === 'completed') {
            $eventKey = 'task.completed';
            $title = 'اكتمال المهمة';
            $icon = 'check-circle';
        }
        
        $message = "{$changedByName} قام بتغيير حالة المهمة '{$task->title}' إلى: {$newStatusLabel}";
        
        // Notify task creator (assigned_by)
        if ($task->assigned_by && $task->assigned_by !== auth()->id()) {
            try {
                NotificationDispatcher::toUser(
                    $task->assigned_by,
                    $eventKey,
                    $title,
                    $message,
                    route('tasks.show', $task->id),
                    $icon,
                    [
                        'type' => 'task_status_changed',
                        'task_id' => $task->id,
                        'task_code' => $task->code,
                        'old_status' => $oldStatus,
                        'new_status' => $newStatus,
                        'actor_id' => auth()->id(),
                    ]
                );
            } catch (\Exception $e) {
                Log::error('Failed to send task status notification to creator', [
                    'task_id' => $task->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }
        
        // Notify assigned employee if different from current user and creator
        if ($task->employee?->user_id && 
            $task->employee->user_id !== auth()->id() && 
            $task->employee->user_id !== $task->assigned_by) {
            try {
                NotificationDispatcher::toUser(
                    $task->employee->user_id,
                    $eventKey,
                    $title,
                    $message,
                    route('tasks.show', $task->id),
                    $icon,
                    [
                        'type' => 'task_status_changed',
                        'task_id' => $task->id,
                        'task_code' => $task->code,
                        'old_status' => $oldStatus,
                        'new_status' => $newStatus,
                        'actor_id' => auth()->id(),
                    ]
                );
            } catch (\Exception $e) {
                Log::error('Failed to send task status notification to assignee', [
                    'task_id' => $task->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    /**
     * Notify about task comment.
     */
    public function notifyTaskComment(Task $task, string $comment): void
    {
        $commenterName = auth()->user()?->name ?? 'مستخدم';
        $recipientIds = [];
        
        // Notify task creator
        if ($task->assigned_by && $task->assigned_by !== auth()->id()) {
            $recipientIds[] = $task->assigned_by;
        }
        
        // Notify assigned employee
        if ($task->employee?->user_id && 
            $task->employee->user_id !== auth()->id() &&
            !in_array($task->employee->user_id, $recipientIds)) {
            $recipientIds[] = $task->employee->user_id;
        }
        
        if (empty($recipientIds)) return;
        
        try {
            NotificationDispatcher::toUsers(
                $recipientIds,
                'task.commented',
                'تعليق جديد على المهمة',
                "{$commenterName} أضاف تعليقاً على المهمة: {$task->title}",
                route('tasks.show', $task->id),
                'message-circle',
                [
                    'type' => 'task_commented',
                    'task_id' => $task->id,
                    'task_code' => $task->code,
                    'comment_preview' => mb_substr($comment, 0, 100),
                    'actor_id' => auth()->id(),
                ]
            );
        } catch (\Exception $e) {
            Log::error('Failed to send task comment notification', [
                'task_id' => $task->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Notify about task like.
     */
    public function notifyTaskLike(Task $task): void
    {
        $likerName = auth()->user()?->name ?? 'مستخدم';
        
        // Notify assigned employee only
        if (!$task->employee?->user_id || $task->employee->user_id === auth()->id()) {
            return;
        }
        
        try {
            NotificationDispatcher::toUser(
                $task->employee->user_id,
                'task.liked',
                'إعجاب بمهمتك',
                "{$likerName} أعجب بمهمتك: {$task->title}",
                route('tasks.show', $task->id),
                'heart',
                [
                    'type' => 'task_liked',
                    'task_id' => $task->id,
                    'task_code' => $task->code,
                    'actor_id' => auth()->id(),
                ]
            );
        } catch (\Exception $e) {
            Log::error('Failed to send task like notification', [
                'task_id' => $task->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Notify about task update (general changes).
     */
    public function notifyTaskUpdate(Task $task, array $changedFields): void
    {
        $updaterName = auth()->user()?->name ?? 'مستخدم';
        $recipientIds = [];
        
        // Notify assigned employee
        if ($task->employee?->user_id && $task->employee->user_id !== auth()->id()) {
            $recipientIds[] = $task->employee->user_id;
        }
        
        if (empty($recipientIds)) return;
        
        $fieldLabels = [
            'title' => 'العنوان',
            'description' => 'الوصف',
            'priority' => 'الأولوية',
            'due_date' => 'تاريخ الاستحقاق',
            'estimated_hours' => 'الساعات المقدرة',
        ];
        
        $changedFieldNames = array_map(fn($f) => $fieldLabels[$f] ?? $f, $changedFields);
        $fieldsText = implode('، ', $changedFieldNames);
        
        try {
            NotificationDispatcher::toUsers(
                $recipientIds,
                'task.updated',
                'تحديث المهمة',
                "{$updaterName} قام بتحديث المهمة '{$task->title}': {$fieldsText}",
                route('tasks.show', $task->id),
                'edit',
                [
                    'type' => 'task_updated',
                    'task_id' => $task->id,
                    'task_code' => $task->code,
                    'changed_fields' => $changedFields,
                    'actor_id' => auth()->id(),
                ]
            );
        } catch (\Exception $e) {
            Log::error('Failed to send task update notification', [
                'task_id' => $task->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}

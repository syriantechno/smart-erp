<?php

namespace App\Services;

use App\Models\Work\Task;
use App\Models\Work\TaskActivity;
use App\Models\Work\TaskTimeLog;
use App\Models\HR\Employee;
use App\Models\User;
use App\Notifications\TaskAssignedNotification;
use App\Notifications\TaskStatusChangedNotification;
use App\Notifications\TaskCommentAddedNotification;
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
        if (!$employee || !$employee->user) return;

        $assignedByName = auth()->user()?->name ?? 'System';

        try {
            $employee->user->notify(new TaskAssignedNotification($task, $assignedByName));
        } catch (\Exception $e) {
            Log::error('Failed to send task assignment notification', [
                'task_id' => $task->id,
                'employee_id' => $employee->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Notify watchers about status change.
     */
    protected function notifyStatusChange(Task $task, string $oldStatus, string $newStatus): void
    {
        $changedByName = auth()->user()?->name ?? 'System';
        $usersToNotify = collect();

        // Notify assigned employee
        if ($task->employee?->user) {
            $usersToNotify->push($task->employee->user);
        }

        // Notify watchers
        if ($task->watchers) {
            $watcherUsers = User::whereIn('id', $task->watchers)->get();
            $usersToNotify = $usersToNotify->merge($watcherUsers);
        }

        // Remove current user from notifications
        $usersToNotify = $usersToNotify->unique('id')->filter(fn($user) => $user->id !== auth()->id());

        foreach ($usersToNotify as $user) {
            try {
                $user->notify(new TaskStatusChangedNotification($task, $oldStatus, $newStatus, $changedByName));
            } catch (\Exception $e) {
                Log::error('Failed to send task status notification', [
                    'task_id' => $task->id,
                    'user_id' => $user->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }
}

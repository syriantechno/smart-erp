<?php

namespace App\Observers;

use App\Models\Work\Task;
use App\Models\Work\TaskStep;
use App\Models\Work\TaskActivity;

class TaskObserver
{
    /**
     * Handle the Task "updated" event.
     * Sync delegated step when subtask is completed.
     */
    public function updated(Task $task): void
    {
        // Check if status changed to completed
        if ($task->isDirty('status') && $task->status === 'completed') {
            $this->syncDelegatedStep($task);
        }
    }

    /**
     * Sync the parent task's step when a delegated subtask is completed.
     */
    protected function syncDelegatedStep(Task $task): void
    {
        // Find the step that has this task as delegated
        $step = TaskStep::where('delegated_task_id', $task->id)->first();

        if ($step && !$step->is_completed) {
            // Mark the step as completed
            $step->update([
                'is_completed' => true,
                'completed_at' => now(),
                'completed_by' => $task->employee?->user_id ?? auth()->id(),
            ]);

            // Update parent task progress
            $parentTask = $step->task;
            if ($parentTask) {
                $parentTask->updateProgress();
                
                // Log activity on parent task
                $parentTask->logActivity(
                    'step_completed_via_delegation',
                    'step',
                    null,
                    $step->title,
                    "Step '{$step->title}' completed by {$task->employee?->full_name} via delegated task"
                );
            }
        }
    }

    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task): void
    {
        // Log creation activity
        $task->activities()->create([
            'user_id' => auth()->id(),
            'action' => TaskActivity::ACTION_CREATED,
            'description' => 'Task created',
        ]);
    }
}

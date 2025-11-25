<?php

namespace App\Models\Work;

use App\Models\BaseModel;
use App\Models\User;
use App\Models\HR\Employee;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskStep extends BaseModel
{
    protected $fillable = [
        'task_id',
        'title',
        'description',
        'step_order',
        'is_completed',
        'completed_at',
        'completed_by',
        'delegated_task_id',
        'assigned_to',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
        'step_order' => 'integer',
    ];

    /**
     * Get the task that owns this step.
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get the user who completed this step.
     */
    public function completedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'completed_by');
    }

    /**
     * Get the delegated subtask (when step is assigned to another employee).
     */
    public function delegatedTask(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'delegated_task_id');
    }

    /**
     * Get the employee assigned to this step.
     */
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'assigned_to');
    }

    /**
     * Check if this step is delegated to another employee.
     */
    public function isDelegated(): bool
    {
        return !is_null($this->delegated_task_id);
    }

    /**
     * Check if this step has an assignee.
     */
    public function hasAssignee(): bool
    {
        return !is_null($this->assigned_to);
    }

    /**
     * Scope to get only completed steps.
     */
    public function scopeCompleted($query)
    {
        return $query->where('is_completed', true);
    }

    /**
     * Scope to get only pending steps.
     */
    public function scopePending($query)
    {
        return $query->where('is_completed', false);
    }

    /**
     * Scope to order by step order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('step_order');
    }

    /**
     * Mark this step as completed.
     */
    public function markAsCompleted($userId = null): bool
    {
        $this->update([
            'is_completed' => true,
            'completed_at' => now(),
            'completed_by' => $userId ?: auth()->id(),
        ]);

        return true;
    }

    /**
     * Mark this step as pending.
     */
    public function markAsPending(): bool
    {
        $this->update([
            'is_completed' => false,
            'completed_at' => null,
            'completed_by' => null,
        ]);

        return true;
    }
}

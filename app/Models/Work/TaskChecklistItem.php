<?php

namespace App\Models\Work;

use App\Models\BaseModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskChecklistItem extends BaseModel
{
    protected $fillable = [
        'checklist_id',
        'title',
        'is_completed',
        'completed_by',
        'completed_at',
        'assigned_to',
        'due_date',
        'sort_order',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
        'due_date' => 'date',
        'sort_order' => 'integer',
    ];

    /**
     * Get the checklist that owns this item.
     */
    public function checklist(): BelongsTo
    {
        return $this->belongsTo(TaskChecklist::class, 'checklist_id');
    }

    /**
     * Get the user who completed this item.
     */
    public function completedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'completed_by');
    }

    /**
     * Get the user assigned to this item.
     */
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Mark this item as completed.
     */
    public function markAsCompleted(?int $userId = null): void
    {
        $this->update([
            'is_completed' => true,
            'completed_at' => now(),
            'completed_by' => $userId ?? auth()->id(),
        ]);

        // Update parent task progress
        $this->checklist->task->updateProgress();
    }

    /**
     * Mark this item as incomplete.
     */
    public function markAsIncomplete(): void
    {
        $this->update([
            'is_completed' => false,
            'completed_at' => null,
            'completed_by' => null,
        ]);

        // Update parent task progress
        $this->checklist->task->updateProgress();
    }

    /**
     * Toggle completion status.
     */
    public function toggle(): void
    {
        if ($this->is_completed) {
            $this->markAsIncomplete();
        } else {
            $this->markAsCompleted();
        }
    }

    /**
     * Check if item is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->due_date && $this->due_date->isPast() && !$this->is_completed;
    }
}

<?php

namespace App\Models\Work;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaskChecklist extends BaseModel
{
    protected $fillable = [
        'task_id',
        'title',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    /**
     * Get the task that owns this checklist.
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get the items in this checklist.
     */
    public function items(): HasMany
    {
        return $this->hasMany(TaskChecklistItem::class, 'checklist_id')->orderBy('sort_order');
    }

    /**
     * Get completed items count.
     */
    public function getCompletedCountAttribute(): int
    {
        return $this->items()->where('is_completed', true)->count();
    }

    /**
     * Get total items count.
     */
    public function getTotalCountAttribute(): int
    {
        return $this->items()->count();
    }

    /**
     * Get progress percentage.
     */
    public function getProgressAttribute(): int
    {
        $total = $this->total_count;
        if ($total === 0) return 0;
        
        return (int) round(($this->completed_count / $total) * 100);
    }

    /**
     * Check if all items are completed.
     */
    public function isComplete(): bool
    {
        return $this->total_count > 0 && $this->completed_count === $this->total_count;
    }
}

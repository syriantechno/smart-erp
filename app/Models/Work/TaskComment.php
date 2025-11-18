<?php

namespace App\Models\Work;

use App\Models\BaseModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskComment extends BaseModel
{
    protected $fillable = [
        'task_id',
        'user_id',
        'comment',
        'type',
        'step_id',
        'is_internal',
    ];

    protected $casts = [
        'is_internal' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the task that owns this comment.
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get the user who created this comment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the step this comment belongs to (if any).
     */
    public function step(): BelongsTo
    {
        return $this->belongsTo(TaskStep::class, 'step_id');
    }

    /**
     * Scope to get only task comments (not step comments).
     */
    public function scopeTaskComments($query)
    {
        return $query->where('type', 'task');
    }

    /**
     * Scope to get only step comments.
     */
    public function scopeStepComments($query)
    {
        return $query->where('type', 'step');
    }

    /**
     * Scope to get only internal comments.
     */
    public function scopeInternal($query)
    {
        return $query->where('is_internal', true);
    }

    /**
     * Scope to get only public comments.
     */
    public function scopePublic($query)
    {
        return $query->where('is_internal', false);
    }

    /**
     * Get formatted time ago.
     */
    public function getTimeAgoAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }
}

<?php

namespace App\Models\Work;

use App\Models\BaseModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    protected $appends = ['likes_count', 'dislikes_count', 'user_reaction'];

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

    /**
     * Get reactions for this comment.
     */
    public function reactions(): HasMany
    {
        return $this->hasMany(TaskCommentReaction::class, 'comment_id');
    }

    /**
     * Get likes count.
     */
    public function getLikesCountAttribute(): int
    {
        return $this->reactions()->where('type', 'like')->count();
    }

    /**
     * Get dislikes count.
     */
    public function getDislikesCountAttribute(): int
    {
        return $this->reactions()->where('type', 'dislike')->count();
    }

    /**
     * Get current user's reaction.
     */
    public function getUserReactionAttribute(): ?string
    {
        if (!auth()->check()) return null;
        
        $reaction = $this->reactions()->where('user_id', auth()->id())->first();
        return $reaction?->type;
    }

    /**
     * Toggle reaction (like/dislike).
     */
    public function toggleReaction(string $type): array
    {
        $userId = auth()->id();
        $existing = $this->reactions()->where('user_id', $userId)->first();

        if ($existing) {
            if ($existing->type === $type) {
                // Remove reaction if same type
                $existing->delete();
                return ['action' => 'removed', 'type' => null];
            } else {
                // Change reaction type
                $existing->update(['type' => $type]);
                return ['action' => 'changed', 'type' => $type];
            }
        } else {
            // Add new reaction
            $this->reactions()->create([
                'user_id' => $userId,
                'type' => $type,
            ]);
            return ['action' => 'added', 'type' => $type];
        }
    }
}

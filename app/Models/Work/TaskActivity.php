<?php

namespace App\Models\Work;

use App\Models\BaseModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskActivity extends BaseModel
{
    protected $fillable = [
        'task_id',
        'user_id',
        'action',
        'field',
        'old_value',
        'new_value',
        'description',
    ];

    /**
     * Activity action types.
     */
    const ACTION_CREATED = 'created';
    const ACTION_UPDATED = 'updated';
    const ACTION_STATUS_CHANGED = 'status_changed';
    const ACTION_ASSIGNED = 'assigned';
    const ACTION_UNASSIGNED = 'unassigned';
    const ACTION_COMMENTED = 'commented';
    const ACTION_ATTACHMENT_ADDED = 'attachment_added';
    const ACTION_ATTACHMENT_REMOVED = 'attachment_removed';
    const ACTION_SUBTASK_ADDED = 'subtask_added';
    const ACTION_SUBTASK_COMPLETED = 'subtask_completed';
    const ACTION_TIME_LOGGED = 'time_logged';
    const ACTION_DUE_DATE_CHANGED = 'due_date_changed';
    const ACTION_PRIORITY_CHANGED = 'priority_changed';
    const ACTION_LABEL_ADDED = 'label_added';
    const ACTION_LABEL_REMOVED = 'label_removed';
    const ACTION_CHECKLIST_ADDED = 'checklist_added';
    const ACTION_CHECKLIST_ITEM_COMPLETED = 'checklist_item_completed';

    /**
     * Get the task that owns this activity.
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get the user who performed this activity.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get human-readable action description.
     */
    public function getActionDescriptionAttribute(): string
    {
        $userName = $this->user?->name ?? 'Someone';

        return match($this->action) {
            self::ACTION_CREATED => "{$userName} created this task",
            self::ACTION_UPDATED => "{$userName} updated {$this->field}",
            self::ACTION_STATUS_CHANGED => "{$userName} changed status from {$this->old_value} to {$this->new_value}",
            self::ACTION_ASSIGNED => "{$userName} assigned this task to {$this->new_value}",
            self::ACTION_UNASSIGNED => "{$userName} unassigned {$this->old_value}",
            self::ACTION_COMMENTED => "{$userName} added a comment",
            self::ACTION_ATTACHMENT_ADDED => "{$userName} added an attachment: {$this->new_value}",
            self::ACTION_ATTACHMENT_REMOVED => "{$userName} removed an attachment: {$this->old_value}",
            self::ACTION_SUBTASK_ADDED => "{$userName} added a subtask: {$this->new_value}",
            self::ACTION_SUBTASK_COMPLETED => "{$userName} completed subtask: {$this->new_value}",
            self::ACTION_TIME_LOGGED => "{$userName} logged {$this->new_value} hours",
            self::ACTION_DUE_DATE_CHANGED => "{$userName} changed due date to {$this->new_value}",
            self::ACTION_PRIORITY_CHANGED => "{$userName} changed priority from {$this->old_value} to {$this->new_value}",
            self::ACTION_LABEL_ADDED => "{$userName} added label: {$this->new_value}",
            self::ACTION_LABEL_REMOVED => "{$userName} removed label: {$this->old_value}",
            self::ACTION_CHECKLIST_ADDED => "{$userName} added checklist: {$this->new_value}",
            self::ACTION_CHECKLIST_ITEM_COMPLETED => "{$userName} completed: {$this->new_value}",
            default => $this->description ?? "{$userName} performed an action",
        };
    }

    /**
     * Get icon for this activity.
     */
    public function getIconAttribute(): string
    {
        return match($this->action) {
            self::ACTION_CREATED => 'plus-circle',
            self::ACTION_UPDATED => 'edit',
            self::ACTION_STATUS_CHANGED => 'refresh-cw',
            self::ACTION_ASSIGNED, self::ACTION_UNASSIGNED => 'user',
            self::ACTION_COMMENTED => 'message-circle',
            self::ACTION_ATTACHMENT_ADDED, self::ACTION_ATTACHMENT_REMOVED => 'paperclip',
            self::ACTION_SUBTASK_ADDED, self::ACTION_SUBTASK_COMPLETED => 'git-branch',
            self::ACTION_TIME_LOGGED => 'clock',
            self::ACTION_DUE_DATE_CHANGED => 'calendar',
            self::ACTION_PRIORITY_CHANGED => 'flag',
            self::ACTION_LABEL_ADDED, self::ACTION_LABEL_REMOVED => 'tag',
            self::ACTION_CHECKLIST_ADDED, self::ACTION_CHECKLIST_ITEM_COMPLETED => 'check-square',
            default => 'activity',
        };
    }

    /**
     * Get color for this activity.
     */
    public function getColorAttribute(): string
    {
        return match($this->action) {
            self::ACTION_CREATED => 'text-green-500',
            self::ACTION_STATUS_CHANGED => 'text-blue-500',
            self::ACTION_ASSIGNED => 'text-purple-500',
            self::ACTION_COMMENTED => 'text-yellow-500',
            self::ACTION_ATTACHMENT_ADDED => 'text-cyan-500',
            self::ACTION_SUBTASK_COMPLETED, self::ACTION_CHECKLIST_ITEM_COMPLETED => 'text-emerald-500',
            self::ACTION_TIME_LOGGED => 'text-orange-500',
            self::ACTION_DUE_DATE_CHANGED => 'text-red-500',
            default => 'text-slate-500',
        };
    }

    /**
     * Scope to get recent activities.
     */
    public function scopeRecent($query, int $limit = 10)
    {
        return $query->latest()->limit($limit);
    }
}

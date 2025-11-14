<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $fillable = [
        'type',
        'title',
        'message',
        'data',
        'user_id',
        'created_by',
        'is_read',
        'read_at',
        'action_url',
        'icon',
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    /**
     * Get the user that owns the notification.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user who created the notification.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead(): bool
    {
        return $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    /**
     * Mark notification as unread.
     */
    public function markAsUnread(): bool
    {
        return $this->update([
            'is_read' => false,
            'read_at' => null,
        ]);
    }

    /**
     * Scope for unread notifications.
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope for read notifications.
     */
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    /**
     * Get notification type color class.
     */
    public function getTypeColorAttribute(): string
    {
        return match ($this->type) {
            'success' => 'text-green-600 bg-green-50',
            'error' => 'text-red-600 bg-red-50',
            'warning' => 'text-yellow-600 bg-yellow-50',
            default => 'text-blue-600 bg-blue-50',
        };
    }

    /**
     * Get notification icon class.
     */
    public function getIconClassAttribute(): string
    {
        return $this->icon ?? match ($this->type) {
            'success' => 'heroicon-o-check-circle',
            'error' => 'heroicon-o-exclamation-circle',
            'warning' => 'heroicon-o-exclamation-triangle',
            default => 'heroicon-o-information-circle',
        };
    }

    /**
     * Get formatted created time.
     */
    public function getTimeAgoAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }
}

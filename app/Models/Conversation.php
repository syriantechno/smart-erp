<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'created_by',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'conversation_participants')
                    ->withPivot('is_admin', 'joined_at', 'last_read_at')
                    ->withTimestamps();
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)->orderBy('created_at', 'asc');
    }

    public function latestMessage(): HasOne
    {
        return $this->hasOne(Message::class)->latest();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeDirect($query)
    {
        return $query->where('type', 'direct');
    }

    public function scopeGroup($query)
    {
        return $query->where('type', 'group');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->whereHas('participants', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        });
    }

    // Methods
    public function addParticipant($userId, $isAdmin = false)
    {
        if (!$this->participants()->where('user_id', $userId)->exists()) {
            $this->participants()->attach($userId, [
                'is_admin' => $isAdmin,
                'joined_at' => now(),
            ]);
        }
    }

    public function removeParticipant($userId)
    {
        $this->participants()->detach($userId);
    }

    public function getDisplayNameAttribute()
    {
        if ($this->type === 'group' && $this->title) {
            return $this->title;
        }

        // For direct messages, return the other participant's name
        $currentUserId = auth()->id();
        $otherParticipant = $this->participants()->where('user_id', '!=', $currentUserId)->first();

        return $otherParticipant ? $otherParticipant->name : 'Unknown';
    }

    public function getUnreadCountAttribute()
    {
        $currentUserId = auth()->id();
        $lastRead = $this->participants()->where('user_id', $currentUserId)->first()?->pivot?->last_read_at;

        if (!$lastRead) {
            return $this->messages()->count();
        }

        return $this->messages()->where('created_at', '>', $lastRead)->count();
    }

    public function markAsRead($userId)
    {
        $this->participants()->updateExistingPivot($userId, [
            'last_read_at' => now(),
        ]);

        // Mark messages as read
        $this->messages()->where('sender_id', '!=', $userId)->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }
}

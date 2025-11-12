<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'sender_id',
        'content',
        'message_type',
        'metadata',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    // Relationships
    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Accessors
    public function getFormattedTimeAttribute()
    {
        return $this->created_at->format('g:i A');
    }

    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('M d, Y');
    }

    public function getIsOwnAttribute()
    {
        return $this->sender_id === auth()->id();
    }

    public function getFileUrlAttribute()
    {
        if ($this->message_type !== 'text' && $this->metadata) {
            return asset('storage/chat-files/' . $this->metadata['path']);
        }
        return null;
    }

    public function getFileNameAttribute()
    {
        return $this->metadata['original_name'] ?? 'Unknown file';
    }

    public function getFileSizeAttribute()
    {
        return $this->metadata['size'] ?? 0;
    }

    // Methods
    public function markAsRead()
    {
        if (!$this->is_read) {
            $this->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ElectronicMail extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'subject',
        'content',
        'type',
        'status',
        'priority',
        'sender_name',
        'sender_email',
        'sender_user_id',
        'recipient_name',
        'recipient_email',
        'recipient_user_id',
        'attachments',
        'cc',
        'bcc',
        'parent_id',
        'is_starred',
        'is_read',
        'department_id',
        'company_id',
        'sent_at',
        'read_at',
    ];

    protected $casts = [
        'attachments' => 'array',
        'cc' => 'array',
        'bcc' => 'array',
        'is_starred' => 'boolean',
        'is_read' => 'boolean',
        'sent_at' => 'datetime',
        'read_at' => 'datetime',
    ];

    // Relationships
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_user_id');
    }

    public function recipient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recipient_user_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(ElectronicMail::class, 'parent_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(ElectronicMail::class, 'parent_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', '!=', 'archived');
    }

    public function scopeInbox($query)
    {
        return $query->where('type', 'incoming')
                    ->where('recipient_user_id', auth()->id());
    }

    public function scopeSent($query)
    {
        return $query->where('type', 'outgoing')
                    ->where('sender_user_id', auth()->id());
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeStarred($query)
    {
        return $query->where('is_starred', true);
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    // Accessors & Mutators
    public function getPriorityBadgeClassAttribute()
    {
        return match($this->priority) {
            'urgent' => 'bg-red-100 text-red-700',
            'high' => 'bg-orange-100 text-orange-700',
            'normal' => 'bg-blue-100 text-blue-700',
            'low' => 'bg-gray-100 text-gray-700',
        };
    }

    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'sent' => 'bg-green-100 text-green-700',
            'received' => 'bg-blue-100 text-blue-700',
            'read' => 'bg-gray-100 text-gray-700',
            'draft' => 'bg-yellow-100 text-yellow-700',
            'archived' => 'bg-slate-100 text-slate-700',
        };
    }

    public function getTypeIconAttribute()
    {
        return $this->type === 'incoming' ? 'ArrowDown' : 'ArrowUp';
    }

    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('M d, Y H:i');
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

    public function toggleStar()
    {
        $this->update(['is_starred' => !$this->is_starred]);
    }
}

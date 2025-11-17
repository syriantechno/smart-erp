<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentShare extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'shared_with_user_id',
        'shared_with_department_id',
        'share_type',
        'permission',
        'expires_at',
        'shared_by',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    // Relationships
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

    public function sharedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'shared_with_user_id');
    }

    public function sharedDepartment(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'shared_with_department_id');
    }

    public function sharedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'shared_by');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expires_at')
              ->orWhere('expires_at', '>', now());
        });
    }

    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<=', now());
    }

    // Accessors
    public function getIsExpiredAttribute()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function getPermissionLabelAttribute()
    {
        return match($this->permission) {
            'view' => 'View Only',
            'download' => 'Download',
            'edit' => 'Edit',
        };
    }
}

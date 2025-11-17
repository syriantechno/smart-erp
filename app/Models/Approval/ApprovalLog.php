<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApprovalLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'approval_request_id',
        'action',
        'comments',
        'user_id',
        'level',
    ];

    // Relationships
    public function approvalRequest(): BelongsTo
    {
        return $this->belongsTo(ApprovalRequest::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Accessors
    public function getActionBadgeClassAttribute()
    {
        return match($this->action) {
            'submitted' => 'bg-blue-100 text-blue-700',
            'approved' => 'bg-green-100 text-green-700',
            'rejected' => 'bg-red-100 text-red-700',
            'commented' => 'bg-yellow-100 text-yellow-700',
            'forwarded' => 'bg-purple-100 text-purple-700',
        };
    }

    public function getActionLabelAttribute()
    {
        return match($this->action) {
            'submitted' => 'Submitted',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'commented' => 'Commented',
            'forwarded' => 'Forwarded',
        };
    }

    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('M d, Y H:i');
    }
}

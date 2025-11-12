<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ApprovalRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'title',
        'description',
        'type',
        'status',
        'priority',
        'request_data',
        'amount',
        'start_date',
        'end_date',
        'duration_days',
        'requester_id',
        'current_approver_id',
        'department_id',
        'company_id',
        'approval_levels',
        'current_level',
        'rejection_reason',
        'attachments',
    ];

    protected $casts = [
        'request_data' => 'array',
        'approval_levels' => 'array',
        'attachments' => 'array',
        'amount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // Relationships
    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function currentApprover(): BelongsTo
    {
        return $this->belongsTo(User::class, 'current_approver_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(ApprovalLog::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeMyRequests($query, $userId)
    {
        return $query->where('requester_id', $userId);
    }

    public function scopePendingMyApproval($query, $userId)
    {
        return $query->where('current_approver_id', $userId)
                    ->where('status', 'pending');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    // Accessors & Mutators
    public function getTypeBadgeClassAttribute()
    {
        return match($this->type) {
            'leave_request' => 'bg-blue-100 text-blue-700',
            'purchase_request' => 'bg-green-100 text-green-700',
            'expense_claim' => 'bg-yellow-100 text-yellow-700',
            'loan_request' => 'bg-purple-100 text-purple-700',
            'overtime_request' => 'bg-indigo-100 text-indigo-700',
            'training_request' => 'bg-pink-100 text-pink-700',
            'equipment_request' => 'bg-red-100 text-red-700',
            'other' => 'bg-gray-100 text-gray-700',
        };
    }

    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-700',
            'approved' => 'bg-green-100 text-green-700',
            'rejected' => 'bg-red-100 text-red-700',
            'cancelled' => 'bg-gray-100 text-gray-700',
        };
    }

    public function getPriorityBadgeClassAttribute()
    {
        return match($this->priority) {
            'urgent' => 'bg-red-100 text-red-700',
            'high' => 'bg-orange-100 text-orange-700',
            'normal' => 'bg-blue-100 text-blue-700',
            'low' => 'bg-gray-100 text-gray-700',
        };
    }

    public function getTypeLabelAttribute()
    {
        return match($this->type) {
            'leave_request' => 'Leave Request',
            'purchase_request' => 'Purchase Request',
            'expense_claim' => 'Expense Claim',
            'loan_request' => 'Loan Request',
            'overtime_request' => 'Overtime Request',
            'training_request' => 'Training Request',
            'equipment_request' => 'Equipment Request',
            'other' => 'Other Request',
        };
    }

    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('M d, Y H:i');
    }

    public function getDurationAttribute()
    {
        if ($this->start_date && $this->end_date) {
            return $this->start_date->diffInDays($this->end_date) + 1;
        }
        return $this->duration_days;
    }

    // Methods
    public function approve($userId, $comments = null)
    {
        $this->logs()->create([
            'action' => 'approved',
            'comments' => $comments,
            'user_id' => $userId,
            'level' => $this->current_level,
        ]);

        // Check if there are more approval levels
        $levels = $this->approval_levels ?? [];
        if ($this->current_level < count($levels)) {
            $this->current_level++;
            $nextApproverId = $levels[$this->current_level - 1]['approver_id'] ?? null;
            $this->current_approver_id = $nextApproverId;
        } else {
            $this->status = 'approved';
            $this->current_approver_id = null;
        }

        $this->save();
    }

    public function reject($userId, $reason, $comments = null)
    {
        $this->logs()->create([
            'action' => 'rejected',
            'comments' => $comments,
            'user_id' => $userId,
            'level' => $this->current_level,
        ]);

        $this->status = 'rejected';
        $this->rejection_reason = $reason;
        $this->current_approver_id = null;
        $this->save();
    }

    public function canBeApprovedBy($userId)
    {
        return $this->status === 'pending' &&
               $this->current_approver_id == $userId;
    }

    public function getNextApprover()
    {
        $levels = $this->approval_levels ?? [];
        if ($this->current_level < count($levels)) {
            return $levels[$this->current_level]['approver_id'] ?? null;
        }
        return null;
    }
}

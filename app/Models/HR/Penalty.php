<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penalty extends Model
{
    protected $fillable = [
        'code',
        'employee_id',
        'type', // written, financial
        'category', // late, absent, misconduct, violation, other
        'title',
        'description',
        'amount', // for financial penalties
        'penalty_date',
        'effective_from',
        'effective_to', // for written warnings validity
        'deduct_from_salary', // whether to deduct from next salary
        'deducted', // already deducted
        'deducted_in_payroll_id',
        'severity', // minor, moderate, major, severe
        'status', // pending, approved, rejected, applied
        'issued_by',
        'approved_by',
        'approved_at',
        'notes',
        'attachments',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'penalty_date' => 'date',
        'effective_from' => 'date',
        'effective_to' => 'date',
        'deduct_from_salary' => 'boolean',
        'deducted' => 'boolean',
        'approved_at' => 'datetime',
        'attachments' => 'array',
    ];

    // Relationships
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function issuedBy(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'issued_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'approved_by');
    }

    public function payroll(): BelongsTo
    {
        return $this->belongsTo(Payroll::class, 'deducted_in_payroll_id');
    }

    // Scopes
    public function scopeFinancial($query)
    {
        return $query->where('type', 'financial');
    }

    public function scopeWritten($query)
    {
        return $query->where('type', 'written');
    }

    public function scopePendingDeduction($query)
    {
        return $query->where('type', 'financial')
            ->where('deduct_from_salary', true)
            ->where('deducted', false)
            ->where('status', 'approved');
    }

    public function scopeForEmployee($query, int $employeeId)
    {
        return $query->where('employee_id', $employeeId);
    }

    // Accessors
    public function getTypeColorAttribute(): string
    {
        return $this->type === 'financial' ? 'danger' : 'warning';
    }

    public function getTypeLabelAttribute(): string
    {
        return $this->type === 'financial' ? 'Financial' : 'Written Warning';
    }

    public function getSeverityColorAttribute(): string
    {
        return match($this->severity) {
            'minor' => 'info',
            'moderate' => 'warning',
            'major' => 'danger',
            'severe' => 'dark',
            default => 'secondary',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'approved' => 'success',
            'rejected' => 'danger',
            'applied' => 'info',
            default => 'secondary',
        };
    }
}

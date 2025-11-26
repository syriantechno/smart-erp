<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Advance extends Model
{
    protected $fillable = [
        'code',
        'employee_id',
        'type', // salary_advance, loan
        'amount',
        'reason',
        'request_date',
        'approval_date',
        'disbursement_date',
        'installments', // number of monthly installments
        'installment_amount',
        'paid_installments',
        'remaining_amount',
        'start_deduction_date', // when to start deducting
        'status', // pending, approved, rejected, disbursed, completed, cancelled
        'requested_by',
        'approved_by',
        'approved_at',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'installment_amount' => 'decimal:2',
        'remaining_amount' => 'decimal:2',
        'request_date' => 'date',
        'approval_date' => 'date',
        'disbursement_date' => 'date',
        'start_deduction_date' => 'date',
        'approved_at' => 'datetime',
    ];

    // Relationships
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function requestedBy(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'requested_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'approved_by');
    }

    public function deductions(): HasMany
    {
        return $this->hasMany(AdvanceDeduction::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['approved', 'disbursed'])
            ->where('remaining_amount', '>', 0);
    }

    public function scopePendingDeduction($query)
    {
        return $query->where('status', 'disbursed')
            ->where('remaining_amount', '>', 0)
            ->where('start_deduction_date', '<=', now());
    }

    public function scopeForEmployee($query, int $employeeId)
    {
        return $query->where('employee_id', $employeeId);
    }

    // Accessors
    public function getTypeLabelAttribute(): string
    {
        return $this->type === 'salary_advance' ? 'Salary Advance' : 'Loan';
    }

    public function getTypeColorAttribute(): string
    {
        return $this->type === 'salary_advance' ? 'info' : 'primary';
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'approved' => 'info',
            'rejected' => 'danger',
            'disbursed' => 'primary',
            'completed' => 'success',
            'cancelled' => 'secondary',
            default => 'secondary',
        };
    }

    public function getProgressPercentAttribute(): float
    {
        if ($this->amount <= 0) return 0;
        return round((($this->amount - $this->remaining_amount) / $this->amount) * 100, 1);
    }

    // Methods
    public function recordDeduction(float $amount, int $payrollId): void
    {
        $this->deductions()->create([
            'payroll_id' => $payrollId,
            'amount' => $amount,
            'deduction_date' => now(),
            'installment_number' => $this->paid_installments + 1,
        ]);

        $this->increment('paid_installments');
        $this->decrement('remaining_amount', $amount);

        if ($this->remaining_amount <= 0) {
            $this->update(['status' => 'completed', 'remaining_amount' => 0]);
        }
    }
}

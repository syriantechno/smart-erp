<?php

namespace App\Models\HR;

use App\Models\Setting\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Leave extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'employee_id',
        'department_id',
        'company_id',
        'leave_type',
        'reason_category',
        'start_date',
        'end_date',
        'days_count',
        'is_paid',
        'status',
        'reason_details',
        'notes',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'approved_at' => 'datetime',
        'is_paid' => 'boolean',
    ];

    public const STATUSES = ['pending', 'approved', 'rejected'];

    public const TYPES = ['annual', 'sick', 'unpaid', 'emergency', 'maternity'];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'approved_by');
    }

    public function getEmployeeAvatarUrlAttribute(): string
    {
        return $this->employee?->profile_picture_url
            ?? asset('images/default-avatar.jpg');
    }

    public function getDurationLabelAttribute(): string
    {
        $start = $this->start_date ? Carbon::parse($this->start_date) : null;
        $end = $this->end_date ? Carbon::parse($this->end_date) : null;

        if (!$start) {
            return '-';
        }

        $end ??= $start;
        $days = max($start->diffInDays($end) + 1, 1);

        return sprintf('%s → %s (%d days)',
            $start->format('d M Y'),
            $end->format('d M Y'),
            $days
        );
    }
}

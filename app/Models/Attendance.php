<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $fillable = [
        'employee_id',
        'shift_id',
        'attendance_date',
        'status',
        'notes',
        'check_in',
        'check_out',
        'working_hours',
    ];

    protected $casts = [
        'attendance_date' => 'date',
        'check_in' => 'datetime:H:i',
        'check_out' => 'datetime:H:i',
        'working_hours' => 'decimal:2',
    ];

    // Relationships
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class);
    }

    // Accessors
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'present' => 'success',
            'absent' => 'danger',
            'vacation' => 'info',
            'travel' => 'warning',
            'half_day' => 'secondary',
            'holiday' => 'primary',
            default => 'secondary'
        };
    }

    public function getStatusIconAttribute(): string
    {
        return match($this->status) {
            'present' => 'check-circle',
            'absent' => 'x-circle',
            'vacation' => 'sun',
            'travel' => 'plane',
            'half_day' => 'clock',
            'holiday' => 'calendar',
            default => 'circle'
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'present' => 'حاضر',
            'absent' => 'غائب',
            'vacation' => 'إجازة',
            'travel' => 'سفر',
            'half_day' => 'نصف يوم',
            'holiday' => 'عطلة',
            default => 'غير محدد'
        };
    }

    // Scopes
    public function scopeForMonth($query, $year, $month)
    {
        return $query->whereYear('attendance_date', $year)
                    ->whereMonth('attendance_date', $month);
    }

    public function scopeForEmployee($query, $employeeId)
    {
        return $query->where('employee_id', $employeeId);
    }

    public function scopePresent($query)
    {
        return $query->where('status', 'present');
    }

    public function scopeAbsent($query)
    {
        return $query->where('status', 'absent');
    }

    // Methods
    public static function getMonthlyStats($employeeId, $year, $month)
    {
        $query = self::forEmployee($employeeId)->forMonth($year, $month);

        return [
            'total_days' => $query->count(),
            'present_days' => (clone $query)->where('status', 'present')->count(),
            'absent_days' => (clone $query)->where('status', 'absent')->count(),
            'vacation_days' => (clone $query)->where('status', 'vacation')->count(),
            'half_days' => (clone $query)->where('status', 'half_day')->count(),
            'travel_days' => (clone $query)->where('status', 'travel')->count(),
            'holiday_days' => (clone $query)->where('status', 'holiday')->count(),
        ];
    }
}

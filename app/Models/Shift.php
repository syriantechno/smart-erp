<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Shift extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'start_time',
        'end_time',
        'working_hours',
        'color',
        'is_active',
        'applicable_to',
        'company_id',
        'department_id',
        'employee_id',
        'work_days',
        'break_start',
        'break_end',
        'break_hours',
    ];

    protected $casts = [
        'work_days' => 'array',
        'is_active' => 'boolean',
        'working_hours' => 'decimal:2',
        'break_hours' => 'decimal:2',
    ];

    // Relationships
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForCompany($query, $companyId)
    {
        return $query->where(function ($q) use ($companyId) {
            $q->where('applicable_to', 'company')
              ->where('company_id', $companyId)
              ->orWhere(function ($subQ) use ($companyId) {
                  $subQ->where('applicable_to', 'department')
                       ->whereHas('department', function ($deptQ) use ($companyId) {
                           $deptQ->where('company_id', $companyId);
                       });
              });
        });
    }

    public function scopeForDepartment($query, $departmentId)
    {
        return $query->where(function ($q) use ($departmentId) {
            $q->where('applicable_to', 'department')
              ->where('department_id', $departmentId)
              ->orWhere('applicable_to', 'company');
        });
    }

    public function scopeForEmployee($query, $employeeId)
    {
        return $query->where(function ($q) use ($employeeId) {
            $q->where('applicable_to', 'employee')
              ->where('employee_id', $employeeId)
              ->orWhere('applicable_to', 'department')
              ->orWhere('applicable_to', 'company');
        });
    }

    // Accessors
    public function getFormattedTimeAttribute()
    {
        return Carbon::parse($this->start_time)->format('H:i') . ' - ' . Carbon::parse($this->end_time)->format('H:i');
    }

    public function getWorkDaysTextAttribute()
    {
        if (!$this->work_days) {
            return 'All Days';
        }

        $days = [
            'monday' => 'Monday',
            'tuesday' => 'Tuesday',
            'wednesday' => 'Wednesday',
            'thursday' => 'Thursday',
            'friday' => 'Friday',
            'saturday' => 'Saturday',
            'sunday' => 'Sunday',
        ];

        return collect($this->work_days)->map(function ($day) use ($days) {
            return $days[$day] ?? $day;
        })->join(', ');
    }

    // Methods
    public function isWorkingDay($dayOfWeek)
    {
        if (!$this->work_days) {
            return true; // All days if not specified
        }

        $dayMap = [
            1 => 'monday',    // Monday
            2 => 'tuesday',   // Tuesday
            3 => 'wednesday', // Wednesday
            4 => 'thursday',  // Thursday
            5 => 'friday',    // Friday
            6 => 'saturday',  // Saturday
            0 => 'sunday',    // Sunday
        ];

        return in_array($dayMap[$dayOfWeek], $this->work_days);
    }

    public function getApplicableTextAttribute()
    {
        return match($this->applicable_to) {
            'company' => 'Company',
            'department' => 'Department: ' . ($this->department?->name ?? 'Not specified'),
            'employee' => 'Employee: ' . ($this->employee?->full_name ?? 'Not specified'),
            default => 'Not specified'
        };
    }

    // Generate unique code using database prefix
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($shift) {
            if (empty($shift->code)) {
                $shift->code = static::generateUniqueCode();
            }
        });
    }

    public static function generateUniqueCode()
    {
        $prefixSetting = PrefixSetting::where('document_type', 'shifts')
            ->where('is_active', true)
            ->first();

        if (!$prefixSetting) {
            // Fallback to default if no prefix setting found
            return 'SHIFT' . str_pad(1, 4, '0', STR_PAD_LEFT);
        }

        $number = $prefixSetting->current_number;
        $code = $prefixSetting->previewCode();

        // Ensure uniqueness
        $counter = 1;
        $originalCode = $code;
        while (static::where('code', $code)->exists()) {
            $code = $prefixSetting->prefix . str_pad($number + $counter, $prefixSetting->padding, '0', STR_PAD_LEFT);
            if ($prefixSetting->include_year) {
                $year = date('Y');
                $code = "{$prefixSetting->prefix}-{$year}-" . str_pad($number + $counter, $prefixSetting->padding, '0', STR_PAD_LEFT);
            }
            $counter++;
        }

        // Update the current number if we found a unique code
        if ($code !== $originalCode) {
            $prefixSetting->current_number = $number + $counter;
            $prefixSetting->save();
        } else {
            $prefixSetting->increment('current_number');
        }

        return $code;
    }
}

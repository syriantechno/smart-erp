<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['full_name'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'employee_id',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'phone',
        'position',
        'salary',
        'hire_date',
        'birth_date',
        'gender',
        'address',
        'city',
        'country',
        'postal_code',
        'department_id',
        'company_id',
        'user_id',
        'is_active',
        'profile_picture'
    ];

    protected $casts = [
        'hire_date' => 'date',
        'birth_date' => 'date',
        'salary' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Scope a query to only include active employees.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the employee's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return trim(implode(' ', [
            $this->first_name,
            $this->middle_name,
            $this->last_name
        ]));
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Get the profile picture URL.
     */
    public function getProfilePictureUrlAttribute()
    {
        if ($this->profile_picture) {
            return asset('storage/' . $this->profile_picture);
        }

        return asset('images/default-avatar.png'); // Fallback to default avatar
    }

    /**
     * Get the employee's assigned shifts.
     */
    public function assignedShifts(): HasMany
    {
        return $this->hasMany(Shift::class, 'employee_id');
    }

    /**
     * Get the employee's applicable shifts for a specific date.
     */
    public function getApplicableShifts($date = null)
    {
        $date = $date ?: now()->toDateString();
        $dayOfWeek = \Carbon\Carbon::parse($date)->dayOfWeek;

        return Shift::active()
            ->where(function ($query) use ($dayOfWeek) {
                // Employee-specific shifts
                $query->where('applicable_to', 'employee')
                      ->where('employee_id', $this->id)
                      ->where(function ($q) use ($dayOfWeek) {
                          $q->whereNull('work_days')
                            ->orWhereRaw('JSON_CONTAINS(work_days, ?)', [json_encode([$this->getDayName($dayOfWeek)])]);
                      });
            })
            ->orWhere(function ($query) use ($dayOfWeek) {
                // Department-specific shifts
                $query->where('applicable_to', 'department')
                      ->where('department_id', $this->department_id)
                      ->where(function ($q) use ($dayOfWeek) {
                          $q->whereNull('work_days')
                            ->orWhereRaw('JSON_CONTAINS(work_days, ?)', [json_encode([$this->getDayName($dayOfWeek)])]);
                      });
            })
            ->orWhere(function ($query) use ($dayOfWeek) {
                // Company-wide shifts
                $query->where('applicable_to', 'company')
                      ->where('company_id', $this->department?->company_id)
                      ->where(function ($q) use ($dayOfWeek) {
                          $q->whereNull('work_days')
                            ->orWhereRaw('JSON_CONTAINS(work_days, ?)', [json_encode([$this->getDayName($dayOfWeek)])]);
                      });
            })
            ->orderBy('applicable_to', 'desc') // employee > department > company
            ->get();
    }

    private function getDayName($dayOfWeek)
    {
        $days = [
            0 => 'sunday',
            1 => 'monday',
            2 => 'tuesday',
            3 => 'wednesday',
            4 => 'thursday',
            5 => 'friday',
            6 => 'saturday',
        ];

        return $days[$dayOfWeek] ?? 'monday';
    }
}

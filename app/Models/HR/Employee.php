<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;

class Employee extends Model
{
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['full_name', 'age'];

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
        'translated_name',
        'position',
        'iqama_position',
        'salary',
        'hire_date',
        'birth_date',
        'gender',
        'address',
        'is_company_housing',
        'housing_room_number',
        'housing_unit_number',
        'city',
        'country',
        'postal_code',
        'department_id',
        'company_id',
        'user_id',
        'has_system_access',
        'system_password',
        'is_active',
        'profile_picture'
    ];

    protected $casts = [
        'hire_date' => 'date',
        'birth_date' => 'date',
        'salary' => 'decimal:2',
        'is_active' => 'boolean',
        'is_company_housing' => 'boolean',
        'has_system_access' => 'boolean',
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
        return $this->belongsTo(\App\Models\Setting\Company::class, 'company_id');
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

    /**
     * Get the employee's age.
     *
     * @return int|null
     */
    public function getAgeAttribute()
    {
        return $this->birth_date ? $this->birth_date->age : null;
    }

    public function getAverageRatingAttribute()
    {
        if (!$this->relationLoaded('evaluations')) {
            $this->loadMissing('evaluations');
        }

        $count = $this->evaluations->count();
        if ($count === 0) {
            return null;
        }

        return (int) round($this->evaluations->avg('overall_rating'));
    }

    public function getTotalPointsAttribute()
    {
        if (!$this->relationLoaded('rewards')) {
            $this->loadMissing('rewards');
        }

        return (int) $this->rewards->sum('points');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function evaluations(): HasMany
    {
        return $this->hasMany(\App\Models\HR\EmployeeEvaluation::class);
    }

    public function rewards(): HasMany
    {
        return $this->hasMany(\App\Models\HR\EmployeeReward::class);
    }

    /**
     * Get the employee's documents.
     */
    public function documents(): HasMany
    {
        return $this->hasMany(EmployeeDocument::class);
    }

    /**
     * Get the employee's passport documents.
     */
    public function passports()
    {
        return $this->documents()->ofType('passport')->active();
    }

    /**
     * Get the employee's visa documents.
     */
    public function visas()
    {
        return $this->documents()->ofType('visa')->active();
    }

    /**
     * Get the profile picture URL.
     */
    public function getProfilePictureUrlAttribute()
    {
        if ($this->profile_picture) {
            return asset('storage/' . $this->profile_picture);
        }

        return asset('build/assets/profile-1-0441b45e.jpg'); // Use existing profile image as fallback
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

    /**
     * Get the tasks assigned to this employee.
     */
    public function assignedTasks(): HasMany
    {
        return $this->hasMany(\App\Models\Work\Task::class, 'employee_id');
    }
}

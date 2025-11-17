<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Position extends Model
{
    protected $fillable = [
        'code',
        'title',
        'description',
        'department_id',
        'is_active',
        'job_description',
        'requirements',
        'salary_range_min',
        'salary_range_max',
        'employment_type', // full-time, part-time, contract, etc.
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'salary_range_min' => 'decimal:2',
        'salary_range_max' => 'decimal:2',
    ];

    /**
     * Get the department that owns the position.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the employees for the position.
     */
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}

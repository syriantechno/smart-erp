<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recruitment extends Model
{
    protected $fillable = [
        'code',
        'candidate_name',
        'email',
        'phone',
        'application_date',
        'position',
        'position_id',
        'department_id',
        'company_id',
        'experience',
        'education_level',
        'skills',
        'status',
        'notes',
        'interview_date',
        'interviewer',
        'expected_salary',
        'offered_salary',
        'joining_date',
        'is_active'
    ];

    protected $casts = [
        'application_date' => 'date',
        'interview_date' => 'date',
        'joining_date' => 'date',
        'expected_salary' => 'decimal:2',
        'offered_salary' => 'decimal:2',
        'is_active' => 'boolean',
        'skills' => 'array'
    ];

    /**
     * Scope a query to only include active recruitments.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to filter by status.
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Generate unique code for recruitment
     */
    public static function generateUniqueCode()
    {
        $attempts = 0;
        $maxAttempts = 100;

        do {
            if ($attempts >= $maxAttempts) {
                // Fallback to timestamp-based code
                return 'REC-' . date('Y') . '-' . time();
            }

            $code = 'REC-' . date('Y') . '-' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $attempts++;
        } while (self::where('code', $code)->exists());

        return $code;
    }

    // Relationships
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'applied' => 'gray',
            'screening' => 'blue',
            'interview' => 'yellow',
            'offered' => 'purple',
            'hired' => 'green',
            'rejected' => 'red',
            default => 'gray'
        };
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'applied' => 'Applied',
            'screening' => 'Screening',
            'interview' => 'Interview',
            'offered' => 'Offered',
            'hired' => 'Hired',
            'rejected' => 'Rejected',
            default => 'Unknown'
        };
    }

    /**
     * Get formatted expected salary
     */
    public function getExpectedSalaryFormattedAttribute()
    {
        return $this->expected_salary ? '$' . number_format($this->expected_salary, 2) : 'N/A';
    }

    /**
     * Get formatted offered salary
     */
    public function getOfferedSalaryFormattedAttribute()
    {
        return $this->offered_salary ? '$' . number_format($this->offered_salary, 2) : 'N/A';
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'company_id',
        'department_id',
        'manager_id',
        'start_date',
        'end_date',
        'actual_end_date',
        'status',
        'priority',
        'budget',
        'actual_cost',
        'progress_percentage',
        'objectives',
        'deliverables',
        'risks',
        'notes',
        'is_active'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'actual_end_date' => 'date',
        'budget' => 'decimal:2',
        'actual_cost' => 'decimal:2',
        'progress_percentage' => 'integer',
        'is_active' => 'boolean'
    ];

    /**
     * Scope a query to only include active projects.
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
     * Scope a query to filter by priority.
     */
    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    /**
     * Generate unique code for project
     */
    public static function generateUniqueCode()
    {
        $attempts = 0;
        $maxAttempts = 100;

        do {
            if ($attempts >= $maxAttempts) {
                return 'PRJ-' . date('Y') . '-' . time();
            }

            $code = 'PRJ-' . date('Y') . '-' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
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

    public function manager(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'manager_id');
    }

    // Many-to-many relationship with employees (team members)
    public function teamMembers(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'project_employees', 'project_id', 'employee_id')
                    ->withPivot('role', 'joined_at', 'left_at')
                    ->withTimestamps();
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'planning' => 'blue',
            'active' => 'green',
            'on_hold' => 'yellow',
            'completed' => 'purple',
            'cancelled' => 'red',
            default => 'gray'
        };
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'planning' => 'Planning',
            'active' => 'Active',
            'on_hold' => 'On Hold',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
            default => 'Unknown'
        };
    }

    /**
     * Get priority color
     */
    public function getPriorityColorAttribute()
    {
        return match($this->priority) {
            'low' => 'green',
            'medium' => 'yellow',
            'high' => 'orange',
            'critical' => 'red',
            default => 'gray'
        };
    }

    /**
     * Get priority label
     */
    public function getPriorityLabelAttribute()
    {
        return match($this->priority) {
            'low' => 'Low',
            'medium' => 'Medium',
            'high' => 'High',
            'critical' => 'Critical',
            default => 'Unknown'
        };
    }

    /**
     * Get formatted budget
     */
    public function getBudgetFormattedAttribute()
    {
        return $this->budget ? '$' . number_format($this->budget, 2) : 'N/A';
    }

    /**
     * Get formatted actual cost
     */
    public function getActualCostFormattedAttribute()
    {
        return $this->actual_cost ? '$' . number_format($this->actual_cost, 2) : 'N/A';
    }

    /**
     * Get project duration in days
     */
    public function getDurationAttribute()
    {
        if (!$this->start_date) return 0;

        $endDate = $this->actual_end_date ?: $this->end_date ?: now();
        return $this->start_date->diffInDays($endDate);
    }

    /**
     * Check if project is overdue
     */
    public function getIsOverdueAttribute()
    {
        if (!$this->end_date || in_array($this->status, ['completed', 'cancelled'])) {
            return false;
        }

        return now()->isAfter($this->end_date);
    }

    /**
     * Get progress status
     */
    public function getProgressStatusAttribute()
    {
        if ($this->progress_percentage >= 100) return 'completed';
        if ($this->progress_percentage >= 75) return 'good';
        if ($this->progress_percentage >= 50) return 'average';
        if ($this->progress_percentage >= 25) return 'slow';
        return 'poor';
    }
}

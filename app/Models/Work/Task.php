<?php

namespace App\Models\Work;

use App\Models\BaseModel;
use App\Models\HR\Employee;
use App\Models\HR\Department;
use App\Models\Setting\Company;
use App\Models\Work\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends BaseModel
{
    use HasFactory;

    /**
     * Task types
     */
    const TYPE_TASK = 'task';
    const TYPE_BUG = 'bug';
    const TYPE_FEATURE = 'feature';
    const TYPE_IMPROVEMENT = 'improvement';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'task_type',
        'title',
        'description',
        'priority',
        'color',
        'status',
        'progress_percentage',
        'due_date',
        'assigned_to',
        'assigned_by',
        'watchers',
        'depends_on',
        'blocks',
        'employee_id',
        'department_id',
        'company_id',
        'project_id',
        'parent_id',
        'estimated_hours',
        'actual_hours',
        'story_points',
        'sprint',
        'started_at',
        'completed_at',
        'is_recurring',
        'recurrence_pattern',
        'recurrence_end_date',
        'tags',
        'is_active'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'due_date' => 'date',
        'recurrence_end_date' => 'date',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'estimated_hours' => 'decimal:2',
        'actual_hours' => 'decimal:2',
        'is_active' => 'boolean',
        'is_recurring' => 'boolean',
        'watchers' => 'array',
        'depends_on' => 'array',
        'blocks' => 'array',
        'progress_percentage' => 'integer',
        'story_points' => 'integer',
    ];

    /**
     * Scope a query to only include active tasks.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the employee that owns the task.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Get the department that owns the task.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the company that owns the task.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the user who assigned the task.
     */
    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    /**
     * Get the user the task is assigned to.
     */
    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get the steps for this task.
     */
    public function steps(): HasMany
    {
        return $this->hasMany(TaskStep::class)->ordered();
    }

    /**
     * Get the comments for this task.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(TaskComment::class)->with('user')->latest();
    }

    /**
     * Get only task-level comments (not step comments).
     */
    public function taskComments(): HasMany
    {
        return $this->hasMany(TaskComment::class)->taskComments()->with('user')->latest();
    }

    /**
     * Get the priority badge class.
     */
    public function getPriorityBadgeClass(): string
    {
        return match($this->priority) {
            'high' => 'bg-red-100 text-red-700',
            'medium' => 'bg-yellow-100 text-yellow-700',
            'low' => 'bg-green-100 text-green-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }

    /**
     * Get the status badge class.
     */
    public function getStatusBadgeClass(): string
    {
        return match($this->status) {
            'completed' => 'bg-green-100 text-green-700',
            'in_progress' => 'bg-blue-100 text-blue-700',
            'pending' => 'bg-yellow-100 text-yellow-700',
            'cancelled' => 'bg-red-100 text-red-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }

    // ============================================
    // NEW RELATIONSHIPS FOR ENHANCED TASK SYSTEM
    // ============================================

    /**
     * Get the parent task (for subtasks).
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'parent_id');
    }

    /**
     * Get the subtasks.
     */
    public function subtasks(): HasMany
    {
        return $this->hasMany(Task::class, 'parent_id');
    }

    /**
     * Get all descendants (nested subtasks).
     */
    public function allSubtasks(): HasMany
    {
        return $this->hasMany(Task::class, 'parent_id')->with('allSubtasks');
    }

    /**
     * Get the attachments for this task.
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(TaskAttachment::class);
    }

    /**
     * Get the time logs for this task.
     */
    public function timeLogs(): HasMany
    {
        return $this->hasMany(TaskTimeLog::class);
    }

    /**
     * Get the checklists for this task.
     */
    public function checklists(): HasMany
    {
        return $this->hasMany(TaskChecklist::class)->orderBy('sort_order');
    }

    /**
     * Get the labels for this task.
     */
    public function labels(): BelongsToMany
    {
        return $this->belongsToMany(TaskLabel::class, 'task_label');
    }

    /**
     * Get the activity log for this task.
     */
    public function activities(): HasMany
    {
        return $this->hasMany(TaskActivity::class)->latest();
    }

    // ============================================
    // SCOPES
    // ============================================

    /**
     * Scope to get only root tasks (no parent).
     */
    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope to get tasks by type.
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('task_type', $type);
    }

    /**
     * Scope to get overdue tasks.
     */
    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', now())
                     ->whereNotIn('status', ['completed', 'cancelled']);
    }

    /**
     * Scope to get tasks due today.
     */
    public function scopeDueToday($query)
    {
        return $query->whereDate('due_date', today());
    }

    /**
     * Scope to get tasks due this week.
     */
    public function scopeDueThisWeek($query)
    {
        return $query->whereBetween('due_date', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    /**
     * Scope to get high priority tasks.
     */
    public function scopeHighPriority($query)
    {
        return $query->where('priority', 'high');
    }

    // ============================================
    // HELPER METHODS
    // ============================================

    /**
     * Check if task is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->due_date && 
               $this->due_date->isPast() && 
               !in_array($this->status, ['completed', 'cancelled']);
    }

    /**
     * Check if task is a subtask.
     */
    public function isSubtask(): bool
    {
        return !is_null($this->parent_id);
    }

    /**
     * Check if task has subtasks.
     */
    public function hasSubtasks(): bool
    {
        return $this->subtasks()->exists();
    }

    /**
     * Get total logged hours.
     */
    public function getTotalLoggedHoursAttribute(): float
    {
        return $this->timeLogs()->sum('hours') ?? 0;
    }

    /**
     * Get remaining hours (estimated - actual).
     */
    public function getRemainingHoursAttribute(): float
    {
        if (!$this->estimated_hours) return 0;
        return max(0, $this->estimated_hours - ($this->actual_hours ?? 0));
    }

    /**
     * Calculate progress based on subtasks or steps.
     */
    public function calculateProgress(): int
    {
        // If has subtasks, calculate from subtasks
        if ($this->hasSubtasks()) {
            $subtasks = $this->subtasks;
            if ($subtasks->isEmpty()) return 0;
            
            $completed = $subtasks->where('status', 'completed')->count();
            return (int) round(($completed / $subtasks->count()) * 100);
        }

        // If has steps, calculate from steps
        if ($this->steps()->exists()) {
            $steps = $this->steps;
            if ($steps->isEmpty()) return 0;
            
            $completed = $steps->where('is_completed', true)->count();
            return (int) round(($completed / $steps->count()) * 100);
        }

        // Otherwise, return based on status
        return match($this->status) {
            'completed' => 100,
            'in_progress' => 50,
            'pending' => 0,
            'cancelled' => 0,
            default => 0,
        };
    }

    /**
     * Update progress percentage.
     */
    public function updateProgress(): void
    {
        $this->update(['progress_percentage' => $this->calculateProgress()]);
    }

    /**
     * Start the task.
     */
    public function start(): void
    {
        $this->update([
            'status' => 'in_progress',
            'started_at' => now(),
        ]);
    }

    /**
     * Complete the task.
     */
    public function complete(): void
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
            'progress_percentage' => 100,
        ]);
    }

    /**
     * Log activity for this task.
     */
    public function logActivity(string $action, ?string $field = null, $oldValue = null, $newValue = null, ?string $description = null): void
    {
        $this->activities()->create([
            'user_id' => auth()->id(),
            'action' => $action,
            'field' => $field,
            'old_value' => is_array($oldValue) ? json_encode($oldValue) : $oldValue,
            'new_value' => is_array($newValue) ? json_encode($newValue) : $newValue,
            'description' => $description,
        ]);
    }

    /**
     * Get task type icon.
     */
    public function getTypeIconAttribute(): string
    {
        return match($this->task_type) {
            'bug' => 'bug',
            'feature' => 'sparkles',
            'improvement' => 'trending-up',
            default => 'check-square',
        };
    }

    /**
     * Get task type color.
     */
    public function getTypeColorAttribute(): string
    {
        return match($this->task_type) {
            'bug' => 'text-red-500',
            'feature' => 'text-purple-500',
            'improvement' => 'text-blue-500',
            default => 'text-slate-500',
        };
    }
}

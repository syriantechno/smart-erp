<?php

namespace App\Models\Work;

use App\Models\BaseModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class TaskTimeLog extends BaseModel
{
    protected $fillable = [
        'task_id',
        'user_id',
        'started_at',
        'ended_at',
        'hours',
        'description',
        'is_billable',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'hours' => 'decimal:2',
        'is_billable' => 'boolean',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-calculate hours when ended_at is set
        static::saving(function ($model) {
            if ($model->started_at && $model->ended_at && !$model->hours) {
                $model->hours = $model->started_at->diffInMinutes($model->ended_at) / 60;
            }
        });
    }

    /**
     * Get the task that owns this time log.
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get the user who logged this time.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope to get only billable time logs.
     */
    public function scopeBillable($query)
    {
        return $query->where('is_billable', true);
    }

    /**
     * Scope to get time logs for a specific date range.
     */
    public function scopeInDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('started_at', [$startDate, $endDate]);
    }

    /**
     * Scope to get running time logs (not ended yet).
     */
    public function scopeRunning($query)
    {
        return $query->whereNull('ended_at');
    }

    /**
     * Check if this time log is still running.
     */
    public function isRunning(): bool
    {
        return is_null($this->ended_at);
    }

    /**
     * Stop the timer.
     */
    public function stop(): void
    {
        $this->update([
            'ended_at' => now(),
            'hours' => $this->started_at->diffInMinutes(now()) / 60,
        ]);
    }

    /**
     * Get formatted duration.
     */
    public function getFormattedDurationAttribute(): string
    {
        if ($this->isRunning()) {
            $minutes = $this->started_at->diffInMinutes(now());
        } else {
            $minutes = (int) ($this->hours * 60);
        }

        $hours = floor($minutes / 60);
        $mins = $minutes % 60;

        if ($hours > 0) {
            return sprintf('%dh %dm', $hours, $mins);
        }
        return sprintf('%dm', $mins);
    }

    /**
     * Start a new time log for a task.
     */
    public static function startTimer(int $taskId, ?string $description = null): self
    {
        return self::create([
            'task_id' => $taskId,
            'user_id' => auth()->id(),
            'started_at' => now(),
            'description' => $description,
            'is_billable' => true,
        ]);
    }
}

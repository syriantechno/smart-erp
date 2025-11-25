<?php

namespace App\Models\Work;

use App\Models\BaseModel;
use App\Models\Setting\Company;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TaskLabel extends BaseModel
{
    protected $fillable = [
        'name',
        'color',
        'description',
        'company_id',
    ];

    /**
     * Get the company that owns this label.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the tasks with this label.
     */
    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'task_label');
    }

    /**
     * Get contrasting text color based on background.
     */
    public function getTextColorAttribute(): string
    {
        // Convert hex to RGB
        $hex = ltrim($this->color, '#');
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        // Calculate luminance
        $luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;

        return $luminance > 0.5 ? '#000000' : '#ffffff';
    }

    /**
     * Scope to get labels for a specific company.
     */
    public function scopeForCompany($query, ?int $companyId)
    {
        if ($companyId) {
            return $query->where('company_id', $companyId);
        }
        return $query->whereNull('company_id');
    }

    /**
     * Get default labels.
     */
    public static function getDefaults(): array
    {
        return [
            ['name' => 'Bug', 'color' => '#ef4444'],
            ['name' => 'Feature', 'color' => '#8b5cf6'],
            ['name' => 'Enhancement', 'color' => '#3b82f6'],
            ['name' => 'Documentation', 'color' => '#10b981'],
            ['name' => 'Urgent', 'color' => '#f97316'],
            ['name' => 'Help Wanted', 'color' => '#ec4899'],
            ['name' => 'Good First Issue', 'color' => '#22c55e'],
            ['name' => 'Duplicate', 'color' => '#6b7280'],
            ['name' => 'Won\'t Fix', 'color' => '#374151'],
        ];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiAutomation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'automation_type',
        'configuration',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'configuration' => 'array',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('automation_type', $type);
    }

    // Accessors
    public function getTypeLabelAttribute()
    {
        return match($this->automation_type) {
            'data_entry' => 'Data Entry',
            'report_generation' => 'Report Generation',
            'analysis' => 'Data Analysis',
            'workflow_automation' => 'Workflow Automation',
        };
    }
}

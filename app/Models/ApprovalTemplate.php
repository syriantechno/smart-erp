<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ApprovalTemplate extends Model
{
    protected $fillable = [
        'name',
        'entity_type',
        'action_type',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function steps(): HasMany
    {
        return $this->hasMany(ApprovalTemplateStep::class)->orderBy('step_order');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function buildLevels(): array
    {
        return $this->steps->values()->map(function (ApprovalTemplateStep $step, int $index) {
            return [
                'level' => $index + 1,
                'approver_id' => $step->approver_user_id,
                'role' => 'Level ' . ($index + 1),
            ];
        })->all();
    }
}

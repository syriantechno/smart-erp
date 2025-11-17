<?php

namespace App\Models\Approval;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApprovalTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'description',
        'levels',
        'is_active',
    ];

    protected $casts = [
        'levels' => 'array',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function approvalRequests(): HasMany
    {
        return $this->hasMany(ApprovalRequest::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Methods
    public function getFirstApprover()
    {
        if (empty($this->levels)) {
            return null;
        }
        return $this->levels[0]['approver_id'] ?? null;
    }

    public function getTotalLevels(): int
    {
        return count($this->levels ?? []);
    }

    public function getApproverAtLevel(int $level)
    {
        if (empty($this->levels) || $level < 1 || $level > count($this->levels)) {
            return null;
        }
        return $this->levels[$level - 1]['approver_id'] ?? null;
    }
}

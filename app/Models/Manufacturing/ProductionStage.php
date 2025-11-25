<?php

namespace App\Models\Manufacturing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductionStage extends Model
{
    protected $fillable = [
        'name',
        'description',
        'sequence',
        'estimated_hours',
        'stage_cost',
        'is_active',
    ];

    protected $casts = [
        'stage_cost' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function orderDetails(): HasMany
    {
        return $this->hasMany(ProductionOrderDetail::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sequence');
    }
}

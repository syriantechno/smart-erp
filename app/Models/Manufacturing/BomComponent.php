<?php

namespace App\Models\Manufacturing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Warehouse\Material;

class BomComponent extends Model
{
    protected $fillable = [
        'bom_template_id',
        'material_id',
        'quantity',
        'unit',
        'waste_percentage',
        'notes',
        'sequence',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
        'waste_percentage' => 'decimal:2',
    ];

    public function bomTemplate(): BelongsTo
    {
        return $this->belongsTo(BomTemplate::class);
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    // حساب الكمية الفعلية مع الهدر
    public function getActualQuantityAttribute(): float
    {
        $wasteMultiplier = 1 + ($this->waste_percentage / 100);
        return $this->quantity * $wasteMultiplier;
    }

    // حساب تكلفة المكون
    public function getCostAttribute(): float
    {
        return $this->quantity * ($this->material->price ?? 0);
    }
}

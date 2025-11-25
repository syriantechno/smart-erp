<?php

namespace App\Models\Manufacturing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Warehouse\Material;

class ManufacturingOrderMaterial extends Model
{
    protected $fillable = [
        'manufacturing_order_id',
        'material_id',
        'required_quantity',
        'consumed_quantity',
        'wasted_quantity',
        'unit_cost',
        'total_cost',
        'status',
    ];

    protected $casts = [
        'required_quantity' => 'decimal:4',
        'consumed_quantity' => 'decimal:4',
        'wasted_quantity' => 'decimal:4',
        'unit_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
    ];

    public function manufacturingOrder(): BelongsTo
    {
        return $this->belongsTo(ManufacturingOrder::class);
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    // الكمية المتبقية
    public function getRemainingQuantityAttribute(): float
    {
        return $this->required_quantity - $this->consumed_quantity - $this->wasted_quantity;
    }
}

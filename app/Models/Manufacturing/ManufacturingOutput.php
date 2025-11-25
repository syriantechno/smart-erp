<?php

namespace App\Models\Manufacturing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Warehouse\Material;
use App\Models\Warehouse\Warehouse;

class ManufacturingOutput extends Model
{
    protected $fillable = [
        'manufacturing_order_id',
        'material_id',
        'quantity',
        'good_quantity',
        'defect_quantity',
        'unit_cost',
        'total_cost',
        'warehouse_id',
        'produced_at',
    ];

    protected $casts = [
        'unit_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'produced_at' => 'datetime',
    ];

    public function manufacturingOrder(): BelongsTo
    {
        return $this->belongsTo(ManufacturingOrder::class);
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    // نسبة الجودة
    public function getQualityRateAttribute(): float
    {
        if ($this->quantity <= 0) return 0;
        return round(($this->good_quantity / $this->quantity) * 100, 1);
    }
}

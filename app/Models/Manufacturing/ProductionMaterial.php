<?php

namespace App\Models\Manufacturing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductionMaterial extends Model
{
    protected $fillable = [
        'production_order_id',
        'material_name',
        'material_code',
        'required_quantity',
        'used_quantity',
        'unit_cost',
        'total_cost',
        'status',
        'notes',
    ];

    protected $casts = [
        'required_quantity' => 'decimal:2',
        'used_quantity' => 'decimal:2',
        'unit_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(ProductionOrder::class, 'production_order_id');
    }
}

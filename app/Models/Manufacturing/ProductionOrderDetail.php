<?php

namespace App\Models\Manufacturing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class ProductionOrderDetail extends Model
{
    protected $fillable = [
        'production_order_id',
        'production_stage_id',
        'quantity',
        'unit_cost',
        'total_cost',
        'start_date',
        'end_date',
        'completed_quantity',
        'status',
        'notes',
        'assigned_to',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'unit_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(ProductionOrder::class, 'production_order_id');
    }

    public function stage(): BelongsTo
    {
        return $this->belongsTo(ProductionStage::class, 'production_stage_id');
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}

<?php

namespace App\Models\Manufacturing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;

class ProductionOrder extends Model
{
    protected $fillable = [
        'order_number',
        'product_name',
        'description',
        'quantity',
        'unit_cost',
        'total_cost',
        'start_date',
        'end_date',
        'actual_end_date',
        'status',
        'priority',
        'created_by',
        'approved_by',
        'notes',
        'specifications',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'actual_end_date' => 'date',
        'unit_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'specifications' => 'array',
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function details(): HasMany
    {
        return $this->hasMany(ProductionOrderDetail::class);
    }

    public function materials(): HasMany
    {
        return $this->hasMany(ProductionMaterial::class);
    }

    public function qualityChecks(): HasMany
    {
        return $this->hasMany(QualityCheck::class);
    }

    public function machineSchedules(): HasMany
    {
        return $this->hasMany(MachineSchedule::class);
    }

    public static function generateOrderNumber(): string
    {
        $year = date('Y');
        $count = self::whereYear('created_at', $year)->count() + 1;
        return 'PO-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}

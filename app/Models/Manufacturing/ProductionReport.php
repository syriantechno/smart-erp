<?php

namespace App\Models\Manufacturing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class ProductionReport extends Model
{
    protected $fillable = [
        'report_number',
        'report_type',
        'report_date',
        'start_date',
        'end_date',
        'total_orders',
        'completed_orders',
        'in_progress_orders',
        'total_production_cost',
        'total_material_cost',
        'total_labor_cost',
        'total_machine_cost',
        'total_defects',
        'efficiency_percentage',
        'summary',
        'details',
        'generated_by',
    ];

    protected $casts = [
        'report_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
        'total_production_cost' => 'decimal:2',
        'total_material_cost' => 'decimal:2',
        'total_labor_cost' => 'decimal:2',
        'total_machine_cost' => 'decimal:2',
        'efficiency_percentage' => 'decimal:2',
        'details' => 'array',
    ];

    public function generatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'generated_by');
    }
}

<?php

namespace App\Models\Manufacturing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MachineSchedule extends Model
{
    protected $fillable = [
        'machine_id',
        'production_order_id',
        'scheduled_start',
        'scheduled_end',
        'actual_start',
        'actual_end',
        'planned_hours',
        'actual_hours',
        'status',
        'notes',
    ];

    protected $casts = [
        'scheduled_start' => 'datetime',
        'scheduled_end' => 'datetime',
        'actual_start' => 'datetime',
        'actual_end' => 'datetime',
    ];

    public function machine(): BelongsTo
    {
        return $this->belongsTo(ProductionMachine::class, 'machine_id');
    }

    public function productionOrder(): BelongsTo
    {
        return $this->belongsTo(ProductionOrder::class);
    }
}

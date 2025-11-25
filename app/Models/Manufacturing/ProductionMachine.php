<?php

namespace App\Models\Manufacturing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductionMachine extends Model
{
    protected $fillable = [
        'name',
        'code',
        'model',
        'description',
        'type',
        'status',
        'hourly_rate',
        'capacity_per_hour',
        'specifications',
        'purchase_date',
        'last_maintenance',
        'next_maintenance',
    ];

    protected $casts = [
        'hourly_rate' => 'decimal:2',
        'specifications' => 'array',
        'purchase_date' => 'date',
        'last_maintenance' => 'date',
        'next_maintenance' => 'date',
    ];

    public function schedules(): HasMany
    {
        return $this->hasMany(MachineSchedule::class, 'machine_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeNeedsMaintenance($query)
    {
        return $query->where('next_maintenance', '<=', now());
    }
}

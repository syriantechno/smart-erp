<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeReward extends Model
{
    protected $fillable = [
        'employee_id',
        'granted_by',
        'type',
        'points',
        'amount',
        'reason',
        'granted_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'points' => 'integer',
        'granted_at' => 'datetime',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Employee::class);
    }

    public function granter(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'granted_by');
    }
}

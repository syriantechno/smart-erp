<?php

namespace App\Models\Manufacturing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class QualityCheck extends Model
{
    protected $fillable = [
        'production_order_id',
        'check_name',
        'description',
        'check_type',
        'status',
        'checked_by',
        'checked_at',
        'sample_size',
        'defect_count',
        'findings',
        'recommendations',
        'measurements',
    ];

    protected $casts = [
        'checked_at' => 'datetime',
        'measurements' => 'array',
    ];

    public function productionOrder(): BelongsTo
    {
        return $this->belongsTo(ProductionOrder::class);
    }

    public function checkedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'checked_by');
    }
}

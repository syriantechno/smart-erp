<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EvaluationCriterion extends Model
{
    protected $fillable = [
        'name',
        'code',
        'max_score',
        'is_active',
        'sort_order',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(EmployeeEvaluationItem::class, 'criterion_id');
    }
}

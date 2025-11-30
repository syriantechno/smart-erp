<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\HR\EmployeeEvaluationItem;

class EmployeeEvaluation extends Model
{
    protected $fillable = [
        'employee_id',
        'evaluator_id',
        'overall_rating',
        'performance_rating',
        'behavior_rating',
        'skills_rating',
        'comments',
        'evaluated_at',
    ];

    protected $casts = [
        'evaluated_at' => 'datetime',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(\App\Models\HR\Employee::class);
    }

    public function evaluator(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'evaluator_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(EmployeeEvaluationItem::class, 'employee_evaluation_id');
    }
}

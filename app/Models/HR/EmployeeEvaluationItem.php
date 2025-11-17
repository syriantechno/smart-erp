<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeEvaluationItem extends Model
{
    protected $fillable = [
        'employee_evaluation_id',
        'criterion_id',
        'score',
        'notes',
    ];

    public function evaluation(): BelongsTo
    {
        return $this->belongsTo(EmployeeEvaluation::class, 'employee_evaluation_id');
    }

    public function criterion(): BelongsTo
    {
        return $this->belongsTo(EvaluationCriterion::class, 'criterion_id');
    }
}

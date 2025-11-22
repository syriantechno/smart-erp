<?php

namespace App\Models\Accounting;

use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CashBox extends Model
{
    protected $fillable = [
        'company_id',
        'account_id',
        'code',
        'name',
        'currency',
        'is_active',
        'description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Accounting::class, 'account_id');
    }
}

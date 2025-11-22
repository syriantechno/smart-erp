<?php

namespace App\Models\Accounting;

use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tax extends Model
{
    protected $fillable = [
        'company_id',
        'name',
        'code',
        'rate',
        'type',
        'sales_account_id',
        'purchase_account_id',
        'is_default',
        'is_active',
        'description',
    ];

    protected $casts = [
        'rate' => 'decimal:3',
        'is_default' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function salesAccount(): BelongsTo
    {
        return $this->belongsTo(Accounting::class, 'sales_account_id');
    }

    public function purchaseAccount(): BelongsTo
    {
        return $this->belongsTo(Accounting::class, 'purchase_account_id');
    }
}

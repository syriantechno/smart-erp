<?php

namespace App\Models\Accounting;

use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentVoucher extends Model
{
    protected $fillable = [
        'company_id',
        'method',
        'cash_box_id',
        'bank_account_id',
        'account_id',
        'tax_id',
        'voucher_date',
        'reference',
        'description',
        'amount',
        'tax_amount',
        'total_amount',
        'status',
    ];

    protected $casts = [
        'voucher_date' => 'date',
        'amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function cashBox(): BelongsTo
    {
        return $this->belongsTo(CashBox::class);
    }

    public function bankAccount(): BelongsTo
    {
        return $this->belongsTo(BankAccount::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Accounting::class, 'account_id');
    }

    public function tax(): BelongsTo
    {
        return $this->belongsTo(Tax::class);
    }
}

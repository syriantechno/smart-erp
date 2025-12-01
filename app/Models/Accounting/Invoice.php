<?php

namespace App\Models\Accounting;

use App\Models\Company;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    protected $fillable = [
        'customer_id',
        'company_id',
        'number',
        'type',
        'tax_id',
        'approval_template_id',
        'invoice_date',
        'due_date',
        'reference',
        'notes',
        'subtotal',
        'tax_amount',
        'total',
        'status',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function tax(): BelongsTo
    {
        return $this->belongsTo(Tax::class);
    }

    public function lines(): HasMany
    {
        return $this->hasMany(InvoiceLine::class);
    }

    public function approvalTemplate(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Approval\ApprovalTemplate::class, 'approval_template_id');
    }

    public function getTypeLabelAttribute(): string
    {
        return $this->type === 'sales' ? 'Sales Invoice' : 'Purchase Invoice';
    }
}

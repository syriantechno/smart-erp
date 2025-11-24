<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'email',
        'phone',
        'mobile',
        'address',
        'tax_id',
        'customer_type',
        'credit_limit',
        'payment_terms',
        'status',
        'notes',
        'account_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'credit_limit' => 'decimal:2',
    ];

    // Relationships
    public function account(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Accounting\Accounting::class, 'account_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(\App\Models\Accounting\Invoice::class);
    }

    public function salesOrders(): HasMany
    {
        return $this->hasMany(\App\Models\Warehouse\SaleOrder::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Accessors
    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'active' => 'bg-green-100 text-green-700',
            'inactive' => 'bg-red-100 text-red-700',
            'suspended' => 'bg-yellow-100 text-yellow-700',
            default => 'bg-gray-100 text-gray-700'
        };
    }

    public function getFullNameAttribute(): string
    {
        return $this->name;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'logo',
        'address',
        'commercial_registration',
        'tax_number',
        'phone',
        'email',
        'website',
        'country',
        'city',
        'postal_code',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Scope a query to only include active companies.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Relationships
    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function approvalRequests()
    {
        return $this->hasMany(ApprovalRequest::class);
    }

    public function documentCategories()
    {
        return $this->hasMany(DocumentCategory::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function electronicMails()
    {
        return $this->hasMany(ElectronicMail::class);
    }

    public function warehouses()
    {
        return $this->hasMany(Warehouse::class);
    }

    public function purchaseRequests()
    {
        return $this->hasMany(PurchaseRequest::class);
    }

    public function saleOrders()
    {
        return $this->hasMany(SaleOrder::class);
    }

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }
}

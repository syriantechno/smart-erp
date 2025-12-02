<?php

namespace App\Models\Warehouse;

use App\Models\Approval\ApprovalRequest;
use App\Models\Approval\ApprovalTemplate;
use App\Models\Setting\Company;
use App\Models\Work\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SaleOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'title',
        'description',
        'status',
        'order_date',
        'expected_delivery_date',
        'company_id',
        'project_id',
        'priority',
        'customer_id',
        'warehouse_id',
        'created_by',
        'total_amount',
        'approval_template_id',
        'approval_request_id',
        'is_active'
    ];

    protected $casts = [
        'order_date' => 'date',
        'expected_delivery_date' => 'date',
        'total_amount' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(SaleOrderItem::class);
    }

    public function approvalTemplate(): BelongsTo
    {
        return $this->belongsTo(ApprovalTemplate::class);
    }

    public function approvalRequest(): BelongsTo
    {
        return $this->belongsTo(ApprovalRequest::class);
    }

    public function deliveryOrders(): HasMany
    {
        return $this->hasMany(DeliveryOrder::class);
    }

    public function getStatusBadgeClass(): string
    {
        return match($this->status) {
            'delivered' => 'bg-green-100 text-green-700',
            'shipped' => 'bg-blue-100 text-blue-700',
            'confirmed' => 'bg-purple-100 text-purple-700',
            'pending' => 'bg-yellow-100 text-yellow-700',
            'cancelled' => 'bg-red-100 text-red-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }
}

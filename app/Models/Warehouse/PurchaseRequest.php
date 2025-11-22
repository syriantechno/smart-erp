<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Setting\Company;
use App\Models\User;

class PurchaseRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'title',
        'description',
        'status',
        'priority',
        'request_date',
        'requested_by',
        'approved_by',
        'company_id',
        'warehouse_id',
        'total_amount',
        'is_active',
        'approval_template_id',
        'approval_request_id',
    ];

    protected $casts = [
        'request_date' => 'date',
        'total_amount' => 'decimal:2',
        'priority' => 'string',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function requestedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(PurchaseRequestItem::class);
    }

    public function approvalTemplate(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Approval\ApprovalTemplate::class);
    }

    public function approvalRequest(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Approval\ApprovalRequest::class);
    }

    public function getEffectiveStatusAttribute(): string
    {
        return $this->approvalRequest?->status ?? $this->status ?? 'pending';
    }

    public function getStatusBadgeClass(): string
    {
        return match($this->effective_status) {
            'approved' => 'text-emerald-600',
            'rejected' => 'text-rose-600',
            'completed' => 'text-slate-700',
            default => 'text-amber-600',
        };
    }

    public function getStatusBadgeHtmlAttribute(): string
    {
        $status = $this->effective_status;
        $label = match($status) {
            'approved' => __('Approved'),
            'rejected' => __('Rejected'),
            'completed' => __('Completed'),
            default => __('Pending'),
        };

        $icon = match($status) {
            'approved' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>',
            'rejected' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6L6 18"/><path d="M6 6l12 12"/></svg>',
            'completed' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12l2 2 4-4"/><path d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>',
            default => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l3 3"/></svg>',
        };

        return sprintf(
            '<span class="inline-flex items-center gap-1.5 text-sm font-semibold %s">%s<span>%s</span></span>',
            $this->getStatusBadgeClass(),
            $icon,
            e($label)
        );
    }
}

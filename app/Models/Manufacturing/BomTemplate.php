<?php

namespace App\Models\Manufacturing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\Warehouse\Material;
use App\Models\Company;

class BomTemplate extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'output_material_id',
        'output_quantity',
        'output_unit',
        'labor_cost',
        'overhead_cost',
        'estimated_time_minutes',
        'status',
        'company_id',
        'created_by',
    ];

    protected $casts = [
        'labor_cost' => 'decimal:2',
        'overhead_cost' => 'decimal:2',
    ];

    // العلاقات
    public function outputMaterial(): BelongsTo
    {
        return $this->belongsTo(Material::class, 'output_material_id');
    }

    public function components(): HasMany
    {
        return $this->hasMany(BomComponent::class)->orderBy('sequence');
    }

    public function manufacturingOrders(): HasMany
    {
        return $this->hasMany(ManufacturingOrder::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // حساب التكلفة الإجمالية للمكونات
    public function getComponentsCostAttribute(): float
    {
        return $this->components->sum(function ($component) {
            return $component->quantity * ($component->material->price ?? 0);
        });
    }

    // حساب التكلفة الإجمالية للوحدة
    public function getTotalUnitCostAttribute(): float
    {
        $componentsCost = $this->components_cost;
        $laborCost = $this->labor_cost ?? 0;
        $overheadCost = $this->overhead_cost ?? 0;
        
        return ($componentsCost + $laborCost + $overheadCost) / max(1, $this->output_quantity);
    }

    // توليد كود جديد
    public static function generateCode(): string
    {
        $lastBom = self::orderBy('id', 'desc')->first();
        $nextNumber = $lastBom ? (intval(substr($lastBom->code, 4)) + 1) : 1;
        return 'BOM-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}

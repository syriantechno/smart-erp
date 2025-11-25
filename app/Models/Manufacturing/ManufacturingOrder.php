<?php

namespace App\Models\Manufacturing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\Company;
use App\Models\Warehouse\Warehouse;

class ManufacturingOrder extends Model
{
    protected $fillable = [
        'code',
        'bom_template_id',
        'quantity',
        'completed_quantity',
        'planned_start_date',
        'planned_end_date',
        'actual_start_date',
        'actual_end_date',
        'status',
        'priority',
        'source_warehouse_id',
        'destination_warehouse_id',
        'estimated_cost',
        'actual_cost',
        'notes',
        'company_id',
        'created_by',
        'approved_by',
    ];

    protected $casts = [
        'planned_start_date' => 'date',
        'planned_end_date' => 'date',
        'actual_start_date' => 'datetime',
        'actual_end_date' => 'datetime',
        'estimated_cost' => 'decimal:2',
        'actual_cost' => 'decimal:2',
    ];

    // العلاقات
    public function bomTemplate(): BelongsTo
    {
        return $this->belongsTo(BomTemplate::class);
    }

    public function materials(): HasMany
    {
        return $this->hasMany(ManufacturingOrderMaterial::class);
    }

    public function outputs(): HasMany
    {
        return $this->hasMany(ManufacturingOutput::class);
    }

    public function sourceWarehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'source_warehouse_id');
    }

    public function destinationWarehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'destination_warehouse_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // حساب نسبة الإنجاز
    public function getProgressPercentageAttribute(): float
    {
        if ($this->quantity <= 0) return 0;
        return round(($this->completed_quantity / $this->quantity) * 100, 1);
    }

    // توليد كود جديد
    public static function generateCode(): string
    {
        $year = date('Y');
        $lastOrder = self::whereYear('created_at', $year)->orderBy('id', 'desc')->first();
        $nextNumber = 1;
        
        if ($lastOrder) {
            preg_match('/MO-' . $year . '-(\d+)/', $lastOrder->code, $matches);
            $nextNumber = isset($matches[1]) ? intval($matches[1]) + 1 : 1;
        }
        
        return 'MO-' . $year . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    // حساب المواد المطلوبة بناءً على الكمية
    public function calculateRequiredMaterials(): array
    {
        $materials = [];
        $bom = $this->bomTemplate;
        
        if (!$bom) return $materials;
        
        foreach ($bom->components as $component) {
            $requiredQty = $component->actual_quantity * $this->quantity;
            $materials[] = [
                'material_id' => $component->material_id,
                'material' => $component->material,
                'required_quantity' => $requiredQty,
                'unit' => $component->unit,
                'unit_cost' => $component->material->price ?? 0,
                'total_cost' => $requiredQty * ($component->material->price ?? 0),
            ];
        }
        
        return $materials;
    }

    // بدء التصنيع - حجز المواد
    public function startProduction(): bool
    {
        if ($this->status !== 'confirmed') return false;
        
        $this->status = 'in_progress';
        $this->actual_start_date = now();
        $this->save();
        
        // تحديث حالة المواد إلى محجوزة
        $this->materials()->update(['status' => 'reserved']);
        
        return true;
    }

    // إكمال التصنيع
    public function completeProduction(int $goodQuantity, int $defectQuantity = 0): bool
    {
        if ($this->status !== 'in_progress') return false;
        
        $totalProduced = $goodQuantity + $defectQuantity;
        $this->completed_quantity += $totalProduced;
        
        // إنشاء سجل المخرجات
        ManufacturingOutput::create([
            'manufacturing_order_id' => $this->id,
            'material_id' => $this->bomTemplate->output_material_id,
            'quantity' => $totalProduced,
            'good_quantity' => $goodQuantity,
            'defect_quantity' => $defectQuantity,
            'warehouse_id' => $this->destination_warehouse_id,
            'produced_at' => now(),
        ]);
        
        // استهلاك المواد
        $this->materials()->update(['status' => 'consumed']);
        
        // التحقق من اكتمال الأمر
        if ($this->completed_quantity >= $this->quantity) {
            $this->status = 'completed';
            $this->actual_end_date = now();
        }
        
        $this->save();
        
        return true;
    }
}

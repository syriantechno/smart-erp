<?php

namespace App\Http\Controllers\Manufacturing;

use App\Http\Controllers\Controller;
use App\Models\Manufacturing\BomTemplate;
use App\Models\Manufacturing\BomComponent;
use App\Models\Manufacturing\ManufacturingOrder;
use App\Models\Manufacturing\ManufacturingOrderMaterial;
use App\Models\Warehouse\Material;
use App\Models\Warehouse\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BomController extends Controller
{
    // ==================== BOM Templates ====================
    
    public function index()
    {
        $templates = BomTemplate::with(['outputMaterial', 'components.material', 'createdBy'])
            ->latest()
            ->paginate(15);
            
        $stats = [
            'total' => BomTemplate::count(),
            'active' => BomTemplate::where('status', 'active')->count(),
            'inactive' => BomTemplate::where('status', 'inactive')->count(),
        ];
        
        return view('manufacturing.bom.index', compact('templates', 'stats'));
    }

    public function create()
    {
        $materials = Material::where('is_active', true)->orderBy('name')->get();
        $code = BomTemplate::generateCode();
        
        return view('manufacturing.bom.create', compact('materials', 'code'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:bom_templates,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'output_material_id' => 'required|exists:materials,id',
            'output_quantity' => 'required|integer|min:1',
            'labor_cost' => 'nullable|numeric|min:0',
            'overhead_cost' => 'nullable|numeric|min:0',
            'estimated_time_minutes' => 'nullable|integer|min:0',
            'components' => 'required|array|min:1',
            'components.*.material_id' => 'required|exists:materials,id',
            'components.*.quantity' => 'required|numeric|min:0.0001',
            'components.*.waste_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        DB::beginTransaction();
        try {
            $template = BomTemplate::create([
                'code' => $validated['code'],
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'output_material_id' => $validated['output_material_id'],
                'output_quantity' => $validated['output_quantity'],
                'labor_cost' => $validated['labor_cost'] ?? 0,
                'overhead_cost' => $validated['overhead_cost'] ?? 0,
                'estimated_time_minutes' => $validated['estimated_time_minutes'] ?? 0,
                'status' => 'active',
                'created_by' => auth()->id(),
            ]);

            foreach ($validated['components'] as $index => $component) {
                BomComponent::create([
                    'bom_template_id' => $template->id,
                    'material_id' => $component['material_id'],
                    'quantity' => $component['quantity'],
                    'waste_percentage' => $component['waste_percentage'] ?? 0,
                    'sequence' => $index + 1,
                ]);
            }

            DB::commit();
            
            // Return JSON for AJAX requests
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'id' => $template->id,
                    'message' => 'BOM Template created successfully'
                ]);
            }
            
            return redirect()->route('manufacturing.bom.show', $template)
                ->with('success', 'BOM Template created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error creating BOM: ' . $e->getMessage()
                ], 422);
            }
            
            return back()->with('error', 'Error creating BOM: ' . $e->getMessage())->withInput();
        }
    }

    public function show(BomTemplate $bom)
    {
        $bom->load(['outputMaterial', 'components.material', 'createdBy', 'manufacturingOrders']);
        
        return view('manufacturing.bom.show', compact('bom'));
    }

    public function edit(BomTemplate $bom)
    {
        $bom->load('components');
        $materials = Material::where('is_active', true)->orderBy('name')->get();
        
        return view('manufacturing.bom.edit', compact('bom', 'materials'));
    }

    public function update(Request $request, BomTemplate $bom)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'output_material_id' => 'required|exists:materials,id',
            'output_quantity' => 'required|integer|min:1',
            'labor_cost' => 'nullable|numeric|min:0',
            'overhead_cost' => 'nullable|numeric|min:0',
            'estimated_time_minutes' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive,draft',
            'components' => 'required|array|min:1',
            'components.*.material_id' => 'required|exists:materials,id',
            'components.*.quantity' => 'required|numeric|min:0.0001',
            'components.*.waste_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        DB::beginTransaction();
        try {
            $bom->update([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'output_material_id' => $validated['output_material_id'],
                'output_quantity' => $validated['output_quantity'],
                'labor_cost' => $validated['labor_cost'] ?? 0,
                'overhead_cost' => $validated['overhead_cost'] ?? 0,
                'estimated_time_minutes' => $validated['estimated_time_minutes'] ?? 0,
                'status' => $validated['status'],
            ]);

            // حذف المكونات القديمة وإضافة الجديدة
            $bom->components()->delete();
            
            foreach ($validated['components'] as $index => $component) {
                BomComponent::create([
                    'bom_template_id' => $bom->id,
                    'material_id' => $component['material_id'],
                    'quantity' => $component['quantity'],
                    'waste_percentage' => $component['waste_percentage'] ?? 0,
                    'sequence' => $index + 1,
                ]);
            }

            DB::commit();
            return redirect()->route('manufacturing.bom.show', $bom)
                ->with('success', 'BOM Template updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error updating BOM: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(BomTemplate $bom)
    {
        if ($bom->manufacturingOrders()->exists()) {
            return back()->with('error', 'Cannot delete BOM with existing manufacturing orders');
        }
        
        $bom->delete();
        return redirect()->route('manufacturing.bom.index')
            ->with('success', 'BOM Template deleted successfully');
    }

    // ==================== Manufacturing Orders ====================
    
    public function ordersIndex()
    {
        $orders = ManufacturingOrder::with(['bomTemplate.outputMaterial', 'sourceWarehouse', 'destinationWarehouse', 'createdBy'])
            ->latest()
            ->paginate(15);
            
        $stats = [
            'total' => ManufacturingOrder::count(),
            'in_progress' => ManufacturingOrder::where('status', 'in_progress')->count(),
            'completed' => ManufacturingOrder::where('status', 'completed')->count(),
            'pending' => ManufacturingOrder::whereIn('status', ['draft', 'confirmed'])->count(),
        ];
        
        return view('manufacturing.orders.index-new', compact('orders', 'stats'));
    }

    public function createOrder()
    {
        $templates = BomTemplate::where('status', 'active')->with('outputMaterial')->get();
        $warehouses = Warehouse::where('is_active', true)->get();
        $code = ManufacturingOrder::generateCode();
        
        return view('manufacturing.orders.create-new', compact('templates', 'warehouses', 'code'));
    }

    public function storeOrder(Request $request)
    {
        $validated = $request->validate([
            'bom_template_id' => 'required|exists:bom_templates,id',
            'quantity' => 'required|integer|min:1',
            'planned_start_date' => 'required|date',
            'planned_end_date' => 'nullable|date|after_or_equal:planned_start_date',
            'priority' => 'required|in:low,medium,high,urgent',
            'source_warehouse_id' => 'required|exists:warehouses,id',
            'destination_warehouse_id' => 'required|exists:warehouses,id',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $bom = BomTemplate::with('components.material')->findOrFail($validated['bom_template_id']);
            
            // حساب التكلفة المقدرة
            $estimatedCost = 0;
            foreach ($bom->components as $component) {
                $requiredQty = $component->actual_quantity * $validated['quantity'];
                $estimatedCost += $requiredQty * ($component->material->price ?? 0);
            }
            $estimatedCost += ($bom->labor_cost + $bom->overhead_cost) * $validated['quantity'];

            $order = ManufacturingOrder::create([
                'code' => ManufacturingOrder::generateCode(),
                'bom_template_id' => $validated['bom_template_id'],
                'quantity' => $validated['quantity'],
                'planned_start_date' => $validated['planned_start_date'],
                'planned_end_date' => $validated['planned_end_date'],
                'priority' => $validated['priority'],
                'source_warehouse_id' => $validated['source_warehouse_id'],
                'destination_warehouse_id' => $validated['destination_warehouse_id'],
                'estimated_cost' => $estimatedCost,
                'notes' => $validated['notes'],
                'status' => 'draft',
                'created_by' => auth()->id(),
            ]);

            // إنشاء سجلات المواد المطلوبة
            foreach ($bom->components as $component) {
                $requiredQty = $component->actual_quantity * $validated['quantity'];
                ManufacturingOrderMaterial::create([
                    'manufacturing_order_id' => $order->id,
                    'material_id' => $component->material_id,
                    'required_quantity' => $requiredQty,
                    'unit_cost' => $component->material->price ?? 0,
                    'total_cost' => $requiredQty * ($component->material->price ?? 0),
                    'status' => 'pending',
                ]);
            }

            DB::commit();
            
            // Return JSON for AJAX requests
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'id' => $order->id,
                    'message' => 'Manufacturing Order created successfully'
                ]);
            }
            
            return redirect()->route('manufacturing.mo.show', $order)
                ->with('success', 'Manufacturing Order created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error creating order: ' . $e->getMessage()
                ], 422);
            }
            
            return back()->with('error', 'Error creating order: ' . $e->getMessage())->withInput();
        }
    }

    public function showOrder(ManufacturingOrder $order)
    {
        $order->load([
            'bomTemplate.outputMaterial',
            'bomTemplate.components.material',
            'materials.material',
            'outputs.material',
            'sourceWarehouse',
            'destinationWarehouse',
            'createdBy',
            'approvedBy'
        ]);
        
        return view('manufacturing.orders.show-new', compact('order'));
    }

    public function confirmOrder(ManufacturingOrder $order)
    {
        if ($order->status !== 'draft') {
            return back()->with('error', 'Order cannot be confirmed');
        }

        // التحقق من توفر المواد
        $insufficientMaterials = [];
        foreach ($order->materials as $material) {
            $available = $material->material->quantity ?? 0;
            if ($available < $material->required_quantity) {
                $insufficientMaterials[] = [
                    'name' => $material->material->name,
                    'required' => $material->required_quantity,
                    'available' => $available,
                ];
            }
        }

        if (!empty($insufficientMaterials)) {
            return back()->with('error', 'Insufficient materials available')
                ->with('insufficient_materials', $insufficientMaterials);
        }

        $order->update([
            'status' => 'confirmed',
            'approved_by' => auth()->id(),
        ]);

        return back()->with('success', 'Order confirmed successfully');
    }

    public function startOrder(ManufacturingOrder $order)
    {
        if ($order->status !== 'confirmed') {
            return back()->with('error', 'Order must be confirmed first');
        }

        $order->startProduction();
        
        return back()->with('success', 'Production started');
    }

    public function completeOrder(Request $request, ManufacturingOrder $order)
    {
        $validated = $request->validate([
            'good_quantity' => 'required|integer|min:0',
            'defect_quantity' => 'nullable|integer|min:0',
        ]);

        if ($order->status !== 'in_progress') {
            return back()->with('error', 'Order is not in progress');
        }

        $order->completeProduction(
            $validated['good_quantity'],
            $validated['defect_quantity'] ?? 0
        );

        return back()->with('success', 'Production recorded successfully');
    }

    // API للحصول على تفاصيل BOM
    public function getBomDetails(BomTemplate $bom)
    {
        $bom->load(['outputMaterial', 'components.material']);
        
        return response()->json([
            'bom' => $bom,
            'components' => $bom->components,
            'total_cost' => $bom->total_unit_cost,
        ]);
    }

    // حساب المواد المطلوبة لكمية معينة
    public function calculateMaterials(Request $request)
    {
        $validated = $request->validate([
            'bom_template_id' => 'required|exists:bom_templates,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $bom = BomTemplate::with('components.material')->findOrFail($validated['bom_template_id']);
        
        $materials = [];
        $totalCost = 0;
        
        foreach ($bom->components as $component) {
            $requiredQty = $component->actual_quantity * $validated['quantity'];
            $cost = $requiredQty * ($component->material->price ?? 0);
            $available = $component->material->quantity ?? 0;
            
            $materials[] = [
                'material_id' => $component->material_id,
                'name' => $component->material->name,
                'code' => $component->material->code,
                'required_quantity' => round($requiredQty, 4),
                'available_quantity' => $available,
                'sufficient' => $available >= $requiredQty,
                'unit_cost' => $component->material->price ?? 0,
                'total_cost' => round($cost, 2),
            ];
            
            $totalCost += $cost;
        }
        
        // إضافة تكاليف العمالة والإضافية
        $laborCost = ($bom->labor_cost ?? 0) * $validated['quantity'];
        $overheadCost = ($bom->overhead_cost ?? 0) * $validated['quantity'];
        
        return response()->json([
            'materials' => $materials,
            'materials_cost' => round($totalCost, 2),
            'labor_cost' => round($laborCost, 2),
            'overhead_cost' => round($overheadCost, 2),
            'total_cost' => round($totalCost + $laborCost + $overheadCost, 2),
            'output_product' => $bom->outputMaterial->name ?? '',
            'output_quantity' => $bom->output_quantity * $validated['quantity'],
        ]);
    }
}

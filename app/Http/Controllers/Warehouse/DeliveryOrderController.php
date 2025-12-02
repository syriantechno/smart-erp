<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Approval\ApprovalTemplate;
use App\Models\Work\Project;
use App\Models\Warehouse\Category;
use App\Models\Warehouse\DeliveryOrder;
use App\Models\Warehouse\Inventory;
use App\Models\Warehouse\Material;
use App\Models\Warehouse\Warehouse;
use App\Services\DocumentCodeGenerator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class DeliveryOrderController extends Controller
{
    public function __construct(private DocumentCodeGenerator $codeGenerator)
    {
    }

    public function index()
    {
        // Header statistics
        $totalDeliveryOrders = DeliveryOrder::count();
        $pendingDeliveryOrders = DeliveryOrder::where('status', 'pending')->count();
        $shippedDeliveryOrders = DeliveryOrder::where('status', 'shipped')->count();
        $deliveredDeliveryOrders = DeliveryOrder::where('status', 'delivered')->count();

        // Companies for hero + company filter
        $companies = Company::query()
            ->select('id', 'name', 'logo', 'address')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $company = $companies->first();

        // Warehouses
        $warehouses = Warehouse::query()
            ->select('id', 'code', 'name', 'location')
            ->orderBy('name')
            ->get();

        // Catalogs (root categories with children)
        $categories = Category::with(['children.children'])
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();

        // Materials with category + unit meta (same mapping as material requests / purchase orders)
        $materials = Material::with(['category:id,name,parent_id', 'unit:id,name,symbol'])
            ->select('id', 'code', 'name', 'category_id', 'unit_id', 'price')
            ->where('is_active', true)
            ->orderBy('name')
            ->get()
            ->map(function (Material $material) {
                return [
                    'id' => $material->id,
                    'code' => $material->code,
                    'name' => $material->name,
                    'category_id' => $material->category_id,
                    'category_name' => $material->category?->name,
                    'unit' => $material->unit?->name,
                    'unit_symbol' => $material->unit?->symbol,
                    'price' => (float) $material->price,
                ];
            });

        $materialCategories = $materials
            ->pluck('category_name', 'category_id')
            ->filter()
            ->map(function ($name, $id) {
                return [
                    'id' => $id,
                    'name' => $name,
                ];
            })
            ->values();

        // Approval templates for delivery orders (reusing same model / scope style)
        $approvalTemplates = ApprovalTemplate::query()
            ->active()
            ->byType('delivery_order')
            ->select('id', 'name', 'description', 'levels')
            ->orderBy('name')
            ->get();

        // Active projects for linking delivery orders to projects
        $projects = Project::query()
            ->active()
            ->select('id', 'code', 'name')
            ->orderBy('name')
            ->get();

        $statusStats = [
            'total' => $totalDeliveryOrders,
            'pending' => $pendingDeliveryOrders,
            'shipped' => $shippedDeliveryOrders,
            'delivered' => $deliveredDeliveryOrders,
        ];

        return view('warehouse.delivery-orders.index-unified', compact(
            'company',
            'companies',
            'warehouses',
            'categories',
            'materials',
            'materialCategories',
            'approvalTemplates',
            'projects',
            'statusStats',
            'totalDeliveryOrders',
            'pendingDeliveryOrders',
            'shippedDeliveryOrders',
            'deliveredDeliveryOrders'
        ));
    }

    public function previewCode()
    {
        $code = $this->codeGenerator->preview('delivery_orders');
        return response()->json(['code' => $code]);
    }

    public function datatable(Request $request): JsonResponse
    {
        $baseQuery = DeliveryOrder::query()
            ->with(['warehouse:id,name', 'createdBy:id,name', 'saleOrder:id,code']);

        if ($request->filled('status')) {
            $baseQuery->where('status', $request->status);
        }

        if ($request->filled('warehouse_id')) {
            $baseQuery->where('warehouse_id', $request->warehouse_id);
        }

        return DataTables::of($baseQuery)
            ->addColumn('warehouse_name', function ($do) {
                return $do->warehouse ? $do->warehouse->name : 'N/A';
            })
            ->addColumn('created_by_name', function ($do) {
                return $do->createdBy ? $do->createdBy->name : 'N/A';
            })
            ->addColumn('sale_order_code', function ($do) {
                return $do->saleOrder ? $do->saleOrder->code : 'N/A';
            })
            ->addColumn('status_badge', function ($do) {
                return '<span class="px-2 py-1 text-xs font-medium rounded-full ' . $do->getStatusBadgeClass() . '">' . ucfirst($do->status) . '</span>';
            })
            ->addColumn('actions', function ($do) {
                return view('warehouse.delivery-orders.partials.actions', compact('do'))->render();
            })
            ->rawColumns(['status_badge', 'actions'])
            ->make(true);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|unique:delivery_orders',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'delivery_date' => 'required|date',
            'warehouse_id' => 'required|exists:warehouses,id',
            'sale_order_id' => 'nullable|exists:sale_orders,id',
            'total_quantity' => 'required|numeric|min:0',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();
            DeliveryOrder::create(array_merge($request->all(), ['created_by' => auth()->id()]));
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Delivery order created successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to create delivery order: ' . $e->getMessage()], 500);
        }
    }

    public function show(DeliveryOrder $deliveryOrder): JsonResponse
    {
        $deliveryOrder->load(['warehouse', 'createdBy', 'saleOrder', 'items.material']);
        return response()->json(['success' => true, 'delivery_order' => $deliveryOrder]);
    }

    public function update(Request $request, DeliveryOrder $deliveryOrder): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'code' => ['required', Rule::unique('delivery_orders')->ignore($deliveryOrder->id)],
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'delivery_date' => 'required|date',
            'warehouse_id' => 'required|exists:warehouses,id',
            'sale_order_id' => 'nullable|exists:sale_orders,id',
            'status' => 'required|in:pending,in_transit,delivered,cancelled',
            'total_quantity' => 'required|numeric|min:0',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $oldStatus = $deliveryOrder->status;
        $lowStockAlerts = [];

        try {
            DB::beginTransaction();

            $deliveryOrder->update($request->all());

            if ($oldStatus !== 'delivered' && $deliveryOrder->status === 'delivered') {
                $deliveryOrder->load(['items.material', 'warehouse']);

                foreach ($deliveryOrder->items as $item) {
                    $inventory = Inventory::firstOrCreate(
                        [
                            'material_id' => $item->material_id,
                            'warehouse_id' => $deliveryOrder->warehouse_id,
                        ],
                        [
                            'quantity' => 0,
                            'unit_price' => 0,
                        ]
                    );

                    $inventory->quantity = max(0, $inventory->quantity - $item->quantity);
                    $inventory->save();

                    if ($inventory->quantity <= 0) {
                        $lowStockAlerts[] = [
                            'material_id' => $item->material_id,
                            'material_name' => $item->material?->name,
                            'warehouse_id' => $deliveryOrder->warehouse_id,
                            'warehouse_name' => $deliveryOrder->warehouse?->name,
                            'quantity' => (float) $inventory->quantity,
                        ];
                    }
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Delivery order updated successfully',
                'low_stock' => $lowStockAlerts,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to update delivery order: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(DeliveryOrder $deliveryOrder): JsonResponse
    {
        try {
            $deliveryOrder->delete();
            return response()->json(['success' => true, 'message' => 'Delivery order deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete delivery order: ' . $e->getMessage()], 500);
        }
    }
}

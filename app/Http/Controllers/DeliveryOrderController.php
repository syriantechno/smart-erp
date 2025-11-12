<?php

namespace App\Http\Controllers;

use App\Models\DeliveryOrder;
use App\Models\Warehouse;
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
        $warehouses = Warehouse::active()->select('id', 'name')->get();
        return view('warehouse.delivery-orders.index', compact('warehouses'));
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

        try {
            DB::beginTransaction();
            $deliveryOrder->update($request->all());
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Delivery order updated successfully']);
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

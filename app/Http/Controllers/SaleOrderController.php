<?php

namespace App\Http\Controllers;

use App\Models\SaleOrder;
use App\Models\Warehouse;
use App\Services\DocumentCodeGenerator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class SaleOrderController extends Controller
{
    public function __construct(private DocumentCodeGenerator $codeGenerator)
    {
    }

    public function index()
    {
        $warehouses = Warehouse::active()->select('id', 'name')->get();
        return view('warehouse.sale-orders.index', compact('warehouses'));
    }

    public function previewCode()
    {
        $code = $this->codeGenerator->preview('sale_orders');
        return response()->json(['code' => $code]);
    }

    public function datatable(Request $request): JsonResponse
    {
        $baseQuery = SaleOrder::query()
            ->with(['warehouse:id,name', 'createdBy:id,name']);

        // Apply status filter
        if ($request->filled('status')) {
            $baseQuery->where('status', $request->status);
        }

        // Apply warehouse filter
        if ($request->filled('warehouse_id')) {
            $baseQuery->where('warehouse_id', $request->warehouse_id);
        }

        return DataTables::of($baseQuery)
            ->addColumn('warehouse_name', function ($so) {
                return $so->warehouse ? $so->warehouse->name : 'N/A';
            })
            ->addColumn('created_by_name', function ($so) {
                return $so->createdBy ? $so->createdBy->name : 'N/A';
            })
            ->addColumn('status_badge', function ($so) {
                return '<span class="px-2 py-1 text-xs font-medium rounded-full ' . $so->getStatusBadgeClass() . '">' . ucfirst($so->status) . '</span>';
            })
            ->addColumn('actions', function ($so) {
                return view('warehouse.sale-orders.partials.actions', compact('so'))->render();
            })
            ->rawColumns(['status_badge', 'actions'])
            ->make(true);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|unique:sale_orders',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order_date' => 'required|date',
            'expected_delivery_date' => 'nullable|date',
            'warehouse_id' => 'required|exists:warehouses,id',
            'total_amount' => 'required|numeric|min:0',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            SaleOrder::create(array_merge($request->all(), [
                'created_by' => auth()->id(),
            ]));

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Sale order created successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create sale order: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(SaleOrder $saleOrder): JsonResponse
    {
        $saleOrder->load(['warehouse', 'createdBy', 'items.material']);
        return response()->json([
            'success' => true,
            'sale_order' => $saleOrder
        ]);
    }

    public function update(Request $request, SaleOrder $saleOrder): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'code' => ['required', 'string', Rule::unique('sale_orders')->ignore($saleOrder->id)],
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order_date' => 'required|date',
            'expected_delivery_date' => 'nullable|date',
            'warehouse_id' => 'required|exists:warehouses,id',
            'status' => 'required|in:pending,confirmed,shipped,delivered,cancelled',
            'total_amount' => 'required|numeric|min:0',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $saleOrder->update($request->all());

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Sale order updated successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update sale order: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(SaleOrder $saleOrder): JsonResponse
    {
        try {
            $saleOrder->delete();

            return response()->json([
                'success' => true,
                'message' => 'Sale order deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete sale order: ' . $e->getMessage()
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Services\DocumentCodeGenerator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class PurchaseOrderController extends Controller
{
    public function __construct(private DocumentCodeGenerator $codeGenerator)
    {
    }

    public function index()
    {
        return view('warehouse.purchase-orders.index');
    }

    public function previewCode()
    {
        $code = $this->codeGenerator->preview('purchase_orders');
        return response()->json(['code' => $code]);
    }

    public function datatable(Request $request): JsonResponse
    {
        $baseQuery = PurchaseOrder::query()
            ->with(['createdBy:id,name', 'approvedBy:id,name']);

        if ($request->filled('status')) {
            $baseQuery->where('status', $request->status);
        }

        return DataTables::of($baseQuery)
            ->addColumn('created_by_name', function ($po) {
                return $po->createdBy ? $po->createdBy->name : 'N/A';
            })
            ->addColumn('approved_by_name', function ($po) {
                return $po->approvedBy ? $po->approvedBy->name : 'N/A';
            })
            ->addColumn('status_badge', function ($po) {
                return '<span class="px-2 py-1 text-xs font-medium rounded-full ' . $po->getStatusBadgeClass() . '">' . ucfirst($po->status) . '</span>';
            })
            ->addColumn('actions', function ($po) {
                return view('warehouse.purchase-orders.partials.actions', compact('po'))->render();
            })
            ->rawColumns(['status_badge', 'actions'])
            ->make(true);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|unique:purchase_orders',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order_date' => 'required|date',
            'expected_delivery_date' => 'nullable|date',
            'total_amount' => 'required|numeric|min:0',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();
            PurchaseOrder::create(array_merge($request->all(), ['created_by' => auth()->id()]));
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Purchase order created successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to create purchase order: ' . $e->getMessage()], 500);
        }
    }

    public function show(PurchaseOrder $purchaseOrder): JsonResponse
    {
        $purchaseOrder->load(['createdBy', 'approvedBy', 'items.material']);
        return response()->json(['success' => true, 'purchase_order' => $purchaseOrder]);
    }

    public function update(Request $request, PurchaseOrder $purchaseOrder): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'code' => ['required', Rule::unique('purchase_orders')->ignore($purchaseOrder->id)],
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order_date' => 'required|date',
            'expected_delivery_date' => 'nullable|date',
            'status' => 'required|in:pending,approved,shipped,delivered,cancelled',
            'total_amount' => 'required|numeric|min:0',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();
            $updateData = $request->all();
            if ($request->status === 'approved' && !$purchaseOrder->approved_by) {
                $updateData['approved_by'] = auth()->id();
            }
            $purchaseOrder->update($updateData);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Purchase order updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to update purchase order: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(PurchaseOrder $purchaseOrder): JsonResponse
    {
        try {
            $purchaseOrder->delete();
            return response()->json(['success' => true, 'message' => 'Purchase order deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete purchase order: ' . $e->getMessage()], 500);
        }
    }
}

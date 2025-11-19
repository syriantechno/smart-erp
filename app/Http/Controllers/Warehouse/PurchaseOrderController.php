<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Approval\ApprovalRequest;
use App\Models\Approval\ApprovalTemplate;
use App\Models\Warehouse\PurchaseOrder;
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
        // Get suppliers and materials for the unified invoice form
        try {
            $suppliers = collect(); // Empty collection as fallback
            $materials = \App\Models\Warehouse\Material::select('id', 'name', 'unit', 'price')->get();
        } catch (\Exception $e) {
            $suppliers = collect();
            $materials = collect();
        }
        
        return view('warehouse.purchase-orders.index', compact('suppliers', 'materials'));
    }

    public function previewCode()
    {
        $code = $this->codeGenerator->preview('purchase_orders');
        return response()->json(['code' => $code]);
    }

    public function datatable(Request $request): JsonResponse
    {
        $baseQuery = PurchaseOrder::query()
            ->with(['createdBy:id,name', 'approvedBy:id,name', 'supplier:id,name'])
            ->select([
                'purchase_orders.*'
            ]);

        // Apply advanced filters like employees
        if ($request->filled('filter_field') && $request->filled('filter_value')) {
            $field = $request->filter_field;
            $type = $request->filter_type ?? 'contains';
            $value = $request->filter_value;

            if ($field === 'all') {
                $baseQuery->where(function($q) use ($type, $value) {
                    if ($type === 'contains') {
                        $q->where('code', 'like', '%' . $value . '%')
                          ->orWhere('title', 'like', '%' . $value . '%')
                          ->orWhere('status', 'like', '%' . $value . '%');
                    } else {
                        $q->where('code', $value)
                          ->orWhere('title', $value)
                          ->orWhere('status', $value);
                    }
                });
            } else {
                if ($type === 'contains') {
                    $baseQuery->where($field, 'like', '%' . $value . '%');
                } else {
                    $baseQuery->where($field, $value);
                }
            }
        }

        return DataTables::of($baseQuery)
            ->addIndexColumn()
            ->addColumn('code', function ($po) {
                return '<a href="' . route('warehouse.purchase-orders.show', $po->id) . '" class="font-medium text-primary hover:underline">' . e($po->code) . '</a>';
            })
            ->addColumn('supplier_name', function ($po) {
                return $po->supplier ? $po->supplier->name : 'N/A';
            })
            ->addColumn('order_date', function ($po) {
                return $po->order_date ? $po->order_date->format('Y-m-d') : 'N/A';
            })
            ->addColumn('total_amount', function ($po) {
                return '$' . number_format($po->total_amount ?? 0, 2);
            })
            ->addColumn('status', function ($po) {
                $statusClasses = [
                    'pending' => 'bg-yellow-100 text-yellow-800',
                    'approved' => 'bg-green-100 text-green-800',
                    'shipped' => 'bg-blue-100 text-blue-800',
                    'delivered' => 'bg-emerald-100 text-emerald-800',
                    'cancelled' => 'bg-red-100 text-red-800'
                ];
                $class = $statusClasses[$po->status] ?? 'bg-slate-100 text-slate-800';
                return '<span class="px-2 py-1 text-xs font-medium rounded-full ' . $class . '">' . ucfirst($po->status) . '</span>';
            })
            ->addColumn('actions', function ($po) {
                $editUrl = route('warehouse.purchase-orders.edit', $po->id);
                $showUrl = route('warehouse.purchase-orders.show', $po->id);
                
                return '
                    <div class="flex items-center justify-center gap-1">
                        <a href="' . $showUrl . '" class="btn-tonal btn-tonal--info btn-tonal--icon" title="View Details">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </a>
                        <a href="' . $editUrl . '" class="btn-tonal btn-tonal--warning btn-tonal--icon" title="Edit">
                            <i data-lucide="edit" class="w-4 h-4"></i>
                        </a>
                        <button onclick="deletePurchaseOrder(' . $po->id . ', \'' . addslashes($po->title) . '\')" class="btn-tonal btn-tonal--danger btn-tonal--icon" title="Delete">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </div>
                ';
            })
            ->rawColumns(['code', 'status', 'actions'])
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
            
            // Create Purchase Order
            $purchaseOrder = PurchaseOrder::create(array_merge($request->all(), ['created_by' => auth()->id()]));
            
            // Create Approval Request
            $template = ApprovalTemplate::where('type', 'purchase_order')
                ->where('is_active', true)
                ->first();
            
            if ($template) {
                $approvalRequest = ApprovalRequest::create([
                    'code' => 'APR-PO-' . $purchaseOrder->id . '-' . time(),
                    'title' => 'Approval for Purchase Order: ' . $purchaseOrder->code,
                    'description' => $purchaseOrder->description ?? 'Purchase Order: ' . $purchaseOrder->title,
                    'type' => 'purchase_order',
                    'status' => 'pending',
                    'priority' => 'normal',
                    'amount' => $purchaseOrder->total_amount,
                    'requester_id' => auth()->id(),
                    'approval_template_id' => $template->id,
                    'approval_levels' => $template->levels,
                    'current_level' => 1,
                    'current_approver_id' => $template->getFirstApprover(),
                    'approvable_type' => PurchaseOrder::class,
                    'approvable_id' => $purchaseOrder->id,
                ]);
                
                // Send notification to first approver
                if ($approvalRequest->current_approver_id) {
                    \App\Http\Controllers\NotificationController::sendToUser(
                        $approvalRequest->current_approver_id,
                        'New Purchase Order Approval',
                        'You have a new purchase order pending your approval: ' . $purchaseOrder->code,
                        'info',
                        route('approval-system.index', ['tab' => 'pending-approval'])
                    );
                }
            }
            
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Purchase order created successfully and sent for approval']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to create purchase order: ' . $e->getMessage()], 500);
        }
    }

    public function show(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load([
            'createdBy', 
            'approvedBy', 
            'supplier',
            'items.material',
            'approvalRequest.logs'
        ]);
        
        return view('warehouse.purchase-orders.show', compact('purchaseOrder'));
    }

    public function edit(PurchaseOrder $purchaseOrder)
    {
        // Get suppliers and materials for the unified invoice form
        try {
            $suppliers = collect(); // Empty collection as fallback
            $materials = \App\Models\Warehouse\Material::select('id', 'name', 'unit', 'price')->get();
        } catch (\Exception $e) {
            $suppliers = collect();
            $materials = collect();
        }
        
        return view('warehouse.purchase-orders.edit', compact('purchaseOrder', 'suppliers', 'materials'));
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

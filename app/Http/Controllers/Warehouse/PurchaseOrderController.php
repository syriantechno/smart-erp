<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Services\Notifications\NotificationDispatcher;
use App\Models\Approval\ApprovalRequest;
use App\Models\Approval\ApprovalTemplate;
use App\Models\Work\Project;
use App\Models\User;
use App\Models\Warehouse\PurchaseOrder;
use App\Services\DocumentCodeGenerator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class PurchaseOrderController extends Controller
{
    public function __construct(private DocumentCodeGenerator $codeGenerator)
    {
    }

    public function index()
    {
        $companies = \App\Models\Setting\Company::query()
            ->select('id', 'name', 'logo', 'address')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $company = $companies->first();

        $warehouses = \App\Models\Warehouse\Warehouse::query()
            ->select('id', 'code', 'name', 'location')
            ->orderBy('name')
            ->get();

        $categories = \App\Models\Warehouse\Category::with(['children.children'])
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();

        $materials = \App\Models\Warehouse\Material::with(['category:id,name,parent_id', 'unit:id,name,symbol'])
            ->select('id', 'code', 'name', 'category_id', 'unit_id', 'price')
            ->where('is_active', true)
            ->orderBy('name')
            ->get()
            ->map(function (\App\Models\Warehouse\Material $material) {
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

        $approvalTemplates = ApprovalTemplate::query()
            ->active()
            ->byType('purchase_order')
            ->select('id', 'name', 'description', 'levels')
            ->orderBy('name')
            ->get();

        $projects = Project::query()
            ->active()
            ->select('id', 'code', 'name')
            ->orderBy('name')
            ->get();

        $purchaseOrders = PurchaseOrder::query()
            ->select('id', 'status')
            ->get();

        $statusStats = [
            'total' => $purchaseOrders->count(),
            'pending' => $purchaseOrders->where('status', 'pending')->count(),
            'approved' => $purchaseOrders->where('status', 'approved')->count(),
            'shipped' => $purchaseOrders->where('status', 'shipped')->count(),
            'delivered' => $purchaseOrders->where('status', 'delivered')->count(),
            'cancelled' => $purchaseOrders->where('status', 'cancelled')->count(),
        ];

        $suppliers = \App\Models\Supplier\Vendor::query()
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return view(
            'warehouse.purchase-orders.index',
            compact(
                'company',
                'companies',
                'warehouses',
                'categories',
                'materials',
                'materialCategories',
                'approvalTemplates',
                'projects',
                'statusStats',
                'suppliers'
            )
        );
    }

    public function previewCode()
    {
        $code = $this->codeGenerator->preview('purchase_orders');
        return response()->json(['code' => $code]);
    }

    public function datatable(Request $request): JsonResponse
    {
        $baseQuery = PurchaseOrder::query()
            ->with(['createdBy:id,name', 'approvedBy:id,name', 'supplier:id,name', 'approvalRequest'])
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
            ->addColumn('approval_progress', function ($po) {
                if (!$po->approvalRequest) {
                    return '<span class="text-xs text-slate-400">—</span>';
                }

                static $approverCache = [];
                $approvalRequest = $po->approvalRequest;
                $levels = collect($approvalRequest->approval_levels ?? [])->map(function ($level, $index) use ($approvalRequest, &$approverCache) {
                    $levelNumber = $level['level'] ?? ($index + 1);
                    $approverId = $level['approver_id'] ?? null;

                    if ($approverId && !array_key_exists($approverId, $approverCache)) {
                        $approverCache[$approverId] = User::find($approverId)?->name;
                    }

                    return [
                        'number' => $levelNumber,
                        'name' => $level['name'] ?? 'Level ' . $levelNumber,
                        'approver' => $level['approver_name'] ?? $approverCache[$approverId] ?? __('Approver'),
                        'is_completed' => $levelNumber < ($approvalRequest->current_level ?? 1) || $approvalRequest->status === 'approved',
                        'is_current' => $approvalRequest->status === 'pending' && ($approvalRequest->current_level ?? 1) === $levelNumber,
                        'is_rejected' => $approvalRequest->status === 'rejected' && ($approvalRequest->current_level ?? 1) === $levelNumber,
                    ];
                })->toArray();

                return view('warehouse.purchase-orders.partials.approval-progress', [
                    'levels' => $levels,
                ])->render();
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
                return view('warehouse.purchase-orders.partials.actions', ['po' => $po])->render();
            })
            ->rawColumns(['code', 'status', 'approval_progress', 'actions'])
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
            'is_active' => 'boolean',
            'approval_template_id' => [
                'required',
                Rule::exists('approval_templates', 'id')->where(function ($query) {
                    $query->where('type', 'purchase_order')->where('is_active', true);
                }),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();

            $template = ApprovalTemplate::active()
                ->byType('purchase_order')
                ->find($request->input('approval_template_id'));

            if (!$template) {
                return response()->json([
                    'success' => false,
                    'message' => 'Selected approval template is no longer available.',
                ], 422);
            }

            if (empty($template->levels)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Selected approval template does not have any approvers configured.',
                ], 422);
            }

            $purchaseOrder = PurchaseOrder::create(array_merge(
                $request->except('approval_template_id'),
                ['created_by' => auth()->id()]
            ));

            $this->startApprovalWorkflow($purchaseOrder, $template);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Purchase order created successfully and sent for approval']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to create purchase order: ' . $e->getMessage()], 500);
        }
    }

    public function show(Request $request, PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load([
            'createdBy', 
            'approvedBy', 
            'supplier',
            'items.material',
            'approvalRequest.logs.user',
            'approvalRequest.currentApprover',
        ]);

        $approvalRequest = $purchaseOrder->approvalRequest;
        $approverNames = collect();

        if ($approvalRequest) {
            $approverIds = collect($approvalRequest->approval_levels ?? [])
                ->pluck('approver_id')
                ->filter()
                ->unique()
                ->values();

            if ($approverIds->isNotEmpty()) {
                $approverNames = User::query()
                    ->select('id', 'name')
                    ->whereIn('id', $approverIds)
                    ->get()
                    ->keyBy('id');
            }
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'purchase_order' => $purchaseOrder,
            ]);
        }

        return view('warehouse.purchase-orders.show', [
            'purchaseOrder' => $purchaseOrder,
            'approvalRequest' => $approvalRequest,
            'approverNames' => $approverNames,
        ]);
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

    private function startApprovalWorkflow(PurchaseOrder $purchaseOrder, ApprovalTemplate $template): ApprovalRequest
    {
        $levels = collect($template->levels ?? [])
            ->filter(function ($level) {
                return !empty($level['approver_id']);
            })
            ->values()
            ->map(function ($level, $index) {
                return [
                    'level' => $level['level'] ?? ($index + 1),
                    'name' => $level['name'] ?? 'Level ' . ($index + 1),
                    'approver_id' => (int) $level['approver_id'],
                    'role' => $level['role'] ?? null,
                ];
            })
            ->toArray();

        if (empty($levels)) {
            throw ValidationException::withMessages([
                'approval_template_id' => 'Selected approval template does not have any approvers configured.',
            ]);
        }

        $currentApproverId = $levels[0]['approver_id'] ?? null;

        $approvalRequest = ApprovalRequest::create([
            'code' => $this->generateUniqueApprovalCode(),
            'title' => $purchaseOrder->title,
            'description' => $purchaseOrder->description ?? 'Purchase order approval request',
            'type' => 'purchase_order',
            'status' => 'pending',
            'priority' => 'normal',
            'amount' => $purchaseOrder->total_amount,
            'requester_id' => $purchaseOrder->created_by,
            'current_approver_id' => $currentApproverId,
            'approval_template_id' => $template->id,
            'approval_levels' => $levels,
            'current_level' => 1,
            'approvable_type' => PurchaseOrder::class,
            'approvable_id' => $purchaseOrder->id,
            'request_data' => [
                'purchase_order_id' => $purchaseOrder->id,
                'purchase_order_code' => $purchaseOrder->code,
                'supplier_id' => $purchaseOrder->supplier_id,
            ],
        ]);

        $approvalRequest->logs()->create([
            'action' => 'submitted',
            'user_id' => $purchaseOrder->created_by,
            'level' => 1,
        ]);

        $purchaseOrder->update([
            'approval_template_id' => $template->id,
            'approval_request_id' => $approvalRequest->id,
        ]);

        if ($currentApproverId) {
            NotificationDispatcher::toUser(
                $currentApproverId,
                'approval.pending',
                'Purchase Order Approval Needed',
                'Purchase order ' . $purchaseOrder->code . ' is pending your approval.',
                route('warehouse.purchase-orders.show', $purchaseOrder),
                'ClipboardCheck',
                ['type' => 'info', 'purchase_order_id' => $purchaseOrder->id]
            );
        }

        return $approvalRequest;
    }

    private function generateUniqueApprovalCode(): string
    {
        $attempts = 0;
        do {
            $code = $this->codeGenerator->generate('approval_requests');
            $exists = ApprovalRequest::where('code', $code)->exists();
            $attempts++;
        } while ($exists && $attempts < 5);

        if ($exists) {
            $code = 'APR-' . now()->format('Ymd-His-u');
        }

        return $code;
    }
}

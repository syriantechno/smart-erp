<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Approval\ApprovalRequest;
use App\Models\Approval\ApprovalTemplate;
use App\Models\Setting\Company;
use App\Models\Work\Project;
use App\Models\Warehouse\SaleOrder;
use App\Models\Warehouse\Warehouse;
use App\Models\Warehouse\Material;
use App\Models\User;
use App\Services\Notifications\NotificationDispatcher;
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
        // Get statistics for the royal theme header
        $totalSaleOrders = SaleOrder::count();
        $pendingSaleOrders = SaleOrder::where('status', 'pending')->count();
        $confirmedSaleOrders = SaleOrder::where('status', 'confirmed')->count();
        $completedSaleOrders = SaleOrder::where('status', 'completed')->count();

        $companies = Company::query()
            ->select('id', 'name', 'logo', 'address')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $company = $companies->first();

        $warehouses = Warehouse::query()
            ->select('id', 'code', 'name', 'location')
            ->orderBy('name')
            ->get();

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

        $approvalTemplates = ApprovalTemplate::query()
            ->active()
            ->byType('sale_order')
            ->select('id', 'name', 'description', 'levels')
            ->orderBy('name')
            ->get();

        $projects = Project::query()
            ->active()
            ->select('id', 'code', 'name')
            ->orderBy('name')
            ->get();

        $currencySymbol = setting('currency.symbol', '$');

        return view(
            'warehouse.sale-orders.index',
            compact(
                'company',
                'companies',
                'warehouses',
                'materials',
                'materialCategories',
                'approvalTemplates',
                'projects',
                'totalSaleOrders',
                'pendingSaleOrders',
                'confirmedSaleOrders',
                'completedSaleOrders',
                'currencySymbol'
            )
        );
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
            'priority' => 'nullable|in:normal,high,urgent',
            'order_date' => 'required|date',
            'expected_delivery_date' => 'nullable|date',
            'company_id' => 'required|exists:companies,id',
            'project_id' => 'nullable|exists:projects,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'status' => 'nullable|in:pending,confirmed,shipped,delivered,cancelled',
            'is_active' => 'boolean',
            'items' => 'required',
            'approval_template_id' => [
                'required',
                Rule::exists('approval_templates', 'id')->where(function ($query) {
                    $query->where('type', 'sale_order')->where('is_active', true);
                }),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $itemsPayload = json_decode($request->input('items', '[]'), true);

        if (!is_array($itemsPayload) || empty($itemsPayload)) {
            return response()->json([
                'success' => false,
                'message' => 'Please add at least one material to the sale order.'
            ], 422);
        }

        $materialIds = collect($itemsPayload)
            ->pluck('material_id')
            ->filter()
            ->unique()
            ->values();

        if ($materialIds->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid material selection submitted.'
            ], 422);
        }

        $materials = Material::query()
            ->whereIn('id', $materialIds)
            ->get()
            ->keyBy('id');

        if ($materials->count() !== $materialIds->count()) {
            return response()->json([
                'success' => false,
                'message' => 'One or more selected materials are no longer available.'
            ], 422);
        }

        $itemsData = collect($itemsPayload)
            ->map(function ($item) use ($materials) {
                $materialId = (int) ($item['material_id'] ?? 0);
                if (!$materialId || !$materials->has($materialId)) {
                    return null;
                }

                $quantity = max(1, (float) ($item['quantity'] ?? 1));
                $material = $materials->get($materialId);
                $unitPrice = (float) ($material->price ?? 0);

                return [
                    'material_id' => $materialId,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'notes' => $item['notes'] ?? null,
                ];
            })
            ->filter()
            ->values();

        if ($itemsData->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No valid materials were provided.'
            ], 422);
        }

        $totalAmount = $itemsData->reduce(function ($carry, $item) {
            return $carry + ($item['quantity'] * $item['unit_price']);
        }, 0);

        if ($totalAmount <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Calculated total cannot be zero.'
            ], 422);
        }

        $approvalTemplate = ApprovalTemplate::active()
            ->byType('sale_order')
            ->find($request->input('approval_template_id'));

        if (!$approvalTemplate) {
            return response()->json([
                'success' => false,
                'message' => 'Selected approval template is no longer available.',
            ], 422);
        }

        if (empty($approvalTemplate->levels)) {
            return response()->json([
                'success' => false,
                'message' => 'Selected approval template does not have any approvers configured.',
            ], 422);
        }

        try {
            $saleOrder = DB::transaction(function () use ($request, $itemsData, $totalAmount, $approvalTemplate) {
                $code = $request->input('code');

                $saleOrder = SaleOrder::create([
                    'code' => $code,
                    'title' => $request->input('title'),
                    'description' => $request->input('description'),
                    'priority' => $request->input('priority', 'normal'),
                    'order_date' => $request->input('order_date'),
                    'expected_delivery_date' => $request->input('expected_delivery_date'),
                    'company_id' => $request->input('company_id'),
                    'project_id' => $request->input('project_id'),
                    'warehouse_id' => $request->input('warehouse_id'),
                    'status' => $request->input('status', 'pending'),
                    'total_amount' => $totalAmount,
                    'is_active' => $request->boolean('is_active', true),
                    'created_by' => auth()->id(),
                    'approval_template_id' => $approvalTemplate->id,
                ]);

                $saleOrder->items()->createMany($itemsData->toArray());

                $this->startApprovalWorkflow(
                    $saleOrder,
                    $approvalTemplate,
                    $totalAmount,
                    $itemsData->count()
                );

                return $saleOrder;
            });

            return response()->json([
                'success' => true,
                'message' => 'Sale order created successfully',
                'code' => $saleOrder->code,
            ]);
        } catch (\Exception $e) {
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

    private function startApprovalWorkflow(
        SaleOrder $saleOrder,
        ApprovalTemplate $template,
        float $totalAmount,
        int $itemsCount
    ): ApprovalRequest {
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
            throw \Illuminate\Validation\ValidationException::withMessages([
                'approval_template_id' => 'Selected approval template does not have any approvers configured.',
            ]);
        }

        $currentApproverId = $levels[0]['approver_id'] ?? null;

        $approvalRequest = ApprovalRequest::create([
            'code' => $this->generateUniqueApprovalCode(),
            'title' => $saleOrder->title,
            'description' => $saleOrder->description ?? 'Sale order approval',
            'type' => 'sale_order',
            'status' => 'pending',
            'priority' => $saleOrder->priority ?? 'normal',
            'request_data' => [
                'sale_order_id' => $saleOrder->id,
                'sale_order_code' => $saleOrder->code,
                'items_count' => $itemsCount,
            ],
            'amount' => $totalAmount,
            'requester_id' => $saleOrder->created_by,
            'current_approver_id' => $currentApproverId,
            'company_id' => $saleOrder->company_id,
            'approval_template_id' => $template->id,
            'approvable_type' => SaleOrder::class,
            'approvable_id' => $saleOrder->id,
            'approval_levels' => $levels,
            'current_level' => 1,
        ]);

        $approvalRequest->logs()->create([
            'action' => 'submitted',
            'user_id' => $saleOrder->created_by,
            'level' => 1,
        ]);

        $saleOrder->update([
            'approval_template_id' => $template->id,
            'approval_request_id' => $approvalRequest->id,
        ]);

        if ($currentApproverId) {
            NotificationDispatcher::toUser(
                $currentApproverId,
                'approval.pending',
                'Sale Order Approval Needed',
                'Sale order ' . $saleOrder->code . ' is pending your approval.',
                null,
                'ClipboardCheck',
                ['type' => 'info', 'sale_order_id' => $saleOrder->id]
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
            // Fallback to timestamp-based code if generator keeps colliding
            $code = 'APR-' . now()->format('Ymd-His-u');
        }

        return $code;
    }
}

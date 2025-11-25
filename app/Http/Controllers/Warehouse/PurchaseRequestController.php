<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Services\Notifications\NotificationDispatcher;
use App\Models\Approval\ApprovalRequest;
use App\Models\Approval\ApprovalTemplate;
use App\Models\Setting\Company;
use App\Models\User;
use App\Models\Warehouse\Category;
use App\Models\Warehouse\Material;
use App\Models\Warehouse\PurchaseRequest;
use App\Models\Warehouse\Warehouse;
use App\Services\DocumentCodeGenerator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class PurchaseRequestController extends Controller
{
    public function __construct(private DocumentCodeGenerator $codeGenerator)
    {
    }

    public function index()
    {
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

        $categories = Category::with(['children.children'])
            ->whereNull('parent_id')
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
            ->byType('material_request')
            ->select('id', 'name', 'description', 'levels')
            ->orderBy('name')
            ->get();

        // Status statistics for dashboard cards
        $requests = PurchaseRequest::query()
            ->with('approvalRequest')
            ->select('id', 'status', 'approval_request_id')
            ->get();

        $groupedByStatus = $requests->groupBy(function (PurchaseRequest $request) {
            return $request->effective_status;
        });

        $statusStats = [
            'total' => $requests->count(),
            'pending' => $groupedByStatus->get('pending')?->count() ?? 0,
            'in_progress' => $groupedByStatus->get('in_progress')?->count() ?? 0,
            'approved' => $groupedByStatus->get('approved')?->count() ?? 0,
            'rejected' => $groupedByStatus->get('rejected')?->count() ?? 0,
            'completed' => $groupedByStatus->get('completed')?->count() ?? 0,
        ];

        return view(
            'warehouse.material-requests.index',
            compact(
                'company',
                'companies',
                'warehouses',
                'categories',
                'materials',
                'materialCategories',
                'approvalTemplates',
                'statusStats'
            )
        );
    }

    public function previewCode()
    {
        $code = $this->codeGenerator->preview('purchase_requests');
        return response()->json(['code' => $code]);
    }

    public function datatable(Request $request): JsonResponse
    {
        $baseQuery = PurchaseRequest::query()
            ->with(['requestedBy:id,name', 'approvedBy:id,name', 'approvalRequest', 'company:id,name']);

        // Apply status filter using effective status logic
        if ($request->filled('status')) {
            $statusFilter = $request->status;

            $baseQuery->where(function ($query) use ($statusFilter) {
                if ($statusFilter === 'pending') {
                    // Pending: no approval yet and PR status pending, OR approval pending at first level
                    $query->where(function ($q) {
                        $q->whereNull('approval_request_id')
                            ->where('status', 'pending');
                    })->orWhereHas('approvalRequest', function ($approvalQuery) {
                        $approvalQuery->where('status', 'pending')
                            ->where(function ($levelQuery) {
                                $levelQuery->whereNull('current_level')->orWhere('current_level', 1);
                            });
                    });
                } elseif ($statusFilter === 'in_progress') {
                    // In progress: approval workflow running beyond first level
                    $query->whereHas('approvalRequest', function ($approvalQuery) {
                        $approvalQuery->where('status', 'pending')
                            ->where('current_level', '>', 1);
                    });
                } else {
                    // Approved / rejected / completed: match either PR status or approvalRequest status
                    $query->where(function ($q) use ($statusFilter) {
                        $q->where('status', $statusFilter)
                            ->orWhereHas('approvalRequest', function ($approvalQuery) use ($statusFilter) {
                                $approvalQuery->where('status', $statusFilter);
                            });
                    });
                }
            });
        }

        return DataTables::of($baseQuery)
            ->editColumn('code', function ($pr) {
                $url = route('warehouse.material-requests.show', $pr);
                return '<a href="' . e($url) . '" class="block">' . e($pr->code) . '</a>';
            })
            ->editColumn('title', function ($pr) {
                $url = route('warehouse.material-requests.show', $pr);
                return '<a href="' . e($url) . '" class="block">' . e($pr->title) . '</a>';
            })
            ->addColumn('requested_by_name', function ($pr) {
                return $pr->requestedBy ? $pr->requestedBy->name : 'N/A';
            })
            ->addColumn('approved_by_name', function ($pr) {
                return $pr->approvedBy ? $pr->approvedBy->name : 'N/A';
            })
            ->addColumn('company_name', function ($pr) {
                return $pr->company?->name ?? '—';
            })
            ->addColumn('request_date', function ($pr) {
                return $pr->request_date ? $pr->request_date->format('Y-m-d') : '—';
            })
            ->addColumn('status_badge', function ($pr) {
                return $pr->status_badge_html;
            })
            ->addColumn('approval_progress', function ($pr) {
                if (!$pr->approvalRequest) {
                    return '<span class="text-xs text-slate-400">—</span>';
                }

                static $approverCache = [];
                $approvalRequest = $pr->approvalRequest;
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

                return view('warehouse.material-requests.partials.approval-progress', [
                    'levels' => $levels,
                ])->render();
            })
            ->addColumn('actions', function ($pr) {
                return view('warehouse.material-requests.partials.actions', compact('pr'))->render();
            })
            ->rawColumns(['code', 'title', 'status_badge', 'approval_progress', 'actions'])
            ->make(true);
    }

    public function materials(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'warehouse_id' => 'required|exists:warehouses,id',
            'catalog_id' => [
                'required',
                Rule::exists('categories', 'id')->where(fn ($query) => $query->whereNull('parent_id')),
            ],
            'sub_catalog_id' => [
                'nullable',
                Rule::exists('categories', 'id'),
            ],
            'search' => 'nullable|string|max:255',
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|integer|min:1|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();

        $catalog = Category::query()
            ->whereKey($validated['catalog_id'])
            ->whereNull('parent_id')
            ->firstOrFail();

        $subCatalog = null;
        if (!empty($validated['sub_catalog_id'])) {
            $subCatalog = Category::query()
                ->whereKey($validated['sub_catalog_id'])
                ->where('parent_id', $catalog->id)
                ->first();

            if (! $subCatalog) {
                return response()->json([
                    'success' => false,
                    'message' => 'Selected sub catalog does not belong to the chosen catalog.',
                ], 422);
            }
        }

        $warehouseId = (int) $validated['warehouse_id'];
        $perPage = min((int) ($validated['per_page'] ?? 12), 50);
        $search = trim((string) ($validated['search'] ?? ''));

        $categoryIds = [];
        if ($subCatalog) {
            $categoryIds[] = $subCatalog->id;
        } else {
            $categoryIds[] = $catalog->id;
            $childIds = Category::query()
                ->where('parent_id', $catalog->id)
                ->pluck('id')
                ->all();
            $categoryIds = array_merge($categoryIds, $childIds);
        }

        $materialsQuery = Material::query()
            ->select([
                'materials.id',
                'materials.code',
                'materials.name',
                'materials.category_id',
                'materials.unit_id',
                'materials.price',
                'materials.image_path',
            ])
            ->selectRaw('COALESCE(inv.quantity, 0) as available_quantity')
            ->leftJoin('inventories as inv', function ($join) use ($warehouseId) {
                $join->on('inv.material_id', '=', 'materials.id')
                    ->where('inv.warehouse_id', $warehouseId);
            })
            ->where('materials.is_active', true)
            ->whereIn('materials.category_id', $categoryIds)
            ->with('unit:id,name,symbol')
            ->orderBy('materials.name');

        if ($search !== '') {
            $materialsQuery->where(function ($query) use ($search) {
                $query->where('materials.name', 'like', "%{$search}%")
                    ->orWhere('materials.code', 'like', "%{$search}%");
            });
        }

        $materials = $materialsQuery->paginate($perPage);

        $items = $materials->getCollection()->map(function (Material $material) {
            return [
                'id' => $material->id,
                'code' => $material->code,
                'name' => $material->name,
                'unit_name' => $material->unit?->name,
                'unit_symbol' => $material->unit?->symbol,
                'price' => (float) $material->price,
                'available_quantity' => (float) ($material->available_quantity ?? 0),
                'image_url' => $material->image_url,
            ];
        })->values();

        return response()->json([
            'success' => true,
            'data' => [
                'items' => $items,
                'pagination' => [
                    'total' => $materials->total(),
                    'per_page' => $materials->perPage(),
                    'current_page' => $materials->currentPage(),
                    'last_page' => $materials->lastPage(),
                ],
            ],
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'nullable|in:normal,high,urgent',
            'request_date' => 'required|date',
            'company_id' => 'required|exists:companies,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'status' => 'nullable|in:pending,approved,rejected,completed',
            'is_active' => 'boolean',
            'items' => 'required',
            'approval_template_id' => [
                'required',
                Rule::exists('approval_templates', 'id')->where(function ($query) {
                    $query->where('type', 'material_request')->where('is_active', true);
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
                'message' => 'Please add at least one material to the request.'
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
            ->byType('material_request')
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
            $purchaseRequest = DB::transaction(function () use ($request, $itemsData, $totalAmount, $approvalTemplate) {
                $code = $this->codeGenerator->generate('purchase_requests');

                $purchaseRequest = PurchaseRequest::create([
                    'code' => $code,
                    'title' => $request->input('title'),
                    'description' => $request->input('description'),
                    'priority' => $request->input('priority', 'normal'),
                    'request_date' => $request->input('request_date'),
                    'requested_by' => auth()->id(),
                    'company_id' => $request->input('company_id'),
                    'warehouse_id' => $request->input('warehouse_id'),
                    'status' => $request->input('status', 'pending'),
                    'total_amount' => $totalAmount,
                    'is_active' => $request->boolean('is_active', true),
                ]);

                $purchaseRequest->items()->createMany($itemsData->toArray());

                $this->startApprovalWorkflow(
                    $purchaseRequest,
                    $approvalTemplate,
                    $totalAmount,
                    $itemsData->count()
                );

                return $purchaseRequest;
            });

            return response()->json([
                'success' => true,
                'message' => 'Purchase request created successfully',
                'code' => $purchaseRequest->code
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create purchase request: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(Request $request, PurchaseRequest $purchaseRequest)
    {
        $purchaseRequest->load([
            'company',
            'warehouse',
            'requestedBy',
            'approvedBy',
            'items.material.unit',
            'approvalRequest.logs.user',
            'approvalRequest.currentApprover',
        ]);

        $approvalRequest = $purchaseRequest->approvalRequest;
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
                'purchase_request' => $purchaseRequest
            ]);
        }

        $currencySymbol = config('app.currency_symbol', config('app.currency', '$'));

        return view('warehouse.material-requests.show', [
            'purchaseRequest' => $purchaseRequest,
            'currencySymbol' => $currencySymbol,
            'approvalRequest' => $approvalRequest,
            'approverNames' => $approverNames,
        ]);
    }

    public function update(Request $request, PurchaseRequest $purchaseRequest): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'code' => ['required', 'string', Rule::unique('purchase_requests')->ignore($purchaseRequest->id)],
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'request_date' => 'required|date',
            'status' => 'required|in:pending,approved,rejected,completed',
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

            $updateData = $request->all();
            if ($request->status === 'approved' && !$purchaseRequest->approved_by) {
                $updateData['approved_by'] = auth()->id();
            }

            $purchaseRequest->update($updateData);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Purchase request updated successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update purchase request: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(PurchaseRequest $purchaseRequest): JsonResponse
    {
        try {
            $purchaseRequest->delete();

            return response()->json([
                'success' => true,
                'message' => 'Purchase request deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete purchase request: ' . $e->getMessage()
            ], 500);
        }
    }

    private function startApprovalWorkflow(
        PurchaseRequest $purchaseRequest,
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
            throw ValidationException::withMessages([
                'approval_template_id' => 'Selected approval template does not have any approvers configured.',
            ]);
        }

        $currentApproverId = $levels[0]['approver_id'] ?? null;

        $approvalRequest = ApprovalRequest::create([
            'code' => $this->generateUniqueApprovalCode(),
            'title' => $purchaseRequest->title,
            'description' => $purchaseRequest->description ?? 'Material request approval',
            'type' => 'material_request',
            'status' => 'pending',
            'priority' => $purchaseRequest->priority ?? 'normal',
            'request_data' => [
                'purchase_request_id' => $purchaseRequest->id,
                'purchase_request_code' => $purchaseRequest->code,
                'items_count' => $itemsCount,
            ],
            'amount' => $totalAmount,
            'requester_id' => $purchaseRequest->requested_by,
            'current_approver_id' => $currentApproverId,
            'company_id' => $purchaseRequest->company_id,
            'approval_template_id' => $template->id,
            'approvable_type' => PurchaseRequest::class,
            'approvable_id' => $purchaseRequest->id,
            'approval_levels' => $levels,
            'current_level' => 1,
        ]);

        $approvalRequest->logs()->create([
            'action' => 'submitted',
            'user_id' => $purchaseRequest->requested_by,
            'level' => 1,
        ]);

        $purchaseRequest->update([
            'approval_template_id' => $template->id,
            'approval_request_id' => $approvalRequest->id,
        ]);

        if ($currentApproverId) {
            NotificationDispatcher::toUser(
                $currentApproverId,
                'approval.pending',
                'Material Request Approval Needed',
                'Material request ' . $purchaseRequest->code . ' is pending your approval.',
                route('warehouse.material-requests.show', $purchaseRequest),
                'ClipboardCheck',
                ['type' => 'info', 'material_request_id' => $purchaseRequest->id]
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

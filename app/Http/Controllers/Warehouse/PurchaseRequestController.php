<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Setting\Company;
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

        return view(
            'warehouse.material-requests.index',
            compact('company', 'companies', 'warehouses', 'categories', 'materials', 'materialCategories')
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
            ->with(['requestedBy:id,name', 'approvedBy:id,name']);

        // Apply status filter
        if ($request->filled('status')) {
            $baseQuery->where('status', $request->status);
        }

        return DataTables::of($baseQuery)
            ->addColumn('requested_by_name', function ($pr) {
                return $pr->requestedBy ? $pr->requestedBy->name : 'N/A';
            })
            ->addColumn('approved_by_name', function ($pr) {
                return $pr->approvedBy ? $pr->approvedBy->name : 'N/A';
            })
            ->addColumn('status_badge', function ($pr) {
                return '<span class="px-2 py-1 text-xs font-medium rounded-full ' . $pr->getStatusBadgeClass() . '">' . ucfirst($pr->status) . '</span>';
            })
            ->addColumn('actions', function ($pr) {
                return view('warehouse.material-requests.partials.actions', compact('pr'))->render();
            })
            ->rawColumns(['status_badge', 'actions'])
            ->make(true);
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
            'items' => 'required'
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

        try {
            $purchaseRequest = DB::transaction(function () use ($request, $itemsData, $totalAmount) {
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
        ]);

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
}

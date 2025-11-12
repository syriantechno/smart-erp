<?php

namespace App\Http\Controllers;

use App\Models\PurchaseRequest;
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
        return view('warehouse.purchase-requests.index');
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
                return view('warehouse.purchase-requests.partials.actions', compact('pr'))->render();
            })
            ->rawColumns(['status_badge', 'actions'])
            ->make(true);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|unique:purchase_requests',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'request_date' => 'required|date',
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

            PurchaseRequest::create(array_merge($request->all(), [
                'requested_by' => auth()->id(),
            ]));

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Purchase request created successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create purchase request: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(PurchaseRequest $purchaseRequest): JsonResponse
    {
        $purchaseRequest->load(['requestedBy', 'approvedBy', 'items.material']);
        return response()->json([
            'success' => true,
            'purchase_request' => $purchaseRequest
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

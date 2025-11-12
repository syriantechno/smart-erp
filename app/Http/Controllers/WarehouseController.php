<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use App\Services\DocumentCodeGenerator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class WarehouseController extends Controller
{
    public function __construct(private DocumentCodeGenerator $codeGenerator)
    {
    }

    public function index()
    {
        return view('warehouse.index');
    }

    public function previewCode()
    {
        $code = $this->codeGenerator->preview('warehouses');
        return response()->json(['code' => $code]);
    }

    public function datatable(Request $request): JsonResponse
    {
        $baseQuery = Warehouse::query();

        // Apply filters
        if ($request->filled('filter_field') && $request->filled('filter_value')) {
            $field = $request->filter_field;
            $type = $request->filter_type ?? 'contains';
            $value = $request->filter_value;

            if ($field === 'all') {
                $baseQuery->where(function ($q) use ($value) {
                    $q->where('code', 'like', "%{$value}%")
                      ->orWhere('name', 'like', "%{$value}%")
                      ->orWhere('location', 'like', "%{$value}%");
                });
            } else {
                if ($type === 'contains') {
                    $baseQuery->where($field, 'like', "%{$value}%");
                } elseif ($type === 'equals') {
                    $baseQuery->where($field, $value);
                }
            }
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $baseQuery->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $baseQuery->where('is_active', false);
            }
        }

        return DataTables::of($baseQuery)
            ->addColumn('status_badge', function ($warehouse) {
                $badgeClass = $warehouse->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700';
                $statusText = $warehouse->is_active ? 'Active' : 'Inactive';
                return '<span class="px-2 py-1 text-xs font-medium rounded-full ' . $badgeClass . '">' . $statusText . '</span>';
            })
            ->addColumn('actions', function ($warehouse) {
                return view('warehouse.partials.actions', compact('warehouse'))->render();
            })
            ->rawColumns(['status_badge', 'actions'])
            ->make(true);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|unique:warehouses',
            'name' => 'required|string|max:255',
            'location' => 'nullable|string',
            'description' => 'nullable|string',
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

            Warehouse::create($request->all());

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Warehouse created successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create warehouse: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(Warehouse $warehouse): JsonResponse
    {
        return response()->json([
            'success' => true,
            'warehouse' => $warehouse
        ]);
    }

    public function update(Request $request, Warehouse $warehouse): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'code' => ['required', 'string', Rule::unique('warehouses')->ignore($warehouse->id)],
            'name' => 'required|string|max:255',
            'location' => 'nullable|string',
            'description' => 'nullable|string',
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

            $warehouse->update($request->all());

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Warehouse updated successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update warehouse: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Warehouse $warehouse): JsonResponse
    {
        try {
            $warehouse->delete();

            return response()->json([
                'success' => true,
                'message' => 'Warehouse deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete warehouse: ' . $e->getMessage()
            ], 500);
        }
    }
}

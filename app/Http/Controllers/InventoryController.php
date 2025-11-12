<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Warehouse;
use App\Models\Material;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class InventoryController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::active()->select('id', 'name')->get();
        $materials = Material::active()->select('id', 'name')->get();
        return view('warehouse.inventory.index', compact('warehouses', 'materials'));
    }

    public function datatable(Request $request): JsonResponse
    {
        $baseQuery = Inventory::query()
            ->with(['material:id,name,unit', 'warehouse:id,name']);

        // Apply warehouse filter
        if ($request->filled('warehouse_id')) {
            $baseQuery->where('warehouse_id', $request->warehouse_id);
        }

        // Apply material filter
        if ($request->filled('material_id')) {
            $baseQuery->where('material_id', $request->material_id);
        }

        return DataTables::of($baseQuery)
            ->addColumn('material_name', function ($inventory) {
                return $inventory->material ? $inventory->material->name : 'N/A';
            })
            ->addColumn('warehouse_name', function ($inventory) {
                return $inventory->warehouse ? $inventory->warehouse->name : 'N/A';
            })
            ->addColumn('unit', function ($inventory) {
                return $inventory->material ? $inventory->material->unit : 'N/A';
            })
            ->addColumn('actions', function ($inventory) {
                return view('warehouse.inventory.partials.actions', compact('inventory'))->render();
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'material_id' => 'required|exists:materials,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'quantity' => 'required|numeric|min:0',
            'unit_price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $inventory = Inventory::updateOrCreate(
                [
                    'material_id' => $request->material_id,
                    'warehouse_id' => $request->warehouse_id,
                ],
                [
                    'quantity' => $request->quantity,
                    'unit_price' => $request->unit_price,
                ]
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Inventory updated successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update inventory: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(Inventory $inventory): JsonResponse
    {
        $inventory->load(['material', 'warehouse']);
        return response()->json([
            'success' => true,
            'inventory' => $inventory
        ]);
    }

    public function update(Request $request, Inventory $inventory): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric|min:0',
            'unit_price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $inventory->update([
                'quantity' => $request->quantity,
                'unit_price' => $request->unit_price,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Inventory updated successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update inventory: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Inventory $inventory): JsonResponse
    {
        try {
            $inventory->delete();

            return response()->json([
                'success' => true,
                'message' => 'Inventory entry deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete inventory entry: ' . $e->getMessage()
            ], 500);
        }
    }
}

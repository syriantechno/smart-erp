<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Warehouse\Inventory;
use App\Models\Warehouse\Warehouse;
use App\Models\Warehouse\Material;
use App\Services\PdfExporter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class InventoryController extends Controller
{
    public function __construct(private PdfExporter $pdfExporter)
    {
    }
    public function index()
    {
        $warehouses = Warehouse::active()->select('id', 'name')->get();
        $materials = Material::active()->select('id', 'name')->get();

        $inventoryTotal = Inventory::count();
        $distinctMaterials = Inventory::distinct('material_id')->count('material_id');
        $distinctWarehouses = Inventory::distinct('warehouse_id')->count('warehouse_id');
        $totalInventoryValue = Inventory::selectRaw('SUM(quantity * unit_price) as total')->value('total') ?? 0;

        return view('warehouse.inventory.index', compact(
            'warehouses',
            'materials',
            'inventoryTotal',
            'distinctMaterials',
            'distinctWarehouses',
            'totalInventoryValue'
        ));
    }

    public function datatable(Request $request): JsonResponse
    {
        $baseQuery = Inventory::query()
            ->with(['material.unit', 'warehouse:id,name']);

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
                if ($inventory->material && $inventory->material->unit) {
                    $unit = $inventory->material->unit;
                    $name = $unit->name ?? null;
                    $symbol = $unit->symbol ?? null;

                    if ($name && $symbol) {
                        return trim($name . ' (' . $symbol . ')');
                    }

                    return $name ?: ($symbol ?: 'N/A');
                }

                return 'N/A';
            })
            ->addColumn('total_value', function ($inventory) {
                $total = (float) $inventory->quantity * (float) $inventory->unit_price;
                return number_format($total, 2, '.', '');
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
        $user = auth()->user();
        if (!$user || (method_exists($user, 'hasAnyRole') && !$user->hasAnyRole(['admin', 'warehouse_manager']))) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to view this inventory entry.',
            ], 403);
        }

        $inventory->load(['material', 'warehouse']);
        return response()->json([
            'success' => true,
            'inventory' => $inventory
        ]);
    }

    public function update(Request $request, Inventory $inventory): JsonResponse
    {
        $user = auth()->user();
        if (!$user || (method_exists($user, 'hasAnyRole') && !$user->hasAnyRole(['admin', 'warehouse_manager']))) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to update this inventory entry.',
            ], 403);
        }

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

    public function exportPdf(Request $request)
    {
        $inventories = Inventory::with(['material.unit', 'warehouse'])
            ->orderBy('warehouse_id')
            ->orderBy('material_id')
            ->get();

        $totalValue = $inventories->sum(function (Inventory $inventory) {
            return (float) $inventory->quantity * (float) $inventory->unit_price;
        });

        return $this->pdfExporter->stream(
            'warehouse.inventory.export_pdf',
            [
                'inventories' => $inventories,
                'exportedAt' => now(),
                'totalInventoryValue' => $totalValue,
            ],
            'inventory.pdf'
        );
    }

    public function exportExcel()
    {
        $inventories = Inventory::with(['material.unit', 'warehouse'])
            ->orderBy('warehouse_id')
            ->orderBy('material_id')
            ->get();

        $export = new class($inventories) implements \Maatwebsite\Excel\Concerns\FromArray, \Maatwebsite\Excel\Concerns\WithHeadings {
            public function __construct(private $inventories) {}

            public function array(): array
            {
                return $this->inventories->map(function (Inventory $inventory) {
                    $material = $inventory->material;
                    $warehouse = $inventory->warehouse;
                    $unit = $material?->unit;

                    $unitLabel = '';
                    if ($unit) {
                        $name = $unit->name ?? null;
                        $symbol = $unit->symbol ?? null;
                        if ($name && $symbol) {
                            $unitLabel = $name . ' (' . $symbol . ')';
                        } else {
                            $unitLabel = $name ?: ($symbol ?: '');
                        }
                    }

                    $total = (float) $inventory->quantity * (float) $inventory->unit_price;

                    return [
                        'Warehouse' => $warehouse?->name ?? '',
                        'Material' => $material?->name ?? '',
                        'Unit' => $unitLabel,
                        'Quantity' => $inventory->quantity,
                        'Unit Price' => $inventory->unit_price,
                        'Total Value' => $total,
                    ];
                })->toArray();
            }

            public function headings(): array
            {
                return ['Warehouse', 'Material', 'Unit', 'Quantity', 'Unit Price', 'Total Value'];
            }
        };

        return Excel::download($export, 'inventory.xlsx');
    }
}

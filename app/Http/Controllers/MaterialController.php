<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Category;
use App\Services\DocumentCodeGenerator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class MaterialController extends Controller
{
    public function __construct(private DocumentCodeGenerator $codeGenerator)
    {
    }

    public function index()
    {
        $categories = Category::active()->select('id', 'name', 'parent_id')->get();
        return view('warehouse.materials.index', compact('categories'));
    }

    public function previewCode()
    {
        $code = $this->codeGenerator->preview('materials');
        return response()->json(['code' => $code]);
    }

    public function datatable(Request $request): JsonResponse
    {
        $baseQuery = Material::query()
            ->with(['category:id,name']);

        // Apply category filter
        if ($request->filled('category_id')) {
            $categoryId = $request->category_id;
            if ($categoryId === 'all') {
                // No filter
            } else {
                // Get all child categories
                $categoryIds = $this->getCategoryIdsRecursive($categoryId);
                $baseQuery->whereIn('category_id', $categoryIds);
            }
        }

        // Apply other filters
        if ($request->filled('filter_field') && $request->filled('filter_value')) {
            $field = $request->filter_field;
            $type = $request->filter_type ?? 'contains';
            $value = $request->filter_value;

            if ($field === 'all') {
                $baseQuery->where(function ($q) use ($value) {
                    $q->where('code', 'like', "%{$value}%")
                      ->orWhere('name', 'like', "%{$value}%")
                      ->orWhere('description', 'like', "%{$value}%");
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
            ->addColumn('category_name', function ($material) {
                return $material->category ? $material->category->name : 'N/A';
            })
            ->addColumn('status_badge', function ($material) {
                $badgeClass = $material->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700';
                $statusText = $material->is_active ? 'Active' : 'Inactive';
                return '<span class="px-2 py-1 text-xs font-medium rounded-full ' . $badgeClass . '">' . $statusText . '</span>';
            })
            ->addColumn('actions', function ($material) {
                return view('warehouse.materials.partials.actions', compact('material'))->render();
            })
            ->rawColumns(['status_badge', 'actions'])
            ->make(true);
    }

    private function getCategoryIdsRecursive($parentId)
    {
        $ids = [$parentId];
        $children = Category::where('parent_id', $parentId)->pluck('id')->toArray();
        foreach ($children as $childId) {
            $ids = array_merge($ids, $this->getCategoryIdsRecursive($childId));
        }
        return $ids;
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|unique:materials',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'unit' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
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

            Material::create($request->all());

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Material created successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create material: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(Material $material): JsonResponse
    {
        $material->load('category');
        return response()->json([
            'success' => true,
            'material' => $material
        ]);
    }

    public function update(Request $request, Material $material): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'code' => ['required', 'string', Rule::unique('materials')->ignore($material->id)],
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'unit' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
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

            $material->update($request->all());

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Material updated successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update material: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Material $material): JsonResponse
    {
        try {
            $material->delete();

            return response()->json([
                'success' => true,
                'message' => 'Material deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete material: ' . $e->getMessage()
            ], 500);
        }
    }
}

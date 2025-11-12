<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\DocumentCodeGenerator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function __construct(private DocumentCodeGenerator $codeGenerator)
    {
    }

    public function index()
    {
        return view('warehouse.categories.index');
    }

    public function previewCode()
    {
        $code = $this->codeGenerator->preview('categories');
        return response()->json(['code' => $code]);
    }

    public function datatable(Request $request): JsonResponse
    {
        $baseQuery = Category::query()
            ->with(['parent:id,name']);

        return DataTables::of($baseQuery)
            ->addColumn('parent_name', function ($category) {
                return $category->parent ? $category->parent->name : 'Root';
            })
            ->addColumn('status_badge', function ($category) {
                $badgeClass = $category->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700';
                $statusText = $category->is_active ? 'Active' : 'Inactive';
                return '<span class="px-2 py-1 text-xs font-medium rounded-full ' . $badgeClass . '">' . $statusText . '</span>';
            })
            ->addColumn('actions', function ($category) {
                return view('warehouse.categories.partials.actions', compact('category'))->render();
            })
            ->rawColumns(['status_badge', 'actions'])
            ->make(true);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|unique:categories',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
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

            Category::create($request->all());

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Category created successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create category: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(Category $category): JsonResponse
    {
        $category->load('parent');
        return response()->json([
            'success' => true,
            'category' => $category
        ]);
    }

    public function update(Request $request, Category $category): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'code' => ['required', 'string', Rule::unique('categories')->ignore($category->id)],
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
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

            $category->update($request->all());

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Category updated successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update category: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Category $category): JsonResponse
    {
        try {
            $category->delete();

            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete category: ' . $e->getMessage()
            ], 500);
        }
    }
}

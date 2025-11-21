<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use App\Models\Approval\ApprovalTemplate;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ApprovalTemplateController extends Controller
{
    public function index()
    {
        $users = User::select('id', 'name')->orderBy('name')->get();

        $stats = [
            'total' => ApprovalTemplate::count(),
            'active' => ApprovalTemplate::where('is_active', true)->count(),
            'material_request' => ApprovalTemplate::where('type', 'material_request')->count(),
        ];

        $recentTemplates = ApprovalTemplate::latest('updated_at')
            ->take(3)
            ->get(['id', 'name', 'type', 'is_active', 'updated_at']);

        return view('approval-system.templates.index', compact('users', 'stats', 'recentTemplates'));
    }

    public function datatable(Request $request): JsonResponse
    {
        $query = ApprovalTemplate::query();

        if ($request->filled('type')) {
            $query->where('type', $request->string('type'));
        }

        if ($request->filled('filter_status')) {
            if ($request->filter_status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->filter_status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        if ($request->filled('search_value')) {
            $search = trim($request->search_value);
            $query->where(function ($builder) use ($search) {
                $builder->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('levels_count', function ($template) {
                $count = count($template->levels ?? []);
                return '<span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                    <i data-lucide="git-branch" class="w-3.5 h-3.5"></i>
                    ' . $count . ' Levels
                </span>';
            })
            ->addColumn('actions', function ($template) {
                return view('approval-system.templates.partials.actions', compact('template'))->render();
            })
            ->rawColumns(['levels_count', 'actions'])
            ->make(true);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'description' => 'nullable|string',
            'levels' => 'required|array|min:1',
            'levels.*.level' => 'required|integer',
            'levels.*.name' => 'required|string',
            'levels.*.approver_id' => 'required|exists:users,id',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $template = ApprovalTemplate::create([
            'name' => $request->name,
            'type' => $request->type,
            'description' => $request->description,
            'levels' => $request->levels,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Template created successfully',
            'data' => $template
        ]);
    }

    public function show($id): JsonResponse
    {
        $template = ApprovalTemplate::findOrFail($id);
        
        return response()->json($template);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $template = ApprovalTemplate::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'description' => 'nullable|string',
            'levels' => 'required|array|min:1',
            'levels.*.level' => 'required|integer',
            'levels.*.name' => 'required|string',
            'levels.*.approver_id' => 'required|exists:users,id',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $template->update([
            'name' => $request->name,
            'type' => $request->type,
            'description' => $request->description,
            'levels' => $request->levels,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Template updated successfully',
            'data' => $template
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $template = ApprovalTemplate::findOrFail($id);
        
        // Check if template is being used
        if ($template->approvalRequests()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete template that is being used by approval requests'
            ], 422);
        }

        $template->delete();

        return response()->json([
            'success' => true,
            'message' => 'Template deleted successfully'
        ]);
    }
}

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
        $users = User::select('id', 'name')->get();
        
        return view('approval-system.templates.index', compact('users'));
    }

    public function datatable(Request $request): JsonResponse
    {
        $query = ApprovalTemplate::query();

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('levels_count', function ($template) {
                $count = count($template->levels ?? []);
                return '<span class="badge bg-primary">' . $count . ' Levels</span>';
            })
            ->addColumn('status', function ($template) {
                if ($template->is_active) {
                    return '<span class="badge bg-success">Active</span>';
                }
                return '<span class="badge bg-secondary">Inactive</span>';
            })
            ->addColumn('actions', function ($template) {
                return '
                    <div class="flex gap-2">
                        <button onclick="editTemplate(' . $template->id . ')" class="btn btn-sm btn-primary">
                            <i data-lucide="edit" class="w-4 h-4"></i>
                        </button>
                        <button onclick="deleteTemplate(' . $template->id . ')" class="btn btn-sm btn-danger">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </div>
                ';
            })
            ->rawColumns(['levels_count', 'status', 'actions'])
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

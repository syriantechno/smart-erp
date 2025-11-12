<?php

namespace App\Http\Controllers\ProjectManagement;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $companies = \App\Models\Company::active()->get();
        $employees = \App\Models\Employee::active()->get();

        return view('project-management.projects.index', compact('companies', 'employees'));
    }

    /**
     * Get project data for DataTables
     */
    public function datatable(Request $request): JsonResponse
    {
        try {
            Log::info('Project datatable called with params:', $request->all());

            $projects = Project::with(['company', 'department', 'manager'])
                ->select(['id', 'code', 'name', 'company_id', 'department_id', 'manager_id', 'start_date', 'end_date', 'status', 'priority', 'budget', 'progress_percentage', 'is_active', 'created_at']);

            Log::info('Projects query count:', $projects->count());

            return \Yajra\DataTables\Facades\DataTables::of($projects)
                ->addIndexColumn()
                ->orderColumn('DT_RowIndex', 'id $1')
                ->addColumn('company_name', function ($project) {
                    return $project->company?->name ?? 'N/A';
                })
                ->addColumn('department_name', function ($project) {
                    return $project->department?->name ?? 'N/A';
                })
                ->addColumn('manager_name', function ($project) {
                    return $project->manager?->full_name ?? 'N/A';
                })
                ->addColumn('status_badge', function ($project) {
                    $color = $project->status_color;
                    $label = $project->status_label;
                    return '<span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold bg-' . $color . '-100 text-' . $color . '-700">' . $label . '</span>';
                })
                ->addColumn('priority_badge', function ($project) {
                    $color = $project->priority_color;
                    $label = $project->priority_label;
                    return '<span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold bg-' . $color . '-100 text-' . $color . '-700">' . $label . '</span>';
                })
                ->addColumn('budget_formatted', function ($project) {
                    return $project->budget_formatted;
                })
                ->addColumn('duration_days', function ($project) {
                    return $project->duration . ' days';
                })
                ->addColumn('progress_bar', function ($project) {
                    $percentage = $project->progress_percentage;
                    $color = $percentage >= 75 ? 'bg-green-500' : ($percentage >= 50 ? 'bg-yellow-500' : 'bg-red-500');
                    return '<div class="w-full bg-gray-200 rounded-full h-2"><div class="' . $color . ' h-2 rounded-full" style="width: ' . $percentage . '%"></div></div><span class="text-xs text-gray-600">' . $percentage . '%</span>';
                })
                ->addColumn('actions', function ($project) {
                    try {
                        return view('project-management.projects.partials.actions', compact('project'))->render();
                    } catch (\Exception $e) {
                        Log::error('Error rendering actions view:', $e->getMessage());
                        return 'Error: ' . $e->getMessage();
                    }
                })
                ->rawColumns(['status_badge', 'priority_badge', 'progress_bar', 'actions'])
                ->toJson();
        } catch (\Exception $e) {
            Log::error('Project datatable error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'Database error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created project
     */
    public function store(Request $request): JsonResponse
    {
        Log::info('Project store called with data:', $request->all());

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'company_id' => 'required|exists:companies,id',
            'department_id' => 'nullable|exists:departments,id',
            'manager_id' => 'nullable|exists:employees,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'status' => 'required|in:planning,active,on_hold,completed,cancelled',
            'priority' => 'required|in:low,medium,high,critical',
            'budget' => 'nullable|numeric|min:0',
            'progress_percentage' => 'required|integer|min:0|max:100',
            'objectives' => 'nullable|string',
            'deliverables' => 'nullable|string',
            'risks' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            Log::warning('Project validation failed:', $validator->errors()->toArray());
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $project = Project::create([
                'code' => Project::generateUniqueCode(),
                'name' => $request->name,
                'description' => $request->description,
                'company_id' => $request->company_id,
                'department_id' => $request->department_id,
                'manager_id' => $request->manager_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'status' => $request->status,
                'priority' => $request->priority,
                'budget' => $request->budget,
                'progress_percentage' => $request->progress_percentage,
                'objectives' => $request->objectives,
                'deliverables' => $request->deliverables,
                'risks' => $request->risks,
                'notes' => $request->notes,
                'is_active' => true
            ]);

            Log::info('Project created successfully:', $project->toArray());

            return response()->json([
                'success' => true,
                'message' => 'Project created successfully',
                'data' => $project
            ]);
        } catch (\Exception $e) {
            Log::error('Project creation failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to create project',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update project status
     */
    public function updateStatus(Request $request, Project $project): JsonResponse
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'status' => 'required|in:planning,active,on_hold,completed,cancelled',
            'progress_percentage' => 'nullable|integer|min:0|max:100',
            'actual_end_date' => 'nullable|date',
            'actual_cost' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $updateData = [
                'status' => $request->status,
                'notes' => $request->notes
            ];

            if ($request->has('progress_percentage')) {
                $updateData['progress_percentage'] = $request->progress_percentage;
            }

            if ($request->has('actual_end_date')) {
                $updateData['actual_end_date'] = $request->actual_end_date;
            }

            if ($request->has('actual_cost')) {
                $updateData['actual_cost'] = $request->actual_cost;
            }

            $project->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Project status updated successfully',
                'data' => $project
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update project status',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get project statistics
     */
    public function stats(Request $request): JsonResponse
    {
        try {
            $stats = [
                'total_projects' => Project::active()->count(),
                'planning' => Project::active()->where('status', 'planning')->count(),
                'active' => Project::active()->where('status', 'active')->count(),
                'on_hold' => Project::active()->where('status', 'on_hold')->count(),
                'completed' => Project::active()->where('status', 'completed')->count(),
                'cancelled' => Project::active()->where('status', 'cancelled')->count(),
                'overdue' => Project::active()->where('end_date', '<', now())->whereNotIn('status', ['completed', 'cancelled'])->count(),
                'total_budget' => Project::active()->sum('budget'),
                'average_progress' => Project::active()->avg('progress_percentage'),
            ];

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get project stats',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export project data
     */
    public function export(Request $request): JsonResponse
    {
        try {
            $projects = Project::active()
                ->with(['company', 'department', 'manager'])
                ->get();

            $csvData = [];
            $csvData[] = ['Code', 'Name', 'Company', 'Department', 'Manager', 'Status', 'Priority', 'Start Date', 'End Date', 'Budget', 'Progress'];

            foreach ($projects as $project) {
                $csvData[] = [
                    $project->code,
                    $project->name,
                    $project->company?->name ?? 'N/A',
                    $project->department?->name ?? 'N/A',
                    $project->manager?->full_name ?? 'N/A',
                    $project->status_label,
                    $project->priority_label,
                    $project->start_date->format('Y-m-d'),
                    $project->end_date ? $project->end_date->format('Y-m-d') : 'N/A',
                    $project->budget ?? 0,
                    $project->progress_percentage . '%'
                ];
            }

            return response()->json([
                'success' => true,
                'message' => 'Project data exported successfully',
                'data' => $csvData
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to export project data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

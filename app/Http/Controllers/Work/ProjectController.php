<?php

namespace App\Http\Controllers\Work;

use App\Http\Controllers\Controller;
use App\Models\Work\Project;
use App\Models\Setting\Company;
use App\Models\HR\Department;
use App\Models\HR\Employee;
use App\Models\User;
use App\Services\DocumentCodeGenerator;
use App\Services\Notifications\NotificationDispatcher;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    public function __construct(private DocumentCodeGenerator $codeGenerator)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $companies = Company::active()->get();
        $departments = Department::all();
        $employees = Employee::active()->get();

        // Get some basic stats for the dashboard
        $projects = Project::active()->latest()->get();
        $stats = [
            'total' => $projects->count(),
            'active' => $projects->where('status', 'active')->count(),
            'completed' => $projects->where('status', 'completed')->count(),
            'overdue' => $projects->where('end_date', '<', now())->whereNotIn('status', ['completed'])->count(),
        ];

        return view('work.projects.index', compact('companies', 'departments', 'employees', 'projects', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $companies = Company::active()->get();
        $departments = Department::all();
        $employees = Employee::active()->get();

        if (request()->ajax()) {
            return view('work.projects.partials.create-modal', compact('companies', 'departments', 'employees'));
        }

        return view('work.projects.create', compact('companies', 'departments', 'employees'));
    }

    public function show(Project $project): View
    {
        $project->load(['company', 'department', 'manager', 'tasks']);

        return view('work.projects.show', compact('project'));
    }

    public function edit(Project $project): View
    {
        $companies = Company::active()->get();
        $departments = Department::all();
        $employees = Employee::active()->get();

        return view('work.projects.edit', compact('project', 'companies', 'departments', 'employees'));
    }

    public function update(Request $request, Project $project): JsonResponse
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'code' => 'required|string|unique:projects,code,' . $project->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'company_id' => 'required|exists:companies,id',
            'department_id' => 'nullable|exists:departments,id',
            'manager_id' => 'nullable|exists:employees,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'actual_end_date' => 'nullable|date',
            'status' => 'required|in:planning,active,on_hold,completed,cancelled',
            'priority' => 'required|in:low,medium,high,critical',
            'budget' => 'nullable|numeric|min:0',
            'actual_cost' => 'nullable|numeric|min:0',
            'progress_percentage' => 'required|integer|min:0|max:100',
            'objectives' => 'nullable|string',
            'deliverables' => 'nullable|string',
            'risks' => 'nullable|string',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            Log::warning('Project update validation failed:', $validator->errors()->toArray());
            notify_error('يرجى تصحيح الأخطاء في البيانات المدخلة', 'خطأ في البيانات');
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $project->update($request->validated());

            Log::info('Project updated successfully:', $project->toArray());

            notify_updated('المشروع');

            return response()->json([
                'success' => true,
                'message' => 'Project updated successfully',
                'data' => $project
            ]);
        } catch (\Exception $e) {
            Log::error('Project update failed:', [
                'project_id' => $project->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            notify_error_code(1001, 'فشل في تحديث المشروع');

            return response()->json([
                'success' => false,
                'message' => 'Failed to update project',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get project data for DataTables
     */
    public function datatable(Request $request): JsonResponse
    {
        $baseQuery = Project::query()
            ->with(['company:id,name', 'department:id,name', 'manager:id,first_name,last_name']);

        // Apply filters
        if ($request->filled('company_id') && $request->company_id !== '') {
            $baseQuery->where('company_id', $request->company_id);
        }

        if ($request->filled('department_id') && $request->department_id !== '') {
            $baseQuery->where('department_id', $request->department_id);
        }

        if ($request->filled('status') && $request->status !== '') {
            $baseQuery->where('status', $request->status);
        }

        return \Yajra\DataTables\Facades\DataTables::of($baseQuery)
            ->addIndexColumn()
            ->addColumn('code', function ($project) {
                return '<a href="' . route('project-management.projects.show', $project->id) . '" class="font-medium text-primary hover:underline">' . e($project->code) . '</a>';
            })
            ->addColumn('name', function ($project) {
                return '<a href="' . route('project-management.projects.show', $project->id) . '" class="font-medium hover:text-primary">' . e($project->name) . '</a>';
            })
            ->addColumn('company_department', function ($project) {
                $company = $project->company ? e($project->company->name) : 'N/A';
                $department = $project->department ? e($project->department->name) : 'No Department';
                return '<div class="leading-tight">' . $company . '<span class="mt-0.5 block text-xs text-slate-500">' . $department . '</span></div>';
            })
            ->addColumn('manager', function ($project) {
                return $project->manager ? e($project->manager->first_name . ' ' . $project->manager->last_name) : '<span class="text-slate-400">Unassigned</span>';
            })
            ->addColumn('status', function ($project) {
                $statusClasses = [
                    'planning' => 'stats-card-info',
                    'active' => 'stats-card-warning', 
                    'on_hold' => 'stats-card-neutral',
                    'completed' => 'stats-card-success',
                    'cancelled' => 'stats-card-danger'
                ];
                $statusClass = $statusClasses[$project->status] ?? 'stats-card-neutral';
                $statusLabel = ucfirst(str_replace('_', ' ', $project->status));
                return '<span class="' . $statusClass . ' px-3 py-1 rounded-full text-xs font-medium">' . $statusLabel . '</span>';
            })
            ->addColumn('priority', function ($project) {
                $priorityClasses = [
                    'low' => 'stats-card-neutral',
                    'medium' => 'stats-card-info',
                    'high' => 'stats-card-warning',
                    'critical' => 'stats-card-danger'
                ];
                $priorityClass = $priorityClasses[$project->priority] ?? 'stats-card-neutral';
                $priorityLabel = ucfirst($project->priority);
                return '<span class="' . $priorityClass . ' px-2 py-1 rounded-full text-xs font-medium">' . $priorityLabel . '</span>';
            })
            ->addColumn('progress_percentage', function ($project) {
                $percentage = $project->progress_percentage ?? 0;
                $progressColor = $percentage >= 75 ? '#1b7a4a' : ($percentage >= 50 ? '#c98028' : '#b21a50');
                return '<div class="flex flex-col items-center"><div class="w-full bg-slate-200 rounded-full h-2 mb-1"><div class="h-2 rounded-full transition-all duration-300" style="width: ' . $percentage . '%; background: ' . $progressColor . ';"></div></div><span class="text-xs font-medium">' . $percentage . '%</span></div>';
            })
            ->addColumn('actions', function ($project) {
                return '<div class="flex items-center justify-center gap-2">' .
                    '<a href="' . route('project-management.projects.show', $project->id) . '" class="btn-tonal btn-tonal--info btn-tonal--icon" title="View">' .
                    '<i data-lucide="eye" class="w-4 h-4"></i></a>' .
                    '<a href="' . route('project-management.projects.edit', $project->id) . '" class="btn-tonal btn-tonal--warning btn-tonal--icon" title="Edit">' .
                    '<i data-lucide="edit" class="w-4 h-4"></i></a>' .
                    '<button onclick="deleteProject(' . $project->id . ', \'' . addslashes($project->name) . '\')" class="btn-tonal btn-tonal--danger btn-tonal--icon" title="Delete">' .
                    '<i data-lucide="trash-2" class="w-4 h-4"></i></button></div>';
            })
            ->rawColumns(['code', 'name', 'company_department', 'manager', 'status', 'priority', 'progress_percentage', 'actions'])
            ->make(true);
    }

    /**
     * Preview project code
     */
    public function previewCode(): JsonResponse
    {
        Log::info('=== PREVIEW CODE START ===');
        Log::info('Preview code called for projects');
        
        try {
            // Check existing settings
            $allSettings = \App\Models\Setting\PrefixSetting::all();
            Log::info('All prefix settings count: ' . $allSettings->count());
            foreach($allSettings as $setting) {
                Log::info('Setting: ' . $setting->document_type . ' -> ' . $setting->prefix . ' (active: ' . ($setting->is_active ? 'yes' : 'no') . ')');
            }
            
            // Ensure projects prefix setting exists
            $setting = \App\Models\Setting\PrefixSetting::where('document_type', 'projects')->first();
            Log::info('Projects setting found: ' . ($setting ? 'YES' : 'NO'));
            
            if (!$setting) {
                Log::info('Creating projects prefix setting...');
                $setting = \App\Models\Setting\PrefixSetting::create([
                    'document_type' => 'projects',
                    'prefix' => 'PRJ',
                    'padding' => 4,
                    'start_number' => 1,
                    'current_number' => 1,
                    'include_year' => false,
                    'is_active' => true,
                ]);
                Log::info('Projects prefix setting created successfully with ID: ' . $setting->id);
                
                // Verify creation
                $verifySetting = \App\Models\Setting\PrefixSetting::where('document_type', 'projects')->first();
                Log::info('Verification after creation: ' . ($verifySetting ? 'SUCCESS' : 'FAILED'));
            } else {
                Log::info('Using existing setting - ID: ' . $setting->id . ', Current: ' . $setting->current_number);
            }
            
            $code = $this->codeGenerator->preview('projects');
            Log::info('Generated preview code:', ['code' => $code]);
            
            Log::info('=== PREVIEW CODE END ===');
            
            return response()->json([
                'success' => true,
                'code' => $code,
                'debug' => [
                    'setting_created' => !$setting->wasRecentlyCreated ?? false,
                    'current_number' => $setting->current_number ?? null
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('=== PREVIEW CODE ERROR ===');
            Log::error('Error generating preview code:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate preview code: ' . $e->getMessage()
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
            'progress_percentage' => 'nullable|integer|min:0|max:100',
            'objectives' => 'nullable|string',
            'deliverables' => 'nullable|string',
            'risks' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            Log::warning('Project validation failed:', $validator->errors()->toArray());
            notify_error('يرجى تصحيح الأخطاء في البيانات المدخلة', 'خطأ في البيانات');
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Ensure projects prefix setting exists
            $setting = \App\Models\Setting\PrefixSetting::where('document_type', 'projects')->first();
            
            if (!$setting) {
                $setting = \App\Models\Setting\PrefixSetting::create([
                    'document_type' => 'projects',
                    'prefix' => 'PRJ',
                    'padding' => 4,
                    'start_number' => 1,
                    'current_number' => 1,
                    'include_year' => false,
                    'is_active' => true,
                ]);
            }
            
            $project = Project::create([
                'code' => $this->codeGenerator->generate('projects'),
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

            // Notify project team
            $projectManagers = User::whereHas('roles', fn($q) => $q->whereIn('name', ['admin', 'project_manager']))->pluck('id')->toArray();
            if (!empty($projectManagers)) {
                NotificationDispatcher::toUsers(
                    $projectManagers,
                    'project.created',
                    'New Project Created',
                    "Project '{$project->name}' ({$project->code}) has been created.",
                    route('project-management.projects.show', $project->id),
                    'folder-plus',
                    ['type' => 'info', 'actor_id' => auth()->id()]
                );
            }

            // Notify assigned manager
            if ($project->manager_id && $project->manager && $project->manager->user_id) {
                NotificationDispatcher::toUser(
                    $project->manager->user_id,
                    'project.assigned',
                    'Project Assigned to You',
                    "You have been assigned as manager for project '{$project->name}'.",
                    route('project-management.projects.show', $project->id),
                    'briefcase',
                    ['type' => 'info', 'actor_id' => auth()->id()]
                );
            }

            notify_created('المشروع');

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

            notify_error_code(1002, 'فشل في إنشاء المشروع');

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
            notify_validation_errors($validator->errors());
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

            notify_updated('حالة المشروع');

            return response()->json([
                'success' => true,
                'message' => 'Project status updated successfully',
                'data' => $project
            ]);
        } catch (\Exception $e) {
            Log::error('Project status update failed:', [
                'project_id' => $project->id,
                'error' => $e->getMessage()
            ]);

            notify_error_code(1003, 'فشل في تحديث حالة المشروع');

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

            notify_exported('بيانات المشاريع');

            return response()->json([
                'success' => true,
                'message' => 'Project data exported successfully',
                'data' => $csvData
            ]);

        } catch (\Exception $e) {
            Log::error('Project export failed:', $e->getMessage());

            notify_error_code(5003, 'فشل في تصدير بيانات المشاريع');

            return response()->json([
                'success' => false,
                'message' => 'Failed to export project data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Debug prefix settings
     */
    public function debugPrefix(): JsonResponse
    {
        try {
            $allSettings = \App\Models\Setting\PrefixSetting::all();
            $projectsSetting = \App\Models\Setting\PrefixSetting::where('document_type', 'projects')->first();
            
            return response()->json([
                'success' => true,
                'total_settings' => $allSettings->count(),
                'all_settings' => $allSettings->map(function($setting) {
                    return [
                        'id' => $setting->id,
                        'document_type' => $setting->document_type,
                        'prefix' => $setting->prefix,
                        'current_number' => $setting->current_number,
                        'is_active' => $setting->is_active,
                    ];
                }),
                'projects_setting' => $projectsSetting ? [
                    'id' => $projectsSetting->id,
                    'document_type' => $projectsSetting->document_type,
                    'prefix' => $projectsSetting->prefix,
                    'current_number' => $projectsSetting->current_number,
                    'is_active' => $projectsSetting->is_active,
                ] : null,
                'projects_setting_exists' => $projectsSetting ? true : false
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function destroy(Project $project): JsonResponse
    {
        try {
            // Check if project has related data that prevents deletion
            if ($project->tasks()->exists() || $project->timeLogs()->exists()) {
                notify_error_code(6001, 'لا يمكن حذف المشروع لوجود بيانات مرتبطة به');
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete project with related data'
                ], 422);
            }

            $projectName = $project->name;
            $project->delete();

            Log::info('Project deleted successfully:', ['name' => $projectName]);

            notify_deleted('المشروع');

            return response()->json([
                'success' => true,
                'message' => 'Project deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Project deletion failed:', [
                'project_id' => $project->id,
                'error' => $e->getMessage()
            ]);

            notify_error_code(1004, 'فشل في حذف المشروع');

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete project',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}

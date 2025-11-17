<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Company;
use App\Services\DocumentCodeGenerator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Exports\TasksExport;
use Yajra\DataTables\Facades\DataTables;

class TaskController extends Controller
{
    public function __construct(private DocumentCodeGenerator $codeGenerator)
    {
    }

    public function index()
    {
        $companies = Company::where('is_active', true)->select('id', 'name')->get();
        $departments = Department::where('is_active', true)->select('id', 'name')->get();
        $employees = Employee::where('is_active', true)->select('id', 'first_name', 'last_name')->get();

        return view('tasks.index', compact('companies', 'departments', 'employees'));
    }

    public function previewCode()
    {
        $code = $this->codeGenerator->preview('tasks');
        return response()->json(['code' => $code]);
    }

    public function datatable(Request $request): JsonResponse
    {
        $baseQuery = Task::query()
            ->with(['employee:id,first_name,last_name', 'department:id,name', 'company:id,name']);

        // Apply filters
        if ($request->filled('filter_field') && $request->filled('filter_value')) {
            $field = $request->filter_field;
            $type = $request->filter_type ?? 'contains';
            $value = $request->filter_value;

            if ($field === 'all') {
                $baseQuery->where(function ($query) use ($value, $type) {
                    $query->where('code', $type === 'equals' ? '=' : 'like', $type === 'equals' ? $value : "%{$value}%")
                          ->orWhere('title', $type === 'equals' ? '=' : 'like', $type === 'equals' ? $value : "%{$value}%")
                          ->orWhere('description', $type === 'equals' ? '=' : 'like', $type === 'equals' ? $value : "%{$value}%");
                });
            } else {
                $operator = $type === 'equals' ? '=' : 'like';
                $searchValue = $type === 'equals' ? $value : "%{$value}%";
                $baseQuery->where($field, $operator, $searchValue);
            }
        }

        // Apply advanced filters
        if ($request->filled('company_id') && $request->company_id !== '') {
            $baseQuery->where('company_id', $request->company_id);
        }

        if ($request->filled('department_id') && $request->department_id !== '') {
            $baseQuery->where('department_id', $request->department_id);
        }

        if ($request->filled('employee_id') && $request->employee_id !== '') {
            $baseQuery->where('employee_id', $request->employee_id);
        }

        if ($request->filled('status_filter') && $request->status_filter !== '') {
            $baseQuery->where('status', '=', $request->status_filter);
        }

        if ($request->filled('priority_filter') && $request->priority_filter !== '') {
            $baseQuery->where('priority', '=', $request->priority_filter);
        }

        return DataTables::of($baseQuery)
            ->addIndexColumn()
            ->addColumn('code', function ($task) {
                return $task->code ?? '-';
            })
            ->addColumn('title', function ($task) {
                return $task->title;
            })
            ->addColumn('employee_name', function ($task) {
                return $task->employee ? $task->employee->full_name : '-';
            })
            ->addColumn('department_name', function ($task) {
                return $task->department ? $task->department->name : '-';
            })
            ->addColumn('priority', function ($task) {
                $priorityClass = $task->getPriorityBadgeClass();
                return "<span class=\"inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {$priorityClass}\">{$task->priority}</span>";
            })
            ->addColumn('status', function ($task) {
                $statusClass = $task->getStatusBadgeClass();
                $statusLabel = ucfirst(str_replace('_', ' ', $task->status));
                return "<span class=\"inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {$statusClass}\">{$statusLabel}</span>";
            })
            ->addColumn('due_date_formatted', function ($task) {
                return $task->due_date ? $task->due_date->format('M d, Y') : '-';
            })
            ->addColumn('actions', function ($task) {
                return view('tasks.partials.actions', ['task' => $task])->render();
            })
            ->rawColumns(['status', 'priority', 'actions'])
            ->make(true);
    }

    public function create()
    {
        $departments = Department::where('is_active', true)->get();
        $companies = Company::where('is_active', true)->get();
        $employees = Employee::where('is_active', true)->get();
        return view('tasks.create', compact('departments', 'companies', 'employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'color' => 'nullable|string|max:32',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'due_date' => 'nullable|date',
            'employee_id' => 'nullable|exists:employees,id',
            'department_id' => 'nullable|exists:departments,id',
            'company_id' => 'nullable|exists:companies,id',
            'project_id' => 'nullable|exists:projects,id',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            DB::beginTransaction();

            $validated['code'] = $this->codeGenerator->generate('tasks');
            $validated['assigned_by'] = auth()->id();
            $validated['is_active'] = $request->boolean('is_active', true);

            Task::create($validated);

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Task created successfully',
                ]);
            }

            return redirect()->route('tasks.index')
                ->with('success', 'تم إضافة المهمة بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error creating task: ' . $e->getMessage(),
                ], 500);
            }

            return back()->with('error', 'Error creating task: ' . $e->getMessage());
        }
    }

    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $departments = Department::where('is_active', true)->get();
        $companies = Company::where('is_active', true)->get();
        $employees = Employee::where('is_active', true)->get();
        return view('tasks.edit', compact('task', 'departments', 'companies', 'employees'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'due_date' => 'nullable|date',
            'employee_id' => 'nullable|exists:employees,id',
            'department_id' => 'nullable|exists:departments,id',
            'company_id' => 'nullable|exists:companies,id',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            DB::beginTransaction();

            $validated['is_active'] = $request->boolean('is_active', true);

            $task->update($validated);

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Task updated successfully',
                ]);
            }

            return redirect()->route('tasks.index')
                ->with('success', 'تم تحديث المهمة بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error updating task: ' . $e->getMessage(),
                ], 500);
            }

            return back()->with('error', 'Error updating task: ' . $e->getMessage());
        }
    }

    public function destroy(Task $task, Request $request)
    {
        try {
            DB::beginTransaction();

            $task->delete();

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Task deleted successfully',
                ]);
            }

            return redirect()->route('tasks.index')
                ->with('success', 'تم حذف المهمة بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error deleting task: ' . $e->getMessage(),
                ], 500);
            }

            return back()->with('error', 'Error deleting task: ' . $e->getMessage());
        }
    }

    public function kanbanData(Request $request): JsonResponse
    {
        $query = Task::query()
            ->with(['employee:id,first_name,last_name', 'department:id,name', 'company:id,name']);

        if ($request->filled('company_id') && $request->company_id !== '') {
            $query->where('company_id', $request->company_id);
        }

        if ($request->filled('department_id') && $request->department_id !== '') {
            $query->where('department_id', $request->department_id);
        }

        if ($request->filled('employee_id') && $request->employee_id !== '') {
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->filled('status_filter') && $request->status_filter !== '') {
            $query->where('status', $request->status_filter);
        }

        $tasks = $query
            ->orderByRaw("FIELD(status, 'pending', 'in_progress', 'completed', 'cancelled')")
            ->orderBy('priority', 'desc')
            ->orderBy('due_date', 'asc')
            ->get();

        $grouped = [
            'pending' => [],
            'in_progress' => [],
            'completed' => [],
            'cancelled' => [],
        ];

        foreach ($tasks as $task) {
            $status = $task->status ?? 'pending';
            if (! isset($grouped[$status])) {
                $grouped[$status] = [];
            }

            $grouped[$status][] = [
                'id' => $task->id,
                'code' => $task->code,
                'title' => $task->title,
                'description' => $task->description,
                'priority' => $task->priority,
                'status' => $task->status,
                'color' => $task->color,
                'due_date' => $task->due_date ? $task->due_date->format('Y-m-d') : null,
                'due_date_formatted' => $task->due_date ? $task->due_date->format('M d, Y') : null,
                'employee_name' => $task->employee ? $task->employee->full_name : null,
                'department_name' => $task->department ? $task->department->name : null,
                'company_name' => $task->company ? $task->company->name : null,
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $grouped,
        ]);
    }

    public function updateStatus(Request $request, Task $task): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'status' => ['required', Rule::in(['pending', 'in_progress', 'completed', 'cancelled'])],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid status value',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            DB::beginTransaction();

            $task->status = $request->input('status');
            $task->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Task status updated successfully',
                'task' => [
                    'id' => $task->id,
                    'status' => $task->status,
                ],
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error updating task status: ' . $e->getMessage(),
            ], 500);
        }
    }
}

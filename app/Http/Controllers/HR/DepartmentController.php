<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Services\DocumentCodeGenerator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\NotificationHelper;

class DepartmentController extends Controller
{
    public function __construct(private DocumentCodeGenerator $codeGenerator)
    {
    }

    public function index()
    {
        $departments = Department::with(['manager', 'parent', 'employees'])->get();
        return view('hr.departments.index', compact('departments'));
    }

    public function create()
    {
        $departments = Department::where('is_active', true)->get();
        return view('hr.departments.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'manager_id' => 'nullable|exists:employees,id',
            'parent_id' => [
                'nullable',
                Rule::exists('departments', 'id')
                    ->where('company_id', request('company_id'))
            ],
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        try {
            DB::beginTransaction();

            $validated['code'] = $this->codeGenerator->generate('department');

            $department = Department::create($validated);
            DB::commit();

            // Send notification
            \App\Http\Controllers\NotificationController::departmentCreated($department);

            if ($request->ajax()) {
                notify_created('Department');
                return response()->json([
                    'success' => true,
                    'message' => 'Department created successfully',
                    'redirect' => route('hr.departments.index')
                ]);
            }

            notify_created('Department');
            return redirect()->route('hr.departments.index');

        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->ajax()) {
                notify_error_code(1002, 'Failed to create department');
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create department: ' . $e->getMessage()
                ], 500);
            }
            
            notify_error_code(1002, 'Failed to create department');
            return back()->with('error', 'Failed to create department: ' . $e->getMessage());
        }
    }

    public function getByCompany($companyId)
    {
        $departments = Department::where('company_id', $companyId)
            ->where('is_active', true)
            ->get();

        return response()->json($departments);
    }
    
    /**
     * Get departments for DataTable
     */
    public function datatable(Request $request)
    {
        $draw = intval($request->input('draw'));
        $length = intval($request->input('length', 10));
        $start = intval($request->input('start', 0));
        $searchValue = $request->input('search.value');

        $baseQuery = Department::query()
            ->with(['company', 'manager'])
            ->withCount('employees');

        $recordsTotal = (clone $baseQuery)->count();

        if (!empty($searchValue)) {
            $baseQuery->where(function ($query) use ($searchValue) {
                $query->where('name', 'like', "%{$searchValue}%")
                    ->orWhereHas('company', function ($companyQuery) use ($searchValue) {
                        $companyQuery->where('name', 'like', "%{$searchValue}%");
                    })
                    ->orWhereHas('manager', function ($managerQuery) use ($searchValue) {
                        $managerQuery->where('full_name', 'like', "%{$searchValue}%");
                    });
            });
        }

        $recordsFiltered = (clone $baseQuery)->count();

        $orderColumnIndex = $request->input('order.0.column', 1);
        $orderDirection = $request->input('order.0.dir', 'asc');
        $orderableColumns = [
            0 => 'id',
            1 => 'name',
            2 => 'company_name',
            3 => 'manager_name',
            4 => 'employees_count',
            5 => 'is_active',
        ];

        $orderColumn = $orderableColumns[$orderColumnIndex] ?? 'name';

        if ($orderColumn === 'company_name') {
            $baseQuery->leftJoin('companies', 'departments.company_id', '=', 'companies.id')
                ->orderBy('companies.name', $orderDirection)
                ->select('departments.*');
        } elseif ($orderColumn === 'manager_name') {
            $baseQuery->leftJoin('employees', 'departments.manager_id', '=', 'employees.id')
                ->orderBy('employees.full_name', $orderDirection)
                ->select('departments.*');
        } else {
            $baseQuery->orderBy($orderColumn, $orderDirection);
        }

        $departments = $baseQuery
            ->skip($start)
            ->take($length)
            ->get();

        $data = $departments->map(function (Department $department, $index) use ($start) {
            return [
                'DT_RowIndex' => $start + $index + 1,
                'code' => $department->code,
                'name' => $department->name,
                'company' => [
                    'name' => optional($department->company)->name,
                ],
                'manager' => [
                    'full_name' => optional($department->manager)->full_name,
                ],
                'employees_count' => $department->employees_count,
                'is_active' => (bool) $department->is_active,
                'actions' => view('hr.departments.partials.actions', ['department' => $department])->render(),
            ];
        })->values();

        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }

    public function previewCode(): JsonResponse
    {
        $code = $this->codeGenerator->preview('department');

        return response()->json([
            'code' => $code,
        ]);
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:departments,id|not_in:' . $department->id,
            'manager_id' => 'nullable|exists:employees,id'
        ]);

        $department->update($validated);

        \App\Http\Controllers\NotificationController::departmentUpdated($department);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Department updated successfully'
            ]);
        }

        return redirect()->route('hr.departments.index')
            ->with('success', 'Department updated successfully');
    }

    public function destroy(Department $department)
    {
        try {
            DB::beginTransaction();

            if ($department->children()->exists()) {
                $message = 'Cannot delete department because it has sub-departments.';
                if (request()->ajax()) {
                    notify_error_code(6001, 'Cannot delete department with sub-departments');
                    return response()->json([
                        'success' => false,
                        'message' => $message
                    ], 400);
                }
                notify_error_code(6001, 'Cannot delete department with sub-departments');
                return back();
            }
            
            if ($department->employees()->exists()) {
                $message = 'Cannot delete department because it has employees.';
                if (request()->ajax()) {
                    notify_error_code(6001, 'Cannot delete department with employees');
                    return response()->json([
                        'success' => false,
                        'message' => $message
                    ], 400);
                }
                notify_error_code(6001, 'Cannot delete department with employees');
                return back();
            }

            $departmentName = $department->name;
            $department->delete();

            DB::commit();

            if (request()->ajax()) {
                \App\Http\Controllers\NotificationController::departmentDeleted($department);
                return response()->json([
                    'success' => true,
                    'message' => 'Department deleted successfully'
                ]);
            }

            \App\Http\Controllers\NotificationController::departmentDeleted($department);
            return redirect()->route('hr.departments.index')
                ->with('success', 'Department deleted successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            
            if (request()->ajax()) {
                notify_error_code(1004, 'Failed to delete department');
                return response()->json([
                    'success' => false,
                    'message' => 'Error deleting department: ' . $e->getMessage()
                ], 500);
            }
            
            notify_error_code(1004, 'Failed to delete department');
            return back()->with('error', 'Error deleting department: ' . $e->getMessage());
        }
    }
}

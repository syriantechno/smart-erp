<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\ApprovalRequest;
use App\Models\ApprovalTemplate;
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
            
            // Try to find a default approval template for department creation
            $template = ApprovalTemplate::active()
                ->where('entity_type', Department::class)
                ->where('action_type', 'create')
                ->first();

            // If there is a template, keep department inactive until fully approved
            if ($template) {
                $validated['is_active'] = false;
            }

            $department = Department::create($validated);

            // If we have a template, create an approval request for this department
            if ($template) {
                $levels = $template->buildLevels();
                $firstApproverId = $levels[0]['approver_id'] ?? null;

                $approvalRequest = ApprovalRequest::create([
                    'code' => $this->codeGenerator->generate('approval_requests'),
                    'title' => 'Department Creation: ' . $department->name,
                    'description' => 'Approval workflow for creating department ' . $department->name,
                    'type' => 'other',
                    'priority' => 'normal',
                    'request_data' => [
                        'department_id' => $department->id,
                        'company_id' => $department->company_id,
                        'requested_by' => auth()->id(),
                    ],
                    'requester_id' => auth()->id(),
                    'current_approver_id' => $firstApproverId,
                    'department_id' => $department->id,
                    'company_id' => $department->company_id,
                    'approval_template_id' => $template->id,
                    'approval_levels' => $levels,
                    'current_level' => 1,
                    'status' => 'pending',
                    'approvable_type' => Department::class,
                    'approvable_id' => $department->id,
                ]);

                // Log submission
                $approvalRequest->logs()->create([
                    'action' => 'submitted',
                    'user_id' => auth()->id(),
                ]);

                if ($firstApproverId) {
                    \App\Http\Controllers\NotificationController::sendToUser(
                        $firstApproverId,
                        'Approval Request Pending',
                        'You have a new approval request pending your action.',
                        'info',
                        route('approval-system.index', ['tab' => 'pending-approval'])
                    );
                }
            } else {
                // No template configured: behave as before and create department directly
                \App\Http\Controllers\NotificationController::departmentCreated($department);
            }

            DB::commit();

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
                        $managerQuery->whereRaw(
                            "CONCAT(IFNULL(first_name, ''), ' ', IFNULL(middle_name, ''), ' ', IFNULL(last_name, '')) LIKE ?",
                            ["%{$searchValue}%"]
                        );
                    });
            });
        }

        $filterField = $request->input('filter_field', 'all');
        $filterType = $request->input('filter_type', 'contains');
        $filterValue = $request->input('filter_value');

        if ($filterValue !== null && $filterValue !== '') {
            $comparison = $filterType === 'equals' ? '=' : 'like';
            $value = $filterType === 'equals' ? $filterValue : "%{$filterValue}%";

            switch ($filterField) {
                case 'name':
                    $baseQuery->where('name', $comparison, $value);
                    break;

                case 'company':
                    $baseQuery->whereHas('company', function ($companyQuery) use ($comparison, $value) {
                        $companyQuery->where('name', $comparison, $value);
                    });
                    break;

                case 'manager':
                    $baseQuery->whereHas('manager', function ($managerQuery) use ($filterType, $filterValue) {
                        if ($filterType === 'equals') {
                            $managerQuery->whereRaw(
                                "TRIM(CONCAT(IFNULL(first_name, ''), ' ', IFNULL(middle_name, ''), ' ', IFNULL(last_name, ''))) = ?",
                                [$filterValue]
                            );
                        } else {
                            $managerQuery->whereRaw(
                                "CONCAT(IFNULL(first_name, ''), ' ', IFNULL(middle_name, ''), ' ', IFNULL(last_name, '')) LIKE ?",
                                ["%{$filterValue}%"]
                            );
                        }
                    });
                    break;

                case 'employees_count':
                    if (is_numeric($filterValue)) {
                        if ($filterType === 'equals') {
                            $baseQuery->having('employees_count', '=', (int) $filterValue);
                        } else {
                            $baseQuery->having('employees_count', '>=', (int) $filterValue);
                        }
                    }
                    break;

                case 'status':
                    $normalized = strtolower(trim($filterValue));
                    if (in_array($normalized, ['active', '1', 'true', 'enabled'])) {
                        $baseQuery->where('is_active', true);
                    } elseif (in_array($normalized, ['inactive', '0', 'false', 'disabled'])) {
                        $baseQuery->where('is_active', false);
                    }
                    break;

                case 'all':
                default:
                    $baseQuery->where(function ($query) use ($comparison, $value, $filterType, $filterValue) {
                        $query->where('name', $comparison, $value)
                            ->orWhereHas('company', function ($companyQuery) use ($comparison, $value) {
                                $companyQuery->where('name', $comparison, $value);
                            })
                            ->orWhereHas('manager', function ($managerQuery) use ($filterType, $filterValue) {
                                if ($filterType === 'equals') {
                                    $managerQuery->whereRaw(
                                        "TRIM(CONCAT(IFNULL(first_name, ''), ' ', IFNULL(middle_name, ''), ' ', IFNULL(last_name, ''))) = ?",
                                        [$filterValue]
                                    );
                                } else {
                                    $managerQuery->whereRaw(
                                        "CONCAT(IFNULL(first_name, ''), ' ', IFNULL(middle_name, ''), ' ', IFNULL(last_name, '')) LIKE ?",
                                        ["%{$filterValue}%"]
                                    );
                                }
                            });
                    });
                    break;
            }
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

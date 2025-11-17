<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use App\Models\Company;
use App\Models\Department;
use App\Models\Employee;
use App\Repositories\ShiftRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ShiftController extends Controller
{
    protected $shiftRepository;

    public function __construct(ShiftRepository $shiftRepository)
    {
        $this->shiftRepository = $shiftRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $companies = \App\Models\Company::active()->get();
        return view('hr.shifts.index', compact('companies'));
    }

    /**
     * Get shifts data for DataTables
     */
    public function datatable(Request $request): JsonResponse
    {
        try {
            $baseQuery = $this->shiftRepository->getForDataTable();

            // Custom filtering similar to other HR tables
            $filterField = $request->get('filter_field', 'all');
            $filterType = $request->get('filter_type', 'contains');
            $filterValue = $request->get('filter_value');

            if ($filterValue !== null && $filterValue !== '') {
                $comparison = $filterType === 'equals' ? '=' : 'like';
                $value = $filterType === 'equals' ? $filterValue : "%{$filterValue}%";

                $baseQuery->where(function ($query) use ($filterField, $comparison, $value, $filterValue) {
                    switch ($filterField) {
                        case 'code':
                            $query->where('code', $comparison, $value);
                            break;

                        case 'name':
                            $query->where('name', $comparison, $value);
                            break;

                        case 'company':
                            $query->whereHas('company', function ($companyQuery) use ($comparison, $value) {
                                $companyQuery->where('name', $comparison, $value);
                            });
                            break;

                        case 'status':
                            $normalized = strtolower(trim($filterValue));
                            if (in_array($normalized, ['active', '1', 'true', 'enabled'])) {
                                $query->where('is_active', true);
                            } elseif (in_array($normalized, ['inactive', '0', 'false', 'disabled'])) {
                                $query->where('is_active', false);
                            }
                            break;

                        case 'all':
                        default:
                            $query->where(function ($sub) use ($comparison, $value) {
                                $sub->where('code', $comparison, $value)
                                    ->orWhere('name', $comparison, $value)
                                    ->orWhereHas('company', function ($companyQuery) use ($comparison, $value) {
                                        $companyQuery->where('name', $comparison, $value);
                                    });
                            });
                            break;
                    }
                });
            }

            return \Yajra\DataTables\Facades\DataTables::of($baseQuery)
                ->addIndexColumn()
                ->orderColumn('DT_RowIndex', 'id $1')
                ->addColumn('formatted_time', function ($shift) {
                    return $shift->formatted_time;
                })
                ->addColumn('applicable_text', function ($shift) {
                    return $shift->applicable_text;
                })
                ->addColumn('status', function ($shift) {
                    return $shift->is_active ?
                        '<span class="badge bg-success">Active</span>' :
                        '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('actions', function ($shift) {
                    try {
                        return view('hr.shifts.partials.actions', compact('shift'))->render();
                    } catch (\Exception $e) {
                        Log::info('Error rendering actions view:', [
                            'shift_id' => $shift->id,
                            'error' => $e->getMessage(),
                        ]);
                        return 'Error: ' . $e->getMessage();
                    }
                })
                ->rawColumns(['status', 'actions'])
                ->toJson();
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Database error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::active()->get();
        $departments = Department::active()->get();
        $employees = Employee::active()->get();

        return view('hr.shifts.create', compact('companies', 'departments', 'employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'working_hours' => 'required|numeric|min:0|max:24',
            'color' => 'required|string|regex:/^#[a-fA-F0-9]{6}$/',
            'is_active' => 'boolean',
            'applicable_to' => 'required|in:company,department,employee',
            // IDs are validated for existence; required combinations are enforced on the frontend
            'company_id' => 'nullable|exists:companies,id',
            'department_id' => 'nullable|exists:departments,id',
            'employee_id' => 'nullable|exists:employees,id',
            'work_days' => 'nullable|array',
            'work_days.*' => 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'break_start' => 'nullable|date_format:H:i',
            'break_end' => 'nullable|date_format:H:i',
            'break_hours' => 'nullable|numeric|min:0|max:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $shift = Shift::create([
                'code' => Shift::generateUniqueCode(),
                'name' => $request->name,
                'description' => $request->description,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'working_hours' => $request->working_hours,
                'color' => $request->color,
                'is_active' => $request->boolean('is_active', true),
                'applicable_to' => $request->applicable_to,
                'company_id' => in_array($request->applicable_to, ['company', 'department', 'employee']) ? $request->company_id : null,
                'department_id' => in_array($request->applicable_to, ['department', 'employee']) ? $request->department_id : null,
                'employee_id' => $request->applicable_to === 'employee' ? $request->employee_id : null,
                'work_days' => $request->work_days,
                'break_start' => $request->break_start,
                'break_end' => $request->break_end,
                'break_hours' => $request->break_hours ?: 1.00,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Shift created successfully',
                'data' => $shift
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create shift',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Shift $shift)
    {
        $shift->load(['company', 'department', 'employee']);
        return response()->json([
            'success' => true,
            'data' => $shift
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shift $shift)
    {
        $companies = Company::active()->get();
        $departments = Department::active()->get();
        $employees = Employee::active()->get();

        return view('hr.shifts.edit', compact('shift', 'companies', 'departments', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shift $shift): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'working_hours' => 'required|numeric|min:0|max:24',
            'color' => 'required|string|regex:/^#[a-fA-F0-9]{6}$/',
            'is_active' => 'boolean',
            'applicable_to' => 'required|in:company,department,employee',
            'company_id' => 'nullable|exists:companies,id',
            'department_id' => 'nullable|exists:departments,id',
            'employee_id' => 'nullable|exists:employees,id',
            'work_days' => 'nullable|array',
            'work_days.*' => 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'break_start' => 'nullable|date_format:H:i',
            'break_end' => 'nullable|date_format:H:i',
            'break_hours' => 'nullable|numeric|min:0|max:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $shift->update([
                'name' => $request->name,
                'description' => $request->description,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'working_hours' => $request->working_hours,
                'color' => $request->color,
                'is_active' => $request->boolean('is_active', true),
                'applicable_to' => $request->applicable_to,
                'company_id' => in_array($request->applicable_to, ['company', 'department', 'employee']) ? $request->company_id : null,
                'department_id' => in_array($request->applicable_to, ['department', 'employee']) ? $request->department_id : null,
                'employee_id' => $request->applicable_to === 'employee' ? $request->employee_id : null,
                'work_days' => $request->work_days,
                'break_start' => $request->break_start,
                'break_end' => $request->break_end,
                'break_hours' => $request->break_hours ?: 1.00,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Shift updated successfully',
                'data' => $shift
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update shift',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shift $shift): JsonResponse
    {
        try {
            // Check if shift is being used
            if ($shift->attendances()->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete shift because it is linked to attendance records'
                ], 422);
            }

            $shift->delete();

            return response()->json([
                'success' => true,
                'message' => 'Shift deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete shift',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle shift status
     */
    public function toggleStatus(Shift $shift): JsonResponse
    {
        try {
            $shift->update(['is_active' => !$shift->is_active]);

            return response()->json([
                'success' => true,
                'message' => $shift->is_active ? 'Shift activated' : 'Shift deactivated',
                'is_active' => $shift->is_active
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update shift status',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get departments for company
     */
    public function getDepartments(Request $request): JsonResponse
    {
        $departments = Department::where('company_id', $request->company_id)
            ->active()
            ->select('id', 'name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $departments
        ]);
    }

    /**
     * Get employees for department
     */
    public function getEmployees(Request $request): JsonResponse
    {
        try {
            $employees = Employee::where('department_id', $request->department_id)
                ->active()
                ->selectRaw(
                    "id, first_name, middle_name, last_name, CONCAT(IFNULL(first_name, ''), ' ', IFNULL(middle_name, ''), ' ', IFNULL(last_name, '')) as full_name"
                )
                ->get();

            return response()->json([
                'success' => true,
                'data' => $employees
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load employees',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate unique code preview
     */
    public function previewCode(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'code' => Shift::generateUniqueCode()
        ]);
    }
}

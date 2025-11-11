<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Company;
use App\Services\DocumentCodeGenerator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Exports\EmployeesExport;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    public function __construct(private DocumentCodeGenerator $codeGenerator)
    {
    }
    
    public function index()
    {
        return view('hr.employees.index');
    }
    
    public function previewCode()
    {
        $code = $this->codeGenerator->preview('employees');
        return response()->json(['code' => $code]);
    }
    
    public function datatable(Request $request): JsonResponse
    {
        $baseQuery = Employee::query()
            ->with(['department', 'company']);

        // Apply filters
        if ($request->filled('filter_field') && $request->filled('filter_value')) {
            $field = $request->filter_field;
            $type = $request->filter_type ?? 'contains';
            $value = $request->filter_value;

            if ($field === 'all') {
                $baseQuery->where(function ($query) use ($value, $type) {
                    $query->where('code', $type === 'equals' ? '=' : 'like', $type === 'equals' ? $value : "%{$value}%")
                          ->orWhere('first_name', $type === 'equals' ? '=' : 'like', $type === 'equals' ? $value : "%{$value}%")
                          ->orWhere('last_name', $type === 'equals' ? '=' : 'like', $type === 'equals' ? $value : "%{$value}%")
                          ->orWhere('employee_id', $type === 'equals' ? '=' : 'like', $type === 'equals' ? $value : "%{$value}%")
                          ->orWhere('email', $type === 'equals' ? '=' : 'like', $type === 'equals' ? $value : "%{$value}%");
                });
            } else {
                $operator = $type === 'equals' ? '=' : 'like';
                $searchValue = $type === 'equals' ? $value : "%{$value}%";
                $baseQuery->where($field, $operator, $searchValue);
            }
        }

        return DataTables::of($baseQuery)
            ->addIndexColumn()
            ->addColumn('code', function ($employee) {
                return $employee->code ?? '-';
            })
            ->addColumn('profile_picture', function ($employee) {
                return '<img src="' . $employee->profile_picture_url . '" alt="' . $employee->full_name . '" class="w-10 h-10 rounded-full object-cover">';
            })
            ->addColumn('full_name', function ($employee) {
                return $employee->full_name;
            })
            ->addColumn('company_name', function ($employee) {
                return $employee->company ? $employee->company->name : '-';
            })
            ->addColumn('position', function ($employee) {
                return $employee->position ?? '-';
            })
            ->addColumn('hire_date_formatted', function ($employee) {
                return $employee->hire_date ? $employee->hire_date->format('M d, Y') : '-';
            })
            ->addColumn('status', function ($employee) {
                $status = $employee->is_active ? 'Active' : 'Inactive';
                $badgeClass = $employee->is_active
                    ? 'bg-green-100 text-green-700'
                    : 'bg-red-100 text-red-700';
                return "<span class=\"inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {$badgeClass}\">{$status}</span>";
            })
            ->addColumn('actions', function ($employee) {
                return view('hr.employees.partials.actions', ['employee' => $employee])->render();
            })
            ->rawColumns(['status', 'actions'])
            ->make(true);
    }

    public function create()
    {
        $departments = Department::where('is_active', true)->get();
        $companies = Company::where('is_active', true)->get();
        return view('hr.employees.create', compact('departments', 'companies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'nullable|string|max:20',
            'position' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
            'hire_date' => 'required|date',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'department_id' => 'required|exists:departments,id',
            'company_id' => 'required|exists:companies,id',
            'is_active' => 'nullable|boolean',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
        ]);

        try {
            DB::beginTransaction();

            $validated['code'] = $this->codeGenerator->generate('employees');
            $validated['employee_id'] = 'EMP' . strtoupper(Str::random(8)); // Keep this for backward compatibility
            $validated['is_active'] = $request->boolean('is_active', true);

            // Handle profile picture upload
            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $filename = time() . '_' . $validated['employee_id'] . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('employees/profile_pictures', $filename, 'public');
                $validated['profile_picture'] = $path;
            }

            Employee::create($validated);

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Employee created successfully',
                ]);
            }

            return redirect()->route('hr.employees.index')
                ->with('success', 'تم إضافة الموظف بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error creating employee: ' . $e->getMessage(),
                ], 500);
            }

            return back()->with('error', 'Error creating employee: ' . $e->getMessage());
        }
    }

    public function show(Employee $employee)
    {
        return view('hr.employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $departments = Department::where('is_active', true)->get();
        $companies = Company::where('is_active', true)->get();
        return view('hr.employees.edit', compact('employee', 'departments', 'companies'));
    }

    public function destroy(Employee $employee, Request $request)
    {
        try {
            DB::beginTransaction();

            $employee->delete();

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Employee deleted successfully',
                ]);
            }

            return redirect()->route('hr.employees.index')
                ->with('success', 'تم حذف الموظف بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error deleting employee: ' . $e->getMessage(),
                ], 500);
            }

            return back()->with('error', 'Error deleting employee: ' . $e->getMessage());
        }
    }
}

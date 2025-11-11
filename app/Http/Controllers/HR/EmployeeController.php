<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmployeesExport;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with(['department', 'company'])
            ->latest()
            ->paginate(10);
            
        return view('hr.employees.index', compact('employees'));
    }
    
    /**
     * Export employees to Excel
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export()
    {
        return Excel::download(new EmployeesExport, 'employees-' . now()->format('Y-m-d') . '.xlsx');
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
            'is_active' => 'boolean'
        ]);

        // Generate employee ID
        $validated['employee_id'] = 'EMP' . strtoupper(Str::random(8));

        Employee::create($validated);

        return redirect()->route('hr.employees.index')
            ->with('success', 'تم إضافة الموظف بنجاح');
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

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('employees')->ignore($employee->id),
            ],
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
            'is_active' => 'boolean'
        ]);

        $employee->update($validated);

        return redirect()->route('hr.employees.index')
            ->with('success', 'تم تحديث بيانات الموظف بنجاح');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('hr.employees.index')
            ->with('success', 'تم حذف الموظف بنجاح');
    }
}

<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\HR\Employee;
use App\Models\HR\Department;
use App\Models\Setting\Company;
use App\Models\User;
use App\Services\DocumentCodeGenerator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Services\Notifications\NotificationDispatcher;
use Carbon\Carbon;
use App\Exports\EmployeesExport;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\Reply;
use App\Services\PdfExporter;
use Illuminate\Validation\ValidationException;

class EmployeeController extends Controller
{
    public function __construct(
        private readonly DocumentCodeGenerator $codeGenerator,
        private readonly PdfExporter $pdfExporter
    )
    {
    }
    
    public function index()
    {
        $this->ensureEmployeeRecordForUser(auth()->user());

        $companies = Company::where('is_active', true)->select('id', 'name')->get();
        $departments = Department::where('is_active', true)->select('id', 'name')->get();
        $generatedCode = $this->codeGenerator->preview('employees');
        $countriesJson = json_encode($this->getCountriesData(), JSON_UNESCAPED_UNICODE);

        $employeesTotal = Employee::count();
        $employeesActive = Employee::where('is_active', true)->count();
        $employeesInactive = Employee::where('is_active', false)->count();

        return view('hr.employees.index', compact(
            'companies',
            'departments',
            'generatedCode',
            'countriesJson',
            'employeesTotal',
            'employeesActive',
            'employeesInactive'
        ));
    }
    
    public function previewCode()
    {
        $code = $this->codeGenerator->preview('employees');
        return Reply::success('', ['code' => $code]);
    }
    
    public function datatable(Request $request): JsonResponse
    {
        $baseQuery = Employee::query()
            ->with(['department:id,name', 'company:id,name']);

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

        // Apply advanced filters
        if ($request->filled('company_id') && $request->company_id !== '') {
            $baseQuery->where('company_id', $request->company_id);
        }

        if ($request->filled('department_id') && $request->department_id !== '') {
            $baseQuery->where('department_id', $request->department_id);
        }

        if ($request->filled('position_filter') && $request->position_filter !== '') {
            $baseQuery->where('position', '=', $request->position_filter);
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
                $translated = $employee->translated_name
                    ? '<span class="mt-0.5 block text-xs text-slate-500">' . e($employee->translated_name) . '</span>'
                    : '';

                return '<div class="leading-tight">'
                    . '<a href="' . route('hr.employees.show', $employee->id) . '" class="font-medium text-slate-700 hover:text-primary">' . e($employee->full_name) . '</a>'
                    . $translated
                    . '</div>';
            })
            ->addColumn('company_name', function ($employee) {
                return $employee->company ? $employee->company->name : '-';
            })
            ->addColumn('department_name', function ($employee) {
                $department = $employee->department ? e($employee->department->name) : '-';
                $position = $employee->position
                    ? '<span class="mt-0.5 block text-xs text-slate-500">' . e($employee->position) . '</span>'
                    : '';

                return '<div class="leading-tight">' . $department . $position . '</div>';
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
            ->rawColumns(['status', 'actions', 'profile_picture', 'full_name', 'department_name'])
            ->make(true);
    }

    public function testData(Request $request): JsonResponse
    {
        $companies = Company::where('is_active', true)->get();
        $departments = Department::where('is_active', true)->get();
        
        return Reply::successWithData('', [
            'companies_count' => $companies->count(),
            'departments_count' => $departments->count(),
            'companies' => $companies->pluck('name'),
            'departments' => $departments->pluck('name'),
        ]);
    }

    public function getCompanies(Request $request): JsonResponse
    {
        $companies = Company::where('is_active', true)
            ->select('id', 'name')
            ->get();
        
        return response()->json($companies);
    }

    public function getPositionsByDepartment(Request $request): JsonResponse
    {
        $departmentId = $request->query('department_id');
        
        $query = Employee::where('is_active', true)
            ->select('position')
            ->distinct();
        
        if ($departmentId && $departmentId !== '') {
            $query->where('department_id', $departmentId);
        }
        
        $positions = $query->whereNotNull('position')
            ->where('position', '!=', '')
            ->orderBy('position')
            ->get()
            ->pluck('position')
            ->filter()
            ->values();
        
        return response()->json($positions);
    }

    public function create()
    {
        $companies = Company::where('is_active', true)->get();
        $departments = Department::where('is_active', true)->get();
        
        // استخدام نظام توليد الكود الأصلي (نفس document_type المستخدم في store)
        $generatedCode = $this->codeGenerator->preview('employees');
        
        return view('hr.employees.modals.create', compact('companies', 'departments', 'generatedCode'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'translated_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'nullable|string|max:20',
            'position' => 'required|string|max:255',
            'iqama_position' => 'nullable|string|max:255',
            'salary' => 'required|numeric|min:0',
            'hire_date' => 'required|date_format:Y-m-d',
            'birth_date' => 'nullable|date_format:Y-m-d',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string',
            'is_company_housing' => 'nullable|boolean',
            'housing_room_number' => 'nullable|string|max:255',
            'housing_unit_number' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'department_id' => 'required|exists:departments,id',
            'company_id' => 'required|exists:companies,id',
            'is_active' => 'nullable|boolean',
            'has_system_access' => 'nullable|boolean',
            'system_password' => 'nullable|string|min:6',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
        ]);

        try {
            DB::beginTransaction();

            $validated['code'] = $this->codeGenerator->generate('employees');
            $validated['employee_id'] = 'EMP' . strtoupper(Str::random(8)); // Keep this for backward compatibility
            $validated['is_active'] = $request->boolean('is_active', true);
            $validated['is_company_housing'] = $request->boolean('is_company_housing');
            $validated['has_system_access'] = $request->boolean('has_system_access');

            $plainSystemPassword = $validated['system_password'] ?? null;

            if (!$validated['is_company_housing']) {
                $validated['housing_room_number'] = null;
                $validated['housing_unit_number'] = null;
            }

            if (!$validated['has_system_access']) {
                $validated['system_password'] = null;
            }

            if ($validated['has_system_access']) {
                $user = $this->provisionUserAccount($validated, null, $plainSystemPassword);
                $validated['user_id'] = $user->id;

                $validated['system_password'] = $plainSystemPassword
                    ? Hash::make($plainSystemPassword)
                    : null;
            }

            // Handle profile picture upload
            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $filename = time() . '_' . $validated['employee_id'] . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('employees/profile_pictures', $filename, 'public');
                $validated['profile_picture'] = $path;
            }

            $employee = Employee::create($validated);

            DB::commit();

            $actor = auth()->user()?->name ?? 'System';
            $employeeName = trim($employee->first_name . ' ' . $employee->last_name);
            NotificationDispatcher::toAllUsers(
                'employee.created',
                'New Employee Added',
                "User {$actor} created employee '{$employeeName}'.",
                route('hr.employees.index'),
                'UserPlus',
                ['employee_id' => $employee->id, 'actor_id' => auth()->id()]
            );

            if ($request->ajax()) {
                return Reply::success('Employee created successfully');
            }

            return redirect()->route('hr.employees.index')
                ->with('success', 'تم إضافة الموظف بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return Reply::error('Error creating employee: ' . $e->getMessage(), [], 500);
            }

            return back()->with('error', 'Error creating employee: ' . $e->getMessage());
        }
    }

    public function show(Employee $employee)
    {
        $employee->loadMissing('user');

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
            'translated_name' => 'nullable|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('employees', 'email')->ignore($employee->id),
            ],
            'phone' => 'nullable|string|max:20',
            'position' => 'required|string|max:255',
            'iqama_position' => 'nullable|string|max:255',
            'salary' => 'required|numeric|min:0',
            'hire_date' => 'required|date_format:Y-m-d',
            'birth_date' => 'nullable|date_format:Y-m-d',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string',
            'is_company_housing' => 'nullable|boolean',
            'housing_room_number' => 'nullable|string|max:255',
            'housing_unit_number' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'department_id' => 'required|exists:departments,id',
            'company_id' => 'required|exists:companies,id',
            'is_active' => 'nullable|boolean',
            'has_system_access' => 'nullable|boolean',
            'system_password' => 'nullable|string|min:6',
            // In edit form the input name is `photo`, but the column is `profile_picture`
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        try {
            DB::beginTransaction();

            $validated['is_active'] = $request->boolean('is_active', false);
            $validated['is_company_housing'] = $request->boolean('is_company_housing');
            $validated['has_system_access'] = $request->boolean('has_system_access');

            $plainSystemPassword = $validated['system_password'] ?? null;

            if (!$validated['is_company_housing']) {
                $validated['housing_room_number'] = null;
                $validated['housing_unit_number'] = null;
            }

            if (!$validated['has_system_access']) {
                $validated['system_password'] = null;
            }

            if ($validated['has_system_access']) {
                $user = $this->provisionUserAccount($validated, $employee, $plainSystemPassword);
                $validated['user_id'] = $user->id;

                if ($plainSystemPassword) {
                    $validated['system_password'] = Hash::make($plainSystemPassword);
                } else {
                    unset($validated['system_password']);
                }
            } else {
                unset($validated['system_password']);
            }

            // Map photo input to profile_picture column
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $filename = time() . '_' . ($employee->employee_id ?? ('EMP' . strtoupper(Str::random(8)))) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('employees/profile_pictures', $filename, 'public');
                $validated['profile_picture'] = $path;
            }

            // Do not allow changing code or employee_id from this form even if present
            unset($validated['code'], $validated['employee_id']);

            $employee->update($validated);

            DB::commit();

            if ($request->ajax()) {
                return Reply::success('Employee updated successfully');
            }

            return redirect()
                ->route('hr.employees.show', $employee)
                ->with('success', 'Employee updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return Reply::error('Error updating employee: ' . $e->getMessage(), [], 500);
            }

            return back()->with('error', 'Error updating employee: ' . $e->getMessage());
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();
        $handle = fopen($path, 'r');

        if ($handle === false) {
            return Reply::error('Unable to read the uploaded file.', [], 422);
        }

        $header = null;
        $created = 0;
        $updated = 0;

        DB::beginTransaction();

        try {
            while (($row = fgetcsv($handle, 2000, ',')) !== false) {
                if ($header === null) {
                    $header = array_map(function ($value) {
                        return Str::snake(trim($value));
                    }, $row);
                    continue;
                }

                if (count(array_filter($row, function ($value) {
                    return trim((string) $value) !== '';
                })) === 0) {
                    continue;
                }

                if (count($row) !== count($header)) {
                    continue;
                }

                $data = array_combine($header, array_map('trim', $row));

                if (empty($data['email'])) {
                    continue;
                }

                $employee = Employee::firstOrNew(['email' => $data['email']]);
                $isNew = !$employee->exists;

                if ($isNew) {
                    $employee->code = $data['code'] ?? $this->codeGenerator->generate('employees');
                    $employee->employee_id = $data['employee_id'] ?? ('EMP' . strtoupper(Str::random(8)));
                }

                $this->assignIfProvided($employee, $data, 'first_name');
                $this->assignIfProvided($employee, $data, 'last_name');
                $this->assignIfProvided($employee, $data, 'phone');
                $this->assignIfProvided($employee, $data, 'position');
                $this->assignIfProvided($employee, $data, 'salary');
                $this->assignIfProvided($employee, $data, 'department_id');
                $this->assignIfProvided($employee, $data, 'company_id');

                if (!empty($data['hire_date'])) {
                    try {
                        $employee->hire_date = Carbon::parse($data['hire_date']);
                    } catch (\Exception $e) {
                        // Ignore invalid date formats
                    }
                }

                if (isset($data['is_active']) && $data['is_active'] !== '') {
                    $employee->is_active = filter_var($data['is_active'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
                    if ($employee->is_active === null) {
                        $employee->is_active = in_array(strtolower($data['is_active']), ['1', 'active', 'yes']);
                    }
                }

                if (!$employee->first_name) {
                    $employee->first_name = 'Imported';
                }

                if (!$employee->last_name) {
                    $employee->last_name = 'Employee';
                }

                $employee->save();
                $isNew ? $created++ : $updated++;
            }

            fclose($handle);
            DB::commit();

            return Reply::success('Employees imported successfully.', [
                'created' => $created,
                'updated' => $updated,
            ]);
        } catch (\Exception $e) {
            fclose($handle);
            DB::rollBack();
            return Reply::error('Failed to import employees: ' . $e->getMessage(), [], 500);
        }
    }

    private function assignIfProvided(Employee $employee, array $data, string $key): void
    {
        if (array_key_exists($key, $data) && $data[$key] !== '') {
            $employee->{$key} = $data[$key];
        }
    }

    public function destroy(Employee $employee, Request $request)
    {
        try {
            DB::beginTransaction();

            $employee->delete();

            DB::commit();

            $actor = auth()->user()?->name ?? 'System';
            $employeeName = trim($employee->first_name . ' ' . $employee->last_name);
            NotificationDispatcher::toAllUsers(
                'employee.deleted',
                'Employee Deleted',
                "User {$actor} deleted employee '{$employeeName}'.",
                route('hr.employees.index'),
                'UserMinus',
                ['employee_id' => $employee->id, 'actor_id' => auth()->id()]
            );

            if ($request->ajax()) {
                return Reply::success('Employee deleted successfully');
            }

            return redirect()->route('hr.employees.index')
                ->with('success', 'تم حذف الموظف بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return Reply::error('Error deleting employee: ' . $e->getMessage(), [], 500);
            }

            return back()->with('error', 'Error deleting employee: ' . $e->getMessage());
        }
    }

    public function exportPdf(Request $request)
    {
        $employees = $this->datatableQuery($request)->get();

        return $this->pdfExporter->stream(
            'hr.employees.export_pdf',
            [
                'employees' => $employees,
                'exportedAt' => now(),
            ],
            'employees.pdf'
        );
    }

    private function datatableQuery(Request $request)
    {
        // Replicate your existing datatable query logic here
        // This should match the query from your datatable method
        $baseQuery = Employee::query()->with(['department', 'company']);
        
        // Add your filters from $request here
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

        // Apply advanced filters
        if ($request->filled('company_id') && $request->company_id !== '') {
            $baseQuery->where('company_id', $request->company_id);
        }

        if ($request->filled('department_id') && $request->department_id !== '') {
            $baseQuery->where('department_id', $request->department_id);
        }

        if ($request->filled('position_filter') && $request->position_filter !== '') {
            $baseQuery->where('position', '=', $request->position_filter);
        }

        return $baseQuery;
    }

    private function getCountriesData(): array
    {
        $path = resource_path('data/countries.json');

        if (file_exists($path)) {
            $json = file_get_contents($path);
            $data = json_decode($json, true);

            if (json_last_error() === JSON_ERROR_NONE && is_array($data)) {
                return $data;
            }
        }

        return [
            ['name' => 'Saudi Arabia', 'flag' => '🇸🇦'],
            ['name' => 'United Arab Emirates', 'flag' => '🇦🇪'],
            ['name' => 'Qatar', 'flag' => '🇶🇦'],
            ['name' => 'Bahrain', 'flag' => '🇧🇭'],
            ['name' => 'Kuwait', 'flag' => '🇰🇼'],
        ];
    }

    protected function ensureEmployeeRecordForUser(?User $user): void
    {
        if (!$user) {
            return;
        }

        $alreadyLinked = Employee::where('user_id', $user->id)->exists();
        if ($alreadyLinked) {
            return;
        }

        $company = Company::where('is_active', true)->first() ?? Company::first();
        if (!$company) {
            return;
        }

        $nameParts = preg_split('/\s+/', trim($user->name));
        $firstName = $nameParts[0] ?? $user->name;
        $lastName = $nameParts[1] ?? $firstName;
        $middleName = $nameParts[2] ?? null;

        Employee::create([
            'code' => $this->codeGenerator->generate('employees'),
            'employee_id' => 'EMP' . strtoupper(Str::random(8)),
            'first_name' => $firstName,
            'middle_name' => $middleName,
            'last_name' => $lastName,
            'email' => $user->email,
            'phone' => null,
            'translated_name' => null,
            'position' => 'System Administrator',
            'iqama_position' => null,
            'salary' => 0,
            'hire_date' => now()->toDateString(),
            'birth_date' => null,
            'gender' => null,
            'address' => null,
            'is_company_housing' => false,
            'housing_room_number' => null,
            'housing_unit_number' => null,
            'city' => null,
            'country' => null,
            'postal_code' => null,
            'department_id' => null,
            'company_id' => $company->id,
            'user_id' => $user->id,
            'has_system_access' => true,
            'system_password' => null,
            'is_active' => true,
            'profile_picture' => null,
        ]);
    }

    protected function provisionUserAccount(array $employeeData, ?Employee $employee, ?string $plainPassword = null): User
    {
        $this->ensureEmployeeRecordForUser(auth()->user());

        $fullName = trim(implode(' ', array_filter([
            $employeeData['first_name'] ?? null,
            $employeeData['middle_name'] ?? null,
            $employeeData['last_name'] ?? null,
        ])));

        $currentUser = $employee?->user;
        $userByEmail = User::where('email', $employeeData['email'])->first();

        if ($userByEmail && (!$currentUser || $userByEmail->id !== $currentUser->id)) {
            $linkedToAnotherEmployee = Employee::where('user_id', $userByEmail->id)
                ->when($employee, fn ($query) => $query->where('id', '!=', $employee->id))
                ->exists();

            if ($linkedToAnotherEmployee) {
                throw ValidationException::withMessages([
                    'email' => __('This email is already linked to another employee profile.'),
                ]);
            }

            $currentUser = $userByEmail;
        }

        if (!$currentUser) {
            if (!$plainPassword) {
                throw ValidationException::withMessages([
                    'system_password' => __('Please provide a password to create a system user for this employee.'),
                ]);
            }

            $currentUser = new User();
        }

        $currentUser->email = $employeeData['email'];
        $currentUser->name = $fullName ?: ($currentUser->name ?? $employeeData['email']);

        if ($plainPassword) {
            $currentUser->password = Hash::make($plainPassword);
        }

        $currentUser->save();

        return $currentUser;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class DepartmentController extends Controller
{
    /**
     * عرض قائمة الأقسام
     */
    public function index()
    {
        $departments = Department::with(['company', 'manager', 'parent'])
            ->latest()
            ->paginate(10);

        return view('hr.departments.index', compact('departments'));
    }

    /**
     * عرض نموذج إنشاء قسم جديد
     */
    public function create()
    {
        $companies = Company::active()->get();
        $managers = Employee::active()->get();
        $departments = Department::active()->get();

        return view('hr.departments.create', compact('companies', 'managers', 'departments'));
    }

    /**
     * حفظ القسم الجديد في قاعدة البيانات
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'manager_id' => 'nullable|exists:employees,id',
            'parent_id' => [
                'nullable',
                Rule::exists('departments', 'id')->where(function ($query) use ($request) {
                    $query->where('company_id', $request->company_id);
                })
            ],
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        try {
            DB::beginTransaction();

            $department = Department::create($validated);

            DB::commit();

            return redirect()->route('hr.departments.index')
                ->with('success', 'تم إنشاء القسم بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ أثناء إنشاء القسم: ' . $e->getMessage());
        }
    }

    /**
     * عرض تفاصيل القسم
     */
    public function show(Department $department)
    {
        $department->load(['company', 'manager', 'parent', 'children', 'positions']);
        return view('hr.departments.show', compact('department'));
    }

    /**
     * عرض نموذج تعديل القسم
     */
    public function edit(Department $department)
    {
        $companies = Company::active()->get();
        $managers = Employee::active()->get();
        $departments = Department::where('id', '!=', $department->id)
            ->where('company_id', $department->company_id)
            ->active()
            ->get();

        return view('hr.departments.edit', compact('department', 'companies', 'managers', 'departments'));
    }

    /**
     * تحديث بيانات القسم في قاعدة البيانات
     */
    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'manager_id' => 'nullable|exists:employees,id',
            'parent_id' => [
                'nullable',
                Rule::exists('departments', 'id')
                    ->where('company_id', $request->company_id)
                    ->where('id', '!=', $department->id),
                function ($attribute, $value, $fail) use ($department) {
                    if ($value) {
                        $isChild = Department::where('id', $value)
                            ->where('company_id', $department->company_id)
                            ->where(function ($query) use ($department) {
                                $query->whereNull('parent_id')
                                    ->orWhere('parent_id', '!=', $department->id);
                            })
                            ->exists();

                        if (!$isChild) {
                            $fail('القسم الفرعي المحدد غير صالح.');
                        }
                    }
                },
            ],
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        try {
            DB::beginTransaction();

            $department->update($validated);

            DB::commit();

            return redirect()->route('hr.departments.index')
                ->with('success', 'تم تحديث القسم بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ أثناء تحديث القسم: ' . $e->getMessage());
        }
    }

    /**
     * حذف القسم
     */
    public function destroy(Department $department)
    {
        try {
            DB::beginTransaction();

            // التحقق مما إذا كان القسم يحتوي على أقسام فرعية
            if ($department->children()->exists()) {
                return back()->with('error', 'لا يمكن حذف القسم لأنه يحتوي على أقسام فرعية.');
            }

            // التحقق مما إذا كان القسم مرتبطًا بموظفين
            if ($department->employees()->exists()) {
                return back()->with('error', 'لا يمكن حذف القسم لأنه مرتبط بموظفين.');
            }

            // حذف القسم
            $department->delete();

            DB::commit();

            return redirect()->route('hr.departments.index')
                ->with('success', 'تم حذف القسم بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ أثناء حذف القسم: ' . $e->getMessage());
        }
    }

    /**
     * الحصول على الأقسام التابعة لشركة معينة (للاستخدام مع AJAX)
     */
    public function getByCompany($companyId)
    {
        $departments = Department::where('company_id', $companyId)
            ->where('is_active', true)
            ->get();

        return response()->json($departments);
    }
}

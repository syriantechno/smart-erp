<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DepartmentController extends Controller
{
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
                    ->where('company_id', $request->company_id)
            ],
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        try {
            DB::beginTransaction();

            $department = Department::create($validated);
            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Department has been created successfully',
                    'redirect' => route('hr.departments.index')
                ]);
            }

            // This will be used for non-AJAX requests
            return redirect()->route('hr.departments.index');

        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create department: ' . $e->getMessage()
                ], 500);
            }
            
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
        $query = Department::with(['company', 'manager'])
            ->withCount('employees')
            ->select('departments.*');
            
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', function($row) {
                return '';
            })
            ->addColumn('actions', function($department) {
                return view('hr.departments.partials.actions', ['department' => $department])->render();
            })
            ->addColumn('edit_url', function($department) {
                return route('hr.departments.edit', $department);
            })
            ->editColumn('created_at', function($department) {
                return $department->created_at->format('Y-m-d H:i:s');
            })
            ->editColumn('updated_at', function($department) {
                return $department->updated_at->format('Y-m-d H:i:s');
            })
            ->rawColumns(['actions', 'is_active'])
            ->make(true);
    }
    
    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'manager_id' => 'nullable|exists:employees,id',
            'parent_id' => 'nullable|exists:departments,id|not_in:' . $department->id,
            'is_active' => 'boolean'
        ]);

        $department->update($validated);

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
                    return response()->json([
                        'success' => false,
                        'message' => $message
                    ], 400);
                }
                return back();
            }
            
            if ($department->employees()->exists()) {
                $message = 'Cannot delete department because it has employees.';
                if (request()->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => $message
                    ], 400);
                }
                return back();
            }

            $department->delete();

            DB::commit();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Department deleted successfully'
                ]);
            }

            return redirect()->route('hr.departments.index')
                ->with('success', 'Department deleted successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error deleting department: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Error deleting department: ' . $e->getMessage());
        }
    }
}

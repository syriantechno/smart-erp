<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Position;
use App\Services\DocumentCodeGenerator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class PositionController extends Controller
{
    public function __construct(private DocumentCodeGenerator $codeGenerator)
    {
    }

    public function index()
    {
        return view('hr.positions.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'department_id' => [
                'required',
                Rule::exists('departments', 'id')->where('is_active', true),
            ],
            'description' => 'nullable|string',
            'requirements' => 'nullable|string',
            'salary_range_min' => 'nullable|numeric|min:0',
            'salary_range_max' => 'nullable|numeric|min:0|gte:salary_range_min',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            return back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        try {
            DB::beginTransaction();

            $validated['code'] = $this->codeGenerator->generate('position');
            $validated['is_active'] = $request->boolean('is_active', true);

            Position::create($validated);

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Position created successfully',
                ]);
            }

            return redirect()->route('hr.positions.index')
                ->with('success', 'Position created successfully');

        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error creating position: ' . $e->getMessage(),
                ], 500);
            }

            return back()->with('error', 'Error creating position: ' . $e->getMessage());
        }
    }

    public function edit(Position $position)
    {
        $departments = Department::active()->get();
        return view('hr.positions.edit', compact('position', 'departments'));
    }

    public function update(Request $request, Position $position)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'department_id' => [
                'required',
                Rule::exists('departments', 'id')->where('is_active', true),
            ],
            'description' => 'nullable|string',
            'requirements' => 'nullable|string',
            'salary_range_min' => 'nullable|numeric|min:0',
            'salary_range_max' => 'nullable|numeric|min:0|gte:salary_range_min',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            return back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        try {
            DB::beginTransaction();

            $validated['is_active'] = $request->boolean('is_active', $position->is_active);

            $position->update($validated);

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Position updated successfully',
                ]);
            }

            return redirect()->route('hr.positions.index')
                ->with('success', 'Position updated successfully');

        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error updating position: ' . $e->getMessage(),
                ], 500);
            }

            return back()->with('error', 'Error updating position: ' . $e->getMessage());
        }
    }

    public function destroy(Position $position, Request $request)
    {
        try {
            DB::beginTransaction();

            // Check if position has employees by matching position string
            $hasEmployees = \App\Models\Employee::where('position', $position->title)->exists();

            if ($hasEmployees) {
                $message = 'Cannot delete position because it has employees.';
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => $message,
                    ], 400);
                }

                return back()->with('error', $message);
            }

            $position->delete();

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Position deleted successfully',
                ]);
            }

            return redirect()->route('hr.positions.index')
                ->with('success', 'Position deleted successfully');

        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error deleting position: ' . $e->getMessage(),
                ], 500);
            }

            return back()->with('error', 'Error deleting position: ' . $e->getMessage());
        }
    }

    public function datatable(Request $request): JsonResponse
    {
        $draw = intval($request->input('draw'));
        $length = intval($request->input('length', 10));
        $start = intval($request->input('start', 0));
        $searchValue = $request->input('search.value');

        $baseQuery = Position::query()
            ->with(['department']);

        $recordsTotal = (clone $baseQuery)->count();

        if (!empty($searchValue)) {
            $baseQuery->where(function ($query) use ($searchValue) {
                $query->where('title', 'like', "%{$searchValue}%")
                    ->orWhere('code', 'like', "%{$searchValue}%")
                    ->orWhereHas('department', function ($departmentQuery) use ($searchValue) {
                        $departmentQuery->where('name', 'like', "%{$searchValue}%");
                    });
            });
        }

        $recordsFiltered = (clone $baseQuery)->count();

        $orderColumnIndex = $request->input('order.0.column', 1);
        $orderDirection = $request->input('order.0.dir', 'asc');
        $orderableColumns = [
            0 => 'id',
            1 => 'code',
            2 => 'title',
            3 => 'department_name',
            4 => 'salary_range_min',
            5 => 'is_active',
        ];

        $orderColumn = $orderableColumns[$orderColumnIndex] ?? 'title';

        if ($orderColumn === 'department_name') {
            $baseQuery->leftJoin('departments', 'positions.department_id', '=', 'departments.id')
                ->orderBy('departments.name', $orderDirection)
                ->select('positions.*');
        } else {
            $baseQuery->orderBy($orderColumn, $orderDirection);
        }

        $positions = $baseQuery
            ->skip($start)
            ->take($length)
            ->get();

        $data = $positions->map(function (Position $position, $index) use ($start) {
            $salaryRange = '-';
            if (!is_null($position->salary_range_min) && !is_null($position->salary_range_max)) {
                $salaryRange = number_format($position->salary_range_min, 2) . ' - ' . number_format($position->salary_range_max, 2);
            }

            return [
                'DT_RowIndex' => $start + $index + 1,
                'code' => $position->code,
                'title' => $position->title,
                'department' => [
                    'name' => optional($position->department)->name,
                ],
                'salary_range' => $salaryRange,
                'is_active' => (bool) $position->is_active,
                'actions' => view('hr.positions.partials.actions', ['position' => $position])->render(),
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
        $code = $this->codeGenerator->preview('position');

        return response()->json([
            'code' => $code,
        ]);
    }

    public function getPositionsByDepartment(Department $department)
    {
        $positions = $department->positions()->active()->get();
        return response()->json($positions);
    }
}

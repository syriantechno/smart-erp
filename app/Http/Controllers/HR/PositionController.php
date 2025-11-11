<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\Controller;
use App\Models\Position;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::with(['department', 'employees'])->latest()->paginate(10);
        return view('hr.positions.index', compact('positions'));
    }

    public function create()
    {
        $departments = Department::active()->get();
        return view('hr.positions.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'description' => 'nullable|string',
            'requirements' => 'nullable|string',
            'minimum_salary' => 'nullable|numeric|min:0',
            'maximum_salary' => 'nullable|numeric|min:0|gt:minimum_salary',
            'is_active' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            Position::create($validated);

            DB::commit();

            return redirect()->route('hr.positions.index')
                ->with('success', 'Position created successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error creating position: ' . $e->getMessage());
        }
    }

    public function show(Position $position)
    {
        $position->load(['department', 'employees']);
        return view('hr.positions.show', compact('position'));
    }

    public function edit(Position $position)
    {
        $departments = Department::active()->get();
        return view('hr.positions.edit', compact('position', 'departments'));
    }

    public function update(Request $request, Position $position)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'description' => 'nullable|string',
            'requirements' => 'nullable|string',
            'minimum_salary' => 'nullable|numeric|min:0',
            'maximum_salary' => 'nullable|numeric|min:0|gt:minimum_salary',
            'is_active' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            $position->update($validated);

            DB::commit();

            return redirect()->route('hr.positions.index')
                ->with('success', 'Position updated successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error updating position: ' . $e->getMessage());
        }
    }

    public function destroy(Position $position)
    {
        try {
            DB::beginTransaction();

            if ($position->employees()->exists()) {
                return back()->with('error', 'Cannot delete position because it has employees');
            }

            $position->delete();

            DB::commit();

            return redirect()->route('hr.positions.index')
                ->with('success', 'Position deleted successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error deleting position: ' . $e->getMessage());
        }
    }

    public function getPositionsByDepartment(Department $department)
    {
        $positions = $department->positions()->active()->get();
        return response()->json($positions);
    }
}

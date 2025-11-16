<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\HR\EmployeeReward;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmployeeRewardController extends Controller
{
    public function index(): View
    {
        $rewards = EmployeeReward::with(['employee.department', 'granter'])
            ->orderByDesc('granted_at')
            ->orderByDesc('created_at')
            ->limit(100)
            ->get();

        $employees = Employee::active()
            ->with('department:id,name')
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get(['id', 'first_name', 'middle_name', 'last_name', 'department_id']);

        return view('hr.rewards.index', compact('rewards', 'employees'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'points' => 'required|integer|min:1',
            'amount' => 'nullable|numeric|min:0',
            'type' => 'nullable|string|max:100',
            'reason' => 'nullable|string|max:2000',
        ]);

        $reward = new EmployeeReward();
        $reward->employee_id = $validated['employee_id'];
        $reward->granted_by = auth()->id();
        $reward->points = $validated['points'];
        $reward->amount = $validated['amount'] ?? null;
        $reward->type = $validated['type'] ?? null;
        $reward->reason = $validated['reason'] ?? null;
        $reward->granted_at = now();
        $reward->save();

        $reward->load(['employee.department', 'granter']);

        if ($request->expectsJson()) {
            $rowHtml = view('hr.rewards._row', compact('reward'))->render();

            return response()->json([
                'message' => 'Employee reward saved successfully.',
                'row' => $rowHtml,
            ]);
        }

        return redirect()
            ->route('hr.employee-rewards.index')
            ->with('success', 'Employee reward saved successfully.');
    }
}

<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\HR\Employee;
use App\Models\HR\EmployeeReward;
use App\Services\Notifications\NotificationDispatcher;
use Illuminate\Http\JsonResponse;
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

        // Send notification to employee
        $employee = Employee::find($validated['employee_id']);
        if ($employee && $employee->user_id) {
            $message = "You have received a reward of {$validated['points']} points";
            if (!empty($validated['amount'])) {
                $message .= " and " . number_format($validated['amount'], 2) . " bonus";
            }
            NotificationDispatcher::toUser(
                $employee->user_id,
                'reward.granted',
                'Reward Received! 🎉',
                $message,
                route('hr.employee-rewards.index'),
                'gift',
                ['type' => 'success', 'actor_id' => auth()->id()]
            );
        }

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

    public function show(EmployeeReward $reward): View
    {
        $reward->load(['employee.department', 'granter']);
        
        return view('hr.rewards.show', compact('reward'));
    }

    public function destroy(EmployeeReward $reward): RedirectResponse|JsonResponse
    {
        $employeeName = $reward->employee->full_name ?? 'Unknown';
        
        $reward->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'message' => "Reward for {$employeeName} deleted successfully.",
            ]);
        }

        return redirect()
            ->route('hr.employee-rewards.index')
            ->with('success', "Reward for {$employeeName} deleted successfully.");
    }
}

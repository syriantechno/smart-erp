<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\HR\EmployeeEvaluation;
use App\Models\HR\EmployeeEvaluationItem;
use App\Models\HR\EvaluationCriterion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmployeeEvaluationController extends Controller
{
    public function index(): View
    {
        $evaluations = EmployeeEvaluation::with(['employee.department', 'evaluator', 'items.criterion'])
            ->orderByDesc('evaluated_at')
            ->orderByDesc('created_at')
            ->limit(100)
            ->get();

        $employees = Employee::active()
            ->with('department:id,name')
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get(['id', 'first_name', 'middle_name', 'last_name', 'department_id']);

        $criteria = EvaluationCriterion::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('hr.evaluations.index', compact('evaluations', 'employees', 'criteria'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'scores' => 'required|array',
            'scores.*' => 'required|integer|min:1|max:10',
            'comments' => 'nullable|string|max:2000',
        ]);

        $scores = $validated['scores'];

        // Filter only active criteria to avoid invalid IDs
        $activeCriteriaIds = EvaluationCriterion::where('is_active', true)
            ->pluck('id')
            ->all();

        $filteredScores = [];
        foreach ($scores as $criterionId => $score) {
            if (in_array((int) $criterionId, $activeCriteriaIds, true)) {
                $filteredScores[(int) $criterionId] = (int) $score;
            }
        }

        if (count($filteredScores) === 0) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['scores' => 'At least one criterion score is required.']);
        }

        $overall = (int) round(array_sum($filteredScores) / count($filteredScores));

        $evaluation = new EmployeeEvaluation();
        $evaluation->employee_id = $validated['employee_id'];
        $evaluation->evaluator_id = auth()->id();
        $evaluation->overall_rating = $overall;
        $evaluation->comments = $validated['comments'] ?? null;
        $evaluation->evaluated_at = now();
        $evaluation->save();

        foreach ($filteredScores as $criterionId => $score) {
            EmployeeEvaluationItem::create([
                'employee_evaluation_id' => $evaluation->id,
                'criterion_id' => $criterionId,
                'score' => $score,
                'notes' => null,
            ]);
        }

        $evaluation->load(['employee.department', 'evaluator']);

        if ($request->expectsJson()) {
            $rowHtml = view('hr.evaluations._row', compact('evaluation'))->render();

            return response()->json([
                'message' => 'Employee evaluation saved successfully.',
                'row' => $rowHtml,
            ]);
        }

        return redirect()
            ->route('hr.employee-evaluations.index')
            ->with('success', 'Employee evaluation saved successfully.');
    }
}

<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\HR\Employee;
use App\Models\HR\EmployeeEvaluation;
use App\Models\HR\EmployeeEvaluationItem;
use App\Models\HR\EvaluationCriterion;
use App\Services\Notifications\NotificationDispatcher;
use Illuminate\Http\JsonResponse;
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
            ->paginate(25);

        // For stats (all evaluations)
        $allEvaluations = EmployeeEvaluation::selectRaw('
            COUNT(*) as total,
            SUM(CASE WHEN overall_rating >= 5 THEN 1 ELSE 0 END) as good,
            SUM(CASE WHEN overall_rating < 5 THEN 1 ELSE 0 END) as low
        ')->first();

        $employees = Employee::active()
            ->with('department:id,name')
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get(['id', 'first_name', 'middle_name', 'last_name', 'department_id']);

        $criteria = EvaluationCriterion::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('hr.evaluations.index', compact('evaluations', 'employees', 'criteria', 'allEvaluations'));
    }

    public function store(Request $request): RedirectResponse|JsonResponse
    {
        // Check if we have active criteria
        $activeCriteria = EvaluationCriterion::where('is_active', true)->get();
        $hasCriteria = $activeCriteria->count() > 0;

        if ($hasCriteria) {
            $validated = $request->validate([
                'employee_id' => 'required|exists:employees,id',
                'scores' => 'required|array',
                'scores.*' => 'required|integer|min:1|max:10',
                'comments' => 'nullable|string|max:2000',
            ]);

            $scores = $validated['scores'];
            $activeCriteriaIds = $activeCriteria->pluck('id')->all();

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
        } else {
            // No criteria - use direct overall_rating
            $validated = $request->validate([
                'employee_id' => 'required|exists:employees,id',
                'overall_rating' => 'required|integer|min:1|max:10',
                'comments' => 'nullable|string|max:2000',
            ]);

            $overall = (int) $validated['overall_rating'];
            $filteredScores = [];
        }

        $evaluation = new EmployeeEvaluation();
        $evaluation->employee_id = $validated['employee_id'];
        $evaluation->evaluator_id = auth()->id();
        $evaluation->overall_rating = $overall;
        $evaluation->comments = $validated['comments'] ?? null;
        $evaluation->evaluated_at = now();
        $evaluation->save();

        // Save criterion scores if any
        foreach ($filteredScores as $criterionId => $score) {
            EmployeeEvaluationItem::create([
                'employee_evaluation_id' => $evaluation->id,
                'criterion_id' => $criterionId,
                'score' => $score,
                'notes' => null,
            ]);
        }

        $evaluation->load(['employee.department', 'evaluator']);

        // Send notification to employee
        $employee = Employee::find($validated['employee_id']);
        if ($employee && $employee->user_id) {
            $ratingText = $overall >= 8 ? 'Excellent' : ($overall >= 6 ? 'Good' : ($overall >= 4 ? 'Average' : 'Needs Improvement'));
            NotificationDispatcher::toUser(
                $employee->user_id,
                'evaluation.completed',
                'Performance Evaluation Completed',
                "Your performance evaluation has been completed. Overall Rating: {$overall}/10 ({$ratingText})",
                route('hr.employee-evaluations.index'),
                'clipboard-check',
                ['type' => $overall >= 6 ? 'success' : 'warning', 'actor_id' => auth()->id()]
            );
        }

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

    public function show(EmployeeEvaluation $evaluation): View
    {
        $evaluation->load(['employee.department', 'evaluator', 'items.criterion']);
        
        return view('hr.evaluations.show', compact('evaluation'));
    }

    public function destroy(EmployeeEvaluation $evaluation): RedirectResponse|JsonResponse
    {
        $employeeName = $evaluation->employee->full_name ?? 'Unknown';
        
        // Delete related items first
        $evaluation->items()->delete();
        $evaluation->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'message' => "Evaluation for {$employeeName} deleted successfully.",
            ]);
        }

        return redirect()
            ->route('hr.employee-evaluations.index')
            ->with('success', "Evaluation for {$employeeName} deleted successfully.");
    }

    public function exportPdf(EmployeeEvaluation $evaluation)
    {
        $evaluation->load(['employee.department', 'employee.company', 'evaluator', 'items.criterion']);
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('hr.evaluations.pdf', compact('evaluation'));
        $pdf->setPaper('a4', 'portrait');
        
        $filename = 'evaluation_' . ($evaluation->employee->full_name ?? 'employee') . '_' . $evaluation->evaluated_at->format('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }
}

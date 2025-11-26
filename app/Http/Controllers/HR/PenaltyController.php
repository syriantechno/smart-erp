<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\HR\Penalty;
use App\Models\HR\Employee;
use App\Helpers\Reply;
use App\Services\Notifications\NotificationDispatcher;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class PenaltyController extends Controller
{
    public function index(Request $request)
    {
        $employees = Employee::where('is_active', true)->orderBy('first_name')->get();
        
        return view('hr.penalties.index', compact('employees'));
    }

    public function getData(Request $request): JsonResponse
    {
        $query = Penalty::with(['employee.department', 'issuedBy', 'approvedBy']);

        if ($request->employee_id) {
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->date_from) {
            $query->where('penalty_date', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->where('penalty_date', '<=', $request->date_to);
        }

        $penalties = $query->orderBy('created_at', 'desc')->get();

        $data = $penalties->map(function ($penalty) {
            return [
                'id' => $penalty->id,
                'code' => $penalty->code,
                'employee' => [
                    'id' => $penalty->employee->id,
                    'name' => $penalty->employee->full_name,
                    'department' => $penalty->employee->department->name ?? 'N/A',
                ],
                'type' => $penalty->type,
                'type_label' => $penalty->type_label,
                'type_color' => $penalty->type_color,
                'category' => $penalty->category,
                'title' => $penalty->title,
                'amount' => $penalty->amount,
                'penalty_date' => $penalty->penalty_date->format('Y-m-d'),
                'severity' => $penalty->severity,
                'severity_color' => $penalty->severity_color,
                'status' => $penalty->status,
                'status_color' => $penalty->status_color,
                'deducted' => $penalty->deducted,
                'issued_by' => $penalty->issuedBy?->name,
            ];
        });

        $summary = [
            'total' => $penalties->count(),
            'written' => $penalties->where('type', 'written')->count(),
            'financial' => $penalties->where('type', 'financial')->count(),
            'total_amount' => $penalties->where('type', 'financial')->sum('amount'),
            'pending' => $penalties->where('status', 'pending')->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $data,
            'summary' => $summary,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required|exists:employees,id',
            'type' => 'required|in:written,financial',
            'category' => 'required|string|max:100',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required_if:type,financial|nullable|numeric|min:0',
            'penalty_date' => 'required|date',
            'severity' => 'required|in:minor,moderate,major,severe',
            'deduct_from_salary' => 'nullable|boolean',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return Reply::error('Validation error', ['errors' => $validator->errors()], 422);
        }

        try {
            $penalty = Penalty::create([
                'code' => $this->generateCode(),
                'employee_id' => $request->employee_id,
                'type' => $request->type,
                'category' => $request->category,
                'title' => $request->title,
                'description' => $request->description,
                'amount' => $request->type === 'financial' ? $request->amount : 0,
                'penalty_date' => $request->penalty_date,
                'effective_from' => $request->penalty_date,
                'severity' => $request->severity,
                'deduct_from_salary' => $request->type === 'financial' && $request->deduct_from_salary,
                'status' => 'pending',
                'issued_by' => auth()->id(),
                'notes' => $request->notes,
            ]);

            // Send notification to employee
            $employee = Employee::find($request->employee_id);
            if ($employee && $employee->user_id) {
                $typeLabel = $request->type === 'financial' ? 'Financial Penalty' : 'Written Warning';
                NotificationDispatcher::toUser(
                    $employee->user_id,
                    'penalty.created',
                    'New ' . $typeLabel,
                    "A {$typeLabel} has been issued to you: {$request->title}",
                    route('hr.penalties.index'),
                    'alert-triangle',
                    ['type' => 'warning', 'actor_id' => auth()->id()]
                );
            }

            return Reply::success('Penalty created successfully', ['penalty' => $penalty]);
        } catch (\Exception $e) {
            return Reply::error('Failed to create penalty: ' . $e->getMessage(), [], 500);
        }
    }

    public function show(Penalty $penalty): JsonResponse
    {
        $penalty->load(['employee.department', 'issuedBy', 'approvedBy']);

        return response()->json([
            'success' => true,
            'data' => $penalty,
        ]);
    }

    public function update(Request $request, Penalty $penalty): JsonResponse
    {
        if ($penalty->status === 'applied') {
            return Reply::error('Cannot update applied penalty', [], 400);
        }

        $validator = Validator::make($request->all(), [
            'type' => 'required|in:written,financial',
            'category' => 'required|string|max:100',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required_if:type,financial|nullable|numeric|min:0',
            'severity' => 'required|in:minor,moderate,major,severe',
            'deduct_from_salary' => 'nullable|boolean',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return Reply::error('Validation error', ['errors' => $validator->errors()], 422);
        }

        try {
            $penalty->update([
                'type' => $request->type,
                'category' => $request->category,
                'title' => $request->title,
                'description' => $request->description,
                'amount' => $request->type === 'financial' ? $request->amount : 0,
                'severity' => $request->severity,
                'deduct_from_salary' => $request->type === 'financial' && $request->deduct_from_salary,
                'notes' => $request->notes,
            ]);

            return Reply::success('Penalty updated successfully');
        } catch (\Exception $e) {
            return Reply::error('Failed to update penalty: ' . $e->getMessage(), [], 500);
        }
    }

    public function approve(Penalty $penalty): JsonResponse
    {
        if ($penalty->status !== 'pending') {
            return Reply::error('Only pending penalties can be approved', [], 400);
        }

        try {
            $penalty->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

            // Send notification to employee
            if ($penalty->employee && $penalty->employee->user_id) {
                NotificationDispatcher::toUser(
                    $penalty->employee->user_id,
                    'penalty.approved',
                    'Penalty Approved',
                    "Your penalty '{$penalty->title}' has been approved and will be applied.",
                    route('hr.penalties.index'),
                    'alert-circle',
                    ['type' => 'warning', 'actor_id' => auth()->id()]
                );
            }

            return Reply::success('Penalty approved successfully');
        } catch (\Exception $e) {
            return Reply::error('Failed to approve penalty: ' . $e->getMessage(), [], 500);
        }
    }

    public function reject(Penalty $penalty): JsonResponse
    {
        if ($penalty->status !== 'pending') {
            return Reply::error('Only pending penalties can be rejected', [], 400);
        }

        try {
            $penalty->update([
                'status' => 'rejected',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

            // Send notification to employee
            if ($penalty->employee && $penalty->employee->user_id) {
                NotificationDispatcher::toUser(
                    $penalty->employee->user_id,
                    'penalty.rejected',
                    'Penalty Rejected',
                    "Your penalty '{$penalty->title}' has been rejected.",
                    route('hr.penalties.index'),
                    'check-circle',
                    ['type' => 'success', 'actor_id' => auth()->id()]
                );
            }

            return Reply::success('Penalty rejected');
        } catch (\Exception $e) {
            return Reply::error('Failed to reject penalty: ' . $e->getMessage(), [], 500);
        }
    }

    public function destroy(Penalty $penalty): JsonResponse
    {
        if ($penalty->deducted) {
            return Reply::error('Cannot delete deducted penalty', [], 400);
        }

        try {
            $penalty->delete();
            return Reply::success('Penalty deleted successfully');
        } catch (\Exception $e) {
            return Reply::error('Failed to delete penalty: ' . $e->getMessage(), [], 500);
        }
    }

    protected function generateCode(): string
    {
        $prefix = 'PEN';
        $year = date('Y');
        
        $last = Penalty::where('code', 'like', "{$prefix}-{$year}-%")
            ->orderBy('code', 'desc')
            ->first();

        $number = $last ? ((int) substr($last->code, -4) + 1) : 1;

        return sprintf('%s-%s-%04d', $prefix, $year, $number);
    }
}

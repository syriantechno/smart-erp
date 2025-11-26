<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\HR\Advance;
use App\Models\HR\Employee;
use App\Models\User;
use App\Helpers\Reply;
use App\Services\Notifications\NotificationDispatcher;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class AdvanceController extends Controller
{
    public function index(Request $request)
    {
        $employees = Employee::where('is_active', true)->orderBy('first_name')->get();
        
        return view('hr.advances.index', compact('employees'));
    }

    public function getData(Request $request): JsonResponse
    {
        $query = Advance::with(['employee.department', 'requestedBy', 'approvedBy']);

        if ($request->employee_id) {
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $advances = $query->orderBy('created_at', 'desc')->get();

        $data = $advances->map(function ($advance) {
            return [
                'id' => $advance->id,
                'code' => $advance->code,
                'employee' => [
                    'id' => $advance->employee->id,
                    'name' => $advance->employee->full_name,
                    'department' => $advance->employee->department->name ?? 'N/A',
                ],
                'type' => $advance->type,
                'type_label' => $advance->type_label,
                'type_color' => $advance->type_color,
                'amount' => $advance->amount,
                'installments' => $advance->installments,
                'installment_amount' => $advance->installment_amount,
                'paid_installments' => $advance->paid_installments,
                'remaining_amount' => $advance->remaining_amount,
                'progress_percent' => $advance->progress_percent,
                'request_date' => $advance->request_date->format('Y-m-d'),
                'start_deduction_date' => $advance->start_deduction_date?->format('Y-m-d'),
                'status' => $advance->status,
                'status_color' => $advance->status_color,
                'requested_by' => $advance->requestedBy?->name,
            ];
        });

        $summary = [
            'total' => $advances->count(),
            'total_amount' => $advances->sum('amount'),
            'total_remaining' => $advances->where('status', 'disbursed')->sum('remaining_amount'),
            'pending' => $advances->where('status', 'pending')->count(),
            'active' => $advances->whereIn('status', ['approved', 'disbursed'])->where('remaining_amount', '>', 0)->count(),
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
            'type' => 'required|in:salary_advance,loan',
            'amount' => 'required|numeric|min:1',
            'reason' => 'nullable|string',
            'installments' => 'required|integer|min:1|max:60',
            'start_deduction_date' => 'required|date|after_or_equal:today',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return Reply::error('Validation error', ['errors' => $validator->errors()], 422);
        }

        try {
            $installmentAmount = round($request->amount / $request->installments, 2);

            $advance = Advance::create([
                'code' => $this->generateCode($request->type),
                'employee_id' => $request->employee_id,
                'type' => $request->type,
                'amount' => $request->amount,
                'reason' => $request->reason,
                'request_date' => now(),
                'installments' => $request->installments,
                'installment_amount' => $installmentAmount,
                'remaining_amount' => $request->amount,
                'start_deduction_date' => $request->start_deduction_date,
                'status' => 'pending',
                'requested_by' => auth()->id(),
                'notes' => $request->notes,
            ]);

            // Notify HR managers about new advance request
            $hrManagers = User::whereHas('roles', fn($q) => $q->whereIn('name', ['admin', 'hr_manager']))->pluck('id')->toArray();
            if (!empty($hrManagers)) {
                $employee = Employee::find($request->employee_id);
                $typeLabel = $request->type === 'loan' ? 'Loan' : 'Salary Advance';
                NotificationDispatcher::toUsers(
                    $hrManagers,
                    'advance.requested',
                    'New ' . $typeLabel . ' Request',
                    "{$employee->full_name} has requested a {$typeLabel} of " . number_format($request->amount, 2),
                    route('hr.advances.index'),
                    'hand-coins',
                    ['type' => 'info', 'actor_id' => auth()->id()]
                );
            }

            return Reply::success('Advance request created successfully', ['advance' => $advance]);
        } catch (\Exception $e) {
            return Reply::error('Failed to create advance request: ' . $e->getMessage(), [], 500);
        }
    }

    public function show(Advance $advance): JsonResponse
    {
        $advance->load(['employee.department', 'requestedBy', 'approvedBy', 'deductions.payroll']);

        return response()->json([
            'success' => true,
            'data' => $advance,
        ]);
    }

    public function update(Request $request, Advance $advance): JsonResponse
    {
        if (!in_array($advance->status, ['pending', 'approved'])) {
            return Reply::error('Cannot update this advance', [], 400);
        }

        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1',
            'reason' => 'nullable|string',
            'installments' => 'required|integer|min:1|max:60',
            'start_deduction_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return Reply::error('Validation error', ['errors' => $validator->errors()], 422);
        }

        try {
            $installmentAmount = round($request->amount / $request->installments, 2);

            $advance->update([
                'amount' => $request->amount,
                'reason' => $request->reason,
                'installments' => $request->installments,
                'installment_amount' => $installmentAmount,
                'remaining_amount' => $request->amount,
                'start_deduction_date' => $request->start_deduction_date,
                'notes' => $request->notes,
            ]);

            return Reply::success('Advance updated successfully');
        } catch (\Exception $e) {
            return Reply::error('Failed to update advance: ' . $e->getMessage(), [], 500);
        }
    }

    public function approve(Advance $advance): JsonResponse
    {
        if ($advance->status !== 'pending') {
            return Reply::error('Only pending advances can be approved', [], 400);
        }

        try {
            $advance->update([
                'status' => 'approved',
                'approval_date' => now(),
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

            // Notify employee
            if ($advance->employee && $advance->employee->user_id) {
                $typeLabel = $advance->type === 'loan' ? 'Loan' : 'Salary Advance';
                NotificationDispatcher::toUser(
                    $advance->employee->user_id,
                    'advance.approved',
                    $typeLabel . ' Approved',
                    "Your {$typeLabel} request of " . number_format($advance->amount, 2) . " has been approved.",
                    route('hr.advances.index'),
                    'check-circle',
                    ['type' => 'success', 'actor_id' => auth()->id()]
                );
            }

            return Reply::success('Advance approved successfully');
        } catch (\Exception $e) {
            return Reply::error('Failed to approve advance: ' . $e->getMessage(), [], 500);
        }
    }

    public function reject(Advance $advance): JsonResponse
    {
        if ($advance->status !== 'pending') {
            return Reply::error('Only pending advances can be rejected', [], 400);
        }

        try {
            $advance->update([
                'status' => 'rejected',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

            // Notify employee
            if ($advance->employee && $advance->employee->user_id) {
                $typeLabel = $advance->type === 'loan' ? 'Loan' : 'Salary Advance';
                NotificationDispatcher::toUser(
                    $advance->employee->user_id,
                    'advance.rejected',
                    $typeLabel . ' Rejected',
                    "Your {$typeLabel} request of " . number_format($advance->amount, 2) . " has been rejected.",
                    route('hr.advances.index'),
                    'x-circle',
                    ['type' => 'error', 'actor_id' => auth()->id()]
                );
            }

            return Reply::success('Advance rejected');
        } catch (\Exception $e) {
            return Reply::error('Failed to reject advance: ' . $e->getMessage(), [], 500);
        }
    }

    public function disburse(Advance $advance): JsonResponse
    {
        if ($advance->status !== 'approved') {
            return Reply::error('Only approved advances can be disbursed', [], 400);
        }

        try {
            $advance->update([
                'status' => 'disbursed',
                'disbursement_date' => now(),
            ]);

            // Notify employee
            if ($advance->employee && $advance->employee->user_id) {
                $typeLabel = $advance->type === 'loan' ? 'Loan' : 'Salary Advance';
                NotificationDispatcher::toUser(
                    $advance->employee->user_id,
                    'advance.disbursed',
                    $typeLabel . ' Disbursed',
                    "Your {$typeLabel} of " . number_format($advance->amount, 2) . " has been disbursed. Monthly deduction: " . number_format($advance->installment_amount, 2),
                    route('hr.advances.index'),
                    'banknote',
                    ['type' => 'success', 'actor_id' => auth()->id()]
                );
            }

            return Reply::success('Advance disbursed successfully');
        } catch (\Exception $e) {
            return Reply::error('Failed to disburse advance: ' . $e->getMessage(), [], 500);
        }
    }

    public function destroy(Advance $advance): JsonResponse
    {
        if ($advance->paid_installments > 0) {
            return Reply::error('Cannot delete advance with paid installments', [], 400);
        }

        try {
            $advance->delete();
            return Reply::success('Advance deleted successfully');
        } catch (\Exception $e) {
            return Reply::error('Failed to delete advance: ' . $e->getMessage(), [], 500);
        }
    }

    protected function generateCode(string $type): string
    {
        $prefix = $type === 'salary_advance' ? 'ADV' : 'LOAN';
        $year = date('Y');
        
        $last = Advance::where('code', 'like', "{$prefix}-{$year}-%")
            ->orderBy('code', 'desc')
            ->first();

        $number = $last ? ((int) substr($last->code, -4) + 1) : 1;

        return sprintf('%s-%s-%04d', $prefix, $year, $number);
    }
}

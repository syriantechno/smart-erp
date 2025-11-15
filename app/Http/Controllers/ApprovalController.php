<?php

namespace App\Http\Controllers;

use App\Models\ApprovalRequest;
use App\Models\ApprovalLog;
use App\Models\Department;
use App\Models\Company;
use App\Models\User;
use App\Services\DocumentCodeGenerator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class ApprovalController extends Controller
{
    public function __construct(private DocumentCodeGenerator $codeGenerator)
    {
    }

    public function index(Request $request)
    {
        $companies = Company::active()->select('id', 'name')->get();
        $departments = Department::active()->select('id', 'name')->get();
        $users = User::select('id', 'name')->get();

        // Get counts for dashboard
        $myRequestsCount = ApprovalRequest::myRequests(auth()->id())->count();
        $pendingApprovalCount = ApprovalRequest::pendingMyApproval(auth()->id())->count();
        $approvedCount = ApprovalRequest::approved()->where('requester_id', auth()->id())->count();
        $rejectedCount = ApprovalRequest::rejected()->where('requester_id', auth()->id())->count();

        $currentTab = $request->get('tab', 'my-requests');

        return view('approval-system.index', compact(
            'companies',
            'departments',
            'users',
            'myRequestsCount',
            'pendingApprovalCount',
            'approvedCount',
            'rejectedCount',
            'currentTab'
        ));
    }

    public function datatable(Request $request): JsonResponse
    {
        $tab = $request->get('tab', 'my-requests');

        $query = ApprovalRequest::query()
            ->with(['requester:id,name', 'currentApprover:id,name', 'department:id,name']);

        // Apply tab filter
        switch ($tab) {
            case 'my-requests':
                $query->myRequests(auth()->id());
                break;
            case 'pending-approval':
                $query->pendingMyApproval(auth()->id());
                break;
            case 'approved':
                $query->approved()->where('requester_id', auth()->id());
                break;
            case 'rejected':
                $query->rejected()->where('requester_id', auth()->id());
                break;
            case 'all':
                // Show all requests user can see (their requests + requests they can approve)
                $query->where(function ($q) {
                    $q->where('requester_id', auth()->id())
                      ->orWhere('current_approver_id', auth()->id());
                });
                break;
        }

        // Apply filters
        if ($request->filled('type_filter') && $request->type_filter !== '') {
            $query->where('type', $request->type_filter);
        }

        if ($request->filled('status_filter') && $request->status_filter !== '') {
            $query->where('status', $request->status_filter);
        }

        if ($request->filled('priority_filter') && $request->priority_filter !== '') {
            $query->where('priority', $request->priority_filter);
        }

        if ($request->filled('date_from') && $request->date_from !== '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to') && $request->date_to !== '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        return DataTables::of($query)
            ->addColumn('type_badge', function ($request) {
                $class = $request->type_badge_class;
                $label = $request->type_label;
                return "<span class='px-2 py-1 text-xs font-medium rounded-full {$class}'>{$label}</span>";
            })
            ->addColumn('status_badge', function ($request) {
                $class = $request->status_badge_class;
                $label = ucfirst($request->status);
                return "<span class='px-2 py-1 text-xs font-medium rounded-full {$class}'>{$label}</span>";
            })
            ->addColumn('priority_badge', function ($request) {
                $class = $request->priority_badge_class;
                $label = ucfirst($request->priority);
                return "<span class='px-2 py-1 text-xs font-medium rounded-full {$class}'>{$label}</span>";
            })
            ->addColumn('requester_name', function ($request) {
                return $request->requester ? $request->requester->name : 'Unknown';
            })
            ->addColumn('approver_name', function ($request) {
                return $request->currentApprover ? $request->currentApprover->name : 'Not Assigned';
            })
            ->addColumn('amount_formatted', function ($request) {
                return $request->amount ? '$' . number_format($request->amount, 2) : '-';
            })
            ->addColumn('date', function ($request) {
                return $request->formatted_date;
            })
            ->addColumn('actions', function ($request) use ($tab) {
                $actions = '';

                if ($tab === 'pending-approval' && $request->canBeApprovedBy(auth()->id())) {
                    $actions .= "
                        <button
                            type='button'
                            onclick='approveRequest({$request->id}); return false;'
                            class='inline-flex items-center justify-center p-2 text-emerald-600 transition hover:text-emerald-800 focus:outline-none'
                            title='Approve'
                        >
                            <svg class='w-4 h-4' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 13l4 4L19 7'/>
                            </svg>
                        </button>
                        <button
                            type='button'
                            onclick='rejectRequest({$request->id}); return false;'
                            class='inline-flex items-center justify-center p-2 text-red-600 transition hover:text-red-800 focus:outline-none'
                            title='Reject'
                        >
                            <svg class='w-4 h-4' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6 18L18 6M6 6l12 12'/>
                            </svg>
                        </button>
                    ";
                }

                $actions .= "
                    <button
                        type='button'
                        onclick='viewRequest({$request->id}); return false;'
                        class='inline-flex items-center justify-center p-2 text-slate-600 transition hover:text-primary focus:outline-none'
                        title='View Details'
                    >
                        <svg class='w-4 h-4' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15 12a3 3 0 11-6 0 3 3 0 016 0z'/>
                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z'/>
                        </svg>
                    </button>
                ";

                return "<div class='flex items-center justify-center gap-2'>{$actions}</div>";
            })
            ->rawColumns(['type_badge', 'status_badge', 'priority_badge', 'actions'])
            ->make(true);
    }

    public function create()
    {
        $companies = Company::active()->select('id', 'name')->get();
        $departments = Department::active()->select('id', 'name')->get();
        $users = User::select('id', 'name')->get();

        return view('approval-system.create', compact('companies', 'departments', 'users'));
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:leave_request,purchase_request,expense_claim,loan_request,overtime_request,training_request,equipment_request,other',
            'priority' => 'required|in:low,normal,high,urgent',
            'amount' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'department_id' => 'nullable|exists:departments,id',
            'company_id' => 'nullable|exists:companies,id',
            'attachments.*' => 'nullable|file|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $data = $request->all();

            // Generate code
            $data['code'] = $this->codeGenerator->generate('approval_requests');
            $data['requester_id'] = auth()->id();

            // Calculate duration if dates provided
            if ($request->start_date && $request->end_date) {
                $start = \Carbon\Carbon::parse($request->start_date);
                $end = \Carbon\Carbon::parse($request->end_date);
                $data['duration_days'] = $start->diffInDays($end) + 1;
            }

            // Handle file attachments
            if ($request->hasFile('attachments')) {
                $attachments = [];
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('approval-attachments', 'public');
                    $attachments[] = [
                        'name' => $file->getClientOriginalName(),
                        'path' => $path,
                        'size' => $file->getSize(),
                        'mime_type' => $file->getMimeType(),
                    ];
                }
                $data['attachments'] = $attachments;
            }

            // Set up approval workflow based on type and amount
            $data['approval_levels'] = $this->setupApprovalLevels($request->type, $request->amount, $request->department_id);
            $data['current_approver_id'] = $data['approval_levels'][0]['approver_id'] ?? null;

            $approvalRequest = ApprovalRequest::create($data);

            // Log submission
            $approvalRequest->logs()->create([
                'action' => 'submitted',
                'user_id' => auth()->id(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Approval request submitted successfully',
                'request_id' => $approvalRequest->id
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit approval request: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(ApprovalRequest $approvalRequest): JsonResponse
    {
        $approvalRequest->load([
            'requester',
            'currentApprover',
            'department',
            'company',
            'logs.user'
        ]);

        return response()->json([
            'success' => true,
            'request' => $approvalRequest
        ]);
    }

    public function approve(Request $request, ApprovalRequest $approvalRequest): JsonResponse
    {
        if (!$approvalRequest->canBeApprovedBy(auth()->id())) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to approve this request'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'comments' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $approvalRequest->approve(auth()->id(), $request->comments);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Request approved successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to approve request: ' . $e->getMessage()
            ], 500);
        }
    }

    public function reject(Request $request, ApprovalRequest $approvalRequest): JsonResponse
    {
        if (!$approvalRequest->canBeApprovedBy(auth()->id())) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to reject this request'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'reason' => 'required|string|max:1000',
            'comments' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $approvalRequest->reject(auth()->id(), $request->reason, $request->comments);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Request rejected successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to reject request: ' . $e->getMessage()
            ], 500);
        }
    }

    private function setupApprovalLevels($type, $amount, $departmentId)
    {
        $levels = [];

        // Basic approval workflow - can be customized based on business rules
        // Level 1: Department Manager
        if ($departmentId) {
            $department = Department::find($departmentId);
            if ($department && $department->manager_id) {
                $levels[] = [
                    'level' => 1,
                    'approver_id' => $department->manager_id,
                    'role' => 'Department Manager'
                ];
            }
        }

        // Level 2: Higher management for large amounts or certain types
        if ($amount > 1000 || in_array($type, ['loan_request', 'equipment_request'])) {
            // Add higher level approver (can be customized)
            $levels[] = [
                'level' => 2,
                'approver_id' => 1, // Admin user as example
                'role' => 'Senior Management'
            ];
        }

        return $levels;
    }

    public function getStats(): JsonResponse
    {
        $userId = auth()->id();

        $stats = [
            'my_requests' => ApprovalRequest::myRequests($userId)->count(),
            'pending_approval' => ApprovalRequest::pendingMyApproval($userId)->count(),
            'approved' => ApprovalRequest::approved()->where('requester_id', $userId)->count(),
            'rejected' => ApprovalRequest::rejected()->where('requester_id', $userId)->count(),
            'total_pending' => ApprovalRequest::pending()->count(),
        ];

        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }
}

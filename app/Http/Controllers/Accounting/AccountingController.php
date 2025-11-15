<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Models\Accounting;
use App\Models\JournalEntry;
use App\Models\JournalEntryLine;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class AccountingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('accounting.chart-of-accounts.index');
    }

    /**
     * Get accounts data for DataTables
     */
    public function datatable(Request $request): JsonResponse
    {
        try {
            Log::info('Accounting datatable called with params:', $request->all());

            $accounts = Accounting::with(['parent', 'children'])
                ->select(['id', 'code', 'name', 'type', 'category', 'parent_id', 'level', 'is_active', 'created_at']);

            Log::info('Accounts query count:', ['count' => $accounts->count()]);

            return \Yajra\DataTables\Facades\DataTables::of($accounts)
                ->addIndexColumn()
                ->orderColumn('DT_RowIndex', 'id $1')
                ->addColumn('parent_name', function ($account) {
                    return $account->parent?->name ?? 'Root Account';
                })
                ->addColumn('type_badge', function ($account) {
                    $color = $account->type_color;
                    $label = $account->type_label;
                    return '<span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold bg-' . $color . '-100 text-' . $color . '-700">' . $label . '</span>';
                })
                ->addColumn('balance_formatted', function ($account) {
                    return $account->balance_formatted;
                })
                ->addColumn('status', function ($account) {
                    return $account->is_active ?
                        '<span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold bg-green-100 text-green-700">Active</span>' :
                        '<span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold bg-red-100 text-red-700">Inactive</span>';
                })
                ->addColumn('actions', function ($account) {
                    try {
                        return view('accounting.chart-of-accounts.partials.actions', compact('account'))->render();
                    } catch (\Exception $e) {
                        Log::error('Error rendering actions view:', $e->getMessage());
                        return 'Error: ' . $e->getMessage();
                    }
                })
                ->rawColumns(['type_badge', 'status', 'actions'])
                ->toJson();
        } catch (\Exception $e) {
            Log::error('Accounting datatable error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'Database error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created account
     */
    public function store(Request $request): JsonResponse
    {
        Log::info('Accounting store called with data:', $request->all());

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:asset,liability,equity,income,expense',
            'category' => 'nullable|in:current_asset,fixed_asset,current_liability,long_term_liability,owner_equity,retained_earnings,operating_income,other_income,cost_of_goods_sold,operating_expense,other_expense',
            'parent_id' => 'nullable|exists:accountings,id',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            Log::warning('Accounting validation failed:', $validator->errors()->toArray());
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Calculate level based on parent
            $level = 1;
            if ($request->parent_id) {
                $parent = Accounting::find($request->parent_id);
                $level = $parent ? $parent->level + 1 : 1;
            }

            $account = Accounting::create([
                'code' => Accounting::generateUniqueCode(),
                'name' => $request->name,
                'description' => $request->description,
                'type' => $request->type,
                'category' => $request->category,
                'parent_id' => $request->parent_id,
                'level' => $level,
                'is_active' => $request->is_active ?? true
            ]);

            Log::info('Account created successfully:', $account->toArray());

            return response()->json([
                'success' => true,
                'message' => 'Account created successfully',
                'data' => $account
            ]);
        } catch (\Exception $e) {
            Log::error('Account creation failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to create account',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update account status
     */
    public function updateStatus(Request $request, Accounting $account): JsonResponse
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'is_active' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $account->update([
                'is_active' => $request->is_active
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Account status updated successfully',
                'data' => $account
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update account status',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get accounts for dropdown
     */
    public function getAccounts(Request $request): JsonResponse
    {
        try {
            $accounts = Accounting::active()
                ->select(['id', 'code', 'name', 'type', 'level'])
                ->get()
                ->map(function ($account) {
                    return [
                        'id' => $account->id,
                        'text' => str_repeat('— ', $account->level - 1) . $account->code . ' - ' . $account->name,
                        'type' => $account->type
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $accounts
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get accounts',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export accounts data
     */
    public function export(Request $request): JsonResponse
    {
        try {
            $accounts = Accounting::with(['parent'])
                ->get();

            $csvData = [];
            $csvData[] = ['Code', 'Name', 'Type', 'Category', 'Parent Account', 'Level', 'Status', 'Balance'];

            foreach ($accounts as $account) {
                $csvData[] = [
                    $account->code,
                    $account->name,
                    $account->type_label,
                    $account->category_label,
                    $account->parent?->name ?? 'Root Account',
                    $account->level,
                    $account->is_active ? 'Active' : 'Inactive',
                    $account->balance_formatted
                ];
            }

            return response()->json([
                'success' => true,
                'message' => 'Accounts data exported successfully',
                'data' => $csvData
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to export accounts data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display journal entries page
     */
    public function journalEntries(): View
    {
        return view('accounting.journal-entries.index');
    }

    /**
     * Get journal entries data for DataTables
     */
    public function journalEntriesDatatable(Request $request): JsonResponse
    {
        try {
            $entries = JournalEntry::with(['creator'])
                ->select(['id', 'reference_number', 'entry_date', 'description', 'status', 'total_debit', 'total_credit', 'created_by', 'created_at']);

            return \Yajra\DataTables\Facades\DataTables::of($entries)
                ->addIndexColumn()
                ->orderColumn('DT_RowIndex', 'id $1')
                ->addColumn('creator_name', function ($entry) {
                    return $entry->creator?->name ?? 'System';
                })
                ->addColumn('status_badge', function ($entry) {
                    $color = $entry->status_color;
                    $label = $entry->status_label;
                    $balancedIcon = $entry->is_balanced ? ' ✓' : ' ⚠';
                    return '<span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold bg-' . $color . '-100 text-' . $color . '-700">' . $label . $balancedIcon . '</span>';
                })
                ->addColumn('total_debit_formatted', function ($entry) {
                    return $entry->total_debit_formatted;
                })
                ->addColumn('total_credit_formatted', function ($entry) {
                    return $entry->total_credit_formatted;
                })
                ->addColumn('actions', function ($entry) {
                    try {
                        return view('accounting.journal-entries.partials.actions', compact('entry'))->render();
                    } catch (\Exception $e) {
                        return 'Error: ' . $e->getMessage();
                    }
                })
                ->rawColumns(['status_badge', 'actions'])
                ->toJson();
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Database error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get journal entries statistics
     */
    public function journalEntriesStats(Request $request): JsonResponse
    {
        try {
            $stats = [
                'total_entries' => JournalEntry::count(),
                'draft_entries' => JournalEntry::where('status', 'draft')->count(),
                'posted_entries' => JournalEntry::where('status', 'posted')->count(),
                'voided_entries' => JournalEntry::where('status', 'voided')->count(),
                'unbalanced_entries' => JournalEntry::whereRaw('ABS(total_debit - total_credit) > 0.01')->count(),
                'total_debit' => JournalEntry::sum('total_debit'),
                'total_credit' => JournalEntry::sum('total_credit')
            ];

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get journal entries stats',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

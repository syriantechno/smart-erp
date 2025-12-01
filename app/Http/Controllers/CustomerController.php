<?php

namespace App\Http\Controllers;

use App\Exports\CustomersExport;
use App\Models\Customer;
use App\Models\User;
use App\Models\Accounting\JournalEntryLine;
use App\Services\Accounting\LinkedAccountManager;
use App\Services\DocumentCodeGenerator;
use App\Services\Notifications\NotificationDispatcher;
use App\Services\PdfExporter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    protected $codeGenerator;
    protected $linkedAccountManager;
    protected PdfExporter $pdfExporter;

    public function __construct(DocumentCodeGenerator $codeGenerator, LinkedAccountManager $linkedAccountManager, PdfExporter $pdfExporter)
    {
        $this->codeGenerator = $codeGenerator;
        $this->linkedAccountManager = $linkedAccountManager;
        $this->pdfExporter = $pdfExporter;
    }

    public function index(): \Illuminate\View\View
    {
        $totalCustomers = Customer::count();
        $activeCustomers = Customer::where('status', 'active')->count();
        $inactiveCustomers = $totalCustomers - $activeCustomers;

        return view('customers.index', [
            'totalCustomers' => $totalCustomers,
            'activeCustomers' => $activeCustomers,
            'inactiveCustomers' => $inactiveCustomers,
        ]);
    }

    public function datatable(): JsonResponse
    {
        $customers = Customer::query()->with('account');

        // Apply advanced search filter
        $field = request('field', 'all');
        $type = request('type', 'contains');
        $value = request('value');

        if ($field !== 'all' && !empty($value)) {
            $operator = $type === 'equals' ? '=' : 'like';
            $searchValue = $type === 'equals' ? $value : "%{$value}%";

            $customers->where($field, $operator, $searchValue);
        }

        // Apply status filter
        if (request()->has('status') && request('status') !== '' && request('status') !== null) {
            $status = request('status');
            $customers->where('status', $status);
        }

        return DataTables::of($customers)
            ->addColumn('linked_account', function ($customer) {
                if ($customer->account) {
                    return '<a href="' . route('accounting.chart-of-accounts.index') . '" class="text-primary hover:underline" title="View in Chart of Accounts">' . $customer->account->code . ' - ' . $customer->account->name . '</a>';
                }
                return '<span class="text-gray-400">No account linked</span>';
            })
            ->addColumn('credit_limit_formatted', function ($customer) {
                return $customer->credit_limit ? '$' . number_format($customer->credit_limit, 2) : '-';
            })
            ->addColumn('action', function ($customer) {
                return view('customers.partials.actions', compact('customer'))->render();
            })
            ->addIndexColumn()
            ->rawColumns(['linked_account', 'action'])
            ->make(true);
    }

    public function previewCode(): JsonResponse
    {
        $code = $this->codeGenerator->preview('customers');
        return response()->json(['code' => $code]);
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'code' => 'required|string|unique:customers',
                'name' => 'required|string|max:255',
                'email' => 'nullable|email|max:255',
                'phone' => 'nullable|string|max:20',
                'mobile' => 'nullable|string|max:20',
                'address' => 'nullable|string',
                'tax_id' => 'nullable|string|max:50',
                'customer_type' => 'required|in:individual,company',
                'credit_limit' => 'nullable|numeric|min:0',
                'payment_terms' => 'nullable|string|max:255',
                'account_id' => 'nullable|exists:accountings,id',
                'notes' => 'nullable|string',
                'status' => 'required|in:active,inactive,suspended'
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }

            $validatedData = $validator->validated();

            // Ensure linked account exists
            if (empty($validatedData['account_id'])) {
                $validatedData['account_id'] = $this->linkedAccountManager->ensureCustomerAccount(null, $validatedData['name']);
            }

            $validatedData['created_by'] = $request->user()->id;

            $customer = Customer::create($validatedData);

            // Notify sales team
            $salesTeam = User::whereHas('roles', fn($q) => $q->whereIn('name', ['admin', 'sales_manager']))->pluck('id')->toArray();
            if (!empty($salesTeam)) {
                NotificationDispatcher::toUsers(
                    $salesTeam,
                    'customer.created',
                    'New Customer Added',
                    "Customer '{$customer->name}' ({$customer->code}) has been added.",
                    route('customers.index'),
                    'user-plus',
                    ['type' => 'info', 'actor_id' => auth()->id()]
                );
            }

            return response()->json(['success' => true, 'message' => 'Customer created successfully', 'customer' => $customer]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function show(Customer $customer): JsonResponse
    {
        return response()->json(['success' => true, 'customer' => $customer->load('account')]);
    }

    public function update(Request $request, Customer $customer): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'code' => ['required', Rule::unique('customers')->ignore($customer->id)],
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'mobile' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'tax_id' => 'nullable|string|max:50',
            'customer_type' => 'required|in:individual,company',
            'credit_limit' => 'nullable|numeric|min:0',
            'payment_terms' => 'nullable|string|max:255',
            'account_id' => 'nullable|exists:accountings,id',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,inactive,suspended'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();

        // Ensure linked account exists
        if (empty($validatedData['account_id'])) {
            $validatedData['account_id'] = $this->linkedAccountManager->ensureCustomerAccount(null, $validatedData['name']);
        }

        $validatedData['updated_by'] = $request->user()->id;

        $customer->update($validatedData);
        return response()->json(['success' => true, 'message' => 'Customer updated successfully', 'customer' => $customer->fresh()]);
    }

    public function destroy(Customer $customer): JsonResponse
    {
        $customer->delete();
        return response()->json(['success' => true, 'message' => 'Customer deleted successfully']);
    }

    public function statement(Request $request, Customer $customer)
    {
        $customer->load('account');

        $data = $this->buildCustomerStatementData($customer, $request);

        return view('customers.statement', $data);
    }

    public function statementPdf(Request $request, Customer $customer)
    {
        $customer->load('account');

        $data = $this->buildCustomerStatementData($customer, $request);

        return $this->pdfExporter->stream(
            'customers.statement_pdf',
            $data,
            'customer-statement-' . ($customer->code ?? $customer->id) . '.pdf'
        );
    }

    protected function buildCustomerStatementData(Customer $customer, Request $request): array
    {
        $customer->loadMissing('account');
        $account = $customer->account;

        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        if (!$account) {
            return [
                'customer' => $customer,
                'account' => null,
                'dateFrom' => $dateFrom,
                'dateTo' => $dateTo,
                'openingBalance' => 0,
                'totalDebit' => 0,
                'totalCredit' => 0,
                'closingBalance' => 0,
                'closingBalanceAbs' => 0,
                'closingBalanceType' => null,
                'transactions' => collect(),
            ];
        }

        $baseQuery = JournalEntryLine::with('journalEntry')
            ->where('account_id', $account->id)
            ->whereHas('journalEntry', function ($q) {
                $q->where('status', 'posted');
            });

        $openingBalance = 0;
        if ($dateFrom) {
            $openingBalance = (clone $baseQuery)
                ->whereHas('journalEntry', function ($q) use ($dateFrom) {
                    $q->where('entry_date', '<', $dateFrom);
                })
                ->selectRaw('COALESCE(SUM(debit - credit), 0) as balance')
                ->value('balance');
        }

        $transactionsQuery = clone $baseQuery;

        if ($dateFrom) {
            $transactionsQuery->whereHas('journalEntry', function ($q) use ($dateFrom) {
                $q->where('entry_date', '>=', $dateFrom);
            });
        }

        if ($dateTo) {
            $transactionsQuery->whereHas('journalEntry', function ($q) use ($dateTo) {
                $q->where('entry_date', '<=', $dateTo);
            });
        }

        $lines = $transactionsQuery
            ->get()
            ->sortBy(function (JournalEntryLine $line) {
                $date = optional(optional($line->journalEntry)->entry_date)->format('Y-m-d') ?? '0000-00-00';
                return $date . '-' . str_pad((string) $line->id, 6, '0', STR_PAD_LEFT);
            })
            ->values();

        $totalDebit = $lines->sum('debit');
        $totalCredit = $lines->sum('credit');

        $runningBalance = $openingBalance;
        $transactions = $lines->map(function (JournalEntryLine $line) use (&$runningBalance) {
            $runningBalance += ((float) $line->debit - (float) $line->credit);

            return [
                'date' => optional(optional($line->journalEntry)->entry_date)->format('Y-m-d'),
                'reference' => optional($line->journalEntry)->reference_number,
                'description' => optional($line->journalEntry)->description ?: $line->memo,
                'debit' => (float) $line->debit,
                'credit' => (float) $line->credit,
                'balance' => $runningBalance,
            ];
        });

        $closingBalance = $runningBalance;
        $closingBalanceAbs = abs($closingBalance);
        $closingBalanceType = $closingBalance > 0 ? 'debit' : ($closingBalance < 0 ? 'credit' : null);

        return [
            'customer' => $customer,
            'account' => $account,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'openingBalance' => $openingBalance,
            'totalDebit' => $totalDebit,
            'totalCredit' => $totalCredit,
            'closingBalance' => $closingBalance,
            'closingBalanceAbs' => $closingBalanceAbs,
            'closingBalanceType' => $closingBalanceType,
            'transactions' => $transactions,
        ];
    }

    public function exportPdf(Request $request)
    {
        $customers = Customer::query()
            ->with('account');

        // نفس منطق الفلاتر المستخدم في datatable()
        $field = $request->input('field', 'all');
        $type = $request->input('type', 'contains');
        $value = $request->input('value');

        if ($field !== 'all' && !empty($value)) {
            $operator = $type === 'equals' ? '=' : 'like';
            $searchValue = $type === 'equals' ? $value : "%{$value}%";

            $customers->where($field, $operator, $searchValue);
        }

        if ($request->filled('status')) {
            $customers->where('status', $request->input('status'));
        }

        $customers = $customers
            ->orderBy('name')
            ->get();

        return $this->pdfExporter->stream(
            'customers.export_pdf',
            [
                'customers' => $customers,
                'exportedAt' => now(),
            ],
            'customers.pdf'
        );
    }

    public function exportExcel(Request $request)
    {
        $customersQuery = Customer::query()
            ->with('account');

        // نفس منطق الفلاتر المستخدم في datatable()
        $field = $request->input('field', 'all');
        $type = $request->input('type', 'contains');
        $value = $request->input('value');

        if ($field !== 'all' && !empty($value)) {
            $operator = $type === 'equals' ? '=' : 'like';
            $searchValue = $type === 'equals' ? $value : "%{$value}%";

            $customersQuery->where($field, $operator, $searchValue);
        }

        if ($request->filled('status')) {
            $customersQuery->where('status', $request->input('status'));
        }

        $customers = $customersQuery
            ->orderBy('name')
            ->get();

        return Excel::download(new CustomersExport($customers), 'customers.xlsx');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use App\Services\Accounting\LinkedAccountManager;
use App\Services\DocumentCodeGenerator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    protected $codeGenerator;
    protected $linkedAccountManager;

    public function __construct(DocumentCodeGenerator $codeGenerator, LinkedAccountManager $linkedAccountManager)
    {
        $this->codeGenerator = $codeGenerator;
        $this->linkedAccountManager = $linkedAccountManager;
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
}

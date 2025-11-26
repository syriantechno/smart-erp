<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Supplier\Vendor;
use App\Models\User;
use App\Services\Accounting\LinkedAccountManager;
use App\Services\DocumentCodeGenerator;
use App\Services\Notifications\NotificationDispatcher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class VendorController extends Controller
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
        $totalVendors = Vendor::count();
        $activeVendors = Vendor::where('is_active', true)->count();
        $inactiveVendors = $totalVendors - $activeVendors;

        return view('supplier.vendors.index', [
            'totalVendors' => $totalVendors,
            'activeVendors' => $activeVendors,
            'inactiveVendors' => $inactiveVendors,
        ]);
    }

    public function datatable(): JsonResponse
    {
        $vendors = Vendor::query()->with('account');

        // Apply advanced search filter
        $field = request('field', 'all');
        $type = request('type', 'contains');
        $value = request('value');

        if ($field !== 'all' && !empty($value)) {
            $operator = $type === 'equals' ? '=' : 'like';
            $searchValue = $type === 'equals' ? $value : "%{$value}%";

            $vendors->where($field, $operator, $searchValue);
        }

        // Apply status filter - only if status is explicitly set to 0 or 1
        if (request()->has('status') && request('status') !== '' && request('status') !== null) {
            $status = request('status');
            // Convert string to boolean
            $vendors->where('is_active', $status == '1' || $status === true ? 1 : 0);
        }

        return DataTables::of($vendors)
            ->addColumn('linked_account', function ($vendor) {
                if ($vendor->account) {
                    return '<a href="' . route('accounting.chart-of-accounts.index') . '" class="text-primary hover:underline" title="View in Chart of Accounts">' . $vendor->account->code . ' - ' . $vendor->account->name . '</a>';
                }
                return '<span class="text-gray-400">No account linked</span>';
            })
            ->addColumn('action', function ($vendor) {
                return view('supplier.vendors.partials.actions', compact('vendor'))->render();
            })
            ->addIndexColumn()
            ->rawColumns(['linked_account', 'action'])
            ->make(true);
    }

    public function previewCode(): JsonResponse
    {
        $code = $this->codeGenerator->preview('vendors');
        return response()->json(['code' => $code]);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|unique:vendors',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'contact_person' => 'nullable|string|max:255',
            'contact_person_phone' => 'nullable|string|max:20',
            'contact_person_email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'tax_id' => 'nullable|string|max:50',
            'payment_terms' => 'nullable|string|max:255',
            'account_id' => 'nullable|exists:accountings,id',
            'notes' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();

        // Ensure linked account exists
        if (empty($validatedData['account_id'])) {
            $validatedData['account_id'] = $this->linkedAccountManager->ensureVendorAccount(null, $validatedData['name']);
        }

        $vendor = Vendor::create($validatedData);

        // Notify purchasing team
        $purchasingTeam = User::whereHas('roles', fn($q) => $q->whereIn('name', ['admin', 'purchasing_manager']))->pluck('id')->toArray();
        if (!empty($purchasingTeam)) {
            NotificationDispatcher::toUsers(
                $purchasingTeam,
                'vendor.created',
                'New Vendor Added',
                "Vendor '{$vendor->name}' ({$vendor->code}) has been added.",
                route('supplier.vendors.index'),
                'truck',
                ['type' => 'info', 'actor_id' => auth()->id()]
            );
        }

        return response()->json(['success' => true, 'message' => 'Vendor created successfully', 'vendor' => $vendor]);
    }

    public function show(Vendor $vendor): JsonResponse
    {
        return response()->json(['success' => true, 'vendor' => $vendor]);
    }

    public function update(Request $request, Vendor $vendor): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'code' => ['required', Rule::unique('vendors')->ignore($vendor->id)],
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'contact_person' => 'nullable|string|max:255',
            'contact_person_phone' => 'nullable|string|max:20',
            'contact_person_email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'tax_id' => 'nullable|string|max:50',
            'payment_terms' => 'nullable|string|max:255',
            'account_id' => 'nullable|exists:accountings,id',
            'notes' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();

        // Ensure linked account exists
        if (empty($validatedData['account_id'])) {
            $validatedData['account_id'] = $this->linkedAccountManager->ensureVendorAccount(null, $validatedData['name']);
        }

        $vendor->update($validatedData);
        return response()->json(['success' => true, 'message' => 'Vendor updated successfully', 'vendor' => $vendor]);
    }

    public function destroy(Vendor $vendor): JsonResponse
    {
        $vendor->delete();
        return response()->json(['success' => true, 'message' => 'Vendor deleted successfully']);
    }
}

<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Supplier\Vendor;
use App\Services\DocumentCodeGenerator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class VendorController extends Controller
{
    protected $codeGenerator;

    public function __construct(DocumentCodeGenerator $codeGenerator)
    {
        $this->codeGenerator = $codeGenerator;
    }

    public function index(): \Illuminate\View\View
    {
        return view('supplier.vendors.index');
    }

    public function datatable(): JsonResponse
    {
        $vendors = Vendor::query();

        // Apply search filter
        if (request()->has('search') && !empty(request('search'))) {
            $search = request('search');
            $vendors->where(function ($query) use ($search) {
                $query->where('code', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('contact_person', 'like', "%{$search}%");
            });
        }

        // Apply status filter - only if status is explicitly set to 0 or 1
        if (request()->has('status') && request('status') !== '' && request('status') !== null) {
            $status = request('status');
            // Convert string to boolean
            $vendors->where('is_active', $status == '1' || $status === true ? 1 : 0);
        }

        return DataTables::of($vendors)
            ->addColumn('action', function ($vendor) {
                return view('supplier.vendors.partials.actions', compact('vendor'))->render();
            })
            ->addIndexColumn()
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
            'notes' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $vendor = Vendor::create($request->all());
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
            'notes' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $vendor->update($request->all());
        return response()->json(['success' => true, 'message' => 'Vendor updated successfully', 'vendor' => $vendor]);
    }

    public function destroy(Vendor $vendor): JsonResponse
    {
        $vendor->delete();
        return response()->json(['success' => true, 'message' => 'Vendor deleted successfully']);
    }
}

<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\CRM\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    public function index()
    {
        $stats = [
            'total_companies' => Company::count(),
            'active_companies' => Company::where('status', 'active')->count(),
            'with_open_opportunities' => Company::whereHas('opportunities', fn ($q) => $q->where('status', 'open'))->count(),
            'with_recent_activity' => Company::whereHas('activities', fn ($q) => $q->where('created_at', '>=', now()->subDays(30)))->count(),
        ];

        $industries = Company::query()
            ->whereNotNull('industry')
            ->orderBy('industry')
            ->distinct()
            ->pluck('industry');

        return view('crm.companies.index', [
            'stats' => $stats,
            'industries' => $industries,
        ]);
    }

    public function datatable(Request $request)
    {
        $query = Company::query()->withCount(['contacts', 'leads', 'opportunities']);

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('industry') && $request->industry !== 'all') {
            $query->where('industry', $request->industry);
        }

        if ($search = $request->input('search.value')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $recordsTotal = $query->count();
        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);

        $companies = $query->orderBy('created_at', 'desc')
            ->skip($start)
            ->take($length)
            ->get();

        return response()->json([
            'draw' => (int) $request->input('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => $companies->map(fn (Company $company) => [
                'id' => $company->id,
                'name' => $company->name,
                'email' => $company->email,
                'phone' => $company->phone,
                'industry' => $company->industry,
                'status' => Str::headline($company->status),
                'contacts_count' => $company->contacts_count,
                'leads_count' => $company->leads_count,
                'opportunities_count' => $company->opportunities_count,
                'created_at' => $company->created_at?->format('Y-m-d'),
            ]),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'industry' => ['nullable', 'string', 'max:255'],
            'company_size' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'status' => ['nullable', 'string', 'max:50'],
            'tags' => ['nullable', 'array'],
            'notes' => ['nullable', 'string'],
        ]);

        $validated['owner_id'] = $validated['owner_id'] ?? $request->user()->id;
        $validated['created_by'] = $request->user()->id;
        $validated['tags'] = $validated['tags'] ?? [];

        $company = Company::create($validated);

        return response()->json([
            'success' => true,
            'message' => __('CRM company created successfully.'),
            'data' => $company,
        ]);
    }

    public function show(Company $company)
    {
        $company->load(['contacts', 'leads', 'opportunities']);

        return response()->json($company);
    }

    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'industry' => ['nullable', 'string', 'max:255'],
            'company_size' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'status' => ['required', 'string', 'max:50'],
            'tags' => ['nullable', 'array'],
            'notes' => ['nullable', 'string'],
        ]);

        $validated['updated_by'] = $request->user()->id;
        $validated['tags'] = $validated['tags'] ?? [];

        $company->update($validated);

        return response()->json([
            'success' => true,
            'message' => __('CRM company updated successfully.'),
            'data' => $company->fresh(),
        ]);
    }

    public function destroy(Company $company)
    {
        $company->delete();

        return response()->json([
            'success' => true,
            'message' => __('CRM company deleted successfully.'),
        ]);
    }
}

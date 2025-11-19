<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CRM\Contact;
use App\Models\CRM\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LeadController extends Controller
{
    public function index()
    {
        $stats = [
            'total_leads' => Lead::count(),
            'open_leads' => Lead::where('status', 'new')->orWhere('status', 'in_progress')->count(),
            'high_priority' => Lead::where('priority', 'high')->count(),
            'closing_this_month' => Lead::whereBetween('expected_close_date', [now()->startOfMonth(), now()->endOfMonth()])->count(),
        ];

        $companies = Company::select('id', 'name')->orderBy('name')->get();
        $contacts = Contact::select('id', 'first_name', 'last_name')->orderBy('first_name')->get();
        $statuses = Lead::query()->whereNotNull('status')->distinct()->orderBy('status')->pluck('status');

        return view('crm.leads.index', [
            'stats' => $stats,
            'companies' => $companies,
            'contacts' => $contacts,
            'statuses' => $statuses,
        ]);
    }

    public function datatable(Request $request)
    {
        $query = Lead::query()->with(['company', 'contact']);

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('company_id') && $request->company_id !== 'all') {
            $query->where('company_id', $request->company_id);
        }

        if ($request->filled('contact_id') && $request->contact_id !== 'all') {
            $query->where('contact_id', $request->contact_id);
        }

        if ($search = $request->input('search.value')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhereHas('company', fn ($builder) => $builder->where('name', 'like', "%{$search}%"));
            });
        }

        $recordsTotal = $query->count();
        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);

        $leads = $query->orderBy('created_at', 'desc')
            ->skip($start)
            ->take($length)
            ->get();

        return response()->json([
            'draw' => (int) $request->input('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => $leads->map(fn (Lead $lead) => [
                'id' => $lead->id,
                'code' => $lead->code,
                'title' => $lead->title,
                'company' => $lead->company?->name,
                'contact' => $lead->contact?->first_name,
                'status' => Str::headline($lead->status),
                'priority' => Str::headline($lead->priority),
                'estimated_value' => $lead->estimated_value,
                'expected_close_date' => $lead->expected_close_date?->format('Y-m-d'),
            ]),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_id' => ['nullable', 'exists:companies,id'],
            'contact_id' => ['nullable', 'exists:crm_contacts,id'],
            'title' => ['required', 'string', 'max:255'],
            'status' => ['nullable', 'string', 'max:50'],
            'source' => ['nullable', 'string', 'max:255'],
            'channel' => ['nullable', 'string', 'max:255'],
            'priority' => ['nullable', 'string', 'max:50'],
            'estimated_value' => ['nullable', 'numeric'],
            'expected_close_date' => ['nullable', 'date'],
            'tags' => ['nullable', 'array'],
            'notes' => ['nullable', 'string'],
        ]);

        $validated['code'] = $validated['code'] ?? $this->generateCode();
        $validated['owner_id'] = $validated['owner_id'] ?? $request->user()->id;
        $validated['created_by'] = $request->user()->id;
        $validated['tags'] = $validated['tags'] ?? [];

        $lead = Lead::create($validated);

        return response()->json([
            'success' => true,
            'message' => __('CRM lead created successfully.'),
            'data' => $lead,
        ]);
    }

    public function show(Lead $lead)
    {
        $lead->load(['company', 'contact', 'opportunities', 'activities', 'tasks']);

        return response()->json($lead);
    }

    public function update(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'company_id' => ['nullable', 'exists:companies,id'],
            'contact_id' => ['nullable', 'exists:crm_contacts,id'],
            'title' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:50'],
            'source' => ['nullable', 'string', 'max:255'],
            'channel' => ['nullable', 'string', 'max:255'],
            'priority' => ['nullable', 'string', 'max:50'],
            'estimated_value' => ['nullable', 'numeric'],
            'expected_close_date' => ['nullable', 'date'],
            'tags' => ['nullable', 'array'],
            'notes' => ['nullable', 'string'],
        ]);

        $validated['updated_by'] = $request->user()->id;
        $validated['tags'] = $validated['tags'] ?? [];

        $lead->update($validated);

        return response()->json([
            'success' => true,
            'message' => __('CRM lead updated successfully.'),
            'data' => $lead->fresh(),
        ]);
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();

        return response()->json([
            'success' => true,
            'message' => __('CRM lead deleted successfully.'),
        ]);
    }

    protected function generateCode(): string
    {
        $next = Lead::withTrashed()->max('id') + 1;

        return 'LEAD-' . str_pad((string) $next, 5, '0', STR_PAD_LEFT);
    }
}

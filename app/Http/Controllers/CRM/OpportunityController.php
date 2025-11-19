<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\CRM\Activity;
use App\Models\Company;
use App\Models\CRM\Contact;
use App\Models\CRM\Lead;
use App\Models\CRM\Opportunity;
use App\Models\CRM\Pipeline;
use App\Models\CRM\PipelineStage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OpportunityController extends Controller
{
    public function index()
    {
        $stats = [
            'total_opportunities' => Opportunity::count(),
            'open_opportunities' => Opportunity::where('status', 'open')->count(),
            'won_opportunities' => Opportunity::where('status', 'won')->count(),
            'closing_this_quarter' => Opportunity::whereBetween('expected_close_date', [now()->startOfQuarter(), now()->endOfQuarter()])->count(),
        ];

        $pipelines = Pipeline::select('id', 'name')->orderBy('name')->get();
        $stages = PipelineStage::select('id', 'name', 'pipeline_id')->orderBy('pipeline_id')->orderBy('sort_order')->get();
        $companies = Company::select('id', 'name')->orderBy('name')->get();
        $contacts = Contact::select('id', 'first_name', 'last_name')->orderBy('first_name')->get();
        $leads = Lead::select('id', 'code', 'title')->orderByDesc('created_at')->limit(50)->get();
        $statuses = Opportunity::query()->whereNotNull('status')->distinct()->orderBy('status')->pluck('status');

        return view('crm.opportunities.index', compact('stats', 'pipelines', 'stages', 'companies', 'contacts', 'leads', 'statuses'));
    }

    public function datatable(Request $request)
    {
        $query = Opportunity::query()->with(['pipeline', 'stage', 'company', 'contact']);

        if ($request->filled('pipeline_id') && $request->pipeline_id !== 'all') {
            $query->where('pipeline_id', $request->pipeline_id);
        }

        if ($request->filled('stage_id') && $request->stage_id !== 'all') {
            $query->where('stage_id', $request->stage_id);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
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

        $opportunities = $query->orderByDesc('created_at')
            ->skip($start)
            ->take($length)
            ->get();

        return response()->json([
            'draw' => (int) $request->input('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => $opportunities->map(fn (Opportunity $opportunity) => [
                'id' => $opportunity->id,
                'code' => $opportunity->code,
                'title' => $opportunity->title,
                'pipeline' => $opportunity->pipeline?->name,
                'stage' => $opportunity->stage?->name,
                'company' => $opportunity->company?->name,
                'amount' => $opportunity->amount,
                'currency' => $opportunity->currency,
                'probability' => $opportunity->probability,
                'status' => Str::headline($opportunity->status),
                'expected_close_date' => $opportunity->expected_close_date?->format('Y-m-d'),
            ]),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pipeline_id' => ['nullable', 'exists:crm_pipelines,id'],
            'stage_id' => ['nullable', 'exists:crm_pipeline_stages,id'],
            'company_id' => ['nullable', 'exists:companies,id'],
            'contact_id' => ['nullable', 'exists:crm_contacts,id'],
            'lead_id' => ['nullable', 'exists:crm_leads,id'],
            'title' => ['required', 'string', 'max:255'],
            'status' => ['nullable', 'string', 'max:50'],
            'probability' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'amount' => ['nullable', 'numeric'],
            'currency' => ['nullable', 'string', 'size:3'],
            'expected_close_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
            'tags' => ['nullable', 'array'],
        ]);

        $validated['code'] = $validated['code'] ?? $this->generateCode();
        $validated['currency'] = $validated['currency'] ?? 'USD';
        $validated['owner_id'] = $validated['owner_id'] ?? $request->user()->id;
        $validated['created_by'] = $request->user()->id;
        $validated['tags'] = $validated['tags'] ?? [];

        $opportunity = Opportunity::create($validated);

        return response()->json([
            'success' => true,
            'message' => __('CRM opportunity created successfully.'),
            'data' => $opportunity,
        ]);
    }

    public function show(Opportunity $opportunity)
    {
        $opportunity->load(['pipeline', 'stage', 'company', 'contact', 'lead', 'activities', 'tasks']);

        return response()->json($opportunity);
    }

    public function update(Request $request, Opportunity $opportunity)
    {
        $validated = $request->validate([
            'pipeline_id' => ['nullable', 'exists:crm_pipelines,id'],
            'stage_id' => ['nullable', 'exists:crm_pipeline_stages,id'],
            'company_id' => ['nullable', 'exists:companies,id'],
            'contact_id' => ['nullable', 'exists:crm_contacts,id'],
            'lead_id' => ['nullable', 'exists:crm_leads,id'],
            'title' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:50'],
            'probability' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'amount' => ['nullable', 'numeric'],
            'currency' => ['nullable', 'string', 'size:3'],
            'expected_close_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
            'tags' => ['nullable', 'array'],
        ]);

        $validated['updated_by'] = $request->user()->id;
        $validated['tags'] = $validated['tags'] ?? [];

        $opportunity->update($validated);

        return response()->json([
            'success' => true,
            'message' => __('CRM opportunity updated successfully.'),
            'data' => $opportunity->fresh(),
        ]);
    }

    public function destroy(Opportunity $opportunity)
    {
        $opportunity->delete();

        return response()->json([
            'success' => true,
            'message' => __('CRM opportunity deleted successfully.'),
        ]);
    }

    protected function generateCode(): string
    {
        $next = Opportunity::withTrashed()->max('id') + 1;

        return 'OPP-' . str_pad((string) $next, 5, '0', STR_PAD_LEFT);
    }
}

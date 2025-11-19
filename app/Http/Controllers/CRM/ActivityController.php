<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\CRM\Activity;
use App\Models\CRM\Company;
use App\Models\CRM\Contact;
use App\Models\CRM\Lead;
use App\Models\CRM\Opportunity;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ActivityController extends Controller
{
    public function index()
    {
        $stats = [
            'total_activities' => Activity::count(),
            'scheduled_today' => Activity::whereDate('scheduled_at', today())->count(),
            'overdue' => Activity::whereNull('completed_at')->where('scheduled_at', '<', now())->count(),
            'completed_this_week' => Activity::whereBetween('completed_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
        ];

        $activityTypes = Activity::query()->whereNotNull('activity_type')->distinct()->orderBy('activity_type')->pluck('activity_type');
        $statuses = Activity::query()->whereNotNull('status')->distinct()->orderBy('status')->pluck('status');

        $companies = Company::select('id', 'name')->orderBy('name')->get();
        $contacts = Contact::select('id', 'first_name', 'last_name')->orderBy('first_name')->get();
        $leads = Lead::select('id', 'code', 'title')->orderByDesc('created_at')->limit(50)->get();
        $opportunities = Opportunity::select('id', 'code', 'title')->orderByDesc('created_at')->limit(50)->get();

        return view('crm.activities.index', compact('stats', 'activityTypes', 'statuses', 'companies', 'contacts', 'leads', 'opportunities'));
    }

    public function datatable(Request $request)
    {
        $query = Activity::query()->with(['company', 'contact', 'lead', 'opportunity']);

        if ($request->filled('activity_type') && $request->activity_type !== 'all') {
            $query->where('activity_type', $request->activity_type);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('company_id') && $request->company_id !== 'all') {
            $query->where('company_id', $request->company_id);
        }

        if ($request->filled('lead_id') && $request->lead_id !== 'all') {
            $query->where('lead_id', $request->lead_id);
        }

        if ($request->filled('opportunity_id') && $request->opportunity_id !== 'all') {
            $query->where('opportunity_id', $request->opportunity_id);
        }

        if ($search = $request->input('search.value')) {
            $query->where(function ($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('company', fn ($builder) => $builder->where('name', 'like', "%{$search}%"));
            });
        }

        $recordsTotal = $query->count();
        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);

        $activities = $query->orderByDesc('scheduled_at')
            ->skip($start)
            ->take($length)
            ->get();

        return response()->json([
            'draw' => (int) $request->input('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => $activities->map(fn (Activity $activity) => [
                'id' => $activity->id,
                'subject' => $activity->subject,
                'activity_type' => Str::headline($activity->activity_type),
                'company' => $activity->company?->name,
                'lead' => $activity->lead?->code,
                'opportunity' => $activity->opportunity?->code,
                'status' => Str::headline($activity->status),
                'scheduled_at' => optional($activity->scheduled_at)->format('Y-m-d H:i'),
                'completed_at' => optional($activity->completed_at)->format('Y-m-d H:i'),
            ]),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'activity_type' => ['required', 'string', 'max:50'],
            'subject' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'scheduled_at' => ['nullable', 'date'],
            'status' => ['nullable', 'string', 'max:50'],
            'priority' => ['nullable', 'string', 'max:50'],
            'company_id' => ['nullable', 'exists:crm_companies,id'],
            'contact_id' => ['nullable', 'exists:crm_contacts,id'],
            'lead_id' => ['nullable', 'exists:crm_leads,id'],
            'opportunity_id' => ['nullable', 'exists:crm_opportunities,id'],
            'reminders' => ['nullable', 'array'],
            'metadata' => ['nullable', 'array'],
        ]);

        $validated['owner_id'] = $validated['owner_id'] ?? $request->user()->id;
        $validated['assigned_to'] = $validated['assigned_to'] ?? $request->user()->id;
        $validated['created_by'] = $request->user()->id;
        $validated['reminders'] = $validated['reminders'] ?? [];
        $validated['metadata'] = $validated['metadata'] ?? [];

        $activity = Activity::create($validated);

        return response()->json([
            'success' => true,
            'message' => __('CRM activity created successfully.'),
            'data' => $activity,
        ]);
    }

    public function update(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'activity_type' => ['required', 'string', 'max:50'],
            'subject' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'scheduled_at' => ['nullable', 'date'],
            'completed_at' => ['nullable', 'date'],
            'status' => ['required', 'string', 'max:50'],
            'priority' => ['nullable', 'string', 'max:50'],
            'company_id' => ['nullable', 'exists:crm_companies,id'],
            'contact_id' => ['nullable', 'exists:crm_contacts,id'],
            'lead_id' => ['nullable', 'exists:crm_leads,id'],
            'opportunity_id' => ['nullable', 'exists:crm_opportunities,id'],
            'reminders' => ['nullable', 'array'],
            'metadata' => ['nullable', 'array'],
        ]);

        $validated['updated_by'] = $request->user()->id;
        $validated['reminders'] = $validated['reminders'] ?? [];
        $validated['metadata'] = $validated['metadata'] ?? [];

        $activity->update($validated);

        return response()->json([
            'success' => true,
            'message' => __('CRM activity updated successfully.'),
            'data' => $activity->fresh(),
        ]);
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();

        return response()->json([
            'success' => true,
            'message' => __('CRM activity deleted successfully.'),
        ]);
    }
}

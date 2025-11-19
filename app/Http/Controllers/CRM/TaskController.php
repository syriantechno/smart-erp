<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\CRM\Company;
use App\Models\CRM\Contact;
use App\Models\CRM\Lead;
use App\Models\CRM\Opportunity;
use App\Models\CRM\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TaskController extends Controller
{
    public function index()
    {
        $stats = [
            'total_tasks' => Task::count(),
            'open_tasks' => Task::where('status', 'open')->count(),
            'overdue_tasks' => Task::where('status', '!=', 'completed')
                                    ->whereNotNull('due_date')
                                    ->where('due_date', '<', today())
                                    ->count(),
            'completed_this_week' => Task::where('status', 'completed')
                                          ->whereBetween('updated_at', [now()->startOfWeek(), now()->endOfWeek()])
                                          ->count(),
        ];

        $companies = Company::select('id', 'name')->orderBy('name')->get();
        $contacts = Contact::select('id', 'first_name', 'last_name')->orderBy('first_name')->get();
        $leads = Lead::select('id', 'code', 'title')->orderByDesc('created_at')->limit(50)->get();
        $opportunities = Opportunity::select('id', 'code', 'title')->orderByDesc('created_at')->limit(50)->get();
        $statuses = ['open', 'in_progress', 'completed', 'blocked'];
        $priorities = ['low', 'medium', 'high'];

        return view('crm.tasks.index', compact('stats', 'companies', 'contacts', 'leads', 'opportunities', 'statuses', 'priorities'));
    }

    public function datatable(Request $request)
    {
        $query = Task::query()->with(['company', 'contact', 'lead', 'opportunity']);

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority') && $request->priority !== 'all') {
            $query->where('priority', $request->priority);
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
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('company', fn ($builder) => $builder->where('name', 'like', "%{$search}%"));
            });
        }

        $recordsTotal = $query->count();
        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);

        $tasks = $query->orderByDesc('due_date')
            ->skip($start)
            ->take($length)
            ->get();

        return response()->json([
            'draw' => (int) $request->input('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => $tasks->map(fn (Task $task) => [
                'id' => $task->id,
                'title' => $task->title,
                'priority' => Str::headline($task->priority ?? 'medium'),
                'status' => Str::headline($task->status ?? 'open'),
                'company' => $task->company?->name,
                'lead' => $task->lead?->code,
                'opportunity' => $task->opportunity?->code,
                'due_date' => optional($task->due_date)->format('Y-m-d'),
            ]),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['nullable', 'string', 'max:50'],
            'priority' => ['nullable', 'string', 'max:50'],
            'due_date' => ['nullable', 'date'],
            'due_time' => ['nullable', 'date_format:H:i'],
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
        $validated['status'] = $validated['status'] ?? 'open';
        $validated['priority'] = $validated['priority'] ?? 'medium';
        $validated['reminders'] = $validated['reminders'] ?? [];
        $validated['metadata'] = $validated['metadata'] ?? [];

        $task = Task::create($validated);

        return response()->json([
            'success' => true,
            'message' => __('CRM task created successfully.'),
            'data' => $task,
        ]);
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'string', 'max:50'],
            'priority' => ['nullable', 'string', 'max:50'],
            'due_date' => ['nullable', 'date'],
            'due_time' => ['nullable', 'date_format:H:i'],
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

        $task->update($validated);

        return response()->json([
            'success' => true,
            'message' => __('CRM task updated successfully.'),
            'data' => $task->fresh(),
        ]);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json([
            'success' => true,
            'message' => __('CRM task deleted successfully.'),
        ]);
    }
}

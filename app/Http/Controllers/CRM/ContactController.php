<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CRM\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContactController extends Controller
{
    public function index()
    {
        $stats = [
            'total_contacts' => Contact::count(),
            'active_contacts' => Contact::where('status', 'active')->count(),
            'with_leads' => Contact::whereHas('leads')->count(),
            'recently_contacted' => Contact::whereHas('activities', fn ($q) => $q->where('created_at', '>=', now()->subDays(30)))->count(),
        ];

        $companies = Company::select('id', 'name')->orderBy('name')->get();
        $statuses = Contact::query()
            ->whereNotNull('status')
            ->distinct()
            ->orderBy('status')
            ->pluck('status');

        return view('crm.contacts.index', [
            'stats' => $stats,
            'companies' => $companies,
            'statuses' => $statuses,
        ]);
    }

    public function datatable(Request $request)
    {
        $query = Contact::query()->with('company');

        if ($request->filled('company_id') && $request->company_id !== 'all') {
            $query->where('company_id', $request->company_id);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($search = $request->input('search.value')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $recordsTotal = $query->count();
        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);

        $contacts = $query->orderBy('created_at', 'desc')
            ->skip($start)
            ->take($length)
            ->get();

        return response()->json([
            'draw' => (int) $request->input('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => $contacts->map(fn (Contact $contact) => [
                'id' => $contact->id,
                'name' => trim($contact->first_name . ' ' . $contact->last_name),
                'email' => $contact->email,
                'phone' => $contact->phone,
                'company' => $contact->company?->name,
                'status' => Str::headline($contact->status),
                'position' => $contact->position,
                'created_at' => $contact->created_at?->format('Y-m-d'),
            ]),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_id' => ['nullable', 'exists:companies,id'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'mobile' => ['nullable', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'string', 'max:50'],
            'channels' => ['nullable', 'array'],
            'notes' => ['nullable', 'string'],
        ]);

        $validated['owner_id'] = $validated['owner_id'] ?? $request->user()->id;
        $validated['created_by'] = $request->user()->id;
        $validated['channels'] = $validated['channels'] ?? [];

        $contact = Contact::create($validated);

        return response()->json([
            'success' => true,
            'message' => __('CRM contact created successfully.'),
            'data' => $contact,
        ]);
    }

    public function show(Contact $contact)
    {
        $contact->load(['company', 'leads', 'opportunities']);

        return response()->json($contact);
    }

    public function update(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'company_id' => ['nullable', 'exists:crm_companies,id'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'mobile' => ['nullable', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:50'],
            'channels' => ['nullable', 'array'],
            'notes' => ['nullable', 'string'],
        ]);

        $validated['updated_by'] = $request->user()->id;
        $validated['channels'] = $validated['channels'] ?? [];

        $contact->update($validated);

        return response()->json([
            'success' => true,
            'message' => __('CRM contact updated successfully.'),
            'data' => $contact->fresh(),
        ]);
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return response()->json([
            'success' => true,
            'message' => __('CRM contact deleted successfully.'),
        ]);
    }
}

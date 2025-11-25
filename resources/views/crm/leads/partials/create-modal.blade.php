<x-modal.form id="crm-lead-create" size="xl" :action="route('crm.leads.store')" method="POST">
    <x-slot name="title">
        <div class="flex items-center gap-2">
            <x-base.lucide icon="Sparkles" class="w-5 h-5 text-primary" />
            <span>Create Lead</span>
        </div>
    </x-slot>

    <div class="grid grid-cols-12 gap-4">
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="lead-title">Title</x-base.form-label>
            <x-base.form-input id="lead-title" name="title" type="text" required placeholder="New ERP rollout" />
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="lead-company">Company</x-base.form-label>
            <x-base.form-select id="lead-company" name="company_id">
                <option value="">Select company</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                @endforeach
            </x-base.form-select>
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="lead-contact">Contact</x-base.form-label>
            <x-base.form-select id="lead-contact" name="contact_id">
                <option value="">Select contact</option>
                @foreach ($contacts as $contact)
                    <option value="{{ $contact->id }}">{{ trim($contact->first_name . ' ' . $contact->last_name) }}</option>
                @endforeach
            </x-base.form-select>
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="lead-status">Status</x-base.form-label>
            <x-base.form-select id="lead-status" name="status">
                <option value="new">New</option>
                <option value="in_progress">In Progress</option>
                <option value="qualified">Qualified</option>
                <option value="lost">Lost</option>
            </x-base.form-select>
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="lead-priority">Priority</x-base.form-label>
            <x-base.form-select id="lead-priority" name="priority">
                <option value="medium">Medium</option>
                <option value="high">High</option>
                <option value="low">Low</option>
            </x-base.form-select>
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="lead-source">Source</x-base.form-label>
            <x-base.form-input id="lead-source" name="source" type="text" placeholder="Referral, Campaign, Website" />
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="lead-estimated">Estimated Value</x-base.form-label>
            <x-base.form-input id="lead-estimated" name="estimated_value" type="number" step="0.01" placeholder="50000" />
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="lead-close-date">Expected Close Date</x-base.form-label>
            <x-base.form-input id="lead-close-date" name="expected_close_date" type="date" />
        </div>
        <div class="col-span-12">
            <x-base.form-label for="lead-notes">Notes</x-base.form-label>
            <x-base.form-textarea id="lead-notes" name="notes" rows="3" placeholder="Context, next steps, blockers..."></x-base.form-textarea>
        </div>
    </div>

    <x-slot name="footer">
        <div class="custom-modal-footer">
            <button type="button" class="btn-royal btn-royal--outline btn-royal--sm" data-tw-dismiss="modal">
                <x-base.lucide icon="x" class="w-4 h-4 mr-1" /> Cancel
            </button>
            <button type="submit" class="btn-royal btn-royal--gold btn-royal--sm">
                <x-base.lucide icon="save" class="w-4 h-4 mr-1" /> Save Lead
            </button>
        </div>
    </x-slot>
</x-modal.form>

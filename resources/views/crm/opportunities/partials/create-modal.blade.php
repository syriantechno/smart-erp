<x-modal.form id="crm-opportunity-create" size="xl" :action="route('crm.opportunities.store')" method="POST">
    <x-slot name="title">
        <div class="flex items-center gap-2">
            <x-base.lucide icon="Target" class="w-5 h-5 text-primary" />
            <span>Create Opportunity</span>
        </div>
    </x-slot>

    <div class="grid grid-cols-12 gap-4">
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="opportunity-title">Title</x-base.form-label>
            <x-base.form-input id="opportunity-title" name="title" type="text" required placeholder="Cloud migration project" />
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="opportunity-company">Company</x-base.form-label>
            <x-base.form-select id="opportunity-company" name="company_id">
                <option value="">Select company</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                @endforeach
            </x-base.form-select>
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="opportunity-contact">Contact</x-base.form-label>
            <x-base.form-select id="opportunity-contact" name="contact_id">
                <option value="">Select contact</option>
                @foreach ($contacts as $contact)
                    <option value="{{ $contact->id }}">{{ trim($contact->first_name . ' ' . $contact->last_name) }}</option>
                @endforeach
            </x-base.form-select>
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="opportunity-lead">Linked Lead</x-base.form-label>
            <x-base.form-select id="opportunity-lead" name="lead_id">
                <option value="">No linked lead</option>
                @foreach ($leads as $lead)
                    <option value="{{ $lead->id }}">{{ $lead->code }} - {{ $lead->title }}</option>
                @endforeach
            </x-base.form-select>
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="opportunity-pipeline">Pipeline</x-base.form-label>
            <x-base.form-select id="opportunity-pipeline" name="pipeline_id">
                <option value="">Select pipeline</option>
                @foreach ($pipelines as $pipeline)
                    <option value="{{ $pipeline->id }}">{{ $pipeline->name }}</option>
                @endforeach
            </x-base.form-select>
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="opportunity-stage">Stage</x-base.form-label>
            <x-base.form-select id="opportunity-stage" name="stage_id">
                <option value="">Select stage</option>
                @foreach ($stages as $stage)
                    <option value="{{ $stage->id }}" data-pipeline="{{ $stage->pipeline_id }}">{{ $stage->name }}</option>
                @endforeach
            </x-base.form-select>
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="opportunity-status">Status</x-base.form-label>
            <x-base.form-select id="opportunity-status" name="status">
                <option value="open">Open</option>
                <option value="won">Won</option>
                <option value="lost">Lost</option>
                <option value="on_hold">On Hold</option>
            </x-base.form-select>
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="opportunity-probability">Probability %</x-base.form-label>
            <x-base.form-input id="opportunity-probability" name="probability" type="number" min="0" max="100" step="5" placeholder="50" />
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="opportunity-amount">Amount</x-base.form-label>
            <div class="flex gap-2">
                <x-base.form-input id="opportunity-amount" name="amount" type="number" step="0.01" placeholder="120000" class="flex-1" />
                <x-base.form-select id="opportunity-currency" name="currency" class="w-28">
                    <option value="USD">USD</option>
                    <option value="EUR">EUR</option>
                    <option value="SAR">SAR</option>
                    <option value="AED">AED</option>
                </x-base.form-select>
            </div>
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="opportunity-close-date">Expected Close Date</x-base.form-label>
            <x-base.form-input id="opportunity-close-date" name="expected_close_date" type="date" />
        </div>
        <div class="col-span-12">
            <x-base.form-label for="opportunity-notes">Notes</x-base.form-label>
            <x-base.form-textarea id="opportunity-notes" name="notes" rows="3" placeholder="Important details, decision makers, next steps..."></x-base.form-textarea>
        </div>
    </div>

    <x-slot name="footer">
        <div class="custom-modal-footer">
            <x-base.button type="button" variant="outline-secondary" class="btn-tonal btn-tonal--warning" data-tw-dismiss="modal" icon="X">
                Cancel
            </x-base.button>
            <x-base.button type="submit" class="btn-tonal btn-tonal--success" icon="Save">
                Save Opportunity
            </x-base.button>
        </div>
    </x-slot>
</x-modal.form>

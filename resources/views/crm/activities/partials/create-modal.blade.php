<x-modal.form id="crm-activity-create" size="lg" :action="route('crm.activities.store')" method="POST">
    <x-slot name="title">
        <div class="flex items-center gap-2">
            <x-base.lucide icon="CalendarPlus" class="w-5 h-5 text-primary" />
            <span>Log Activity</span>
        </div>
    </x-slot>

    <div class="grid grid-cols-12 gap-4">
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="activity-type">Activity Type</x-base.form-label>
            <x-base.form-select id="activity-type" name="activity_type" required>
                <option value="call">Call</option>
                <option value="email">Email</option>
                <option value="meeting">Meeting</option>
                <option value="task">Task</option>
                <option value="note">Note</option>
            </x-base.form-select>
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="activity-status">Status</x-base.form-label>
            <x-base.form-select id="activity-status" name="status">
                <option value="scheduled">Scheduled</option>
                <option value="completed">Completed</option>
                <option value="canceled">Canceled</option>
            </x-base.form-select>
        </div>
        <div class="col-span-12">
            <x-base.form-label for="activity-subject">Subject</x-base.form-label>
            <x-base.form-input id="activity-subject" name="subject" type="text" required placeholder="Follow up call" />
        </div>
        <div class="col-span-12">
            <x-base.form-label for="activity-description">Description</x-base.form-label>
            <x-base.form-textarea id="activity-description" name="description" rows="3" placeholder="Conversation summary, talking points, outcome..."></x-base.form-textarea>
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="activity-scheduled">Scheduled At</x-base.form-label>
            <x-base.form-input id="activity-scheduled" name="scheduled_at" type="datetime-local" />
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="activity-priority">Priority</x-base.form-label>
            <x-base.form-select id="activity-priority" name="priority">
                <option value="normal">Normal</option>
                <option value="high">High</option>
                <option value="low">Low</option>
            </x-base.form-select>
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="activity-company">Company</x-base.form-label>
            <x-base.form-select id="activity-company" name="company_id">
                <option value="">Select company</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                @endforeach
            </x-base.form-select>
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="activity-contact">Contact</x-base.form-label>
            <x-base.form-select id="activity-contact" name="contact_id">
                <option value="">Select contact</option>
                @foreach ($contacts as $contact)
                    <option value="{{ $contact->id }}">{{ trim($contact->first_name . ' ' . $contact->last_name) }}</option>
                @endforeach
            </x-base.form-select>
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="activity-lead">Lead</x-base.form-label>
            <x-base.form-select id="activity-lead" name="lead_id">
                <option value="">Select lead</option>
                @foreach ($leads as $lead)
                    <option value="{{ $lead->id }}">{{ $lead->code }} - {{ $lead->title }}</option>
                @endforeach
            </x-base.form-select>
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="activity-opportunity">Opportunity</x-base.form-label>
            <x-base.form-select id="activity-opportunity" name="opportunity_id">
                <option value="">Select opportunity</option>
                @foreach ($opportunities as $opportunity)
                    <option value="{{ $opportunity->id }}">{{ $opportunity->code }} - {{ $opportunity->title }}</option>
                @endforeach
            </x-base.form-select>
        </div>
    </div>

    <x-slot name="footer">
        <div class="custom-modal-footer">
            <x-base.button type="button" variant="outline-secondary" class="btn-tonal btn-tonal--warning" data-tw-dismiss="modal" icon="X">
                Cancel
            </x-base.button>
            <x-base.button type="submit" class="btn-tonal btn-tonal--success" icon="Save">
                Save Activity
            </x-base.button>
        </div>
    </x-slot>
</x-modal.form>

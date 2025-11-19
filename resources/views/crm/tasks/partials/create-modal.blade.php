<x-modal.form id="crm-task-create" size="lg" :action="route('crm.tasks.store')" method="POST">
    <x-slot name="title">
        <div class="flex items-center gap-2">
            <x-base.lucide icon="CheckSquare" class="w-5 h-5 text-primary" />
            <span>Create Task</span>
        </div>
    </x-slot>

    <div class="grid grid-cols-12 gap-4">
        <div class="col-span-12">
            <x-base.form-label for="task-title">Title</x-base.form-label>
            <x-base.form-input id="task-title" name="title" type="text" required placeholder="Prepare proposal" />
        </div>
        <div class="col-span-12">
            <x-base.form-label for="task-description">Description</x-base.form-label>
            <x-base.form-textarea id="task-description" name="description" rows="3" placeholder="Outline requirements, confirm pricing, schedule review..."></x-base.form-textarea>
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="task-status">Status</x-base.form-label>
            <x-base.form-select id="task-status" name="status">
                <option value="open">Open</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
                <option value="blocked">Blocked</option>
            </x-base.form-select>
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="task-priority">Priority</x-base.form-label>
            <x-base.form-select id="task-priority" name="priority">
                <option value="medium">Medium</option>
                <option value="high">High</option>
                <option value="low">Low</option>
            </x-base.form-select>
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="task-due-date">Due Date</x-base.form-label>
            <x-base.form-input id="task-due-date" name="due_date" type="date" />
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="task-due-time">Due Time</x-base.form-label>
            <x-base.form-input id="task-due-time" name="due_time" type="time" />
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="task-company">Company</x-base.form-label>
            <x-base.form-select id="task-company" name="company_id">
                <option value="">Select company</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                @endforeach
            </x-base.form-select>
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="task-contact">Contact</x-base.form-label>
            <x-base.form-select id="task-contact" name="contact_id">
                <option value="">Select contact</option>
                @foreach ($contacts as $contact)
                    <option value="{{ $contact->id }}">{{ trim($contact->first_name . ' ' . $contact->last_name) }}</option>
                @endforeach
            </x-base.form-select>
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="task-lead">Lead</x-base.form-label>
            <x-base.form-select id="task-lead" name="lead_id">
                <option value="">Select lead</option>
                @foreach ($leads as $lead)
                    <option value="{{ $lead->id }}">{{ $lead->code }}</option>
                @endforeach
            </x-base.form-select>
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="task-opportunity">Opportunity</x-base.form-label>
            <x-base.form-select id="task-opportunity" name="opportunity_id">
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
                Save Task
            </x-base.button>
        </div>
    </x-slot>
</x-modal.form>

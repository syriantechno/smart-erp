<x-modal.form id="crm-contact-create" size="lg" :action="route('crm.contacts.store')" method="POST">
    <x-slot name="title">
        <div class="flex items-center gap-2">
            <x-base.lucide icon="UserPlus" class="w-5 h-5 text-primary" />
            <span>Create Contact</span>
        </div>
    </x-slot>

    <div class="grid grid-cols-12 gap-4">
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="contact-first-name">First Name</x-base.form-label>
            <x-base.form-input id="contact-first-name" name="first_name" type="text" required placeholder="Aisha" />
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="contact-last-name">Last Name</x-base.form-label>
            <x-base.form-input id="contact-last-name" name="last_name" type="text" placeholder="Al-Farsi" />
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="contact-company">Company</x-base.form-label>
            <x-base.form-select id="contact-company" name="company_id">
                <option value="">Select company</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                @endforeach
            </x-base.form-select>
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="contact-position">Position</x-base.form-label>
            <x-base.form-input id="contact-position" name="position" type="text" placeholder="Operations Manager" />
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="contact-email">Email</x-base.form-label>
            <x-base.form-input id="contact-email" name="email" type="email" placeholder="aisha@acme.com" />
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="contact-phone">Phone</x-base.form-label>
            <x-base.form-input id="contact-phone" name="phone" type="text" placeholder="+971 50 789 1234" />
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="contact-mobile">Mobile</x-base.form-label>
            <x-base.form-input id="contact-mobile" name="mobile" type="text" placeholder="+971 55 456 9870" />
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="contact-status">Status</x-base.form-label>
            <x-base.form-select id="contact-status" name="status">
                <option value="active">Active</option>
                <option value="prospect">Prospect</option>
                <option value="inactive">Inactive</option>
            </x-base.form-select>
        </div>
        <div class="col-span-12">
            <x-base.form-label for="contact-notes">Notes</x-base.form-label>
            <x-base.form-textarea id="contact-notes" name="notes" rows="3" placeholder="Context, preferences, scheduling info..."></x-base.form-textarea>
        </div>
    </div>

    <x-slot name="footer">
        <div class="custom-modal-footer">
            <x-base.button type="button" variant="outline-secondary" class="btn-tonal btn-tonal--warning" data-tw-dismiss="modal" icon="X">
                Cancel
            </x-base.button>
            <x-base.button type="submit" class="btn-tonal btn-tonal--success" icon="Save">
                Save Contact
            </x-base.button>
        </div>
    </x-slot>
</x-modal.form>

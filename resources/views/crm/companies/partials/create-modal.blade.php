<x-modal.form id="crm-company-create" size="xl" :action="route('crm.companies.store')" method="POST">
    <x-slot name="title">
        <div class="flex items-center gap-2">
            <x-base.lucide icon="Building2" class="w-5 h-5 text-primary" />
            <span>Create Company</span>
        </div>
    </x-slot>

    <div class="grid grid-cols-12 gap-4">
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="company-name">Name</x-base.form-label>
            <x-base.form-input id="company-name" name="name" type="text" required placeholder="Acme Holding" />
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="company-industry">Industry</x-base.form-label>
            <x-base.form-input id="company-industry" name="industry" type="text" placeholder="Technology" />
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="company-email">Email</x-base.form-label>
            <x-base.form-input id="company-email" name="email" type="email" placeholder="contact@acme.com" />
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="company-phone">Phone</x-base.form-label>
            <x-base.form-input id="company-phone" name="phone" type="text" placeholder="+971 50 123 4567" />
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="company-website">Website</x-base.form-label>
            <x-base.form-input id="company-website" name="website" type="url" placeholder="https://acme.com" />
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-base.form-label for="company-status">Status</x-base.form-label>
            <x-base.form-select id="company-status" name="status">
                <option value="active">Active</option>
                <option value="prospect">Prospect</option>
                <option value="inactive">Inactive</option>
            </x-base.form-select>
        </div>
        <div class="col-span-12">
            <x-base.form-label for="company-address">Address</x-base.form-label>
            <x-base.form-textarea id="company-address" name="address" rows="3" placeholder="Office 12, Business Bay, Dubai"></x-base.form-textarea>
        </div>
        <div class="col-span-12">
            <x-base.form-label for="company-notes">Notes</x-base.form-label>
            <x-base.form-textarea id="company-notes" name="notes" rows="3" placeholder="Internal context, stakeholders, expectations..."></x-base.form-textarea>
        </div>
    </div>

    <x-slot name="footer">
        <div class="custom-modal-footer">
            <x-base.button type="button" variant="outline-secondary" class="btn-tonal btn-tonal--warning" data-tw-dismiss="modal" icon="X">
                Cancel
            </x-base.button>
            <x-base.button type="submit" class="btn-tonal btn-tonal--success" icon="Save">
                Save Company
            </x-base.button>
        </div>
    </x-slot>
</x-modal.form>

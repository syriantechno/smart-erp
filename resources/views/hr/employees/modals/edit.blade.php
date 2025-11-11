<x-modal.form id="edit-employee-modal" title="Edit Employee">
    <form id="edit-employee-form" action="" method="POST">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-12 gap-4 gap-y-4">
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="edit-employee-id">Employee ID</x-base.form-label>
                <x-base.form-input id="edit-employee-id" type="text" class="w-full" readonly />
            </div>

            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="edit-first-name">First Name <span class="text-danger">*</span></x-base.form-label>
                <x-base.form-input id="edit-first-name" name="first_name" type="text" placeholder="Enter first name" class="w-full" required />
            </div>

            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="edit-last-name">Last Name <span class="text-danger">*</span></x-base.form-label>
                <x-base.form-input id="edit-last-name" name="last_name" type="text" placeholder="Enter last name" class="w-full" required />
            </div>

            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="edit-email">Email <span class="text-danger">*</span></x-base.form-label>
                <x-base.form-input id="edit-email" name="email" type="email" placeholder="Enter email address" class="w-full" required />
            </div>

            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="edit-phone">Phone</x-base.form-label>
                <x-base.form-input id="edit-phone" name="phone" type="text" placeholder="Enter phone number" class="w-full" />
            </div>

            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="edit-position">Position</x-base.form-label>
                <x-base.form-input id="edit-position" name="position" type="text" placeholder="Enter position" class="w-full" />
            </div>

            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="edit-salary">Salary <span class="text-danger">*</span></x-base.form-label>
                <x-base.form-input id="edit-salary" name="salary" type="number" step="0.01" min="0" placeholder="Enter salary" class="w-full" required />
            </div>

            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="edit-hire-date">Hire Date <span class="text-danger">*</span></x-base.form-label>
                <x-base.form-input id="edit-hire-date" name="hire_date" type="date" class="w-full" required />
            </div>

            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="edit-birth-date">Birth Date</x-base.form-label>
                <x-base.form-input id="edit-birth-date" name="birth_date" type="date" class="w-full" />
            </div>

            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="edit-gender">Gender</x-base.form-label>
                <x-base.form-select id="edit-gender" name="gender" class="w-full">
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </x-base.form-select>
            </div>

            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="edit-department_id">Department <span class="text-danger">*</span></x-base.form-label>
                <x-base.form-select id="edit-department_id" name="department_id" class="w-full" required>
                    <option value="">Select Department</option>
                    @foreach(\App\Models\Department::active()->get() as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </x-base.form-select>
            </div>

            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="edit-company_id">Company <span class="text-danger">*</span></x-base.form-label>
                <x-base.form-select id="edit-company_id" name="company_id" class="w-full" required>
                    <option value="">Select Company</option>
                    @foreach(\App\Models\Company::active()->get() as $company)
                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                    @endforeach
                </x-base.form-select>
            </div>

            <div class="col-span-12">
                <x-base.form-label for="edit-address">Address</x-base.form-label>
                <x-base.form-textarea id="edit-address" name="address" rows="2" placeholder="Enter address" class="w-full"></x-base.form-textarea>
            </div>

            <div class="col-span-12 md:col-span-4">
                <x-base.form-label for="edit-city">City</x-base.form-label>
                <x-base.form-input id="edit-city" name="city" type="text" placeholder="Enter city" class="w-full" />
            </div>

            <div class="col-span-12 md:col-span-4">
                <x-base.form-label for="edit-country">Country</x-base.form-label>
                <x-base.form-input id="edit-country" name="country" type="text" placeholder="Enter country" class="w-full" />
            </div>

            <div class="col-span-12 md:col-span-4">
                <x-base.form-label for="edit-postal-code">Postal Code</x-base.form-label>
                <x-base.form-input id="edit-postal-code" name="postal_code" type="text" placeholder="Enter postal code" class="w-full" />
            </div>

            <div class="col-span-12">
                <x-base.form-check
                    id="edit-is_active"
                    name="is_active"
                    label="Active"
                    type="checkbox"
                />
            </div>
        </div>
    </form>

    @slot('footer')
        <div class="flex justify-end gap-2 w-full">
            <x-base.button
                class="w-24"
                data-tw-dismiss="modal"
                type="button"
                variant="outline-secondary"
            >
                Cancel
            </x-base.button>
            <x-base.button
                class="w-32"
                type="submit"
                form="edit-employee-form"
                variant="primary"
            >
                <x-base.lucide icon="Save" class="w-4 h-4 mr-2" />
                Update
            </x-base.button>
        </div>
    @endslot
</x-modal.form>

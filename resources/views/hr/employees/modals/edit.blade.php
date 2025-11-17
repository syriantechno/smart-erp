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
                <div class="relative w-full">
                    <div
                        class="absolute inset-y-0 left-0 flex w-10 items-center justify-center rounded-l border bg-slate-100 text-slate-500 dark:border-darkmode-800 dark:bg-darkmode-700 dark:text-slate-400">
                        <x-base.lucide icon="calendar" class="h-5 w-5 stroke-1.5"></x-base.lucide>
                    </div>
                    <x-base.litepicker
                        id="edit-hire-date"
                        name="hire_date"
                        class="pl-12 w-full"
                        data-single-mode="true"
                        required
                    />
                </div>
            </div>

            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="edit-birth-date">Birth Date</x-base.form-label>
                <div class="relative w-full">
                    <div
                        class="absolute inset-y-0 left-0 flex w-10 items-center justify-center rounded-l border bg-slate-100 text-slate-500 dark:border-darkmode-800 dark:bg-darkmode-700 dark:text-slate-400">
                        <x-base.lucide icon="calendar" class="h-5 w-5 stroke-1.5"></x-base.lucide>
                    </div>
                    <x-base.litepicker
                        id="edit-birth-date"
                        name="birth_date"
                        class="pl-12 w-full"
                        data-single-mode="true"
                    />
                </div>
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
                    @foreach(\App\Models\HR\Department::active()->get() as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </x-base.form-select>
            </div>

            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="edit-company_id">Company <span class="text-danger">*</span></x-base.form-label>
                <x-base.form-select id="edit-company_id" name="company_id" class="w-full" required>
                    <option value="">Select Company</option>
                    @foreach(\App\Models\Setting\Company::active()->get() as $company)
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

            <div class="col-span-12 mt-2">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="font-medium text-sm">Active Account</div>
                        <div class="text-xs text-slate-500">Toggle to activate or deactivate this employee.</div>
                    </div>
                    <div class="ml-4">
                        <input
                            type="checkbox"
                            id="edit-is_active"
                            name="is_active"
                            value="1"
                            class="transition-all duration-100 ease-in-out shadow-sm border-slate-200 cursor-pointer focus:ring-4 focus:ring-offset-0 focus:ring-primary focus:ring-opacity-20 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&[type='radio']]:checked:bg-primary [&[type='radio']]:checked:border-primary [&[type='radio']]:checked:border-opacity-10 [&[type='checkbox']]:checked:bg-primary [&[type='checkbox']]:checked:border-primary [&[type='checkbox']]:checked:border-opacity-10 [&:disabled:not(:checked)]:bg-slate-100 [&:disabled:not(:checked)]:cursor-not-allowed [&:disabled:not(:checked)]:dark:bg-darkmode-800/50 [&:disabled:checked]:opacity-70 [&:disabled:checked]:cursor-not-allowed [&:disabled:checked]:dark:bg-darkmode-800/50 w-[38px] h-[24px] p-px rounded-full relative before:w-[20px] before:h-[20px] before:shadow-[1px_1px_3px_rgba(0,0,0,0.25)] before:transition-[margin-left] before:duration-200 before:ease-in-out before:absolute before:inset-y-0 before:my-auto before:rounded-full before:dark:bg-darkmode-600 checked:bg-primary checked:border-primary checked:bg-none before:checked:ml-[14px] before:checked:bg-white"
                        >
                    </div>
                </div>
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

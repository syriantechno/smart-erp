<x-modal.form id="edit-employee-modal" title="Edit Employee" size="5xl">
    <form id="edit-employee-form" action="" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" id="edit-remove-profile-picture" name="remove_profile_picture" value="0" />

        <div class="mb-6 flex flex-col lg:flex-row gap-6 lg:items-start">
            <div class="flex-1 order-2 lg:order-1">
                <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                    <x-base.lucide icon="User" class="h-5 w-5"></x-base.lucide>
                    Personal Information
                </h4>
                <div class="flex flex-wrap gap-4 gap-y-4">
                    <div class="w-full md:w-1/3 lg:w-1/6">
                        <x-base.form-label for="edit-employee-id">Employee ID</x-base.form-label>
                        <x-base.form-input id="edit-employee-id" type="text" class="w-full" readonly />
                    </div>

                    <div class="w-full md:w-1/3 lg:w-1/6">
                        <x-base.form-label for="edit-first-name">First Name <span class="text-danger">*</span></x-base.form-label>
                        <x-base.form-input id="edit-first-name" name="first_name" type="text" placeholder="Enter first name" class="w-full" required />
                    </div>

                    <div class="w-full md:w-1/3 lg:w-1/6">
                        <x-base.form-label for="edit-middle-name">Middle Name</x-base.form-label>
                        <x-base.form-input id="edit-middle-name" name="middle_name" type="text" placeholder="Enter middle name" class="w-full" />
                    </div>

                    <div class="w-full md:w-1/3 lg:w-1/6">
                        <x-base.form-label for="edit-last-name">Last Name <span class="text-danger">*</span></x-base.form-label>
                        <x-base.form-input id="edit-last-name" name="last_name" type="text" placeholder="Enter last name" class="w-full" required />
                    </div>

                    <div class="w-full md:w-1/3 lg:w-1/6">
                        <x-base.form-label for="edit-translated-name">Translated / Localized Name</x-base.form-label>
                        <x-base.form-input id="edit-translated-name" name="translated_name" type="text" placeholder="Enter translated name" class="w-full" />
                    </div>

                    <div class="w-full md:w-1/3 lg:w-1/6">
                        <x-base.form-label for="edit-email">Email <span class="text-danger">*</span></x-base.form-label>
                        <x-base.form-input id="edit-email" name="email" type="email" placeholder="Enter email address" class="w-full" required />
                    </div>

                    <div class="w-full md:w-1/3 lg:w-1/6">
                        <x-base.form-label for="edit-phone">Phone</x-base.form-label>
                        <x-base.form-input id="edit-phone" name="phone" type="text" placeholder="Enter phone number" class="w-full" />
                    </div>

                    <div class="w-full md:w-1/3 lg:w-1/6">
                        <x-base.form-label for="edit-birth-date">Birth Date</x-base.form-label>
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex w-10 items-center justify-center rounded-l border bg-slate-100 text-slate-500 dark:border-darkmode-800 dark:bg-darkmode-700 dark:text-slate-400">
                                <x-base.lucide icon="calendar" class="h-5 w-5 stroke-1.5"></x-base.lucide>
                            </div>
                            <x-base.litepicker
                                id="edit-birth-date"
                                name="birth_date"
                                class="pl-12 w-full"
                                data-single-mode="true"
                                data-format="YYYY-MM-DD"
                            />
                        </div>
                    </div>

                    <div class="w-full md:w-1/3 lg:w-1/6">
                        <x-base.form-label for="edit-gender">Gender</x-base.form-label>
                        <x-base.form-select id="edit-gender" name="gender" class="w-full">
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </x-base.form-select>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-1/4 order-1 lg:order-2 lg:self-start">
                <div class="rounded-lg bg-white dark:bg-darkmode-700 p-5 shadow-md border border-slate-200 dark:border-darkmode-600">
                    <div class="text-center">
                        <div id="edit-image-preview-container" class="hidden mb-4">
                            <div class="relative inline-block">
                                <img id="edit-image-preview" src="" alt="Profile Preview" class="w-40 h-48 object-cover rounded-lg shadow-md">
                                <button type="button" id="edit-remove-image" class="absolute -top-2 -right-2 bg-danger text-white rounded-full w-6 h-6 flex items-center justify-center text-sm hover:bg-red-600 shadow-md">×</button>
                            </div>
                        </div>
                        <div id="edit-image-placeholder" class="mb-4">
                            <div class="w-40 h-48 mx-auto bg-slate-300 dark:bg-darkmode-500 rounded-lg flex items-center justify-center">
                                <x-base.lucide icon="User" class="w-16 h-16 text-slate-600 dark:text-slate-400"></x-base.lucide>
                            </div>
                        </div>
                        <div class="text-xs font-semibold text-slate-700 dark:text-slate-300 mb-3">Update employee photo:</div>
                        <input type="file" id="edit_profile_picture" name="profile_picture" accept="image/*" class="hidden" />
                        <button type="button" onclick="document.getElementById('edit_profile_picture').click()" class="w-full px-3 py-2 bg-primary text-white text-xs font-semibold rounded hover:bg-primary/90 transition">
                            Browse...
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-6">
            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <x-base.lucide icon="Briefcase" class="h-5 w-5"></x-base.lucide>
                Employment Information
            </h4>
            <div class="flex flex-wrap gap-4 gap-y-4">
                <div class="w-full md:w-1/3 lg:w-1/6">
                    <x-base.form-label for="edit-position">Position</x-base.form-label>
                    <x-base.form-input id="edit-position" name="position" type="text" placeholder="Enter position" class="w-full" />
                </div>

                <div class="w-full md:w-1/3 lg:w-1/6">
                    <x-base.form-label for="edit-iqama-position">Iqama / Residency Position</x-base.form-label>
                    <x-base.form-input id="edit-iqama-position" name="iqama_position" type="text" placeholder="Enter iqama position" class="w-full" />
                </div>

                <div class="w-full md:w-1/3 lg:w-1/6">
                    <x-base.form-label for="edit-salary">Salary <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-input id="edit-salary" name="salary" type="number" step="0.01" min="0" placeholder="0.00" class="w-full" required />
                </div>

                <div class="w-full md:w-1/3 lg:w-1/6">
                    <x-base.form-label for="edit-hire-date">Hire Date <span class="text-danger">*</span></x-base.form-label>
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex w-10 items-center justify-center rounded-l border bg-slate-100 text-slate-500 dark:border-darkmode-800 dark:bg-darkmode-700 dark:text-slate-400">
                            <x-base.lucide icon="calendar" class="h-5 w-5 stroke-1.5"></x-base.lucide>
                        </div>
                        <x-base.litepicker
                            id="edit-hire-date"
                            name="hire_date"
                            class="pl-12 w-full"
                            data-single-mode="true"
                            data-format="YYYY-MM-DD"
                            required
                        />
                    </div>
                </div>

                <div class="w-full md:w-1/3 lg:w-1/6">
                    <x-base.form-label for="edit-company_id">Company <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-select id="edit-company_id" name="company_id" class="w-full" required>
                        <option value="">Select Company</option>
                        @foreach(\App\Models\Setting\Company::active()->get() as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>

                <div class="w-full md:w-1/3 lg:w-1/6">
                    <x-base.form-label for="edit-department_id">Department <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-select id="edit-department_id" name="department_id" class="w-full" required>
                        <option value="">Select Department</option>
                        @foreach(\App\Models\HR\Department::active()->get() as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>

                <div class="w-full md:w-1/3 lg:w-1/6">
                    <x-base.form-label for="edit-is_active">Status</x-base.form-label>
                    <x-base.form-select id="edit-is_active" name="is_active" class="w-full">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </x-base.form-select>
                </div>
            </div>
        </div>

        <div class="mb-6">
            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <x-base.lucide icon="MapPin" class="h-5 w-5"></x-base.lucide>
                Address Information
            </h4>
            <div class="flex flex-wrap gap-4 gap-y-4">
                <div class="w-full">
                    <x-base.form-label for="edit-address">Full Address</x-base.form-label>
                    <x-base.form-textarea id="edit-address" name="address" rows="3" placeholder="Enter full address" class="w-full"></x-base.form-textarea>
                </div>

                <div class="w-full md:w-1/3 lg:w-1/6">
                    <x-base.form-label for="edit-city">City</x-base.form-label>
                    <x-base.form-input id="edit-city" name="city" type="text" placeholder="Enter city" class="w-full" />
                </div>

                <div class="w-full md:w-1/3 lg:w-1/6">
                    <x-base.form-label for="edit-country">Country</x-base.form-label>
                    <x-base.form-input id="edit-country" name="country" type="text" placeholder="Enter country" class="w-full" />
                </div>

                <div class="w-full md:w-1/3 lg:w-1/6">
                    <x-base.form-label for="edit-postal-code">Postal Code</x-base.form-label>
                    <x-base.form-input id="edit-postal-code" name="postal_code" type="text" placeholder="Enter postal code" class="w-full" />
                </div>
            </div>
        </div>

        <div class="mb-6">
            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <x-base.lucide icon="Shield" class="h-5 w-5"></x-base.lucide>
                Residency & Access
            </h4>
            <div class="grid grid-cols-12 gap-4 gap-y-4">
                <div class="col-span-12 md:col-span-6">
                    <div class="rounded-xl bg-white/80 px-4 py-3 shadow-sm ring-1 ring-slate-100 dark:bg-darkmode-600/70 dark:ring-darkmode-500/50">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <div class="font-medium text-sm text-slate-800 dark:text-slate-100">Company Housing</div>
                                <div class="text-xs text-slate-500">Toggle if employee lives in company accommodation.</div>
                            </div>
                            <label class="inline-flex cursor-pointer items-center">
                                <input
                                    type="checkbox"
                                    id="edit-is_company_housing"
                                    name="is_company_housing"
                                    value="1"
                                    class="transition-all duration-100 ease-in-out shadow-sm border-slate-200 cursor-pointer focus:ring-4 focus:ring-offset-0 focus:ring-primary focus:ring-opacity-20 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&[type='checkbox']]:checked:bg-primary [&[type='checkbox']]:checked:border-primary [&[type='checkbox']]:checked:border-opacity-10 w-[38px] h-[24px] p-px rounded-full relative before:w-[20px] before:h-[20px] before:shadow-[1px_1px_3px_rgba(0,0,0,0.25)] before:transition-[margin-left] before:duration-200 before:ease-in-out before:absolute before:inset-y-0 before:my-auto before:rounded-full before:dark:bg-darkmode-600 checked:bg-primary checked:border-primary checked:bg-none before:checked:ml-[14px] before:checked:bg-white"
                                >
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 md:col-span-6 hidden" id="edit-housing-details">
                    <div class="rounded-2xl border border-slate-200/70 bg-slate-50/70 p-4 shadow-inner dark:border-darkmode-600 dark:bg-darkmode-700/40">
                        <div class="grid grid-cols-12 gap-3">
                            <div class="col-span-12 md:col-span-6">
                                <x-base.form-label for="edit-housing-room-number">Room / Flat No.</x-base.form-label>
                                <x-base.form-input id="edit-housing-room-number" name="housing_room_number" type="text" placeholder="Room number" class="w-full" />
                            </div>
                            <div class="col-span-12 md:col-span-6">
                                <x-base.form-label for="edit-housing-unit-number">Unit / Building</x-base.form-label>
                                <x-base.form-input id="edit-housing-unit-number" name="housing_unit_number" type="text" placeholder="Building or unit" class="w-full" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-span-12">
                    <div class="rounded-xl bg-white/80 px-4 py-3 shadow-sm ring-1 ring-slate-100 dark:bg-darkmode-600/70 dark:ring-darkmode-500/50">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <div class="font-medium text-sm text-slate-800 dark:text-slate-100">System Access</div>
                                <div class="text-xs text-slate-500">Grant ERP login and set a temporary password.</div>
                            </div>
                            <label class="inline-flex cursor-pointer items-center">
                                <input
                                    type="checkbox"
                                    id="edit-has_system_access"
                                    name="has_system_access"
                                    value="1"
                                    class="transition-all duration-100 ease-in-out shadow-sm border-slate-200 cursor-pointer focus:ring-4 focus:ring-offset-0 focus:ring-primary focus:ring-opacity-20 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&[type='checkbox']]:checked:bg-primary [&[type='checkbox']]:checked:border-primary [&[type='checkbox']]:checked:border-opacity-10 w-[38px] h-[24px] p-px rounded-full relative before:w-[20px] before:h-[20px] before:shadow-[1px_1px_3px_rgba(0,0,0,0.25)] before:transition-[margin-left] before:duration-200 before:ease-in-out before:absolute before:inset-y-0 before:my-auto before:rounded-full before:dark:bg-darkmode-600 checked:bg-primary checked:border-primary checked:bg-none before:checked:ml-[14px] before:checked:bg-white"
                                >
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 md:col-span-6 hidden" id="edit-system-access-details">
                    <div class="rounded-2xl border border-slate-200/70 bg-slate-50/70 p-4 shadow-inner dark:border-darkmode-600 dark:bg-darkmode-700/40">
                        <div class="grid grid-cols-12 gap-3">
                            <div class="col-span-12 md:col-span-6">
                                <x-base.form-label for="edit-system_password">Temporary Password</x-base.form-label>
                                <x-base.form-input id="edit-system_password" name="system_password" type="text" placeholder="Enter temporary password" class="w-full" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @slot('footer')
        <div class="flex w-full flex-wrap justify-end gap-2">
            <button
                type="button"
                class="btn-tonal btn-tonal--neutral group"
                data-tw-dismiss="modal"
            >
                <x-base.lucide icon="x-circle" class="w-5 h-5 icon-hover-rise" />
                Cancel
            </button>
            <button
                type="submit"
                id="update-employee-btn"
                form="edit-employee-form"
                class="btn-tonal btn-tonal--success group"
            >
                <x-base.lucide icon="save" class="w-5 h-5 icon-hover-rise" />
                Save
            </button>
        </div>
    @endslot
</x-modal.form>

@push('scripts')
<script>
            document.getElementById('edit-housing-room-number'),
            document.getElementById('edit-housing-unit-number')
        ];
document.addEventListener('DOMContentLoaded', function () {
    const housingToggle = document.getElementById('edit-is_company_housing');
    const housingDetails = document.getElementById('edit-housing-details');
    const housingInputs = [
        document.getElementById('edit-housing-room-number'),
        document.getElementById('edit-housing-unit-number')
    ];

    const systemToggle = document.getElementById('edit-has_system_access');
    const systemDetails = document.getElementById('edit-system-access-details');
    const systemPasswordInput = document.getElementById('edit-system_password');

    function syncHousingUI() {
        if (!housingToggle || !housingDetails) return;
        const enabled = housingToggle.checked;
        housingDetails.classList.toggle('hidden', !enabled);
        housingInputs.forEach(input => {
            if (input) {
                input.disabled = !enabled;
                if (!enabled) input.value = '';
            }
        });
    }

    function syncSystemUI() {
        if (!systemToggle || !systemDetails || !systemPasswordInput) return;
        const enabled = systemToggle.checked;
        systemDetails.classList.toggle('hidden', !enabled);
        systemPasswordInput.disabled = !enabled;
        if (!enabled) {
            systemPasswordInput.value = '';
        }
    }

    if (housingToggle) {
        housingToggle.addEventListener('change', syncHousingUI);
        syncHousingUI();
    }

    if (systemToggle) {
        systemToggle.addEventListener('change', syncSystemUI);
        syncSystemUI();
    }
});
</script>
@endpush

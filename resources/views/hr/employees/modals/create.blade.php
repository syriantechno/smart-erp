@php
    $companies = \App\Models\Setting\Company::active()->get();
    $codeGenerator = app(\App\Services\DocumentCodeGenerator::class);
    $previewCode = $codeGenerator->preview('employees');
    $countries = include app_path('Data/countries.php');
    $countriesJson = json_encode($countries);
@endphp
<x-modal.form id="create-employee-modal" title="Add New Employee" size="3xl">
    <form id="create-employee-form" action="{{ route('hr.employees.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Personal Information -->
        <div class="mb-6">
            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <x-base.lucide icon="User" class="h-5 w-5"></x-base.lucide>
                Personal Information
            </h4>
            <div class="grid grid-cols-12 gap-4 gap-y-4">
                <div class="col-span-12 md:col-span-4 lg:col-span-3">
                    <x-base.form-label for="code">Employee Code</x-base.form-label>
                    <x-base.form-input id="code" name="code" type="text" class="w-full" formInputSize="sm" value="{{ $previewCode }}" readonly />
                </div>

                <div class="col-span-12 md:col-span-4 lg:col-span-3">
                    <x-base.form-label for="first_name">First Name <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-input id="first_name" name="first_name" type="text" placeholder="Enter first name" class="w-full" formInputSize="sm" required />
                </div>

                <div class="col-span-12 md:col-span-4 lg:col-span-3">
                    <x-base.form-label for="middle_name">Middle Name</x-base.form-label>
                    <x-base.form-input id="middle_name" name="middle_name" type="text" placeholder="Enter middle name" class="w-full" formInputSize="sm" />
                </div>

                <div class="col-span-12 md:col-span-4 lg:col-span-3">
                    <x-base.form-label for="last_name">Last Name <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-input id="last_name" name="last_name" type="text" placeholder="Enter last name" class="w-full" formInputSize="sm" required />
                </div>

                <div class="col-span-12 md:col-span-4 lg:col-span-3">
                    <x-base.form-label for="translated_name">Translated / Localized Name</x-base.form-label>
                    <x-base.form-input id="translated_name" name="translated_name" type="text" placeholder="Enter translated name" class="w-full" formInputSize="sm" />
                    <x-base.form-help>Use any language needed for official documents.</x-base.form-help>
                </div>

                <div class="col-span-12 md:col-span-4 lg:col-span-3">
                    <x-base.form-label for="email">Email Address <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-input id="email" name="email" type="email" placeholder="employee@example.com" class="w-full" formInputSize="sm" required />
                </div>

                <div class="col-span-12 md:col-span-4 lg:col-span-3">
                    <x-base.form-label for="phone">Phone Number</x-base.form-label>
                    <x-base.form-input id="phone" name="phone" type="tel" placeholder="+966XXXXXXXXX" class="w-full" formInputSize="sm" />
                </div>

                <div class="col-span-12 md:col-span-4 lg:col-span-3">
                    <x-base.form-label for="birth_date">Date of Birth</x-base.form-label>
                    <div class="relative w-full">
                        <div
                            class="absolute flex h-full w-10 items-center justify-center rounded-l border bg-slate-100 text-slate-500 dark:border-darkmode-800 dark:bg-darkmode-700 dark:text-slate-400">
                            <x-base.lucide icon="calendar" class="stroke-1.5 w-5 h-5"></x-base.lucide>
                        </div>
                        <x-base.litepicker
                            id="birth_date"
                            name="birth_date"
                            class="pl-12"
                            data-single-mode="true"
                            data-format="YYYY-MM-DD"
                        />
                    </div>
                </div>

                <div class="col-span-12 md:col-span-4 lg:col-span-3">
                    <x-base.form-label for="gender">Gender</x-base.form-label>
                    <x-base.form-select id="gender" name="gender" class="w-full">
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </x-base.form-select>
                </div>
            </div>
        </div>

        <!-- Employment Information -->
        <div class="mb-6">
            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <x-base.lucide icon="Briefcase" class="h-5 w-5"></x-base.lucide>
                Employment Information
            </h4>
            <div class="grid grid-cols-12 gap-4 gap-y-4">
                <div class="col-span-12 md:col-span-4 lg:col-span-3">
                    <x-base.form-label for="company_id">Company <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-select id="company_id" name="company_id" class="w-full" required>
                        <option value="">Select Company</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>

                <div class="col-span-12 md:col-span-4 lg:col-span-3">
                    <x-base.form-label for="department_id">Department <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-select id="department_id" name="department_id" class="w-full" required disabled>
                        <option value="">Select Department</option>
                    </x-base.form-select>
                </div>

                <div class="col-span-12 md:col-span-4 lg:col-span-3">
                    <x-base.form-label for="position">Position <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-select id="position" name="position" class="w-full" required disabled>
                        <option value="">Select Position</option>
                    </x-base.form-select>
                </div>

                <div class="col-span-12 md:col-span-4 lg:col-span-3">
                    <x-base.form-label for="iqama_position">Iqama / Residency Position</x-base.form-label>
                    <x-base.form-input id="iqama_position" name="iqama_position" type="text" placeholder="Enter iqama position title" class="w-full" formInputSize="sm" />
                </div>

                <div class="col-span-12 md:col-span-4 lg:col-span-3">
                    <x-base.form-label for="hire_date">Hire Date <span class="text-danger">*</span></x-base.form-label>
                    <div class="relative w-full">
                        <div
                            class="absolute flex h-full w-10 items-center justify-center rounded-l border bg-slate-100 text-slate-500 dark:border-darkmode-800 dark:bg-darkmode-700 dark:text-slate-400">
                            <x-base.lucide icon="calendar" class="stroke-1.5 w-5 h-5"></x-base.lucide>
                        </div>
                        <x-base.litepicker
                            id="hire_date"
                            name="hire_date"
                            class="pl-12"
                            data-single-mode="true"
                            data-format="YYYY-MM-DD"
                            required
                        />
                    </div>
                </div>

                <div class="col-span-12 md:col-span-4 lg:col-span-3">
                    <x-base.form-label for="salary">Basic Salary <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-input id="salary" name="salary" type="number" step="0.01" min="0" placeholder="0.00" class="w-full" formInputSize="sm" required />
                </div>

                <div class="col-span-12 md:col-span-4 lg:col-span-3">
                    <x-base.form-label for="is_active">Status</x-base.form-label>
                    <x-base.form-select id="is_active" name="is_active" class="w-full">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </x-base.form-select>
                </div>
            </div>
        </div>

        <!-- Address Information -->
        <div class="mb-6">
            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <x-base.lucide icon="MapPin" class="h-5 w-5"></x-base.lucide>
                Address Information
            </h4>
            <div class="grid grid-cols-12 gap-4 gap-y-4">
                <div class="col-span-12">
                    <x-base.form-label for="address">Full Address</x-base.form-label>
                    <x-base.form-textarea id="address" name="address" rows="3" placeholder="Enter full address" class="w-full"></x-base.form-textarea>
                </div>

                <div class="col-span-12 md:col-span-4 lg:col-span-3">
                    <x-base.form-label for="city">City</x-base.form-label>
                    <x-base.form-input id="city" name="city" type="text" placeholder="Enter city" class="w-full" formInputSize="sm" />
                </div>

                <div class="col-span-12 md:col-span-4 lg:col-span-3">
                    <x-base.form-label for="country">Country</x-base.form-label>
                    <x-base.form-select id="country" name="country" class="w-full">
                        <option value="">Select Country</option>
                    </x-base.form-select>
                </div>
                <div class="col-span-12 md:col-span-4 lg:col-span-3">
                    <x-base.form-label for="postal_code">Postal Code</x-base.form-label>
                    <x-base.form-input id="postal_code" name="postal_code" type="text" placeholder="Enter postal code" class="w-full" formInputSize="sm" />
                </div>
            </div>
        </div>

        <!-- Residency & Access -->
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
                                    id="is_company_housing"
                                    name="is_company_housing"
                                    value="1"
                                    class="transition-all duration-100 ease-in-out shadow-sm border-slate-200 cursor-pointer focus:ring-4 focus:ring-offset-0 focus:ring-primary focus:ring-opacity-20 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&[type='radio']]:checked:bg-primary [&[type='radio']]:checked:border-primary [&[type='radio']]:checked:border-opacity-10 [&[type='checkbox']]:checked:bg-primary [&[type='checkbox']]:checked:border-primary [&[type='checkbox']]:checked:border-opacity-10 [&:disabled:not(:checked)]:bg-slate-100 [&:disabled:not(:checked)]:cursor-not-allowed [&:disabled:not(:checked)]:dark:bg-darkmode-800/50 [&:disabled:checked]:opacity-70 [&:disabled:checked]:cursor-not-allowed [&:disabled:checked]:dark:bg-darkmode-800/50 w-[38px] h-[24px] p-px rounded-full relative before:w-[20px] before:h-[20px] before:shadow-[1px_1px_3px_rgba(0,0,0,0.25)] before:transition-[margin-left] before:duration-200 before:ease-in-out before:absolute before:inset-y-0 before:my-auto before:rounded-full before:dark:bg-darkmode-600 checked:bg-primary checked:border-primary checked:bg-none before:checked:ml-[14px] before:checked:bg-white"
                                >
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 md:col-span-6 hidden" id="housing-details">
                    <div class="rounded-2xl border border-slate-200/70 bg-slate-50/70 p-4 shadow-inner dark:border-darkmode-600 dark:bg-darkmode-700/40">
                        <div class="grid grid-cols-12 gap-3">
                            <div class="col-span-12 md:col-span-6">
                                <x-base.form-label for="housing_room_number">Room / Flat No.</x-base.form-label>
                                <x-base.form-input id="housing_room_number" name="housing_room_number" type="text" placeholder="Room number" class="w-full" formInputSize="sm" />
                            </div>
                            <div class="col-span-12 md:col-span-6">
                                <x-base.form-label for="housing_unit_number">Unit / Building</x-base.form-label>
                                <x-base.form-input id="housing_unit_number" name="housing_unit_number" type="text" placeholder="Building or unit" class="w-full" formInputSize="sm" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 md:col-span-6">
                    <div class="rounded-xl bg-white/80 px-4 py-3 shadow-sm ring-1 ring-slate-100 dark:bg-darkmode-600/70 dark:ring-darkmode-500/50">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <div class="font-medium text-sm text-slate-800 dark:text-slate-100">System Access</div>
                                <div class="text-xs text-slate-500">Allow employee to login to Smart ERP.</div>
                            </div>
                            <label class="inline-flex cursor-pointer items-center">
                                <input
                                    type="checkbox"
                                    id="has_system_access"
                                    name="has_system_access"
                                    value="1"
                                    class="transition-all duration-100 ease-in-out shadow-sm border-slate-200 cursor-pointer focus:ring-4 focus:ring-offset-0 focus:ring-primary focus:ring-opacity-20 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&[type='radio']]:checked:bg-primary [&[type='radio']]:checked:border-primary [&[type='radio']]:checked:border-opacity-10 [&[type='checkbox']]:checked:bg-primary [&[type='checkbox']]:checked:border-primary [&[type='checkbox']]:checked:border-opacity-10 [&:disabled:not(:checked)]:bg-slate-100 [&:disabled:not(:checked)]:cursor-not-allowed [&:disabled:not(:checked)]:dark:bg-darkmode-800/50 [&:disabled:checked]:opacity-70 [&:disabled:checked]:cursor-not-allowed [&:disabled:checked]:dark:bg-darkmode-800/50 w-[38px] h-[24px] p-px rounded-full relative before:w-[20px] before:h-[20px] before:shadow-[1px_1px_3px_rgba(0,0,0,0.25)] before:transition-[margin-left] before:duration-200 before:ease-in-out before:absolute before:inset-y-0 before:my-auto before:rounded-full before:dark:bg-darkmode-600 checked:bg-primary checked:border-primary checked:bg-none before:checked:ml-[14px] before:checked:bg-white"
                                >
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 md:col-span-6 hidden" id="system-access-details">
                    <x-base.form-label for="system_password">Temporary Password</x-base.form-label>
                    <x-base.form-input id="system_password" name="system_password" type="password" placeholder="Enter temporary password" class="w-full" formInputSize="sm" />
                    <x-base.form-help>Password is required when access is enabled.</x-base.form-help>
                </div>
            </div>
        </div>

        <!-- Profile Picture -->
        <div class="mb-6">
            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <x-base.lucide icon="Camera" class="h-5 w-5"></x-base.lucide>
                Profile Picture
            </h4>
            <div class="grid grid-cols-12 gap-4 gap-y-4">
                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="profile_picture">Upload Picture</x-base.form-label>
                    <input type="file" id="profile_picture" name="profile_picture" accept="image/*"
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                    <p class="mt-1 text-sm text-gray-500">PNG, JPG, GIF up to 5MB</p>
                </div>

                <div class="col-span-12 md:col-span-6">
                    <div id="image-preview-container" class="hidden">
                        <x-base.form-label>Preview</x-base.form-label>
                        <div class="relative">
                            <img id="image-preview" src="" alt="Profile Preview"
                                 class="w-32 h-32 object-cover rounded-lg border border-gray-300">
                            <button type="button" id="remove-image"
                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600">
                                ×
                            </button>
                        </div>
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
                form="create-employee-form"
                variant="primary"
            >
                <x-base.lucide icon="Save" class="w-4 h-4 mr-2" />
                Save
            </x-base.button>
        </div>
    @endslot

    <script>
    // Countries data from PHP
    const countriesData = {!! $countriesJson !!};

    document.addEventListener('DOMContentLoaded', function() {
        let modalInitialized = false;

        function initializeModal() {
            if (modalInitialized) return;

            loadCountries();
            setupEventListeners();

            modalInitialized = true;
        }

        function setupEventListeners() {
            const companySelect = document.getElementById('company_id');
            const departmentSelect = document.getElementById('department_id');
            const housingToggle = document.getElementById('is_company_housing');
            const housingDetails = document.getElementById('housing-details');
            const housingInputs = ['housing_room_number', 'housing_unit_number'].map(id => document.getElementById(id));
            const systemToggle = document.getElementById('has_system_access');
            const systemDetails = document.getElementById('system-access-details');
            const systemPasswordInput = document.getElementById('system_password');

            if (companySelect) {
                console.log('🎧 Setting up company change listener');
                companySelect.addEventListener('change', function() {
                    handleCompanyChange.call(this);
                });
            }

            if (departmentSelect) {
                console.log('🎧 Setting up department change listener');
                departmentSelect.addEventListener('change', function() {
                    handleDepartmentChange.call(this);
                });
            }

            if (housingToggle && housingDetails) {
                const syncHousingUI = () => {
                    const enabled = housingToggle.checked;
                    housingDetails.classList.toggle('hidden', !enabled);
                    housingInputs.forEach(input => {
                        if (input) {
                            input.disabled = !enabled;
                            if (!enabled) input.value = '';
                        }
                    });
                };

                housingToggle.addEventListener('change', syncHousingUI);
                syncHousingUI();
            }

            if (systemToggle && systemDetails && systemPasswordInput) {
                const syncSystemUI = () => {
                    const enabled = systemToggle.checked;
                    systemDetails.classList.toggle('hidden', !enabled);
                    systemPasswordInput.disabled = !enabled;
                    if (!enabled) {
                        systemPasswordInput.value = '';
                    }
                };

                systemToggle.addEventListener('change', syncSystemUI);
                syncSystemUI();
            }
        }

        function handleCompanyChange() {
            const dept = document.getElementById('department_id');
            const pos = document.getElementById('position');

            if (!dept || !pos) {
                return;
            }

            // Complete clearing
            dept.innerHTML = '';
            pos.innerHTML = '';

            // Add default options
            const deptDefault = document.createElement('option');
            deptDefault.value = '';
            deptDefault.textContent = 'Select Department';
            dept.appendChild(deptDefault);

            const posDefault = document.createElement('option');
            posDefault.value = '';
            posDefault.textContent = 'Select Position';
            pos.appendChild(posDefault);

            dept.disabled = true;
            pos.disabled = true;

            if (this.value) {
                fetch(`/hr/departments/api/company/${this.value}`, {
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                })
                .then(r => {
                    return r.json();
                })
                .then(d => {
                    // Clear again and add default
                    dept.innerHTML = '';
                    const newDeptDefault = document.createElement('option');
                    newDeptDefault.value = '';
                    newDeptDefault.textContent = 'Select Department';
                    dept.appendChild(newDeptDefault);

                    if (d && Array.isArray(d) && d.length > 0) {
                        d.forEach((x, index) => {
                            const o = document.createElement('option');
                            o.value = x.id;
                            o.textContent = x.name;
                            dept.appendChild(o);
                        });

                        dept.disabled = false;
                    } else {
                        const noDept = document.createElement('option');
                        noDept.value = '';
                        noDept.textContent = 'No departments found';
                        dept.appendChild(noDept);
                    }
                })
                .catch(e => {
                    dept.innerHTML = '';
                    const errorDept = document.createElement('option');
                    errorDept.value = '';
                    errorDept.textContent = 'Error loading';
                    dept.appendChild(errorDept);
                });
            }
        }

        function handleDepartmentChange() {
            const pos = document.getElementById('position');

            if (!pos) {
                return;
            }

            pos.innerHTML = '';

            // Add default option
            const posDefault = document.createElement('option');
            posDefault.value = '';
            posDefault.textContent = 'Select Position';
            pos.appendChild(posDefault);

            pos.disabled = true;

            if (this.value) {
                fetch(`/hr/positions/api/department/${this.value}`, {
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                })
                .then(r => {
                    return r.json();
                })
                .then(d => {
                    // Clear again and add default
                    pos.innerHTML = '';
                    const newPosDefault = document.createElement('option');
                    newPosDefault.value = '';
                    newPosDefault.textContent = 'Select Position';
                    pos.appendChild(newPosDefault);

                    if (d && Array.isArray(d) && d.length > 0) {
                        d.forEach((x, index) => {
                            const o = document.createElement('option');
                            o.value = x.title; // Changed from x.name to x.title
                            o.textContent = x.title; // Changed from x.name to x.title
                            pos.appendChild(o);
                        });

                        pos.disabled = false;
                    } else {
                        const noPos = document.createElement('option');
                        noPos.value = '';
                        noPos.textContent = 'No positions found';
                        pos.appendChild(noPos);
                    }
                })
                .catch(e => {
                    pos.innerHTML = '';
                    const errorPos = document.createElement('option');
                    errorPos.value = '';
                    errorPos.textContent = 'Error loading';
                    pos.appendChild(errorPos);
                });
            } else {
            }
        }

        function loadCountries() {
            const countrySelect = document.getElementById('country');

            if (!countrySelect) {
                return;
            }

            if (!countriesData || !Array.isArray(countriesData) || countriesData.length === 0) {
                const errorOption = document.createElement('option');
                errorOption.value = '';
                errorOption.textContent = 'Error loading data';
                countrySelect.appendChild(errorOption);
                return;
            }

            // Clear existing options
            countrySelect.innerHTML = '';

            // Add default option
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = 'Select Country';
            countrySelect.appendChild(defaultOption);

            // Sort countries alphabetically
            const countries = [...countriesData].sort((a, b) => a.name.localeCompare(b.name));

            // Add all countries as options
            countries.forEach(country => {
                const option = document.createElement('option');
                option.value = country.name;
                option.textContent = `${country.flag} ${country.name}`;
                countrySelect.appendChild(option);
            });
        }

        // Initialize immediately since modal is rendered in DOM
        initializeModal();
    });
    </script>
</x-modal.form>

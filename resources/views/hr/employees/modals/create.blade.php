@php
    $companies = \App\Models\Company::active()->get();
    $codeGenerator = app(\App\Services\DocumentCodeGenerator::class);
    $previewCode = $codeGenerator->preview('employees');
    $countries = include app_path('Data/countries.php');
    $countriesJson = json_encode($countries);
@endphp
<x-modal.form id="create-employee-modal" title="Add New Employee" size="xl">
    <form id="create-employee-form" action="{{ route('hr.employees.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Personal Information -->
        <div class="mb-6">
            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <x-base.lucide icon="User" class="h-5 w-5"></x-base.lucide>
                Personal Information
            </h4>
            <div class="grid grid-cols-12 gap-4 gap-y-4">
                <div class="col-span-12 md:col-span-3">
                    <x-base.form-label for="code">Employee Code</x-base.form-label>
                    <x-base.form-input id="code" name="code" type="text" class="w-full" value="{{ $previewCode }}" readonly />
                </div>

                <div class="col-span-12 md:col-span-3">
                    <x-base.form-label for="first_name">First Name <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-input id="first_name" name="first_name" type="text" placeholder="Enter first name" class="w-full" required />
                </div>

                <div class="col-span-12 md:col-span-3">
                    <x-base.form-label for="middle_name">Middle Name</x-base.form-label>
                    <x-base.form-input id="middle_name" name="middle_name" type="text" placeholder="Enter middle name" class="w-full" />
                </div>

                <div class="col-span-12 md:col-span-3">
                    <x-base.form-label for="last_name">Last Name <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-input id="last_name" name="last_name" type="text" placeholder="Enter last name" class="w-full" required />
                </div>

                <div class="col-span-12 md:col-span-3">
                    <x-base.form-label for="email">Email Address <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-input id="email" name="email" type="email" placeholder="employee@example.com" class="w-full" required />
                </div>

                <div class="col-span-12 md:col-span-3">
                    <x-base.form-label for="phone">Phone Number</x-base.form-label>
                    <x-base.form-input id="phone" name="phone" type="tel" placeholder="+966XXXXXXXXX" class="w-full" />
                </div>

                <div class="col-span-12 md:col-span-3">
                    <x-base.form-label for="birth_date">Date of Birth</x-base.form-label>
                    <x-base.form-input id="birth_date" name="birth_date" type="date" class="w-full" />
                </div>

                <div class="col-span-12 md:col-span-3">
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
                <div class="col-span-12 md:col-span-4">
                    <x-base.form-label for="company_id">Company <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-select id="company_id" name="company_id" class="w-full" required>
                        <option value="">Select Company</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>

                <div class="col-span-12 md:col-span-4">
                    <x-base.form-label for="department_id">Department <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-select id="department_id" name="department_id" class="w-full" required disabled>
                        <option value="">Select Department</option>
                    </x-base.form-select>
                </div>

                <div class="col-span-12 md:col-span-4">
                    <x-base.form-label for="position">Position <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-select id="position" name="position" class="w-full" required disabled>
                        <option value="">Select Position</option>
                    </x-base.form-select>
                </div>

                <div class="col-span-12 md:col-span-4">
                    <x-base.form-label for="hire_date">Hire Date <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-input id="hire_date" name="hire_date" type="date" class="w-full" required />
                </div>

                <div class="col-span-12 md:col-span-4">
                    <x-base.form-label for="salary">Basic Salary <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-input id="salary" name="salary" type="number" step="0.01" min="0" placeholder="0.00" class="w-full" required />
                </div>

                <div class="col-span-12 md:col-span-4">
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

                <div class="col-span-12 md:col-span-4">
                    <x-base.form-label for="city">City</x-base.form-label>
                    <x-base.form-input id="city" name="city" type="text" placeholder="Enter city" class="w-full" />
                </div>

                <div class="col-span-12 md:col-span-4">
                    <x-base.form-label for="country">Country</x-base.form-label>
                    <x-base.form-select id="country" name="country" class="w-full">
                        <option value="">Select Country</option>
                    </x-base.form-select>
                </div>
                <div class="col-span-12 md:col-span-4">
                    <x-base.form-label for="postal_code">Postal Code</x-base.form-label>
                    <x-base.form-input id="postal_code" name="postal_code" type="text" placeholder="Enter postal code" class="w-full" />
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

    console.log('🔧 Script starting, countriesData:', typeof countriesData, countriesData ? countriesData.length : 'undefined');

    document.addEventListener('DOMContentLoaded', function() {
        console.log('🚀 Employee modal script loaded at:', new Date().toISOString());

        let modalInitialized = false;
        let codeGenerated = false;

        // Try to load countries immediately if modal exists
        const existingModal = document.getElementById('create-employee-modal');
        if (existingModal) {
            console.log('🎯 Modal already exists on page load, loading countries...');
            loadCountries();
        }

        // Use MutationObserver to watch for modal being added to DOM
        const observer = new MutationObserver(function(mutations) {
            console.log('👀 MutationObserver triggered, mutations:', mutations.length);
            mutations.forEach(function(mutation) {
                if (mutation.type === 'childList') {
                    const modal = document.getElementById('create-employee-modal');
                    console.log('🔍 Looking for modal, found:', modal ? 'YES' : 'NO');
                    if (modal && !modalInitialized) {
                        console.log('🎯 Modal found in DOM via MutationObserver, initializing...');
                        initializeModal();
                    }
                }
            });
        });

        // Start observing
        observer.observe(document.body, {
            childList: true,
            subtree: true
        });

        // Fallback: check for modal every second for 10 seconds
        let checkCount = 0;
        const checkInterval = setInterval(() => {
            checkCount++;
            console.log('⏱️ Interval check #' + checkCount);
            const modal = document.getElementById('create-employee-modal');
            console.log('🔍 Modal in interval check:', modal ? 'YES' : 'NO');
            if (modal && !modalInitialized) {
                console.log('🎯 Modal found via interval check #' + checkCount + ', initializing...');
                initializeModal();
                clearInterval(checkInterval);
            }
            if (checkCount >= 10) {
                console.log('⏰ Stopped checking for modal after 10 attempts');
                clearInterval(checkInterval);
            }
        }, 1000);

        // Also listen for modal events (in case they work)
        document.addEventListener('show.tw.modal', function(event) {
            console.log('📂 Modal show event detected');
            if (event.target && event.target.id === 'create-employee-modal') {
                console.log('📂 Modal show event for create-employee-modal');
                if (!modalInitialized) {
                    setTimeout(() => initializeModal(), 100);
                }
            }
        });

        document.addEventListener('shown.tw.modal', function(event) {
            console.log('🎯 Modal shown event detected');
            if (event.target && event.target.id === 'create-employee-modal') {
                console.log('🎯 Modal shown event for create-employee-modal');
                if (!modalInitialized) {
                    setTimeout(() => initializeModal(), 200);
                }
            }
        });

        function initializeModal() {
            if (modalInitialized) return;

            console.log('🔄 Initializing modal functionality...');

            // Generate code if not already done
            if (!codeGenerated) {
                generateEmployeeCode();
            }

            // Load countries - make sure this happens
            console.log('🚀 About to call loadCountries...');
            loadCountries();

            // Setup event listeners
            setupEventListeners();

            modalInitialized = true;
            console.log('✅ Modal initialized successfully');
        }

        function generateEmployeeCode() {
            if (codeGenerated) return;

            const codeInput = document.getElementById('code');
            if (!codeInput || codeInput.value) {
                codeGenerated = true;
                return;
            }

            console.log('🔢 Generating employee code...');
            fetch('{{ route("hr.employees.preview-code") }}', {
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(r => {
                console.log('📡 Code API response:', r.status);
                return r.json();
            })
            .then(d => {
                console.log('🔢 Code data received:', d);
                if (d.code && codeInput) {
                    codeInput.value = d.code;
                    console.log('✅ Code set to:', d.code);
                    codeGenerated = true;
                }
            })
            .catch(e => {
                console.error('❌ Code generation error:', e);
                codeGenerated = true; // Don't try again
            });
        }

        function setupEventListeners() {
            const companySelect = document.getElementById('company_id');
            const departmentSelect = document.getElementById('department_id');

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
        }

        function handleCompanyChange() {
            console.log('🏢 Company changed to:', this.value);
            const dept = document.getElementById('department_id');
            const pos = document.getElementById('position');

            if (!dept || !pos) {
                console.error('❌ Select elements not found');
                return;
            }

            // Complete clearing
            console.log('🧹 Clearing department and position options completely');
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

            console.log('📊 After clearing - department options:', dept.options.length, ', position options:', pos.options.length);

            if (this.value) {
                console.log('🌐 Fetching departments for company:', this.value);
                fetch(`/hr/departments/api/company/${this.value}`, {
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                })
                .then(r => {
                    console.log('📡 Departments response status:', r.status);
                    return r.json();
                })
                .then(d => {
                    console.log('📦 Departments data received:', d);

                    // Clear again and add default
                    dept.innerHTML = '';
                    const newDeptDefault = document.createElement('option');
                    newDeptDefault.value = '';
                    newDeptDefault.textContent = 'Select Department';
                    dept.appendChild(newDeptDefault);

                    if (d && Array.isArray(d) && d.length > 0) {
                        console.log('✅ Adding', d.length, 'departments');

                        d.forEach((x, index) => {
                            console.log('  ', index + 1, ':', x.name, '(ID:', x.id + ')');
                            const o = document.createElement('option');
                            o.value = x.id;
                            o.textContent = x.name;
                            dept.appendChild(o);
                        });

                        dept.disabled = false;
                        console.log('✅ Departments loaded, total options:', dept.options.length);
                    } else {
                        console.log('⚠️ No departments found');
                        const noDept = document.createElement('option');
                        noDept.value = '';
                        noDept.textContent = 'No departments found';
                        dept.appendChild(noDept);
                    }
                })
                .catch(e => {
                    console.error('❌ Departments error:', e);
                    dept.innerHTML = '';
                    const errorDept = document.createElement('option');
                    errorDept.value = '';
                    errorDept.textContent = 'Error loading';
                    dept.appendChild(errorDept);
                });
            }
        }

        function handleDepartmentChange() {
            console.log('🏢 Department changed to:', this.value);
            const pos = document.getElementById('position');

            if (!pos) {
                console.error('❌ Position select not found');
                return;
            }

            // Clear position options
            console.log('🧹 Clearing position options');
            pos.innerHTML = '';

            // Add default option
            const posDefault = document.createElement('option');
            posDefault.value = '';
            posDefault.textContent = 'Select Position';
            pos.appendChild(posDefault);

            pos.disabled = true;

            if (this.value) {
                console.log('🌐 Fetching positions for department:', this.value);
                fetch(`/hr/positions/api/department/${this.value}`, {
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                })
                .then(r => {
                    console.log('📡 Positions response status:', r.status);
                    return r.json();
                })
                .then(d => {
                    console.log('📦 Positions data received:', d);

                    // Clear again and add default
                    pos.innerHTML = '';
                    const newPosDefault = document.createElement('option');
                    newPosDefault.value = '';
                    newPosDefault.textContent = 'Select Position';
                    pos.appendChild(newPosDefault);

                    if (d && Array.isArray(d) && d.length > 0) {
                        console.log('✅ Adding', d.length, 'positions');

                        d.forEach((x, index) => {
                            console.log('  ', index + 1, ':', x.title, '(ID:', x.id + ')');
                            const o = document.createElement('option');
                            o.value = x.title; // Changed from x.name to x.title
                            o.textContent = x.title; // Changed from x.name to x.title
                            pos.appendChild(o);
                        });

                        pos.disabled = false;
                        console.log('✅ Positions loaded, total options:', pos.options.length);
                    } else {
                        console.log('⚠️ No positions found');
                        const noPos = document.createElement('option');
                        noPos.value = '';
                        noPos.textContent = 'No positions found';
                        pos.appendChild(noPos);
                    }
                })
                .catch(e => {
                    console.error('❌ Positions error:', e);
                    pos.innerHTML = '';
                    const errorPos = document.createElement('option');
                    errorPos.value = '';
                    errorPos.textContent = 'Error loading';
                    pos.appendChild(errorPos);
                });
            } else {
                console.log('ℹ️ No department selected');
            }
        }

        function loadCountries() {
            console.log('🌍 Loading countries...');
            console.log('📊 countriesData type:', typeof countriesData);
            console.log('📊 countriesData length:', countriesData ? countriesData.length : 'undefined');

            const countrySelect = document.getElementById('country');

            if (!countrySelect) {
                console.error('❌ Country select not found');
                return;
            }

            if (!countriesData || !Array.isArray(countriesData) || countriesData.length === 0) {
                console.error('❌ Countries data is invalid or empty');
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

            console.log('✅ Countries loaded successfully, total options:', countrySelect.options.length);
        }
    });
    </script>
</x-modal.form>

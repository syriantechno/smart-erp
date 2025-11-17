<!-- Create Shift Modal -->
<x-modal.form id="create-shift-modal" title="Add New Shift" size="xl">
    <form id="create-shift-form" action="{{ route('hr.shifts.store') }}" method="POST">
        @csrf

        <!-- Basic Information -->
        <div class="mb-6">
            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <x-base.lucide icon="Info" class="h-5 w-5"></x-base.lucide>
                Basic Information
            </h4>
            <div class="grid grid-cols-12 gap-4 gap-y-4">
                <!-- Code -->
                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="shift-code">Code <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-input id="shift-code" name="code" type="text" class="w-full" readonly required />
                    <small class="text-slate-500">Generated automatically</small>
                </div>

                <!-- Name -->
                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="shift-name">Shift Name <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-input id="shift-name" name="name" type="text" placeholder="Example: Morning Shift" class="w-full" required />
                </div>

                <!-- Description -->
                <div class="col-span-12">
                    <x-base.form-label for="shift-description">Description</x-base.form-label>
                    <x-base.form-textarea id="shift-description" name="description" rows="3" placeholder="Shift description..." class="w-full"></x-base.form-textarea>
                </div>
            </div>
        </div>

        <!-- Working Hours -->
        <div class="mb-6">
            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <x-base.lucide icon="Clock" class="h-5 w-5"></x-base.lucide>
                Working Hours
            </h4>
            <div class="grid grid-cols-12 gap-4 gap-y-4">
                <!-- Start Time -->
                <div class="col-span-12 md:col-span-4">
                    <x-base.form-label for="start-time">Start Time <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-input id="start-time" name="start_time" type="time" class="w-full" required />
                </div>

                <!-- End Time -->
                <div class="col-span-12 md:col-span-4">
                    <x-base.form-label for="end-time">End Time <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-input id="end-time" name="end_time" type="time" class="w-full" required />
                </div>

                <!-- Working Hours (auto calculated) -->
                <div class="col-span-12 md:col-span-4">
                    <x-base.form-label for="working-hours">Working Hours <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-input id="working-hours" name="working_hours" type="number" step="0.5" min="0" max="24" class="w-full" readonly required />
                    <small class="text-slate-500">Calculated automatically from start and end time</small>
                </div>

                <!-- Color -->
                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="shift-color">Shift Color <span class="text-danger">*</span></x-base.form-label>
                    <div class="flex items-center gap-3">
                        <x-base.form-input id="shift-color" name="color" type="color" value="#007bff" class="w-16 h-10 border rounded" required />
                        <small class="text-slate-500">Choose a distinctive color for the shift</small>
                    </div>
                </div>

                <!-- Active Status -->
                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="is-active">Status</x-base.form-label>
                    <div class="flex items-center">
                        <input type="checkbox" id="is-active" name="is_active" value="1" checked class="form-check-input">
                        <label for="is-active" class="ml-2">Active</label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Break Time -->
        <div class="mb-6">
            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <x-base.lucide icon="Coffee" class="h-5 w-5"></x-base.lucide>
                Break Time
            </h4>
            <div class="grid grid-cols-12 gap-4 gap-y-4">
                <!-- Break Start -->
                <div class="col-span-12 md:col-span-4">
                    <x-base.form-label for="break-start">Break Start</x-base.form-label>
                    <x-base.form-input id="break-start" name="break_start" type="time" class="w-full" />
                </div>

                <!-- Break End -->
                <div class="col-span-12 md:col-span-4">
                    <x-base.form-label for="break-end">Break End</x-base.form-label>
                    <x-base.form-input id="break-end" name="break_end" type="time" class="w-full" />
                </div>

                <!-- Break Hours -->
                <div class="col-span-12 md:col-span-4">
                    <x-base.form-label for="break-hours">Break Hours</x-base.form-label>
                    <x-base.form-input id="break-hours" name="break_hours" type="number" step="0.5" min="0" max="8" value="1.00" class="w-full" />
                </div>
            </div>
        </div>

        <!-- Work Days -->
        <div class="mb-6">
            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <x-base.lucide icon="Calendar" class="h-5 w-5"></x-base.lucide>
                Work Days
            </h4>
            <div class="grid grid-cols-12 gap-4 gap-y-4">
                <div class="col-span-12">
                    <label class="flex items-center mb-3">
                        <input type="checkbox" id="select-all-days" class="form-check-input">
                        <span class="ml-2">All Days</span>
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        <label class="flex items-center">
                            <input type="checkbox" name="work_days[]" value="monday" class="form-check-input">
                            <span class="ml-2">Monday</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="work_days[]" value="tuesday" class="form-check-input">
                            <span class="ml-2">Tuesday</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="work_days[]" value="wednesday" class="form-check-input">
                            <span class="ml-2">Wednesday</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="work_days[]" value="thursday" class="form-check-input">
                            <span class="ml-2">Thursday</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="work_days[]" value="friday" class="form-check-input">
                            <span class="ml-2">Friday</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="work_days[]" value="saturday" class="form-check-input">
                            <span class="ml-2">Saturday</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="work_days[]" value="sunday" class="form-check-input">
                            <span class="ml-2">Sunday</span>
                        </label>
                    </div>
                    <small class="text-slate-500 mt-2 block">If no day is selected, the shift will apply to all days</small>
                </div>
            </div>
        </div>

        <!-- Applicability -->
        <div class="mb-6">
            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <x-base.lucide icon="Target" class="h-5 w-5"></x-base.lucide>
                Apply Shift To
            </h4>
            <div class="grid grid-cols-12 gap-4 gap-y-4">
                <!-- Applicable To -->
                <div class="col-span-12 md:col-span-4">
                    <x-base.form-label for="applicable-to">Apply To <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-select id="applicable-to" name="applicable_to" class="w-full" required>
                        <option value="company">Entire Company</option>
                        <option value="department">Specific Department</option>
                        <option value="employee">Specific Employee</option>
                    </x-base.form-select>
                </div>

                <!-- Company Selection -->
                <div class="col-span-12 md:col-span-4" id="company-selection">
                    <x-base.form-label for="company-id">Company <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-select id="company-id" name="company_id" class="w-full" required>
                        <option value="">Select Company</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>

                <!-- Department Selection -->
                <div class="col-span-12 md:col-span-4" id="shift-department-selection" style="display: none;">
                    <x-base.form-label for="department-id">Department</x-base.form-label>
                    <x-base.form-select id="department-id" name="department_id" class="w-full">
                        <option value="">Select Department</option>
                    </x-base.form-select>
                </div>

                <!-- Employee Selection -->
                <div class="col-span-12 md:col-span-4" id="shift-employee-selection" style="display: none;">
                    <x-base.form-label for="employee-id">Employee</x-base.form-label>
                    <x-base.form-select id="employee-id" name="employee_id" class="w-full">
                        <option value="">Select Employee</option>
                    </x-base.form-select>
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
                type="button"
                variant="primary"
                id="save-shift-btn"
                onclick="submitShiftForm()"
            >
                <x-base.lucide icon="Save" class="w-4 h-4 mr-2" />
                Save
            </x-base.button>
        </div>
    @endslot
</x-modal.form>

@push('scripts')
<script>
// Define globally available function
function submitShiftForm() {
    const form = document.getElementById('create-shift-form');
    if (form) {
        handleFormSubmit(form);
    }
}

// Form submit handler
document.addEventListener('submit', function(e) {
    if (e.target && e.target.id === 'create-shift-form') {
        e.preventDefault();
        handleFormSubmit(e.target);
    }
});

function handleFormSubmit(form) {
    const formData = new FormData(form);
    const data = {};

        // Convert FormData to object properly
        for (let [key, value] of formData.entries()) {
            if (key === 'work_days[]') {
                if (!data.work_days) data.work_days = [];
                data.work_days.push(value);
            } else if (data[key] !== undefined) {
                // Handle multiple values for same key
                if (!Array.isArray(data[key])) {
                    data[key] = [data[key]];
                }
                data[key].push(value);
            } else {
                data[key] = value;
            }
        }

        // Ensure work_days is properly set
        if (!data.work_days) {
            data.work_days = [];
        }

        if (!data.name || data.name.trim() === '') {
            showToast('Please enter the shift name', 'error');
            return;
        }

        if (!data.start_time || !data.end_time) {
            showToast('Please specify start and end time', 'error');
            return;
        }

        // Auto-calculate working hours from start and end time
        function calculateWorkingHours(start, end) {
            const [sh, sm] = start.split(':').map(Number);
            const [eh, em] = end.split(':').map(Number);
            if (isNaN(sh) || isNaN(sm) || isNaN(eh) || isNaN(em)) return null;

            const startMinutes = sh * 60 + sm;
            const endMinutes = eh * 60 + em;
            if (endMinutes <= startMinutes) return null;

            const diffHours = (endMinutes - startMinutes) / 60;
            return Math.round(diffHours * 2) / 2; // round to nearest 0.5
        }

        const autoHours = calculateWorkingHours(data.start_time, data.end_time);
        if (autoHours === null || autoHours <= 0 || autoHours > 24) {
            showToast('Working hours derived from time range are invalid', 'error');
            return;
        }

        data.working_hours = autoHours;
        const workingHoursInput = document.getElementById('working-hours');
        if (workingHoursInput) {
            workingHoursInput.value = autoHours;
        }

        if (!data.color || !/^#[a-fA-F0-9]{6}$/.test(data.color)) {
            showToast('Please choose a correct color', 'error');
            return;
        }

        if (!data.applicable_to) {
            showToast('Please select application level', 'error');
            return;
        }

        // Validate applicable_to requirements
        if (data.applicable_to === 'company' && (!data.company_id || data.company_id.trim() === '')) {
            showToast('Please select the company', 'error');
            return;
        }

        if (data.applicable_to === 'department' && (!data.department_id || data.department_id.trim() === '')) {
            showToast('Please select the department', 'error');
            return;
        }

        if (data.applicable_to === 'employee' && (!data.employee_id || data.employee_id.trim() === '')) {
            showToast('Please select the employee', 'error');
            return;
        }

        if (data.applicable_to === 'employee' && (!data.department_id || data.department_id.trim() === '')) {
            showToast('Please select the department', 'error');
            return;
        }

        console.log('📤 البيانات المرسلة:', data);

        fetch('{{ route("hr.shifts.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            console.log('📡 استجابة الخادم:', response.status, response.statusText);
            return response.json();
        })
        .then(data => {
            console.log('📨 بيانات الاستجابة:', data);
            if (data.success) {
                showToast(data.message || 'Shift created successfully', 'success');
                // Close modal
                const modal = document.getElementById('create-shift-modal');
                if (modal) {
                    modal.__tw_modal.hide();
                }
                // Reload the table instead of the whole page
                if (window.reloadTable) {
                    window.reloadTable();
                } else {
                    // Fallback to reload if table reload function not available
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }
            } else {
                console.error('❌ Failed to save data:', data);
                showToast(data.message || 'Failed to create shift', 'error');
                if (data.errors) {
                    console.error('Error details:', data.errors);
                }
            }
        })
        .catch(error => {
            console.error('💥 Network error:', error);
            showToast('An error occurred while saving', 'error');
        });
}

// Wait for data to be preloaded
document.addEventListener('DOMContentLoaded', function() {
    // Check if dataCache is available and has data
    if (typeof window.dataCache !== 'undefined') {
        // Populate companies if available
        const companies = window.dataCache.get('companies');
        if (companies && companies.length > 0) {
            const companySelect = document.getElementById('company-id');
            if (companySelect) {
                companySelect.innerHTML = '<option value="">Select Company</option>';
                companies.forEach(company => {
                    const option = document.createElement('option');
                    option.value = company.id;
                    option.textContent = company.name;
                    companySelect.appendChild(option);
                });
                console.log('✅ Companies populated from cache');
            }
        }
    }

    // Generate code preview
    function generateCodePreview() {
        fetch('{{ route("hr.shifts.preview-code") }}')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const codeInput = document.getElementById('shift-code');
                    if (codeInput) {
                        codeInput.value = data.code;
                    }
                }
            })
            .catch(error => {
                console.error('Error generating code:', error);
            });
    }

    // Call it immediately on load
    generateCodePreview();

    // Handle applicable to changes
    document.getElementById('applicable-to').addEventListener('change', function() {
        const applicableTo = this.value;
        const companySelection = document.getElementById('company-selection');
        const departmentSelection = document.getElementById('shift-department-selection');
        const employeeSelection = document.getElementById('shift-employee-selection');
        const companyField = document.getElementById('company-id');
        const departmentField = document.getElementById('department-id');
        const employeeField = document.getElementById('employee-id');

        // Reset all
        companySelection.style.display = 'block';
        departmentSelection.style.display = 'none';
        employeeSelection.style.display = 'none';
        companyField.required = false;
        departmentField.required = false;
        employeeField.required = false;

        if (applicableTo === 'company') {
            companyField.required = true;
        } else if (applicableTo === 'department') {
            companySelection.style.display = 'block';
            departmentSelection.style.display = 'block';
            companyField.required = true;
            departmentField.required = true;

            // Load departments when company changes
            document.getElementById('company-id').addEventListener('change', function() {
                loadDepartments(this.value);
            });
        } else if (applicableTo === 'employee') {
            companySelection.style.display = 'block';
            departmentSelection.style.display = 'block';
            employeeSelection.style.display = 'block';
            companyField.required = true;
            departmentField.required = true;
            employeeField.required = true;

            // Load departments and employees
            document.getElementById('company-id').addEventListener('change', function() {
                loadDepartments(this.value);
            });
            document.getElementById('department-id').addEventListener('change', function() {
                loadEmployees(this.value);
            });
        }
    });

    // Select all days
    document.getElementById('select-all-days').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('input[name="work_days[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Initialize when modal opens
    document.addEventListener('show.tw.modal', function(event) {
        if (event.target && event.target.id === 'create-shift-modal') {
            generateCodePreview();
        }
    });

    function loadDepartments(companyId) {
        fetch(`{{ route('hr.shifts.departments') }}?company_id=${companyId}`)
            .then(response => response.json())
            .then(data => {
                const departmentSelect = document.getElementById('department-id');
                departmentSelect.innerHTML = '<option value="">Select Department</option>';

                if (data.success) {
                    data.data.forEach(department => {
                        const option = document.createElement('option');
                        option.value = department.id;
                        option.textContent = department.name;
                        departmentSelect.appendChild(option);
                    });
                }
            })
            .catch(error => {
                console.error('Error loading departments:', error);
            });
    }

    function loadEmployees(departmentId) {
        fetch(`{{ route('hr.shifts.employees') }}?department_id=${departmentId}`)
            .then(response => response.json())
            .then(data => {
                const employeeSelect = document.getElementById('employee-id');
                employeeSelect.innerHTML = '<option value="">Select Employee</option>';

                if (data.success) {
                    data.data.forEach(employee => {
                        const option = document.createElement('option');
                        option.value = employee.id;
                        option.textContent = employee.full_name;
                        employeeSelect.appendChild(option);
                    });
                }
            })
            .catch(error => {
                console.error('Error loading employees:', error);
            });
    }
});
</script>
@endpush

<!-- Add Recruitment Modal -->
<x-base.dialog id="add-recruitment-modal" size="lg">
    <x-base.dialog.panel>
        <!-- Header -->
        <x-base.dialog.title>
            <x-base.lucide icon="UserPlus" class="w-5 h-5 mr-2" />
            Add New Candidate
        </x-base.dialog.title>

        <form id="add-recruitment-form">
            <!-- Modal Body -->
            <div class="px-5 py-3">
                <div class="space-y-6">
                    <!-- Basic Information -->
                    <div class="grid grid-cols-12 gap-4">
                        <!-- Candidate Name -->
                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Candidate Name *
                            </label>
                            <x-base.form-input
                                id="candidate_name"
                                name="candidate_name"
                                type="text"
                                placeholder="Enter candidate full name"
                                class="w-full"
                                required
                            />
                        </div>

                        <!-- Email -->
                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Email Address *
                            </label>
                            <x-base.form-input
                                id="email"
                                name="email"
                                type="email"
                                placeholder="candidate@example.com"
                                class="w-full"
                                required
                            />
                        </div>

                        <!-- Phone -->
                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Phone Number
                            </label>
                            <x-base.form-input
                                id="phone"
                                name="phone"
                                type="tel"
                                placeholder="+1234567890"
                                class="w-full"
                            />
                        </div>

                        <!-- Application Date -->
                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Application Date *
                            </label>
                            <div class="relative mx-auto w-56">
                                <div
                                    class="absolute flex h-full w-10 items-center justify-center rounded-l border bg-slate-100 text-slate-500 dark:border-darkmode-800 dark:bg-darkmode-700 dark:text-slate-400">
                                    <x-base.lucide icon="calendar" class="stroke-1.5 w-5 h-5"></x-base.lucide>
                                </div>
                                <x-base.litepicker
                                    id="application_date"
                                    name="application_date"
                                    class="pl-12"
                                    data-single-mode="true"
                                    :value="date('Y-m-d')"
                                    required
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Position Information -->
                    <div class="grid grid-cols-12 gap-4">
                        <!-- Company -->
                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Company *
                            </label>
                            <x-base.form-select id="company_id" name="company_id" class="w-full" required>
                                <option value="">Select Company</option>
                                @foreach($companies ?? [] as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </x-base.form-select>
                        </div>

                        <!-- Department -->
                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Department *
                            </label>
                            <x-base.form-select id="department_id" name="department_id" class="w-full" required>
                                <option value="">Select Department</option>
                            </x-base.form-select>
                        </div>

                        <!-- Position -->
                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Position *
                            </label>
                            <x-base.form-input
                                id="position"
                                name="position"
                                type="text"
                                placeholder="e.g. Software Developer"
                                class="w-full"
                                required
                            />
                        </div>

                        <!-- Expected Salary -->
                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Expected Salary
                            </label>
                            <x-base.form-input
                                id="expected_salary"
                                name="expected_salary"
                                type="number"
                                step="0.01"
                                placeholder="0.00"
                                class="w-full"
                            />
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="grid grid-cols-12 gap-4">
                        <!-- Education Level -->
                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Education Level
                            </label>
                            <x-base.form-select id="education_level" name="education_level" class="w-full">
                                <option value="">Select Education Level</option>
                                <option value="high_school">High School</option>
                                <option value="associate">Associate Degree</option>
                                <option value="bachelor">Bachelor's Degree</option>
                                <option value="master">Master's Degree</option>
                                <option value="phd">PhD</option>
                                <option value="other">Other</option>
                            </x-base.form-select>
                        </div>

                        <!-- Skills -->
                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Skills (comma separated)
                            </label>
                            <x-base.form-input
                                id="skills"
                                name="skills"
                                type="text"
                                placeholder="PHP, JavaScript, MySQL..."
                                class="w-full"
                            />
                        </div>

                        <!-- Experience -->
                        <div class="col-span-12">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Experience
                            </label>
                            <x-base.form-textarea
                                id="experience"
                                name="experience"
                                rows="3"
                                placeholder="Describe candidate's work experience..."
                                class="w-full"
                            />
                        </div>

                        <!-- Notes -->
                        <div class="col-span-12">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Notes
                            </label>
                            <x-base.form-textarea
                                id="notes"
                                name="notes"
                                rows="2"
                                placeholder="Any additional notes about the candidate..."
                                class="w-full"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <x-base.dialog.footer>
                <x-base.button
                    type="button"
                    variant="secondary"
                    x-on:click="$dispatch('close')"
                >
                    Cancel
                </x-base.button>

                <x-base.button
                    type="submit"
                    variant="primary"
                    id="submit-recruitment-btn"
                >
                    <x-base.lucide icon="Save" class="w-4 h-4 mr-2" />
                    Add Candidate
                </x-base.button>
            </x-base.dialog.footer>
        </form>
    </x-base.dialog.panel>
</x-base.dialog>

<script>
// Recruitment Form Handling
document.addEventListener('DOMContentLoaded', function() {
    const recruitmentForm = document.getElementById('add-recruitment-form');
    const companySelect = document.getElementById('company_id');
    const departmentSelect = document.getElementById('department_id');

    // Load departments when company changes
    if (companySelect) {
        companySelect.addEventListener('change', function() {
            loadDepartmentsForCompany(this.value, departmentSelect);
        });
    }

    // Form submission
    if (recruitmentForm) {
        recruitmentForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const submitBtn = document.getElementById('submit-recruitment-btn');
            const originalText = submitBtn.innerHTML;

            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<x-base.lucide icon="Loader" class="w-4 h-4 mr-2 animate-spin"></x-base.lucide>Adding...';

            const formData = new FormData(recruitmentForm);

            // Debug: Log form data
            console.log('Form data being sent:');
            for (let [key, value] of formData.entries()) {
                console.log(key + ': ' + value);
            }

            // Convert FormData to JSON for better handling
            const data = {};
            for (let [key, value] of formData.entries()) {
                if (key === 'skills') {
                    // Handle skills as array
                    data[key] = value ? value.split(',').map(s => s.trim()) : [];
                } else {
                    data[key] = value;
                }
            }

            console.log('Converted data:', data);

            fetch('{{ route("hr.recruitment.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data),
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message || 'Candidate added successfully', 'success');

                    // Reset form and close modal
                    recruitmentForm.reset();
                    const modal = document.getElementById('add-recruitment-modal');
                    if (modal) {
                        modal.__tippy?.hide();
                    }

                    // Reload table
                    if (window.recruitmentTable) {
                        window.recruitmentTable.ajax.reload(null, false);
                    }
                } else {
                    // Show validation errors
                    if (data.errors) {
                        let errorMessage = 'Validation errors:\n';
                        Object.values(data.errors).forEach(errors => {
                            if (Array.isArray(errors)) {
                                errors.forEach(error => errorMessage += '• ' + error + '\n');
                            } else {
                                errorMessage += '• ' + errors + '\n';
                            }
                        });
                        showToast(errorMessage, 'error');
                    } else {
                        showToast(data.message || 'Failed to add candidate', 'error');
                    }
                }
            })
            .catch(error => {
                console.error('Error adding candidate:', error);
                showToast('An error occurred while adding the candidate', 'error');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        });
    }

    function loadDepartmentsForCompany(companyId, departmentSelect) {
        if (!departmentSelect) return;

        departmentSelect.innerHTML = '<option value="">Loading departments...</option>';

        if (!companyId) {
            departmentSelect.innerHTML = '<option value="">Select Department</option>';
            return;
        }

        fetch(`/hr/departments/api/company/${companyId}`, {
            credentials: 'same-origin',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            departmentSelect.innerHTML = '<option value="">Select Department</option>';
            if (data && Array.isArray(data)) {
                data.forEach(dept => {
                    const option = document.createElement('option');
                    option.value = dept.id;
                    option.textContent = dept.name;
                    departmentSelect.appendChild(option);
                });
            }
        })
        .catch(error => {
            console.error('Error loading departments:', error);
            departmentSelect.innerHTML = '<option value="">Error loading departments</option>';
        });
    }
});
</script>

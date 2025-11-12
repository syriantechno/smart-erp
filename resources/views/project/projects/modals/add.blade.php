<!-- Add Project Modal -->
<x-base.dialog id="add-project-modal" size="lg">
    <x-base.dialog.panel>
        <!-- Header -->
        <x-base.dialog.title>
            <x-base.lucide icon="FolderPlus" class="w-5 h-5 mr-2" />
            Add New Project
        </x-base.dialog.title>

        <form id="add-project-form">
            <!-- Modal Body -->
            <div class="px-5 py-3">
                <div class="space-y-6">
                    <!-- Basic Information -->
                    <div class="grid grid-cols-12 gap-4">
                        <!-- Project Name -->
                        <div class="col-span-12 md:col-span-8">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Project Name *
                            </label>
                            <x-base.form-input
                                id="name"
                                name="name"
                                type="text"
                                placeholder="Enter project name"
                                class="w-full"
                                required
                            />
                        </div>

                        <!-- Progress -->
                        <div class="col-span-12 md:col-span-4">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Initial Progress (%) *
                            </label>
                            <x-base.form-input
                                id="progress_percentage"
                                name="progress_percentage"
                                type="number"
                                min="0"
                                max="100"
                                value="0"
                                class="w-full"
                                required
                            />
                        </div>

                        <!-- Description -->
                        <div class="col-span-12">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Description
                            </label>
                            <x-base.form-textarea
                                id="description"
                                name="description"
                                rows="3"
                                placeholder="Describe the project..."
                                class="w-full"
                            />
                        </div>
                    </div>

                    <!-- Organization Information -->
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
                                Department
                            </label>
                            <x-base.form-select id="department_id" name="department_id" class="w-full">
                                <option value="">Select Department</option>
                            </x-base.form-select>
                        </div>

                        <!-- Project Manager -->
                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Project Manager
                            </label>
                            <x-base.form-select id="manager_id" name="manager_id" class="w-full">
                                <option value="">Select Manager</option>
                                @foreach($employees ?? [] as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->full_name }}</option>
                                @endforeach
                            </x-base.form-select>
                        </div>

                        <!-- Priority -->
                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Priority *
                            </label>
                            <x-base.form-select id="priority" name="priority" class="w-full" required>
                                <option value="">Select Priority</option>
                                <option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                                <option value="critical">Critical</option>
                            </x-base.form-select>
                        </div>
                    </div>

                    <!-- Timeline Information -->
                    <div class="grid grid-cols-12 gap-4">
                        <!-- Start Date -->
                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Start Date *
                            </label>
                            <x-base.form-input
                                id="start_date"
                                name="start_date"
                                type="date"
                                class="w-full"
                                :value="date('Y-m-d')"
                                required
                            />
                        </div>

                        <!-- End Date -->
                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                End Date
                            </label>
                            <x-base.form-input
                                id="end_date"
                                name="end_date"
                                type="date"
                                class="w-full"
                            />
                        </div>

                        <!-- Status -->
                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Status *
                            </label>
                            <x-base.form-select id="status" name="status" class="w-full" required>
                                <option value="">Select Status</option>
                                <option value="planning">Planning</option>
                                <option value="active">Active</option>
                                <option value="on_hold">On Hold</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </x-base.form-select>
                        </div>

                        <!-- Budget -->
                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Budget
                            </label>
                            <x-base.form-input
                                id="budget"
                                name="budget"
                                type="number"
                                step="0.01"
                                placeholder="0.00"
                                class="w-full"
                            />
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="grid grid-cols-12 gap-4">
                        <!-- Objectives -->
                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Objectives
                            </label>
                            <x-base.form-textarea
                                id="objectives"
                                name="objectives"
                                rows="3"
                                placeholder="Project objectives..."
                                class="w-full"
                            />
                        </div>

                        <!-- Deliverables -->
                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Deliverables
                            </label>
                            <x-base.form-textarea
                                id="deliverables"
                                name="deliverables"
                                rows="3"
                                placeholder="Expected deliverables..."
                                class="w-full"
                            />
                        </div>

                        <!-- Risks -->
                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Risks
                            </label>
                            <x-base.form-textarea
                                id="risks"
                                name="risks"
                                rows="3"
                                placeholder="Potential risks..."
                                class="w-full"
                            />
                        </div>

                        <!-- Notes -->
                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Notes
                            </label>
                            <x-base.form-textarea
                                id="notes"
                                name="notes"
                                rows="3"
                                placeholder="Additional notes..."
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
                    id="submit-project-btn"
                >
                    <x-base.lucide icon="Save" class="w-4 h-4 mr-2" />
                    Create Project
                </x-base.button>
            </x-base.dialog.footer>
        </form>
    </x-base.dialog.panel>
</x-base.dialog>

<script>
// Project Form Handling
document.addEventListener('DOMContentLoaded', function() {
    const projectForm = document.getElementById('add-project-form');
    const companySelect = document.getElementById('company_id');
    const departmentSelect = document.getElementById('department_id');

    // Load departments when company changes
    if (companySelect) {
        companySelect.addEventListener('change', function() {
            loadDepartmentsForCompany(this.value, departmentSelect);
        });
    }

    // Form submission
    if (projectForm) {
        projectForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const submitBtn = document.getElementById('submit-project-btn');
            const originalText = submitBtn.innerHTML;

            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<x-base.lucide icon="Loader" class="w-4 h-4 mr-2 animate-spin"></x-base.lucide>Creating...';

            const formData = new FormData(projectForm);

            // Convert FormData to JSON for better handling
            const data = {};
            for (let [key, value] of formData.entries()) {
                if (key === 'skills') {
                    // Handle skills as array
                    data[key] = value ? value.split(',').map(function(s) { return s.trim(); }) : [];
                } else {
                    data[key] = value;
                }
            }

            console.log('Converted data:', data);

            fetch('{{ route("project-management.projects.store") }}', {
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
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
                if (data.success) {
                    showToast(data.message || 'Project created successfully', 'success');

                    // Reset form and close modal
                    projectForm.reset();
                    const modal = document.getElementById('add-project-modal');
                    if (modal) {
                        modal.__tippy?.hide();
                    }

                    // Reload table
                    if (window.projectTable) {
                        window.projectTable.ajax.reload(null, false);
                    }
                } else {
                    // Show validation errors
                    if (data.errors) {
                        let errorMessage = 'Validation errors:\n';
                        Object.values(data.errors).forEach(function(errors) {
                            if (Array.isArray(errors)) {
                                errors.forEach(function(error) { errorMessage += '• ' + error + '\n'; });
                            } else {
                                errorMessage += '• ' + errors + '\n';
                            }
                        });
                        showToast(errorMessage, 'error');
                    } else {
                        showToast(data.message || 'Failed to create project', 'error');
                    }
                }
            })
            .catch(function(error) {
                console.error('Error creating project:', error);
                showToast('An error occurred while creating the project', 'error');
            })
            .finally(function() {
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

        fetch('/hr/departments/api/company/' + companyId, {
            credentials: 'same-origin',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            departmentSelect.innerHTML = '<option value="">Select Department</option>';
            if (data && Array.isArray(data)) {
                data.forEach(function(dept) {
                    const option = document.createElement('option');
                    option.value = dept.id;
                    option.textContent = dept.name;
                    departmentSelect.appendChild(option);
                });
            }
        })
        .catch(function(error) {
            console.error('Error loading departments:', error);
            departmentSelect.innerHTML = '<option value="">Error loading departments</option>';
        });
    }
});
</script>

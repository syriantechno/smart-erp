@php
    $companies = \App\Models\Company::active()->get();
    $departments = \App\Models\Department::active()->get();
    $employees = \App\Models\Employee::active()->get();
@endphp
<x-modal.form id="edit-task-modal" title="Edit Task" size="lg">
    <form id="edit-task-form" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <input type="hidden" id="edit-task-id" name="id">

        <!-- Task Information -->
        <div class="mb-6">
            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <x-base.lucide icon="CheckSquare" class="h-5 w-5"></x-base.lucide>
                Task Information
            </h4>
            <div class="grid grid-cols-12 gap-4 gap-y-4">
                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="edit-code">Task Code</x-base.form-label>
                    <x-base.form-input id="edit-code" name="code" type="text" class="w-full" readonly />
                </div>

                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="edit-title">Task Title <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-input id="edit-title" name="title" type="text" placeholder="Enter task title" class="w-full" required />
                </div>

                <div class="col-span-12">
                    <x-base.form-label for="edit-description">Description</x-base.form-label>
                    <x-base.form-textarea id="edit-description" name="description" rows="3" placeholder="Enter task description" class="w-full"></x-base.form-textarea>
                </div>

                <div class="col-span-12 md:col-span-4">
                    <x-base.form-label for="edit-priority">Priority <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-select id="edit-priority" name="priority" class="w-full" required>
                        <option value="">Select Priority</option>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </x-base.form-select>
                </div>

                <div class="col-span-12 md:col-span-4">
                    <x-base.form-label for="edit-status">Status <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-select id="edit-status" name="status" class="w-full" required>
                        <option value="">Select Status</option>
                        <option value="pending">Pending</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </x-base.form-select>
                </div>

                <div class="col-span-12 md:col-span-4">
                    <x-base.form-label for="edit-due-date">Due Date</x-base.form-label>
                    <x-base.form-input id="edit-due-date" name="due_date" type="date" class="w-full" />
                </div>
            </div>
        </div>

        <!-- Assignment Information -->
        <div class="mb-6">
            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <x-base.lucide icon="User" class="h-5 w-5"></x-base.lucide>
                Assignment Information
            </h4>
            <div class="grid grid-cols-12 gap-4 gap-y-4">
                <div class="col-span-12 md:col-span-4">
                    <x-base.form-label for="edit-company-id">Company</x-base.form-label>
                    <x-base.form-select id="edit-company-id" name="company_id" class="w-full">
                        <option value="">Select Company</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>

                <div class="col-span-12 md:col-span-4">
                    <x-base.form-label for="edit-department-id">Department</x-base.form-label>
                    <x-base.form-select id="edit-department-id" name="department_id" class="w-full">
                        <option value="">Select Department</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>

                <div class="col-span-12 md:col-span-4">
                    <x-base.form-label for="edit-employee-id">Assigned Employee</x-base.form-label>
                    <x-base.form-select id="edit-employee-id" name="employee_id" class="w-full">
                        <option value="">Select Employee</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->full_name }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>

                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="edit-is-active">Active Status</x-base.form-label>
                    <x-base.form-select id="edit-is-active" name="is_active" class="w-full">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
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
                type="submit"
                form="edit-task-form"
                variant="primary"
            >
                <x-base.lucide icon="Save" class="w-4 h-4 mr-2" />
                Update
            </x-base.button>
        </div>
    @endslot

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🎯 Edit task modal script loaded');

            // Company change handler
            const companySelect = document.getElementById('edit-company-id');
            const departmentSelect = document.getElementById('edit-department-id');
            const employeeSelect = document.getElementById('edit-employee-id');

            if (companySelect) {
                companySelect.addEventListener('change', function() {
                    console.log('🏢 Company changed to:', this.value);
                    if (departmentSelect) {
                        departmentSelect.innerHTML = '<option value="">Select Department</option>';
                        @foreach($departments as $department)
                            const deptOption = document.createElement('option');
                            deptOption.value = '{{ $department->id }}';
                            deptOption.textContent = '{{ $department->name }}';
                            if ({{ $department->company_id }} == this.value || this.value === '') {
                                departmentSelect.appendChild(deptOption);
                            }
                        @endforeach
                    }
                    // Reset employee selection
                    if (employeeSelect) {
                        employeeSelect.value = '';
                    }
                });
            }

            if (departmentSelect) {
                departmentSelect.addEventListener('change', function() {
                    console.log('🏢 Department changed to:', this.value);
                    if (employeeSelect) {
                        employeeSelect.innerHTML = '<option value="">Select Employee</option>';
                        @foreach($employees as $employee)
                            const empOption = document.createElement('option');
                            empOption.value = '{{ $employee->id }}';
                            empOption.textContent = '{{ $employee->full_name }}';
                            if ({{ $employee->department_id ?? 'null' }} == this.value || this.value === '') {
                                employeeSelect.appendChild(empOption);
                            }
                        @endforeach
                    }
                });
            }
        });
    </script>
</x-modal.form>

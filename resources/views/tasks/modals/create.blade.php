@php
    $companies = \App\Models\Company::active()->get();
    $codeGenerator = app(\App\Services\DocumentCodeGenerator::class);
    $previewCode = $codeGenerator->preview('tasks');
    $departments = \App\Models\Department::active()->get();
    $employees = \App\Models\Employee::active()->get();
@endphp
<x-modal.form id="create-task-modal" title="Add New Task" size="lg">
    <form id="create-task-form" action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Task Information -->
        <div class="mb-6">
            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <x-base.lucide icon="CheckSquare" class="h-5 w-5"></x-base.lucide>
                Task Information
            </h4>
            <div class="grid grid-cols-12 gap-4 gap-y-4">
                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="code">Task Code</x-base.form-label>
                    <x-base.form-input id="code" name="code" type="text" class="w-full" value="{{ $previewCode }}" readonly />
                </div>

                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="title">Task Title <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-input id="title" name="title" type="text" placeholder="Enter task title" class="w-full" required />
                </div>

                <div class="col-span-12">
                    <x-base.form-label for="description">Description</x-base.form-label>
                    <x-base.form-textarea id="description" name="description" rows="3" placeholder="Enter task description" class="w-full"></x-base.form-textarea>
                </div>

                <div class="col-span-12 md:col-span-4">
                    <x-base.form-label for="priority">Priority <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-select id="priority" name="priority" class="w-full" required>
                        <option value="">Select Priority</option>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </x-base.form-select>
                </div>

                <div class="col-span-12 md:col-span-4">
                    <x-base.form-label for="status">Status <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-select id="status" name="status" class="w-full" required>
                        <option value="">Select Status</option>
                        <option value="pending">Pending</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </x-base.form-select>
                </div>

                <div class="col-span-12 md:col-span-4">
                    <x-base.form-label for="due_date">Due Date</x-base.form-label>
                    <div class="relative mx-auto w-56">
                        <div
                            class="absolute flex h-full w-10 items-center justify-center rounded-l border bg-slate-100 text-slate-500 dark:border-darkmode-800 dark:bg-darkmode-700 dark:text-slate-400">
                            <x-base.lucide icon="calendar" class="stroke-1.5 w-5 h-5"></x-base.lucide>
                        </div>
                        <x-base.litepicker
                            id="due_date"
                            name="due_date"
                            class="pl-12"
                            data-single-mode="true"
                        />
                    </div>
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
                    <x-base.form-label for="company_id">Company</x-base.form-label>
                    <x-base.form-select id="company_id" name="company_id" class="w-full">
                        <option value="">Select Company</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>

                <div class="col-span-12 md:col-span-4">
                    <x-base.form-label for="department_id">Department</x-base.form-label>
                    <x-base.form-select id="department_id" name="department_id" class="w-full">
                        <option value="">Select Department</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>

                <div class="col-span-12 md:col-span-4">
                    <x-base.form-label for="employee_id">Assigned Employee</x-base.form-label>
                    <x-base.form-select id="employee_id" name="employee_id" class="w-full">
                        <option value="">Select Employee</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->full_name }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>

                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="is_active">Active Status</x-base.form-label>
                    <x-base.form-select id="is_active" name="is_active" class="w-full">
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
                form="create-task-form"
                variant="primary"
            >
                <x-base.lucide icon="Save" class="w-4 h-4 mr-2" />
                Save
            </x-base.button>
        </div>
    @endslot

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🎯 Task modal script loaded');

            // Company change handler
            const companySelect = document.getElementById('company_id');
            const departmentSelect = document.getElementById('department_id');
            const employeeSelect = document.getElementById('employee_id');

            if (companySelect) {
                companySelect.addEventListener('change', function() {
                    console.log('🏢 Company changed to:', this.value);
                    if (departmentSelect) {
                        departmentSelect.innerHTML = '<option value="">Select Department</option>';
                        @foreach($departments as $department)
                            if ({{ $department->company_id }} == this.value || this.value === '') {
                                departmentSelect.innerHTML += '<option value="{{ $department->id }}">{{ $department->name }}</option>';
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
                            if ({{ $employee->department_id ?? 'null' }} == this.value || this.value === '') {
                                employeeSelect.innerHTML += '<option value="{{ $employee->id }}">{{ $employee->full_name }}</option>';
                            }
                        @endforeach
                    }
                });
            }
        });
    </script>
</x-modal.form>

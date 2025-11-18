@php
    $codeGenerator = app(\App\Services\DocumentCodeGenerator::class);
    $previewCode = $codeGenerator->preview('tasks');
    $employees = \App\Models\HR\Employee::active()->with(['department', 'company'])->get();
    $projects = \App\Models\Work\Project::active()->get();
@endphp
<x-modal.form id="create-task-modal" title="Add New Task" size="xl">
    <form id="create-task-form" action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Task Information -->
        <div class="mb-6">
            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <x-base.lucide icon="CheckSquare" class="h-5 w-5 text-primary"></x-base.lucide>
                Task Information
            </h4>
            <div class="grid grid-cols-12 gap-4 gap-y-4">
                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="code">Task Code</x-base.form-label>
                    <x-base.form-input id="code" name="code" type="text" class="w-full bg-slate-50" value="{{ $previewCode }}" readonly />
                </div>

                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="title">Task Title <span class="text-red-500">*</span></x-base.form-label>
                    <x-base.form-input id="title" name="title" type="text" placeholder="Enter task title" class="w-full" required />
                </div>

                <div class="col-span-12">
                    <x-base.form-label for="description">Description</x-base.form-label>
                    <x-base.form-textarea id="description" name="description" rows="3" placeholder="Enter task description" class="w-full"></x-base.form-textarea>
                </div>

                <div class="col-span-12 md:col-span-3">
                    <x-base.form-label for="priority">Priority <span class="text-red-500">*</span></x-base.form-label>
                    <x-base.form-select id="priority" name="priority" class="w-full" required>
                        <option value="">Select Priority</option>
                        <option value="low">Low</option>
                        <option value="medium" selected>Medium</option>
                        <option value="high">High</option>
                    </x-base.form-select>
                </div>

                <div class="col-span-12 md:col-span-3">
                    <x-base.form-label for="status">Status <span class="text-red-500">*</span></x-base.form-label>
                    <x-base.form-select id="status" name="status" class="w-full" required>
                        <option value="pending" selected>Pending</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </x-base.form-select>
                </div>

                <div class="col-span-12 md:col-span-3">
                    <x-base.form-label for="color">Task Color</x-base.form-label>
                    <div class="flex gap-2 items-center">
                        <x-base.form-input id="color" name="color" type="color" class="w-16 h-10 p-1" value="#2563eb" />
                        <div class="flex-1 relative">
                            <x-base.form-select id="color-preset" class="w-full color-preset-select">
                                <option value="">Choose Preset</option>
                                <option value="primary" data-color="#2563eb">● Primary</option>
                                <option value="success" data-color="#1b7a4a">● Success</option>
                                <option value="warning" data-color="#c98028">● Warning</option>
                                <option value="danger" data-color="#b21a50">● Danger</option>
                                <option value="info" data-color="#2563eb">● Info</option>
                            </x-base.form-select>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 md:col-span-3">
                    <x-base.form-label for="due_date">Due Date</x-base.form-label>
                    <div class="relative w-full">
                        <div
                            class="absolute flex h-full w-10 items-center justify-center rounded-l border bg-slate-100 text-slate-500 dark:border-darkmode-800 dark:bg-darkmode-700 dark:text-slate-400">
                            <x-base.lucide icon="calendar" class="stroke-1.5 w-5 h-5"></x-base.lucide>
                        </div>
                        <x-base.litepicker
                            id="due_date"
                            name="due_date"
                            class="pl-12"
                            data-single-mode="true"
                            data-format="YYYY-MM-DD"
                        />
                    </div>
                </div>
            </div>
        </div>

        <!-- Assignment & Project Information -->
        <div class="mb-6">
            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <x-base.lucide icon="Users" class="h-5 w-5 text-primary"></x-base.lucide>
                Assignment & Project
            </h4>
            <div class="grid grid-cols-12 gap-4 gap-y-4">
                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="employee_id">Assigned Employee</x-base.form-label>
                    <x-base.form-select id="employee_id" name="employee_id" class="w-full">
                        <option value="">Select Employee</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" 
                                    data-department="{{ $employee->department->name ?? 'No Department' }}"
                                    data-company="{{ $employee->company->name ?? 'No Company' }}">
                                {{ $employee->full_name }} 
                                @if($employee->department)
                                    ({{ $employee->department->name }})
                                @endif
                            </option>
                        @endforeach
                    </x-base.form-select>
                </div>

                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="project_id">Project (Optional)</x-base.form-label>
                    <x-base.form-select id="project_id" name="project_id" class="w-full">
                        <option value="">General / No Project</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}">
                                {{ $project->name ?? $project->code ?? ('Project #' . $project->id) }}
                            </option>
                        @endforeach
                    </x-base.form-select>
                </div>
            </div>
        </div>

        <!-- Additional Features -->
        <div class="mb-6">
            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <x-base.lucide icon="Settings" class="h-5 w-5 text-primary"></x-base.lucide>
                Additional Options
            </h4>
            <div class="grid grid-cols-12 gap-4 gap-y-4">
                <div class="col-span-12 md:col-span-4">
                    <x-base.form-label for="estimated_hours">Estimated Hours</x-base.form-label>
                    <x-base.form-input id="estimated_hours" name="estimated_hours" type="number" 
                                       min="0" step="0.5" placeholder="0.0" class="w-full" />
                    <div class="text-xs text-slate-500 mt-1">How many hours do you estimate this task will take?</div>
                </div>

                <div class="col-span-12 md:col-span-4">
                    <x-base.form-label for="tags">Tags</x-base.form-label>
                    <x-base.form-input id="tags" name="tags" type="text" 
                                       placeholder="urgent, frontend, bug" class="w-full" />
                    <div class="text-xs text-slate-500 mt-1">Separate tags with commas</div>
                </div>

                <div class="col-span-12 md:col-span-4">
                    <x-base.form-label for="is_active">Status</x-base.form-label>
                    <div class="flex items-center gap-3 mt-2">
                        <label class="inline-flex cursor-pointer items-center gap-3">
                            <input type="checkbox" name="is_active" value="1" checked class="sr-only peer" />
                            <div class="relative w-11 h-6 rounded-full bg-slate-200 transition-colors duration-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/25 dark:bg-darkmode-600 peer-checked:bg-primary after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition-all after:duration-200 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full"></div>
                            <span class="text-sm font-medium">Active Task</span>
                        </label>
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
                form="create-task-form"
                variant="primary"
            >
                <x-base.lucide icon="Save" class="w-4 h-4 mr-2" />
                Save
            </x-base.button>
        </div>
    @endslot

    <style>
        /* Color preset select styling using btn-tonal colors */
        .color-preset-select option[value="primary"] {
            color: var(--color-primary, #2563eb) !important;
        }
        .color-preset-select option[value="success"] {
            color: #1b7a4a !important;
        }
        .color-preset-select option[value="warning"] {
            color: #c98028 !important;
        }
        .color-preset-select option[value="danger"] {
            color: #b21a50 !important;
        }
        .color-preset-select option[value="info"] {
            color: var(--color-primary, #2563eb) !important;
        }
        
        /* Custom color dots with proper styling */
        .color-preset-select option {
            padding: 8px 12px !important;
            font-weight: 500 !important;
        }
        
        .color-preset-select option[value="primary"]::before {
            content: "●";
            margin-right: 8px;
            font-size: 16px;
            color: var(--color-primary, #2563eb);
        }
        
        .color-preset-select option[value="success"]::before {
            content: "●";
            margin-right: 8px;
            font-size: 16px;
            color: #1b7a4a;
        }
        
        .color-preset-select option[value="warning"]::before {
            content: "●";
            margin-right: 8px;
            font-size: 16px;
            color: #c98028;
        }
        
        .color-preset-select option[value="danger"]::before {
            content: "●";
            margin-right: 8px;
            font-size: 16px;
            color: #b21a50;
        }
        
        .color-preset-select option[value="info"]::before {
            content: "●";
            margin-right: 8px;
            font-size: 16px;
            color: var(--color-primary, #2563eb);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🎯 Task modal script loaded');

            // Color preset handler
            const colorInput = document.getElementById('color');
            const colorPreset = document.getElementById('color-preset');
            
            if (colorPreset && colorInput) {
                colorPreset.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const colorValue = selectedOption.getAttribute('data-color');
                    
                    if (colorValue) {
                        colorInput.value = colorValue;
                        console.log('🎨 Color changed to:', colorValue);
                    }
                });
            }

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

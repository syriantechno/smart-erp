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

        <!-- Task Steps -->
        <div class="mb-6">
            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <x-base.lucide icon="List" class="h-5 w-5 text-primary"></x-base.lucide>
                Task Timeline Steps
            </h4>
            <div class="bg-slate-50 dark:bg-darkmode-600 rounded-lg p-4">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm text-slate-600 dark:text-slate-400">
                        Add steps to create a timeline for this task. Each step can be marked as completed individually.
                    </p>
                    <x-base.button type="button" id="add-step-btn" variant="outline-primary" size="sm">
                        <x-base.lucide icon="Plus" class="w-4 h-4 mr-1" />
                        Add Step
                    </x-base.button>
                </div>
                
                <div id="task-steps-container" class="space-y-3">
                    <!-- Steps will be added here dynamically -->
                </div>
                
                <div id="no-steps-message" class="text-center py-8 text-slate-500">
                    <x-base.lucide icon="ListChecks" class="w-12 h-12 mx-auto mb-2 text-slate-300" />
                    <p>No steps added yet. Click "Add Step" to create your first timeline step.</p>
                </div>
            </div>
        </div>
    </form>

    @slot('footer')
        <div class="flex justify-end gap-2 w-full">
            <button
                type="button"
                data-tw-dismiss="modal"
                class="btn-tonal btn-tonal--neutral w-28 group"
            >
                <x-base.lucide icon="X" class="w-4 h-4 mr-2 icon-hover-rise" />
                Cancel
            </button>
            <button
                type="submit"
                form="create-task-form"
                class="btn-tonal btn-tonal--success w-36 group"
            >
                <x-base.lucide icon="Save" class="w-4 h-4 mr-2 icon-hover-rise" />
                Create Task
            </button>
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
        // Wrap everything in try-catch to prevent errors from stopping execution
        try {
            console.log('🎯 Task modal script starting...');
            
            document.addEventListener('DOMContentLoaded', function() {
                console.log('🎯 Task modal DOM loaded');
            
            // Also check when modal is shown
            const modal = document.getElementById('create-task-modal');
            if (modal) {
                modal.addEventListener('shown.tw.modal', function() {
                    console.log('📋 Create task modal opened');
                    
                    // Re-check elements when modal is shown
                    const stepsContainer = document.getElementById('task-steps-container');
                    const addStepBtn = document.getElementById('add-step-btn');
                    console.log('Modal opened - stepsContainer:', stepsContainer);
                    console.log('Modal opened - addStepBtn:', addStepBtn);
                });
            }

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

            // Task Steps Management
            let stepCounter = 0;
            const stepsContainer = document.getElementById('task-steps-container');
            const noStepsMessage = document.getElementById('no-steps-message');
            const addStepBtn = document.getElementById('add-step-btn');

            console.log('🔍 Task Steps Elements Check:');
            console.log('stepsContainer:', stepsContainer);
            console.log('noStepsMessage:', noStepsMessage);
            console.log('addStepBtn:', addStepBtn);

            function updateStepNumbers() {
                const stepItems = stepsContainer.querySelectorAll('.step-item');
                stepItems.forEach((item, index) => {
                    const numberSpan = item.querySelector('.step-number');
                    const orderInput = item.querySelector('input[name$="[step_order]"]');
                    if (numberSpan) numberSpan.textContent = index + 1;
                    if (orderInput) orderInput.value = index + 1;
                });
                
                // Update step name attributes
                stepItems.forEach((item, index) => {
                    const titleInput = item.querySelector('input[name*="[title]"]');
                    const descInput = item.querySelector('textarea[name*="[description]"]');
                    const orderInput = item.querySelector('input[name*="[step_order]"]');
                    
                    if (titleInput) titleInput.name = `steps[${index}][title]`;
                    if (descInput) descInput.name = `steps[${index}][description]`;
                    if (orderInput) orderInput.name = `steps[${index}][step_order]`;
                });
            }

            function toggleNoStepsMessage() {
                const hasSteps = stepsContainer.children.length > 0;
                noStepsMessage.style.display = hasSteps ? 'none' : 'block';
            }

            function createStepItem() {
                stepCounter++;
                const stepDiv = document.createElement('div');
                stepDiv.className = 'step-item bg-white dark:bg-darkmode-700 border border-slate-200 dark:border-darkmode-400 rounded-lg p-4';
                stepDiv.innerHTML = `
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center text-sm font-semibold">
                            <span class="step-number">${stepCounter}</span>
                        </div>
                        <div class="flex-1 space-y-3">
                            <div>
                                <label class="inline-block mb-2 text-slate-600 dark:text-slate-300">Step Title <span class="text-red-500">*</span></label>
                                <input 
                                    name="steps[${stepCounter-1}][title]" 
                                    type="text" 
                                    placeholder="e.g., Contact the client" 
                                    class="w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm placeholder-slate-400 shadow-sm transition duration-200 ease-in-out focus:border-primary focus:outline-none focus:ring-4 focus:ring-primary/20 dark:border-darkmode-300 dark:bg-darkmode-800 dark:text-white dark:placeholder-slate-500 dark:focus:border-primary" 
                                    required 
                                />
                            </div>
                            <div>
                                <label class="inline-block mb-2 text-slate-600 dark:text-slate-300">Step Description (Optional)</label>
                                <textarea 
                                    name="steps[${stepCounter-1}][description]" 
                                    rows="2" 
                                    placeholder="Additional details about this step..." 
                                    class="w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm placeholder-slate-400 shadow-sm transition duration-200 ease-in-out focus:border-primary focus:outline-none focus:ring-4 focus:ring-primary/20 dark:border-darkmode-300 dark:bg-darkmode-800 dark:text-white dark:placeholder-slate-500 dark:focus:border-primary resize-none"
                                ></textarea>
                            </div>
                            <input type="hidden" name="steps[${stepCounter-1}][step_order]" value="${stepCounter}" />
                        </div>
                        <div class="flex-shrink-0 flex gap-2">
                            <button type="button" class="move-up-btn inline-flex items-center justify-center rounded-md border border-slate-300 bg-white px-2 py-1 text-xs font-medium text-slate-700 shadow-sm transition duration-200 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-darkmode-300 dark:bg-darkmode-600 dark:text-slate-300 dark:hover:bg-darkmode-500" title="Move Up">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15L12 8L19 15"></path></svg>
                            </button>
                            <button type="button" class="move-down-btn inline-flex items-center justify-center rounded-md border border-slate-300 bg-white px-2 py-1 text-xs font-medium text-slate-700 shadow-sm transition duration-200 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-darkmode-300 dark:bg-darkmode-600 dark:text-slate-300 dark:hover:bg-darkmode-500" title="Move Down">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9L12 16L5 9"></path></svg>
                            </button>
                            <button type="button" class="remove-step-btn inline-flex items-center justify-center rounded-md border border-red-300 bg-white px-2 py-1 text-xs font-medium text-red-700 shadow-sm transition duration-200 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500/20 dark:border-red-600 dark:bg-darkmode-600 dark:text-red-400 dark:hover:bg-red-900/20" title="Remove Step">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7L5 7M19 7L17.133 19.142A2 2 0 0115.138 21H8.862A2 2 0 016.867 19.142L5 7M10 11V17M14 11V17M15 7V4A1 1 0 0014 3H10A1 1 0 009 4V7"></path></svg>
                            </button>
                        </div>
                    </div>
                `;
                return stepDiv;
            }

            if (addStepBtn) {
                console.log('✅ Add Step button found and event listener attached');
                addStepBtn.addEventListener('click', function() {
                    console.log('🔥 Add Step button clicked!');
                    const stepItem = createStepItem();
                    stepsContainer.appendChild(stepItem);
                    updateStepNumbers();
                    toggleNoStepsMessage();
                    
                    // Focus on the title input
                    const titleInput = stepItem.querySelector('input[name*="[title]"]');
                    if (titleInput) titleInput.focus();
                    
                    console.log('✅ Step added successfully');
                });
            } else {
                console.error('❌ Add Step button not found!');
            }

            // Event delegation for step actions
            if (stepsContainer) {
                stepsContainer.addEventListener('click', function(e) {
                    const stepItem = e.target.closest('.step-item');
                    if (!stepItem) return;

                    if (e.target.closest('.remove-step-btn')) {
                        stepItem.remove();
                        updateStepNumbers();
                        toggleNoStepsMessage();
                    } else if (e.target.closest('.move-up-btn')) {
                        const prevSibling = stepItem.previousElementSibling;
                        if (prevSibling) {
                            stepsContainer.insertBefore(stepItem, prevSibling);
                            updateStepNumbers();
                        }
                    } else if (e.target.closest('.move-down-btn')) {
                        const nextSibling = stepItem.nextElementSibling;
                        if (nextSibling) {
                            stepsContainer.insertBefore(nextSibling, stepItem);
                            updateStepNumbers();
                        }
                    }
                });
            }

            // Initialize
            toggleNoStepsMessage();

            // Alternative event listener using document delegation
            document.addEventListener('click', function(e) {
                if (e.target && e.target.id === 'add-step-btn') {
                    console.log('🔥 Add Step button clicked via delegation!');
                    e.preventDefault();
                    
                    const stepItem = createStepItem();
                    const container = document.getElementById('task-steps-container');
                    if (container) {
                        container.appendChild(stepItem);
                        updateStepNumbers();
                        toggleNoStepsMessage();
                        
                        // Focus on the title input
                        const titleInput = stepItem.querySelector('input[name*="[title]"]');
                        if (titleInput) titleInput.focus();
                        
                        console.log('✅ Step added via delegation');
                    }
                }
            });

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
                            if ('{{ $department->company_id }}' == this.value || this.value === '') {
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
                            if ('{{ $employee->department_id ?? "" }}' == this.value || this.value === '') {
                                employeeSelect.innerHTML += '<option value="{{ $employee->id }}">{{ $employee->full_name }}</option>';
                            }
                        @endforeach
                    }
                });
            }
        });
        
        } catch (error) {
            console.error('❌ Task modal script error:', error);
        }
    </script>

    <!-- Simple fallback script for Add Step button -->
    <script>
        console.log('🔧 Fallback script loaded');
        
        // Simple click handler that should always work
        setTimeout(function() {
            const btn = document.getElementById('add-step-btn');
            console.log('🔍 Fallback check - Add Step button:', btn);
            
            if (btn) {
                btn.onclick = function(e) {
                    console.log('🚀 Fallback: Add Step clicked!');
                    e.preventDefault();
                    
                    // Simple step creation
                    const container = document.getElementById('task-steps-container');
                    const noMsg = document.getElementById('no-steps-message');
                    
                    if (container) {
                        const stepCount = container.children.length + 1;
                        const stepHTML = `
                            <div class="step-item bg-white dark:bg-darkmode-700 border border-slate-200 dark:border-darkmode-400 rounded-lg p-4 mb-3">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0 w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center text-sm font-semibold">
                                        ${stepCount}
                                    </div>
                                    <div class="flex-1 space-y-3">
                                        <div>
                                            <label class="inline-block mb-2 text-slate-600 dark:text-slate-300">Step Title <span class="text-red-500">*</span></label>
                                            <input name="steps[${stepCount-1}][title]" type="text" placeholder="e.g., Contact the client" class="w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm" required />
                                        </div>
                                        <div>
                                            <label class="inline-block mb-2 text-slate-600 dark:text-slate-300">Step Description (Optional)</label>
                                            <textarea name="steps[${stepCount-1}][description]" rows="2" placeholder="Additional details..." class="w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm resize-none"></textarea>
                                        </div>
                                        <input type="hidden" name="steps[${stepCount-1}][step_order]" value="${stepCount}" />
                                    </div>
                                    <div class="flex-shrink-0">
                                        <button type="button" onclick="this.closest('.step-item').remove()" class="text-red-600 hover:text-red-800 p-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7L5 7M19 7L17.133 19.142A2 2 0 0115.138 21H8.862A2 2 0 016.867 19.142L5 7M10 11V17M14 11V17M15 7V4A1 1 0 0014 3H10A1 1 0 009 4V7"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                        
                        container.insertAdjacentHTML('beforeend', stepHTML);
                        
                        if (noMsg) {
                            noMsg.style.display = 'none';
                        }
                        
                        console.log('✅ Fallback: Step added successfully');
                        
                        // Focus on the new input
                        const newInput = container.lastElementChild.querySelector('input[type="text"]');
                        if (newInput) newInput.focus();
                    }
                };
            }
        }, 1000);
    </script>
</x-modal.form>

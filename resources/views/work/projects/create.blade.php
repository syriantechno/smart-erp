@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Create Project - {{ config('app.name') }}</title>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">
@endpush

@section('subcontent')
    @include('components.global-notifications')

    <div class="mt-8 grid grid-cols-12 gap-6">
        <div class="col-span-12">
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-medium">Create New Project</h2>
                        <x-base.button
                            variant="outline-secondary"
                            onclick="window.location.href='{{ route('work.projects.index') }}'"
                        >
                            <x-base.lucide icon="ArrowLeft" class="w-4 h-4 mr-2" />
                            Back to Projects
                        </x-base.button>
                    </div>

                    <form id="create-project-form" enctype="multipart/form-data">
                        @csrf

                        <!-- Basic Information -->
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4">Basic Information</h4>

                            <div class="grid grid-cols-12 gap-4">
                                <div class="col-span-12 md:col-span-6">
                                    <label class="form-label">Project Code <span class="text-danger">*</span></label>
                                    <x-base.form-input
                                        id="code"
                                        name="code"
                                        type="text"
                                        placeholder="Enter project code"
                                        class="w-full"
                                        required
                                    />
                                </div>

                                <div class="col-span-12 md:col-span-6">
                                    <label class="form-label">Project Name <span class="text-danger">*</span></label>
                                    <x-base.form-input
                                        id="name"
                                        name="name"
                                        type="text"
                                        placeholder="Enter project name"
                                        class="w-full"
                                        required
                                    />
                                </div>

                                <div class="col-span-12">
                                    <label class="form-label">Description</label>
                                    <x-base.form-textarea
                                        id="description"
                                        name="description"
                                        rows="3"
                                        placeholder="Enter project description"
                                        class="w-full"
                                    ></x-base.form-textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Organization -->
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4">Organization</h4>

                            <div class="grid grid-cols-12 gap-4">
                                <div class="col-span-12 md:col-span-4">
                                    <label class="form-label">Company <span class="text-danger">*</span></label>
                                    <x-base.form-select id="company_id" name="company_id" class="w-full" required>
                                        <option value="">Select Company</option>
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </x-base.form-select>
                                </div>

                                <div class="col-span-12 md:col-span-4">
                                    <label class="form-label">Department</label>
                                    <x-base.form-select id="department_id" name="department_id" class="w-full">
                                        <option value="">Select Department</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    </x-base.form-select>
                                </div>

                                <div class="col-span-12 md:col-span-4">
                                    <label class="form-label">Project Manager</label>
                                    <x-base.form-select id="manager_id" name="manager_id" class="w-full">
                                        <option value="">Select Manager</option>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                        @endforeach
                                    </x-base.form-select>
                                </div>
                            </div>
                        </div>

                        <!-- Timeline -->
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4">Timeline</h4>

                            <div class="grid grid-cols-12 gap-4">
                                <div class="col-span-12 md:col-span-4">
                                    <label class="form-label">Start Date <span class="text-danger">*</span></label>
                                    <x-base.form-input
                                        id="start_date"
                                        name="start_date"
                                        type="date"
                                        class="w-full"
                                        required
                                    />
                                </div>

                                <div class="col-span-12 md:col-span-4">
                                    <label class="form-label">End Date</label>
                                    <x-base.form-input
                                        id="end_date"
                                        name="end_date"
                                        type="date"
                                        class="w-full"
                                    />
                                </div>

                                <div class="col-span-12 md:col-span-4">
                                    <label class="form-label">Progress (%)</label>
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
                            </div>
                        </div>

                        <!-- Status & Priority -->
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4">Status & Priority</h4>

                            <div class="grid grid-cols-12 gap-4">
                                <div class="col-span-12 md:col-span-6">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <x-base.form-select id="status" name="status" class="w-full" required>
                                        <option value="planning">Planning</option>
                                        <option value="active">Active</option>
                                        <option value="on_hold">On Hold</option>
                                        <option value="completed">Completed</option>
                                        <option value="cancelled">Cancelled</option>
                                    </x-base.form-select>
                                </div>

                                <div class="col-span-12 md:col-span-6">
                                    <label class="form-label">Priority <span class="text-danger">*</span></label>
                                    <x-base.form-select id="priority" name="priority" class="w-full" required>
                                        <option value="low">Low</option>
                                        <option value="medium">Medium</option>
                                        <option value="high">High</option>
                                        <option value="critical">Critical</option>
                                    </x-base.form-select>
                                </div>
                            </div>
                        </div>

                        <!-- Budget -->
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4">Budget & Costs</h4>

                            <div class="grid grid-cols-12 gap-4">
                                <div class="col-span-12 md:col-span-6">
                                    <label class="form-label">Budget</label>
                                    <x-base.form-input
                                        id="budget"
                                        name="budget"
                                        type="number"
                                        step="0.01"
                                        placeholder="Enter budget amount"
                                        class="w-full"
                                    />
                                </div>

                                <div class="col-span-12 md:col-span-6">
                                    <label class="form-label">Actual Cost</label>
                                    <x-base.form-input
                                        id="actual_cost"
                                        name="actual_cost"
                                        type="number"
                                        step="0.01"
                                        placeholder="Enter actual cost"
                                        class="w-full"
                                    />
                                </div>
                            </div>
                        </div>

                        <!-- Objectives & Deliverables -->
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4">Objectives & Deliverables</h4>

                            <div class="grid grid-cols-12 gap-4">
                                <div class="col-span-12 md:col-span-6">
                                    <label class="form-label">Objectives</label>
                                    <x-base.form-textarea
                                        id="objectives"
                                        name="objectives"
                                        rows="3"
                                        placeholder="Enter project objectives"
                                        class="w-full"
                                    ></x-base.form-textarea>
                                </div>

                                <div class="col-span-12 md:col-span-6">
                                    <label class="form-label">Deliverables</label>
                                    <x-base.form-textarea
                                        id="deliverables"
                                        name="deliverables"
                                        rows="3"
                                        placeholder="Enter project deliverables"
                                        class="w-full"
                                    ></x-base.form-textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Risks & Notes -->
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4">Risks & Notes</h4>

                            <div class="grid grid-cols-12 gap-4">
                                <div class="col-span-12 md:col-span-6">
                                    <label class="form-label">Risks</label>
                                    <x-base.form-textarea
                                        id="risks"
                                        name="risks"
                                        rows="3"
                                        placeholder="Enter project risks"
                                        class="w-full"
                                    ></x-base.form-textarea>
                                </div>

                                <div class="col-span-12 md:col-span-6">
                                    <label class="form-label">Notes</label>
                                    <x-base.form-textarea
                                        id="notes"
                                        name="notes"
                                        rows="3"
                                        placeholder="Enter additional notes"
                                        class="w-full"
                                    ></x-base.form-textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex justify-end gap-2 pt-6 border-t">
                            <x-base.button
                                variant="outline-secondary"
                                type="button"
                                onclick="window.location.href='{{ route('work.projects.index') }}'"
                            >
                                Cancel
                            </x-base.button>
                            <x-base.button
                                variant="primary"
                                type="submit"
                                id="create-project-btn"
                            >
                                <x-base.lucide icon="Save" class="w-4 h-4 mr-2" />
                                Create Project
                            </x-base.button>
                        </div>
                    </form>
                </div>
            </x-base.preview-component>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>

    <script>
        $(document).ready(function() {
            // Auto-generate project code
            $('#name').on('input', function() {
                const name = $(this).val();
                if (name && !$('#code').val()) {
                    const code = name.replace(/\s+/g, '-').toUpperCase().substring(0, 10);
                    $('#code').val(code);
                }
            });

            // Form submission
            $('#create-project-form').on('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const submitBtn = $('#create-project-btn');
                const originalText = submitBtn.html();

                submitBtn.prop('disabled', true).html('<svg class="w-4 h-4 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>Creating...');

                fetch('{{ route("work.projects.store") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (typeof window.showSuccess === 'function') {
                            window.showSuccess(data.message || 'Project created successfully');
                        }
                        setTimeout(() => {
                            window.location.href = '{{ route("work.projects.index") }}';
                        }, 1500);
                    } else {
                        if (data.errors) {
                            const errors = Object.values(data.errors).flat().join('\n');
                            if (typeof window.showError === 'function') {
                                window.showError(errors);
                            }
                        } else if (typeof window.showError === 'function') {
                            window.showError(data.message || 'Failed to create project');
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (typeof window.showError === 'function') {
                        window.showError('An error occurred while creating the project');
                    }
                })
                .finally(() => {
                    submitBtn.prop('disabled', false).html(originalText);
                });
            });
        });
    </script>
@endpush

{{-- Create Project Modal --}}
@php
    // Use the unified DocumentCodeGenerator to preview the next project code
    $projectCodeGenerator = app(\App\Services\DocumentCodeGenerator::class);
    $projectPreviewCode = $projectCodeGenerator->preview('projects');
@endphp

<div class="custom-modal" id="create-project-modal" tabindex="-1" aria-labelledby="createProjectModalLabel" aria-hidden="true">
    <div class="custom-modal-dialog">
        <form id="create-project-form" enctype="multipart/form-data">
            @csrf

            <!-- Modal Header -->
            <div class="custom-modal-header">
                <h5 class="custom-modal-title" id="createProjectModalLabel">Create New Project</h5>
                <button type="button" class="btn-close-custom" onclick="closeCreateModal()" aria-label="Close">&times;</button>
            </div>

            <!-- Modal Body -->
            <div class="custom-modal-body">
                    <!-- Basic Information -->
                    <div class="mb-6">
                        <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                            <x-base.lucide icon="clipboard-list" class="h-5 w-5"></x-base.lucide>
                            Basic Information
                        </h4>

                        <div class="grid grid-cols-12 gap-4 lg:gap-5">
                            <div class="col-span-12 md:col-span-6 xl:col-span-3">
                                <label class="form-label">Project Code <span class="text-danger">*</span></label>
                                <x-base.form-input
                                    id="create-code"
                                    name="code"
                                    type="text"
                                    placeholder="Project code will be generated"
                                    class="w-full"
                                    value="{{ $projectPreviewCode ?? '' }}"
                                    readonly
                                />
                            </div>

                            <div class="col-span-12 md:col-span-6 xl:col-span-3">
                                <label class="form-label">Project Name <span class="text-danger">*</span></label>
                                <x-base.form-input
                                    id="create-name"
                                    name="name"
                                    type="text"
                                    placeholder="Enter project name"
                                    class="w-full"
                                    required
                                />
                            </div>

                            <div class="col-span-12 md:col-span-6 xl:col-span-3">
                                <label class="form-label">Description</label>
                                <x-base.form-textarea
                                    id="create-description"
                                    name="description"
                                    rows="3"
                                    placeholder="Enter project description"
                                    class="w-full"
                                ></x-base.form-textarea>
                            </div>
                            <div class="hidden xl:block xl:col-span-3"></div>
                            <div class="hidden xl:block xl:col-span-3"></div>
                            <div class="hidden xl:block xl:col-span-3"></div>
                        </div>
                    </div>

                    <!-- Organization -->
                    <div class="mb-6">
                        <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                            <x-base.lucide icon="building-2" class="h-5 w-5"></x-base.lucide>
                            Organization
                        </h4>

                        <div class="grid grid-cols-12 gap-4 lg:gap-5">
                            <div class="col-span-12 md:col-span-6 xl:col-span-3">
                                <label class="form-label">Company <span class="text-danger">*</span></label>
                                <x-base.form-select id="create-company_id" name="company_id" class="w-full" required>
                                    <option value="">Select Company</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </x-base.form-select>
                            </div>
                            <div class="hidden xl:block xl:col-span-3"></div>
                            <div class="hidden xl:block xl:col-span-3"></div>

                            <div class="col-span-12 md:col-span-6 xl:col-span-3">
                                <label class="form-label">Project Manager</label>
                                <x-base.form-select id="create-manager_id" name="manager_id" class="w-full">
                                    <option value="">Select Manager</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach
                                </x-base.form-select>
                            </div>
                            <div class="hidden xl:block xl:col-span-3"></div>
                            <div class="hidden xl:block xl:col-span-3"></div>
                        </div>
                    </div>

                    <!-- Timeline -->
                    <div class="mb-6">
                        <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                            <x-base.lucide icon="calendar-range" class="h-5 w-5"></x-base.lucide>
                            Timeline
                        </h4>

                        <div class="grid grid-cols-12 gap-4 lg:gap-5">
                            <div class="col-span-12 md:col-span-6 xl:col-span-3">
                                <label class="form-label">Start Date <span class="text-danger">*</span></label>
                                <div class="relative w-full">
                                    <div
                                        class="absolute flex h-full w-10 items-center justify-center rounded-l border bg-slate-100 text-slate-500 dark:border-darkmode-800 dark:bg-darkmode-700 dark:text-slate-400">
                                        <x-base.lucide icon="calendar" class="stroke-1.5 w-5 h-5"></x-base.lucide>
                                    </div>
                                    <x-base.litepicker
                                        id="create-start_date"
                                        name="start_date"
                                        class="pl-12 w-full"
                                        data-single-mode="true"
                                        required
                                    />
                                </div>
                            </div>

                            <div class="col-span-12 md:col-span-6 xl:col-span-3">
                                <label class="form-label">End Date</label>
                                <div class="relative w-full">
                                    <div
                                        class="absolute flex h-full w-10 items-center justify-center rounded-l border bg-slate-100 text-slate-500 dark:border-darkmode-800 dark:bg-darkmode-700 dark:text-slate-400">
                                        <x-base.lucide icon="calendar" class="stroke-1.5 w-5 h-5"></x-base.lucide>
                                    </div>
                                    <x-base.litepicker
                                        id="create-end_date"
                                        name="end_date"
                                        class="pl-12 w-full"
                                        data-single-mode="true"
                                    />
                                </div>
                            </div>
                            <div class="hidden xl:block xl:col-span-3"></div>
                            <div class="hidden xl:block xl:col-span-3"></div>
                        </div>
                    </div>

                    <!-- Status & Priority -->
                    <div class="mb-6">
                        <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                            <x-base.lucide icon="activity" class="h-5 w-5"></x-base.lucide>
                            Status & Priority
                        </h4>

                        <div class="grid grid-cols-12 gap-4 lg:gap-5">
                            <div class="col-span-12 md:col-span-6 xl:col-span-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <x-base.form-select id="create-status" name="status" class="w-full" required>
                                    <option value="planning">Planning</option>
                                    <option value="active">Active</option>
                                    <option value="on_hold">On Hold</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                </x-base.form-select>
                            </div>

                            <div class="col-span-12 md:col-span-6 xl:col-span-3">
                                <label class="form-label">Priority <span class="text-danger">*</span></label>
                                <x-base.form-select id="create-priority" name="priority" class="w-full" required>
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                    <option value="critical">Critical</option>
                                </x-base.form-select>
                            </div>
                        </div>
                    </div>

                    <!-- Progress & Budget -->
                    <div class="mb-6">
                        <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                            <x-base.lucide icon="bar-chart-2" class="h-5 w-5"></x-base.lucide>
                            Progress & Budget
                        </h4>

                        <div class="grid grid-cols-12 gap-4 lg:gap-5">
                            <div class="col-span-12 md:col-span-6 xl:col-span-3">
                                <label class="form-label">Progress (%)</label>
                                <x-base.form-input
                                    id="create-progress_percentage"
                                    name="progress_percentage"
                                    type="number"
                                    min="0"
                                    max="100"
                                    value="0"
                                    class="w-full"
                                />
                            </div>

                            <div class="col-span-12 md:col-span-6 xl:col-span-3">
                                <label class="form-label">Budget</label>
                                <x-base.form-input
                                    id="create-budget"
                                    name="budget"
                                    type="number"
                                    step="0.01"
                                    placeholder="Enter budget amount"
                                    class="w-full"
                                />
                            </div>
                            <div class="hidden xl:block xl:col-span-3"></div>
                            <div class="hidden xl:block xl:col-span-3"></div>
                        </div>
                    </div>

                    <!-- Objectives & Deliverables -->
                    <div class="mb-6">
                        <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                            <x-base.lucide icon="target" class="h-5 w-5"></x-base.lucide>
                            Objectives & Deliverables
                        </h4>

                        <div class="grid grid-cols-12 gap-4 lg:gap-5">
                            <div class="col-span-12 md:col-span-6 xl:col-span-3">
                                <label class="form-label">Objectives</label>
                                <x-base.form-textarea
                                    id="create-objectives"
                                    name="objectives"
                                    rows="3"
                                    placeholder="Enter project objectives"
                                    class="w-full"
                                ></x-base.form-textarea>
                            </div>

                            <div class="col-span-12 md:col-span-6 xl:col-span-3">
                                <label class="form-label">Deliverables</label>
                                <x-base.form-textarea
                                    id="create-deliverables"
                                    name="deliverables"
                                    rows="3"
                                    placeholder="Enter project deliverables"
                                    class="w-full"
                                ></x-base.form-textarea>
                            </div>
                            <div class="hidden xl:block xl:col-span-3"></div>
                            <div class="hidden xl:block xl:col-span-3"></div>
                        </div>
                    </div>

                    <!-- Risks & Notes -->
                    <div class="mb-6">
                        <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                            <x-base.lucide icon="alert-triangle" class="h-5 w-5"></x-base.lucide>
                            Risks & Notes
                        </h4>

                        <div class="grid grid-cols-12 gap-4 lg:gap-5">
                            <div class="col-span-12 md:col-span-6 xl:col-span-3">
                                <label class="form-label">Risks</label>
                                <x-base.form-textarea
                                    id="create-risks"
                                    name="risks"
                                    rows="3"
                                    placeholder="Enter project risks"
                                    class="w-full"
                                ></x-base.form-textarea>
                            </div>

                            <div class="col-span-12 md:col-span-6 xl:col-span-3">
                                <label class="form-label">Notes</label>
                                <x-base.form-textarea
                                    id="create-notes"
                                    name="notes"
                                    rows="3"
                                    placeholder="Enter additional notes"
                                    class="w-full"
                                ></x-base.form-textarea>
                            </div>
                        </div>
                    </div>
>            </div>

            <!-- Modal Footer -->
            <div class="custom-modal-footer">
                <button type="button" class="btn-tonal btn-tonal--warning" onclick="closeCreateModal()">
                    <x-base.lucide icon="X" class="w-4 h-4 mr-2" />
                    Cancel
                </button>
                <button type="submit" class="btn-tonal btn-tonal--success" id="create-project-btn">
                    <x-base.lucide icon="save" class="w-4 h-4 mr-2" />
                    Create Project
                </button>
            </div>
        </form>
    </div>
</div>

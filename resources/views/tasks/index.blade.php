@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Tasks Management - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
@endpush

@section('subcontent')
    @include('components.global-notifications')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Tasks Management</h2>

        <div class="flex items-center gap-2">
            <button
                type="button"
                class="btn-royal btn-royal--outline btn-royal--sm hidden sm:inline-flex min-h-[44px] items-center gap-2 px-4 group"
                data-tw-toggle="modal"
                data-tw-target="#tasks-filters-slideover"
            >
                <x-base.lucide icon="filter" class="w-4 h-4 icon-hover-rise" />
                Filters
                <span
                    id="active-filters-indicator"
                    class="hidden items-center gap-1 rounded-full border border-emerald-500/30 bg-emerald-500/10 px-2 py-0.5 text-xs font-semibold text-emerald-700"
                >
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    Active
                </span>
            </button>

            <!-- Mobile filters icon -->
            <button
                type="button"
                class="btn-royal btn-royal--outline btn-royal--sm inline-flex min-h-[44px] items-center justify-center gap-2 px-3 sm:hidden"
                data-tw-toggle="modal"
                data-tw-target="#tasks-filters-slideover"
                title="Filters"
            >
                <x-base.lucide icon="filter" class="w-4 h-4 icon-hover-rise" />
            </button>

            <div class="hidden sm:flex items-center rounded-full bg-slate-100 dark:bg-darkmode-700 px-1 py-1 ml-2">
                <button
                    type="button"
                    id="tasks-view-toggle-list"
                    class="tasks-view-toggle-button inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold bg-white text-slate-700 shadow-sm transition-all"
                    data-view="list"
                >
                    <x-base.lucide icon="List" class="w-3 h-3 mr-1" />
                    List
                </button>
                <button
                    type="button"
                    id="tasks-view-toggle-kanban"
                    class="tasks-view-toggle-button inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold text-slate-500 hover:text-slate-800 transition-all"
                    data-view="kanban"
                >
                    <x-base.lucide icon="Layout" class="w-3 h-3 mr-1" />
                    Kanban
                </button>
            </div>

            <button
                type="button"
                class="btn-royal btn-royal--gold btn-royal--sm w-36 sm:w-auto sm:ml-2 group"
                data-tw-toggle="modal"
                data-tw-target="#create-task-modal"
            >
                <x-base.lucide icon="square-plus" class="w-4 h-4 icon-hover-rise" />
                Add Task
            </button>
        </div>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                        <form id="tasks-filter-form" class="w-full sm:mr-auto xl:flex">
                            <div class="items-center sm:mr-4 sm:flex">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Field
                                </label>
                                <x-base.form-select id="tasks-filter-field" class="mt-2 w-full sm:mt-0 sm:w-auto 2xl:w-full">
                                    <option value="all">All Fields</option>
                                    <option value="code">Code</option>
                                    <option value="title">Title</option>
                                    <option value="description">Description</option>
                                    <option value="priority">Priority</option>
                                    <option value="status">Status</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Type
                                </label>
                                <x-base.form-select id="tasks-filter-type" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                    <option value="contains">Contains</option>
                                    <option value="equals">Equals</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Value
                                </label>
                                <x-base.form-input id="tasks-filter-value" type="text" placeholder="Search..." class="mt-2 w-full sm:mt-0 sm:w-48 2xl:w-full" />
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Show
                                </label>
                                <x-base.form-select id="tasks-filter-length" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 xl:mt-0 flex flex-col gap-2">
                                <button
                                    id="tasks-filter-go"
                                    type="button"
                                    class="btn-royal btn-royal--dark btn-royal--sm w-full sm:w-24 group"
                                >
                                    <x-base.lucide icon="search" class="w-4 h-4 icon-hover-rise" />
                                    Go
                                </button>
                                <button
                                    id="tasks-filter-reset"
                                    type="button"
                                    class="btn-royal btn-royal--outline btn-royal--sm w-full sm:w-24 group"
                                >
                                    <x-base.lucide icon="rotate-ccw" class="w-4 h-4 icon-hover-rise" />
                                    Reset
                                </button>
                            </div>
                        </form>

                        <div class="mt-5 flex sm:mt-0">
                            <button
                                id="tasks-export"
                                type="button"
                                class="btn-royal btn-royal--outline btn-royal--sm mr-2 w-1/2 sm:w-auto group"
                            >
                                <x-base.lucide icon="download" class="h-4 w-4 icon-hover-rise" />
                                Export
                            </button>
                            <button
                                id="tasks-refresh"
                                type="button"
                                class="btn-royal btn-royal--outline btn-royal--sm w-1/2 sm:w-auto group"
                            >
                                <x-base.lucide icon="refresh-ccw" class="h-4 w-4 icon-hover-rise" />
                                Refresh
                            </button>
                        </div>
                    </div>

                    <div id="tasks-list-view" class="overflow-x-auto sm:overflow-visible" data-erp-table-wrapper>
                        <table id="tasks-table" data-tw-merge data-erp-table class="datatable-default w-full min-w-full table-auto text-left text-sm">
                            <thead>
                                <tr>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">#</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Code</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Title</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Priority</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Status</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Assigned To</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Due Date</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                    <div id="tasks-kanban-view" class="hidden mt-6">
                        <div class="mb-4 flex items-center justify-between">
                            <div class="text-sm text-slate-500 dark:text-slate-400">
                                Drag & drop tasks between columns to update their status.
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4" id="tasks-kanban-columns">
                            <div class="tasks-kanban-column flex flex-col rounded-xl bg-slate-50/80 p-3 dark:bg-darkmode-600/90 border border-slate-100 dark:border-darkmode-500" data-status="pending">
                                <div class="mb-3 flex items-center justify-between">
                                    <div class="inline-flex items-center gap-2 rounded-full bg-yellow-100/80 px-3 py-1 text-xs font-semibold text-yellow-700">
                                        <span class="h-2 w-2 rounded-full bg-yellow-500 animate-pulse"></span>
                                        Pending
                                    </div>
                                    <span class="tasks-kanban-count text-xs text-slate-500" data-status-count="pending">0</span>
                                </div>
                                <div class="tasks-kanban-dropzone flex-1 space-y-3" data-status="pending"></div>
                            </div>

                            <div class="tasks-kanban-column flex flex-col rounded-xl bg-slate-50/80 p-3 dark:bg-darkmode-600/90 border border-slate-100 dark:border-darkmode-500" data-status="in_progress">
                                <div class="mb-3 flex items-center justify-between">
                                    <div class="inline-flex items-center gap-2 rounded-full bg-blue-100/80 px-3 py-1 text-xs font-semibold text-blue-700">
                                        <span class="h-2 w-2 rounded-full bg-blue-500 animate-pulse"></span>
                                        In Progress
                                    </div>
                                    <span class="tasks-kanban-count text-xs text-slate-500" data-status-count="in_progress">0</span>
                                </div>
                                <div class="tasks-kanban-dropzone flex-1 space-y-3" data-status="in_progress"></div>
                            </div>

                            <div class="tasks-kanban-column flex flex-col rounded-xl bg-slate-50/80 p-3 dark:bg-darkmode-600/90 border border-slate-100 dark:border-darkmode-500" data-status="completed">
                                <div class="mb-3 flex items-center justify-between">
                                    <div class="inline-flex items-center gap-2 rounded-full bg-green-100/80 px-3 py-1 text-xs font-semibold text-green-700">
                                        <span class="h-2 w-2 rounded-full bg-green-500 animate-pulse"></span>
                                        Completed
                                    </div>
                                    <span class="tasks-kanban-count text-xs text-slate-500" data-status-count="completed">0</span>
                                </div>
                                <div class="tasks-kanban-dropzone flex-1 space-y-3" data-status="completed"></div>
                            </div>

                            <div class="tasks-kanban-column flex flex-col rounded-xl bg-slate-50/80 p-3 dark:bg-darkmode-600/90 border border-slate-100 dark:border-darkmode-500" data-status="cancelled">
                                <div class="mb-3 flex items-center justify-between">
                                    <div class="inline-flex items-center gap-2 rounded-full bg-rose-100/80 px-3 py-1 text-xs font-semibold text-rose-700">
                                        <span class="h-2 w-2 rounded-full bg-rose-500 animate-pulse"></span>
                                        Cancelled
                                    </div>
                                    <span class="tasks-kanban-count text-xs text-slate-500" data-status-count="cancelled">0</span>
                                </div>
                                <div class="tasks-kanban-dropzone flex-1 space-y-3" data-status="cancelled"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </x-base.preview-component>
        </div>
    </div>

    <!-- Tasks Filters Slide Over -->
    <x-base.slideover id="tasks-filters-slideover" size="md">
        <x-base.slideover.panel>
            <a
                class="absolute top-0 left-0 right-auto mt-4 -ml-10 sm:-ml-12"
                data-tw-dismiss="modal"
                href="#"
            >
                <x-base.lucide class="h-8 w-8 text-slate-400" icon="X" />
            </a>
            <x-base.slideover.title class="border-b border-slate-200/60 p-5 dark:border-darkmode-400">
                <h2 class="mr-auto text-base font-medium flex items-center gap-2">
                    <x-base.lucide icon="Filter" class="h-5 w-5" />
                    Tasks Filters
                </h2>
            </x-base.slideover.title>

            <x-base.slideover.description class="p-5">
                <div class="mb-4 text-sm text-slate-600 dark:text-slate-400">
                    Use these filters to narrow down the tasks list. Click "Apply Filters" to update the table.
                </div>

                <div class="grid grid-cols-12 gap-4">
                    <!-- Company Filter -->
                    <div class="col-span-12">
                        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                            Filter by Company
                        </label>
                        <x-base.form-select id="company-filter" class="w-full">
                            <option value="">All Companies</option>
                            @foreach($companies ?? [] as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </x-base.form-select>
                    </div>

                    <!-- Department Filter -->
                    <div class="col-span-12">
                        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                            Filter by Department
                        </label>
                        <x-base.form-select id="department-filter" class="w-full">
                            <option value="">All Departments</option>
                            @foreach($departments ?? [] as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </x-base.form-select>
                    </div>

                    <!-- Employee Filter -->
                    <div class="col-span-12">
                        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                            Filter by Employee
                        </label>
                        <x-base.form-select id="employee-filter" class="w-full">
                            <option value="">All Employees</option>
                            @foreach($employees ?? [] as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->full_name }}</option>
                            @endforeach
                        </x-base.form-select>
                    </div>

                    <!-- Status Filter -->
                    <div class="col-span-12">
                        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                            Filter by Status
                        </label>
                        <x-base.form-select id="status-filter" class="w-full">
                            <option value="">All Statuses</option>
                            <option value="pending">Pending</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </x-base.form-select>
                    </div>
                </div>

                <!-- Filter Results Summary & Actions -->
                <div class="mt-5 rounded-lg bg-slate-50 p-4 dark:bg-darkmode-600">
                    <div class="flex flex-col gap-3">
                        <div class="flex flex-wrap items-center gap-4">
                            <div class="text-sm text-slate-600 dark:text-slate-400">
                                <span class="font-medium">Total Tasks:</span>
                                <span id="total-tasks-count" class="font-semibold text-slate-800 dark:text-white">0</span>
                            </div>
                            <div class="text-sm text-slate-600 dark:text-slate-400">
                                <span class="font-medium">Filtered:</span>
                                <span id="filtered-tasks-count" class="font-semibold text-blue-600">0</span>
                            </div>
                        </div>

                        <div class="mt-2 flex justify-end gap-2">
                            <button
                                type="button"
                                class="btn-royal btn-royal--outline btn-royal--sm w-28 group"
                                data-tw-dismiss="modal"
                            >
                                <x-base.lucide icon="x" class="mr-2 h-4 w-4 icon-hover-rise" />
                                Close
                            </button>
                            <button
                                id="advanced-filter-apply"
                                type="button"
                                class="btn-royal btn-royal--dark btn-royal--sm w-32 group"
                            >
                                <x-base.lucide icon="search" class="mr-2 h-4 w-4 icon-hover-rise" />
                                Apply Filters
                            </button>
                        </div>
                    </div>
                </div>
            </x-base.slideover.description>
        </x-base.slideover.panel>
    </x-base.slideover>

    @include('tasks.modals.create')
    @include('tasks.modals.edit')
    @stack('modals')

    <!-- Hidden button to trigger edit modal -->
    <button id="edit-task-trigger" data-tw-toggle="modal" data-tw-target="#edit-task-modal" class="hidden"></button>
@endsection

@include('components.datatable.scripts')

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>
    
    <style>
        /* DataTable Links Styling */
        .dataTables_wrapper a {
            text-decoration: none;
        }
        
        .dataTables_wrapper a:hover {
            text-decoration: none;
        }
        
        /* Kanban Card Link Styling */
        .tasks-kanban-card {
            color: inherit;
            text-decoration: none;
        }
        
        .tasks-kanban-card:hover {
            text-decoration: none;
            color: inherit;
        }
        
        .tasks-kanban-card:focus {
            outline: 2px solid rgb(var(--color-primary-rgb));
            outline-offset: 2px;
        }
    </style>
    
    <script>
    // Define showToast function if not available
    if (typeof showToast === 'undefined') {
        // showToast is already defined globally, no need for fallback
    }

    try {
        document.addEventListener('DOMContentLoaded', function () {
            const filterField = document.getElementById('tasks-filter-field');
            const filterType = document.getElementById('tasks-filter-type');
            const filterValue = document.getElementById('tasks-filter-value');
            const lengthSelect = document.getElementById('tasks-filter-length');
            const filterGoBtn = document.getElementById('tasks-filter-go');
            const filterResetBtn = document.getElementById('tasks-filter-reset');
            const exportBtn = document.getElementById('tasks-export');
            const refreshBtn = document.getElementById('tasks-refresh');

            // Advanced filters
            const companyFilter = document.getElementById('company-filter');
            const departmentFilter = document.getElementById('department-filter');
            const employeeFilter = document.getElementById('employee-filter');
            const statusFilter = document.getElementById('status-filter');
            const advancedFilterApplyBtn = document.getElementById('advanced-filter-apply');
            const totalTasksCount = document.getElementById('total-tasks-count');
            const filteredTasksCount = document.getElementById('filtered-tasks-count');

            const initialLength = lengthSelect ? parseInt(lengthSelect.value, 10) || 10 : 10;

            const table = window.erpCrud.initDataTable({
                tableSelector: '#tasks-table',
                ajaxUrl: '{{ route("tasks.datatable") }}',
                ajaxData: function (d) {
                    if (filterField) {
                        d.filter_field = filterField.value || 'all';
                    }
                    if (filterType) {
                        d.filter_type = filterType.value || 'contains';
                    }
                    if (filterValue) {
                        d.filter_value = filterValue.value || '';
                    }
                    if (companyFilter) {
                        d.company_id = companyFilter.value || '';
                    }
                    if (departmentFilter) {
                        d.department_id = departmentFilter.value || '';
                    }
                    if (employeeFilter) {
                        d.employee_id = employeeFilter.value || '';
                    }
                    if (statusFilter) {
                        d.status_filter = statusFilter.value || '';
                    }
                    d.page_length = lengthSelect ? parseInt(lengthSelect.value, 10) || initialLength : initialLength;
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center font-medium', orderable: false },
                    { 
                        data: 'code', 
                        name: 'code', 
                        className: 'px-5 py-3 border-b dark:border-darkmode-300 font-medium text-slate-700 whitespace-nowrap',
                        render: function (data, type, row) {
                            return `<a href="/tasks/${row.id}" class="text-primary hover:text-primary/80 font-medium transition-colors inline-flex items-center gap-1 group">
                                ${data}
                                <svg class="w-3 h-3 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                            </a>`;
                        }
                    },
                    { 
                        data: 'title', 
                        name: 'title', 
                        className: 'px-5 py-3 border-b dark:border-darkmode-300 font-medium text-slate-700 datatable-cell-wrap',
                        render: function (data, type, row) {
                            return `<a href="/tasks/${row.id}" class="text-primary hover:text-primary/80 font-medium transition-colors hover:underline inline-flex items-center gap-2 group">
                                <span>${data}</span>
                                <svg class="w-3 h-3 opacity-0 group-hover:opacity-100 transition-opacity flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                            </a>`;
                        }
                    },
                    {
                        data: 'priority',
                        name: 'priority',
                        render: function (value) {
                            let badgeClass = 'bg-gray-100 text-gray-700';
                            if (value === 'high') {
                                badgeClass = 'bg-red-100 text-red-700';
                            } else if (value === 'medium') {
                                badgeClass = 'bg-yellow-100 text-yellow-700';
                            } else if (value === 'low') {
                                badgeClass = 'bg-green-100 text-green-700';
                            }
                            return `<span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ${badgeClass}">${value}</span>`;
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function (value) {
                            let badgeClass = 'bg-gray-100 text-gray-700';
                            if (value === 'completed') {
                                badgeClass = 'bg-green-100 text-green-700';
                            } else if (value === 'in_progress') {
                                badgeClass = 'bg-blue-100 text-blue-700';
                            } else if (value === 'pending') {
                                badgeClass = 'bg-yellow-100 text-yellow-700';
                            } else if (value === 'cancelled') {
                                badgeClass = 'bg-red-100 text-red-700';
                            }
                            const label = value.replace('_', ' ');
                            return `<span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ${badgeClass}">${label}</span>`;
                        }
                    },
                    { data: 'employee_name', name: 'employee_name', className: 'px-5 py-3 border-b dark:border-darkmode-300 datatable-cell-wrap' },
                    { data: 'due_date_formatted', name: 'due_date_formatted', className: 'px-5 py-3 border-b dark:border-darkmode-300 whitespace-nowrap' },
                    {
                        data: 'actions',
                        name: 'actions',
                        className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center',
                        orderable: false,
                        searchable: false
                    }
                ],
                pageLength: initialLength
            });

            if (!table) return;

            table.on('draw', function () {
                if (typeof window.Lucide !== 'undefined') {
                    window.Lucide.createIcons();
                }

                // Update task counts
                const info = table.page.info();
                if (totalTasksCount) {
                    totalTasksCount.textContent = info.recordsTotal;
                }
                if (filteredTasksCount) {
                    filteredTasksCount.textContent = info.recordsDisplay;
                }

                // Show filter summary if filters are active
                const basicFiltersActive =
                    (filterField && filterField.value && filterField.value !== 'all') ||
                    (filterType && filterType.value && filterType.value !== 'contains') ||
                    (filterValue && filterValue.value && filterValue.value.trim() !== '');

                const advancedFiltersActive =
                    (companyFilter && companyFilter.value) ||
                    (departmentFilter && departmentFilter.value) ||
                    (employeeFilter && employeeFilter.value) ||
                    (statusFilter && statusFilter.value);

                const hasFilters = basicFiltersActive || advancedFiltersActive;

                // Show filter summary if filters are active (only once, not on every draw)
                if (hasFilters && info && info.recordsTotal !== info.recordsDisplay) {
                    // Only show toast if we haven't shown it for this filter combination
                    if (typeof window.lastFilterToast === 'undefined' || window.lastFilterToast !== `${info.recordsDisplay}-${info.recordsTotal}`) {
                        if (typeof showToast === 'function') {
                            showToast(`Filtered ${info.recordsDisplay} out of ${info.recordsTotal} tasks`, 'success');
                        } else {
                            console.log(`✅ Filtered ${info.recordsDisplay} out of ${info.recordsTotal} tasks`);
                        }
                        window.lastFilterToast = `${info.recordsDisplay}-${info.recordsTotal}`;
                    }
                }

                // Update active filters indicator
                const activeFiltersIndicator = document.getElementById('active-filters-indicator');
                if (activeFiltersIndicator) {
                    if (hasFilters) {
                        activeFiltersIndicator.classList.remove('hidden');
                    } else {
                        activeFiltersIndicator.classList.add('hidden');
                    }
                }
            });

            if (!table) {
                return;
            }

            if (lengthSelect) {
                lengthSelect.addEventListener('change', function () {
                    const newLength = parseInt(this.value, 10) || initialLength;
                    table.page.len(newLength).draw();
                });
            }

            const reloadTable = function () {
                table.ajax.reload(null, false);
            };

            if (filterGoBtn) {
                filterGoBtn.addEventListener('click', reloadTable);
            }

            if (filterValue) {
                filterValue.addEventListener('keyup', function (event) {
                    if (event.key === 'Enter') {
                        reloadTable();
                    }
                });
            }

            if (filterResetBtn) {
                filterResetBtn.addEventListener('click', function () {
                    if (filterField) {
                        filterField.value = 'all';
                    }
                    if (filterType) {
                        filterType.value = 'contains';
                    }
                    if (filterValue) {
                        filterValue.value = '';
                    }
                    if (lengthSelect) {
                        lengthSelect.value = String(initialLength);
                        table.page.len(initialLength).draw();
                    }
                    // Reset advanced filters
                    if (companyFilter) {
                        companyFilter.value = '';
                    }
                    if (departmentFilter) {
                        departmentFilter.value = '';
                    }
                    if (employeeFilter) {
                        employeeFilter.value = '';
                    }
                    if (statusFilter) {
                        statusFilter.value = '';
                    }
                    reloadTable();
                });
            }

            if (refreshBtn) {
                refreshBtn.addEventListener('click', reloadTable);
            }

            // Advanced filters event listeners
            if (advancedFilterApplyBtn) {
                advancedFilterApplyBtn.addEventListener('click', reloadTable);
            }

            // Auto-apply filters when changed
            if (companyFilter) {
                companyFilter.addEventListener('change', function() {
                    // Reset department filter when company changes
                    if (departmentFilter) {
                        departmentFilter.value = '';
                    }
                    setTimeout(reloadTable, 300);
                });
            }

            if (departmentFilter) {
                departmentFilter.addEventListener('change', function() {
                    setTimeout(reloadTable, 300);
                });
            }

            if (employeeFilter) {
                employeeFilter.addEventListener('change', function() {
                    setTimeout(reloadTable, 300);
                });
            }

            if (statusFilter) {
                statusFilter.addEventListener('change', function() {
                    setTimeout(function () {
                        reloadTable();
                        fetchKanbanData();
                    }, 300);
                });
            }

            const listView = document.getElementById('tasks-list-view');
            const kanbanView = document.getElementById('tasks-kanban-view');
            const toggleListBtn = document.getElementById('tasks-view-toggle-list');
            const toggleKanbanBtn = document.getElementById('tasks-view-toggle-kanban');
            const kanbanColumnsWrapper = document.getElementById('tasks-kanban-columns');

            const kanbanDropzones = kanbanColumnsWrapper
                ? kanbanColumnsWrapper.querySelectorAll('.tasks-kanban-dropzone')
                : [];

            let kanbanInitialized = false;

            function setTasksView(view) {
                if (!listView || !kanbanView || !toggleListBtn || !toggleKanbanBtn) {
                    return;
                }

                if (view === 'kanban') {
                    listView.classList.add('hidden');
                    kanbanView.classList.remove('hidden');

                    toggleListBtn.classList.remove('bg-white', 'text-slate-700', 'shadow-sm');
                    toggleListBtn.classList.add('text-slate-500');
                    toggleKanbanBtn.classList.add('bg-white', 'text-slate-700', 'shadow-sm');
                    toggleKanbanBtn.classList.remove('text-slate-500');

                    if (!kanbanInitialized) {
                        fetchKanbanData();
                        kanbanInitialized = true;
                    } else {
                        fetchKanbanData();
                    }
                } else {
                    listView.classList.remove('hidden');
                    kanbanView.classList.add('hidden');

                    toggleKanbanBtn.classList.remove('bg-white', 'text-slate-700', 'shadow-sm');
                    toggleKanbanBtn.classList.add('text-slate-500');
                    toggleListBtn.classList.add('bg-white', 'text-slate-700', 'shadow-sm');
                    toggleListBtn.classList.remove('text-slate-500');
                }
            }

            if (toggleListBtn) {
                toggleListBtn.addEventListener('click', function () {
                    setTasksView('list');
                });
            }

            if (toggleKanbanBtn) {
                toggleKanbanBtn.addEventListener('click', function () {
                    setTasksView('kanban');
                });
            }

            function buildKanbanCard(task) {
                const card = document.createElement('a');
                card.href = `/tasks/${task.id}`;
                card.className = 'tasks-kanban-card group rounded-xl border border-slate-200/80 bg-white/90 px-3 py-3 text-xs shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-primary/60 hover:shadow-md dark:border-darkmode-500 dark:bg-darkmode-600/95 block no-underline';
                card.setAttribute('draggable', 'true');
                card.dataset.taskId = task.id;
                card.dataset.status = task.status;

                // Priority class mapping
                let priorityClass = 'bg-slate-100 text-slate-700';
                if (task.priority === 'high') {
                    priorityClass = 'bg-red-100 text-red-700';
                } else if (task.priority === 'medium') {
                    priorityClass = 'bg-yellow-100 text-yellow-700';
                } else if (task.priority === 'low') {
                    priorityClass = 'bg-green-100 text-green-700';
                }

                // Status class mapping
                let statusClass = 'bg-slate-100 text-slate-700';
                if (task.status === 'completed') {
                    statusClass = 'bg-green-100 text-green-700';
                } else if (task.status === 'in_progress') {
                    statusClass = 'bg-blue-100 text-blue-700';
                } else if (task.status === 'pending') {
                    statusClass = 'bg-yellow-100 text-yellow-700';
                } else if (task.status === 'cancelled') {
                    statusClass = 'bg-rose-100 text-rose-700';
                }

                const statusLabel = (task.status || '').replace('_', ' ');

                let colorDot = '';
                if (task.color) {
                    colorDot = `<span class="mr-1 inline-block h-2.5 w-2.5 rounded-full border border-white shadow-sm" style="background-color: ${task.color}"></span>`;
                }

                const employee = task.employee_name || '-';
                const dueDate = task.due_date_formatted || '-';

                card.innerHTML = `
                    <div class="mb-2 flex items-start justify-between gap-2">
                        <div class="flex flex-col gap-1">
                            <div class="flex items-center gap-1.5">
                                ${colorDot}
                                <span class="max-w-[160px] truncate font-semibold text-slate-800 dark:text-slate-50 group-hover:text-primary transition-colors">${task.title || 'Untitled Task'}</span>
                                <svg class="w-3 h-3 opacity-0 group-hover:opacity-100 transition-opacity text-primary flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                            </div>
                            <div class="text-[10px] font-medium uppercase tracking-wide text-slate-400">${task.code || ''}</div>
                        </div>
                        <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-semibold ${priorityClass}">
                            ${task.priority || '-'}
                        </span>
                    </div>
                    <div class="mb-2 line-clamp-2 text-[11px] text-slate-500 dark:text-slate-300">
                        ${task.description || ''}
                    </div>
                    <div class="flex items-center justify-between text-[11px] text-slate-500 dark:text-slate-300">
                        <div class="flex items-center gap-1.5">
                            <x-base.lucide icon="User" class="h-3 w-3"></x-base.lucide>
                            <span class="max-w-[120px] truncate">${employee}</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <x-base.lucide icon="Calendar" class="h-3 w-3"></x-base.lucide>
                            <span>${dueDate}</span>
                        </div>
                    </div>
                    <div class="mt-2 flex items-center justify-between text-[10px]">
                        <span class="inline-flex items-center rounded-full px-2 py-0.5 font-medium ${statusClass}">
                            ${statusLabel}
                        </span>
                    </div>
                `;

                return card;
            }

            function clearKanbanColumns() {
                if (!kanbanColumnsWrapper) {
                    return;
                }

                kanbanColumnsWrapper.querySelectorAll('.tasks-kanban-dropzone').forEach(function (zone) {
                    zone.innerHTML = '';
                });

                kanbanColumnsWrapper.querySelectorAll('.tasks-kanban-count').forEach(function (el) {
                    el.textContent = '0';
                });
            }

            function setupKanbanDragAndDrop() {
                if (!kanbanColumnsWrapper) {
                    return;
                }

                const cards = kanbanColumnsWrapper.querySelectorAll('.tasks-kanban-card');

                cards.forEach(function (card) {
                    card.addEventListener('dragstart', function (event) {
                        card.classList.add('ring-2', 'ring-primary/70', 'shadow-lg', 'scale-[1.02]');
                        event.dataTransfer.effectAllowed = 'move';
                        event.dataTransfer.setData('text/plain', card.dataset.taskId || '');
                        event.dataTransfer.setData('text/status', card.dataset.status || '');
                    });

                    card.addEventListener('dragend', function () {
                        card.classList.remove('ring-2', 'ring-primary/70', 'shadow-lg', 'scale-[1.02]');
                    });
                });

                kanbanDropzones.forEach(function (zone) {
                    zone.addEventListener('dragover', function (event) {
                        event.preventDefault();
                        event.dataTransfer.dropEffect = 'move';
                        zone.classList.add('bg-slate-100/70', 'dark:bg-darkmode-500/70');
                    });

                    zone.addEventListener('dragleave', function () {
                        zone.classList.remove('bg-slate-100/70', 'dark:bg-darkmode-500/70');
                    });

                    zone.addEventListener('drop', function (event) {
                        event.preventDefault();
                        zone.classList.remove('bg-slate-100/70', 'dark:bg-darkmode-500/70');

                        const taskId = event.dataTransfer.getData('text/plain');
                        const previousStatus = event.dataTransfer.getData('text/status');
                        const newStatus = zone.dataset.status;

                        if (!taskId || !newStatus || previousStatus === newStatus) {
                            return;
                        }

                        const card = kanbanColumnsWrapper.querySelector('.tasks-kanban-card[data-task-id="' + taskId + '"]');
                        if (!card) {
                            return;
                        }

                        const previousZone = kanbanColumnsWrapper.querySelector('.tasks-kanban-dropzone[data-status="' + previousStatus + '"]');

                        zone.appendChild(card);
                        card.dataset.status = newStatus;

                        updateKanbanCounters();
                        animateCardDrop(card);

                        updateTaskStatus(taskId, newStatus, function (success) {
                            if (!success && previousZone) {
                                previousZone.appendChild(card);
                                card.dataset.status = previousStatus;
                                updateKanbanCounters();
                            }
                        });
                    });
                });
            }

            function animateCardDrop(card) {
                card.classList.add('animate-[pulse_0.35s_ease-out_1]');
                setTimeout(function () {
                    card.classList.remove('animate-[pulse_0.35s_ease-out_1]');
                }, 400);
            }

            function updateKanbanCounters() {
                if (!kanbanColumnsWrapper) {
                    return;
                }

                const counts = {
                    pending: 0,
                    in_progress: 0,
                    completed: 0,
                    cancelled: 0,
                };

                kanbanColumnsWrapper.querySelectorAll('.tasks-kanban-card').forEach(function (card) {
                    const status = card.dataset.status || 'pending';
                    if (typeof counts[status] === 'number') {
                        counts[status] += 1;
                    }
                });

                kanbanColumnsWrapper.querySelectorAll('.tasks-kanban-count').forEach(function (el) {
                    const status = el.getAttribute('data-status-count');
                    if (status && typeof counts[status] === 'number') {
                        el.textContent = String(counts[status]);
                    }
                });
            }

            function buildKanbanQueryString() {
                const params = new URLSearchParams();

                if (companyFilter && companyFilter.value) {
                    params.append('company_id', companyFilter.value);
                }
                if (departmentFilter && departmentFilter.value) {
                    params.append('department_id', departmentFilter.value);
                }
                if (employeeFilter && employeeFilter.value) {
                    params.append('employee_id', employeeFilter.value);
                }
                if (statusFilter && statusFilter.value) {
                    params.append('status_filter', statusFilter.value);
                }

                return params.toString();
            }

            function fetchKanbanData() {
                if (!kanbanView) {
                    return;
                }

                const baseUrl = '{{ route("tasks.kanban-data") }}';
                const queryString = buildKanbanQueryString();
                const url = queryString ? baseUrl + '?' + queryString : baseUrl;

                clearKanbanColumns();

                fetch(url, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                    },
                })
                    .then(function (response) {
                        if (!response.ok) {
                            throw new Error('Failed to load kanban data');
                        }
                        return response.json();
                    })
                    .then(function (data) {
                        if (!data || !data.success || !data.data) {
                            return;
                        }

                        const grouped = data.data || {};

                        Object.keys(grouped).forEach(function (statusKey) {
                            const zone = kanbanColumnsWrapper
                                ? kanbanColumnsWrapper.querySelector('.tasks-kanban-dropzone[data-status="' + statusKey + '"]')
                                : null;

                            if (!zone) {
                                return;
                            }

                            const tasks = grouped[statusKey] || [];

                            tasks.forEach(function (task) {
                                const card = buildKanbanCard(task);
                                zone.appendChild(card);
                            });
                        });

                        updateKanbanCounters();
                        setupKanbanDragAndDrop();
                    })
                    .catch(function (error) {
                        console.error('Kanban data error:', error);
                        showToast('Failed to load kanban view.', 'error');
                    });
            }

            function updateTaskStatus(taskId, newStatus, callback) {
                const url = '/tasks/' + taskId + '/update-status';

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ status: newStatus }),
                })
                    .then(async function (response) {
                        if (response.ok) {
                            return response.json();
                        }

                        if (response.status === 422) {
                            const data = await response.json();
                            const errors = data.errors || {};
                            const firstError = Object.values(errors)[0];
                            if (firstError) {
                                showToast(Array.isArray(firstError) ? firstError[0] : firstError, 'error');
                            } else {
                                showToast(data.message || 'Validation error', 'error');
                            }
                            throw new Error('validation');
                        }

                        throw new Error('request');
                    })
                    .then(function (data) {
                        if (data && data.success) {
                            showToast(data.message || 'Task status updated successfully', 'success');
                            if (typeof callback === 'function') {
                                callback(true);
                            }
                        } else {
                            showToast((data && data.message) || 'Failed to update task status', 'error');
                            if (typeof callback === 'function') {
                                callback(false);
                            }
                        }
                    })
                    .catch(function (error) {
                        if (error.message === 'validation') {
                            if (typeof callback === 'function') {
                                callback(false);
                            }
                            return;
                        }
                        console.error('Task status update error:', error);
                        showToast('An error occurred while updating task status', 'error');
                        if (typeof callback === 'function') {
                            callback(false);
                        }
                    });
            }

            // Edit form handler
            const editForm = document.getElementById('edit-task-form');
            const editModal = document.getElementById('edit-task-modal');

            if (editForm) {
                editForm.addEventListener('submit', function (event) {
                    event.preventDefault();

                    const formData = new FormData(editForm);
                    const taskId = document.getElementById('edit-task-id').value;

                    fetch(`/tasks/${taskId}`, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-HTTP-Method-Override': 'PUT',
                        },
                        body: formData,
                    })
                        .then(async (response) => {
                            if (response.ok) {
                                return response.json();
                            }

                            if (response.status === 422) {
                                const data = await response.json();
                                const errors = data.errors || {};
                                const firstError = Object.values(errors)[0];
                                if (firstError) {
                                    showToast(Array.isArray(firstError) ? firstError[0] : firstError, 'error');
                                } else {
                                    showToast(data.message || 'Validation error', 'error');
                                }
                                throw new Error('validation');
                            }

                            throw new Error('request');
                        })
                        .then((data) => {
                            if (data.success) {
                                showToast(data.message || 'Task updated successfully', 'success');
                                editModal.__tippy?.hide?.();
                                reloadTable();
                            } else {
                                showToast(data.message || 'Failed to update task', 'error');
                            }
                        })
                        .catch((error) => {
                            if (error.message === 'validation') {
                                return;
                            }
                            console.error('Task update error:', error);
                            showToast('An error occurred while updating the task', 'error');
                        });
                });
            }

            // Export CSV handler
            if (exportBtn) {
                exportBtn.addEventListener('click', function () {
                    try {
                        const data = table.ajax.json();
                        const rows = (data && data.data) ? data.data : [];

                        const headers = ['#', 'Code', 'Title', 'Priority', 'Status', 'Assigned To', 'Due Date'];
                        const csvRows = [headers.join(',')];

                        rows.forEach(function (row) {
                            const csvRow = [
                                row.DT_RowIndex,
                                '"' + (row.code || '').replace(/"/g, '""') + '"',
                                '"' + (row.title || '').replace(/"/g, '""') + '"',
                                '"' + (row.priority || '').replace(/"/g, '""') + '"',
                                '"' + (row.status || '').replace(/"/g, '""') + '"',
                                '"' + (row.employee_name || '').replace(/"/g, '""') + '"',
                                '"' + (row.due_date_formatted || '').replace(/"/g, '""') + '"',
                            ];
                            csvRows.push(csvRow.join(','));
                        });

                        const blob = new Blob([csvRows.join('\n')], { type: 'text/csv;charset=utf-8;' });
                        const url = URL.createObjectURL(blob);
                        const link = document.createElement('a');
                        link.href = url;
                        link.download = 'tasks.csv';
                        link.click();
                        URL.revokeObjectURL(url);
                        showToast('Export completed successfully.', 'success');
                    } catch (error) {
                        console.error('Export error:', error);
                        showToast('Failed to export data.', 'error');
                    }
                });
            }

            document.addEventListener('hidden.tw.modal', function () {
                if (document.activeElement && typeof document.activeElement.blur === 'function') {
                    document.activeElement.blur();
                }
                table.ajax.reload(null, false);
            });

            window.openEditModal = function(id, title, description, priority, status, dueDate, employeeId, departmentId, companyId, isActive) {
                console.log('Opening edit modal for task:', id);

                // Populate form fields
                document.getElementById('edit-task-id').value = id || '';
                document.getElementById('edit-title').value = title || '';
                document.getElementById('edit-description').value = description || '';
                document.getElementById('edit-priority').value = priority || 'medium';
                document.getElementById('edit-status').value = status || 'pending';
                document.getElementById('edit-due-date').value = dueDate || '';
                document.getElementById('edit-employee-id').value = employeeId || '';
                document.getElementById('edit-department-id').value = departmentId || '';
                document.getElementById('edit-company-id').value = companyId || '';
                document.getElementById('edit-is-active').checked = isActive === 'true' || isActive === true;

                // Trigger modal
                document.getElementById('edit-task-trigger').click();
            };
        });
    } catch (error) {
        console.error('Tasks page script error:', error);
        console.error('Error details:', error.message, 'at line:', error.lineNumber);
    }

    // Fix missing Lucide icons
    document.addEventListener('DOMContentLoaded', function() {
        // Icons are now fixed, no replacements needed

        // Re-initialize Lucide icons after replacement
        if (typeof window.Lucide !== 'undefined') {
            window.Lucide.createIcons();
        }
    });
    </script>
@endpush

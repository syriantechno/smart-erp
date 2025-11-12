@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Project Management - {{ config('app.name') }}</title>
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
        <h2 class="mr-auto text-lg font-medium">Project Management</h2>
        <x-base.button
            variant="primary"
            class="w-40 sm:w-auto sm:ml-4"
            data-tw-toggle="modal"
            data-tw-target="#add-project-modal"
        >
            <x-base.lucide icon="FolderPlus" class="w-4 h-4 mr-2" />
            Add Project
        </x-base.button>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <!-- Advanced Filters Section -->
            <x-base.preview-component class="intro-y box mb-6">
                <div class="p-5">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                        <x-base.lucide icon="Filter" class="h-5 w-5"></x-base.lucide>
                        Project Filters
                        <span id="active-filters-indicator" class="hidden ml-2 px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded-full">Active</span>
                    </h3>

                    <div class="grid grid-cols-12 gap-4">
                        <!-- Company Filter -->
                        <div class="col-span-12 md:col-span-3">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
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
                        <div class="col-span-12 md:col-span-3">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Filter by Department
                            </label>
                            <x-base.form-select id="department-filter" class="w-full">
                                <option value="">All Departments</option>
                            </x-base.form-select>
                        </div>

                        <!-- Status Filter -->
                        <div class="col-span-12 md:col-span-3">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Filter by Status
                            </label>
                            <x-base.form-select id="status-filter" class="w-full">
                                <option value="">All Status</option>
                                <option value="planning">Planning</option>
                                <option value="active">Active</option>
                                <option value="on_hold">On Hold</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </x-base.form-select>
                        </div>

                        <!-- Priority Filter -->
                        <div class="col-span-12 md:col-span-3">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Filter by Priority
                            </label>
                            <x-base.form-select id="priority-filter" class="w-full">
                                <option value="">All Priorities</option>
                                <option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                                <option value="critical">Critical</option>
                            </x-base.form-select>
                        </div>
                    </div>

                    <!-- Filter Results Summary -->
                    <div class="mt-4 p-4 bg-slate-50 dark:bg-darkmode-600 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-6">
                                <div class="text-sm text-slate-600 dark:text-slate-400">
                                    <span class="font-medium">Total Projects:</span>
                                    <span id="total-projects-count" class="font-semibold text-slate-800 dark:text-white">0</span>
                                </div>
                                <div class="text-sm text-slate-600 dark:text-slate-400">
                                    <span class="font-medium">Active:</span>
                                    <span id="active-count" class="font-semibold text-green-600">0</span>
                                </div>
                                <div class="text-sm text-slate-600 dark:text-slate-400">
                                    <span class="font-medium">Completed:</span>
                                    <span id="completed-count" class="font-semibold text-blue-600">0</span>
                                </div>
                                <div class="text-sm text-slate-600 dark:text-slate-400">
                                    <span class="font-medium">Overdue:</span>
                                    <span id="overdue-count" class="font-semibold text-red-600">0</span>
                                </div>
                            </div>
                            <x-base.button id="advanced-filter-apply" variant="primary" size="sm">
                                <x-base.lucide icon="Search" class="w-4 h-4 mr-1" />
                                Apply Filters
                            </x-base.button>
                        </div>
                    </div>
                </div>
            </x-base.preview-component>
        </div>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                        <form id="project-filter-form" class="w-full sm:mr-auto xl:flex">
                            <div class="items-center sm:mr-4 sm:flex">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Field
                                </label>
                                <x-base.form-select id="project-filter-field" class="mt-2 w-full sm:mt-0 sm:w-auto 2xl:w-full">
                                    <option value="all">All Fields</option>
                                    <option value="code">Code</option>
                                    <option value="name">Name</option>
                                    <option value="status">Status</option>
                                    <option value="priority">Priority</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Type
                                </label>
                                <x-base.form-select id="project-filter-type" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                    <option value="contains">Contains</option>
                                    <option value="equals">Equals</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Value
                                </label>
                                <x-base.form-input id="project-filter-value" type="text" placeholder="Search..." class="mt-2 w-full sm:mt-0 sm:w-48 2xl:w-full" />
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Show
                                </label>
                                <x-base.form-select id="project-filter-length" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 xl:mt-0">
                                <x-base.button id="project-filter-go" type="button" variant="primary" class="w-full sm:w-16">
                                    Go
                                </x-base.button>
                                <x-base.button id="project-filter-reset" type="button" variant="secondary" class="mt-2 w-full sm:ml-1 sm:mt-0 sm:w-16">
                                    Reset
                                </x-base.button>
                            </div>
                        </form>

                        <div class="mt-5 flex sm:mt-0">
                            <x-base.button id="project-export" variant="outline-secondary" class="mr-2 w-1/2 sm:w-auto">
                                <x-base.lucide icon="Download" class="mr-2 h-4 w-4" /> Export
                            </x-base.button>
                            <x-base.button id="project-refresh" variant="outline-secondary" class="w-1/2 sm:w-auto">
                                <x-base.lucide icon="RefreshCcw" class="mr-2 h-4 w-4" /> Refresh
                            </x-base.button>
                        </div>
                    </div>

                    <div class="overflow-x-auto sm:overflow-visible" data-erp-table-wrapper>
                        <table id="project-table" data-tw-merge data-erp-table class="datatable-default w-full min-w-full table-auto text-left text-sm">
                            <thead>
                                <tr>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">#</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Code</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Project Name</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Manager</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Status</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Priority</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Progress</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Budget</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Duration</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

            </x-base.preview-component>
        </div>
    </div>

    @include('project.projects.modals.add')
    @include('project.projects.modals.status')
    @stack('modals')
@endsection

@include('components.datatable.scripts')

@push('scripts')
    <script>
    try {
        document.addEventListener('DOMContentLoaded', function () {
            const filterField = document.getElementById('project-filter-field');
            const filterType = document.getElementById('project-filter-type');
            const filterValue = document.getElementById('project-filter-value');
            const lengthSelect = document.getElementById('project-filter-length');
            const filterGoBtn = document.getElementById('project-filter-go');
            const filterResetBtn = document.getElementById('project-filter-reset');
            const exportBtn = document.getElementById('project-export');
            const refreshBtn = document.getElementById('project-refresh');

            // Advanced filters
            const companyFilter = document.getElementById('company-filter');
            const departmentFilter = document.getElementById('department-filter');
            const statusFilter = document.getElementById('status-filter');
            const priorityFilter = document.getElementById('priority-filter');
            const advancedFilterApplyBtn = document.getElementById('advanced-filter-apply');
            const totalProjectsCount = document.getElementById('total-projects-count');
            const activeCount = document.getElementById('active-count');
            const completedCount = document.getElementById('completed-count');
            const overdueCount = document.getElementById('overdue-count');

            const initialLength = lengthSelect ? parseInt(lengthSelect.value, 10) || 10 : 10;

            const table = window.initDataTable('#project-table', {
                ajax: {
                    url: '{{ route("project-management.projects.datatable") }}',
                    type: 'GET',
                    data: function (d) {
                        console.log('DataTable sending data:', d);
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
                        if (statusFilter) {
                            d.status = statusFilter.value || '';
                        }
                        if (priorityFilter) {
                            d.priority = priorityFilter.value || '';
                        }
                        d.page_length = lengthSelect ? parseInt(lengthSelect.value, 10) || initialLength : initialLength;
                    },
                    error: function (xhr, textStatus, error) {
                        console.error('DataTables AJAX error:', textStatus, error, xhr.responseText);
                    }
                },
                pageLength: initialLength,
                lengthChange: false,
                searching: false,
                order: [[2, 'asc']],
                dom:
                    "t<'datatable-footer flex flex-col md:flex-row md:items-center md:justify-between mt-5 gap-4'<'datatable-info text-slate-500'i><'datatable-pagination'p>>",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center font-medium', orderable: false },
                    { data: 'code', name: 'code', className: 'px-5 py-3 border-b dark:border-darkmode-300 font-medium text-slate-700 whitespace-nowrap' },
                    { data: 'name', name: 'name', className: 'px-5 py-3 border-b dark:border-darkmode-300 font-medium text-slate-700 datatable-cell-wrap' },
                    { data: 'manager_name', name: 'manager_name', className: 'px-5 py-3 border-b dark:border-darkmode-300 datatable-cell-wrap' },
                    {
                        data: 'status_badge',
                        name: 'status_badge',
                        render: function (value) {
                            return value;
                        }
                    },
                    {
                        data: 'priority_badge',
                        name: 'priority_badge',
                        render: function (value) {
                            return value;
                        }
                    },
                    {
                        data: 'progress_bar',
                        name: 'progress_bar',
                        render: function (value) {
                            return value;
                        }
                    },
                    { data: 'budget_formatted', name: 'budget_formatted', className: 'px-5 py-3 border-b dark:border-darkmode-300 whitespace-nowrap text-green-600 font-medium' },
                    { data: 'duration_days', name: 'duration_days', className: 'px-5 py-3 border-b dark:border-darkmode-300 whitespace-nowrap' },
                    {
                        data: 'actions',
                        name: 'actions',
                        className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center',
                        orderable: false,
                        searchable: false
                    }
                ],
                rawColumns: ['status_badge', 'priority_badge', 'progress_bar', 'actions'],
                drawCallback: function () {
                    console.log('DataTable draw callback - table data:', table.rows().data().toArray());
                    if (typeof window.Lucide !== 'undefined') {
                        window.Lucide.createIcons();
                    }
                }
            });

            if (!table) {
                return;
            }

            // Load initial stats
            loadProjectStats();

            if (lengthSelect) {
                lengthSelect.addEventListener('change', function () {
                    const newLength = parseInt(this.value, 10) || initialLength;
                    table.page.len(newLength).draw();
                });
            }

            const reloadTable = function () {
                table.ajax.reload(null, false);
                loadProjectStats();
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
                    if (filterField) filterField.value = 'all';
                    if (filterType) filterType.value = 'contains';
                    if (filterValue) filterValue.value = '';
                    if (lengthSelect) {
                        lengthSelect.value = String(initialLength);
                        table.page.len(initialLength).draw();
                    }
                    // Reset advanced filters
                    if (companyFilter) companyFilter.value = '';
                    if (departmentFilter) departmentFilter.value = '';
                    if (statusFilter) statusFilter.value = '';
                    if (priorityFilter) priorityFilter.value = '';
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
                        // Load departments for selected company
                        loadDepartmentsForCompany(this.value);
                    }
                    setTimeout(reloadTable, 300);
                });
            }

            if (departmentFilter) {
                departmentFilter.addEventListener('change', function() {
                    setTimeout(reloadTable, 300);
                });
            }

            if (statusFilter) {
                statusFilter.addEventListener('change', function() {
                    setTimeout(reloadTable, 300);
                });
            }

            if (priorityFilter) {
                priorityFilter.addEventListener('change', function() {
                    setTimeout(reloadTable, 300);
                });
            }

            // Function to load departments based on company
            function loadDepartmentsForCompany(companyId) {
                if (!departmentFilter) return;

                departmentFilter.innerHTML = '<option value="">Loading departments...</option>';

                if (!companyId) {
                    departmentFilter.innerHTML = '<option value="">All Departments</option>';
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
                        departmentFilter.innerHTML = '<option value="">All Departments</option>';
                        if (data && Array.isArray(data)) {
                            data.forEach(function(dept) {
                                const option = document.createElement('option');
                                option.value = dept.id;
                                option.textContent = dept.name;
                                departmentFilter.appendChild(option);
                            });
                        }
                    })
                    .catch(function(error) {
                        console.error('Error loading departments:', error);
                        departmentFilter.innerHTML = '<option value="">Error loading departments</option>';
                    });
            }

            // Load project statistics
            function loadProjectStats() {
                fetch('{{ route("project-management.projects.stats") }}', {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    credentials: 'same-origin'
                })
                    .then(function(response) {
                        return response.json();
                    })
                    .then(function(data) {
                        if (data.success && data.data) {
                            const stats = data.data;
                            if (totalProjectsCount) {
                                totalProjectsCount.textContent = stats.total_projects || 0;
                            }
                            if (activeCount) {
                                activeCount.textContent = stats.active || 0;
                            }
                            if (completedCount) {
                                completedCount.textContent = stats.completed || 0;
                            }
                            if (overdueCount) {
                                overdueCount.textContent = stats.overdue || 0;
                            }
                        }
                    })
                    .catch(function(error) {
                        console.error('Error loading project stats:', error);
                    });
            }

            // Export functionality
            if (exportBtn) {
                exportBtn.addEventListener('click', function () {
                    try {
                        const rows = table.rows({ search: 'applied' }).data().toArray();
                        if (!rows.length) {
                            showToast('No data available for export.', 'error');
                            return;
                        }

                        const headers = ['#', 'Code', 'Name', 'Manager', 'Status', 'Priority', 'Progress', 'Budget', 'Duration'];
                        const csvRows = [headers.join(',')];

                        rows.forEach(function (row) {
                            const csvRow = [
                                row.DT_RowIndex,
                                '"' + (row.code || '').replace(/"/g, '""') + '"',
                                '"' + (row.name || '').replace(/"/g, '""') + '"',
                                '"' + (row.manager_name || '').replace(/"/g, '""') + '"',
                                row.status_label || 'Unknown',
                                row.priority_label || 'Unknown',
                                row.progress_percentage + '%',
                                row.budget_formatted ? parseFloat(row.budget_formatted.replace('$', '').replace(',', '')) : 0,
                                '"' + (row.duration_days || '').replace(/"/g, '""') + '"'
                            ];
                            csvRows.push(csvRow.join(','));
                        });

                        const blob = new Blob(['\ufeff' + csvRows.join('\n')], { type: 'text/csv;charset=utf-8;' });
                        const link = document.createElement('a');
                        link.href = URL.createObjectURL(blob);
                        link.download = 'projects_' + new Date().toISOString().split('T')[0] + '.csv';
                        link.click();
                        URL.revokeObjectURL(link);

                        showToast('Project data exported successfully', 'success');
                    } catch (error) {
                        console.error('Export error:', error);
                        showToast('Failed to export project data', 'error');
                    }
                });
            }
        });

    } catch (error) {
        console.error('❌ Error loading project page:', error);
    }
    </script>
@endpush

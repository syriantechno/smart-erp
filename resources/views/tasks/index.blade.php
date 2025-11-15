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
        <x-base.button
            variant="primary"
            class="w-32 sm:w-auto sm:ml-4"
            data-tw-toggle="modal"
            data-tw-target="#create-task-modal"
        >
            <x-base.lucide icon="Plus" class="w-4 h-4 mr-2" />
            Add Task
        </x-base.button>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <!-- Advanced Filters Section -->
            <x-base.preview-component class="intro-y box mb-6">
                <div class="p-5">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                        <x-base.lucide icon="Filter" class="h-5 w-5"></x-base.lucide>
                        Advanced Filters
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
                                @foreach($departments ?? [] as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </x-base.form-select>
                        </div>

                        <!-- Employee Filter -->
                        <div class="col-span-12 md:col-span-3">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
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
                        <div class="col-span-12 md:col-span-3">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
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

                    <!-- Filter Results Summary -->
                    <div class="mt-4 p-4 bg-slate-50 dark:bg-darkmode-600 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="text-sm text-slate-600 dark:text-slate-400">
                                    <span class="font-medium">Total Tasks:</span>
                                    <span id="total-tasks-count" class="font-semibold text-slate-800 dark:text-white">0</span>
                                </div>
                                <div class="text-sm text-slate-600 dark:text-slate-400">
                                    <span class="font-medium">Filtered:</span>
                                    <span id="filtered-tasks-count" class="font-semibold text-blue-600">0</span>
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
                            <div class="mt-2 xl:mt-0">
                                <x-base.button id="tasks-filter-go" type="button" variant="primary" class="w-full sm:w-16">
                                    Go
                                </x-base.button>
                                <x-base.button id="tasks-filter-reset" type="button" variant="secondary" class="mt-2 w-full sm:ml-1 sm:mt-0 sm:w-16">
                                    Reset
                                </x-base.button>
                            </div>
                        </form>

                        <div class="mt-5 flex sm:mt-0">
                            <x-base.button id="tasks-export" variant="outline-secondary" class="mr-2 w-1/2 sm:w-auto">
                                <x-base.lucide icon="Download" class="mr-2 h-4 w-4" /> Export
                            </x-base.button>
                            <x-base.button id="tasks-refresh" variant="outline-secondary" class="w-1/2 sm:w-auto">
                                <x-base.lucide icon="RefreshCcw" class="mr-2 h-4 w-4" /> Refresh
                            </x-base.button>
                        </div>
                    </div>

                    <div class="overflow-x-auto sm:overflow-visible" data-erp-table-wrapper>
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
                </div>

            </x-base.preview-component>
        </div>
    </div>

    @include('tasks.modals.create')
    @include('tasks.modals.edit')
    @stack('modals')

    <!-- Hidden button to trigger edit modal -->
    <button id="edit-task-trigger" data-tw-toggle="modal" data-tw-target="#edit-task-modal" class="hidden"></button>
@endsection

@include('components.datatable.scripts')

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>
    <script>
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

            const table = window.initDataTable('#tasks-table', {
                ajax: {
                    url: '{{ route("tasks.datatable") }}',
                    type: 'GET',
                    data: function (d) {
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
                    error: function (xhr, textStatus, error) {
                        console.error('DataTables AJAX error:', textStatus, error, xhr.responseText);
                    }
                },
                pageLength: initialLength,
                lengthChange: false,
                searching: false,
                order: [[1, 'asc']], // Order by code column (index 1)
                dom:
                    "t<'datatable-footer flex flex-col md:flex-row md:items-center md:justify-between mt-5 gap-4'<'datatable-info text-slate-500'i><'datatable-pagination'p>>",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center font-medium', orderable: false },
                    { data: 'code', name: 'code', className: 'px-5 py-3 border-b dark:border-darkmode-300 font-medium text-slate-700 whitespace-nowrap' },
                    { data: 'title', name: 'title', className: 'px-5 py-3 border-b dark:border-darkmode-300 font-medium text-slate-700 datatable-cell-wrap' },
                    {
                        data: 'priority',
                        name: 'priority',
                        render: function (value) {
                            const badgeClass = value === 'high' ? 'bg-red-100 text-red-700' :
                                             value === 'medium' ? 'bg-yellow-100 text-yellow-700' :
                                             value === 'low' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700';
                            return `<span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ${badgeClass}">${value}</span>`;
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function (value) {
                            const badgeClass = value === 'completed' ? 'bg-green-100 text-green-700' :
                                             value === 'in_progress' ? 'bg-blue-100 text-blue-700' :
                                             value === 'pending' ? 'bg-yellow-100 text-yellow-700' :
                                             value === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700';
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
                rawColumns: ['priority', 'status', 'actions'],
                drawCallback: function () {
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
                    const hasFilters = (companyFilter && companyFilter.value) ||
                                     (departmentFilter && departmentFilter.value) ||
                                     (employeeFilter && employeeFilter.value) ||
                                     (statusFilter && statusFilter.value);

                    if (hasFilters && info.recordsTotal !== info.recordsDisplay) {
                        showToast(`Filtered ${info.recordsDisplay} out of ${info.recordsTotal} tasks`, 'success');
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
                    setTimeout(reloadTable, 300);
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
    }
    </script>
@endpush

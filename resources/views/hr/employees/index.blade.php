@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Employees Management - {{ config('app.name') }}</title>
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
        <h2 class="mr-auto text-lg font-medium">Employees Management</h2>
        <x-base.button
            variant="primary"
            class="w-40 sm:w-auto sm:ml-4"
            data-tw-toggle="modal"
            data-tw-target="#create-employee-modal"
        >
            <x-base.lucide icon="UserPlus" class="w-4 h-4 mr-2" />
            Add Employee
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
                        <div class="col-span-12 md:col-span-4">
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
                        <div class="col-span-12 md:col-span-4">
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

                        <!-- Position Filter -->
                        <div class="col-span-12 md:col-span-4">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Filter by Position
                            </label>
                            <x-base.form-select id="position-filter" class="w-full">
                                <option value="">All Positions</option>
                                <!-- Will be populated via JavaScript -->
                            </x-base.form-select>
                        </div>
                    </div>

                    <!-- Filter Results Summary -->
                    <div class="mt-4 p-4 bg-slate-50 dark:bg-darkmode-600 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="text-sm text-slate-600 dark:text-slate-400">
                                    <span class="font-medium">Total Employees:</span>
                                    <span id="total-employees-count" class="font-semibold text-slate-800 dark:text-white">0</span>
                                </div>
                                <div class="text-sm text-slate-600 dark:text-slate-400">
                                    <span class="font-medium">Filtered:</span>
                                    <span id="filtered-employees-count" class="font-semibold text-blue-600">0</span>
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
                        <form id="employees-filter-form" class="w-full sm:mr-auto xl:flex">
                            <div class="items-center sm:mr-4 sm:flex">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Field
                                </label>
                                <x-base.form-select id="employees-filter-field" class="mt-2 w-full sm:mt-0 sm:w-auto 2xl:w-full">
                                    <option value="all">All Fields</option>
                                    <option value="code">Code</option>
                                    <option value="first_name">First Name</option>
                                    <option value="last_name">Last Name</option>
                                    <option value="email">Email</option>
                                    <option value="position">Position</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Type
                                </label>
                                <x-base.form-select id="employees-filter-type" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                    <option value="contains">Contains</option>
                                    <option value="equals">Equals</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Value
                                </label>
                                <x-base.form-input id="employees-filter-value" type="text" placeholder="Search..." class="mt-2 w-full sm:mt-0 sm:w-48 2xl:w-full" />
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Show
                                </label>
                                <x-base.form-select id="employees-filter-length" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 xl:mt-0">
                                <x-base.button id="employees-filter-go" type="button" variant="primary" class="w-full sm:w-16">
                                    Go
                                </x-base.button>
                                <x-base.button id="employees-filter-reset" type="button" variant="secondary" class="mt-2 w-full sm:ml-1 sm:mt-0 sm:w-16">
                                    Reset
                                </x-base.button>
                            </div>
                        </form>

                        <div class="mt-5 flex sm:mt-0">
                            <x-base.button id="employees-export" variant="outline-secondary" class="mr-2 w-1/2 sm:w-auto">
                                <x-base.lucide icon="Download" class="mr-2 h-4 w-4" /> Export
                            </x-base.button>
                            <x-base.button id="employees-refresh" variant="outline-secondary" class="w-1/2 sm:w-auto">
                                <x-base.lucide icon="RefreshCcw" class="mr-2 h-4 w-4" /> Refresh
                            </x-base.button>
                        </div>
                    </div>

                    <div class="overflow-x-auto sm:overflow-visible" data-erp-table-wrapper>
                        <table id="employees-table" data-tw-merge data-erp-table class="datatable-default w-full min-w-full table-auto text-left text-sm">
                            <thead>
                                <tr>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">#</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Code</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Photo</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Full Name</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Department</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Position</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Email</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Status</th>
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

    @include('hr.employees.modals.create')
    @stack('modals')

    <!-- Hidden button to trigger edit modal -->
    <button id="edit-employee-trigger" data-tw-toggle="modal" data-tw-target="#edit-employee-modal" class="hidden"></button>
@endsection

@include('components.datatable.scripts')

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
            const filterField = document.getElementById('employees-filter-field');
            const filterType = document.getElementById('employees-filter-type');
            const filterValue = document.getElementById('employees-filter-value');
            const lengthSelect = document.getElementById('employees-filter-length');
            const filterGoBtn = document.getElementById('employees-filter-go');
            const filterResetBtn = document.getElementById('employees-filter-reset');
            const exportBtn = document.getElementById('employees-export');
            const refreshBtn = document.getElementById('employees-refresh');

            // Advanced filters
            const companyFilter = document.getElementById('company-filter');
            const departmentFilter = document.getElementById('department-filter');
            const positionFilter = document.getElementById('position-filter');
            const advancedFilterApplyBtn = document.getElementById('advanced-filter-apply');
            const totalEmployeesCount = document.getElementById('total-employees-count');
            const filteredEmployeesCount = document.getElementById('filtered-employees-count');

            const initialLength = lengthSelect ? parseInt(lengthSelect.value, 10) || 10 : 10;

            const table = window.initDataTable('#employees-table', {
                ajax: {
                    url: '{{ route("hr.employees.datatable") }}',
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
                        if (positionFilter) {
                            d.position_filter = positionFilter.value || '';
                        }
                        d.page_length = lengthSelect ? parseInt(lengthSelect.value, 10) || initialLength : initialLength;
                    },
                    error: function () {}
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
                    { data: 'profile_picture', name: 'profile_picture', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center', orderable: false },
                    { data: 'full_name', name: 'full_name', className: 'px-5 py-3 border-b dark:border-darkmode-300 font-medium text-slate-700 datatable-cell-wrap' },
                    { data: 'department_name', name: 'department_name', className: 'px-5 py-3 border-b dark:border-darkmode-300 datatable-cell-wrap' },
                    { data: 'position', name: 'position', className: 'px-5 py-3 border-b dark:border-darkmode-300 datatable-cell-wrap' },
                    { data: 'email', name: 'email', className: 'px-5 py-3 border-b dark:border-darkmode-300 datatable-cell-wrap' },
                    {
                        data: 'is_active',
                        name: 'is_active',
                        render: function (value) {
                            const status = Boolean(value);
                            const badgeClass = status
                                ? 'bg-green-100 text-green-700'
                                : 'bg-red-100 text-red-700';
                            const label = status ? 'Active' : 'Inactive';
                            return `<span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ${badgeClass}">${label}</span>`;
                        }
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center',
                        orderable: false,
                        searchable: false
                    }
                ],
                rawColumns: ['status', 'profile_picture', 'actions'],
                drawCallback: function () {
                    if (typeof window.Lucide !== 'undefined') {
                        window.Lucide.createIcons();
                    }

                    // Update employee counts
                    const info = table.page.info();
                    if (totalEmployeesCount) {
                        totalEmployeesCount.textContent = info.recordsTotal;
                    }
                    if (filteredEmployeesCount) {
                        filteredEmployeesCount.textContent = info.recordsDisplay;
                    }

                    // Show filter summary if filters are active
                    const hasFilters = (companyFilter && companyFilter.value) ||
                                     (departmentFilter && departmentFilter.value) ||
                                     (positionFilter && positionFilter.value);

                    if (hasFilters && info.recordsTotal !== info.recordsDisplay) {
                        showToast(`Filtered ${info.recordsDisplay} out of ${info.recordsTotal} employees`, 'success');
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
                    if (positionFilter) {
                        positionFilter.value = '';
                        loadPositionsForDepartment(''); // Reset positions
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
                        // Load departments for selected company
                        loadDepartmentsForCompany(this.value);
                    }
                    setTimeout(reloadTable, 300);
                });
            }

            if (departmentFilter) {
                departmentFilter.addEventListener('change', function() {
                    loadPositionsForDepartment(this.value);
                    setTimeout(reloadTable, 300);
                });
            }

            if (positionFilter) {
                positionFilter.addEventListener('change', function() {
                    setTimeout(reloadTable, 300);
                });
            }

            // Function to load departments based on company
            function loadDepartmentsForCompany(companyId) {
                if (!departmentFilter) return;

                departmentFilter.innerHTML = '<option value="">Loading departments...</option>';

                if (!companyId) {
                    departmentFilter.innerHTML = '<option value="">All Departments</option>';
                    // Add all departments back
                    @foreach($departments ?? [] as $department)
                        departmentFilter.innerHTML += '<option value="{{ $department->id }}">{{ $department->name }}</option>';
                    @endforeach
                    loadPositionsForDepartment(''); // Reset positions
                    return;
                }

                fetch(`/hr/departments/api/company/${companyId}`, {
                    credentials: 'same-origin',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        departmentFilter.innerHTML = '<option value="">All Departments</option>';
                        if (data && Array.isArray(data)) {
                            data.forEach(dept => {
                                const option = document.createElement('option');
                                option.value = dept.id;
                                option.textContent = dept.name;
                                departmentFilter.appendChild(option);
                            });
                        }
                        loadPositionsForDepartment(''); // Reset positions when company changes
                    })
                    .catch(() => {
                        departmentFilter.innerHTML = '<option value="">Error loading departments</option>';
                    });
            }

            // Function to load positions based on department
            function loadPositionsForDepartment(departmentId) {
                if (!positionFilter) return;

                positionFilter.innerHTML = '<option value="">Loading positions...</option>';

                const url = departmentId 
                    ? `/hr/employees/positions/department?department_id=${departmentId}`
                    : '/hr/employees/positions/department';

                fetch(url, {
                    credentials: 'same-origin',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        positionFilter.innerHTML = '<option value="">All Positions</option>';
                        if (data && Array.isArray(data)) {
                            data.forEach(position => {
                                const option = document.createElement('option');
                                option.value = position;
                                option.textContent = position;
                                positionFilter.appendChild(option);
                            });
                        }
                    })
                    .catch(() => {
                        positionFilter.innerHTML = '<option value="">Error loading positions</option>';
                    });
            }

            // Employee code preview
            const refreshEmployeeCode = function () {
                const codePreview = document.getElementById('employee-code-preview');
                const codeInput = document.getElementById('code');
                if (!codePreview) return;

                fetch('{{ route("hr.employees.preview-code") }}')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to preview employee code');
                        }
                        return response.json();
                    })
                    .then(data => {
                        const code = data.code || '-';
                        codePreview.textContent = code;
                        // Also update the form input if it exists
                        if (codeInput) {
                            codeInput.value = code;
                        }
                    })
                    .catch(() => {
                        codePreview.textContent = '-';
                        if (codeInput) {
                            codeInput.value = '-';
                        }
                    });
            };
            // Image preview functionality
            const profilePictureInput = document.getElementById('profile_picture');
            const imagePreviewContainer = document.getElementById('image-preview-container');
            const imagePreview = document.getElementById('image-preview');
            const removeImageBtn = document.getElementById('remove-image');

            if (profilePictureInput) {
                profilePictureInput.addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            imagePreview.src = e.target.result;
                            imagePreviewContainer.classList.remove('hidden');
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            if (removeImageBtn) {
                removeImageBtn.addEventListener('click', function() {
                    profilePictureInput.value = '';
                    imagePreview.src = '';
                    imagePreviewContainer.classList.add('hidden');
                });
            }

            // Dynamic department and position loading - handled in modal
            // Removed to avoid conflicts with modal's own JavaScript

            const createForm = document.getElementById('create-employee-form');
            const createModal = document.getElementById('create-employee-modal');

            if (createForm) {
                createForm.addEventListener('submit', function (event) {
                    event.preventDefault();

                    const formData = new FormData(createForm);

                    fetch(createForm.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
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
                                showToast(data.message || 'Employee created successfully', 'success');
                                createForm.reset();
                                // Reset selects - handled in modal
                                createModal.__tippy?.hide?.();
                                reloadTable();
                            } else {
                                showToast(data.message || 'Failed to create employee', 'error');
                            }
                        })
                        .catch((error) => {
                            if (error.message === 'validation') {
                                return;
                            }
                            showToast('An error occurred while saving the employee', 'error');
                        });
                });
            }

            if (exportBtn) {
                exportBtn.addEventListener('click', function () {
                    try {
                        const rows = table.rows({ search: 'applied' }).data().toArray();
                        if (!rows.length) {
                            showToast('No data available for export.', 'error');
                            return;
                        }

                        const headers = ['#', 'Code', 'Photo', 'Full Name', 'Department', 'Position', 'Email', 'Status'];
                        const csvRows = [headers.join(',')];

                        rows.forEach(function (row) {
                            const csvRow = [
                                row.DT_RowIndex,
                                '"' + (row.code || '').replace(/"/g, '""') + '"',
                                row.profile_picture ? 'Yes' : 'No', // Photo indicator
                                '"' + (row.full_name || '').replace(/"/g, '""') + '"',
                                '"' + (row.department_name || '').replace(/"/g, '""') + '"',
                                '"' + (row.position || '').replace(/"/g, '""') + '"',
                                '"' + (row.email || '').replace(/"/g, '""') + '"',
                                row.is_active ? 'Active' : 'Inactive'
                            ];
                            csvRows.push(csvRow.join(','));
                        });

                        const blob = new Blob([csvRows.join('\n')], { type: 'text/csv;charset=utf-8;' });
                        const url = URL.createObjectURL(blob);
                        const link = document.createElement('a');
                        link.href = url;
                        link.download = 'employees.csv';
                        link.click();
                        URL.revokeObjectURL(url);
                        showToast('Export completed successfully.', 'success');
                    } catch (error) {
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

            // Initialize positions on page load
            loadPositionsForDepartment('');

            window.openEditModal = function(id, employeeId, firstName, lastName, email, phone, position, salary, hireDate, birthDate, gender, address, city, country, postalCode, departmentId, companyId, isActive) {
                // Populate form fields
                document.getElementById('edit-employee-id').value = employeeId || '';
                document.getElementById('edit-first-name').value = firstName || '';
                document.getElementById('edit-last-name').value = lastName || '';
                document.getElementById('edit-email').value = email || '';
                document.getElementById('edit-phone').value = phone || '';
                document.getElementById('edit-position').value = position || '';
                document.getElementById('edit-salary').value = salary || '';
                document.getElementById('edit-hire-date').value = hireDate || '';
                document.getElementById('edit-birth-date').value = birthDate || '';
                document.getElementById('edit-gender').value = gender || '';
                document.getElementById('edit-address').value = address || '';
                document.getElementById('edit-city').value = city || '';
                document.getElementById('edit-country').value = country || '';
                document.getElementById('edit-postal-code').value = postalCode || '';
                document.getElementById('edit-department_id').value = departmentId || '';
                document.getElementById('edit-company_id').value = companyId || '';
                document.getElementById('edit-is_active').checked = isActive;

                // Update form action
                const form = document.getElementById('edit-employee-form');
                form.action = `/hr/employees/${id}`;

                // Show modal using the hidden trigger button
                const modalTrigger = document.getElementById('edit-employee-trigger');
                if (modalTrigger) {
                    modalTrigger.click();
                }
            };

            const editForm = document.getElementById('edit-employee-form');
            const editModal = document.getElementById('edit-employee-modal');

            if (editForm) {
                editForm.addEventListener('submit', function (event) {
                    event.preventDefault();

                    const formData = new FormData(editForm);

                    fetch(editForm.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
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
                                showToast(data.message || 'Employee updated successfully', 'success');
                                editModal.__tippy?.hide?.();
                                reloadTable();
                            } else {
                                showToast(data.message || 'Failed to update employee', 'error');
                            }
                        })
                        .catch((error) => {
                            if (error.message === 'validation') {
                                return;
                            }
                            showToast('An error occurred while updating the employee', 'error');
                        });
                });
            }

            window.deleteEmployee = function (id, name) {
                Swal.fire({
                    title: 'Delete Employee?',
                    html: `Are you sure you want to delete <strong>"${name}"</strong>?<br>This action cannot be undone.`,
                    icon: 'warning',
                    iconColor: '#ef4444',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel',
                    background: '#ffffff',
                    customClass: {
                        popup: 'rounded-xl shadow-2xl',
                        confirmButton: 'px-6 py-2 rounded-lg font-semibold',
                        cancelButton: 'px-6 py-2 rounded-lg font-semibold'
                    },
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown animate__faster'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp animate__faster'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`{{ route('hr.employees.destroy', '') }}/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                            },
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    reloadTable();
                                    showToast(data.message || 'Employee deleted successfully', 'success');
                                } else {
                                    showToast(data.message || 'Failed to delete employee', 'error');
                                }
                            })
                            .catch(() => {
                                showToast('An error occurred while deleting the employee', 'error');
                            });
                    }
                });
            };
        });
    </script>
@endpush

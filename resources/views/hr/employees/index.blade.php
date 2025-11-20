@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Employees Management - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        /* Make employees table rows more compact */
        #employees-table tbody tr {
            height: 2.25rem; /* ~36px */
        }

        #employees-table td {
            padding-top: 0.375rem;  /* 6px */
            padding-bottom: 0.375rem;
        }

        .btn-tonal {
            --btn-surface: color-mix(in oklch, var(--color-primary, #2563eb) 20%, #ffffff);
            --btn-border: color-mix(in oklch, var(--color-primary, #2563eb), transparent 80%);
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.5rem 1.15rem;
            border-radius: 9999px;
            border: 1px solid var(--btn-border);
            background-color: var(--btn-surface);
            color: color-mix(in oklch, var(--color-primary, #2563eb), black 20%);
            font-weight: 600;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.08);
        }

        .btn-tonal:hover {
            transform: translateY(-1px) scale(1.02);
            box-shadow: 0 15px 25px rgba(37, 99, 235, 0.12);
        }

        .btn-tonal:focus-visible {
            outline: 2px solid color-mix(in oklch, var(--color-primary, #2563eb), transparent 60%);
            outline-offset: 3px;
        }

    </style>
@endpush

@section('subcontent')
    @include('components.global-notifications')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Employees Management</h2>
        <div class="flex items-center gap-2">
            <button
                type="button"
                class="btn-tonal btn-tonal--info hidden sm:flex"
                data-tw-toggle="modal"
                data-tw-target="#employees-filters-slideover"
                title="Open advanced filters"
                aria-label="Open advanced filters"
            >
                <x-base.lucide icon="Filter" class="w-4 h-4 mr-2" />
                Filters
                <span id="active-filters-indicator" class="hidden ml-2 px-2 py-0.5 text-xs bg-blue-100 text-blue-700 rounded-full">Active</span>
            </button>

            <!-- Mobile filters icon -->
            <x-base.tippy
                as="button"
                type="button"
                content="Open filters"
                class="flex items-center justify-center rounded-full border border-slate-200 px-3 py-2 text-slate-600 hover:bg-slate-50 sm:hidden"
                data-tw-toggle="modal"
                data-tw-target="#employees-filters-slideover"
            >
                <x-base.lucide icon="Filter" class="w-4 h-4" />
            </x-base.tippy>

            <button
                type="button"
                class="btn-tonal btn-tonal--success"
                data-tw-toggle="modal"
                data-tw-target="#create-employee-modal"
                title="Add a new employee"
                aria-label="Add a new employee"
            >
                <x-base.lucide icon="user-plus" class="w-4 h-4 mr-2" />
                Add Employee
            </button>
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
                            <div class="mt-2 flex flex-wrap gap-2 xl:mt-0">
                                <x-base.tippy as="button" id="employees-filter-go" type="button" content="Run filters" class="btn-tonal btn-tonal--info">
                                    <x-base.lucide icon="Search" class="w-4 h-4" />
                                    Go
                                </x-base.tippy>
                                <x-base.tippy as="button" id="employees-filter-reset" type="button" content="Reset filters" class="btn-tonal btn-tonal--warning">
                                    <x-base.lucide icon="RotateCcw" class="w-4 h-4" />
                                    Reset
                                </x-base.tippy>
                            </div>
                        </form>

                        <div class="mt-5 flex flex-wrap items-center gap-2 sm:mt-0 sm:flex-nowrap">
                            <button type="button" class="btn-tonal btn-tonal--purple btn-tonal--icon group" title="Print">
                                <x-base.lucide icon="printer" class="w-5 h-5 icon-hover-rise" />
                            </button>
                            <button id="employees-export-pdf" type="button" class="btn-tonal btn-tonal--rose btn-tonal--icon group" title="Export PDF">
                                <x-base.lucide icon="file-text" class="w-5 h-5 icon-hover-rise" />
                            </button>
                            <button id="employees-export" type="button" class="btn-tonal btn-tonal--lime btn-tonal--icon group" title="Export to Excel">
                                <x-base.lucide icon="file-spreadsheet" class="w-5 h-5 icon-hover-rise" />
                            </button>
                            <button id="employees-import" type="button" class="btn-tonal btn-tonal--amber btn-tonal--icon group" title="Import employees">
                                <x-base.lucide icon="upload-cloud" class="w-5 h-5 icon-hover-rise" />
                            </button>
                            <input type="file" id="employees-import-input" accept=".csv,text/csv" class="hidden" />
                            <button id="employees-refresh" type="button" class="btn-tonal btn-tonal--sky btn-tonal--icon group" title="Refresh">
                                <x-base.lucide icon="refresh-cw" class="w-5 h-5 icon-hover-rise" />
                            </button>
                        </div>
                    </div>

                    <div class="overflow-x-auto sm:overflow-visible" data-erp-table-wrapper>
                        <table id="employees-table" data-tw-merge data-erp-table class="datatable-default w-full min-w-full table-auto text-left text-sm">
                            <thead>
                                <tr>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">#</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Code</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 text-center">Photo</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Full Name</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Department / Position</th>
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

    <!-- Employees Filters Slide Over -->
    <x-base.slideover id="employees-filters-slideover" size="md">
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
                    Employees Filters
                </h2>
            </x-base.slideover.title>

            <x-base.slideover.description class="p-5">
                <div class="mb-4 text-sm text-slate-600 dark:text-slate-400">
                    Use these filters to narrow down the employees list. Click "Apply Filters" to update the table.
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

                    <!-- Position Filter -->
                    <div class="col-span-12">
                        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                            Filter by Position
                        </label>
                        <x-base.form-select id="position-filter" class="w-full">
                            <option value="">All Positions</option>
                            <!-- Will be populated via JavaScript -->
                        </x-base.form-select>
                    </div>
                </div>

                <!-- Filter Results Summary & Actions -->
                <div class="mt-5 rounded-lg bg-slate-50 p-4 dark:bg-darkmode-600">
                    <div class="flex flex-col gap-3">
                        <div class="flex flex-wrap items-center gap-4">
                            <div class="text-sm text-slate-600 dark:text-slate-400">
                                <span class="font-medium">Total Employees:</span>
                                <span id="total-employees-count" class="font-semibold text-slate-800">0</span>
                            </div>
                            <div class="text-sm text-slate-600 dark:text-slate-400">
                                <span class="font-medium">Filtered:</span>
                                <span id="filtered-employees-count" class="font-semibold text-blue-600">0</span>
                            </div>
                        </div>

                        <div class="mt-2 flex justify-end gap-2">
                            <x-base.tippy
                                as="button"
                                type="button"
                                content="Close advanced filters"
                                class="btn-tonal btn-tonal--warning w-28"
                                data-tw-dismiss="modal"
                            >
                                <x-base.lucide icon="X" class="mr-2 h-4 w-4 animate-pulse" />
                                Close
                            </x-base.tippy>
                            <x-base.tippy
                                as="button"
                                id="advanced-filter-apply"
                                type="button"
                                content="Apply filters"
                                class="btn-tonal btn-tonal--info w-28"
                            >
                                <x-base.lucide icon="Search" class="mr-2 h-4 w-4 animate-pulse" />
                                Apply
                            </x-base.tippy>
                        </div>
                    </div>
                </div>
            </x-base.slideover.description>
        </x-base.slideover.panel>
    </x-base.slideover>

    @include('hr.employees.modals.create')
    @include('hr.employees.modals.edit')
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
            const exportPdfBtn = document.getElementById('employees-export-pdf');
            const refreshBtn = document.getElementById('employees-refresh');
            const importBtn = document.getElementById('employees-import');
            const importInput = document.getElementById('employees-import-input');

            const initialLength = lengthSelect ? parseInt(lengthSelect.value, 10) || 10 : 10;

            const table = (window.erpCrud && window.erpCrud.initDataTable) ? window.erpCrud.initDataTable({
                tableSelector: '#employees-table',
                ajaxUrl: '{{ route("hr.employees.datatable") }}',
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
                    d.page_length = lengthSelect ? parseInt(lengthSelect.value, 10) || initialLength : initialLength;
                },
                pageLength: initialLength,
                order: [[1, 'asc']],
                dom: "t<'datatable-footer flex flex-col md:flex-row md:items-center md:justify-between mt-5 gap-4'<'datatable-info text-slate-500'i><'datatable-pagination'p>>",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center font-medium', orderable: false },
                    { data: 'code', name: 'code', className: 'px-5 py-3 border-b dark:border-darkmode-300 font-medium text-slate-700 whitespace-nowrap' },
                    { data: 'profile_picture', name: 'profile_picture', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center', orderable: false },
                    { data: 'full_name', name: 'full_name', className: 'px-5 py-3 border-b dark:border-darkmode-300 font-medium text-slate-700 datatable-cell-wrap' },
                    { data: 'department_name', name: 'department_name', className: 'px-5 py-3 border-b dark:border-darkmode-300 datatable-cell-wrap' },
                    { data: 'email', name: 'email', className: 'px-5 py-3 border-b dark:border-darkmode-300 datatable-cell-wrap' },
                    {
                        data: 'is_active',
                        name: 'is_active',
                        className: 'text-center',
                        title: 'Status',
                        render: function (value) {
                            if (window.erpCrud && typeof window.erpCrud.renderStatusBadge === 'function') {
                                return window.erpCrud.renderStatusBadge(value);
                            }
                            return value ? 'Active' : 'Inactive';
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
                drawCallback: function (settings) {
                    if (typeof window.Lucide !== 'undefined') {
                        window.Lucide.createIcons();
                    }

                    const info = settings.api().page.info();
                    const totalEmployeesCount = document.getElementById('total-employees-count');
                    const filteredEmployeesCount = document.getElementById('filtered-employees-count');

                    if (totalEmployeesCount) {
                        totalEmployeesCount.textContent = info.recordsTotal;
                    }
                    if (filteredEmployeesCount) {
                        filteredEmployeesCount.textContent = info.recordsDisplay;
                    }

                    const activeFiltersIndicator = document.getElementById('active-filters-indicator');
                    if (activeFiltersIndicator) {
                        activeFiltersIndicator.classList.toggle('hidden', !hasFilters());
                    }
                }
            }) : null;

            if (!table) {
                return;
            }

            if (lengthSelect) {
                lengthSelect.addEventListener('change', function () {
                    const newLength = parseInt(this.value, 10) || initialLength;
                    table.page.len(newLength).draw();
                });
            }

            if (exportPdfBtn) {
                exportPdfBtn.addEventListener('click', function () {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route("hr.employees.export-pdf") }}';

                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    if (csrfToken) {
                        const csrfInput = document.createElement('input');
                        csrfInput.type = 'hidden';
                        csrfInput.name = '_token';
                        csrfInput.value = csrfToken;
                        form.appendChild(csrfInput);
                    }

                    const params = {
                        'filter_field': filterField ? filterField.value : '',
                        'filter_type': filterType ? filterType.value : '',
                        'filter_value': filterValue ? filterValue.value : '',
                        'company_id': companyFilter ? companyFilter.value : '',
                        'department_id': departmentFilter ? departmentFilter.value : '',
                        'position_filter': positionFilter ? positionFilter.value : ''
                    };

                    Object.entries(params).forEach(function ([key, value]) {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = key;
                        input.value = value || '';
                        form.appendChild(input);
                    });

                    document.body.appendChild(form);
                    form.submit();
                    document.body.removeChild(form);
                });
            }

            if (importBtn && importInput) {
                importBtn.addEventListener('click', function () {
                    importInput.click();
                });

                importInput.addEventListener('change', function () {
                    const file = this.files[0];
                    if (!file) {
                        return;
                    }

                    if (!file.name.toLowerCase().endsWith('.csv')) {
                        showToast('Please select a CSV file.', 'error');
                        this.value = '';
                        return;
                    }

                    const formData = new FormData();
                    formData.append('file', file);

                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                    fetch('{{ route('hr.employees.import') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken || '',
                            'Accept': 'application/json',
                        },
                        body: formData,
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const details = data.data || {};
                                const summary = `Imported: ${details.created ?? 0}, Updated: ${details.updated ?? 0}`;
                                showToast(details.message || summary, 'success');
                                reloadTable();
                            } else {
                                showToast(data.message || 'Import failed.', 'error');
                            }
                        })
                        .catch(() => {
                            showToast('Unable to import the selected file.', 'error');
                        })
                        .finally(() => {
                            importInput.value = '';
                        });
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
                    reloadTable();
                });
            }

            if (refreshBtn) {
                refreshBtn.addEventListener('click', reloadTable);
            }

            // Advanced filters event listeners
            const companyFilter = document.getElementById('company-filter');
            const departmentFilter = document.getElementById('department-filter');
            const positionFilter = document.getElementById('position-filter');
            const advancedFilterApplyBtn = document.getElementById('advanced-filter-apply');

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

            // Use shared CRUD helper for create form
            if (window.erpCrud) {
                window.erpCrud.handleCreateForm({
                    formSelector: '#create-employee-form',
                    modalSelector: '#create-employee-modal',
                    onSuccess: function () {
                        reloadTable();
                    },
                });
            }

            const htmlStripper = document.createElement('div');
            const stripHtml = function (value) {
                if (!value) {
                    return '';
                }
                htmlStripper.innerHTML = value;
                const walker = document.createTreeWalker(htmlStripper, NodeFilter.SHOW_TEXT, null);
                const parts = [];
                while (walker.nextNode()) {
                    const textChunk = walker.currentNode.textContent.replace(/\s+/g, ' ').trim();
                    if (textChunk) {
                        parts.push(textChunk);
                    }
                }
                return parts.join(' ')
                    .replace(/\s*\/\s*/g, ' / ')
                    .trim();
            };

            if (exportBtn) {
                exportBtn.addEventListener('click', function () {
                    try {
                        const rows = table.rows({ search: 'applied' }).data().toArray();
                        if (!rows.length) {
                            showToast('No data available for export.', 'error');
                            return;
                        }

                        const headers = ['#', 'Code', 'Photo', 'Full Name', 'Department / Position', 'Email', 'Status'];
                        const csvRows = [headers.join(',')];

                        rows.forEach(function (row) {
                            const csvRow = [
                                row.DT_RowIndex,
                                '"' + (row.code || '').replace(/"/g, '""') + '"',
                                row.profile_picture ? 'Yes' : 'No', // Photo indicator
                                '"' + stripHtml(row.full_name || '').replace(/"/g, '""') + '"',
                                '"' + stripHtml(row.department_name || '').replace(/"/g, '""') + '"',
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

            // Use shared CRUD helper for edit form
            if (window.erpCrud) {
                window.erpCrud.handleEditForm({
                    formSelector: '#edit-employee-form',
                    modalSelector: '#edit-employee-modal',
                    onSuccess: function () {
                        reloadTable();
                    },
                });
            }

            // Use shared CRUD helper for delete, but expose as deleteEmployee
            if (window.erpCrud) {
                window.erpCrud.handleDelete({
                    urlBuilder: function (id) {
                        return `{{ route('hr.employees.destroy', '') }}/${id}`;
                    },
                    onSuccess: function () {
                        reloadTable();
                    },
                });

                // Keep backwards-compatible function name used in Blade actions
                window.deleteEmployee = function (id, name) {
                    if (typeof window.erpDeleteRecord === 'function') {
                        window.erpDeleteRecord(id, name);
                    }
                };
            }
        });
        console.log('[Employees Index] Script loaded - version 2025-11-19-01');
    </script>
@endpush

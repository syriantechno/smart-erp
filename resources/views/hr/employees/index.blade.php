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

    {{-- Heading + top stats strip on the same row (Employees template matches Positions) --}}
    <div class="intro-y mt-6 mb-2 flex flex-col gap-1 text-[#3a2a1a]">
        <div class="flex items-baseline justify-between gap-6">
            <h2 class="flex items-center gap-2 text-2xl md:text-3xl font-semibold text-royalDark tracking-wide">
                <x-base.lucide icon="users" class="w-7 h-7" />
                <span>Employees Management</span>
            </h2>

            <div class="flex flex-row items-end gap-8 md:gap-12 justify-end">
                {{-- Inactive employees --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="pause-circle" class="w-4 h-4" />
                        </div>
                        <div id="stats-inactive" class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $employeesInactive ?? '—' }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Inactive
                    </div>
                </div>

                {{-- Active employees --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="check-circle-2" class="w-4 h-4" />
                        </div>
                        <div id="stats-active" class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $employeesActive ?? '—' }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Active
                    </div>
                </div>

                {{-- Total employees --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="users" class="w-4 h-4" />
                        </div>
                        <div id="stats-total" class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $employeesTotal ?? '—' }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Employees
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <x-base.preview-component class="intro-y box bg-white/80 border border-slate-200/70 shadow-[0_18px_45px_rgba(15,23,42,0.10)]">
                <div class="p-5">
                    {{-- Filters & Actions in One Row --}}
                    <div class="flex flex-wrap items-center gap-2 mb-4">
                        {{-- Search Input --}}
                        <div class="relative min-w-[180px]">
                            <x-base.lucide icon="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" />
                            <x-base.form-input 
                                id="employees-filter-value" 
                                type="text" 
                                placeholder="Search..." 
                                class="pl-9 w-full text-sm py-1.5"
                            />
                        </div>

                        {{-- Company Filter --}}
                        <x-base.form-select id="company-filter" class="w-auto text-sm py-1.5">
                            <option value="">All Companies</option>
                            @foreach($companies ?? [] as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </x-base.form-select>

                        {{-- Department Filter --}}
                        <x-base.form-select id="department-filter" class="w-auto text-sm py-1.5">
                            <option value="">All Depts</option>
                            @foreach($departments ?? [] as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </x-base.form-select>

                        {{-- Status Filter --}}
                        <x-base.form-select id="status-filter" class="w-auto text-sm py-1.5">
                            <option value="">Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </x-base.form-select>

                        {{-- Page Length --}}
                        <x-base.form-select id="employees-filter-length" class="w-auto text-sm py-1.5">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </x-base.form-select>

                        {{-- Reset Button --}}
                        <x-base.tippy as="button" id="employees-filter-reset" type="button" content="Reset filters" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                            <x-base.lucide icon="x" class="w-4 h-4" />
                        </x-base.tippy>

                        {{-- Spacer --}}
                        <div class="flex-1"></div>

                        {{-- Action Buttons --}}
                        <div class="flex items-center gap-1">
                            <x-base.tippy content="Print" placement="bottom">
                                <button type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2" title="Print">
                                    <x-base.lucide icon="printer" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Export PDF" placement="bottom">
                                <button id="employees-export-pdf" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2" title="Export PDF">
                                    <x-base.lucide icon="file-text" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Export Excel" placement="bottom">
                                <button id="employees-export" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2" title="Export Excel">
                                    <x-base.lucide icon="file-spreadsheet" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Import" placement="bottom">
                                <button id="employees-import" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2" title="Import">
                                    <x-base.lucide icon="upload-cloud" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>
                            <input type="file" id="employees-import-input" accept=".csv,text/csv" class="hidden" />
                            <x-base.tippy content="Refresh" placement="bottom">
                                <button id="employees-refresh" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2" title="Refresh">
                                    <x-base.lucide icon="refresh-cw" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>

                            {{-- Add Employee Button --}}
                            <x-base.tippy content="Add employee" placement="bottom">
                                <button
                                    type="button"
                                    class="btn-royal btn-royal--gold btn-royal--sm"
                                    data-tw-toggle="modal"
                                    data-tw-target="#create-employee-modal"
                                >
                                    <x-base.lucide icon="user-plus" class="w-4 h-4 mr-2 icon-hover-rise" />
                                    <span class="hidden sm:inline">Add</span>
                                </button>
                            </x-base.tippy>
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
            // Filter elements
            const filterValue = document.getElementById('employees-filter-value');
            const companyFilter = document.getElementById('company-filter');
            const departmentFilter = document.getElementById('department-filter');
            const statusFilter = document.getElementById('status-filter');
            const lengthSelect = document.getElementById('employees-filter-length');
            const filterResetBtn = document.getElementById('employees-filter-reset');
            const exportBtn = document.getElementById('employees-export');
            const exportPdfBtn = document.getElementById('employees-export-pdf');
            const refreshBtn = document.getElementById('employees-refresh');
            const importBtn = document.getElementById('employees-import');
            const importInput = document.getElementById('employees-import-input');

            const initialLength = lengthSelect ? parseInt(lengthSelect.value, 10) || 10 : 10;
            let searchTimeout = null;

            // Check if any filter is active
            function hasFilters() {
                return (filterValue && filterValue.value.trim() !== '') ||
                       (companyFilter && companyFilter.value !== '') ||
                       (departmentFilter && departmentFilter.value !== '') ||
                       (statusFilter && statusFilter.value !== '');
            }

            const table = (window.erpCrud && window.erpCrud.initDataTable) ? window.erpCrud.initDataTable({
                tableSelector: '#employees-table',
                ajaxUrl: '{{ route("hr.employees.datatable") }}',
                ajaxData: function (d) {
                    d.search_value = filterValue ? filterValue.value.trim() : '';
                    d.company_id = companyFilter ? companyFilter.value : '';
                    d.department_id = departmentFilter ? departmentFilter.value : '';
                    d.status = statusFilter ? statusFilter.value : '';
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

            // Stats elements
            const statsTotal = document.getElementById('stats-total');
            const statsActive = document.getElementById('stats-active');
            const statsInactive = document.getElementById('stats-inactive');

            // Update stats based on current filters
            function updateStats() {
                const params = new URLSearchParams();
                if (filterValue && filterValue.value.trim()) params.append('search_value', filterValue.value.trim());
                if (companyFilter && companyFilter.value) params.append('company_id', companyFilter.value);
                if (departmentFilter && departmentFilter.value) params.append('department_id', departmentFilter.value);
                // Don't include status filter for stats

                fetch('{{ route("hr.employees.stats") }}?' + params.toString(), {
                    credentials: 'same-origin',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (statsTotal) statsTotal.textContent = data.total;
                    if (statsActive) statsActive.textContent = data.active;
                    if (statsInactive) statsInactive.textContent = data.inactive;
                })
                .catch(() => {
                    // Keep existing values on error
                });
            }

            const reloadTable = function () {
                table.ajax.reload(null, false);
                updateStats();
            };

            // Search with debounce (auto-search as you type)
            if (filterValue) {
                filterValue.addEventListener('input', function () {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(reloadTable, 400);
                });
            }

            // Instant filter on dropdown change
            if (companyFilter) {
                companyFilter.addEventListener('change', function() {
                    // Load departments for selected company
                    loadDepartmentsForCompany(this.value);
                    reloadTable();
                });
            }

            if (departmentFilter) {
                departmentFilter.addEventListener('change', reloadTable);
            }

            if (statusFilter) {
                statusFilter.addEventListener('change', reloadTable);
            }

            if (lengthSelect) {
                lengthSelect.addEventListener('change', function () {
                    const newLength = parseInt(this.value, 10) || initialLength;
                    table.page.len(newLength).draw();
                });
            }

            // Reset all filters
            if (filterResetBtn) {
                filterResetBtn.addEventListener('click', function () {
                    if (filterValue) filterValue.value = '';
                    if (companyFilter) companyFilter.value = '';
                    if (departmentFilter) {
                        departmentFilter.value = '';
                        // Reload all departments
                        loadDepartmentsForCompany('');
                    }
                    if (statusFilter) statusFilter.value = '';
                    if (lengthSelect) {
                        lengthSelect.value = String(initialLength);
                        table.page.len(initialLength);
                    }
                    reloadTable();
                });
            }

            // Load departments based on company
            function loadDepartmentsForCompany(companyId) {
                if (!departmentFilter) return;

                departmentFilter.innerHTML = '<option value="">Loading...</option>';

                if (!companyId) {
                    departmentFilter.innerHTML = '<option value="">All Departments</option>';
                    const allDepartments = @json($departments ?? []);
                    allDepartments.forEach(function(dept) {
                        departmentFilter.innerHTML += '<option value="' + dept.id + '">' + (dept.name || '') + '</option>';
                    });
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
                .then(response => response.json())
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
                })
                .catch(() => {
                    departmentFilter.innerHTML = '<option value="">All Departments</option>';
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
                        'search_value': filterValue ? filterValue.value : '',
                        'company_id': companyFilter ? companyFilter.value : '',
                        'department_id': departmentFilter ? departmentFilter.value : '',
                        'status': statusFilter ? statusFilter.value : ''
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

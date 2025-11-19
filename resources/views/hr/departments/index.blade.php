@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Departments Management - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <style>
        /* Make table more compact with better readability */
        #departments-table {
            font-size: 0.95rem; /* 15px - slightly larger */
            line-height: 1.4;
        }

        #departments-table tbody tr {
            height: 2.25rem; /* 36px - more compact */
        }

        #departments-table th {
            font-size: 0.8rem; /* 13px - slightly larger headers */
            font-weight: 700;
            padding: 0.5rem 1.25rem; /* py-2 px-5 */
        }

        #departments-table td {
            padding: 0.375rem 1.25rem; /* py-1.5 px-5 - even more compact */
        }

        /* Status badges - compact and readable */
        #departments-table .inline-flex {
            padding: 0.125rem 0.5rem; /* 2px 8px */
            font-weight: 600;
        }

        /* Actions column - keep compact */
        #departments-table .px-5.py-1\.5 {
            padding: 0.375rem 1.25rem;
        }

        #departments-table thead th,
        #departments-table tbody td {
            text-align: center;
            font-size: 0.9rem;
        }

        #departments-table .datatable-cell-wrap {
            text-align: center;
        }

        #departments-table [class^="stats-card-"],
        #departments-table [class*=" stats-card-"] {
            font-size: 0.95rem;
            font-weight: 600;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .icon-hover-rise {
            transition: transform 200ms ease;
        }

        .group:hover .icon-hover-rise {
            transform: translateY(-2px);
        }
    </style>
@endpush

@section('subcontent')
    @include('components.global-notifications')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Departments Management</h2>
        <button
            type="button"
            class="btn-tonal btn-tonal--info w-40 sm:w-auto sm:ml-4 group"
            data-tw-toggle="modal"
            data-tw-target="#create-department-modal"
        >
            <x-base.lucide icon="plus-circle" class="w-5 h-5 icon-hover-rise" />
            Add Department
        </button>
    </div>

    <div class="intro-y mt-6">
        <div class="box border-primary/10 bg-primary/5 p-5">
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div>
                    <h3 class="text-base font-semibold text-slate-800 dark:text-slate-100">معاينة النمط الموحد للأزرار</h3>
                    <p class="text-sm text-slate-500">الأزرار التالية توضح درجات الألوان المتاحة؛ نعدّل الألوان أو الظلال حسب رغبتك قبل التعميم.</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <button type="button" class="btn-tonal btn-tonal--info group">
                        <x-base.lucide icon="plus-circle" class="w-5 h-5 icon-hover-rise" />
                        زر 1
                    </button>
                    <button type="button" class="btn-tonal btn-tonal--success group">
                        <x-base.lucide icon="save" class="w-5 h-5 icon-hover-rise" />
                        زر 2
                    </button>
                    <button type="button" class="btn-tonal btn-tonal--warning">زر 3</button>
                    <button type="button" class="btn-tonal btn-tonal--danger group">
                        <x-base.lucide icon="trash-2" class="w-5 h-5 icon-hover-rise" />
                        زر 4
                    </button>
                    <button type="button" class="btn-tonal btn-tonal--neutral group">
                        <x-base.lucide icon="x-circle" class="w-5 h-5 icon-hover-rise" />
                        زر 5
                    </button>
                </div>
                <div class="mt-3 flex flex-wrap gap-2">
                    <button type="button" class="btn-tonal btn-tonal--teal group">
                        <x-base.lucide icon="check-circle" class="w-5 h-5 icon-hover-rise" />
                        زر 6
                    </button>
                    <button type="button" class="btn-tonal btn-tonal--purple group">
                        <x-base.lucide icon="printer" class="w-5 h-5 icon-hover-rise" />
                        زر 7
                    </button>
                    <button type="button" class="btn-tonal btn-tonal--rose group">
                        <x-base.lucide icon="file-text" class="w-5 h-5 icon-hover-rise" />
                        زر 8
                    </button>
                </div>
                <div class="mt-3 flex flex-wrap gap-2">
                    <button type="button" class="btn-tonal btn-tonal--sky group">
                        <x-base.lucide icon="refresh-cw" class="w-5 h-5 icon-hover-rise" />
                        زر 9
                    </button>
                    <button type="button" class="btn-tonal btn-tonal--amber group">
                        <x-base.lucide icon="sun" class="w-5 h-5 icon-hover-rise" />
                        زر 10
                    </button>
                    <button type="button" class="btn-tonal btn-tonal--lime group">
                        <x-base.lucide icon="file-spreadsheet" class="w-5 h-5 icon-hover-rise" />
                        زر 11
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    @if (session('success'))
                        <x-base.alert class="mb-4" variant="success">
                            <div class="flex items-center">
                                <x-base.lucide icon="CheckCircle" class="w-5 h-5 mr-2" />
                                {{ session('success') }}
                            </div>
                        </x-base.alert>
                    @endif

                    @if (session('error'))
                        <x-base.alert class="mb-4" variant="danger">
                            <div class="flex items-center">
                                <x-base.lucide icon="AlertTriangle" class="w-5 h-5 mr-2" />
                                {{ session('error') }}
                            </div>
                        </x-base.alert>
                    @endif

                    <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                        <form id="departments-filter-form" class="w-full sm:mr-auto xl:flex">
                            <div class="items-center sm:mr-4 sm:flex">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Field
                                </label>
                                <x-base.form-select id="departments-filter-field" class="mt-2 w-full sm:mt-0 sm:w-auto 2xl:w-full">
                                    <option value="all">All Fields</option>
                                    <option value="name">Name</option>
                                    <option value="company">Company</option>
                                    <option value="manager">Manager</option>
                                    <option value="employees_count">Employees</option>
                                    <option value="status">Status</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Type
                                </label>
                                <x-base.form-select id="departments-filter-type" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                    <option value="contains">Contains</option>
                                    <option value="equals">Equals</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Value
                                </label>
                                <x-base.form-input id="departments-filter-value" type="text" placeholder="Search..." class="mt-2 w-full sm:mt-0 sm:w-48 2xl:w-full" />
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Show
                                </label>
                                <x-base.form-select id="departments-filter-length" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                    <option value="10">10</option>
                                    <option value="25" selected>25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-4 flex flex-wrap gap-2 sm:items-center xl:mt-0">
                                <button id="departments-filter-go" type="button" class="btn-tonal btn-tonal--info w-full sm:w-24 group">
                                    <x-base.lucide icon="search" class="w-4 h-4 icon-hover-rise" />
                                    Go
                                </button>
                                <button id="departments-filter-reset" type="button" class="btn-tonal btn-tonal--amber w-full sm:w-24 group">
                                    <x-base.lucide icon="rotate-ccw" class="w-4 h-4 icon-hover-rise" />
                                    Reset
                                </button>
                            </div>
                        </form>

                        <div class="mt-5 flex flex-wrap items-center gap-2 sm:mt-0 sm:flex-nowrap">
                            <button type="button" class="btn-tonal btn-tonal--purple btn-tonal--icon group" title="Print">
                                <x-base.lucide icon="printer" class="w-5 h-5 icon-hover-rise" />
                            </button>
                            <button type="button" class="btn-tonal btn-tonal--rose btn-tonal--icon group" title="Export PDF">
                                <x-base.lucide icon="file-text" class="w-5 h-5 icon-hover-rise" />
                            </button>
                            <button id="departments-export" type="button" class="btn-tonal btn-tonal--lime btn-tonal--icon group" title="Export to Excel">
                                <x-base.lucide icon="file-spreadsheet" class="w-5 h-5 icon-hover-rise" />
                            </button>
                            <button id="departments-refresh" type="button" class="btn-tonal btn-tonal--sky btn-tonal--icon group" title="Refresh">
                                <x-base.lucide icon="refresh-cw" class="w-5 h-5 icon-hover-rise" />
                            </button>
                        </div>
                    </div>

                    <div class="overflow-x-auto sm:overflow-visible" data-erp-table-wrapper>
                        <table id="departments-table" data-tw-merge data-erp-table class="datatable-default w-full min-w-full table-auto text-left text-sm">
                            <thead>
                                <tr>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">#</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Code</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Name</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Company</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Manager</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Employees</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Status</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

            </x-base.preview-component>
        </div>
    </div>

    @include('hr.departments.modals.create')
    @stack('modals')
@endsection
@include('components.datatable.scripts')

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const filterField = document.getElementById('departments-filter-field');
        const filterType = document.getElementById('departments-filter-type');
        const filterValue = document.getElementById('departments-filter-value');
        const lengthSelect = document.getElementById('departments-filter-length');
        const filterGoBtn = document.getElementById('departments-filter-go');
        const filterResetBtn = document.getElementById('departments-filter-reset');
        const exportBtn = document.getElementById('departments-export');
        const refreshBtn = document.getElementById('departments-refresh');
        const codeInput = document.getElementById('code');

        const initialLength = lengthSelect ? parseInt(lengthSelect.value, 10) || 25 : 25;

        const table = (window.erpCrud && window.erpCrud.initDataTable) ? window.erpCrud.initDataTable({
            tableSelector: '#departments-table',
            ajaxUrl: '{{ route("hr.departments.datatable") }}',
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
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    className: 'px-5 py-1.5 border-b dark:border-darkmode-300 whitespace-nowrap text-center font-medium',
                    title: '#'
                },
                {
                    data: 'code',
                    name: 'code',
                    className: 'px-5 py-1.5 border-b dark:border-darkmode-300 font-medium text-slate-700 whitespace-nowrap',
                    title: 'Code',
                    defaultContent: '-'
                },
                {
                    data: 'name',
                    name: 'name',
                    className: 'px-5 py-1.5 border-b dark:border-darkmode-300 font-medium text-slate-700 datatable-cell-wrap',
                    title: 'Name'
                },
                {
                    data: 'company',
                    name: 'company.name',
                    render: function (data) {
                        return data && data.name ? data.name : '-';
                    },
                    className: 'px-5 py-1.5 border-b dark:border-darkmode-300 datatable-cell-wrap',
                    title: 'Company'
                },
                {
                    data: 'manager',
                    name: 'manager.full_name',
                    render: function (data) {
                        return data && data.full_name ? data.full_name : '-';
                    },
                    className: 'px-5 py-1.5 border-b dark:border-darkmode-300 datatable-cell-wrap',
                    title: 'Manager'
                },
                {
                    data: 'employees_count',
                    name: 'employees_count',
                    className: 'px-5 py-1.5 border-b dark:border-darkmode-300 text-center whitespace-nowrap font-medium',
                    title: 'Employees'
                },
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
                    className: 'px-5 py-1.5 border-b dark:border-darkmode-300 text-center',
                    title: 'Actions',
                    orderable: false,
                    searchable: false
                }
            ]
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

        const reloadTable = function () {
            table.ajax.reload(null, false);
        };

        const refreshDepartmentCode = function () {
            if (!codeInput) {
                return;
            }

            fetch('{{ route("hr.departments.preview-code") }}')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to preview department code');
                    }

                    return response.json();
                })
                .then(data => {
                    codeInput.value = data.code || '';
                })
                .catch(error => {
                    console.error(error);
                    codeInput.value = '';
                });
        };

        refreshDepartmentCode();

        const closeModal = function (modalEl) {
            if (!modalEl) {
                return;
            }

            const dismissTrigger = modalEl.querySelector('[data-tw-dismiss="modal"]');
            if (dismissTrigger) {
                dismissTrigger.click();
            }
        };

        // Use shared CRUD helper for department create form
        if (window.erpCrud) {
            window.erpCrud.handleCreateForm({
                formSelector: '#create-department-form',
                modalSelector: '#create-department-modal',
                onSuccess: function () {
                    refreshDepartmentCode();
                    reloadTable();
                }
            });
        }

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
                    lengthSelect.value = String(25);
                    table.page.len(25).draw();
                }
                reloadTable();
            });
        }

        if (refreshBtn) {
            refreshBtn.addEventListener('click', reloadTable);
        }

        if (codeInput) {
            document.addEventListener('show.tw.modal', function (event) {
                if (event.target && event.target.id === 'create-department-modal') {
                    refreshDepartmentCode();
                }
            });
        }

        if (exportBtn) {
            exportBtn.addEventListener('click', function () {
                try {
                    const rows = table.rows({ search: 'applied' }).data().toArray();
                    if (!rows.length) {
                        showToast('No data available for export', 'error');
                        return;
                    }

                    const headers = ['#', 'Name', 'Company', 'Manager', 'Employees', 'Status'];
                    const csvRows = [headers.join(',')];

                    rows.forEach(function (row) {
                        const csvRow = [
                            row.DT_RowIndex,
                            '"' + (row.name || '').replace(/"/g, '""') + '"',
                            '"' + ((row.company && row.company.name) ? row.company.name : '').replace(/"/g, '""') + '"',
                            '"' + ((row.manager && row.manager.full_name) ? row.manager.full_name : '').replace(/"/g, '""') + '"',
                            row.employees_count ?? '',
                            row.is_active ? 'Active' : 'Inactive'
                        ];
                        csvRows.push(csvRow.join(','));
                    });

                    const blob = new Blob(['\ufeff' + csvRows.join('\n')], { type: 'text/csv;charset=utf-8;' });
                    const url = URL.createObjectURL(blob);
                    const link = document.createElement('a');
                    link.href = url;
                    link.download = 'departments_' + new Date().toISOString().split('T')[0] + '.csv';
                    link.click();
                    URL.revokeObjectURL(url);
                    showToast('Data exported successfully', 'success');
                } catch (error) {
                    console.error('Export error:', error);
                    showToast('Failed to export data', 'error');
                }
            });
        }

        document.addEventListener('hidden.tw.modal', function () {
            if (document.activeElement && typeof document.activeElement.blur === 'function') {
                document.activeElement.blur();
            }
            table.ajax.reload(null, false);
        });

        // Use shared CRUD helper for delete
        window.openDepartmentModal = function (id) {
            console.log('[Departments] openDepartmentModal triggered', { id });
            const modalEl = document.getElementById(`edit-department-modal-${id}`);

            if (!modalEl) {
                console.error('Department modal not found for id', id);
                return;
            }

            console.log('[Departments] Found modal element', modalEl);

            let modalInstance = null;
            if (window.tailwind?.Modal?.getOrCreateInstance) {
                modalInstance = window.tailwind.Modal.getOrCreateInstance(modalEl);
            } else if (window.tailwind?.Modal) {
                try {
                    modalInstance = new window.tailwind.Modal(modalEl);
                } catch (error) {
                    console.warn('Failed to instantiate tailwind.Modal, falling back to manual toggle.', error);
                }
            }

            if (modalInstance?.show) {
                console.log('[Departments] Showing modal via Tailwind instance');
                modalInstance.show();
                setTimeout(() => {
                    if (modalEl.classList.contains('hidden') || !modalEl.classList.contains('show')) {
                        console.warn('[Departments] Tailwind modal did not become visible, applying manual fallback');
                        modalEl.classList.remove('hidden');
                        modalEl.classList.add('show');
                        modalEl.style.display = 'flex';
                        modalEl.style.alignItems = 'center';
                        modalEl.style.justifyContent = 'center';
                    }
                }, 100);
                return;
            }

            console.warn('[Departments] Falling back to manual show');
            modalEl.classList.remove('hidden');
            modalEl.classList.add('show');
            modalEl.style.display = 'flex';
            modalEl.style.alignItems = 'center';
            modalEl.style.justifyContent = 'center';
        };

        if (window.erpCrud) {
            window.erpCrud.handleDelete({
                urlBuilder: function (id) {
                    return `{{ route('hr.departments.destroy', '') }}/${id}`;
                },
                onSuccess: function () {
                    reloadTable();
                }
            });

            window.deleteDepartment = function (id, name) {
                if (typeof window.erpDeleteRecord === 'function') {
                    window.erpDeleteRecord(id, name);
                }
            };
        }
    });
    </script>
@endpush

@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Departments Management - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Departments Management</h2>
        <x-base.button
            variant="primary"
            class="w-40 sm:w-auto sm:ml-4"
            data-tw-toggle="modal"
            data-tw-target="#create-department-modal"
        >
            <x-base.lucide icon="Plus" class="w-4 h-4 mr-2" />
            Add Department
        </x-base.button>
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
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 xl:mt-0">
                                <x-base.button id="departments-filter-go" type="button" variant="primary" class="w-full sm:w-16">
                                    Go
                                </x-base.button>
                                <x-base.button id="departments-filter-reset" type="button" variant="secondary" class="mt-2 w-full sm:ml-1 sm:mt-0 sm:w-16">
                                    Reset
                                </x-base.button>
                            </div>
                        </form>

                        <div class="mt-5 flex sm:mt-0">
                            <x-base.button id="departments-export" variant="outline-secondary" class="mr-2 w-1/2 sm:w-auto">
                                <x-base.lucide icon="Download" class="mr-2 h-4 w-4" /> Export
                            </x-base.button>
                            <x-base.button id="departments-refresh" variant="outline-secondary" class="w-1/2 sm:w-auto">
                                <x-base.lucide icon="RefreshCcw" class="mr-2 h-4 w-4" /> Refresh
                            </x-base.button>
                        </div>
                    </div>

                    <div class="overflow-x-auto sm:overflow-visible" data-erp-table-wrapper>
                        <table id="departments-table" data-tw-merge data-erp-table class="datatable-default w-full min-w-full table-auto text-left text-sm">
                            <thead>
                                <tr>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">#</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Code</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Name</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Company</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Manager</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Employees</th>
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

    @include('hr.departments.modals.create')
    @stack('modals')
@endsection
@include('components.datatable.scripts')

@push('scripts')
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

        const initialLength = lengthSelect ? parseInt(lengthSelect.value, 10) || 10 : 10;

        const table = window.initDataTable('#departments-table', {
            ajax: {
                url: @json(route('hr.departments.datatable')),
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
                    d.page_length = lengthSelect ? parseInt(lengthSelect.value, 10) || initialLength : initialLength;
                },
                error: function (xhr, textStatus, error) {
                    console.error('DataTables AJAX error:', textStatus, error, xhr.responseText);
                }
            },
            pageLength: initialLength,
            lengthChange: false,
            searching: false,
            dom:
                "t<'datatable-footer flex flex-col md:flex-row md:items-center md:justify-between mt-5 gap-4'<'datatable-info text-slate-500'i><'datatable-pagination'p>>",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center font-medium' },
                { data: 'code', name: 'code', className: 'px-5 py-3 border-b dark:border-darkmode-300 font-medium text-slate-700 whitespace-nowrap' },
                { data: 'name', name: 'name', className: 'px-5 py-3 border-b dark:border-darkmode-300 font-medium text-slate-700 datatable-cell-wrap' },
                {
                    data: 'company',

                    render: function (data) {
                        return data && data.name ? data.name : '-';
                    },
                    className: 'px-5 py-3 border-b dark:border-darkmode-300 datatable-cell-wrap'
                },
                {
                    data: 'manager',
                    name: 'manager.full_name',
                    render: function (data) {
                        return data && data.full_name ? data.full_name : '-';
                    },
                    className: 'px-5 py-3 border-b dark:border-darkmode-300 datatable-cell-wrap'
                },
                { data: 'employees_count', name: 'employees_count', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center whitespace-nowrap font-medium' },
                {
                    data: 'is_active',
                    name: 'is_active',
                    className: 'text-center',
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
            drawCallback: function () {
                if (typeof window.Lucide !== 'undefined') {
                    window.Lucide.createIcons();
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

        const refreshDepartmentCode = function () {
            if (!codeInput) {
                return;
            }

            fetch(@json(route('hr.departments.preview-code')))
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
                        showToast('No data available for export.', 'error');
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

                    const blob = new Blob([csvRows.join('\n')], { type: 'text/csv;charset=utf-8;' });
                    const url = URL.createObjectURL(blob);
                    const link = document.createElement('a');
                    link.href = url;
                    link.download = 'departments.csv';
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

        window.deleteDepartment = function (id, name) {
            if (!confirm(`Are you sure you want to delete the department "${name}"?`)) {
                return;
            }

            fetch(`{{ route('hr.departments.destroy', '') }}/${id}`, {
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
                        showToast(data.message || 'Department deleted successfully', 'success');
                    } else {
                        showToast(data.message || 'Failed to delete department', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('An error occurred while deleting the department', 'error');
                });
        };
    });
    </script>
@endpush

@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Shift Management - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Shift Management</h2>
        <x-base.button
            variant="primary"
            class="w-40 sm:w-auto sm:ml-4"
            data-tw-toggle="modal"
            data-tw-target="#create-shift-modal"
        >
            <x-base.lucide icon="Plus" class="w-4 h-4 mr-2" />
            Add Shift
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
                        <form id="shifts-filter-form" class="w-full sm:mr-auto xl:flex">
                            <div class="items-center sm:mr-4 sm:flex">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Field
                                </label>
                                <x-base.form-select id="shifts-filter-field" class="mt-2 w-full sm:mt-0 sm:w-auto 2xl:w-full">
                                    <option value="all">All Fields</option>
                                    <option value="code">Code</option>
                                    <option value="name">Name</option>
                                    <option value="company">Company</option>
                                    <option value="status">Status</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Type
                                </label>
                                <x-base.form-select id="shifts-filter-type" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                    <option value="contains">Contains</option>
                                    <option value="equals">Equals</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Value
                                </label>
                                <x-base.form-input id="shifts-filter-value" type="text" placeholder="Search..." class="mt-2 w-full sm:mt-0 sm:w-48 2xl:w-full" />
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Display
                                </label>
                                <x-base.form-select id="shifts-filter-length" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 xl:mt-0">
                                <x-base.button id="shifts-filter-go" type="button" variant="primary" class="w-full sm:w-16">
                                    Search
                                </x-base.button>
                                <x-base.button id="shifts-filter-reset" type="button" variant="secondary" class="mt-2 w-full sm:ml-1 sm:mt-0 sm:w-16">
                                    Reset
                                </x-base.button>
                            </div>
                        </form>

                        <div class="mt-5 flex sm:mt-0">
                            <x-base.button id="shifts-export" variant="primary" class="mr-2 w-1/2 sm:w-auto">
                                <x-base.lucide icon="Download" class="mr-2 h-4 w-4" /> Export
                            </x-base.button>
                            <x-base.button id="shifts-refresh" variant="primary" class="mr-2 w-1/2 sm:w-auto">
                                <x-base.lucide icon="RefreshCcw" class="mr-2 h-4 w-4" /> Refresh
                            </x-base.button>
                        </div>
                    </div>

                    <div class="overflow-x-auto sm:overflow-visible" data-erp-table-wrapper>
                        <table id="shifts-table" data-tw-merge data-erp-table class="datatable-default w-full min-w-full table-auto text-left text-sm">
                            <thead>
                                <tr>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">#</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Code</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Name</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Working Hours</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Color</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Apply To</th>
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

    @include('hr.shifts.modals.create')
    @stack('shift-modals')
@endsection

@push('scripts')
    <script>
    // Silence console output ONLY within this script scope
    const console = {
        log: () => {},
        error: () => {},
        warn: () => {},
        info: () => {},
        debug: () => {},
    };

    document.addEventListener('DOMContentLoaded', function () {
        const filterField = document.getElementById('shifts-filter-field');
        const filterType = document.getElementById('shifts-filter-type');
        const filterValue = document.getElementById('shifts-filter-value');
        const lengthSelect = document.getElementById('shifts-filter-length');
        const filterGoBtn = document.getElementById('shifts-filter-go');
        const filterResetBtn = document.getElementById('shifts-filter-reset');
        const exportBtn = document.getElementById('shifts-export');
        const refreshBtn = document.getElementById('shifts-refresh');

        const initialLength = lengthSelect ? parseInt(lengthSelect.value, 10) || 10 : 10;
        let tableInstance = null;

        function setupDataTable() {
            const $ = window.jQuery;
            if (!$ || typeof $.fn === 'undefined' || typeof $.fn.DataTable === 'undefined') {
                setTimeout(setupDataTable, 100);
                return;
            }

            tableInstance = $('#shifts-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("hr.shifts.datatable") }}',
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
                    { data: 'name', name: 'name', className: 'px-5 py-3 border-b dark:border-darkmode-300 font-medium text-slate-700' },
                    { data: 'formatted_time', name: 'formatted_time', className: 'px-5 py-3 border-b dark:border-darkmode-300 whitespace-nowrap' },
                    {
                        data: 'color',
                        name: 'color',
                        className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center',
                        render: function (data) {
                            return '<div class="flex items-center justify-center"><div class="w-6 h-6 rounded-full border-2 border-gray-300" style="background-color: ' + data + '"></div></div>';
                        }
                    },
                    { data: 'applicable_text', name: 'applicable_text', className: 'px-5 py-3 border-b dark:border-darkmode-300' },
                    {
                        data: 'is_active',
                        name: 'is_active',
                        className: 'text-center',
                        render: function (value) {
                            var status = Boolean(value);
                            var badgeClass = status ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700';
                            var label = status ? 'Active' : 'Inactive';
                            return '<span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ' + badgeClass + '">' + label + '</span>';
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

            bindTableEvents();
        }

        function bindTableEvents() {
            if (!tableInstance) {
                return;
            }

            if (lengthSelect) {
                lengthSelect.addEventListener('change', function () {
                    const newLength = parseInt(this.value, 10) || initialLength;
                    tableInstance.page.len(newLength).draw();
                });
            }

            const reloadTable = function () {
                tableInstance.ajax.reload(null, false);
            };

            window.reloadTable = reloadTable;

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
                    }
                    // After reset, fully reload the page to ensure actions column and icons are restored correctly
                    window.location.reload();
                });
            }

            if (refreshBtn) {
                refreshBtn.addEventListener('click', reloadTable);
            }

            if (exportBtn) {
                exportBtn.addEventListener('click', function () {
                    try {
                        const rows = tableInstance.rows({ search: 'applied' }).data().toArray();
                        if (!rows.length) {
                            showToast('No data to export', 'error');
                            return;
                        }

                        const headers = ['#', 'Code', 'Name', 'Working Hours', 'Color', 'Apply To', 'Status'];
                        const csvRows = [headers.join(',')];

                        rows.forEach(function (row) {
                            const csvRow = [
                                row.DT_RowIndex,
                                '"' + (row.code || '').replace(/"/g, '""') + '"',
                                '"' + (row.name || '').replace(/"/g, '""') + '"',
                                '"' + (row.formatted_time || '').replace(/"/g, '""') + '"',
                                row.color || '',
                                '"' + (row.applicable_text || '').replace(/"/g, '""') + '"',
                                row.is_active ? 'Active' : 'Inactive'
                            ];
                            csvRows.push(csvRow.join(','));
                        });

                        const blob = new Blob(['\ufeff' + csvRows.join('\n')], { type: 'text/csv;charset=utf-8;' });
                        const link = document.createElement('a');
                        link.href = URL.createObjectURL(blob);
                        link.download = `shifts_${new Date().toISOString().split('T')[0]}.csv`;
                        link.click();
                        URL.revokeObjectURL(link);

                        showToast('Data exported successfully', 'success');
                    } catch (error) {
                        showToast('Failed to export data', 'error');
                    }
                });
            }
        }

        setupDataTable();
    });

    window.deleteShift = function (id, name) {
        if (!confirm(`Are you sure you want to delete the shift "${name}"?`)) {
            return;
        }

        fetch(`{{ route('hr.shifts.destroy', '') }}/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            credentials: 'same-origin',
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (window.reloadTable) {
                        window.reloadTable();
                    } else {
                        location.reload();
                    }
                    showToast(data.message || 'Shift deleted successfully', 'success');
                } else {
                    showToast(data.message || 'Failed to delete shift', 'error');
                }
            })
            .catch(() => {
                showToast('An error occurred while deleting', 'error');
            });
    };

    window.toggleShiftStatus = function (id) {
        fetch(`{{ route('hr.shifts.toggle-status', '') }}/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            credentials: 'same-origin',
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (window.reloadTable) {
                        window.reloadTable();
                    } else {
                        location.reload();
                    }
                    showToast(data.message, 'success');
                } else {
                    showToast(data.message || 'Failed to update shift status', 'error');
                }
            })
            .catch(() => {
                showToast('An error occurred while updating', 'error');
            });
    };
    </script>
@endpush

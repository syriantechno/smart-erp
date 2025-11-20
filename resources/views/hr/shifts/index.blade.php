@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Shift Management - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Shift Management</h2>
        <button
            type="button"
            class="btn-tonal btn-tonal--info w-40 sm:w-auto sm:ml-4 group"
            data-tw-toggle="modal"
            data-tw-target="#create-shift-modal"
        >
            <x-base.lucide icon="plus-circle" class="w-5 h-5 icon-hover-rise" />
            Add Shift
        </button>
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
                            <div class="mt-4 flex flex-wrap gap-2 sm:items-center xl:mt-0">
                                <button id="shifts-filter-go" type="button" class="btn-tonal btn-tonal--info w-full sm:w-24 group">
                                    <x-base.lucide icon="search" class="w-4 h-4 icon-hover-rise" />
                                    Go
                                </button>
                                <button id="shifts-filter-reset" type="button" class="btn-tonal btn-tonal--amber w-full sm:w-24 group">
                                    <x-base.lucide icon="rotate-ccw" class="w-4 h-4 icon-hover-rise" />
                                    Reset
                                </button>
                            </div>
                        </form>

                        <div class="mt-5 flex flex-wrap items-center gap-2 sm:mt-0 sm:flex-nowrap">
                            <button type="button" class="btn-tonal btn-tonal--purple btn-tonal--icon group" title="Print">
                                <x-base.lucide icon="printer" class="w-5 h-5 icon-hover-rise" />
                            </button>
                            <button id="shifts-export" type="button" class="btn-tonal btn-tonal--lime btn-tonal--icon group" title="Export">
                                <x-base.lucide icon="file-spreadsheet" class="w-5 h-5 icon-hover-rise" />
                            </button>
                            <button id="shifts-refresh" type="button" class="btn-tonal btn-tonal--sky btn-tonal--icon group" title="Refresh">
                                <x-base.lucide icon="refresh-cw" class="w-5 h-5 icon-hover-rise" />
                            </button>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>
    <script>
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

        const table = window.erpCrud.initDataTable({
            tableSelector: '#shifts-table',
            ajaxUrl: '{{ route("hr.shifts.datatable") }}',
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
            },
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
            pageLength: initialLength
        });

        if (!table) return;

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
                if (filterField) filterField.value = 'all';
                if (filterType) filterType.value = 'contains';
                if (filterValue) filterValue.value = '';
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

        if (exportBtn) {
            exportBtn.addEventListener('click', function () {
                try {
                    const rows = table.rows({ search: 'applied' }).data().toArray();
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

        window.erpCrud.handleDelete({
            urlBuilder: function(id) {
                return `{{ route('hr.shifts.destroy', '') }}/${id}`;
            },
            onSuccess: function() {
                reloadTable();
            }
        });
    });

    window.deleteShift = function(id, name) {
        window.erpDeleteRecord(id, name);
    };

    // Simple view handler for now - can be extended to open a modal later
    window.viewShift = function (id) {
        showToast('View shift #' + id + ' (view details modal not implemented yet)', 'info');
    };

    // Simple edit handler for now - can be extended to open an edit modal
    window.editShift = function (id) {
        showToast('Edit shift #' + id + ' (edit modal not implemented yet)', 'info');
    };

    window.toggleShiftStatus = function (id) {
        const baseUrl = '{{ rtrim(route('hr.shifts.toggle-status', ['shift' => '__ID__']), '__ID__') }}';
        fetch(baseUrl + id, {
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
                    window.location.reload();
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

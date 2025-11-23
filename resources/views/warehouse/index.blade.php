@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Warehouses Management - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <style>
        /* Match general compact table style used in HR modules */
        #warehouses-table {
            font-size: 0.95rem;
            line-height: 1.4;
        }

        #warehouses-table tbody tr {
            height: 2.25rem;
        }

        #warehouses-table th {
            font-size: 0.8rem;
            font-weight: 700;
            padding: 0.5rem 1.25rem;
        }

        #warehouses-table td {
            padding: 0.375rem 1.25rem;
        }

        #warehouses-table .inline-flex {
            padding: 0.125rem 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
        }

        #warehouses-table .px-5.py-1\.5 {
            padding: 0.375rem 1.25rem;
        }
    </style>
@endpush

@section('subcontent')
    @include('components.global-notifications')

    {{-- Heading + top stats strip on the same row (Departments template matches Positions) --}}
    <div class="intro-y mt-6 mb-2 flex flex-col gap-1 text-[#3a2a1a]">
        <div class="flex items-baseline justify-between gap-6">
            <h2 class="flex items-center gap-2 text-2xl md:text-3xl font-semibold text-royalDark tracking-wide">
                <x-base.lucide icon="warehouse" class="w-7 h-7" />
                <span>Warehouses Management</span>
            </h2>

            <div class="flex flex-row items-end gap-8 md:gap-12 justify-end">
                {{-- Inactive warehouses --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="pause-circle" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $inactiveWarehouses ?? '—' }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Inactive
                    </div>
                </div>

                {{-- Active warehouses --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="check-circle-2" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $activeWarehouses ?? '—' }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Active
                    </div>
                </div>

                {{-- Total warehouses --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="warehouse" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $totalWarehouses ?? '—' }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Warehouses
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <x-base.preview-component class="intro-y box bg-white/80 border border-slate-200/70 shadow-[0_18px_45px_rgba(15,23,42,0.10)]">
                <div class="p-5">
                    <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                        <form id="warehouses-filter-form" class="w-full sm:mr-auto xl:flex">
                            <div class="items-center sm:mr-4 sm:flex">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Status
                                </label>
                                <x-base.form-select id="warehouses-status-filter" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                    <option value="">All Status</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Search
                                </label>
                                <x-base.form-input
                                    id="warehouses-search-filter"
                                    type="text"
                                    placeholder="Search..."
                                    class="mt-2 w-full sm:mt-0 sm:w-48 2xl:w-full"
                                />
                            </div>
                            <div class="mt-4 flex flex-wrap gap-2 sm:items-center xl:mt-0">
                                <button id="warehouses-filter-go" type="button" class="btn-royal btn-royal--dark btn-royal--sm w-full sm:w-24 group">
                                    <x-base.lucide icon="search" class="w-4 h-4 icon-hover-rise" />
                                    Go
                                </button>
                                <button id="warehouses-filter-reset" type="button" class="btn-royal btn-royal--outline btn-royal--sm w-full sm:w-24 group">
                                    <x-base.lucide icon="rotate-ccw" class="w-4 h-4 icon-hover-rise" />
                                    Reset
                                </button>
                            </div>
                        </form>

                        <div class="mt-5 flex flex-wrap items-center gap-2 sm:mt-0 sm:flex-nowrap">
                            <x-base.tippy content="Export PDF" placement="bottom">
                                <button id="warehouses-pdf" type="button" class="btn-royal btn-royal--outline btn-royal--sm btn-tonal--icon group text-royalDark">
                                    <x-base.lucide icon="file-text" class="w-5 h-5 icon-hover-rise" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Export" placement="bottom">
                                <button id="warehouses-export" type="button" class="btn-royal btn-royal--outline btn-royal--sm btn-tonal--icon group text-royalDark">
                                    <x-base.lucide icon="file-spreadsheet" class="w-5 h-5 icon-hover-rise" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Refresh" placement="bottom">
                                <button id="warehouses-refresh" type="button" class="btn-royal btn-royal--outline btn-royal--sm btn-tonal--icon group text-royalDark">
                                    <x-base.lucide icon="refresh-cw" class="w-5 h-5 icon-hover-rise" />
                                </button>
                            </x-base.tippy>

                            {{-- Add Warehouse button at the right end of the toolbar --}}
                            <x-base.tippy content="Add new warehouse" placement="bottom">
                                <button
                                    type="button"
                                    class="btn-royal btn-royal--gold btn-royal--sm sm:btn-royal--lg group"
                                    data-tw-toggle="modal"
                                    data-tw-target="#create-warehouse-modal"
                                >
                                    <x-base.lucide icon="plus-circle" class="w-5 h-5 icon-hover-rise" />
                                    <span class="hidden sm:inline">Add</span>
                                </button>
                            </x-base.tippy>
                        </div>
                    </div>

                    <div class="overflow-x-auto sm:overflow-visible" data-erp-table-wrapper>
                        <table
                            id="warehouses-table"
                            data-tw-merge
                            data-erp-table
                            class="datatable-default w-full min-w-full table-auto text-left text-sm"
                        >
                            <thead class="bg-gradient-to-r from-royalDark to-gray-800 text-white">
                                <tr>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Code</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Name</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Location</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Status</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </x-base.preview-component>
        </div>
    </div>

    @include('warehouse.modals.create')
    @include('warehouse.modals.edit')
    @stack('modals')
@endsection

@include('components.datatable.scripts')

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>

    <script>
        let warehousesTable;

        document.addEventListener('DOMContentLoaded', function () {
            const jq = window.jQuery || window.$;

            if (!jq || typeof jq.fn === 'undefined' || typeof jq.fn.DataTable === 'undefined') {
                console.error('DataTables is not loaded; warehouses table will not be initialised.');
                return;
            }

            initializeWarehousesDataTable();
            setupWarehousesEventListeners();
        });

        function initializeWarehousesDataTable() {
            warehousesTable = window.erpCrud.initDataTable({
                tableSelector: '#warehouses-table',
                ajaxUrl: '{{ route("warehouse.warehouses.datatable") }}',
                ajaxData: function (d) {
                    const statusEl = document.getElementById('warehouses-status-filter');
                    const searchEl = document.getElementById('warehouses-search-filter');

                    d.status = statusEl ? statusEl.value : '';
                    d.filter_value = searchEl ? searchEl.value : '';
                    d.filter_field = 'all';
                    d.filter_type = 'contains';
                },
                columns: [
                    { data: 'code', name: 'code' },
                    { data: 'name', name: 'name' },
                    { data: 'location', name: 'location' },
                    { data: 'status_badge', name: 'status_badge', orderable: false, searchable: false },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ],
                pageLength: 25
            });

            window.warehousesTable = warehousesTable;

            if (!warehousesTable) {
                return;
            }

            warehousesTable.on('draw', function () {
                if (typeof window.lucide !== 'undefined' && window.lucide.createIcons) {
                    window.lucide.createIcons();
                }
            });
        }

        function setupWarehousesEventListeners() {
            const jq = window.jQuery || window.$;
            if (!jq) {
                return;
            }

            const pdfBtn = jq('#warehouses-pdf');
            const exportBtn = jq('#warehouses-export');
            const refreshBtn = jq('#warehouses-refresh');

            jq('#warehouses-search-filter').on('keypress', function (e) {
                if (e.which === 13) {
                    applyWarehousesFilters();
                }
            });

            jq('#warehouses-status-filter').on('change', function () {
                applyWarehousesFilters();
            });

            if (pdfBtn.length) {
                pdfBtn.on('click', function () {
                    showToast('PDF export functionality not implemented yet', 'info');
                });
            }

            if (exportBtn.length) {
                exportBtn.on('click', function () {
                    if (window.erpCrud && typeof window.erpCrud.exportDataTable === 'function') {
                        window.erpCrud.exportDataTable(warehousesTable, 'warehouses');
                    } else {
                        showToast('Export functionality not available', 'error');
                    }
                });
            }

            if (refreshBtn.length) {
                refreshBtn.on('click', function () {
                    if (warehousesTable) {
                        warehousesTable.ajax.reload();
                        showToast('Data refreshed', 'success');
                    }
                });
            }
        }

        function applyWarehousesFilters() {
            if (warehousesTable) {
                warehousesTable.ajax.reload();
            }
            updateWarehousesActiveFiltersIndicator();
        }

        function clearWarehousesFilters() {
            const jq = window.jQuery || window.$;
            if (!jq) {
                return;
            }

            jq('#warehouses-status-filter').val('');
            jq('#warehouses-search-filter').val('');
            if (warehousesTable) {
                warehousesTable.ajax.reload();
            }
            updateWarehousesActiveFiltersIndicator();
            showToast('Filters reset', 'success');
        }

        function updateWarehousesActiveFiltersIndicator() {
            const jq = window.jQuery || window.$;
            if (!jq) {
                return;
            }

            const hasActiveFilters = jq('#warehouses-status-filter').val() || jq('#warehouses-search-filter').val();
            jq('#warehouses-active-filters-indicator').toggleClass('hidden', !hasActiveFilters);
        }

        window.editWarehouse = function(id) {
            const jq = window.jQuery || window.$;
            if (!jq) {
                return;
            }

            jq.get('{{ route("warehouse.warehouses.show", ":id") }}'.replace(':id', id))
                .done(function(response) {
                    if (response.success) {
                        if (typeof window.populateEditWarehouseModal === 'function') {
                            window.populateEditWarehouseModal(response.warehouse);
                        }
                        jq('#edit-warehouse-modal').modal('show');
                    }
                });
        };

        window.deleteWarehouse = function(id, name) {
            const jq = window.jQuery || window.$;
            if (!jq) {
                return;
            }

            if (typeof window.confirmDelete === 'function') {
                window.confirmDelete(name, function() {
                    jq.ajax({
                        url: '{{ route("warehouse.warehouses.destroy", ":id") }}'.replace(':id', id),
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").getAttribute('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                if (warehousesTable) {
                                    warehousesTable.ajax.reload();
                                }
                                if (typeof window.showSuccess === 'function') {
                                    window.showSuccess(response.message || 'Warehouse deleted successfully');
                                }
                            } else if (typeof window.showError === 'function') {
                                window.showError(response.message || 'Failed to delete warehouse.');
                            }
                        },
                        error: function() {
                            if (typeof window.showError === 'function') {
                                window.showError('Failed to delete warehouse.');
                            }
                        }
                    });
                });
            } else {
                if (window.confirm(`Delete warehouse "${name}"?`)) {
                    jq.ajax({
                        url: '{{ route("warehouse.warehouses.destroy", ":id") }}'.replace(':id', id),
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").getAttribute('content')
                        },
                        success: function(response) {
                            if (response.success && warehousesTable) {
                                warehousesTable.ajax.reload();
                            }
                        }
                    });
                }
            }
        };
    </script>
@endpush

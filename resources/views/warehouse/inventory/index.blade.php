@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Inventory Management - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">
@endpush

@section('subcontent')
    @include('components.global-notifications')

    <div class="intro-y mt-6 mb-2 flex flex-col gap-1 text-[#3a2a1a]">
        <div class="flex items-baseline justify-between gap-6">
            <h2 class="flex items-center gap-2 text-2xl md:text-3xl font-semibold text-royalDark tracking-wide">
                <x-base.lucide icon="boxes" class="w-7 h-7" />
                <span>Inventory Management</span>
            </h2>

            <div class="flex flex-row items-end gap-8 md:gap-12 justify-end">
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="box" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $inventoryTotal ?? '—' }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Entries
                    </div>
                </div>

                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="package" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $distinctMaterials ?? '—' }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Materials
                    </div>
                </div>

                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="warehouse" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $distinctWarehouses ?? '—' }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Warehouses
                    </div>
                </div>

                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="dollar-sign" class="w-4 h-4" />
                        </div>
                        <div class="text-3xl md:text-4xl font-semibold tracking-tight">
                            {{ number_format($totalInventoryValue ?? 0, 2) }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Total Value
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <x-base.preview-component class="intro-y box bg-white/80 border border-slate-200/70 shadow-[0_18px_45px_rgba(15,23,42,0.10)]">
                <div class="p-5">
                    <div class="flex flex-wrap items-center gap-2 mb-4">
                        <x-base.form-select id="inventory-warehouse-filter" class="w-auto text-sm py-1.5">
                            <option value="">All Warehouses</option>
                            @foreach($warehouses ?? [] as $warehouse)
                                <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                            @endforeach
                        </x-base.form-select>

                        <x-base.form-select id="inventory-material-filter" class="w-auto text-sm py-1.5">
                            <option value="">All Materials</option>
                            @foreach($materials ?? [] as $material)
                                <option value="{{ $material->id }}">{{ $material->name }}</option>
                            @endforeach
                        </x-base.form-select>

                        <x-base.tippy as="button" id="inventory-filter-reset" type="button" content="Reset filters" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                            <x-base.lucide icon="x" class="w-4 h-4" />
                        </x-base.tippy>

                        <div class="flex-1"></div>

                        <div class="flex items-center gap-1">
                            <x-base.tippy content="Print" placement="bottom">
                                <button id="inventory-print" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="printer" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Export PDF" placement="bottom">
                                <button id="inventory-pdf" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="file-text" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Export Excel" placement="bottom">
                                <button id="inventory-export" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="file-spreadsheet" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Refresh" placement="bottom">
                                <button id="inventory-refresh" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="refresh-cw" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>
                        </div>
                    </div>

                    <div class="overflow-x-auto sm:overflow-visible" data-erp-table-wrapper>
                        <table
                            id="inventory-table"
                            data-tw-merge
                            data-erp-table
                            class="datatable-default w-full min-w-full table-auto text-left text-sm"
                        >
                            <thead>
                                <tr>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Warehouse</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Material</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Unit</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-right">Quantity</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-right">Unit Price</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-right">Total Value</th>
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

    <form id="inventory-export-pdf-form" action="{{ route('warehouse.inventory.export-pdf') }}" method="POST" target="_blank" class="hidden">
        @csrf
    </form>
    <form id="inventory-export-excel-form" action="{{ route('warehouse.inventory.export-excel') }}" method="GET" target="_blank" class="hidden"></form>

    @include('warehouse.inventory.modals.edit')
@endsection

@include('components.datatable.scripts')

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>

    <script>
        let inventoryTable;

        document.addEventListener('DOMContentLoaded', function () {
            const jq = window.jQuery || window.$;

            if (!jq || typeof jq.fn === 'undefined' || typeof jq.fn.DataTable === 'undefined') {
                console.error('DataTables is not loaded; inventory table will not be initialised.');
                return;
            }

            initializeInventoryDataTable();
            setupInventoryEventListeners();
        });

        function initializeInventoryDataTable() {
            inventoryTable = window.erpCrud.initDataTable({
                tableSelector: '#inventory-table',
                ajaxUrl: '{{ route("warehouse.inventory.datatable") }}',
                ajaxData: function (d) {
                    const warehouseEl = document.getElementById('inventory-warehouse-filter');
                    const materialEl = document.getElementById('inventory-material-filter');

                    d.warehouse_id = warehouseEl ? warehouseEl.value : '';
                    d.material_id = materialEl ? materialEl.value : '';
                },
                columns: [
                    { data: 'warehouse_name', name: 'warehouse_name' },
                    { data: 'material_name', name: 'material_name' },
                    { data: 'unit', name: 'unit' },
                    { data: 'quantity', name: 'quantity', className: 'text-right' },
                    { data: 'unit_price', name: 'unit_price', className: 'text-right' },
                    { data: 'total_value', name: 'total_value', className: 'text-right', orderable: false },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'text-center' }
                ],
                pageLength: 25,
            });

            window.inventoryTable = inventoryTable;
        }

        function setupInventoryEventListeners() {
            const jq = window.jQuery || window.$;
            if (!jq) {
                return;
            }

            jq('#inventory-warehouse-filter, #inventory-material-filter').on('change', function () {
                applyInventoryFilters();
            });

            jq('#inventory-filter-reset').on('click', function () {
                clearInventoryFilters();
            });

            const refreshBtn = jq('#inventory-refresh');
            const pdfBtn = jq('#inventory-pdf');
            const exportBtn = jq('#inventory-export');
            const printBtn = jq('#inventory-print');
            if (refreshBtn.length) {
                refreshBtn.on('click', function () {
                    if (inventoryTable) {
                        inventoryTable.ajax.reload();
                        if (typeof window.showToast === 'function') {
                            window.showToast('Data refreshed', 'success');
                        }
                    }
                });
            }

            if (pdfBtn.length) {
                pdfBtn.on('click', function () {
                    const form = document.getElementById('inventory-export-pdf-form');
                    if (form) form.submit();
                });
            }

            if (exportBtn.length) {
                exportBtn.on('click', function () {
                    const form = document.getElementById('inventory-export-excel-form');
                    if (form) form.submit();
                });
            }

            if (printBtn.length) {
                printBtn.on('click', function () {
                    window.print();
                });
            }
        }

        function applyInventoryFilters() {
            if (inventoryTable) {
                inventoryTable.ajax.reload();
            }
        }

        function clearInventoryFilters() {
            const jq = window.jQuery || window.$;
            if (!jq) {
                return;
            }

            jq('#inventory-warehouse-filter').val('');
            jq('#inventory-material-filter').val('');

            if (inventoryTable) {
                inventoryTable.ajax.reload();
            }
        }
    </script>
@endpush

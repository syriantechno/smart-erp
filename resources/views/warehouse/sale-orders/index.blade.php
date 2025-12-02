@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Sale Orders - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">
@endpush

@section('subcontent')
    @include('components.global-notifications')

    {{-- Heading + top stats strip on the same row (Departments template matches Positions) --}}
    <div class="intro-y mt-6 mb-2 flex flex-col gap-1 text-[#3a2a1a]">
        <div class="flex items-baseline justify-between gap-6">
            <h2 class="flex items-center gap-2 text-2xl md:text-3xl font-semibold text-royalDark tracking-wide">
                <x-base.lucide icon="shopping-bag" class="w-7 h-7" />
                <span>Sale Orders</span>
            </h2>

            <div class="flex flex-row items-end gap-8 md:gap-12 justify-end">
                {{-- Completed --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="check-circle-2" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $completedSaleOrders ?? '—' }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Completed
                    </div>
                </div>

                {{-- Confirmed --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="thumbs-up" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $confirmedSaleOrders ?? '—' }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Confirmed
                    </div>
                </div>

                {{-- Pending --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="clock" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $pendingSaleOrders ?? '—' }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Pending
                    </div>
                </div>

                {{-- Total --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="shopping-bag" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $totalSaleOrders ?? '—' }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Orders
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <x-base.preview-component class="intro-y box bg-white/80 border border-slate-200/70 shadow-[0_18px_45px_rgba(15,23,42,0.10)]">
                <div class="p-5">
                    {{-- Unified filter & actions bar (same pattern as Purchase Orders / Delivery Orders) --}}
                    <div class="flex flex-wrap items-center gap-2 mb-4">
                        {{-- Search Input --}}
                        <div class="relative min-w-[180px]">
                            <x-base.lucide icon="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" />
                            <x-base.form-input
                                id="sale-orders-search-filter"
                                type="text"
                                placeholder="Search..."
                                class="pl-9 w-full text-sm py-1.5"
                            />
                        </div>

                        {{-- Status Filter --}}
                        <x-base.form-select id="sale-orders-status-filter" class="w-auto text-sm py-1.5">
                            <option value="">All Status</option>
                            <option value="pending">Pending</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="shipped">Shipped</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </x-base.form-select>

                        {{-- Warehouse Filter --}}
                        <x-base.form-select id="sale-orders-warehouse-filter" class="w-auto text-sm py-1.5">
                            <option value="">All Warehouses</option>
                            @foreach ($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                            @endforeach
                        </x-base.form-select>

                        {{-- Page Length --}}
                        <x-base.form-select id="sale-orders-filter-length" class="w-auto text-sm py-1.5">
                            <option value="10">10</option>
                            <option value="25" selected>25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </x-base.form-select>

                        {{-- Reset Button --}}
                        <x-base.tippy as="button" id="sale-orders-filter-reset" type="button" content="Reset filters" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                            <x-base.lucide icon="x" class="w-4 h-4" />
                        </x-base.tippy>

                        {{-- Spacer --}}
                        <div class="flex-1"></div>

                        {{-- Action Buttons --}}
                        <div class="flex items-center gap-1">
                            <x-base.tippy content="Print" placement="bottom">
                                <button id="sale-orders-print" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="printer" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Export PDF" placement="bottom">
                                <button id="sale-orders-pdf" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="file-text" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Export Excel" placement="bottom">
                                <button id="sale-orders-export" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="file-spreadsheet" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Refresh" placement="bottom">
                                <button id="sale-orders-refresh" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="refresh-cw" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>

                            {{-- Add Sale Order button at the right end of the toolbar --}}
                            <x-base.tippy content="Add new sale order" placement="bottom">
                                <button
                                    type="button"
                                    id="open-create-so-modal"
                                    class="btn-royal btn-royal--gold btn-royal--sm"
                                    data-tw-toggle="modal"
                                    data-tw-target="#sale-order-modal"
                                >
                                    <x-base.lucide icon="plus-circle" class="w-4 h-4 mr-1" />
                                    <span class="hidden sm:inline">Add</span>
                                </button>
                            </x-base.tippy>
                        </div>
                    </div>

                    <div class="overflow-x-auto sm:overflow-visible" data-erp-table-wrapper>
                        <table
                            id="sale-orders-table"
                            data-tw-merge
                            data-erp-table
                            class="datatable-default w-full min-w-full table-auto text-left text-sm"
                        >
                            <thead>
                                <tr>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Code</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Title</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Warehouse</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Created By</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Order Date</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-right">Total Amount</th>
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

    @include('warehouse.sale-orders.modals.create')
@endsection

@include('components.datatable.scripts')

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>

    <script>
        let saleOrdersTable;

        document.addEventListener('DOMContentLoaded', function () {
            const jq = window.jQuery || window.$;
            if (!jq) {
                console.error('jQuery not available on sale orders page.');
                return;
            }

            jq(function () {
                initializeSaleOrdersTable();
                setupSaleOrdersFilters();
            });
        });

        function initializeSaleOrdersTable() {
            saleOrdersTable = window.erpCrud.initDataTable({
                tableSelector: '#sale-orders-table',
                ajaxUrl: '{{ route("warehouse.sale-orders.datatable") }}',
                ajaxData: function(d) {
                    const jq = window.jQuery || window.$;
                    d.status = jq ? jq('#sale-orders-status-filter').val() : '';
                    d.warehouse_id = jq ? jq('#sale-orders-warehouse-filter').val() : '';
                    d.search_value = jq ? jq('#sale-orders-search-filter').val() : '';
                },
                columns: [
                    { data: 'code', name: 'code' },
                    { data: 'title', name: 'title' },
                    { data: 'warehouse_name', name: 'warehouse_name' },
                    { data: 'created_by_name', name: 'created_by_name' },
                    { data: 'order_date', name: 'order_date' },
                    { data: 'total_amount', name: 'total_amount', className: 'text-right' },
                    { data: 'status_badge', name: 'status', className: 'text-center' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ],
                pageLength: 25
            });
        }

        function setupSaleOrdersFilters() {
            const jq = window.jQuery || window.$;
            if (!jq) {
                return;
            }

            jq('#sale-orders-search-filter').on('keypress', function (e) {
                if (e.which === 13) {
                    applySaleOrdersFilters();
                }
            });

            jq('#sale-orders-status-filter, #sale-orders-warehouse-filter, #sale-orders-filter-length').on('change', function () {
                const lengthEl = document.getElementById('sale-orders-filter-length');
                if (saleOrdersTable && lengthEl) {
                    saleOrdersTable.page.len(parseInt(lengthEl.value || '25', 10)).draw();
                } else {
                    applySaleOrdersFilters();
                }
            });

            // PDF export (placeholder)
            jq('#sale-orders-pdf').on('click', function () {
                if (typeof window.showToast === 'function') {
                    window.showToast('PDF export functionality not implemented yet', 'info');
                }
            });

            // Export functionality (fallback to client-side export helper if available)
            jq('#sale-orders-export').on('click', function () {
                if (window.erpCrud && typeof window.erpCrud.exportDataTable === 'function') {
                    window.erpCrud.exportDataTable(saleOrdersTable, 'sale-orders');
                } else if (typeof window.showToast === 'function') {
                    window.showToast('Export functionality not available', 'error');
                }
            });

            // Refresh functionality
            jq('#sale-orders-refresh').on('click', function () {
                if (saleOrdersTable) {
                    saleOrdersTable.ajax.reload();
                    if (typeof window.showToast === 'function') {
                        window.showToast('Data refreshed', 'success');
                    }
                }
            });

            // Print
            jq('#sale-orders-print').on('click', function () {
                window.print();
            });

            // Reset filters
            jq('#sale-orders-filter-reset').on('click', function () {
                jq('#sale-orders-search-filter').val('');
                jq('#sale-orders-status-filter').val('');
                jq('#sale-orders-warehouse-filter').val('');
                const lengthEl = document.getElementById('sale-orders-filter-length');
                if (lengthEl) {
                    lengthEl.value = '25';
                }
                if (saleOrdersTable) {
                    saleOrdersTable.page.len(25).draw();
                }
                applySaleOrdersFilters();
            });
        }

        function applySaleOrdersFilters() {
            if (saleOrdersTable) {
                saleOrdersTable.ajax.reload();
            }
        }
    </script>
@endpush

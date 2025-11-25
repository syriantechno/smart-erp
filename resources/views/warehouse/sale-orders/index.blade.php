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
                    <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                        <form id="sale-orders-filter-form" class="w-full sm:mr-auto xl:flex">
                            <div class="items-center sm:mr-4 sm:flex">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Status
                                </label>
                                <x-base.form-select id="sale-orders-status-filter" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                    <option value="">All Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="confirmed">Confirmed</option>
                                    <option value="shipped">Shipped</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Search
                                </label>
                                <x-base.form-input
                                    id="sale-orders-search-filter"
                                    type="text"
                                    placeholder="Search..."
                                    class="mt-2 w-full sm:mt-0 sm:w-48 2xl:w-full"
                                />
                            </div>
                            <div class="mt-4 flex flex-wrap gap-2 sm:items-center xl:mt-0">
                                <button id="sale-orders-filter-go" type="button" class="btn-royal btn-royal--dark btn-royal--sm w-full sm:w-24 group">
                                    <x-base.lucide icon="search" class="w-4 h-4 icon-hover-rise" />
                                    Go
                                </button>
                                <button id="sale-orders-filter-reset" type="button" class="btn-royal btn-royal--outline btn-royal--sm w-full sm:w-24 group">
                                    <x-base.lucide icon="rotate-ccw" class="w-4 h-4 icon-hover-rise" />
                                    Reset
                                </button>
                            </div>
                        </form>

                        <div class="mt-5 flex flex-wrap items-center gap-2 sm:mt-0 sm:flex-nowrap">
                            <x-base.tippy content="Export PDF" placement="bottom">
                                <button id="sale-orders-pdf" type="button" class="btn-royal btn-royal--outline btn-royal--sm  group text-royalDark">
                                    <x-base.lucide icon="file-text" class="w-5 h-5 icon-hover-rise" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Export" placement="bottom">
                                <button id="sale-orders-export" type="button" class="btn-royal btn-royal--outline btn-royal--sm  group text-royalDark">
                                    <x-base.lucide icon="file-spreadsheet" class="w-5 h-5 icon-hover-rise" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Refresh" placement="bottom">
                                <button id="sale-orders-refresh" type="button" class="btn-royal btn-royal--outline btn-royal--sm  group text-royalDark">
                                    <x-base.lucide icon="refresh-cw" class="w-5 h-5 icon-hover-rise" />
                                </button>
                            </x-base.tippy>

                            {{-- Add Sale Order button at the right end of the toolbar --}}
                            <x-base.tippy content="Add new sale order" placement="bottom">
                                <button
                                    type="button"
                                    id="open-create-so-modal"
                                    class="btn-royal btn-royal--gold btn-royal--sm sm:btn-royal--lg group"
                                    data-tw-toggle="modal"
                                >
                                    <x-base.lucide icon="plus-circle" class="w-5 h-5 icon-hover-rise" />
                                    <span class="hidden sm:inline">Add</span>
                                </button>
                            </x-base.tippy>
                        <!-- Warehouse Filter -->
                        <div class="col-span-12 md:col-span-4">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Warehouse
                            </label>
                            <x-base.form-select id="so-warehouse-filter" class="w-full">
                                <option value="">All Warehouses</option>
                                @foreach ($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                @endforeach
                            </x-base.form-select>
                        </div>

                        <!-- Search Filter -->
                        <div class="col-span-12 md:col-span-4">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Search
                            </label>
                            <x-base.form-input
                                id="so-search-filter"
                                type="text"
                                placeholder="Search sale orders..."
                                class="w-full"
                            />
                        </div>

                        <div class="col-span-12 flex justify-end gap-2 mt-2 flex-wrap">
                            <button
                                type="button"
                                class="btn-royal btn-royal--outline btn-royal--sm group"
                                onclick="clearSoFilters()"
                            >
                                <x-base.lucide icon="rotate-ccw" class="w-4 h-4 icon-hover-rise" />
                                Clear
                            </button>
                            <button
                                type="button"
                                class="btn-royal btn-royal--dark btn-royal--sm group"
                                onclick="applySoFilters()"
                            >
                                <x-base.lucide icon="search" class="w-4 h-4 icon-hover-rise" />
                                Apply
                            </button>
                        </div>
                    </div>

                    <div class="overflow-x-auto sm:overflow-visible" data-erp-table-wrapper>
                        <table
                            id="sale-orders-table"
                            data-tw-merge
                            data-erp-table
                            class="datatable-default w-full min-w-full table-auto text-left text-sm"
                        >
                            <thead class="bg-gradient-to-r from-royalDark to-gray-800 text-white">
                                <tr>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">#</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Code</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Title</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Customer</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Warehouse</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Order Date</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Total Amount</th>
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
                    d.status = jq ? jq('#so-status-filter').val() : '';
                    d.warehouse_id = jq ? jq('#so-warehouse-filter').val() : '';
                    d.search_value = jq ? jq('#so-search-filter').val() : '';
                },
                columns: [
                    { data: 'code', name: 'code' },
                    { data: 'title', name: 'title' },
                    { data: 'warehouse_name', name: 'warehouse_name' },
                    { data: 'created_by_name', name: 'created_by_name' },
                    { data: 'order_date', name: 'order_date' },
                    { data: 'total_amount', name: 'total_amount' },
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

            jq('#sale-orders-status-filter').on('change', function () {
                applySaleOrdersFilters();
            });

            // PDF export
            jq('#sale-orders-pdf').on('click', function () {
                showToast('PDF export functionality not implemented yet', 'info');
            });

            // Export functionality
            jq('#sale-orders-export').on('click', function () {
                if (window.erpCrud && typeof window.erpCrud.exportDataTable === 'function') {
                    window.erpCrud.exportDataTable(saleOrdersTable, 'sale-orders');
                } else {
                    showToast('Export functionality not available', 'error');
                }
            });

            // Refresh functionality
            jq('#sale-orders-refresh').on('click', function () {
                if (saleOrdersTable) {
                    saleOrdersTable.ajax.reload();
                    showToast('Data refreshed', 'success');
                }
            });
        }

        function applySaleOrdersFilters() {
            if (saleOrdersTable) {
                saleOrdersTable.ajax.reload();
            }
        }
    </script>
@endpush

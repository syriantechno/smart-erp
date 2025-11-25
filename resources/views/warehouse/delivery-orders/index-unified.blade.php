@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Delivery Orders - {{ config('app.name') }}</title>
@endsection

@section('subcontent')
    @include('components.global-notifications')

    {{-- Heading + top stats strip on the same row (Departments template matches Positions) --}}
    <div class="intro-y mt-6 mb-2 flex flex-col gap-1 text-[#3a2a1a]">
        <div class="flex items-baseline justify-between gap-6">
            <h2 class="flex items-center gap-2 text-2xl md:text-3xl font-semibold text-royalDark tracking-wide">
                <x-base.lucide icon="truck" class="w-7 h-7" />
                <span>Delivery Orders</span>
            </h2>

            <div class="flex flex-row items-end gap-8 md:gap-12 justify-end">
                {{-- Delivered --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="check-circle-2" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $deliveredDeliveryOrders ?? '—' }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Delivered
                    </div>
                </div>

                {{-- Shipped --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="truck" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $shippedDeliveryOrders ?? '—' }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Shipped
                    </div>
                </div>

                {{-- Pending --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="clock" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $pendingDeliveryOrders ?? '—' }}
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
                            <x-base.lucide icon="package" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $totalDeliveryOrders ?? '—' }}
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
                        <form id="delivery-orders-filter-form" class="w-full sm:mr-auto xl:flex">
                            <div class="items-center sm:mr-4 sm:flex">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Status
                                </label>
                                <x-base.form-select id="delivery-orders-status-filter" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                    <option value="">All Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="shipped">Shipped</option>
                                    <option value="delivered">Delivered</option>
                                    <option value="cancelled">Cancelled</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Search
                                </label>
                                <x-base.form-input
                                    id="delivery-orders-search-filter"
                                    type="text"
                                    placeholder="Search..."
                                    class="mt-2 w-full sm:mt-0 sm:w-48 2xl:w-full"
                                />
                            </div>
                            <div class="mt-4 flex flex-wrap gap-2 sm:items-center xl:mt-0">
                                <button id="delivery-orders-filter-go" type="button" class="btn-royal btn-royal--dark btn-royal--sm w-full sm:w-24 group">
                                    <x-base.lucide icon="search" class="w-4 h-4 icon-hover-rise" />
                                    Go
                                </button>
                                <button id="delivery-orders-filter-reset" type="button" class="btn-royal btn-royal--outline btn-royal--sm w-full sm:w-24 group">
                                    <x-base.lucide icon="rotate-ccw" class="w-4 h-4 icon-hover-rise" />
                                    Reset
                                </button>
                            </div>
                        </form>

                        <div class="mt-5 flex flex-wrap items-center gap-2 sm:mt-0 sm:flex-nowrap">
                            <x-base.tippy content="Export PDF" placement="bottom">
                                <button id="delivery-orders-pdf" type="button" class="btn-royal btn-royal--outline btn-royal--sm  group text-royalDark">
                                    <x-base.lucide icon="file-text" class="w-5 h-5 icon-hover-rise" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Export" placement="bottom">
                                <button id="delivery-orders-export" type="button" class="btn-royal btn-royal--outline btn-royal--sm  group text-royalDark">
                                    <x-base.lucide icon="file-spreadsheet" class="w-5 h-5 icon-hover-rise" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Refresh" placement="bottom">
                                <button id="delivery-orders-refresh" type="button" class="btn-royal btn-royal--outline btn-royal--sm  group text-royalDark">
                                    <x-base.lucide icon="refresh-cw" class="w-5 h-5 icon-hover-rise" />
                                </button>
                            </x-base.tippy>

                            {{-- Add Delivery Order button at the right end of the toolbar --}}
                            <x-base.tippy content="Add new delivery order" placement="bottom">
                                <button
                                    type="button"
                                    id="open-create-do-modal"
                                    class="btn-royal btn-royal--gold btn-royal--sm sm:btn-royal--lg group"
                                    data-tw-toggle="modal"
                                    data-tw-target="#create-do-modal"
                                >
                                    <x-base.lucide icon="plus-circle" class="w-5 h-5 icon-hover-rise" />
                                    <span class="hidden sm:inline">Add</span>
                                </button>
                            </x-base.tippy>
                        </div>
                    </div>

                    <div class="overflow-x-auto sm:overflow-visible" data-erp-table-wrapper>
                        <table
                            id="delivery-orders-table"
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
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Delivery Date</th>
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

    <!-- Unified Invoice Modal for Delivery Orders -->
    <x-invoice.unified-form 
        id="create-do-modal" 
        title="Create Delivery Order" 
        type="delivery_order"
        :customers="$customers ?? []"
        :warehouses="$warehouses ?? []"
        :materials="$materials ?? []"
    />

    @include('components.datatable.scripts')

    <script>
        let deliveryOrdersTable;

        document.addEventListener('DOMContentLoaded', function () {
            const jq = window.jQuery || window.$;
            if (!jq) {
                console.error('jQuery not available on delivery orders page.');
                return;
            }

            jq(document).ready(function () {
                initializeDeliveryOrdersTable();
                setupDeliveryOrdersEventListeners();
            });
        });

        function initializeDeliveryOrdersTable() {
            deliveryOrdersTable = window.erpCrud.initDataTable({
                tableSelector: '#delivery-orders-table',
                ajaxUrl: '{{ route("warehouse.delivery-orders.datatable") }}',
                ajaxData: function (d) {
                    const statusEl = document.getElementById('delivery-orders-status-filter');
                    const searchEl = document.getElementById('delivery-orders-search-filter');

                    d.status = statusEl ? statusEl.value : '';
                    d.filter_value = searchEl ? searchEl.value : '';
                    d.filter_field = 'all';
                    d.filter_type = 'contains';
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center font-medium', orderable: false },
                    { data: 'code', name: 'code' },
                    { data: 'title', name: 'title' },
                    { data: 'customer_name', name: 'customer_name' },
                    { data: 'warehouse_name', name: 'warehouse_name' },
                    { data: 'delivery_date', name: 'delivery_date' },
                    { data: 'total_amount', name: 'total_amount' },
                    { data: 'status', name: 'status', className: 'text-center' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ],
                pageLength: 25
            });

            window.deliveryOrdersTable = deliveryOrdersTable;

            if (!deliveryOrdersTable) {
                return;
            }

            deliveryOrdersTable.on('draw', function () {
                if (typeof window.lucide !== 'undefined' && window.lucide.createIcons) {
                    window.lucide.createIcons();
                }
            });
        }

        function setupDeliveryOrdersEventListeners() {
            const jq = window.jQuery || window.$;
            if (!jq) {
                return;
            }

            jq('#delivery-orders-search-filter').on('keypress', function (e) {
                if (e.which === 13) {
                    applyDeliveryOrdersFilters();
                }
            });

            jq('#delivery-orders-status-filter').on('change', function () {
                applyDeliveryOrdersFilters();
            });

            // PDF export
            jq('#delivery-orders-pdf').on('click', function () {
                showToast('PDF export functionality not implemented yet', 'info');
            });

            // Export functionality
            jq('#delivery-orders-export').on('click', function () {
                if (window.erpCrud && typeof window.erpCrud.exportDataTable === 'function') {
                    window.erpCrud.exportDataTable(deliveryOrdersTable, 'delivery-orders');
                } else {
                    showToast('Export functionality not available', 'error');
                }
            });

            // Refresh functionality
            jq('#delivery-orders-refresh').on('click', function () {
                if (deliveryOrdersTable) {
                    deliveryOrdersTable.ajax.reload();
                    showToast('Data refreshed', 'success');
                }
            });
        }

        function applyDeliveryOrdersFilters() {
            if (deliveryOrdersTable) {
                deliveryOrdersTable.ajax.reload();
            }
        }
    </script>
@endsection

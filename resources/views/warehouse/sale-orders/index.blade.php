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

    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Sale Orders</h2>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <!-- Filters -->
            <x-base.preview-component class="intro-y box mb-6">
                <div class="p-5">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                        <x-base.lucide icon="Filter" class="h-5 w-5" />
                        Filters
                    </h3>

                    <div class="grid grid-cols-12 gap-4">
                        <!-- Status Filter -->
                        <div class="col-span-12 md:col-span-4">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Status
                            </label>
                            <x-base.form-select id="so-status-filter" class="w-full">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="shipped">Shipped</option>
                                <option value="delivered">Delivered</option>
                                <option value="cancelled">Cancelled</option>
                            </x-base.form-select>
                        </div>

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

                        <div class="col-span-12 flex justify-end gap-2 mt-2">
                            <x-base.button
                                variant="secondary"
                                type="button"
                                onclick="clearSoFilters()"
                            >
                                <x-base.lucide icon="X" class="w-4 h-4 mr-2" />
                                Clear
                            </x-base.button>
                            <x-base.button
                                variant="primary"
                                type="button"
                                onclick="applySoFilters()"
                            >
                                <x-base.lucide icon="Filter" class="w-4 h-4 mr-2" />
                                Apply
                            </x-base.button>
                        </div>
                    </div>
                </div>
            </x-base.preview-component>

            <!-- Sale Orders Table -->
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
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
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Total Amount</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Status</th>
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
            saleOrdersTable = window.initDataTable('#sale-orders-table', {
                ajax: {
                    url: '{{ route("warehouse.sale-orders.datatable") }}',
                    data: function(d) {
                        const jq = window.jQuery || window.$;
                        d.status = jq ? jq('#so-status-filter').val() : '';
                        d.warehouse_id = jq ? jq('#so-warehouse-filter').val() : '';
                        d.search_value = jq ? jq('#so-search-filter').val() : '';
                    }
                },
                columns: [
                    { data: 'code', name: 'code' },
                    { data: 'title', name: 'title' },
                    { data: 'warehouse_name', name: 'warehouse_name' },
                    { data: 'created_by_name', name: 'created_by_name' },
                    { data: 'order_date', name: 'order_date' },
                    { data: 'total_amount', name: 'total_amount' },
                    { data: 'status_badge', name: 'status_badge', orderable: false },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ],
                pageLength: 25,
                lengthChange: false,
                searching: false,
                order: [[0, 'desc']],
                responsive: true,
                dom: "t<'datatable-footer flex flex-col md:flex-row md:items-center md:justify-between mt-5 gap-4'<'datatable-info text-slate-500'i><'datatable-pagination'p>>",
                drawCallback: function () {
                    if (typeof window.Lucide !== 'undefined') {
                        window.Lucide.createIcons();
                    } else if (typeof lucide !== 'undefined' && typeof lucide.createIcons === 'function') {
                        lucide.createIcons();
                    }
                }
            });
        }

        function setupSaleOrdersFilters() {
            const jq = window.jQuery || window.$;
            if (!jq) {
                return;
            }

            jq('#so-search-filter').on('keypress', function(e) {
                if (e.which === 13) {
                    applySoFilters();
                }
            });

            jq('#so-status-filter, #so-warehouse-filter').on('change', function() {
                applySoFilters();
            });
        }

        function applySoFilters() {
            if (saleOrdersTable) {
                saleOrdersTable.ajax.reload();
            }
        }

        function clearSoFilters() {
            const jq = window.jQuery || window.$;
            if (!jq) {
                return;
            }

            jq('#so-status-filter').val('');
            jq('#so-warehouse-filter').val('');
            jq('#so-search-filter').val('');
            applySoFilters();
        }
    </script>
@endpush

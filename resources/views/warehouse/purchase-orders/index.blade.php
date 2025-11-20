@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Purchase Orders - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">
@endpush

@push('scripts')
    @vite('resources/js/purchase-orders-modal.js')
@endpush

@section('subcontent')
    @include('components.global-notifications')

    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Purchase Orders</h2>
        <div class="flex items-center gap-2">
            <button
                type="button"
                class="btn-tonal btn-tonal--info hidden sm:flex group"
                data-tw-toggle="modal"
                data-tw-target="#purchase-orders-filters-slideover"
            >
                <x-base.lucide icon="filter" class="w-5 h-5 icon-hover-rise" />
                Filters
                <span id="active-filters-indicator" class="hidden ml-2 px-2 py-0.5 text-xs bg-white/20 rounded-full">Active</span>
            </button>

            <!-- Mobile filters icon -->
            <button
                type="button"
                class="btn-tonal btn-tonal--info btn-tonal--icon sm:hidden"
                data-tw-toggle="modal"
                data-tw-target="#purchase-orders-filters-slideover"
                title="Filters"
            >
                <x-base.lucide icon="filter" class="w-5 h-5" />
            </button>

            <button
                type="button"
                id="open-create-po-modal"
                class="btn-tonal btn-tonal--success group"
                data-tw-toggle="modal"
                data-tw-target="#create-po-modal"
            >
                <x-base.lucide icon="plus-circle" class="w-5 h-5 icon-hover-rise" />
                Add Purchase Order
            </button>
        </div>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                        <form id="purchase-orders-filter-form" class="w-full sm:mr-auto xl:flex">
                            <div class="items-center sm:mr-4 sm:flex">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Field
                                </label>
                                <x-base.form-select id="purchase-orders-filter-field" class="mt-2 w-full sm:mt-0 sm:w-auto 2xl:w-full">
                                    <option value="all">All Fields</option>
                                    <option value="code">Code</option>
                                    <option value="title">Title</option>
                                    <option value="supplier_name">Supplier</option>
                                    <option value="status">Status</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Type
                                </label>
                                <x-base.form-select id="purchase-orders-filter-type" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                    <option value="contains">Contains</option>
                                    <option value="equals">Equals</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Value
                                </label>
                                <x-base.form-input id="purchase-orders-filter-value" type="text" placeholder="Search..." class="mt-2 w-full sm:mt-0 sm:w-48 2xl:w-full" />
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Show
                                </label>
                                <x-base.form-select id="purchase-orders-filter-length" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 flex flex-wrap gap-2 xl:mt-0">
                                <button id="purchase-orders-filter-go" type="button" class="btn-tonal btn-tonal--info group">
                                    <x-base.lucide icon="search" class="w-4 h-4 icon-hover-rise" />
                                    Go
                                </button>
                                <button id="purchase-orders-filter-reset" type="button" class="btn-tonal btn-tonal--amber group">
                                    <x-base.lucide icon="rotate-ccw" class="w-4 h-4 icon-hover-rise" />
                                    Reset
                                </button>
                            </div>
                        </form>

                        <div class="mt-5 flex items-center gap-2 sm:mt-0">
                            <button id="purchase-orders-export" type="button"
                                class="btn-tonal btn-tonal--info btn-tonal--icon group">
                                <x-base.lucide icon="download" class="h-5 w-5 icon-hover-rise" />
                            </button>
                            <button id="purchase-orders-refresh" type="button"
                                class="btn-tonal btn-tonal--success btn-tonal--icon group">
                                <x-base.lucide icon="refresh-ccw" class="h-5 w-5 icon-hover-rise" />
                            </button>
                        </div>
                    </div>

                    <div class="overflow-x-auto sm:overflow-visible" data-erp-table-wrapper>
                        <table id="purchase-orders-table" data-tw-merge data-erp-table class="datatable-default w-full min-w-full table-auto text-left text-sm">
                            <thead>
                                <tr>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">#</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Code</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Title</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Supplier</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Order Date</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Total Amount</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Status</th>
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

    <!-- Purchase Order Create Modal -->
    @include('warehouse.purchase-orders.modals.create')

    @include('components.datatable.scripts')

    <script>
        let purchaseOrdersTable;

        document.addEventListener('DOMContentLoaded', function () {
            const jq = window.jQuery || window.$;
            if (!jq) {
                console.error('jQuery not available for purchase orders.');
                return;
            }

            jq(document).ready(function () {
                initializePurchaseOrdersTable();
                setupEventListeners();

                // Auto-generate PO code when opening create modal
                const openBtn = document.getElementById('open-create-po-modal');
                if (openBtn) {
                    openBtn.addEventListener('click', function () {
                        refreshPurchaseOrderCode();
                    });
                }
            });
        });

        function initializePurchaseOrdersTable() {
            purchaseOrdersTable = window.erpCrud.initDataTable({
                tableSelector: '#purchase-orders-table',
                ajaxUrl: '{{ route("warehouse.purchase-orders.datatable") }}',
                ajaxData: function(d) {
                    // Advanced filtering like employees
                    const field = $('#purchase-orders-filter-field').val();
                    const type = $('#purchase-orders-filter-type').val();
                    const value = $('#purchase-orders-filter-value').val();
                    
                    if (field && field !== 'all' && value) {
                        d.filter_field = field;
                        d.filter_type = type;
                        d.filter_value = value;
                    }
                    
                    return d;
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center font-medium', orderable: false },
                    { data: 'code', name: 'code', className: 'px-5 py-3 border-b dark:border-darkmode-300 font-medium text-slate-700 whitespace-nowrap' },
                    { data: 'title', name: 'title', className: 'px-5 py-3 border-b dark:border-darkmode-300 font-medium text-slate-700 whitespace-nowrap' },
                    { data: 'supplier_name', name: 'supplier_name', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-slate-700 whitespace-nowrap' },
                    { data: 'order_date', name: 'order_date', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-slate-700 whitespace-nowrap' },
                    { data: 'total_amount', name: 'total_amount', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-slate-700 whitespace-nowrap' },
                    { data: 'status', name: 'status', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-slate-700 whitespace-nowrap' },
                    { data: 'actions', name: 'actions', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center', orderable: false, searchable: false }
                ],
                pageLength: parseInt($('#purchase-orders-filter-length').val()) || 25,
                drawCallback: function() {
                    // Re-initialize Lucide icons
                    if (typeof lucide !== 'undefined') {
                        lucide.createIcons();
                    }
                }
            });

            window.purchaseOrdersTable = purchaseOrdersTable;
        }

        function setupEventListeners() {
            // Filter form submission
            $('#purchase-orders-filter-go').on('click', function() {
                purchaseOrdersTable.page.len(parseInt($('#purchase-orders-filter-length').val())).draw();
                purchaseOrdersTable.ajax.reload();
                updateActiveFiltersIndicator();
            });

            // Reset filters
            $('#purchase-orders-filter-reset').on('click', function() {
                $('#purchase-orders-filter-field').val('all');
                $('#purchase-orders-filter-type').val('contains');
                $('#purchase-orders-filter-value').val('');
                $('#purchase-orders-filter-length').val('25');
                purchaseOrdersTable.page.len(25).draw();
                purchaseOrdersTable.ajax.reload();
                updateActiveFiltersIndicator();
            });

            // Enter key on search
            $('#purchase-orders-filter-value').on('keypress', function(e) {
                if (e.which === 13) {
                    $('#purchase-orders-filter-go').click();
                }
            });

            $('#purchase-orders-filter-field, #purchase-orders-filter-type').on('change', updateActiveFiltersIndicator);
            $('#purchase-orders-filter-value').on('input', updateActiveFiltersIndicator);

            updateActiveFiltersIndicator();

            // Page length change
            $('#purchase-orders-filter-length').on('change', function() {
                purchaseOrdersTable.page.len(parseInt($(this).val())).draw();
            });

            // Export functionality
            $('#purchase-orders-export').on('click', function() {
                // Add export functionality here
                console.log('Export purchase orders');
            });

            // Refresh table
            $('#purchase-orders-refresh').on('click', function() {
                purchaseOrdersTable.ajax.reload();
            });
        }

        function refreshPurchaseOrderCode() {
            const $ = window.jQuery || window.$;
            $.get('{{ route("warehouse.purchase-orders.preview-code") }}')
                .done(function (response) {
                    if (response && response.code) {
                        const input = document.getElementById('create-po-code');
                        if (input) {
                            input.value = response.code;
                        }
                    }
                });
        }

        function updateActiveFiltersIndicator() {
            const field = $('#purchase-orders-filter-field').val();
            const value = $('#purchase-orders-filter-value').val() || '';
            const hasValue = value.trim().length > 0;
            const hasSpecificField = field && field !== 'all' && hasValue;
            $('#active-filters-indicator').toggleClass('hidden', !(hasValue || hasSpecificField));
        }

        function deletePurchaseOrder(id, name) {
            if (confirm(`Are you sure you want to delete "${name}"?`)) {
                const $ = window.jQuery || window.$;
                $.ajax({
                    url: `/warehouse/purchase-orders/${id}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            purchaseOrdersTable.ajax.reload();
                            // Show success message
                        }
                    },
                    error: function() {
                        alert('Error deleting purchase order');
                    }
                });
            }
        }
    </script>
@endsection

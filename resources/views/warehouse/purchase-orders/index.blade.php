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

    {{-- Heading + top stats strip on the same row (Departments template matches Positions) --}}
    <div class="intro-y mt-6 mb-2 flex flex-col gap-1 text-[#3a2a1a]">
        <div class="flex items-baseline justify-between gap-6">
            <h2 class="flex items-center gap-2 text-2xl md:text-3xl font-semibold text-royalDark tracking-wide">
                <x-base.lucide icon="shopping-cart" class="w-7 h-7" />
                <span>Purchase Orders</span>
            </h2>

            <div class="flex flex-row items-end gap-8 md:gap-12 justify-end">
                {{-- Completed orders --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="check-circle-2" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $completedPurchaseOrders ?? '—' }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Completed
                    </div>
                </div>

                {{-- Approved orders --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="thumbs-up" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $approvedPurchaseOrders ?? '—' }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Approved
                    </div>
                </div>

                {{-- Pending orders --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="clock" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $pendingPurchaseOrders ?? '—' }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Pending
                    </div>
                </div>

                {{-- Total orders --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="shopping-cart" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $totalPurchaseOrders ?? '—' }}
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
                        <form id="purchase-orders-filter-form" class="w-full sm:mr-auto xl:flex">
                            <div class="items-center sm:mr-4 sm:flex">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Status
                                </label>
                                <x-base.form-select id="purchase-orders-status-filter" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                    <option value="">All Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="approved">Approved</option>
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
                                    id="purchase-orders-search-filter"
                                    type="text"
                                    placeholder="Search..."
                                    class="mt-2 w-full sm:mt-0 sm:w-48 2xl:w-full"
                                />
                            </div>
                            <div class="mt-4 flex flex-wrap gap-2 sm:items-center xl:mt-0">
                                <button id="purchase-orders-filter-go" type="button" class="btn-royal btn-royal--dark btn-royal--sm w-full sm:w-24 group">
                                    <x-base.lucide icon="search" class="w-4 h-4 icon-hover-rise" />
                                    Go
                                </button>
                                <button id="purchase-orders-filter-reset" type="button" class="btn-royal btn-royal--outline btn-royal--sm w-full sm:w-24 group">
                                    <x-base.lucide icon="rotate-ccw" class="w-4 h-4 icon-hover-rise" />
                                    Reset
                                </button>
                            </div>
                        </form>

                        <div class="mt-5 flex flex-wrap items-center gap-2 sm:mt-0 sm:flex-nowrap">
                            <x-base.tippy content="Export PDF" placement="bottom">
                                <button id="purchase-orders-pdf" type="button" class="btn-royal btn-royal--outline btn-royal--sm btn-tonal--icon group text-royalDark">
                                    <x-base.lucide icon="file-text" class="w-5 h-5 icon-hover-rise" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Export" placement="bottom">
                                <button id="purchase-orders-export" type="button" class="btn-royal btn-royal--outline btn-royal--sm btn-tonal--icon group text-royalDark">
                                    <x-base.lucide icon="file-spreadsheet" class="w-5 h-5 icon-hover-rise" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Refresh" placement="bottom">
                                <button id="purchase-orders-refresh" type="button" class="btn-royal btn-royal--outline btn-royal--sm btn-tonal--icon group text-royalDark">
                                    <x-base.lucide icon="refresh-cw" class="w-5 h-5 icon-hover-rise" />
                                </button>
                            </x-base.tippy>

                            {{-- Add Purchase Order button at the right end of the toolbar --}}
                            <x-base.tippy content="Create new purchase order" placement="bottom">
                                <button
                                    type="button"
                                    id="open-create-po-modal"
                                    class="btn-royal btn-royal--gold btn-royal--sm sm:btn-royal--lg group"
                                    data-tw-toggle="modal"
                                    data-tw-target="#create-purchase-order-modal"
                                >
                                    <x-base.lucide icon="plus-circle" class="w-5 h-5 icon-hover-rise" />
                                    <span class="hidden sm:inline">Add</span>
                                </button>
                            </x-base.tippy>
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

            // PDF export
            $('#purchase-orders-pdf').on('click', function() {
                showToast('PDF export functionality not implemented yet', 'info');
            });

            // Export functionality
            $('#purchase-orders-export').on('click', function() {
                if (window.erpCrud && typeof window.erpCrud.exportDataTable === 'function') {
                    window.erpCrud.exportDataTable(purchaseOrdersTable, 'purchase-orders');
                } else {
                    showToast('Export functionality not available', 'error');
                }
            });

            // Refresh table
            $('#purchase-orders-refresh').on('click', function() {
                purchaseOrdersTable.ajax.reload();
                showToast('Data refreshed', 'success');
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

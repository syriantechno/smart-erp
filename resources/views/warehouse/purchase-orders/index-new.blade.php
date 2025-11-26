@extends('../themes/' . $activeTheme)

@section('subhead')
    <title>Purchase Orders - {{ config('app.name') }}</title>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">
@endpush

@section('subcontent')
    @include('components.global-notifications')

    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Purchase Orders</h2>
        <button
            id="open-create-po-modal"
            class="btn-royal btn-royal--gold btn-royal--sm"
            data-tw-toggle="modal"
            data-tw-target="#create-po-modal"
        >
            <x-base.lucide icon="plus" class="w-4 h-4 mr-2" />
            Add Purchase Order
        </button>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <!-- Filters -->
            <x-base.preview-component class="intro-y box mb-6">
                <div class="p-5">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                        <x-base.lucide icon="filter" class="h-5 w-5" />
                        Filters
                    </h3>

                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12 md:col-span-4">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Status
                            </label>
                            <x-base.form-select id="po-status-filter" class="w-full">
                                <option value="">All Status</option>
                                <option value="draft">Draft</option>
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="delivered">Delivered</option>
                                <option value="cancelled">Cancelled</option>
                            </x-base.form-select>
                        </div>

                        <div class="col-span-12 md:col-span-4">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Search
                            </label>
                            <x-base.form-input
                                id="po-search-filter"
                                type="text"
                                placeholder="Search purchase orders..."
                                class="w-full"
                            />
                        </div>

                        <div class="col-span-12 md:col-span-4 flex items-end gap-2">
                            <button
                                class="btn-royal btn-royal--outline btn-royal--sm flex-1"
                                type="button"
                                onclick="clearPoFilters()"
                            >
                                <x-base.lucide icon="x" class="w-4 h-4 mr-2" />
                                Clear
                            </button>
                            <button
                                class="btn-royal btn-royal--dark btn-royal--sm flex-1"
                                type="button"
                                onclick="applyPoFilters()"
                            >
                                <x-base.lucide icon="filter" class="w-4 h-4 mr-2" />
                                Apply
                            </button>
                        </div>
                    </div>
                </div>
            </x-base.preview-component>

            <!-- Purchase Orders Table -->
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    <div class="overflow-x-auto sm:overflow-visible" data-erp-table-wrapper>
                        <table
                            id="purchase-orders-table"
                            class="table table-striped"
                            data-erp-table
                        >
                            <thead>
                                <tr>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Code</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Title</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Supplier</th>
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

    <!-- Unified Invoice Modal for Purchase Orders -->
    <x-invoice.unified-form 
        id="create-po-modal" 
        title="Create Purchase Order" 
        type="purchase_order"
        :suppliers="$suppliers ?? []"
        :materials="$materials ?? []"
    />

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
                        const codeInput = document.getElementById('create-po-modal-code');
                        if (codeInput) {
                            jq.get('{{ route("warehouse.purchase-orders.preview-code") }}')
                                .done(function (response) {
                                    if (response && response.code) {
                                        codeInput.value = response.code;
                                    }
                                });
                        }
                    });
                }
            });
        });

        function initializePurchaseOrdersTable() {
            purchaseOrdersTable = window.erpCrud.initDataTable({
                tableSelector: '#purchase-orders-table',
                ajaxUrl: '{{ route("warehouse.purchase-orders.datatable") }}',
                ajaxData: function(d) {
                    d.status = $('#po-status-filter').val();
                    d.search = $('#po-search-filter').val();
                },
                columns: [
                    { data: 'code', name: 'code' },
                    { data: 'title', name: 'title' },
                    { data: 'supplier_name', name: 'supplier_name' },
                    { data: 'order_date', name: 'order_date' },
                    { data: 'total_amount', name: 'total_amount' },
                    { data: 'status', name: 'status' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ],
                pageLength: 25
            });

            window.purchaseOrdersTable = purchaseOrdersTable;
        }

        function setupEventListeners() {
            // Enter key on search filter
            $('#po-search-filter').on('keypress', function(e) {
                if (e.which === 13) {
                    applyPoFilters();
                }
            });

            // Auto-apply filters on select change
            $('#po-status-filter').on('change', function() {
                applyPoFilters();
            });
        }

        function applyPoFilters() {
            purchaseOrdersTable.ajax.reload();
        }

        function clearPoFilters() {
            $('#po-status-filter').val('');
            $('#po-search-filter').val('');
            purchaseOrdersTable.ajax.reload();
        }

        function refreshPurchaseOrderCode() {
            const $ = window.jQuery || window.$;
            $.get('{{ route("warehouse.purchase-orders.preview-code") }}')
                .done(function (response) {
                    if (response && response.code) {
                        document.getElementById('create-po-modal-code').value = response.code;
                    }
                });
        }

        function deletePurchaseOrder(id, name) {
            const doDelete = () => {
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
                            if (typeof window.showSuccess === 'function') {
                                window.showSuccess('Purchase order deleted successfully');
                            }
                        }
                    },
                    error: function() {
                        if (typeof window.showError === 'function') {
                            window.showError('Error deleting purchase order');
                        }
                    }
                });
            };

            if (typeof window.confirmDelete === 'function') {
                window.confirmDelete(name, doDelete);
            } else {
                doDelete();
            }
        }
    </script>
@endsection

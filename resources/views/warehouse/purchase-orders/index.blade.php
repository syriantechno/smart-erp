@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Purchase Orders - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">
@endpush

@section('subcontent')
    @include('components.global-notifications')

    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Purchase Orders</h2>
        <x-base.button
            id="open-create-po-modal"
            variant="primary"
            class="w-40 sm:w-auto sm:ml-4"
            data-tw-toggle="modal"
            data-tw-target="#create-po-modal"
        >
            <x-base.lucide icon="Plus" class="w-4 h-4 mr-2" />
            Add Purchase Order
        </x-base.button>
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
                        <div class="col-span-12 md:col-span-4">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Status
                            </label>
                            <x-base.form-select id="po-status-filter" class="w-full">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="shipped">Shipped</option>
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
                            <x-base.button
                                variant="secondary"
                                class="flex-1"
                                type="button"
                                onclick="clearPoFilters()"
                            >
                                <x-base.lucide icon="X" class="w-4 h-4 mr-2" />
                                Clear
                            </x-base.button>
                            <x-base.button
                                variant="primary"
                                class="flex-1"
                                type="button"
                                onclick="applyPoFilters()"
                            >
                                <x-base.lucide icon="Filter" class="w-4 h-4 mr-2" />
                                Apply
                            </x-base.button>
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
                            data-tw-merge
                            data-erp-table
                            class="datatable-default w-full min-w-full table-auto text-left text-sm"
                        >
                            <thead>
                                <tr>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Code</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Title</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Created By</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Approved By</th>
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

    <!-- Create Purchase Order Modal (unified design) -->
    <x-modal.form id="create-po-modal" title="Add New Purchase Order" size="xl">
        <form id="create-po-form">
            @csrf

            <div class="mb-6">
                <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                    <x-base.lucide icon="ClipboardList" class="h-5 w-5"></x-base.lucide>
                    Purchase Order Information
                </h4>

                <div class="grid grid-cols-12 gap-4 gap-y-4">
                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="create-po-code">Code</x-base.form-label>
                        <x-base.form-input
                            id="create-po-code"
                            name="code"
                            type="text"
                            class="w-full"
                            placeholder="PO code"
                            required
                            readonly
                        />
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="create-po-title">Title</x-base.form-label>
                        <x-base.form-input
                            id="create-po-title"
                            name="title"
                            type="text"
                            class="w-full"
                            placeholder="Purchase order title"
                            required
                        />
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="create-po-order-date">Order Date</x-base.form-label>
                        <x-base.form-input
                            id="create-po-order-date"
                            name="order_date"
                            type="date"
                            class="w-full"
                            required
                        />
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="create-po-expected-delivery-date">Expected Delivery Date</x-base.form-label>
                        <x-base.form-input
                            id="create-po-expected-delivery-date"
                            name="expected_delivery_date"
                            type="date"
                            class="w-full"
                        />
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="create-po-total-amount">Total Amount</x-base.form-label>
                        <x-base.form-input
                            id="create-po-total-amount"
                            name="total_amount"
                            type="number"
                            step="0.01"
                            min="0"
                            class="w-full"
                            placeholder="0.00"
                            required
                        />
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="create-po-status">Active</x-base.form-label>
                        <x-base.form-select id="create-po-status" name="is_active" class="w-full" required>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </x-base.form-select>
                    </div>

                    <div class="col-span-12">
                        <x-base.form-label for="create-po-description">Description</x-base.form-label>
                        <x-base.form-textarea
                            id="create-po-description"
                            name="description"
                            class="w-full"
                            rows="3"
                            placeholder="Purchase order description"
                        ></x-base.form-textarea>
                    </div>
                </div>
            </div>
        </form>

        @slot('footer')
            <div class="flex justify-end gap-2 w-full">
                <x-base.button
                    class="w-24"
                    data-tw-dismiss="modal"
                    type="button"
                    variant="outline-secondary"
                >
                    Cancel
                </x-base.button>
                <x-base.button
                    class="w-32"
                    type="submit"
                    form="create-po-form"
                    id="create-po-btn"
                    variant="primary"
                >
                    <x-base.lucide icon="Save" class="w-4 h-4 mr-2" />
                    Save Purchase Order
                </x-base.button>
            </div>
        @endslot

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const jq = window.jQuery || window.$;
                if (!jq) {
                    console.error('jQuery not available for create purchase order modal.');
                    return;
                }

                const $ = jq;
                const form = document.getElementById('create-po-form');
                const submitBtn = $('#create-po-btn');

                if (!form) {
                    return;
                }

                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    const formData = new FormData(form);
                    const originalText = submitBtn.html();

                    submitBtn.prop('disabled', true).html('<i class="w-4 h-4 mr-2 animate-spin" data-lucide="loader"></i> Saving...');

                    $.ajax({
                        url: '{{ route("warehouse.purchase-orders.store") }}',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                const modalEl = document.getElementById('create-po-modal');
                                if (modalEl && modalEl.__tippy?.hide) {
                                    modalEl.__tippy.hide();
                                }

                                form.reset();
                                if (window.purchaseOrdersTable) {
                                    window.purchaseOrdersTable.ajax.reload();
                                }

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: response.message,
                                    timer: 3000,
                                    showConfirmButton: false
                                });
                            }
                        },
                        error: function(xhr) {
                            let errors = xhr.responseJSON?.errors || {};
                            let errorMessage = xhr.responseJSON?.message || 'An error occurred';

                            if (Object.keys(errors).length > 0) {
                                errorMessage = Object.values(errors).flat().join('\n');
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: errorMessage
                            });
                        },
                        complete: function() {
                            submitBtn.prop('disabled', false).html(originalText);
                            if (typeof lucide !== 'undefined' && typeof lucide.createIcons === 'function') {
                                lucide.createIcons();
                            }
                        }
                    });
                });
            });
        </script>
    </x-modal.form>
@endsection

@include('components.datatable.scripts')

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>

    <script>
        let purchaseOrdersTable;

        document.addEventListener('DOMContentLoaded', function () {
            const jq = window.jQuery || window.$;
            if (!jq) {
                console.error('jQuery not available on purchase orders page.');
                return;
            }

            jq(function () {
                initializePurchaseOrdersTable();
                setupPurchaseOrdersFilters();

                // Auto-generate PO code when opening create modal
                const openBtn = document.getElementById('open-create-po-modal');
                if (openBtn) {
                    openBtn.addEventListener('click', function () {
                        const $ = jq;
                        const codeInput = document.getElementById('create-po-code');
                        if (!codeInput) {
                            return;
                        }

                        $.get('{{ route("warehouse.purchase-orders.preview-code") }}')
                            .done(function (response) {
                                if (response && response.code) {
                                    codeInput.value = response.code;
                                }
                            });
                    });
                }
            });
        });

        function initializePurchaseOrdersTable() {
            purchaseOrdersTable = window.initDataTable('#purchase-orders-table', {
                ajax: {
                    url: '{{ route("warehouse.purchase-orders.datatable") }}',
                    data: function(d) {
                        const jq = window.jQuery || window.$;
                        d.status = jq ? jq('#po-status-filter').val() : '';
                        d.search_value = jq ? jq('#po-search-filter').val() : '';
                    }
                },
                columns: [
                    { data: 'code', name: 'code' },
                    { data: 'title', name: 'title' },
                    { data: 'created_by_name', name: 'created_by_name' },
                    { data: 'approved_by_name', name: 'approved_by_name' },
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

        function setupPurchaseOrdersFilters() {
            const jq = window.jQuery || window.$;
            if (!jq) {
                return;
            }

            jq('#po-search-filter').on('keypress', function(e) {
                if (e.which === 13) {
                    applyPoFilters();
                }
            });

            jq('#po-status-filter').on('change', function() {
                applyPoFilters();
            });
        }

        function applyPoFilters() {
            if (purchaseOrdersTable) {
                purchaseOrdersTable.ajax.reload();
            }
        }

        function clearPoFilters() {
            const jq = window.jQuery || window.$;
            if (!jq) {
                return;
            }

            jq('#po-status-filter').val('');
            jq('#po-search-filter').val('');
            applyPoFilters();
        }
    </script>
@endpush

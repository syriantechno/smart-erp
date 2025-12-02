@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@php
    $company = $company ?? null;
    $companies = $companies ?? collect();
    $warehouses = $warehouses ?? collect();
    $categories = $categories ?? collect();
    $materials = $materials ?? collect();
    $materialCategories = $materialCategories ?? collect();
    $approvalTemplates = $approvalTemplates ?? collect();

    $warehousesPayload = $warehouses->map(fn ($warehouse) => [
        'id' => $warehouse->id,
        'code' => $warehouse->code,
        'name' => $warehouse->name,
        'location' => $warehouse->location,
    ])->values();

    $materialsPayload = $materials->map(fn ($material) => [
        'id' => $material['id'] ?? null,
        'code' => $material['code'] ?? null,
        'name' => $material['name'] ?? null,
        'category_id' => $material['category_id'] ?? null,
        'category_name' => $material['category_name'] ?? null,
        'unit' => $material['unit'] ?? null,
        'unit_symbol' => $material['unit_symbol'] ?? null,
        'price' => $material['price'] ?? 0,
    ])->values();

    $materialCategoriesPayload = $materialCategories->map(fn ($category) => [
        'id' => $category['id'] ?? null,
        'name' => $category['name'] ?? null,
    ])->values();

    $catalogsPayload = $categories->map(fn ($category) => [
        'id' => $category->id,
        'name' => $category->name,
        'children' => $category->children->map(fn ($child) => [
            'id' => $child->id,
            'name' => $child->name,
        ])->values(),
    ])->values();

    $approvalTemplatesPayload = $approvalTemplates->map(fn ($template) => [
        'id' => $template->id,
        'name' => $template->name,
        'description' => $template->description,
        'levels' => $template->levels,
    ])->values();

    $companiesPayload = $companies->map(fn ($company) => [
        'id' => $company->id,
        'name' => $company->name,
        'address' => $company->address,
        'logo_url' => $company->logo ? \Illuminate\Support\Facades\Storage::url($company->logo) : null,
    ])->values();

    $currencySymbol = setting('currency.symbol', '$');

    $defaultCompany = $company ?? $companies->first();
    $defaultCompanyName = $defaultCompany->name ?? 'Smart ERP';
    $defaultCompanyAddress = $defaultCompany->address ?? 'Select the warehouse items needed for fulfillment.';
    $defaultCompanyLogo = $defaultCompany?->logo ? \Illuminate\Support\Facades\Storage::url($defaultCompany->logo) : null;
    $defaultCompanyId = $defaultCompany->id ?? null;

    $defaultCompanyMeta = [
        'id' => $defaultCompanyId,
        'name' => $defaultCompanyName,
        'address' => $defaultCompanyAddress,
        'logo_url' => $defaultCompanyLogo
            ?? 'https://ui-avatars.com/api/?name=' . urlencode($defaultCompanyName)
            . '&background=1D4ED8&color=fff',
    ];
@endphp

@section('subhead')
    <title>Purchase Orders - {{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                    {{-- Filters & Actions in One Row (copied from Departments) --}}
                    <div class="flex flex-wrap items-center gap-2 mb-4">
                        {{-- Search Input --}}
                        <div class="relative min-w-[180px]">
                            <x-base.lucide icon="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" />
                            <x-base.form-input
                                id="purchase-orders-search-filter"
                                type="text"
                                placeholder="Search..."
                                class="pl-9 w-full text-sm py-1.5"
                            />
                        </div>

                        {{-- Company Filter --}}
                        <x-base.form-select id="purchase-orders-company-filter" class="w-auto text-sm py-1.5">
                            <option value="">All Companies</option>
                            @foreach($companies ?? [] as $companyOption)
                                <option value="{{ $companyOption->id }}">{{ $companyOption->name }}</option>
                            @endforeach
                        </x-base.form-select>

                        {{-- Status Filter --}}
                        <x-base.form-select id="purchase-orders-status-filter" class="w-auto text-sm py-1.5">
                            <option value="">Status</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="shipped">Shipped</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                        </x-base.form-select>

                        {{-- Page Length --}}
                        <x-base.form-select id="purchase-orders-filter-length" class="w-auto text-sm py-1.5">
                            <option value="10">10</option>
                            <option value="25" selected>25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </x-base.form-select>

                        {{-- Reset Button --}}
                        <x-base.tippy as="button" id="purchase-orders-filter-reset" type="button" content="Reset filters" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                            <x-base.lucide icon="x" class="w-4 h-4" />
                        </x-base.tippy>

                        {{-- Spacer --}}
                        <div class="flex-1"></div>

                        {{-- Action Buttons --}}
                        <div class="flex items-center gap-1">
                            <x-base.tippy content="Print" placement="bottom">
                                <button type="button" id="purchase-orders-print" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="printer" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Export PDF" placement="bottom">
                                <button type="button" id="purchase-orders-pdf" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="file-text" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Export Excel" placement="bottom">
                                <button id="purchase-orders-export" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="file-spreadsheet" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Refresh" placement="bottom">
                                <button id="purchase-orders-refresh" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="refresh-cw" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>

                            {{-- Add Purchase Order Button --}}
                            <x-base.tippy content="Add purchase order" placement="bottom">
                                <button
                                    type="button"
                                    id="open-create-po-modal"
                                    class="btn-royal btn-royal--gold btn-royal--sm"
                                    data-tw-toggle="modal"
                                    data-tw-target="#create-po-modal"
                                >
                                    <x-base.lucide icon="plus-circle" class="w-4 h-4 mr-2" />
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
        window.purchaseOrderPayload = {
            routes: {
                store: '{{ route('warehouse.purchase-orders.store') }}',
                previewCode: '{{ route('warehouse.purchase-orders.preview-code') }}',
                materials: '{{ route('warehouse.material-requests.materials') }}',
                categoryChildren: '{{ route('warehouse.categories.children') }}'
            },
            meta: {
                csrf: '{{ csrf_token() }}'
            },
            data: {
                companies: @json($companiesPayload),
                defaultCompany: @json($defaultCompanyMeta),
                warehouses: @json($warehousesPayload),
                materials: @json($materialsPayload),
                categories: @json($materialCategoriesPayload),
                catalogs: @json($catalogsPayload),
                approvalTemplates: @json($approvalTemplatesPayload),
                currencySymbol: @json($currencySymbol)
            }
        };

        window.dispatchEvent(new Event('purchase-order:payload-ready'));

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
                    const statusEl = document.getElementById('purchase-orders-status-filter');
                    const searchEl = document.getElementById('purchase-orders-search-filter');

                    if (statusEl && statusEl.value) {
                        d.status = statusEl.value;
                    }

                    if (searchEl && searchEl.value) {
                        d.search_value = searchEl.value;
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
                pageLength: 25,
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
            // Filter form submission (status/search only if elements exist)
            $('#purchase-orders-filter-go').on('click', function() {
                if (purchaseOrdersTable) {
                    purchaseOrdersTable.ajax.reload();
                }
            });

            // Reset filters
            $('#purchase-orders-filter-reset').on('click', function() {
                const statusEl = document.getElementById('purchase-orders-status-filter');
                const searchEl = document.getElementById('purchase-orders-search-filter');

                if (statusEl) {
                    statusEl.value = '';
                }

                if (searchEl) {
                    searchEl.value = '';
                }

                if (purchaseOrdersTable) {
                    purchaseOrdersTable.page.len(25).draw();
                    purchaseOrdersTable.ajax.reload();
                }
            });

            // Enter key on search
            $('#purchase-orders-search-filter').on('keypress', function(e) {
                if (e.which === 13) {
                    $('#purchase-orders-filter-go').click();
                }
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
            const statusEl = document.getElementById('purchase-orders-status-filter');
            const searchEl = document.getElementById('purchase-orders-search-filter');
            const indicator = document.getElementById('active-filters-indicator');

            if (!indicator) {
                return;
            }

            const hasStatus = !!(statusEl && statusEl.value && statusEl.value.trim().length > 0);
            const hasSearch = !!(searchEl && searchEl.value && searchEl.value.trim().length > 0);

            indicator.classList.toggle('hidden', !(hasStatus || hasSearch));
        }

        function deletePurchaseOrder(id, name) {
            const confirmFn = typeof window.confirmDelete === 'function'
                ? window.confirmDelete
                : null;

            const runDelete = () => {
                const $ = window.jQuery || window.$;
                $.ajax({
                    url: `/warehouse/purchase-orders/${id}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            if (window.purchaseOrdersTable) {
                                window.purchaseOrdersTable.ajax.reload();
                            }

                            const msg = response.message || 'Purchase order deleted successfully';
                            if (typeof window.showSuccess === 'function') {
                                window.showSuccess(msg, 'Deleted!');
                            } else if (typeof window.showToast === 'function') {
                                window.showToast(msg, 'delete');
                            } else {
                                console.log('Deleted:', msg);
                            }
                        } else {
                            const err = response.message || 'Failed to delete purchase order';
                            if (typeof window.showError === 'function') {
                                window.showError(err);
                            } else if (typeof window.showToast === 'function') {
                                window.showToast(err, 'error');
                            } else {
                                console.error('Error:', err);
                            }
                        }
                    },
                    error: function(xhr) {
                        const err = (xhr.responseJSON && xhr.responseJSON.message) || 'Error deleting purchase order';
                        if (typeof window.showError === 'function') {
                            window.showError(err);
                        } else if (typeof window.showToast === 'function') {
                            window.showToast(err, 'error');
                        } else {
                            console.error('Error:', err);
                        }
                    }
                });
            };

            if (confirmFn) {
                confirmFn(name, runDelete);
            } else if (typeof window.confirmDelete === 'function') {
                window.confirmDelete(name, runDelete);
            } else {
                runDelete();
            }
        }
    </script>
@endsection

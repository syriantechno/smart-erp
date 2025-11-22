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

    $currencySymbol = config('app.currency_symbol', config('app.currency', '$'));

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
    <title>Material Requests - {{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">
@endpush

@section('subcontent')
    @include('components.global-notifications')

    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Material Requests</h2>
        <button
            type="button"
            id="create-material-request-button"
            class="btn-tonal btn-tonal--success w-40 sm:w-auto sm:ml-4 group"
            data-tw-toggle="modal"
            data-tw-target="#material-request-modal"
        >
            <x-base.lucide icon="plus-circle" class="w-5 h-5 icon-hover-rise" />
            New Material Request
        </button>
    </div>

    <!-- Compact filters bar -->
    <div class="intro-y mt-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        @php
            $stats = $statusStats ?? [
                'total' => 0,
                'pending' => 0,
                'in_progress' => 0,
                'approved' => 0,
                'rejected' => 0,
                'completed' => 0,
            ];
        @endphp

        <!-- Modern status cards with counts -->
        <div class="flex w-full overflow-x-auto gap-2 text-xs sm:max-w-xl">
            <button
                type="button"
                data-status=""
                onclick="filterByStatus('')"
                class="status-card flex min-w-[100px] flex-col rounded-xl border border-slate-200 bg-white/80 px-3 py-2 text-left shadow-sm hover:border-primary/40 hover:bg-primary/5 transition"
            >
                <span class="text-[0.7rem] font-medium text-slate-500">All</span>
                <span class="mt-1 text-base font-semibold text-slate-800">{{ number_format($stats['total']) }}</span>
            </button>

            <button
                type="button"
                data-status="pending"
                onclick="filterByStatus('pending')"
                class="status-card flex min-w-[110px] flex-col rounded-xl border border-amber-100 bg-amber-50/80 px-3 py-2 text-left shadow-sm hover:border-amber-300 hover:bg-amber-50 transition"
            >
                <span class="inline-flex items-center gap-1 text-[0.7rem] font-medium text-amber-700">
                    <span class="inline-block h-1.5 w-1.5 rounded-full bg-amber-400"></span>
                    Pending
                </span>
                <span class="mt-1 text-base font-semibold text-amber-800">{{ number_format($stats['pending']) }}</span>
            </button>

            <button
                type="button"
                data-status="in_progress"
                onclick="filterByStatus('in_progress')"
                class="status-card flex min-w-[120px] flex-col rounded-xl border border-sky-100 bg-sky-50/80 px-3 py-2 text-left shadow-sm hover:border-sky-300 hover:bg-sky-50 transition"
            >
                <span class="inline-flex items-center gap-1 text-[0.7rem] font-medium text-sky-700">
                    <span class="inline-block h-1.5 w-1.5 rounded-full bg-sky-400"></span>
                    In progress
                </span>
                <span class="mt-1 text-base font-semibold text-sky-800">{{ number_format($stats['in_progress']) }}</span>
            </button>

            <button
                type="button"
                data-status="approved"
                onclick="filterByStatus('approved')"
                class="status-card flex min-w-[110px] flex-col rounded-xl border border-emerald-100 bg-emerald-50/80 px-3 py-2 text-left shadow-sm hover:border-emerald-300 hover:bg-emerald-50 transition"
            >
                <span class="inline-flex items-center gap-1 text-[0.7rem] font-medium text-emerald-700">
                    <span class="inline-block h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                    Approved
                </span>
                <span class="mt-1 text-base font-semibold text-emerald-800">{{ number_format($stats['approved']) }}</span>
            </button>

            <button
                type="button"
                data-status="rejected"
                onclick="filterByStatus('rejected')"
                class="status-card flex min-w-[110px] flex-col rounded-xl border border-rose-100 bg-rose-50/80 px-3 py-2 text-left shadow-sm hover:border-rose-300 hover:bg-rose-50 transition"
            >
                <span class="inline-flex items-center gap-1 text-[0.7rem] font-medium text-rose-700">
                    <span class="inline-block h-1.5 w-1.5 rounded-full bg-rose-400"></span>
                    Rejected
                </span>
                <span class="mt-1 text-base font-semibold text-rose-800">{{ number_format($stats['rejected']) }}</span>
            </button>

            <button
                type="button"
                data-status="completed"
                onclick="filterByStatus('completed')"
                class="status-card flex min-w-[120px] flex-col rounded-xl border border-slate-200 bg-slate-50/80 px-3 py-2 text-left shadow-sm hover:border-slate-400 hover:bg-slate-50 transition"
            >
                <span class="inline-flex items-center gap-1 text-[0.7rem] font-medium text-slate-700">
                    <span class="inline-block h-1.5 w-1.5 rounded-full bg-slate-500"></span>
                    Completed
                </span>
                <span class="mt-1 text-base font-semibold text-slate-800">{{ number_format($stats['completed']) }}</span>
            </button>
        </div>

        <!-- Quick search + advanced toggle -->
        <div class="flex w-full items-center gap-2 sm:w-auto">
            <div class="relative flex-1 sm:w-56">
                <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
                    <x-base.lucide icon="search" class="w-3.5 h-3.5" />
                </span>
                <input
                    id="quick-search"
                    type="text"
                    placeholder="Quick search..."
                    class="w-full rounded-full border border-slate-200 bg-white py-1.5 pl-8 pr-3 text-xs text-slate-700 placeholder:text-slate-400 focus:border-primary focus:ring-0"
                />
            </div>
            <button
                type="button"
                onclick="toggleAdvancedFilters()"
                class="hidden sm:inline-flex items-center rounded-full border border-slate-200 bg-white px-3 py-1.5 text-[0.72rem] font-medium text-slate-700 hover:bg-slate-50"
            >
                <x-base.lucide icon="sliders" class="w-3.5 h-3.5 mr-1" />
                Advanced
            </button>
        </div>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <!-- Advanced filters -->
            <x-base.preview-component id="advanced-filters-panel" class="intro-y box mb-6 hidden">
                <div class="p-5">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                        <x-base.lucide icon="filter" class="h-5 w-5" />
                        Filters
                        <span id="material-requests-active-filters" class="hidden ml-2 px-2 py-0.5 text-xs bg-emerald-500/15 text-emerald-700 rounded-full">Active</span>
                    </h3>

                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12 md:col-span-4">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Status
                            </label>
                            <x-base.form-select id="status-filter" class="w-full">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="in_progress">In progress</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                                <option value="completed">Completed</option>
                            </x-base.form-select>
                        </div>

                        <div class="col-span-12 md:col-span-4">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Search
                            </label>
                            <x-base.form-input
                                id="search-filter"
                                type="text"
                                placeholder="Search material requests..."
                                class="w-full"
                            />
                        </div>

                        <div class="col-span-12 md:col-span-4 flex items-end gap-2">
                            <button
                                type="button"
                                class="btn-tonal btn-tonal--amber flex-1 group"
                                onclick="clearFilters()"
                            >
                                <x-base.lucide icon="rotate-ccw" class="w-4 h-4 icon-hover-rise" />
                                Clear
                            </button>
                            <button
                                type="button"
                                class="btn-tonal btn-tonal--info flex-1 group"
                                onclick="applyFilters()"
                            >
                                <x-base.lucide icon="search" class="w-4 h-4 icon-hover-rise" />
                                Apply
                            </button>
                        </div>
                    </div>
                </div>
            </x-base.preview-component>

            <!-- Material Requests Table -->
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    <div class="overflow-x-auto sm:overflow-visible" data-erp-table-wrapper>
                        <table
                            id="material-requests-table"
                            data-tw-merge
                            data-erp-table
                            class="datatable-default w-full min-w-full table-auto text-left text-sm"
                        >
                            <thead>
                                <tr>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Code</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Title</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Requested By</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Company</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Request Date</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Total Amount</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Approvals</th>
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

@include('warehouse.material-requests.modals.create-request')

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>

    <script>
        window.materialRequestPayload = {
            routes: {
                store: '{{ route('warehouse.material-requests.store') }}',
                previewCode: '{{ route('warehouse.material-requests.preview-code') }}',
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

        window.dispatchEvent(new Event('material-request:payload-ready'));

        let materialRequestsTable;

        document.addEventListener('DOMContentLoaded', function () {
            const jq = window.jQuery || window.$;
            if (!jq) {
                console.error('jQuery not available on material requests page.');
                return;
            }

            jq(function () {
                initializeMaterialRequestsTable();
                setupMaterialRequestsFilters();
            });
        });

        function initializeMaterialRequestsTable() {
            materialRequestsTable = window.erpCrud.initDataTable({
                tableSelector: '#material-requests-table',
                ajaxUrl: '{{ route("warehouse.material-requests.datatable") }}',
                ajaxData: function(d) {
                    d.status = $('#status-filter').val();
                    d.search_value = $('#search-filter').val();
                },
                columns: [
                    { data: 'code', name: 'code' },
                    { data: 'title', name: 'title' },
                    { data: 'requested_by_name', name: 'requested_by_name' },
                    { data: 'company_name', name: 'company_name' },
                    { data: 'request_date', name: 'request_date' },
                    {
                        data: 'total_amount',
                        name: 'total_amount',
                        render: function (value) {
                            if (window.erpCrud && typeof window.erpCrud.formatCurrency === 'function') {
                                return window.erpCrud.formatCurrency(value);
                            }
                            return value ?? 0;
                        }
                    },
                    { data: 'approval_progress', name: 'approval_progress', orderable: false, searchable: false },
                    {
                        data: 'status_badge',
                        name: 'status',
                        className: 'text-center',
                        orderable: false,
                        searchable: false,
                        render: function (value) {
                            return value || '';
                        }
                    },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ],
                pageLength: 25
            });
            window.materialRequestsTable = materialRequestsTable;
        }

        function setupMaterialRequestsFilters() {
            $('#search-filter').on('keypress', function(e) {
                if (e.which === 13) {
                    applyFilters();
                }
            });

            $('#status-filter').on('change', function() {
                applyFilters();
            });

            // Quick search input in compact bar
            $('#quick-search').on('keypress', function(e) {
                if (e.which === 13) {
                    const value = $(this).val();
                    $('#search-filter').val(value);
                    applyFilters();
                }
            });
        }

        function applyFilters() {
            if (materialRequestsTable) {
                materialRequestsTable.ajax.reload();
            }
        }

        function clearFilters() {
            $('#status-filter').val('');
            $('#search-filter').val('');
            $('#quick-search').val('');
            applyFilters();
        }

        window.filterByStatus = function (status) {
            const statusSelect = $('#status-filter');
            if (!statusSelect.length) {
                return;
            }

            statusSelect.val(status || '');
            $('#search-filter').val('');
            applyFilters();
        };

        window.toggleAdvancedFilters = function () {
            const panel = document.getElementById('advanced-filters-panel');
            if (!panel) return;
            panel.classList.toggle('hidden');
        };

        function deleteMaterialRequest(id, code) {
            if (!window.confirmDelete || !window.showError || !window.showToast) {
                console.error('Global notification helpers are not available.');
                return;
            }

            window.confirmDelete(code, function () {
                const jq = window.jQuery || window.$;
                if (!jq) {
                    console.error('jQuery is not available for deleteMaterialRequest.');
                    return;
                }

                jq.ajax({
                    url: '{{ route('warehouse.material-requests.destroy', ':id') }}'.replace(':id', id),
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    }
                })
                .done(function (response) {
                    const message = response.message || 'Material request deleted successfully.';
                    window.showToast(message, 'delete');
                    if (window.materialRequestsTable) {
                        window.materialRequestsTable.ajax.reload(null, false);
                    }
                })
                .fail(function (xhr) {
                    const message = xhr.responseJSON?.message || 'Failed to delete material request.';
                    window.showError(message);
                });
            });
        }

        function openMaterialRequestEditModal(id) {
            // Placeholder for Ajax-powered edit modal; implementation will
            // reuse the create modal structure and populate it with data.
            // For now, simply navigate to the show page with edit flag
            // to avoid breaking the UI until the full edit modal is wired.
            window.location.href = '{{ route('warehouse.material-requests.show', ':id') }}'.replace(':id', id) + '?edit=1';
        }
    </script>
@endpush

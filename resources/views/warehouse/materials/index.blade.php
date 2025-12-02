@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Materials Management - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
@endpush

@section('subcontent')
    @include('components.global-notifications')

    {{-- Heading + top stats strip on the same row (Departments template matches Positions) --}}
    <div class="intro-y mt-6 mb-2 flex flex-col gap-1 text-[#3a2a1a]">
        <div class="flex items-baseline justify-between gap-6">
            <h2 class="flex items-center gap-2 text-2xl md:text-3xl font-semibold text-royalDark tracking-wide">
                <x-base.lucide icon="package" class="w-7 h-7" />
                <span>Materials Management</span>
            </h2>

            <div class="flex flex-row items-end gap-8 md:gap-12 justify-end">
                {{-- Low stock --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="alert-triangle" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $lowStockMaterials ?? '—' }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Low Stock
                    </div>
                </div>

                {{-- Inactive materials --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="pause-circle" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $inactiveMaterials ?? '—' }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Inactive
                    </div>
                </div>

                {{-- Active materials --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="check-circle-2" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $activeMaterials ?? '—' }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Active
                    </div>
                </div>

                {{-- Total materials --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="package" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $totalMaterials ?? '—' }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Materials
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <x-base.preview-component class="intro-y box bg-white/80 border border-slate-200/70 shadow-[0_18px_45px_rgba(15,23,42,0.10)]">
                <div class="p-5">
                    {{-- Unified filter & actions bar (same pattern as Departments / Categories) --}}
                    <div class="flex flex-wrap items-center gap-2 mb-4">
                        {{-- Search Input --}}
                        <div class="relative min-w-[180px]">
                            <x-base.lucide icon="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" />
                            <x-base.form-input
                                id="search-filter"
                                type="text"
                                placeholder="Search..."
                                class="pl-9 w-full text-sm py-1.5"
                            />
                        </div>

                        {{-- Category Filter --}}
                        <x-base.form-select id="category-filter" class="w-auto text-sm py-1.5">
                            <option value="">All Categories</option>
                            @foreach($categories ?? [] as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </x-base.form-select>

                        {{-- Status Filter --}}
                        <x-base.form-select id="status-filter" class="w-auto text-sm py-1.5">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </x-base.form-select>

                        {{-- Page Length --}}
                        <x-base.form-select id="materials-filter-length" class="w-auto text-sm py-1.5">
                            <option value="10">10</option>
                            <option value="25" selected>25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </x-base.form-select>

                        {{-- Reset Button --}}
                        <x-base.tippy as="button" id="materials-filter-reset" type="button" content="Reset filters" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                            <x-base.lucide icon="x" class="w-4 h-4" />
                        </x-base.tippy>

                        {{-- Spacer --}}
                        <div class="flex-1"></div>

                        {{-- Action Buttons --}}
                        <div class="flex items-center gap-1">
                            <x-base.tippy content="Print" placement="bottom">
                                <button id="materials-print" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="printer" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Export PDF" placement="bottom">
                                <button id="materials-pdf" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="file-text" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Export Excel" placement="bottom">
                                <button id="materials-export" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="file-spreadsheet" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Refresh" placement="bottom">
                                <button id="materials-refresh" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="refresh-cw" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>

                            {{-- Add Material button at the right end of the toolbar --}}
                            <x-base.tippy content="Add new material" placement="bottom">
                                <button
                                    type="button"
                                    id="open-create-material-modal"
                                    class="btn-royal btn-royal--gold btn-royal--sm group"
                                    data-tw-toggle="modal"
                                    data-tw-target="#create-material-modal"
                                >
                                    <x-base.lucide icon="plus-circle" class="w-4 h-4 mr-2" />
                                    <span class="hidden sm:inline">Add</span>
                                </button>
                            </x-base.tippy>
                        </div>
                    </div>

                    <div class="overflow-x-auto sm:overflow-visible" data-erp-table-wrapper>
                        <table
                            id="materials-table"
                            data-tw-merge
                            data-erp-table
                            class="datatable-default w-full min-w-full table-auto text-left text-sm"
                        >
                            <thead>
                                <tr>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Code</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Name</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Category</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Unit</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Price</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Status</th>
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


    <!-- Create Material Modal -->
    @include('warehouse.materials.modals.create')

    <!-- Edit Material Modal -->
    @include('warehouse.materials.modals.edit')

    <!-- Hidden button to trigger edit material modal -->
    <button id="edit-material-trigger" data-tw-toggle="modal" data-tw-target="#edit-material-modal" class="hidden"></button>
@endsection

@include('components.datatable.scripts')

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>

    <script>
        let materialsTable;
        const unitStoreUrl = '{{ route("warehouse.measurement-units.store") }}';
        
        // Make categories, units, and warehouses data available globally for modals
        window.materialsCategories = @json($categories ?? []);
        window.materialsUnits = @json($units ?? []);
        window.materialsWarehouses = @json($warehouses ?? []);

        document.addEventListener('DOMContentLoaded', function () {
            const jq = window.jQuery || window.$;
            if (!jq) {
                console.error('jQuery not available on materials page.');
                return;
            }

            jq(function () {
                initializeDataTable();
                setupEventListeners();
                initUnitQuickAdd();

                // Auto-generate material code when opening create modal (unified code system)
                const openBtn = document.getElementById('open-create-material-modal');
                if (openBtn) {
                    openBtn.addEventListener('click', function () {
                        const $ = jq;
                        const codeInput = document.getElementById('create-code');
                        if (!codeInput) {
                            return;
                        }

                        $.get('{{ route("warehouse.materials.preview-code") }}')
                            .done(function (response) {
                                if (response && response.code) {
                                    codeInput.value = response.code;
                                }
                            });
                    });
                }
            });
        });

        function initializeDataTable() {
            materialsTable = window.erpCrud.initDataTable({
                tableSelector: '#materials-table',
                ajaxUrl: '{{ route("warehouse.materials.datatable") }}',
                ajaxData: function(d) {
                    d.category_id = $('#category-filter').val();
                    d.status = $('#status-filter').val();
                    d.filter_value = $('#search-filter').val();
                    d.filter_field = 'all';
                    d.filter_type = 'contains';
                },
                columns: [
                    { data: 'code', name: 'code' },
                    { data: 'name', name: 'name' },
                    { data: 'category_name', name: 'category_name' },
                    { data: 'unit_name', name: 'unit_name' },
                    { data: 'price', name: 'price', render: function(data) { return '{{ setting('currency.symbol', '$') }}' + parseFloat(data).toFixed(2); } },
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
                pageLength: 25,
                drawCallback: function () {
                    if (typeof window.Lucide !== 'undefined') {
                        window.Lucide.createIcons();
                    } else if (typeof lucide !== 'undefined' && typeof lucide.createIcons === 'function') {
                        lucide.createIcons();
                    }
                }
            });

            // Make table instance globally accessible for modals
            window.materialsTable = materialsTable;
        }

        function setupEventListeners() {
            // Enter key on search filter
            $('#search-filter').on('keypress', function(e) {
                if (e.which === 13) {
                    applyFilters();
                }
            });

            // Auto-apply filters on select change
            $('#category-filter, #status-filter').on('change', function() {
                applyFilters();
            });

            // Reset filters button
            $('#materials-filter-reset').on('click', function () {
                clearFilters();
            });

            // PDF export
            const pdfBtn = $('#materials-pdf');
            if (pdfBtn.length) {
                pdfBtn.on('click', function () {
                    showToast('PDF export functionality not implemented yet', 'info');
                });
            }

            // Export functionality
            const exportBtn = $('#materials-export');
            if (exportBtn.length) {
                exportBtn.on('click', function () {
                    if (window.erpCrud && typeof window.erpCrud.exportDataTable === 'function') {
                        window.erpCrud.exportDataTable(materialsTable, 'materials');
                    } else {
                        showToast('Export functionality not available', 'error');
                    }
                });
            }

            // Refresh functionality
            const refreshBtn = $('#materials-refresh');
            if (refreshBtn.length) {
                refreshBtn.on('click', function () {
                    if (materialsTable) {
                        materialsTable.ajax.reload();
                        showToast('Data refreshed', 'success');
                    }
                });
            }

            // Print functionality
            const printBtn = $('#materials-print');
            if (printBtn.length) {
                printBtn.on('click', function () {
                    window.print();
                });
            }
        }

        function initUnitQuickAdd() {
            const jq = window.jQuery || window.$;
            if (!jq) {
                console.error('jQuery not available for unit quick add.');
                return;
            }

            const $ = jq;

            $('[data-unit-quick-add-toggle]').off('click.unitQuickAdd').on('click.unitQuickAdd', function () {
                const targetSelector = $(this).data('target');
                if (!targetSelector) {
                    return;
                }

                const $target = $(targetSelector);
                if (!$target.length) {
                    return;
                }

                $target.toggleClass('hidden');
                if (!$target.hasClass('hidden')) {
                    const firstInput = $target.find('[data-unit-field="code"], input[name="code"]').first();
                    if (firstInput.length) {
                        firstInput.trigger('focus');
                    }
                }
            });

            $('[data-unit-quick-add]').each(function () {
                const $container = $(this);
                if ($container.data('unitQuickAddBound')) {
                    return;
                }
                $container.data('unitQuickAddBound', true);

                setupUnitQuickAddContainer($container, $);
            });
        }

        function setupUnitQuickAddContainer($container, $) {
            const $formWrapper = $container.find('[data-unit-quick-add-form]');
            const targetSelectSelector = $formWrapper.data('unit-select');
            const $cancelBtn = $container.find('[data-unit-quick-add-cancel]');
            const $submitBtn = $container.find('[data-unit-quick-add-submit]');

            const getField = (name) => $formWrapper.find(`[data-unit-field="${name}"]`);

            const resetFields = () => {
                getField('code').val('');
                getField('name').val('');
                getField('symbol').val('');
            };

            $cancelBtn.on('click', function () {
                resetFields();
                $container.addClass('hidden');
            });

            $submitBtn.on('click', function () {
                const payload = {
                    code: getField('code').val().trim(),
                    name: getField('name').val().trim(),
                    symbol: getField('symbol').val().trim(),
                    is_active: getField('is_active').val() || 1,
                };

                if (!payload.code || !payload.name) {
                    if (typeof window.showError === 'function') {
                        window.showError('Please enter both unit code and name.');
                    }
                    return;
                }

                const originalHtml = $submitBtn.html();
                $submitBtn.prop('disabled', true)
                    .html('<i class="w-4 h-4 mr-2 animate-spin" data-lucide="loader"></i> Saving');

                $.ajax({
                    url: unitStoreUrl,
                    method: 'POST',
                    data: {
                        ...payload,
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (response) {
                        if (response.success && response.unit) {
                            updateUnitSelects(response.unit);
                            if (targetSelectSelector) {
                                const $targetSelect = $(targetSelectSelector);
                                if ($targetSelect.length) {
                                    $targetSelect.val(response.unit.id).trigger('change');
                                }
                            }

                            if (typeof window.showSuccess === 'function') {
                                window.showSuccess(response.message || 'Unit created successfully');
                            }

                            resetFields();
                            $container.addClass('hidden');
                        } else if (typeof window.showError === 'function') {
                            window.showError(response.message || 'Failed to create unit.');
                        }
                    },
                    error: function (xhr) {
                        let message = xhr.responseJSON?.message || 'Failed to create unit.';
                        if (xhr.status === 422 && xhr.responseJSON?.errors) {
                            message = Object.values(xhr.responseJSON.errors).flat().join('\n');
                        }

                        if (typeof window.showError === 'function') {
                            window.showError(message);
                        }
                    },
                    complete: function () {
                        $submitBtn.prop('disabled', false).html(originalHtml);
                        if (typeof lucide !== 'undefined' && typeof lucide.createIcons === 'function') {
                            lucide.createIcons();
                        }
                    }
                });
            });
        }

        function updateUnitSelects(unit) {
            const jq = window.jQuery || window.$;
            if (!jq) {
                return;
            }

            const $ = jq;
            const label = formatUnitLabel(unit);
            ['#create-unit', '#edit-unit'].forEach(function (selector) {
                const $select = $(selector);
                if (!$select.length) {
                    return;
                }

                let $option = $select.find(`option[value="${unit.id}"]`);
                if (!$option.length) {
                    const newOption = new Option(label, unit.id, false, false);
                    $select.append(newOption);
                } else {
                    $option.text(label);
                }
            });
        }

        function formatUnitLabel(unit) {
            if (!unit) {
                return '';
            }

            return unit.symbol ? `${unit.name} (${unit.symbol})` : unit.name;
        }

        function applyFilters() {
            materialsTable.ajax.reload();
            updateActiveFiltersIndicator();
        }

        function clearFilters() {
            $('#category-filter').val('');
            $('#status-filter').val('');
            $('#search-filter').val('');
            materialsTable.ajax.reload();
            updateActiveFiltersIndicator();
        }

        function updateActiveFiltersIndicator() {
            const hasActiveFilters = $('#category-filter').val() || $('#status-filter').val() || $('#search-filter').val();
            $('#active-filters-indicator').toggleClass('hidden', !hasActiveFilters);
        }

        // Global functions for modal interactions
        window.editMaterial = function(id) {
            const jq = window.jQuery || window.$;
            if (!jq) {
                console.error('jQuery not available for editMaterial.');
                return;
            }

            jq.get('{{ route("warehouse.materials.show", ":id") }}'.replace(':id', id))
                .done(function(response) {
                    if (response.success) {
                        populateEditModal(response.material);
                        const trigger = document.getElementById('edit-material-trigger');
                        if (trigger) {
                            trigger.click();
                        }
                    }
                });
        };

        window.deleteMaterial = function(id, name) {
            const jq = window.jQuery || window.$;
            if (!jq) {
                console.error('jQuery not available for deleteMaterial.');
                return;
            }

            if (typeof window.confirmDelete === 'function') {
                window.confirmDelete(name, function() {
                    jq.ajax({
                        url: '{{ route("warehouse.materials.destroy", ":id") }}'.replace(':id', id),
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").getAttribute('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                if (materialsTable) {
                                    materialsTable.ajax.reload();
                                }

                                if (typeof window.showSuccess === 'function') {
                                    window.showSuccess(response.message || 'Material has been deleted');
                                }
                            } else if (typeof window.showError === 'function') {
                                window.showError(response.message || 'Failed to delete material.');
                            }
                        },
                        error: function(xhr) {
                            if (typeof window.showError === 'function') {
                                window.showError('An error occurred while deleting the material.');
                            }
                        }
                    });
                });
            } else {
                // Fallback - just run delete without confirmation
                jq.ajax({
                    url: '{{ route("warehouse.materials.destroy", ":id") }}'.replace(':id', id),
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").getAttribute('content')
                    },
                    success: function(response) {
                        if (response.success && materialsTable) {
                            materialsTable.ajax.reload();
                        }
                    }
                });
            }
        };
    </script>
@endpush

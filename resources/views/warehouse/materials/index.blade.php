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
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Materials Management</h2>
        <div class="flex items-center gap-2">
            <button
                type="button"
                class="btn-tonal btn-tonal--info hidden sm:flex group"
                data-tw-toggle="modal"
                data-tw-target="#materials-filters-slideover"
            >
                <x-base.lucide icon="filter" class="w-4 h-4 icon-hover-rise" />
                Filters
                <span id="active-filters-indicator" class="hidden ml-2 px-2 py-0.5 text-xs bg-white/20 rounded-full">Active</span>
            </button>

            <!-- Mobile filters icon -->
            <button
                type="button"
                class="btn-tonal btn-tonal--info btn-tonal--icon sm:hidden"
                data-tw-toggle="modal"
                data-tw-target="#materials-filters-slideover"
                title="Filters"
            >
                <x-base.lucide icon="filter" class="w-4 h-4" />
            </button>

            <button
                type="button"
                id="open-create-material-modal"
                class="btn-tonal btn-tonal--success w-32 sm:w-auto sm:ml-2 group"
                data-tw-toggle="modal"
                data-tw-target="#create-material-modal"
            >
                <x-base.lucide icon="plus-circle" class="w-5 h-5 icon-hover-rise" />
                Add Material
            </button>
        </div>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <!-- Materials Table -->
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    <div class="overflow-x-auto sm:overflow-visible" data-erp-table-wrapper>
                        <table
                            id="materials-table"
                            data-tw-merge
                            data-erp-table
                            class="datatable-default w-full min-w-full table-auto text-left text-sm"
                        >
                            <thead>
                                <tr>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Code</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Name</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Category</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Unit</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Price</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Status</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </x-base.preview-component>
        </div>
    </div>

    <!-- Materials Filters Slide Over -->
    <x-base.slideover id="materials-filters-slideover" size="md">
        <x-base.slideover.panel>
            <a
                class="absolute top-0 left-0 right-auto mt-4 -ml-10 sm:-ml-12"
                data-tw-dismiss="modal"
                href="#"
            >
                <x-base.lucide class="h-8 w-8 text-slate-400" icon="X" />
            </a>
            <x-base.slideover.title class="border-b border-slate-200/60 p-5 dark:border-darkmode-400">
                <h2 class="mr-auto text-base font-medium flex items-center gap-2">
                    <x-base.lucide icon="Filter" class="h-5 w-5" />
                    Materials Filters
                </h2>
            </x-base.slideover.title>

            <x-base.slideover.description class="p-5">
                <div class="mb-4 text-sm text-slate-600 dark:text-slate-400">
                    Use these filters to narrow down the materials list. Click "Apply" to update the table.
                </div>

                <div class="grid grid-cols-12 gap-4">
                    <!-- Category Filter -->
                    <div class="col-span-12">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Filter by Category
                        </label>
                        <x-base.form-select id="category-filter" class="w-full">
                            <option value="">All Categories</option>
                            @foreach($categories ?? [] as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </x-base.form-select>
                    </div>

                    <!-- Status Filter -->
                    <div class="col-span-12">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Status
                        </label>
                        <x-base.form-select id="status-filter" class="w-full">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </x-base.form-select>
                    </div>

                    <!-- Search Filter -->
                    <div class="col-span-12">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Search
                        </label>
                        <x-base.form-input
                            id="search-filter"
                            type="text"
                            placeholder="Search materials..."
                            class="w-full"
                        />
                    </div>
                </div>

                <div class="mt-5 flex justify-end gap-2 flex-wrap">
                    <button
                        type="button"
                        class="btn-tonal btn-tonal--amber w-full sm:w-auto group"
                        onclick="clearFilters()"
                    >
                        <x-base.lucide icon="rotate-ccw" class="mr-2 h-4 w-4" />
                        Clear
                    </button>
                    <button
                        id="materials-filter-apply"
                        type="button"
                        class="btn-tonal btn-tonal--info w-full sm:w-auto group"
                        onclick="applyFilters()"
                    >
                        <x-base.lucide icon="search" class="mr-2 h-4 w-4" />
                        Apply
                    </button>
                </div>
            </x-base.slideover.description>
        </x-base.slideover.panel>
    </x-base.slideover>

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
                    { data: 'price', name: 'price', render: function(data) { return '{{ config("app.currency", "$") }}' + parseFloat(data).toFixed(2); } },
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
                // Fallback simple confirm if confirmDelete is not available
                if (window.confirm(`Delete material "${name}"?`)) {
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
            }
        };
    </script>
@endpush

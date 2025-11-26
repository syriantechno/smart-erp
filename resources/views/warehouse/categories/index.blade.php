@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Categories Management - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">
@endpush

@section('subcontent')
    @include('components.global-notifications')

    {{-- Heading + top stats strip on the same row (Departments template matches Positions) --}}
    <div class="intro-y mt-6 mb-2 flex flex-col gap-1 text-[#3a2a1a]">
        <div class="flex items-baseline justify-between gap-6">
            <h2 class="flex items-center gap-2 text-2xl md:text-3xl font-semibold text-royalDark tracking-wide">
                <x-base.lucide icon="tag" class="w-7 h-7" />
                <span>Categories Management</span>
            </h2>

            <div class="flex flex-row items-end gap-8 md:gap-12 justify-end">
                {{-- Inactive categories --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="pause-circle" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $inactiveCategories ?? '—' }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Inactive
                    </div>
                </div>

                {{-- Active categories --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="check-circle-2" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $activeCategories ?? '—' }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Active
                    </div>
                </div>

                {{-- Total categories --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="tag" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $totalCategories ?? '—' }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Categories
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        function renderCategoryOptions($categories, $level = 0) {
            foreach ($categories as $category) {
                $indent = str_repeat('&nbsp;', $level * 4);
                echo '<option value="' . $category->id . '">' . $indent . $category->name . '</option>';
                if ($category->children && $category->children->count() > 0) {
                    renderCategoryOptions($category->children, $level + 1);
                }
            }
        }
    @endphp

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <x-base.preview-component class="intro-y box bg-white/80 border border-slate-200/70 shadow-[0_18px_45px_rgba(15,23,42,0.10)]">
                <div class="p-5">
                    <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                        <form id="categories-filter-form" class="w-full sm:mr-auto xl:flex">
                            <div class="items-center sm:mr-4 sm:flex">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Status
                                </label>
                                <x-base.form-select id="categories-status-filter" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                    <option value="">All Status</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Search
                                </label>
                                <x-base.form-input
                                    id="categories-search-filter"
                                    type="text"
                                    placeholder="Search..."
                                    class="mt-2 w-full sm:mt-0 sm:w-48 2xl:w-full"
                                />
                            </div>
                            <div class="mt-4 flex flex-wrap gap-2 sm:items-center xl:mt-0">
                                <button id="categories-filter-go" type="button" class="btn-royal btn-royal--dark btn-royal--sm w-full sm:w-24 group">
                                    <x-base.lucide icon="search" class="w-4 h-4 icon-hover-rise" />
                                    Go
                                </button>
                                <button id="categories-filter-reset" type="button" class="btn-royal btn-royal--outline btn-royal--sm w-full sm:w-24 group">
                                    <x-base.lucide icon="rotate-ccw" class="w-4 h-4 icon-hover-rise" />
                                    Reset
                                </button>
                            </div>
                        </form>

                        <div class="mt-5 flex flex-wrap items-center gap-2 sm:mt-0 sm:flex-nowrap">
                            <x-base.tippy content="Export PDF" placement="bottom">
                                <button id="categories-pdf" type="button" class="btn-royal btn-royal--outline btn-royal--sm  group text-royalDark">
                                    <x-base.lucide icon="file-text" class="w-5 h-5 icon-hover-rise" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Export" placement="bottom">
                                <button id="categories-export" type="button" class="btn-royal btn-royal--outline btn-royal--sm  group text-royalDark">
                                    <x-base.lucide icon="file-spreadsheet" class="w-5 h-5 icon-hover-rise" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Refresh" placement="bottom">
                                <button id="categories-refresh" type="button" class="btn-royal btn-royal--outline btn-royal--sm  group text-royalDark">
                                    <x-base.lucide icon="refresh-cw" class="w-5 h-5 icon-hover-rise" />
                                </button>
                            </x-base.tippy>

                            {{-- Add Category button at the right end of the toolbar --}}
                            <x-base.tippy content="Add new category" placement="bottom">
                                <button
                                    type="button"
                                    id="open-create-category-modal"
                                    class="btn-royal btn-royal--gold btn-royal--sm sm:btn-royal--lg group"
                                    data-tw-toggle="modal"
                                    data-tw-target="#create-category-modal"
                                >
                                    <x-base.lucide icon="plus-circle" class="w-5 h-5 icon-hover-rise" />
                                    <span class="hidden sm:inline">Add</span>
                                </button>
                            </x-base.tippy>
                        </div>
                    </div>

                    <div class="overflow-x-auto sm:overflow-visible" data-erp-table-wrapper>
                        <table
                            id="categories-table"
                            data-tw-merge
                            data-erp-table
                            class="datatable-default w-full min-w-full table-auto text-left text-sm"
                        >
                            <thead class="bg-gradient-to-r from-royalDark to-gray-800 text-white">
                                <tr>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Code</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Name</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Parent</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Description</th>
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

    <!-- Create Category Modal (unified design) -->
    <x-modal.form id="create-category-modal" title="Add New Category" size="xl">
        <form id="create-category-form">
            @csrf

            <div class="mb-6">
                <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                    <x-base.lucide icon="Layers" class="h-5 w-5"></x-base.lucide>
                    Category Information
                </h4>
                <div class="grid grid-cols-12 gap-4 gap-y-4">
                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="create-category-code">Code</x-base.form-label>
                        <x-base.form-input
                            id="create-category-code"
                            name="code"
                            type="text"
                            class="w-full"
                            placeholder="Category code"
                            required
                            readonly
                        />
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="create-category-name">Name</x-base.form-label>
                        <x-base.form-input
                            id="create-category-name"
                            name="name"
                            type="text"
                            class="w-full"
                            placeholder="Category name"
                            required
                        />
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="create-category-parent">Parent Category</x-base.form-label>
                        <x-base.form-select id="create-category-parent" name="parent_id" class="w-full">
                            <option value="">Root Category</option>
                            @php
                                $rootCategories = \App\Models\Warehouse\Category::whereNull('parent_id')->with('children')->orderBy('name')->get();
                                renderCategoryOptions($rootCategories);
                            @endphp
                        </x-base.form-select>
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="create-category-status">Status</x-base.form-label>
                        <x-base.form-select id="create-category-status" name="is_active" class="w-full" required>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </x-base.form-select>
                    </div>

                    <div class="col-span-12">
                        <x-base.form-label for="create-category-description">Description</x-base.form-label>
                        <x-base.form-textarea
                            id="create-category-description"
                            name="description"
                            class="w-full"
                            rows="3"
                            placeholder="Category description"
                        ></x-base.form-textarea>
                    </div>
                </div>
            </div>
        </form>

        @slot('footer')
            <div class="flex w-full flex-wrap justify-end gap-2">
                <button
                    type="button"
                    class="btn-royal btn-royal--outline group"
                    data-tw-dismiss="modal"
                >
                    <x-base.lucide icon="x-circle" class="w-5 h-5 icon-hover-rise" />
                    Cancel
                </button>
                <button
                    type="submit"
                    form="create-category-form"
                    id="create-category-btn"
                    class="btn-royal btn-royal--gold group"
                >
                    <x-base.lucide icon="save" class="w-5 h-5 icon-hover-rise" />
                    Save Category
                </button>
            </div>
        @endslot

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const jq = window.jQuery || window.$;
                if (!jq) {
                    console.error('jQuery not available for create category modal.');
                    return;
                }

                const $ = jq;
                const form = document.getElementById('create-category-form');
                const submitBtn = $('#create-category-btn');

                if (!form) {
                    return;
                }

                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    const formData = new FormData(form);
                    const originalText = submitBtn.html();

                    submitBtn.prop('disabled', true).html('<i class="w-4 h-4 mr-2 animate-spin" data-lucide="loader"></i> Saving...');

                    $.ajax({
                        url: '{{ route("warehouse.categories.store") }}',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                const modalEl = document.getElementById('create-category-modal');
                                if (modalEl && modalEl.__tippy?.hide) {
                                    modalEl.__tippy.hide();
                                }

                                form.reset();
                                if (window.categoriesTable) {
                                    window.categoriesTable.ajax.reload();
                                }

                                if (typeof window.showSuccess === 'function') {
                                    window.showSuccess(response.message || 'Category created successfully');
                                }
                            } else if (typeof window.showError === 'function') {
                                window.showError(response.message || 'Failed to create category.');
                            }
                        },
                        error: function(xhr) {
                            let errors = xhr.responseJSON?.errors || {};
                            let errorMessage = xhr.responseJSON?.message || 'An error occurred';

                            if (Object.keys(errors).length > 0) {
                                errorMessage = Object.values(errors).flat().join('\n');
                            }

                            if (typeof window.showError === 'function') {
                                window.showError(errorMessage);
                            }
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

    <!-- Edit Category Modal -->
    <x-modal.form id="edit-category-modal" title="Edit Category" size="xl">
        <form id="edit-category-form">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit-category-id" name="id">

            <div class="mb-6">
                <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                    <x-base.lucide icon="Edit" class="h-5 w-5"></x-base.lucide>
                    Category Details
                </h4>
                <div class="grid grid-cols-12 gap-4 gap-y-4">
                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="edit-category-code">Code</x-base.form-label>
                        <x-base.form-input
                            id="edit-category-code"
                            name="code"
                            type="text"
                            class="w-full"
                            placeholder="Category code"
                            required
                        />
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="edit-category-name">Name</x-base.form-label>
                        <x-base.form-input
                            id="edit-category-name"
                            name="name"
                            type="text"
                            class="w-full"
                            placeholder="Category name"
                            required
                        />
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="edit-category-parent">Parent Category</x-base.form-label>
                        <x-base.form-select id="edit-category-parent" name="parent_id" class="w-full">
                            <option value="">Root Category</option>
                            @php
                                $rootCategories = \App\Models\Warehouse\Category::whereNull('parent_id')->with('children')->orderBy('name')->get();
                                renderCategoryOptions($rootCategories);
                            @endphp
                        </x-base.form-select>
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="edit-category-status">Status</x-base.form-label>
                        <x-base.form-select id="edit-category-status" name="is_active" class="w-full" required>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </x-base.form-select>
                    </div>

                    <div class="col-span-12">
                        <x-base.form-label for="edit-category-description">Description</x-base.form-label>
                        <x-base.form-textarea
                            id="edit-category-description"
                            name="description"
                            class="w-full"
                            rows="3"
                            placeholder="Category description"
                        ></x-base.form-textarea>
                    </div>
                </div>
            </div>
        </form>

        @slot('footer')
            <div class="flex w-full flex-wrap justify-end gap-2">
                <button
                    type="button"
                    class="btn-royal btn-royal--outline group"
                    data-tw-dismiss="modal"
                >
                    <x-base.lucide icon="x-circle" class="w-5 h-5 icon-hover-rise" />
                    Cancel
                </button>
                <button
                    type="submit"
                    form="edit-category-form"
                    id="edit-category-btn"
                    class="btn-royal btn-royal--gold group"
                >
                    <x-base.lucide icon="save" class="w-5 h-5 icon-hover-rise" />
                    Update Category
                </button>
            </div>
        @endslot
    </x-modal.form>
@endsection

@include('components.datatable.scripts')

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>

    <script>
        let categoriesTable;

        document.addEventListener('DOMContentLoaded', function () {
            const jq = window.jQuery || window.$;

            if (!jq || typeof jq.fn === 'undefined' || typeof jq.fn.DataTable === 'undefined') {
                console.error('DataTables is not loaded; categories table will not be initialised.');
                return;
            }

            initializeCategoriesDataTable();
            setupCategoriesEventListeners();

            // Auto-generate code when opening create category modal
            const openBtn = document.getElementById('open-create-category-modal');
            if (openBtn) {
                openBtn.addEventListener('click', function () {
                    const $ = jq;
                    const codeInput = document.getElementById('create-category-code');
                    if (!codeInput) {
                        return;
                    }

                    $.get('{{ route("warehouse.categories.preview-code") }}')
                        .done(function (response) {
                            if (response && response.code) {
                                codeInput.value = response.code;
                            }
                        });
                });
            }
        });

        function initializeCategoriesDataTable() {
            categoriesTable = window.erpCrud.initDataTable({
                tableSelector: '#categories-table',
                ajaxUrl: @json(route('warehouse.categories.datatable')),
                ajaxData: function (d) {
                    const statusEl = document.getElementById('categories-status-filter');
                    const searchEl = document.getElementById('categories-search-filter');

                    d.status = statusEl ? statusEl.value : '';
                    d.filter_value = searchEl ? searchEl.value : '';
                    d.filter_field = 'all';
                    d.filter_type = 'contains';
                },
                columns: [
                    { data: 'code', name: 'code' },
                    { data: 'indented_name', name: 'indented_name', orderable: false },
                    {
                        data: 'parent_name',
                        name: 'parent_name',
                        render: function(value) {
                            return value || 'Root';
                        }
                    },
                    { data: 'description', name: 'description' },
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
                pageLength: 25
            });

            window.categoriesTable = categoriesTable;

            if (!categoriesTable) {
                return;
            }

            categoriesTable.on('draw', function () {
                if (typeof window.lucide !== 'undefined' && window.lucide.createIcons) {
                    window.lucide.createIcons();
                }
            });
        }

        function setupCategoriesEventListeners() {
            const jq = window.jQuery || window.$;
            if (!jq) {
                return;
            }

            const pdfBtn = jq('#categories-pdf');
            const exportBtn = jq('#categories-export');
            const refreshBtn = jq('#categories-refresh');

            jq('#categories-search-filter').on('keypress', function (e) {
                if (e.which === 13) {
                    applyCategoriesFilters();
                }
            });

            jq('#categories-status-filter').on('change', function () {
                applyCategoriesFilters();
            });

            if (pdfBtn.length) {
                pdfBtn.on('click', function () {
                    showToast('PDF export functionality not implemented yet', 'info');
                });
            }

            if (exportBtn.length) {
                exportBtn.on('click', function () {
                    if (window.erpCrud && typeof window.erpCrud.exportDataTable === 'function') {
                        window.erpCrud.exportDataTable(categoriesTable, 'categories');
                    } else {
                        showToast('Export functionality not available', 'error');
                    }
                });
            }

            if (refreshBtn.length) {
                refreshBtn.on('click', function () {
                    if (categoriesTable) {
                        categoriesTable.ajax.reload();
                        showToast('Data refreshed', 'success');
                    }
                });
            }
        }

        function applyCategoriesFilters() {
            if (categoriesTable) {
                categoriesTable.ajax.reload();
            }
        }

        window.editCategory = function(id) {
            const jq = window.jQuery || window.$;
            if (!jq) {
                return;
            }

            jq.get('{{ route("warehouse.categories.show", ":id") }}'.replace(':id', id))
                .done(function(response) {
                    if (response.success) {
                        populateEditCategoryModal(response.category);
                        const modalEl = document.getElementById('edit-category-modal');
                        if (modalEl) {
                            const instance = tailwind.Modal.getOrCreateInstance(modalEl);
                            instance.show();
                        }
                    }
                });
        };

        function populateEditCategoryModal(category) {
            const jq = window.jQuery || window.$;
            if (!jq) {
                return;
            }

            jq('#edit-category-id').val(category.id);
            jq('#edit-category-code').val(category.code);
            jq('#edit-category-name').val(category.name);
            jq('#edit-category-description').val(category.description || '');
            jq('#edit-category-status').val(category.is_active ? '1' : '0');
            jq('#edit-category-parent').val(category.parent_id || '');
        }

        window.deleteCategory = function(id, name) {
            const jq = window.jQuery || window.$;
            if (!jq) {
                return;
            }

            if (typeof window.confirmDelete === 'function') {
                window.confirmDelete(name, function() {
                    jq.ajax({
                        url: '{{ route("warehouse.categories.destroy", ":id") }}'.replace(':id', id),
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").getAttribute('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                if (categoriesTable) {
                                    categoriesTable.ajax.reload();
                                }
                                if (typeof window.showSuccess === 'function') {
                                    window.showSuccess(response.message || 'Category deleted successfully');
                                }
                            } else if (typeof window.showError === 'function') {
                                window.showError(response.message || 'Failed to delete category.');
                            }
                        },
                        error: function() {
                            if (typeof window.showError === 'function') {
                                window.showError('Failed to delete category.');
                            }
                        }
                    });
                });
            } else {
                // Fallback - just run delete
                jq.ajax({
                    url: '{{ route("warehouse.categories.destroy", ":id") }}'.replace(':id', id),
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").getAttribute('content')
                    },
                    success: function(response) {
                        if (response.success && categoriesTable) {
                            categoriesTable.ajax.reload();
                        }
                    }
                });
            }
        };

        document.addEventListener('DOMContentLoaded', function () {
            const jq = window.jQuery || window.$;
            if (!jq) {
                return;
            }

            jq('#edit-category-form').on('submit', function (e) {
                e.preventDefault();

                const formData = new FormData(this);
                const categoryId = jq('#edit-category-id').val();
                const submitBtn = jq('#edit-category-btn');
                const originalText = submitBtn.html();

                submitBtn.prop('disabled', true).html('<i class="w-4 h-4 mr-2 animate-spin" data-lucide="loader"></i> Updating...');

                jq.ajax({
                    url: '{{ route("warehouse.categories.update", ":id") }}'.replace(':id', categoryId),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").getAttribute('content')
                    },
                    success: function (response) {
                        if (response.success) {
                            const modalEl = document.getElementById('edit-category-modal');
                            if (modalEl) {
                                const instance = tailwind.Modal.getOrCreateInstance(modalEl);
                                instance.hide();
                            }
                            if (categoriesTable) {
                                categoriesTable.ajax.reload();
                            }
                            if (typeof window.showSuccess === 'function') {
                                window.showSuccess(response.message || 'Category updated successfully');
                            }
                        } else if (typeof window.showError === 'function') {
                            window.showError(response.message || 'Failed to update category.');
                        }
                    },
                    error: function (xhr) {
                        const errors = xhr.responseJSON?.errors || {};
                        let errorMessage = xhr.responseJSON?.message || 'An error occurred';

                        if (Object.keys(errors).length > 0) {
                            errorMessage = Object.values(errors).flat().join('\n');
                        }

                        if (typeof window.showError === 'function') {
                            window.showError(errorMessage);
                        }
                    },
                    complete: function () {
                        submitBtn.prop('disabled', false).html(originalText);
                        if (typeof window.lucide !== 'undefined' && window.lucide.createIcons) {
                            window.lucide.createIcons();
                        }
                    }
                });
            });
        });
    </script>
@endpush

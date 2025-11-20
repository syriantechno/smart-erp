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
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Categories Management</h2>
        <button
            type="button"
            id="open-create-category-modal"
            class="btn-tonal btn-tonal--info w-40 sm:w-auto sm:ml-4 group"
            data-tw-toggle="modal"
            data-tw-target="#create-category-modal"
        >
            <x-base.lucide icon="plus-circle" class="w-5 h-5 icon-hover-rise" />
            Add Category
        </button>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <!-- Categories Table -->
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    <div class="overflow-x-auto sm:overflow-visible" data-erp-table-wrapper>
                        <table
                            id="categories-table"
                            data-tw-merge
                            data-erp-table
                            class="datatable-default w-full min-w-full table-auto text-left text-sm"
                        >
                            <thead>
                                <tr>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Code</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Name</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Description</th>
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
                            @foreach(\App\Models\Warehouse\Category::orderBy('name')->get() as $parentCategory)
                                <option value="{{ $parentCategory->id }}">{{ $parentCategory->name }}</option>
                            @endforeach
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
                    class="btn-tonal btn-tonal--neutral group"
                    data-tw-dismiss="modal"
                >
                    <x-base.lucide icon="x-circle" class="w-5 h-5 icon-hover-rise" />
                    Cancel
                </button>
                <button
                    type="submit"
                    form="create-category-form"
                    id="create-category-btn"
                    class="btn-tonal btn-tonal--success group"
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
                            @foreach(\App\Models\Warehouse\Category::orderBy('name')->get() as $parentCategory)
                                <option value="{{ $parentCategory->id }}">{{ $parentCategory->name }}</option>
                            @endforeach
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
                    class="btn-tonal btn-tonal--neutral group"
                    data-tw-dismiss="modal"
                >
                    <x-base.lucide icon="x-circle" class="w-5 h-5 icon-hover-rise" />
                    Cancel
                </button>
                <button
                    type="submit"
                    form="edit-category-form"
                    id="edit-category-btn"
                    class="btn-tonal btn-tonal--success group"
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
                columns: [
                    { data: 'code', name: 'code' },
                    { data: 'name', name: 'name' },
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
                if (window.confirm(`Delete category "${name}"?`)) {
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

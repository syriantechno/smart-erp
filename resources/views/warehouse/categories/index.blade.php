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
        <x-base.button
            id="open-create-category-modal"
            variant="primary"
            class="w-40 sm:w-auto sm:ml-4"
            data-tw-toggle="modal"
            data-tw-target="#create-category-modal"
        >
            <x-base.lucide icon="Plus" class="w-4 h-4 mr-2" />
            Add Category
        </x-base.button>
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
                            @foreach(\App\Models\Category::orderBy('name')->get() as $parentCategory)
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
                    form="create-category-form"
                    id="create-category-btn"
                    variant="primary"
                >
                    <x-base.lucide icon="Save" class="w-4 h-4 mr-2" />
                    Save Category
                </x-base.button>
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
            categoriesTable = window.initDataTable('#categories-table', {
                ajax: {
                    url: @json(route('warehouse.categories.datatable')),
                    type: 'GET',
                },
                columns: [
                    { data: 'code', name: 'code' },
                    { data: 'name', name: 'name' },
                    { data: 'description', name: 'description' },
                    { data: 'status_badge', name: 'status_badge', orderable: false, searchable: false },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ],
                pageLength: 25,
                lengthChange: false,
                searching: false,
                dom:
                    "t<'datatable-footer flex flex-col md:flex-row md:items-center md:justify-between mt-5 gap-4'<'datatable-info text-slate-500'i><'datatable-pagination'p>>",
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

        window.editCategory = function(id) {
            const jq = window.jQuery || window.$;
            if (!jq) {
                return;
            }

            jq.get('{{ route("warehouse.categories.show", ":id") }}'.replace(':id', id))
                .done(function(response) {
                    if (response.success && typeof window.populateEditWarehouseModal === 'function') {
                        window.populateEditWarehouseModal(response.category);
                        jq('#edit-warehouse-modal').modal('show');
                    }
                });
        };

        window.deleteCategory = function(id, name) {
            const jq = window.jQuery || window.$;
            if (!jq) {
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: `Delete category "${name}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
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
                                Swal.fire('Deleted!', response.message, 'success');
                            } else {
                                Swal.fire('Error!', response.message || 'Failed to delete category.', 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error!', 'Failed to delete category.', 'error');
                        }
                    });
                }
            });
        };
    </script>
@endpush

<!-- Edit Material Modal -->
<x-modal.form id="edit-material-modal" title="Edit Material" size="xl">
    <form id="edit-material-form" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" id="edit-material-id" name="id">

        <div class="mb-6">
            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <x-base.lucide icon="Package" class="h-5 w-5"></x-base.lucide>
                Material Information
            </h4>
            <div class="grid grid-cols-12 gap-4 gap-y-4">
                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="edit-code">Code</x-base.form-label>
                    <x-base.form-input
                        id="edit-code"
                        name="code"
                        type="text"
                        class="w-full"
                        placeholder="Material code"
                        required
                    />
                </div>

                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="edit-name">Name</x-base.form-label>
                    <x-base.form-input
                        id="edit-name"
                        name="name"
                        type="text"
                        class="w-full"
                        placeholder="Material name"
                        required
                    />
                </div>

                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="edit-category">Category</x-base.form-label>
                    <x-base.form-select id="edit-category" name="category_id" class="w-full" required>
                        <option value="">Select Category</option>
                        @foreach($categories ?? [] as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>

                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="edit-unit">Unit</x-base.form-label>
                    <x-base.form-select id="edit-unit" name="unit" class="w-full" required>
                        <option value="piece">Piece</option>
                        <option value="kg">Kilogram</option>
                        <option value="liter">Liter</option>
                        <option value="meter">Meter</option>
                    </x-base.form-select>
                </div>

                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="edit-price">Price</x-base.form-label>
                    <x-base.form-input
                        id="edit-price"
                        name="price"
                        type="number"
                        step="0.01"
                        min="0"
                        class="w-full"
                        placeholder="0.00"
                        required
                    />
                </div>

                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="edit-status">Status</x-base.form-label>
                    <x-base.form-select id="edit-status" name="is_active" class="w-full" required>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </x-base.form-select>
                </div>

                <div class="col-span-12">
                    <x-base.form-label for="edit-description">Description</x-base.form-label>
                    <x-base.form-textarea
                        id="edit-description"
                        name="description"
                        class="w-full"
                        rows="3"
                        placeholder="Material description"
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
                form="edit-material-form"
                id="edit-material-btn"
                variant="primary"
            >
                <x-base.lucide icon="Save" class="w-4 h-4 mr-2" />
                Update Material
            </x-base.button>
        </div>
    @endslot

    <script>
        function populateEditModal(material) {
            const jq = window.jQuery || window.$;
            const useDom = !jq;

            if (useDom) {
                document.getElementById('edit-material-id').value = material.id;
                document.getElementById('edit-code').value = material.code;
                document.getElementById('edit-name').value = material.name;
                document.getElementById('edit-category').value = material.category_id;
                document.getElementById('edit-unit').value = material.unit;
                document.getElementById('edit-price').value = material.price;
                document.getElementById('edit-status').value = material.is_active ? '1' : '0';
                document.getElementById('edit-description').value = material.description || '';
                return;
            }

            const $ = jq;
            $('#edit-material-id').val(material.id);
            $('#edit-code').val(material.code);
            $('#edit-name').val(material.name);
            $('#edit-category').val(material.category_id);
            $('#edit-unit').val(material.unit);
            $('#edit-price').val(material.price);
            $('#edit-status').val(material.is_active ? '1' : '0');
            $('#edit-description').val(material.description);
        }

        document.addEventListener('DOMContentLoaded', function () {
            const jq = window.jQuery || window.$;
            if (!jq) {
                console.error('jQuery not available for edit material modal.');
                return;
            }

            const $ = jq;
            const form = document.getElementById('edit-material-form');
            const submitBtn = $('#edit-material-btn');

            if (!form) {
                return;
            }

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                const materialId = document.getElementById('edit-material-id').value;
                const formData = new FormData(form);
                const originalText = submitBtn.html();

                submitBtn.prop('disabled', true).html('<i class="w-4 h-4 mr-2 animate-spin" data-lucide="loader"></i> Updating...');

                $.ajax({
                    url: '{{ route("warehouse.materials.update", ":id") }}'.replace(':id', materialId),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            const modalEl = document.getElementById('edit-material-modal');
                            if (modalEl && modalEl.__tippy?.hide) {
                                modalEl.__tippy.hide();
                            }

                            if (window.materialsTable) {
                                window.materialsTable.ajax.reload();
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

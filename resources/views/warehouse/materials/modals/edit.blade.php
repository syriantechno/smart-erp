<!-- Edit Material Modal -->
<x-modal.form id="edit-material-modal" title="Edit Material" size="xl">
    <form id="edit-material-form" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" id="edit-material-id" name="id">
        <input type="hidden" id="edit-remove-image" name="remove_image" value="0">

        <div class="mb-6">
            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <x-base.lucide icon="Package" class="h-5 w-5"></x-base.lucide>
                Material Information
            </h4>
            <div class="grid grid-cols-12 gap-4 gap-y-4">
                <!-- Row 1: Code, Name -->
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

                <!-- Row 2: Category, Unit -->
                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="edit-category">Category</x-base.form-label>
                    <x-base.form-select id="edit-category" name="category_id" class="w-full" required>
                        <option value="">Select Category</option>
                        <!-- Categories will be populated by JavaScript -->
                    </x-base.form-select>
                </div>

                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="edit-unit">Unit</x-base.form-label>
                    <div class="flex gap-2">
                        <x-base.form-select id="edit-unit" name="unit_id" class="w-full" required>
                            <option value="">Select Unit</option>
                            <!-- Units will be populated by JavaScript -->
                        </x-base.form-select>
                        <button
                            type="button"
                            class="btn-royal btn-royal--action btn-royal--primary  h-10 w-10 mt-auto"
                            data-unit-quick-add-toggle
                            data-target="#edit-unit-quick-add"
                            title="Add Unit"
                        >
                            <x-base.lucide icon="Plus" class="h-4 w-4" />
                        </button>
                    </div>
                    <div id="edit-unit-quick-add" class="mt-3 hidden" data-unit-quick-add>
                        <div class="rounded-xl border border-dashed border-slate-200 bg-slate-50 p-3 dark:border-darkmode-400 dark:bg-darkmode-700/40">
                            <div data-unit-quick-add-form data-unit-select="#edit-unit">
                                <div class="grid gap-3">
                                    <div class="space-y-1">
                                        <x-base.form-label for="edit-unit-code" class="text-xs font-medium">Code</x-base.form-label>
                                        <x-base.form-input
                                            id="edit-unit-code"
                                            type="text"
                                            class="w-full"
                                            placeholder="Code (e.g. PCS)"
                                            data-unit-field="code"
                                            autocomplete="off"
                                        />
                                    </div>

                                    <div class="space-y-1">
                                        <x-base.form-label for="edit-unit-name" class="text-xs font-medium">Unit Name</x-base.form-label>
                                        <x-base.form-input
                                            id="edit-unit-name"
                                            type="text"
                                            class="w-full"
                                            placeholder="Unit Name"
                                            data-unit-field="name"
                                            autocomplete="off"
                                        />
                                    </div>

                                    <div class="space-y-1">
                                        <x-base.form-label for="edit-unit-symbol" class="text-xs font-medium">Symbol <span class="text-[10px] text-slate-400">(optional)</span></x-base.form-label>
                                        <x-base.form-input
                                            id="edit-unit-symbol"
                                            type="text"
                                            class="w-full"
                                            placeholder="Symbol (optional)"
                                            data-unit-field="symbol"
                                            autocomplete="off"
                                        />
                                    </div>

                                    <input type="hidden" data-unit-field="is_active" value="1" />

                                    <div class="flex justify-end gap-2 pt-1">
                                        <button type="button" class="btn-royal btn-royal--outline btn-royal--sm" data-unit-quick-add-cancel>
                                            <x-base.lucide icon="X" class="h-4 w-4" />
                                            Cancel
                                        </button>
                                        <button type="button" class="btn-royal btn-royal--gold btn-royal--sm" data-unit-quick-add-submit>
                                            <x-base.lucide icon="Save" class="h-4 w-4" />
                                            Save Unit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Row 3: Price, Opening Balance -->
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
                    <x-base.form-label for="edit-opening-quantity">Opening Balance</x-base.form-label>
                    <div class="grid grid-cols-12 gap-2">
                        <div class="col-span-12 sm:col-span-7">
                            <x-base.form-select id="edit-opening-warehouse" name="opening_warehouse_id" class="w-full">
                                <option value="">Select Warehouse</option>
                                @foreach(($warehouses ?? []) as $warehouse)
                                    <option value="{{ $warehouse->id }}">
                                        {{ $warehouse->name }}@if($warehouse->location) — {{ $warehouse->location }} @endif
                                    </option>
                                @endforeach
                            </x-base.form-select>
                        </div>
                        <div class="col-span-12 sm:col-span-5">
                            <x-base.form-input
                                id="edit-opening-quantity"
                                name="opening_quantity"
                                type="number"
                                step="0.0001"
                                min="0"
                                class="w-full"
                                placeholder="0.0000"
                            />
                        </div>
                    </div>
                </div>

                <!-- Row 4: SKU, Barcode -->
                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="edit-sku" class="flex items-center gap-2">
                        SKU
                        <span class="text-xs font-normal text-slate-400">(Optional)</span>
                    </x-base.form-label>
                    <x-base.form-input
                        id="edit-sku"
                        name="sku"
                        type="text"
                        class="w-full"
                        placeholder="Internal stock code"
                    />
                </div>

                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="edit-barcode" class="flex items-center gap-2">
                        Barcode
                        <span class="text-xs font-normal text-slate-400">(Optional)</span>
                    </x-base.form-label>
                    <x-base.form-input
                        id="edit-barcode"
                        name="barcode"
                        type="text"
                        class="w-full"
                        placeholder="EAN / UPC"
                    />
                </div>

                <!-- Row 5: Status on its own line -->
                <div class="col-span-12 md:col-span-4 lg:col-span-3">
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

                <div class="col-span-12">
                    <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50/70 p-4 dark:border-darkmode-400 dark:bg-darkmode-700/40">
                        <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
                            <div>
                                <p class="text-sm font-semibold text-slate-700 dark:text-slate-100">Material Image</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">Optional — recommended size 800x600px</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <label for="edit-material-image" class="btn-royal btn-royal--action btn-royal--primary cursor-pointer flex items-center gap-2">
                                    <x-base.lucide icon="Upload" class="h-4 w-4" />
                                    Upload
                                </label>
                                <button type="button" id="edit-material-image-remove" class="btn-royal btn-royal--action btn-royal--danger hidden">
                                    <x-base.lucide icon="Trash2" class="h-4 w-4" />
                                    Remove
                                </button>
                            </div>
                        </div>

                        <input type="file" id="edit-material-image" name="image" accept="image/*" class="hidden">
                        <div class="relative w-full h-48 sm:h-56 overflow-hidden rounded-xl border border-slate-200 bg-white/70 dark:border-darkmode-400">
                            <img id="edit-material-image-preview" class="hidden h-full w-full object-cover" alt="Material preview" />
                            <div id="edit-material-image-placeholder" class="flex h-full flex-col items-center justify-center gap-2 text-center text-slate-500">
                                <x-base.lucide icon="Image" class="h-10 w-10 text-slate-300" />
                                <div>
                                    <p class="text-sm font-semibold">No image selected</p>
                                    <p class="text-xs text-slate-400">Upload a cover photo or keep existing</p>
                                </div>
                            </div>
                        </div>
                    </div>
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
                form="edit-material-form"
                id="edit-material-btn"
                class="btn-royal btn-royal--gold group"
            >
                <x-base.lucide icon="save" class="w-5 h-5 icon-hover-rise" />
                Update Material
            </button>
        </div>
    @endslot

    <script>
        function populateEditModal(material) {
            const jq = window.jQuery || window.$;
            const useDom = !jq;

            const fillInputs = () => {
                document.getElementById('edit-material-id').value = material.id;
                document.getElementById('edit-remove-image').value = '0';
                document.getElementById('edit-code').value = material.code;
                document.getElementById('edit-name').value = material.name;
                document.getElementById('edit-category').value = material.category_id;
                document.getElementById('edit-unit').value = material.unit_id ?? material.unit?.id ?? material.unit;
                document.getElementById('edit-sku').value = material.sku || '';
                document.getElementById('edit-barcode').value = material.barcode || '';
                document.getElementById('edit-price').value = material.price;
                document.getElementById('edit-opening-quantity').value = material.opening_quantity ?? '';
                document.getElementById('edit-status').value = material.is_active ? '1' : '0';
                document.getElementById('edit-description').value = material.description || '';

                const preview = document.getElementById('edit-material-image-preview');
                const placeholder = document.getElementById('edit-material-image-placeholder');
                const removeButton = document.getElementById('edit-material-image-remove');
                const imageInput = document.getElementById('edit-material-image');

                if (imageInput) {
                    imageInput.value = '';
                }

                if (material.image_url) {
                    preview.src = material.image_url;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                    removeButton.classList.remove('hidden');
                } else {
                    preview.src = '';
                    preview.classList.add('hidden');
                    placeholder.classList.remove('hidden');
                    removeButton.classList.add('hidden');
                }
            };

            if (useDom) {
                fillInputs();
                return;
            }

            fillInputs();
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
            
            // Populate categories and units dropdowns
            populateDropdowns();

            const imageInput = document.getElementById('edit-material-image');
            const previewImage = document.getElementById('edit-material-image-preview');
            const placeholder = document.getElementById('edit-material-image-placeholder');
            const removeBtn = document.getElementById('edit-material-image-remove');
            const removeInput = document.getElementById('edit-remove-image');

            if (!form) {
                return;
            }

            function populateDropdowns() {
                // Populate categories
                const categorySelect = $('#edit-category');
                if (window.materialsCategories && window.materialsCategories.length > 0) {
                    window.materialsCategories.forEach(function(category) {
                        categorySelect.append('<option value="' + category.id + '">' + category.name + '</option>');
                    });
                }

                // Populate units
                const unitSelect = $('#edit-unit');
                if (window.materialsUnits && window.materialsUnits.length > 0) {
                    window.materialsUnits.forEach(function(unit) {
                        const label = unit.symbol ? unit.name + ' (' + unit.symbol + ')' : unit.name;
                        unitSelect.append('<option value="' + unit.id + '">' + label + '</option>');
                    });
                }
            }

            const resetImagePreview = () => {
                if (previewImage) {
                    previewImage.src = '';
                    previewImage.classList.add('hidden');
                }
                placeholder?.classList.remove('hidden');
                removeBtn?.classList.add('hidden');
                if (imageInput) {
                    imageInput.value = '';
                }
            };

            const setImagePreview = (file) => {
                if (!file || !previewImage) {
                    resetImagePreview();
                    return;
                }

                const reader = new FileReader();
                reader.onload = (e) => {
                    previewImage.src = e.target?.result;
                    previewImage.classList.remove('hidden');
                    placeholder?.classList.add('hidden');
                    removeBtn?.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            };

            imageInput?.addEventListener('change', () => {
                const file = imageInput.files?.[0];
                if (file) {
                    setImagePreview(file);
                    if (removeInput) {
                        removeInput.value = '0';
                    }
                }
            });

            removeBtn?.addEventListener('click', () => {
                resetImagePreview();
                if (removeInput) {
                    removeInput.value = '1';
                }
            });

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
                            if (modalEl && typeof tailwind !== 'undefined' && tailwind.Modal) {
                                const instance = tailwind.Modal.getOrCreateInstance(modalEl);
                                instance.hide();
                            }

                            if (window.materialsTable) {
                                window.materialsTable.ajax.reload();
                            }

                            if (typeof window.showSuccess === 'function') {
                                window.showSuccess(response.message || 'Material updated successfully');
                            }

                            resetImagePreview();
                            if (removeInput) {
                                removeInput.value = '0';
                            }
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

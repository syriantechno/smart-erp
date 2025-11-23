<!-- Create Material Modal -->
<x-modal.form id="create-material-modal" title="Add New Material" size="xl">
    <form id="create-material-form" enctype="multipart/form-data">
        @csrf

        <div class="mb-6">
            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <x-base.lucide icon="package" class="h-5 w-5"></x-base.lucide>
                Material Information
            </h4>
            <div class="grid grid-cols-12 gap-4 gap-y-4">
                <!-- First Row: Code, Name, Category, Unit, Status -->
                <div class="col-span-12 md:col-span-2 xl:col-span-15/100">
                    <x-base.form-label for="create-code">Code</x-base.form-label>
                    <x-base.form-input
                        id="create-code"
                        name="code"
                        type="text"
                        class="w-full"
                        placeholder="Material code"
                        required
                        readonly
                    />
                </div>

                <div class="col-span-12 md:col-span-3 xl:col-span-25/100">
                    <x-base.form-label for="create-name">Name</x-base.form-label>
                    <x-base.form-input
                        id="create-name"
                        name="name"
                        type="text"
                        class="w-full"
                        placeholder="Material name"
                        required
                    />
                </div>

                <div class="col-span-12 md:col-span-2 xl:col-span-15/100">
                    <x-base.form-label for="create-category">Category</x-base.form-label>
                    <x-base.form-select id="create-category" name="category_id" class="w-full" required>
                        <option value="">Select Category</option>
                        <!-- Categories will be populated by JavaScript -->
                    </x-base.form-select>
                </div>

                <div class="col-span-12 md:col-span-2 xl:col-span-20/100">
                    <x-base.form-label for="create-unit">Unit</x-base.form-label>
                    <div class="flex gap-2">
                        <x-base.form-select id="create-unit" name="unit_id" class="w-full" required>
                            <option value="">Select Unit</option>
                            <!-- Units will be populated by JavaScript -->
                        </x-base.form-select>
                        <button
                            type="button"
                            class="btn-tonal btn-tonal--primary btn-tonal--icon h-10 w-10 mt-auto"
                            data-unit-quick-add-toggle
                            data-target="#create-unit-quick-add"
                            title="Add Unit"
                        >
                            <x-base.lucide icon="Plus" class="h-4 w-4" />
                        </button>
                    </div>
                    <div id="create-unit-quick-add" class="mt-3 hidden" data-unit-quick-add>
                        <div class="rounded-xl border border-dashed border-slate-200 bg-slate-50 p-3 dark:border-darkmode-400 dark:bg-darkmode-700/40">
                            <div data-unit-quick-add-form data-unit-select="#create-unit">
                                <div class="grid gap-3">
                                    <div class="space-y-1">
                                        <x-base.form-label for="create-unit-code" class="text-xs font-medium">Code</x-base.form-label>
                                        <x-base.form-input
                                            id="create-unit-code"
                                            type="text"
                                            class="w-full"
                                            placeholder="Code (e.g. PCS)"
                                            data-unit-field="code"
                                            autocomplete="off"
                                        />
                                    </div>

                                    <div class="space-y-1">
                                        <x-base.form-label for="create-unit-name" class="text-xs font-medium">Unit Name</x-base.form-label>
                                        <x-base.form-input
                                            id="create-unit-name"
                                            type="text"
                                            class="w-full"
                                            placeholder="Unit Name"
                                            data-unit-field="name"
                                            autocomplete="off"
                                        />
                                    </div>

                                    <div class="space-y-1">
                                        <x-base.form-label for="create-unit-symbol" class="text-xs font-medium">Symbol <span class="text-[10px] text-slate-400">(optional)</span></x-base.form-label>
                                        <x-base.form-input
                                            id="create-unit-symbol"
                                            type="text"
                                            class="w-full"
                                            placeholder="Symbol (optional)"
                                            data-unit-field="symbol"
                                            autocomplete="off"
                                        />
                                    </div>

                                    <input type="hidden" data-unit-field="is_active" value="1" />

                                    <div class="flex justify-end gap-2 pt-1">
                                        <button type="button" class="btn-tonal btn-tonal--neutral" data-unit-quick-add-cancel>
                                            <x-base.lucide icon="X" class="h-4 w-4" />
                                            Cancel
                                        </button>
                                        <button type="button" class="btn-tonal btn-tonal--success" data-unit-quick-add-submit>
                                            <x-base.lucide icon="Save" class="h-4 w-4" />
                                            Save Unit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 md:col-span-2 xl:col-span-10/100">
                    <x-base.form-label for="create-status">Status</x-base.form-label>
                    <x-base.form-select id="create-status" name="is_active" class="w-full" required>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </x-base.form-select>
                </div>

                <!-- Second Row: SKU, Barcode, Price, Opening Balance -->
                <div class="col-span-12 md:col-span-3 xl:col-span-25/100">
                    <x-base.form-label for="create-sku" class="flex items-center gap-2">
                        SKU
                        <span class="text-xs font-normal text-slate-400">(Optional)</span>
                    </x-base.form-label>
                    <x-base.form-input
                        id="create-sku"
                        name="sku"
                        type="text"
                        class="w-full"
                        placeholder="Internal stock code"
                    />
                </div>

                <div class="col-span-12 md:col-span-3 xl:col-span-25/100">
                    <x-base.form-label for="create-barcode" class="flex items-center gap-2">
                        Barcode
                        <span class="text-xs font-normal text-slate-400">(Optional)</span>
                    </x-base.form-label>
                    <x-base.form-input
                        id="create-barcode"
                        name="barcode"
                        type="text"
                        class="w-full"
                        placeholder="EAN / UPC"
                    />
                </div>

                <div class="col-span-12 md:col-span-2 xl:col-span-15/100">
                    <x-base.form-label for="create-price">Price</x-base.form-label>
                    <x-base.form-input
                        id="create-price"
                        name="price"
                        type="number"
                        step="0.01"
                        min="0"
                        class="w-full"
                        placeholder="0.00"
                        required
                    />
                </div>

                <div class="col-span-12 md:col-span-3 xl:col-span-20/100">
                    <x-base.form-label for="create-opening-quantity">Opening Balance</x-base.form-label>
                    <x-base.form-input
                        id="create-opening-quantity"
                        name="opening_quantity"
                        type="number"
                        step="0.0001"
                        min="0"
                        class="w-full"
                        value="0"
                        placeholder="0.0000"
                    />
                </div>

                <div class="col-span-12">
                    <x-base.form-label for="create-description">Description</x-base.form-label>
                    <x-base.form-textarea
                        id="create-description"
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
                                <label for="create-material-image" class="btn-tonal btn-tonal--primary cursor-pointer flex items-center gap-2">
                                    <x-base.lucide icon="Upload" class="h-4 w-4" />
                                    Upload
                                </label>
                                <button type="button" id="create-material-image-remove" class="btn-tonal btn-tonal--danger hidden">
                                    <x-base.lucide icon="Trash2" class="h-4 w-4" />
                                    Remove
                                </button>
                            </div>
                        </div>

                        <input type="file" id="create-material-image" name="image" accept="image/*" class="hidden">
                        <div class="relative w-full h-48 sm:h-56 overflow-hidden rounded-xl border border-slate-200 bg-white/70 dark:border-darkmode-400">
                            <img id="create-material-image-preview" class="hidden h-full w-full object-cover" alt="Material preview" />
                            <div id="create-material-image-placeholder" class="flex h-full flex-col items-center justify-center gap-2 text-center text-slate-500">
                                <x-base.lucide icon="Image" class="h-10 w-10 text-slate-300" />
                                <div>
                                    <p class="text-sm font-semibold">No image selected</p>
                                    <p class="text-xs text-slate-400">Click Upload to add a cover photo</p>
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
                form="create-material-form"
                id="create-material-btn"
                class="btn-royal btn-royal--success group"
            >
                <x-base.lucide icon="save" class="w-5 h-5 icon-hover-rise" />
                Save
            </button>
        </div>
    @endslot

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const jq = window.jQuery || window.$;
            if (!jq) {
                console.error('jQuery not available for create material modal.');
                return;
            }

            const $ = jq;
            const form = document.getElementById('create-material-form');
            const submitBtn = $('#create-material-btn');
            
            // Populate categories and units dropdowns
            populateDropdowns();

            const imageInput = document.getElementById('create-material-image');
            const previewImage = document.getElementById('create-material-image-preview');
            const placeholder = document.getElementById('create-material-image-placeholder');
            const removeBtn = document.getElementById('create-material-image-remove');

            if (!form) {
                return;
            }

            function populateDropdowns() {
                // Populate categories
                const categorySelect = $('#create-category');
                if (window.materialsCategories && window.materialsCategories.length > 0) {
                    window.materialsCategories.forEach(function(category) {
                        categorySelect.append('<option value="' + category.id + '">' + category.name + '</option>');
                    });
                }

                // Populate units
                const unitSelect = $('#create-unit');
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
                } else {
                    resetImagePreview();
                }
            });

            removeBtn?.addEventListener('click', () => {
                resetImagePreview();
            });

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                const formData = new FormData(form);
                const originalText = submitBtn.html();

                submitBtn.prop('disabled', true).html('<i class="w-4 h-4 mr-2 animate-spin" data-lucide="loader"></i> Saving...');

                $.ajax({
                    url: '{{ route("warehouse.materials.store") }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            const modalEl = document.getElementById('create-material-modal');
                            if (modalEl && typeof tailwind !== 'undefined' && tailwind.Modal) {
                                const instance = tailwind.Modal.getOrCreateInstance(modalEl);
                                instance.hide();
                            }

                            form.reset();
                            resetImagePreview();
                            if (window.materialsTable) {
                                window.materialsTable.ajax.reload();
                            }

                            if (typeof window.showSuccess === 'function') {
                                window.showSuccess(response.message || 'Material created successfully');
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

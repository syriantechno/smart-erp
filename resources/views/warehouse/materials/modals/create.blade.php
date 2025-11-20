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
                <div class="col-span-12 md:col-span-6">
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

                <div class="col-span-12 md:col-span-6">
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

                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="create-category">Category</x-base.form-label>
                    <x-base.form-select id="create-category" name="category_id" class="w-full" required>
                        <option value="">Select Category</option>
                        @foreach($categories ?? [] as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>

                <div class="col-span-12 md:col-span-6">
                    <div class="flex items-center justify-between">
                        <x-base.form-label for="create-unit">Unit</x-base.form-label>
                        <button
                            type="button"
                            class="btn-tonal btn-tonal--primary btn-tonal--icon h-8 w-8"
                            data-unit-quick-add-toggle
                            data-target="#create-unit-quick-add"
                            title="Add Unit"
                        >
                            <x-base.lucide icon="Plus" class="h-4 w-4" />
                        </button>
                    </div>
                    <x-base.form-select id="create-unit" name="unit_id" class="w-full" required>
                        <option value="">Select Unit</option>
                        @foreach(($units ?? []) as $unit)
                            <option value="{{ $unit->id }}">
                                {{ $unit->name }}{{ $unit->symbol ? ' (' . $unit->symbol . ')' : '' }}
                            </option>
                        @endforeach
                    </x-base.form-select>
                    <div id="create-unit-quick-add" class="mt-3 hidden" data-unit-quick-add>
                        <div class="rounded-xl border border-dashed border-slate-200 bg-slate-50 p-3 dark:border-darkmode-400 dark:bg-darkmode-700/40">
                            <div data-unit-quick-add-form data-unit-select="#create-unit">
                                <div class="grid gap-2">
                                    <input type="text" data-unit-field="code" class="form-input w-full" placeholder="Code (e.g. PCS)" autocomplete="off" />
                                    <input type="text" data-unit-field="name" class="form-input w-full" placeholder="Unit Name" autocomplete="off" />
                                    <input type="text" data-unit-field="symbol" class="form-input w-full" placeholder="Symbol (optional)" autocomplete="off" />
                                    <input type="hidden" data-unit-field="is_active" value="1" />
                                    <div class="flex justify-end gap-2">
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

                <div class="col-span-12 md:col-span-6">
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

                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="create-status">Status</x-base.form-label>
                    <x-base.form-select id="create-status" name="is_active" class="w-full" required>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </x-base.form-select>
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
                form="create-material-form"
                id="create-material-btn"
                class="btn-tonal btn-tonal--success group"
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

            if (!form) {
                return;
            }

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

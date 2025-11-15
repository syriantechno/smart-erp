@push('modals')
    <!-- Create Warehouse Modal -->
    <x-modal.form id="create-warehouse-modal" title="Add New Warehouse" size="xl">
        <form id="create-warehouse-form">
            @csrf

            <div class="mb-6">
                <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                    <x-base.lucide icon="Warehouse" class="h-5 w-5"></x-base.lucide>
                    Warehouse Information
                </h4>
                <div class="grid grid-cols-12 gap-4 gap-y-4">
                    <div class="col-span-12 sm:col-span-6">
                        <x-base.form-label for="create-warehouse-code">Code</x-base.form-label>
                        <x-base.form-input
                            id="create-warehouse-code"
                            name="code"
                            type="text"
                            class="w-full"
                            placeholder="Warehouse code"
                            required
                        />
                    </div>

                    <div class="col-span-12 sm:col-span-6">
                        <x-base.form-label for="create-warehouse-name">Name</x-base.form-label>
                        <x-base.form-input
                            id="create-warehouse-name"
                            name="name"
                            type="text"
                            class="w-full"
                            placeholder="Warehouse name"
                            required
                        />
                    </div>

                    <div class="col-span-12 sm:col-span-6">
                        <x-base.form-label for="create-warehouse-location">Location</x-base.form-label>
                        <x-base.form-input
                            id="create-warehouse-location"
                            name="location"
                            type="text"
                            class="w-full"
                            placeholder="Warehouse location"
                        />
                    </div>

                    <div class="col-span-12 sm:col-span-6">
                        <x-base.form-label for="create-warehouse-status">Status</x-base.form-label>
                        <x-base.form-select id="create-warehouse-status" name="is_active" class="w-full" required>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </x-base.form-select>
                    </div>

                    <div class="col-span-12">
                        <x-base.form-label for="create-warehouse-description">Description</x-base.form-label>
                        <x-base.form-textarea
                            id="create-warehouse-description"
                            name="description"
                            class="w-full"
                            rows="3"
                            placeholder="Warehouse description"
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
                    form="create-warehouse-form"
                    id="create-warehouse-btn"
                    variant="primary"
                >
                    <x-base.lucide icon="Save" class="w-4 h-4 mr-2" />
                    Save Warehouse
                </x-base.button>
            </div>
        @endslot
    </x-modal.form>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const jq = window.jQuery || window.$;
            if (!jq) {
                console.error('jQuery is not loaded; warehouse create modal scripts will not run.');
                return;
            }

            jq('#create-warehouse-form').on('submit', function (e) {
                e.preventDefault();

                const formData = new FormData(this);
                const submitBtn = jq('#create-warehouse-btn');
                const originalText = submitBtn.html();

                submitBtn.prop('disabled', true).html('<i class="w-4 h-4 mr-2 animate-spin" data-lucide="loader"></i> Saving...');

                jq.ajax({
                    url: '{{ route("warehouse.warehouses.store") }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").getAttribute('content')
                    },
                    success: function (response) {
                        if (response.success) {
                            jq('#create-warehouse-modal').modal('hide');
                            const formEl = document.getElementById('create-warehouse-form');
                            if (formEl) {
                                formEl.reset();
                            }

                            if (typeof window.warehousesTable !== 'undefined' && window.warehousesTable) {
                                window.warehousesTable.ajax.reload();
                            }

                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                                timer: 3000,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message || 'Failed to create warehouse.'
                            });
                        }
                    },
                    error: function (xhr) {
                        const errors = xhr.responseJSON?.errors || {};
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

@push('modals')
    <!-- Edit Warehouse Modal -->
    <x-modal.form id="edit-warehouse-modal" title="Edit Warehouse" size="xl">
        <form id="edit-warehouse-form">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit-warehouse-id" name="id">

            <div class="mb-6">
                <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                    <x-base.lucide icon="Warehouse" class="h-5 w-5"></x-base.lucide>
                    Warehouse Information
                </h4>
                <div class="grid grid-cols-12 gap-4 gap-y-4">
                    <div class="col-span-12 sm:col-span-6">
                        <x-base.form-label for="edit-warehouse-code">Code</x-base.form-label>
                        <x-base.form-input
                            id="edit-warehouse-code"
                            name="code"
                            type="text"
                            class="w-full"
                            placeholder="Warehouse code"
                            required
                        />
                    </div>

                    <div class="col-span-12 sm:col-span-6">
                        <x-base.form-label for="edit-warehouse-name">Name</x-base.form-label>
                        <x-base.form-input
                            id="edit-warehouse-name"
                            name="name"
                            type="text"
                            class="w-full"
                            placeholder="Warehouse name"
                            required
                        />
                    </div>

                    <div class="col-span-12 sm:col-span-6">
                        <x-base.form-label for="edit-warehouse-location">Location</x-base.form-label>
                        <x-base.form-input
                            id="edit-warehouse-location"
                            name="location"
                            type="text"
                            class="w-full"
                            placeholder="Warehouse location"
                        />
                    </div>

                    <div class="col-span-12 sm:col-span-6">
                        <x-base.form-label for="edit-warehouse-status">Status</x-base.form-label>
                        <x-base.form-select id="edit-warehouse-status" name="is_active" class="w-full" required>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </x-base.form-select>
                    </div>

                    <div class="col-span-12">
                        <x-base.form-label for="edit-warehouse-description">Description</x-base.form-label>
                        <x-base.form-textarea
                            id="edit-warehouse-description"
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
                    form="edit-warehouse-form"
                    id="edit-warehouse-btn"
                    variant="primary"
                >
                    <x-base.lucide icon="Save" class="w-4 h-4 mr-2" />
                    Update Warehouse
                </x-base.button>
            </div>
        @endslot
    </x-modal.form>
@endpush

@push('scripts')
    <script>
        window.populateEditWarehouseModal = function (warehouse) {
            const jq = window.jQuery || window.$;
            if (!jq) {
                console.error('jQuery is not loaded; cannot populate edit warehouse modal.');
                return;
            }

            jq('#edit-warehouse-id').val(warehouse.id);
            jq('#edit-warehouse-code').val(warehouse.code);
            jq('#edit-warehouse-name').val(warehouse.name);
            jq('#edit-warehouse-location').val(warehouse.location);
            jq('#edit-warehouse-status').val(warehouse.is_active ? '1' : '0');
            jq('#edit-warehouse-description').val(warehouse.description);
        };

        document.addEventListener('DOMContentLoaded', function () {
            const jq = window.jQuery || window.$;
            if (!jq) {
                console.error('jQuery is not loaded; warehouse edit modal scripts will not run.');
                return;
            }

            jq('#edit-warehouse-form').on('submit', function (e) {
                e.preventDefault();

                const warehouseId = jq('#edit-warehouse-id').val();
                const formData = new FormData(this);
                const submitBtn = jq('#edit-warehouse-btn');
                const originalText = submitBtn.html();

                submitBtn.prop('disabled', true).html('<i class="w-4 h-4 mr-2 animate-spin" data-lucide="loader"></i> Updating...');

                jq.ajax({
                    url: '{{ route("warehouse.warehouses.update", ":id") }}'.replace(':id', warehouseId),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").getAttribute('content')
                    },
                    success: function (response) {
                        if (response.success) {
                            jq('#edit-warehouse-modal').modal('hide');

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
                                text: response.message || 'Failed to update warehouse.'
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

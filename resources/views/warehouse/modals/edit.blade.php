@push('modals')
    <!-- Edit Warehouse Modal -->
    <div id="edit-warehouse-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Edit Warehouse</h2>
                </div>
                <form id="edit-warehouse-form">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit-warehouse-id" name="id">
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-6">
                            <label for="edit-warehouse-code" class="form-label">Code</label>
                            <x-base.form-input
                                id="edit-warehouse-code"
                                name="code"
                                type="text"
                                class="form-control"
                                placeholder="Warehouse code"
                                required
                            />
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <label for="edit-warehouse-name" class="form-label">Name</label>
                            <x-base.form-input
                                id="edit-warehouse-name"
                                name="name"
                                type="text"
                                class="form-control"
                                placeholder="Warehouse name"
                                required
                            />
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <label for="edit-warehouse-location" class="form-label">Location</label>
                            <x-base.form-input
                                id="edit-warehouse-location"
                                name="location"
                                type="text"
                                class="form-control"
                                placeholder="Warehouse location"
                            />
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <label for="edit-warehouse-status" class="form-label">Status</label>
                            <x-base.form-select id="edit-warehouse-status" name="is_active" class="form-control" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </x-base.form-select>
                        </div>
                        <div class="col-span-12">
                            <label for="edit-warehouse-description" class="form-label">Description</label>
                            <x-base.form-textarea
                                id="edit-warehouse-description"
                                name="description"
                                class="form-control"
                                rows="3"
                                placeholder="Warehouse description"
                            ></x-base.form-textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <x-base.button
                            variant="outline-secondary"
                            data-tw-dismiss="modal"
                            type="button"
                        >
                            Cancel
                        </x-base.button>
                        <x-base.button
                            variant="primary"
                            type="submit"
                            id="edit-warehouse-btn"
                        >
                            <x-base.lucide icon="Save" class="w-4 h-4 mr-2" />
                            Update Warehouse
                        </x-base.button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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

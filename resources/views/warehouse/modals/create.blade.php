<!-- Create Warehouse Modal -->
<div id="create-warehouse-modal" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Add New Warehouse</h2>
            </div>
            <form id="create-warehouse-form">
                @csrf
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12 sm:col-span-6">
                        <label for="create-warehouse-code" class="form-label">Code</label>
                        <x-base.form-input
                            id="create-warehouse-code"
                            name="code"
                            type="text"
                            class="form-control"
                            placeholder="Warehouse code"
                            required
                        />
                    </div>
                    <div class="col-span-12 sm:col-span-6">
                        <label for="create-warehouse-name" class="form-label">Name</label>
                        <x-base.form-input
                            id="create-warehouse-name"
                            name="name"
                            type="text"
                            class="form-control"
                            placeholder="Warehouse name"
                            required
                        />
                    </div>
                    <div class="col-span-12 sm:col-span-6">
                        <label for="create-warehouse-location" class="form-label">Location</label>
                        <x-base.form-input
                            id="create-warehouse-location"
                            name="location"
                            type="text"
                            class="form-control"
                            placeholder="Warehouse location"
                        />
                    </div>
                    <div class="col-span-12 sm:col-span-6">
                        <label for="create-warehouse-status" class="form-label">Status</label>
                        <x-base.form-select id="create-warehouse-status" name="is_active" class="form-control" required>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </x-base.form-select>
                    </div>
                    <div class="col-span-12">
                        <label for="create-warehouse-description" class="form-label">Description</label>
                        <x-base.form-textarea
                            id="create-warehouse-description"
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
                        id="create-warehouse-btn"
                    >
                        <x-base.lucide icon="Save" class="w-4 h-4 mr-2" />
                        Save Warehouse
                    </x-base.button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#create-warehouse-form').on('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const submitBtn = $('#create-warehouse-btn');
        const originalText = submitBtn.html();

        submitBtn.prop('disabled', true).html('<i class="w-4 h-4 mr-2 animate-spin" data-lucide="loader"></i> Saving...');

        $.ajax({
            url: '{{ route("warehouse.warehouses.store") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    $('#create-warehouse-modal').modal('hide');
                    $('#create-warehouse-form')[0].reset();

                    if (typeof warehousesTable !== 'undefined') {
                        warehousesTable.ajax.reload();
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
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            }
        });
    });
});
</script>

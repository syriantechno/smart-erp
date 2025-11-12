<!-- Edit Material Modal -->
<div id="edit-material-modal" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Edit Material</h2>
            </div>
            <form id="edit-material-form" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit-material-id" name="id">
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12 sm:col-span-6">
                        <label for="edit-code" class="form-label">Code</label>
                        <x-base.form-input
                            id="edit-code"
                            name="code"
                            type="text"
                            class="form-control"
                            placeholder="Material code"
                            required
                        />
                    </div>
                    <div class="col-span-12 sm:col-span-6">
                        <label for="edit-name" class="form-label">Name</label>
                        <x-base.form-input
                            id="edit-name"
                            name="name"
                            type="text"
                            class="form-control"
                            placeholder="Material name"
                            required
                        />
                    </div>
                    <div class="col-span-12 sm:col-span-6">
                        <label for="edit-category" class="form-label">Category</label>
                        <x-base.form-select id="edit-category" name="category_id" class="form-control" required>
                            <option value="">Select Category</option>
                            @foreach($categories ?? [] as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </x-base.form-select>
                    </div>
                    <div class="col-span-12 sm:col-span-6">
                        <label for="edit-unit" class="form-label">Unit</label>
                        <x-base.form-select id="edit-unit" name="unit" class="form-control" required>
                            <option value="piece">Piece</option>
                            <option value="kg">Kilogram</option>
                            <option value="liter">Liter</option>
                            <option value="meter">Meter</option>
                        </x-base.form-select>
                    </div>
                    <div class="col-span-12 sm:col-span-6">
                        <label for="edit-price" class="form-label">Price</label>
                        <x-base.form-input
                            id="edit-price"
                            name="price"
                            type="number"
                            step="0.01"
                            min="0"
                            class="form-control"
                            placeholder="0.00"
                            required
                        />
                    </div>
                    <div class="col-span-12 sm:col-span-6">
                        <label for="edit-status" class="form-label">Status</label>
                        <x-base.form-select id="edit-status" name="is_active" class="form-control" required>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </x-base.form-select>
                    </div>
                    <div class="col-span-12">
                        <label for="edit-description" class="form-label">Description</label>
                        <x-base.form-textarea
                            id="edit-description"
                            name="description"
                            class="form-control"
                            rows="3"
                            placeholder="Material description"
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
                        id="edit-material-btn"
                    >
                        <x-base.lucide icon="Save" class="w-4 h-4 mr-2" />
                        Update Material
                    </x-base.button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function populateEditModal(material) {
    $('#edit-material-id').val(material.id);
    $('#edit-code').val(material.code);
    $('#edit-name').val(material.name);
    $('#edit-category').val(material.category_id);
    $('#edit-unit').val(material.unit);
    $('#edit-price').val(material.price);
    $('#edit-status').val(material.is_active ? '1' : '0');
    $('#edit-description').val(material.description);
}

$(document).ready(function() {
    // Edit Material Form Submission
    $('#edit-material-form').on('submit', function(e) {
        e.preventDefault();

        const materialId = $('#edit-material-id').val();
        const formData = new FormData(this);
        const submitBtn = $('#edit-material-btn');
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
                    $('#edit-material-modal').modal('hide');
                    materialsTable.ajax.reload();

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
                lucide.createIcons();
            }
        });
    });
});
</script>

<!-- Create Material Modal -->
<div id="create-material-modal" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Add New Material</h2>
            </div>
            <form id="create-material-form" enctype="multipart/form-data">
                @csrf
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12 sm:col-span-6">
                        <label for="create-code" class="form-label">Code</label>
                        <x-base.form-input
                            id="create-code"
                            name="code"
                            type="text"
                            class="form-control"
                            placeholder="Material code"
                            required
                        />
                    </div>
                    <div class="col-span-12 sm:col-span-6">
                        <label for="create-name" class="form-label">Name</label>
                        <x-base.form-input
                            id="create-name"
                            name="name"
                            type="text"
                            class="form-control"
                            placeholder="Material name"
                            required
                        />
                    </div>
                    <div class="col-span-12 sm:col-span-6">
                        <label for="create-category" class="form-label">Category</label>
                        <x-base.form-select id="create-category" name="category_id" class="form-control" required>
                            <option value="">Select Category</option>
                            @foreach($categories ?? [] as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </x-base.form-select>
                    </div>
                    <div class="col-span-12 sm:col-span-6">
                        <label for="create-unit" class="form-label">Unit</label>
                        <x-base.form-select id="create-unit" name="unit" class="form-control" required>
                            <option value="piece">Piece</option>
                            <option value="kg">Kilogram</option>
                            <option value="liter">Liter</option>
                            <option value="meter">Meter</option>
                        </x-base.form-select>
                    </div>
                    <div class="col-span-12 sm:col-span-6">
                        <label for="create-price" class="form-label">Price</label>
                        <x-base.form-input
                            id="create-price"
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
                        <label for="create-status" class="form-label">Status</label>
                        <x-base.form-select id="create-status" name="is_active" class="form-control" required>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </x-base.form-select>
                    </div>
                    <div class="col-span-12">
                        <label for="create-description" class="form-label">Description</label>
                        <x-base.form-textarea
                            id="create-description"
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
                        id="create-material-btn"
                    >
                        <x-base.lucide icon="Save" class="w-4 h-4 mr-2" />
                        Save Material
                    </x-base.button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Create Material Form Submission
    $('#create-material-form').on('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const submitBtn = $('#create-material-btn');
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
                    $('#create-material-modal').modal('hide');
                    $('#create-material-form')[0].reset();
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

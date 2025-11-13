@php
$companies = \App\Models\Company::active()->get();
$managers = \App\Models\Employee::active()->get();
$departments = \App\Models\Department::where('id', '!=', $department->id)
    ->where('company_id', $department->company_id)
    ->where(function($query) use ($department) {
        $query->whereNull('parent_id')
            ->orWhere('parent_id', '!=', $department->id);
    })
    ->where('is_active', true)
    ->get();
@endphp

@include('components.global-notifications')

<x-base.dialog id="edit-department-modal-{{ $department->id }}" size="lg">
    <x-base.dialog.panel>
        <x-base.dialog.title>
            <h2 class="font-medium text-lg text-gray-900 dark:text-white">Edit Department: {{ $department->name }}</h2>
            <button
                type="button"
                class="text-slate-500 hover:text-slate-400"
                data-tw-dismiss="modal"
            >
                <x-base.lucide icon="X" class="w-5 h-5" />
            </button>
        </x-base.dialog.title>

        <x-base.dialog.description class="p-5">
            <form id="edit-department-form-{{ $department->id }}"
                  action="{{ route('hr.departments.update', $department) }}"
                  method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12 sm:col-span-6">
                        <x-base.form-label for="name">Department Name <span class="text-danger">*</span></x-base.form-label>
                        <x-base.form-input
                            id="name"
                            name="name"
                            type="text"
                            value="{{ old('name', $department->name) }}"
                            placeholder="Enter department name"
                            required
                        />
                    </div>

                    <div class="col-span-12 sm:col-span-6">
                        <x-base.form-label for="company_id">Company <span class="text-danger">*</span></x-base.form-label>
                        <x-base.tom-select
                            id="company_id"
                            name="company_id"
                            class="w-full"
                            required
                            disabled
                        >
                            <option value="{{ $department->company_id }}" selected>{{ $department->company->name }}</option>
                        </x-base.tom-select>
                    </div>

                    <div class="col-span-12 sm:col-span-6">
                        <x-base.form-label for="parent_id">Parent Department</x-base.form-label>
                        <x-base.tom-select
                            id="parent_id"
                            name="parent_id"
                            class="w-full"
                        >
                            <option value="">Select Parent Department (Optional)</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ $department->parent_id == $dept->id ? 'selected' : '' }}>
                                    {{ $dept->name }}
                                </option>
                            @endforeach
                        </x-base.tom-select>
                    </div>

                    <div class="col-span-12 sm:col-span-6">
                        <x-base.form-label for="manager_id">Department Manager</x-base.form-label>
                        <x-base.tom-select
                            id="manager_id"
                            name="manager_id"
                            class="w-full"
                        >
                            <option value="">Select Manager (Optional)</option>
                            @foreach($managers as $manager)
                                <option value="{{ $manager->id }}" {{ $department->manager_id == $manager->id ? 'selected' : '' }}>
                                    {{ $manager->full_name }}
                                </option>
                            @endforeach
                        </x-base.tom-select>
                    </div>

                    <div class="col-span-12">
                        <x-base.form-label for="description">Description</x-base.form-label>
                        <x-base.form-textarea
                            id="description"
                            name="description"
                            rows="3"
                            placeholder="Enter department description"
                        >{{ old('description', $department->description) }}</x-base.form-textarea>
                    </div>
                </div>
            </form>
        </x-base.dialog.description>

        <x-base.dialog.footer class="border-t border-gray-200 dark:border-dark-5 pt-4 mt-4">
            <div class="flex justify-end gap-2 w-full">
                <x-base.button
                    data-tw-dismiss="modal"
                    variant="outline-secondary"
                >
                    Cancel
                </x-base.button>
                <x-base.button
                    id="update-department-btn-{{ $department->id }}"
                    variant="primary"
                >
                    <x-base.lucide icon="Save" class="w-4 h-4 mr-2" />
                    Update Department
                </x-base.button>
            </div>
        </x-base.dialog.footer>
    </x-base.dialog.panel>
</x-base.dialog>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle department update
    const updateBtn = document.getElementById('update-department-btn-{{ $department->id }}');
    const form = document.getElementById('edit-department-form-{{ $department->id }}');

    if (updateBtn && form) {
        updateBtn.addEventListener('click', function(e) {
            e.preventDefault();

            // Get form data
            const formData = new FormData(form);

            // Send AJAX request
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Close modal
                    const modal = document.getElementById('edit-department-modal-{{ $department->id }}');
                    if (modal) {
                        modal.classList.remove('show');
                        document.body.classList.remove('overflow-hidden');
                    }

                    // Show success message
                    showSuccess(data.message || 'Department updated successfully');

                    // Reload table
                    if (typeof table !== 'undefined') {
                        table.ajax.reload(null, false);
                    }
                } else {
                    // Show error message
                    showError(data.message || 'Failed to update department');

                    // Handle validation errors
                    if (data.errors) {
                        let errorMessages = [];
                        for (let field in data.errors) {
                            errorMessages = errorMessages.concat(data.errors[field]);
                        }
                        if (errorMessages.length > 0) {
                            showError('Please correct the following errors: ' + errorMessages.join(', '));
                        }
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showError('An error occurred while updating the department');
            });
        });
    }
});
</script>
@endpush

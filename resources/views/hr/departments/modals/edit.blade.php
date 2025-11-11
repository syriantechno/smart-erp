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

<x-base.modal id="edit-department-modal-{{ $department->id }}" size="modal-lg">
    <x-base.modal-header>
        <h2 class="font-medium text-lg">Edit Department: {{ $department->name }}</h2>
    </x-base.modal-header>
    <x-base.modal-body>
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
                
                <div class="col-span-12">
                    <x-base.form-check
                        id="is_active"
                        name="is_active"
                        label="Active"
                        :checked="$department->is_active"
                        type="checkbox"
                    />
                </div>
            </div>
        </form>
    </x-base.modal-body>
    <x-base.modal-footer>
        <x-base.button
            type="button"
            data-tw-dismiss="modal"
            variant="outline-secondary"
            class="mr-1"
        >
            Cancel
        </x-base.button>
        <x-base.button
            type="submit"
            form="edit-department-form-{{ $department->id }}"
            variant="primary"
        >
            Update Department
        </x-base.button>
    </x-base.modal-footer>
</x-base.modal>

@push('scripts')
<script>
    // Handle edit form submission
    document.getElementById('edit-department-form-{{ $department->id }}').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = this;
        const submitButton = form.querySelector('button[type="submit"]');
        const originalButtonText = submitButton.innerHTML;
        
        // Show loading state
        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Updating...';
        
        // Submit form via AJAX
        fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.redirect) {
                window.location.href = data.redirect;
            } else if (data.error) {
                showToast('error', data.message || 'An error occurred');
            } else {
                // Reload the DataTable
                if (window.LaravelDataTables && window.LaravelDataTables['departments-table']) {
                    window.LaravelDataTables['departments-table'].draw(false);
                }
                
                // Close the modal
                const modal = document.getElementById('edit-department-modal-{{ $department->id }}');
                const modalInstance = bootstrap.Modal.getInstance(modal);
                if (modalInstance) {
                    modalInstance.hide();
                }
                
                showToast('success', 'Department updated successfully');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('error', 'An error occurred while updating the department');
        })
        .finally(() => {
            // Reset button state
            submitButton.disabled = false;
            submitButton.innerHTML = originalButtonText;
        });
    });
</script>
@endpush

@php
$companies = \App\Models\Company::active()->get();
$managers = \App\Models\Employee::active()->get();
$departments = \App\Models\Department::active()->get();
@endphp

@push('modals')
    <x-base.dialog id="create-department-modal" size="lg">
        <x-base.dialog.panel>
            <x-base.dialog.title>
                <h2 class="font-medium text-lg text-gray-900 dark:text-white">Create New Department</h2>
                <button
                    type="button"
                    class="text-slate-500 hover:text-slate-400"
                    data-tw-dismiss="modal"
                >
                    <x-base.lucide icon="X" class="w-5 h-5" />
                </button>
            </x-base.dialog.title>
            
            <x-base.dialog.description class="p-5">
                <form id="create-department-form" action="{{ route('hr.departments.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-12 gap-4 gap-y-4">
                        <!-- Department Information -->
                        <div class="col-span-12 md:col-span-6">
                            <x-base.form-label for="name">Department Name <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-input id="name" name="name" type="text" placeholder="Enter department name" class="w-full" required />
                        </div>
                        
                        <div class="col-span-12 md:col-span-6">
                            <x-base.form-label for="company_id">Company <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-select id="company_id" name="company_id" class="w-full" required>
                                <option value="">Select Company</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </x-base.form-select>
                        </div>
                        
                        <div class="col-span-12 md:col-span-6">
                            <x-base.form-label for="parent_id">Parent Department</x-base.form-label>
                            <x-base.form-select id="parent_id" name="parent_id" class="w-full">
                                <option value="">Select Parent Department (Optional)</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                @endforeach
                            </x-base.form-select>
                        </div>
                        
                        <div class="col-span-12 md:col-span-6">
                            <x-base.form-label for="manager_id">Department Manager</x-base.form-label>
                            <x-base.form-select id="manager_id" name="manager_id" class="w-full">
                                <option value="">Select Manager (Optional)</option>
                                @foreach($managers as $manager)
                                    <option value="{{ $manager->id }}">{{ $manager->full_name }}</option>
                                @endforeach
                            </x-base.form-select>
                        </div>
                        
                        <div class="col-span-12">
                            <x-base.form-label for="description">Description</x-base.form-label>
                            <x-base.form-textarea 
                                id="description" 
                                name="description" 
                                rows="3" 
                                placeholder="Enter department description"
                                class="w-full"
                            ></x-base.form-textarea>
                        </div>
                        
                        <div class="col-span-12">
                            <x-base.form-check
                                id="is_active"
                                name="is_active"
                                label="Active"
                                :checked="true"
                                type="checkbox"
                            />
                        </div>
                    </div>
                    
                    <x-base.dialog.footer class="border-t border-gray-200 dark:border-dark-5 pt-4 mt-4">
                        <div class="flex justify-end space-x-2 w-full">
                            <x-base.button
                                type="button"
                                data-tw-dismiss="modal"
                                variant="outline-secondary"
                            >
                                Cancel
                            </x-base.button>
                            <x-base.button
                                type="submit"
                                variant="primary"
                            >
                                <x-base.lucide icon="Save" class="w-4 h-4 mr-2" />
                                Save Department
                            </x-base.button>
                        </div>
                    </x-base.dialog.footer>
                </form>
            </x-base.dialog.description>
        </x-base.dialog.panel>
    </x-base.dialog>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('create-department-form');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const submitButton = form.querySelector('button[type="submit"]');
                const originalButtonText = submitButton.innerHTML;
                
                // Show loading state
                submitButton.disabled = true;
                submitButton.innerHTML = '<x-base.lucide icon="Loader2" class="w-4 h-4 mr-2 animate-spin" />Saving...';
                
                // Submit form via AJAX
                fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    } else if (data.success) {
                        // Show success message using the global notification system
                        showToast('Department has been created successfully', 'success');
                        
                        // Close the modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('create-department-modal'));
                        if (modal) {
                            modal.hide();
                            // Reset form after modal is hidden to prevent flickering
                            setTimeout(() => form.reset(), 300);
                        }
                        
                        // Reload the DataTable if it exists
                        const dataTable = window.LaravelDataTables && window.LaravelDataTables['departments-table'];
                        if (dataTable) {
                            dataTable.ajax.reload(null, false); // false to keep current page and search
                        } else {
                            // Fallback to page reload after a short delay
                            setTimeout(() => window.location.reload(), 1500);
                        }
                    } else {
                        showToast(data.message || 'An error occurred while processing your request', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('An error occurred while saving the department. Please try again.', 'error');
                })
                .finally(() => {
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalButtonText;
                });
            });
        }
    });
    
    // Using the global showToast function from toast-notifications component
</script>
@endpush

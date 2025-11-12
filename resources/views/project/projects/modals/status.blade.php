<!-- Update Project Status Modal -->
<x-base.dialog id="status-project-modal" size="md">
    <x-base.dialog.panel>
        <!-- Header -->
        <x-base.dialog.title>
            <x-base.lucide icon="Edit3" class="w-5 h-5 mr-2" />
            Update Project Status
        </x-base.dialog.title>

        <form id="status-project-form">
            <!-- Modal Body -->
            <div class="px-5 py-3">
                <div class="space-y-4">
                    <!-- Current Status Info -->
                    <div class="bg-slate-50 dark:bg-darkmode-600 rounded-lg p-4">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <x-base.lucide icon="Folder" class="w-8 h-8 text-slate-400" />
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-slate-900 dark:text-white" id="status-project-name">
                                    Project Name
                                </h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400" id="status-current-status">
                                    Current Status
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- New Status -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            New Status *
                        </label>
                        <x-base.form-select id="new_status" name="status" class="w-full" required>
                            <option value="">Select New Status</option>
                            <option value="planning">Planning</option>
                            <option value="active">Active</option>
                            <option value="on_hold">On Hold</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </x-base.form-select>
                    </div>

                    <!-- Progress Update -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Progress Percentage (0-100)
                        </label>
                        <x-base.form-input
                            id="progress_percentage"
                            name="progress_percentage"
                            type="number"
                            min="0"
                            max="100"
                            class="w-full"
                        />
                    </div>

                    <!-- Conditional Fields -->
                    <div id="completion-fields" class="hidden space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Actual End Date
                            </label>
                            <x-base.form-input
                                id="actual_end_date"
                                name="actual_end_date"
                                type="date"
                                class="w-full"
                            />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Actual Cost
                            </label>
                            <x-base.form-input
                                id="actual_cost"
                                name="actual_cost"
                                type="number"
                                step="0.01"
                                placeholder="0.00"
                                class="w-full"
                            />
                        </div>
                    </div>

                    <!-- Notes -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Notes
                        </label>
                        <x-base.form-textarea
                            id="status_notes"
                            name="notes"
                            rows="3"
                            placeholder="Add any notes about this status change..."
                            class="w-full"
                        />
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <x-base.dialog.footer>
                <x-base.button
                    type="button"
                    variant="secondary"
                    x-on:click="$dispatch('close')"
                >
                    Cancel
                </x-base.button>

                <x-base.button
                    type="submit"
                    variant="primary"
                    id="update-status-btn"
                >
                    <x-base.lucide icon="CheckCircle" class="w-4 h-4 mr-2" />
                    Update Status
                </x-base.button>
            </x-base.dialog.footer>

            <!-- Hidden Fields -->
            <input type="hidden" id="status-project-id" name="project_id" />
        </form>
    </x-base.dialog.panel>
</x-base.dialog>

<script>
// Project Status Update Modal
document.addEventListener('DOMContentLoaded', function() {
    const statusForm = document.getElementById('status-project-form');
    const newStatusSelect = document.getElementById('new_status');
    const completionFields = document.getElementById('completion-fields');

    let currentProjectData = null;

    // Show conditional fields based on status
    if (newStatusSelect) {
        newStatusSelect.addEventListener('change', function() {
            const selectedStatus = this.value;

            // Hide completion fields by default
            completionFields.classList.add('hidden');

            // Show completion fields for completed or cancelled projects
            if (selectedStatus === 'completed' || selectedStatus === 'cancelled') {
                completionFields.classList.remove('hidden');
            }
        });
    }

    // Form submission
    if (statusForm) {
        statusForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const projectId = document.getElementById('status-project-id').value;
            const updateBtn = document.getElementById('update-status-btn');
            const originalText = updateBtn.innerHTML;

            if (!projectId) {
                showToast('No project selected', 'error');
                return;
            }

            // Show loading state
            updateBtn.disabled = true;
            updateBtn.innerHTML = '<x-base.lucide icon="Loader" class="w-4 h-4 mr-2 animate-spin"></x-base.lucide>Updating...';

            const formData = new FormData(statusForm);

            fetch('/project-management/projects/' + projectId + '/status', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData,
                credentials: 'same-origin'
            })
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
                if (data.success) {
                    showToast(data.message || 'Status updated successfully', 'success');

                    // Close modal and reset form
                    const modal = document.getElementById('status-project-modal');
                    if (modal) {
                        modal.__tippy?.hide();
                    }
                    statusForm.reset();

                    // Hide conditional fields
                    completionFields.classList.add('hidden');

                    // Reload table
                    if (window.projectTable) {
                        window.projectTable.ajax.reload(null, false);
                    }
                } else {
                    showToast(data.message || 'Failed to update status', 'error');
                }
            })
            .catch(function(error) {
                console.error('Error updating status:', error);
                showToast('An error occurred while updating status', 'error');
            })
            .finally(function() {
                updateBtn.disabled = false;
                updateBtn.innerHTML = originalText;
            });
        });
    }
});

// Function to open status update modal
window.updateProjectStatus = function(id, name, currentStatus) {
    // Set project data
    document.getElementById('status-project-id').value = id;
    document.getElementById('status-project-name').textContent = name;
    document.getElementById('status-current-status').textContent = 'Current: ' + currentStatus.charAt(0).toUpperCase() + currentStatus.slice(1).replace('_', ' ');

    // Set current status in select
    const statusSelect = document.getElementById('new_status');
    if (statusSelect) {
        statusSelect.value = currentStatus;
        // Trigger change event to show/hide conditional fields
        statusSelect.dispatchEvent(new Event('change'));
    }

    // Open modal
    const modal = document.getElementById('status-project-modal');
    if (modal) {
        modal.__tippy?.show();
    }
};
</script>

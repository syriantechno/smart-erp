<!-- Update Recruitment Status Modal -->
<x-base.dialog id="status-recruitment-modal" size="md">
    <x-base.dialog.panel>
        <!-- Header -->
        <x-base.dialog.title>
            <x-base.lucide icon="Edit3" class="w-5 h-5 mr-2" />
            Update Candidate Status
        </x-base.dialog.title>

        <form id="status-recruitment-form">
            <!-- Modal Body -->
            <div class="px-5 py-3">
                <div class="space-y-4">
                    <!-- Current Status Info -->
                    <div class="bg-slate-50 dark:bg-darkmode-600 rounded-lg p-4">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <x-base.lucide icon="User" class="w-8 h-8 text-slate-400" />
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-slate-900 dark:text-white" id="status-candidate-name">
                                    Candidate Name
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
                            <option value="applied">Applied</option>
                            <option value="screening">Screening</option>
                            <option value="interview">Interview</option>
                            <option value="offered">Offered</option>
                            <option value="hired">Hired</option>
                            <option value="rejected">Rejected</option>
                        </x-base.form-select>
                    </div>

                    <!-- Conditional Fields -->
                    <div id="interview-fields" class="hidden space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Interview Date *
                            </label>
                            <x-base.form-input
                                id="interview_date"
                                name="interview_date"
                                type="datetime-local"
                                class="w-full"
                            />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Interviewer *
                            </label>
                            <x-base.form-input
                                id="interviewer"
                                name="interviewer"
                                type="text"
                                placeholder="Interviewer name"
                                class="w-full"
                            />
                        </div>
                    </div>

                    <div id="offer-fields" class="hidden space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Offered Salary *
                            </label>
                            <x-base.form-input
                                id="offered_salary"
                                name="offered_salary"
                                type="number"
                                step="0.01"
                                placeholder="0.00"
                                class="w-full"
                            />
                        </div>
                    </div>

                    <div id="hire-fields" class="hidden space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Joining Date *
                            </label>
                            <x-base.form-input
                                id="joining_date"
                                name="joining_date"
                                type="date"
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
            <input type="hidden" id="status-recruitment-id" name="recruitment_id" />
        </form>
    </x-base.dialog.panel>
</x-base.dialog>

<script>
// Recruitment Status Update Modal
document.addEventListener('DOMContentLoaded', function() {
    const statusForm = document.getElementById('status-recruitment-form');
    const newStatusSelect = document.getElementById('new_status');
    const interviewFields = document.getElementById('interview-fields');
    const offerFields = document.getElementById('offer-fields');
    const hireFields = document.getElementById('hire-fields');

    let currentRecruitmentData = null;

    // Show conditional fields based on status
    if (newStatusSelect) {
        newStatusSelect.addEventListener('change', function() {
            const selectedStatus = this.value;

            // Hide all conditional fields
            interviewFields.classList.add('hidden');
            offerFields.classList.add('hidden');
            hireFields.classList.add('hidden');

            // Show relevant fields
            if (selectedStatus === 'interview') {
                interviewFields.classList.remove('hidden');
                document.getElementById('interview_date').required = true;
                document.getElementById('interviewer').required = true;
            } else {
                document.getElementById('interview_date').required = false;
                document.getElementById('interviewer').required = false;
            }

            if (selectedStatus === 'offered') {
                offerFields.classList.remove('hidden');
                document.getElementById('offered_salary').required = true;
            } else {
                document.getElementById('offered_salary').required = false;
            }

            if (selectedStatus === 'hired') {
                hireFields.classList.remove('hidden');
                document.getElementById('joining_date').required = true;
            } else {
                document.getElementById('joining_date').required = false;
            }
        });
    }

    // Form submission
    if (statusForm) {
        statusForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const recruitmentId = document.getElementById('status-recruitment-id').value;
            const updateBtn = document.getElementById('update-status-btn');
            const originalText = updateBtn.innerHTML;

            if (!recruitmentId) {
                showToast('No recruitment selected', 'error');
                return;
            }

            // Show loading state
            updateBtn.disabled = true;
            updateBtn.innerHTML = '<x-base.lucide icon="Loader" class="w-4 h-4 mr-2 animate-spin"></x-base.lucide>Updating...';

            const formData = new FormData(statusForm);

            fetch(`{{ url('/hr/recruitment') }}/${recruitmentId}/status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData,
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message || 'Status updated successfully', 'success');

                    // Close modal and reset form
                    const modal = document.getElementById('status-recruitment-modal');
                    if (modal) {
                        modal.__tippy?.hide();
                    }
                    statusForm.reset();

                    // Hide conditional fields
                    interviewFields.classList.add('hidden');
                    offerFields.classList.add('hidden');
                    hireFields.classList.add('hidden');

                    // Reload table
                    if (window.recruitmentTable) {
                        window.recruitmentTable.ajax.reload(null, false);
                    }
                } else {
                    showToast(data.message || 'Failed to update status', 'error');
                }
            })
            .catch(error => {
                console.error('Error updating status:', error);
                showToast('An error occurred while updating status', 'error');
            })
            .finally(() => {
                updateBtn.disabled = false;
                updateBtn.innerHTML = originalText;
            });
        });
    }
});

// Function to open status update modal
window.updateRecruitmentStatus = function(id, name, currentStatus) {
    // Set recruitment data
    document.getElementById('status-recruitment-id').value = id;
    document.getElementById('status-candidate-name').textContent = name;
    document.getElementById('status-current-status').textContent = `Current: ${currentStatus.charAt(0).toUpperCase() + currentStatus.slice(1)}`;

    // Set current status in select
    const statusSelect = document.getElementById('new_status');
    if (statusSelect) {
        statusSelect.value = currentStatus;
        // Trigger change event to show/hide conditional fields
        statusSelect.dispatchEvent(new Event('change'));
    }

    // Open modal
    const modal = document.getElementById('status-recruitment-modal');
    if (modal) {
        modal.__tippy?.show();
    }
};
</script>

<div class="flex items-center justify-center space-x-2">
    <!-- View Project Details -->
    <button type="button"
            onclick="viewProject({{ $project->id }})"
            class="flex items-center px-2 py-1 text-xs font-medium text-blue-600 bg-blue-100 rounded-md hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
            title="View Project Details">
        <x-base.lucide icon="Eye" class="w-3 h-3 mr-1" />
        View
    </button>

    <!-- Update Status -->
    <button type="button"
            onclick="updateProjectStatus({{ $project->id }}, '{{ $project->name }}', '{{ $project->status }}')"
            class="flex items-center px-2 py-1 text-xs font-medium text-purple-600 bg-purple-100 rounded-md hover:bg-purple-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
            title="Update Status">
        <x-base.lucide icon="Edit3" class="w-3 h-3 mr-1" />
        Status
    </button>

    <!-- Update Progress -->
    <button type="button"
            onclick="updateProjectProgress({{ $project->id }}, '{{ $project->name }}', {{ $project->progress_percentage }})"
            class="flex items-center px-2 py-1 text-xs font-medium text-green-600 bg-green-100 rounded-md hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
            title="Update Progress">
        <x-base.lucide icon="TrendingUp" class="w-3 h-3 mr-1" />
        Progress
    </button>
</div>

<script>
// View Project Details
window.viewProject = function(id) {
    console.log('Viewing project details:', id);
    showToast('Project details view coming soon', 'info');
};

// Update Project Status
window.updateProjectStatus = function(id, name, currentStatus) {
    // Create status options
    const statuses = [
        { value: 'planning', label: 'Planning' },
        { value: 'active', label: 'Active' },
        { value: 'on_hold', label: 'On Hold' },
        { value: 'completed', label: 'Completed' },
        { value: 'cancelled', label: 'Cancelled' }
    ];

    const options = statuses.map(function(status) {
        const selected = status.value === currentStatus ? ' selected' : '';
        return '<option value="' + status.value + '"' + selected + '>' + status.label + '</option>';
    }).join('');

    const newStatus = prompt('Update status for ' + name + ':', currentStatus);

    if (newStatus && newStatus !== currentStatus) {
        // Validate status
        if (!statuses.find(function(s) { return s.value === newStatus; })) {
            showToast('Invalid status selected', 'error');
            return;
        }

        // Here you would make an API call to update the status
        fetch('/project-management/projects/' + id + '/status', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                status: newStatus
            }),
            credentials: 'same-origin'
        })
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            if (data.success) {
                showToast('Status updated successfully for ' + name, 'success');
                // Reload the table
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
        });
    }
};

// Update Project Progress
window.updateProjectProgress = function(id, name, currentProgress) {
    const newProgress = prompt('Update progress for ' + name + ' (0-100):', currentProgress);

    if (newProgress !== null && newProgress !== '') {
        const progressValue = parseInt(newProgress, 10);

        if (isNaN(progressValue) || progressValue < 0 || progressValue > 100) {
            showToast('Progress must be a number between 0 and 100', 'error');
            return;
        }

        // Here you would make an API call to update the progress
        fetch('/project-management/projects/' + id + '/status', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                progress_percentage: progressValue
            }),
            credentials: 'same-origin'
        })
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            if (data.success) {
                showToast('Progress updated successfully for ' + name, 'success');
                // Reload the table
                if (window.projectTable) {
                    window.projectTable.ajax.reload(null, false);
                }
            } else {
                showToast(data.message || 'Failed to update progress', 'error');
            }
        })
        .catch(function(error) {
            console.error('Error updating progress:', error);
            showToast('An error occurred while updating progress', 'error');
        });
    }
};
</script>

<div class="flex items-center justify-center space-x-2">
    <!-- View Candidate Details -->
    <button type="button"
            onclick="viewRecruitment({{ $recruitment->id }})"
            class="flex items-center px-2 py-1 text-xs font-medium text-blue-600 bg-blue-100 rounded-md hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
            title="View Candidate Details">
        <x-base.lucide icon="Eye" class="w-3 h-3 mr-1" />
        View
    </button>

    <!-- Update Status -->
    <button type="button"
            onclick="updateRecruitmentStatus({{ $recruitment->id }}, '{{ $recruitment->candidate_name }}', '{{ $recruitment->status }}')"
            class="flex items-center px-2 py-1 text-xs font-medium text-purple-600 bg-purple-100 rounded-md hover:bg-purple-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
            title="Update Status">
        <x-base.lucide icon="Edit3" class="w-3 h-3 mr-1" />
        Status
    </button>

    <!-- Schedule Interview -->
    @if($recruitment->status === 'screening')
    <button type="button"
            onclick="scheduleInterview({{ $recruitment->id }}, '{{ $recruitment->candidate_name }}')"
            class="flex items-center px-2 py-1 text-xs font-medium text-orange-600 bg-orange-100 rounded-md hover:bg-orange-200 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2"
            title="Schedule Interview">
        <x-base.lucide icon="Calendar" class="w-3 h-3 mr-1" />
        Interview
    </button>
    @endif

    <!-- Send Offer -->
    @if($recruitment->status === 'interview')
    <button type="button"
            onclick="sendOffer({{ $recruitment->id }}, '{{ $recruitment->candidate_name }}')"
            class="flex items-center px-2 py-1 text-xs font-medium text-indigo-600 bg-indigo-100 rounded-md hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
            title="Send Offer">
        <x-base.lucide icon="Send" class="w-3 h-3 mr-1" />
        Offer
    </button>
    @endif
</div>

<script>
// View Recruitment Details
window.viewRecruitment = function(id) {
    console.log('Viewing recruitment details:', id);
    showToast('Recruitment details view coming soon', 'info');
};

// Update Recruitment Status
window.updateRecruitmentStatus = function(id, name, currentStatus) {
    // Create status options
    const statuses = [
        { value: 'applied', label: 'Applied' },
        { value: 'screening', label: 'Screening' },
        { value: 'interview', label: 'Interview' },
        { value: 'offered', label: 'Offered' },
        { value: 'hired', label: 'Hired' },
        { value: 'rejected', label: 'Rejected' }
    ];

    const options = statuses.map(function(status) {
        const selected = status.value === currentStatus ? ' selected' : '';
        return '<option value="' + status.value + '"' + selected + '>' + status.label + '</option>';
    }).join('');

    const newStatus = prompt(`Update status for ${name}:`, currentStatus);

    if (newStatus && newStatus !== currentStatus) {
        // Validate status
        if (!statuses.find(s => s.value === newStatus)) {
            showToast('Invalid status selected', 'error');
            return;
        }

        // Here you would make an API call to update the status
        fetch('/hr/recruitment/' + id + '/status', {
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
                if (window.recruitmentTable) {
                    window.recruitmentTable.ajax.reload(null, false);
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

// Schedule Interview
window.scheduleInterview = function(id, name) {
    const interviewDate = prompt('Schedule interview for ' + name + ' (YYYY-MM-DD):');
    const interviewer = prompt('Interviewer name for ' + name + ':');

    if (interviewDate && interviewer) {
        // Here you would make an API call to schedule the interview
        fetch('/hr/recruitment/' + id + '/status', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                status: 'interview',
                interview_date: interviewDate,
                interviewer: interviewer
            }),
            credentials: 'same-origin'
        })
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            if (data.success) {
                showToast('Interview scheduled successfully for ' + name, 'success');
                // Reload the table
                if (window.recruitmentTable) {
                    window.recruitmentTable.ajax.reload(null, false);
                }
            } else {
                showToast(data.message || 'Failed to schedule interview', 'error');
            }
        })
        .catch(function(error) {
            console.error('Error scheduling interview:', error);
            showToast('An error occurred while scheduling interview', 'error');
        });
    }
};

// Send Offer
window.sendOffer = function(id, name) {
    const offeredSalary = prompt('Enter offered salary for ' + name + ':');

    if (offeredSalary && !isNaN(offeredSalary)) {
        // Here you would make an API call to send offer
        fetch('/hr/recruitment/' + id + '/status', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                status: 'offered',
                offered_salary: parseFloat(offeredSalary)
            }),
            credentials: 'same-origin'
        })
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            if (data.success) {
                showToast('Offer sent successfully to ' + name, 'success');
                // Reload the table
                if (window.recruitmentTable) {
                    window.recruitmentTable.ajax.reload(null, false);
                }
            } else {
                showToast(data.message || 'Failed to send offer', 'error');
            }
        })
        .catch(function(error) {
            console.error('Error sending offer:', error);
            showToast('An error occurred while sending offer', 'error');
        });
    }
};
</script>

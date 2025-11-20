<div class="flex items-center justify-center gap-2 min-w-[120px]">
    <x-erp.action-button
        icon="Eye"
        title="View Account"
        variant="info"
        onclick="viewAccount({{ $account->id }})"
    />

    <x-erp.action-button
        icon="Pencil"
        title="Edit Account"
        variant="warning"
        onclick="editAccount({{ $account->id }}, '{{ addslashes($account->name) }}', '{{ $account->type }}')"
    />

    <x-erp.action-button
        icon="{{ $account->is_active ? 'Slash' : 'CheckCircle' }}"
        title="{{ $account->is_active ? 'Deactivate Account' : 'Activate Account' }}"
        variant="{{ $account->is_active ? 'danger' : 'success' }}"
        onclick="toggleAccountStatus({{ $account->id }}, '{{ addslashes($account->name) }}', {{ $account->is_active ? 'true' : 'false' }})"
    />
</div>

<script>
// View Account Details
window.viewAccount = function(id) {
    console.log('Viewing account details:', id);
    showToast('Account details view coming soon', 'info');
};

// Edit Account
window.editAccount = function(id, name, type) {
    console.log('Editing account:', id, name, type);
    showToast('Account editing coming soon', 'info');
};

// Toggle Account Status
window.toggleAccountStatus = function(id, name, isActive) {
    const action = isActive ? 'deactivate' : 'activate';
    const confirmMessage = 'Are you sure you want to ' + action + ' account "' + name + '"?';

    if (confirm(confirmMessage)) {
        fetch('/accounting/chart-of-accounts/' + id + '/status', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                is_active: !isActive
            }),
            credentials: 'same-origin'
        })
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            if (data.success) {
                showToast('Account ' + action + 'd successfully', 'success');
                // Reload the table
                if (window.accountTable) {
                    window.accountTable.ajax.reload(null, false);
                }
            } else {
                showToast(data.message || 'Failed to ' + action + ' account', 'error');
            }
        })
        .catch(function(error) {
            console.error('Error toggling account status:', error);
            showToast('An error occurred while updating account status', 'error');
        });
    }
};
</script>

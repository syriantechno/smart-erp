<div class="flex items-center justify-center space-x-2">
    <!-- View Account Details -->
    <button type="button"
            onclick="viewAccount({{ $account->id }})"
            class="flex items-center px-2 py-1 text-xs font-medium text-blue-600 bg-blue-100 rounded-md hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
            title="View Account Details">
        <x-base.lucide icon="Eye" class="w-3 h-3 mr-1" />
        View
    </button>

    <!-- Edit Account -->
    <button type="button"
            onclick="editAccount({{ $account->id }}, '{{ $account->name }}', '{{ $account->type }}')"
            class="flex items-center px-2 py-1 text-xs font-medium text-yellow-600 bg-yellow-100 rounded-md hover:bg-yellow-200 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2"
            title="Edit Account">
        <x-base.lucide icon="Edit" class="w-3 h-3 mr-1" />
        Edit
    </button>

    <!-- Toggle Status -->
    <button type="button"
            onclick="toggleAccountStatus({{ $account->id }}, '{{ $account->name }}', {{ $account->is_active ? 'true' : 'false' }})"
            class="flex items-center px-2 py-1 text-xs font-medium {{ $account->is_active ? 'text-red-600 bg-red-100 hover:bg-red-200 focus:ring-red-500' : 'text-green-600 bg-green-100 hover:bg-green-200 focus:ring-green-500' }} rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2"
            title="{{ $account->is_active ? 'Deactivate Account' : 'Activate Account' }}">
        <x-base.lucide icon="{{ $account->is_active ? 'X' : 'Check' }}" class="w-3 h-3 mr-1" />
        {{ $account->is_active ? 'Deactivate' : 'Activate' }}
    </button>
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

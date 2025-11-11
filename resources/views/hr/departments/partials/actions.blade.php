<div class="flex justify-center items-center space-x-2">
    <!-- Edit Button -->
    <button type="button" 
            data-tw-toggle="modal" 
            data-tw-target="#edit-department-modal-{{ $department->id }}"
            class="btn btn-sm btn-primary"
            title="Edit">
        <i class="fas fa-edit"></i>
    </button>
    
    <!-- Include Edit Modal -->
    @include('hr.departments.modals.edit', ['department' => $department])
    
    <!-- Delete Button -->
    <button type="button" 
            onclick="deleteDepartment({{ $department->id }}, '{{ $department->name }}')"
            class="btn btn-sm btn-danger"
            title="Delete">
        <i class="fas fa-trash"></i>
    </button>
</div>

@push('scripts')
<script>
    function deleteDepartment(id, name) {
        if (confirm(`Are you sure you want to delete the department "${name}"?`)) {
            const url = `{{ route('hr.departments.destroy', '') }}/${id}`;
            
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload the DataTable
                    if (window.LaravelDataTables && window.LaravelDataTables['departments-table']) {
                        window.LaravelDataTables['departments-table'].draw(false);
                    }
                    showToast('success', data.message || 'Department deleted successfully');
                } else {
                    showToast('error', data.message || 'Failed to delete department');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('error', 'An error occurred while deleting the department');
            });
        }
    }
    
    // Function to show toast notifications
    function showToast(type, message) {
        const toast = document.createElement('div');
        toast.className = `toast toast-${type} fixed top-4 right-4 z-50 flex items-center p-4 mb-4 w-full max-w-xs rounded-lg shadow`;
        toast.innerHTML = `
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-${type}-500 bg-${type}-100 rounded-lg">
                <i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle"></i>
            </div>
            <div class="ml-3 text-sm font-normal">${message}</div>
            <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-100 inline-flex h-8 w-8" data-dismiss-target="#toast-${type}">
                <span class="sr-only">Close</span>
                <i class="fas fa-times"></i>
            </button>
        `;
        
        document.body.appendChild(toast);
        
        // Auto remove toast after 5 seconds
        setTimeout(() => {
            toast.remove();
        }, 5000);
    }
</script>
@endpush

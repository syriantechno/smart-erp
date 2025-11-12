<div class="flex items-center justify-center space-x-2">
    <!-- View Employee Details -->
    <button type="button"
            onclick="viewEmployee({{ $employee->id }})"
            class="flex items-center px-2 py-1 text-xs font-medium text-blue-600 bg-blue-100 rounded-md hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
            title="View Employee Details">
        <x-base.lucide icon="Eye" class="w-3 h-3 mr-1" />
        View
    </button>

    <!-- Edit Employee Salary -->
    <button type="button"
            onclick="editEmployeeSalary({{ $employee->id }}, '{{ $employee->full_name }}', {{ $employee->salary ?? 0 }})"
            class="flex items-center px-2 py-1 text-xs font-medium text-amber-600 bg-amber-100 rounded-md hover:bg-amber-200 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2"
            title="Edit Salary">
        <x-base.lucide icon="Edit3" class="w-3 h-3 mr-1" />
        Salary
    </button>

    <!-- Payroll History -->
    <button type="button"
            onclick="viewPayrollHistory({{ $employee->id }}, '{{ $employee->full_name }}')"
            class="flex items-center px-2 py-1 text-xs font-medium text-purple-600 bg-purple-100 rounded-md hover:bg-purple-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
            title="Payroll History">
        <x-base.lucide icon="History" class="w-3 h-3 mr-1" />
        History
    </button>
</div>

<script>
// View Employee Details
window.viewEmployee = function(id) {
    console.log('Viewing employee details:', id);
    showToast('Employee details view coming soon', 'info');
};

// Edit Employee Salary
window.editEmployeeSalary = function(id, name, currentSalary) {
    const newSalary = prompt(`Edit salary for ${name}:`, currentSalary || 0);

    if (newSalary !== null && newSalary !== '') {
        const salary = parseFloat(newSalary);
        if (isNaN(salary) || salary < 0) {
            showToast('Please enter a valid salary amount', 'error');
            return;
        }

        // Here you would make an API call to update the salary
        fetch(`/hr/employees/${id}/salary`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ salary: salary }),
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast(`Salary updated successfully for ${name}`, 'success');
                // Reload the table
                if (window.payrollTable) {
                    window.payrollTable.ajax.reload(null, false);
                }
            } else {
                showToast(data.message || 'Failed to update salary', 'error');
            }
        })
        .catch(error => {
            console.error('Error updating salary:', error);
            showToast('An error occurred while updating salary', 'error');
        });
    }
};

// View Payroll History
window.viewPayrollHistory = function(id, name) {
    console.log('Viewing payroll history for:', name);
    showToast('Payroll history view coming soon', 'info');
};
</script>

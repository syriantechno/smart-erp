<div class="flex items-center justify-center gap-1 min-w-[80px]">
    <!-- Edit Employee (open modal) -->
    <x-erp.action-button
        icon="Edit"
        variant="primary"
        title="Edit Employee"
        onclick="openEditModal(
            {{ $employee->id }},
            '{{ addslashes($employee->employee_id) }}',
            '{{ addslashes($employee->first_name) }}',
            '{{ addslashes($employee->last_name) }}',
            '{{ addslashes($employee->email) }}',
            '{{ addslashes($employee->phone ?? '') }}',
            '{{ addslashes($employee->position ?? '') }}',
            {{ $employee->salary }},
            '{{ $employee->hire_date ? $employee->hire_date->format('Y-m-d') : '' }}',
            '{{ $employee->birth_date ? $employee->birth_date->format('Y-m-d') : '' }}',
            '{{ addslashes($employee->gender ?? '') }}',
            '{{ addslashes($employee->address ?? '') }}',
            '{{ addslashes($employee->city ?? '') }}',
            '{{ addslashes($employee->country ?? '') }}',
            '{{ addslashes($employee->postal_code ?? '') }}',
            {{ $employee->department_id ?? 'null' }},
            {{ $employee->company_id ?? 'null' }},
            {{ $employee->is_active ? 'true' : 'false' }}
        )"
    />

    <!-- Delete Employee -->
    <x-erp.action-button
        icon="Trash2"
        variant="danger"
        title="Delete Employee"
        onclick="deleteEmployee({{ $employee->id }}, '{{ addslashes($employee->full_name) }}')"
    />
</div>

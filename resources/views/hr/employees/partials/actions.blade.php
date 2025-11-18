<div class="flex items-center justify-center gap-1 min-w-[80px]">
    <!-- Edit Employee (open modal) -->
    <x-erp.action-button
        icon="Edit"
        variant="primary"
        title="Edit Employee"
        onclick='openEditModal(
            {{ $employee->id }},
            {!! json_encode($employee->employee_id) !!},
            {!! json_encode($employee->first_name) !!},
            {!! json_encode($employee->last_name) !!},
            {!! json_encode($employee->email) !!},
            {!! json_encode($employee->phone ?? "") !!},
            {!! json_encode($employee->position ?? "") !!},
            {{ $employee->salary }},
            {!! json_encode($employee->hire_date ? $employee->hire_date->format("Y-m-d") : "") !!},
            {!! json_encode($employee->birth_date ? $employee->birth_date->format("Y-m-d") : "") !!},
            {!! json_encode($employee->gender ?? "") !!},
            {!! json_encode($employee->address ?? "") !!},
            {!! json_encode($employee->city ?? "") !!},
            {!! json_encode($employee->country ?? "") !!},
            {!! json_encode($employee->postal_code ?? "") !!},
            {{ $employee->department_id ?? 'null' }},
            {{ $employee->company_id ?? 'null' }},
            {{ $employee->is_active ? 'true' : 'false' }}
        )'
    />

    <!-- Delete Employee -->
    <x-erp.action-button
        icon="Trash2"
        variant="danger"
        title="Delete Employee"
        onclick="deleteEmployee({{ $employee->id }}, '{{ addslashes($employee->full_name) }}')"
    />
</div>

<div class="flex items-center justify-center gap-1 min-w-[80px]">
    <!-- Edit Employee (open modal) -->
    <button
        type="button"
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
        class="inline-flex items-center justify-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200"
        title="Edit"
    >
        <x-base.lucide icon="Edit" class="h-4 w-4" />
    </button>

    <!-- Delete Employee -->
    <button
        type="button"
        onclick="deleteEmployee({{ $employee->id }}, '{{ addslashes($employee->full_name) }}')"
        class="inline-flex items-center justify-center text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200"
        title="Delete"
    >
        <x-base.lucide icon="Trash2" class="h-4 w-4" />
    </button>
</div>

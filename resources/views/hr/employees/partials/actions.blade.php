<div class="flex items-center justify-center gap-1">
    <!-- Edit Employee -->
    <button
        type="button"
        onclick="openEditModal({{ $employee->id }}, '{{ addslashes($employee->employee_id) }}', '{{ addslashes($employee->first_name) }}', '{{ addslashes($employee->last_name) }}', '{{ addslashes($employee->email) }}', '{{ addslashes($employee->phone ?? '') }}', '{{ addslashes($employee->position ?? '') }}', '{{ $employee->salary }}', '{{ $employee->hire_date ? $employee->hire_date->format('Y-m-d') : '' }}', '{{ $employee->birth_date ? $employee->birth_date->format('Y-m-d') : '' }}', '{{ addslashes($employee->gender ?? '') }}', '{{ addslashes($employee->address ?? '') }}', '{{ addslashes($employee->city ?? '') }}', '{{ addslashes($employee->country ?? '') }}', '{{ addslashes($employee->postal_code ?? '') }}', {{ $employee->department_id }}, {{ $employee->company_id }}, {{ $employee->is_active ? 'true' : 'false' }})"
        class="flex items-center px-2 py-1 text-xs font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200"
        title="Edit"
    >
        <x-base.lucide icon="Edit" class="w-4 h-4" />
    </button>

    <!-- Delete Employee -->
    <button
        type="button"
        onclick="deleteEmployee({{ $employee->id }}, '{{ addslashes($employee->full_name) }}')"
        class="flex items-center px-2 py-1 text-xs font-medium text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200"
        title="Delete"
    >
        <x-base.lucide icon="Trash2" class="w-4 h-4" />
    </button>
</div>

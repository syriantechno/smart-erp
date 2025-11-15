<div class="flex items-center justify-center gap-1">
    @include('hr.departments.modals.edit', ['department' => $department])

    <!-- Edit Department -->
    <button
        type="button"
        data-tw-toggle="modal"
        data-tw-target="#edit-department-modal-{{ $department->id }}"
        class="flex items-center px-2 py-1 text-xs font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200"
        title="Edit"
    >
        <x-base.lucide icon="Edit" class="w-4 h-4" />
    </button>

    <!-- Delete Department -->
    <button
        type="button"
        onclick="deleteDepartment({{ $department->id }}, '{{ addslashes($department->name) }}')"
        class="flex items-center px-2 py-1 text-xs font-medium text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200"
        title="Delete"
    >
        <x-base.lucide icon="Trash2" class="w-4 h-4" />
    </button>
</div>

<div class="flex items-center justify-center gap-1 min-w-[80px]">
    @include('hr.departments.modals.edit', ['department' => $department])

    <!-- Edit Department -->
    <button
        type="button"
        data-tw-toggle="modal"
        data-tw-target="#edit-department-modal-{{ $department->id }}"
        class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-blue-50 text-blue-600 transition hover:bg-blue-100 hover:text-blue-800 dark:bg-darkmode-700 dark:text-blue-400 dark:hover:bg-darkmode-600"
        title="Edit"
    >
        <x-base.lucide icon="Edit" class="h-4 w-4" />
    </button>

    <!-- Delete Department -->
    <button
        type="button"
        onclick="deleteDepartment({{ $department->id }}, '{{ addslashes($department->name) }}')"
        class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-red-50 text-red-600 transition hover:bg-red-100 hover:text-red-800 dark:bg-darkmode-700 dark:text-red-400 dark:hover:bg-darkmode-600"
        title="Delete"
    >
        <x-base.lucide icon="Trash2" class="h-4 w-4" />
    </button>
</div>

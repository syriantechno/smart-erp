<div class="flex items-center justify-center gap-1">

    <!-- Edit Position -->
    <button
        type="button"
        onclick="openEditModal({{ $position->id }}, '{{ addslashes($position->title) }}', '{{ $position->code }}', {{ $position->department_id }}, '{{ $position->salary_range_min }}', '{{ $position->salary_range_max }}', '{{ addslashes($position->description ?? '') }}', '{{ addslashes($position->requirements ?? '') }}', {{ $position->is_active ? 'true' : 'false' }})"
        class="flex items-center px-2 py-1 text-xs font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200"
        title="Edit"
    >
        <x-base.lucide icon="Edit" class="w-4 h-4" />
    </button>

    <!-- Delete Position -->
    <button
        type="button"
        onclick="deletePosition({{ $position->id }}, '{{ addslashes($position->title) }}')"
        class="flex items-center px-2 py-1 text-xs font-medium text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200"
        title="Delete"
    >
        <x-base.lucide icon="Trash2" class="w-4 h-4" />
    </button>
</div>

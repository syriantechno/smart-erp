<div class="flex items-center justify-center gap-1 min-w-[80px]">
    <button
        type="button"
        onclick="editMaterial({{ $material->id }})"
        class="inline-flex items-center justify-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200"
        title="Edit"
    >
        <x-base.lucide icon="Edit" class="h-4 w-4" />
    </button>

    <button
        type="button"
        onclick="deleteMaterial({{ $material->id }}, '{{ addslashes($material->name) }}')"
        class="inline-flex items-center justify-center text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200"
        title="Delete"
    >
        <x-base.lucide icon="Trash2" class="h-4 w-4" />
    </button>
</div>

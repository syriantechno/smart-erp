<div class="flex items-center justify-center gap-2">
    <button
        class="btn-tonal btn-tonal--warning btn-tonal--icon"
        onclick="editMaterial({{ $material->id }})"
        title="Edit Material"
    >
        <i data-lucide="edit" class="w-4 h-4"></i>
    </button>
    <button
        class="btn-tonal btn-tonal--danger btn-tonal--icon"
        onclick="deleteMaterial({{ $material->id }}, '{{ addslashes($material->name) }}')"
        title="Delete Material"
    >
        <i data-lucide="trash-2" class="w-4 h-4"></i>
    </button>
</div>

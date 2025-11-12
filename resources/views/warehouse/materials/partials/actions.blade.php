<div class="flex items-center gap-2">
    <x-base.button
        variant="outline-primary"
        size="sm"
        onclick="editMaterial({{ $material->id }})"
        title="Edit Material"
    >
        <x-base.lucide icon="Edit" class="w-4 h-4" />
    </x-base.button>

    <x-base.button
        variant="outline-danger"
        size="sm"
        onclick="deleteMaterial({{ $material->id }}, '{{ addslashes($material->name) }}')"
        title="Delete Material"
    >
        <x-base.lucide icon="Trash" class="w-4 h-4" />
    </x-base.button>
</div>

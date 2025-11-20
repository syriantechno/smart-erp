<div class="flex items-center justify-center gap-1 min-w-[80px]">
    <x-erp.action-button
        icon="Edit"
        variant="primary"
        title="Edit Material"
        onclick="editMaterial({{ $material->id }})"
    />

    <x-erp.action-button
        icon="Trash2"
        variant="danger"
        title="Delete Material"
        onclick="deleteMaterial({{ $material->id }}, '{{ addslashes($material->name) }}')"
    />
</div>

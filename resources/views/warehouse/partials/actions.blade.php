<div class="flex items-center gap-2">
    <button
        class="btn-tonal btn-tonal--warning btn-tonal--icon"
        onclick="editWarehouse({{ $warehouse->id }})"
        title="Edit Warehouse"
    >
        <x-base.lucide icon="edit" class="w-4 h-4" />
    </button>

    <button
        class="btn-tonal btn-tonal--danger btn-tonal--icon"
        onclick="deleteWarehouse({{ $warehouse->id }}, '{{ addslashes($warehouse->name) }}')"
        title="Delete Warehouse"
    >
        <x-base.lucide icon="trash-2" class="w-4 h-4" />
    </button>
</div>

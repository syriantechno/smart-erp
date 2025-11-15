<div class="flex items-center gap-2">
    <x-base.button
        variant="outline-primary"
        size="sm"
        onclick="editWarehouse({{ $warehouse->id }})"
        title="Edit Warehouse"
    >
        <x-base.lucide icon="Edit" class="w-4 h-4" />
    </x-base.button>

    <x-base.button
        variant="outline-danger"
        size="sm"
        onclick="deleteWarehouse({{ $warehouse->id }}, '{{ addslashes($warehouse->name) }}')"
        title="Delete Warehouse"
    >
        <x-base.lucide icon="Trash" class="w-4 h-4" />
    </x-base.button>
</div>

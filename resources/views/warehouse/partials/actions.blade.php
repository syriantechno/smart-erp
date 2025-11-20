<div class="flex items-center justify-center gap-1 min-w-[80px]">
    <x-erp.action-button
        icon="Edit"
        variant="primary"
        title="Edit Warehouse"
        onclick="editWarehouse({{ $warehouse->id }})"
    />

    <x-erp.action-button
        icon="Trash2"
        variant="danger"
        title="Delete Warehouse"
        onclick="deleteWarehouse({{ $warehouse->id }}, '{{ addslashes($warehouse->name) }}')"
    />
</div>

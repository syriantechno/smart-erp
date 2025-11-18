<div class="flex items-center gap-2 justify-center">
    <x-erp.action-button
        icon="Eye"
        variant="primary"
        title="View"
        onclick="viewVendor({{ $vendor->id }})"
    />
    <x-erp.action-button
        icon="Edit"
        variant="warning"
        title="Edit"
        onclick="editVendor({{ $vendor->id }})"
    />
    <x-erp.action-button
        icon="Trash2"
        variant="danger"
        title="Delete"
        onclick="deleteVendor({{ $vendor->id }})"
    />
</div>

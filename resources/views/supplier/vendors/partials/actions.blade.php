<div class="flex items-center justify-center gap-1 min-w-[80px]">
    <x-erp.action-button
        icon="Eye"
        variant="secondary"
        title="View Vendor"
        onclick="window.viewVendor && window.viewVendor({{ $vendor->id }})"
    />

    <x-erp.action-button
        icon="Edit"
        variant="primary"
        title="Edit Vendor"
        onclick="window.editVendor && window.editVendor({{ $vendor->id }})"
    />

    <x-erp.action-button
        icon="Trash2"
        variant="danger"
        title="Delete Vendor"
        onclick="window.erpDeleteRecord && window.erpDeleteRecord({{ $vendor->id }}, '{{ addslashes($vendor->name) }}')"
    />
</div>

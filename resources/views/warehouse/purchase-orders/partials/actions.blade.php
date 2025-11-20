<div class="flex items-center justify-center gap-1 min-w-[110px]">
    <x-erp.action-button
        icon="Eye"
        variant="neutral"
        title="View Purchase Order"
        onclick="viewPurchaseOrder({{ $po->id }})"
    />

    <x-erp.action-button
        icon="Edit"
        variant="primary"
        title="Edit Purchase Order"
        onclick="editPurchaseOrder({{ $po->id }})"
    />

    <x-erp.action-button
        icon="Trash2"
        variant="danger"
        title="Delete Purchase Order"
        onclick="deletePurchaseOrder({{ $po->id }}, '{{ addslashes($po->title ?? $po->code) }}')"
    />
</div>

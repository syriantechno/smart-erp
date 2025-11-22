<div class="flex items-center justify-center gap-1 min-w-[90px]">
    <x-erp.action-button
        icon="Eye"
        variant="primary"
        title="View details"
        onclick="window.location.href='{{ route('warehouse.material-requests.show', $pr) }}'"
    />

    <x-erp.action-button
        icon="Trash2"
        variant="danger"
        title="Delete"
        disabled
    />
</div>

<div class="flex items-center justify-center gap-1 min-w-[80px]">
    <x-erp.action-button
        icon="Eye"
        variant="secondary"
        title="View Customer"
        onclick="window.location.href='{{ route('customers.statement', $customer) }}'"
    />

    <x-erp.action-button
        icon="Edit"
        variant="primary"
        title="Edit Customer"
        onclick="window.editCustomer && window.editCustomer({{ $customer->id }})"
    />

    <x-erp.action-button
        icon="Trash2"
        variant="danger"
        title="Delete Customer"
        onclick="window.erpDeleteRecord && window.erpDeleteRecord({{ $customer->id }}, '{{ addslashes($customer->name) }}')"
    />
</div>

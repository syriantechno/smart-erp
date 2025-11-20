<div class="flex items-center justify-center gap-1">
    <x-erp.action-button
        icon="Edit"
        variant="primary"
        title="Edit Leave"
        onclick="window.leaveUI?.edit('{{ $leave->id }}')"
    />

    <x-erp.action-button
        icon="Trash2"
        variant="danger"
        title="Delete Leave"
        onclick="window.leaveUI?.delete('{{ $leave->id }}', '{{ addslashes($leave->code) }}')"
    />
</div>

<div class="flex items-center justify-center gap-1">
    {{-- View Leave --}}
    <x-erp.action-button
        icon="eye"
        variant="neutral"
        title="View Leave"
        onclick="window.leaveUI?.view('{{ $leave->id }}')"
    />

    {{-- Edit Leave - only for pending --}}
    @if($leave->status === 'pending')
        <x-erp.action-button
            icon="edit"
            variant="primary"
            title="Edit Leave"
            onclick="window.leaveUI?.edit('{{ $leave->id }}')"
        />

        {{-- Approve/Reject buttons --}}
        <x-erp.action-button
            icon="check-circle"
            variant="success"
            title="Approve"
            onclick="window.leaveUI?.approve('{{ $leave->id }}')"
        />
        <x-erp.action-button
            icon="x-circle"
            variant="warning"
            title="Reject"
            onclick="window.leaveUI?.reject('{{ $leave->id }}')"
        />

        {{-- Delete Leave - only for pending --}}
        <x-erp.action-button
            icon="trash-2"
            variant="danger"
            title="Delete Leave"
            onclick="window.leaveUI?.delete('{{ $leave->id }}', '{{ addslashes($leave->code) }}')"
        />
    @endif
</div>

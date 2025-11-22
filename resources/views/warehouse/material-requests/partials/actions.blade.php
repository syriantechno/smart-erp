@php
    $approvalRequest = $pr->approvalRequest;
    $approvalStarted = false;

    if ($approvalRequest) {
        $status = $approvalRequest->status;
        $currentLevel = $approvalRequest->current_level ?? 1;

        // Consider approval started once we move beyond the first level
        // or once the overall status is no longer simple pending.
        $approvalStarted = $currentLevel > 1 || in_array($status, ['approved', 'rejected', 'completed'], true);
    }

    $canEdit = ! $approvalStarted;
    $canDelete = ! $approvalStarted;
@endphp

<div class="flex items-center justify-center gap-1 min-w-[90px]">
    <x-erp.action-button
        icon="Eye"
        variant="primary"
        title="View details"
        onclick="window.location.href='{{ route('warehouse.material-requests.show', $pr) }}'"
    />

    @if ($canEdit)
        <x-erp.action-button
            icon="Edit"
            variant="secondary"
            title="Edit request"
            onclick="openMaterialRequestEditModal({{ $pr->id }})"
        />
    @else
        <x-erp.action-button
            icon="Edit"
            variant="secondary"
            title="Edit not allowed when approval is in progress or completed"
            onclick="
                if (window.showError) {
                    window.showError('Editing is not allowed once the approval workflow has started or completed.');
                }
            "
        />
    @endif

    @if ($canDelete)
        <x-erp.action-button
            icon="Trash2"
            variant="danger"
            title="Delete request"
            onclick="deleteMaterialRequest({{ $pr->id }}, '{{ addslashes($pr->code) }}')"
        />
    @else
        <x-erp.action-button
            icon="Trash2"
            variant="danger"
            title="Delete not allowed when approval is in progress or completed"
            onclick="
                if (window.showError) {
                    window.showError('Deleting is not allowed once the approval workflow has started or completed.');
                }
            "
        />
    @endif
</div>

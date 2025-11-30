<div class="flex items-center justify-center gap-1">
    <!-- View Button -->
    <x-erp.action-button
        icon="eye"
        variant="neutral"
        title="View Shift"
        onclick="viewShift({{ $shift->id }})"
    />

    <!-- Edit Button -->
    <x-erp.action-button
        icon="edit"
        variant="primary"
        title="Edit Shift"
        onclick="openEditShiftModal({{ $shift->id }})"
    />

    <!-- Toggle Status Button -->
    <x-erp.action-button
        icon="{{ $shift->is_active ? 'pause-circle' : 'play-circle' }}"
        variant="{{ $shift->is_active ? 'warning' : 'success' }}"
        title="{{ $shift->is_active ? 'Deactivate' : 'Activate' }}"
        onclick="toggleShiftStatus({{ $shift->id }})"
    />

    <!-- Delete Button -->
    <x-erp.action-button
        icon="trash-2"
        variant="danger"
        title="Delete Shift"
        onclick="deleteShift({{ $shift->id }}, '{{ addslashes($shift->name) }}')"
    />
</div>

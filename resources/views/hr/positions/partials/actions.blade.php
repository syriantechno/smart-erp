<div class="flex items-center justify-center gap-1">
    <!-- Edit Position -->
    <x-erp.action-button
        icon="Edit"
        variant="primary"
        title="Edit Position"
        onclick="openEditModal({{ $position->id }}, '{{ addslashes($position->title) }}', '{{ $position->code }}', {{ $position->department_id ?? 'null' }}, '{{ $position->salary_range_min }}', '{{ $position->salary_range_max }}', '{{ addslashes($position->description ?? '') }}', '{{ addslashes($position->requirements ?? '') }}', {{ $position->is_active ? 'true' : 'false' }})"
    />

    <!-- Delete Position -->
    <x-erp.action-button
        icon="Trash2"
        variant="danger"
        title="Delete Position"
        onclick="deletePosition({{ $position->id }}, '{{ addslashes($position->title) }}')"
    />
</div>

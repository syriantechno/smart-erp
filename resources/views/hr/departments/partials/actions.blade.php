<div class="flex items-center justify-center gap-1 min-w-[80px]">
    @include('hr.departments.modals.edit', ['department' => $department])

    <!-- Edit Department -->
    <x-erp.action-button
        icon="Edit"
        variant="primary"
        title="Edit Department"
        onclick="openDepartmentModal({{ $department->id }})"
    />

    <!-- Delete Department -->
    <x-erp.action-button
        icon="Trash2"
        variant="danger"
        title="Delete Department"
        onclick="deleteDepartment({{ $department->id }}, '{{ addslashes($department->name) }}')"
    />
</div>

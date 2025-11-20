<div class="flex items-center justify-center gap-1 min-w-[80px]">
    <!-- Edit Department -->
    <x-erp.action-button
        icon="Edit"
        variant="primary"
        title="Edit Department"
        onclick="openDepartmentEditModal(
            {{ $department->id }},
            '{{ addslashes($department->name) }}',
            {{ $department->company_id ?? 'null' }},
            {{ $department->parent_id ?? 'null' }},
            {{ $department->manager_id ?? 'null' }},
            '{{ addslashes($department->description ?? '') }}'
        )"
    />

    <!-- Delete Department -->
    <x-erp.action-button
        icon="Trash2"
        variant="danger"
        title="Delete Department"
        onclick="deleteDepartment({{ $department->id }}, '{{ addslashes($department->name) }}')"
    />
</div>

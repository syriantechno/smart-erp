<div class="flex items-center justify-center gap-2 min-w-[90px]">
    <x-erp.action-button
        icon="Pencil"
        title="Edit"
        variant="info"
        onclick="openEditModal({{ $task->id }}, {{ json_encode($task->title) }}, {{ json_encode($task->description ?? '') }}, {{ json_encode($task->priority) }}, {{ json_encode($task->status) }}, {{ json_encode($task->due_date ? $task->due_date->format('Y-m-d') : '') }}, {{ $task->employee_id ?? 'null' }}, {{ $task->department_id ?? 'null' }}, {{ $task->company_id ?? 'null' }}, {{ $task->is_active ? 'true' : 'false' }})"
    />

    <x-erp.action-button
        icon="Trash2"
        title="Delete"
        variant="danger"
        onclick="deleteTask({{ $task->id }}, {{ json_encode($task->title) }})"
    />
</div>

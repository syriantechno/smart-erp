<div class="flex items-center justify-center gap-3">
    <button
        type="button"
        onclick="openEditModal(<?php echo e($task->id); ?>, <?php echo e(json_encode($task->title)); ?>, <?php echo e(json_encode($task->description ?? '')); ?>, <?php echo e(json_encode($task->priority)); ?>, <?php echo e(json_encode($task->status)); ?>, <?php echo e(json_encode($task->due_date ? $task->due_date->format('Y-m-d') : '')); ?>, <?php echo e($task->employee_id ?? 'null'); ?>, <?php echo e($task->department_id ?? 'null'); ?>, <?php echo e($task->company_id ?? 'null'); ?>, <?php echo e($task->is_active ? 'true' : 'false'); ?>)"
        class="inline-flex items-center justify-center p-2 text-slate-500 transition hover:text-primary focus:outline-none"
        title="Edit"
    >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 20h9" />
            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4Z" />
        </svg>
    </button>

    <button
        type="button"
        onclick="deleteTask(<?php echo e($task->id); ?>, <?php echo e(json_encode($task->title)); ?>)"
        class="inline-flex items-center justify-center p-2 text-slate-500 transition hover:text-danger focus:outline-none"
        title="Delete"
    >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="3 6 5 6 21 6" />
            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
            <path d="M10 11v6" />
            <path d="M14 11v6" />
            <path d="M9 6V4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2" />
        </svg>
    </button>
</div>
<?php /**PATH E:\ERP System\Source\resources\views/tasks/partials/actions.blade.php ENDPATH**/ ?>
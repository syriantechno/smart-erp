<div class="flex items-center justify-center gap-2 min-w-[90px]">
    <?php if (isset($component)) { $__componentOriginal032f83e94ea583b9c58157a8acdf0a87 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal032f83e94ea583b9c58157a8acdf0a87 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.erp.action-button','data' => ['icon' => 'Pencil','title' => 'Edit','variant' => 'info','onclick' => 'openEditModal('.e($task->id).', '.e(json_encode($task->title)).', '.e(json_encode($task->description ?? '')).', '.e(json_encode($task->priority)).', '.e(json_encode($task->status)).', '.e(json_encode($task->due_date ? $task->due_date->format('Y-m-d') : '')).', '.e($task->employee_id ?? 'null').', '.e($task->department_id ?? 'null').', '.e($task->company_id ?? 'null').', '.e($task->is_active ? 'true' : 'false').')']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('erp.action-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Pencil','title' => 'Edit','variant' => 'info','onclick' => 'openEditModal('.e($task->id).', '.e(json_encode($task->title)).', '.e(json_encode($task->description ?? '')).', '.e(json_encode($task->priority)).', '.e(json_encode($task->status)).', '.e(json_encode($task->due_date ? $task->due_date->format('Y-m-d') : '')).', '.e($task->employee_id ?? 'null').', '.e($task->department_id ?? 'null').', '.e($task->company_id ?? 'null').', '.e($task->is_active ? 'true' : 'false').')']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal032f83e94ea583b9c58157a8acdf0a87)): ?>
<?php $attributes = $__attributesOriginal032f83e94ea583b9c58157a8acdf0a87; ?>
<?php unset($__attributesOriginal032f83e94ea583b9c58157a8acdf0a87); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal032f83e94ea583b9c58157a8acdf0a87)): ?>
<?php $component = $__componentOriginal032f83e94ea583b9c58157a8acdf0a87; ?>
<?php unset($__componentOriginal032f83e94ea583b9c58157a8acdf0a87); ?>
<?php endif; ?>

    <?php if (isset($component)) { $__componentOriginal032f83e94ea583b9c58157a8acdf0a87 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal032f83e94ea583b9c58157a8acdf0a87 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.erp.action-button','data' => ['icon' => 'Trash2','title' => 'Delete','variant' => 'danger','onclick' => 'deleteTask('.e($task->id).', '.e(json_encode($task->title)).')']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('erp.action-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Trash2','title' => 'Delete','variant' => 'danger','onclick' => 'deleteTask('.e($task->id).', '.e(json_encode($task->title)).')']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal032f83e94ea583b9c58157a8acdf0a87)): ?>
<?php $attributes = $__attributesOriginal032f83e94ea583b9c58157a8acdf0a87; ?>
<?php unset($__attributesOriginal032f83e94ea583b9c58157a8acdf0a87); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal032f83e94ea583b9c58157a8acdf0a87)): ?>
<?php $component = $__componentOriginal032f83e94ea583b9c58157a8acdf0a87; ?>
<?php unset($__componentOriginal032f83e94ea583b9c58157a8acdf0a87); ?>
<?php endif; ?>
</div>
<?php /**PATH E:\ERP System\Source\resources\views/tasks/partials/actions.blade.php ENDPATH**/ ?>
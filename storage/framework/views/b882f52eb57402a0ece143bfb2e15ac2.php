<div class="flex items-center justify-center gap-1 min-w-[80px]">
    <!-- Edit Department -->
    <?php if (isset($component)) { $__componentOriginal032f83e94ea583b9c58157a8acdf0a87 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal032f83e94ea583b9c58157a8acdf0a87 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.erp.action-button','data' => ['icon' => 'Edit','variant' => 'primary','title' => 'Edit Department','onclick' => 'openDepartmentEditModal(
            '.e($department->id).',
            \''.e(addslashes($department->name)).'\',
            '.e($department->company_id ?? 'null').',
            '.e($department->parent_id ?? 'null').',
            '.e($department->manager_id ?? 'null').',
            \''.e(addslashes($department->description ?? '')).'\'
        )']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('erp.action-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Edit','variant' => 'primary','title' => 'Edit Department','onclick' => 'openDepartmentEditModal(
            '.e($department->id).',
            \''.e(addslashes($department->name)).'\',
            '.e($department->company_id ?? 'null').',
            '.e($department->parent_id ?? 'null').',
            '.e($department->manager_id ?? 'null').',
            \''.e(addslashes($department->description ?? '')).'\'
        )']); ?>
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

    <!-- Delete Department -->
    <?php if (isset($component)) { $__componentOriginal032f83e94ea583b9c58157a8acdf0a87 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal032f83e94ea583b9c58157a8acdf0a87 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.erp.action-button','data' => ['icon' => 'Trash2','variant' => 'danger','title' => 'Delete Department','onclick' => 'deleteDepartment('.e($department->id).', \''.e(addslashes($department->name)).'\')']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('erp.action-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Trash2','variant' => 'danger','title' => 'Delete Department','onclick' => 'deleteDepartment('.e($department->id).', \''.e(addslashes($department->name)).'\')']); ?>
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
<?php /**PATH D:\laravel\smart-erp\resources\views/hr/departments/partials/actions.blade.php ENDPATH**/ ?>
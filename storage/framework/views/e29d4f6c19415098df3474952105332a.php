<div class="flex items-center justify-center gap-1">
    <!-- View Button -->
    <?php if (isset($component)) { $__componentOriginal032f83e94ea583b9c58157a8acdf0a87 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal032f83e94ea583b9c58157a8acdf0a87 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.erp.action-button','data' => ['icon' => 'eye','variant' => 'neutral','title' => 'View Shift','onclick' => 'viewShift('.e($shift->id).')']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('erp.action-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'eye','variant' => 'neutral','title' => 'View Shift','onclick' => 'viewShift('.e($shift->id).')']); ?>
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

    <!-- Edit Button -->
    <?php if (isset($component)) { $__componentOriginal032f83e94ea583b9c58157a8acdf0a87 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal032f83e94ea583b9c58157a8acdf0a87 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.erp.action-button','data' => ['icon' => 'edit','variant' => 'primary','title' => 'Edit Shift','onclick' => 'openEditShiftModal('.e($shift->id).')']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('erp.action-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'edit','variant' => 'primary','title' => 'Edit Shift','onclick' => 'openEditShiftModal('.e($shift->id).')']); ?>
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

    <!-- Toggle Status Button -->
    <?php if (isset($component)) { $__componentOriginal032f83e94ea583b9c58157a8acdf0a87 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal032f83e94ea583b9c58157a8acdf0a87 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.erp.action-button','data' => ['icon' => ''.e($shift->is_active ? 'pause-circle' : 'play-circle').'','variant' => ''.e($shift->is_active ? 'warning' : 'success').'','title' => ''.e($shift->is_active ? 'Deactivate' : 'Activate').'','onclick' => 'toggleShiftStatus('.e($shift->id).')']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('erp.action-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => ''.e($shift->is_active ? 'pause-circle' : 'play-circle').'','variant' => ''.e($shift->is_active ? 'warning' : 'success').'','title' => ''.e($shift->is_active ? 'Deactivate' : 'Activate').'','onclick' => 'toggleShiftStatus('.e($shift->id).')']); ?>
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

    <!-- Delete Button -->
    <?php if (isset($component)) { $__componentOriginal032f83e94ea583b9c58157a8acdf0a87 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal032f83e94ea583b9c58157a8acdf0a87 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.erp.action-button','data' => ['icon' => 'trash-2','variant' => 'danger','title' => 'Delete Shift','onclick' => 'deleteShift('.e($shift->id).', \''.e(addslashes($shift->name)).'\')']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('erp.action-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'trash-2','variant' => 'danger','title' => 'Delete Shift','onclick' => 'deleteShift('.e($shift->id).', \''.e(addslashes($shift->name)).'\')']); ?>
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
<?php /**PATH D:\laravel\smart-erp\resources\views/hr/shifts/partials/actions.blade.php ENDPATH**/ ?>
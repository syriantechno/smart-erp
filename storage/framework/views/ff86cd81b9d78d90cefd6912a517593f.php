<div class="flex items-center justify-center gap-1 min-w-[80px]">
    <!-- Edit Employee (open modal) -->
    <button
        type="button"
        onclick='openEditModal(
            <?php echo e($employee->id); ?>,
            <?php echo json_encode($employee->employee_id); ?>,
            <?php echo json_encode($employee->first_name); ?>,
            <?php echo json_encode($employee->last_name); ?>,
            <?php echo json_encode($employee->email); ?>,
            <?php echo json_encode($employee->phone ?? ""); ?>,
            <?php echo json_encode($employee->position ?? ""); ?>,
            <?php echo e($employee->salary); ?>,
            <?php echo json_encode($employee->hire_date ? $employee->hire_date->format("Y-m-d") : ""); ?>,
            <?php echo json_encode($employee->birth_date ? $employee->birth_date->format("Y-m-d") : ""); ?>,
            <?php echo json_encode($employee->gender ?? ""); ?>,
            <?php echo json_encode($employee->address ?? ""); ?>,
            <?php echo json_encode($employee->city ?? ""); ?>,
            <?php echo json_encode($employee->country ?? ""); ?>,
            <?php echo json_encode($employee->postal_code ?? ""); ?>,
            <?php echo e($employee->department_id ?? 'null'); ?>,
            <?php echo e($employee->company_id ?? 'null'); ?>,
            <?php echo e($employee->is_active ? 'true' : 'false'); ?>

        )'
        class="inline-flex items-center justify-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200"
        title="Edit"
    >
        <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Edit','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Edit','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $attributes = $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $component = $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
    </button>

    <!-- Delete Employee -->
    <button
        type="button"
        onclick="deleteEmployee(<?php echo e($employee->id); ?>, '<?php echo e(addslashes($employee->full_name)); ?>')"
        class="inline-flex items-center justify-center text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200"
        title="Delete"
    >
        <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Trash2','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Trash2','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $attributes = $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $component = $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
    </button>
</div>
<?php /**PATH E:\ERP System\Source\resources\views/hr/employees/partials/actions.blade.php ENDPATH**/ ?>
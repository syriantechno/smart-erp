<div class="flex items-center justify-center gap-1 min-w-[80px]">
    <!-- Edit Employee (open modal) -->
    <x-erp.action-button
        icon="Edit"
        variant="primary"
        title="Edit Employee"
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
    />

    <!-- Delete Employee -->
    <?php if (isset($component)) { $__componentOriginal032f83e94ea583b9c58157a8acdf0a87 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal032f83e94ea583b9c58157a8acdf0a87 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.erp.action-button','data' => ['icon' => 'Trash2','variant' => 'danger','title' => 'Delete Employee','onclick' => 'deleteEmployee('.e($employee->id).', \''.e(addslashes($employee->full_name)).'\')']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('erp.action-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Trash2','variant' => 'danger','title' => 'Delete Employee','onclick' => 'deleteEmployee('.e($employee->id).', \''.e(addslashes($employee->full_name)).'\')']); ?>
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
<?php /**PATH E:\ERP System\Source\resources\views/hr/employees/partials/actions.blade.php ENDPATH**/ ?>
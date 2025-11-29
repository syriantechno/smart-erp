<div class="flex items-center justify-center gap-1 min-w-[80px]">
    <!-- Edit Employee (open modal) -->
    <?php if (isset($component)) { $__componentOriginal032f83e94ea583b9c58157a8acdf0a87 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal032f83e94ea583b9c58157a8acdf0a87 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.erp.action-button','data' => ['icon' => 'Edit','variant' => 'primary','title' => 'Edit Employee','onclick' => 'openEditModal(
            '.e($employee->id).',
            \''.e(addslashes($employee->employee_id)).'\',
            \''.e(addslashes($employee->first_name)).'\',
            \''.e(addslashes($employee->last_name)).'\',
            \''.e(addslashes($employee->email)).'\',
            \''.e(addslashes($employee->phone ?? '')).'\',
            \''.e(addslashes($employee->position ?? '')).'\',
            '.e($employee->salary).',
            \''.e($employee->hire_date ? $employee->hire_date->format('Y-m-d') : '').'\',
            \''.e($employee->birth_date ? $employee->birth_date->format('Y-m-d') : '').'\',
            \''.e(addslashes($employee->gender ?? '')).'\',
            \''.e(addslashes($employee->address ?? '')).'\',
            \''.e(addslashes($employee->city ?? '')).'\',
            \''.e(addslashes($employee->country ?? '')).'\',
            \''.e(addslashes($employee->postal_code ?? '')).'\',
            '.e($employee->department_id ?? 'null').',
            '.e($employee->company_id ?? 'null').',
            '.e($employee->is_active ? 'true' : 'false').'

        )']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('erp.action-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Edit','variant' => 'primary','title' => 'Edit Employee','onclick' => 'openEditModal(
            '.e($employee->id).',
            \''.e(addslashes($employee->employee_id)).'\',
            \''.e(addslashes($employee->first_name)).'\',
            \''.e(addslashes($employee->last_name)).'\',
            \''.e(addslashes($employee->email)).'\',
            \''.e(addslashes($employee->phone ?? '')).'\',
            \''.e(addslashes($employee->position ?? '')).'\',
            '.e($employee->salary).',
            \''.e($employee->hire_date ? $employee->hire_date->format('Y-m-d') : '').'\',
            \''.e($employee->birth_date ? $employee->birth_date->format('Y-m-d') : '').'\',
            \''.e(addslashes($employee->gender ?? '')).'\',
            \''.e(addslashes($employee->address ?? '')).'\',
            \''.e(addslashes($employee->city ?? '')).'\',
            \''.e(addslashes($employee->country ?? '')).'\',
            \''.e(addslashes($employee->postal_code ?? '')).'\',
            '.e($employee->department_id ?? 'null').',
            '.e($employee->company_id ?? 'null').',
            '.e($employee->is_active ? 'true' : 'false').'

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
<?php /**PATH D:\laravel\smart-erp\resources\views/hr/employees/partials/actions.blade.php ENDPATH**/ ?>
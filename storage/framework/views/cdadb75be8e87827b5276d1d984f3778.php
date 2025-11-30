<?php /** @var \App\Models\HR\EmployeeEvaluation $evaluation */ ?>
<tr>
    <td class="px-5 py-2">
        <a href="<?php echo e(route('hr.employees.show', $evaluation->employee_id)); ?>" class="font-medium text-slate-800 dark:text-slate-100 hover:text-primary">
            <?php echo e($evaluation->employee->full_name ?? 'Unknown'); ?>

        </a>
    </td>
    <td class="px-5 py-2 text-slate-600 dark:text-slate-400">
        <?php echo e($evaluation->employee->department->name ?? '-'); ?>

    </td>
    <td class="px-5 py-2">
        <div class="flex items-center">
            <?php for($i = 1; $i <= 10; $i++): ?>
                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Star','class' => 'w-4 h-4 mr-0.5 '.e($evaluation->overall_rating >= $i ? 'text-amber-400 fill-amber-300/80' : 'text-slate-300 dark:text-slate-600').'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Star','class' => 'w-4 h-4 mr-0.5 '.e($evaluation->overall_rating >= $i ? 'text-amber-400 fill-amber-300/80' : 'text-slate-300 dark:text-slate-600').'']); ?>
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
            <?php endfor; ?>
            <span class="ml-2 text-xs text-slate-500 dark:text-slate-400"><?php echo e($evaluation->overall_rating); ?> / 10</span>
        </div>
    </td>
    <td class="px-5 py-2 text-slate-600 dark:text-slate-400">
        <?php echo e($evaluation->evaluator->name ?? '-'); ?>

    </td>
    <td class="px-5 py-2 text-slate-600 dark:text-slate-400">
        <?php echo e(optional($evaluation->evaluated_at ?? $evaluation->created_at)->format('Y-m-d')); ?>

    </td>
    <td class="px-5 py-2 text-slate-600 dark:text-slate-400 max-w-xs">
        <span class="line-clamp-2"><?php echo e($evaluation->comments); ?></span>
    </td>
</tr>
<?php /**PATH D:\laravel\smart-erp\resources\views/hr/evaluations/_row.blade.php ENDPATH**/ ?>
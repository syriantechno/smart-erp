<?php if (isset($component)) { $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.index','data' => ['attributes' => $attributes->merge($attributes->whereDoesntStartWith('class')->getAttributes())]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['attributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($attributes->merge($attributes->whereDoesntStartWith('class')->getAttributes()))]); ?>
    <?php echo e($slot); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $attributes = $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $component = $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
<?php /**PATH D:\laravel\smart-erp\resources\views/components/base/form-switch/index.blade.php ENDPATH**/ ?>
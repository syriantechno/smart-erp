<?php if (isset($component)) { $__componentOriginal45dc70583f76c3df9e7383efd567b5fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.input','data' => ['attributes' => $attributes->class(
            merge([
                // Default
                'w-[38px] h-[24px] p-px rounded-full relative appearance-none border border-slate-300 bg-slate-200 focus:outline-none focus:ring-4 focus:ring-primary/20 dark:bg-darkmode-700 dark:border-darkmode-500',
                'before:w-[20px] before:h-[20px] before:bg-white before:shadow-[1px_1px_3px_rgba(0,0,0,0.25)] before:transition-[margin-left] before:duration-200 before:ease-in-out before:absolute before:inset-y-0 before:my-auto before:rounded-full before:dark:bg-darkmode-600',
    
                // On checked
                'checked:bg-primary checked:border-primary',
                'before:checked:ml-[14px] before:checked:bg-white',
    
                $attributes->whereStartsWith('class')->first(),
            ]),
        )->merge($attributes->whereDoesntStartWith('class')->getAttributes())]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['attributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($attributes->class(
            merge([
                // Default
                'w-[38px] h-[24px] p-px rounded-full relative appearance-none border border-slate-300 bg-slate-200 focus:outline-none focus:ring-4 focus:ring-primary/20 dark:bg-darkmode-700 dark:border-darkmode-500',
                'before:w-[20px] before:h-[20px] before:bg-white before:shadow-[1px_1px_3px_rgba(0,0,0,0.25)] before:transition-[margin-left] before:duration-200 before:ease-in-out before:absolute before:inset-y-0 before:my-auto before:rounded-full before:dark:bg-darkmode-600',
    
                // On checked
                'checked:bg-primary checked:border-primary',
                'before:checked:ml-[14px] before:checked:bg-white',
    
                $attributes->whereStartsWith('class')->first(),
            ]),
        )->merge($attributes->whereDoesntStartWith('class')->getAttributes()))]); ?>
    <?php echo e($slot); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $attributes = $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $component = $__componentOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
<?php /**PATH E:\ERP System\Source\resources\views/components/base/form-switch/input.blade.php ENDPATH**/ ?>
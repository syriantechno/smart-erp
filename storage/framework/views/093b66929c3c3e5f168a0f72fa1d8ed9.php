<div
    <?php echo e($attributes->class('source hide relative [&.hide]:overflow-hidden [&.hide]:h-0')->merge($attributes->whereDoesntStartWith('class')->getAttributes())); ?>>
    <?php echo e($slot); ?>

</div>

<?php if (! $__env->hasRenderedOnce('89444197-04b4-459f-ae6b-0d664b308e82')): $__env->markAsRenderedOnce('89444197-04b4-459f-ae6b-0d664b308e82');
$__env->startPush('scripts'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/components/base/source.js'); ?>
<?php $__env->stopPush(); endif; ?>
<?php /**PATH D:\laravel\smart-erp\resources\views/components/base/source/index.blade.php ENDPATH**/ ?>
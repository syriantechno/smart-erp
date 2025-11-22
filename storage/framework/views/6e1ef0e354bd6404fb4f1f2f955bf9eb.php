<canvas
    <?php echo e($attributes->class(merge(['chart', $attributes->whereStartsWith('class')->first()]))->merge($attributes->whereDoesntStartWith('class')->getAttributes())); ?>

></canvas>

<?php if (! $__env->hasRenderedOnce('2b95ff9d-83f6-4ac2-a42e-3d9c66407e60')): $__env->markAsRenderedOnce('2b95ff9d-83f6-4ac2-a42e-3d9c66407e60');
$__env->startPush('vendors'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/vendors/chartjs.js'); ?>
<?php $__env->stopPush(); endif; ?>
<?php /**PATH E:\ERP System\Source\resources\views/components/base/chart/index.blade.php ENDPATH**/ ?>
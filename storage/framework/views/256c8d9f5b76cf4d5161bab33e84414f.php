<canvas
    <?php echo e($attributes->class(merge(['chart', $attributes->whereStartsWith('class')->first()]))->merge($attributes->whereDoesntStartWith('class')->getAttributes())); ?>

></canvas>

<?php if (! $__env->hasRenderedOnce('f546bf8e-c763-4084-848d-b830d7d7d012')): $__env->markAsRenderedOnce('f546bf8e-c763-4084-848d-b830d7d7d012');
$__env->startPush('vendors'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/vendors/chartjs.js'); ?>
<?php $__env->stopPush(); endif; ?>
<?php /**PATH D:\laravel\smart-erp\resources\views/components/base/chart/index.blade.php ENDPATH**/ ?>
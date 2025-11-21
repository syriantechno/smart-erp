<select <?php echo e($attributes->class(['tom-select'])->merge($attributes->whereDoesntStartWith('class')->getAttributes())); ?>>
    <?php echo e($slot); ?>

</select>

<?php if (! $__env->hasRenderedOnce('0a1263e1-3ee5-43ba-987d-db978ff2a2df')): $__env->markAsRenderedOnce('0a1263e1-3ee5-43ba-987d-db978ff2a2df');
$__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/vendors/tom-select.css'); ?>
<?php $__env->stopPush(); endif; ?>

<?php if (! $__env->hasRenderedOnce('a8648cea-f04d-4600-9f43-02e59251bd00')): $__env->markAsRenderedOnce('a8648cea-f04d-4600-9f43-02e59251bd00');
$__env->startPush('vendors'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/vendors/tom-select.js'); ?>
<?php $__env->stopPush(); endif; ?>

<?php if (! $__env->hasRenderedOnce('593fc578-b6b2-400d-b683-eb2b5bdac97c')): $__env->markAsRenderedOnce('593fc578-b6b2-400d-b683-eb2b5bdac97c');
$__env->startPush('scripts'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/components/base/tom-select.js'); ?>
<?php $__env->stopPush(); endif; ?>
<?php /**PATH E:\ERP System\Source\resources\views/components/base/tom-select/index.blade.php ENDPATH**/ ?>
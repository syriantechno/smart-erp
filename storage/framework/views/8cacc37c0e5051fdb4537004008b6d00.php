<select <?php echo e($attributes->class(['tom-select'])->merge($attributes->whereDoesntStartWith('class')->getAttributes())); ?>>
    <?php echo e($slot); ?>

</select>

<?php if (! $__env->hasRenderedOnce('d95ea79a-7f4f-4fc4-a55b-dfe5f500dede')): $__env->markAsRenderedOnce('d95ea79a-7f4f-4fc4-a55b-dfe5f500dede');
$__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/vendors/tom-select.css'); ?>
<?php $__env->stopPush(); endif; ?>

<?php if (! $__env->hasRenderedOnce('e7946cf7-9865-4a49-a49d-021682bd2b31')): $__env->markAsRenderedOnce('e7946cf7-9865-4a49-a49d-021682bd2b31');
$__env->startPush('vendors'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/vendors/tom-select.js'); ?>
<?php $__env->stopPush(); endif; ?>

<?php if (! $__env->hasRenderedOnce('ead78624-2349-4c7f-8ba6-623739c92ca5')): $__env->markAsRenderedOnce('ead78624-2349-4c7f-8ba6-623739c92ca5');
$__env->startPush('scripts'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/components/base/tom-select.js'); ?>
<?php $__env->stopPush(); endif; ?>
<?php /**PATH D:\laravel\smart-erp\resources\views/components/base/tom-select/index.blade.php ENDPATH**/ ?>
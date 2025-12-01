<select <?php echo e($attributes->class(['tom-select'])->merge($attributes->whereDoesntStartWith('class')->getAttributes())); ?>>
    <?php echo e($slot); ?>

</select>

<?php if (! $__env->hasRenderedOnce('96740eba-89ea-4b79-83ef-6d4c44ec848b')): $__env->markAsRenderedOnce('96740eba-89ea-4b79-83ef-6d4c44ec848b');
$__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/vendors/tom-select.css'); ?>
<?php $__env->stopPush(); endif; ?>

<?php if (! $__env->hasRenderedOnce('8ad8bb35-30eb-42aa-bd4f-cf06af81a4ba')): $__env->markAsRenderedOnce('8ad8bb35-30eb-42aa-bd4f-cf06af81a4ba');
$__env->startPush('vendors'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/vendors/tom-select.js'); ?>
<?php $__env->stopPush(); endif; ?>

<?php if (! $__env->hasRenderedOnce('eb2dcc77-c2dc-4dec-a0bd-6a82b166c3fb')): $__env->markAsRenderedOnce('eb2dcc77-c2dc-4dec-a0bd-6a82b166c3fb');
$__env->startPush('scripts'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/components/base/tom-select.js'); ?>
<?php $__env->stopPush(); endif; ?>
<?php /**PATH D:\laravel\smart-erp\resources\views/components/base/tom-select/index.blade.php ENDPATH**/ ?>
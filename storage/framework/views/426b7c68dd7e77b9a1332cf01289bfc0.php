<select <?php echo e($attributes->class(['tom-select'])->merge($attributes->whereDoesntStartWith('class')->getAttributes())); ?>>
    <?php echo e($slot); ?>

</select>

<?php if (! $__env->hasRenderedOnce('b0bf4dc5-6e26-4a41-a833-d8821136bf4f')): $__env->markAsRenderedOnce('b0bf4dc5-6e26-4a41-a833-d8821136bf4f');
$__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/vendors/tom-select.css'); ?>
<?php $__env->stopPush(); endif; ?>

<?php if (! $__env->hasRenderedOnce('0e333053-b22a-438d-b18b-18910e12ac5a')): $__env->markAsRenderedOnce('0e333053-b22a-438d-b18b-18910e12ac5a');
$__env->startPush('vendors'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/vendors/tom-select.js'); ?>
<?php $__env->stopPush(); endif; ?>

<?php if (! $__env->hasRenderedOnce('55ffce9e-37c9-454a-b8e0-e77ad6b38bff')): $__env->markAsRenderedOnce('55ffce9e-37c9-454a-b8e0-e77ad6b38bff');
$__env->startPush('scripts'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/components/base/tom-select.js'); ?>
<?php $__env->stopPush(); endif; ?>
<?php /**PATH E:\ERP System\Source\resources\views/components/base/tom-select/index.blade.php ENDPATH**/ ?>
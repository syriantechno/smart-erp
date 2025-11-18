<div <?php echo e($attributes->class('preview-component')->merge($attributes->whereDoesntStartWith('class')->getAttributes())); ?>>
    <?php echo e($slot); ?>

</div>

<?php if (! $__env->hasRenderedOnce('f7bd03bd-a986-403d-beb6-d69b6c33027b')): $__env->markAsRenderedOnce('f7bd03bd-a986-403d-beb6-d69b6c33027b');
$__env->startPush('scripts'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/components/base/preview-component.js'); ?>
<?php $__env->stopPush(); endif; ?>
<?php /**PATH E:\ERP System\Source\resources\views/components/base/preview-component/index.blade.php ENDPATH**/ ?>
<div <?php echo e($attributes->class('preview-component')->merge($attributes->whereDoesntStartWith('class')->getAttributes())); ?>>
    <?php echo e($slot); ?>

</div>

<?php if (! $__env->hasRenderedOnce('67784381-7e60-49a0-901f-bc32e5514f4d')): $__env->markAsRenderedOnce('67784381-7e60-49a0-901f-bc32e5514f4d');
$__env->startPush('scripts'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/components/base/preview-component.js'); ?>
<?php $__env->stopPush(); endif; ?>
<?php /**PATH E:\ERP System\Source\resources\views/components/base/preview-component/index.blade.php ENDPATH**/ ?>
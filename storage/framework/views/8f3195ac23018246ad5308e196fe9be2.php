<div <?php echo e($attributes->class('preview-component')->merge($attributes->whereDoesntStartWith('class')->getAttributes())); ?>>
    <?php echo e($slot); ?>

</div>

<?php if (! $__env->hasRenderedOnce('cdd00086-8876-456b-b3ff-c82e6684e2ae')): $__env->markAsRenderedOnce('cdd00086-8876-456b-b3ff-c82e6684e2ae');
$__env->startPush('scripts'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/components/base/preview-component.js'); ?>
<?php $__env->stopPush(); endif; ?>
<?php /**PATH E:\ERP System\Source\resources\views/components/base/preview-component/index.blade.php ENDPATH**/ ?>
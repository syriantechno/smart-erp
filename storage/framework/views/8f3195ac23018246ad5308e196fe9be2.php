<div <?php echo e($attributes->class('preview-component')->merge($attributes->whereDoesntStartWith('class')->getAttributes())); ?>>
    <?php echo e($slot); ?>

</div>

<?php if (! $__env->hasRenderedOnce('0c2435e7-c089-440c-a5ce-daa695183bb1')): $__env->markAsRenderedOnce('0c2435e7-c089-440c-a5ce-daa695183bb1');
$__env->startPush('scripts'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/components/base/preview-component.js'); ?>
<?php $__env->stopPush(); endif; ?>
<?php /**PATH E:\ERP System\Source\resources\views/components/base/preview-component/index.blade.php ENDPATH**/ ?>
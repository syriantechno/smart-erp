<div
    <?php echo e($attributes->class('source hide relative [&.hide]:overflow-hidden [&.hide]:h-0')->merge($attributes->whereDoesntStartWith('class')->getAttributes())); ?>>
    <?php echo e($slot); ?>

</div>

<?php if (! $__env->hasRenderedOnce('18ef0c33-79e0-45a1-8183-0d5269afb314')): $__env->markAsRenderedOnce('18ef0c33-79e0-45a1-8183-0d5269afb314');
$__env->startPush('scripts'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/components/base/source.js'); ?>
<?php $__env->stopPush(); endif; ?>
<?php /**PATH E:\ERP System\Source\resources\views/components/base/source/index.blade.php ENDPATH**/ ?>
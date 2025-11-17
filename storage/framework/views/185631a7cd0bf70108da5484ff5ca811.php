<div <?php echo e($attributes->class('preview-component')->merge($attributes->whereDoesntStartWith('class')->getAttributes())); ?>>
    <?php echo e($slot); ?>

</div>

<?php if (! $__env->hasRenderedOnce('51592861-1bbc-48f1-8a0e-c8f72c963c15')): $__env->markAsRenderedOnce('51592861-1bbc-48f1-8a0e-c8f72c963c15');
$__env->startPush('scripts'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/components/base/preview-component.js'); ?>
<?php $__env->stopPush(); endif; ?>
<?php /**PATH D:\laravel\smart-erp\resources\views/components/base/preview-component/index.blade.php ENDPATH**/ ?>
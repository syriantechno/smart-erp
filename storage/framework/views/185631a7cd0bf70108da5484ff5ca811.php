<div <?php echo e($attributes->class('preview-component')->merge($attributes->whereDoesntStartWith('class')->getAttributes())); ?>>
    <?php echo e($slot); ?>

</div>

<?php if (! $__env->hasRenderedOnce('2bae8605-78ae-4cd5-ab8a-2f8e27f2241d')): $__env->markAsRenderedOnce('2bae8605-78ae-4cd5-ab8a-2f8e27f2241d');
$__env->startPush('scripts'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/components/base/preview-component.js'); ?>
<?php $__env->stopPush(); endif; ?>
<?php /**PATH D:\laravel\smart-erp\resources\views/components/base/preview-component/index.blade.php ENDPATH**/ ?>
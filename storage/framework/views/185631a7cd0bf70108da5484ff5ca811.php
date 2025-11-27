<div <?php echo e($attributes->class('preview-component')->merge($attributes->whereDoesntStartWith('class')->getAttributes())); ?>>
    <?php echo e($slot); ?>

</div>

<?php if (! $__env->hasRenderedOnce('9e4dd584-d2df-4841-887b-8dcd47f9cd9c')): $__env->markAsRenderedOnce('9e4dd584-d2df-4841-887b-8dcd47f9cd9c');
$__env->startPush('scripts'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/components/base/preview-component.js'); ?>
<?php $__env->stopPush(); endif; ?>
<?php /**PATH D:\laravel\smart-erp\resources\views/components/base/preview-component/index.blade.php ENDPATH**/ ?>
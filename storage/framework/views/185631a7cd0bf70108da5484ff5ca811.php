<div <?php echo e($attributes->class('preview-component')->merge($attributes->whereDoesntStartWith('class')->getAttributes())); ?>>
    <?php echo e($slot); ?>

</div>

<?php if (! $__env->hasRenderedOnce('a2aa62bc-7392-4687-9894-44c4dd0bbbcc')): $__env->markAsRenderedOnce('a2aa62bc-7392-4687-9894-44c4dd0bbbcc');
$__env->startPush('scripts'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/components/base/preview-component.js'); ?>
<?php $__env->stopPush(); endif; ?>
<?php /**PATH D:\laravel\smart-erp\resources\views/components/base/preview-component/index.blade.php ENDPATH**/ ?>
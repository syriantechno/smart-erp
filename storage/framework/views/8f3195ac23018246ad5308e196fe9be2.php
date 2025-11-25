<div <?php echo e($attributes->class('preview-component')->merge($attributes->whereDoesntStartWith('class')->getAttributes())); ?>>
    <?php echo e($slot); ?>

</div>

<?php if (! $__env->hasRenderedOnce('f7e2d16b-4f72-4e16-a1cc-e9bc96bfad59')): $__env->markAsRenderedOnce('f7e2d16b-4f72-4e16-a1cc-e9bc96bfad59');
$__env->startPush('scripts'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/components/base/preview-component.js'); ?>
<?php $__env->stopPush(); endif; ?>
<?php /**PATH E:\ERP System\Source\resources\views/components/base/preview-component/index.blade.php ENDPATH**/ ?>
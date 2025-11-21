<div class="editor">
    <?php echo e($slot); ?>

</div>

<?php if (! $__env->hasRenderedOnce('22fd7a40-87ff-472e-bcce-02f1c60538cc')): $__env->markAsRenderedOnce('22fd7a40-87ff-472e-bcce-02f1c60538cc');
$__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/vendors/ckeditor.css'); ?>
<?php $__env->stopPush(); endif; ?>

<?php if (! $__env->hasRenderedOnce('219a6633-15af-4c69-8696-18ade454052f')): $__env->markAsRenderedOnce('219a6633-15af-4c69-8696-18ade454052f');
$__env->startPush('vendors'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/vendors/ckeditor/classic.js'); ?>
<?php $__env->stopPush(); endif; ?>

<?php if (! $__env->hasRenderedOnce('324a1631-0807-4d86-ab6f-443dcc77d32c')): $__env->markAsRenderedOnce('324a1631-0807-4d86-ab6f-443dcc77d32c');
$__env->startPush('scripts'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/components/base/classic-editor.js'); ?>
<?php $__env->stopPush(); endif; ?>
<?php /**PATH E:\ERP System\Source\resources\views/components/base/classic-editor/index.blade.php ENDPATH**/ ?>
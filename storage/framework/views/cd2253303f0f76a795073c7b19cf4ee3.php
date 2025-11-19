<div class="editor">
    <?php echo e($slot); ?>

</div>

<?php if (! $__env->hasRenderedOnce('a5eee8f9-051a-44ea-85cb-ef6e46dcdd48')): $__env->markAsRenderedOnce('a5eee8f9-051a-44ea-85cb-ef6e46dcdd48');
$__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/vendors/ckeditor.css'); ?>
<?php $__env->stopPush(); endif; ?>

<?php if (! $__env->hasRenderedOnce('4b965761-a4c5-458b-86dc-b71fe3365c66')): $__env->markAsRenderedOnce('4b965761-a4c5-458b-86dc-b71fe3365c66');
$__env->startPush('vendors'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/vendors/ckeditor/classic.js'); ?>
<?php $__env->stopPush(); endif; ?>

<?php if (! $__env->hasRenderedOnce('60d55ea2-d038-4a07-8145-8fc7c8f48139')): $__env->markAsRenderedOnce('60d55ea2-d038-4a07-8145-8fc7c8f48139');
$__env->startPush('scripts'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/components/base/classic-editor.js'); ?>
<?php $__env->stopPush(); endif; ?>
<?php /**PATH E:\ERP System\Source\resources\views/components/base/classic-editor/index.blade.php ENDPATH**/ ?>
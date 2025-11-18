<div
    data-tw-merge
    <?php echo e($attributes->class(['text-xs text-slate-500 mt-2'])->merge($attributes->whereDoesntStartWith('class')->getAttributes())); ?>

>
    <?php echo e($slot); ?>

</div>
<?php /**PATH D:\laravel\smart-erp\resources\views/components/base/form-help/index.blade.php ENDPATH**/ ?>
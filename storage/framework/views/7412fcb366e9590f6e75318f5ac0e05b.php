<div
    data-tw-merge
    <?php echo e($attributes->class(['block sm:flex items-center group form-inline'])->merge($attributes->whereDoesntStartWith('class')->getAttributes())); ?>

>
    <?php echo e($slot); ?>

</div>
<?php /**PATH D:\laravel\smart-erp\resources\views/components/base/form-inline/index.blade.php ENDPATH**/ ?>
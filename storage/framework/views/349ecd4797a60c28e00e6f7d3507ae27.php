<div
    data-tw-merge
    <?php echo e($attributes->class(merge(['flex items-center', $attributes->whereStartsWith('class')->first()]))->merge($attributes->whereDoesntStartWith('class')->getAttributes())); ?>

><?php echo e($slot); ?></div>
<?php /**PATH E:\ERP System\Source\resources\views/components/base/form-check/index.blade.php ENDPATH**/ ?>
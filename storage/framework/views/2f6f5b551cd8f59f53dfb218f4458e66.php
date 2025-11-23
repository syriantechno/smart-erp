<label
    data-tw-merge
    <?php echo e($attributes->class(merge(['cursor-pointer ml-2', $attributes->whereStartsWith('class')->first()]))->merge($attributes->whereDoesntStartWith('class')->getAttributes())); ?>

><?php echo e($slot); ?></label>
<?php /**PATH D:\laravel\smart-erp\resources\views/components/base/form-check/label.blade.php ENDPATH**/ ?>
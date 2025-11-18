<div
    <?php echo e($attributes->class('preview relative [&.hide]:overflow-hidden [&.hide]:h-0')->merge($attributes->whereDoesntStartWith('class')->getAttributes())); ?>>
    <?php echo e($slot); ?>

</div>
<?php /**PATH D:\laravel\smart-erp\resources\views/components/base/preview/index.blade.php ENDPATH**/ ?>
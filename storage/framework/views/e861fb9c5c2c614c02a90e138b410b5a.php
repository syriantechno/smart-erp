<nav <?php echo e($attributes->merge($attributes->whereDoesntStartWith('class')->getAttributes())); ?>>
    <ul class="flex w-full mr-0 sm:mr-auto sm:w-auto">
        <?php echo e($slot); ?>

    </ul>
</nav>
<?php /**PATH D:\laravel\smart-erp\resources\views/components/base/pagination/index.blade.php ENDPATH**/ ?>
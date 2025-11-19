<?php foreach ((['class' => null]) as $__key => $__value) {
    $__consumeVariable = is_string($__key) ? $__key : $__value;
    $$__consumeVariable = is_string($__key) ? $__env->getConsumableComponentData($__key, $__value) : $__env->getConsumableComponentData($__value);
} ?>

<label
    data-tw-merge
    <?php echo e($attributes->class(['inline-block mb-2', 'group-[.form-inline]:mb-2 group-[.form-inline]:sm:mb-0 group-[.form-inline]:sm:mr-5 group-[.form-inline]:sm:text-right'])->merge($attributes->whereDoesntStartWith('class')->getAttributes())); ?>

>
    <?php echo e($slot); ?>

</label>
<?php /**PATH E:\ERP System\Source\resources\views/components/base/form-label/index.blade.php ENDPATH**/ ?>
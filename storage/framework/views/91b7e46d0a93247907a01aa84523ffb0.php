<?php foreach ((['hover' => null, 'striped' => null]) as $__key => $__value) {
    $__consumeVariable = is_string($__key) ? $__key : $__value;
    $$__consumeVariable = is_string($__key) ? $__env->getConsumableComponentData($__key, $__value) : $__env->getConsumableComponentData($__value);
} ?>

<tr
    data-tw-merge
    <?php echo e($attributes->class(
            merge([
                $hover
                    ? '[&:hover_td]:bg-slate-100 [&:hover_td]:dark:bg-darkmode-300 [&:hover_td]:dark:bg-opacity-50'
                    : null,
                $striped
                    ? '[&:nth-of-type(odd)_td]:bg-slate-100 [&:nth-of-type(odd)_td]:dark:bg-darkmode-300 [&:nth-of-type(odd)_td]:dark:bg-opacity-50'
                    : null,
            ]),
        )->merge($attributes->whereDoesntStartWith('class')->getAttributes())); ?>

>
    <?php echo e($slot); ?>

</tr>
<?php /**PATH E:\ERP System\Source\resources\views/components/base/table/tr.blade.php ENDPATH**/ ?>
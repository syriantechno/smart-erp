<?php foreach ((['dark' => null, 'bordered' => null, 'sm' => null]) as $__key => $__value) {
    $__consumeVariable = is_string($__key) ? $__key : $__value;
    $$__consumeVariable = is_string($__key) ? $__env->getConsumableComponentData($__key, $__value) : $__env->getConsumableComponentData($__value);
} ?>

<td
    data-tw-merge
    <?php echo e($attributes->class(
            merge([
                'px-5 py-3 border-b dark:border-darkmode-300',
                $dark ? 'border-slate-600 dark:border-darkmode-300' : null,
                $bordered ? 'border-l border-r border-t' : null,
                $sm ? 'px-4 py-2' : null,
            ]),
        )->merge($attributes->whereDoesntStartWith('class')->getAttributes())); ?>

>
    <?php echo e($slot); ?>

</td>
<?php /**PATH E:\ERP System\Source\resources\views/components/base/table/td.blade.php ENDPATH**/ ?>
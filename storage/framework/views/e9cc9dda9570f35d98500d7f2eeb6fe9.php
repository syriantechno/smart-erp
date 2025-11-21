<?php foreach ((['variant' => null, 'dark' => null, 'bordered' => null, 'sm' => null]) as $__key => $__value) {
    $__consumeVariable = is_string($__key) ? $__key : $__value;
    $$__consumeVariable = is_string($__key) ? $__env->getConsumableComponentData($__key, $__value) : $__env->getConsumableComponentData($__value);
} ?>

<th
    data-tw-merge
    <?php echo e($attributes->class(
            merge([
                'font-medium px-5 py-3 border-b-2 dark:border-darkmode-300',
                $variant === 'light' ? 'border-b-0 text-slate-700' : null,
                $variant === 'dark' ? 'border-b-0' : null,
                $dark ? 'border-slate-600 dark:border-darkmode-300' : null,
                $bordered ? 'border-l border-r border-t' : null,
                $sm ? 'px-4 py-2' : null,
            ]),
        )->merge($attributes->whereDoesntStartWith('class')->getAttributes())); ?>

>
    <?php echo e($slot); ?>

</th>
<?php /**PATH E:\ERP System\Source\resources\views/components/base/table/th.blade.php ENDPATH**/ ?>
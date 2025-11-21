<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['as' => 'div']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['as' => 'div']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>
<?php foreach ((['size' => 'md']) as $__key => $__value) {
    $__consumeVariable = is_string($__key) ? $__key : $__value;
    $$__consumeVariable = is_string($__key) ? $__env->getConsumableComponentData($__key, $__value) : $__env->getConsumableComponentData($__value);
} ?>

<<?php echo e($as); ?>

    data-tw-merge
    <?php echo e($attributes->class([
            'w-[90%] mx-auto bg-white relative rounded-md shadow-md transition-[margin-top,transform] duration-[0.4s,0.3s] -mt-16 group-[.show]:mt-16 group-[.modal-static]:scale-[1.05] dark:bg-darkmode-600',
            $size == 'md' ? 'sm:w-[460px]' : null,
            $size == 'sm' ? 'sm:w-[300px]' : null,
            $size == 'lg' ? 'sm:w-[600px]' : null,
            $size == 'xl' ? 'sm:w-[600px] lg:w-[900px]' : null,
            $size == 'xxl' ? 'sm:w-[680px] lg:w-[1100px]' : null,
        ])->merge($attributes->whereDoesntStartWith('class')->getAttributes())); ?>

><?php echo e($slot); ?></<?php echo e($as); ?>>
<?php /**PATH E:\ERP System\Source\resources\views/components/base/dialog/panel.blade.php ENDPATH**/ ?>
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
            'absolute top-0 right-0 h-full flex flex-col bg-white shadow-md transition-transform duration-300 translate-x-full group-[.show]:translate-x-0 dark:bg-darkmode-600 z-[100]',
            $size == 'md' ? 'w-[460px] max-w-[90vw]' : null,
            $size == 'sm' ? 'w-[300px] max-w-[90vw]' : null,
            $size == 'lg' ? 'w-[600px] max-w-[90vw]' : null,
            $size == 'xl' ? 'w-[900px] max-w-[90vw]' : null,
        ])->merge($attributes->whereDoesntStartWith('class')->getAttributes())); ?>

><?php echo e($slot); ?></<?php echo e($as); ?>>
<?php /**PATH D:\laravel\smart-erp\resources\views/components/base/slideover/panel.blade.php ENDPATH**/ ?>
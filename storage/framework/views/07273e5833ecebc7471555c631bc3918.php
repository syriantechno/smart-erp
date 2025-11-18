<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['as' => 'div', 'placement' => 'bottom-end']));

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

foreach (array_filter((['as' => 'div', 'placement' => 'bottom-end']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php if (! $__env->hasRenderedOnce('13443782-9b03-4a13-9c05-ee047a70a6bf')): $__env->markAsRenderedOnce('13443782-9b03-4a13-9c05-ee047a70a6bf');
$__env->startPush('vendors'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/vendors/popper.js'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/vendors/dropdown.js'); ?>
<?php $__env->stopPush(); endif; ?>

<<?php echo e($as); ?>

    data-tw-merge
    data-tw-placement="<?php echo e($placement); ?>"
    <?php echo e($attributes->class(['dropdown relative'])->merge($attributes->whereDoesntStartWith('class')->getAttributes())); ?>

><?php echo e($slot); ?></<?php echo e($as); ?>>
<?php /**PATH D:\laravel\smart-erp\resources\views/components/base/menu/index.blade.php ENDPATH**/ ?>
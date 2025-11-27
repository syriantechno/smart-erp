<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['as' => 'div', 'staticBackdrop' => false, 'size' => 'md']));

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

foreach (array_filter((['as' => 'div', 'staticBackdrop' => false, 'size' => 'md']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php if (! $__env->hasRenderedOnce('872e879d-73aa-45da-ab43-41897f47f96b')): $__env->markAsRenderedOnce('872e879d-73aa-45da-ab43-41897f47f96b');
$__env->startPush('vendors'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/vendors/modal.js'); ?>
<?php $__env->stopPush(); endif; ?>

<<?php echo e($as); ?>

    data-tw-backdrop="<?php echo e($staticBackdrop ? 'static' : null); ?>"
    aria-hidden="true"
    tabindex="-1"
    <?php echo e($attributes->class([
            'modal group bg-black/60 transition-[visibility,opacity] w-screen h-screen fixed left-0 top-0 flex items-center justify-center',
            '[&:not(.show)]:duration-[0s,0.2s] [&:not(.show)]:delay-[0.2s,0s] [&:not(.show)]:invisible [&:not(.show)]:opacity-0',
            '[&.show]:visible [&.show]:opacity-100 [&.show]:duration-[0s,0.4s]',
        ])->merge($attributes->whereDoesntStartWith('class')->getAttributes())); ?>>
    <?php echo e($slot); ?>

</<?php echo e($as); ?>>
<?php /**PATH D:\laravel\smart-erp\resources\views/components/base/dialog/index.blade.php ENDPATH**/ ?>
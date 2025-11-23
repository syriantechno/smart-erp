<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['variant' => null, 'type' => null, 'src' => null]));

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

foreach (array_filter((['variant' => null, 'type' => null, 'src' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div <?php echo e($attributes->merge($attributes->whereDoesntStartWith('class')->getAttributes())); ?>>
    <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([
        'relative block bg-center bg-no-repeat bg-contain',
        'before:content-[\'\'] before:pt-[100%] before:w-full before:block',
        'bg-file-icon-empty-directory' => $variant == 'empty-directory',
        'bg-file-icon-directory' => $variant == 'directory',
        'bg-file-icon-file' => $variant == 'file',
    ]); ?>">
        <?php if($variant == 'file'): ?>
            <div class="absolute bottom-0 left-0 right-0 top-0 m-auto flex items-center justify-center text-white">
                <?php echo e($type); ?>

            </div>
        <?php elseif($variant == 'image'): ?>
            <div class="image-fit absolute left-0 top-0 h-full w-full">
                <img
                    class="rounded-md"
                    src="<?php echo e($src); ?>"
                    alt="Midone - Admin Dashboard Template"
                >
            </div>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH D:\laravel\smart-erp\resources\views/components/base/file-icon/index.blade.php ENDPATH**/ ?>
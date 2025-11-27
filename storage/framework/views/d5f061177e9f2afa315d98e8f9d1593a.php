<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'icon' => 'Edit',
    'title' => null,
    'variant' => 'primary', // primary, success, warning, danger, neutral
    'size' => 'sm',
    'type' => 'button',
]));

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

foreach (array_filter(([
    'icon' => 'Edit',
    'title' => null,
    'variant' => 'primary', // primary, success, warning, danger, neutral
    'size' => 'sm',
    'type' => 'button',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $baseClasses = 'inline-flex items-center justify-center p-2 rounded-md text-slate-500 hover:scale-105 transition focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-offset-transparent dark:text-slate-400';
    $sizeClasses = [
        'xs' => 'text-xs',
        'sm' => 'text-sm',
        'md' => 'text-base',
    ][$size] ?? 'text-sm';

    $variants = [
        'primary' => 'hover:text-blue-600 dark:hover:text-blue-400',
        'success' => 'hover:text-emerald-600 dark:hover:text-emerald-400',
        'warning' => 'hover:text-amber-600 dark:hover:text-amber-400',
        'danger' => 'hover:text-red-600 dark:hover:text-red-400',
        'neutral' => 'hover:text-slate-700 dark:hover:text-slate-200',
    ];

    $variantClasses = $variants[$variant] ?? $variants['neutral'];
?>

<button
    type="<?php echo e($type); ?>"
    title="<?php echo e($title ?? ''); ?>"
    <?php echo e($attributes->merge(['class' => trim("{$baseClasses} {$sizeClasses} {$variantClasses}")])); ?>

>
    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => $icon,'class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($icon),'class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $attributes = $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $component = $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
</button>
<?php /**PATH D:\laravel\smart-erp\resources\views/components/erp/action-button.blade.php ENDPATH**/ ?>
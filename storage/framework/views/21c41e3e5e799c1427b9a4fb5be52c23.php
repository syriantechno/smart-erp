<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['width' => 'w-auto', 'height' => 'h-auto']));

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

foreach (array_filter((['width' => 'w-auto', 'height' => 'h-auto']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div class="<?php echo e($width); ?> <?php echo e($height); ?>">
    <?php if (isset($component)) { $__componentOriginal5fd628dddac5e0df039575d0587916cd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5fd628dddac5e0df039575d0587916cd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.chart.index','data' => ['class' => 'stacked-bar-chart','attributes' => $attributes->merge($attributes->whereDoesntStartWith('class')->getAttributes())]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.chart'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'stacked-bar-chart','attributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($attributes->merge($attributes->whereDoesntStartWith('class')->getAttributes()))]); ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5fd628dddac5e0df039575d0587916cd)): ?>
<?php $attributes = $__attributesOriginal5fd628dddac5e0df039575d0587916cd; ?>
<?php unset($__attributesOriginal5fd628dddac5e0df039575d0587916cd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5fd628dddac5e0df039575d0587916cd)): ?>
<?php $component = $__componentOriginal5fd628dddac5e0df039575d0587916cd; ?>
<?php unset($__componentOriginal5fd628dddac5e0df039575d0587916cd); ?>
<?php endif; ?>
</div>

<?php if (! $__env->hasRenderedOnce('c59d3c46-1a23-4552-9f82-6410c67f8d25')): $__env->markAsRenderedOnce('c59d3c46-1a23-4552-9f82-6410c67f8d25');
$__env->startPush('scripts'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/utils/colors.js'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/components/stacked-bar-chart.js'); ?>
<?php $__env->stopPush(); endif; ?>
<?php /**PATH D:\laravel\smart-erp\resources\views/components/stacked-bar-chart/index.blade.php ENDPATH**/ ?>
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'as' => 'div',
    'selector' => null,
    'enter' => null,
    'enterFrom' => null,
    'enterTo' => null,
    'leave' => null,
    'leaveFrom' => null,
    'leaveTo' => null,
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
    'as' => 'div',
    'selector' => null,
    'enter' => null,
    'enterFrom' => null,
    'enterTo' => null,
    'leave' => null,
    'leaveFrom' => null,
    'leaveTo' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php if (! $__env->hasRenderedOnce('516fb133-4ffc-48a0-bfd2-62df5d0c95d5')): $__env->markAsRenderedOnce('516fb133-4ffc-48a0-bfd2-62df5d0c95d5');
$__env->startPush('vendors'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/vendors/transition.js'); ?>
<?php $__env->stopPush(); endif; ?>

<?php if(substr($as, 0, 2) == 'x-'): ?>
    <?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => substr($as, 2)] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\DynamicComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['data-transition' => true,'data-selector' => ''.e($selector).'','data-enter' => ''.e($enter).'','data-enter-from' => ''.e($enterFrom).'','data-enter-to' => ''.e($enterTo).'','data-leave' => ''.e($leave).'','data-leave-from' => ''.e($leaveFrom).'','data-leave-to' => ''.e($leaveTo).'','attributes' => $attributes]); ?><?php echo e($slot); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal511d4862ff04963c3c16115c05a86a9d)): ?>
<?php $attributes = $__attributesOriginal511d4862ff04963c3c16115c05a86a9d; ?>
<?php unset($__attributesOriginal511d4862ff04963c3c16115c05a86a9d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal511d4862ff04963c3c16115c05a86a9d)): ?>
<?php $component = $__componentOriginal511d4862ff04963c3c16115c05a86a9d; ?>
<?php unset($__componentOriginal511d4862ff04963c3c16115c05a86a9d); ?>
<?php endif; ?>
<?php else: ?>
    <<?php echo e($as); ?>

        data-transition
        data-selector="<?php echo e($selector); ?>"
        data-enter="<?php echo e($enter); ?>"
        data-enter-from="<?php echo e($enterFrom); ?>"
        data-enter-to="<?php echo e($enterTo); ?>"
        data-leave="<?php echo e($leave); ?>"
        data-leave-from="<?php echo e($leaveFrom); ?>"
        data-leave-to="<?php echo e($leaveTo); ?>"
        <?php echo e($attributes); ?>

    ><?php echo e($slot); ?></<?php echo e($as); ?>>
<?php endif; ?>
<?php /**PATH D:\laravel\smart-erp\resources\views/components/base/transition/index.blade.php ENDPATH**/ ?>
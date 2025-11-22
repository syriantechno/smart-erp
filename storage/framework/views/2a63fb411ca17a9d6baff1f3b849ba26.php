<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'pending' => 0,
    'inProgress' => 0,
    'approved' => 0,
    'rejected' => 0,
    'completed' => 0,
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
    'pending' => 0,
    'inProgress' => 0,
    'approved' => 0,
    'rejected' => 0,
    'completed' => 0,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div class="w-full h-full">
    <?php if (isset($component)) { $__componentOriginal5fd628dddac5e0df039575d0587916cd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5fd628dddac5e0df039575d0587916cd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.chart.index','data' => ['class' => 'material-requests-line-chart','dataPending' => ''.e($pending).'','dataInProgress' => ''.e($inProgress).'','dataApproved' => ''.e($approved).'','dataRejected' => ''.e($rejected).'','dataCompleted' => ''.e($completed).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.chart'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'material-requests-line-chart','data-pending' => ''.e($pending).'','data-in-progress' => ''.e($inProgress).'','data-approved' => ''.e($approved).'','data-rejected' => ''.e($rejected).'','data-completed' => ''.e($completed).'']); ?>
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

<?php if (! $__env->hasRenderedOnce('8db01e54-3142-4c63-915f-a2121b61bd0f')): $__env->markAsRenderedOnce('8db01e54-3142-4c63-915f-a2121b61bd0f');
$__env->startPush('scripts'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/components/material-requests-line-chart.js'); ?>
<?php $__env->stopPush(); endif; ?>
<?php /**PATH E:\ERP System\Source\resources\views/components/material-requests-line-chart.blade.php ENDPATH**/ ?>
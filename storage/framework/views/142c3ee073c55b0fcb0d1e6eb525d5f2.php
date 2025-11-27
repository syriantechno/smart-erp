<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'id',
    'title',
    'size' => 'lg',
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
    'id',
    'title',
    'size' => 'lg',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php if (! $__env->hasRenderedOnce('acab1bd3-03e2-4a08-80d7-e4d055d126f3')): $__env->markAsRenderedOnce('acab1bd3-03e2-4a08-80d7-e4d055d126f3');
$__env->startPush('styles'); ?>
    <style>
        .modal-themed-header {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 1rem;
            background: #303030;
            padding: 1rem 1.5rem;
            border-top-left-radius: 0.30rem;
            border-top-right-radius: 0.30rem;
            color: #f9fafb;
            box-shadow: 0 15px 35px rgba(48, 48, 48, 0.25);
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        @supports (background: color-mix(in srgb, red 50%, transparent)) {
            .modal-themed-header {
                background: linear-gradient(
                    135deg,
                    color-mix(in srgb, #303030 88%, transparent),
                    color-mix(in srgb, #303030 70%, #d49a24 30%)
                );
                color: #f9fafb;
            }
        }

        .modal-themed-header__title {
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: none;
            color: #f9fafb;
        }

        .modal-themed-header__subtitle {
            font-size: 0.7rem;
            font-weight: 600;
            opacity: 0.85;
        }

        .modal-themed-header__close {
            margin-left: auto;
            border: 1px solid rgba(248, 250, 252, 0.35);
            background-color: rgba(255, 255, 255, 0.08);
            color: #fff;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 0.75rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: transform 150ms ease, background-color 150ms ease;
        }

        .modal-themed-header__close:hover {
            background-color: rgba(255, 255, 255, 0.18);
            transform: translateY(-1px);
        }
    </style>
<?php $__env->stopPush(); endif; ?>

<?php if (isset($component)) { $__componentOriginalad7e71e98d6bc7c4deec90df8ba81dfd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalad7e71e98d6bc7c4deec90df8ba81dfd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.dialog.index','data' => ['id' => $id,'size' => $size]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.dialog'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($id),'size' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($size)]); ?>
    <?php if (isset($component)) { $__componentOriginal231386b9e8f52ce181634663542c77d5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal231386b9e8f52ce181634663542c77d5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.dialog.panel','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.dialog.panel'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
        <?php if (isset($component)) { $__componentOriginalcff2bb8681c24921e5a983f69e36057e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcff2bb8681c24921e5a983f69e36057e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.dialog.title','data' => ['class' => 'modal-themed-header']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.dialog.title'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'modal-themed-header']); ?>
            <div class="flex flex-col gap-1">
                <h2 class="modal-themed-header__title"><?php echo e($title); ?></h2>
            </div>
            <button
                type="button"
                class="modal-themed-header__close"
                data-tw-dismiss="modal"
                title="Close"
            >
                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'x','class' => 'w-5 h-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'x','class' => 'w-5 h-5']); ?>
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
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcff2bb8681c24921e5a983f69e36057e)): ?>
<?php $attributes = $__attributesOriginalcff2bb8681c24921e5a983f69e36057e; ?>
<?php unset($__attributesOriginalcff2bb8681c24921e5a983f69e36057e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcff2bb8681c24921e5a983f69e36057e)): ?>
<?php $component = $__componentOriginalcff2bb8681c24921e5a983f69e36057e; ?>
<?php unset($__componentOriginalcff2bb8681c24921e5a983f69e36057e); ?>
<?php endif; ?>

        <?php if (isset($component)) { $__componentOriginalddd13be32d44d36d335ddd0d0d16868a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalddd13be32d44d36d335ddd0d0d16868a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.dialog.description','data' => ['class' => 'p-5 max-h-[80vh] overflow-y-auto']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.dialog.description'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'p-5 max-h-[80vh] overflow-y-auto']); ?>
            <?php echo $slot->toHtml(); ?>

         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalddd13be32d44d36d335ddd0d0d16868a)): ?>
<?php $attributes = $__attributesOriginalddd13be32d44d36d335ddd0d0d16868a; ?>
<?php unset($__attributesOriginalddd13be32d44d36d335ddd0d0d16868a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalddd13be32d44d36d335ddd0d0d16868a)): ?>
<?php $component = $__componentOriginalddd13be32d44d36d335ddd0d0d16868a; ?>
<?php unset($__componentOriginalddd13be32d44d36d335ddd0d0d16868a); ?>
<?php endif; ?>

        <?php if(isset($footer)): ?>
            <?php if (isset($component)) { $__componentOriginal5bb3458f4debbed77859911966de4e9b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bb3458f4debbed77859911966de4e9b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.dialog.footer','data' => ['class' => 'border-t border-gray-200 dark:border-dark-5 pt-4 mt-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.dialog.footer'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'border-t border-gray-200 dark:border-dark-5 pt-4 mt-4']); ?>
                <?php echo $footer->toHtml(); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bb3458f4debbed77859911966de4e9b)): ?>
<?php $attributes = $__attributesOriginal5bb3458f4debbed77859911966de4e9b; ?>
<?php unset($__attributesOriginal5bb3458f4debbed77859911966de4e9b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bb3458f4debbed77859911966de4e9b)): ?>
<?php $component = $__componentOriginal5bb3458f4debbed77859911966de4e9b; ?>
<?php unset($__componentOriginal5bb3458f4debbed77859911966de4e9b); ?>
<?php endif; ?>
        <?php endif; ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal231386b9e8f52ce181634663542c77d5)): ?>
<?php $attributes = $__attributesOriginal231386b9e8f52ce181634663542c77d5; ?>
<?php unset($__attributesOriginal231386b9e8f52ce181634663542c77d5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal231386b9e8f52ce181634663542c77d5)): ?>
<?php $component = $__componentOriginal231386b9e8f52ce181634663542c77d5; ?>
<?php unset($__componentOriginal231386b9e8f52ce181634663542c77d5); ?>
<?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalad7e71e98d6bc7c4deec90df8ba81dfd)): ?>
<?php $attributes = $__attributesOriginalad7e71e98d6bc7c4deec90df8ba81dfd; ?>
<?php unset($__attributesOriginalad7e71e98d6bc7c4deec90df8ba81dfd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalad7e71e98d6bc7c4deec90df8ba81dfd)): ?>
<?php $component = $__componentOriginalad7e71e98d6bc7c4deec90df8ba81dfd; ?>
<?php unset($__componentOriginalad7e71e98d6bc7c4deec90df8ba81dfd); ?>
<?php endif; ?>
<?php /**PATH D:\laravel\smart-erp\resources\views/components/modal/form.blade.php ENDPATH**/ ?>
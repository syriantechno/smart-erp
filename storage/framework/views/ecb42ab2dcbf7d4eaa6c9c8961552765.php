<?php if (isset($component)) { $__componentOriginalf680044c1842e049a2fe070d6973c7e9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf680044c1842e049a2fe070d6973c7e9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.transition.index','data' => ['class' => 'dropdown-menu absolute z-[9999] hidden','selector' => '.show','enter' => 'transition-all ease-linear duration-150','enterFrom' => 'absolute !mt-5 invisible opacity-0 translate-y-1','enterTo' => '!mt-1 visible opacity-100 translate-y-0','leave' => 'transition-all ease-linear duration-150','leaveFrom' => '!mt-1 visible opacity-100 translate-y-0','leaveTo' => 'absolute !mt-5 invisible opacity-0 translate-y-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.transition'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'dropdown-menu absolute z-[9999] hidden','selector' => '.show','enter' => 'transition-all ease-linear duration-150','enterFrom' => 'absolute !mt-5 invisible opacity-0 translate-y-1','enterTo' => '!mt-1 visible opacity-100 translate-y-0','leave' => 'transition-all ease-linear duration-150','leaveFrom' => '!mt-1 visible opacity-100 translate-y-0','leaveTo' => 'absolute !mt-5 invisible opacity-0 translate-y-1']); ?>
    <div
        data-tw-merge
        <?php echo e($attributes->class(['dropdown-content rounded-md border-transparent bg-white p-2 shadow-[0px_3px_10px_#00000017] dark:border-transparent dark:bg-darkmode-600'])->merge($attributes->whereDoesntStartWith('class')->getAttributes())); ?>

    >
        <?php echo e($slot); ?>

    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf680044c1842e049a2fe070d6973c7e9)): ?>
<?php $attributes = $__attributesOriginalf680044c1842e049a2fe070d6973c7e9; ?>
<?php unset($__attributesOriginalf680044c1842e049a2fe070d6973c7e9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf680044c1842e049a2fe070d6973c7e9)): ?>
<?php $component = $__componentOriginalf680044c1842e049a2fe070d6973c7e9; ?>
<?php unset($__componentOriginalf680044c1842e049a2fe070d6973c7e9); ?>
<?php endif; ?>
<?php /**PATH E:\ERP System\Source\resources\views/components/base/menu/items.blade.php ENDPATH**/ ?>
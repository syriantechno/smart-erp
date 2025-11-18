<?php $__env->startSection('subhead'); ?>
    <title>Chart - Midone - Tailwind Admin Dashboard Template</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('subcontent'); ?>
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Chart</h2>
    </div>
    <div class="intro-y mt-5 grid grid-cols-12 gap-6">
        <div class="col-span-12 lg:col-span-6">
            <!-- BEGIN: Vertical Bar Chart -->
            <?php if (isset($component)) { $__componentOriginal1e00c22da64774fd0d873cb958c26686 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1e00c22da64774fd0d873cb958c26686 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.preview-component.index','data' => ['class' => 'intro-y box']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.preview-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'intro-y box']); ?>
                <div
                    class="flex flex-col items-center border-b border-slate-200/60 p-5 dark:border-darkmode-400 sm:flex-row">
                    <h2 class="mr-auto text-base font-medium">
                        Vertical Bar Chart
                    </h2>
                    <?php if (isset($component)) { $__componentOriginal0e9b1708c541f0772f542e0482be43cc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0e9b1708c541f0772f542e0482be43cc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-switch.index','data' => ['class' => 'mt-3 w-full sm:ml-auto sm:mt-0 sm:w-auto']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-switch'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-3 w-full sm:ml-auto sm:mt-0 sm:w-auto']); ?>
                        <?php if (isset($component)) { $__componentOriginal2d72b4ed762a09d18a89903d2344442f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2d72b4ed762a09d18a89903d2344442f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-switch.label','data' => ['for' => 'show-example-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-switch.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'show-example-1']); ?>
                            Show example code
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2d72b4ed762a09d18a89903d2344442f)): ?>
<?php $attributes = $__attributesOriginal2d72b4ed762a09d18a89903d2344442f; ?>
<?php unset($__attributesOriginal2d72b4ed762a09d18a89903d2344442f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2d72b4ed762a09d18a89903d2344442f)): ?>
<?php $component = $__componentOriginal2d72b4ed762a09d18a89903d2344442f; ?>
<?php unset($__componentOriginal2d72b4ed762a09d18a89903d2344442f); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginala545c0dc845886385891e9173fb8e250 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala545c0dc845886385891e9173fb8e250 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-switch.input','data' => ['class' => 'ml-3 mr-0','id' => 'show-example-1','type' => 'checkbox']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-switch.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'ml-3 mr-0','id' => 'show-example-1','type' => 'checkbox']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala545c0dc845886385891e9173fb8e250)): ?>
<?php $attributes = $__attributesOriginala545c0dc845886385891e9173fb8e250; ?>
<?php unset($__attributesOriginala545c0dc845886385891e9173fb8e250); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala545c0dc845886385891e9173fb8e250)): ?>
<?php $component = $__componentOriginala545c0dc845886385891e9173fb8e250; ?>
<?php unset($__componentOriginala545c0dc845886385891e9173fb8e250); ?>
<?php endif; ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0e9b1708c541f0772f542e0482be43cc)): ?>
<?php $attributes = $__attributesOriginal0e9b1708c541f0772f542e0482be43cc; ?>
<?php unset($__attributesOriginal0e9b1708c541f0772f542e0482be43cc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0e9b1708c541f0772f542e0482be43cc)): ?>
<?php $component = $__componentOriginal0e9b1708c541f0772f542e0482be43cc; ?>
<?php unset($__componentOriginal0e9b1708c541f0772f542e0482be43cc); ?>
<?php endif; ?>
                </div>
                <div class="p-5">
                    <?php if (isset($component)) { $__componentOriginal104ae678e1fe7772577c7c9566b19e53 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal104ae678e1fe7772577c7c9566b19e53 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.preview.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.preview'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                        <?php if (isset($component)) { $__componentOriginal6f99e8445b1129a0deb989e448f261ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6f99e8445b1129a0deb989e448f261ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.vertical-bar-chart.index','data' => ['height' => 'h-[400px]']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('vertical-bar-chart'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['height' => 'h-[400px]']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6f99e8445b1129a0deb989e448f261ee)): ?>
<?php $attributes = $__attributesOriginal6f99e8445b1129a0deb989e448f261ee; ?>
<?php unset($__attributesOriginal6f99e8445b1129a0deb989e448f261ee); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6f99e8445b1129a0deb989e448f261ee)): ?>
<?php $component = $__componentOriginal6f99e8445b1129a0deb989e448f261ee; ?>
<?php unset($__componentOriginal6f99e8445b1129a0deb989e448f261ee); ?>
<?php endif; ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal104ae678e1fe7772577c7c9566b19e53)): ?>
<?php $attributes = $__attributesOriginal104ae678e1fe7772577c7c9566b19e53; ?>
<?php unset($__attributesOriginal104ae678e1fe7772577c7c9566b19e53); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal104ae678e1fe7772577c7c9566b19e53)): ?>
<?php $component = $__componentOriginal104ae678e1fe7772577c7c9566b19e53; ?>
<?php unset($__componentOriginal104ae678e1fe7772577c7c9566b19e53); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginalc50921fa19a58987fc5ef0780b4ea876 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc50921fa19a58987fc5ef0780b4ea876 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.source.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.source'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                        <?php if (isset($component)) { $__componentOriginalf84bfef2e4b7363f7e3ce2496a4a8820 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf84bfef2e4b7363f7e3ce2496a4a8820 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.highlight.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.highlight'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                            <?php if (isset($component)) { $__componentOriginal6f99e8445b1129a0deb989e448f261ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6f99e8445b1129a0deb989e448f261ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.vertical-bar-chart.index','data' => ['height' => 'h-[400px]']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('vertical-bar-chart'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['height' => 'h-[400px]']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6f99e8445b1129a0deb989e448f261ee)): ?>
<?php $attributes = $__attributesOriginal6f99e8445b1129a0deb989e448f261ee; ?>
<?php unset($__attributesOriginal6f99e8445b1129a0deb989e448f261ee); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6f99e8445b1129a0deb989e448f261ee)): ?>
<?php $component = $__componentOriginal6f99e8445b1129a0deb989e448f261ee; ?>
<?php unset($__componentOriginal6f99e8445b1129a0deb989e448f261ee); ?>
<?php endif; ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf84bfef2e4b7363f7e3ce2496a4a8820)): ?>
<?php $attributes = $__attributesOriginalf84bfef2e4b7363f7e3ce2496a4a8820; ?>
<?php unset($__attributesOriginalf84bfef2e4b7363f7e3ce2496a4a8820); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf84bfef2e4b7363f7e3ce2496a4a8820)): ?>
<?php $component = $__componentOriginalf84bfef2e4b7363f7e3ce2496a4a8820; ?>
<?php unset($__componentOriginalf84bfef2e4b7363f7e3ce2496a4a8820); ?>
<?php endif; ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc50921fa19a58987fc5ef0780b4ea876)): ?>
<?php $attributes = $__attributesOriginalc50921fa19a58987fc5ef0780b4ea876; ?>
<?php unset($__attributesOriginalc50921fa19a58987fc5ef0780b4ea876); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc50921fa19a58987fc5ef0780b4ea876)): ?>
<?php $component = $__componentOriginalc50921fa19a58987fc5ef0780b4ea876; ?>
<?php unset($__componentOriginalc50921fa19a58987fc5ef0780b4ea876); ?>
<?php endif; ?>
                </div>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1e00c22da64774fd0d873cb958c26686)): ?>
<?php $attributes = $__attributesOriginal1e00c22da64774fd0d873cb958c26686; ?>
<?php unset($__attributesOriginal1e00c22da64774fd0d873cb958c26686); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1e00c22da64774fd0d873cb958c26686)): ?>
<?php $component = $__componentOriginal1e00c22da64774fd0d873cb958c26686; ?>
<?php unset($__componentOriginal1e00c22da64774fd0d873cb958c26686); ?>
<?php endif; ?>
            <!-- END: Vertical Bar Chart -->
            <!-- BEGIN: Horizontal Bar Chart -->
            <?php if (isset($component)) { $__componentOriginal1e00c22da64774fd0d873cb958c26686 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1e00c22da64774fd0d873cb958c26686 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.preview-component.index','data' => ['class' => 'intro-y box mt-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.preview-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'intro-y box mt-5']); ?>
                <div
                    class="flex flex-col items-center border-b border-slate-200/60 p-5 dark:border-darkmode-400 sm:flex-row">
                    <h2 class="mr-auto text-base font-medium">
                        Horizontal Bar Chart
                    </h2>
                    <?php if (isset($component)) { $__componentOriginal0e9b1708c541f0772f542e0482be43cc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0e9b1708c541f0772f542e0482be43cc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-switch.index','data' => ['class' => 'mt-3 w-full sm:ml-auto sm:mt-0 sm:w-auto']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-switch'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-3 w-full sm:ml-auto sm:mt-0 sm:w-auto']); ?>
                        <?php if (isset($component)) { $__componentOriginal2d72b4ed762a09d18a89903d2344442f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2d72b4ed762a09d18a89903d2344442f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-switch.label','data' => ['for' => 'show-example-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-switch.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'show-example-2']); ?>
                            Show example code
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2d72b4ed762a09d18a89903d2344442f)): ?>
<?php $attributes = $__attributesOriginal2d72b4ed762a09d18a89903d2344442f; ?>
<?php unset($__attributesOriginal2d72b4ed762a09d18a89903d2344442f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2d72b4ed762a09d18a89903d2344442f)): ?>
<?php $component = $__componentOriginal2d72b4ed762a09d18a89903d2344442f; ?>
<?php unset($__componentOriginal2d72b4ed762a09d18a89903d2344442f); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginala545c0dc845886385891e9173fb8e250 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala545c0dc845886385891e9173fb8e250 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-switch.input','data' => ['class' => 'ml-3 mr-0','id' => 'show-example-2','type' => 'checkbox']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-switch.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'ml-3 mr-0','id' => 'show-example-2','type' => 'checkbox']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala545c0dc845886385891e9173fb8e250)): ?>
<?php $attributes = $__attributesOriginala545c0dc845886385891e9173fb8e250; ?>
<?php unset($__attributesOriginala545c0dc845886385891e9173fb8e250); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala545c0dc845886385891e9173fb8e250)): ?>
<?php $component = $__componentOriginala545c0dc845886385891e9173fb8e250; ?>
<?php unset($__componentOriginala545c0dc845886385891e9173fb8e250); ?>
<?php endif; ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0e9b1708c541f0772f542e0482be43cc)): ?>
<?php $attributes = $__attributesOriginal0e9b1708c541f0772f542e0482be43cc; ?>
<?php unset($__attributesOriginal0e9b1708c541f0772f542e0482be43cc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0e9b1708c541f0772f542e0482be43cc)): ?>
<?php $component = $__componentOriginal0e9b1708c541f0772f542e0482be43cc; ?>
<?php unset($__componentOriginal0e9b1708c541f0772f542e0482be43cc); ?>
<?php endif; ?>
                </div>
                <div class="p-5">
                    <?php if (isset($component)) { $__componentOriginal104ae678e1fe7772577c7c9566b19e53 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal104ae678e1fe7772577c7c9566b19e53 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.preview.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.preview'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                        <?php if (isset($component)) { $__componentOriginal005f4b5d879c691604f4b99f31627309 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal005f4b5d879c691604f4b99f31627309 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.horizontal-bar-chart.index','data' => ['height' => 'h-[400px]']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('horizontal-bar-chart'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['height' => 'h-[400px]']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal005f4b5d879c691604f4b99f31627309)): ?>
<?php $attributes = $__attributesOriginal005f4b5d879c691604f4b99f31627309; ?>
<?php unset($__attributesOriginal005f4b5d879c691604f4b99f31627309); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal005f4b5d879c691604f4b99f31627309)): ?>
<?php $component = $__componentOriginal005f4b5d879c691604f4b99f31627309; ?>
<?php unset($__componentOriginal005f4b5d879c691604f4b99f31627309); ?>
<?php endif; ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal104ae678e1fe7772577c7c9566b19e53)): ?>
<?php $attributes = $__attributesOriginal104ae678e1fe7772577c7c9566b19e53; ?>
<?php unset($__attributesOriginal104ae678e1fe7772577c7c9566b19e53); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal104ae678e1fe7772577c7c9566b19e53)): ?>
<?php $component = $__componentOriginal104ae678e1fe7772577c7c9566b19e53; ?>
<?php unset($__componentOriginal104ae678e1fe7772577c7c9566b19e53); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginalc50921fa19a58987fc5ef0780b4ea876 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc50921fa19a58987fc5ef0780b4ea876 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.source.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.source'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                        <?php if (isset($component)) { $__componentOriginalf84bfef2e4b7363f7e3ce2496a4a8820 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf84bfef2e4b7363f7e3ce2496a4a8820 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.highlight.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.highlight'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                            <?php if (isset($component)) { $__componentOriginal005f4b5d879c691604f4b99f31627309 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal005f4b5d879c691604f4b99f31627309 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.horizontal-bar-chart.index','data' => ['height' => 'h-[400px]']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('horizontal-bar-chart'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['height' => 'h-[400px]']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal005f4b5d879c691604f4b99f31627309)): ?>
<?php $attributes = $__attributesOriginal005f4b5d879c691604f4b99f31627309; ?>
<?php unset($__attributesOriginal005f4b5d879c691604f4b99f31627309); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal005f4b5d879c691604f4b99f31627309)): ?>
<?php $component = $__componentOriginal005f4b5d879c691604f4b99f31627309; ?>
<?php unset($__componentOriginal005f4b5d879c691604f4b99f31627309); ?>
<?php endif; ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf84bfef2e4b7363f7e3ce2496a4a8820)): ?>
<?php $attributes = $__attributesOriginalf84bfef2e4b7363f7e3ce2496a4a8820; ?>
<?php unset($__attributesOriginalf84bfef2e4b7363f7e3ce2496a4a8820); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf84bfef2e4b7363f7e3ce2496a4a8820)): ?>
<?php $component = $__componentOriginalf84bfef2e4b7363f7e3ce2496a4a8820; ?>
<?php unset($__componentOriginalf84bfef2e4b7363f7e3ce2496a4a8820); ?>
<?php endif; ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc50921fa19a58987fc5ef0780b4ea876)): ?>
<?php $attributes = $__attributesOriginalc50921fa19a58987fc5ef0780b4ea876; ?>
<?php unset($__attributesOriginalc50921fa19a58987fc5ef0780b4ea876); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc50921fa19a58987fc5ef0780b4ea876)): ?>
<?php $component = $__componentOriginalc50921fa19a58987fc5ef0780b4ea876; ?>
<?php unset($__componentOriginalc50921fa19a58987fc5ef0780b4ea876); ?>
<?php endif; ?>
                </div>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1e00c22da64774fd0d873cb958c26686)): ?>
<?php $attributes = $__attributesOriginal1e00c22da64774fd0d873cb958c26686; ?>
<?php unset($__attributesOriginal1e00c22da64774fd0d873cb958c26686); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1e00c22da64774fd0d873cb958c26686)): ?>
<?php $component = $__componentOriginal1e00c22da64774fd0d873cb958c26686; ?>
<?php unset($__componentOriginal1e00c22da64774fd0d873cb958c26686); ?>
<?php endif; ?>
            <!-- END: Horizontal Bar Chart -->
            <!-- BEGIN: Donut Chart -->
            <?php if (isset($component)) { $__componentOriginal1e00c22da64774fd0d873cb958c26686 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1e00c22da64774fd0d873cb958c26686 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.preview-component.index','data' => ['class' => 'intro-y box mt-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.preview-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'intro-y box mt-5']); ?>
                <div
                    class="flex flex-col items-center border-b border-slate-200/60 p-5 dark:border-darkmode-400 sm:flex-row">
                    <h2 class="mr-auto text-base font-medium">Donut Chart</h2>
                    <?php if (isset($component)) { $__componentOriginal0e9b1708c541f0772f542e0482be43cc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0e9b1708c541f0772f542e0482be43cc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-switch.index','data' => ['class' => 'mt-3 w-full sm:ml-auto sm:mt-0 sm:w-auto']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-switch'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-3 w-full sm:ml-auto sm:mt-0 sm:w-auto']); ?>
                        <?php if (isset($component)) { $__componentOriginal2d72b4ed762a09d18a89903d2344442f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2d72b4ed762a09d18a89903d2344442f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-switch.label','data' => ['for' => 'show-example-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-switch.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'show-example-3']); ?>
                            Show example code
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2d72b4ed762a09d18a89903d2344442f)): ?>
<?php $attributes = $__attributesOriginal2d72b4ed762a09d18a89903d2344442f; ?>
<?php unset($__attributesOriginal2d72b4ed762a09d18a89903d2344442f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2d72b4ed762a09d18a89903d2344442f)): ?>
<?php $component = $__componentOriginal2d72b4ed762a09d18a89903d2344442f; ?>
<?php unset($__componentOriginal2d72b4ed762a09d18a89903d2344442f); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginala545c0dc845886385891e9173fb8e250 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala545c0dc845886385891e9173fb8e250 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-switch.input','data' => ['class' => 'ml-3 mr-0','id' => 'show-example-3','type' => 'checkbox']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-switch.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'ml-3 mr-0','id' => 'show-example-3','type' => 'checkbox']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala545c0dc845886385891e9173fb8e250)): ?>
<?php $attributes = $__attributesOriginala545c0dc845886385891e9173fb8e250; ?>
<?php unset($__attributesOriginala545c0dc845886385891e9173fb8e250); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala545c0dc845886385891e9173fb8e250)): ?>
<?php $component = $__componentOriginala545c0dc845886385891e9173fb8e250; ?>
<?php unset($__componentOriginala545c0dc845886385891e9173fb8e250); ?>
<?php endif; ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0e9b1708c541f0772f542e0482be43cc)): ?>
<?php $attributes = $__attributesOriginal0e9b1708c541f0772f542e0482be43cc; ?>
<?php unset($__attributesOriginal0e9b1708c541f0772f542e0482be43cc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0e9b1708c541f0772f542e0482be43cc)): ?>
<?php $component = $__componentOriginal0e9b1708c541f0772f542e0482be43cc; ?>
<?php unset($__componentOriginal0e9b1708c541f0772f542e0482be43cc); ?>
<?php endif; ?>
                </div>
                <div class="p-5">
                    <?php if (isset($component)) { $__componentOriginal104ae678e1fe7772577c7c9566b19e53 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal104ae678e1fe7772577c7c9566b19e53 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.preview.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.preview'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                        <?php if (isset($component)) { $__componentOriginaleb4680f19f6910399be4a108cac83983 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaleb4680f19f6910399be4a108cac83983 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.donut-chart.index','data' => ['height' => 'h-[400px]']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('donut-chart'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['height' => 'h-[400px]']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaleb4680f19f6910399be4a108cac83983)): ?>
<?php $attributes = $__attributesOriginaleb4680f19f6910399be4a108cac83983; ?>
<?php unset($__attributesOriginaleb4680f19f6910399be4a108cac83983); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaleb4680f19f6910399be4a108cac83983)): ?>
<?php $component = $__componentOriginaleb4680f19f6910399be4a108cac83983; ?>
<?php unset($__componentOriginaleb4680f19f6910399be4a108cac83983); ?>
<?php endif; ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal104ae678e1fe7772577c7c9566b19e53)): ?>
<?php $attributes = $__attributesOriginal104ae678e1fe7772577c7c9566b19e53; ?>
<?php unset($__attributesOriginal104ae678e1fe7772577c7c9566b19e53); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal104ae678e1fe7772577c7c9566b19e53)): ?>
<?php $component = $__componentOriginal104ae678e1fe7772577c7c9566b19e53; ?>
<?php unset($__componentOriginal104ae678e1fe7772577c7c9566b19e53); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginalc50921fa19a58987fc5ef0780b4ea876 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc50921fa19a58987fc5ef0780b4ea876 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.source.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.source'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                        <?php if (isset($component)) { $__componentOriginalf84bfef2e4b7363f7e3ce2496a4a8820 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf84bfef2e4b7363f7e3ce2496a4a8820 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.highlight.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.highlight'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                            <?php if (isset($component)) { $__componentOriginaleb4680f19f6910399be4a108cac83983 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaleb4680f19f6910399be4a108cac83983 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.donut-chart.index','data' => ['height' => 'h-[400px]']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('donut-chart'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['height' => 'h-[400px]']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaleb4680f19f6910399be4a108cac83983)): ?>
<?php $attributes = $__attributesOriginaleb4680f19f6910399be4a108cac83983; ?>
<?php unset($__attributesOriginaleb4680f19f6910399be4a108cac83983); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaleb4680f19f6910399be4a108cac83983)): ?>
<?php $component = $__componentOriginaleb4680f19f6910399be4a108cac83983; ?>
<?php unset($__componentOriginaleb4680f19f6910399be4a108cac83983); ?>
<?php endif; ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf84bfef2e4b7363f7e3ce2496a4a8820)): ?>
<?php $attributes = $__attributesOriginalf84bfef2e4b7363f7e3ce2496a4a8820; ?>
<?php unset($__attributesOriginalf84bfef2e4b7363f7e3ce2496a4a8820); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf84bfef2e4b7363f7e3ce2496a4a8820)): ?>
<?php $component = $__componentOriginalf84bfef2e4b7363f7e3ce2496a4a8820; ?>
<?php unset($__componentOriginalf84bfef2e4b7363f7e3ce2496a4a8820); ?>
<?php endif; ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc50921fa19a58987fc5ef0780b4ea876)): ?>
<?php $attributes = $__attributesOriginalc50921fa19a58987fc5ef0780b4ea876; ?>
<?php unset($__attributesOriginalc50921fa19a58987fc5ef0780b4ea876); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc50921fa19a58987fc5ef0780b4ea876)): ?>
<?php $component = $__componentOriginalc50921fa19a58987fc5ef0780b4ea876; ?>
<?php unset($__componentOriginalc50921fa19a58987fc5ef0780b4ea876); ?>
<?php endif; ?>
                </div>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1e00c22da64774fd0d873cb958c26686)): ?>
<?php $attributes = $__attributesOriginal1e00c22da64774fd0d873cb958c26686; ?>
<?php unset($__attributesOriginal1e00c22da64774fd0d873cb958c26686); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1e00c22da64774fd0d873cb958c26686)): ?>
<?php $component = $__componentOriginal1e00c22da64774fd0d873cb958c26686; ?>
<?php unset($__componentOriginal1e00c22da64774fd0d873cb958c26686); ?>
<?php endif; ?>
            <!-- END: Donut Chart -->
        </div>
        <div class="col-span-12 lg:col-span-6">
            <!-- BEGIN: Stacked Bar Chart -->
            <?php if (isset($component)) { $__componentOriginal1e00c22da64774fd0d873cb958c26686 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1e00c22da64774fd0d873cb958c26686 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.preview-component.index','data' => ['class' => 'intro-y box']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.preview-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'intro-y box']); ?>
                <div
                    class="flex flex-col items-center border-b border-slate-200/60 p-5 dark:border-darkmode-400 sm:flex-row">
                    <h2 class="mr-auto text-base font-medium">
                        Stacked Bar Chart
                    </h2>
                    <?php if (isset($component)) { $__componentOriginal0e9b1708c541f0772f542e0482be43cc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0e9b1708c541f0772f542e0482be43cc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-switch.index','data' => ['class' => 'mt-3 w-full sm:ml-auto sm:mt-0 sm:w-auto']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-switch'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-3 w-full sm:ml-auto sm:mt-0 sm:w-auto']); ?>
                        <?php if (isset($component)) { $__componentOriginal2d72b4ed762a09d18a89903d2344442f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2d72b4ed762a09d18a89903d2344442f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-switch.label','data' => ['for' => 'show-example-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-switch.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'show-example-4']); ?>
                            Show example code
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2d72b4ed762a09d18a89903d2344442f)): ?>
<?php $attributes = $__attributesOriginal2d72b4ed762a09d18a89903d2344442f; ?>
<?php unset($__attributesOriginal2d72b4ed762a09d18a89903d2344442f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2d72b4ed762a09d18a89903d2344442f)): ?>
<?php $component = $__componentOriginal2d72b4ed762a09d18a89903d2344442f; ?>
<?php unset($__componentOriginal2d72b4ed762a09d18a89903d2344442f); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginala545c0dc845886385891e9173fb8e250 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala545c0dc845886385891e9173fb8e250 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-switch.input','data' => ['class' => 'ml-3 mr-0','id' => 'show-example-4','type' => 'checkbox']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-switch.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'ml-3 mr-0','id' => 'show-example-4','type' => 'checkbox']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala545c0dc845886385891e9173fb8e250)): ?>
<?php $attributes = $__attributesOriginala545c0dc845886385891e9173fb8e250; ?>
<?php unset($__attributesOriginala545c0dc845886385891e9173fb8e250); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala545c0dc845886385891e9173fb8e250)): ?>
<?php $component = $__componentOriginala545c0dc845886385891e9173fb8e250; ?>
<?php unset($__componentOriginala545c0dc845886385891e9173fb8e250); ?>
<?php endif; ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0e9b1708c541f0772f542e0482be43cc)): ?>
<?php $attributes = $__attributesOriginal0e9b1708c541f0772f542e0482be43cc; ?>
<?php unset($__attributesOriginal0e9b1708c541f0772f542e0482be43cc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0e9b1708c541f0772f542e0482be43cc)): ?>
<?php $component = $__componentOriginal0e9b1708c541f0772f542e0482be43cc; ?>
<?php unset($__componentOriginal0e9b1708c541f0772f542e0482be43cc); ?>
<?php endif; ?>
                </div>
                <div class="p-5">
                    <?php if (isset($component)) { $__componentOriginal104ae678e1fe7772577c7c9566b19e53 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal104ae678e1fe7772577c7c9566b19e53 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.preview.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.preview'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                        <?php if (isset($component)) { $__componentOriginale21c1bfdca34eb84ef54d65edd58f09a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale21c1bfdca34eb84ef54d65edd58f09a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stacked-bar-chart.index','data' => ['height' => 'h-[400px]']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stacked-bar-chart'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['height' => 'h-[400px]']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale21c1bfdca34eb84ef54d65edd58f09a)): ?>
<?php $attributes = $__attributesOriginale21c1bfdca34eb84ef54d65edd58f09a; ?>
<?php unset($__attributesOriginale21c1bfdca34eb84ef54d65edd58f09a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale21c1bfdca34eb84ef54d65edd58f09a)): ?>
<?php $component = $__componentOriginale21c1bfdca34eb84ef54d65edd58f09a; ?>
<?php unset($__componentOriginale21c1bfdca34eb84ef54d65edd58f09a); ?>
<?php endif; ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal104ae678e1fe7772577c7c9566b19e53)): ?>
<?php $attributes = $__attributesOriginal104ae678e1fe7772577c7c9566b19e53; ?>
<?php unset($__attributesOriginal104ae678e1fe7772577c7c9566b19e53); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal104ae678e1fe7772577c7c9566b19e53)): ?>
<?php $component = $__componentOriginal104ae678e1fe7772577c7c9566b19e53; ?>
<?php unset($__componentOriginal104ae678e1fe7772577c7c9566b19e53); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginalc50921fa19a58987fc5ef0780b4ea876 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc50921fa19a58987fc5ef0780b4ea876 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.source.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.source'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                        <?php if (isset($component)) { $__componentOriginalf84bfef2e4b7363f7e3ce2496a4a8820 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf84bfef2e4b7363f7e3ce2496a4a8820 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.highlight.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.highlight'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                            <?php if (isset($component)) { $__componentOriginale21c1bfdca34eb84ef54d65edd58f09a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale21c1bfdca34eb84ef54d65edd58f09a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stacked-bar-chart.index','data' => ['height' => 'h-[400px]']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stacked-bar-chart'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['height' => 'h-[400px]']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale21c1bfdca34eb84ef54d65edd58f09a)): ?>
<?php $attributes = $__attributesOriginale21c1bfdca34eb84ef54d65edd58f09a; ?>
<?php unset($__attributesOriginale21c1bfdca34eb84ef54d65edd58f09a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale21c1bfdca34eb84ef54d65edd58f09a)): ?>
<?php $component = $__componentOriginale21c1bfdca34eb84ef54d65edd58f09a; ?>
<?php unset($__componentOriginale21c1bfdca34eb84ef54d65edd58f09a); ?>
<?php endif; ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf84bfef2e4b7363f7e3ce2496a4a8820)): ?>
<?php $attributes = $__attributesOriginalf84bfef2e4b7363f7e3ce2496a4a8820; ?>
<?php unset($__attributesOriginalf84bfef2e4b7363f7e3ce2496a4a8820); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf84bfef2e4b7363f7e3ce2496a4a8820)): ?>
<?php $component = $__componentOriginalf84bfef2e4b7363f7e3ce2496a4a8820; ?>
<?php unset($__componentOriginalf84bfef2e4b7363f7e3ce2496a4a8820); ?>
<?php endif; ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc50921fa19a58987fc5ef0780b4ea876)): ?>
<?php $attributes = $__attributesOriginalc50921fa19a58987fc5ef0780b4ea876; ?>
<?php unset($__attributesOriginalc50921fa19a58987fc5ef0780b4ea876); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc50921fa19a58987fc5ef0780b4ea876)): ?>
<?php $component = $__componentOriginalc50921fa19a58987fc5ef0780b4ea876; ?>
<?php unset($__componentOriginalc50921fa19a58987fc5ef0780b4ea876); ?>
<?php endif; ?>
                </div>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1e00c22da64774fd0d873cb958c26686)): ?>
<?php $attributes = $__attributesOriginal1e00c22da64774fd0d873cb958c26686; ?>
<?php unset($__attributesOriginal1e00c22da64774fd0d873cb958c26686); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1e00c22da64774fd0d873cb958c26686)): ?>
<?php $component = $__componentOriginal1e00c22da64774fd0d873cb958c26686; ?>
<?php unset($__componentOriginal1e00c22da64774fd0d873cb958c26686); ?>
<?php endif; ?>
            <!-- END: Stacked Bar Chart -->
            <!-- BEGIN: Line Chart -->
            <?php if (isset($component)) { $__componentOriginal1e00c22da64774fd0d873cb958c26686 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1e00c22da64774fd0d873cb958c26686 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.preview-component.index','data' => ['class' => 'intro-y box mt-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.preview-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'intro-y box mt-5']); ?>
                <div
                    class="flex flex-col items-center border-b border-slate-200/60 p-5 dark:border-darkmode-400 sm:flex-row">
                    <h2 class="mr-auto text-base font-medium">Line Chart</h2>
                    <?php if (isset($component)) { $__componentOriginal0e9b1708c541f0772f542e0482be43cc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0e9b1708c541f0772f542e0482be43cc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-switch.index','data' => ['class' => 'mt-3 w-full sm:ml-auto sm:mt-0 sm:w-auto']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-switch'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-3 w-full sm:ml-auto sm:mt-0 sm:w-auto']); ?>
                        <?php if (isset($component)) { $__componentOriginal2d72b4ed762a09d18a89903d2344442f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2d72b4ed762a09d18a89903d2344442f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-switch.label','data' => ['for' => 'show-example-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-switch.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'show-example-5']); ?>
                            Show example code
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2d72b4ed762a09d18a89903d2344442f)): ?>
<?php $attributes = $__attributesOriginal2d72b4ed762a09d18a89903d2344442f; ?>
<?php unset($__attributesOriginal2d72b4ed762a09d18a89903d2344442f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2d72b4ed762a09d18a89903d2344442f)): ?>
<?php $component = $__componentOriginal2d72b4ed762a09d18a89903d2344442f; ?>
<?php unset($__componentOriginal2d72b4ed762a09d18a89903d2344442f); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginala545c0dc845886385891e9173fb8e250 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala545c0dc845886385891e9173fb8e250 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-switch.input','data' => ['class' => 'ml-3 mr-0','id' => 'show-example-5','type' => 'checkbox']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-switch.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'ml-3 mr-0','id' => 'show-example-5','type' => 'checkbox']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala545c0dc845886385891e9173fb8e250)): ?>
<?php $attributes = $__attributesOriginala545c0dc845886385891e9173fb8e250; ?>
<?php unset($__attributesOriginala545c0dc845886385891e9173fb8e250); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala545c0dc845886385891e9173fb8e250)): ?>
<?php $component = $__componentOriginala545c0dc845886385891e9173fb8e250; ?>
<?php unset($__componentOriginala545c0dc845886385891e9173fb8e250); ?>
<?php endif; ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0e9b1708c541f0772f542e0482be43cc)): ?>
<?php $attributes = $__attributesOriginal0e9b1708c541f0772f542e0482be43cc; ?>
<?php unset($__attributesOriginal0e9b1708c541f0772f542e0482be43cc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0e9b1708c541f0772f542e0482be43cc)): ?>
<?php $component = $__componentOriginal0e9b1708c541f0772f542e0482be43cc; ?>
<?php unset($__componentOriginal0e9b1708c541f0772f542e0482be43cc); ?>
<?php endif; ?>
                </div>
                <div class="p-5">
                    <?php if (isset($component)) { $__componentOriginal104ae678e1fe7772577c7c9566b19e53 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal104ae678e1fe7772577c7c9566b19e53 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.preview.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.preview'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                        <?php if (isset($component)) { $__componentOriginal1d640cb4ac758fdb081df5b51e265af0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1d640cb4ac758fdb081df5b51e265af0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.line-chart.index','data' => ['height' => 'h-[400px]']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('line-chart'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['height' => 'h-[400px]']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1d640cb4ac758fdb081df5b51e265af0)): ?>
<?php $attributes = $__attributesOriginal1d640cb4ac758fdb081df5b51e265af0; ?>
<?php unset($__attributesOriginal1d640cb4ac758fdb081df5b51e265af0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1d640cb4ac758fdb081df5b51e265af0)): ?>
<?php $component = $__componentOriginal1d640cb4ac758fdb081df5b51e265af0; ?>
<?php unset($__componentOriginal1d640cb4ac758fdb081df5b51e265af0); ?>
<?php endif; ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal104ae678e1fe7772577c7c9566b19e53)): ?>
<?php $attributes = $__attributesOriginal104ae678e1fe7772577c7c9566b19e53; ?>
<?php unset($__attributesOriginal104ae678e1fe7772577c7c9566b19e53); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal104ae678e1fe7772577c7c9566b19e53)): ?>
<?php $component = $__componentOriginal104ae678e1fe7772577c7c9566b19e53; ?>
<?php unset($__componentOriginal104ae678e1fe7772577c7c9566b19e53); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginalc50921fa19a58987fc5ef0780b4ea876 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc50921fa19a58987fc5ef0780b4ea876 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.source.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.source'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                        <?php if (isset($component)) { $__componentOriginalf84bfef2e4b7363f7e3ce2496a4a8820 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf84bfef2e4b7363f7e3ce2496a4a8820 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.highlight.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.highlight'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                            <?php if (isset($component)) { $__componentOriginal1d640cb4ac758fdb081df5b51e265af0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1d640cb4ac758fdb081df5b51e265af0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.line-chart.index','data' => ['height' => 'h-[400px]']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('line-chart'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['height' => 'h-[400px]']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1d640cb4ac758fdb081df5b51e265af0)): ?>
<?php $attributes = $__attributesOriginal1d640cb4ac758fdb081df5b51e265af0; ?>
<?php unset($__attributesOriginal1d640cb4ac758fdb081df5b51e265af0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1d640cb4ac758fdb081df5b51e265af0)): ?>
<?php $component = $__componentOriginal1d640cb4ac758fdb081df5b51e265af0; ?>
<?php unset($__componentOriginal1d640cb4ac758fdb081df5b51e265af0); ?>
<?php endif; ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf84bfef2e4b7363f7e3ce2496a4a8820)): ?>
<?php $attributes = $__attributesOriginalf84bfef2e4b7363f7e3ce2496a4a8820; ?>
<?php unset($__attributesOriginalf84bfef2e4b7363f7e3ce2496a4a8820); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf84bfef2e4b7363f7e3ce2496a4a8820)): ?>
<?php $component = $__componentOriginalf84bfef2e4b7363f7e3ce2496a4a8820; ?>
<?php unset($__componentOriginalf84bfef2e4b7363f7e3ce2496a4a8820); ?>
<?php endif; ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc50921fa19a58987fc5ef0780b4ea876)): ?>
<?php $attributes = $__attributesOriginalc50921fa19a58987fc5ef0780b4ea876; ?>
<?php unset($__attributesOriginalc50921fa19a58987fc5ef0780b4ea876); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc50921fa19a58987fc5ef0780b4ea876)): ?>
<?php $component = $__componentOriginalc50921fa19a58987fc5ef0780b4ea876; ?>
<?php unset($__componentOriginalc50921fa19a58987fc5ef0780b4ea876); ?>
<?php endif; ?>
                </div>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1e00c22da64774fd0d873cb958c26686)): ?>
<?php $attributes = $__attributesOriginal1e00c22da64774fd0d873cb958c26686; ?>
<?php unset($__attributesOriginal1e00c22da64774fd0d873cb958c26686); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1e00c22da64774fd0d873cb958c26686)): ?>
<?php $component = $__componentOriginal1e00c22da64774fd0d873cb958c26686; ?>
<?php unset($__componentOriginal1e00c22da64774fd0d873cb958c26686); ?>
<?php endif; ?>
            <!-- END: Line Chart -->
            <!-- BEGIN: Pie Chart -->
            <?php if (isset($component)) { $__componentOriginal1e00c22da64774fd0d873cb958c26686 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1e00c22da64774fd0d873cb958c26686 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.preview-component.index','data' => ['class' => 'intro-y box mt-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.preview-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'intro-y box mt-5']); ?>
                <div
                    class="flex flex-col items-center border-b border-slate-200/60 p-5 dark:border-darkmode-400 sm:flex-row">
                    <h2 class="mr-auto text-base font-medium">Pie Chart</h2>
                    <?php if (isset($component)) { $__componentOriginal0e9b1708c541f0772f542e0482be43cc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0e9b1708c541f0772f542e0482be43cc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-switch.index','data' => ['class' => 'mt-3 w-full sm:ml-auto sm:mt-0 sm:w-auto']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-switch'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-3 w-full sm:ml-auto sm:mt-0 sm:w-auto']); ?>
                        <?php if (isset($component)) { $__componentOriginal2d72b4ed762a09d18a89903d2344442f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2d72b4ed762a09d18a89903d2344442f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-switch.label','data' => ['for' => 'show-example-6']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-switch.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'show-example-6']); ?>
                            Show example code
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2d72b4ed762a09d18a89903d2344442f)): ?>
<?php $attributes = $__attributesOriginal2d72b4ed762a09d18a89903d2344442f; ?>
<?php unset($__attributesOriginal2d72b4ed762a09d18a89903d2344442f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2d72b4ed762a09d18a89903d2344442f)): ?>
<?php $component = $__componentOriginal2d72b4ed762a09d18a89903d2344442f; ?>
<?php unset($__componentOriginal2d72b4ed762a09d18a89903d2344442f); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginala545c0dc845886385891e9173fb8e250 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala545c0dc845886385891e9173fb8e250 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-switch.input','data' => ['class' => 'ml-3 mr-0','id' => 'show-example-6','type' => 'checkbox']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-switch.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'ml-3 mr-0','id' => 'show-example-6','type' => 'checkbox']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala545c0dc845886385891e9173fb8e250)): ?>
<?php $attributes = $__attributesOriginala545c0dc845886385891e9173fb8e250; ?>
<?php unset($__attributesOriginala545c0dc845886385891e9173fb8e250); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala545c0dc845886385891e9173fb8e250)): ?>
<?php $component = $__componentOriginala545c0dc845886385891e9173fb8e250; ?>
<?php unset($__componentOriginala545c0dc845886385891e9173fb8e250); ?>
<?php endif; ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0e9b1708c541f0772f542e0482be43cc)): ?>
<?php $attributes = $__attributesOriginal0e9b1708c541f0772f542e0482be43cc; ?>
<?php unset($__attributesOriginal0e9b1708c541f0772f542e0482be43cc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0e9b1708c541f0772f542e0482be43cc)): ?>
<?php $component = $__componentOriginal0e9b1708c541f0772f542e0482be43cc; ?>
<?php unset($__componentOriginal0e9b1708c541f0772f542e0482be43cc); ?>
<?php endif; ?>
                </div>
                <div class="p-5">
                    <?php if (isset($component)) { $__componentOriginal104ae678e1fe7772577c7c9566b19e53 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal104ae678e1fe7772577c7c9566b19e53 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.preview.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.preview'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                        <?php if (isset($component)) { $__componentOriginal97420d662d07480141d58032fdeb00e4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal97420d662d07480141d58032fdeb00e4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.pie-chart.index','data' => ['height' => 'h-[400px]']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('pie-chart'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['height' => 'h-[400px]']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal97420d662d07480141d58032fdeb00e4)): ?>
<?php $attributes = $__attributesOriginal97420d662d07480141d58032fdeb00e4; ?>
<?php unset($__attributesOriginal97420d662d07480141d58032fdeb00e4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal97420d662d07480141d58032fdeb00e4)): ?>
<?php $component = $__componentOriginal97420d662d07480141d58032fdeb00e4; ?>
<?php unset($__componentOriginal97420d662d07480141d58032fdeb00e4); ?>
<?php endif; ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal104ae678e1fe7772577c7c9566b19e53)): ?>
<?php $attributes = $__attributesOriginal104ae678e1fe7772577c7c9566b19e53; ?>
<?php unset($__attributesOriginal104ae678e1fe7772577c7c9566b19e53); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal104ae678e1fe7772577c7c9566b19e53)): ?>
<?php $component = $__componentOriginal104ae678e1fe7772577c7c9566b19e53; ?>
<?php unset($__componentOriginal104ae678e1fe7772577c7c9566b19e53); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginalc50921fa19a58987fc5ef0780b4ea876 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc50921fa19a58987fc5ef0780b4ea876 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.source.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.source'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                        <?php if (isset($component)) { $__componentOriginalf84bfef2e4b7363f7e3ce2496a4a8820 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf84bfef2e4b7363f7e3ce2496a4a8820 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.highlight.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.highlight'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                            <?php if (isset($component)) { $__componentOriginal97420d662d07480141d58032fdeb00e4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal97420d662d07480141d58032fdeb00e4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.pie-chart.index','data' => ['height' => 'h-[400px]']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('pie-chart'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['height' => 'h-[400px]']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal97420d662d07480141d58032fdeb00e4)): ?>
<?php $attributes = $__attributesOriginal97420d662d07480141d58032fdeb00e4; ?>
<?php unset($__attributesOriginal97420d662d07480141d58032fdeb00e4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal97420d662d07480141d58032fdeb00e4)): ?>
<?php $component = $__componentOriginal97420d662d07480141d58032fdeb00e4; ?>
<?php unset($__componentOriginal97420d662d07480141d58032fdeb00e4); ?>
<?php endif; ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf84bfef2e4b7363f7e3ce2496a4a8820)): ?>
<?php $attributes = $__attributesOriginalf84bfef2e4b7363f7e3ce2496a4a8820; ?>
<?php unset($__attributesOriginalf84bfef2e4b7363f7e3ce2496a4a8820); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf84bfef2e4b7363f7e3ce2496a4a8820)): ?>
<?php $component = $__componentOriginalf84bfef2e4b7363f7e3ce2496a4a8820; ?>
<?php unset($__componentOriginalf84bfef2e4b7363f7e3ce2496a4a8820); ?>
<?php endif; ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc50921fa19a58987fc5ef0780b4ea876)): ?>
<?php $attributes = $__attributesOriginalc50921fa19a58987fc5ef0780b4ea876; ?>
<?php unset($__attributesOriginalc50921fa19a58987fc5ef0780b4ea876); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc50921fa19a58987fc5ef0780b4ea876)): ?>
<?php $component = $__componentOriginalc50921fa19a58987fc5ef0780b4ea876; ?>
<?php unset($__componentOriginalc50921fa19a58987fc5ef0780b4ea876); ?>
<?php endif; ?>
                </div>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1e00c22da64774fd0d873cb958c26686)): ?>
<?php $attributes = $__attributesOriginal1e00c22da64774fd0d873cb958c26686; ?>
<?php unset($__attributesOriginal1e00c22da64774fd0d873cb958c26686); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1e00c22da64774fd0d873cb958c26686)): ?>
<?php $component = $__componentOriginal1e00c22da64774fd0d873cb958c26686; ?>
<?php unset($__componentOriginal1e00c22da64774fd0d873cb958c26686); ?>
<?php endif; ?>
            <!-- END: Pie Chart -->
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../themes/' . $activeTheme . '/' . $activeLayout, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\smart-erp\resources\views/pages/chart.blade.php ENDPATH**/ ?>
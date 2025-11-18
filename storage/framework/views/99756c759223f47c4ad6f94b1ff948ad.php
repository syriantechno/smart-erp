<?php $__env->startSection('subhead'); ?>
    <title>Regular Form - Midone - Tailwind Admin Dashboard Template</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('subcontent'); ?>
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Regular Form</h2>
    </div>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 lg:col-span-6">
            <!-- BEGIN: Input -->
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
                    <h2 class="mr-auto text-base font-medium">Input</h2>
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
                        <div>
                            <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'regular-form-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'regular-form-1']); ?>Input Text <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $attributes = $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $component = $__componentOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'regular-form-1','type' => 'text','placeholder' => 'Input text']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'regular-form-1','type' => 'text','placeholder' => 'Input text']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
                        </div>
                        <div class="mt-3">
                            <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'regular-form-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'regular-form-2']); ?>Rounded <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $attributes = $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $component = $__componentOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'regular-form-2','type' => 'text','rounded' => true,'placeholder' => 'Rounded']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'regular-form-2','type' => 'text','rounded' => true,'placeholder' => 'Rounded']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
                        </div>
                        <div class="mt-3">
                            <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'regular-form-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'regular-form-3']); ?>With Help <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $attributes = $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $component = $__componentOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'regular-form-3','type' => 'text','placeholder' => 'With help']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'regular-form-3','type' => 'text','placeholder' => 'With help']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal1dd8ac463ddec31bf1a4b0eb4904d7de = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1dd8ac463ddec31bf1a4b0eb4904d7de = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-help.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-help'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                                Lorem Ipsum is simply dummy text of the printing and
                                typesetting industry.
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1dd8ac463ddec31bf1a4b0eb4904d7de)): ?>
<?php $attributes = $__attributesOriginal1dd8ac463ddec31bf1a4b0eb4904d7de; ?>
<?php unset($__attributesOriginal1dd8ac463ddec31bf1a4b0eb4904d7de); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1dd8ac463ddec31bf1a4b0eb4904d7de)): ?>
<?php $component = $__componentOriginal1dd8ac463ddec31bf1a4b0eb4904d7de; ?>
<?php unset($__componentOriginal1dd8ac463ddec31bf1a4b0eb4904d7de); ?>
<?php endif; ?>
                        </div>
                        <div class="mt-3">
                            <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'regular-form-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'regular-form-4']); ?>Password <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $attributes = $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $component = $__componentOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'regular-form-4','type' => 'password','placeholder' => 'Password']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'regular-form-4','type' => 'password','placeholder' => 'Password']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
                        </div>
                        <div class="mt-3">
                            <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'regular-form-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'regular-form-5']); ?>Disabled <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $attributes = $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $component = $__componentOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'regular-form-5','type' => 'text','placeholder' => 'Disabled','disabled' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'regular-form-5','type' => 'text','placeholder' => 'Disabled','disabled' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
                        </div>
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
                            <div>
                                <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'regular-form-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'regular-form-1']); ?>Input Text <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $attributes = $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $component = $__componentOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'regular-form-1','type' => 'text','placeholder' => 'Input text']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'regular-form-1','type' => 'text','placeholder' => 'Input text']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
                            </div>
                            <div class="mt-3">
                                <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'regular-form-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'regular-form-2']); ?>Rounded <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $attributes = $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $component = $__componentOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'regular-form-2','type' => 'text','rounded' => true,'placeholder' => 'Rounded']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'regular-form-2','type' => 'text','rounded' => true,'placeholder' => 'Rounded']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
                            </div>
                            <div class="mt-3">
                                <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'regular-form-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'regular-form-3']); ?>With Help <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $attributes = $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $component = $__componentOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'regular-form-3','type' => 'text','placeholder' => 'With help']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'regular-form-3','type' => 'text','placeholder' => 'With help']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginal1dd8ac463ddec31bf1a4b0eb4904d7de = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1dd8ac463ddec31bf1a4b0eb4904d7de = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-help.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-help'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                                    Lorem Ipsum is simply dummy text of the printing and
                                    typesetting industry.
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1dd8ac463ddec31bf1a4b0eb4904d7de)): ?>
<?php $attributes = $__attributesOriginal1dd8ac463ddec31bf1a4b0eb4904d7de; ?>
<?php unset($__attributesOriginal1dd8ac463ddec31bf1a4b0eb4904d7de); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1dd8ac463ddec31bf1a4b0eb4904d7de)): ?>
<?php $component = $__componentOriginal1dd8ac463ddec31bf1a4b0eb4904d7de; ?>
<?php unset($__componentOriginal1dd8ac463ddec31bf1a4b0eb4904d7de); ?>
<?php endif; ?>
                            </div>
                            <div class="mt-3">
                                <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'regular-form-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'regular-form-4']); ?>Password <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $attributes = $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $component = $__componentOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'regular-form-4','type' => 'password','placeholder' => 'Password']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'regular-form-4','type' => 'password','placeholder' => 'Password']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
                            </div>
                            <div class="mt-3">
                                <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'regular-form-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'regular-form-5']); ?>Disabled <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $attributes = $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $component = $__componentOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'regular-form-5','type' => 'text','placeholder' => 'Disabled','disabled' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'regular-form-5','type' => 'text','placeholder' => 'Disabled','disabled' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
                            </div>
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
            <!-- END: Input -->
            <!-- BEGIN: Input Sizing -->
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
                        Input Sizing
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
                        <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['formInputSize' => 'lg','type' => 'text','ariaLabel' => '.form-control-lg example','placeholder' => '.form-control-lg']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['formInputSize' => 'lg','type' => 'text','aria-label' => '.form-control-lg example','placeholder' => '.form-control-lg']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['class' => 'mt-2','type' => 'text','ariaLabel' => 'default input example','placeholder' => 'Default input']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2','type' => 'text','aria-label' => 'default input example','placeholder' => 'Default input']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['class' => 'mt-2','formInputSize' => 'sm','type' => 'text','ariaLabel' => '.form-control-sm example','placeholder' => '.form-control-sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2','formInputSize' => 'sm','type' => 'text','aria-label' => '.form-control-sm example','placeholder' => '.form-control-sm']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
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
                            <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['formInputSize' => 'lg','type' => 'text','ariaLabel' => '.form-control-lg example','placeholder' => '.form-control-lg']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['formInputSize' => 'lg','type' => 'text','aria-label' => '.form-control-lg example','placeholder' => '.form-control-lg']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['class' => 'mt-2','type' => 'text','ariaLabel' => 'default input example','placeholder' => 'Default input']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2','type' => 'text','aria-label' => 'default input example','placeholder' => 'Default input']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['class' => 'mt-2','formInputSize' => 'sm','type' => 'text','ariaLabel' => '.form-control-sm example','placeholder' => '.form-control-sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2','formInputSize' => 'sm','type' => 'text','aria-label' => '.form-control-sm example','placeholder' => '.form-control-sm']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
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
            <!-- END: Input Sizing -->
            <!-- BEGIN: Input Groups -->
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
                        Input Groups
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
                        <?php if (isset($component)) { $__componentOriginal5330edf0c5c7e6d23e63fc185f67ce9e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5330edf0c5c7e6d23e63fc185f67ce9e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.input-group.index','data' => ['inputGroup' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.input-group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['inputGroup' => true]); ?>
                            <?php if (isset($component)) { $__componentOriginal5a639262d688b9ee3921c254c1a0d6de = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5a639262d688b9ee3921c254c1a0d6de = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.input-group.text','data' => ['id' => 'input-group-email']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.input-group.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'input-group-email']); ?>
                                @
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5a639262d688b9ee3921c254c1a0d6de)): ?>
<?php $attributes = $__attributesOriginal5a639262d688b9ee3921c254c1a0d6de; ?>
<?php unset($__attributesOriginal5a639262d688b9ee3921c254c1a0d6de); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5a639262d688b9ee3921c254c1a0d6de)): ?>
<?php $component = $__componentOriginal5a639262d688b9ee3921c254c1a0d6de; ?>
<?php unset($__componentOriginal5a639262d688b9ee3921c254c1a0d6de); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['type' => 'text','ariaLabel' => 'Email','ariaDescribedby' => 'input-group-email','placeholder' => 'Email']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'text','aria-label' => 'Email','aria-describedby' => 'input-group-email','placeholder' => 'Email']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5330edf0c5c7e6d23e63fc185f67ce9e)): ?>
<?php $attributes = $__attributesOriginal5330edf0c5c7e6d23e63fc185f67ce9e; ?>
<?php unset($__attributesOriginal5330edf0c5c7e6d23e63fc185f67ce9e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5330edf0c5c7e6d23e63fc185f67ce9e)): ?>
<?php $component = $__componentOriginal5330edf0c5c7e6d23e63fc185f67ce9e; ?>
<?php unset($__componentOriginal5330edf0c5c7e6d23e63fc185f67ce9e); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5330edf0c5c7e6d23e63fc185f67ce9e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5330edf0c5c7e6d23e63fc185f67ce9e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.input-group.index','data' => ['class' => 'mt-2','inputGroup' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.input-group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2','inputGroup' => true]); ?>
                            <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['type' => 'text','ariaLabel' => 'Price','ariaDescribedby' => 'input-group-price','placeholder' => 'Price']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'text','aria-label' => 'Price','aria-describedby' => 'input-group-price','placeholder' => 'Price']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal5a639262d688b9ee3921c254c1a0d6de = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5a639262d688b9ee3921c254c1a0d6de = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.input-group.text','data' => ['id' => 'input-group-price']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.input-group.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'input-group-price']); ?>
                                .00
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5a639262d688b9ee3921c254c1a0d6de)): ?>
<?php $attributes = $__attributesOriginal5a639262d688b9ee3921c254c1a0d6de; ?>
<?php unset($__attributesOriginal5a639262d688b9ee3921c254c1a0d6de); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5a639262d688b9ee3921c254c1a0d6de)): ?>
<?php $component = $__componentOriginal5a639262d688b9ee3921c254c1a0d6de; ?>
<?php unset($__componentOriginal5a639262d688b9ee3921c254c1a0d6de); ?>
<?php endif; ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5330edf0c5c7e6d23e63fc185f67ce9e)): ?>
<?php $attributes = $__attributesOriginal5330edf0c5c7e6d23e63fc185f67ce9e; ?>
<?php unset($__attributesOriginal5330edf0c5c7e6d23e63fc185f67ce9e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5330edf0c5c7e6d23e63fc185f67ce9e)): ?>
<?php $component = $__componentOriginal5330edf0c5c7e6d23e63fc185f67ce9e; ?>
<?php unset($__componentOriginal5330edf0c5c7e6d23e63fc185f67ce9e); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5330edf0c5c7e6d23e63fc185f67ce9e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5330edf0c5c7e6d23e63fc185f67ce9e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.input-group.index','data' => ['class' => 'mt-2','inputGroup' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.input-group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2','inputGroup' => true]); ?>
                            <?php if (isset($component)) { $__componentOriginal5a639262d688b9ee3921c254c1a0d6de = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5a639262d688b9ee3921c254c1a0d6de = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.input-group.text','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.input-group.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>@ <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5a639262d688b9ee3921c254c1a0d6de)): ?>
<?php $attributes = $__attributesOriginal5a639262d688b9ee3921c254c1a0d6de; ?>
<?php unset($__attributesOriginal5a639262d688b9ee3921c254c1a0d6de); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5a639262d688b9ee3921c254c1a0d6de)): ?>
<?php $component = $__componentOriginal5a639262d688b9ee3921c254c1a0d6de; ?>
<?php unset($__componentOriginal5a639262d688b9ee3921c254c1a0d6de); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['type' => 'text','ariaLabel' => 'Amount (to the nearest dollar)','placeholder' => 'Price']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'text','aria-label' => 'Amount (to the nearest dollar)','placeholder' => 'Price']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal5a639262d688b9ee3921c254c1a0d6de = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5a639262d688b9ee3921c254c1a0d6de = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.input-group.text','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.input-group.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>.00 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5a639262d688b9ee3921c254c1a0d6de)): ?>
<?php $attributes = $__attributesOriginal5a639262d688b9ee3921c254c1a0d6de; ?>
<?php unset($__attributesOriginal5a639262d688b9ee3921c254c1a0d6de); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5a639262d688b9ee3921c254c1a0d6de)): ?>
<?php $component = $__componentOriginal5a639262d688b9ee3921c254c1a0d6de; ?>
<?php unset($__componentOriginal5a639262d688b9ee3921c254c1a0d6de); ?>
<?php endif; ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5330edf0c5c7e6d23e63fc185f67ce9e)): ?>
<?php $attributes = $__attributesOriginal5330edf0c5c7e6d23e63fc185f67ce9e; ?>
<?php unset($__attributesOriginal5330edf0c5c7e6d23e63fc185f67ce9e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5330edf0c5c7e6d23e63fc185f67ce9e)): ?>
<?php $component = $__componentOriginal5330edf0c5c7e6d23e63fc185f67ce9e; ?>
<?php unset($__componentOriginal5330edf0c5c7e6d23e63fc185f67ce9e); ?>
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
                            <?php if (isset($component)) { $__componentOriginal5330edf0c5c7e6d23e63fc185f67ce9e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5330edf0c5c7e6d23e63fc185f67ce9e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.input-group.index','data' => ['inputGroup' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.input-group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['inputGroup' => true]); ?>
                                <?php if (isset($component)) { $__componentOriginal5a639262d688b9ee3921c254c1a0d6de = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5a639262d688b9ee3921c254c1a0d6de = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.input-group.text','data' => ['id' => 'input-group-email']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.input-group.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'input-group-email']); ?>
                                    @
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5a639262d688b9ee3921c254c1a0d6de)): ?>
<?php $attributes = $__attributesOriginal5a639262d688b9ee3921c254c1a0d6de; ?>
<?php unset($__attributesOriginal5a639262d688b9ee3921c254c1a0d6de); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5a639262d688b9ee3921c254c1a0d6de)): ?>
<?php $component = $__componentOriginal5a639262d688b9ee3921c254c1a0d6de; ?>
<?php unset($__componentOriginal5a639262d688b9ee3921c254c1a0d6de); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['type' => 'text','ariaLabel' => 'Email','ariaDescribedby' => 'input-group-email','placeholder' => 'Email']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'text','aria-label' => 'Email','aria-describedby' => 'input-group-email','placeholder' => 'Email']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5330edf0c5c7e6d23e63fc185f67ce9e)): ?>
<?php $attributes = $__attributesOriginal5330edf0c5c7e6d23e63fc185f67ce9e; ?>
<?php unset($__attributesOriginal5330edf0c5c7e6d23e63fc185f67ce9e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5330edf0c5c7e6d23e63fc185f67ce9e)): ?>
<?php $component = $__componentOriginal5330edf0c5c7e6d23e63fc185f67ce9e; ?>
<?php unset($__componentOriginal5330edf0c5c7e6d23e63fc185f67ce9e); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal5330edf0c5c7e6d23e63fc185f67ce9e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5330edf0c5c7e6d23e63fc185f67ce9e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.input-group.index','data' => ['class' => 'mt-2','inputGroup' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.input-group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2','inputGroup' => true]); ?>
                                <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['type' => 'text','ariaLabel' => 'Price','ariaDescribedby' => 'input-group-price','placeholder' => 'Price']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'text','aria-label' => 'Price','aria-describedby' => 'input-group-price','placeholder' => 'Price']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginal5a639262d688b9ee3921c254c1a0d6de = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5a639262d688b9ee3921c254c1a0d6de = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.input-group.text','data' => ['id' => 'input-group-price']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.input-group.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'input-group-price']); ?>
                                    .00
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5a639262d688b9ee3921c254c1a0d6de)): ?>
<?php $attributes = $__attributesOriginal5a639262d688b9ee3921c254c1a0d6de; ?>
<?php unset($__attributesOriginal5a639262d688b9ee3921c254c1a0d6de); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5a639262d688b9ee3921c254c1a0d6de)): ?>
<?php $component = $__componentOriginal5a639262d688b9ee3921c254c1a0d6de; ?>
<?php unset($__componentOriginal5a639262d688b9ee3921c254c1a0d6de); ?>
<?php endif; ?>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5330edf0c5c7e6d23e63fc185f67ce9e)): ?>
<?php $attributes = $__attributesOriginal5330edf0c5c7e6d23e63fc185f67ce9e; ?>
<?php unset($__attributesOriginal5330edf0c5c7e6d23e63fc185f67ce9e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5330edf0c5c7e6d23e63fc185f67ce9e)): ?>
<?php $component = $__componentOriginal5330edf0c5c7e6d23e63fc185f67ce9e; ?>
<?php unset($__componentOriginal5330edf0c5c7e6d23e63fc185f67ce9e); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal5330edf0c5c7e6d23e63fc185f67ce9e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5330edf0c5c7e6d23e63fc185f67ce9e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.input-group.index','data' => ['class' => 'mt-2','inputGroup' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.input-group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2','inputGroup' => true]); ?>
                                <?php if (isset($component)) { $__componentOriginal5a639262d688b9ee3921c254c1a0d6de = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5a639262d688b9ee3921c254c1a0d6de = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.input-group.text','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.input-group.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>@ <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5a639262d688b9ee3921c254c1a0d6de)): ?>
<?php $attributes = $__attributesOriginal5a639262d688b9ee3921c254c1a0d6de; ?>
<?php unset($__attributesOriginal5a639262d688b9ee3921c254c1a0d6de); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5a639262d688b9ee3921c254c1a0d6de)): ?>
<?php $component = $__componentOriginal5a639262d688b9ee3921c254c1a0d6de; ?>
<?php unset($__componentOriginal5a639262d688b9ee3921c254c1a0d6de); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['type' => 'text','ariaLabel' => 'Amount (to the nearest dollar)','placeholder' => 'Price']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'text','aria-label' => 'Amount (to the nearest dollar)','placeholder' => 'Price']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginal5a639262d688b9ee3921c254c1a0d6de = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5a639262d688b9ee3921c254c1a0d6de = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.input-group.text','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.input-group.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>.00 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5a639262d688b9ee3921c254c1a0d6de)): ?>
<?php $attributes = $__attributesOriginal5a639262d688b9ee3921c254c1a0d6de; ?>
<?php unset($__attributesOriginal5a639262d688b9ee3921c254c1a0d6de); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5a639262d688b9ee3921c254c1a0d6de)): ?>
<?php $component = $__componentOriginal5a639262d688b9ee3921c254c1a0d6de; ?>
<?php unset($__componentOriginal5a639262d688b9ee3921c254c1a0d6de); ?>
<?php endif; ?>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5330edf0c5c7e6d23e63fc185f67ce9e)): ?>
<?php $attributes = $__attributesOriginal5330edf0c5c7e6d23e63fc185f67ce9e; ?>
<?php unset($__attributesOriginal5330edf0c5c7e6d23e63fc185f67ce9e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5330edf0c5c7e6d23e63fc185f67ce9e)): ?>
<?php $component = $__componentOriginal5330edf0c5c7e6d23e63fc185f67ce9e; ?>
<?php unset($__componentOriginal5330edf0c5c7e6d23e63fc185f67ce9e); ?>
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
            <!-- END: Input Groups -->
            <!-- BEGIN: Input State -->
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
                    <h2 class="mr-auto text-base font-medium">Input State</h2>
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
                        <div>
                            <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'input-state-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'input-state-1']); ?>
                                Input Success
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $attributes = $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $component = $__componentOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['class' => 'border-success','id' => 'input-state-1','type' => 'text','placeholder' => 'Input text']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'border-success','id' => 'input-state-1','type' => 'text','placeholder' => 'Input text']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
                            <div class="mt-3 grid h-1 w-full grid-cols-12 gap-4">
                                <div class="col-span-3 h-full rounded bg-success"></div>
                                <div class="col-span-3 h-full rounded bg-success"></div>
                                <div class="col-span-3 h-full rounded bg-success"></div>
                                <div class="col-span-3 h-full rounded bg-slate-100 dark:bg-darkmode-800"></div>
                            </div>
                            <div class="mt-2 text-success">Strong password</div>
                        </div>
                        <div class="mt-3">
                            <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'input-state-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'input-state-2']); ?>
                                Input Warning
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $attributes = $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $component = $__componentOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['class' => 'border-warning','id' => 'input-state-2','type' => 'text','placeholder' => 'Input text']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'border-warning','id' => 'input-state-2','type' => 'text','placeholder' => 'Input text']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
                            <div class="mt-2 text-warning">
                                Attempting to reconnect to server...
                            </div>
                        </div>
                        <div class="mt-3">
                            <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'input-state-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'input-state-3']); ?>Input Error <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $attributes = $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $component = $__componentOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['class' => 'border-danger','id' => 'input-state-3','type' => 'text','placeholder' => 'Input text']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'border-danger','id' => 'input-state-3','type' => 'text','placeholder' => 'Input text']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
                            <div class="mt-2 text-danger">
                                This field is required
                            </div>
                        </div>
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
                            <div>
                                <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'input-state-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'input-state-1']); ?>
                                    Input Success
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $attributes = $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $component = $__componentOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['class' => 'border-success','id' => 'input-state-1','type' => 'text','placeholder' => 'Input text']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'border-success','id' => 'input-state-1','type' => 'text','placeholder' => 'Input text']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
                                <div class="mt-3 grid h-1 w-full grid-cols-12 gap-4">
                                    <div class="col-span-3 h-full rounded bg-success"></div>
                                    <div class="col-span-3 h-full rounded bg-success"></div>
                                    <div class="col-span-3 h-full rounded bg-success"></div>
                                    <div class="col-span-3 h-full rounded bg-slate-100 dark:bg-darkmode-800"></div>
                                </div>
                                <div class="mt-2 text-success">Strong password</div>
                            </div>
                            <div class="mt-3">
                                <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'input-state-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'input-state-2']); ?>
                                    Input Warning
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $attributes = $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $component = $__componentOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['class' => 'border-warning','id' => 'input-state-2','type' => 'text','placeholder' => 'Input text']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'border-warning','id' => 'input-state-2','type' => 'text','placeholder' => 'Input text']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
                                <div class="mt-2 text-warning">
                                    Attempting to reconnect to server...
                                </div>
                            </div>
                            <div class="mt-3">
                                <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'input-state-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'input-state-3']); ?>Input Error <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $attributes = $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $component = $__componentOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['class' => 'border-danger','id' => 'input-state-3','type' => 'text','placeholder' => 'Input text']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'border-danger','id' => 'input-state-3','type' => 'text','placeholder' => 'Input text']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
                                <div class="mt-2 text-danger">
                                    This field is required
                                </div>
                            </div>
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
            <!-- END: Input State -->
            <!-- BEGIN: Select Options -->
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
                        Select Options
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
                        <div class="flex flex-col items-center sm:flex-row">
                            <?php if (isset($component)) { $__componentOriginal1c0beb3cd2271cd34645d22f15db5e3a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1c0beb3cd2271cd34645d22f15db5e3a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-select.index','data' => ['class' => 'sm:mr-2 sm:mt-2','formSelectSize' => 'lg','ariaLabel' => '.form-select-lg example']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'sm:mr-2 sm:mt-2','formSelectSize' => 'lg','aria-label' => '.form-select-lg example']); ?>
                                <option>Chris Evans</option>
                                <option>Liam Neeson</option>
                                <option>Daniel Craig</option>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1c0beb3cd2271cd34645d22f15db5e3a)): ?>
<?php $attributes = $__attributesOriginal1c0beb3cd2271cd34645d22f15db5e3a; ?>
<?php unset($__attributesOriginal1c0beb3cd2271cd34645d22f15db5e3a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1c0beb3cd2271cd34645d22f15db5e3a)): ?>
<?php $component = $__componentOriginal1c0beb3cd2271cd34645d22f15db5e3a; ?>
<?php unset($__componentOriginal1c0beb3cd2271cd34645d22f15db5e3a); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal1c0beb3cd2271cd34645d22f15db5e3a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1c0beb3cd2271cd34645d22f15db5e3a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-select.index','data' => ['class' => 'mt-2 sm:mr-2','ariaLabel' => 'Default select example']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2 sm:mr-2','aria-label' => 'Default select example']); ?>
                                <option>Chris Evans</option>
                                <option>Liam Neeson</option>
                                <option>Daniel Craig</option>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1c0beb3cd2271cd34645d22f15db5e3a)): ?>
<?php $attributes = $__attributesOriginal1c0beb3cd2271cd34645d22f15db5e3a; ?>
<?php unset($__attributesOriginal1c0beb3cd2271cd34645d22f15db5e3a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1c0beb3cd2271cd34645d22f15db5e3a)): ?>
<?php $component = $__componentOriginal1c0beb3cd2271cd34645d22f15db5e3a; ?>
<?php unset($__componentOriginal1c0beb3cd2271cd34645d22f15db5e3a); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal1c0beb3cd2271cd34645d22f15db5e3a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1c0beb3cd2271cd34645d22f15db5e3a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-select.index','data' => ['class' => 'mt-2','formSelectSize' => 'sm','ariaLabel' => '.form-select-sm example']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2','formSelectSize' => 'sm','aria-label' => '.form-select-sm example']); ?>
                                <option>Chris Evans</option>
                                <option>Liam Neeson</option>
                                <option>Daniel Craig</option>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1c0beb3cd2271cd34645d22f15db5e3a)): ?>
<?php $attributes = $__attributesOriginal1c0beb3cd2271cd34645d22f15db5e3a; ?>
<?php unset($__attributesOriginal1c0beb3cd2271cd34645d22f15db5e3a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1c0beb3cd2271cd34645d22f15db5e3a)): ?>
<?php $component = $__componentOriginal1c0beb3cd2271cd34645d22f15db5e3a; ?>
<?php unset($__componentOriginal1c0beb3cd2271cd34645d22f15db5e3a); ?>
<?php endif; ?>
                        </div>
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
                            <div class="flex flex-col items-center sm:flex-row">
                                <?php if (isset($component)) { $__componentOriginal1c0beb3cd2271cd34645d22f15db5e3a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1c0beb3cd2271cd34645d22f15db5e3a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-select.index','data' => ['class' => 'sm:mr-2 sm:mt-2','formSelectSize' => 'lg','ariaLabel' => '.form-select-lg example']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'sm:mr-2 sm:mt-2','formSelectSize' => 'lg','aria-label' => '.form-select-lg example']); ?>
                                    <option>Chris Evans</option>
                                    <option>Liam Neeson</option>
                                    <option>Daniel Craig</option>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1c0beb3cd2271cd34645d22f15db5e3a)): ?>
<?php $attributes = $__attributesOriginal1c0beb3cd2271cd34645d22f15db5e3a; ?>
<?php unset($__attributesOriginal1c0beb3cd2271cd34645d22f15db5e3a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1c0beb3cd2271cd34645d22f15db5e3a)): ?>
<?php $component = $__componentOriginal1c0beb3cd2271cd34645d22f15db5e3a; ?>
<?php unset($__componentOriginal1c0beb3cd2271cd34645d22f15db5e3a); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginal1c0beb3cd2271cd34645d22f15db5e3a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1c0beb3cd2271cd34645d22f15db5e3a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-select.index','data' => ['class' => 'mt-2 sm:mr-2','ariaLabel' => 'Default select example']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2 sm:mr-2','aria-label' => 'Default select example']); ?>
                                    <option>Chris Evans</option>
                                    <option>Liam Neeson</option>
                                    <option>Daniel Craig</option>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1c0beb3cd2271cd34645d22f15db5e3a)): ?>
<?php $attributes = $__attributesOriginal1c0beb3cd2271cd34645d22f15db5e3a; ?>
<?php unset($__attributesOriginal1c0beb3cd2271cd34645d22f15db5e3a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1c0beb3cd2271cd34645d22f15db5e3a)): ?>
<?php $component = $__componentOriginal1c0beb3cd2271cd34645d22f15db5e3a; ?>
<?php unset($__componentOriginal1c0beb3cd2271cd34645d22f15db5e3a); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginal1c0beb3cd2271cd34645d22f15db5e3a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1c0beb3cd2271cd34645d22f15db5e3a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-select.index','data' => ['class' => 'mt-2','formSelectSize' => 'sm','ariaLabel' => '.form-select-sm example']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2','formSelectSize' => 'sm','aria-label' => '.form-select-sm example']); ?>
                                    <option>Chris Evans</option>
                                    <option>Liam Neeson</option>
                                    <option>Daniel Craig</option>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1c0beb3cd2271cd34645d22f15db5e3a)): ?>
<?php $attributes = $__attributesOriginal1c0beb3cd2271cd34645d22f15db5e3a; ?>
<?php unset($__attributesOriginal1c0beb3cd2271cd34645d22f15db5e3a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1c0beb3cd2271cd34645d22f15db5e3a)): ?>
<?php $component = $__componentOriginal1c0beb3cd2271cd34645d22f15db5e3a; ?>
<?php unset($__componentOriginal1c0beb3cd2271cd34645d22f15db5e3a); ?>
<?php endif; ?>
                            </div>
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
            <!-- END: Select Options -->
        </div>
        <div class="intro-y col-span-12 lg:col-span-6">
            <!-- BEGIN: Vertical Form -->
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
                        Vertical Form
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
                        <div>
                            <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'vertical-form-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'vertical-form-1']); ?>Email <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $attributes = $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $component = $__componentOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'vertical-form-1','type' => 'text','placeholder' => 'example@gmail.com']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'vertical-form-1','type' => 'text','placeholder' => 'example@gmail.com']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
                        </div>
                        <div class="mt-3">
                            <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'vertical-form-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'vertical-form-2']); ?>Password <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $attributes = $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $component = $__componentOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'vertical-form-2','type' => 'text','placeholder' => 'secret']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'vertical-form-2','type' => 'text','placeholder' => 'secret']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
                        </div>
                        <?php if (isset($component)) { $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.index','data' => ['class' => 'mt-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-5']); ?>
                            <?php if (isset($component)) { $__componentOriginal45dc70583f76c3df9e7383efd567b5fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.input','data' => ['id' => 'vertical-form-3','type' => 'checkbox','value' => '']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'vertical-form-3','type' => 'checkbox','value' => '']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $attributes = $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $component = $__componentOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal8218ba5fba45bffb9ccf737358e222ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.label','data' => ['for' => 'vertical-form-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'vertical-form-3']); ?>
                                Remember me
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $attributes = $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $component = $__componentOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $attributes = $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $component = $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginale00eb601fbe667f0da582732d70c41c5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale00eb601fbe667f0da582732d70c41c5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.button.index','data' => ['class' => 'mt-5','variant' => 'primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-5','variant' => 'primary']); ?>
                            Login
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale00eb601fbe667f0da582732d70c41c5)): ?>
<?php $attributes = $__attributesOriginale00eb601fbe667f0da582732d70c41c5; ?>
<?php unset($__attributesOriginale00eb601fbe667f0da582732d70c41c5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale00eb601fbe667f0da582732d70c41c5)): ?>
<?php $component = $__componentOriginale00eb601fbe667f0da582732d70c41c5; ?>
<?php unset($__componentOriginale00eb601fbe667f0da582732d70c41c5); ?>
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
                            <div>
                                <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'vertical-form-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'vertical-form-1']); ?>Email <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $attributes = $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $component = $__componentOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'vertical-form-1','type' => 'text','placeholder' => 'example@gmail.com']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'vertical-form-1','type' => 'text','placeholder' => 'example@gmail.com']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
                            </div>
                            <div class="mt-3">
                                <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'vertical-form-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'vertical-form-2']); ?>Password <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $attributes = $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $component = $__componentOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'vertical-form-2','type' => 'text','placeholder' => 'secret']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'vertical-form-2','type' => 'text','placeholder' => 'secret']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
                            </div>
                            <?php if (isset($component)) { $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.index','data' => ['class' => 'mt-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-5']); ?>
                                <?php if (isset($component)) { $__componentOriginal45dc70583f76c3df9e7383efd567b5fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.input','data' => ['id' => 'vertical-form-3','type' => 'checkbox','value' => '']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'vertical-form-3','type' => 'checkbox','value' => '']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $attributes = $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $component = $__componentOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginal8218ba5fba45bffb9ccf737358e222ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.label','data' => ['for' => 'vertical-form-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'vertical-form-3']); ?>
                                    Remember me
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $attributes = $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $component = $__componentOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $attributes = $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $component = $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginale00eb601fbe667f0da582732d70c41c5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale00eb601fbe667f0da582732d70c41c5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.button.index','data' => ['class' => 'mt-5','variant' => 'primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-5','variant' => 'primary']); ?>
                                Login
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale00eb601fbe667f0da582732d70c41c5)): ?>
<?php $attributes = $__attributesOriginale00eb601fbe667f0da582732d70c41c5; ?>
<?php unset($__attributesOriginale00eb601fbe667f0da582732d70c41c5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale00eb601fbe667f0da582732d70c41c5)): ?>
<?php $component = $__componentOriginale00eb601fbe667f0da582732d70c41c5; ?>
<?php unset($__componentOriginale00eb601fbe667f0da582732d70c41c5); ?>
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
            <!-- END: Vertical Form -->
            <!-- BEGIN: Horizontal Form -->
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
                        Horizontal Form
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-switch.label','data' => ['for' => 'show-example-7']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-switch.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'show-example-7']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-switch.input','data' => ['class' => 'ml-3 mr-0','id' => 'show-example-7','type' => 'checkbox']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-switch.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'ml-3 mr-0','id' => 'show-example-7','type' => 'checkbox']); ?>
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
                        <?php if (isset($component)) { $__componentOriginal988054647a7af8d7b6d7518342f136c5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal988054647a7af8d7b6d7518342f136c5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-inline.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-inline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                            <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['class' => 'sm:w-20','for' => 'horizontal-form-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'sm:w-20','for' => 'horizontal-form-1']); ?>
                                Email
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $attributes = $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $component = $__componentOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'horizontal-form-1','type' => 'text','placeholder' => 'example@gmail.com']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'horizontal-form-1','type' => 'text','placeholder' => 'example@gmail.com']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal988054647a7af8d7b6d7518342f136c5)): ?>
<?php $attributes = $__attributesOriginal988054647a7af8d7b6d7518342f136c5; ?>
<?php unset($__attributesOriginal988054647a7af8d7b6d7518342f136c5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal988054647a7af8d7b6d7518342f136c5)): ?>
<?php $component = $__componentOriginal988054647a7af8d7b6d7518342f136c5; ?>
<?php unset($__componentOriginal988054647a7af8d7b6d7518342f136c5); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal988054647a7af8d7b6d7518342f136c5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal988054647a7af8d7b6d7518342f136c5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-inline.index','data' => ['class' => 'mt-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-inline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-5']); ?>
                            <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['class' => 'sm:w-20','for' => 'horizontal-form-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'sm:w-20','for' => 'horizontal-form-2']); ?>
                                Password
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $attributes = $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $component = $__componentOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'horizontal-form-2','type' => 'password','placeholder' => 'secret']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'horizontal-form-2','type' => 'password','placeholder' => 'secret']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal988054647a7af8d7b6d7518342f136c5)): ?>
<?php $attributes = $__attributesOriginal988054647a7af8d7b6d7518342f136c5; ?>
<?php unset($__attributesOriginal988054647a7af8d7b6d7518342f136c5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal988054647a7af8d7b6d7518342f136c5)): ?>
<?php $component = $__componentOriginal988054647a7af8d7b6d7518342f136c5; ?>
<?php unset($__componentOriginal988054647a7af8d7b6d7518342f136c5); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.index','data' => ['class' => 'mt-5 sm:ml-20 sm:pl-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-5 sm:ml-20 sm:pl-5']); ?>
                            <?php if (isset($component)) { $__componentOriginal45dc70583f76c3df9e7383efd567b5fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.input','data' => ['id' => 'horizontal-form-3','type' => 'checkbox','value' => '']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'horizontal-form-3','type' => 'checkbox','value' => '']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $attributes = $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $component = $__componentOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal8218ba5fba45bffb9ccf737358e222ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.label','data' => ['for' => 'horizontal-form-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'horizontal-form-3']); ?>
                                Remember me
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $attributes = $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $component = $__componentOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $attributes = $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $component = $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
                        <div class="mt-5 sm:ml-20 sm:pl-5">
                            <?php if (isset($component)) { $__componentOriginale00eb601fbe667f0da582732d70c41c5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale00eb601fbe667f0da582732d70c41c5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.button.index','data' => ['variant' => 'primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'primary']); ?>Login <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale00eb601fbe667f0da582732d70c41c5)): ?>
<?php $attributes = $__attributesOriginale00eb601fbe667f0da582732d70c41c5; ?>
<?php unset($__attributesOriginale00eb601fbe667f0da582732d70c41c5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale00eb601fbe667f0da582732d70c41c5)): ?>
<?php $component = $__componentOriginale00eb601fbe667f0da582732d70c41c5; ?>
<?php unset($__componentOriginale00eb601fbe667f0da582732d70c41c5); ?>
<?php endif; ?>
                        </div>
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
                            <?php if (isset($component)) { $__componentOriginal988054647a7af8d7b6d7518342f136c5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal988054647a7af8d7b6d7518342f136c5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-inline.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-inline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                                <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['class' => 'sm:w-20','for' => 'horizontal-form-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'sm:w-20','for' => 'horizontal-form-1']); ?>
                                    Email
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $attributes = $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $component = $__componentOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'horizontal-form-1','type' => 'text','placeholder' => 'example@gmail.com']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'horizontal-form-1','type' => 'text','placeholder' => 'example@gmail.com']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal988054647a7af8d7b6d7518342f136c5)): ?>
<?php $attributes = $__attributesOriginal988054647a7af8d7b6d7518342f136c5; ?>
<?php unset($__attributesOriginal988054647a7af8d7b6d7518342f136c5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal988054647a7af8d7b6d7518342f136c5)): ?>
<?php $component = $__componentOriginal988054647a7af8d7b6d7518342f136c5; ?>
<?php unset($__componentOriginal988054647a7af8d7b6d7518342f136c5); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal988054647a7af8d7b6d7518342f136c5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal988054647a7af8d7b6d7518342f136c5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-inline.index','data' => ['class' => 'mt-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-inline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-5']); ?>
                                <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['class' => 'sm:w-20','for' => 'horizontal-form-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'sm:w-20','for' => 'horizontal-form-2']); ?>
                                    Password
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $attributes = $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $component = $__componentOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'horizontal-form-2','type' => 'password','placeholder' => 'secret']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'horizontal-form-2','type' => 'password','placeholder' => 'secret']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal988054647a7af8d7b6d7518342f136c5)): ?>
<?php $attributes = $__attributesOriginal988054647a7af8d7b6d7518342f136c5; ?>
<?php unset($__attributesOriginal988054647a7af8d7b6d7518342f136c5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal988054647a7af8d7b6d7518342f136c5)): ?>
<?php $component = $__componentOriginal988054647a7af8d7b6d7518342f136c5; ?>
<?php unset($__componentOriginal988054647a7af8d7b6d7518342f136c5); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.index','data' => ['class' => 'mt-5 sm:ml-20 sm:pl-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-5 sm:ml-20 sm:pl-5']); ?>
                                <?php if (isset($component)) { $__componentOriginal45dc70583f76c3df9e7383efd567b5fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.input','data' => ['id' => 'horizontal-form-3','type' => 'checkbox','value' => '']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'horizontal-form-3','type' => 'checkbox','value' => '']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $attributes = $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $component = $__componentOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginal8218ba5fba45bffb9ccf737358e222ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.label','data' => ['for' => 'horizontal-form-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'horizontal-form-3']); ?>
                                    Remember me
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $attributes = $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $component = $__componentOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $attributes = $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $component = $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
                            <div class="mt-5 sm:ml-20 sm:pl-5">
                                <?php if (isset($component)) { $__componentOriginale00eb601fbe667f0da582732d70c41c5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale00eb601fbe667f0da582732d70c41c5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.button.index','data' => ['variant' => 'primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'primary']); ?>Login <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale00eb601fbe667f0da582732d70c41c5)): ?>
<?php $attributes = $__attributesOriginale00eb601fbe667f0da582732d70c41c5; ?>
<?php unset($__attributesOriginale00eb601fbe667f0da582732d70c41c5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale00eb601fbe667f0da582732d70c41c5)): ?>
<?php $component = $__componentOriginale00eb601fbe667f0da582732d70c41c5; ?>
<?php unset($__componentOriginale00eb601fbe667f0da582732d70c41c5); ?>
<?php endif; ?>
                            </div>
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
            <!-- END: Horizontal Form -->
            <!-- BEGIN: Inline Form -->
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
                    <h2 class="mr-auto text-base font-medium">Inline Form</h2>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-switch.label','data' => ['for' => 'show-example-8']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-switch.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'show-example-8']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-switch.input','data' => ['class' => 'ml-3 mr-0','id' => 'show-example-8','type' => 'checkbox']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-switch.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'ml-3 mr-0','id' => 'show-example-8','type' => 'checkbox']); ?>
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
                        <div class="grid grid-cols-12 gap-2">
                            <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['class' => 'col-span-4','type' => 'text','ariaLabel' => 'default input inline 1','placeholder' => 'Input inline 1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'col-span-4','type' => 'text','aria-label' => 'default input inline 1','placeholder' => 'Input inline 1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['class' => 'col-span-4','type' => 'text','ariaLabel' => 'default input inline 2','placeholder' => 'Input inline 2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'col-span-4','type' => 'text','aria-label' => 'default input inline 2','placeholder' => 'Input inline 2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['class' => 'col-span-4','type' => 'text','ariaLabel' => 'default input inline 3','placeholder' => 'Input inline 3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'col-span-4','type' => 'text','aria-label' => 'default input inline 3','placeholder' => 'Input inline 3']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
                        </div>
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
                            <div class="grid grid-cols-12 gap-2">
                                <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['class' => 'col-span-4','type' => 'text','ariaLabel' => 'default input inline 1','placeholder' => 'Input inline 1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'col-span-4','type' => 'text','aria-label' => 'default input inline 1','placeholder' => 'Input inline 1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['class' => 'col-span-4','type' => 'text','ariaLabel' => 'default input inline 2','placeholder' => 'Input inline 2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'col-span-4','type' => 'text','aria-label' => 'default input inline 2','placeholder' => 'Input inline 2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['class' => 'col-span-4','type' => 'text','ariaLabel' => 'default input inline 3','placeholder' => 'Input inline 3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'col-span-4','type' => 'text','aria-label' => 'default input inline 3','placeholder' => 'Input inline 3']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
                            </div>
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
            <!-- END: Inline Form -->
            <!-- BEGIN: Checkbox & Switch -->
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
                        Checkbox & Switch
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-switch.label','data' => ['for' => 'show-example-9']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-switch.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'show-example-9']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-switch.input','data' => ['class' => 'ml-3 mr-0','id' => 'show-example-9','type' => 'checkbox']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-switch.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'ml-3 mr-0','id' => 'show-example-9','type' => 'checkbox']); ?>
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
                        <div>
                            <label>Vertical Checkbox</label>
                            <?php if (isset($component)) { $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.index','data' => ['class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2']); ?>
                                <?php if (isset($component)) { $__componentOriginal45dc70583f76c3df9e7383efd567b5fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.input','data' => ['id' => 'checkbox-switch-1','type' => 'checkbox','value' => '']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'checkbox-switch-1','type' => 'checkbox','value' => '']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $attributes = $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $component = $__componentOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginal8218ba5fba45bffb9ccf737358e222ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.label','data' => ['for' => 'checkbox-switch-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'checkbox-switch-1']); ?>
                                    Chris Evans
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $attributes = $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $component = $__componentOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $attributes = $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $component = $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.index','data' => ['class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2']); ?>
                                <?php if (isset($component)) { $__componentOriginal45dc70583f76c3df9e7383efd567b5fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.input','data' => ['id' => 'checkbox-switch-2','type' => 'checkbox','value' => '']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'checkbox-switch-2','type' => 'checkbox','value' => '']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $attributes = $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $component = $__componentOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginal8218ba5fba45bffb9ccf737358e222ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.label','data' => ['for' => 'checkbox-switch-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'checkbox-switch-2']); ?>
                                    Liam Neeson
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $attributes = $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $component = $__componentOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $attributes = $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $component = $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.index','data' => ['class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2']); ?>
                                <?php if (isset($component)) { $__componentOriginal45dc70583f76c3df9e7383efd567b5fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.input','data' => ['id' => 'checkbox-switch-3','type' => 'checkbox','value' => '']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'checkbox-switch-3','type' => 'checkbox','value' => '']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $attributes = $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $component = $__componentOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginal8218ba5fba45bffb9ccf737358e222ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.label','data' => ['for' => 'checkbox-switch-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'checkbox-switch-3']); ?>
                                    Daniel Craig
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $attributes = $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $component = $__componentOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $attributes = $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $component = $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
                        </div>
                        <div class="mt-3">
                            <label>Horizontal Checkbox</label>
                            <div class="mt-2 flex flex-col sm:flex-row">
                                <?php if (isset($component)) { $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.index','data' => ['class' => 'mr-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mr-2']); ?>
                                    <?php if (isset($component)) { $__componentOriginal45dc70583f76c3df9e7383efd567b5fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.input','data' => ['id' => 'checkbox-switch-4','type' => 'checkbox','value' => '']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'checkbox-switch-4','type' => 'checkbox','value' => '']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $attributes = $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $component = $__componentOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
                                    <?php if (isset($component)) { $__componentOriginal8218ba5fba45bffb9ccf737358e222ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.label','data' => ['for' => 'checkbox-switch-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'checkbox-switch-4']); ?>
                                        Chris Evans
                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $attributes = $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $component = $__componentOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $attributes = $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $component = $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.index','data' => ['class' => 'mr-2 mt-2 sm:mt-0']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mr-2 mt-2 sm:mt-0']); ?>
                                    <?php if (isset($component)) { $__componentOriginal45dc70583f76c3df9e7383efd567b5fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.input','data' => ['id' => 'checkbox-switch-5','type' => 'checkbox','value' => '']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'checkbox-switch-5','type' => 'checkbox','value' => '']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $attributes = $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $component = $__componentOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
                                    <?php if (isset($component)) { $__componentOriginal8218ba5fba45bffb9ccf737358e222ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.label','data' => ['for' => 'checkbox-switch-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'checkbox-switch-5']); ?>
                                        Liam Neeson
                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $attributes = $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $component = $__componentOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $attributes = $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $component = $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.index','data' => ['class' => 'mr-2 mt-2 sm:mt-0']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mr-2 mt-2 sm:mt-0']); ?>
                                    <?php if (isset($component)) { $__componentOriginal45dc70583f76c3df9e7383efd567b5fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.input','data' => ['id' => 'checkbox-switch-6','type' => 'checkbox','value' => '']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'checkbox-switch-6','type' => 'checkbox','value' => '']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $attributes = $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $component = $__componentOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
                                    <?php if (isset($component)) { $__componentOriginal8218ba5fba45bffb9ccf737358e222ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.label','data' => ['for' => 'checkbox-switch-6']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'checkbox-switch-6']); ?>
                                        Daniel Craig
                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $attributes = $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $component = $__componentOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $attributes = $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $component = $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
                            </div>
                        </div>
                        <div class="mt-3">
                            <label>Switch</label>
                            <div class="mt-2">
                                <?php if (isset($component)) { $__componentOriginal0e9b1708c541f0772f542e0482be43cc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0e9b1708c541f0772f542e0482be43cc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-switch.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-switch'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                                    <?php if (isset($component)) { $__componentOriginala545c0dc845886385891e9173fb8e250 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala545c0dc845886385891e9173fb8e250 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-switch.input','data' => ['id' => 'checkbox-switch-7','type' => 'checkbox']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-switch.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'checkbox-switch-7','type' => 'checkbox']); ?>
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
                                    <?php if (isset($component)) { $__componentOriginal2d72b4ed762a09d18a89903d2344442f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2d72b4ed762a09d18a89903d2344442f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-switch.label','data' => ['for' => 'checkbox-switch-7']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-switch.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'checkbox-switch-7']); ?>
                                        Default switch checkbox input
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
                        </div>
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
                            <div>
                                <label>Vertical Checkbox</label>
                                <?php if (isset($component)) { $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.index','data' => ['class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2']); ?>
                                    <?php if (isset($component)) { $__componentOriginal45dc70583f76c3df9e7383efd567b5fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.input','data' => ['id' => 'checkbox-switch-1','type' => 'checkbox','value' => '']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'checkbox-switch-1','type' => 'checkbox','value' => '']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $attributes = $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $component = $__componentOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
                                    <?php if (isset($component)) { $__componentOriginal8218ba5fba45bffb9ccf737358e222ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.label','data' => ['for' => 'checkbox-switch-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'checkbox-switch-1']); ?>
                                        Chris Evans
                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $attributes = $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $component = $__componentOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $attributes = $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $component = $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.index','data' => ['class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2']); ?>
                                    <?php if (isset($component)) { $__componentOriginal45dc70583f76c3df9e7383efd567b5fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.input','data' => ['id' => 'checkbox-switch-2','type' => 'checkbox','value' => '']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'checkbox-switch-2','type' => 'checkbox','value' => '']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $attributes = $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $component = $__componentOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
                                    <?php if (isset($component)) { $__componentOriginal8218ba5fba45bffb9ccf737358e222ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.label','data' => ['for' => 'checkbox-switch-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'checkbox-switch-2']); ?>
                                        Liam Neeson
                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $attributes = $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $component = $__componentOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $attributes = $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $component = $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.index','data' => ['class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2']); ?>
                                    <?php if (isset($component)) { $__componentOriginal45dc70583f76c3df9e7383efd567b5fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.input','data' => ['id' => 'checkbox-switch-3','type' => 'checkbox','value' => '']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'checkbox-switch-3','type' => 'checkbox','value' => '']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $attributes = $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $component = $__componentOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
                                    <?php if (isset($component)) { $__componentOriginal8218ba5fba45bffb9ccf737358e222ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.label','data' => ['for' => 'checkbox-switch-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'checkbox-switch-3']); ?>
                                        Daniel Craig
                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $attributes = $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $component = $__componentOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $attributes = $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $component = $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
                            </div>
                            <div class="mt-3">
                                <label>Horizontal Checkbox</label>
                                <div class="mt-2 flex flex-col sm:flex-row">
                                    <?php if (isset($component)) { $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.index','data' => ['class' => 'mr-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mr-2']); ?>
                                        <?php if (isset($component)) { $__componentOriginal45dc70583f76c3df9e7383efd567b5fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.input','data' => ['id' => 'checkbox-switch-4','type' => 'checkbox','value' => '']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'checkbox-switch-4','type' => 'checkbox','value' => '']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $attributes = $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $component = $__componentOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
                                        <?php if (isset($component)) { $__componentOriginal8218ba5fba45bffb9ccf737358e222ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.label','data' => ['for' => 'checkbox-switch-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'checkbox-switch-4']); ?>
                                            Chris Evans
                                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $attributes = $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $component = $__componentOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $attributes = $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $component = $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
                                    <?php if (isset($component)) { $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.index','data' => ['class' => 'mr-2 mt-2 sm:mt-0']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mr-2 mt-2 sm:mt-0']); ?>
                                        <?php if (isset($component)) { $__componentOriginal45dc70583f76c3df9e7383efd567b5fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.input','data' => ['id' => 'checkbox-switch-5','type' => 'checkbox','value' => '']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'checkbox-switch-5','type' => 'checkbox','value' => '']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $attributes = $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $component = $__componentOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
                                        <?php if (isset($component)) { $__componentOriginal8218ba5fba45bffb9ccf737358e222ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.label','data' => ['for' => 'checkbox-switch-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'checkbox-switch-5']); ?>
                                            Liam Neeson
                                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $attributes = $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $component = $__componentOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $attributes = $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $component = $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
                                    <?php if (isset($component)) { $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.index','data' => ['class' => 'mr-2 mt-2 sm:mt-0']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mr-2 mt-2 sm:mt-0']); ?>
                                        <?php if (isset($component)) { $__componentOriginal45dc70583f76c3df9e7383efd567b5fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.input','data' => ['id' => 'checkbox-switch-6','type' => 'checkbox','value' => '']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'checkbox-switch-6','type' => 'checkbox','value' => '']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $attributes = $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $component = $__componentOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
                                        <?php if (isset($component)) { $__componentOriginal8218ba5fba45bffb9ccf737358e222ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.label','data' => ['for' => 'checkbox-switch-6']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'checkbox-switch-6']); ?>
                                            Daniel Craig
                                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $attributes = $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $component = $__componentOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $attributes = $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $component = $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
                                </div>
                            </div>
                            <div class="mt-3">
                                <label>Switch</label>
                                <div class="mt-2">
                                    <?php if (isset($component)) { $__componentOriginal0e9b1708c541f0772f542e0482be43cc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0e9b1708c541f0772f542e0482be43cc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-switch.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-switch'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                                        <?php if (isset($component)) { $__componentOriginala545c0dc845886385891e9173fb8e250 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala545c0dc845886385891e9173fb8e250 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-switch.input','data' => ['id' => 'checkbox-switch-7','type' => 'checkbox']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-switch.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'checkbox-switch-7','type' => 'checkbox']); ?>
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
                                        <?php if (isset($component)) { $__componentOriginal2d72b4ed762a09d18a89903d2344442f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2d72b4ed762a09d18a89903d2344442f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-switch.label','data' => ['for' => 'checkbox-switch-7']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-switch.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'checkbox-switch-7']); ?>
                                            Default switch checkbox input
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
                            </div>
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
            <!-- END: Checkbox & Switch -->
            <!-- BEGIN: Radio Button -->
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
                    <h2 class="mr-auto text-base font-medium">Radio</h2>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-switch.label','data' => ['for' => 'show-example-10']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-switch.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'show-example-10']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-switch.input','data' => ['class' => 'ml-3 mr-0','id' => 'show-example-10','type' => 'checkbox']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-switch.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'ml-3 mr-0','id' => 'show-example-10','type' => 'checkbox']); ?>
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
                        <div>
                            <label>Vertical Radio Button</label>
                            <?php if (isset($component)) { $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.index','data' => ['class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2']); ?>
                                <?php if (isset($component)) { $__componentOriginal45dc70583f76c3df9e7383efd567b5fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.input','data' => ['id' => 'radio-switch-1','name' => 'vertical_radio_button','type' => 'radio','value' => 'vertical-radio-chris-evans']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'radio-switch-1','name' => 'vertical_radio_button','type' => 'radio','value' => 'vertical-radio-chris-evans']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $attributes = $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $component = $__componentOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginal8218ba5fba45bffb9ccf737358e222ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.label','data' => ['for' => 'radio-switch-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'radio-switch-1']); ?>
                                    Chris Evans
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $attributes = $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $component = $__componentOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $attributes = $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $component = $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.index','data' => ['class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2']); ?>
                                <?php if (isset($component)) { $__componentOriginal45dc70583f76c3df9e7383efd567b5fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.input','data' => ['id' => 'radio-switch-2','name' => 'vertical_radio_button','type' => 'radio','value' => 'vertical-radio-liam-neeson']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'radio-switch-2','name' => 'vertical_radio_button','type' => 'radio','value' => 'vertical-radio-liam-neeson']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $attributes = $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $component = $__componentOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginal8218ba5fba45bffb9ccf737358e222ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.label','data' => ['for' => 'radio-switch-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'radio-switch-2']); ?>
                                    Liam Neeson
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $attributes = $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $component = $__componentOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $attributes = $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $component = $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.index','data' => ['class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2']); ?>
                                <?php if (isset($component)) { $__componentOriginal45dc70583f76c3df9e7383efd567b5fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.input','data' => ['id' => 'radio-switch-3','name' => 'vertical_radio_button','type' => 'radio','value' => 'vertical-radio-daniel-craig']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'radio-switch-3','name' => 'vertical_radio_button','type' => 'radio','value' => 'vertical-radio-daniel-craig']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $attributes = $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $component = $__componentOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginal8218ba5fba45bffb9ccf737358e222ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.label','data' => ['for' => 'radio-switch-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'radio-switch-3']); ?>
                                    Daniel Craig
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $attributes = $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $component = $__componentOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $attributes = $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $component = $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
                        </div>
                        <div class="mt-3">
                            <label>Horizontal Radio Button</label>
                            <div class="mt-2 flex flex-col sm:flex-row">
                                <?php if (isset($component)) { $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.index','data' => ['class' => 'mr-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mr-2']); ?>
                                    <?php if (isset($component)) { $__componentOriginal45dc70583f76c3df9e7383efd567b5fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.input','data' => ['id' => 'radio-switch-4','name' => 'horizontal_radio_button','type' => 'radio','value' => 'horizontal-radio-chris-evans']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'radio-switch-4','name' => 'horizontal_radio_button','type' => 'radio','value' => 'horizontal-radio-chris-evans']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $attributes = $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $component = $__componentOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
                                    <?php if (isset($component)) { $__componentOriginal8218ba5fba45bffb9ccf737358e222ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.label','data' => ['for' => 'radio-switch-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'radio-switch-4']); ?>
                                        Chris Evans
                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $attributes = $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $component = $__componentOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $attributes = $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $component = $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.index','data' => ['class' => 'mr-2 mt-2 sm:mt-0']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mr-2 mt-2 sm:mt-0']); ?>
                                    <?php if (isset($component)) { $__componentOriginal45dc70583f76c3df9e7383efd567b5fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.input','data' => ['id' => 'radio-switch-5','name' => 'horizontal_radio_button','type' => 'radio','value' => 'horizontal-radio-liam-neeson']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'radio-switch-5','name' => 'horizontal_radio_button','type' => 'radio','value' => 'horizontal-radio-liam-neeson']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $attributes = $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $component = $__componentOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
                                    <?php if (isset($component)) { $__componentOriginal8218ba5fba45bffb9ccf737358e222ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.label','data' => ['for' => 'radio-switch-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'radio-switch-5']); ?>
                                        Liam Neeson
                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $attributes = $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $component = $__componentOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $attributes = $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $component = $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.index','data' => ['class' => 'mr-2 mt-2 sm:mt-0']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mr-2 mt-2 sm:mt-0']); ?>
                                    <?php if (isset($component)) { $__componentOriginal45dc70583f76c3df9e7383efd567b5fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.input','data' => ['id' => 'radio-switch-6','name' => 'horizontal_radio_button','type' => 'radio','value' => 'horizontal-radio-daniel-craig']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'radio-switch-6','name' => 'horizontal_radio_button','type' => 'radio','value' => 'horizontal-radio-daniel-craig']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $attributes = $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $component = $__componentOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
                                    <?php if (isset($component)) { $__componentOriginal8218ba5fba45bffb9ccf737358e222ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.label','data' => ['for' => 'radio-switch-6']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'radio-switch-6']); ?>
                                        Daniel Craig
                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $attributes = $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $component = $__componentOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $attributes = $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $component = $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
                            </div>
                        </div>
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
                            <div>
                                <label>Vertical Radio Button</label>
                                <?php if (isset($component)) { $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.index','data' => ['class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2']); ?>
                                    <?php if (isset($component)) { $__componentOriginal45dc70583f76c3df9e7383efd567b5fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.input','data' => ['id' => 'radio-switch-1','name' => 'vertical_radio_button','type' => 'radio','value' => 'vertical-radio-chris-evans']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'radio-switch-1','name' => 'vertical_radio_button','type' => 'radio','value' => 'vertical-radio-chris-evans']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $attributes = $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $component = $__componentOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
                                    <?php if (isset($component)) { $__componentOriginal8218ba5fba45bffb9ccf737358e222ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.label','data' => ['for' => 'radio-switch-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'radio-switch-1']); ?>
                                        Chris Evans
                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $attributes = $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $component = $__componentOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $attributes = $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $component = $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.index','data' => ['class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2']); ?>
                                    <?php if (isset($component)) { $__componentOriginal45dc70583f76c3df9e7383efd567b5fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.input','data' => ['id' => 'radio-switch-2','name' => 'vertical_radio_button','type' => 'radio','value' => 'vertical-radio-liam-neeson']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'radio-switch-2','name' => 'vertical_radio_button','type' => 'radio','value' => 'vertical-radio-liam-neeson']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $attributes = $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $component = $__componentOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
                                    <?php if (isset($component)) { $__componentOriginal8218ba5fba45bffb9ccf737358e222ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.label','data' => ['for' => 'radio-switch-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'radio-switch-2']); ?>
                                        Liam Neeson
                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $attributes = $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $component = $__componentOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $attributes = $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $component = $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.index','data' => ['class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2']); ?>
                                    <?php if (isset($component)) { $__componentOriginal45dc70583f76c3df9e7383efd567b5fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.input','data' => ['id' => 'radio-switch-3','name' => 'vertical_radio_button','type' => 'radio','value' => 'vertical-radio-daniel-craig']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'radio-switch-3','name' => 'vertical_radio_button','type' => 'radio','value' => 'vertical-radio-daniel-craig']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $attributes = $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $component = $__componentOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
                                    <?php if (isset($component)) { $__componentOriginal8218ba5fba45bffb9ccf737358e222ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.label','data' => ['for' => 'radio-switch-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'radio-switch-3']); ?>
                                        Daniel Craig
                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $attributes = $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $component = $__componentOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $attributes = $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $component = $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
                            </div>
                            <div class="mt-3">
                                <label>Horizontal Radio Button</label>
                                <div class="mt-2 flex flex-col sm:flex-row">
                                    <?php if (isset($component)) { $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.index','data' => ['class' => 'mr-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mr-2']); ?>
                                        <?php if (isset($component)) { $__componentOriginal45dc70583f76c3df9e7383efd567b5fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.input','data' => ['id' => 'radio-switch-4','name' => 'horizontal_radio_button','type' => 'radio','value' => 'horizontal-radio-chris-evans']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'radio-switch-4','name' => 'horizontal_radio_button','type' => 'radio','value' => 'horizontal-radio-chris-evans']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $attributes = $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $component = $__componentOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
                                        <?php if (isset($component)) { $__componentOriginal8218ba5fba45bffb9ccf737358e222ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.label','data' => ['for' => 'radio-switch-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'radio-switch-4']); ?>
                                            Chris Evans
                                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $attributes = $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $component = $__componentOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $attributes = $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $component = $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
                                    <?php if (isset($component)) { $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.index','data' => ['class' => 'mr-2 mt-2 sm:mt-0']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mr-2 mt-2 sm:mt-0']); ?>
                                        <?php if (isset($component)) { $__componentOriginal45dc70583f76c3df9e7383efd567b5fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.input','data' => ['id' => 'radio-switch-5','name' => 'horizontal_radio_button','type' => 'radio','value' => 'horizontal-radio-liam-neeson']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'radio-switch-5','name' => 'horizontal_radio_button','type' => 'radio','value' => 'horizontal-radio-liam-neeson']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $attributes = $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $component = $__componentOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
                                        <?php if (isset($component)) { $__componentOriginal8218ba5fba45bffb9ccf737358e222ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.label','data' => ['for' => 'radio-switch-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'radio-switch-5']); ?>
                                            Liam Neeson
                                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $attributes = $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $component = $__componentOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $attributes = $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $component = $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
                                    <?php if (isset($component)) { $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.index','data' => ['class' => 'mr-2 mt-2 sm:mt-0']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mr-2 mt-2 sm:mt-0']); ?>
                                        <?php if (isset($component)) { $__componentOriginal45dc70583f76c3df9e7383efd567b5fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.input','data' => ['id' => 'radio-switch-6','name' => 'horizontal_radio_button','type' => 'radio','value' => 'horizontal-radio-daniel-craig']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'radio-switch-6','name' => 'horizontal_radio_button','type' => 'radio','value' => 'horizontal-radio-daniel-craig']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $attributes = $__attributesOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__attributesOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd)): ?>
<?php $component = $__componentOriginal45dc70583f76c3df9e7383efd567b5fd; ?>
<?php unset($__componentOriginal45dc70583f76c3df9e7383efd567b5fd); ?>
<?php endif; ?>
                                        <?php if (isset($component)) { $__componentOriginal8218ba5fba45bffb9ccf737358e222ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-check.label','data' => ['for' => 'radio-switch-6']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-check.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'radio-switch-6']); ?>
                                            Daniel Craig
                                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $attributes = $__attributesOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__attributesOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee)): ?>
<?php $component = $__componentOriginal8218ba5fba45bffb9ccf737358e222ee; ?>
<?php unset($__componentOriginal8218ba5fba45bffb9ccf737358e222ee); ?>
<?php endif; ?>
                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $attributes = $__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__attributesOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b)): ?>
<?php $component = $__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b; ?>
<?php unset($__componentOriginalfc0d3255d411960ba8c8fe29d7ad392b); ?>
<?php endif; ?>
                                </div>
                            </div>
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
            <!-- END: Radio Button -->
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../themes/' . $activeTheme . '/' . $activeLayout, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\smart-erp\resources\views/pages/regular-form.blade.php ENDPATH**/ ?>
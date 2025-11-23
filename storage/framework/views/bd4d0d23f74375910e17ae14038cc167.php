<?php $__env->startSection('subhead'); ?>
    <title>Departments Management - <?php echo e(config('app.name')); ?></title>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.datatable.styles', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.datatable.theme', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('subcontent'); ?>
    <?php echo $__env->make('components.global-notifications', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <div class="intro-y mt-6 mb-2 flex flex-col gap-1 text-[#3a2a1a]">
        <div class="flex items-baseline justify-between gap-6">
            <h2 class="flex items-center gap-2 text-2xl md:text-3xl font-semibold text-royalDark tracking-wide">
                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'building','class' => 'w-7 h-7']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'building','class' => 'w-7 h-7']); ?>
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
                <span>Departments Management</span>
            </h2>

            <div class="flex flex-row items-end gap-8 md:gap-12 justify-end">
                
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'pause-circle','class' => 'w-4 h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'pause-circle','class' => 'w-4 h-4']); ?>
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
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            <?php echo e($departmentsInactive ?? '—'); ?>

                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Inactive
                    </div>
                </div>

                
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'check-circle-2','class' => 'w-4 h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'check-circle-2','class' => 'w-4 h-4']); ?>
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
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            <?php echo e($departmentsActive ?? '—'); ?>

                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Active
                    </div>
                </div>

                
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'building','class' => 'w-4 h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'building','class' => 'w-4 h-4']); ?>
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
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            <?php echo e($departmentsTotal ?? '—'); ?>

                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Departments
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <?php if (isset($component)) { $__componentOriginal1e00c22da64774fd0d873cb958c26686 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1e00c22da64774fd0d873cb958c26686 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.preview-component.index','data' => ['class' => 'intro-y box bg-white/80 border border-slate-200/70 shadow-[0_18px_45px_rgba(15,23,42,0.10)]']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.preview-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'intro-y box bg-white/80 border border-slate-200/70 shadow-[0_18px_45px_rgba(15,23,42,0.10)]']); ?>
                <div class="p-5">
                    <?php if(session('success')): ?>
                        <?php if (isset($component)) { $__componentOriginalaedd4f8693339056cc3bcfecdf92dacf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalaedd4f8693339056cc3bcfecdf92dacf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.alert.index','data' => ['class' => 'mb-4','variant' => 'success']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mb-4','variant' => 'success']); ?>
                            <div class="flex items-center">
                                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'CheckCircle','class' => 'w-5 h-5 mr-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'CheckCircle','class' => 'w-5 h-5 mr-2']); ?>
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
                                <?php echo e(session('success')); ?>

                            </div>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalaedd4f8693339056cc3bcfecdf92dacf)): ?>
<?php $attributes = $__attributesOriginalaedd4f8693339056cc3bcfecdf92dacf; ?>
<?php unset($__attributesOriginalaedd4f8693339056cc3bcfecdf92dacf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalaedd4f8693339056cc3bcfecdf92dacf)): ?>
<?php $component = $__componentOriginalaedd4f8693339056cc3bcfecdf92dacf; ?>
<?php unset($__componentOriginalaedd4f8693339056cc3bcfecdf92dacf); ?>
<?php endif; ?>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        <?php if (isset($component)) { $__componentOriginalaedd4f8693339056cc3bcfecdf92dacf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalaedd4f8693339056cc3bcfecdf92dacf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.alert.index','data' => ['class' => 'mb-4','variant' => 'danger']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mb-4','variant' => 'danger']); ?>
                            <div class="flex items-center">
                                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'AlertTriangle','class' => 'w-5 h-5 mr-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'AlertTriangle','class' => 'w-5 h-5 mr-2']); ?>
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
                                <?php echo e(session('error')); ?>

                            </div>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalaedd4f8693339056cc3bcfecdf92dacf)): ?>
<?php $attributes = $__attributesOriginalaedd4f8693339056cc3bcfecdf92dacf; ?>
<?php unset($__attributesOriginalaedd4f8693339056cc3bcfecdf92dacf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalaedd4f8693339056cc3bcfecdf92dacf)): ?>
<?php $component = $__componentOriginalaedd4f8693339056cc3bcfecdf92dacf; ?>
<?php unset($__componentOriginalaedd4f8693339056cc3bcfecdf92dacf); ?>
<?php endif; ?>
                    <?php endif; ?>

                    <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                        <form id="departments-filter-form" class="w-full sm:mr-auto xl:flex">
                            <div class="items-center sm:mr-4 sm:flex">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Field
                                </label>
                                <?php if (isset($component)) { $__componentOriginal1c0beb3cd2271cd34645d22f15db5e3a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1c0beb3cd2271cd34645d22f15db5e3a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-select.index','data' => ['id' => 'departments-filter-field','class' => 'mt-2 w-full sm:mt-0 sm:w-auto 2xl:w-full']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'departments-filter-field','class' => 'mt-2 w-full sm:mt-0 sm:w-auto 2xl:w-full']); ?>
                                    <option value="all">All Fields</option>
                                    <option value="name">Name</option>
                                    <option value="company">Company</option>
                                    <option value="manager">Manager</option>
                                    <option value="employees_count">Employees</option>
                                    <option value="status">Status</option>
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
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Type
                                </label>
                                <?php if (isset($component)) { $__componentOriginal1c0beb3cd2271cd34645d22f15db5e3a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1c0beb3cd2271cd34645d22f15db5e3a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-select.index','data' => ['id' => 'departments-filter-type','class' => 'mt-2 w-full sm:mt-0 sm:w-auto']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'departments-filter-type','class' => 'mt-2 w-full sm:mt-0 sm:w-auto']); ?>
                                    <option value="contains">Contains</option>
                                    <option value="equals">Equals</option>
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
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Value
                                </label>
                                <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'departments-filter-value','type' => 'text','placeholder' => 'Search...','class' => 'mt-2 w-full sm:mt-0 sm:w-48 2xl:w-full']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'departments-filter-value','type' => 'text','placeholder' => 'Search...','class' => 'mt-2 w-full sm:mt-0 sm:w-48 2xl:w-full']); ?>
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
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Show
                                </label>
                                <?php if (isset($component)) { $__componentOriginal1c0beb3cd2271cd34645d22f15db5e3a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1c0beb3cd2271cd34645d22f15db5e3a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-select.index','data' => ['id' => 'departments-filter-length','class' => 'mt-2 w-full sm:mt-0 sm:w-auto']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'departments-filter-length','class' => 'mt-2 w-full sm:mt-0 sm:w-auto']); ?>
                                    <option value="10">10</option>
                                    <option value="25" selected>25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
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
                            <div class="mt-4 flex flex-wrap gap-2 sm:items-center xl:mt-0">
                                <?php if (isset($component)) { $__componentOriginaleaefd826d177068d67dd4af24306c055 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaleaefd826d177068d67dd4af24306c055 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.tippy.index','data' => ['content' => 'Apply filters','placement' => 'top']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.tippy'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['content' => 'Apply filters','placement' => 'top']); ?>
                                    <button id="departments-filter-go" type="button" class="btn-royal btn-royal--dark btn-royal--sm w-full sm:w-24 group">
                                        <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'search','class' => 'w-4 h-4 icon-hover-rise']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'search','class' => 'w-4 h-4 icon-hover-rise']); ?>
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
                                        Go
                                    </button>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaleaefd826d177068d67dd4af24306c055)): ?>
<?php $attributes = $__attributesOriginaleaefd826d177068d67dd4af24306c055; ?>
<?php unset($__attributesOriginaleaefd826d177068d67dd4af24306c055); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaleaefd826d177068d67dd4af24306c055)): ?>
<?php $component = $__componentOriginaleaefd826d177068d67dd4af24306c055; ?>
<?php unset($__componentOriginaleaefd826d177068d67dd4af24306c055); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginaleaefd826d177068d67dd4af24306c055 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaleaefd826d177068d67dd4af24306c055 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.tippy.index','data' => ['content' => 'Reset filters','placement' => 'top']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.tippy'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['content' => 'Reset filters','placement' => 'top']); ?>
                                    <button id="departments-filter-reset" type="button" class="btn-royal btn-royal--outline btn-royal--sm w-full sm:w-24 group">
                                        <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'rotate-ccw','class' => 'w-4 h-4 icon-hover-rise']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'rotate-ccw','class' => 'w-4 h-4 icon-hover-rise']); ?>
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
                                        Reset
                                    </button>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaleaefd826d177068d67dd4af24306c055)): ?>
<?php $attributes = $__attributesOriginaleaefd826d177068d67dd4af24306c055; ?>
<?php unset($__attributesOriginaleaefd826d177068d67dd4af24306c055); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaleaefd826d177068d67dd4af24306c055)): ?>
<?php $component = $__componentOriginaleaefd826d177068d67dd4af24306c055; ?>
<?php unset($__componentOriginaleaefd826d177068d67dd4af24306c055); ?>
<?php endif; ?>
                            </div>
                        </form>

                        <div class="mt-5 flex flex-wrap items-center gap-2 sm:mt-0 sm:flex-nowrap">
                            <?php if (isset($component)) { $__componentOriginaleaefd826d177068d67dd4af24306c055 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaleaefd826d177068d67dd4af24306c055 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.tippy.index','data' => ['content' => 'Print','placement' => 'bottom']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.tippy'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['content' => 'Print','placement' => 'bottom']); ?>
                                <button type="button" class="btn-royal btn-royal--outline btn-royal--sm btn-tonal--icon group text-royalDark">
                                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'printer','class' => 'w-5 h-5 icon-hover-rise']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'printer','class' => 'w-5 h-5 icon-hover-rise']); ?>
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
<?php if (isset($__attributesOriginaleaefd826d177068d67dd4af24306c055)): ?>
<?php $attributes = $__attributesOriginaleaefd826d177068d67dd4af24306c055; ?>
<?php unset($__attributesOriginaleaefd826d177068d67dd4af24306c055); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaleaefd826d177068d67dd4af24306c055)): ?>
<?php $component = $__componentOriginaleaefd826d177068d67dd4af24306c055; ?>
<?php unset($__componentOriginaleaefd826d177068d67dd4af24306c055); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginaleaefd826d177068d67dd4af24306c055 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaleaefd826d177068d67dd4af24306c055 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.tippy.index','data' => ['content' => 'Export PDF','placement' => 'bottom']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.tippy'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['content' => 'Export PDF','placement' => 'bottom']); ?>
                                <button type="button" class="btn-royal btn-royal--outline btn-royal--sm btn-tonal--icon group text-royalDark">
                                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'file-text','class' => 'w-5 h-5 icon-hover-rise']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'file-text','class' => 'w-5 h-5 icon-hover-rise']); ?>
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
<?php if (isset($__attributesOriginaleaefd826d177068d67dd4af24306c055)): ?>
<?php $attributes = $__attributesOriginaleaefd826d177068d67dd4af24306c055; ?>
<?php unset($__attributesOriginaleaefd826d177068d67dd4af24306c055); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaleaefd826d177068d67dd4af24306c055)): ?>
<?php $component = $__componentOriginaleaefd826d177068d67dd4af24306c055; ?>
<?php unset($__componentOriginaleaefd826d177068d67dd4af24306c055); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginaleaefd826d177068d67dd4af24306c055 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaleaefd826d177068d67dd4af24306c055 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.tippy.index','data' => ['content' => 'Export to Excel','placement' => 'bottom']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.tippy'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['content' => 'Export to Excel','placement' => 'bottom']); ?>
                                <button id="departments-export" type="button" class="btn-royal btn-royal--outline btn-royal--sm btn-tonal--icon group text-royalDark">
                                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'file-spreadsheet','class' => 'w-5 h-5 icon-hover-rise']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'file-spreadsheet','class' => 'w-5 h-5 icon-hover-rise']); ?>
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
<?php if (isset($__attributesOriginaleaefd826d177068d67dd4af24306c055)): ?>
<?php $attributes = $__attributesOriginaleaefd826d177068d67dd4af24306c055; ?>
<?php unset($__attributesOriginaleaefd826d177068d67dd4af24306c055); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaleaefd826d177068d67dd4af24306c055)): ?>
<?php $component = $__componentOriginaleaefd826d177068d67dd4af24306c055; ?>
<?php unset($__componentOriginaleaefd826d177068d67dd4af24306c055); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginaleaefd826d177068d67dd4af24306c055 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaleaefd826d177068d67dd4af24306c055 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.tippy.index','data' => ['content' => 'Refresh','placement' => 'bottom']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.tippy'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['content' => 'Refresh','placement' => 'bottom']); ?>
                                <button id="departments-refresh" type="button" class="btn-royal btn-royal--outline btn-royal--sm btn-tonal--icon group text-royalDark">
                                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'refresh-cw','class' => 'w-5 h-5 icon-hover-rise']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'refresh-cw','class' => 'w-5 h-5 icon-hover-rise']); ?>
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
<?php if (isset($__attributesOriginaleaefd826d177068d67dd4af24306c055)): ?>
<?php $attributes = $__attributesOriginaleaefd826d177068d67dd4af24306c055; ?>
<?php unset($__attributesOriginaleaefd826d177068d67dd4af24306c055); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaleaefd826d177068d67dd4af24306c055)): ?>
<?php $component = $__componentOriginaleaefd826d177068d67dd4af24306c055; ?>
<?php unset($__componentOriginaleaefd826d177068d67dd4af24306c055); ?>
<?php endif; ?>

                            
                            <?php if (isset($component)) { $__componentOriginaleaefd826d177068d67dd4af24306c055 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaleaefd826d177068d67dd4af24306c055 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.tippy.index','data' => ['content' => 'Add new department','placement' => 'bottom']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.tippy'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['content' => 'Add new department','placement' => 'bottom']); ?>
                                <button
                                    type="button"
                                    class="btn-royal btn-royal--gold btn-royal--sm sm:btn-royal--lg group"
                                    data-tw-toggle="modal"
                                    data-tw-target="#create-department-modal"
                                >
                                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'plus-circle','class' => 'w-5 h-5 icon-hover-rise']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'plus-circle','class' => 'w-5 h-5 icon-hover-rise']); ?>
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
                                    <span class="hidden sm:inline">Add</span>
                                </button>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaleaefd826d177068d67dd4af24306c055)): ?>
<?php $attributes = $__attributesOriginaleaefd826d177068d67dd4af24306c055; ?>
<?php unset($__attributesOriginaleaefd826d177068d67dd4af24306c055); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaleaefd826d177068d67dd4af24306c055)): ?>
<?php $component = $__componentOriginaleaefd826d177068d67dd4af24306c055; ?>
<?php unset($__componentOriginaleaefd826d177068d67dd4af24306c055); ?>
<?php endif; ?>
                        </div>
                    </div>

                    <div class="overflow-x-auto sm:overflow-visible" data-erp-table-wrapper>
                        <table
                            id="departments-table"
                            data-tw-merge
                            data-erp-table
                            data-departments-datatable-url="<?php echo e(route('hr.departments.datatable')); ?>"
                            data-departments-delete-url-base="<?php echo e(url('hr/departments')); ?>"
                            class="datatable-default w-full min-w-full table-auto text-left text-sm"
                        >
                            <thead>
                                <tr>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">#</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Code</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Name</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Company</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Manager</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Employees</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Status</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
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
        </div>
    </div>

    <?php echo $__env->make('hr.departments.modals.create', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('hr.departments.modals.edit', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <button id="edit-department-trigger" data-tw-toggle="modal" data-tw-target="#edit-department-modal" class="hidden"></button>
<?php $__env->stopSection(); ?>
<?php echo $__env->yieldPushContent('modals'); ?>
<?php echo $__env->make('components.datatable.scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php echo $__env->make('../themes/' . $activeTheme . '/' . $activeLayout, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\smart-erp\resources\views/hr/departments/index.blade.php ENDPATH**/ ?>
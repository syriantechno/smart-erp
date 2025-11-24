

<?php $__env->startSection('subhead'); ?>
    <title>CRM Companies - <?php echo e(config('app.name')); ?></title>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.datatable.styles', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.datatable.theme', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <style>
        /* Make table more compact with better readability */
        #companies-table {
            font-size: 0.95rem; /* 15px - slightly larger */
            line-height: 1.4;
        }

        #companies-table tbody tr {
            height: 2.25rem; /* 36px - more compact */
        }

        #companies-table th {
            font-size: 0.8rem; /* 13px - slightly larger headers */
            font-weight: 700;
            padding: 0.5rem 1.25rem; /* py-2 px-5 */
        }

        #companies-table td {
            padding: 0.375rem 1.25rem; /* py-1.5 px-5 - even more compact */
        }

        /* Status badges - compact and readable */
        #companies-table .inline-flex {
            padding: 0.125rem 0.5rem; /* 2px 8px */
            font-weight: 600;
        }

        /* Actions column - keep compact */
        #companies-table .px-5.py-1\.5 {
            padding: 0.375rem 1.25rem;
        }

        #companies-table thead th,
        #companies-table tbody td {
            text-align: center;
            font-size: 0.9rem;
        }

        #companies-table .datatable-cell-wrap {
            text-align: center;
        }

        #companies-table [class^="stats-card-"],
        #companies-table [class*=" stats-card-"] {
            font-size: 0.95rem;
            font-weight: 600;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .icon-hover-rise {
            transition: transform 200ms ease;
        }

        .group:hover .icon-hover-rise {
            transform: translateY(-2px);
        }
    </style>
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
                <span>Companies Management</span>
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
                        <div class="text-4xl md:text-5xl font-semibold tracking-tight">
                            <?php echo e($inactiveCompanies ?? 0); ?>

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
                        <div class="text-4xl md:text-5xl font-semibold tracking-tight">
                            <?php echo e($activeCompanies ?? 0); ?>

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
                        <div class="text-4xl md:text-5xl font-semibold tracking-tight">
                            <?php echo e($totalCompanies ?? 0); ?>

                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Companies
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
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
                <div class="p-5">
                    <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                        <form id="companies-filter-form" class="w-full sm:mr-auto xl:flex">
                            <div class="items-center sm:mr-4 sm:flex">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Field
                                </label>
                                <?php if (isset($component)) { $__componentOriginal1c0beb3cd2271cd34645d22f15db5e3a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1c0beb3cd2271cd34645d22f15db5e3a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-select.index','data' => ['id' => 'companies-filter-field','class' => 'mt-2 w-full sm:mt-0 sm:w-auto 2xl:w-full']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'companies-filter-field','class' => 'mt-2 w-full sm:mt-0 sm:w-auto 2xl:w-full']); ?>
                                    <option value="all">All Fields</option>
                                    <option value="name">Name</option>
                                    <option value="industry">Industry</option>
                                    <option value="email">Email</option>
                                    <option value="phone">Phone</option>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-select.index','data' => ['id' => 'companies-filter-type','class' => 'mt-2 w-full sm:mt-0 sm:w-auto']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'companies-filter-type','class' => 'mt-2 w-full sm:mt-0 sm:w-auto']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'companies-filter-value','type' => 'text','placeholder' => 'Search...','class' => 'mt-2 w-full sm:mt-0 sm:w-48 2xl:w-full']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'companies-filter-value','type' => 'text','placeholder' => 'Search...','class' => 'mt-2 w-full sm:mt-0 sm:w-48 2xl:w-full']); ?>
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
                                    Industry
                                </label>
                                <?php if (isset($component)) { $__componentOriginal1c0beb3cd2271cd34645d22f15db5e3a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1c0beb3cd2271cd34645d22f15db5e3a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-select.index','data' => ['id' => 'companies-filter-industry','class' => 'mt-2 w-full sm:mt-0 sm:w-auto']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'companies-filter-industry','class' => 'mt-2 w-full sm:mt-0 sm:w-auto']); ?>
                                    <option value="">All Industries</option>
                                    <?php $__currentLoopData = $industries ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $industry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($industry); ?>"><?php echo e($industry); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                    Status
                                </label>
                                <?php if (isset($component)) { $__componentOriginal1c0beb3cd2271cd34645d22f15db5e3a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1c0beb3cd2271cd34645d22f15db5e3a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-select.index','data' => ['id' => 'companies-filter-status','class' => 'mt-2 w-full sm:mt-0 sm:w-auto']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'companies-filter-status','class' => 'mt-2 w-full sm:mt-0 sm:w-auto']); ?>
                                    <option value="">All</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
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
                                    Show
                                </label>
                                <?php if (isset($component)) { $__componentOriginal1c0beb3cd2271cd34645d22f15db5e3a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1c0beb3cd2271cd34645d22f15db5e3a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-select.index','data' => ['id' => 'companies-filter-length','class' => 'mt-2 w-full sm:mt-0 sm:w-auto']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'companies-filter-length','class' => 'mt-2 w-full sm:mt-0 sm:w-auto']); ?>
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
                                    <button id="companies-filter-go" type="button" class="btn-royal btn-royal--dark btn-royal--sm w-full sm:w-24 group">
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
                                    <button id="companies-filter-reset" type="button" class="btn-royal btn-royal--outline btn-royal--sm w-full sm:w-24 group">
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
                                <button id="companies-export" type="button" class="btn-royal btn-royal--outline btn-royal--sm btn-tonal--icon group text-royalDark">
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
                                <button id="companies-refresh" type="button" class="btn-royal btn-royal--outline btn-royal--sm btn-tonal--icon group text-royalDark">
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.tippy.index','data' => ['content' => 'Add new company','placement' => 'bottom']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.tippy'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['content' => 'Add new company','placement' => 'bottom']); ?>
                                <button
                                    type="button"
                                    id="add-company-btn"
                                    class="btn-royal btn-royal--gold btn-royal--sm sm:btn-royal--lg group"
                                    data-tw-toggle="modal"
                                    data-tw-target="#create-company-modal"
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

                    <div class="overflow-x-auto sm:overflow-visible">
                        <table
                            id="companies-table"
                            data-tw-merge
                            data-erp-table
                            data-companies-datatable-url="<?php echo e(route('crm.companies.datatable')); ?>"
                            class="datatable-default w-full min-w-full table-auto text-left text-sm"
                        >
                            <thead>
                                <tr>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">#</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Name</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Industry</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Email</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Phone</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Contacts</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Leads</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Opportunities</th>
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

    <!-- Create Company Modal -->
    <?php if (isset($component)) { $__componentOriginal8ffb2951ef6cc6f4f3162130bd0a3e82 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8ffb2951ef6cc6f4f3162130bd0a3e82 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal.form','data' => ['id' => 'create-company-modal','title' => 'Add New Company','size' => 'xl']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal.form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'create-company-modal','title' => 'Add New Company','size' => 'xl']); ?>
        <form id="create-company-form">
            <?php echo csrf_field(); ?>

            <div class="mb-6">
                <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Building','class' => 'h-5 w-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Building','class' => 'h-5 w-5']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $attributes = $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $component = $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
                    Company Information
                </h4>

                <div class="grid grid-cols-12 gap-4 gap-y-4">
                    <div class="col-span-12 md:col-span-6">
                        <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'create-company-name']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'create-company-name']); ?>Company Name <span class="text-danger">*</span> <?php echo $__env->renderComponent(); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'create-company-name','name' => 'name','type' => 'text','class' => 'w-full','placeholder' => 'Enter company name','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'create-company-name','name' => 'name','type' => 'text','class' => 'w-full','placeholder' => 'Enter company name','required' => true]); ?>
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

                    <div class="col-span-12 md:col-span-6">
                        <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'create-company-industry']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'create-company-industry']); ?>Industry <?php echo $__env->renderComponent(); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'create-company-industry','name' => 'industry','type' => 'text','class' => 'w-full','placeholder' => 'e.g. Technology, Healthcare']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'create-company-industry','name' => 'industry','type' => 'text','class' => 'w-full','placeholder' => 'e.g. Technology, Healthcare']); ?>
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

                    <div class="col-span-12 md:col-span-6">
                        <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'create-company-email']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'create-company-email']); ?>Email Address <?php echo $__env->renderComponent(); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'create-company-email','name' => 'email','type' => 'email','class' => 'w-full','placeholder' => 'company@example.com']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'create-company-email','name' => 'email','type' => 'email','class' => 'w-full','placeholder' => 'company@example.com']); ?>
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

                    <div class="col-span-12 md:col-span-6">
                        <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'create-company-phone']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'create-company-phone']); ?>Phone Number <?php echo $__env->renderComponent(); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'create-company-phone','name' => 'phone','type' => 'text','class' => 'w-full','placeholder' => '+1 234 567 8900']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'create-company-phone','name' => 'phone','type' => 'text','class' => 'w-full','placeholder' => '+1 234 567 8900']); ?>
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

                    <div class="col-span-12 md:col-span-6">
                        <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'create-company-website']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'create-company-website']); ?>Website <?php echo $__env->renderComponent(); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'create-company-website','name' => 'website','type' => 'url','class' => 'w-full','placeholder' => 'https://example.com']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'create-company-website','name' => 'website','type' => 'url','class' => 'w-full','placeholder' => 'https://example.com']); ?>
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

                    <div class="col-span-12 md:col-span-6">
                        <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'create-company-status']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'create-company-status']); ?>Status <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $attributes = $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $component = $__componentOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal1c0beb3cd2271cd34645d22f15db5e3a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1c0beb3cd2271cd34645d22f15db5e3a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-select.index','data' => ['id' => 'create-company-status','name' => 'status','class' => 'w-full','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'create-company-status','name' => 'status','class' => 'w-full','required' => true]); ?>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
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

                    <div class="col-span-12 md:col-span-6">
                        <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'create-company-country']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'create-company-country']); ?>Country <?php echo $__env->renderComponent(); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'create-company-country','name' => 'country','type' => 'text','class' => 'w-full','placeholder' => 'Country']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'create-company-country','name' => 'country','type' => 'text','class' => 'w-full','placeholder' => 'Country']); ?>
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

                    <div class="col-span-12 md:col-span-6">
                        <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'create-company-city']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'create-company-city']); ?>City <?php echo $__env->renderComponent(); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'create-company-city','name' => 'city','type' => 'text','class' => 'w-full','placeholder' => 'City']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'create-company-city','name' => 'city','type' => 'text','class' => 'w-full','placeholder' => 'City']); ?>
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

                    <div class="col-span-12">
                        <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'create-company-address']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'create-company-address']); ?>Address <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $attributes = $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $component = $__componentOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal29dbcf960a4ade6d0a2b790c04ae12cf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal29dbcf960a4ade6d0a2b790c04ae12cf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-textarea.index','data' => ['id' => 'create-company-address','name' => 'address','class' => 'w-full','rows' => '3','placeholder' => 'Enter complete address']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'create-company-address','name' => 'address','class' => 'w-full','rows' => '3','placeholder' => 'Enter complete address']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal29dbcf960a4ade6d0a2b790c04ae12cf)): ?>
<?php $attributes = $__attributesOriginal29dbcf960a4ade6d0a2b790c04ae12cf; ?>
<?php unset($__attributesOriginal29dbcf960a4ade6d0a2b790c04ae12cf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal29dbcf960a4ade6d0a2b790c04ae12cf)): ?>
<?php $component = $__componentOriginal29dbcf960a4ade6d0a2b790c04ae12cf; ?>
<?php unset($__componentOriginal29dbcf960a4ade6d0a2b790c04ae12cf); ?>
<?php endif; ?>
                    </div>

                    <div class="col-span-12">
                        <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'create-company-notes']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'create-company-notes']); ?>Notes <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $attributes = $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $component = $__componentOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal29dbcf960a4ade6d0a2b790c04ae12cf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal29dbcf960a4ade6d0a2b790c04ae12cf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-textarea.index','data' => ['id' => 'create-company-notes','name' => 'notes','class' => 'w-full','rows' => '3','placeholder' => 'Additional notes or comments']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'create-company-notes','name' => 'notes','class' => 'w-full','rows' => '3','placeholder' => 'Additional notes or comments']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal29dbcf960a4ade6d0a2b790c04ae12cf)): ?>
<?php $attributes = $__attributesOriginal29dbcf960a4ade6d0a2b790c04ae12cf; ?>
<?php unset($__attributesOriginal29dbcf960a4ade6d0a2b790c04ae12cf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal29dbcf960a4ade6d0a2b790c04ae12cf)): ?>
<?php $component = $__componentOriginal29dbcf960a4ade6d0a2b790c04ae12cf; ?>
<?php unset($__componentOriginal29dbcf960a4ade6d0a2b790c04ae12cf); ?>
<?php endif; ?>
                    </div>
                </div>
            </div>
        </form>

        <?php $__env->slot('footer'); ?>
            <div class="custom-modal-footer">
                <button
                    type="button"
                    class="btn-royal btn-royal--outline group"
                    data-tw-dismiss="modal"
                >
                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'x-circle','class' => 'w-5 h-5 icon-hover-rise']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'x-circle','class' => 'w-5 h-5 icon-hover-rise']); ?>
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
                    Cancel
                </button>
                <button
                    type="submit"
                    form="create-company-form"
                    id="create-company-btn"
                    class="btn-royal btn-royal--dark group"
                >
                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'save','class' => 'w-5 h-5 icon-hover-rise']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'save','class' => 'w-5 h-5 icon-hover-rise']); ?>
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
                    Save Company
                </button>
            </div>
        <?php $__env->endSlot(); ?>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const jq = window.jQuery || window.$;
                if (!jq) {
                    console.error('jQuery not available for create company modal.');
                    return;
                }

                const $ = jq;
                const form = document.getElementById('create-company-form');
                const submitBtn = $('#create-company-btn');

                if (!form) {
                    return;
                }

                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    const formData = new FormData(form);
                    const originalText = submitBtn.html();

                    submitBtn.prop('disabled', true).html('<i class="w-4 h-4 mr-2 animate-spin" data-lucide="loader"></i> Saving...');

                    $.ajax({
                        url: '<?php echo e(route("crm.companies.store")); ?>',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                const modalEl = document.getElementById('create-company-modal');
                                if (modalEl && modalEl.__tippy?.hide) {
                                    modalEl.__tippy.hide();
                                }

                                form.reset();
                                if (window.companiesTable) {
                                    window.companiesTable.ajax.reload();
                                }

                                if (typeof window.showSuccess === 'function') {
                                    window.showSuccess(response.message || 'Company created successfully');
                                }
                            } else if (typeof window.showError === 'function') {
                                window.showError(response.message || 'Failed to create company.');
                            }
                        },
                        error: function(xhr) {
                            let errors = xhr.responseJSON?.errors || {};
                            let errorMessage = xhr.responseJSON?.message || 'An error occurred';

                            if (Object.keys(errors).length > 0) {
                                errorMessage = Object.values(errors).flat().join('\n');
                            }

                            if (typeof window.showError === 'function') {
                                window.showError(errorMessage);
                            }
                        },
                        complete: function() {
                            submitBtn.prop('disabled', false).html(originalText);
                            if (typeof lucide !== 'undefined' && typeof lucide.createIcons === 'function') {
                                lucide.createIcons();
                            }
                        }
                    });
                });
            });
        </script>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8ffb2951ef6cc6f4f3162130bd0a3e82)): ?>
<?php $attributes = $__attributesOriginal8ffb2951ef6cc6f4f3162130bd0a3e82; ?>
<?php unset($__attributesOriginal8ffb2951ef6cc6f4f3162130bd0a3e82); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8ffb2951ef6cc6f4f3162130bd0a3e82)): ?>
<?php $component = $__componentOriginal8ffb2951ef6cc6f4f3162130bd0a3e82; ?>
<?php unset($__componentOriginal8ffb2951ef6cc6f4f3162130bd0a3e82); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.datatable.scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>

    <script>
        let companiesTable;

        document.addEventListener('DOMContentLoaded', function () {
            console.log('DOM Content Loaded');

            // Wait for jQuery to be available
            if (typeof window.jQuery === 'undefined') {
                console.error('jQuery not available');
                setTimeout(function() {
                    initializeCompaniesTable();
                }, 1000);
            } else {
                const $ = window.jQuery;
                $(function () {
                    console.log('jQuery ready');
                    initializeCompaniesTable();
                });
            }
        });

        function initializeCompaniesTable() {
            if (!window.erpCrud || !window.erpCrud.initDataTable) {
                console.error('erpCrud not available');
                return;
            }

            companiesTable = window.erpCrud.initDataTable({
                tableSelector: '#companies-table',
                ajaxUrl: '<?php echo e(route("crm.companies.datatable")); ?>',
                ajaxData: function(d) {
                    d.field = $('#companies-filter-field').val();
                    d.type = $('#companies-filter-type').val();
                    d.value = $('#companies-filter-value').val();
                    d.industry = $('#companies-filter-industry').val();
                    d.status = $('#companies-filter-status').val();
                },
                pageLength: 25,
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center font-medium', orderable: false },
                    { data: 'name', name: 'name', className: 'px-5 py-3 border-b dark:border-darkmode-300 font-medium text-slate-700' },
                    { data: 'industry', name: 'industry', className: 'px-5 py-3 border-b dark:border-darkmode-300' },
                    { data: 'email', name: 'email', className: 'px-5 py-3 border-b dark:border-darkmode-300' },
                    { data: 'phone', name: 'phone', className: 'px-5 py-3 border-b dark:border-darkmode-300' },
                    { data: 'contacts_count', name: 'contacts_count', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center', orderable: false },
                    { data: 'leads_count', name: 'leads_count', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center', orderable: false },
                    { data: 'opportunities_count', name: 'opportunities_count', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center', orderable: false },
                    {
                        data: 'status',
                        name: 'status',
                        className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center',
                        orderable: false,
                        render: function(value) {
                            if (window.erpCrud && typeof window.erpCrud.renderStatusBadge === 'function') {
                                return window.erpCrud.renderStatusBadge(value === 'active');
                            }
                            const isActive = value === 'active';
                            const badgeClass = isActive ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700';
                            const label = isActive ? 'Active' : 'Inactive';
                            return `<span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ${badgeClass}">${label}</span>`;
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center',
                        orderable: false,
                        searchable: false
                    }
                ],
                drawCallback: function(settings) {
                    if (typeof window.Lucide !== 'undefined') {
                        window.Lucide.createIcons();
                    }
                }
            });

            window.companiesTable = companiesTable;

            // Setup filter buttons
            $('#companies-filter-go').on('click', function() {
                companiesTable.ajax.reload();
            });

            $('#companies-filter-reset').on('click', function() {
                $('#companies-filter-field').val('all');
                $('#companies-filter-type').val('contains');
                $('#companies-filter-value').val('');
                $('#companies-filter-industry').val('');
                $('#companies-filter-status').val('');
                companiesTable.ajax.reload();
            });

            $('#companies-refresh').on('click', function() {
                companiesTable.ajax.reload();
            });

            $('#companies-filter-length').on('change', function() {
                companiesTable.page.len($(this).val()).draw();
            });
        }

        function viewCompany(id) {
            Swal.fire({
                title: 'View Company',
                text: 'View functionality will be implemented soon',
                icon: 'info'
            });
        }

        function editCompany(id) {
            Swal.fire({
                title: 'Edit Company',
                text: 'Edit functionality will be implemented soon',
                icon: 'info'
            });
        }

        function deleteCompany(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const jq = window.jQuery || window.$;
                    if (!jq) return;

                    jq.ajax({
                        url: '<?php echo e(route("crm.companies.destroy", ":id")); ?>'.replace(':id', id),
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': jq('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire('Deleted!', response.message, 'success');
                                if (companiesTable) {
                                    companiesTable.ajax.reload();
                                }
                            }
                        },
                        error: function(xhr) {
                            Swal.fire('Error!', xhr.responseJSON?.message || 'Failed to delete', 'error');
                        }
                    });
                }
            });
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('../themes/' . $activeTheme . '/' . $activeLayout, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\smart-erp\resources\views/crm/companies/index.blade.php ENDPATH**/ ?>
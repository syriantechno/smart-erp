<?php $__env->startSection('subhead'); ?>
    <title>Employees Management - <?php echo e(config('app.name')); ?></title>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.datatable.styles', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.datatable.theme', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        /* Make employees table rows more compact */
        #employees-table tbody tr {
            height: 2.25rem; /* ~36px */
        }

        #employees-table td {
            padding-top: 0.375rem;  /* 6px */
            padding-bottom: 0.375rem;
        }

        .btn-tonal {
            --btn-surface: color-mix(in oklch, var(--color-primary, #2563eb) 20%, #ffffff);
            --btn-border: color-mix(in oklch, var(--color-primary, #2563eb), transparent 80%);
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.5rem 1.15rem;
            border-radius: 9999px;
            border: 1px solid var(--btn-border);
            background-color: var(--btn-surface);
            color: color-mix(in oklch, var(--color-primary, #2563eb), black 20%);
            font-weight: 600;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.08);
        }

        .btn-tonal:hover {
            transform: translateY(-1px) scale(1.02);
            box-shadow: 0 15px 25px rgba(37, 99, 235, 0.12);
        }

        .btn-tonal:focus-visible {
            outline: 2px solid color-mix(in oklch, var(--color-primary, #2563eb), transparent 60%);
            outline-offset: 3px;
        }

        .btn-tonal svg {
            color: color-mix(in oklch, var(--color-primary, #2563eb), black 10%);
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('subcontent'); ?>
    <?php echo $__env->make('components.global-notifications', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Employees Management</h2>
        <div class="flex items-center gap-2">
            <button
                type="button"
                class="btn-tonal btn-tonal--info hidden sm:flex"
                data-tw-toggle="modal"
                data-tw-target="#employees-filters-slideover"
            >
                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Filter','class' => 'w-4 h-4 mr-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Filter','class' => 'w-4 h-4 mr-2']); ?>
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
                Filters
                <span id="active-filters-indicator" class="hidden ml-2 px-2 py-0.5 text-xs bg-blue-100 text-blue-700 rounded-full">Active</span>
            </button>

            <!-- Mobile filters icon -->
            <button
                type="button"
                class="flex items-center justify-center rounded-full border border-slate-200 px-3 py-2 text-slate-600 hover:bg-slate-50 sm:hidden"
                data-tw-toggle="modal"
                data-tw-target="#employees-filters-slideover"
                title="Filters"
            >
                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Filter','class' => 'w-4 h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Filter','class' => 'w-4 h-4']); ?>
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

            <button
                type="button"
                class="btn-tonal btn-tonal--success"
                data-tw-toggle="modal"
                data-tw-target="#create-employee-modal"
            >
                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'UserPlus','class' => 'w-4 h-4 mr-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'UserPlus','class' => 'w-4 h-4 mr-2']); ?>
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
                Add Employee
            </button>
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
                        <form id="employees-filter-form" class="w-full sm:mr-auto xl:flex">
                            <div class="items-center sm:mr-4 sm:flex">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Field
                                </label>
                                <?php if (isset($component)) { $__componentOriginal1c0beb3cd2271cd34645d22f15db5e3a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1c0beb3cd2271cd34645d22f15db5e3a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-select.index','data' => ['id' => 'employees-filter-field','class' => 'mt-2 w-full sm:mt-0 sm:w-auto 2xl:w-full']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'employees-filter-field','class' => 'mt-2 w-full sm:mt-0 sm:w-auto 2xl:w-full']); ?>
                                    <option value="all">All Fields</option>
                                    <option value="code">Code</option>
                                    <option value="first_name">First Name</option>
                                    <option value="last_name">Last Name</option>
                                    <option value="email">Email</option>
                                    <option value="position">Position</option>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-select.index','data' => ['id' => 'employees-filter-type','class' => 'mt-2 w-full sm:mt-0 sm:w-auto']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'employees-filter-type','class' => 'mt-2 w-full sm:mt-0 sm:w-auto']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'employees-filter-value','type' => 'text','placeholder' => 'Search...','class' => 'mt-2 w-full sm:mt-0 sm:w-48 2xl:w-full']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'employees-filter-value','type' => 'text','placeholder' => 'Search...','class' => 'mt-2 w-full sm:mt-0 sm:w-48 2xl:w-full']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-select.index','data' => ['id' => 'employees-filter-length','class' => 'mt-2 w-full sm:mt-0 sm:w-auto']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'employees-filter-length','class' => 'mt-2 w-full sm:mt-0 sm:w-auto']); ?>
                                    <option value="10">10</option>
                                    <option value="25">25</option>
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
                            <div class="mt-2 flex flex-wrap gap-2 xl:mt-0">
                                <button id="employees-filter-go" type="button" class="btn-tonal btn-tonal--info">
                                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Search','class' => 'w-4 h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Search','class' => 'w-4 h-4']); ?>
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
                                <button id="employees-filter-reset" type="button" class="btn-tonal btn-tonal--warning">
                                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'RotateCcw','class' => 'w-4 h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'RotateCcw','class' => 'w-4 h-4']); ?>
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
                            </div>
                        </form>

                        <div class="mt-5 flex items-center gap-2 sm:mt-0">
                            <button id="employees-export" type="button"
                                class="btn-tonal btn-tonal--info btn-tonal--icon">
                                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Download','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Download','class' => 'h-4 w-4']); ?>
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
                            <button id="employees-refresh" type="button"
                                class="btn-tonal btn-tonal--success btn-tonal--icon">
                                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'RefreshCcw','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'RefreshCcw','class' => 'h-4 w-4']); ?>
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
                        </div>
                    </div>

                    <div class="overflow-x-auto sm:overflow-visible" data-erp-table-wrapper>
                        <table id="employees-table" data-tw-merge data-erp-table class="datatable-default w-full min-w-full table-auto text-left text-sm">
                            <thead>
                                <tr>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">#</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Code</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Photo</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Full Name</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Department / Position</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Email</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Status</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Actions</th>
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

    <!-- Employees Filters Slide Over -->
    <?php if (isset($component)) { $__componentOriginal7b984b2f83e0e1ed46be48207486a493 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7b984b2f83e0e1ed46be48207486a493 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.slideover.index','data' => ['id' => 'employees-filters-slideover','size' => 'md']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.slideover'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'employees-filters-slideover','size' => 'md']); ?>
        <?php if (isset($component)) { $__componentOriginalbf24d1b6c00bc08aa4e052383ee60570 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbf24d1b6c00bc08aa4e052383ee60570 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.slideover.panel','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.slideover.panel'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
            <a
                class="absolute top-0 left-0 right-auto mt-4 -ml-10 sm:-ml-12"
                data-tw-dismiss="modal"
                href="#"
            >
                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['class' => 'h-8 w-8 text-slate-400','icon' => 'X']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-8 w-8 text-slate-400','icon' => 'X']); ?>
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
            </a>
            <?php if (isset($component)) { $__componentOriginala9479a745407756aa806bba6e780c74f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala9479a745407756aa806bba6e780c74f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.slideover.title','data' => ['class' => 'border-b border-slate-200/60 p-5 dark:border-darkmode-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.slideover.title'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'border-b border-slate-200/60 p-5 dark:border-darkmode-400']); ?>
                <h2 class="mr-auto text-base font-medium flex items-center gap-2">
                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Filter','class' => 'h-5 w-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Filter','class' => 'h-5 w-5']); ?>
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
                    Employees Filters
                </h2>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala9479a745407756aa806bba6e780c74f)): ?>
<?php $attributes = $__attributesOriginala9479a745407756aa806bba6e780c74f; ?>
<?php unset($__attributesOriginala9479a745407756aa806bba6e780c74f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala9479a745407756aa806bba6e780c74f)): ?>
<?php $component = $__componentOriginala9479a745407756aa806bba6e780c74f; ?>
<?php unset($__componentOriginala9479a745407756aa806bba6e780c74f); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginal52a8e2b085d6c4797e2849447438b96c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal52a8e2b085d6c4797e2849447438b96c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.slideover.description','data' => ['class' => 'p-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.slideover.description'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'p-5']); ?>
                <div class="mb-4 text-sm text-slate-600 dark:text-slate-400">
                    Use these filters to narrow down the employees list. Click "Apply Filters" to update the table.
                </div>

                <div class="grid grid-cols-12 gap-4">
                    <!-- Company Filter -->
                    <div class="col-span-12">
                        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                            Filter by Company
                        </label>
                        <?php if (isset($component)) { $__componentOriginal1c0beb3cd2271cd34645d22f15db5e3a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1c0beb3cd2271cd34645d22f15db5e3a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-select.index','data' => ['id' => 'company-filter','class' => 'w-full']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'company-filter','class' => 'w-full']); ?>
                            <option value="">All Companies</option>
                            <?php $__currentLoopData = $companies ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($company->id); ?>"><?php echo e($company->name); ?></option>
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

                    <!-- Department Filter -->
                    <div class="col-span-12">
                        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                            Filter by Department
                        </label>
                        <?php if (isset($component)) { $__componentOriginal1c0beb3cd2271cd34645d22f15db5e3a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1c0beb3cd2271cd34645d22f15db5e3a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-select.index','data' => ['id' => 'department-filter','class' => 'w-full']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'department-filter','class' => 'w-full']); ?>
                            <option value="">All Departments</option>
                            <?php $__currentLoopData = $departments ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($department->id); ?>"><?php echo e($department->name); ?></option>
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

                    <!-- Position Filter -->
                    <div class="col-span-12">
                        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                            Filter by Position
                        </label>
                        <?php if (isset($component)) { $__componentOriginal1c0beb3cd2271cd34645d22f15db5e3a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1c0beb3cd2271cd34645d22f15db5e3a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-select.index','data' => ['id' => 'position-filter','class' => 'w-full']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'position-filter','class' => 'w-full']); ?>
                            <option value="">All Positions</option>
                            <!-- Will be populated via JavaScript -->
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
                </div>

                <!-- Filter Results Summary & Actions -->
                <div class="mt-5 rounded-lg bg-slate-50 p-4 dark:bg-darkmode-600">
                    <div class="flex flex-col gap-3">
                        <div class="flex flex-wrap items-center gap-4">
                            <div class="text-sm text-slate-600 dark:text-slate-400">
                                <span class="font-medium">Total Employees:</span>
                                <span id="total-employees-count" class="font-semibold text-slate-800">0</span>
                            </div>
                            <div class="text-sm text-slate-600 dark:text-slate-400">
                                <span class="font-medium">Filtered:</span>
                                <span id="filtered-employees-count" class="font-semibold text-blue-600">0</span>
                            </div>
                        </div>

                        <div class="mt-2 flex justify-end gap-2">
                            <button
                                type="button"
                                class="btn-tonal btn-tonal--warning w-28"
                                data-tw-dismiss="modal"
                            >
                                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'X','class' => 'mr-2 h-4 w-4 animate-pulse']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'X','class' => 'mr-2 h-4 w-4 animate-pulse']); ?>
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
                                Close
                            </button>
                            <button
                                id="advanced-filter-apply"
                                type="button"
                                class="btn-tonal btn-tonal--info w-28"
                            >
                                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Search','class' => 'mr-2 h-4 w-4 animate-pulse']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Search','class' => 'mr-2 h-4 w-4 animate-pulse']); ?>
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
                                Apply
                            </button>
                        </div>
                    </div>
                </div>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal52a8e2b085d6c4797e2849447438b96c)): ?>
<?php $attributes = $__attributesOriginal52a8e2b085d6c4797e2849447438b96c; ?>
<?php unset($__attributesOriginal52a8e2b085d6c4797e2849447438b96c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal52a8e2b085d6c4797e2849447438b96c)): ?>
<?php $component = $__componentOriginal52a8e2b085d6c4797e2849447438b96c; ?>
<?php unset($__componentOriginal52a8e2b085d6c4797e2849447438b96c); ?>
<?php endif; ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbf24d1b6c00bc08aa4e052383ee60570)): ?>
<?php $attributes = $__attributesOriginalbf24d1b6c00bc08aa4e052383ee60570; ?>
<?php unset($__attributesOriginalbf24d1b6c00bc08aa4e052383ee60570); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbf24d1b6c00bc08aa4e052383ee60570)): ?>
<?php $component = $__componentOriginalbf24d1b6c00bc08aa4e052383ee60570; ?>
<?php unset($__componentOriginalbf24d1b6c00bc08aa4e052383ee60570); ?>
<?php endif; ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7b984b2f83e0e1ed46be48207486a493)): ?>
<?php $attributes = $__attributesOriginal7b984b2f83e0e1ed46be48207486a493; ?>
<?php unset($__attributesOriginal7b984b2f83e0e1ed46be48207486a493); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7b984b2f83e0e1ed46be48207486a493)): ?>
<?php $component = $__componentOriginal7b984b2f83e0e1ed46be48207486a493; ?>
<?php unset($__componentOriginal7b984b2f83e0e1ed46be48207486a493); ?>
<?php endif; ?>

    <?php echo $__env->make('hr.employees.modals.create', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('hr.employees.modals.edit', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->yieldPushContent('modals'); ?>

    <!-- Hidden button to trigger edit modal -->
    <button id="edit-employee-trigger" data-tw-toggle="modal" data-tw-target="#edit-employee-modal" class="hidden"></button>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.datatable.scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
            const filterField = document.getElementById('employees-filter-field');
            const filterType = document.getElementById('employees-filter-type');
            const filterValue = document.getElementById('employees-filter-value');
            const lengthSelect = document.getElementById('employees-filter-length');
            const filterGoBtn = document.getElementById('employees-filter-go');
            const filterResetBtn = document.getElementById('employees-filter-reset');
            const exportBtn = document.getElementById('employees-export');
            const refreshBtn = document.getElementById('employees-refresh');

            // Advanced filters
            const companyFilter = document.getElementById('company-filter');
            const departmentFilter = document.getElementById('department-filter');
            const positionFilter = document.getElementById('position-filter');
            const advancedFilterApplyBtn = document.getElementById('advanced-filter-apply');
            const totalEmployeesCount = document.getElementById('total-employees-count');
            const filteredEmployeesCount = document.getElementById('filtered-employees-count');

            const initialLength = lengthSelect ? parseInt(lengthSelect.value, 10) || 10 : 10;

            const table = (window.erpCrud && window.erpCrud.initDataTable) ? window.erpCrud.initDataTable({
                tableSelector: '#employees-table',
                ajaxUrl: '<?php echo e(route("hr.employees.datatable")); ?>',
                ajaxData: function (d) {
                    if (filterField) {
                        d.filter_field = filterField.value || 'all';
                    }
                    if (filterType) {
                        d.filter_type = filterType.value || 'contains';
                    }
                    if (filterValue) {
                        d.filter_value = filterValue.value || '';
                    }
                    if (companyFilter) {
                        d.company_id = companyFilter.value || '';
                    }
                    if (departmentFilter) {
                        d.department_id = departmentFilter.value || '';
                    }
                    if (positionFilter) {
                        d.position_filter = positionFilter.value || '';
                    }
                    d.page_length = lengthSelect ? parseInt(lengthSelect.value, 10) || initialLength : initialLength;
                },
                pageLength: initialLength,
                order: [[1, 'asc']],
                dom: "t<'datatable-footer flex flex-col md:flex-row md:items-center md:justify-between mt-5 gap-4'<'datatable-info text-slate-500'i><'datatable-pagination'p>>",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center font-medium', orderable: false },
                    { data: 'code', name: 'code', className: 'px-5 py-3 border-b dark:border-darkmode-300 font-medium text-slate-700 whitespace-nowrap' },
                    { data: 'profile_picture', name: 'profile_picture', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center', orderable: false },
                    { data: 'full_name', name: 'full_name', className: 'px-5 py-3 border-b dark:border-darkmode-300 font-medium text-slate-700 datatable-cell-wrap' },
                    { data: 'department_name', name: 'department_name', className: 'px-5 py-3 border-b dark:border-darkmode-300 datatable-cell-wrap' },
                    { data: 'email', name: 'email', className: 'px-5 py-3 border-b dark:border-darkmode-300 datatable-cell-wrap' },
                    {
                        data: 'is_active',
                        name: 'is_active',
                        className: 'text-center',
                        title: 'Status',
                        render: function (value) {
                            if (window.erpCrud && typeof window.erpCrud.renderStatusBadge === 'function') {
                                return window.erpCrud.renderStatusBadge(value);
                            }
                            return value ? 'Active' : 'Inactive';
                        }
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center',
                        orderable: false,
                        searchable: false
                    }
                ],
                drawCallback: function (settings) {
                    if (typeof window.Lucide !== 'undefined') {
                        window.Lucide.createIcons();
                    }

                    const info = settings.api().page.info();
                    if (totalEmployeesCount) {
                        totalEmployeesCount.textContent = info.recordsTotal;
                    }
                    if (filteredEmployeesCount) {
                        filteredEmployeesCount.textContent = info.recordsDisplay;
                    }

                    const hasFilters = (companyFilter && companyFilter.value) ||
                                      (departmentFilter && departmentFilter.value) ||
                                      (positionFilter && positionFilter.value);

                    if (hasFilters && info.recordsTotal !== info.recordsDisplay && typeof window.showToast === 'function') {
                        window.showToast(`Filtered ${info.recordsDisplay} out of ${info.recordsTotal} employees`, 'success');
                    }

                    const activeFiltersIndicator = document.getElementById('active-filters-indicator');
                    if (activeFiltersIndicator) {
                        activeFiltersIndicator.classList.toggle('hidden', !hasFilters);
                    }
                }
            }) : null;

            if (!table) {
                return;
            }

            if (lengthSelect) {
                lengthSelect.addEventListener('change', function () {
                    const newLength = parseInt(this.value, 10) || initialLength;
                    table.page.len(newLength).draw();
                });
            }

            const reloadTable = function () {
                table.ajax.reload(null, false);
            };

            if (filterGoBtn) {
                filterGoBtn.addEventListener('click', reloadTable);
            }

            if (filterValue) {
                filterValue.addEventListener('keyup', function (event) {
                    if (event.key === 'Enter') {
                        reloadTable();
                    }
                });
            }

            if (filterResetBtn) {
                filterResetBtn.addEventListener('click', function () {
                    if (filterField) {
                        filterField.value = 'all';
                    }
                    if (filterType) {
                        filterType.value = 'contains';
                    }
                    if (filterValue) {
                        filterValue.value = '';
                    }
                    if (lengthSelect) {
                        lengthSelect.value = String(initialLength);
                        table.page.len(initialLength).draw();
                    }
                    // Reset advanced filters
                    if (companyFilter) {
                        companyFilter.value = '';
                    }
                    if (departmentFilter) {
                        departmentFilter.value = '';
                    }
                    if (positionFilter) {
                        positionFilter.value = '';
                        loadPositionsForDepartment(''); // Reset positions
                    }
                    reloadTable();
                });
            }

            if (refreshBtn) {
                refreshBtn.addEventListener('click', reloadTable);
            }

            // Advanced filters event listeners
            if (advancedFilterApplyBtn) {
                advancedFilterApplyBtn.addEventListener('click', reloadTable);
            }

            // Auto-apply filters when changed
            if (companyFilter) {
                companyFilter.addEventListener('change', function() {
                    // Reset department filter when company changes
                    if (departmentFilter) {
                        departmentFilter.value = '';
                        // Load departments for selected company
                        loadDepartmentsForCompany(this.value);
                    }
                    setTimeout(reloadTable, 300);
                });
            }

            if (departmentFilter) {
                departmentFilter.addEventListener('change', function() {
                    loadPositionsForDepartment(this.value);
                    setTimeout(reloadTable, 300);
                });
            }

            if (positionFilter) {
                positionFilter.addEventListener('change', function() {
                    setTimeout(reloadTable, 300);
                });
            }

            // Function to load departments based on company
            function loadDepartmentsForCompany(companyId) {
                if (!departmentFilter) return;

                departmentFilter.innerHTML = '<option value="">Loading departments...</option>';

                if (!companyId) {
                    departmentFilter.innerHTML = '<option value="">All Departments</option>';
                    // Add all departments back
                    <?php $__currentLoopData = $departments ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        departmentFilter.innerHTML += '<option value="<?php echo e($department->id); ?>"><?php echo e($department->name); ?></option>';
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    loadPositionsForDepartment(''); // Reset positions
                    return;
                }

                fetch(`/hr/departments/api/company/${companyId}`, {
                    credentials: 'same-origin',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                    }
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        departmentFilter.innerHTML = '<option value="">All Departments</option>';
                        if (data && Array.isArray(data)) {
                            data.forEach(dept => {
                                const option = document.createElement('option');
                                option.value = dept.id;
                                option.textContent = dept.name;
                                departmentFilter.appendChild(option);
                            });
                        }
                        loadPositionsForDepartment(''); // Reset positions when company changes
                    })
                    .catch(() => {
                        departmentFilter.innerHTML = '<option value="">Error loading departments</option>';
                    });
            }

            // Function to load positions based on department
            function loadPositionsForDepartment(departmentId) {
                if (!positionFilter) return;

                positionFilter.innerHTML = '<option value="">Loading positions...</option>';

                const url = departmentId 
                    ? `/hr/employees/positions/department?department_id=${departmentId}`
                    : '/hr/employees/positions/department';

                fetch(url, {
                    credentials: 'same-origin',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                    }
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        positionFilter.innerHTML = '<option value="">All Positions</option>';
                        if (data && Array.isArray(data)) {
                            data.forEach(position => {
                                const option = document.createElement('option');
                                option.value = position;
                                option.textContent = position;
                                positionFilter.appendChild(option);
                            });
                        }
                    })
                    .catch(() => {
                        positionFilter.innerHTML = '<option value="">Error loading positions</option>';
                    });
            }

            // Employee code preview
            const refreshEmployeeCode = function () {
                const codePreview = document.getElementById('employee-code-preview');
                const codeInput = document.getElementById('code');
                if (!codePreview) return;

                fetch('<?php echo e(route("hr.employees.preview-code")); ?>')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to preview employee code');
                        }
                        return response.json();
                    })
                    .then(data => {
                        const code = data.code || '-';
                        codePreview.textContent = code;
                        // Also update the form input if it exists
                        if (codeInput) {
                            codeInput.value = code;
                        }
                    })
                    .catch(() => {
                        codePreview.textContent = '-';
                        if (codeInput) {
                            codeInput.value = '-';
                        }
                    });
            };
            // Image preview functionality
            const profilePictureInput = document.getElementById('profile_picture');
            const imagePreviewContainer = document.getElementById('image-preview-container');
            const imagePreview = document.getElementById('image-preview');
            const removeImageBtn = document.getElementById('remove-image');

            if (profilePictureInput) {
                profilePictureInput.addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            imagePreview.src = e.target.result;
                            imagePreviewContainer.classList.remove('hidden');
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            if (removeImageBtn) {
                removeImageBtn.addEventListener('click', function() {
                    profilePictureInput.value = '';
                    imagePreview.src = '';
                    imagePreviewContainer.classList.add('hidden');
                });
            }

            // Dynamic department and position loading - handled in modal
            // Removed to avoid conflicts with modal's own JavaScript

            // Use shared CRUD helper for create form
            if (window.erpCrud) {
                window.erpCrud.handleCreateForm({
                    formSelector: '#create-employee-form',
                    modalSelector: '#create-employee-modal',
                    onSuccess: function () {
                        reloadTable();
                    },
                });
            }

            if (exportBtn) {
                exportBtn.addEventListener('click', function () {
                    try {
                        const rows = table.rows({ search: 'applied' }).data().toArray();
                        if (!rows.length) {
                            showToast('No data available for export.', 'error');
                            return;
                        }

                        const headers = ['#', 'Code', 'Photo', 'Full Name', 'Department / Position', 'Email', 'Status'];
                        const csvRows = [headers.join(',')];

                        rows.forEach(function (row) {
                            const csvRow = [
                                row.DT_RowIndex,
                                '"' + (row.code || '').replace(/"/g, '""') + '"',
                                row.profile_picture ? 'Yes' : 'No', // Photo indicator
                                '"' + (row.full_name || '').replace(/"/g, '""') + '"',
                                '"' + (row.department_name || '').replace(/"/g, '""') + '"',
                                '"' + (row.email || '').replace(/"/g, '""') + '"',
                                row.is_active ? 'Active' : 'Inactive'
                            ];
                            csvRows.push(csvRow.join(','));
                        });

                        const blob = new Blob([csvRows.join('\n')], { type: 'text/csv;charset=utf-8;' });
                        const url = URL.createObjectURL(blob);
                        const link = document.createElement('a');
                        link.href = url;
                        link.download = 'employees.csv';
                        link.click();
                        URL.revokeObjectURL(url);
                        showToast('Export completed successfully.', 'success');
                    } catch (error) {
                        showToast('Failed to export data.', 'error');
                    }
                });
            }

            document.addEventListener('hidden.tw.modal', function () {
                if (document.activeElement && typeof document.activeElement.blur === 'function') {
                    document.activeElement.blur();
                }
                table.ajax.reload(null, false);
            });

            // Initialize positions on page load
            loadPositionsForDepartment('');

            window.openEditModal = function(id, employeeId, firstName, lastName, email, phone, position, salary, hireDate, birthDate, gender, address, city, country, postalCode, departmentId, companyId, isActive) {
                // Populate form fields
                document.getElementById('edit-employee-id').value = employeeId || '';
                document.getElementById('edit-first-name').value = firstName || '';
                document.getElementById('edit-last-name').value = lastName || '';
                document.getElementById('edit-email').value = email || '';
                document.getElementById('edit-phone').value = phone || '';
                document.getElementById('edit-position').value = position || '';
                document.getElementById('edit-salary').value = salary || '';
                document.getElementById('edit-hire-date').value = hireDate || '';
                document.getElementById('edit-birth-date').value = birthDate || '';
                document.getElementById('edit-gender').value = gender || '';
                document.getElementById('edit-address').value = address || '';
                document.getElementById('edit-city').value = city || '';
                document.getElementById('edit-country').value = country || '';
                document.getElementById('edit-postal-code').value = postalCode || '';
                document.getElementById('edit-department_id').value = departmentId || '';
                document.getElementById('edit-company_id').value = companyId || '';
                document.getElementById('edit-is_active').checked = isActive;

                // Update form action
                const form = document.getElementById('edit-employee-form');
                form.action = `/hr/employees/${id}`;

                // Show modal using the hidden trigger button
                const modalTrigger = document.getElementById('edit-employee-trigger');
                if (modalTrigger) {
                    modalTrigger.click();
                }
            };

            // Use shared CRUD helper for edit form
            if (window.erpCrud) {
                window.erpCrud.handleEditForm({
                    formSelector: '#edit-employee-form',
                    modalSelector: '#edit-employee-modal',
                    onSuccess: function () {
                        reloadTable();
                    },
                });
            }

            // Use shared CRUD helper for delete, but expose as deleteEmployee
            if (window.erpCrud) {
                window.erpCrud.handleDelete({
                    urlBuilder: function (id) {
                        return `<?php echo e(route('hr.employees.destroy', '')); ?>/${id}`;
                    },
                    onSuccess: function () {
                        reloadTable();
                    },
                });

                // Keep backwards-compatible function name used in Blade actions
                window.deleteEmployee = function (id, name) {
                    if (typeof window.erpDeleteRecord === 'function') {
                        window.erpDeleteRecord(id, name);
                    }
                };
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('../themes/' . $activeTheme . '/' . $activeLayout, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\smart-erp\resources\views/hr/employees/index.blade.php ENDPATH**/ ?>
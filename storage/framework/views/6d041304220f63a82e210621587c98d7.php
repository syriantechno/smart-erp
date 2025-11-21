<?php $__env->startSection('subhead'); ?>
    <title>Materials Management - <?php echo e(config('app.name')); ?></title>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.datatable.styles', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.datatable.theme', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('subcontent'); ?>
    <?php echo $__env->make('components.global-notifications', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Materials Management</h2>
        <div class="flex items-center gap-2">
            <button
                type="button"
                class="btn-tonal btn-tonal--info hidden sm:flex group"
                data-tw-toggle="modal"
                data-tw-target="#materials-filters-slideover"
            >
                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'filter','class' => 'w-4 h-4 icon-hover-rise']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'filter','class' => 'w-4 h-4 icon-hover-rise']); ?>
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
                <span id="active-filters-indicator" class="hidden ml-2 px-2 py-0.5 text-xs bg-white/20 rounded-full">Active</span>
            </button>

            <!-- Mobile filters icon -->
            <button
                type="button"
                class="btn-tonal btn-tonal--info btn-tonal--icon sm:hidden"
                data-tw-toggle="modal"
                data-tw-target="#materials-filters-slideover"
                title="Filters"
            >
                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'filter','class' => 'w-4 h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'filter','class' => 'w-4 h-4']); ?>
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
                id="open-create-material-modal"
                class="btn-tonal btn-tonal--success w-32 sm:w-auto sm:ml-2 group"
                data-tw-toggle="modal"
                data-tw-target="#create-material-modal"
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
                Add Material
            </button>
        </div>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <!-- Materials Table -->
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
                    <div class="overflow-x-auto sm:overflow-visible" data-erp-table-wrapper>
                        <table
                            id="materials-table"
                            data-tw-merge
                            data-erp-table
                            class="datatable-default w-full min-w-full table-auto text-left text-sm"
                        >
                            <thead>
                                <tr>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Code</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Name</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Category</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Unit</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Price</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Status</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Actions</th>
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

    <!-- Materials Filters Slide Over -->
    <?php if (isset($component)) { $__componentOriginal7b984b2f83e0e1ed46be48207486a493 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7b984b2f83e0e1ed46be48207486a493 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.slideover.index','data' => ['id' => 'materials-filters-slideover','size' => 'md']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.slideover'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'materials-filters-slideover','size' => 'md']); ?>
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
                    Materials Filters
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
                    Use these filters to narrow down the materials list. Click "Apply" to update the table.
                </div>

                <div class="grid grid-cols-12 gap-4">
                    <!-- Category Filter -->
                    <div class="col-span-12">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Filter by Category
                        </label>
                        <?php if (isset($component)) { $__componentOriginal1c0beb3cd2271cd34645d22f15db5e3a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1c0beb3cd2271cd34645d22f15db5e3a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-select.index','data' => ['id' => 'category-filter','class' => 'w-full']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'category-filter','class' => 'w-full']); ?>
                            <option value="">All Categories</option>
                            <?php $__currentLoopData = $categories ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
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

                    <!-- Status Filter -->
                    <div class="col-span-12">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Status
                        </label>
                        <?php if (isset($component)) { $__componentOriginal1c0beb3cd2271cd34645d22f15db5e3a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1c0beb3cd2271cd34645d22f15db5e3a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-select.index','data' => ['id' => 'status-filter','class' => 'w-full']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'status-filter','class' => 'w-full']); ?>
                            <option value="">All Status</option>
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

                    <!-- Search Filter -->
                    <div class="col-span-12">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Search
                        </label>
                        <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'search-filter','type' => 'text','placeholder' => 'Search materials...','class' => 'w-full']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'search-filter','type' => 'text','placeholder' => 'Search materials...','class' => 'w-full']); ?>
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
                </div>

                <div class="mt-5 flex justify-end gap-2 flex-wrap">
                    <button
                        type="button"
                        class="btn-tonal btn-tonal--amber w-full sm:w-auto group"
                        onclick="clearFilters()"
                    >
                        <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'rotate-ccw','class' => 'mr-2 h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'rotate-ccw','class' => 'mr-2 h-4 w-4']); ?>
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
                        Clear
                    </button>
                    <button
                        id="materials-filter-apply"
                        type="button"
                        class="btn-tonal btn-tonal--info w-full sm:w-auto group"
                        onclick="applyFilters()"
                    >
                        <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'search','class' => 'mr-2 h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'search','class' => 'mr-2 h-4 w-4']); ?>
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

    <!-- Create Material Modal -->
    <?php echo $__env->make('warehouse.materials.modals.create', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Edit Material Modal -->
    <?php echo $__env->make('warehouse.materials.modals.edit', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Hidden button to trigger edit material modal -->
    <button id="edit-material-trigger" data-tw-toggle="modal" data-tw-target="#edit-material-modal" class="hidden"></button>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.datatable.scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>

    <script>
        let materialsTable;
        const unitStoreUrl = '<?php echo e(route("warehouse.measurement-units.store")); ?>';

        document.addEventListener('DOMContentLoaded', function () {
            const jq = window.jQuery || window.$;
            if (!jq) {
                console.error('jQuery not available on materials page.');
                return;
            }

            jq(function () {
                initializeDataTable();
                setupEventListeners();
                initUnitQuickAdd();

                // Auto-generate material code when opening create modal (unified code system)
                const openBtn = document.getElementById('open-create-material-modal');
                if (openBtn) {
                    openBtn.addEventListener('click', function () {
                        const $ = jq;
                        const codeInput = document.getElementById('create-code');
                        if (!codeInput) {
                            return;
                        }

                        $.get('<?php echo e(route("warehouse.materials.preview-code")); ?>')
                            .done(function (response) {
                                if (response && response.code) {
                                    codeInput.value = response.code;
                                }
                            });
                    });
                }
            });
        });

        function initializeDataTable() {
            materialsTable = window.erpCrud.initDataTable({
                tableSelector: '#materials-table',
                ajaxUrl: '<?php echo e(route("warehouse.materials.datatable")); ?>',
                ajaxData: function(d) {
                    d.category_id = $('#category-filter').val();
                    d.status = $('#status-filter').val();
                    d.filter_value = $('#search-filter').val();
                    d.filter_field = 'all';
                    d.filter_type = 'contains';
                },
                columns: [
                    { data: 'code', name: 'code' },
                    { data: 'name', name: 'name' },
                    { data: 'category_name', name: 'category_name' },
                    { data: 'unit_name', name: 'unit_name' },
                    { data: 'price', name: 'price', render: function(data) { return '<?php echo e(config("app.currency", "$")); ?>' + parseFloat(data).toFixed(2); } },
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
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ],
                pageLength: 25,
                drawCallback: function () {
                    if (typeof window.Lucide !== 'undefined') {
                        window.Lucide.createIcons();
                    } else if (typeof lucide !== 'undefined' && typeof lucide.createIcons === 'function') {
                        lucide.createIcons();
                    }
                }
            });

            // Make table instance globally accessible for modals
            window.materialsTable = materialsTable;
        }

        function setupEventListeners() {
            // Enter key on search filter
            $('#search-filter').on('keypress', function(e) {
                if (e.which === 13) {
                    applyFilters();
                }
            });

            // Auto-apply filters on select change
            $('#category-filter, #status-filter').on('change', function() {
                applyFilters();
            });
        }

        function initUnitQuickAdd() {
            const jq = window.jQuery || window.$;
            if (!jq) {
                console.error('jQuery not available for unit quick add.');
                return;
            }

            const $ = jq;

            $('[data-unit-quick-add-toggle]').off('click.unitQuickAdd').on('click.unitQuickAdd', function () {
                const targetSelector = $(this).data('target');
                if (!targetSelector) {
                    return;
                }

                const $target = $(targetSelector);
                if (!$target.length) {
                    return;
                }

                $target.toggleClass('hidden');
                if (!$target.hasClass('hidden')) {
                    const firstInput = $target.find('[data-unit-field="code"], input[name="code"]').first();
                    if (firstInput.length) {
                        firstInput.trigger('focus');
                    }
                }
            });

            $('[data-unit-quick-add]').each(function () {
                const $container = $(this);
                if ($container.data('unitQuickAddBound')) {
                    return;
                }
                $container.data('unitQuickAddBound', true);

                setupUnitQuickAddContainer($container, $);
            });
        }

        function setupUnitQuickAddContainer($container, $) {
            const $formWrapper = $container.find('[data-unit-quick-add-form]');
            const targetSelectSelector = $formWrapper.data('unit-select');
            const $cancelBtn = $container.find('[data-unit-quick-add-cancel]');
            const $submitBtn = $container.find('[data-unit-quick-add-submit]');

            const getField = (name) => $formWrapper.find(`[data-unit-field="${name}"]`);

            const resetFields = () => {
                getField('code').val('');
                getField('name').val('');
                getField('symbol').val('');
            };

            $cancelBtn.on('click', function () {
                resetFields();
                $container.addClass('hidden');
            });

            $submitBtn.on('click', function () {
                const payload = {
                    code: getField('code').val().trim(),
                    name: getField('name').val().trim(),
                    symbol: getField('symbol').val().trim(),
                    is_active: getField('is_active').val() || 1,
                };

                if (!payload.code || !payload.name) {
                    if (typeof window.showError === 'function') {
                        window.showError('Please enter both unit code and name.');
                    }
                    return;
                }

                const originalHtml = $submitBtn.html();
                $submitBtn.prop('disabled', true)
                    .html('<i class="w-4 h-4 mr-2 animate-spin" data-lucide="loader"></i> Saving');

                $.ajax({
                    url: unitStoreUrl,
                    method: 'POST',
                    data: {
                        ...payload,
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (response) {
                        if (response.success && response.unit) {
                            updateUnitSelects(response.unit);
                            if (targetSelectSelector) {
                                const $targetSelect = $(targetSelectSelector);
                                if ($targetSelect.length) {
                                    $targetSelect.val(response.unit.id).trigger('change');
                                }
                            }

                            if (typeof window.showSuccess === 'function') {
                                window.showSuccess(response.message || 'Unit created successfully');
                            }

                            resetFields();
                            $container.addClass('hidden');
                        } else if (typeof window.showError === 'function') {
                            window.showError(response.message || 'Failed to create unit.');
                        }
                    },
                    error: function (xhr) {
                        let message = xhr.responseJSON?.message || 'Failed to create unit.';
                        if (xhr.status === 422 && xhr.responseJSON?.errors) {
                            message = Object.values(xhr.responseJSON.errors).flat().join('\n');
                        }

                        if (typeof window.showError === 'function') {
                            window.showError(message);
                        }
                    },
                    complete: function () {
                        $submitBtn.prop('disabled', false).html(originalHtml);
                        if (typeof lucide !== 'undefined' && typeof lucide.createIcons === 'function') {
                            lucide.createIcons();
                        }
                    }
                });
            });
        }

        function updateUnitSelects(unit) {
            const jq = window.jQuery || window.$;
            if (!jq) {
                return;
            }

            const $ = jq;
            const label = formatUnitLabel(unit);
            ['#create-unit', '#edit-unit'].forEach(function (selector) {
                const $select = $(selector);
                if (!$select.length) {
                    return;
                }

                let $option = $select.find(`option[value="${unit.id}"]`);
                if (!$option.length) {
                    const newOption = new Option(label, unit.id, false, false);
                    $select.append(newOption);
                } else {
                    $option.text(label);
                }
            });
        }

        function formatUnitLabel(unit) {
            if (!unit) {
                return '';
            }

            return unit.symbol ? `${unit.name} (${unit.symbol})` : unit.name;
        }

        function applyFilters() {
            materialsTable.ajax.reload();
            updateActiveFiltersIndicator();
        }

        function clearFilters() {
            $('#category-filter').val('');
            $('#status-filter').val('');
            $('#search-filter').val('');
            materialsTable.ajax.reload();
            updateActiveFiltersIndicator();
        }

        function updateActiveFiltersIndicator() {
            const hasActiveFilters = $('#category-filter').val() || $('#status-filter').val() || $('#search-filter').val();
            $('#active-filters-indicator').toggleClass('hidden', !hasActiveFilters);
        }

        // Global functions for modal interactions
        window.editMaterial = function(id) {
            const jq = window.jQuery || window.$;
            if (!jq) {
                console.error('jQuery not available for editMaterial.');
                return;
            }

            jq.get('<?php echo e(route("warehouse.materials.show", ":id")); ?>'.replace(':id', id))
                .done(function(response) {
                    if (response.success) {
                        populateEditModal(response.material);
                        const trigger = document.getElementById('edit-material-trigger');
                        if (trigger) {
                            trigger.click();
                        }
                    }
                });
        };

        window.deleteMaterial = function(id, name) {
            const jq = window.jQuery || window.$;
            if (!jq) {
                console.error('jQuery not available for deleteMaterial.');
                return;
            }

            if (typeof window.confirmDelete === 'function') {
                window.confirmDelete(name, function() {
                    jq.ajax({
                        url: '<?php echo e(route("warehouse.materials.destroy", ":id")); ?>'.replace(':id', id),
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").getAttribute('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                if (materialsTable) {
                                    materialsTable.ajax.reload();
                                }

                                if (typeof window.showSuccess === 'function') {
                                    window.showSuccess(response.message || 'Material has been deleted');
                                }
                            } else if (typeof window.showError === 'function') {
                                window.showError(response.message || 'Failed to delete material.');
                            }
                        },
                        error: function(xhr) {
                            if (typeof window.showError === 'function') {
                                window.showError('An error occurred while deleting the material.');
                            }
                        }
                    });
                });
            } else {
                // Fallback simple confirm if confirmDelete is not available
                if (window.confirm(`Delete material "${name}"?`)) {
                    jq.ajax({
                        url: '<?php echo e(route("warehouse.materials.destroy", ":id")); ?>'.replace(':id', id),
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").getAttribute('content')
                        },
                        success: function(response) {
                            if (response.success && materialsTable) {
                                materialsTable.ajax.reload();
                            }
                        }
                    });
                }
            }
        };
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('../themes/' . $activeTheme . '/' . $activeLayout, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\ERP System\Source\resources\views/warehouse/materials/index.blade.php ENDPATH**/ ?>
<?php
    $company = $company ?? null;
    $companies = $companies ?? collect();
    $warehouses = $warehouses ?? collect();
    $categories = $categories ?? collect();
    $materials = $materials ?? collect();
    $materialCategories = $materialCategories ?? collect();
    $approvalTemplates = $approvalTemplates ?? collect();

    $warehousesPayload = $warehouses->map(fn ($warehouse) => [
        'id' => $warehouse->id,
        'code' => $warehouse->code,
        'name' => $warehouse->name,
        'location' => $warehouse->location,
    ])->values();

    $materialsPayload = $materials->map(fn ($material) => [
        'id' => $material['id'] ?? null,
        'code' => $material['code'] ?? null,
        'name' => $material['name'] ?? null,
        'category_id' => $material['category_id'] ?? null,
        'category_name' => $material['category_name'] ?? null,
        'unit' => $material['unit'] ?? null,
        'unit_symbol' => $material['unit_symbol'] ?? null,
        'price' => $material['price'] ?? 0,
    ])->values();

    $materialCategoriesPayload = $materialCategories->map(fn ($category) => [
        'id' => $category['id'] ?? null,
        'name' => $category['name'] ?? null,
    ])->values();

    $catalogsPayload = $categories->map(fn ($category) => [
        'id' => $category->id,
        'name' => $category->name,
        'children' => $category->children->map(fn ($child) => [
            'id' => $child->id,
            'name' => $child->name,
        ])->values(),
    ])->values();

    $approvalTemplatesPayload = $approvalTemplates->map(fn ($template) => [
        'id' => $template->id,
        'name' => $template->name,
        'description' => $template->description,
        'levels' => $template->levels,
    ])->values();

    $companiesPayload = $companies->map(fn ($company) => [
        'id' => $company->id,
        'name' => $company->name,
        'address' => $company->address,
        'logo_url' => $company->logo ? \Illuminate\Support\Facades\Storage::url($company->logo) : null,
    ])->values();

    $currencySymbol = config('app.currency_symbol', config('app.currency', '$'));

    $defaultCompany = $company ?? $companies->first();
    $defaultCompanyName = $defaultCompany->name ?? 'Smart ERP';
    $defaultCompanyAddress = $defaultCompany->address ?? 'Select the warehouse items needed for fulfillment.';
    $defaultCompanyLogo = $defaultCompany?->logo ? \Illuminate\Support\Facades\Storage::url($defaultCompany->logo) : null;
    $defaultCompanyId = $defaultCompany->id ?? null;

    $defaultCompanyMeta = [
        'id' => $defaultCompanyId,
        'name' => $defaultCompanyName,
        'address' => $defaultCompanyAddress,
        'logo_url' => $defaultCompanyLogo
            ?? 'https://ui-avatars.com/api/?name=' . urlencode($defaultCompanyName)
            . '&background=1D4ED8&color=fff',
    ];
?>

<?php $__env->startSection('subhead'); ?>
    <title>Material Requests - <?php echo e(config('app.name')); ?></title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.datatable.styles', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.datatable.theme', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('subcontent'); ?>
    <?php echo $__env->make('components.global-notifications', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Material Requests</h2>
        <button
            type="button"
            id="create-material-request-button"
            class="btn-tonal btn-tonal--success w-40 sm:w-auto sm:ml-4 group"
            data-tw-toggle="modal"
            data-tw-target="#material-request-modal"
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
            New Material Request
        </button>
    </div>

    <!-- Compact filters bar -->
    <div class="intro-y mt-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <?php
            $stats = $statusStats ?? [
                'total' => 0,
                'pending' => 0,
                'in_progress' => 0,
                'approved' => 0,
                'rejected' => 0,
                'completed' => 0,
            ];
        ?>

        <!-- Modern status cards with counts -->
        <div class="flex w-full overflow-x-auto gap-2 text-xs sm:max-w-xl">
            <button
                type="button"
                data-status=""
                onclick="filterByStatus('')"
                class="status-card flex min-w-[100px] flex-col rounded-xl border border-slate-200 bg-white/80 px-3 py-2 text-left shadow-sm hover:border-primary/40 hover:bg-primary/5 transition"
            >
                <span class="text-[0.7rem] font-medium text-slate-500">All</span>
                <span class="mt-1 text-base font-semibold text-slate-800"><?php echo e(number_format($stats['total'])); ?></span>
            </button>

            <button
                type="button"
                data-status="pending"
                onclick="filterByStatus('pending')"
                class="status-card flex min-w-[110px] flex-col rounded-xl border border-amber-100 bg-amber-50/80 px-3 py-2 text-left shadow-sm hover:border-amber-300 hover:bg-amber-50 transition"
            >
                <span class="inline-flex items-center gap-1 text-[0.7rem] font-medium text-amber-700">
                    <span class="inline-block h-1.5 w-1.5 rounded-full bg-amber-400"></span>
                    Pending
                </span>
                <span class="mt-1 text-base font-semibold text-amber-800"><?php echo e(number_format($stats['pending'])); ?></span>
            </button>

            <button
                type="button"
                data-status="in_progress"
                onclick="filterByStatus('in_progress')"
                class="status-card flex min-w-[120px] flex-col rounded-xl border border-sky-100 bg-sky-50/80 px-3 py-2 text-left shadow-sm hover:border-sky-300 hover:bg-sky-50 transition"
            >
                <span class="inline-flex items-center gap-1 text-[0.7rem] font-medium text-sky-700">
                    <span class="inline-block h-1.5 w-1.5 rounded-full bg-sky-400"></span>
                    In progress
                </span>
                <span class="mt-1 text-base font-semibold text-sky-800"><?php echo e(number_format($stats['in_progress'])); ?></span>
            </button>

            <button
                type="button"
                data-status="approved"
                onclick="filterByStatus('approved')"
                class="status-card flex min-w-[110px] flex-col rounded-xl border border-emerald-100 bg-emerald-50/80 px-3 py-2 text-left shadow-sm hover:border-emerald-300 hover:bg-emerald-50 transition"
            >
                <span class="inline-flex items-center gap-1 text-[0.7rem] font-medium text-emerald-700">
                    <span class="inline-block h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                    Approved
                </span>
                <span class="mt-1 text-base font-semibold text-emerald-800"><?php echo e(number_format($stats['approved'])); ?></span>
            </button>

            <button
                type="button"
                data-status="rejected"
                onclick="filterByStatus('rejected')"
                class="status-card flex min-w-[110px] flex-col rounded-xl border border-rose-100 bg-rose-50/80 px-3 py-2 text-left shadow-sm hover:border-rose-300 hover:bg-rose-50 transition"
            >
                <span class="inline-flex items-center gap-1 text-[0.7rem] font-medium text-rose-700">
                    <span class="inline-block h-1.5 w-1.5 rounded-full bg-rose-400"></span>
                    Rejected
                </span>
                <span class="mt-1 text-base font-semibold text-rose-800"><?php echo e(number_format($stats['rejected'])); ?></span>
            </button>

            <button
                type="button"
                data-status="completed"
                onclick="filterByStatus('completed')"
                class="status-card flex min-w-[120px] flex-col rounded-xl border border-slate-200 bg-slate-50/80 px-3 py-2 text-left shadow-sm hover:border-slate-400 hover:bg-slate-50 transition"
            >
                <span class="inline-flex items-center gap-1 text-[0.7rem] font-medium text-slate-700">
                    <span class="inline-block h-1.5 w-1.5 rounded-full bg-slate-500"></span>
                    Completed
                </span>
                <span class="mt-1 text-base font-semibold text-slate-800"><?php echo e(number_format($stats['completed'])); ?></span>
            </button>
        </div>

        <!-- Quick search + advanced toggle -->
        <div class="flex w-full items-center gap-2 sm:w-auto">
            <div class="relative flex-1 sm:w-56">
                <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'search','class' => 'w-3.5 h-3.5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'search','class' => 'w-3.5 h-3.5']); ?>
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
                </span>
                <input
                    id="quick-search"
                    type="text"
                    placeholder="Quick search..."
                    class="w-full rounded-full border border-slate-200 bg-white py-1.5 pl-8 pr-3 text-xs text-slate-700 placeholder:text-slate-400 focus:border-primary focus:ring-0"
                />
            </div>
            <button
                type="button"
                onclick="toggleAdvancedFilters()"
                class="hidden sm:inline-flex items-center rounded-full border border-slate-200 bg-white px-3 py-1.5 text-[0.72rem] font-medium text-slate-700 hover:bg-slate-50"
            >
                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'sliders','class' => 'w-3.5 h-3.5 mr-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'sliders','class' => 'w-3.5 h-3.5 mr-1']); ?>
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
                Advanced
            </button>
        </div>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <!-- Advanced filters -->
            <?php if (isset($component)) { $__componentOriginal1e00c22da64774fd0d873cb958c26686 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1e00c22da64774fd0d873cb958c26686 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.preview-component.index','data' => ['id' => 'advanced-filters-panel','class' => 'intro-y box mb-6 hidden']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.preview-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'advanced-filters-panel','class' => 'intro-y box mb-6 hidden']); ?>
                <div class="p-5">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                        <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'filter','class' => 'h-5 w-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'filter','class' => 'h-5 w-5']); ?>
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
                        <span id="material-requests-active-filters" class="hidden ml-2 px-2 py-0.5 text-xs bg-emerald-500/15 text-emerald-700 rounded-full">Active</span>
                    </h3>

                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12 md:col-span-4">
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
                                <option value="pending">Pending</option>
                                <option value="in_progress">In progress</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                                <option value="completed">Completed</option>
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

                        <div class="col-span-12 md:col-span-4">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Search
                            </label>
                            <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'search-filter','type' => 'text','placeholder' => 'Search material requests...','class' => 'w-full']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'search-filter','type' => 'text','placeholder' => 'Search material requests...','class' => 'w-full']); ?>
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

                        <div class="col-span-12 md:col-span-4 flex items-end gap-2">
                            <button
                                type="button"
                                class="btn-tonal btn-tonal--amber flex-1 group"
                                onclick="clearFilters()"
                            >
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
                                Clear
                            </button>
                            <button
                                type="button"
                                class="btn-tonal btn-tonal--info flex-1 group"
                                onclick="applyFilters()"
                            >
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
                                Apply
                            </button>
                        </div>
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

            <!-- Material Requests Table -->
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
                            id="material-requests-table"
                            data-tw-merge
                            data-erp-table
                            class="datatable-default w-full min-w-full table-auto text-left text-sm"
                        >
                            <thead>
                                <tr>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Code</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Title</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Requested By</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Company</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Request Date</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Total Amount</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Approvals</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Status</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Actions</th>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.datatable.scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php echo $__env->make('warehouse.material-requests.modals.create-request', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>

    <script>
        window.materialRequestPayload = {
            routes: {
                store: '<?php echo e(route('warehouse.material-requests.store')); ?>',
                previewCode: '<?php echo e(route('warehouse.material-requests.preview-code')); ?>',
                materials: '<?php echo e(route('warehouse.material-requests.materials')); ?>',
                categoryChildren: '<?php echo e(route('warehouse.categories.children')); ?>'
            },
            meta: {
                csrf: '<?php echo e(csrf_token()); ?>'
            },
            data: {
                companies: <?php echo json_encode($companiesPayload, 15, 512) ?>,
                defaultCompany: <?php echo json_encode($defaultCompanyMeta, 15, 512) ?>,
                warehouses: <?php echo json_encode($warehousesPayload, 15, 512) ?>,
                materials: <?php echo json_encode($materialsPayload, 15, 512) ?>,
                categories: <?php echo json_encode($materialCategoriesPayload, 15, 512) ?>,
                catalogs: <?php echo json_encode($catalogsPayload, 15, 512) ?>,
                approvalTemplates: <?php echo json_encode($approvalTemplatesPayload, 15, 512) ?>,
                currencySymbol: <?php echo json_encode($currencySymbol, 15, 512) ?>
            }
        };

        window.dispatchEvent(new Event('material-request:payload-ready'));

        let materialRequestsTable;

        document.addEventListener('DOMContentLoaded', function () {
            const jq = window.jQuery || window.$;
            if (!jq) {
                console.error('jQuery not available on material requests page.');
                return;
            }

            jq(function () {
                initializeMaterialRequestsTable();
                setupMaterialRequestsFilters();
            });
        });

        function initializeMaterialRequestsTable() {
            materialRequestsTable = window.erpCrud.initDataTable({
                tableSelector: '#material-requests-table',
                ajaxUrl: '<?php echo e(route("warehouse.material-requests.datatable")); ?>',
                ajaxData: function(d) {
                    d.status = $('#status-filter').val();
                    d.search_value = $('#search-filter').val();
                },
                columns: [
                    { data: 'code', name: 'code' },
                    { data: 'title', name: 'title' },
                    { data: 'requested_by_name', name: 'requested_by_name' },
                    { data: 'company_name', name: 'company_name' },
                    { data: 'request_date', name: 'request_date' },
                    {
                        data: 'total_amount',
                        name: 'total_amount',
                        render: function (value) {
                            if (window.erpCrud && typeof window.erpCrud.formatCurrency === 'function') {
                                return window.erpCrud.formatCurrency(value);
                            }
                            return value ?? 0;
                        }
                    },
                    { data: 'approval_progress', name: 'approval_progress', orderable: false, searchable: false },
                    {
                        data: 'status_badge',
                        name: 'status',
                        className: 'text-center',
                        orderable: false,
                        searchable: false,
                        render: function (value) {
                            return value || '';
                        }
                    },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ],
                pageLength: 25
            });
            window.materialRequestsTable = materialRequestsTable;
        }

        function setupMaterialRequestsFilters() {
            $('#search-filter').on('keypress', function(e) {
                if (e.which === 13) {
                    applyFilters();
                }
            });

            $('#status-filter').on('change', function() {
                applyFilters();
            });

            // Quick search input in compact bar
            $('#quick-search').on('keypress', function(e) {
                if (e.which === 13) {
                    const value = $(this).val();
                    $('#search-filter').val(value);
                    applyFilters();
                }
            });
        }

        function applyFilters() {
            if (materialRequestsTable) {
                materialRequestsTable.ajax.reload();
            }
        }

        function clearFilters() {
            $('#status-filter').val('');
            $('#search-filter').val('');
            $('#quick-search').val('');
            applyFilters();
        }

        window.filterByStatus = function (status) {
            const statusSelect = $('#status-filter');
            if (!statusSelect.length) {
                return;
            }

            statusSelect.val(status || '');
            $('#search-filter').val('');
            applyFilters();
        };

        window.toggleAdvancedFilters = function () {
            const panel = document.getElementById('advanced-filters-panel');
            if (!panel) return;
            panel.classList.toggle('hidden');
        };

        function deleteMaterialRequest(id, code) {
            if (!window.confirmDelete || !window.showError || !window.showToast) {
                console.error('Global notification helpers are not available.');
                return;
            }

            window.confirmDelete(code, function () {
                const jq = window.jQuery || window.$;
                if (!jq) {
                    console.error('jQuery is not available for deleteMaterialRequest.');
                    return;
                }

                jq.ajax({
                    url: '<?php echo e(route('warehouse.material-requests.destroy', ':id')); ?>'.replace(':id', id),
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '<?php echo e(csrf_token()); ?>'
                    }
                })
                .done(function (response) {
                    const message = response.message || 'Material request deleted successfully.';
                    window.showToast(message, 'delete');
                    if (window.materialRequestsTable) {
                        window.materialRequestsTable.ajax.reload(null, false);
                    }
                })
                .fail(function (xhr) {
                    const message = xhr.responseJSON?.message || 'Failed to delete material request.';
                    window.showError(message);
                });
            });
        }

        function openMaterialRequestEditModal(id) {
            // Placeholder for Ajax-powered edit modal; implementation will
            // reuse the create modal structure and populate it with data.
            // For now, simply navigate to the show page with edit flag
            // to avoid breaking the UI until the full edit modal is wired.
            window.location.href = '<?php echo e(route('warehouse.material-requests.show', ':id')); ?>'.replace(':id', id) + '?edit=1';
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('../themes/' . $activeTheme . '/' . $activeLayout, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\ERP System\Source\resources\views/warehouse/material-requests/index.blade.php ENDPATH**/ ?>
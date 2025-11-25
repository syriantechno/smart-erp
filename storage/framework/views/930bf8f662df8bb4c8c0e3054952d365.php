<?php $__env->startSection('subhead'); ?>
    <title>Material Request <?php echo e($purchaseRequest->code); ?> - <?php echo e(config('app.name')); ?></title>
<?php $__env->stopSection(); ?>

<?php
    $company = $purchaseRequest->company;
    $companyName = $company->name ?? 'Smart ERP';
    $companyAddress = $company->address ?? '—';
    $companyEmail = $company->email ?? '—';
    $companyPhone = $company->phone ?? '—';
    $companyLogo = $company?->logo ? \Illuminate\Support\Facades\Storage::url($company->logo) : 'https://ui-avatars.com/api/?name=' . urlencode($companyName) . '&background=1D4ED8&color=fff';

    $effectiveStatus = $approvalRequest->status ?? $purchaseRequest->status;
    $showApprovedStamp = $effectiveStatus === 'approved';
    $showRejectedStamp = $effectiveStatus === 'rejected';
    $stampLabel = strtoupper($showApprovedStamp ? 'Approved' : 'Rejected');
    $stampColor = $showApprovedStamp ? '#10b981' : '#dc2626';
    $stampBgColor = $showApprovedStamp ? '#ecfdf5' : '#fee2e2';
?>


<?php $__env->startSection('subcontent'); ?>
    <div class="intro-y mt-8 space-y-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Material Request</p>
                <h1 class="text-2xl font-semibold text-slate-800 dark:text-slate-100">
                    <?php echo e($purchaseRequest->code); ?> — <?php echo e($purchaseRequest->title); ?>

                </h1>
            </div>
            <a href="<?php echo e(route('warehouse.material-requests.index')); ?>" class="btn btn-outline-secondary">
                Back to list
            </a>
        </div>

        <?php if (isset($component)) { $__componentOriginal1e00c22da64774fd0d873cb958c26686 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1e00c22da64774fd0d873cb958c26686 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.preview-component.index','data' => ['class' => 'box']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.preview-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'box']); ?>
            <div class="space-y-6 p-5">
                <div class="flex flex-col gap-3 rounded-2xl border border-slate-200/70 bg-slate-50/60 p-4 dark:border-darkmode-400 dark:bg-darkmode-600/30">
                    <div class="flex flex-wrap items-center gap-3">
                        <div class="h-14 w-14 overflow-hidden rounded-2xl border border-white/60 bg-white shadow-sm flex items-center justify-center">
                            <img src="<?php echo e($companyLogo); ?>" alt="<?php echo e($companyName); ?> Logo" class="h-full w-full object-cover">
                        </div>
                        <div class="flex-1 min-w-[200px]">
                            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">Company</p>
                            <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100">
                                <?php echo e($companyName); ?>

                            </h3>
                            <p class="text-sm text-slate-500">
                                <?php echo e($companyAddress); ?>

                            </p>
                        </div>
                        <div class="text-sm text-slate-500 space-y-1">
                            <p class="flex items-center gap-1">
                                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Mail','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Mail','class' => 'h-4 w-4']); ?>
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
                                <span><?php echo e($companyEmail); ?></span>
                            </p>
                            <p class="flex items-center gap-1">
                                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Phone','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Phone','class' => 'h-4 w-4']); ?>
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
                                <span><?php echo e($companyPhone); ?></span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12 lg:col-span-8 space-y-6">
                        <?php if($approvalRequest): ?>
                            <div class="box p-6">
                                <h2 class="text-sm font-semibold text-slate-600 mb-4">Approval Workflow</h2>
                                <div class="flex flex-wrap items-center gap-4">
                                    <?php $__currentLoopData = ($approvalRequest->approval_levels ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $levelNumber = $level['level'] ?? $loop->iteration;
                                            $approverName = $approverNames->get($level['approver_id'] ?? null)?->name ?? 'Approver';

                                            $state = 'pending';
                                            if ($approvalRequest->status === 'approved' || ($approvalRequest->current_level ?? 1) > $levelNumber) {
                                                $state = 'approved';
                                            } elseif ($approvalRequest->status === 'rejected' && ($approvalRequest->current_level ?? 1) === $levelNumber) {
                                                $state = 'rejected';
                                            } elseif ($approvalRequest->status === 'pending' && ($approvalRequest->current_level ?? 1) === $levelNumber) {
                                                $state = 'in_progress';
                                            }

                                            $stateMeta = [
                                                'approved' => [
                                                    'wrapper' => 'border-emerald-500 bg-emerald-50 text-emerald-600',
                                                    'icon' => 'CheckCircle',
                                                    'connector' => 'bg-emerald-500'
                                                ],
                                                'rejected' => [
                                                    'wrapper' => 'border-rose-500 bg-rose-50 text-rose-600',
                                                    'icon' => 'XCircle',
                                                    'connector' => 'bg-rose-500'
                                                ],
                                                'in_progress' => [
                                                    'wrapper' => 'border-sky-500 bg-sky-50 text-sky-600',
                                                    'icon' => 'RefreshCw',
                                                    'connector' => 'bg-sky-500'
                                                ],
                                                'pending' => [
                                                    'wrapper' => 'border-amber-400 bg-amber-50 text-amber-600',
                                                    'icon' => 'Clock',
                                                    'connector' => 'bg-amber-300'
                                                ],
                                            ];

                                            $styles = $stateMeta[$state];
                                            $iconClasses = 'w-5 h-5';
                                            if ($state === 'in_progress') {
                                                $iconClasses .= ' animate-spin';
                                            }
                                        ?>
                                        <div class="flex items-center <?php echo e(!$loop->last ? 'flex-1' : ''); ?>">
                                            <div class="flex flex-col items-center text-center">
                                                <div class="flex items-center justify-center w-12 h-12 rounded-full border-2 <?php echo e($styles['wrapper']); ?>">
                                                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => ''.e($styles['icon']).'','class' => ''.e($iconClasses).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => ''.e($styles['icon']).'','class' => ''.e($iconClasses).'']); ?>
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
                                                <p class="mt-2 text-sm font-medium text-slate-700"><?php echo e($level['name'] ?? "Level {$levelNumber}"); ?></p>
                                                <p class="text-xs text-slate-500"><?php echo e($approverName); ?></p>
                                            </div>
                                            <?php if (! ($loop->last)): ?>
                                                <div class="flex-1 h-0.5 mx-4 <?php echo e($styles['connector']); ?>"></div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>

                                <div class="mt-6 space-y-4">
                                    <div class="flex items-center justify-between text-sm">
                                        <div>
                                            <p class="text-xs text-slate-500">Current Status</p>
                                            <p class="font-semibold capitalize"><?php echo e($approvalRequest->status); ?></p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-slate-500">Current Approver</p>
                                            <p class="font-semibold"><?php echo e($approvalRequest->currentApprover?->name ?? 'N/A'); ?></p>
                                        </div>
                                    </div>

                                    <?php if($approvalRequest->status === 'rejected' && $approvalRequest->rejection_reason): ?>
                                        <div class="rounded-lg border border-danger bg-danger/10 p-4 text-sm text-danger">
                                            <p class="font-semibold mb-1">Rejected</p>
                                            <p><?php echo e($approvalRequest->rejection_reason); ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <?php if($approvalRequest->status === 'pending' && $approvalRequest->current_approver_id === auth()->id()): ?>
                                    <div class="mt-6 flex flex-wrap gap-3">
                                        <?php if (isset($component)) { $__componentOriginale00eb601fbe667f0da582732d70c41c5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale00eb601fbe667f0da582732d70c41c5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.button.index','data' => ['variant' => 'danger','onclick' => 'rejectMaterialRequest('.e($approvalRequest->id).')']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'danger','onclick' => 'rejectMaterialRequest('.e($approvalRequest->id).')']); ?>
                                            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'XCircle','class' => 'w-4 h-4 mr-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'XCircle','class' => 'w-4 h-4 mr-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $attributes = $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $component = $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?> Reject
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
                                        <?php if (isset($component)) { $__componentOriginale00eb601fbe667f0da582732d70c41c5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale00eb601fbe667f0da582732d70c41c5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.button.index','data' => ['variant' => 'success','onclick' => 'approveMaterialRequest('.e($approvalRequest->id).')']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'success','onclick' => 'approveMaterialRequest('.e($approvalRequest->id).')']); ?>
                                            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'CheckCircle','class' => 'w-4 h-4 mr-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'CheckCircle','class' => 'w-4 h-4 mr-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $attributes = $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $component = $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?> Approve
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
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <div class="box p-6">
                            <h2 class="text-sm font-semibold text-slate-600 mb-4">General Information</h2>
                            <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                                <div class="grid flex-1 grid-cols-1 gap-4 text-sm md:grid-cols-2">
                                    <div>
                                        <p class="text-xs text-slate-500">Warehouse</p>
                                        <p class="font-medium"><?php echo e($purchaseRequest->warehouse?->name ?? '—'); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500">Request Date</p>
                                        <p class="font-medium"><?php echo e(optional($purchaseRequest->request_date)->format('Y-m-d') ?? '—'); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500">Priority</p>
                                        <p class="font-medium capitalize"><?php echo e($purchaseRequest->priority ?? 'normal'); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500">Requested By</p>
                                        <p class="font-medium"><?php echo e($purchaseRequest->requestedBy?->name ?? '—'); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500">Approved By</p>
                                        <p class="font-medium"><?php echo e($purchaseRequest->approvedBy?->name ?? '—'); ?></p>
                                    </div>
                                </div>

                                <?php if($showApprovedStamp || $showRejectedStamp): ?>
                                    <div class="flex justify-center lg:justify-end">
                                        <div
                                            class="mr-approval-stamp inline-flex h-36 w-36 items-center justify-center rounded-full border-[6px]"
                                            style="transform: rotate(-8deg); border-color: <?php echo e($stampColor); ?>; color: <?php echo e($stampColor); ?>; background-color: <?php echo e($stampBgColor); ?>;"
                                        >
                                            <?php echo e($stampLabel); ?>

                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="box p-6">
                            <h2 class="text-sm font-semibold text-slate-600 mb-4">Items</h2>

                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="text-left text-xs uppercase tracking-wide text-slate-500">
                                            <th class="py-2">Material</th>
                                            <th class="py-2">Unit</th>
                                            <th class="py-2">Qty</th>
                                            <th class="py-2">Unit Price</th>
                                            <th class="py-2 text-right">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        <?php $__currentLoopData = $purchaseRequest->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td class="py-3">
                                                    <p class="font-medium"><?php echo e($item->material->name ?? '—'); ?></p>
                                                    <p class="text-xs text-slate-500"><?php echo e($item->material->code ?? ''); ?></p>
                                                </td>
                                                <td><?php echo e($item->material->unit->name ?? $item->material->unit->symbol ?? '—'); ?></td>
                                                <td><?php echo e(number_format($item->quantity, 2)); ?></td>
                                                <td><?php echo e($currencySymbol); ?><?php echo e(number_format($item->unit_price, 2)); ?></td>
                                                <td class="text-right"><?php echo e($currencySymbol); ?><?php echo e(number_format($item->quantity * $item->unit_price, 2)); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 lg:col-span-4 space-y-6">
                        <div class="box p-6">
                            <h2 class="text-sm font-semibold text-slate-600 mb-4">Summary</h2>
                            <dl class="space-y-3 text-sm">
                                <div class="flex justify-between">
                                    <dt>Status</dt>
                                    <dd class="font-semibold capitalize"><?php echo e($purchaseRequest->status); ?></dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt>Total Amount</dt>
                                    <dd class="font-semibold"><?php echo e($currencySymbol); ?><?php echo e(number_format($purchaseRequest->total_amount, 2)); ?></dd>
                                </div>
                                <div>
                                    <dt class="text-xs text-slate-500 mb-1">Notes</dt>
                                    <dd class="text-slate-600"><?php echo e($purchaseRequest->description ?? 'No additional notes provided.'); ?></dd>
                                </div>
                            </dl>
                        </div>

                        <div class="box p-6">
                            <h2 class="text-sm font-semibold text-slate-600 mb-4">Company</h2>
                            <p class="font-medium"><?php echo e($purchaseRequest->company?->name ?? '—'); ?></p>
                            <p class="text-xs text-slate-500"><?php echo e($purchaseRequest->company?->address ?? '—'); ?></p>
                        </div>

                        <?php if($approvalRequest && $approvalRequest->logs->isNotEmpty()): ?>
                            <div class="box p-6">
                                <h2 class="text-sm font-semibold text-slate-600 mb-4">Approval Activity</h2>
                                <div class="space-y-4">
                                    <?php $__currentLoopData = $approvalRequest->logs->sortByDesc('created_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="flex items-start gap-3">
                                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full text-xs font-semibold <?php echo e($log->action_badge_class); ?>">
                                                <?php echo e(strtoupper(substr($log->action, 0, 1))); ?>

                                            </span>
                                            <div class="text-sm">
                                                <p class="font-semibold capitalize"><?php echo e($log->action_label); ?></p>
                                                <p class="text-xs text-slate-500"><?php echo e($log->user?->name ?? 'System'); ?> • <?php echo e($log->formatted_date); ?></p>
                                                <?php if($log->comments): ?>
                                                    <p class="mt-1 text-slate-600 text-sm"><?php echo e($log->comments); ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        <?php endif; ?>
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
    </div>

    <?php $__env->startPush('scripts'); ?>
        <script>
            function approveMaterialRequest(approvalRequestId) {
                Swal.fire({
                    title: 'Approve Material Request',
                    input: 'textarea',
                    inputLabel: 'Comments (optional)',
                    showCancelButton: true,
                    confirmButtonText: 'Approve',
                    confirmButtonColor: '#10b981'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.jQuery.post('<?php echo e(route("approval-system.approve", ':id')); ?>'.replace(':id', approvalRequestId), {
                            comments: result.value,
                            _token: '<?php echo e(csrf_token()); ?>'
                        })
                        .done(() => {
                            window.location.reload();
                        })
                        .fail((xhr) => {
                            showError(xhr.responseJSON?.message || 'Failed to approve request.');
                        });
                    }
                });
            }

            function rejectMaterialRequest(approvalRequestId) {
                Swal.fire({
                    title: 'Reject Material Request',
                    input: 'textarea',
                    inputLabel: 'Reason for rejection',
                    inputValidator: (value) => {
                        if (!value) {
                            return 'Reason is required';
                        }
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Reject',
                    confirmButtonColor: '#ef4444'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.jQuery.post('<?php echo e(route("approval-system.reject", ':id')); ?>'.replace(':id', approvalRequestId), {
                            reason: result.value,
                            _token: '<?php echo e(csrf_token()); ?>'
                        })
                        .done(() => {
                            window.location.reload();
                        })
                        .fail((xhr) => {
                            showError(xhr.responseJSON?.message || 'Failed to reject request.');
                        });
                    }
                });
            }
        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../themes/' . $activeTheme . '/' . $activeLayout, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\smart-erp\resources\views/warehouse/material-requests/show.blade.php ENDPATH**/ ?>
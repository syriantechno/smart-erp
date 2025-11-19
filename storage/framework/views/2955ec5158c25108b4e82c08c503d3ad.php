

<?php $__env->startSection('subhead'); ?>
    <title>Purchase Order Details - <?php echo e(config('app.name')); ?></title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('subcontent'); ?>
    <?php echo $__env->make('components.global-notifications', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Purchase Order Details</h2>
        <div class="flex gap-2">
            <a href="<?php echo e(route('warehouse.purchase-orders.edit', $purchaseOrder->id)); ?>" class="btn-tonal btn-tonal--warning">
                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'edit','class' => 'w-4 h-4 mr-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'edit','class' => 'w-4 h-4 mr-2']); ?>
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
                Edit
            </a>
            <a href="<?php echo e(route('warehouse.purchase-orders.index')); ?>" class="btn-tonal btn-tonal--secondary">
                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'arrow-left','class' => 'w-4 h-4 mr-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'arrow-left','class' => 'w-4 h-4 mr-2']); ?>
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
                Back to List
            </a>
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
                    <div class="grid grid-cols-12 gap-6">
                        <!-- Purchase Order Info -->
                        <div class="col-span-12 lg:col-span-8">
                            <h3 class="text-lg font-semibold mb-4">Purchase Order Information</h3>
                            
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-1">Code</label>
                                    <p class="text-slate-900 font-medium"><?php echo e($purchaseOrder->code); ?></p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-1">Status</label>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full 
                                        <?php if($purchaseOrder->status === 'pending'): ?> bg-yellow-100 text-yellow-800
                                        <?php elseif($purchaseOrder->status === 'approved'): ?> bg-green-100 text-green-800
                                        <?php elseif($purchaseOrder->status === 'shipped'): ?> bg-blue-100 text-blue-800
                                        <?php elseif($purchaseOrder->status === 'delivered'): ?> bg-emerald-100 text-emerald-800
                                        <?php elseif($purchaseOrder->status === 'cancelled'): ?> bg-red-100 text-red-800
                                        <?php else: ?> bg-slate-100 text-slate-800
                                        <?php endif; ?>">
                                        <?php echo e(ucfirst($purchaseOrder->status)); ?>

                                    </span>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-1">Title</label>
                                    <p class="text-slate-900"><?php echo e($purchaseOrder->title); ?></p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-1">Order Date</label>
                                    <p class="text-slate-900"><?php echo e($purchaseOrder->order_date->format('Y-m-d')); ?></p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-1">Supplier</label>
                                    <p class="text-slate-900"><?php echo e($purchaseOrder->supplier->name ?? 'N/A'); ?></p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-1">Total Amount</label>
                                    <p class="text-slate-900 font-semibold text-lg">$<?php echo e(number_format($purchaseOrder->total_amount, 2)); ?></p>
                                </div>
                            </div>

                            <?php if($purchaseOrder->description): ?>
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-slate-600 mb-1">Description</label>
                                <p class="text-slate-900"><?php echo e($purchaseOrder->description); ?></p>
                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- Sidebar Info -->
                        <div class="col-span-12 lg:col-span-4">
                            <h3 class="text-lg font-semibold mb-4">Additional Information</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-1">Created By</label>
                                    <p class="text-slate-900"><?php echo e($purchaseOrder->createdBy->name ?? 'N/A'); ?></p>
                                </div>
                                
                                <?php if($purchaseOrder->approvedBy): ?>
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-1">Approved By</label>
                                    <p class="text-slate-900"><?php echo e($purchaseOrder->approvedBy->name); ?></p>
                                </div>
                                <?php endif; ?>
                                
                                <?php if($purchaseOrder->expected_delivery_date): ?>
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-1">Expected Delivery</label>
                                    <p class="text-slate-900"><?php echo e($purchaseOrder->expected_delivery_date->format('Y-m-d')); ?></p>
                                </div>
                                <?php endif; ?>
                                
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-1">Created At</label>
                                    <p class="text-slate-900"><?php echo e($purchaseOrder->created_at->format('Y-m-d H:i')); ?></p>
                                </div>
                            </div>
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
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../themes/' . $activeTheme . '/' . $activeLayout, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\smart-erp\resources\views/warehouse/purchase-orders/show.blade.php ENDPATH**/ ?>


<?php $__env->startSection('subhead'); ?>
    <title>Create Production Order - Manufacturing</title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('subcontent'); ?>
<div class="max-w-4xl mx-auto space-y-6">
    
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-800">Create Production Order</h1>
            <p class="text-sm text-slate-500 mt-1">Fill in the details to create a new production order</p>
        </div>
        <a href="<?php echo e(route('manufacturing.orders.index')); ?>" class="h-10 rounded-full px-5 flex items-center justify-center text-xs font-semibold text-slate-600 border border-slate-300 hover:bg-white/80 transition-all">
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
<?php endif; ?> Back to Orders
        </a>
    </div>

    
    <form action="<?php echo e(route('manufacturing.orders.store')); ?>" method="POST" class="space-y-6">
        <?php echo csrf_field(); ?>
        
        <div class="rounded-2xl bg-white shadow-lg border border-slate-200/60 overflow-hidden">
            <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-[#303030]">Order Details</h3>
            </div>
            <div class="p-6 space-y-6">
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Product Name <span class="text-red-500">*</span></label>
                    <input type="text" name="product_name" value="<?php echo e(old('product_name')); ?>" required
                        class="w-full h-11 px-4 rounded-xl border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all <?php $__errorArgs = ['product_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        placeholder="Enter product name">
                    <?php $__errorArgs = ['product_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Description</label>
                    <textarea name="description" rows="3"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all"
                        placeholder="Enter product description"><?php echo e(old('description')); ?></textarea>
                </div>

                
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Quantity <span class="text-red-500">*</span></label>
                        <input type="number" name="quantity" value="<?php echo e(old('quantity', 1)); ?>" required min="1"
                            class="w-full h-11 px-4 rounded-xl border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all <?php $__errorArgs = ['quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="Enter quantity">
                        <?php $__errorArgs = ['quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Unit Cost ($) <span class="text-red-500">*</span></label>
                        <input type="number" name="unit_cost" value="<?php echo e(old('unit_cost', 0)); ?>" required min="0" step="0.01"
                            class="w-full h-11 px-4 rounded-xl border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all <?php $__errorArgs = ['unit_cost'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="0.00">
                        <?php $__errorArgs = ['unit_cost'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Start Date <span class="text-red-500">*</span></label>
                        <input type="date" name="start_date" value="<?php echo e(old('start_date', date('Y-m-d'))); ?>" required
                            class="w-full h-11 px-4 rounded-xl border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all <?php $__errorArgs = ['start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">End Date</label>
                        <input type="date" name="end_date" value="<?php echo e(old('end_date')); ?>"
                            class="w-full h-11 px-4 rounded-xl border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all">
                    </div>
                </div>

                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Priority <span class="text-red-500">*</span></label>
                    <div class="flex gap-4">
                        <?php $__currentLoopData = ['low', 'medium', 'high', 'urgent']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $priority): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="priority" value="<?php echo e($priority); ?>" <?php echo e(old('priority', 'medium') === $priority ? 'checked' : ''); ?>

                                class="w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500">
                            <span class="text-sm text-slate-700 capitalize"><?php echo e($priority); ?></span>
                        </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Notes</label>
                    <textarea name="notes" rows="3"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all"
                        placeholder="Additional notes..."><?php echo e(old('notes')); ?></textarea>
                </div>
            </div>
        </div>

        
        <div class="flex items-center justify-end gap-3">
            <a href="<?php echo e(route('manufacturing.orders.index')); ?>" class="h-11 rounded-full px-6 flex items-center justify-center text-sm font-semibold text-slate-600 border border-slate-300 hover:bg-white/80 transition-all">
                Cancel
            </a>
            <button type="submit" class="h-11 rounded-full px-6 flex items-center justify-center text-sm font-semibold text-white bg-[#303030] hover:bg-[#404040] transition-all">
                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'save','class' => 'w-4 h-4 mr-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'save','class' => 'w-4 h-4 mr-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $attributes = $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $component = $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?> Create Order
            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../themes/' . $activeTheme . '/' . $activeLayout, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\smart-erp\resources\views/manufacturing/orders/create.blade.php ENDPATH**/ ?>
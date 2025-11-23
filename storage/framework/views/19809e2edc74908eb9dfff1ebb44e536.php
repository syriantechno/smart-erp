<div class="bg-white dark:bg-darkmode-600 rounded-lg shadow-sm border border-slate-200/60 dark:border-darkmode-400 mt-5">
    <div class="flex items-center border-b border-slate-200/60 p-5 dark:border-darkmode-400">
        <h2 class="mr-auto text-base font-medium flex items-center gap-2">
            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Shield','class' => 'w-5 h-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Shield','class' => 'w-5 h-5']); ?>
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
            Roles & Permissions
        </h2>
    </div>

    <form class="p-5">
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 xl:col-span-6">
                <h3 class="text-base font-semibold mb-3">Roles</h3>
                <div class="space-y-4">
                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="border rounded-lg p-4 bg-slate-50 dark:bg-darkmode-700/50">
                            <div class="flex items-center justify-between mb-3">
                                <div>
                                    <div class="font-semibold text-slate-800 dark:text-slate-100"><?php echo e($role->name); ?></div>
                                    <div class="text-xs text-slate-500">ID: <?php echo e($role->id); ?></div>
                                </div>
                            </div>
                            <form class="role-permissions-form space-y-3" data-role-id="<?php echo e($role->id); ?>">
                                <div class="grid grid-cols-2 gap-2 max-h-48 overflow-y-auto border rounded-md p-2 bg-white dark:bg-darkmode-600">
                                    <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <label class="flex items-center space-x-2 text-sm">
                                            <input
                                                type="checkbox"
                                                name="permissions[]"
                                                value="<?php echo e($permission->id); ?>"
                                                <?php if($role->permissions->contains('id', $permission->id)): ?> checked <?php endif; ?>
                                                class="border-slate-300 rounded"
                                            >
                                            <span><?php echo e($permission->name); ?></span>
                                        </label>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                                <div class="flex justify-end">
                                    <?php if (isset($component)) { $__componentOriginale00eb601fbe667f0da582732d70c41c5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale00eb601fbe667f0da582732d70c41c5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.button.index','data' => ['type' => 'submit','variant' => 'primary','size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','variant' => 'primary','size' => 'sm']); ?>
                                        Save Permissions
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
                            </form>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <div class="col-span-12 xl:col-span-6">
                <h3 class="text-base font-semibold mb-3">All Permissions</h3>
                <div class="border rounded-lg p-4 max-h-[500px] overflow-y-auto bg-slate-50 dark:bg-darkmode-700/50">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b">
                                <th class="py-2 text-left">Permission</th>
                                <th class="py-2 text-left">ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="border-b last:border-b-0">
                                    <td class="py-1"><?php echo e($permission->name); ?></td>
                                    <td class="py-1 text-xs text-slate-500"><?php echo e($permission->id); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>
<?php /**PATH D:\laravel\smart-erp\resources\views/settings/partials/permissions.blade.php ENDPATH**/ ?>
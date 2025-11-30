<?php $__env->startSection('subhead'); ?>
    <title><?php echo e($employee->full_name); ?> - Employee Profile</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('subcontent'); ?>
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium"><?php echo e($employee->full_name); ?> Profile</h2>
    </div>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <!-- BEGIN: Profile Card -->
        <div class="col-span-12 flex flex-col-reverse lg:col-span-4 lg:block 2xl:col-span-3">
            <div class="intro-y box mt-5 lg:mt-0 overflow-hidden">
                <!-- Cover Image & Profile Picture -->
                <div class="relative">
                    <div class="h-32 bg-gradient-to-r from-amber-400 via-orange-400 to-yellow-300">
                        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20100%20100%22%3E%3Ccircle%20cx%3D%2250%22%20cy%3D%2250%22%20r%3D%2240%22%20fill%3D%22none%22%20stroke%3D%22rgba(255%2C255%2C255%2C0.2)%22%20stroke-width%3D%222%22%2F%3E%3Ccircle%20cx%3D%2250%22%20cy%3D%2250%22%20r%3D%2230%22%20fill%3D%22none%22%20stroke%3D%22rgba(255%2C255%2C255%2C0.15)%22%20stroke-width%3D%222%22%2F%3E%3Ccircle%20cx%3D%2250%22%20cy%3D%2250%22%20r%3D%2220%22%20fill%3D%22none%22%20stroke%3D%22rgba(255%2C255%2C255%2C0.1)%22%20stroke-width%3D%222%22%2F%3E%3C%2Fsvg%3E')] bg-cover opacity-50"></div>
                    </div>
                    <div class="absolute -bottom-12 left-1/2 -translate-x-1/2">
                        <div class="h-24 w-24 rounded-full border-4 border-white dark:border-darkmode-600 overflow-hidden shadow-lg bg-white">
                            <img
                                class="h-full w-full object-cover"
                                src="<?php echo e($employee->profile_picture_url); ?>"
                                alt="<?php echo e($employee->full_name); ?>"
                            />
                        </div>
                    </div>
                </div>

                <!-- Name & Position -->
                <div class="pt-14 pb-5 px-5 text-center">
                    <h3 class="text-xl font-semibold text-slate-800 dark:text-white"><?php echo e($employee->full_name); ?></h3>
                    <p class="text-slate-500 dark:text-slate-400 text-sm mt-1"><?php echo e($employee->positionRelation->title ?? $employee->position ?? 'Employee'); ?></p>
                    <div class="flex items-center justify-center gap-2 mt-2">
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300">
                            <?php echo e($employee->code ?? $employee->employee_id); ?>

                        </span>
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold <?php echo e($employee->is_active ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400'); ?>">
                            <?php echo e($employee->is_active ? 'Active' : 'Inactive'); ?>

                        </span>
                    </div>
                </div>

                <!-- Employment Information -->
                <div class="border-t border-slate-200/60 dark:border-darkmode-400 px-5 py-5">
                    <h4 class="text-base font-semibold text-slate-800 dark:text-white mb-4">Employment Info</h4>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-slate-600 dark:text-slate-400">
                                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'hash','class' => 'w-4 h-4 mr-3 text-slate-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'hash','class' => 'w-4 h-4 mr-3 text-slate-400']); ?>
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
                                <span class="text-sm">Employee Code</span>
                            </div>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300"><?php echo e($employee->code ?? $employee->employee_id ?? '-'); ?></span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-slate-600 dark:text-slate-400">
                                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'briefcase','class' => 'w-4 h-4 mr-3 text-slate-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'briefcase','class' => 'w-4 h-4 mr-3 text-slate-400']); ?>
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
                                <span class="text-sm">Position</span>
                            </div>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300 truncate max-w-[140px]" title="<?php echo e($employee->positionRelation->title ?? $employee->position ?? '-'); ?>"><?php echo e($employee->positionRelation->title ?? $employee->position ?? '-'); ?></span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-slate-600 dark:text-slate-400">
                                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'building-2','class' => 'w-4 h-4 mr-3 text-slate-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'building-2','class' => 'w-4 h-4 mr-3 text-slate-400']); ?>
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
                                <span class="text-sm">Department</span>
                            </div>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300 truncate max-w-[140px]" title="<?php echo e($employee->department->name ?? '-'); ?>"><?php echo e($employee->department->name ?? '-'); ?></span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-slate-600 dark:text-slate-400">
                                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'building','class' => 'w-4 h-4 mr-3 text-slate-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'building','class' => 'w-4 h-4 mr-3 text-slate-400']); ?>
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
                                <span class="text-sm">Company</span>
                            </div>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300 truncate max-w-[140px]" title="<?php echo e($employee->company->name ?? '-'); ?>"><?php echo e($employee->company->name ?? '-'); ?></span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-slate-600 dark:text-slate-400">
                                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'banknote','class' => 'w-4 h-4 mr-3 text-slate-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'banknote','class' => 'w-4 h-4 mr-3 text-slate-400']); ?>
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
                                <span class="text-sm">Salary</span>
                            </div>
                            <span class="text-sm font-medium text-emerald-600 dark:text-emerald-400"><?php echo e($employee->salary ? number_format($employee->salary, 2) : '-'); ?></span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-slate-600 dark:text-slate-400">
                                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'calendar','class' => 'w-4 h-4 mr-3 text-slate-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'calendar','class' => 'w-4 h-4 mr-3 text-slate-400']); ?>
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
                                <span class="text-sm">Hire Date</span>
                            </div>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300"><?php echo e($employee->hire_date ? $employee->hire_date->format('d M Y') : '-'); ?></span>
                        </div>
                    </div>
                </div>

                <!-- Basic Information -->
                <div class="border-t border-slate-200/60 dark:border-darkmode-400 px-5 py-5">
                    <h4 class="text-base font-semibold text-slate-800 dark:text-white mb-4">Personal Info</h4>
                    <div class="space-y-3">
                        <?php if($employee->birth_date): ?>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-slate-600 dark:text-slate-400">
                                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'cake','class' => 'w-4 h-4 mr-3 text-slate-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'cake','class' => 'w-4 h-4 mr-3 text-slate-400']); ?>
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
                                <span class="text-sm">Birthday</span>
                            </div>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300"><?php echo e($employee->birth_date->format('d M Y')); ?></span>
                        </div>
                        <?php endif; ?>

                        <?php if($employee->gender): ?>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-slate-600 dark:text-slate-400">
                                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'user','class' => 'w-4 h-4 mr-3 text-slate-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'user','class' => 'w-4 h-4 mr-3 text-slate-400']); ?>
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
                                <span class="text-sm">Gender</span>
                            </div>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300"><?php echo e(ucfirst($employee->gender)); ?></span>
                        </div>
                        <?php endif; ?>

                        <?php if($employee->phone): ?>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-slate-600 dark:text-slate-400">
                                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'phone','class' => 'w-4 h-4 mr-3 text-slate-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'phone','class' => 'w-4 h-4 mr-3 text-slate-400']); ?>
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
                                <span class="text-sm">Phone</span>
                            </div>
                            <a href="tel:<?php echo e($employee->phone); ?>" class="text-sm font-medium text-primary hover:underline"><?php echo e($employee->phone); ?></a>
                        </div>
                        <?php endif; ?>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-slate-600 dark:text-slate-400">
                                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'mail','class' => 'w-4 h-4 mr-3 text-slate-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'mail','class' => 'w-4 h-4 mr-3 text-slate-400']); ?>
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
                                <span class="text-sm">E-Mail</span>
                            </div>
                            <a href="mailto:<?php echo e($employee->email); ?>" class="text-sm font-medium text-primary hover:underline truncate max-w-[140px]" title="<?php echo e($employee->email); ?>"><?php echo e($employee->email); ?></a>
                        </div>

                        <?php if($employee->nationality): ?>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-slate-600 dark:text-slate-400">
                                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'flag','class' => 'w-4 h-4 mr-3 text-slate-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'flag','class' => 'w-4 h-4 mr-3 text-slate-400']); ?>
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
                                <span class="text-sm">Nationality</span>
                            </div>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300"><?php echo e($employee->nationality); ?></span>
                        </div>
                        <?php endif; ?>

                        <?php if($employee->city || $employee->country): ?>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-slate-600 dark:text-slate-400">
                                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'map-pin','class' => 'w-4 h-4 mr-3 text-slate-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'map-pin','class' => 'w-4 h-4 mr-3 text-slate-400']); ?>
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
                                <span class="text-sm">Location</span>
                            </div>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300"><?php echo e(implode(', ', array_filter([$employee->city, $employee->country]))); ?></span>
                        </div>
                        <?php endif; ?>

                        <?php if($employee->address): ?>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-slate-600 dark:text-slate-400">
                                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'home','class' => 'w-4 h-4 mr-3 text-slate-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'home','class' => 'w-4 h-4 mr-3 text-slate-400']); ?>
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
                                <span class="text-sm">Address</span>
                            </div>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300 truncate max-w-[140px]" title="<?php echo e($employee->address); ?>"><?php echo e($employee->address); ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Documents Section -->
                <?php
                    $documents = $employee->documents()->latest()->take(4)->get();
                ?>
                <?php if($documents->count() > 0): ?>
                <div class="border-t border-slate-200/60 dark:border-darkmode-400 px-5 py-5">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-base font-semibold text-slate-800 dark:text-white">Documents</h4>
                        <a href="<?php echo e(route('hr.employees.documents.index', ['employee' => $employee->id])); ?>" class="text-xs text-primary hover:underline">View All</a>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <?php $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $extension = strtolower(pathinfo($doc->file_name ?? $doc->original_name ?? '', PATHINFO_EXTENSION));
                            $iconBg = match($extension) {
                                'pdf' => 'bg-red-100 dark:bg-red-900/30',
                                'doc', 'docx' => 'bg-blue-100 dark:bg-blue-900/30',
                                'xls', 'xlsx' => 'bg-green-100 dark:bg-green-900/30',
                                'ppt', 'pptx' => 'bg-orange-100 dark:bg-orange-900/30',
                                'jpg', 'jpeg', 'png', 'gif' => 'bg-purple-100 dark:bg-purple-900/30',
                                default => 'bg-slate-100 dark:bg-slate-700'
                            };
                            $iconColor = match($extension) {
                                'pdf' => 'text-red-600 dark:text-red-400',
                                'doc', 'docx' => 'text-blue-600 dark:text-blue-400',
                                'xls', 'xlsx' => 'text-green-600 dark:text-green-400',
                                'ppt', 'pptx' => 'text-orange-600 dark:text-orange-400',
                                'jpg', 'jpeg', 'png', 'gif' => 'text-purple-600 dark:text-purple-400',
                                default => 'text-slate-600 dark:text-slate-400'
                            };
                            $fileSize = $doc->file_size ? round($doc->file_size / 1024, 1) . ' KB' : '';
                        ?>
                        <a href="<?php echo e($doc->file_url ?? '#'); ?>" target="_blank" class="flex items-center gap-3 p-3 rounded-xl <?php echo e($iconBg); ?> hover:opacity-80 transition-opacity">
                            <div class="flex-shrink-0">
                                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'file-text','class' => 'w-6 h-6 '.e($iconColor).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'file-text','class' => 'w-6 h-6 '.e($iconColor).'']); ?>
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
                            <div class="min-w-0">
                                <p class="text-xs font-medium text-slate-700 dark:text-slate-300 truncate"><?php echo e($doc->title ?? $doc->document_type ?? 'Document'); ?></p>
                                <?php if($fileSize): ?>
                                <p class="text-[10px] text-slate-500 dark:text-slate-400"><?php echo e($fileSize); ?></p>
                                <?php endif; ?>
                            </div>
                        </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Statistics Section -->
                <div class="border-t border-slate-200/60 dark:border-darkmode-400 px-5 py-5">
                    <h4 class="text-base font-semibold text-slate-800 dark:text-white mb-4">Statistics</h4>
                    <?php
                        $taskStats = [
                            'total' => $employee->assignedTasks()->count(),
                            'completed' => $employee->assignedTasks()->where('status', 'completed')->count(),
                        ];
                        // Calculate years and months of service properly
                        $yearsOfService = 0;
                        $monthsOfService = 0;
                        $daysOfService = 0;
                        if ($employee->hire_date) {
                            $hireDate = $employee->hire_date;
                            $now = now();
                            $yearsOfService = (int) $hireDate->diffInYears($now);
                            $monthsOfService = (int) $hireDate->copy()->addYears($yearsOfService)->diffInMonths($now);
                            $daysOfService = (int) $hireDate->diffInDays($now);
                        }
                        $leavesTaken = (int) ($employee->leaves()->where('status', 'approved')->sum('days_count') ?? 0);
                    ?>

                    <div class="space-y-4">
                        <!-- Years of Service -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-slate-600 dark:text-slate-400">Years of Service</span>
                                <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">
                                    <?php if($yearsOfService > 0): ?>
                                        <?php echo e($yearsOfService); ?> yr<?php echo e($yearsOfService > 1 ? 's' : ''); ?> <?php echo e($monthsOfService); ?> mo
                                    <?php elseif($monthsOfService > 0): ?>
                                        <?php echo e($monthsOfService); ?> month<?php echo e($monthsOfService > 1 ? 's' : ''); ?>

                                    <?php else: ?>
                                        <?php echo e($daysOfService); ?> day<?php echo e($daysOfService > 1 ? 's' : ''); ?>

                                    <?php endif; ?>
                                </span>
                            </div>
                            <div class="h-2 w-full overflow-hidden rounded-full bg-slate-200 dark:bg-darkmode-600">
                                <div class="h-full rounded-full bg-gradient-to-r from-amber-400 to-orange-500" style="width: <?php echo e(min(100, max(5, $yearsOfService * 10 + $monthsOfService))); ?>%"></div>
                            </div>
                        </div>

                        <!-- Tasks Completed -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-slate-600 dark:text-slate-400">Tasks Completed</span>
                                <span class="text-sm font-semibold text-slate-700 dark:text-slate-300"><?php echo e($taskStats['completed']); ?>/<?php echo e($taskStats['total']); ?></span>
                            </div>
                            <div class="h-2 w-full overflow-hidden rounded-full bg-slate-200 dark:bg-darkmode-600">
                                <?php $taskPercent = $taskStats['total'] > 0 ? ($taskStats['completed'] / $taskStats['total']) * 100 : 0; ?>
                                <div class="h-full rounded-full bg-gradient-to-r from-emerald-400 to-green-500" style="width: <?php echo e($taskPercent); ?>%"></div>
                            </div>
                        </div>

                        <!-- Leaves Taken -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-slate-600 dark:text-slate-400">Leaves Taken</span>
                                <span class="text-sm font-semibold text-slate-700 dark:text-slate-300"><?php echo e($leavesTaken); ?> day<?php echo e($leavesTaken != 1 ? 's' : ''); ?></span>
                            </div>
                            <div class="h-2 w-full overflow-hidden rounded-full bg-slate-200 dark:bg-darkmode-600">
                                <div class="h-full rounded-full bg-gradient-to-r from-blue-400 to-indigo-500" style="width: <?php echo e(min(100, $leavesTaken * 3)); ?>%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="border-t border-slate-200/60 dark:border-darkmode-400 p-4 flex gap-2">
                    <a href="<?php echo e(route('hr.employees.edit', $employee)); ?>" class="flex-1 btn-tonal btn-tonal--warning text-center py-2 rounded-lg text-sm font-medium">
                        <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'edit','class' => 'w-4 h-4 inline mr-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'edit','class' => 'w-4 h-4 inline mr-1']); ?>
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
                    <a href="mailto:<?php echo e($employee->email); ?>" class="flex-1 btn-tonal btn-tonal--info text-center py-2 rounded-lg text-sm font-medium">
                        <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'mail','class' => 'w-4 h-4 inline mr-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'mail','class' => 'w-4 h-4 inline mr-1']); ?>
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
                        Email
                    </a>
                </div>
            </div>
        </div>
        <!-- END: Profile Card -->
        <div class="col-span-12 lg:col-span-8 2xl:col-span-9">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: Performance & Rewards -->
                <div class="intro-y box col-span-12 2xl:col-span-6" id="performance-rewards">
                    <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
                        <h2 class="mr-auto text-base font-medium flex items-center">
                            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Star','class' => 'w-5 h-5 mr-2 text-amber-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Star','class' => 'w-5 h-5 mr-2 text-amber-400']); ?>
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
                            Performance & Rewards
                        </h2>
                    </div>
                    <div class="p-5">
                        <div class="grid grid-cols-12 gap-4">
                            <!-- Rating card -->
                            <div class="col-span-12">
                                <div class="rounded-lg border border-slate-200/60 p-4 dark:border-darkmode-400 bg-gradient-to-br from-amber-50/80 to-white dark:from-darkmode-600 dark:to-darkmode-700">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="text-sm font-medium text-slate-700 dark:text-slate-100">Overall Rating</div>
                                        <?php $avgRating = $employee->average_rating; ?>
                                        <div class="text-xs text-slate-500 dark:text-slate-400">
                                            <?php echo e($avgRating ? $avgRating . ' / 10' : 'Not rated yet'); ?>

                                        </div>
                                    </div>
                                    <div class="flex items-center mb-3">
                                        <?php for($i = 1; $i <= 10; $i++): ?>
                                            <?php $filled = $avgRating && $avgRating >= $i; ?>
                                            <div class="transition-transform duration-200 hover:scale-110">
                                                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Star','class' => 'w-5 h-5 mr-1 '.e($filled ? 'text-amber-400 fill-amber-300/80' : 'text-slate-300 dark:text-slate-600').'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Star','class' => 'w-5 h-5 mr-1 '.e($filled ? 'text-amber-400 fill-amber-300/80' : 'text-slate-300 dark:text-slate-600').'']); ?>
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
                                        <?php endfor; ?>
                                        <span class="ml-2 text-xs text-slate-500 dark:text-slate-400">
                                            <?php echo e($avgRating ? $avgRating . ' / 10' : 'Not rated yet'); ?>

                                        </span>
                                    </div>
                                    <?php
                                        $latestEvaluations = $employee->evaluations()->latest('evaluated_at')->latest()->take(3)->get();
                                    ?>
                                    <?php if($latestEvaluations->count()): ?>
                                        <div class="space-y-2 max-h-40 overflow-y-auto text-xs">
                                            <?php $__currentLoopData = $latestEvaluations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $eval): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="flex items-start justify-between rounded-md bg-white/60 dark:bg-darkmode-600/80 px-3 py-2">
                                                    <div class="mr-2">
                                                        <div class="font-medium text-slate-800 dark:text-slate-100">
                                                            <?php echo e($eval->overall_rating); ?> ★
                                                        </div>
                                                        <?php if($eval->comments): ?>
                                                            <div class="text-[11px] text-slate-500 dark:text-slate-400 line-clamp-2"><?php echo e($eval->comments); ?></div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="text-right text-[11px] text-slate-400">
                                                        <?php if($eval->evaluated_at): ?>
                                                            <div><?php echo e($eval->evaluated_at->format('Y-m-d')); ?></div>
                                                        <?php endif; ?>
                                                        <?php if($eval->evaluator): ?>
                                                            <div>by <?php echo e($eval->evaluator->name); ?></div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-xs text-slate-500 dark:text-slate-400">
                                            No evaluations recorded yet.
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Rewards card -->
                            <div class="col-span-12">
                                <div class="rounded-lg border border-slate-200/60 p-4 dark:border-darkmode-400 bg-gradient-to-br from-emerald-50/80 to-white dark:from-darkmode-600 dark:to-darkmode-700">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="text-sm font-medium text-slate-700 dark:text-slate-100 flex items-center">
                                            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Gift','class' => 'w-4 h-4 mr-2 text-emerald-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Gift','class' => 'w-4 h-4 mr-2 text-emerald-500']); ?>
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
                                            Rewards & Points
                                        </div>
                                    </div>
                                    <?php
                                        $totalPoints = $employee->total_points;
                                        $rewards = $employee->rewards()->latest('granted_at')->latest()->take(3)->get();
                                    ?>
                                    <div class="mb-3">
                                        <div class="flex items-center justify-between text-xs text-slate-500 dark:text-slate-400 mb-1">
                                            <span>Total Points</span>
                                            <span class="font-semibold text-emerald-600 dark:text-emerald-400"><?php echo e($totalPoints); ?></span>
                                        </div>
                                        <div class="h-2 w-full overflow-hidden rounded-full bg-slate-100 dark:bg-darkmode-600">
                                            <?php $progress = min(100, ($totalPoints / 100) * 100); ?>
                                            <div class="h-full rounded-full bg-emerald-500 transition-all duration-500" style="width: <?php echo e($progress); ?>%"></div>
                                        </div>
                                    </div>

                                    <?php if($rewards->count()): ?>
                                        <div class="space-y-2 max-h-40 overflow-y-auto text-xs">
                                            <?php $__currentLoopData = $rewards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reward): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="flex items-start justify-between rounded-md bg-white/60 dark:bg-darkmode-600/80 px-3 py-2">
                                                    <div class="mr-2">
                                                        <div class="font-medium text-slate-800 dark:text-slate-100 flex items-center">
                                                            <span class="mr-1">+<?php echo e($reward->points); ?> pts</span>
                                                            <?php if($reward->amount): ?>
                                                                <span class="text-[11px] text-emerald-600">(<?php echo e(format_currency($reward->amount, 2)); ?>)</span>
                                                            <?php endif; ?>
                                                        </div>
                                                        <?php if($reward->reason): ?>
                                                            <div class="text-[11px] text-slate-500 dark:text-slate-400 line-clamp-2"><?php echo e($reward->reason); ?></div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="text-right text-[11px] text-slate-400">
                                                        <?php if($reward->granted_at): ?>
                                                            <div><?php echo e($reward->granted_at->format('Y-m-d')); ?></div>
                                                        <?php endif; ?>
                                                        <?php if($reward->granter): ?>
                                                            <div>by <?php echo e($reward->granter->name); ?></div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-xs text-slate-500 dark:text-slate-400">
                                            No rewards recorded yet.
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Task Likes card -->
                            <div class="col-span-12">
                                <div class="rounded-lg border border-slate-200/60 p-4 dark:border-darkmode-400 bg-gradient-to-br from-pink-50/80 to-white dark:from-darkmode-600 dark:to-darkmode-700">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="text-sm font-medium text-slate-700 dark:text-slate-100 flex items-center">
                                            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'heart','class' => 'w-4 h-4 mr-2 text-pink-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'heart','class' => 'w-4 h-4 mr-2 text-pink-500']); ?>
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
                                            Task Likes
                                        </div>
                                    </div>
                                    <?php
                                        $taskLikesCount = $employee->task_likes_count ?? 0;
                                        $taskLikesPoints = $employee->task_likes_points ?? 0;
                                        $totalPointsWithLikes = $employee->total_points_with_likes ?? $totalPoints;
                                    ?>
                                    <div class="grid grid-cols-3 gap-3 mb-3">
                                        <div class="text-center p-3 rounded-lg bg-white/60 dark:bg-darkmode-600/80">
                                            <div class="text-2xl font-bold text-pink-500"><?php echo e($taskLikesCount); ?></div>
                                            <div class="text-[11px] text-slate-500">Total Likes</div>
                                        </div>
                                        <div class="text-center p-3 rounded-lg bg-white/60 dark:bg-darkmode-600/80">
                                            <div class="text-2xl font-bold text-emerald-500">+<?php echo e($taskLikesPoints); ?></div>
                                            <div class="text-[11px] text-slate-500">Points from Likes</div>
                                        </div>
                                        <div class="text-center p-3 rounded-lg bg-white/60 dark:bg-darkmode-600/80">
                                            <div class="text-2xl font-bold text-amber-500"><?php echo e($totalPointsWithLikes); ?></div>
                                            <div class="text-[11px] text-slate-500">Total Points</div>
                                        </div>
                                    </div>
                                    <div class="text-xs text-slate-500 dark:text-slate-400 text-center">
                                        <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'info','class' => 'w-3 h-3 inline mr-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'info','class' => 'w-3 h-3 inline mr-1']); ?>
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
                                        Each like on completed tasks adds 1 point to the employee's score
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Performance & Rewards -->

                <!-- BEGIN: Approval Signature -->
                <div class="intro-y box col-span-12 2xl:col-span-6" id="approval-signature">
                    <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
                        <h2 class="mr-auto text-base font-medium flex items-center gap-2">
                            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'PenSquare','class' => 'h-4 w-4 text-primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'PenSquare','class' => 'h-4 w-4 text-primary']); ?>
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
                            Approval Signature
                        </h2>
                    </div>
                    <div class="p-5">
                        <?php
                            $linkedUser = $employee->user;
                            $signatureUrl = $linkedUser?->signature_url;
                            $canManageSignature = $linkedUser && $linkedUser->id === auth()->id();
                        ?>

                        <?php if(!$linkedUser): ?>
                            <div class="rounded-md border border-slate-200/60 bg-slate-50 px-4 py-3 text-sm text-slate-600 dark:border-darkmode-400 dark:bg-darkmode-600 dark:text-slate-300">
                                This employee is not linked to a system user, so no signature can be stored.
                            </div>
                        <?php else: ?>
                            <div class="rounded-lg border-2 border-dashed border-slate-200/80 bg-white/60 p-5 text-center dark:border-darkmode-400 dark:bg-darkmode-700/40">
                                <?php if($signatureUrl): ?>
                                    <img
                                        src="<?php echo e($signatureUrl); ?>"
                                        alt="<?php echo e($employee->full_name); ?> signature"
                                        class="mx-auto max-h-32"
                                    />
                                    <div class="mt-2 text-xs text-slate-500">Stored on <?php echo e($linkedUser->updated_at?->format('Y-m-d') ?? '—'); ?></div>
                                <?php else: ?>
                                    <div class="text-sm font-medium text-slate-500 dark:text-slate-300">
                                        No signature on file yet
                                    </div>
                                <?php endif; ?>
                            </div>

                            <?php if($canManageSignature): ?>
                                <form
                                    class="mt-5 space-y-4"
                                    action="<?php echo e(route('profile.signature.update')); ?>"
                                    method="POST"
                                    enctype="multipart/form-data"
                                >
                                    <?php echo csrf_field(); ?>
                                    <div class="text-left">
                                        <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['class' => 'text-xs uppercase tracking-wide text-slate-500','for' => 'signature']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'text-xs uppercase tracking-wide text-slate-500','for' => 'signature']); ?>
                                            Upload New Signature (PNG / JPG / WEBP up to 2MB)
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'signature','name' => 'signature','type' => 'file','accept' => 'image/png,image/jpeg,image/webp,image/svg+xml']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'signature','name' => 'signature','type' => 'file','accept' => 'image/png,image/jpeg,image/webp,image/svg+xml']); ?>
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
                                        <?php $__errorArgs = ['signature', 'profileSignature'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <p class="mt-2 text-xs text-danger"><?php echo e($message); ?></p>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="flex flex-wrap gap-2">
                                        <?php if (isset($component)) { $__componentOriginale00eb601fbe667f0da582732d70c41c5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale00eb601fbe667f0da582732d70c41c5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.button.index','data' => ['type' => 'submit','variant' => 'primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','variant' => 'primary']); ?>
                                            Save Signature
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

                                        <?php if($linkedUser->signature_path): ?>
                                            <button
                                                type="submit"
                                                name="remove_signature"
                                                value="1"
                                                class="btn btn-danger"
                                            >
                                                Remove Signature
                                            </button>
                                        <?php endif; ?>
                                    </div>

                                    <?php if(session('profile_signature_status')): ?>
                                        <div class="rounded border border-success/40 bg-success/10 px-3 py-2 text-xs text-success">
                                            <?php echo e(session('profile_signature_status')); ?>

                                        </div>
                                    <?php endif; ?>
                                </form>
                            <?php else: ?>
                                <div class="mt-4 rounded-md bg-slate-100/80 px-4 py-3 text-sm text-slate-600 dark:bg-darkmode-600 dark:text-slate-300">
                                    Only the employee can update their stored signature. Ask <?php echo e($employee->full_name); ?> to sign in and upload it here.
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- END: Approval Signature -->

                <!-- BEGIN: Documents -->
                <div class="intro-y box col-span-12 2xl:col-span-6" id="documents">
                    <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
                        <h2 class="mr-auto text-base font-medium">Documents</h2>
                        <?php if (isset($component)) { $__componentOriginale00eb601fbe667f0da582732d70c41c5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale00eb601fbe667f0da582732d70c41c5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.button.index','data' => ['as' => 'a','href' => ''.e(route('hr.employees.documents.index', ['employee' => $employee->id])).'','variant' => 'outline-secondary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['as' => 'a','href' => ''.e(route('hr.employees.documents.index', ['employee' => $employee->id])).'','variant' => 'outline-secondary']); ?>
                            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['class' => 'mr-2 h-4 w-4','icon' => 'ExternalLink']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mr-2 h-4 w-4','icon' => 'ExternalLink']); ?>
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
                            Manage
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
                    <div class="p-5">
                        <?php
                            $recentDocuments = $employee->documents()->active()->latest()->take(3)->get();
                        ?>

                        <?php if($recentDocuments->count() > 0): ?>
                            <div class="space-y-3">
                                <?php $__currentLoopData = $recentDocuments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flex items-center justify-between p-3 border border-slate-200/60 rounded-lg dark:border-darkmode-400">
                                        <div class="flex items-center">
                                            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['class' => 'h-8 w-8 text-slate-400 mr-3','icon' => 'FileText']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-8 w-8 text-slate-400 mr-3','icon' => 'FileText']); ?>
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
                                            <div>
                                                <div class="font-medium text-sm"><?php echo e($document->document_name); ?></div>
                                                <div class="text-xs text-slate-500"><?php echo e($document->document_type_formatted); ?></div>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <?php if($document->file_path): ?>
                                                <?php if (isset($component)) { $__componentOriginale00eb601fbe667f0da582732d70c41c5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale00eb601fbe667f0da582732d70c41c5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.button.index','data' => ['as' => 'a','href' => ''.e(route('hr.employees.documents.download', ['employee' => $employee->id, 'document' => $document->id])).'','variant' => 'outline-secondary','size' => 'xs','title' => 'Download']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['as' => 'a','href' => ''.e(route('hr.employees.documents.download', ['employee' => $employee->id, 'document' => $document->id])).'','variant' => 'outline-secondary','size' => 'xs','title' => 'Download']); ?>
                                                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Download','class' => 'w-3 h-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Download','class' => 'w-3 h-3']); ?>
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
                                            <?php endif; ?>
                                            <?php if($document->expiry_date && $document->is_expired): ?>
                                                <span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded">Expired</span>
                                            <?php elseif($document->expiry_date && $document->is_expiring_soon): ?>
                                                <span class="px-2 py-1 text-xs bg-orange-100 text-orange-700 rounded">Expiring Soon</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <?php if($employee->documents()->active()->count() > 3): ?>
                                <div class="mt-4 text-center">
                                    <a href="<?php echo e(route('hr.employees.documents.index', ['employee' => $employee->id])); ?>"
                                       class="text-primary hover:text-primary/80 text-sm">
                                        View all <?php echo e($employee->documents()->active()->count()); ?> documents
                                    </a>
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="flex flex-col items-center justify-center py-10">
                                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['class' => 'h-12 w-12 text-slate-400 mb-4','icon' => 'FileText']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-12 w-12 text-slate-400 mb-4','icon' => 'FileText']); ?>
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
                                <div class="text-slate-500 text-center mb-2">No documents uploaded</div>
                                <a href="<?php echo e(route('hr.employees.documents.index', ['employee' => $employee->id])); ?>"
                                   class="text-primary hover:text-primary/80 text-sm">
                                    Add first document
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- END: Documents -->

                <!-- BEGIN: Assigned Tasks (New Design) -->
                <div class="intro-y box col-span-12" id="assigned-tasks">
                    <div class="flex items-center border-b border-slate-200/60 px-5 py-4 dark:border-darkmode-400">
                        <h2 class="mr-auto text-base font-semibold text-slate-800 dark:text-white flex items-center">
                            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'clipboard-list','class' => 'w-5 h-5 mr-2 text-amber-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'clipboard-list','class' => 'w-5 h-5 mr-2 text-amber-500']); ?>
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
                            Assigned Tasks
                        </h2>
                        <span class="text-xs text-slate-500 mr-3"><?php echo e($employee->assignedTasks()->count()); ?> tasks</span>
                        <a href="<?php echo e(route('tasks.index', ['employee_id' => $employee->id])); ?>" class="btn-royal btn-royal--outline btn-royal--sm">
                            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['class' => 'mr-1 h-3 w-3','icon' => 'external-link']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mr-1 h-3 w-3','icon' => 'external-link']); ?>
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
                            View All
                        </a>
                    </div>
                    <div class="p-5">
                        <?php
                            $assignedTasks = $employee->assignedTasks()->with(['project', 'assignee'])->latest()->take(8)->get();
                        ?>

                        <?php if($assignedTasks->count() > 0): ?>
                            <div class="space-y-4">
                                <?php $__currentLoopData = $assignedTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $progress = $task->progress_percentage ?? 0;
                                        $progressColor = $progress >= 100 ? 'bg-slate-800' : ($progress >= 50 ? 'bg-amber-400' : 'bg-slate-300');
                                    ?>
                                    <a href="<?php echo e(route('tasks.show', $task)); ?>" class="flex items-center gap-4 p-3 rounded-xl bg-slate-50/50 dark:bg-darkmode-600/50 hover:bg-slate-100/80 dark:hover:bg-darkmode-500/50 transition-colors cursor-pointer group">
                                        <div class="flex-shrink-0">
                                            <?php if($task->assignee && $task->assignee->profile_picture_url): ?>
                                                <img src="<?php echo e($task->assignee->profile_picture_url); ?>" alt="<?php echo e($task->assignee->full_name); ?>" class="h-12 w-12 rounded-full object-cover border-2 border-white shadow-sm" />
                                            <?php else: ?>
                                                <div class="h-12 w-12 rounded-full bg-gradient-to-br from-amber-100 to-orange-100 dark:from-amber-900/30 dark:to-orange-900/30 flex items-center justify-center border-2 border-white shadow-sm">
                                                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'check-square','class' => 'w-5 h-5 text-amber-600 dark:text-amber-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'check-square','class' => 'w-5 h-5 text-amber-600 dark:text-amber-400']); ?>
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
                                            <?php endif; ?>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between mb-1">
                                                <span class="font-semibold text-slate-800 dark:text-white group-hover:text-primary truncate transition-colors">
                                                    <?php echo e($task->title); ?>

                                                </span>
                                                <?php if($task->status === 'completed'): ?>
                                                    <span class="text-xs px-2 py-0.5 rounded-full bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 flex-shrink-0 ml-2">Done</span>
                                                <?php elseif($task->status === 'in_progress'): ?>
                                                    <span class="text-xs px-2 py-0.5 rounded-full bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 flex-shrink-0 ml-2">In Progress</span>
                                                <?php else: ?>
                                                    <span class="text-xs px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-400 flex-shrink-0 ml-2"><?php echo e(ucfirst($task->status)); ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <p class="text-sm text-slate-500 dark:text-slate-400 mb-2 truncate"><?php echo e($task->project->name ?? 'No Project'); ?></p>
                                            <div class="flex items-center gap-3">
                                                <div class="flex-1 h-2 rounded-full bg-slate-200 dark:bg-darkmode-400 overflow-hidden">
                                                    <div class="h-full rounded-full <?php echo e($progressColor); ?> transition-all duration-300" style="width: <?php echo e($progress); ?>%"></div>
                                                </div>
                                                <span class="text-xs font-medium text-slate-600 dark:text-slate-400 w-10 text-right"><?php echo e($progress); ?>%</span>
                                            </div>
                                        </div>
                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            
                            <?php
                                $totalTasks = $employee->assignedTasks()->count();
                                $completedTasks = $employee->assignedTasks()->where('status', 'completed')->count();
                                $pendingTasks = $employee->assignedTasks()->where('status', 'pending')->count();
                                $inProgressTasks = $employee->assignedTasks()->where('status', 'in_progress')->count();
                            ?>
                            
                            <?php if($totalTasks > 5): ?>
                                <div class="mt-4 text-center">
                                    <a href="<?php echo e(route('tasks.index', ['employee_id' => $employee->id])); ?>"
                                       class="text-primary hover:text-primary/80 text-sm">
                                        View all <?php echo e($totalTasks); ?> tasks
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Task Statistics -->
                            <div class="mt-6 grid grid-cols-4 gap-4 pt-4 border-t border-slate-200/60 dark:border-darkmode-400">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-slate-700 dark:text-slate-300"><?php echo e($totalTasks); ?></div>
                                    <div class="text-xs text-slate-500">Total</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-green-600"><?php echo e($completedTasks); ?></div>
                                    <div class="text-xs text-slate-500">Completed</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-blue-600"><?php echo e($inProgressTasks); ?></div>
                                    <div class="text-xs text-slate-500">In Progress</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-yellow-600"><?php echo e($pendingTasks); ?></div>
                                    <div class="text-xs text-slate-500">Pending</div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="flex flex-col items-center justify-center py-10">
                                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['class' => 'h-12 w-12 text-slate-400 mb-4','icon' => 'CheckSquare']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-12 w-12 text-slate-400 mb-4','icon' => 'CheckSquare']); ?>
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
                                <div class="text-slate-500 text-center mb-2">No tasks assigned</div>
                                <a href="<?php echo e(route('tasks.create', ['employee_id' => $employee->id])); ?>"
                                   class="text-primary hover:text-primary/80 text-sm">
                                    Assign first task
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- END: Assigned Tasks -->

                <!-- BEGIN: Recent Activities -->
                <div class="intro-y box col-span-12">
                    <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
                        <h2 class="mr-auto text-base font-medium">Recent Activities</h2>
                    </div>
                    <div class="p-5">
                        <div class="flex flex-col items-center justify-center py-10">
                            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['class' => 'h-12 w-12 text-slate-400 mb-4','icon' => 'Activity']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-12 w-12 text-slate-400 mb-4','icon' => 'Activity']); ?>
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
                            <div class="text-slate-500 text-center">
                                No recent activities
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Recent Activities -->
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../themes/' . $activeTheme . '/' . $activeLayout, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\smart-erp\resources\views/hr/employees/show.blade.php ENDPATH**/ ?>
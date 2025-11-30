

<?php $__env->startSection('subhead'); ?>
    <title>Evaluation Details - <?php echo e($evaluation->employee->full_name ?? 'Employee'); ?></title>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    @media print {
        /* Hide everything except print content */
        body * {
            visibility: hidden;
        }
        
        #print-content, #print-content * {
            visibility: visible;
        }
        
        #print-content {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            padding: 20px;
            background: white !important;
        }
        
        /* Remove all backgrounds */
        body, html {
            background: white !important;
        }
        
        /* Page settings */
        @page {
            size: A4;
            margin: 1cm;
        }
    }
    
    .print-only { 
        display: none; 
    }
    
    @media print {
        .print-only { 
            display: block !important; 
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('subcontent'); ?>
    <?php echo $__env->make('components.global-notifications', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <div class="intro-y mt-6 mb-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 no-print">
        <h2 class="text-2xl font-semibold text-royalDark flex items-center gap-2">
            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'clipboard-check','class' => 'w-7 h-7']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'clipboard-check','class' => 'w-7 h-7']); ?>
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
            Evaluation Details
        </h2>
        <div class="flex items-center gap-2">
            <a href="<?php echo e(route('hr.employee-evaluations.index')); ?>" class="btn-royal btn-royal--outline btn-royal--sm">
                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'arrow-left','class' => 'w-4 h-4 mr-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'arrow-left','class' => 'w-4 h-4 mr-1']); ?>
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
                Back
            </a>
            <button onclick="window.print()" class="btn-royal btn-royal--outline btn-royal--sm">
                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'printer','class' => 'w-4 h-4 mr-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'printer','class' => 'w-4 h-4 mr-1']); ?>
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
                Print
            </button>
            <a href="<?php echo e(route('hr.employee-evaluations.export-pdf', $evaluation)); ?>" class="btn-royal btn-royal--gold btn-royal--sm">
                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'file-text','class' => 'w-4 h-4 mr-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'file-text','class' => 'w-4 h-4 mr-1']); ?>
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
                Export PDF
            </a>
        </div>
    </div>

    
    <div class="grid grid-cols-12 gap-6">
        
        <div class="col-span-12 lg:col-span-4 2xl:col-span-3">
            
            <div class="intro-y box overflow-hidden">
                <!-- Cover Image & Profile Picture -->
                <div class="relative">
                    <div class="h-32 bg-gradient-to-r from-amber-400 via-orange-400 to-yellow-300">
                        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20100%20100%22%3E%3Ccircle%20cx%3D%2250%22%20cy%3D%2250%22%20r%3D%2240%22%20fill%3D%22none%22%20stroke%3D%22rgba(255%2C255%2C255%2C0.2)%22%20stroke-width%3D%222%22%2F%3E%3Ccircle%20cx%3D%2250%22%20cy%3D%2250%22%20r%3D%2230%22%20fill%3D%22none%22%20stroke%3D%22rgba(255%2C255%2C255%2C0.15)%22%20stroke-width%3D%222%22%2F%3E%3Ccircle%20cx%3D%2250%22%20cy%3D%2250%22%20r%3D%2220%22%20fill%3D%22none%22%20stroke%3D%22rgba(255%2C255%2C255%2C0.1)%22%20stroke-width%3D%222%22%2F%3E%3C%2Fsvg%3E')] bg-cover opacity-50"></div>
                    </div>
                    <div class="absolute -bottom-12 left-1/2 -translate-x-1/2">
                        <div class="h-24 w-24 rounded-full border-4 border-white dark:border-darkmode-600 overflow-hidden shadow-lg bg-white">
                            <?php if($evaluation->employee->profile_picture): ?>
                                <img class="h-full w-full object-cover" src="<?php echo e(asset('storage/' . $evaluation->employee->profile_picture)); ?>" alt="<?php echo e($evaluation->employee->full_name); ?>" />
                            <?php else: ?>
                                <div class="h-full w-full flex items-center justify-center bg-slate-100">
                                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'user','class' => 'w-10 h-10 text-slate-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'user','class' => 'w-10 h-10 text-slate-400']); ?>
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
                    </div>
                </div>

                <!-- Name & Position -->
                <div class="pt-14 pb-5 px-5 text-center">
                    <a href="<?php echo e(route('hr.employees.show', $evaluation->employee)); ?>" class="text-xl font-semibold text-slate-800 dark:text-white hover:text-primary">
                        <?php echo e($evaluation->employee->full_name ?? 'N/A'); ?>

                    </a>
                    <p class="text-slate-500 dark:text-slate-400 text-sm mt-1"><?php echo e($evaluation->employee->position ?? 'Employee'); ?></p>
                    <div class="flex items-center justify-center gap-2 mt-2">
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300">
                            <?php echo e($evaluation->employee->code ?? $evaluation->employee->employee_id ?? '-'); ?>

                        </span>
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold <?php echo e($evaluation->employee->is_active ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400'); ?>">
                            <?php echo e($evaluation->employee->is_active ? 'Active' : 'Inactive'); ?>

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
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300 truncate max-w-[120px]"><?php echo e($evaluation->employee->department->name ?? '-'); ?></span>
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
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300 truncate max-w-[120px]"><?php echo e($evaluation->employee->position ?? '-'); ?></span>
                        </div>

                        <?php if($evaluation->employee->phone): ?>
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
                            <a href="tel:<?php echo e($evaluation->employee->phone); ?>" class="text-sm font-medium text-primary hover:underline"><?php echo e($evaluation->employee->phone); ?></a>
                        </div>
                        <?php endif; ?>

                        <?php if($evaluation->employee->email): ?>
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
                                <span class="text-sm">Email</span>
                            </div>
                            <a href="mailto:<?php echo e($evaluation->employee->email); ?>" class="text-sm font-medium text-primary hover:underline truncate max-w-[120px]"><?php echo e($evaluation->employee->email); ?></a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Evaluation Info -->
                <div class="border-t border-slate-200/60 dark:border-darkmode-400 px-5 py-5">
                    <h4 class="text-base font-semibold text-slate-800 dark:text-white mb-4">Evaluation Info</h4>
                    <div class="space-y-3">
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
                                <span class="text-sm">Date</span>
                            </div>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300"><?php echo e($evaluation->evaluated_at ? $evaluation->evaluated_at->format('M d, Y') : '-'); ?></span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-slate-600 dark:text-slate-400">
                                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'user-check','class' => 'w-4 h-4 mr-3 text-slate-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'user-check','class' => 'w-4 h-4 mr-3 text-slate-400']); ?>
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
                                <span class="text-sm">Evaluator</span>
                            </div>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300"><?php echo e($evaluation->evaluator->name ?? 'System'); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="intro-y box p-5 mt-5">
                <h4 class="text-sm font-semibold text-slate-600 dark:text-slate-300 mb-4 flex items-center gap-2">
                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'award','class' => 'w-4 h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'award','class' => 'w-4 h-4']); ?>
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
                    Overall Rating
                </h4>
                <?php
                    $overallStarColor = $evaluation->overall_rating >= 8 ? 'text-green-500 fill-green-400' : ($evaluation->overall_rating >= 5 ? 'text-amber-500 fill-amber-400' : 'text-red-500 fill-red-400');
                ?>
                <div class="text-center py-4">
                    <div class="text-6xl font-bold <?php echo e($evaluation->overall_rating >= 8 ? 'text-green-600' : ($evaluation->overall_rating >= 5 ? 'text-amber-600' : 'text-red-600')); ?>">
                        <?php echo e($evaluation->overall_rating); ?><span class="text-2xl text-slate-400">/10</span>
                    </div>
                    <div class="flex items-center justify-center gap-1 mt-3">
                        <?php for($i = 1; $i <= 10; $i++): ?>
                            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'star','class' => 'w-5 h-5 '.e($i <= $evaluation->overall_rating ? $overallStarColor : 'text-slate-300').'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'star','class' => 'w-5 h-5 '.e($i <= $evaluation->overall_rating ? $overallStarColor : 'text-slate-300').'']); ?>
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
                        <?php endfor; ?>
                    </div>
                    <div class="mt-3">
                        <?php if($evaluation->overall_rating >= 8): ?>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                Excellent Performance
                            </span>
                        <?php elseif($evaluation->overall_rating >= 5): ?>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400">
                                Good Performance
                            </span>
                        <?php else: ?>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                Needs Improvement
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-span-12 lg:col-span-8 2xl:col-span-9">
            <div class="intro-y box p-5">
                <h4 class="text-sm font-semibold text-slate-600 dark:text-slate-300 mb-4 flex items-center gap-2">
                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'list-checks','class' => 'w-4 h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'list-checks','class' => 'w-4 h-4']); ?>
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
                    Evaluation Criteria
                </h4>

                <?php if($evaluation->items->count() > 0): ?>
                    <div class="space-y-4">
                        <?php $__currentLoopData = $evaluation->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $starColor = $item->score >= 8 ? 'text-green-500 fill-green-400' : ($item->score >= 5 ? 'text-amber-500 fill-amber-400' : 'text-red-500 fill-red-400');
                            ?>
                            <div class="p-4 rounded-lg bg-slate-50 dark:bg-darkmode-600/50">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-medium text-slate-700 dark:text-slate-300">
                                        <?php echo e($item->criterion->name ?? 'Unknown Criterion'); ?>

                                    </span>
                                    <span class="font-bold <?php echo e($item->score >= 8 ? 'text-green-600' : ($item->score >= 5 ? 'text-amber-600' : 'text-red-600')); ?>">
                                        <?php echo e($item->score); ?>/10
                                    </span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <?php for($i = 1; $i <= 10; $i++): ?>
                                        <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'star','class' => 'w-4 h-4 '.e($i <= $item->score ? $starColor : 'text-slate-300').'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'star','class' => 'w-4 h-4 '.e($i <= $item->score ? $starColor : 'text-slate-300').'']); ?>
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
                                    <?php endfor; ?>
                                </div>
                                <?php if($item->notes): ?>
                                    <p class="mt-2 text-xs text-slate-500"><?php echo e($item->notes); ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-8 text-slate-500">
                        <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'clipboard-x','class' => 'w-12 h-12 mx-auto mb-3 text-slate-300']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'clipboard-x','class' => 'w-12 h-12 mx-auto mb-3 text-slate-300']); ?>
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
                        <p>No detailed criteria scores available.</p>
                    </div>
                <?php endif; ?>

                
                <?php if($evaluation->comments): ?>
                    <div class="mt-6 pt-6 border-t border-slate-200/60 dark:border-darkmode-400">
                        <h4 class="text-sm font-semibold text-slate-600 dark:text-slate-300 mb-3 flex items-center gap-2">
                            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'message-square','class' => 'w-4 h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'message-square','class' => 'w-4 h-4']); ?>
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
                            Comments
                        </h4>
                        <div class="p-4 rounded-lg bg-slate-50 dark:bg-darkmode-600/50">
                            <p class="text-sm text-slate-700 dark:text-slate-300 whitespace-pre-line"><?php echo e($evaluation->comments); ?></p>
                        </div>
                    </div>
                <?php endif; ?>

                
                <?php if($evaluation->items->count() > 0): ?>
                    <div class="mt-6 pt-6 border-t border-slate-200/60 dark:border-darkmode-400">
                        <h4 class="text-sm font-semibold text-slate-600 dark:text-slate-300 mb-4 flex items-center gap-2">
                            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'bar-chart-3','class' => 'w-4 h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'bar-chart-3','class' => 'w-4 h-4']); ?>
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
                            Performance Summary
                        </h4>
                        <div class="grid grid-cols-3 gap-4 text-center">
                            <div class="p-4 rounded-lg bg-green-50 dark:bg-green-900/20">
                                <div class="text-2xl font-bold text-green-600"><?php echo e($evaluation->items->where('score', '>=', 8)->count()); ?></div>
                                <div class="text-xs text-green-700 dark:text-green-400">Excellent</div>
                            </div>
                            <div class="p-4 rounded-lg bg-amber-50 dark:bg-amber-900/20">
                                <div class="text-2xl font-bold text-amber-600"><?php echo e($evaluation->items->whereBetween('score', [5, 7])->count()); ?></div>
                                <div class="text-xs text-amber-700 dark:text-amber-400">Good</div>
                            </div>
                            <div class="p-4 rounded-lg bg-red-50 dark:bg-red-900/20">
                                <div class="text-2xl font-bold text-red-600"><?php echo e($evaluation->items->where('score', '<', 5)->count()); ?></div>
                                <div class="text-xs text-red-700 dark:text-red-400">Needs Work</div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <div class="print-only" id="print-content">
        <div style="text-align: center; border-bottom: 3px solid #1e293b; padding-bottom: 15px; margin-bottom: 20px;">
            <h1 style="font-size: 22px; font-weight: bold; margin: 0; text-transform: uppercase; letter-spacing: 2px;">Employee Performance Evaluation</h1>
            <p style="font-size: 12px; color: #64748b; margin: 5px 0 0 0;"><?php echo e(config('app.name')); ?> | <?php echo e($evaluation->evaluated_at ? $evaluation->evaluated_at->format('F d, Y') : now()->format('F d, Y')); ?></p>
        </div>
        
        
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <tr>
                <td style="padding: 8px; border: 1px solid #cbd5e1; font-weight: bold; width: 25%;">Employee Name</td>
                <td style="padding: 8px; border: 1px solid #cbd5e1; width: 25%;"><?php echo e($evaluation->employee->full_name ?? 'N/A'); ?></td>
                <td style="padding: 8px; border: 1px solid #cbd5e1; font-weight: bold; width: 25%;">Employee ID</td>
                <td style="padding: 8px; border: 1px solid #cbd5e1; width: 25%;"><?php echo e($evaluation->employee->employee_number ?? $evaluation->employee->code ?? '-'); ?></td>
            </tr>
            <tr>
                <td style="padding: 8px; border: 1px solid #cbd5e1; font-weight: bold;">Department</td>
                <td style="padding: 8px; border: 1px solid #cbd5e1;"><?php echo e($evaluation->employee->department->name ?? '-'); ?></td>
                <td style="padding: 8px; border: 1px solid #cbd5e1; font-weight: bold;">Position</td>
                <td style="padding: 8px; border: 1px solid #cbd5e1;"><?php echo e($evaluation->employee->position ?? '-'); ?></td>
            </tr>
            <tr>
                <td style="padding: 8px; border: 1px solid #cbd5e1; font-weight: bold;">Evaluated By</td>
                <td style="padding: 8px; border: 1px solid #cbd5e1;"><?php echo e($evaluation->evaluator->name ?? 'System'); ?></td>
                <td style="padding: 8px; border: 1px solid #cbd5e1; font-weight: bold;">Evaluation Date</td>
                <td style="padding: 8px; border: 1px solid #cbd5e1;"><?php echo e($evaluation->evaluated_at ? $evaluation->evaluated_at->format('F d, Y') : '-'); ?></td>
            </tr>
        </table>

        
        <?php
            $ratingColor = $evaluation->overall_rating >= 8 ? '#16a34a' : ($evaluation->overall_rating >= 5 ? '#d97706' : '#dc2626');
            $ratingLabel = $evaluation->overall_rating >= 8 ? 'Excellent Performance' : ($evaluation->overall_rating >= 5 ? 'Good Performance' : 'Needs Improvement');
        ?>
        <div style="text-align: center; padding: 20px; border: 2px solid <?php echo e($ratingColor); ?>; border-radius: 8px; margin-bottom: 20px;">
            <div style="font-size: 48px; font-weight: bold; color: <?php echo e($ratingColor); ?>;"><?php echo e($evaluation->overall_rating); ?>/10</div>
            <div style="font-size: 18px; margin-top: 5px;">
                <?php for($i = 1; $i <= 10; $i++): ?>
                    <span style="color: <?php echo e($i <= $evaluation->overall_rating ? '#1e293b' : '#cbd5e1'); ?>;">★</span>
                <?php endfor; ?>
            </div>
            <div style="font-size: 14px; font-weight: bold; color: <?php echo e($ratingColor); ?>; margin-top: 10px;"><?php echo e($ratingLabel); ?></div>
        </div>

        
        <?php if($evaluation->items->count() > 0): ?>
            <h3 style="font-size: 14px; font-weight: bold; margin-bottom: 10px; text-transform: uppercase; border-bottom: 1px solid #e2e8f0; padding-bottom: 5px;">Evaluation Criteria</h3>
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                <thead>
                    <tr style="background: #1e293b; color: white;">
                        <th style="padding: 10px; border: 1px solid #1e293b; text-align: left; width: 5%;">#</th>
                        <th style="padding: 10px; border: 1px solid #1e293b; text-align: left; width: 45%;">Criterion</th>
                        <th style="padding: 10px; border: 1px solid #1e293b; text-align: center; width: 15%;">Score</th>
                        <th style="padding: 10px; border: 1px solid #1e293b; text-align: left; width: 35%;">Rating</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $evaluation->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $itemColor = $item->score >= 8 ? '#16a34a' : ($item->score >= 5 ? '#d97706' : '#dc2626');
                        ?>
                        <tr>
                            <td style="padding: 8px; border: 1px solid #cbd5e1; text-align: center;"><?php echo e($index + 1); ?></td>
                            <td style="padding: 8px; border: 1px solid #cbd5e1;"><?php echo e($item->criterion->name ?? 'Unknown'); ?></td>
                            <td style="padding: 8px; border: 1px solid #cbd5e1; text-align: center; font-weight: bold; color: <?php echo e($itemColor); ?>;"><?php echo e($item->score); ?>/10</td>
                            <td style="padding: 8px; border: 1px solid #cbd5e1;">
                                <?php for($i = 1; $i <= 10; $i++): ?>
                                    <span style="color: <?php echo e($i <= $item->score ? '#1e293b' : '#cbd5e1'); ?>;">★</span>
                                <?php endfor; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                <tr>
                    <td style="width: 33%; padding: 15px; text-align: center; border: 2px solid #16a34a;">
                        <div style="font-size: 24px; font-weight: bold; color: #16a34a;"><?php echo e($evaluation->items->where('score', '>=', 8)->count()); ?></div>
                        <div style="font-size: 11px; text-transform: uppercase; color: #16a34a;">Excellent (8-10)</div>
                    </td>
                    <td style="width: 33%; padding: 15px; text-align: center; border: 2px solid #d97706;">
                        <div style="font-size: 24px; font-weight: bold; color: #d97706;"><?php echo e($evaluation->items->whereBetween('score', [5, 7])->count()); ?></div>
                        <div style="font-size: 11px; text-transform: uppercase; color: #d97706;">Good (5-7)</div>
                    </td>
                    <td style="width: 33%; padding: 15px; text-align: center; border: 2px solid #dc2626;">
                        <div style="font-size: 24px; font-weight: bold; color: #dc2626;"><?php echo e($evaluation->items->where('score', '<', 5)->count()); ?></div>
                        <div style="font-size: 11px; text-transform: uppercase; color: #dc2626;">Needs Work (1-4)</div>
                    </td>
                </tr>
            </table>
        <?php endif; ?>

        
        <?php if($evaluation->comments): ?>
            <h3 style="font-size: 14px; font-weight: bold; margin-bottom: 10px; text-transform: uppercase; border-bottom: 1px solid #cbd5e1; padding-bottom: 5px;">Comments & Remarks</h3>
            <div style="padding: 15px; border: 1px solid #cbd5e1; border-radius: 4px; margin-bottom: 20px;">
                <?php echo e($evaluation->comments); ?>

            </div>
        <?php endif; ?>

        
        <div style="margin-top: 40px;">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 45%; text-align: center; padding-top: 50px;">
                        <div style="border-top: 1px solid #1e293b; padding-top: 5px;">
                            <strong>Evaluator Signature</strong><br>
                            <small><?php echo e($evaluation->evaluator->name ?? 'N/A'); ?></small>
                        </div>
                    </td>
                    <td style="width: 10%;"></td>
                    <td style="width: 45%; text-align: center; padding-top: 50px;">
                        <div style="border-top: 1px solid #1e293b; padding-top: 5px;">
                            <strong>Employee Signature</strong><br>
                            <small><?php echo e($evaluation->employee->full_name ?? 'N/A'); ?></small>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../themes/' . $activeTheme . '/' . $activeLayout, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\smart-erp\resources\views/hr/evaluations/show.blade.php ENDPATH**/ ?>

<div class="flex flex-col gap-6">
    
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-semibold text-[#303030]">Project Team</h2>
            <p class="text-sm text-slate-500 mt-1"><?php echo e($teamMembers->count()); ?> team members assigned to this project</p>
        </div>
        <button class="h-10 rounded-full px-5 flex items-center justify-center text-xs font-semibold text-white bg-[#303030] hover:bg-[#404040]">
            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'user-plus','class' => 'w-4 h-4 mr-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'user-plus','class' => 'w-4 h-4 mr-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $attributes = $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $component = $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?> Add Member
        </button>
    </div>

    
    <?php if($project->manager): ?>
    <div class="rounded-[24px] bg-gradient-to-r from-slate-800 to-slate-900 text-white p-6 flex items-center gap-6">
        <div class="h-20 w-20 rounded-full bg-white/20 flex items-center justify-center text-2xl font-bold">
            <?php echo e(strtoupper(substr($project->manager->first_name, 0, 1))); ?><?php echo e(strtoupper(substr($project->manager->last_name, 0, 1))); ?>

        </div>
        <div class="flex-1">
            <div class="text-xs uppercase tracking-wider text-slate-400 mb-1">Project Manager</div>
            <div class="text-xl font-semibold"><?php echo e($project->manager->first_name); ?> <?php echo e($project->manager->last_name); ?></div>
            <div class="text-sm text-slate-300 mt-1"><?php echo e($project->manager->position ?? 'Manager'); ?> • <?php echo e($project->manager->department?->name); ?></div>
        </div>
        <div class="text-right">
            <div class="text-3xl font-bold"><?php echo e($project->tasks->where('employee_id', $project->manager->id)->count()); ?></div>
            <div class="text-xs text-slate-400">Tasks Assigned</div>
        </div>
    </div>
    <?php endif; ?>

    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php $__empty_1 = true; $__currentLoopData = $teamMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="rounded-[24px] bg-white/60 shadow-[0_16px_40px_rgba(15,15,20,0.08)] p-5 hover:shadow-[0_20px_50px_rgba(15,15,20,0.12)] transition-all">
            <div class="flex items-start gap-4">
                <div class="h-14 w-14 rounded-full bg-gradient-to-br from-slate-600 to-slate-800 flex items-center justify-center text-white text-lg font-semibold">
                    <?php echo e(strtoupper(substr($member->first_name, 0, 1))); ?><?php echo e(strtoupper(substr($member->last_name, 0, 1))); ?>

                </div>
                <div class="flex-1">
                    <div class="font-semibold text-[#303030]"><?php echo e($member->first_name); ?> <?php echo e($member->last_name); ?></div>
                    <div class="text-sm text-slate-500"><?php echo e($member->position ?? 'Team Member'); ?></div>
                    <div class="text-xs text-slate-400 mt-1"><?php echo e($member->department?->name); ?></div>
                </div>
            </div>
            
            <?php
                $memberTasks = $project->tasks->where('employee_id', $member->id);
                $memberCompleted = $memberTasks->where('status', 'completed')->count();
                $memberTotal = $memberTasks->count();
            ?>
            
            <div class="mt-4 pt-4 border-t border-slate-100">
                <div class="flex items-center justify-between text-sm mb-2">
                    <span class="text-slate-500">Tasks Progress</span>
                    <span class="font-medium"><?php echo e($memberCompleted); ?>/<?php echo e($memberTotal); ?></span>
                </div>
                <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full bg-green-500 rounded-full" style="width: <?php echo e($memberTotal > 0 ? ($memberCompleted/$memberTotal)*100 : 0); ?>%"></div>
                </div>
            </div>
            
            <div class="mt-4 flex items-center justify-between">
                <div class="flex gap-2">
                    <span class="px-2 py-1 rounded-full bg-green-100 text-green-700 text-xs"><?php echo e($memberCompleted); ?> done</span>
                    <span class="px-2 py-1 rounded-full bg-blue-100 text-blue-700 text-xs"><?php echo e($memberTasks->where('status', 'in_progress')->count()); ?> active</span>
                </div>
                <a href="<?php echo e(route('hr.employees.show', $member)); ?>" class="text-slate-400 hover:text-[#303030]">
                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'external-link','class' => 'w-4 h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'external-link','class' => 'w-4 h-4']); ?>
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
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-span-3 text-center py-12">
            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'users','class' => 'w-12 h-12 mx-auto text-slate-300 mb-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'users','class' => 'w-12 h-12 mx-auto text-slate-300 mb-3']); ?>
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
            <p class="text-slate-500">No team members assigned yet</p>
            <p class="text-sm text-slate-400 mt-1">Assign tasks to employees to add them to the team</p>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH D:\laravel\smart-erp\resources\views/work/projects/partials/show/tab-team.blade.php ENDPATH**/ ?>
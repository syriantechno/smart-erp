
<div class="flex flex-row items-start gap-3 w-full">
    <div class="flex-1 flex flex-col gap-6">
        
        <div class="flex flex-row flex-nowrap items-stretch gap-3 w-full">
            
            <div class="flex-1 min-w-[280px] rounded-[32px] overflow-hidden bg-white/60 shadow-[0_24px_50px_rgba(15,15,20,0.12)] flex">
                <div class="w-1/2 bg-gradient-to-br from-slate-800 to-slate-900 flex items-center justify-center p-6">
                    <div class="text-center text-white">
                        <div class="text-5xl font-bold"><?php echo e($project->progress_percentage); ?>%</div>
                        <div class="mt-2 text-sm text-slate-300">Complete</div>
                        <div class="mt-4 w-full bg-slate-700 rounded-full h-2">
                            <div class="h-2 rounded-full" style="width: <?php echo e($project->progress_percentage); ?>%; background: linear-gradient(to right, #f7e08a, #d49a24);"></div>
                        </div>
                    </div>
                </div>
                <div class="w-1/2 flex flex-col justify-between p-6">
                    <div>
                        <div class="text-lg tracking-[0.15em] uppercase text-[#303030] mb-2">Manager</div>
                        <div class="text-base font-semibold text-[#3a2a1a]"><?php echo e($project->manager?->first_name); ?> <?php echo e($project->manager?->last_name); ?></div>
                        <div class="mt-1 text-sm text-slate-500"><?php echo e($project->manager?->position ?? 'Project Manager'); ?></div>
                    </div>
                    <div class="mt-4 self-start rounded-full bg-[#303030] text-slate-50 px-4 py-2 text-xs font-semibold">
                        $<?php echo e(number_format($project->budget ?? 0)); ?>

                    </div>
                </div>
            </div>

            
            <div class="flex-1 min-w-[280px] rounded-[32px] bg-white/60 shadow-[0_24px_50px_rgba(15,15,20,0.10)] p-6 flex flex-col justify-between">
                <div class="flex items-start justify-between">
                    <div>
                        <div class="text-xl text-[#303030]">Timeline</div>
                        <div class="mt-2 text-2xl font-semibold text-[#3a2a1a]"><?php echo e($daysPassed); ?> / <?php echo e($totalDays); ?> days</div>
                    </div>
                    <span class="text-xs px-3 py-1 rounded-full <?php echo e($timeProgress > $project->progress_percentage ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600'); ?>">
                        <?php echo e($timeProgress > $project->progress_percentage ? 'Behind' : 'On Track'); ?>

                    </span>
                </div>
                <div class="mt-4">
                    <div class="flex justify-between text-xs text-slate-500 mb-2">
                        <span><?php echo e($project->start_date?->format('M d, Y')); ?></span>
                        <span><?php echo e($project->end_date?->format('M d, Y')); ?></span>
                    </div>
                    <div class="w-full h-3 rounded-full bg-slate-200 overflow-hidden">
                        <div class="h-full rounded-full" style="width: <?php echo e($timeProgress); ?>%; background: linear-gradient(to right, #f7e08a, #d49a24);"></div>
                    </div>
                </div>
                <div class="mt-4 grid grid-cols-2 gap-3 text-center">
                    <div class="p-2 rounded-xl bg-slate-100">
                        <div class="text-lg font-bold text-[#3a2a1a]"><?php echo e($daysPassed); ?></div>
                        <div class="text-xs text-slate-500">Days Passed</div>
                    </div>
                    <div class="p-2 rounded-xl bg-slate-100">
                        <div class="text-lg font-bold text-[#3a2a1a]"><?php echo e($daysRemaining ?? '∞'); ?></div>
                        <div class="text-xs text-slate-500">Days Left</div>
                    </div>
                </div>
            </div>

            
            <div class="flex-1 min-w-[280px] rounded-[32px] bg-white/60 shadow-[0_24px_50px_rgba(15,15,20,0.10)] p-6 flex flex-col justify-between">
                <div class="flex items-start justify-between">
                    <div class="text-xl text-[#303030]">Budget</div>
                    <span class="text-xs px-3 py-1 rounded-full <?php echo e($budgetUsed > 90 ? 'bg-red-100 text-red-600' : ($budgetUsed > 70 ? 'bg-amber-100 text-amber-600' : 'bg-green-100 text-green-600')); ?>">
                        <?php echo e($budgetUsed); ?>% used
                    </span>
                </div>
                <div class="flex-1 flex items-center justify-center">
                    <div class="relative w-32 h-32">
                        <svg viewBox="0 0 120 120" class="w-full h-full">
                            <circle cx="60" cy="60" r="48" stroke="#e5e7eb" stroke-width="12" fill="none" />
                            <circle cx="60" cy="60" r="48" stroke="<?php echo e($budgetUsed > 90 ? '#ef4444' : '#f7d46a'); ?>" stroke-width="12" fill="none" 
                                stroke-dasharray="<?php echo e(301.6); ?>" stroke-dashoffset="<?php echo e(301.6 - (301.6 * min($budgetUsed, 100) / 100)); ?>" 
                                stroke-linecap="round" transform="rotate(-90 60 60)" />
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <div class="text-xl font-bold text-[#3a2a1a]">$<?php echo e(number_format(($project->actual_cost ?? 0)/1000, 1)); ?>K</div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2 text-center text-xs">
                    <div><span class="text-slate-500">Budget:</span> <span class="font-semibold">$<?php echo e(number_format($project->budget ?? 0)); ?></span></div>
                    <div><span class="text-slate-500">Spent:</span> <span class="font-semibold">$<?php echo e(number_format($project->actual_cost ?? 0)); ?></span></div>
                </div>
            </div>
        </div>

        
        <div class="flex flex-row flex-nowrap items-stretch gap-3 w-full">
            
            <div class="flex-1 rounded-[32px] bg-white/60 shadow-[0_24px_50px_rgba(15,15,20,0.10)] p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-xl text-[#303030]">Tasks Overview</div>
                    <a href="<?php echo e(route('tasks.index', ['project_id' => $project->id])); ?>" class="text-xs text-slate-500 hover:text-[#303030]">View All →</a>
                </div>
                <div class="grid grid-cols-4 gap-3 mb-6">
                    <div class="text-center p-4 rounded-2xl bg-green-50 border border-green-100">
                        <div class="text-3xl font-bold text-green-600"><?php echo e($completedTasks); ?></div>
                        <div class="text-xs text-green-700 mt-1">Completed</div>
                    </div>
                    <div class="text-center p-4 rounded-2xl bg-blue-50 border border-blue-100">
                        <div class="text-3xl font-bold text-blue-600"><?php echo e($inProgressTasks); ?></div>
                        <div class="text-xs text-blue-700 mt-1">In Progress</div>
                    </div>
                    <div class="text-center p-4 rounded-2xl bg-amber-50 border border-amber-100">
                        <div class="text-3xl font-bold text-amber-600"><?php echo e($pendingTasks); ?></div>
                        <div class="text-xs text-amber-700 mt-1">Pending</div>
                    </div>
                    <div class="text-center p-4 rounded-2xl <?php echo e($overdueTasks > 0 ? 'bg-red-50 border-red-100' : 'bg-slate-50 border-slate-100'); ?>">
                        <div class="text-3xl font-bold <?php echo e($overdueTasks > 0 ? 'text-red-600' : 'text-slate-400'); ?>"><?php echo e($overdueTasks); ?></div>
                        <div class="text-xs <?php echo e($overdueTasks > 0 ? 'text-red-700' : 'text-slate-500'); ?> mt-1">Overdue</div>
                    </div>
                </div>
                
                
                <div class="space-y-2">
                    <?php $__currentLoopData = $project->tasks->sortByDesc('updated_at')->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('tasks.show', $task)); ?>" class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 transition-all group">
                        <div class="flex items-center gap-3">
                            <div class="h-8 w-8 rounded-full flex items-center justify-center text-xs
                                <?php if($task->status === 'completed'): ?> bg-green-100 text-green-600
                                <?php elseif($task->status === 'in_progress'): ?> bg-blue-100 text-blue-600
                                <?php else: ?> bg-slate-100 text-slate-500 <?php endif; ?>">
                                <?php if($task->status === 'completed'): ?>✓<?php elseif($task->status === 'in_progress'): ?>▶<?php else: ?>○<?php endif; ?>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-[#303030] group-hover:text-blue-600"><?php echo e(Str::limit($task->title, 40)); ?></div>
                                <div class="text-xs text-slate-500"><?php echo e($task->employee?->full_name ?? 'Unassigned'); ?></div>
                            </div>
                        </div>
                        <span class="text-xs text-slate-400"><?php echo e($task->due_date?->format('M d')); ?></span>
                    </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            
            <div class="w-[400px] rounded-[32px] bg-white/60 shadow-[0_24px_50px_rgba(15,15,20,0.10)] p-6">
                <div class="text-xl text-[#303030] mb-4">About</div>
                <p class="text-sm text-slate-600 leading-relaxed mb-4"><?php echo e($project->description ?? 'No description provided.'); ?></p>
                
                <?php if($project->objectives): ?>
                <div class="mb-4">
                    <div class="text-sm font-semibold text-[#303030] mb-2">Objectives</div>
                    <p class="text-sm text-slate-600"><?php echo e(Str::limit($project->objectives, 150)); ?></p>
                </div>
                <?php endif; ?>

                <div class="pt-4 border-t border-slate-200 space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-slate-500">Priority</span><span class="font-medium"><?php echo e(ucfirst($project->priority)); ?></span></div>
                    <div class="flex justify-between"><span class="text-slate-500">Company</span><span class="font-medium"><?php echo e($project->company?->name ?? 'N/A'); ?></span></div>
                    <div class="flex justify-between"><span class="text-slate-500">Department</span><span class="font-medium"><?php echo e($project->department?->name ?? 'N/A'); ?></span></div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="w-[280px] flex flex-col gap-4">
        
        <div class="rounded-[32px] bg-[#303030] text-white shadow-[0_24px_50px_rgba(15,15,20,0.25)] p-5">
            <div class="text-lg font-semibold mb-4">Quick Actions</div>
            <div class="space-y-2">
                <a href="<?php echo e(route('tasks.create', ['project_id' => $project->id])); ?>" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/10 transition-all">
                    <div class="h-8 w-8 rounded-full bg-[#f7e08a] text-[#3a2a1a] flex items-center justify-center"><?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'plus','class' => 'w-4 h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'plus','class' => 'w-4 h-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $attributes = $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $component = $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?></div>
                    <span class="text-sm">Add Task</span>
                </a>
                <a href="#" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/10 transition-all" onclick="document.querySelector('[data-tab=team]').click()">
                    <div class="h-8 w-8 rounded-full bg-slate-600 flex items-center justify-center"><?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'user-plus','class' => 'w-4 h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'user-plus','class' => 'w-4 h-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $attributes = $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $component = $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?></div>
                    <span class="text-sm">Add Member</span>
                </a>
                <a href="#" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/10 transition-all" onclick="document.querySelector('[data-tab=requests]').click()">
                    <div class="h-8 w-8 rounded-full bg-slate-600 flex items-center justify-center"><?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'file-plus','class' => 'w-4 h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'file-plus','class' => 'w-4 h-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $attributes = $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $component = $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?></div>
                    <span class="text-sm">Material Request</span>
                </a>
                <a href="<?php echo e(route('project-management.projects.edit', $project)); ?>" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/10 transition-all">
                    <div class="h-8 w-8 rounded-full bg-slate-600 flex items-center justify-center"><?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'settings','class' => 'w-4 h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'settings','class' => 'w-4 h-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $attributes = $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $component = $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?></div>
                    <span class="text-sm">Settings</span>
                </a>
            </div>
        </div>

        
        <div class="rounded-[32px] bg-white/60 shadow-[0_24px_50px_rgba(15,15,20,0.10)] p-5">
            <div class="flex items-center justify-between mb-4">
                <div class="text-lg text-[#303030]">Team</div>
                <span class="text-xs text-slate-500"><?php echo e($teamMembers->count()); ?> members</span>
            </div>
            <div class="flex -space-x-2 mb-3">
                <?php $__currentLoopData = $teamMembers->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-slate-600 to-slate-800 border-2 border-white flex items-center justify-center text-white text-xs font-semibold">
                    <?php echo e(strtoupper(substr($member->first_name, 0, 1))); ?>

                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if($teamMembers->count() > 5): ?>
                <div class="h-10 w-10 rounded-full bg-slate-200 border-2 border-white flex items-center justify-center text-slate-600 text-xs font-semibold">
                    +<?php echo e($teamMembers->count() - 5); ?>

                </div>
                <?php endif; ?>
            </div>
            <button class="w-full text-center text-xs text-slate-500 hover:text-[#303030]" onclick="document.querySelector('[data-tab=team]').click()">
                View All Members →
            </button>
        </div>
    </div>
</div>
<?php /**PATH D:\laravel\smart-erp\resources\views/work/projects/partials/show/tab-overview.blade.php ENDPATH**/ ?>
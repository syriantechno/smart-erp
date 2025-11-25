<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['task', 'showProgress' => true]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['task', 'showProgress' => true]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $steps = $task->steps ?? collect();
    $totalSteps = $steps->count();
    $completedSteps = $steps->where('is_completed', true)->count();
    $progressPercentage = $totalSteps > 0 ? round(($completedSteps / $totalSteps) * 100) : 0;
?>

<div class="task-timeline">
    <?php if($showProgress && $totalSteps > 0): ?>
        <!-- Progress Chart -->
        <div class="mb-6 p-4 rounded-lg" style="background-color: color-mix(in oklch, #2563eb 5%, #ffffff); border: 1px solid color-mix(in oklch, #2563eb, transparent 90%); box-shadow: 0 4px 12px color-mix(in oklch, #2563eb, transparent 90%);">
            <div class="flex items-center justify-between mb-3">
                <h4 class="font-semibold" style="color: color-mix(in oklch, #2563eb, black 22%);">Task Progress</h4>
                <span class="text-sm font-medium" style="color: color-mix(in oklch, #2563eb, black 35%);">
                    <?php echo e($completedSteps); ?>/<?php echo e($totalSteps); ?> Steps Completed
                </span>
            </div>
            
            <!-- Progress Bar -->
            <div class="w-full rounded-full h-3" style="background-color: color-mix(in oklch, #2563eb, transparent 85%);">
                <div class="h-3 rounded-full transition-all duration-500 ease-out" 
                     style="width: <?php echo e($progressPercentage); ?>%; background: linear-gradient(90deg, color-mix(in oklch, #1b7a4a 70%, #ffffff), color-mix(in oklch, #1b7a4a 90%, #ffffff));"></div>
            </div>
            
            <div class="flex items-center justify-between mt-2 text-sm">
                <span style="color: color-mix(in oklch, #2563eb, black 35%);"><?php echo e($progressPercentage); ?>% Complete</span>
                <?php if($progressPercentage === 100): ?>
                    <span class="font-medium flex items-center gap-1 px-2 py-1 rounded-full" style="background-color: color-mix(in oklch, #1b7a4a 18%, #ffffff); color: color-mix(in oklch, #1b7a4a, black 22%);">
                        <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'CheckCircle','class' => 'w-4 h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'CheckCircle','class' => 'w-4 h-4']); ?>
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
                        All Steps Completed!
                    </span>
                <?php elseif($progressPercentage > 0): ?>
                    <span class="font-medium px-2 py-1 rounded-full" style="background-color: color-mix(in oklch, #2563eb 18%, #ffffff); color: color-mix(in oklch, #2563eb, black 22%);">In Progress</span>
                <?php else: ?>
                    <span class="px-2 py-1 rounded-full" style="background-color: color-mix(in oklch, #6b7280 18%, #ffffff); color: color-mix(in oklch, #6b7280, black 22%);">Not Started</span>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if($totalSteps > 0): ?>
        <!-- Timeline Steps -->
        <div class="relative">
            <!-- Timeline Line -->
            <div class="absolute left-4 top-0 bottom-0 w-0.5 rounded-full" style="background: linear-gradient(180deg, color-mix(in oklch, #2563eb 40%, #ffffff), color-mix(in oklch, #1b7a4a 40%, #ffffff));"></div>
            
            <div class="space-y-6">
                <?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="relative flex items-start gap-4 step-item" data-step-id="<?php echo e($step->id); ?>">
                        <!-- Step Number/Status -->
                        <div class="relative z-10 flex-shrink-0">
                            <?php if($step->is_completed): ?>
                                <div class="w-8 h-8 flex items-center justify-center font-semibold text-sm timeline-step-completed">
                                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Check','class' => 'w-4 h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Check','class' => 'w-4 h-4']); ?>
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
                            <?php else: ?>
                                <div class="w-8 h-8 flex items-center justify-center font-semibold text-sm timeline-step-pending">
                                    <?php echo e($step->step_order); ?>

                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Step Content -->
                        <div class="flex-1 min-w-0 pb-6">
                            <div class="rounded-lg p-4 transition-all duration-200 hover:transform hover:translateY(-1px)" 
                                 style="background-color: color-mix(in oklch, #f8fafc 90%, #ffffff); 
                                        border: 1px solid color-mix(in oklch, #e2e8f0, transparent 50%);
                                        box-shadow: 0 2px 8px color-mix(in oklch, #64748b, transparent 90%);"
                                 onmouseover="this.style.boxShadow='0 4px 16px color-mix(in oklch, #64748b, transparent 85%)'"
                                 onmouseout="this.style.boxShadow='0 2px 8px color-mix(in oklch, #64748b, transparent 90%)'">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h5 class="font-semibold text-slate-800 dark:text-slate-200 <?php echo e($step->is_completed ? 'line-through text-slate-500' : ''); ?>">
                                            <?php echo e($step->title); ?>

                                        </h5>
                                        
                                        <?php if($step->description): ?>
                                            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1 <?php echo e($step->is_completed ? 'line-through' : ''); ?>">
                                                <?php echo e($step->description); ?>

                                            </p>
                                        <?php endif; ?>
                                        
                                        <!-- Step Status Info -->
                                        <div class="flex items-center flex-wrap gap-2 mt-3 text-xs">
                                            <span class="status-badge-info">Step <?php echo e($step->step_order); ?></span>
                                            <?php if($step->is_completed): ?>
                                                <span class="status-badge-success flex items-center gap-1">
                                                    ✓ Completed <?php echo e($step->completed_at->diffForHumans()); ?>

                                                </span>
                                                <?php if($step->completedBy): ?>
                                                    <span class="text-slate-500">by <?php echo e($step->completedBy->name); ?></span>
                                                <?php endif; ?>
                                            <?php elseif($step->isDelegated()): ?>
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400">
                                                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'send','class' => 'w-3 h-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'send','class' => 'w-3 h-3']); ?>
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
                                                    Delegated to <?php echo e($step->assignee?->full_name ?? 'Employee'); ?>

                                                </span>
                                                <?php if($step->delegatedTask): ?>
                                                    <a href="<?php echo e(route('tasks.show', $step->delegatedTask)); ?>" 
                                                       class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 hover:bg-blue-200 transition-colors">
                                                        <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'external-link','class' => 'w-3 h-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'external-link','class' => 'w-3 h-3']); ?>
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
                                                        View Subtask (<?php echo e(ucfirst($step->delegatedTask->status)); ?>)
                                                    </a>
                                                <?php endif; ?>
                                            <?php elseif($step->hasAssignee()): ?>
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-indigo-100 text-indigo-700">
                                                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'user','class' => 'w-3 h-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'user','class' => 'w-3 h-3']); ?>
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
                                                    Assigned to <?php echo e($step->assignee?->full_name); ?>

                                                </span>
                                            <?php else: ?>
                                                <span class="status-badge-warning">Pending</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <!-- Action Buttons -->
                                    <div class="flex-shrink-0 ml-4 flex flex-col gap-2">
                                        <?php if(!$step->is_completed): ?>
                                            <button 
                                                type="button" 
                                                class="complete-step-btn inline-flex items-center gap-2 px-3 py-1.5 text-xs font-medium timeline-btn-complete"
                                                data-step-id="<?php echo e($step->id); ?>"
                                                title="Mark as Complete"
                                            >
                                                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'check','class' => 'w-4 h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'check','class' => 'w-4 h-4']); ?>
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
                                                Complete
                                            </button>
                                            
                                            <?php if(!$step->isDelegated()): ?>
                                                <button 
                                                    type="button" 
                                                    class="delegate-step-btn inline-flex items-center gap-2 px-3 py-1.5 text-xs font-medium rounded-md border border-purple-300 bg-purple-50 text-purple-700 hover:bg-purple-100 transition-colors dark:bg-purple-900/20 dark:border-purple-700 dark:text-purple-400"
                                                    data-step-id="<?php echo e($step->id); ?>"
                                                    data-step-title="<?php echo e($step->title); ?>"
                                                    data-task-id="<?php echo e($task->id); ?>"
                                                    title="Delegate to Employee"
                                                >
                                                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'send','class' => 'w-4 h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'send','class' => 'w-4 h-4']); ?>
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
                                                    Delegate
                                                </button>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <button 
                                                type="button" 
                                                class="uncomplete-step-btn inline-flex items-center gap-2 px-3 py-1.5 text-xs font-medium timeline-btn-undo"
                                                data-step-id="<?php echo e($step->id); ?>"
                                                title="Mark as Pending"
                                            >
                                                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'rotate-ccw','class' => 'w-4 h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'rotate-ccw','class' => 'w-4 h-4']); ?>
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
                                                Undo
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php else: ?>
        <!-- No Steps Message -->
        <div class="text-center py-12">
            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'ListChecks','class' => 'w-16 h-16 mx-auto text-slate-300 mb-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'ListChecks','class' => 'w-16 h-16 mx-auto text-slate-300 mb-4']); ?>
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
            <h4 class="text-lg font-medium text-slate-600 dark:text-slate-400 mb-2">No Timeline Steps</h4>
            <p class="text-slate-500 dark:text-slate-500">This task doesn't have any timeline steps defined.</p>
        </div>
    <?php endif; ?>
</div>

<?php if($totalSteps > 0): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let employeesLoaded = false;
            
            // Create and append modal to body
            if (!document.getElementById('delegate-step-modal')) {
                const modalHTML = `
                    <div id="delegate-step-modal" class="fixed inset-0 hidden" style="z-index: 99999;">
                        <div class="fixed inset-0 bg-black/70" onclick="closeDelegateModal()"></div>
                        <div class="fixed inset-0 flex items-center justify-center p-4" style="z-index: 100000;">
                            <div class="relative w-full max-w-md p-6 bg-white rounded-xl shadow-2xl dark:bg-darkmode-600">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-semibold text-slate-800 dark:text-white flex items-center gap-2">
                                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                        Delegate Step
                                    </h3>
                                    <button type="button" onclick="closeDelegateModal()" class="text-slate-400 hover:text-slate-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                                <form id="delegate-step-form">
                                    <input type="hidden" id="delegate-task-id" name="task_id">
                                    <input type="hidden" id="delegate-step-id" name="step_id">
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Step</label>
                                        <div id="delegate-step-title" class="p-3 bg-slate-50 dark:bg-darkmode-700 rounded-lg text-sm font-medium"></div>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Assign to Employee <span class="text-red-500">*</span></label>
                                        <select id="delegate-employee-id" name="employee_id" required class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-darkmode-400 dark:bg-darkmode-700">
                                            <option value="">Select Employee...</option>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Due Date</label>
                                        <input type="date" id="delegate-due-date" name="due_date" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-darkmode-400 dark:bg-darkmode-700">
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Priority</label>
                                        <select id="delegate-priority" name="priority" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-darkmode-400 dark:bg-darkmode-700">
                                            <option value="low">Low</option>
                                            <option value="medium" selected>Medium</option>
                                            <option value="high">High</option>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Additional Notes</label>
                                        <textarea id="delegate-description" name="description" rows="2" placeholder="Add any additional instructions..." class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-darkmode-400 dark:bg-darkmode-700 resize-none"></textarea>
                                    </div>
                                    <div class="flex justify-end gap-2">
                                        <button type="button" onclick="closeDelegateModal()" class="px-4 py-2 text-sm font-medium text-slate-700 bg-slate-100 rounded-lg hover:bg-slate-200">Cancel</button>
                                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700 flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                            Delegate
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                `;
                document.body.insertAdjacentHTML('beforeend', modalHTML);
            }
            
            // Handle step completion
            document.addEventListener('click', function(e) {
                if (e.target.closest('.complete-step-btn')) {
                    const btn = e.target.closest('.complete-step-btn');
                    const stepId = btn.getAttribute('data-step-id');
                    toggleStepCompletion(stepId, true);
                } else if (e.target.closest('.uncomplete-step-btn')) {
                    const btn = e.target.closest('.uncomplete-step-btn');
                    const stepId = btn.getAttribute('data-step-id');
                    toggleStepCompletion(stepId, false);
                } else if (e.target.closest('.delegate-step-btn')) {
                    const btn = e.target.closest('.delegate-step-btn');
                    openDelegateModal(btn);
                }
            });

            function toggleStepCompletion(stepId, isCompleted) {
                const action = isCompleted ? 'complete' : 'uncomplete';
                
                fetch(`/tasks/steps/${stepId}/${action}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                        if (typeof showToast === 'function') {
                            showToast(data.message || `Step ${action}d successfully`, 'success');
                        }
                    } else {
                        if (typeof showToast === 'function') {
                            showToast(data.message || 'Failed to update step', 'error');
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (typeof showToast === 'function') {
                        showToast('An error occurred while updating the step', 'error');
                    }
                });
            }

            // Delegation functions
            window.openDelegateModal = function(btn) {
                const stepId = btn.getAttribute('data-step-id');
                const stepTitle = btn.getAttribute('data-step-title');
                const taskId = btn.getAttribute('data-task-id');
                
                document.getElementById('delegate-step-id').value = stepId;
                document.getElementById('delegate-task-id').value = taskId;
                document.getElementById('delegate-step-title').textContent = stepTitle;
                
                // Load employees if not loaded
                if (!employeesLoaded) {
                    loadEmployees();
                }
                
                document.getElementById('delegate-step-modal').classList.remove('hidden');
            };

            window.closeDelegateModal = function() {
                document.getElementById('delegate-step-modal').classList.add('hidden');
                document.getElementById('delegate-step-form').reset();
            };

            function loadEmployees() {
                fetch('/tasks/employees-for-delegation', {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.data.employees) {
                        const select = document.getElementById('delegate-employee-id');
                        select.innerHTML = '<option value="">Select Employee...</option>';
                        
                        data.data.employees.forEach(emp => {
                            const option = document.createElement('option');
                            option.value = emp.id;
                            option.textContent = `${emp.name} - ${emp.position || 'Employee'} (${emp.department || 'No Dept'})`;
                            select.appendChild(option);
                        });
                        
                        employeesLoaded = true;
                    }
                })
                .catch(error => console.error('Error loading employees:', error));
            }

            // Handle delegation form submit
            document.getElementById('delegate-step-form').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const taskId = document.getElementById('delegate-task-id').value;
                const stepId = document.getElementById('delegate-step-id').value;
                const formData = new FormData(this);
                
                fetch(`/tasks/${taskId}/steps/${stepId}/delegate`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        employee_id: formData.get('employee_id'),
                        due_date: formData.get('due_date'),
                        priority: formData.get('priority'),
                        description: formData.get('description'),
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        closeDelegateModal();
                        window.location.reload();
                        if (typeof showToast === 'function') {
                            showToast('Step delegated successfully!', 'success');
                        }
                    } else {
                        if (typeof showToast === 'function') {
                            showToast(data.message || 'Failed to delegate step', 'error');
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (typeof showToast === 'function') {
                        showToast('An error occurred while delegating the step', 'error');
                    }
                });
            });
        });
    </script>
<?php endif; ?>
<?php /**PATH D:\laravel\smart-erp\resources\views/components/task-timeline.blade.php ENDPATH**/ ?>
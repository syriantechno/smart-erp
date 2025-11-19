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
                                        <div class="flex items-center gap-4 mt-3 text-xs">
                                            <span class="status-badge-info">Step <?php echo e($step->step_order); ?></span>
                                            <?php if($step->is_completed): ?>
                                                <span class="status-badge-success flex items-center gap-1">
                                                    ✓ Completed <?php echo e($step->completed_at->diffForHumans()); ?>

                                                </span>
                                                <?php if($step->completedBy): ?>
                                                    <span class="text-slate-500">by <?php echo e($step->completedBy->name); ?></span>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="status-badge-warning">Pending</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <!-- Action Button -->
                                    <div class="flex-shrink-0 ml-4">
                                        <?php if(!$step->is_completed): ?>
                                            <button 
                                                type="button" 
                                                class="complete-step-btn inline-flex items-center gap-2 px-3 py-1.5 text-xs font-medium timeline-btn-complete"
                                                data-step-id="<?php echo e($step->id); ?>"
                                                title="Mark as Complete"
                                            >
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
                                                Complete
                                            </button>
                                        <?php else: ?>
                                            <button 
                                                type="button" 
                                                class="uncomplete-step-btn inline-flex items-center gap-2 px-3 py-1.5 text-xs font-medium timeline-btn-undo"
                                                data-step-id="<?php echo e($step->id); ?>"
                                                title="Mark as Pending"
                                            >
                                                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'RotateCcw','class' => 'w-4 h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'RotateCcw','class' => 'w-4 h-4']); ?>
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
                        // Reload the page to update the timeline
                        window.location.reload();
                        
                        // Show success message
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
        });
    </script>
<?php endif; ?>
<?php /**PATH E:\ERP System\Source\resources\views/components/task-timeline.blade.php ENDPATH**/ ?>
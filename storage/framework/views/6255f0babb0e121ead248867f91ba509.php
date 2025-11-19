<?php $__env->startSection('subhead'); ?>
    <title><?php echo e($task->title); ?> - Task Details</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('subcontent'); ?>
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Task Details</h2>
        <div class="flex items-center gap-2">
            <?php if (isset($component)) { $__componentOriginale00eb601fbe667f0da582732d70c41c5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale00eb601fbe667f0da582732d70c41c5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.button.index','data' => ['as' => 'a','href' => ''.e(route('tasks.index')).'','variant' => 'outline-secondary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['as' => 'a','href' => ''.e(route('tasks.index')).'','variant' => 'outline-secondary']); ?>
                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'ArrowLeft','class' => 'w-4 h-4 mr-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'ArrowLeft','class' => 'w-4 h-4 mr-2']); ?>
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
                Back to Tasks
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.button.index','data' => ['as' => 'a','href' => ''.e(route('tasks.edit', $task)).'','variant' => 'primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['as' => 'a','href' => ''.e(route('tasks.edit', $task)).'','variant' => 'primary']); ?>
                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Edit','class' => 'w-4 h-4 mr-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Edit','class' => 'w-4 h-4 mr-2']); ?>
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
                Edit Task
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
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <!-- Task Information -->
        <div class="col-span-12 lg:col-span-8">
            <div class="intro-y box">
                <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400">
                    <div class="flex items-center gap-3">
                        <?php if($task->color): ?>
                            <div class="w-4 h-4 rounded-full border border-white shadow-sm" style="background-color: <?php echo e($task->color); ?>"></div>
                        <?php endif; ?>
                        <h2 class="mr-auto text-lg font-medium"><?php echo e($task->title); ?></h2>
                    </div>
                    <div class="flex items-center gap-2">
                        <!-- Priority Badge -->
                        <?php
                            $priorityClass = match($task->priority) {
                                'high' => 'bg-red-100 text-red-700',
                                'medium' => 'bg-yellow-100 text-yellow-700',
                                'low' => 'bg-green-100 text-green-700',
                                default => 'bg-gray-100 text-gray-700'
                            };
                        ?>
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-semibold <?php echo e($priorityClass); ?>">
                            <?php echo e(ucfirst($task->priority)); ?> Priority
                        </span>
                        
                        <!-- Status Badge -->
                        <?php
                            $statusClass = match($task->status) {
                                'completed' => 'bg-green-100 text-green-700',
                                'in_progress' => 'bg-blue-100 text-blue-700',
                                'pending' => 'bg-yellow-100 text-yellow-700',
                                'cancelled' => 'bg-red-100 text-red-700',
                                default => 'bg-gray-100 text-gray-700'
                            };
                        ?>
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-semibold <?php echo e($statusClass); ?>">
                            <?php echo e(ucfirst(str_replace('_', ' ', $task->status))); ?>

                        </span>
                    </div>
                </div>
                
                <div class="p-5">
                    <!-- Task Code -->
                    <div class="mb-6">
                        <div class="text-sm text-slate-500 mb-1">Task Code</div>
                        <div class="font-mono text-lg"><?php echo e($task->code); ?></div>
                    </div>

                    <!-- Description -->
                    <?php if($task->description): ?>
                        <div class="mb-6">
                            <div class="text-sm text-slate-500 mb-2">Description</div>
                            <div class="prose max-w-none">
                                <?php echo nl2br(e($task->description)); ?>

                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Task Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Due Date -->
                        <?php if($task->due_date): ?>
                            <div>
                                <div class="text-sm text-slate-500 mb-1">Due Date</div>
                                <div class="flex items-center gap-2">
                                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Calendar','class' => 'w-4 h-4 text-slate-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Calendar','class' => 'w-4 h-4 text-slate-400']); ?>
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
                                    <span class="font-medium"><?php echo e($task->due_date->format('M d, Y')); ?></span>
                                    <?php if($task->due_date->isPast() && $task->status !== 'completed'): ?>
                                        <span class="text-red-500 text-sm">(Overdue)</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Estimated Hours -->
                        <?php if($task->estimated_hours): ?>
                            <div>
                                <div class="text-sm text-slate-500 mb-1">Estimated Hours</div>
                                <div class="flex items-center gap-2">
                                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Clock','class' => 'w-4 h-4 text-slate-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Clock','class' => 'w-4 h-4 text-slate-400']); ?>
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
                                    <span class="font-medium"><?php echo e($task->estimated_hours); ?> hours</span>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Tags -->
                        <?php if($task->tags): ?>
                            <div class="md:col-span-2">
                                <div class="text-sm text-slate-500 mb-2">Tags</div>
                                <div class="flex flex-wrap gap-2">
                                    <?php $__currentLoopData = explode(',', $task->tags); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700">
                                            <?php echo e(trim($tag)); ?>

                                        </span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Created/Updated Info -->
                    <div class="border-t border-slate-200/60 pt-4 dark:border-darkmode-400">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-slate-500">
                            <div>
                                <span class="font-medium">Created:</span> <?php echo e($task->created_at->format('M d, Y \a\t H:i')); ?>

                            </div>
                            <div>
                                <span class="font-medium">Last Updated:</span> <?php echo e($task->updated_at->format('M d, Y \a\t H:i')); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Task Timeline -->
            <?php if($task->steps->count() > 0): ?>
                <div class="intro-y box mt-6">
                    <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400">
                        <h2 class="mr-auto text-lg font-medium">Task Timeline</h2>
                    </div>
                    <div class="p-5">
                        <?php if (isset($component)) { $__componentOriginal6243a699ec44fb6eae713055e6a13a94 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6243a699ec44fb6eae713055e6a13a94 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.task-timeline','data' => ['task' => $task]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('task-timeline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['task' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($task)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6243a699ec44fb6eae713055e6a13a94)): ?>
<?php $attributes = $__attributesOriginal6243a699ec44fb6eae713055e6a13a94; ?>
<?php unset($__attributesOriginal6243a699ec44fb6eae713055e6a13a94); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6243a699ec44fb6eae713055e6a13a94)): ?>
<?php $component = $__componentOriginal6243a699ec44fb6eae713055e6a13a94; ?>
<?php unset($__componentOriginal6243a699ec44fb6eae713055e6a13a94); ?>
<?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Task Comments -->
            <div class="intro-y box mt-6">
                <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400">
                    <h2 class="mr-auto text-lg font-medium">Comments</h2>
                    <span class="text-sm text-slate-500"><?php echo e($task->taskComments->count()); ?> comments</span>
                </div>
                <div class="p-5">
                    <!-- Add Comment Form -->
                    <div class="mb-6">
                        <form id="add-comment-form" class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                    Add your comment
                                </label>
                                <?php if (isset($component)) { $__componentOriginalec417908f484c6254334310189c939e6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalec417908f484c6254334310189c939e6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.classic-editor.index','data' => ['id' => 'comment-editor']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.classic-editor'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'comment-editor']); ?>
                                    <p>Write your comment here...</p>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalec417908f484c6254334310189c939e6)): ?>
<?php $attributes = $__attributesOriginalec417908f484c6254334310189c939e6; ?>
<?php unset($__attributesOriginalec417908f484c6254334310189c939e6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalec417908f484c6254334310189c939e6)): ?>
<?php $component = $__componentOriginalec417908f484c6254334310189c939e6; ?>
<?php unset($__componentOriginalec417908f484c6254334310189c939e6); ?>
<?php endif; ?>
                            </div>
                            <div class="flex items-center justify-between">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="is_internal" class="rounded border-slate-300 text-primary shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-slate-600 dark:text-slate-400">Internal comment (not visible to client)</span>
                                </label>
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
                                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Send','class' => 'w-4 h-4 mr-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Send','class' => 'w-4 h-4 mr-1']); ?>
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
                                    Add Comment
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

                    <!-- Comments List -->
                    <div id="comments-list" class="space-y-4">
                        <?php $__empty_1 = true; $__currentLoopData = $task->taskComments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="comment-item flex gap-3 p-4 bg-slate-50 dark:bg-darkmode-600 rounded-lg">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center text-sm font-semibold">
                                        <?php echo e(strtoupper(substr($comment->user->name ?? 'U', 0, 1))); ?>

                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="font-medium text-sm text-slate-700 dark:text-slate-300">
                                            <?php echo e($comment->user->name ?? 'Unknown User'); ?>

                                        </span>
                                        <span class="text-xs text-slate-500"><?php echo e($comment->time_ago); ?></span>
                                        <?php if($comment->is_internal): ?>
                                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Internal
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="text-sm text-slate-600 dark:text-slate-400 prose prose-sm max-w-none">
                                        <?php echo $comment->comment; ?>

                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="text-center py-8 text-slate-500">
                                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'MessageSquare','class' => 'w-12 h-12 mx-auto mb-2 text-slate-300']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'MessageSquare','class' => 'w-12 h-12 mx-auto mb-2 text-slate-300']); ?>
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
                                <p>No comments yet. Be the first to add a comment!</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-span-12 lg:col-span-4">
            <!-- Assignment Info -->
            <div class="intro-y box mb-6">
                <div class="flex items-center border-b border-slate-200/60 px-5 py-3 dark:border-darkmode-400">
                    <h3 class="text-base font-medium">Assignment</h3>
                </div>
                <div class="p-5 space-y-4">
                    <!-- Assigned Employee -->
                    <?php if($task->employee): ?>
                        <div>
                            <div class="text-sm text-slate-500 mb-2">Assigned To</div>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center">
                                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'User','class' => 'w-4 h-4 text-slate-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'User','class' => 'w-4 h-4 text-slate-500']); ?>
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
                                <div>
                                    <div class="font-medium"><?php echo e($task->employee->full_name); ?></div>
                                    <?php if($task->employee->department): ?>
                                        <div class="text-xs text-slate-500"><?php echo e($task->employee->department->name); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Project -->
                    <?php if($task->project): ?>
                        <div>
                            <div class="text-sm text-slate-500 mb-2">Project</div>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center">
                                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Folder','class' => 'w-4 h-4 text-slate-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Folder','class' => 'w-4 h-4 text-slate-500']); ?>
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
                                <div>
                                    <div class="font-medium"><?php echo e($task->project->name); ?></div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Assigned By -->
                    <?php if($task->assignedBy): ?>
                        <div>
                            <div class="text-sm text-slate-500 mb-2">Assigned By</div>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center">
                                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'UserCheck','class' => 'w-4 h-4 text-slate-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'UserCheck','class' => 'w-4 h-4 text-slate-500']); ?>
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
                                <div>
                                    <div class="font-medium"><?php echo e($task->assignedBy->name); ?></div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Task Progress Chart -->
            <?php if($task->steps->count() > 0): ?>
                <div class="intro-y box mb-6">
                    <div class="flex items-center border-b border-slate-200/60 px-5 py-3 dark:border-darkmode-400">
                        <h3 class="text-base font-medium">Progress Overview</h3>
                    </div>
                    <div class="p-5">
                        <div class="w-auto h-[400px] chart-container p-4">
                            <canvas class="chart donut-chart" id="task-progress-chart"></canvas>
                        </div>
                        
                        <?php
                            $totalSteps = $task->steps->count();
                            $completedSteps = $task->steps->where('is_completed', true)->count();
                            $pendingSteps = $totalSteps - $completedSteps;
                            $progressPercentage = $totalSteps > 0 ? round(($completedSteps / $totalSteps) * 100) : 0;
                        ?>
                        
                        <!-- Progress Stats -->
                        <div class="mt-4 grid grid-cols-3 gap-4 text-center">
                            <div class="p-3 rounded-lg stats-card-success">
                                <div class="text-2xl font-bold"><?php echo e($completedSteps); ?></div>
                                <div class="text-xs opacity-80">Completed</div>
                            </div>
                            <div class="p-3 rounded-lg stats-card-warning">
                                <div class="text-2xl font-bold"><?php echo e($pendingSteps); ?></div>
                                <div class="text-xs opacity-80">Pending</div>
                            </div>
                            <div class="p-3 rounded-lg stats-card-info">
                                <div class="text-2xl font-bold"><?php echo e($progressPercentage); ?>%</div>
                                <div class="text-xs opacity-80">Progress</div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- Task Status Chart (when no steps) -->
                <div class="intro-y box mb-6">
                    <div class="flex items-center border-b border-slate-200/60 px-5 py-3 dark:border-darkmode-400">
                        <h3 class="text-base font-medium">Task Status</h3>
                    </div>
                    <div class="p-5">
                        <div class="w-auto h-[300px] chart-container p-4">
                            <canvas class="chart donut-chart" id="task-status-chart"></canvas>
                        </div>
                        
                        <!-- Status Info -->
                        <div class="mt-4 text-center">
                            <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium
                                <?php if($task->status === 'completed'): ?> stats-card-success
                                <?php elseif($task->status === 'in_progress'): ?> stats-card-info
                                <?php elseif($task->status === 'pending'): ?> stats-card-warning
                                <?php elseif($task->status === 'cancelled'): ?> stats-card-danger
                                <?php else: ?> stats-card-neutral
                                <?php endif; ?>">
                                <?php echo e(ucfirst(str_replace('_', ' ', $task->status))); ?>

                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Quick Actions -->
            <div class="intro-y box">
                <div class="flex items-center border-b border-slate-200/60 px-5 py-3 dark:border-darkmode-400">
                    <h3 class="text-base font-medium">Quick Actions</h3>
                </div>
                <div class="p-5 space-y-3">
                    <?php if($task->status !== 'completed'): ?>
                        <?php if (isset($component)) { $__componentOriginale00eb601fbe667f0da582732d70c41c5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale00eb601fbe667f0da582732d70c41c5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.button.index','data' => ['variant' => 'success','class' => 'w-full complete-task-btn','dataTaskId' => ''.e($task->id).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'success','class' => 'w-full complete-task-btn','data-task-id' => ''.e($task->id).'']); ?>
                            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Check','class' => 'w-4 h-4 mr-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Check','class' => 'w-4 h-4 mr-2']); ?>
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
                            Mark as Completed
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
                    
                    <?php if($task->status === 'pending'): ?>
                        <?php if (isset($component)) { $__componentOriginale00eb601fbe667f0da582732d70c41c5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale00eb601fbe667f0da582732d70c41c5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.button.index','data' => ['variant' => 'primary','class' => 'w-full start-task-btn','dataTaskId' => ''.e($task->id).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'primary','class' => 'w-full start-task-btn','data-task-id' => ''.e($task->id).'']); ?>
                            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Play','class' => 'w-4 h-4 mr-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Play','class' => 'w-4 h-4 mr-2']); ?>
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
                            Start Working
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

                    <?php if (isset($component)) { $__componentOriginale00eb601fbe667f0da582732d70c41c5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale00eb601fbe667f0da582732d70c41c5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.button.index','data' => ['variant' => 'outline-secondary','class' => 'w-full add-comment-btn','dataTaskId' => ''.e($task->id).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'outline-secondary','class' => 'w-full add-comment-btn','data-task-id' => ''.e($task->id).'']); ?>
                        <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'MessageSquare','class' => 'w-4 h-4 mr-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'MessageSquare','class' => 'w-4 h-4 mr-2']); ?>
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
                        Add Comment
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.button.index','data' => ['variant' => 'outline-secondary','class' => 'w-full share-task-btn','dataTaskId' => ''.e($task->id).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'outline-secondary','class' => 'w-full share-task-btn','data-task-id' => ''.e($task->id).'']); ?>
                        <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Share','class' => 'w-4 h-4 mr-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Share','class' => 'w-4 h-4 mr-2']); ?>
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
                        Share Task
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
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* Chart Colors - Using btn-tonal colors */
    :root {
        --chart-success: #1b7a4a;
        --chart-warning: #c98028;
        --chart-info: #2563eb;
        --chart-danger: #b21a50;
        --chart-neutral: #6b7280;
    }
    
    /* Tonal background styles for stats cards */
    .stats-card-success {
        background-color: color-mix(in oklch, var(--chart-success) 18%, #ffffff);
        border: 1px solid color-mix(in oklch, var(--chart-success), transparent 78%);
        color: color-mix(in oklch, var(--chart-success), black 22%);
    }
    
    .stats-card-warning {
        background-color: color-mix(in oklch, var(--chart-warning) 18%, #ffffff);
        border: 1px solid color-mix(in oklch, var(--chart-warning), transparent 78%);
        color: color-mix(in oklch, var(--chart-warning), black 22%);
    }
    
    .stats-card-info {
        background-color: color-mix(in oklch, var(--chart-info) 18%, #ffffff);
        border: 1px solid color-mix(in oklch, var(--chart-info), transparent 78%);
        color: color-mix(in oklch, var(--chart-info), black 22%);
    }
    
    .stats-card-danger {
        background-color: color-mix(in oklch, var(--chart-danger) 18%, #ffffff);
        border: 1px solid color-mix(in oklch, var(--chart-danger), transparent 78%);
        color: color-mix(in oklch, var(--chart-danger), black 22%);
    }
    
    .stats-card-neutral {
        background-color: color-mix(in oklch, var(--chart-neutral) 18%, #ffffff);
        border: 1px solid color-mix(in oklch, var(--chart-neutral), transparent 78%);
        color: color-mix(in oklch, var(--chart-neutral), black 22%);
    }
    
    /* Chart containers with btn-tonal styling */
    .chart-container {
        background-color: color-mix(in oklch, var(--chart-info) 5%, #ffffff);
        border: 1px solid color-mix(in oklch, var(--chart-info), transparent 90%);
        border-radius: 0.5rem;
        box-shadow: 0 4px 12px color-mix(in oklch, var(--chart-info), transparent 90%);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .chart-container:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 20px color-mix(in oklch, var(--chart-info), transparent 85%);
    }

    /* Comment prose styling */
    .comment-item .prose {
        color: inherit;
    }
    
    .comment-item .prose p {
        margin: 0.5em 0;
    }
    
    .comment-item .prose p:first-child {
        margin-top: 0;
    }
    
    .comment-item .prose p:last-child {
        margin-bottom: 0;
    }
    
    .comment-item .prose strong {
        font-weight: 600;
        color: inherit;
    }
    
    .comment-item .prose em {
        font-style: italic;
    }
    
    .comment-item .prose ul,
    .comment-item .prose ol {
        margin: 0.5em 0;
        padding-left: 1.5em;
    }
    
    .comment-item .prose li {
        margin: 0.25em 0;
    }
    
    .comment-item .prose blockquote {
        border-left: 4px solid #e2e8f0;
        padding-left: 1em;
        margin: 0.5em 0;
        font-style: italic;
        color: #64748b;
    }
    
    .comment-item .prose code {
        background-color: #f1f5f9;
        padding: 0.125em 0.25em;
        border-radius: 0.25rem;
        font-size: 0.875em;
        font-family: ui-monospace, SFMono-Regular, "SF Mono", Consolas, "Liberation Mono", Menlo, monospace;
    }
    
    .dark .comment-item .prose blockquote {
        border-left-color: #475569;
        color: #94a3b8;
    }
    
    .dark .comment-item .prose code {
        background-color: #334155;
        color: #e2e8f0;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('🎯 Task details page loaded');

    // Wait for CKEditor to be ready
    let editorReady = false;
    let commentEditor = null;

    // Check for CKEditor initialization
    const checkEditor = setInterval(() => {
        const editorElement = document.querySelector('#comment-editor .ck-editor');
        if (editorElement && window.ClassicEditor) {
            // Try to find the editor instance
            const editorContainer = document.querySelector('#comment-editor .editor');
            if (editorContainer && editorContainer.ckeditorInstance) {
                commentEditor = editorContainer.ckeditorInstance;
                editorReady = true;
                console.log('✅ CKEditor ready');
                clearInterval(checkEditor);
            }
        }
    }, 500);

    // Clear interval after 10 seconds to avoid infinite checking
    setTimeout(() => {
        clearInterval(checkEditor);
        if (!editorReady) {
            console.log('⚠️ CKEditor not found, using fallback');
        }
    }, 10000);

    // Initialize Task Progress Chart
    const progressChart = document.getElementById('task-progress-chart');
    if (progressChart) {
        initTaskProgressChart();
    }

    // Initialize Task Status Chart (for tasks without steps)
    const statusChart = document.getElementById('task-status-chart');
    if (statusChart) {
        initTaskStatusChart();
    }

    function initTaskProgressChart() {
        // Get task progress data from PHP
        const totalSteps = <?php echo e($task->steps->count() ?? 0); ?>;
        const completedSteps = <?php echo e($task->steps->where('is_completed', true)->count() ?? 0); ?>;
        const pendingSteps = totalSteps - completedSteps;

        if (totalSteps === 0) {
            // Show "No Steps" message
            const chartContainer = progressChart.parentElement;
            chartContainer.innerHTML = `
                <div class="flex items-center justify-center h-[400px] text-slate-500">
                    <div class="text-center">
                        <svg class="w-16 h-16 mx-auto mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <p class="text-lg font-medium">No Timeline Steps</p>
                        <p class="text-sm">Add steps to see progress visualization</p>
                    </div>
                </div>
            `;
            return;
        }

        // Chart.js configuration
        const ctx = progressChart.getContext('2d');
        
        // Check if Chart.js is available
        if (typeof Chart === 'undefined') {
            console.error('Chart.js not found');
            return;
        }

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Completed Steps', 'Pending Steps'],
                datasets: [{
                    data: [completedSteps, pendingSteps],
                    backgroundColor: [
                        'color-mix(in oklch, #1b7a4a 18%, #ffffff)', // btn-tonal success background
                        'color-mix(in oklch, #c98028 18%, #ffffff)'  // btn-tonal warning background
                    ],
                    borderColor: [
                        'color-mix(in oklch, #1b7a4a, transparent 78%)', // btn-tonal success border
                        'color-mix(in oklch, #c98028, transparent 78%)'  // btn-tonal warning border
                    ],
                    borderWidth: 2,
                    hoverBackgroundColor: [
                        'color-mix(in oklch, #1b7a4a 25%, #ffffff)', // darker on hover
                        'color-mix(in oklch, #c98028 25%, #ffffff)'  // darker on hover
                    ],
                    hoverBorderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            font: {
                                size: 14
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                },
                cutout: '60%', // Makes it a donut chart
                animation: {
                    animateRotate: true,
                    duration: 1000
                }
            }
        });

        console.log('📊 Task progress chart initialized');
    }

    function initTaskStatusChart() {
        const taskStatus = '<?php echo e($task->status); ?>';
        const ctx = statusChart.getContext('2d');
        
        // Check if Chart.js is available
        if (typeof Chart === 'undefined') {
            console.error('Chart.js not found');
            return;
        }

        // Define status colors and data
        let chartData, chartColors;
        
        // Define btn-tonal style colors with color-mix
        const neutralColor = '#e5e7eb';
        
        switch(taskStatus) {
            case 'completed':
                chartData = [100, 0, 0, 0];
                chartColors = [
                    'color-mix(in oklch, #1b7a4a 18%, #ffffff)', // success background
                    neutralColor, neutralColor, neutralColor
                ];
                break;
            case 'in_progress':
                chartData = [0, 100, 0, 0];
                chartColors = [
                    neutralColor, 
                    'color-mix(in oklch, #2563eb 18%, #ffffff)', // info background
                    neutralColor, neutralColor
                ];
                break;
            case 'pending':
                chartData = [0, 0, 100, 0];
                chartColors = [
                    neutralColor, neutralColor, 
                    'color-mix(in oklch, #c98028 18%, #ffffff)', // warning background
                    neutralColor
                ];
                break;
            case 'cancelled':
                chartData = [0, 0, 0, 100];
                chartColors = [
                    neutralColor, neutralColor, neutralColor, 
                    'color-mix(in oklch, #b21a50 18%, #ffffff)' // danger background
                ];
                break;
            default:
                chartData = [0, 0, 100, 0];
                chartColors = [
                    neutralColor, neutralColor, 
                    'color-mix(in oklch, #c98028 18%, #ffffff)', // warning background
                    neutralColor
                ];
        }

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'In Progress', 'Pending', 'Cancelled'],
                datasets: [{
                    data: chartData,
                    backgroundColor: chartColors,
                    borderColor: chartColors.map(color => {
                        if (color === '#e5e7eb') return '#d1d5db';
                        if (color.includes('#1b7a4a')) return 'color-mix(in oklch, #1b7a4a, transparent 78%)';
                        if (color.includes('#2563eb')) return 'color-mix(in oklch, #2563eb, transparent 78%)';
                        if (color.includes('#c98028')) return 'color-mix(in oklch, #c98028, transparent 78%)';
                        if (color.includes('#b21a50')) return 'color-mix(in oklch, #b21a50, transparent 78%)';
                        return color;
                    }),
                    borderWidth: 2,
                    hoverBackgroundColor: chartColors.map(color => {
                        if (color === '#e5e7eb') return '#d1d5db';
                        if (color.includes('#1b7a4a')) return 'color-mix(in oklch, #1b7a4a 25%, #ffffff)';
                        if (color.includes('#2563eb')) return 'color-mix(in oklch, #2563eb 25%, #ffffff)';
                        if (color.includes('#c98028')) return 'color-mix(in oklch, #c98028 25%, #ffffff)';
                        if (color.includes('#b21a50')) return 'color-mix(in oklch, #b21a50 25%, #ffffff)';
                        return color;
                    }),
                    hoverBorderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            font: {
                                size: 14
                            },
                            filter: function(legendItem, chartData) {
                                // Only show the active status in legend
                                const index = legendItem.index;
                                return chartData.datasets[0].data[index] > 0;
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + (context.parsed > 0 ? 'Active' : 'Inactive');
                            }
                        }
                    }
                },
                cutout: '70%', // Makes it a donut chart
                animation: {
                    animateRotate: true,
                    duration: 1000
                }
            }
        });

        console.log('📊 Task status chart initialized');
    }

    // Complete Task Button
    const completeTaskBtn = document.querySelector('.complete-task-btn');
    if (completeTaskBtn) {
        completeTaskBtn.addEventListener('click', function() {
            const taskId = this.getAttribute('data-task-id');
            console.log('✅ Complete task clicked:', taskId);
            
            if (confirm('Are you sure you want to mark this task as completed?')) {
                updateTaskStatus(taskId, 'completed');
            }
        });
    }

    // Start Task Button
    const startTaskBtn = document.querySelector('.start-task-btn');
    if (startTaskBtn) {
        startTaskBtn.addEventListener('click', function() {
            const taskId = this.getAttribute('data-task-id');
            console.log('▶️ Start task clicked:', taskId);
            
            updateTaskStatus(taskId, 'in_progress');
        });
    }

    // Add Comment Button
    const addCommentBtn = document.querySelector('.add-comment-btn');
    if (addCommentBtn) {
        addCommentBtn.addEventListener('click', function() {
            const taskId = this.getAttribute('data-task-id');
            console.log('💬 Add comment clicked:', taskId);
            
            showCommentModal(taskId);
        });
    }

    // Share Task Button
    const shareTaskBtn = document.querySelector('.share-task-btn');
    if (shareTaskBtn) {
        shareTaskBtn.addEventListener('click', function() {
            const taskId = this.getAttribute('data-task-id');
            console.log('📤 Share task clicked:', taskId);
            
            shareTask(taskId);
        });
    }

    // Update Task Status Function
    function updateTaskStatus(taskId, status) {
        fetch(`/tasks/${taskId}/update-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (typeof showToast === 'function') {
                    showToast(data.message || 'Task status updated successfully', 'success');
                }
                // Reload page to show updated status
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                if (typeof showToast === 'function') {
                    showToast(data.message || 'Failed to update task status', 'error');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (typeof showToast === 'function') {
                showToast('An error occurred while updating task status', 'error');
            }
        });
    }

    // Show Comment Modal Function
    function showCommentModal(taskId) {
        // Simple prompt for now - can be enhanced with a proper modal later
        const comment = prompt('Add your comment:');
        if (comment && comment.trim()) {
            addTaskComment(taskId, comment.trim());
        }
    }

    // Add Task Comment Function
    function addTaskComment(taskId, comment, isInternal = false) {
        fetch(`/tasks/${taskId}/comments`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ 
                comment: comment,
                is_internal: isInternal
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (typeof showToast === 'function') {
                    showToast(data.message || 'Comment added successfully', 'success');
                }
                // Reload page to show new comment
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                if (typeof showToast === 'function') {
                    showToast(data.message || 'Failed to add comment', 'error');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (typeof showToast === 'function') {
                showToast('An error occurred while adding comment', 'error');
            }
        });
    }

    // Handle comment form submission
    const commentForm = document.getElementById('add-comment-form');
    if (commentForm) {
        commentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get comment content from CKEditor
            let comment = '';
            
            if (commentEditor && editorReady) {
                // Use the stored editor instance
                comment = commentEditor.getData().trim();
            } else {
                // Fallback: try to find editor instance
                const editorElement = document.querySelector('#comment-editor .ck-editor__editable');
                if (editorElement) {
                    comment = editorElement.innerHTML.trim();
                } else {
                    // Last resort: get from any editor element
                    const fallbackElement = document.querySelector('#comment-editor .editor');
                    if (fallbackElement) {
                        comment = fallbackElement.innerHTML.trim();
                    }
                }
            }
            
            const isInternalCheckbox = document.querySelector('input[name="is_internal"]');
            const isInternal = isInternalCheckbox.checked;
            
            // Remove empty paragraph tags
            const cleanComment = comment.replace(/<p><\/p>/g, '').replace(/<p><br><\/p>/g, '').trim();
            
            if (cleanComment && cleanComment !== '<p>Write your comment here...</p>') {
                const taskId = document.querySelector('.complete-task-btn, .start-task-btn, .add-comment-btn')?.getAttribute('data-task-id');
                if (taskId) {
                    addTaskComment(taskId, cleanComment, isInternal);
                    
                    // Clear editor content
                    if (commentEditor && editorReady) {
                        commentEditor.setData('<p>Write your comment here...</p>');
                    } else {
                        // Fallback: clear editor content
                        const editorElement = document.querySelector('#comment-editor .ck-editor__editable');
                        if (editorElement) {
                            editorElement.innerHTML = '<p>Write your comment here...</p>';
                        }
                    }
                    
                    isInternalCheckbox.checked = false;
                }
            } else {
                if (typeof showToast === 'function') {
                    showToast('Please enter a comment', 'warning');
                }
            }
        });
    }

    // Share Task Function
    function shareTask(taskId) {
        const taskUrl = window.location.href;
        
        if (navigator.share) {
            // Use Web Share API if available
            navigator.share({
                title: 'Task Details',
                text: 'Check out this task',
                url: taskUrl
            }).then(() => {
                console.log('📤 Task shared successfully');
            }).catch(err => {
                console.log('📤 Share cancelled');
            });
        } else {
            // Fallback: copy to clipboard
            navigator.clipboard.writeText(taskUrl).then(() => {
                if (typeof showToast === 'function') {
                    showToast('Task link copied to clipboard!', 'success');
                }
            }).catch(err => {
                console.error('Failed to copy: ', err);
                if (typeof showToast === 'function') {
                    showToast('Failed to copy link', 'error');
                }
            });
        }
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('../themes/' . $activeTheme . '/' . $activeLayout, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\ERP System\Source\resources\views/tasks/show.blade.php ENDPATH**/ ?>
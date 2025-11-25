

<?php $__env->startSection('subhead'); ?>
    <title><?php echo e($task->title); ?> - Task Details</title>
<?php $__env->stopSection(); ?>

<?php
    $priorityClass = match($task->priority) {
        'high' => 'bg-red-100 text-red-700',
        'medium' => 'bg-yellow-100 text-yellow-700',
        'low' => 'bg-green-100 text-green-700',
        default => 'bg-gray-100 text-gray-700'
    };
    $statusClass = match($task->status) {
        'completed' => 'bg-green-100 text-green-700',
        'in_progress' => 'bg-blue-100 text-blue-700',
        'pending' => 'bg-yellow-100 text-yellow-700',
        'cancelled' => 'bg-red-100 text-red-700',
        default => 'bg-gray-100 text-gray-700'
    };
    $totalSteps = $task->steps->count();
    $completedSteps = $task->steps->where('is_completed', true)->count();
    $pendingSteps = $totalSteps - $completedSteps;
    $progressPercentage = $totalSteps > 0 ? round(($completedSteps / $totalSteps) * 100) : 0;
?>

<?php $__env->startSection('subcontent'); ?>
    <div class="intro-y mt-8 space-y-6">
        <!-- Header -->
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Task Details</p>
                <h1 class="text-2xl font-semibold text-slate-800 dark:text-slate-100">
                    <?php echo e($task->code); ?> — <?php echo e($task->title); ?>

                </h1>
            </div>
<a href="<?php echo e(route('tasks.index')); ?>" class="btn-royal btn-royal--outline btn-royal--sm">
                Back to list
            </a>
        </div>

        <!-- Main Content Box -->
        <?php if (isset($component)) { $__componentOriginal1e00c22da64774fd0d873cb958c26686 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1e00c22da64774fd0d873cb958c26686 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.preview-component.index','data' => ['class' => 'box']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.preview-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'box']); ?>
            <div class="space-y-6 p-5">
                <!-- Task Header Info -->
                <div class="flex flex-col gap-3 rounded-2xl border border-slate-200/70 bg-slate-50/60 p-4 dark:border-darkmode-400 dark:bg-darkmode-600/30">
                    <div class="flex flex-wrap items-center gap-3">
                        <?php if($task->color): ?>
                            <div class="w-6 h-6 rounded-full border-2 border-white shadow-sm" style="background-color: <?php echo e($task->color); ?>"></div>
                        <?php endif; ?>
                        <div class="flex-1 min-w-[200px]">
                            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">Task</p>
                            <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100"><?php echo e($task->title); ?></h3>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-semibold <?php echo e($priorityClass); ?>">
                                <?php echo e(ucfirst($task->priority)); ?>

                            </span>
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-semibold <?php echo e($statusClass); ?>">
                                <?php echo e(ucfirst(str_replace('_', ' ', $task->status))); ?>

                            </span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-12 gap-6">
                    <!-- Left Column -->
                    <div class="col-span-12 lg:col-span-8 space-y-6">
                        <!-- General Information -->
                        <div class="rounded-xl border border-slate-200/70 p-5 dark:border-darkmode-400">
                            <h2 class="text-sm font-semibold text-slate-600 mb-4">General Information</h2>
                            <div class="grid flex-1 grid-cols-1 gap-4 text-sm md:grid-cols-2">
                                <div>
                                    <p class="text-xs text-slate-500">Task Code</p>
                                    <p class="font-medium font-mono"><?php echo e($task->code); ?></p>
                                </div>
                                <?php if($task->due_date): ?>
                                    <div>
                                        <p class="text-xs text-slate-500">Due Date</p>
                                        <p class="font-medium"><?php echo e($task->due_date->format('M d, Y')); ?>

                                            <?php if($task->due_date->isPast() && $task->status !== 'completed'): ?>
                                                <span class="text-red-500 text-xs">(Overdue)</span>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                <?php endif; ?>
                                <?php if($task->estimated_hours): ?>
                                    <div>
                                        <p class="text-xs text-slate-500">Estimated Hours</p>
                                        <p class="font-medium"><?php echo e($task->estimated_hours); ?> hours</p>
                                    </div>
                                <?php endif; ?>
                                <?php if($task->employee): ?>
                                    <div>
                                        <p class="text-xs text-slate-500">Assigned To</p>
                                        <a href="<?php echo e(route('hr.employees.show', $task->employee)); ?>" 
                                           class="font-medium text-primary hover:text-primary/80 hover:underline transition-colors"
                                           target="_blank">
                                            <?php echo e($task->employee->full_name); ?>

                                            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'external-link','class' => 'w-3 h-3 inline-block ml-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'external-link','class' => 'w-3 h-3 inline-block ml-1']); ?>
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
                                <?php endif; ?>
                                <?php if($task->project): ?>
                                    <div>
                                        <p class="text-xs text-slate-500">Project</p>
                                        <p class="font-medium"><?php echo e($task->project->name); ?></p>
                                    </div>
                                <?php endif; ?>
                                <?php if($task->assignedBy): ?>
                                    <div>
                                        <p class="text-xs text-slate-500">Assigned By</p>
                                        <p class="font-medium"><?php echo e($task->assignedBy->name); ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <?php if($task->description): ?>
                                <div class="mt-4 pt-4 border-t border-slate-200/60">
                                    <p class="text-xs text-slate-500 mb-2">Description</p>
                                    <p class="text-slate-600"><?php echo e($task->description); ?></p>
                                </div>
                            <?php endif; ?>

                            <?php if($task->tags): ?>
                                <div class="mt-4 pt-4 border-t border-slate-200/60">
                                    <p class="text-xs text-slate-500 mb-2">Tags</p>
                                    <div class="flex flex-wrap gap-2">
                                        <?php $__currentLoopData = explode(',', $task->tags); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700"><?php echo e(trim($tag)); ?></span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Task Timeline -->
                        <?php if($task->steps->count() > 0): ?>
                            <div class="rounded-xl border border-slate-200/70 p-5 dark:border-darkmode-400">
                                <h2 class="text-sm font-semibold text-slate-600 mb-4">Task Timeline</h2>
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
                        <?php endif; ?>

                        <!-- Task Comments -->
                        <div class="rounded-xl border border-slate-200/70 p-5 dark:border-darkmode-400">
                            <h2 class="text-sm font-semibold text-slate-600 mb-4">Comments (<?php echo e($task->taskComments->count()); ?>)</h2>
                            
                            <!-- Add Comment Form -->
                            <div class="mb-6">
                                <form id="add-comment-form" class="space-y-3">
                                    <?php echo csrf_field(); ?>
                                    <textarea 
                                        id="comment-text" 
                                        name="comment" 
                                        rows="3" 
                                        placeholder="Write your comment here..."
                                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-darkmode-400 dark:bg-darkmode-700 resize-none"
                                        required
                                    ></textarea>
                                    <div class="flex items-center justify-between">
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="is_internal" id="is_internal" class="rounded border-slate-300 text-primary">
                                            <span class="ml-2 text-sm text-slate-600">Internal comment</span>
                                        </label>
<button type="submit" class="btn-royal btn-royal--gold btn-royal--sm">Add Comment</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Comments List -->
                            <div id="comments-list" class="space-y-4">
                                <?php $__empty_1 = true; $__currentLoopData = $task->taskComments->sortByDesc('created_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="comment-item flex gap-3 p-4 bg-slate-50 dark:bg-darkmode-600 rounded-lg" data-comment-id="<?php echo e($comment->id); ?>">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 bg-gradient-to-br from-primary to-primary/70 text-white rounded-full flex items-center justify-center text-sm font-semibold shadow-md">
                                                <?php echo e(strtoupper(substr($comment->user->name ?? 'U', 0, 1))); ?>

                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between mb-2">
                                                <div class="flex items-center gap-2 flex-wrap">
                                                    <span class="font-semibold text-sm text-slate-800 dark:text-slate-200">
                                                        <?php echo e($comment->user->name ?? 'Unknown User'); ?>

                                                    </span>
                                                    <span class="text-xs text-slate-500"><?php echo e($comment->time_ago); ?></span>
                                                    <?php if($comment->is_internal): ?>
                                                        <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium bg-yellow-100 text-yellow-800">
                                                            Internal
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
<div class="text-sm text-slate-600 dark:text-slate-400 mb-3">
                                                <?php echo nl2br(e($comment->comment)); ?>

                                            </div>
                                            <!-- Comment Reactions -->
                                            <div class="flex items-center gap-3">
                                                <button type="button" 
                                                        class="reaction-btn flex items-center gap-1 px-2 py-1 rounded-full text-xs transition-all <?php echo e($comment->user_reaction === 'like' ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600 hover:bg-green-50 hover:text-green-600'); ?>"
                                                        data-comment-id="<?php echo e($comment->id); ?>"
                                                        data-type="like">
                                                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'thumbs-up','class' => 'w-3.5 h-3.5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'thumbs-up','class' => 'w-3.5 h-3.5']); ?>
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
                                                    <span class="likes-count"><?php echo e($comment->likes_count); ?></span>
                                                </button>
                                                <button type="button" 
                                                        class="reaction-btn flex items-center gap-1 px-2 py-1 rounded-full text-xs transition-all <?php echo e($comment->user_reaction === 'dislike' ? 'bg-red-100 text-red-700' : 'bg-slate-100 text-slate-600 hover:bg-red-50 hover:text-red-600'); ?>"
                                                        data-comment-id="<?php echo e($comment->id); ?>"
                                                        data-type="dislike">
                                                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'thumbs-down','class' => 'w-3.5 h-3.5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'thumbs-down','class' => 'w-3.5 h-3.5']); ?>
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
                                                    <span class="dislikes-count"><?php echo e($comment->dislikes_count); ?></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div id="no-comments-message" class="text-center py-8 text-slate-500">
                                        <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'message-square','class' => 'w-12 h-12 mx-auto mb-2 text-slate-300']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'message-square','class' => 'w-12 h-12 mx-auto mb-2 text-slate-300']); ?>
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

                    <!-- Right Column (Sidebar) -->
                    <div class="col-span-12 lg:col-span-4 space-y-6">
                        <!-- Summary -->
                        <div class="rounded-xl border border-slate-200/70 p-5 dark:border-darkmode-400">
                            <h2 class="text-sm font-semibold text-slate-600 mb-4">Summary</h2>
                            <dl class="space-y-3 text-sm">
                                <div class="flex justify-between">
                                    <dt>Status</dt>
                                    <dd class="font-semibold capitalize"><?php echo e(str_replace('_', ' ', $task->status)); ?></dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt>Priority</dt>
                                    <dd class="font-semibold capitalize"><?php echo e($task->priority); ?></dd>
                                </div>
                                <?php if($totalSteps > 0): ?>
                                    <div class="flex justify-between">
                                        <dt>Progress</dt>
                                        <dd class="font-semibold"><?php echo e($progressPercentage); ?>%</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt>Steps</dt>
                                        <dd class="font-semibold"><?php echo e($completedSteps); ?>/<?php echo e($totalSteps); ?></dd>
                                    </div>
                                <?php endif; ?>
                            </dl>
                        </div>

                        <!-- Like Task -->
                        <div class="rounded-xl border border-slate-200/70 p-5 dark:border-darkmode-400">
                            <h2 class="text-sm font-semibold text-slate-600 mb-4">Rate This Task</h2>
                            <div class="flex flex-col items-center gap-3">
                                <button type="button" 
                                        id="task-like-btn"
                                        class="task-like-btn flex items-center gap-2 px-6 py-3 rounded-xl text-lg font-semibold transition-all <?php echo e($task->is_liked_by_user ? 'bg-gradient-to-r from-pink-500 to-red-500 text-white shadow-lg' : 'bg-slate-100 text-slate-600 hover:bg-pink-50 hover:text-pink-600'); ?>"
                                        data-task-id="<?php echo e($task->id); ?>">
                                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'heart','class' => 'w-6 h-6 '.e($task->is_liked_by_user ? 'fill-current' : '').'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'heart','class' => 'w-6 h-6 '.e($task->is_liked_by_user ? 'fill-current' : '').'']); ?>
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
                                    <span id="task-likes-count"><?php echo e($task->likes_count); ?></span>
                                </button>
                                <p class="text-xs text-slate-500">Like this task to appreciate the work!</p>
                                <?php if($task->employee): ?>
                                    <p class="text-xs text-slate-400">Points go to: 
                                        <a href="<?php echo e(route('hr.employees.show', $task->employee)); ?>" 
                                           class="font-semibold text-primary hover:underline" 
                                           target="_blank"><?php echo e($task->employee->full_name); ?></a>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="rounded-xl border border-slate-200/70 p-5 dark:border-darkmode-400">
                            <h2 class="text-sm font-semibold text-slate-600 mb-4">Quick Actions</h2>
                            <div class="space-y-3">
                                <?php if($task->status !== 'completed'): ?>
                                    <button type="button" class="btn-royal btn-royal--gold w-full complete-task-btn" data-task-id="<?php echo e($task->id); ?>">
                                        <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'check','class' => 'w-4 h-4 mr-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'check','class' => 'w-4 h-4 mr-2']); ?>
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
                                    </button>
                                <?php endif; ?>
                                
                                <?php if($task->status === 'pending'): ?>
                                    <button type="button" class="btn-royal btn-royal--outline w-full start-task-btn" data-task-id="<?php echo e($task->id); ?>">
                                        <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'play','class' => 'w-4 h-4 mr-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'play','class' => 'w-4 h-4 mr-2']); ?>
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
                                    </button>
                                <?php endif; ?>

                                <button type="button" class="btn-royal btn-royal--outline w-full share-task-btn" data-task-id="<?php echo e($task->id); ?>">
                                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'share','class' => 'w-4 h-4 mr-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'share','class' => 'w-4 h-4 mr-2']); ?>
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
                                </button>
                            </div>
                        </div>

                        <!-- Activity Log -->
                        <div class="rounded-xl border border-slate-200/70 p-5 dark:border-darkmode-400">
                            <h2 class="text-sm font-semibold text-slate-600 mb-4">Activity</h2>
                            <div class="space-y-3 text-sm">
                                <div class="flex items-start gap-3">
                                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full text-xs font-semibold bg-blue-100 text-blue-700">C</span>
                                    <div>
                                        <p class="font-semibold">Created</p>
                                        <p class="text-xs text-slate-500"><?php echo e($task->created_at->format('M d, Y H:i')); ?></p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full text-xs font-semibold bg-green-100 text-green-700">U</span>
                                    <div>
                                        <p class="font-semibold">Last Updated</p>
                                        <p class="text-xs text-slate-500"><?php echo e($task->updated_at->format('M d, Y H:i')); ?></p>
                                    </div>
                                </div>
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const taskId = <?php echo e($task->id); ?>;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Add Comment Form Handler
    const addCommentForm = document.getElementById('add-comment-form');
    if (addCommentForm) {
        addCommentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const commentText = document.getElementById('comment-text').value.trim();
            const isInternal = document.getElementById('is_internal').checked;
            
            if (!commentText) {
                window.showWarning && showWarning('Please enter a comment');
                return;
            }
            
            fetch(`/tasks/${taskId}/comments`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    comment: commentText,
                    is_internal: isInternal
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.showSuccess && showSuccess('Comment added successfully');
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    window.showError && showError(data.message || 'Failed to add comment');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                window.showError && showError('Failed to add comment');
            });
        });
    }

    // Complete Task Button
    document.querySelectorAll('.complete-task-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const taskId = this.getAttribute('data-task-id');
            fetch(`/tasks/${taskId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ status: 'completed' })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.showSuccess && showSuccess('Task marked as completed!');
                    setTimeout(() => window.location.reload(), 1000);
                }
            });
        });
    });

    // Start Task Button
    document.querySelectorAll('.start-task-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const taskId = this.getAttribute('data-task-id');
            fetch(`/tasks/${taskId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ status: 'in_progress' })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.showSuccess && showSuccess('Task started!');
                    setTimeout(() => window.location.reload(), 1000);
                }
            });
        });
    });

    // Share Task Button
    document.querySelectorAll('.share-task-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            navigator.clipboard.writeText(window.location.href).then(() => {
                window.showSuccess && showSuccess('Task link copied to clipboard!');
            });
        });
    });

    // Task Like Button
    const taskLikeBtn = document.getElementById('task-like-btn');
    if (taskLikeBtn) {
        taskLikeBtn.addEventListener('click', function() {
            const id = this.getAttribute('data-task-id');
            
            fetch(`/tasks/${id}/like`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Handle both data.data and direct data structure
                const responseData = data.data || data;
                
                if (data.success) {
                    const likesCount = document.getElementById('task-likes-count');
                    likesCount.textContent = responseData.likes_count;
                    
                    if (responseData.is_liked) {
                        taskLikeBtn.classList.remove('bg-slate-100', 'text-slate-600', 'hover:bg-pink-50', 'hover:text-pink-600');
                        taskLikeBtn.classList.add('bg-gradient-to-r', 'from-pink-500', 'to-red-500', 'text-white', 'shadow-lg');
                        taskLikeBtn.querySelector('svg').classList.add('fill-current');
                        window.showSuccess && showSuccess('You liked this task! ❤️');
                    } else {
                        taskLikeBtn.classList.add('bg-slate-100', 'text-slate-600', 'hover:bg-pink-50', 'hover:text-pink-600');
                        taskLikeBtn.classList.remove('bg-gradient-to-r', 'from-pink-500', 'to-red-500', 'text-white', 'shadow-lg');
                        taskLikeBtn.querySelector('svg').classList.remove('fill-current');
                        window.showInfo && showInfo('Like removed');
                    }
                } else {
                    window.showError && showError(data.message || 'Failed to update like');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                window.showError && showError('Failed to update like');
            });
        });
    }

    // Comment Reaction Buttons
    document.querySelectorAll('.reaction-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const commentId = this.getAttribute('data-comment-id');
            const type = this.getAttribute('data-type');
            const button = this;
            
            fetch(`/tasks/comments/${commentId}/reaction`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ type: type })
            })
            .then(response => response.json())
            .then(data => {
                // Handle both data.data and direct data structure
                const responseData = data.data || data;
                
                if (data.success) {
                    // Update counts
                    const commentItem = button.closest('.comment-item');
                    commentItem.querySelector('.likes-count').textContent = responseData.likes_count;
                    commentItem.querySelector('.dislikes-count').textContent = responseData.dislikes_count;
                    
                    // Update button styles
                    const likeBtn = commentItem.querySelector('[data-type="like"]');
                    const dislikeBtn = commentItem.querySelector('[data-type="dislike"]');
                    
                    // Reset both buttons
                    likeBtn.classList.remove('bg-green-100', 'text-green-700');
                    likeBtn.classList.add('bg-slate-100', 'text-slate-600');
                    dislikeBtn.classList.remove('bg-red-100', 'text-red-700');
                    dislikeBtn.classList.add('bg-slate-100', 'text-slate-600');
                    
                    // Apply active style
                    if (responseData.user_reaction === 'like') {
                        likeBtn.classList.remove('bg-slate-100', 'text-slate-600');
                        likeBtn.classList.add('bg-green-100', 'text-green-700');
                    } else if (responseData.user_reaction === 'dislike') {
                        dislikeBtn.classList.remove('bg-slate-100', 'text-slate-600');
                        dislikeBtn.classList.add('bg-red-100', 'text-red-700');
                    }
                } else {
                    window.showError && showError(data.message || 'Failed to update reaction');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                window.showError && showError('Failed to update reaction');
            });
        });
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('../themes/' . $activeTheme . '/' . $activeLayout, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\smart-erp\resources\views/tasks/show.blade.php ENDPATH**/ ?>
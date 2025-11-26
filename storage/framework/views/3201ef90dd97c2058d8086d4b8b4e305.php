<!-- Notification Settings Content -->
<div class="bg-white dark:bg-darkmode-600 rounded-lg shadow-sm border border-slate-200/60 dark:border-darkmode-400 mt-5">
    <div class="flex items-center border-b border-slate-200/60 p-5 dark:border-darkmode-400">
        <h2 class="mr-auto text-base font-medium flex items-center">
            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Bell','class' => 'w-5 h-5 mr-2 text-yellow-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Bell','class' => 'w-5 h-5 mr-2 text-yellow-500']); ?>
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
            <?php echo e(__('settings.notification_settings')); ?>

        </h2>
    </div>

    <?php
        // Notification Channels
        $channelSettings = [
            'database' => [
                'label' => __('settings.in_app_notifications'),
                'description' => __('settings.in_app_notifications_desc'),
                'icon' => 'bell',
                'value' => \App\Models\Setting\Setting::get('notifications.channels.database', true),
            ],
            'mail' => [
                'label' => __('settings.email_notifications'),
                'description' => __('settings.email_notifications_desc'),
                'icon' => 'mail',
                'value' => \App\Models\Setting\Setting::get('notifications.channels.mail', false),
            ],
        ];

        // Task Notifications
        $taskNotifications = [
            'task.assigned' => [
                'label' => __('settings.task_assigned'),
                'description' => __('settings.task_assigned_desc'),
                'value' => \App\Models\Setting\Setting::get('notifications.task.assigned', true),
            ],
            'task.started' => [
                'label' => __('settings.task_started'),
                'description' => __('settings.task_started_desc'),
                'value' => \App\Models\Setting\Setting::get('notifications.task.started', true),
            ],
            'task.completed' => [
                'label' => __('settings.task_completed'),
                'description' => __('settings.task_completed_desc'),
                'value' => \App\Models\Setting\Setting::get('notifications.task.completed', true),
            ],
            'task.updated' => [
                'label' => __('settings.task_updated'),
                'description' => __('settings.task_updated_desc'),
                'value' => \App\Models\Setting\Setting::get('notifications.task.updated', true),
            ],
            'task.commented' => [
                'label' => __('settings.task_commented'),
                'description' => __('settings.task_commented_desc'),
                'value' => \App\Models\Setting\Setting::get('notifications.task.commented', true),
            ],
            'task.liked' => [
                'label' => __('settings.task_liked'),
                'description' => __('settings.task_liked_desc'),
                'value' => \App\Models\Setting\Setting::get('notifications.task.liked', true),
            ],
        ];

        // Task Extension Notifications
        $extensionNotifications = [
            'task_extension.requested' => [
                'label' => __('settings.extension_requested'),
                'description' => __('settings.extension_requested_desc'),
                'value' => \App\Models\Setting\Setting::get('notifications.task_extension.requested', true),
            ],
            'task_extension.approved' => [
                'label' => __('settings.extension_approved'),
                'description' => __('settings.extension_approved_desc'),
                'value' => \App\Models\Setting\Setting::get('notifications.task_extension.approved', true),
            ],
            'task_extension.rejected' => [
                'label' => __('settings.extension_rejected'),
                'description' => __('settings.extension_rejected_desc'),
                'value' => \App\Models\Setting\Setting::get('notifications.task_extension.rejected', true),
            ],
        ];

        // HR Notifications
        $hrNotifications = [
            'department.created' => [
                'label' => __('settings.department_created'),
                'description' => __('settings.department_created_desc'),
                'value' => \App\Models\Setting\Setting::get('notifications.department.created', true),
            ],
            'employee.created' => [
                'label' => __('settings.employee_created'),
                'description' => __('settings.employee_created_desc'),
                'value' => \App\Models\Setting\Setting::get('notifications.employee.created', true),
            ],
        ];

        // Payroll Notifications
        $payrollNotifications = [
            'payroll.generated' => [
                'label' => 'Payroll Generated',
                'description' => 'When payroll is generated for employees',
                'value' => \App\Models\Setting\Setting::get('notifications.payroll.generated', true),
            ],
            'payroll.approved' => [
                'label' => 'Payroll Approved',
                'description' => 'When payroll is approved',
                'value' => \App\Models\Setting\Setting::get('notifications.payroll.approved', true),
            ],
            'payroll.paid' => [
                'label' => 'Salary Paid',
                'description' => 'When salary is paid to employee',
                'value' => \App\Models\Setting\Setting::get('notifications.payroll.paid', true),
            ],
        ];

        // Penalty Notifications
        $penaltyNotifications = [
            'penalty.created' => [
                'label' => 'Penalty Created',
                'description' => 'When a penalty is issued to employee',
                'value' => \App\Models\Setting\Setting::get('notifications.penalty.created', true),
            ],
            'penalty.approved' => [
                'label' => 'Penalty Approved',
                'description' => 'When a penalty is approved',
                'value' => \App\Models\Setting\Setting::get('notifications.penalty.approved', true),
            ],
        ];

        // Advance Notifications
        $advanceNotifications = [
            'advance.requested' => [
                'label' => 'Advance Requested',
                'description' => 'When employee requests advance/loan',
                'value' => \App\Models\Setting\Setting::get('notifications.advance.requested', true),
            ],
            'advance.approved' => [
                'label' => 'Advance Approved',
                'description' => 'When advance request is approved',
                'value' => \App\Models\Setting\Setting::get('notifications.advance.approved', true),
            ],
            'advance.disbursed' => [
                'label' => 'Advance Disbursed',
                'description' => 'When advance is disbursed',
                'value' => \App\Models\Setting\Setting::get('notifications.advance.disbursed', true),
            ],
        ];

        // Leave Notifications
        $leaveNotifications = [
            'leave.requested' => [
                'label' => 'Leave Requested',
                'description' => 'When employee requests leave',
                'value' => \App\Models\Setting\Setting::get('notifications.leave.requested', true),
            ],
            'leave.approved' => [
                'label' => 'Leave Approved',
                'description' => 'When leave request is approved',
                'value' => \App\Models\Setting\Setting::get('notifications.leave.approved', true),
            ],
            'leave.rejected' => [
                'label' => 'Leave Rejected',
                'description' => 'When leave request is rejected',
                'value' => \App\Models\Setting\Setting::get('notifications.leave.rejected', true),
            ],
        ];

        $documentsExpiryReminderDays = \App\Models\Setting\Setting::get('notifications.documents.expiry_reminder_days', 30);
    ?>

    <form id="notification-settings-form" action="<?php echo e(route('settings.notifications.update')); ?>" method="POST" class="p-5">
        <?php echo csrf_field(); ?>
        
        <!-- Notification Channels Section -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100 mb-4 flex items-center border-b border-slate-200 dark:border-darkmode-400 pb-3">
                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'radio','class' => 'w-5 h-5 mr-2 text-primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'radio','class' => 'w-5 h-5 mr-2 text-primary']); ?>
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
                <?php echo e(__('settings.notification_channels')); ?>

            </h3>
            <p class="text-sm text-slate-500 mb-4"><?php echo e(__('settings.notification_channels_desc')); ?></p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php $__currentLoopData = $channelSettings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $channel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $fieldName = 'notifications_channels_' . $key; ?>
                    <div class="p-4 rounded-lg border border-slate-200 dark:border-darkmode-400 bg-slate-50 dark:bg-darkmode-700">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center">
                                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => ''.e($channel['icon']).'','class' => 'w-5 h-5 text-primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => ''.e($channel['icon']).'','class' => 'w-5 h-5 text-primary']); ?>
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
                                    <div class="font-medium text-slate-800 dark:text-slate-100"><?php echo e($channel['label']); ?></div>
                                    <div class="text-xs text-slate-500"><?php echo e($channel['description']); ?></div>
                                </div>
                            </div>
                            <input type="hidden" name="<?php echo e($fieldName); ?>" value="0">
                            <label class="inline-flex cursor-pointer items-center">
                                <input type="checkbox" name="<?php echo e($fieldName); ?>" value="1" <?php echo e($channel['value'] ? 'checked' : ''); ?> class="sr-only peer" />
                                <div class="relative w-11 h-6 rounded-full bg-slate-200 transition-colors duration-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/25 dark:bg-darkmode-600 peer-checked:bg-primary after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition-all after:duration-200 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full"></div>
                            </label>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <!-- Task Notifications Section -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100 mb-4 flex items-center border-b border-slate-200 dark:border-darkmode-400 pb-3">
                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'clipboard-list','class' => 'w-5 h-5 mr-2 text-blue-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'clipboard-list','class' => 'w-5 h-5 mr-2 text-blue-500']); ?>
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
                <?php echo e(__('settings.task_notifications')); ?>

            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php $__currentLoopData = $taskNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $fieldName = 'notifications_' . str_replace('.', '_', $key); ?>
                    <div class="flex items-center justify-between p-3 rounded-lg border border-slate-200 dark:border-darkmode-400">
                        <div class="flex-1">
                            <div class="font-medium text-sm text-slate-800 dark:text-slate-100"><?php echo e($notification['label']); ?></div>
                            <div class="text-xs text-slate-500"><?php echo e($notification['description']); ?></div>
                        </div>
                        <input type="hidden" name="<?php echo e($fieldName); ?>" value="0">
                        <label class="inline-flex cursor-pointer items-center ml-3">
                            <input type="checkbox" name="<?php echo e($fieldName); ?>" value="1" <?php echo e($notification['value'] ? 'checked' : ''); ?> class="sr-only peer" />
                            <div class="relative w-11 h-6 rounded-full bg-slate-200 transition-colors duration-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/25 dark:bg-darkmode-600 peer-checked:bg-primary after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition-all after:duration-200 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full"></div>
                        </label>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <!-- Task Extension Notifications Section -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100 mb-4 flex items-center border-b border-slate-200 dark:border-darkmode-400 pb-3">
                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'clock','class' => 'w-5 h-5 mr-2 text-yellow-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'clock','class' => 'w-5 h-5 mr-2 text-yellow-500']); ?>
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
                <?php echo e(__('settings.extension_notifications')); ?>

            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <?php $__currentLoopData = $extensionNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $fieldName = 'notifications_' . str_replace('.', '_', $key); ?>
                    <div class="flex items-center justify-between p-3 rounded-lg border border-slate-200 dark:border-darkmode-400">
                        <div class="flex-1">
                            <div class="font-medium text-sm text-slate-800 dark:text-slate-100"><?php echo e($notification['label']); ?></div>
                            <div class="text-xs text-slate-500"><?php echo e($notification['description']); ?></div>
                        </div>
                        <input type="hidden" name="<?php echo e($fieldName); ?>" value="0">
                        <label class="inline-flex cursor-pointer items-center ml-3">
                            <input type="checkbox" name="<?php echo e($fieldName); ?>" value="1" <?php echo e($notification['value'] ? 'checked' : ''); ?> class="sr-only peer" />
                            <div class="relative w-11 h-6 rounded-full bg-slate-200 transition-colors duration-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/25 dark:bg-darkmode-600 peer-checked:bg-primary after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition-all after:duration-200 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full"></div>
                        </label>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <!-- HR Notifications Section -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100 mb-4 flex items-center border-b border-slate-200 dark:border-darkmode-400 pb-3">
                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'users','class' => 'w-5 h-5 mr-2 text-green-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'users','class' => 'w-5 h-5 mr-2 text-green-500']); ?>
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
                <?php echo e(__('settings.hr_notifications')); ?>

            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php $__currentLoopData = $hrNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $fieldName = 'notifications_' . str_replace('.', '_', $key); ?>
                    <div class="flex items-center justify-between p-3 rounded-lg border border-slate-200 dark:border-darkmode-400">
                        <div class="flex-1">
                            <div class="font-medium text-sm text-slate-800 dark:text-slate-100"><?php echo e($notification['label']); ?></div>
                            <div class="text-xs text-slate-500"><?php echo e($notification['description']); ?></div>
                        </div>
                        <input type="hidden" name="<?php echo e($fieldName); ?>" value="0">
                        <label class="inline-flex cursor-pointer items-center ml-3">
                            <input type="checkbox" name="<?php echo e($fieldName); ?>" value="1" <?php echo e($notification['value'] ? 'checked' : ''); ?> class="sr-only peer" />
                            <div class="relative w-11 h-6 rounded-full bg-slate-200 transition-colors duration-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/25 dark:bg-darkmode-600 peer-checked:bg-primary after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition-all after:duration-200 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full"></div>
                        </label>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <!-- Payroll Notifications Section -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100 mb-4 flex items-center border-b border-slate-200 dark:border-darkmode-400 pb-3">
                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'wallet','class' => 'w-5 h-5 mr-2 text-emerald-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'wallet','class' => 'w-5 h-5 mr-2 text-emerald-500']); ?>
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
                Payroll Notifications
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <?php $__currentLoopData = $payrollNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $fieldName = 'notifications_' . str_replace('.', '_', $key); ?>
                    <div class="flex items-center justify-between p-3 rounded-lg border border-slate-200 dark:border-darkmode-400">
                        <div class="flex-1">
                            <div class="font-medium text-sm text-slate-800 dark:text-slate-100"><?php echo e($notification['label']); ?></div>
                            <div class="text-xs text-slate-500"><?php echo e($notification['description']); ?></div>
                        </div>
                        <input type="hidden" name="<?php echo e($fieldName); ?>" value="0">
                        <label class="inline-flex cursor-pointer items-center ml-3">
                            <input type="checkbox" name="<?php echo e($fieldName); ?>" value="1" <?php echo e($notification['value'] ? 'checked' : ''); ?> class="sr-only peer" />
                            <div class="relative w-11 h-6 rounded-full bg-slate-200 transition-colors duration-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/25 dark:bg-darkmode-600 peer-checked:bg-primary after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition-all after:duration-200 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full"></div>
                        </label>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <!-- Penalty Notifications Section -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100 mb-4 flex items-center border-b border-slate-200 dark:border-darkmode-400 pb-3">
                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'alert-triangle','class' => 'w-5 h-5 mr-2 text-orange-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'alert-triangle','class' => 'w-5 h-5 mr-2 text-orange-500']); ?>
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
                Penalty Notifications
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php $__currentLoopData = $penaltyNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $fieldName = 'notifications_' . str_replace('.', '_', $key); ?>
                    <div class="flex items-center justify-between p-3 rounded-lg border border-slate-200 dark:border-darkmode-400">
                        <div class="flex-1">
                            <div class="font-medium text-sm text-slate-800 dark:text-slate-100"><?php echo e($notification['label']); ?></div>
                            <div class="text-xs text-slate-500"><?php echo e($notification['description']); ?></div>
                        </div>
                        <input type="hidden" name="<?php echo e($fieldName); ?>" value="0">
                        <label class="inline-flex cursor-pointer items-center ml-3">
                            <input type="checkbox" name="<?php echo e($fieldName); ?>" value="1" <?php echo e($notification['value'] ? 'checked' : ''); ?> class="sr-only peer" />
                            <div class="relative w-11 h-6 rounded-full bg-slate-200 transition-colors duration-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/25 dark:bg-darkmode-600 peer-checked:bg-primary after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition-all after:duration-200 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full"></div>
                        </label>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <!-- Advance Notifications Section -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100 mb-4 flex items-center border-b border-slate-200 dark:border-darkmode-400 pb-3">
                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'hand-coins','class' => 'w-5 h-5 mr-2 text-violet-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'hand-coins','class' => 'w-5 h-5 mr-2 text-violet-500']); ?>
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
                Advance & Loan Notifications
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <?php $__currentLoopData = $advanceNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $fieldName = 'notifications_' . str_replace('.', '_', $key); ?>
                    <div class="flex items-center justify-between p-3 rounded-lg border border-slate-200 dark:border-darkmode-400">
                        <div class="flex-1">
                            <div class="font-medium text-sm text-slate-800 dark:text-slate-100"><?php echo e($notification['label']); ?></div>
                            <div class="text-xs text-slate-500"><?php echo e($notification['description']); ?></div>
                        </div>
                        <input type="hidden" name="<?php echo e($fieldName); ?>" value="0">
                        <label class="inline-flex cursor-pointer items-center ml-3">
                            <input type="checkbox" name="<?php echo e($fieldName); ?>" value="1" <?php echo e($notification['value'] ? 'checked' : ''); ?> class="sr-only peer" />
                            <div class="relative w-11 h-6 rounded-full bg-slate-200 transition-colors duration-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/25 dark:bg-darkmode-600 peer-checked:bg-primary after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition-all after:duration-200 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full"></div>
                        </label>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <!-- Leave Notifications Section -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100 mb-4 flex items-center border-b border-slate-200 dark:border-darkmode-400 pb-3">
                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'calendar-off','class' => 'w-5 h-5 mr-2 text-sky-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'calendar-off','class' => 'w-5 h-5 mr-2 text-sky-500']); ?>
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
                Leave Notifications
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <?php $__currentLoopData = $leaveNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $fieldName = 'notifications_' . str_replace('.', '_', $key); ?>
                    <div class="flex items-center justify-between p-3 rounded-lg border border-slate-200 dark:border-darkmode-400">
                        <div class="flex-1">
                            <div class="font-medium text-sm text-slate-800 dark:text-slate-100"><?php echo e($notification['label']); ?></div>
                            <div class="text-xs text-slate-500"><?php echo e($notification['description']); ?></div>
                        </div>
                        <input type="hidden" name="<?php echo e($fieldName); ?>" value="0">
                        <label class="inline-flex cursor-pointer items-center ml-3">
                            <input type="checkbox" name="<?php echo e($fieldName); ?>" value="1" <?php echo e($notification['value'] ? 'checked' : ''); ?> class="sr-only peer" />
                            <div class="relative w-11 h-6 rounded-full bg-slate-200 transition-colors duration-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/25 dark:bg-darkmode-600 peer-checked:bg-primary after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition-all after:duration-200 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full"></div>
                        </label>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <!-- Document Expiry Settings -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100 mb-4 flex items-center border-b border-slate-200 dark:border-darkmode-400 pb-3">
                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'file-warning','class' => 'w-5 h-5 mr-2 text-red-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'file-warning','class' => 'w-5 h-5 mr-2 text-red-500']); ?>
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
                <?php echo e(__('settings.document_expiry')); ?>

            </h3>
            
            <div class="p-4 rounded-lg border border-slate-200 dark:border-darkmode-400 bg-slate-50 dark:bg-darkmode-700">
                <div class="flex items-center gap-4">
                    <div class="flex-1">
                        <div class="font-medium text-slate-800 dark:text-slate-100"><?php echo e(__('settings.expiry_reminder_days')); ?></div>
                        <div class="text-xs text-slate-500"><?php echo e(__('settings.expiry_reminder_days_desc')); ?></div>
                    </div>
                    <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['type' => 'number','min' => '1','max' => '365','name' => 'notifications_documents_expiry_reminder_days','value' => ''.e($documentsExpiryReminderDays).'','class' => 'w-24 text-center']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'number','min' => '1','max' => '365','name' => 'notifications_documents_expiry_reminder_days','value' => ''.e($documentsExpiryReminderDays).'','class' => 'w-24 text-center']); ?>
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
                    <span class="text-sm text-slate-500"><?php echo e(__('settings.days')); ?></span>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end border-t border-slate-200 dark:border-darkmode-400 pt-5">
            <button type="submit" class="btn-royal btn-royal--gold btn-royal--sm w-48">
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
<?php endif; ?>
                <?php echo e(__('settings.save_settings')); ?>

            </button>
        </div>
    </form>
</div>
<?php /**PATH E:\ERP System\Source\resources\views/settings/partials/notifications.blade.php ENDPATH**/ ?>
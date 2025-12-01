<?php
    // Attendance Settings
    $attendanceSettings = [
        'attendance.working_hours_per_day' => [
            'value' => \App\Models\Setting\Setting::get('attendance.working_hours_per_day', '8'),
            'type' => 'number',
            'label' => 'Working Hours Per Day',
            'description' => 'Number of working hours in a full day',
            'placeholder' => '8',
            'min' => '1',
            'max' => '24'
        ],
        'attendance.half_day_hours' => [
            'value' => \App\Models\Setting\Setting::get('attendance.half_day_hours', '4'),
            'type' => 'number',
            'label' => 'Half Day Hours',
            'description' => 'Number of hours required to consider the day as half day',
            'placeholder' => '4',
            'min' => '1',
            'max' => '12'
        ],
        'attendance.grace_period_minutes' => [
            'value' => \App\Models\Setting\Setting::get('attendance.grace_period_minutes', '15'),
            'type' => 'number',
            'label' => 'Grace Period (Minutes)',
            'description' => 'Allowed delay time before considering it as absence',
            'placeholder' => '15',
            'min' => '0',
            'max' => '120'
        ],
        'attendance.auto_checkout_time' => [
            'value' => \App\Models\Setting\Setting::get('attendance.auto_checkout_time', '18:00'),
            'type' => 'time',
            'label' => 'Auto Checkout Time',
            'description' => 'Automatic checkout time if employee doesn\'t log their checkout',
            'placeholder' => '18:00'
        ],
        'attendance.minimum_working_hours' => [
            'value' => \App\Models\Setting\Setting::get('attendance.minimum_working_hours', '6'),
            'type' => 'number',
            'label' => 'Minimum Working Hours',
            'description' => 'Minimum hours required to consider the day as complete',
            'placeholder' => '6',
            'min' => '1',
            'max' => '24'
        ],
        'attendance.enable_auto_attendance' => [
            'value' => \App\Models\Setting\Setting::get('attendance.enable_auto_attendance', '0'),
            'type' => 'checkbox',
            'label' => 'Enable Auto Attendance',
            'description' => 'Enable automatic attendance check-in and check-out recording'
        ],
        'attendance.allow_mobile_checkin' => [
            'value' => \App\Models\Setting\Setting::get('attendance.allow_mobile_checkin', '1'),
            'type' => 'checkbox',
            'label' => 'Allow Mobile Check-in',
            'description' => 'Allow employees to check-in through mobile applications'
        ],
        'attendance.require_location' => [
            'value' => \App\Models\Setting\Setting::get('attendance.require_location', '0'),
            'type' => 'checkbox',
            'label' => 'Require Location',
            'description' => 'Require employee location verification during check-in'
        ],
        'attendance.notify_late_arrival' => [
            'value' => \App\Models\Setting\Setting::get('attendance.notify_late_arrival', '1'),
            'type' => 'checkbox',
            'label' => 'Late Arrival Notification',
            'description' => 'Send notification when employee arrives late'
        ],
        'attendance.notify_early_departure' => [
            'value' => \App\Models\Setting\Setting::get('attendance.notify_early_departure', '1'),
            'type' => 'checkbox',
            'label' => 'Early Departure Notification',
            'description' => 'Send notification when employee leaves early'
        ],
        'attendance.weekend_days' => [
            'value' => \App\Models\Setting\Setting::get('attendance.weekend_days', '5,6'),
            'type' => 'text',
            'label' => 'Weekend Days',
            'description' => 'Weekend day numbers (0=Sunday, 1=Monday, etc). Comma separated',
            'placeholder' => '5,6'
        ],
        'attendance.holidays' => [
            'value' => \App\Models\Setting\Setting::get('attendance.holidays', ''),
            'type' => 'textarea',
            'label' => 'Official Holidays',
            'description' => 'Official holiday dates (YYYY-MM-DD), each date on a separate line',
            'placeholder' => '2025-01-01' . "\n" . '2025-12-25'
        ],
        // Overtime Settings
        'attendance.overtime_multiplier' => [
            'value' => \App\Models\Setting\Setting::get('attendance.overtime_multiplier', '1.5'),
            'type' => 'number',
            'label' => 'Overtime Multiplier',
            'description' => 'Overtime hour rate multiplier (1 = same rate, 1.5 = 150%, 2 = double)',
            'placeholder' => '1.5',
            'min' => '1',
            'max' => '5',
            'step' => '0.25'
        ],
        'attendance.working_days_per_month' => [
            'value' => \App\Models\Setting\Setting::get('attendance.working_days_per_month', '22'),
            'type' => 'number',
            'label' => 'Working Days Per Month',
            'description' => 'Average number of working days per month for salary calculation',
            'placeholder' => '22',
            'min' => '20',
            'max' => '31'
        ],
        'attendance.overtime_after_hours' => [
            'value' => \App\Models\Setting\Setting::get('attendance.overtime_after_hours', '8'),
            'type' => 'number',
            'label' => 'Overtime After Hours',
            'description' => 'Hours after which overtime starts counting',
            'placeholder' => '8',
            'min' => '1',
            'max' => '12'
        ],
        'attendance.max_overtime_hours_per_day' => [
            'value' => \App\Models\Setting\Setting::get('attendance.max_overtime_hours_per_day', '4'),
            'type' => 'number',
            'label' => 'Max Overtime Hours/Day',
            'description' => 'Maximum allowed overtime hours per day',
            'placeholder' => '4',
            'min' => '0',
            'max' => '12'
        ],
        'attendance.weekend_overtime_multiplier' => [
            'value' => \App\Models\Setting\Setting::get('attendance.weekend_overtime_multiplier', '2'),
            'type' => 'number',
            'label' => 'Weekend Overtime Multiplier',
            'description' => 'Overtime multiplier for weekend work',
            'placeholder' => '2',
            'min' => '1',
            'max' => '5',
            'step' => '0.25'
        ]
    ];
?>

<!-- Attendance Settings Content Loaded -->
<div class="bg-white dark:bg-darkmode-600 rounded-lg shadow-sm border border-slate-200/60 dark:border-darkmode-400 mt-5">
    <div class="flex items-center border-b border-slate-200/60 p-5 dark:border-darkmode-400">
        <h2 class="mr-auto text-base font-medium flex items-center">
            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Clock','class' => 'w-5 h-5 mr-2 text-blue-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Clock','class' => 'w-5 h-5 mr-2 text-blue-500']); ?>
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
            Attendance Settings
        </h2>
    </div>

    <form id="attendance-settings-form" action="<?php echo e(route('settings.attendance.update')); ?>" method="POST" class="p-5">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="grid grid-cols-12 gap-6">
            <!-- Working Hours Per Day -->
            <div class="col-span-12 md:col-span-6 lg:col-span-4">
                    <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'attendance.working_hours_per_day']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'attendance.working_hours_per_day']); ?>
                        <?php echo e($attendanceSettings['attendance.working_hours_per_day']['label']); ?>

                        <span class="text-danger">*</span>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'attendance.working_hours_per_day','name' => 'attendance.working_hours_per_day','type' => 'number','value' => ''.e($attendanceSettings['attendance.working_hours_per_day']['value']).'','placeholder' => ''.e($attendanceSettings['attendance.working_hours_per_day']['placeholder']).'','min' => ''.e($attendanceSettings['attendance.working_hours_per_day']['min']).'','max' => ''.e($attendanceSettings['attendance.working_hours_per_day']['max']).'','class' => 'w-full','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'attendance.working_hours_per_day','name' => 'attendance.working_hours_per_day','type' => 'number','value' => ''.e($attendanceSettings['attendance.working_hours_per_day']['value']).'','placeholder' => ''.e($attendanceSettings['attendance.working_hours_per_day']['placeholder']).'','min' => ''.e($attendanceSettings['attendance.working_hours_per_day']['min']).'','max' => ''.e($attendanceSettings['attendance.working_hours_per_day']['max']).'','class' => 'w-full','required' => true]); ?>
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
                    <div class="text-sm text-slate-500 mt-1">
                        <?php echo e($attendanceSettings['attendance.working_hours_per_day']['description']); ?>

                    </div>
                </div>

                <!-- Half Day Hours -->
                <div class="col-span-12 md:col-span-6 lg:col-span-4">
                    <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'attendance.half_day_hours']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'attendance.half_day_hours']); ?>
                        <?php echo e($attendanceSettings['attendance.half_day_hours']['label']); ?>

                        <span class="text-danger">*</span>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'attendance.half_day_hours','name' => 'attendance.half_day_hours','type' => 'number','value' => ''.e($attendanceSettings['attendance.half_day_hours']['value']).'','placeholder' => ''.e($attendanceSettings['attendance.half_day_hours']['placeholder']).'','min' => ''.e($attendanceSettings['attendance.half_day_hours']['min']).'','max' => ''.e($attendanceSettings['attendance.half_day_hours']['max']).'','class' => 'w-full','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'attendance.half_day_hours','name' => 'attendance.half_day_hours','type' => 'number','value' => ''.e($attendanceSettings['attendance.half_day_hours']['value']).'','placeholder' => ''.e($attendanceSettings['attendance.half_day_hours']['placeholder']).'','min' => ''.e($attendanceSettings['attendance.half_day_hours']['min']).'','max' => ''.e($attendanceSettings['attendance.half_day_hours']['max']).'','class' => 'w-full','required' => true]); ?>
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
                    <div class="text-sm text-slate-500 mt-1">
                        <?php echo e($attendanceSettings['attendance.half_day_hours']['description']); ?>

                    </div>
                </div>

                <!-- Minimum Working Hours -->
                <div class="col-span-12 md:col-span-6 lg:col-span-4">
                    <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'attendance.minimum_working_hours']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'attendance.minimum_working_hours']); ?>
                        <?php echo e($attendanceSettings['attendance.minimum_working_hours']['label']); ?>

                        <span class="text-danger">*</span>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'attendance.minimum_working_hours','name' => 'attendance.minimum_working_hours','type' => 'number','value' => ''.e($attendanceSettings['attendance.minimum_working_hours']['value']).'','placeholder' => ''.e($attendanceSettings['attendance.minimum_working_hours']['placeholder']).'','min' => ''.e($attendanceSettings['attendance.minimum_working_hours']['min']).'','max' => ''.e($attendanceSettings['attendance.minimum_working_hours']['max']).'','class' => 'w-full','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'attendance.minimum_working_hours','name' => 'attendance.minimum_working_hours','type' => 'number','value' => ''.e($attendanceSettings['attendance.minimum_working_hours']['value']).'','placeholder' => ''.e($attendanceSettings['attendance.minimum_working_hours']['placeholder']).'','min' => ''.e($attendanceSettings['attendance.minimum_working_hours']['min']).'','max' => ''.e($attendanceSettings['attendance.minimum_working_hours']['max']).'','class' => 'w-full','required' => true]); ?>
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
                    <div class="text-sm text-slate-500 mt-1">
                        <?php echo e($attendanceSettings['attendance.minimum_working_hours']['description']); ?>

                    </div>
                </div>

                <!-- Grace Period -->
                <div class="col-span-12 md:col-span-6 lg:col-span-4">
                    <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'attendance.grace_period_minutes']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'attendance.grace_period_minutes']); ?>
                        <?php echo e($attendanceSettings['attendance.grace_period_minutes']['label']); ?>

                        <span class="text-danger">*</span>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'attendance.grace_period_minutes','name' => 'attendance.grace_period_minutes','type' => 'number','value' => ''.e($attendanceSettings['attendance.grace_period_minutes']['value']).'','placeholder' => ''.e($attendanceSettings['attendance.grace_period_minutes']['placeholder']).'','min' => ''.e($attendanceSettings['attendance.grace_period_minutes']['min']).'','max' => ''.e($attendanceSettings['attendance.grace_period_minutes']['max']).'','class' => 'w-full','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'attendance.grace_period_minutes','name' => 'attendance.grace_period_minutes','type' => 'number','value' => ''.e($attendanceSettings['attendance.grace_period_minutes']['value']).'','placeholder' => ''.e($attendanceSettings['attendance.grace_period_minutes']['placeholder']).'','min' => ''.e($attendanceSettings['attendance.grace_period_minutes']['min']).'','max' => ''.e($attendanceSettings['attendance.grace_period_minutes']['max']).'','class' => 'w-full','required' => true]); ?>
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
                    <div class="text-sm text-slate-500 mt-1">
                        <?php echo e($attendanceSettings['attendance.grace_period_minutes']['description']); ?>

                    </div>
                </div>

                <!-- Auto Checkout Time -->
                <div class="col-span-12 md:col-span-6 lg:col-span-4">
                    <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'attendance.auto_checkout_time']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'attendance.auto_checkout_time']); ?>
                        <?php echo e($attendanceSettings['attendance.auto_checkout_time']['label']); ?>

                        <span class="text-danger">*</span>
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
                    <div class="relative mx-auto w-56">
                        <div
                            class="absolute flex h-full w-10 items-center justify-center rounded-l border bg-slate-100 text-slate-500 dark:border-darkmode-800 dark:bg-darkmode-700 dark:text-slate-400">
                            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Clock','class' => 'stroke-1.5 w-5 h-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Clock','class' => 'stroke-1.5 w-5 h-5']); ?> <?php echo $__env->renderComponent(); ?>
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
                        <?php if (isset($component)) { $__componentOriginal398ab4cd6da012e7fa913c6582e9e7a1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal398ab4cd6da012e7fa913c6582e9e7a1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.litepicker.index','data' => ['id' => 'attendance.auto_checkout_time','name' => 'attendance.auto_checkout_time','class' => 'pl-12','dataSingleMode' => 'false','value' => ''.e($attendanceSettings['attendance.auto_checkout_time']['value']).'','dataFormat' => 'HH:mm','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.litepicker'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'attendance.auto_checkout_time','name' => 'attendance.auto_checkout_time','class' => 'pl-12','data-single-mode' => 'false','value' => ''.e($attendanceSettings['attendance.auto_checkout_time']['value']).'','data-format' => 'HH:mm','required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal398ab4cd6da012e7fa913c6582e9e7a1)): ?>
<?php $attributes = $__attributesOriginal398ab4cd6da012e7fa913c6582e9e7a1; ?>
<?php unset($__attributesOriginal398ab4cd6da012e7fa913c6582e9e7a1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal398ab4cd6da012e7fa913c6582e9e7a1)): ?>
<?php $component = $__componentOriginal398ab4cd6da012e7fa913c6582e9e7a1; ?>
<?php unset($__componentOriginal398ab4cd6da012e7fa913c6582e9e7a1); ?>
<?php endif; ?>
                    </div>
                    <div class="text-sm text-slate-500 mt-1">
                        <?php echo e($attendanceSettings['attendance.auto_checkout_time']['description']); ?>

                    </div>
                </div>

                <!-- Enable Auto Attendance -->
                <div class="col-span-12 md:col-span-6 lg:col-span-4">
                    <label class="flex items-center">
                        <input type="hidden" name="attendance.enable_auto_attendance" value="0">
                        <input
                            type="checkbox"
                            name="attendance.enable_auto_attendance"
                            value="1"
                            <?php echo e($attendanceSettings['attendance.enable_auto_attendance']['value'] ? 'checked' : ''); ?>

                            class="form-check-input mr-3"
                        >
                        <div>
                            <div class="font-medium"><?php echo e($attendanceSettings['attendance.enable_auto_attendance']['label']); ?></div>
                            <div class="text-sm text-slate-500"><?php echo e($attendanceSettings['attendance.enable_auto_attendance']['description']); ?></div>
                        </div>
                    </label>
                </div>

                <!-- Allow Mobile Check-in -->
                <div class="col-span-12 md:col-span-6 lg:col-span-4">
                    <label class="flex items-center">
                        <input type="hidden" name="attendance.allow_mobile_checkin" value="0">
                        <input
                            type="checkbox"
                            name="attendance.allow_mobile_checkin"
                            value="1"
                            <?php echo e($attendanceSettings['attendance.allow_mobile_checkin']['value'] ? 'checked' : ''); ?>

                            class="form-check-input mr-3"
                        >
                        <div>
                            <div class="font-medium"><?php echo e($attendanceSettings['attendance.allow_mobile_checkin']['label']); ?></div>
                            <div class="text-sm text-slate-500"><?php echo e($attendanceSettings['attendance.allow_mobile_checkin']['description']); ?></div>
                        </div>
                    </label>
                </div>

                <!-- Require Location -->
                <div class="col-span-12 md:col-span-6 lg:col-span-4">
                    <label class="flex items-center">
                        <input type="hidden" name="attendance.require_location" value="0">
                        <input
                            type="checkbox"
                            name="attendance.require_location"
                            value="1"
                            <?php echo e($attendanceSettings['attendance.require_location']['value'] ? 'checked' : ''); ?>

                            class="form-check-input mr-3"
                        >
                        <div>
                            <div class="font-medium"><?php echo e($attendanceSettings['attendance.require_location']['label']); ?></div>
                            <div class="text-sm text-slate-500"><?php echo e($attendanceSettings['attendance.require_location']['description']); ?></div>
                        </div>
                    </label>
                </div>

                <!-- Notify Late Arrival -->
                <div class="col-span-12 md:col-span-6 lg:col-span-4">
                    <label class="flex items-center">
                        <input type="hidden" name="attendance.notify_late_arrival" value="0">
                        <input
                            type="checkbox"
                            name="attendance.notify_late_arrival"
                            value="1"
                            <?php echo e($attendanceSettings['attendance.notify_late_arrival']['value'] ? 'checked' : ''); ?>

                            class="form-check-input mr-3"
                        >
                        <div>
                            <div class="font-medium"><?php echo e($attendanceSettings['attendance.notify_late_arrival']['label']); ?></div>
                            <div class="text-sm text-slate-500"><?php echo e($attendanceSettings['attendance.notify_late_arrival']['description']); ?></div>
                        </div>
                    </label>
                </div>

                <!-- Notify Early Departure -->
                <div class="col-span-12 md:col-span-6 lg:col-span-4">
                    <label class="flex items-center">
                        <input type="hidden" name="attendance.notify_early_departure" value="0">
                        <input
                            type="checkbox"
                            name="attendance.notify_early_departure"
                            value="1"
                            <?php echo e($attendanceSettings['attendance.notify_early_departure']['value'] ? 'checked' : ''); ?>

                            class="form-check-input mr-3"
                        >
                        <div>
                            <div class="font-medium"><?php echo e($attendanceSettings['attendance.notify_early_departure']['label']); ?></div>
                            <div class="text-sm text-slate-500"><?php echo e($attendanceSettings['attendance.notify_early_departure']['description']); ?></div>
                        </div>
                    </label>
                </div>

                <!-- Weekend Days -->
                <div class="col-span-12 md:col-span-6">
                    <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'attendance.weekend_days']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'attendance.weekend_days']); ?>
                        <?php echo e($attendanceSettings['attendance.weekend_days']['label']); ?>

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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'attendance.weekend_days','name' => 'attendance.weekend_days','type' => 'text','value' => ''.e($attendanceSettings['attendance.weekend_days']['value']).'','placeholder' => ''.e($attendanceSettings['attendance.weekend_days']['placeholder']).'','class' => 'w-full']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'attendance.weekend_days','name' => 'attendance.weekend_days','type' => 'text','value' => ''.e($attendanceSettings['attendance.weekend_days']['value']).'','placeholder' => ''.e($attendanceSettings['attendance.weekend_days']['placeholder']).'','class' => 'w-full']); ?>
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
                    <div class="text-sm text-slate-500 mt-1">
                        <?php echo e($attendanceSettings['attendance.weekend_days']['description']); ?>

                    </div>
                </div>

                <!-- Holidays -->
                <div class="col-span-12">
                    <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'attendance.holidays']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'attendance.holidays']); ?>
                        <?php echo e($attendanceSettings['attendance.holidays']['label']); ?>

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
                    <?php if (isset($component)) { $__componentOriginal29dbcf960a4ade6d0a2b790c04ae12cf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal29dbcf960a4ade6d0a2b790c04ae12cf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-textarea.index','data' => ['id' => 'attendance.holidays','name' => 'attendance.holidays','rows' => '4','placeholder' => ''.e($attendanceSettings['attendance.holidays']['placeholder']).'','class' => 'w-full']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'attendance.holidays','name' => 'attendance.holidays','rows' => '4','placeholder' => ''.e($attendanceSettings['attendance.holidays']['placeholder']).'','class' => 'w-full']); ?><?php echo e($attendanceSettings['attendance.holidays']['value']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal29dbcf960a4ade6d0a2b790c04ae12cf)): ?>
<?php $attributes = $__attributesOriginal29dbcf960a4ade6d0a2b790c04ae12cf; ?>
<?php unset($__attributesOriginal29dbcf960a4ade6d0a2b790c04ae12cf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal29dbcf960a4ade6d0a2b790c04ae12cf)): ?>
<?php $component = $__componentOriginal29dbcf960a4ade6d0a2b790c04ae12cf; ?>
<?php unset($__componentOriginal29dbcf960a4ade6d0a2b790c04ae12cf); ?>
<?php endif; ?>
                    <div class="text-sm text-slate-500 mt-1">
                        <?php echo e($attendanceSettings['attendance.holidays']['description']); ?>

                    </div>
                </div>
        </div>

        
        <div class="border-t border-slate-200/60 dark:border-darkmode-400 mt-6 pt-6">
            <h3 class="text-base font-medium flex items-center mb-5">
                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Timer','class' => 'w-5 h-5 mr-2 text-amber-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Timer','class' => 'w-5 h-5 mr-2 text-amber-500']); ?>
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
                Overtime Settings
            </h3>
            
            <div class="grid grid-cols-12 gap-6">
                <!-- Overtime Multiplier -->
                <div class="col-span-12 md:col-span-6 lg:col-span-4">
                    <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'attendance.overtime_multiplier']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'attendance.overtime_multiplier']); ?>
                        <?php echo e($attendanceSettings['attendance.overtime_multiplier']['label']); ?>

                        <span class="text-danger">*</span>
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
                    <div class="relative">
                        <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'attendance.overtime_multiplier','name' => 'attendance.overtime_multiplier','type' => 'number','value' => ''.e($attendanceSettings['attendance.overtime_multiplier']['value']).'','placeholder' => ''.e($attendanceSettings['attendance.overtime_multiplier']['placeholder']).'','min' => ''.e($attendanceSettings['attendance.overtime_multiplier']['min']).'','max' => ''.e($attendanceSettings['attendance.overtime_multiplier']['max']).'','step' => ''.e($attendanceSettings['attendance.overtime_multiplier']['step']).'','class' => 'w-full pr-12','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'attendance.overtime_multiplier','name' => 'attendance.overtime_multiplier','type' => 'number','value' => ''.e($attendanceSettings['attendance.overtime_multiplier']['value']).'','placeholder' => ''.e($attendanceSettings['attendance.overtime_multiplier']['placeholder']).'','min' => ''.e($attendanceSettings['attendance.overtime_multiplier']['min']).'','max' => ''.e($attendanceSettings['attendance.overtime_multiplier']['max']).'','step' => ''.e($attendanceSettings['attendance.overtime_multiplier']['step']).'','class' => 'w-full pr-12','required' => true]); ?>
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
                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">x</span>
                    </div>
                    <div class="text-sm text-slate-500 mt-1">
                        <?php echo e($attendanceSettings['attendance.overtime_multiplier']['description']); ?>

                    </div>
                    <div class="mt-2 p-2 bg-amber-50 rounded text-xs text-amber-700">
                        <strong>Example:</strong> If hourly rate = 50, overtime rate = 50 × <span id="ot-multiplier-preview"><?php echo e($attendanceSettings['attendance.overtime_multiplier']['value']); ?></span> = <span id="ot-rate-preview"><?php echo e(50 * floatval($attendanceSettings['attendance.overtime_multiplier']['value'])); ?></span>
                    </div>
                </div>

                <!-- Working Days Per Month -->
                <div class="col-span-12 md:col-span-6 lg:col-span-4">
                    <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'attendance.working_days_per_month']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'attendance.working_days_per_month']); ?>
                        <?php echo e($attendanceSettings['attendance.working_days_per_month']['label']); ?>

                        <span class="text-danger">*</span>
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
                    <div class="relative">
                        <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'attendance.working_days_per_month','name' => 'attendance.working_days_per_month','type' => 'number','value' => ''.e($attendanceSettings['attendance.working_days_per_month']['value']).'','placeholder' => ''.e($attendanceSettings['attendance.working_days_per_month']['placeholder']).'','min' => ''.e($attendanceSettings['attendance.working_days_per_month']['min']).'','max' => ''.e($attendanceSettings['attendance.working_days_per_month']['max']).'','class' => 'w-full pr-16','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'attendance.working_days_per_month','name' => 'attendance.working_days_per_month','type' => 'number','value' => ''.e($attendanceSettings['attendance.working_days_per_month']['value']).'','placeholder' => ''.e($attendanceSettings['attendance.working_days_per_month']['placeholder']).'','min' => ''.e($attendanceSettings['attendance.working_days_per_month']['min']).'','max' => ''.e($attendanceSettings['attendance.working_days_per_month']['max']).'','class' => 'w-full pr-16','required' => true]); ?>
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
                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">days</span>
                    </div>
                    <div class="text-sm text-slate-500 mt-1">
                        <?php echo e($attendanceSettings['attendance.working_days_per_month']['description']); ?>

                    </div>
                </div>

                <!-- Overtime After Hours -->
                <div class="col-span-12 md:col-span-6 lg:col-span-4">
                    <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'attendance.overtime_after_hours']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'attendance.overtime_after_hours']); ?>
                        <?php echo e($attendanceSettings['attendance.overtime_after_hours']['label']); ?>

                        <span class="text-danger">*</span>
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
                    <div class="relative">
                        <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'attendance.overtime_after_hours','name' => 'attendance.overtime_after_hours','type' => 'number','value' => ''.e($attendanceSettings['attendance.overtime_after_hours']['value']).'','placeholder' => ''.e($attendanceSettings['attendance.overtime_after_hours']['placeholder']).'','min' => ''.e($attendanceSettings['attendance.overtime_after_hours']['min']).'','max' => ''.e($attendanceSettings['attendance.overtime_after_hours']['max']).'','class' => 'w-full pr-16','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'attendance.overtime_after_hours','name' => 'attendance.overtime_after_hours','type' => 'number','value' => ''.e($attendanceSettings['attendance.overtime_after_hours']['value']).'','placeholder' => ''.e($attendanceSettings['attendance.overtime_after_hours']['placeholder']).'','min' => ''.e($attendanceSettings['attendance.overtime_after_hours']['min']).'','max' => ''.e($attendanceSettings['attendance.overtime_after_hours']['max']).'','class' => 'w-full pr-16','required' => true]); ?>
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
                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">hours</span>
                    </div>
                    <div class="text-sm text-slate-500 mt-1">
                        <?php echo e($attendanceSettings['attendance.overtime_after_hours']['description']); ?>

                    </div>
                </div>

                <!-- Max Overtime Hours Per Day -->
                <div class="col-span-12 md:col-span-6 lg:col-span-4">
                    <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'attendance.max_overtime_hours_per_day']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'attendance.max_overtime_hours_per_day']); ?>
                        <?php echo e($attendanceSettings['attendance.max_overtime_hours_per_day']['label']); ?>

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
                    <div class="relative">
                        <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'attendance.max_overtime_hours_per_day','name' => 'attendance.max_overtime_hours_per_day','type' => 'number','value' => ''.e($attendanceSettings['attendance.max_overtime_hours_per_day']['value']).'','placeholder' => ''.e($attendanceSettings['attendance.max_overtime_hours_per_day']['placeholder']).'','min' => ''.e($attendanceSettings['attendance.max_overtime_hours_per_day']['min']).'','max' => ''.e($attendanceSettings['attendance.max_overtime_hours_per_day']['max']).'','class' => 'w-full pr-16']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'attendance.max_overtime_hours_per_day','name' => 'attendance.max_overtime_hours_per_day','type' => 'number','value' => ''.e($attendanceSettings['attendance.max_overtime_hours_per_day']['value']).'','placeholder' => ''.e($attendanceSettings['attendance.max_overtime_hours_per_day']['placeholder']).'','min' => ''.e($attendanceSettings['attendance.max_overtime_hours_per_day']['min']).'','max' => ''.e($attendanceSettings['attendance.max_overtime_hours_per_day']['max']).'','class' => 'w-full pr-16']); ?>
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
                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">hours</span>
                    </div>
                    <div class="text-sm text-slate-500 mt-1">
                        <?php echo e($attendanceSettings['attendance.max_overtime_hours_per_day']['description']); ?>

                    </div>
                </div>

                <!-- Weekend Overtime Multiplier -->
                <div class="col-span-12 md:col-span-6 lg:col-span-4">
                    <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'attendance.weekend_overtime_multiplier']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'attendance.weekend_overtime_multiplier']); ?>
                        <?php echo e($attendanceSettings['attendance.weekend_overtime_multiplier']['label']); ?>

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
                    <div class="relative">
                        <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'attendance.weekend_overtime_multiplier','name' => 'attendance.weekend_overtime_multiplier','type' => 'number','value' => ''.e($attendanceSettings['attendance.weekend_overtime_multiplier']['value']).'','placeholder' => ''.e($attendanceSettings['attendance.weekend_overtime_multiplier']['placeholder']).'','min' => ''.e($attendanceSettings['attendance.weekend_overtime_multiplier']['min']).'','max' => ''.e($attendanceSettings['attendance.weekend_overtime_multiplier']['max']).'','step' => ''.e($attendanceSettings['attendance.weekend_overtime_multiplier']['step']).'','class' => 'w-full pr-12']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'attendance.weekend_overtime_multiplier','name' => 'attendance.weekend_overtime_multiplier','type' => 'number','value' => ''.e($attendanceSettings['attendance.weekend_overtime_multiplier']['value']).'','placeholder' => ''.e($attendanceSettings['attendance.weekend_overtime_multiplier']['placeholder']).'','min' => ''.e($attendanceSettings['attendance.weekend_overtime_multiplier']['min']).'','max' => ''.e($attendanceSettings['attendance.weekend_overtime_multiplier']['max']).'','step' => ''.e($attendanceSettings['attendance.weekend_overtime_multiplier']['step']).'','class' => 'w-full pr-12']); ?>
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
                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">x</span>
                    </div>
                    <div class="text-sm text-slate-500 mt-1">
                        <?php echo e($attendanceSettings['attendance.weekend_overtime_multiplier']['description']); ?>

                    </div>
                </div>

                <!-- Overtime Calculation Info -->
                <div class="col-span-12">
                    <div class="p-4 bg-slate-50 dark:bg-darkmode-400 rounded-lg">
                        <h4 class="font-medium text-slate-700 dark:text-slate-300 mb-2 flex items-center">
                            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Calculator','class' => 'w-4 h-4 mr-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Calculator','class' => 'w-4 h-4 mr-2']); ?>
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
                            Overtime Calculation Formula
                        </h4>
                        <div class="text-sm text-slate-600 dark:text-slate-400 space-y-1">
                            <p><strong>Hourly Rate</strong> = Monthly Salary ÷ Working Days ÷ Working Hours Per Day</p>
                            <p><strong>Overtime Rate</strong> = Hourly Rate × Overtime Multiplier</p>
                            <p><strong>Weekend Overtime Rate</strong> = Hourly Rate × Weekend Overtime Multiplier</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5 flex justify-end">
            <button type="submit" class="btn-royal btn-royal--gold btn-royal--sm w-32"><?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
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
<?php endif; ?>Save</button>
        </div>
    </form>

    <!-- Fallback content in case the form doesn't load -->
    <div id="attendance-fallback" class="hidden p-5 text-center">
        <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'AlertCircle','class' => 'h-16 w-16 text-orange-500 mx-auto mb-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'AlertCircle','class' => 'h-16 w-16 text-orange-500 mx-auto mb-4']); ?>
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
        <h3 class="text-lg font-semibold text-slate-800 dark:text-white mb-2">Loading Attendance Settings</h3>
        <p class="text-slate-600 dark:text-slate-400 mb-4">
            If the settings don't appear, please reload the page or contact technical support.
        </p>
        <button type="button" onclick="window.location.reload()" class="btn-royal btn-royal--dark btn-royal--sm">
            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'refresh-cw','class' => 'w-4 h-4 mr-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'refresh-cw','class' => 'w-4 h-4 mr-2']); ?>
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
            Reload Page
        </button>
    </div>
</div>

<script>
    // Show fallback content after 3 seconds if main content is not visible
    setTimeout(function() {
        const mainContent = document.querySelector('#attendance-settings-form');
        const fallbackContent = document.querySelector('#attendance-fallback');

        if (mainContent && fallbackContent && mainContent.offsetParent === null) {
            fallbackContent.classList.remove('hidden');
        }
    }, 3000);
    
    // Update overtime preview when multiplier changes
    document.addEventListener('DOMContentLoaded', function() {
        const multiplierInput = document.getElementById('attendance.overtime_multiplier');
        const multiplierPreview = document.getElementById('ot-multiplier-preview');
        const ratePreview = document.getElementById('ot-rate-preview');
        
        if (multiplierInput && multiplierPreview && ratePreview) {
            multiplierInput.addEventListener('input', function() {
                const multiplier = parseFloat(this.value) || 1;
                multiplierPreview.textContent = multiplier;
                ratePreview.textContent = (50 * multiplier).toFixed(2);
            });
        }
    });
</script>
<?php /**PATH D:\laravel\smart-erp\resources\views/settings/partials/attendance.blade.php ENDPATH**/ ?>
<?php $__env->startSection('subhead'); ?>
    <title>HR Dashboard - Smart ERP</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('subcontent'); ?>
    <?php
        $attendanceStatuses = [
            'present' => ['label' => __('Present'), 'color' => 'emerald'],
            'absent' => ['label' => __('Absent'), 'color' => 'rose'],
            'vacation' => ['label' => __('Vacation'), 'color' => 'sky'],
            'travel' => ['label' => __('Travel'), 'color' => 'amber'],
            'half_day' => ['label' => __('Half Day'), 'color' => 'purple'],
            'holiday' => ['label' => __('Holiday'), 'color' => 'lime'],
        ];

        $getExpiryTone = function (?int $daysLeft) {
            if (is_null($daysLeft)) {
                return [
                    'class' => 'btn-tonal btn-tonal--neutral !px-3 !py-1 text-[0.7rem] font-semibold',
                    'label' => __('No date'),
                ];
            }

            if ($daysLeft <= 0) {
                return [
                    'class' => 'btn-tonal btn-tonal--rose !px-3 !py-1 text-[0.7rem] font-semibold',
                    'label' => __('Expired'),
                ];
            }

            if ($daysLeft <= 10) {
                return [
                    'class' => 'btn-tonal btn-tonal--danger !px-3 !py-1 text-[0.7rem] font-semibold',
                    'label' => __('Urgent'),
                ];
            }

            if ($daysLeft <= 20) {
                return [
                    'class' => 'btn-tonal btn-tonal--amber !px-3 !py-1 text-[0.7rem] font-semibold',
                    'label' => __('Soon'),
                ];
            }

            return [
                'class' => 'btn-tonal btn-tonal--sky !px-3 !py-1 text-[0.7rem] font-semibold',
                'label' => __('Upcoming'),
            ];
        };
    ?>

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 2xl:col-span-9 space-y-6">
            <!-- Hero summary -->
            <div class="intro-y mt-6">
                <div
                    class="rounded-2xl border border-white/10 text-white shadow-[0_25px_60px_rgba(15,31,61,0.35)]"
                    style="background: linear-gradient(135deg, var(--primary-color, #0f1f3d) 0%, var(--secondary-color, #1d3d8f) 45%, var(--accent-color, #0998d6) 100%);"
                >
                    <div class="flex flex-col gap-4 p-6 lg:flex-row lg:items-center">
                        <div class="flex-1">
                            <p class="text-sm uppercase tracking-[0.35em] text-white/80">HR Control Center</p>
                            <h2 class="mt-2 text-2xl font-semibold leading-tight lg:text-3xl">
                                People pulse for <?php echo e(config('app.name')); ?>

                            </h2>
                            <p class="mt-3 text-sm text-white/80">
                                <?php echo e($activeEmployees); ?> active team members · <?php echo e($departmentsCount); ?> departments · <?php echo e($openPositions); ?> open roles
                            </p>
                        </div>
                        <div class="flex flex-col gap-3 text-sm font-medium lg:text-base">
                            <div class="flex items-center gap-2">
                                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Activity','class' => 'h-5 w-5 text-lime-200']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Activity','class' => 'h-5 w-5 text-lime-200']); ?>
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
                                Presence rate
                                <span class="ml-auto rounded-full bg-white/20 px-3 py-1 text-sm font-semibold">
                                    <?php echo e($presenceRate); ?>%
                                </span>
                            </div>
                            <div class="flex items-center gap-2">
                                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Clock8','class' => 'h-5 w-5 text-amber-200']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Clock8','class' => 'h-5 w-5 text-amber-200']); ?>
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
                                Present today
                                <span class="ml-auto text-white/90"><?php echo e($presentToday); ?> / <?php echo e($activeEmployees); ?></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Sun','class' => 'h-5 w-5 text-rose-200']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Sun','class' => 'h-5 w-5 text-rose-200']); ?>
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
                                On leave today
                                <span class="ml-auto text-white/90"><?php echo e($onLeaveToday); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="grid gap-4 border-t border-white/10 p-6 sm:grid-cols-2 lg:grid-cols-4">
                        <div class="rounded-2xl border border-white/15 bg-white/10 p-4 backdrop-blur-md shadow-lg shadow-primary/20">
                            <div class="flex items-center gap-4">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/20 text-white">
                                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Users','class' => 'h-6 w-6']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Users','class' => 'h-6 w-6']); ?>
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
                                    <p class="text-xs uppercase tracking-wide text-white/70"><?php echo e(__('Total Employees')); ?></p>
                                    <p class="mt-1 text-2xl font-semibold"><?php echo e(number_format($totalEmployees)); ?></p>
                                    <span class="text-xs text-white/60"><?php echo e($activeEmployees); ?> <?php echo e(__('active')); ?> · <?php echo e(max(0, $totalEmployees - $activeEmployees)); ?> <?php echo e(__('inactive')); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="rounded-2xl border border-white/15 bg-white/10 p-4 backdrop-blur-md shadow-lg shadow-sky-500/20">
                            <div class="flex items-center gap-4">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/20 text-white">
                                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Briefcase','class' => 'h-6 w-6']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Briefcase','class' => 'h-6 w-6']); ?>
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
                                    <p class="text-xs uppercase tracking-wide text-white/70"><?php echo e(__('Open Positions')); ?></p>
                                    <p class="mt-1 text-2xl font-semibold"><?php echo e($openPositions); ?></p>
                                    <span class="text-xs text-white/60"><?php echo e($departmentsCount); ?> <?php echo e(__('departments hiring')); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="rounded-2xl border border-white/15 bg-white/10 p-4 backdrop-blur-md shadow-lg shadow-rose-500/20">
                            <div class="flex items-center gap-4">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/20 text-white">
                                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'ClipboardList','class' => 'h-6 w-6']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'ClipboardList','class' => 'h-6 w-6']); ?>
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
                                    <p class="text-xs uppercase tracking-wide text-white/70"><?php echo e(__('Pending Approvals')); ?></p>
                                    <p class="mt-1 text-2xl font-semibold"><?php echo e($pendingApprovals); ?></p>
                                    <span class="text-xs text-white/60"><?php echo e(__('Awaiting HR action')); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="rounded-2xl border border-white/15 bg-white/10 p-4 backdrop-blur-md shadow-lg shadow-emerald-500/20">
                            <div class="flex items-center gap-4">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/20 text-white">
                                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'UserPlus','class' => 'h-6 w-6']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'UserPlus','class' => 'h-6 w-6']); ?>
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
                                    <p class="text-xs uppercase tracking-wide text-white/70"><?php echo e(__('New Hires')); ?> (<?php echo e(now()->format('M')); ?>)</p>
                                    <p class="mt-1 text-2xl font-semibold"><?php echo e($newHiresThisMonth->count()); ?></p>
                                    <span class="text-xs text-white/60"><?php echo e(__('Welcome aboard!')); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- HR Analytics Charts -->
            <div class="grid grid-cols-12 gap-6">
                <div class="intro-y col-span-12 xl:col-span-8">
                    <div class="box h-full rounded-2xl p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-base font-semibold">Attendance Trend</h3>
                                <p class="text-xs text-slate-500">Last <?php echo e(($attendanceTrendLabels ?? []) ? count($attendanceTrendLabels) : 7); ?> days</p>
                            </div>
                            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Activity','class' => 'h-5 w-5 text-emerald-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Activity','class' => 'h-5 w-5 text-emerald-500']); ?>
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
                        <div class="mt-5 h-[260px]">
                            <canvas id="hr-attendance-chart" class="w-full h-full"></canvas>
                        </div>
                    </div>
                </div>

                <div class="intro-y col-span-12 xl:col-span-4">
                    <div class="box h-full rounded-2xl p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-base font-semibold">Workforce by Department</h3>
                                <p class="text-xs text-slate-500">Active employees distribution</p>
                            </div>
                            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'PieChart','class' => 'h-5 w-5 text-sky-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'PieChart','class' => 'h-5 w-5 text-sky-500']); ?>
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
                        <div class="mt-5 h-[260px]">
                            <canvas id="hr-departments-chart" class="w-full h-full"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-12 gap-6">
                <!-- Attendance snapshot -->
                <div class="intro-y col-span-12 xl:col-span-6">
                    <div class="box h-full rounded-2xl p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-base font-semibold">Attendance Snapshot</h3>
                                <p class="text-xs text-slate-500"><?php echo e(now()->format(setting('date_format', 'Y-m-d'))); ?></p>
                            </div>
                            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600 dark:bg-darkmode-600 dark:text-slate-300">
                                <?php echo e($presenceRate); ?>% presence
                            </span>
                        </div>
                        <div class="mt-5 space-y-3">
                            <?php $__currentLoopData = $attendanceStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $meta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $value = (int) ($attendanceSummary[$status] ?? 0);
                                    $percent = $activeEmployees > 0 ? round(($value / $activeEmployees) * 100) : 0;
                                ?>
                                <div>
                                    <div class="flex items-center text-sm font-medium text-slate-600 dark:text-slate-200">
                                        <span class="flex items-center gap-2 capitalize">
                                            <span class="h-2.5 w-2.5 rounded-full bg-<?php echo e($meta['color']); ?>-500/80"></span>
                                            <?php echo e($meta['label']); ?>

                                        </span>
                                        <span class="ml-auto text-sm text-slate-500"><?php echo e($value); ?> · <?php echo e($percent); ?>%</span>
                                    </div>
                                    <div class="mt-2 h-2 rounded-full bg-slate-100 dark:bg-darkmode-600">
                                        <div class="h-full rounded-full bg-<?php echo e($meta['color']); ?>-500" style="width: <?php echo e($percent); ?>%"></div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>

                <!-- New hires -->
                <div class="intro-y col-span-12 xl:col-span-6">
                    <div class="box h-full rounded-2xl p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-base font-semibold">New hires this month</h3>
                                <p class="text-xs text-slate-500"><?php echo e($newHiresThisMonth->count()); ?> team members joined</p>
                            </div>
                            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Sparkles','class' => 'h-5 w-5 text-amber-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Sparkles','class' => 'h-5 w-5 text-amber-400']); ?>
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
                        <?php if($newHiresThisMonth->isNotEmpty()): ?>
                            <div class="mt-5 space-y-4">
                                <?php $__currentLoopData = $newHiresThisMonth; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flex items-center justify-between rounded-2xl border border-slate-100 px-3 py-2 shadow-sm dark:border-darkmode-500">
                                        <div class="flex items-center gap-3">
                                            <div class="h-12 w-12 overflow-hidden rounded-full ring-2 ring-slate-100 dark:ring-darkmode-400">
                                                <img
                                                    src="<?php echo e($employee->profile_picture_url); ?>"
                                                    alt="<?php echo e($employee->full_name); ?>"
                                                    class="h-full w-full object-cover"
                                                />
                                            </div>
                                            <div>
                                                <p class="font-semibold text-slate-800 dark:text-slate-100"><?php echo e($employee->full_name); ?></p>
                                                <p class="text-xs text-slate-500">
                                                    <?php echo e($employee->position ?? '—'); ?>

                                                    <?php if($employee->department): ?>
                                                        · <?php echo e($employee->department->name); ?>

                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-right text-xs text-slate-500">
                                            <p>Joined</p>
                                            <p class="font-semibold text-slate-700 dark:text-slate-200">
                                                <?php echo e(optional($employee->hire_date)->format(setting('date_format', 'Y-m-d')) ?? '—'); ?>

                                            </p>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <div class="mt-10 text-center text-sm text-slate-500">
                                No new hires recorded this month.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Talent highlights -->
            <div class="grid grid-cols-12 gap-6">
                <div class="intro-y col-span-12 xl:col-span-6">
                    <div class="box rounded-2xl p-5">
                        <div class="flex items-center gap-2">
                            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Star','class' => 'h-5 w-5 text-amber-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Star','class' => 'h-5 w-5 text-amber-400']); ?>
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
                            <h3 class="text-base font-semibold">Top Rated Employees</h3>
                        </div>
                        <?php if(isset($topRatedEmployees) && $topRatedEmployees->count()): ?>
                            <div class="mt-5 space-y-4">
                                <?php $__currentLoopData = $topRatedEmployees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $rating = $emp->avg_rating ? round($emp->avg_rating, 1) : null; ?>
                                    <div class="flex items-center justify-between rounded-2xl border border-slate-100 px-3 py-2 dark:border-darkmode-500">
                                        <div class="flex items-center gap-3">
                                            <div class="h-12 w-12 overflow-hidden rounded-full">
                                                <img src="<?php echo e($emp->profile_picture_url ?? asset('build/assets/profile-1-0441b45e.jpg')); ?>" alt="<?php echo e($emp->full_name); ?>" class="h-full w-full object-cover" />
                                            </div>
                                            <div>
                                                <p class="font-semibold"><?php echo e($emp->full_name); ?></p>
                                                <p class="text-xs text-slate-500">
                                                    <?php echo e($emp->position ?? 'Employee'); ?>

                                                    <?php if($emp->department): ?>
                                                        · <?php echo e($emp->department->name); ?>

                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="flex items-center justify-end text-xs">
                                                <?php for($i = 1; $i <= 5; $i++): ?>
                                                    <?php $filled = $rating && $rating >= $i - 0.25; ?>
                                                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Star','class' => 'h-4 w-4 '.e($filled ? 'text-amber-400 fill-amber-400/60' : 'text-slate-300 dark:text-slate-600').'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Star','class' => 'h-4 w-4 '.e($filled ? 'text-amber-400 fill-amber-400/60' : 'text-slate-300 dark:text-slate-600').'']); ?>
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
                                            <p class="text-xs text-slate-500"><?php echo e($rating ? $rating . ' / 5' : 'Not rated'); ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <div class="mt-6 text-sm text-slate-500">No evaluations yet.</div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="intro-y col-span-12 xl:col-span-6">
                    <div class="box rounded-2xl p-5">
                        <div class="flex items-center gap-2">
                            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Award','class' => 'h-5 w-5 text-emerald-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Award','class' => 'h-5 w-5 text-emerald-500']); ?>
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
                            <h3 class="text-base font-semibold">Top Rewarded Employees</h3>
                        </div>
                        <?php if(isset($topRewardedEmployees) && $topRewardedEmployees->count()): ?>
                            <div class="mt-5 space-y-4">
                                <?php $__currentLoopData = $topRewardedEmployees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $points = (int) ($emp->total_points ?? 0); ?>
                                    <div class="flex items-center justify-between rounded-2xl border border-slate-100 px-3 py-2 dark:border-darkmode-500">
                                        <div class="flex items-center gap-3">
                                            <div class="h-12 w-12 overflow-hidden rounded-full">
                                                <img src="<?php echo e($emp->profile_picture_url ?? asset('build/assets/profile-1-0441b45e.jpg')); ?>" alt="<?php echo e($emp->full_name); ?>" class="h-full w-full object-cover" />
                                            </div>
                                            <div>
                                                <p class="font-semibold"><?php echo e($emp->full_name); ?></p>
                                                <p class="text-xs text-slate-500">
                                                    <?php echo e($emp->position ?? 'Employee'); ?>

                                                    <?php if($emp->department): ?>
                                                        · <?php echo e($emp->department->name); ?>

                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-semibold text-emerald-600 dark:text-emerald-400"><?php echo e($points); ?> pts</p>
                                            <div class="mt-1 h-1.5 w-24 rounded-full bg-slate-100 dark:bg-darkmode-600">
                                                <?php $progress = min(100, $points); ?>
                                                <div class="h-full rounded-full bg-emerald-500" style="width: <?php echo e($progress); ?>%"></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <div class="mt-6 text-sm text-slate-500">No rewards recorded yet.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-span-12 2xl:col-span-3 space-y-6">
            <!-- Quick shortcuts -->
            <div class="intro-y box mt-6 rounded-2xl p-5">
                <div class="flex items-center justify-between">
                    <h3 class="text-base font-semibold">Quick Shortcuts</h3>
                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Zap','class' => 'h-5 w-5 text-warning']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Zap','class' => 'h-5 w-5 text-warning']); ?>
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
                <div class="mt-4 space-y-3 text-sm">
                    <a href="<?php echo e(route('hr.employees.index')); ?>" class="flex items-center justify-between rounded-xl bg-slate-50 px-3 py-2 text-slate-700 hover:bg-slate-100 dark:bg-darkmode-600 dark:text-slate-200">
                        <span class="flex items-center gap-2">
                            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Users','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Users','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $attributes = $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $component = $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?> Employees
                        </span>
                        <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'ArrowUpRight','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'ArrowUpRight','class' => 'h-4 w-4']); ?>
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
                    <a href="<?php echo e(route('hr.attendance.index')); ?>" class="flex items-center justify-between rounded-xl bg-slate-50 px-3 py-2 text-slate-700 hover:bg-slate-100 dark:bg-darkmode-600 dark:text-slate-200">
                        <span class="flex items-center gap-2">
                            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Clock','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Clock','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $attributes = $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $component = $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?> Attendance
                        </span>
                        <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'ArrowUpRight','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'ArrowUpRight','class' => 'h-4 w-4']); ?>
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
                    <a href="<?php echo e(route('hr.payroll.index')); ?>" class="flex items-center justify-between rounded-xl bg-slate-50 px-3 py-2 text-slate-700 hover:bg-slate-100 dark:bg-darkmode-600 dark:text-slate-200">
                        <span class="flex items-center gap-2">
                            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Wallet','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Wallet','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $attributes = $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $component = $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?> Payroll
                        </span>
                        <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'ArrowUpRight','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'ArrowUpRight','class' => 'h-4 w-4']); ?>
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

            <!-- Upcoming birthdays -->
            <div class="intro-y box rounded-2xl p-5">
                <div class="flex items-center justify-between">
                    <h3 class="text-base font-semibold">Upcoming Birthdays</h3>
                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Cake','class' => 'h-5 w-5 text-pink-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Cake','class' => 'h-5 w-5 text-pink-400']); ?>
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
                <?php if($upcomingBirthdays->isNotEmpty()): ?>
                    <div class="mt-4 space-y-4 text-sm">
                        <?php $__currentLoopData = $upcomingBirthdays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $birthday = $employee->birth_date?->copy()->setYear(now()->year);
                                if($birthday && $birthday->isBefore(now())) {
                                    $birthday = $birthday->copy()->addYear();
                                }
                                $days = $birthday ? now()->diffInDays($birthday) : null;
                            ?>
                            <div class="flex items-center justify-between rounded-2xl border border-slate-100 px-3 py-2 dark:border-darkmode-500">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 overflow-hidden rounded-full">
                                        <img src="<?php echo e($employee->profile_picture_url); ?>" alt="<?php echo e($employee->full_name); ?>" class="h-full w-full object-cover" />
                                    </div>
                                    <div>
                                        <p class="font-semibold"><?php echo e($employee->full_name); ?></p>
                                        <p class="text-xs text-slate-500"><?php echo e(optional($employee->department)->name ?? '—'); ?></p>
                                    </div>
                                </div>
                                <div class="text-right text-xs text-slate-500">
                                    <p><?php echo e(optional($employee->birth_date)->format('M d')); ?></p>
                                    <p class="font-semibold text-slate-600"><?php echo e($days === 0 ? 'Today' : $days . ' days'); ?></p>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <div class="mt-6 text-sm text-slate-500">No birthdays in the coming days.</div>
                <?php endif; ?>
            </div>

            <!-- Documents expiring -->
            <div class="intro-y box rounded-2xl p-5">
                <div class="flex items-center justify-between">
                    <h3 class="text-base font-semibold flex items-center gap-2">
                        <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'FileWarning','class' => 'h-5 w-5 text-warning']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'FileWarning','class' => 'h-5 w-5 text-warning']); ?>
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
                        Company Documents
                    </h3>
                    <span class="text-xs text-slate-500">Next <?php echo e($hrExpiryDays); ?> days</span>
                </div>
                <?php if(isset($hrExpiringDocuments) && $hrExpiringDocuments->count()): ?>
                    <div class="mt-4 space-y-3 text-sm max-h-72 overflow-y-auto">
                        <?php $__currentLoopData = $hrExpiringDocuments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $days = $doc->days_until_expiry; ?>
                            <div class="rounded-2xl border border-slate-100 p-3 dark:border-darkmode-500">
                                <p class="font-semibold text-slate-800 dark:text-slate-100 truncate"><?php echo e($doc->title ?? $doc->file_name); ?></p>
                                <div class="mt-1 flex items-center text-xs text-slate-500">
                                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Calendar','class' => 'mr-1 h-3.5 w-3.5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Calendar','class' => 'mr-1 h-3.5 w-3.5']); ?>
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
                                    <?php echo e(optional($doc->expiry_date)->format(setting('date_format', 'Y-m-d'))); ?>

                                    <span class="ml-auto rounded-full px-2 py-0.5 text-[11px]
                                        <?php if($days <= 0): ?>
                                            bg-red-100 text-red-700
                                        <?php elseif($days <= 7): ?>
                                            bg-orange-100 text-orange-700
                                        <?php else: ?>
                                            bg-amber-100 text-amber-700
                                        <?php endif; ?>
                                    ">
                                        <?php if($days <= 0): ?>
                                            Expired
                                        <?php else: ?>
                                            <?php echo e($days); ?> days left
                                        <?php endif; ?>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <div class="mt-6 text-sm text-slate-500">No expiring documents.</div>
                <?php endif; ?>
            </div>

            <!-- Employee documents expiring -->
            <div class="intro-y box rounded-2xl p-5">
                <div class="flex items-center justify-between">
                    <h3 class="text-base font-semibold flex items-center gap-2">
                        <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'IdCard','class' => 'h-5 w-5 text-sky-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'IdCard','class' => 'h-5 w-5 text-sky-500']); ?>
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
                        Employee Documents
                    </h3>
                    <span class="text-xs text-slate-500">Next <?php echo e($hrEmployeeExpiryDays); ?> days</span>
                </div>
                <?php if(isset($hrEmployeeExpiringDocuments) && $hrEmployeeExpiringDocuments->count()): ?>
                    <div class="mt-4 space-y-3 text-sm max-h-72 overflow-y-auto">
                        <?php $__currentLoopData = $hrEmployeeExpiringDocuments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $days = $doc->expiry_date ? $doc->expiry_date->diffInDays(now(), false) : null;
                                $employee = $doc->employee;
                            ?>
                            <div class="flex items-start gap-3 rounded-2xl border border-slate-100 p-3 dark:border-darkmode-500">
                                <div class="h-10 w-10 flex-none overflow-hidden rounded-full">
                                    <?php if($employee): ?>
                                        <img src="<?php echo e($employee->profile_picture_url); ?>" alt="<?php echo e($employee->full_name); ?>" class="h-full w-full object-cover" />
                                    <?php else: ?>
                                        <div class="flex h-full w-full items-center justify-center bg-slate-100 text-xs text-slate-500">N/A</div>
                                    <?php endif; ?>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-slate-800 dark:text-slate-100"><?php echo e($doc->document_name); ?></p>
                                    <p class="text-xs text-slate-500">
                                    <?php if($employee): ?>
                                        <?php echo e($employee->full_name); ?>

                                        <?php if($employee->department): ?>
                                            · <?php echo e($employee->department->name); ?>

                                        <?php endif; ?>
                                    <?php else: ?>
                                        Unknown employee
                                    <?php endif; ?>
                                    </p>
                                    <div class="mt-1 flex items-center text-xs text-slate-500">
                                        <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Calendar','class' => 'mr-1 h-3.5 w-3.5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Calendar','class' => 'mr-1 h-3.5 w-3.5']); ?>
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
                                        <?php echo e(optional($doc->expiry_date)->format(setting('date_format', 'Y-m-d'))); ?>

                                        <?php if(!is_null($days)): ?>
                                            <span class="ml-auto rounded-full px-2 py-0.5 text-[11px]
                                                <?php if($days <= 0): ?>
                                                    bg-red-100 text-red-700
                                                <?php elseif($days <= 7): ?>
                                                    bg-orange-100 text-orange-700
                                                <?php else: ?>
                                                    bg-amber-100 text-amber-700
                                                <?php endif; ?>
                                            ">
                                                <?php if($days <= 0): ?>
                                                    Expired
                                                <?php else: ?>
                                                    <?php echo e($days); ?> days left
                                                <?php endif; ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php if($employee): ?>
                                    <a href="<?php echo e(route('hr.employees.documents.index', $employee->id)); ?>" class="btn-tonal btn-tonal--icon btn-tonal--info" title="View documents">
                                        <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'ExternalLink','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'ExternalLink','class' => 'h-4 w-4']); ?>
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
                                <?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <div class="mt-6 text-sm text-slate-500">No employee documents expiring soon.</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Passport & Visa expiry trackers -->
        <div class="col-span-12">
            <div class="grid grid-cols-12 gap-6">
                <div class="intro-y col-span-12 lg:col-span-6">
                    <div class="box rounded-2xl p-5 h-full">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-base font-semibold flex items-center gap-2">
                                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Globe','class' => 'h-5 w-5 text-sky-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Globe','class' => 'h-5 w-5 text-sky-500']); ?>
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
                                    <?php echo e(__('Passports Expiring Soon')); ?>

                                </h3>
                                <p class="text-xs text-slate-500"><?php echo e(__('Nearest 10 passports to expire')); ?></p>
                            </div>
                            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'AlertTriangle','class' => 'h-5 w-5 text-amber-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'AlertTriangle','class' => 'h-5 w-5 text-amber-400']); ?>
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
                        <?php if($upcomingPassports->isNotEmpty()): ?>
                            <div class="mt-5 space-y-4">
                                <?php $__currentLoopData = $upcomingPassports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $passport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $daysLeft = $passport->expiry_date ? now()->diffInDays($passport->expiry_date, false) : null;
                                        $tone = $getExpiryTone($daysLeft);
                                        $employee = $passport->employee;
                                    ?>
                                    <div class="flex items-start gap-3 rounded-2xl border border-slate-100 p-3 dark:border-darkmode-500">
                                        <div class="h-11 w-11 flex-none overflow-hidden rounded-full">
                                            <?php if($employee): ?>
                                                <img src="<?php echo e($employee->profile_picture_url); ?>" alt="<?php echo e($employee->full_name); ?>" class="h-full w-full object-cover" />
                                            <?php else: ?>
                                                <div class="flex h-full w-full items-center justify-center bg-slate-100 text-xs text-slate-500">N/A</div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2">
                                                <p class="font-semibold text-sm text-slate-800 dark:text-slate-100">
                                                    <?php echo e($employee->full_name ?? __('Unknown Employee')); ?>

                                                </p>
                                                <span class="inline-flex items-center gap-1 rounded-full <?php echo e($tone['class']); ?>">
                                                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Timer','class' => 'h-3.5 w-3.5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Timer','class' => 'h-3.5 w-3.5']); ?>
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
                                                    <?php if(is_null($daysLeft)): ?>
                                                        <?php echo e($tone['label']); ?>

                                                    <?php elseif($daysLeft <= 0): ?>
                                                        <?php echo e(__('Expired')); ?>

                                                    <?php else: ?>
                                                        <?php echo e($daysLeft); ?> <?php echo e(__('days')); ?>

                                                    <?php endif; ?>
                                                </span>
                                            </div>
                                            <p class="text-xs text-slate-500">
                                                <?php echo e(__('Passport')); ?> · <?php echo e(optional($passport->expiry_date)->format(setting('date_format', 'Y-m-d'))); ?>

                                                <?php if($employee && $employee->department): ?>
                                                    · <?php echo e($employee->department->name); ?>

                                                <?php endif; ?>
                                            </p>
                                        </div>
                                        <div class="text-xs text-slate-500 text-right">
                                            <p class="font-semibold"><?php echo e($passport->document_number ?? __('No number')); ?></p>
                                            <p><?php echo e(__('Code:')); ?> <?php echo e($employee->code ?? '—'); ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <div class="mt-10 text-center text-sm text-slate-500">
                                <?php echo e(__('No passports nearing expiry.')); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="intro-y col-span-12 lg:col-span-6">
                    <div class="box rounded-2xl p-5 h-full">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-base font-semibold flex items-center gap-2">
                                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Plane','class' => 'h-5 w-5 text-emerald-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Plane','class' => 'h-5 w-5 text-emerald-500']); ?>
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
                                    <?php echo e(__('Visas Expiring Soon')); ?>

                                </h3>
                                <p class="text-xs text-slate-500"><?php echo e(__('Nearest 10 visas to expire')); ?></p>
                            </div>
                            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'AlertTriangle','class' => 'h-5 w-5 text-rose-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'AlertTriangle','class' => 'h-5 w-5 text-rose-400']); ?>
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
                        <?php if($upcomingVisas->isNotEmpty()): ?>
                            <div class="mt-5 space-y-4">
                                <?php $__currentLoopData = $upcomingVisas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $visa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $daysLeft = $visa->expiry_date ? now()->diffInDays($visa->expiry_date, false) : null;
                                        $tone = $getExpiryTone($daysLeft);
                                        $employee = $visa->employee;
                                    ?>
                                    <div class="flex items-start gap-3 rounded-2xl border border-slate-100 p-3 dark:border-darkmode-500">
                                        <div class="h-11 w-11 flex-none overflow-hidden rounded-full">
                                            <?php if($employee): ?>
                                                <img src="<?php echo e($employee->profile_picture_url); ?>" alt="<?php echo e($employee->full_name); ?>" class="h-full w-full object-cover" />
                                            <?php else: ?>
                                                <div class="flex h-full w-full items-center justify-center bg-slate-100 text-xs text-slate-500">N/A</div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2">
                                                <p class="font-semibold text-sm text-slate-800 dark:text-slate-100">
                                                    <?php echo e($employee->full_name ?? __('Unknown Employee')); ?>

                                                </p>
                                                <span class="inline-flex items-center gap-1 rounded-full <?php echo e($tone['class']); ?>">
                                                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Timer','class' => 'h-3.5 w-3.5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Timer','class' => 'h-3.5 w-3.5']); ?>
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
                                                    <?php if(is_null($daysLeft)): ?>
                                                        <?php echo e($tone['label']); ?>

                                                    <?php elseif($daysLeft <= 0): ?>
                                                        <?php echo e(__('Expired')); ?>

                                                    <?php else: ?>
                                                        <?php echo e($daysLeft); ?> <?php echo e(__('days')); ?>

                                                    <?php endif; ?>
                                                </span>
                                            </div>
                                            <p class="text-xs text-slate-500">
                                                <?php echo e(__('Visa')); ?> · <?php echo e(optional($visa->expiry_date)->format(setting('date_format', 'Y-m-d'))); ?>

                                                <?php if($employee && $employee->department): ?>
                                                    · <?php echo e($employee->department->name); ?>

                                                <?php endif; ?>
                                            </p>
                                        </div>
                                        <div class="text-xs text-slate-500 text-right">
                                            <p class="font-semibold"><?php echo e($visa->document_number ?? __('No number')); ?></p>
                                            <p><?php echo e(__('Code:')); ?> <?php echo e($employee->code ?? '—'); ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <div class="mt-10 text-center text-sm text-slate-500">
                                <?php echo e(__('No visas nearing expiry.')); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Attendance trend line chart
            const attendanceCanvas = document.getElementById('hr-attendance-chart');
            if (attendanceCanvas && typeof Chart !== 'undefined') {
                const attendanceLabels = <?php echo json_encode($attendanceTrendLabels ?? [], 15, 512) ?>;
                const attendanceData = <?php echo json_encode($attendanceTrendData ?? [], 15, 512) ?>;

                if (attendanceLabels.length && attendanceData.length) {
                    const ctx = attendanceCanvas.getContext('2d');

                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: attendanceLabels,
                            datasets: [
                                {
                                    label: 'Presence rate %',
                                    data: attendanceData,
                                    borderColor: 'rgba(34, 197, 94, 1)', // emerald-500
                                    backgroundColor: 'rgba(34, 197, 94, 0.15)',
                                    borderWidth: 2,
                                    fill: true,
                                    tension: 0.35,
                                    pointRadius: 3,
                                    pointBackgroundColor: 'rgba(34, 197, 94, 1)',
                                },
                            ],
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    max: 100,
                                    ticks: {
                                        callback: function (value) {
                                            return value + '%';
                                        },
                                    },
                                },
                            },
                            plugins: {
                                legend: {
                                    display: false,
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function (context) {
                                            return context.parsed.y + '% presence';
                                        },
                                    },
                                },
                            },
                        },
                    });
                }
            }

            // Workforce by department donut chart
            const departmentCanvas = document.getElementById('hr-departments-chart');
            if (departmentCanvas && typeof Chart !== 'undefined') {
                const departmentLabels = <?php echo json_encode($departmentDistributionLabels ?? [], 15, 512) ?>;
                const departmentData = <?php echo json_encode($departmentDistributionData ?? [], 15, 512) ?>;

                if (departmentLabels.length && departmentData.length) {
                    const ctx = departmentCanvas.getContext('2d');

                    const baseColors = [
                        '#0ea5e9', // sky-500
                        '#6366f1', // indigo-500
                        '#f97316', // orange-500
                        '#22c55e', // green-500
                        '#ec4899', // pink-500
                        '#eab308', // yellow-500
                    ];

                    const colors = departmentLabels.map((_, index) => {
                        return baseColors[index % baseColors.length];
                    });

                    new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: departmentLabels,
                            datasets: [
                                {
                                    data: departmentData,
                                    backgroundColor: colors.map(color => color + 'CC'),
                                    borderColor: colors,
                                    borderWidth: 2,
                                },
                            ],
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        usePointStyle: true,
                                        padding: 16,
                                    },
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function (context) {
                                            const label = context.label || '';
                                            const value = context.parsed;
                                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                            const percentage = total ? Math.round((value / total) * 100) : 0;
                                            return `${label}: ${value} (${percentage}%)`;
                                        },
                                    },
                                },
                            },
                            cutout: '65%',
                        },
                    });
                }
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('../themes/' . $activeTheme . '/' . $activeLayout, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\ERP System\Source\resources\views/hr/dashboard.blade.php ENDPATH**/ ?>
<?php $__env->startSection('subhead'); ?>
    <title>Settings - ERP System</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('subcontent'); ?>
    <?php echo $__env->make('components.global-notifications', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="grid grid-cols-12 gap-6">
        <!-- Sidebar -->
        <div class="col-span-12 lg:col-span-3">
            <?php echo $__env->make('settings.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

        <!-- Content Area -->
        <div class="col-span-12 lg:col-span-9">
            <div class="container mx-auto px-4 lg:px-0">
                <!-- General Settings Tab -->
                <div class="settings-content intro-y" id="general-content">
                    <?php echo $__env->make('settings.partials.general', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>

                <!-- Company Settings Tab -->
                <div class="settings-content hidden intro-y" id="company-content">
                    <?php echo $__env->make('settings.partials.company', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>

                <!-- Prefix Settings Tab -->
                <div class="settings-content hidden intro-y" id="prefix-content">
                    <?php echo $__env->make('settings.partials.prefix', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>

                <!-- Notifications Settings Tab -->
                <div class="settings-content hidden intro-y" id="notifications-content">
                    <?php echo $__env->make('settings.partials.notifications', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>

                 <!-- AI Settings Tab -->
                <div class="settings-content hidden intro-y" id="ai-content">
                    <?php echo $__env->make('settings.partials.ai', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>

                <!-- Permissions Settings Tab -->
                <div class="settings-content hidden intro-y" id="permissions-content">
                    <?php echo $__env->make('settings.partials.permissions', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>

                <!-- Taxes Settings Tab -->
                <div class="settings-content hidden intro-y" id="taxes-content">
                    <?php echo $__env->make('settings.partials.taxes', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>

                <!-- Email Settings Tab -->
                <div class="settings-content hidden intro-y" id="email-content">
                    <?php echo $__env->make('settings.partials.email', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>

                <!-- Appearance Settings Tab -->
                <div class="settings-content hidden intro-y" id="appearance-content">
                    <?php echo $__env->make('settings.partials.appearance', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>

                <!-- Attendance Settings Tab -->
                <div class="settings-content hidden intro-y" id="attendance-content">
                    <?php echo $__env->make('settings.partials.attendance', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>
        </div>
    </div>

    <?php echo $__env->make('settings.partials.scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../themes/' . $activeTheme . '/' . $activeLayout, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\ERP System\Source\resources\views/settings/index.blade.php ENDPATH**/ ?>
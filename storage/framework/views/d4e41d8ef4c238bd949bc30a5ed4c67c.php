<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>" <?php echo e(app()->getLocale() === 'ar' ? 'dir="rtl"' : ''); ?>>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(__('messages.welcome')); ?> - <?php echo e(config('app.name')); ?></title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; direction: <?php echo e(app()->getLocale() === 'ar' ? 'rtl' : 'ltr'); ?>; }
        .section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
        .section h3 { margin-top: 0; color: #333; }
        .item { margin: 5px 0; }
        .highlight { background: #f0f0f0; padding: 2px 4px; border-radius: 3px; }
    </style>
</head>
<body>
    <h1><?php echo e(__('messages.welcome')); ?> - <?php echo e(config('app.name')); ?></h1>
    <p><?php echo e(__('messages.current_language')); ?>: <strong><?php echo e(app()->getLocale()); ?></strong></p>
    <p>Session Locale: <strong><?php echo e(session('locale', 'not set')); ?></strong></p>
    <p>App Locale: <strong><?php echo e(config('app.locale')); ?></strong></p>

    <?php if(isset($debug)): ?>
    <div style="background: #f0f0f0; padding: 10px; margin: 10px 0; border-radius: 5px;">
        <h4>Debug Info:</h4>
        <p>App Locale: <?php echo e($debug['app_locale']); ?></p>
        <p>Session Locale: <?php echo e($debug['session_locale']); ?></p>
        <p>Config Locale: <?php echo e($debug['config_locale']); ?></p>
    </div>
    <?php endif; ?>

    <div style="margin: 20px 0;">
        <a href="<?php echo e(route('lang.switch', 'en')); ?>" style="margin: 0 10px;">🇺🇸 English</a> |
        <a href="<?php echo e(route('lang.switch', 'ar')); ?>" style="margin: 0 10px;">🇸🇦 العربية</a>
    </div>

    <div class="section">
        <h3>📋 <?php echo e(__('menu.dashboard')); ?></h3>
        <div class="item"><strong><?php echo e(__('actions.save')); ?></strong> | <strong><?php echo e(__('actions.delete')); ?></strong> | <strong><?php echo e(__('actions.edit')); ?></strong></div>
    </div>

    <div class="section">
        <h3>🏢 <?php echo e(__('menu.warehouse')); ?></h3>
        <div class="item"><?php echo e(__('menu.purchase_orders')); ?> | <?php echo e(__('menu.material_requests')); ?> | <?php echo e(__('menu.materials')); ?></div>
    </div>

    <div class="section">
        <h3>👥 <?php echo e(__('menu.customers')); ?></h3>
        <div class="item"><?php echo e(__('menu.suppliers')); ?> | <?php echo e(__('menu.vendors')); ?></div>
    </div>

    <div class="section">
        <h3>👨‍💼 <?php echo e(__('menu.hr')); ?></h3>
        <div class="item"><?php echo e(__('menu.employees')); ?> | <?php echo e(__('menu.departments')); ?> | <?php echo e(__('menu.attendance')); ?></div>
    </div>

    <div class="section">
        <h3>📊 <?php echo e(__('menu.accounts')); ?></h3>
        <div class="item"><?php echo e(__('menu.invoices')); ?> | <?php echo e(__('menu.payments')); ?> | <?php echo e(__('menu.reports')); ?></div>
    </div>

    <div class="section">
        <h3>📝 <?php echo e(__('status.active')); ?> / <?php echo e(__('status.inactive')); ?></h3>
        <div class="item"><?php echo e(__('status.pending')); ?> | <?php echo e(__('status.approved')); ?> | <?php echo e(__('status.completed')); ?></div>
    </div>

    <div class="section">
        <h3>💬 <?php echo e(__('messages.success_saved')); ?></h3>
        <div class="item"><?php echo e(__('messages.success_saved')); ?></div>
        <div class="item"><?php echo e(__('messages.error_occurred')); ?></div>
        <div class="item"><?php echo e(__('messages.loading')); ?></div>
        <div class="item"><?php echo e(__('messages.confirm_delete')); ?></div>
    </div>

    <div class="section">
        <h3>🧪 Test Translations</h3>
        <div class="item">Direct: <?php echo e(__('menu.crm')); ?></div>
        <div class="item">Trans Helper: <?php echo e(trans('menu.crm')); ?></div>
    </div>
</body>
</html>
<?php /**PATH D:\laravel\smart-erp\resources\views/test-lang.blade.php ENDPATH**/ ?>
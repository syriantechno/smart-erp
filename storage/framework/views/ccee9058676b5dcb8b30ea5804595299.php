<!DOCTYPE html>

<html
    lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>"
>
<!-- BEGIN: Head -->

<head>
    <meta charset="utf-8">
    <meta
        name="csrf-token"
        content="<?php echo e(csrf_token()); ?>"
    >
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    <meta
        name="description"
        content="Midone admin is super flexible, powerful, clean & modern responsive tailwind admin template with unlimited possibilities."
    >
    <meta
        name="keywords"
        content="admin template, midone Admin Template, dashboard template, flat admin template, responsive admin template, web app"
    >
    <meta
        name="author"
        content="LEFT4CODE"
    >

    <?php echo $__env->yieldContent('head'); ?>

    <!-- BEGIN: CSS Assets-->
    <?php echo $__env->yieldPushContent('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>

    <!-- Custom Theme CSS -->
    <?php if(file_exists(public_path('css/custom-theme.css'))): ?>
        <link rel="stylesheet" href="<?php echo e(asset('css/custom-theme.css?v=' . filemtime(public_path('css/custom-theme.css')))); ?>">
    <?php endif; ?>

    <!-- Dark Mode CSS -->
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/dark-mode.css'); ?>

    <!-- DataTables Local CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('vendor/datatables/datatables.min.css')); ?>">
</head>
<!-- END: Head -->

<body class="<?php echo e(setting('dark_mode', false) ? 'dark' : ''); ?> <?php echo e(setting('font_size', 'medium')); ?> <?php echo e(setting('animations_enabled', true) ? '' : 'no-animations'); ?>">


<?php echo $__env->yieldContent('content'); ?>

 <!-- BEGIN: Vendor JS Assets-->
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/vendors/dom.js'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/vendors/tailwind-merge.js'); ?>
    <?php echo $__env->yieldPushContent('vendors'); ?>

    <!-- BEGIN: Pages, layouts, components JS Assets-->

    <?php echo $__env->make('components.global-notifications', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- DataTables Local JavaScript -->
    <script src="<?php echo e(asset('vendor/datatables/jquery-3.7.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/datatables/datatables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/datatables/sweetalert2.min.js')); ?>"></script>

    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        // Wait for Alpine.js to load
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Alpine !== 'undefined') {
                console.log('✅ Alpine.js loaded successfully');
            } else {
                console.error('❌ Alpine.js not loaded');
            }
        });
    </script>

    <!-- Fix: prevent layout shift when modals/slideover adjust body padding-right -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var resetBodyPadding = function () {
                if (document && document.body) {
                    document.body.style.paddingRight = '0px';
                }
            };

            ['show.tw.modal', 'shown.tw.modal', 'hide.tw.modal', 'hidden.tw.modal'].forEach(function (eventName) {
                document.addEventListener(eventName, resetBodyPadding, true);
            });
        });
    </script>

    <!-- Lucide Icons Local JavaScript -->
    <script src="<?php echo e(asset('vendor/lucide/lucide.umd.min.js')); ?>"></script>
    <script>
        // Initialize Lucide Icons
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined' && lucide.createIcons) {
                lucide.createIcons({
                    'stroke-width': 1.5,
                    nameAttr: 'data-lucide'
                });
                console.log('✅ Lucide icons initialized locally');
            } else {
                console.error('❌ Lucide library not loaded');
            }
        });
    </script>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/app.js'); ?>
    <?php echo $__env->yieldPushContent('scripts'); ?>
    <!-- END: Pages, layouts, components JS Assets-->
</body>

</html>
<?php /**PATH D:\laravel\smart-erp\resources\views////themes/base.blade.php ENDPATH**/ ?>
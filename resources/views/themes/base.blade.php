<!DOCTYPE html>

<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
>
<!-- BEGIN: Head -->

<head>
    <meta charset="utf-8">
    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
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

    @yield('head')

    <!-- BEGIN: CSS Assets-->
    @stack('styles')
    @vite('resources/css/app.css')

    <!-- Custom Theme CSS -->
    @if(file_exists(public_path('css/custom-theme.css')))
        <link rel="stylesheet" href="{{ asset('css/custom-theme.css?v=' . filemtime(public_path('css/custom-theme.css'))) }}">
    @endif

    <!-- Dark Mode CSS -->
    @vite('resources/css/dark-mode.css')

    <!-- DataTables Local CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/datatables/datatables.min.css') }}">
</head>
<!-- END: Head -->

<body class="{{ setting('dark_mode', false) ? 'dark' : '' }} {{ setting('font_size', 'medium') }} {{ setting('animations_enabled', true) ? '' : 'no-animations' }}">


@yield('content')

 <!-- BEGIN: Vendor JS Assets-->
    @vite('resources/js/vendors/dom.js')
    @vite('resources/js/vendors/tailwind-merge.js')
    @stack('vendors')

    <!-- BEGIN: Pages, layouts, components JS Assets-->

    @include('components.global-notifications')

    <!-- DataTables Local JavaScript -->
    <script src="{{ asset('vendor/datatables/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/sweetalert2.min.js') }}"></script>

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
    <script src="{{ asset('vendor/lucide/lucide.umd.min.js') }}"></script>
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

    @stack('scripts')
    <!-- END: Pages, layouts, components JS Assets-->
</body>

</html>

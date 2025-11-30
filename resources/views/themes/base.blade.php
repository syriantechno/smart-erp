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

    <style>
        :root {
            --color-primary: var(--primary-color, #2563eb);
            --color-secondary: var(--secondary-color, #0f172a);
            --color-primary-rgb: var(--primary-rgb, 37 99 235);
        }

        /* Fix for Toggle Switches */
        .peer:checked ~ div {
            background-color: rgb(var(--color-primary-rgb, 37 99 235)) !important;
        }
        
        .peer:checked ~ .peer-checked\:bg-primary {
            background-color: rgb(var(--color-primary-rgb, 37 99 235)) !important;
        }

        /* Add Shadow to Toggle Switches */
        input[type="checkbox"] + div,
        input[type="checkbox"] ~ div {
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
        }

        input[type="checkbox"]:focus + div,
        input[type="checkbox"]:focus ~ div {
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05), 0 0 0 3px rgba(var(--color-primary-rgb, 37 99 235), 0.1) !important;
        }

        /* Fix for Form Input Shadows */
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"],
        input[type="tel"],
        input[type="url"],
        input[type="date"],
        input[type="datetime-local"],
        input[type="time"],
        textarea,
        select {
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
            transition: box-shadow 0.15s ease-in-out, border-color 0.15s ease-in-out !important;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="number"]:focus,
        input[type="tel"]:focus,
        input[type="url"]:focus,
        input[type="date"]:focus,
        input[type="datetime-local"]:focus,
        input[type="time"]:focus,
        textarea:focus,
        select:focus {
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05), 0 0 0 3px rgba(var(--color-primary-rgb, 37 99 235), 0.1) !important;
            border-color: rgb(var(--color-primary-rgb, 37 99 235)) !important;
        }
        
    </style>

    <!-- Dark Mode CSS -->
    @vite('resources/css/dark-mode.css')

    <!-- DataTables Local CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/datatables/datatables.min.css') }}">
</head>
<!-- END: Head -->

<body class="{{ setting('dark_mode', false) ? 'dark' : '' }} {{ setting('font_size', 'medium') }} {{ setting('animations_enabled', true) ? '' : 'no-animations' }} overflow-x-hidden">


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
    <script src="{{ asset('vendor/lucide/lucide.umd.min.js') }}" defer></script>
    <script>
        // Initialize Lucide Icons with performance optimization
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined' && lucide.createIcons) {
                // Use requestAnimationFrame for better performance
                requestAnimationFrame(() => {
                    lucide.createIcons({
                        'stroke-width': 1.5,
                        nameAttr: 'data-lucide'
                    });
                    console.log('✅ Lucide icons initialized locally');
                });
            } else {
                console.error('❌ Lucide library not loaded');
            }
        });
    </script>
    @vite(['resources/js/app.js', 'resources/js/accessibility-fixes.js'])
    
    
    @stack('scripts')
    <!-- END: Pages, layouts, components JS Assets-->

<!-- Toast Container - Must be at the end of body for proper z-index -->
<div id="global-toast-container"></div>

</body>

</html>

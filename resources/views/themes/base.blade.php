<!DOCTYPE html>
<!--
Template Name: Midone - Admin Dashboard Template
Author: Left4code
Website: http://www.left4code.com/
Contact: muhammadrizki@left4code.com
Purchase: https://themeforest.net/user/left4code/portfolio
Renew Support: https://themeforest.net/user/left4code/portfolio
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
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

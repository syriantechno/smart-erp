<?php
/**
 * إعدادات مكتبات DataTables المحلية
 *
 * هذا الملف يحتوي على إعدادات المكتبات المحلية
 * وطرق للتحقق من وجودها وتحديثها
 */

return [
    /*
    |--------------------------------------------------------------------------
    | DataTables Local Libraries Configuration
    |--------------------------------------------------------------------------
    |
    | إعدادات مكتبات DataTables المحلية المُحمّلة في المشروع
    |
    */

    'libraries' => [
        'jquery' => [
            'version' => '3.7.1',
            'file' => 'jquery-3.7.1.min.js',
            'url' => 'https://code.jquery.com/jquery-3.7.1.min.js',
            'path' => public_path('vendor/datatables/jquery-3.7.1.min.js'),
            'asset_path' => 'vendor/datatables/jquery-3.7.1.min.js',
        ],

        'datatables_js' => [
            'version' => '1.13.8',
            'file' => 'datatables.min.js',
            'url' => 'https://cdn.datatables.net/v/bs5/dt-1.13.8/datatables.min.js',
            'path' => public_path('vendor/datatables/datatables.min.js'),
            'asset_path' => 'vendor/datatables/datatables.min.js',
        ],

        'datatables_css' => [
            'version' => '1.13.8',
            'file' => 'datatables.min.css',
            'url' => 'https://cdn.datatables.net/v/bs5/dt-1.13.8/datatables.min.css',
            'path' => public_path('vendor/datatables/datatables.min.css'),
            'asset_path' => 'vendor/datatables/datatables.min.css',
        ],

        'sweetalert2' => [
            'version' => '11.10.1',
            'file' => 'sweetalert2.min.js',
            'url' => 'https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js',
            'path' => public_path('vendor/datatables/sweetalert2.min.js'),
            'asset_path' => 'vendor/datatables/sweetalert2.min.js',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CDN Fallback
    |--------------------------------------------------------------------------
    |
    | استخدام CDN كبديل في حالة عدم وجود الملفات المحلية
    |
    */

    'cdn_fallback' => [
        'enabled' => true,
        'jquery' => 'https://code.jquery.com/jquery-3.7.1.min.js',
        'datatables_js' => 'https://cdn.datatables.net/v/bs5/dt-1.13.8/datatables.min.js',
        'datatables_css' => 'https://cdn.datatables.net/v/bs5/dt-1.13.8/datatables.min.css',
        'sweetalert2' => 'https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js',
    ],
];

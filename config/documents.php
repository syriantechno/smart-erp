<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Document Management Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration options for the Document Management system.
    | You can customize file upload limits, allowed extensions, access levels,
    | and other document-related settings.
    |
    */

    'max_file_size' => env('DOCUMENT_MAX_FILE_SIZE', 51200), // KB (50MB)

    'allowed_extensions' => [
        // Documents
        'pdf', 'doc', 'docx', 'txt', 'rtf', 'odt',
        // Spreadsheets
        'xls', 'xlsx', 'csv', 'ods',
        // Presentations
        'ppt', 'pptx', 'odp',
        // Images
        'jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'svg',
        // Archives
        'zip', 'rar', '7z',
        // Other
        'xml', 'json', 'md'
    ],

    'allowed_mime_types' => [
        // PDF
        'application/pdf',
        // Word Documents
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        // Text Files
        'text/plain',
        'text/rtf',
        // Excel Spreadsheets
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'text/csv',
        // PowerPoint
        'application/vnd.ms-powerpoint',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        // Images
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/bmp',
        'image/tiff',
        'image/svg+xml',
        // Archives
        'application/zip',
        'application/x-rar-compressed',
        'application/x-7z-compressed',
        // Other
        'application/xml',
        'application/json',
        'text/markdown'
    ],

    'access_levels' => [
        'public' => [
            'label' => 'Public',
            'description' => 'Accessible to all authenticated users',
            'color' => '#10b981'
        ],
        'internal' => [
            'label' => 'Internal',
            'description' => 'Accessible to company employees',
            'color' => '#3b82f6'
        ],
        'confidential' => [
            'label' => 'Confidential',
            'description' => 'Accessible to department members only',
            'color' => '#f59e0b'
        ],
        'restricted' => [
            'label' => 'Restricted',
            'description' => 'Accessible to specific users only',
            'color' => '#ef4444'
        ]
    ],

    'document_types' => [
        'contract' => ['label' => 'Contract', 'icon' => 'file-text', 'color' => '#ef4444'],
        'invoice' => ['label' => 'Invoice', 'icon' => 'receipt', 'color' => '#22c55e'],
        'report' => ['label' => 'Report', 'icon' => 'bar-chart-3', 'color' => '#3b82f6'],
        'certificate' => ['label' => 'Certificate', 'icon' => 'award', 'color' => '#f59e0b'],
        'license' => ['label' => 'License', 'icon' => 'key', 'color' => '#8b5cf6'],
        'agreement' => ['label' => 'Agreement', 'icon' => 'file-signature', 'color' => '#06b6d4'],
        'policy' => ['label' => 'Policy', 'icon' => 'shield', 'color' => '#ec4899'],
        'manual' => ['label' => 'Manual', 'icon' => 'book', 'color' => '#84cc16'],
        'other' => ['label' => 'Other', 'icon' => 'file', 'color' => '#6b7280']
    ],

    'category_colors' => [
        'contracts' => '#ef4444',
        'financial' => '#22c55e',
        'hr' => '#3b82f6',
        'reports' => '#f59e0b',
        'legal' => '#8b5cf6',
        'technical' => '#06b6d4',
        'marketing' => '#ec4899',
        'operations' => '#84cc16',
        'other' => '#6b7280'
    ],

    'storage' => [
        'disk' => env('DOCUMENT_STORAGE_DISK', 'local'),
        'path' => env('DOCUMENT_STORAGE_PATH', 'documents'),
        'visibility' => env('DOCUMENT_STORAGE_VISIBILITY', 'private'),
    ],

    'versioning' => [
        'enabled' => env('DOCUMENT_VERSIONING_ENABLED', true),
        'max_versions' => env('DOCUMENT_MAX_VERSIONS', 10),
        'auto_cleanup' => env('DOCUMENT_AUTO_CLEANUP', true),
    ],

    'notifications' => [
        'enabled' => env('DOCUMENT_NOTIFICATIONS_ENABLED', true),
        'events' => [
            'document_uploaded' => true,
            'document_shared' => true,
            'document_deleted' => true,
            'version_created' => false,
        ]
    ],

    'audit' => [
        'enabled' => env('DOCUMENT_AUDIT_ENABLED', true),
        'retention_days' => env('DOCUMENT_AUDIT_RETENTION', 365),
    ],

    'auto_archive' => [
        'enabled' => env('DOCUMENT_AUTO_ARCHIVE_ENABLED', false),
        'days_inactive' => env('DOCUMENT_AUTO_ARCHIVE_DAYS', 365),
        'target_status' => 'archived',
    ],

    'preview' => [
        'enabled' => env('DOCUMENT_PREVIEW_ENABLED', true),
        'max_size' => env('DOCUMENT_PREVIEW_MAX_SIZE', 10240), // KB
        'supported_types' => ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'txt'],
    ],

    'search' => [
        'full_text_enabled' => env('DOCUMENT_FULL_TEXT_SEARCH', true),
        'index_content' => env('DOCUMENT_INDEX_CONTENT', true),
        'searchable_fields' => ['title', 'description', 'content', 'tags'],
    ],

    'sharing' => [
        'enabled' => env('DOCUMENT_SHARING_ENABLED', true),
        'default_expiry_days' => env('DOCUMENT_SHARE_EXPIRY_DAYS', 30),
        'max_shares_per_document' => env('DOCUMENT_MAX_SHARES', 50),
        'require_approval' => env('DOCUMENT_SHARE_APPROVAL_REQUIRED', false),
    ],

    'upload' => [
        'chunked_enabled' => env('DOCUMENT_CHUNKED_UPLOAD', true),
        'chunk_size' => env('DOCUMENT_CHUNK_SIZE', 1024), // KB
        'max_concurrent_uploads' => env('DOCUMENT_MAX_CONCURRENT_UPLOADS', 3),
    ],

    'cleanup' => [
        'enabled' => env('DOCUMENT_CLEANUP_ENABLED', true),
        'temp_files_older_than' => env('DOCUMENT_CLEANUP_TEMP_HOURS', 24), // hours
        'orphaned_files_older_than' => env('DOCUMENT_CLEANUP_ORPHANED_DAYS', 30), // days
    ]
];

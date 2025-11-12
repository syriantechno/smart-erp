<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Chat System Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration options for the Internal Chat system.
    | You can customize message limits, file uploads, real-time settings,
    | and other chat-related features.
    |
    */

    'max_file_size' => env('CHAT_MAX_FILE_SIZE', 10240), // KB (10MB)

    'allowed_extensions' => explode(',', env('CHAT_ALLOWED_EXTENSIONS', 'jpg,jpeg,png,gif,pdf,doc,docx,txt,zip')),

    'message_history_days' => env('CHAT_MESSAGE_HISTORY_DAYS', 365),

    'max_participants' => env('CHAT_MAX_PARTICIPANTS', 50),

    'real_time_enabled' => env('CHAT_REAL_TIME_ENABLED', true),

    'typing_indicator_timeout' => env('CHAT_TYPING_TIMEOUT', 3000), // milliseconds

    'message_preview_length' => env('CHAT_PREVIEW_LENGTH', 100),

    'storage' => [
        'disk' => env('CHAT_STORAGE_DISK', 'public'),
        'path' => env('CHAT_STORAGE_PATH', 'chat-files'),
    ],

    'broadcasting' => [
        'driver' => env('CHAT_BROADCAST_DRIVER', 'pusher'),
        'connection' => env('CHAT_BROADCAST_CONNECTION', 'pusher'),
    ],

    'notifications' => [
        'browser_enabled' => env('CHAT_BROWSER_NOTIFICATIONS', true),
        'sound_enabled' => env('CHAT_SOUND_NOTIFICATIONS', true),
        'desktop_enabled' => env('CHAT_DESKTOP_NOTIFICATIONS', false),
        'email_enabled' => env('CHAT_EMAIL_NOTIFICATIONS', false),
    ],

    'message_types' => [
        'text' => [
            'label' => 'Text Message',
            'icon' => 'message-square',
            'max_length' => env('CHAT_MAX_TEXT_LENGTH', 5000),
        ],
        'file' => [
            'label' => 'File',
            'icon' => 'paperclip',
            'allowed_types' => ['pdf', 'doc', 'docx', 'txt', 'zip'],
        ],
        'image' => [
            'label' => 'Image',
            'icon' => 'image',
            'allowed_types' => ['jpg', 'jpeg', 'png', 'gif'],
            'max_width' => env('CHAT_MAX_IMAGE_WIDTH', 1920),
            'max_height' => env('CHAT_MAX_IMAGE_HEIGHT', 1080),
        ],
    ],

    'conversations' => [
        'types' => [
            'direct' => [
                'label' => 'Direct Message',
                'max_participants' => 2,
                'icon' => 'user',
            ],
            'group' => [
                'label' => 'Group Chat',
                'max_participants' => env('CHAT_MAX_GROUP_PARTICIPANTS', 50),
                'icon' => 'users',
            ],
        ],
        'auto_cleanup' => [
            'enabled' => env('CHAT_AUTO_CLEANUP_ENABLED', false),
            'inactive_days' => env('CHAT_AUTO_CLEANUP_DAYS', 365),
        ],
    ],

    'search' => [
        'enabled' => env('CHAT_SEARCH_ENABLED', true),
        'index_messages' => env('CHAT_INDEX_MESSAGES', true),
        'searchable_fields' => ['content', 'sender_name'],
        'max_results' => env('CHAT_SEARCH_MAX_RESULTS', 100),
    ],

    'encryption' => [
        'enabled' => env('CHAT_ENCRYPTION_ENABLED', false),
        'algorithm' => env('CHAT_ENCRYPTION_ALGORITHM', 'AES-256-CBC'),
        'key_rotation_days' => env('CHAT_KEY_ROTATION_DAYS', 90),
    ],

    'rate_limiting' => [
        'enabled' => env('CHAT_RATE_LIMITING_ENABLED', true),
        'messages_per_minute' => env('CHAT_MESSAGES_PER_MINUTE', 60),
        'files_per_hour' => env('CHAT_FILES_PER_HOUR', 20),
    ],

    'moderation' => [
        'enabled' => env('CHAT_MODERATION_ENABLED', false),
        'banned_words' => env('CHAT_BANNED_WORDS', ''),
        'auto_moderate' => env('CHAT_AUTO_MODERATE', false),
    ],

    'integrations' => [
        'user_status_sync' => env('CHAT_USER_STATUS_SYNC', true),
        'notification_center' => env('CHAT_NOTIFICATION_CENTER', true),
        'activity_log' => env('CHAT_ACTIVITY_LOG', true),
    ],

    'ui' => [
        'message_bubble_max_width' => env('CHAT_BUBBLE_MAX_WIDTH', '70%'),
        'sidebar_width' => env('CHAT_SIDEBAR_WIDTH', '320px'),
        'theme' => env('CHAT_THEME', 'default'),
        'language' => env('CHAT_LANGUAGE', 'en'),
    ],
];

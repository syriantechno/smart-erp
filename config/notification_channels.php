<?php

return [
    'default_channels' => ['database'],

    'channels' => [
        'database' => [
            'enabled' => true,
        ],
        'mail' => [
            'enabled' => env('NOTIFICATIONS_EMAIL_ENABLED', true),
        ],
        'sms' => [
            'enabled' => env('NOTIFICATIONS_SMS_ENABLED', false),
        ],
        'webpush' => [
            'enabled' => env('NOTIFICATIONS_WEBPUSH_ENABLED', false),
        ],
    ],

    'event_channels' => [
        'department.created' => ['database', 'mail'],
        'department.updated' => ['database'],
        'department.deleted' => ['database', 'mail'],

        'position.created' => ['database', 'mail'],
        'position.updated' => ['database'],
        'position.deleted' => ['database', 'mail'],

        'employee.created' => ['database', 'mail'],
        'employee.deleted' => ['database', 'mail'],

        'document.expiring' => ['database', 'mail'],
        'employee_document.expiring' => ['database', 'mail'],

        'approval.pending' => ['database', 'mail', 'sms'],
        'approval.approved' => ['database', 'mail'],
        'approval.rejected' => ['database', 'mail'],
    ],
];

<?php

return [
    'default_channels' => ['database'],

    'channels' => [
        'database' => [
            'enabled' => true,
        ],
        'mail' => [
            'enabled' => env('NOTIFICATIONS_EMAIL_ENABLED', false),
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

        // Task Extension Requests
        'task_extension.requested' => ['database', 'mail'],
        'task_extension.approved' => ['database', 'mail'],
        'task_extension.rejected' => ['database', 'mail'],

        // Task Notifications
        'task.assigned' => ['database', 'mail'],
        'task.started' => ['database'],
        'task.completed' => ['database', 'mail'],
        'task.updated' => ['database'],
        'task.commented' => ['database'],
        'task.liked' => ['database'],

        // HR Payroll Notifications
        'payroll.generated' => ['database', 'mail'],
        'payroll.approved' => ['database', 'mail'],
        'payroll.paid' => ['database', 'mail'],

        // HR Penalty Notifications
        'penalty.created' => ['database', 'mail'],
        'penalty.approved' => ['database', 'mail'],
        'penalty.rejected' => ['database'],

        // HR Advance Notifications
        'advance.requested' => ['database', 'mail'],
        'advance.approved' => ['database', 'mail'],
        'advance.rejected' => ['database'],
        'advance.disbursed' => ['database', 'mail'],

        // HR Leave Notifications
        'leave.requested' => ['database', 'mail'],
        'leave.approved' => ['database', 'mail'],
        'leave.rejected' => ['database'],

        // HR Attendance Notifications
        'attendance.late' => ['database'],
        'attendance.absent' => ['database', 'mail'],

        // Warehouse Notifications
        'material.low_stock' => ['database', 'mail'],
        'material_request.created' => ['database', 'mail'],
        'material_request.approved' => ['database', 'mail'],

        // Manufacturing Notifications
        'production.started' => ['database'],
        'production.completed' => ['database', 'mail'],
        'quality.failed' => ['database', 'mail'],

        // Accounting Notifications
        'invoice.created' => ['database'],
        'invoice.paid' => ['database', 'mail'],
        'payment.received' => ['database'],

        // HR Reward & Evaluation Notifications
        'reward.granted' => ['database', 'mail'],
        'evaluation.completed' => ['database', 'mail'],

        // Material & Warehouse Notifications
        'material.created' => ['database'],

        // Customer & Vendor Notifications
        'customer.created' => ['database'],
        'vendor.created' => ['database'],

        // Production Notifications
        'production.created' => ['database', 'mail'],

        // CRM Notifications
        'lead.created' => ['database', 'mail'],
        'lead.converted' => ['database', 'mail'],
        'opportunity.created' => ['database', 'mail'],
        'opportunity.won' => ['database', 'mail'],
        'opportunity.lost' => ['database'],

        // Recruitment Notifications
        'recruitment.applied' => ['database', 'mail'],
        'recruitment.shortlisted' => ['database', 'mail'],
        'recruitment.interviewed' => ['database'],
        'recruitment.hired' => ['database', 'mail'],

        // Contract Notifications
        'contract.created' => ['database', 'mail'],
        'contract.expiring' => ['database', 'mail'],
        'contract.renewed' => ['database', 'mail'],

        // Project Notifications
        'project.created' => ['database', 'mail'],
        'project.completed' => ['database', 'mail'],
        'project.delayed' => ['database', 'mail'],
        'project.assigned' => ['database', 'mail'],

        // Payment & Receipt Notifications
        'payment.created' => ['database'],
        'receipt.created' => ['database'],
    ],
];

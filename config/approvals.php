<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Approval System Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration options for the Approval System.
    | You can customize workflow rules, approval levels, notifications,
    | and other approval-related settings.
    |
    */

    'auto_approval' => [
        'enabled' => env('APPROVAL_AUTO_APPROVAL_ENABLED', true),
        'max_amount' => env('APPROVAL_AUTO_MAX_AMOUNT', 1000),
        'max_days' => env('APPROVAL_AUTO_MAX_DAYS', 3),
    ],

    'escalation' => [
        'enabled' => env('APPROVAL_ESCALATION_ENABLED', true),
        'days_without_action' => env('APPROVAL_ESCALATION_DAYS', 3),
        'notify_approver' => env('APPROVAL_ESCALATION_NOTIFY_APPROVER', true),
        'notify_requester' => env('APPROVAL_ESCALATION_NOTIFY_REQUESTER', false),
    ],

    'notifications' => [
        'enabled' => env('APPROVAL_NOTIFICATIONS_ENABLED', true),
        'email_enabled' => env('APPROVAL_EMAIL_NOTIFICATIONS', true),
        'in_app_enabled' => env('APPROVAL_IN_APP_NOTIFICATIONS', true),
        'sms_enabled' => env('APPROVAL_SMS_NOTIFICATIONS', false),
        'reminder_days' => explode(',', env('APPROVAL_REMINDER_DAYS', '1,3,7')),
    ],

    'workflows' => [
        'leave_request' => [
            'name' => 'Leave Request Approval',
            'levels' => [
                [
                    'level' => 1,
                    'role' => 'supervisor',
                    'condition' => 'days <= 3',
                    'auto_approve' => true,
                ],
                [
                    'level' => 2,
                    'role' => 'manager',
                    'condition' => 'days > 3 && days <= 14',
                ],
                [
                    'level' => 3,
                    'role' => 'hr_director',
                    'condition' => 'days > 14',
                ],
            ],
        ],

        'purchase_request' => [
            'name' => 'Purchase Request Approval',
            'levels' => [
                [
                    'level' => 1,
                    'role' => 'department_head',
                    'condition' => 'amount <= 1000',
                    'auto_approve' => true,
                ],
                [
                    'level' => 2,
                    'role' => 'finance_manager',
                    'condition' => 'amount <= 10000',
                ],
                [
                    'level' => 3,
                    'role' => 'ceo',
                    'condition' => 'amount > 10000',
                ],
            ],
        ],

        'expense_claim' => [
            'name' => 'Expense Claim Approval',
            'levels' => [
                [
                    'level' => 1,
                    'role' => 'supervisor',
                    'condition' => 'amount <= 500',
                    'auto_approve' => true,
                ],
                [
                    'level' => 2,
                    'role' => 'finance_manager',
                    'condition' => 'amount > 500',
                ],
            ],
        ],

        'loan_request' => [
            'name' => 'Loan Request Approval',
            'levels' => [
                [
                    'level' => 1,
                    'role' => 'supervisor',
                    'condition' => 'amount <= 5000',
                ],
                [
                    'level' => 2,
                    'role' => 'manager',
                    'condition' => 'amount <= 25000',
                ],
                [
                    'level' => 3,
                    'role' => 'finance_manager',
                    'condition' => 'amount > 25000',
                ],
            ],
        ],

        'overtime_request' => [
            'name' => 'Overtime Request Approval',
            'levels' => [
                [
                    'level' => 1,
                    'role' => 'supervisor',
                    'condition' => 'hours <= 10',
                    'auto_approve' => true,
                ],
                [
                    'level' => 2,
                    'role' => 'manager',
                    'condition' => 'hours > 10',
                ],
            ],
        ],

        'training_request' => [
            'name' => 'Training Request Approval',
            'levels' => [
                [
                    'level' => 1,
                    'role' => 'supervisor',
                    'condition' => 'cost <= 1000',
                    'auto_approve' => true,
                ],
                [
                    'level' => 2,
                    'role' => 'hr_director',
                    'condition' => 'cost > 1000',
                ],
            ],
        ],

        'equipment_request' => [
            'name' => 'Equipment Request Approval',
            'levels' => [
                [
                    'level' => 1,
                    'role' => 'department_head',
                    'condition' => 'cost <= 2000',
                    'auto_approve' => true,
                ],
                [
                    'level' => 2,
                    'role' => 'it_manager',
                    'condition' => 'type == "IT" && cost > 2000',
                ],
                [
                    'level' => 3,
                    'role' => 'procurement_manager',
                    'condition' => 'type != "IT"',
                ],
            ],
        ],
    ],

    'request_types' => [
        'leave_request' => [
            'label' => 'Leave Request',
            'icon' => 'calendar',
            'color' => '#3b82f6',
            'fields' => ['start_date', 'end_date', 'reason', 'leave_type'],
            'requires_attachment' => false,
        ],
        'purchase_request' => [
            'label' => 'Purchase Request',
            'icon' => 'shopping-cart',
            'color' => '#22c55e',
            'fields' => ['amount', 'description', 'vendor', 'justification'],
            'requires_attachment' => true,
        ],
        'expense_claim' => [
            'label' => 'Expense Claim',
            'icon' => 'receipt',
            'color' => '#f59e0b',
            'fields' => ['amount', 'category', 'description', 'date'],
            'requires_attachment' => true,
        ],
        'loan_request' => [
            'label' => 'Loan Request',
            'icon' => 'dollar-sign',
            'color' => '#8b5cf6',
            'fields' => ['amount', 'purpose', 'repayment_period', 'monthly_payment'],
            'requires_attachment' => false,
        ],
        'overtime_request' => [
            'label' => 'Overtime Request',
            'icon' => 'clock',
            'color' => '#ec4899',
            'fields' => ['date', 'hours', 'reason', 'project'],
            'requires_attachment' => false,
        ],
        'training_request' => [
            'label' => 'Training Request',
            'icon' => 'graduation-cap',
            'color' => '#84cc16',
            'fields' => ['course_name', 'provider', 'cost', 'duration', 'justification'],
            'requires_attachment' => false,
        ],
        'equipment_request' => [
            'label' => 'Equipment Request',
            'icon' => 'monitor',
            'color' => '#06b6d4',
            'fields' => ['equipment_type', 'cost', 'justification', 'urgency'],
            'requires_attachment' => true,
        ],
        'other' => [
            'label' => 'Other Request',
            'icon' => 'file-text',
            'color' => '#6b7280',
            'fields' => ['description', 'amount', 'justification'],
            'requires_attachment' => false,
        ],
    ],

    'priorities' => [
        'low' => [
            'label' => 'Low',
            'color' => '#6b7280',
            'escalation_days' => 7,
        ],
        'normal' => [
            'label' => 'Normal',
            'color' => '#3b82f6',
            'escalation_days' => 3,
        ],
        'high' => [
            'label' => 'High',
            'color' => '#f59e0b',
            'escalation_days' => 1,
        ],
        'urgent' => [
            'label' => 'Urgent',
            'color' => '#ef4444',
            'escalation_days' => 0,
        ],
    ],

    'max_attachment_size' => env('APPROVAL_MAX_ATTACHMENT_SIZE', 5120), // KB

    'allowed_attachment_types' => ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'xls', 'xlsx'],

    'storage' => [
        'disk' => env('APPROVAL_STORAGE_DISK', 'public'),
        'path' => env('APPROVAL_STORAGE_PATH', 'approval-attachments'),
    ],

    'audit' => [
        'enabled' => env('APPROVAL_AUDIT_ENABLED', true),
        'log_actions' => ['submitted', 'approved', 'rejected', 'commented', 'forwarded', 'escalated'],
        'retention_days' => env('APPROVAL_AUDIT_RETENTION', 365),
    ],

    'templates' => [
        'enabled' => env('APPROVAL_TEMPLATES_ENABLED', true),
        'auto_generate_documents' => env('APPROVAL_AUTO_GENERATE_DOCS', true),
        'document_templates' => [
            'leave_request' => 'leave_request_template.docx',
            'purchase_request' => 'purchase_request_template.docx',
            'expense_claim' => 'expense_claim_template.docx',
        ],
    ],

    'dashboard' => [
        'stats_cache_ttl' => env('APPROVAL_STATS_CACHE_TTL', 300), // seconds
        'recent_requests_limit' => env('APPROVAL_RECENT_LIMIT', 10),
        'pending_alert_threshold' => env('APPROVAL_PENDING_THRESHOLD', 5),
    ],

    'email_templates' => [
        'request_submitted' => [
            'subject' => 'New Approval Request: {title}',
            'template' => 'emails.approval.request_submitted',
        ],
        'request_approved' => [
            'subject' => 'Approval Request Approved: {title}',
            'template' => 'emails.approval.request_approved',
        ],
        'request_rejected' => [
            'subject' => 'Approval Request Rejected: {title}',
            'template' => 'emails.approval.request_rejected',
        ],
        'escalation_reminder' => [
            'subject' => 'Urgent: Pending Approval Request',
            'template' => 'emails.approval.escalation_reminder',
        ],
    ],
];

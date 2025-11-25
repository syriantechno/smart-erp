<?php

namespace App\Main;

class SideMenu
{
    /**
     * List of side menu items.
     */
    public static function menu(): array
    {
        return [
            'dashboard' => [
                'icon' => 'home',
                'title' => __('menu.dashboard'),
                'sub_menu' => [
                    'dashboard-overview-1' => [
                        'icon' => 'activity',
                        'route_name' => 'dashboard-overview-1',
                        'title' => __('menu.general')
                    ],
                    'dashboard-overview-2' => [
                        'icon' => 'activity',
                        'route_name' => 'dashboard-overview-2',
                        'title' => __('menu.projects')
                    ],
                    'dashboard-overview-3' => [
                        'icon' => 'activity',
                        'route_name' => 'dashboard-overview-3',
                        'title' => __('menu.accounting')
                    ],
                    'dashboard-overview-4' => [
                        'icon' => 'activity',
                        'route_name' => 'dashboard-overview-4',
                        'title' => __('menu.hr')
                    ]
                ]
            ],
            'crm' => [
                'icon' => 'building-2',
                'title' => __('menu.crm'),
                'sub_menu' => [
                    'crm-contacts' => [
                        'icon' => 'user-circle-2',
                        'title' => __('menu.contacts'),
                        'route_name' => 'crm.contacts.index',
                    ],
                    'crm-leads' => [
                        'icon' => 'sparkles',
                        'title' => __('menu.leads'),
                        'route_name' => 'crm.leads.index',
                    ],
                    'crm-opportunities' => [
                        'icon' => 'target',
                        'title' => __('menu.opportunities'),
                        'route_name' => 'crm.opportunities.index',
                    ],
                    'crm-activities' => [
                        'icon' => 'calendar-clock',
                        'title' => __('menu.activities'),
                        'route_name' => 'crm.activities.index',
                    ],
                ],
            ],
            'hr' => [
                'icon' => 'users',
                'title' => __('menu.human_resources'),
                'sub_menu' => [
                    'departments' => [
                        'icon' => 'layers',
                        'title' => __('menu.departments'),
                        'route_name' => 'hr.departments.index'
                    ],
                    'positions' => [
                        'icon' => 'briefcase',
                        'title' => __('menu.positions'),
                        'route_name' => 'hr.positions.index'
                    ],
                    'employees' => [
                        'icon' => 'users',
                        'title' => __('menu.employees'),
                        'route_name' => 'hr.employees.index'
                    ],
                    'employee-performance' => [
                        'icon' => 'star',
                        'title' => __('menu.performance'),
                        'route_name' => 'hr.employee-evaluations.index',
                    ],
                    'employee-rewards' => [
                        'icon' => 'award',
                        'title' => __('menu.rewards'),
                        'route_name' => 'hr.employee-rewards.index',
                    ],
                    'attendance' => [
                        'icon' => 'clock',
                        'title' => __('menu.attendance'),
                        'route_name' => 'hr.attendance.index'
                    ],
                    'shifts' => [
                        'icon' => 'watch',
                        'title' => __('menu.shifts'),
                        'route_name' => 'hr.shifts.index'
                    ],
                    'leave' => [
                        'icon' => 'calendar',
                        'title' => __('menu.leave'),
                        'route_name' => 'hr.leave.index'
                    ],
                    'payroll' => [
                        'icon' => 'dollar-sign',
                        'title' => __('menu.payroll'),
                        'route_name' => 'hr.payroll.index'
                    ],
                    'recruitment' => [
                        'icon' => 'user-plus',
                        'title' => __('menu.recruitment'),
                        'route_name' => 'hr.recruitment.index'
                    ]
                ]
            ],
            'approval-system' => [
                'icon' => 'check-circle',
                'title' => __('menu.approval_system'),
                'sub_menu' => [
                    'approval-system-requests' => [
                        'icon' => 'list-checks',
                        'route_name' => 'approval-system.index',
                        'title' => __('menu.requests'),
                    ],
                    'approval-system-templates' => [
                        'icon' => 'layers',
                        'route_name' => 'approval-system.templates.index',
                        'title' => __('menu.templates'),
                    ],
                ],
            ],
            'work' => [
                'icon' => 'briefcase',
                'title' => __('menu.work_management'),
                'sub_menu' => [
                    'projects' => [
                        'icon' => 'folder',
                        'route_name' => 'project-management.projects.index',
                        'title' => __('menu.projects')
                    ],
                    'tasks' => [
                        'icon' => 'check-square',
                        'route_name' => 'tasks.index',
                        'title' => __('menu.tasks')
                    ],
                    'estimates' => [
                        'icon' => 'calculator',
                        'route_name' => 'work.estimates.index',
                        'title' => __('menu.estimates')
                    ],
                    'contracts' => [
                        'icon' => 'file-signature',
                        'route_name' => 'work.contracts.index',
                        'title' => __('menu.contracts')
                    ]
                ]
            ],
            'warehouse' => [
                'icon' => 'package',
                'title' => __('menu.warehouse'),
                'sub_menu' => [
                    'categories' => [
                        'icon' => 'tag',
                        'route_name' => 'warehouse.categories.index',
                        'title' => __('menu.categories')
                    ],
                    'warehouses' => [
                        'icon' => 'home',
                        'route_name' => 'warehouse.warehouses.index',
                        'title' => __('menu.warehouses')
                    ],
                    'materials' => [
                        'icon' => 'box',
                        'route_name' => 'warehouse.materials.index',
                        'title' => __('menu.materials')
                    ],
                    'inventory' => [
                        'icon' => 'clipboard-list',
                        'route_name' => 'warehouse.inventory.index',
                        'title' => __('menu.inventory')
                    ],
                    'material-requests' => [
                        'icon' => 'file-text',
                        'route_name' => 'warehouse.material-requests.index',
                        'title' => __('menu.material_requests')
                    ],
                    'purchase-orders' => [
                        'icon' => 'shopping-cart',
                        'route_name' => 'warehouse.purchase-orders.index',
                        'title' => __('menu.purchase_orders')
                    ],
                    'sale-orders' => [
                        'icon' => 'truck',
                        'route_name' => 'warehouse.sale-orders.index',
                        'title' => __('menu.sale_orders')
                    ],
                    'delivery-orders' => [
                        'icon' => 'send',
                        'route_name' => 'warehouse.delivery-orders.index',
                        'title' => __('menu.delivery_orders')
                    ]
                ]
            ],
            'supplier' => [
                'icon' => 'truck',
                'title' => __('menu.suppliers'),
                'sub_menu' => [
                    'supplier-vendors' => [
                        'icon' => 'building-2',
                        'route_name' => 'supplier.vendors.index',
                        'title' => __('menu.vendors'),
                    ],
                ],
            ],
            'customers' => [
                'icon' => 'users',
                'title' => __('menu.customers'),
                'sub_menu' => [
                    'customers-index' => [
                        'icon' => 'user-plus',
                        'route_name' => 'customers.index',
                        'title' => __('menu.all_customers'),
                    ],
                ],
            ],
            'accounting' => [
                'icon' => 'file-text',
                'title' => __('menu.accounts'),
                'sub_menu' => [
                    'accounting-chart-of-accounts' => [
                        'icon' => 'layers',
                        'route_name' => 'accounting.chart-of-accounts.index',
                        'title' => __('menu.chart_of_accounts'),
                    ],
                    'accounting-journal-entries' => [
                        'icon' => 'book-open',
                        'route_name' => 'accounting.journal-entries.index',
                        'title' => __('menu.journal_entries'),
                    ],
                    'accounting-invoices' => [
                        'icon' => 'file-text',
                        'route_name' => 'accounting.invoices.index',
                        'title' => __('menu.invoices'),
                    ],
                    'accounting-payment-vouchers' => [
                        'icon' => 'corner-down-right',
                        'route_name' => 'accounting.payment-vouchers.index',
                        'title' => __('menu.payment_vouchers'),
                    ],
                    'accounting-receipt-vouchers' => [
                        'icon' => 'corner-up-right',
                        'route_name' => 'accounting.receipt-vouchers.index',
                        'title' => __('menu.receipt_vouchers'),
                    ],
                    'accounting-cash-boxes' => [
                        'icon' => 'wallet',
                        'route_name' => 'accounting.cash-boxes.index',
                        'title' => __('menu.cash_boxes'),
                    ],
                    'accounting-bank-accounts' => [
                        'icon' => 'banknote',
                        'route_name' => 'accounting.bank-accounts.index',
                        'title' => __('menu.bank_accounts'),
                    ],
                ],
            ],
            'settings' => [
                'icon' => 'settings',
                'route_name' => 'settings.index',
                'title' => __('menu.settings')
            ],
            'manufacturing' => [
                'icon' => 'settings',
                'route_name' => 'manufacturing.index',
                'title' => __('menu.manufacturing')
            ],
            'electronic-mail' => [
                'icon' => 'mail',
                'route_name' => 'electronic-mail.index',
                'title' => __('menu.electronic_mail')
            ],
            'chat' => [
                'icon' => 'message-square',
                'route_name' => 'chat.index',
                'title' => __('menu.internal_chat')
            ],
            'documents' => [
                'icon' => 'file-text',
                'route_name' => 'documents.index',
                'title' => __('menu.document_management')
            ],
            'ai' => [
                'icon' => 'bot',
                'route_name' => 'ai.index',
                'title' => __('menu.ai_assistant')
            ],
            'e-commerce' => [
                'icon' => 'shopping-bag',
                'title' => 'E-Commerce',
                'sub_menu' => [
                    'categories' => [
                        'icon' => 'activity',
                        'route_name' => 'categories',
                        'title' => 'Categories'
                    ],
                    'add-product' => [
                        'icon' => 'activity',
                        'route_name' => 'add-product',
                        'title' => 'Add Product',
                    ],
                    'products' => [
                        'icon' => 'activity',
                        'title' => 'Products',
                        'sub_menu' => [
                            'product-list' => [
                                'icon' => 'zap',
                                'route_name' => 'product-list',
                                'title' => 'Product List'
                            ],
                            'product-grid' => [
                                'icon' => 'zap',
                                'route_name' => 'product-grid',
                                'title' => 'Product Grid'
                            ]
                        ]
                    ],
                    'transactions' => [
                        'icon' => 'activity',
                        'title' => 'Transactions',
                        'sub_menu' => [
                            'transaction-list' => [
                                'icon' => 'zap',
                                'route_name' => 'transaction-list',
                                'title' => 'Transaction List'
                            ],
                            'transaction-detail' => [
                                'icon' => 'zap',
                                'route_name' => 'transaction-detail',
                                'title' => 'Transaction Detail'
                            ]
                        ]
                    ],
                    'sellers' => [
                        'icon' => 'activity',
                        'title' => 'Sellers',
                        'sub_menu' => [
                            'seller-list' => [
                                'icon' => 'zap',
                                'route_name' => 'seller-list',
                                'title' => 'Seller List'
                            ],
                            'seller-detail' => [
                                'icon' => 'zap',
                                'route_name' => 'seller-detail',
                                'title' => 'Seller Detail'
                            ]
                        ]
                    ],
                    'reviews' => [
                        'icon' => 'activity',
                        'route_name' => 'reviews',
                        'title' => 'Reviews'
                    ],
                ]
            ],
            'inbox' => [
                'icon' => 'inbox',
                'route_name' => 'inbox',
                'title' => 'Inbox'
            ],
            'file-manager' => [
                'icon' => 'hard-drive',
                'route_name' => 'file-manager',
                'title' => 'File Manager'
            ],
            'point-of-sale' => [
                'icon' => 'credit-card',
                'route_name' => 'point-of-sale',
                'title' => 'Point of Sale'
            ],
            'post' => [
                'icon' => 'file-text',
                'route_name' => 'post',
                'title' => 'Post'
            ],
            'calendar' => [
                'icon' => 'calendar',
                'route_name' => 'calendar',
                'title' => 'Calendar'
            ],
            'divider',
            'crud' => [
                'icon' => 'edit',
                'title' => 'Crud',
                'sub_menu' => [
                    'crud-data-list' => [
                        'icon' => 'activity',
                        'route_name' => 'crud-data-list',
                        'title' => 'Data List'
                    ],
                    'crud-form' => [
                        'icon' => 'activity',
                        'route_name' => 'crud-form',
                        'title' => 'Form'
                    ]
                ]
            ],
            'users' => [
                'icon' => 'users',
                'title' => 'Users',
                'sub_menu' => [
                    'users-layout-1' => [
                        'icon' => 'activity',
                        'route_name' => 'users-layout-1',
                        'title' => 'Layout 1'
                    ],
                    'users-layout-2' => [
                        'icon' => 'activity',
                        'route_name' => 'users-layout-2',
                        'title' => 'Layout 2'
                    ],
                    'users-layout-3' => [
                        'icon' => 'activity',
                        'route_name' => 'users-layout-3',
                        'title' => 'Layout 3'
                    ]
                ]
            ],
            'profile' => [
                'icon' => 'trello',
                'title' => 'Profile',
                'sub_menu' => [
                    'profile-overview-1' => [
                        'icon' => 'activity',
                        'route_name' => 'profile-overview-1',
                        'title' => 'Overview 1'
                    ],
                    'profile-overview-2' => [
                        'icon' => 'activity',
                        'route_name' => 'profile-overview-2',
                        'title' => 'Overview 2'
                    ],
                    'profile-overview-3' => [
                        'icon' => 'activity',
                        'route_name' => 'profile-overview-3',
                        'title' => 'Overview 3'
                    ]
                ]
            ],
            'pages' => [
                'icon' => 'layout',
                'title' => 'Pages',
                'sub_menu' => [
                    'wizards' => [
                        'icon' => 'activity',
                        'title' => 'Wizards',
                        'sub_menu' => [
                            'wizard-layout-1' => [
                                'icon' => 'zap',
                                'route_name' => 'wizard-layout-1',
                                'title' => 'Layout 1'
                            ],
                            'wizard-layout-2' => [
                                'icon' => 'zap',
                                'route_name' => 'wizard-layout-2',
                                'title' => 'Layout 2'
                            ],
                            'wizard-layout-3' => [
                                'icon' => 'zap',
                                'route_name' => 'wizard-layout-3',
                                'title' => 'Layout 3'
                            ]
                        ]
                    ],
                    'blog' => [
                        'icon' => 'activity',
                        'title' => 'Blog',
                        'sub_menu' => [
                            'blog-layout-1' => [
                                'icon' => 'zap',
                                'route_name' => 'blog-layout-1',
                                'title' => 'Layout 1'
                            ],
                            'blog-layout-2' => [
                                'icon' => 'zap',
                                'route_name' => 'blog-layout-2',
                                'title' => 'Layout 2'
                            ],
                            'blog-layout-3' => [
                                'icon' => 'zap',
                                'route_name' => 'blog-layout-3',
                                'title' => 'Layout 3'
                            ]
                        ]
                    ],
                    'pricing' => [
                        'icon' => 'activity',
                        'title' => 'Pricing',
                        'sub_menu' => [
                            'pricing-layout-1' => [
                                'icon' => 'zap',
                                'route_name' => 'pricing-layout-1',
                                'title' => 'Layout 1'
                            ],
                            'pricing-layout-2' => [
                                'icon' => 'zap',
                                'route_name' => 'pricing-layout-2',
                                'title' => 'Layout 2'
                            ]
                        ]
                    ],
                    'invoice' => [
                        'icon' => 'activity',
                        'title' => 'Invoice',
                        'sub_menu' => [
                            'invoice-layout-1' => [
                                'icon' => 'zap',
                                'route_name' => 'invoice-layout-1',
                                'title' => 'Layout 1'
                            ],
                            'invoice-layout-2' => [
                                'icon' => 'zap',
                                'route_name' => 'invoice-layout-2',
                                'title' => 'Layout 2'
                            ]
                        ]
                    ],
                    'faq' => [
                        'icon' => 'activity',
                        'title' => 'FAQ',
                        'sub_menu' => [
                            'faq-layout-1' => [
                                'icon' => 'zap',
                                'route_name' => 'faq-layout-1',
                                'title' => 'Layout 1'
                            ],
                            'faq-layout-2' => [
                                'icon' => 'zap',
                                'route_name' => 'faq-layout-2',
                                'title' => 'Layout 2'
                            ],
                            'faq-layout-3' => [
                                'icon' => 'zap',
                                'route_name' => 'faq-layout-3',
                                'title' => 'Layout 3'
                            ]
                        ]
                    ],
                    'login' => [
                        'icon' => 'activity',
                        'route_name' => 'login',
                        'title' => 'Login'
                    ],
                    'register' => [
                        'icon' => 'activity',
                        'route_name' => 'register',
                        'title' => 'Register'
                    ],
                    'error-page' => [
                        'icon' => 'activity',
                        'route_name' => 'error-page',
                        'title' => 'Error Page'
                    ],
                    'update-profile' => [
                        'icon' => 'activity',
                        'route_name' => 'update-profile',
                        'title' => 'Update profile'
                    ],
                    'change-password' => [
                        'icon' => 'activity',
                        'route_name' => 'change-password',
                        'title' => 'Change Password'
                    ]
                ]
            ],
            'divider',
            'components' => [
                'icon' => 'inbox',
                'title' => 'Components',
                'sub_menu' => [
                    'grid' => [
                        'icon' => 'activity',
                        'title' => 'Grid',
                        'sub_menu' => [
                            'regular-table' => [
                                'icon' => 'zap',
                                'route_name' => 'regular-table',
                                'title' => 'Regular Table'
                            ],
                            'tabulator' => [
                                'icon' => 'zap',
                                'route_name' => 'tabulator',
                                'title' => 'Tabulator'
                            ]
                        ]
                    ],
                    'overlay' => [
                        'icon' => 'activity',
                        'title' => 'Overlay',
                        'sub_menu' => [
                            'modal' => [
                                'icon' => 'zap',
                                'route_name' => 'modal',
                                'title' => 'Modal'
                            ],
                            'slide-over' => [
                                'icon' => 'zap',
                                'route_name' => 'slide-over',
                                'title' => 'Slide Over'
                            ],
                            'notification' => [
                                'icon' => 'zap',
                                'route_name' => 'notification',
                                'title' => 'Notification'
                            ],
                        ]
                    ],
                    'tab' => [
                        'icon' => 'activity',
                        'route_name' => 'tab',
                        'title' => 'Tab'
                    ],
                    'accordion' => [
                        'icon' => 'activity',
                        'route_name' => 'accordion',
                        'title' => 'Accordion'
                    ],
                    'button' => [
                        'icon' => 'activity',
                        'route_name' => 'button',
                        'title' => 'Button'
                    ],
                    'alert' => [
                        'icon' => 'activity',
                        'route_name' => 'alert',
                        'title' => 'Alert'
                    ],
                    'progress-bar' => [
                        'icon' => 'activity',
                        'route_name' => 'progress-bar',
                        'title' => 'Progress Bar'
                    ],
                    'tooltip' => [
                        'icon' => 'activity',
                        'route_name' => 'tooltip',
                        'title' => 'Tooltip'
                    ],
                    'dropdown' => [
                        'icon' => 'activity',
                        'route_name' => 'dropdown',
                        'title' => 'Dropdown'
                    ],
                    'typography' => [
                        'icon' => 'activity',
                        'route_name' => 'typography',
                        'title' => 'Typography'
                    ],
                    'icon' => [
                        'icon' => 'activity',
                        'route_name' => 'icon',
                        'title' => 'Icon'
                    ],
                    'loading-icon' => [
                        'icon' => 'activity',
                        'route_name' => 'loading-icon',
                        'title' => 'Loading Icon'
                    ]
                ]
            ],
            'forms' => [
                'icon' => 'sidebar',
                'title' => 'Forms',
                'sub_menu' => [
                    'regular-form' => [
                        'icon' => 'activity',
                        'route_name' => 'regular-form',
                        'title' => 'Regular Form'
                    ],
                    'datepicker' => [
                        'icon' => 'activity',
                        'route_name' => 'datepicker',
                        'title' => 'Datepicker'
                    ],
                    'tom-select' => [
                        'icon' => 'activity',
                        'route_name' => 'tom-select',
                        'title' => 'Tom Select'
                    ],
                    'file-upload' => [
                        'icon' => 'activity',
                        'route_name' => 'file-upload',
                        'title' => 'File Upload'
                    ],
                    'wysiwyg-editor' => [
                        'icon' => 'activity',
                        'title' => 'Wysiwyg Editor',
                        'sub_menu' => [
                            'wysiwyg-editor-classic' => [
                                'icon' => 'zap',
                                'route_name' => 'wysiwyg-editor-classic',
                                'title' => 'Classic'
                            ],
                            'wysiwyg-editor-inline' => [
                                'icon' => 'zap',
                                'route_name' => 'wysiwyg-editor-inline',
                                'title' => 'Inline'
                            ],
                            'wysiwyg-editor-balloon' => [
                                'icon' => 'zap',
                                'route_name' => 'wysiwyg-editor-balloon',
                                'title' => 'Balloon'
                            ],
                            'wysiwyg-editor-balloon-block' => [
                                'icon' => 'zap',
                                'route_name' => 'wysiwyg-editor-balloon-block',
                                'title' => 'Balloon Block'
                            ],
                            'wysiwyg-editor-document' => [
                                'icon' => 'zap',
                                'route_name' => 'wysiwyg-editor-document',
                                'title' => 'Document'
                            ],
                        ]
                    ],
                    'validation' => [
                        'icon' => 'activity',
                        'route_name' => 'validation',
                        'title' => 'Validation'
                    ]
                ]
            ],
            'widgets' => [
                'icon' => 'hard-drive',
                'title' => 'Widgets',
                'sub_menu' => [
                    'chart' => [
                        'icon' => 'activity',
                        'route_name' => 'chart',
                        'title' => 'Chart'
                    ],
                    'slider' => [
                        'icon' => 'activity',
                        'route_name' => 'slider',
                        'title' => 'Slider'
                    ],
                    'image-zoom' => [
                        'icon' => 'activity',
                        'route_name' => 'image-zoom',
                        'title' => 'Image Zoom'
                    ]
                ]
            ]
        ];
    }
}

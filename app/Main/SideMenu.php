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
                'title' => 'Dashboard',
                'sub_menu' => [
                    'dashboard-overview-1' => [
                        'icon' => 'activity',
                        'route_name' => 'dashboard-overview-1',
                        'title' => 'Overview 1'
                    ],
                    'dashboard-overview-2' => [
                        'icon' => 'activity',
                        'route_name' => 'dashboard-overview-2',
                        'title' => 'Overview 2'
                    ],
                    'dashboard-overview-3' => [
                        'icon' => 'activity',
                        'route_name' => 'dashboard-overview-3',
                        'title' => 'Overview 3'
                    ],
                    'dashboard-overview-4' => [
                        'icon' => 'activity',
                        'route_name' => 'dashboard-overview-4',
                        'title' => 'Overview 4'
                    ]
                ]
            ],
            'settings' => [
                'icon' => 'settings',
                'route_name' => 'settings.index',
                'title' => 'Settings'
            ],
            'hr' => [
                'icon' => 'users',
                'title' => 'Human Resources',
                'sub_menu' => [
                    'departments' => [
                        'icon' => 'layers',
                        'title' => 'Departments',
                        'route_name' => 'hr.departments.index'
                    ],
                    'positions' => [
                        'icon' => 'briefcase',
                        'title' => 'Positions',
                        'route_name' => 'hr.positions.index'
                    ],
                    'employees' => [
                        'icon' => 'users',
                        'title' => 'Employees',
                        'route_name' => 'hr.employees.index'
                    ],
                    'attendance' => [
                        'icon' => 'clock',
                        'title' => 'Attendance',
                        'route_name' => 'hr.attendance.index'
                    ],
                    'shifts' => [
                        'icon' => 'watch',
                        'title' => 'Shifts',
                        'route_name' => 'hr.shifts.index'
                    ],
                    'leave' => [
                        'icon' => 'calendar',
                        'title' => 'Leave Management',
                        'route_name' => 'hr.leave.index'
                    ],
                    'payroll' => [
                        'icon' => 'dollar-sign',
                        'title' => 'Payroll',
                        'route_name' => 'hr.payroll.index'
                    ],
                    'recruitment' => [
                        'icon' => 'user-plus',
                        'title' => 'Recruitment',
                        'route_name' => 'hr.recruitment.index'
                    ],
                    'project-management' => [
                        'icon' => 'folder',
                        'title' => 'Project Management',
                        'route_name' => 'project-management.projects.index'
                    ]
                ]
            ],
            'accounting' => [
                'icon' => 'file-text',
                'route_name' => 'accounting.chart-of-accounts.index',
                'title' => 'Accounting'
            ],
            'manufacturing' => [
                'icon' => 'settings',
                'route_name' => 'manufacturing.index',
                'title' => 'Manufacturing'
            ],
            'projects-manager' => [
                'icon' => 'folder',
                'route_name' => 'project-management.projects.index',
                'title' => 'Projects Manager'
            ],
            'warehouse' => [
                'icon' => 'package',
                'title' => 'Warehouse',
                'sub_menu' => [
                    'categories' => [
                        'icon' => 'tag',
                        'route_name' => 'warehouse.categories.index',
                        'title' => 'Categories'
                    ],
                    'warehouses' => [
                        'icon' => 'home',
                        'route_name' => 'warehouse.warehouses.index',
                        'title' => 'Warehouses'
                    ],
                    'materials' => [
                        'icon' => 'box',
                        'route_name' => 'warehouse.materials.index',
                        'title' => 'Materials'
                    ],
                    'inventory' => [
                        'icon' => 'clipboard-list',
                        'route_name' => 'warehouse.inventory.index',
                        'title' => 'Inventory'
                    ],
                    'purchase-requests' => [
                        'icon' => 'file-text',
                        'route_name' => 'warehouse.purchase-requests.index',
                        'title' => 'Purchase Requests'
                    ],
                    'purchase-orders' => [
                        'icon' => 'shopping-cart',
                        'route_name' => 'warehouse.purchase-orders.index',
                        'title' => 'Purchase Orders'
                    ],
                    'sale-orders' => [
                        'icon' => 'truck',
                        'route_name' => 'warehouse.sale-orders.index',
                        'title' => 'Sale Orders'
                    ],
                    'delivery-orders' => [
                        'icon' => 'send',
                        'route_name' => 'warehouse.delivery-orders.index',
                        'title' => 'Delivery Orders'
                    ]
                ]
            ],
            'tasks' => [
                'icon' => 'check-square',
                'route_name' => 'tasks.index',
                'title' => 'Tasks Management'
            ],
            'electronic-mail' => [
                'icon' => 'mail',
                'route_name' => 'electronic-mail.index',
                'title' => 'Electronic Mail'
            ],
            'approval-system' => [
                'icon' => 'check-circle',
                'route_name' => 'approval-system.index',
                'title' => 'Approval System'
            ],
            'chat' => [
                'icon' => 'message-square',
                'route_name' => 'chat.index',
                'title' => 'Internal Chat'
            ],
            'documents' => [
                'icon' => 'file-text',
                'route_name' => 'documents.index',
                'title' => 'Document Management'
            ],
            'ai' => [
                'icon' => 'bot',
                'route_name' => 'ai.index',
                'title' => 'AI Assistant'
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

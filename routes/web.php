<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\Setting\PageController;
use App\Http\Controllers\Setting\LayoutController;
use App\Http\Controllers\Setting\SettingsController;
use App\Http\Controllers\Setting\NotificationController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Mail\UserMailAccountController;
use App\Http\Controllers\CRM\CompanyController;
use App\Http\Controllers\CRM\ContactController;
use App\Http\Controllers\CRM\LeadController;
use App\Http\Controllers\CRM\OpportunityController;
use App\Http\Controllers\CRM\ActivityController;
use App\Http\Controllers\CRM\FileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
            ->middleware('auth')
            ->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    // Settings Routes
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::post('/settings/appearance', [SettingsController::class, 'updateAppearance'])->name('settings.appearance.update');
    Route::put('/settings/appearance', [SettingsController::class, 'updateAppearance']);
    Route::post('/settings/prefix', [SettingsController::class, 'updatePrefix'])->name('settings.prefix.update');
    Route::post('/settings/permissions/roles/{role}', [SettingsController::class, 'updateRolePermissions'])->name('settings.permissions.roles.update');
    Route::post('/settings/company', [SettingsController::class, 'updateCompany'])->name('settings.company.update');
    Route::post('/settings/attendance', [SettingsController::class, 'updateAttendance'])->name('settings.attendance.update');
    Route::post('/settings/notifications', [SettingsController::class, 'updateNotifications'])->name('settings.notifications.update');
    Route::post('/settings/ai', [SettingsController::class, 'updateAiSettings'])->name('settings.ai.update');

    // Notifications API
    Route::get('notifications/recent', [NotificationController::class, 'recent'])->name('notifications.recent');
    Route::get('notifications/unread-count', [NotificationController::class, 'unreadCount'])->name('notifications.unread-count');

    // Global Search API
    Route::get('search', [App\Http\Controllers\SearchController::class, 'search'])->name('search');

    // Calendar
    Route::get('calendar', [CalendarController::class, 'index'])->name('calendar');

    // HR Routes
    Route::prefix('hr')->name('hr.')->group(function () {
        // Departments
        Route::resource('departments', 'App\Http\Controllers\HR\DepartmentController')
            ->except(['show']);
            
        // DataTable route for departments
        Route::get('departments/datatable', [App\Http\Controllers\HR\DepartmentController::class, 'datatable'])
            ->name('departments.datatable');
        Route::post('departments/export-pdf', [App\Http\Controllers\HR\DepartmentController::class, 'exportPdf'])
            ->name('departments.export-pdf');
        Route::get('departments/export-excel', [App\Http\Controllers\HR\DepartmentController::class, 'exportExcel'])
            ->name('departments.export-excel');

        // Preview generated department code
        Route::get('departments/preview-code', [App\Http\Controllers\HR\DepartmentController::class, 'previewCode'])
            ->name('departments.preview-code');
            
        // API for departments by company
        Route::get('departments/api/company/{company}', [App\Http\Controllers\HR\DepartmentController::class, 'getByCompany'])
            ->name('departments.api.by-company');
            
        // Positions
        Route::get('positions/datatable', [App\Http\Controllers\HR\PositionController::class, 'datatable'])
            ->name('positions.datatable');
        Route::get('positions/preview-code', [App\Http\Controllers\HR\PositionController::class, 'previewCode'])
            ->name('positions.preview-code');
        Route::resource('positions', 'App\Http\Controllers\HR\PositionController')
            ->only(['index', 'store', 'update', 'destroy']);
            
        // API for positions by department
        Route::get('positions/api/department/{department}', [App\Http\Controllers\HR\PositionController::class, 'getPositionsByDepartment'])
            ->name('positions.api.by-department');
            
        // Employees
        Route::get('employees/datatable', [App\Http\Controllers\HR\EmployeeController::class, 'datatable'])
            ->name('employees.datatable');
        Route::get('employees/preview-code', [App\Http\Controllers\HR\EmployeeController::class, 'previewCode'])
            ->name('employees.preview-code');
        Route::get('employees/companies', [App\Http\Controllers\HR\EmployeeController::class, 'getCompanies'])
            ->name('employees.companies');
        Route::get('employees/positions/department', [App\Http\Controllers\HR\EmployeeController::class, 'getPositionsByDepartment'])
            ->name('employees.positions.by-department');
        Route::get('employees/test-data', [App\Http\Controllers\HR\EmployeeController::class, 'testData'])
            ->name('employees.test-data');
        Route::post('employees/import', [App\Http\Controllers\HR\EmployeeController::class, 'import'])
            ->name('employees.import');
        Route::resource('employees', 'App\Http\Controllers\HR\EmployeeController');
        Route::post('employees/export-pdf', [\App\Http\Controllers\HR\EmployeeController::class, 'exportPdf'])
            ->name('employees.export-pdf');
        
        // Employee evaluations & rewards overview
        Route::get('employee-evaluations', [App\Http\Controllers\HR\EmployeeEvaluationController::class, 'index'])
            ->name('employee-evaluations.index');
        Route::post('employee-evaluations', [App\Http\Controllers\HR\EmployeeEvaluationController::class, 'store'])
            ->name('employee-evaluations.store');
        Route::get('employee-rewards', [App\Http\Controllers\HR\EmployeeRewardController::class, 'index'])
            ->name('employee-rewards.index');
        Route::post('employee-rewards', [App\Http\Controllers\HR\EmployeeRewardController::class, 'store'])
            ->name('employee-rewards.store');
        
        // Employee Documents
        Route::prefix('employees/{employee}/documents')->name('employees.documents.')->group(function () {
            Route::get('/', [App\Http\Controllers\HR\EmployeeDocumentController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\HR\EmployeeDocumentController::class, 'create'])->name('create');
            Route::post('/', [App\Http\Controllers\HR\EmployeeDocumentController::class, 'store'])->name('store');
            Route::get('/{document}/edit', [App\Http\Controllers\HR\EmployeeDocumentController::class, 'edit'])->name('edit');
            Route::put('/{document}', [App\Http\Controllers\HR\EmployeeDocumentController::class, 'update'])->name('update');
            Route::delete('/{document}', [App\Http\Controllers\HR\EmployeeDocumentController::class, 'destroy'])->name('destroy');
            Route::get('/{document}/download', [App\Http\Controllers\HR\EmployeeDocumentController::class, 'download'])->name('download');
        });
        
        // Attendance
        Route::get('attendance', [App\Http\Controllers\HR\AttendanceController::class, 'index'])->name('attendance.index');
        Route::post('attendance', [App\Http\Controllers\HR\AttendanceController::class, 'store'])->name('attendance.store');
        Route::put('attendance/{id}', [App\Http\Controllers\HR\AttendanceController::class, 'update'])->name('attendance.update');
        Route::delete('attendance/{id}', [App\Http\Controllers\HR\AttendanceController::class, 'destroy'])->name('attendance.destroy');
        Route::post('attendance/bulk-update', [App\Http\Controllers\HR\AttendanceController::class, 'bulkUpdate'])->name('attendance.bulk-update');
        Route::get('attendance/stats', [App\Http\Controllers\HR\AttendanceController::class, 'getMonthlyStats'])->name('attendance.stats');
        
        // Leave Management
        Route::get('leave', [App\Http\Controllers\HR\LeaveController::class, 'index'])->name('leave.index');
        
        // Payroll
        Route::get('payroll', [App\Http\Controllers\HR\PayrollController::class, 'index'])->name('payroll.index');
        
        // Recruitment
        Route::get('recruitment', [App\Http\Controllers\HR\RecruitmentController::class, 'index'])->name('recruitment.index');
        
        // Shifts (under HR namespace)
        Route::get('shifts/datatable', [App\Http\Controllers\HR\ShiftController::class, 'datatable'])->name('shifts.datatable');
        Route::get('shifts/preview-code', [App\Http\Controllers\HR\ShiftController::class, 'previewCode'])->name('shifts.preview-code');
        Route::post('shifts/{shift}/toggle-status', [App\Http\Controllers\HR\ShiftController::class, 'toggleStatus'])->name('shifts.toggle-status');
        Route::get('shifts/departments', [App\Http\Controllers\HR\ShiftController::class, 'getDepartments'])->name('shifts.departments');
        Route::get('shifts/employees', [App\Http\Controllers\HR\ShiftController::class, 'getEmployees'])->name('shifts.employees');
        Route::get('shifts', [App\Http\Controllers\HR\ShiftController::class, 'index'])->name('shifts.index');
        Route::post('shifts', [App\Http\Controllers\HR\ShiftController::class, 'store'])->name('shifts.store');
        Route::get('shifts/{shift}', [App\Http\Controllers\HR\ShiftController::class, 'show'])->name('shifts.show');
        Route::put('shifts/{shift}', [App\Http\Controllers\HR\ShiftController::class, 'update'])->name('shifts.update');
        Route::delete('shifts/{shift}', [App\Http\Controllers\HR\ShiftController::class, 'destroy'])->name('shifts.destroy');
    });

    // Tasks Routes
    Route::prefix('tasks')->name('tasks.')->group(function () {
        Route::get('/', [App\Http\Controllers\Work\TaskController::class, 'index'])->name('index');
        Route::get('/datatable', [App\Http\Controllers\Work\TaskController::class, 'datatable'])->name('datatable');
        Route::get('/kanban-data', [App\Http\Controllers\Work\TaskController::class, 'kanbanData'])->name('kanban-data');
        Route::post('/{task}/update-status', [App\Http\Controllers\Work\TaskController::class, 'updateStatus'])->name('update-status');
        Route::get('/preview-code', [App\Http\Controllers\Work\TaskController::class, 'previewCode'])->name('preview-code');
        Route::get('/create', [App\Http\Controllers\Work\TaskController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Work\TaskController::class, 'store'])->name('store');
        Route::get('/{task}', [App\Http\Controllers\Work\TaskController::class, 'show'])->name('show');
        Route::get('/{task}/edit', [App\Http\Controllers\Work\TaskController::class, 'edit'])->name('edit');
        Route::put('/{task}', [App\Http\Controllers\Work\TaskController::class, 'update'])->name('update');
        Route::delete('/{task}', [App\Http\Controllers\Work\TaskController::class, 'destroy'])->name('destroy');
        
        // Task Steps Routes
        Route::post('/steps/{step}/complete', [App\Http\Controllers\Work\TaskController::class, 'completeStep'])->name('steps.complete');
        Route::post('/steps/{step}/uncomplete', [App\Http\Controllers\Work\TaskController::class, 'uncompleteStep'])->name('steps.uncomplete');
        
        // Task Comments Routes
        Route::post('/{task}/comments', [App\Http\Controllers\Work\TaskController::class, 'addComment'])->name('comments.store');
    });

    // Warehouse Routes
    Route::prefix('warehouse')->name('warehouse.')->group(function () {
        // Categories
        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/', [App\Http\Controllers\Warehouse\CategoryController::class, 'index'])->name('index');
            Route::get('/datatable', [App\Http\Controllers\Warehouse\CategoryController::class, 'datatable'])->name('datatable');
            Route::get('/preview-code', [App\Http\Controllers\Warehouse\CategoryController::class, 'previewCode'])->name('preview-code');
            Route::post('/', [App\Http\Controllers\Warehouse\CategoryController::class, 'store'])->name('store');
            Route::get('/{category}', [App\Http\Controllers\Warehouse\CategoryController::class, 'show'])->name('show');
            Route::put('/{category}', [App\Http\Controllers\Warehouse\CategoryController::class, 'update'])->name('update');
            Route::delete('/{category}', [App\Http\Controllers\Warehouse\CategoryController::class, 'destroy'])->name('destroy');
        });

        // Warehouses
        Route::prefix('warehouses')->name('warehouses.')->group(function () {
            Route::get('/', [App\Http\Controllers\Warehouse\WarehouseController::class, 'index'])->name('index');
            Route::get('/datatable', [App\Http\Controllers\Warehouse\WarehouseController::class, 'datatable'])->name('datatable');
            Route::get('/preview-code', [App\Http\Controllers\Warehouse\WarehouseController::class, 'previewCode'])->name('preview-code');
            Route::post('/', [App\Http\Controllers\Warehouse\WarehouseController::class, 'store'])->name('store');
            Route::get('/{warehouse}', [App\Http\Controllers\Warehouse\WarehouseController::class, 'show'])->name('show');
            Route::put('/{warehouse}', [App\Http\Controllers\Warehouse\WarehouseController::class, 'update'])->name('update');
            Route::delete('/{warehouse}', [App\Http\Controllers\Warehouse\WarehouseController::class, 'destroy'])->name('destroy');
        });

        // Materials
        Route::prefix('materials')->name('materials.')->group(function () {
            Route::get('/', [App\Http\Controllers\Warehouse\MaterialController::class, 'index'])->name('index');
            Route::get('/datatable', [App\Http\Controllers\Warehouse\MaterialController::class, 'datatable'])->name('datatable');
            Route::get('/preview-code', [App\Http\Controllers\Warehouse\MaterialController::class, 'previewCode'])->name('preview-code');
            Route::post('/', [App\Http\Controllers\Warehouse\MaterialController::class, 'store'])->name('store');
            Route::get('/{material}', [App\Http\Controllers\Warehouse\MaterialController::class, 'show'])->name('show');
            Route::put('/{material}', [App\Http\Controllers\Warehouse\MaterialController::class, 'update'])->name('update');
            Route::delete('/{material}', [App\Http\Controllers\Warehouse\MaterialController::class, 'destroy'])->name('destroy');
        });

        // Inventory
        Route::prefix('inventory')->name('inventory.')->group(function () {
            Route::get('/', [App\Http\Controllers\Warehouse\InventoryController::class, 'index'])->name('index');
            Route::get('/datatable', [App\Http\Controllers\Warehouse\InventoryController::class, 'datatable'])->name('datatable');
            Route::post('/', [App\Http\Controllers\Warehouse\InventoryController::class, 'store'])->name('store');
            Route::get('/{inventory}', [App\Http\Controllers\Warehouse\InventoryController::class, 'show'])->name('show');
            Route::put('/{inventory}', [App\Http\Controllers\Warehouse\InventoryController::class, 'update'])->name('update');
            Route::delete('/{inventory}', [App\Http\Controllers\Warehouse\InventoryController::class, 'destroy'])->name('destroy');
        });

        // Material Requests
        Route::prefix('material-requests')->name('material-requests.')->group(function () {
            Route::get('/', [App\Http\Controllers\Warehouse\PurchaseRequestController::class, 'index'])->name('index');
            Route::get('/datatable', [App\Http\Controllers\Warehouse\PurchaseRequestController::class, 'datatable'])->name('datatable');
            Route::get('/preview-code', [App\Http\Controllers\Warehouse\PurchaseRequestController::class, 'previewCode'])->name('preview-code');
            Route::post('/', [App\Http\Controllers\Warehouse\PurchaseRequestController::class, 'store'])->name('store');
            Route::get('/{purchaseRequest}', [App\Http\Controllers\Warehouse\PurchaseRequestController::class, 'show'])->name('show');
            Route::put('/{purchaseRequest}', [App\Http\Controllers\Warehouse\PurchaseRequestController::class, 'update'])->name('update');
            Route::delete('/{purchaseRequest}', [App\Http\Controllers\Warehouse\PurchaseRequestController::class, 'destroy'])->name('destroy');
        });

        // Purchase Orders
        Route::prefix('purchase-orders')->name('purchase-orders.')->group(function () {
            Route::get('/', [App\Http\Controllers\Warehouse\PurchaseOrderController::class, 'index'])->name('index');
            Route::get('/datatable', [App\Http\Controllers\Warehouse\PurchaseOrderController::class, 'datatable'])->name('datatable');
            Route::get('/preview-code', [App\Http\Controllers\Warehouse\PurchaseOrderController::class, 'previewCode'])->name('preview-code');
            Route::post('/', [App\Http\Controllers\Warehouse\PurchaseOrderController::class, 'store'])->name('store');
            Route::get('/{purchaseOrder}', [App\Http\Controllers\Warehouse\PurchaseOrderController::class, 'show'])->name('show');
            Route::get('/{purchaseOrder}/edit', [App\Http\Controllers\Warehouse\PurchaseOrderController::class, 'edit'])->name('edit');
            Route::put('/{purchaseOrder}', [App\Http\Controllers\Warehouse\PurchaseOrderController::class, 'update'])->name('update');
            Route::delete('/{purchaseOrder}', [App\Http\Controllers\Warehouse\PurchaseOrderController::class, 'destroy'])->name('destroy');
        });

        // Sale Orders
        Route::prefix('sale-orders')->name('sale-orders.')->group(function () {
            Route::get('/', [App\Http\Controllers\Warehouse\SaleOrderController::class, 'index'])->name('index');
            Route::get('/datatable', [App\Http\Controllers\Warehouse\SaleOrderController::class, 'datatable'])->name('datatable');
            Route::get('/preview-code', [App\Http\Controllers\Warehouse\SaleOrderController::class, 'previewCode'])->name('preview-code');
            Route::post('/', [App\Http\Controllers\Warehouse\SaleOrderController::class, 'store'])->name('store');
            Route::get('/{saleOrder}', [App\Http\Controllers\Warehouse\SaleOrderController::class, 'show'])->name('show');
            Route::put('/{saleOrder}', [App\Http\Controllers\Warehouse\SaleOrderController::class, 'update'])->name('update');
            Route::delete('/{saleOrder}', [App\Http\Controllers\Warehouse\SaleOrderController::class, 'destroy'])->name('destroy');
        });

        // Delivery Orders
        Route::prefix('delivery-orders')->name('delivery-orders.')->group(function () {
            Route::get('/', [App\Http\Controllers\Warehouse\DeliveryOrderController::class, 'index'])->name('index');
            Route::get('/datatable', [App\Http\Controllers\Warehouse\DeliveryOrderController::class, 'datatable'])->name('datatable');
            Route::get('/preview-code', [App\Http\Controllers\Warehouse\DeliveryOrderController::class, 'previewCode'])->name('preview-code');
            Route::post('/', [App\Http\Controllers\Warehouse\DeliveryOrderController::class, 'store'])->name('store');
            Route::get('/{deliveryOrder}', [App\Http\Controllers\Warehouse\DeliveryOrderController::class, 'show'])->name('show');
            Route::put('/{deliveryOrder}', [App\Http\Controllers\Warehouse\DeliveryOrderController::class, 'update'])->name('update');
            Route::delete('/{deliveryOrder}', [App\Http\Controllers\Warehouse\DeliveryOrderController::class, 'destroy'])->name('destroy');
        });

        });

    // Supplier Routes
    Route::prefix('supplier')->name('supplier.')->group(function () {
        // Vendors
        Route::prefix('vendors')->name('vendors.')->group(function () {
            Route::get('/', [App\Http\Controllers\Supplier\VendorController::class, 'index'])->name('index');
            Route::get('/datatable', [App\Http\Controllers\Supplier\VendorController::class, 'datatable'])->name('datatable');
            Route::get('/preview-code', [App\Http\Controllers\Supplier\VendorController::class, 'previewCode'])->name('preview-code');
            Route::post('/', [App\Http\Controllers\Supplier\VendorController::class, 'store'])->name('store');
            Route::get('/{vendor}', [App\Http\Controllers\Supplier\VendorController::class, 'show'])->name('show');
            Route::put('/{vendor}', [App\Http\Controllers\Supplier\VendorController::class, 'update'])->name('update');
            Route::delete('/{vendor}', [App\Http\Controllers\Supplier\VendorController::class, 'destroy'])->name('destroy');
        });
    });

    // Electronic Mail Routes
    Route::prefix('electronic-mail')->name('electronic-mail.')->group(function () {
        Route::get('/', [App\Http\Controllers\Mail\ElectronicMailController::class, 'index'])->name('index');
        Route::get('/compose', [App\Http\Controllers\Mail\ElectronicMailController::class, 'compose'])->name('compose');
        Route::get('/datatable', [App\Http\Controllers\Mail\ElectronicMailController::class, 'datatable'])->name('datatable');
        Route::post('/sync', [App\Http\Controllers\Mail\ElectronicMailController::class, 'syncIncoming'])->name('sync');
        Route::post('/', [App\Http\Controllers\Mail\ElectronicMailController::class, 'store'])->name('store');
        Route::get('/{electronicMail}', [App\Http\Controllers\Mail\ElectronicMailController::class, 'show'])->name('show');
        Route::put('/{electronicMail}', [App\Http\Controllers\Mail\ElectronicMailController::class, 'update'])->name('update');
        Route::delete('/{electronicMail}', [App\Http\Controllers\Mail\ElectronicMailController::class, 'destroy'])->name('destroy');
        Route::post('/{electronicMail}/toggle-star', [App\Http\Controllers\Mail\ElectronicMailController::class, 'toggleStar'])->name('toggle-star');
        Route::post('/{electronicMail}/mark-read', [App\Http\Controllers\Mail\ElectronicMailController::class, 'markAsRead'])->name('mark-read');
    });

    // User Mail Account Routes (personal email settings)
    Route::prefix('user-mail-accounts')->name('user-mail-accounts.')->group(function () {
        Route::post('/save', [UserMailAccountController::class, 'save'])->name('save');
        Route::post('/test', [UserMailAccountController::class, 'test'])->name('test');
    });

    // Approval System Routes
    Route::prefix('approval-system')->name('approval-system.')->group(function () {
        Route::get('/', [App\Http\Controllers\Approval\ApprovalController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Approval\ApprovalController::class, 'create'])->name('create');
        Route::get('/datatable', [App\Http\Controllers\Approval\ApprovalController::class, 'datatable'])->name('datatable');
        Route::post('/', [App\Http\Controllers\Approval\ApprovalController::class, 'store'])->name('store');
        Route::get('/{approvalRequest}', [App\Http\Controllers\Approval\ApprovalController::class, 'show'])->name('show');
        Route::post('/{approvalRequest}/approve', [App\Http\Controllers\Approval\ApprovalController::class, 'approve'])->name('approve');
        Route::post('/{approvalRequest}/reject', [App\Http\Controllers\Approval\ApprovalController::class, 'reject'])->name('reject');
        Route::get('/stats', [App\Http\Controllers\Approval\ApprovalController::class, 'getStats'])->name('stats');
        
        // Templates Management
        Route::prefix('templates')->name('templates.')->group(function () {
            Route::get('/', [App\Http\Controllers\Approval\ApprovalTemplateController::class, 'index'])->name('index');
            Route::get('/datatable', [App\Http\Controllers\Approval\ApprovalTemplateController::class, 'datatable'])->name('datatable');
            Route::post('/', [App\Http\Controllers\Approval\ApprovalTemplateController::class, 'store'])->name('store');
            Route::get('/{id}', [App\Http\Controllers\Approval\ApprovalTemplateController::class, 'show'])->name('show');
            Route::put('/{id}', [App\Http\Controllers\Approval\ApprovalTemplateController::class, 'update'])->name('update');
            Route::delete('/{id}', [App\Http\Controllers\Approval\ApprovalTemplateController::class, 'destroy'])->name('destroy');
        });
    });

    // Chat System Routes
    Route::prefix('chat')->name('chat.')->group(function () {
        Route::get('/', [App\Http\Controllers\Chat\ChatController::class, 'index'])->name('index');
        Route::get('/conversations', [App\Http\Controllers\Chat\ChatController::class, 'getConversations'])->name('conversations');
        Route::get('/messages/{conversationId}', [App\Http\Controllers\Chat\ChatController::class, 'getMessages'])->name('messages');
        Route::post('/messages', [App\Http\Controllers\Chat\ChatController::class, 'sendMessage'])->name('send-message');
        Route::post('/conversations', [App\Http\Controllers\Chat\ChatController::class, 'startConversation'])->name('start-conversation');
        Route::post('/mark-read/{conversationId}', [App\Http\Controllers\Chat\ChatController::class, 'markAsRead'])->name('mark-read');
        Route::get('/unread-count', [App\Http\Controllers\Chat\ChatController::class, 'getUnreadCount'])->name('unread-count');
    });

    // AI System Routes
    Route::prefix('ai')->name('ai.')->group(function () {
        Route::get('/', [App\Http\Controllers\Chat\AiController::class, 'index'])->name('index');
        Route::get('/chat', [App\Http\Controllers\Chat\AiController::class, 'chat'])->name('chat');
        Route::get('/datatable', [App\Http\Controllers\Chat\AiController::class, 'datatable'])->name('datatable');
        Route::get('/admin-users', [App\Http\Controllers\Chat\AiController::class, 'adminUsers'])->name('admin-users');
        Route::get('/admin-recent', [App\Http\Controllers\Chat\AiController::class, 'adminRecent'])->name('admin-recent');
        Route::post('/interact', [App\Http\Controllers\Chat\AiController::class, 'interact'])->name('interact');
        Route::get('/interactions/{aiInteraction}', [App\Http\Controllers\Chat\AiController::class, 'show'])->name('show');
        Route::post('/interactions/{aiInteraction}/retry', [App\Http\Controllers\Chat\AiController::class, 'retry'])->name('retry');
        Route::get('/automations', [App\Http\Controllers\Chat\AiController::class, 'automations'])->name('automations');
        Route::post('/automations', [App\Http\Controllers\Chat\AiController::class, 'createAutomation'])->name('create-automation');
        Route::get('/generated-content', [App\Http\Controllers\Chat\AiController::class, 'generatedContent'])->name('generated-content');
        Route::post('/generated-content/{content}/rate', [App\Http\Controllers\Chat\AiController::class, 'rateContent'])->name('rate-content');
        Route::get('/analytics', [App\Http\Controllers\Chat\AiController::class, 'analytics'])->name('analytics');
        Route::get('/available', [App\Http\Controllers\Chat\AiController::class, 'isAvailable'])->name('available');
    });

    // Accounting Routes (Chart of Accounts & Journal Entries)
    Route::prefix('accounting')->name('accounting.')->group(function () {
        // Chart of Accounts main page
        Route::get('chart-of-accounts', [App\Http\Controllers\Accounting\AccountingController::class, 'index'])
            ->name('chart-of-accounts.index');

        // Datatable data for Chart of Accounts
        Route::get('chart-of-accounts/datatable', [App\Http\Controllers\Accounting\AccountingController::class, 'datatable'])
            ->name('chart-of-accounts.datatable');

        // Store new account
        Route::post('chart-of-accounts', [App\Http\Controllers\Accounting\AccountingController::class, 'store'])
            ->name('chart-of-accounts.store');

        // Update account status
        Route::post('chart-of-accounts/{account}/status', [App\Http\Controllers\Accounting\AccountingController::class, 'updateStatus'])
            ->name('chart-of-accounts.update-status');

        // Get accounts for dropdowns
        Route::get('chart-of-accounts/accounts', [App\Http\Controllers\Accounting\AccountingController::class, 'getAccounts'])
            ->name('chart-of-accounts.accounts');

        // Export accounts data
        Route::get('chart-of-accounts/export', [App\Http\Controllers\Accounting\AccountingController::class, 'export'])
            ->name('chart-of-accounts.export');

        // Journal Entries page & data
        Route::get('journal-entries', [App\Http\Controllers\Accounting\AccountingController::class, 'journalEntries'])
            ->name('journal-entries.index');

        Route::get('journal-entries/datatable', [App\Http\Controllers\Accounting\AccountingController::class, 'journalEntriesDatatable'])
            ->name('journal-entries.datatable');

        Route::get('journal-entries/stats', [App\Http\Controllers\Accounting\AccountingController::class, 'journalEntriesStats'])
            ->name('journal-entries.stats');
    });

    // Document Management Routes
    Route::prefix('documents')->name('documents.')->group(function () {
        Route::get('/', [App\Http\Controllers\Document\DocumentController::class, 'index'])->name('index');
        Route::get('/stats', [App\Http\Controllers\Document\DocumentController::class, 'stats'])->name('stats');
        Route::get('/categories', [App\Http\Controllers\Document\DocumentController::class, 'categories'])->name('categories');
        Route::get('/datatable', [App\Http\Controllers\Document\DocumentController::class, 'datatable'])->name('datatable');
        Route::get('/create', [App\Http\Controllers\Document\DocumentController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Document\DocumentController::class, 'store'])->name('store');
        Route::get('/{document}', [App\Http\Controllers\Document\DocumentController::class, 'show'])->name('show');
        Route::put('/{document}', [App\Http\Controllers\Document\DocumentController::class, 'update'])->name('update');
        Route::delete('/{document}', [App\Http\Controllers\Document\DocumentController::class, 'destroy'])->name('destroy');

        // Category management
        Route::post('/categories', [App\Http\Controllers\Document\DocumentController::class, 'storeCategory'])->name('store-category');
        Route::put('/categories/{category}', [App\Http\Controllers\Document\DocumentController::class, 'updateCategory'])->name('update-category');
        Route::delete('/categories/{category}', [App\Http\Controllers\Document\DocumentController::class, 'destroyCategory'])->name('destroy-category');
    });

    // CRM Routes
    Route::prefix('crm')->name('crm.')->group(function () {
        Route::get('contacts/datatable', [ContactController::class, 'datatable'])->name('contacts.datatable');
        Route::resource('contacts', ContactController::class)->except(['create', 'edit']);

        Route::get('leads/datatable', [LeadController::class, 'datatable'])->name('leads.datatable');
        Route::resource('leads', LeadController::class)->except(['create', 'edit']);

        Route::get('opportunities/datatable', [OpportunityController::class, 'datatable'])->name('opportunities.datatable');
        Route::resource('opportunities', OpportunityController::class)->except(['create', 'edit']);

        Route::get('activities/datatable', [ActivityController::class, 'datatable'])->name('activities.datatable');
        Route::resource('activities', ActivityController::class)->except(['create', 'edit']);

        Route::prefix('files')->name('files.')->group(function () {
            Route::get('/', [FileController::class, 'index'])->name('index');
            Route::post('/', [FileController::class, 'store'])->name('store');
            Route::get('/{file}/download', [FileController::class, 'download'])->name('download');
            Route::delete('/{file}', [FileController::class, 'destroy'])->name('destroy');
        });
    });

    // Manufacturing Routes
    Route::prefix('manufacturing')->name('manufacturing.')->group(function () {
        // Main dashboard
        Route::get('/', [App\Http\Controllers\Manufacturing\ManufacturingController::class, 'index'])->name('index');

        // Production Orders
        Route::get('/orders', [App\Http\Controllers\Manufacturing\ManufacturingController::class, 'ordersIndex'])->name('orders.index');
        Route::get('/orders/create', [App\Http\Controllers\Manufacturing\ManufacturingController::class, 'createOrder'])->name('orders.create');
        Route::post('/orders', [App\Http\Controllers\Manufacturing\ManufacturingController::class, 'storeOrder'])->name('orders.store');
        Route::get('/orders/{order}', [App\Http\Controllers\Manufacturing\ManufacturingController::class, 'showOrder'])->name('orders.show');
        Route::get('/orders/{order}/edit', [App\Http\Controllers\Manufacturing\ManufacturingController::class, 'editOrder'])->name('orders.edit');
        Route::put('/orders/{order}', [App\Http\Controllers\Manufacturing\ManufacturingController::class, 'updateOrder'])->name('orders.update');
        Route::delete('/orders/{order}', [App\Http\Controllers\Manufacturing\ManufacturingController::class, 'destroyOrder'])->name('orders.destroy');

        // Production Stages
        Route::get('/stages', [App\Http\Controllers\Manufacturing\ManufacturingController::class, 'stagesIndex'])->name('stages.index');
        Route::post('/stages', [App\Http\Controllers\Manufacturing\ManufacturingController::class, 'storeStage'])->name('stages.store');
        Route::put('/stages/{stage}', [App\Http\Controllers\Manufacturing\ManufacturingController::class, 'updateStage'])->name('stages.update');
        Route::delete('/stages/{stage}', [App\Http\Controllers\Manufacturing\ManufacturingController::class, 'destroyStage'])->name('stages.destroy');

        // Machines
        Route::get('/machines', [App\Http\Controllers\Manufacturing\ManufacturingController::class, 'machinesIndex'])->name('machines.index');
        Route::post('/machines', [App\Http\Controllers\Manufacturing\ManufacturingController::class, 'storeMachine'])->name('machines.store');
        Route::put('/machines/{machine}', [App\Http\Controllers\Manufacturing\ManufacturingController::class, 'updateMachine'])->name('machines.update');
        Route::delete('/machines/{machine}', [App\Http\Controllers\Manufacturing\ManufacturingController::class, 'destroyMachine'])->name('machines.destroy');

        // Quality Control
        Route::get('/quality', [App\Http\Controllers\Manufacturing\ManufacturingController::class, 'qualityIndex'])->name('quality.index');
        Route::post('/quality', [App\Http\Controllers\Manufacturing\ManufacturingController::class, 'storeQualityCheck'])->name('quality.store');
        Route::put('/quality/{check}', [App\Http\Controllers\Manufacturing\ManufacturingController::class, 'updateQualityCheck'])->name('quality.update');

        // Reports
        Route::get('/reports', [App\Http\Controllers\Manufacturing\ManufacturingController::class, 'reportsIndex'])->name('reports.index');
        Route::post('/reports', [App\Http\Controllers\Manufacturing\ManufacturingController::class, 'generateReport'])->name('reports.generate');

        // AJAX helpers
        Route::get('/orders/datatable', [App\Http\Controllers\Manufacturing\ManufacturingController::class, 'ordersDatatable'])->name('orders.datatable');
        Route::get('/stages/active', [App\Http\Controllers\Manufacturing\ManufacturingController::class, 'getActiveStages'])->name('stages.active');
        Route::get('/machines/available', [App\Http\Controllers\Manufacturing\ManufacturingController::class, 'getAvailableMachines'])->name('machines.available');
    });

    // Project Management Routes
    Route::prefix('project-management')->name('project-management.')->group(function () {
        // Main CRUD & listing
        Route::get('projects', [App\Http\Controllers\Work\ProjectController::class, 'index'])->name('projects.index');
        Route::get('projects/create', [App\Http\Controllers\Work\ProjectController::class, 'create'])->name('projects.create');

        // Data & operations (define BEFORE dynamic {project} routes to avoid conflicts)
        Route::get('projects/datatable', [App\Http\Controllers\Work\ProjectController::class, 'datatable'])->name('projects.datatable');
        Route::post('projects', [App\Http\Controllers\Work\ProjectController::class, 'store'])->name('projects.store');
        Route::put('projects/{project}', [App\Http\Controllers\Work\ProjectController::class, 'update'])->name('projects.update');
        Route::delete('projects/{project}', [App\Http\Controllers\Work\ProjectController::class, 'destroy'])->name('projects.destroy');

        // Status, stats & export
        Route::put('projects/{project}/status', [App\Http\Controllers\Work\ProjectController::class, 'updateStatus'])->name('projects.update-status');
        Route::get('projects/stats', [App\Http\Controllers\Work\ProjectController::class, 'stats'])->name('projects.stats');
        Route::get('projects/export', [App\Http\Controllers\Work\ProjectController::class, 'export'])->name('projects.export');

        // Detail & edit views (placed last so they don't swallow other routes)
        Route::get('projects/{project}', [App\Http\Controllers\Work\ProjectController::class, 'show'])->name('projects.show');
        Route::get('projects/{project}/edit', [App\Http\Controllers\Work\ProjectController::class, 'edit'])->name('projects.edit');
    });

    // Dashboard and other pages
    Route::controller(PageController::class)->group(function () {
        Route::get('/', 'dashboardOverview1')->name('dashboard-overview-1');
        Route::get('dashboard-overview-2-page', 'dashboardOverview2')->name('dashboard-overview-2');
        Route::get('dashboard-overview-3-page', 'dashboardOverview3')->name('dashboard-overview-3');
        Route::get('dashboard-overview-4-page', 'dashboardOverview4')->name('dashboard-overview-4');
        Route::get('categories-page', 'categories')->name('categories');
        Route::get('add-product-page', 'addProduct')->name('add-product');
        Route::get('product-list-page', 'productList')->name('product-list');
        Route::get('product-grid-page', 'productGrid')->name('product-grid');
        Route::get('transaction-list-page', 'transactionList')->name('transaction-list');
        Route::get('transaction-detail-page', 'transactionDetail')->name('transaction-detail');
        Route::get('seller-list-page', 'sellerList')->name('seller-list');
        Route::get('seller-detail-page', 'sellerDetail')->name('seller-detail');
        Route::get('reviews-page', 'reviews')->name('reviews');
        Route::get('inbox-page', 'inbox')->name('inbox');
        Route::get('file-manager-page', 'fileManager')->name('file-manager');
        Route::get('point-of-sale-page', 'pointOfSale')->name('point-of-sale');
        Route::get('chat-page', 'chat')->name('chat');
        Route::get('post-page', 'post')->name('post');
        Route::get('calendar-page', 'calendar')->name('calendar-page');
        Route::get('crud-data-list-page', 'crudDataList')->name('crud-data-list');
        Route::get('crud-form-page', 'crudForm')->name('crud-form');
        Route::get('users-layout-1-page', 'usersLayout1')->name('users-layout-1');
        Route::get('users-layout-2-page', 'usersLayout2')->name('users-layout-2');
        Route::get('users-layout-3-page', 'usersLayout3')->name('users-layout-3');
        Route::get('profile-overview-1-page', 'profileOverview1')->name('profile-overview-1');
        Route::get('profile-overview-2-page', 'profileOverview2')->name('profile-overview-2');
        Route::get('profile-overview-3-page', 'profileOverview3')->name('profile-overview-3');
        Route::get('wizard-layout-1-page', 'wizardLayout1')->name('wizard-layout-1');
        Route::get('wizard-layout-2-page', 'wizardLayout2')->name('wizard-layout-2');
        Route::get('wizard-layout-3-page', 'wizardLayout3')->name('wizard-layout-3');
        Route::get('blog-layout-1-page', 'blogLayout1')->name('blog-layout-1');
        Route::get('blog-layout-2-page', 'blogLayout2')->name('blog-layout-2');
        Route::get('blog-layout-3-page', 'blogLayout3')->name('blog-layout-3');
        Route::get('pricing-layout-1-page', 'pricingLayout1')->name('pricing-layout-1');
        Route::get('pricing-layout-2-page', 'pricingLayout2')->name('pricing-layout-2');
        Route::get('invoice-layout-1-page', 'invoiceLayout1')->name('invoice-layout-1');
        Route::get('invoice-layout-2-page', 'invoiceLayout2')->name('invoice-layout-2');
        Route::get('faq-layout-1-page', 'faqLayout1')->name('faq-layout-1');
        Route::get('faq-layout-2-page', 'faqLayout2')->name('faq-layout-2');
        Route::get('faq-layout-3-page', 'faqLayout3')->name('faq-layout-3');
        Route::get('error-page-page', 'errorPage')->name('error-page');
        Route::get('update-profile-page', 'updateProfile')->name('update-profile');
        Route::get('change-password-page', 'changePassword')->name('change-password');
        Route::get('regular-table-page', 'regularTable')->name('regular-table');
        Route::get('tabulator-page', 'tabulator')->name('tabulator');
        Route::get('modal-page', 'modal')->name('modal');
        Route::get('slide-over-page', 'slideOver')->name('slide-over');
        Route::get('notification-page', 'notification')->name('notification');
        Route::get('tab-page', 'tab')->name('tab');
        Route::get('accordion-page', 'accordion')->name('accordion');
        Route::get('button-page', 'button')->name('button');
        Route::get('alert-page', 'alert')->name('alert');
        Route::get('progress-bar-page', 'progressBar')->name('progress-bar');
        Route::get('tooltip-page', 'tooltip')->name('tooltip');
        Route::get('dropdown-page', 'dropdown')->name('dropdown');
        Route::get('typography-page', 'typography')->name('typography');
        Route::get('icon-page', 'icon')->name('icon');
        Route::get('loading-icon-page', 'loadingIcon')->name('loading-icon');
        Route::get('regular-form-page', 'regularForm')->name('regular-form');
        Route::get('datepicker-page', 'datepicker')->name('datepicker');
        Route::get('tom-select-page', 'tomSelect')->name('tom-select');
        Route::get('file-upload-page', 'fileUpload')->name('file-upload');
        Route::get('wysiwyg-editor-classic-page', 'wysiwygEditorClassic')->name('wysiwyg-editor-classic');
        Route::get('wysiwyg-editor-inline-page', 'wysiwygEditorInline')->name('wysiwyg-editor-inline');
        Route::get('wysiwyg-editor-balloon-page', 'wysiwygEditorBalloon')->name('wysiwyg-editor-balloon');
        Route::get('wysiwyg-editor-balloon-block-page', 'wysiwyg-editorBalloonBlock')->name('wysiwyg-editor-balloon-block');
        Route::get('wysiwyg-editor-document-page', 'wysiwygEditorDocument')->name('wysiwyg-editor-document');
        Route::get('validation-page', 'validation')->name('validation');
        Route::get('chart-page', 'chart')->name('chart');
        Route::get('slider-page', 'slider')->name('slider');
        Route::get('image-zoom-page', 'imageZoom')->name('image-zoom');
    });

    // Notification Routes
    Route::prefix('notifications')->name('notifications.')->middleware('auth')->group(function () {
        Route::get('/', [App\Http\Controllers\NotificationController::class, 'index'])->name('index');
        Route::get('/unread-count', [App\Http\Controllers\NotificationController::class, 'unreadCount'])->name('unread-count');
        Route::get('/recent', [App\Http\Controllers\NotificationController::class, 'recent'])->name('recent');
        Route::patch('/{notification}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('mark-read');
        Route::patch('/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
        Route::delete('/{notification}', [App\Http\Controllers\NotificationController::class, 'destroy'])->name('destroy');
        Route::delete('/delete-all', [App\Http\Controllers\NotificationController::class, 'destroyAll'])->name('delete-all');
        Route::post('/create', [App\Http\Controllers\NotificationController::class, 'createNotification'])->name('create');
        Route::post('/send-to-users', [App\Http\Controllers\NotificationController::class, 'sendToUsers'])->name('send-to-users');
    });

    // Work Management Routes
    Route::prefix('work')->name('work.')->group(function () {
        // Projects
        Route::resource('projects', App\Http\Controllers\Work\ProjectController::class);
        Route::get('projects/datatable/data', [App\Http\Controllers\Work\ProjectController::class, 'datatable'])->name('projects.datatable');
        Route::put('projects/{project}/status', [App\Http\Controllers\Work\ProjectController::class, 'updateStatus'])->name('projects.update-status');
        Route::get('projects/stats/data', [App\Http\Controllers\Work\ProjectController::class, 'stats'])->name('projects.stats');
        Route::get('projects/export/data', [App\Http\Controllers\Work\ProjectController::class, 'export'])->name('projects.export');
        Route::get('projects/preview-code', [App\Http\Controllers\Work\ProjectController::class, 'previewCode'])->name('projects.preview-code');
        Route::get('projects/debug-prefix', [App\Http\Controllers\Work\ProjectController::class, 'debugPrefix'])->name('projects.debug-prefix');
        
        // Estimates
        Route::resource('estimates', App\Http\Controllers\Work\EstimateController::class);
        Route::get('estimates/datatable', [App\Http\Controllers\Work\EstimateController::class, 'datatable'])->name('estimates.datatable');
        Route::get('estimates/preview-code', [App\Http\Controllers\Work\EstimateController::class, 'previewCode'])->name('estimates.preview-code');
        
        // Contracts
        Route::resource('contracts', App\Http\Controllers\Work\ContractController::class);
        Route::get('contracts/datatable', [App\Http\Controllers\Work\ContractController::class, 'datatable'])->name('contracts.datatable');
        Route::get('contracts/preview-code', [App\Http\Controllers\Work\ContractController::class, 'previewCode'])->name('contracts.preview-code');
    });
    // Manufacturing Routes

});

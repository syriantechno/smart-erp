<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\LayoutController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

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
    Route::post('/settings/prefix', [SettingsController::class, 'updatePrefix'])->name('settings.prefix.update');
    Route::post('/settings/company', [SettingsController::class, 'updateCompany'])->name('settings.company.update');

    // HR Routes
    Route::prefix('hr')->name('hr.')->group(function () {
        // Departments
        Route::resource('departments', 'App\Http\Controllers\HR\DepartmentController')
            ->except(['show']);
            
        // DataTable route for departments
        Route::get('departments/datatable', [App\Http\Controllers\HR\DepartmentController::class, 'datatable'])
            ->name('departments.datatable');

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
        Route::resource('employees', 'App\Http\Controllers\HR\EmployeeController');
        
        // Attendance
        Route::get('attendance', [App\Http\Controllers\HR\AttendanceController::class, 'index'])->name('attendance.index');
        Route::post('attendance', [App\Http\Controllers\HR\AttendanceController::class, 'store'])->name('attendance.store');
        Route::put('attendance/{id}', [App\Http\Controllers\HR\AttendanceController::class, 'update'])->name('attendance.update');
        Route::delete('attendance/{id}', [App\Http\Controllers\HR\AttendanceController::class, 'destroy'])->name('attendance.destroy');
        Route::post('attendance/bulk-update', [App\Http\Controllers\HR\AttendanceController::class, 'bulkUpdate'])->name('attendance.bulk-update');
        Route::get('attendance/stats', [App\Http\Controllers\HR\AttendanceController::class, 'getMonthlyStats'])->name('attendance.stats');
        
        // Shifts
        Route::get('shifts/datatable', [App\Http\Controllers\ShiftController::class, 'datatable'])->name('shifts.datatable');
        Route::get('shifts/preview-code', [App\Http\Controllers\ShiftController::class, 'previewCode'])->name('shifts.preview-code');
        Route::post('shifts/{shift}/toggle-status', [App\Http\Controllers\ShiftController::class, 'toggleStatus'])->name('shifts.toggle-status');
        Route::get('shifts/departments', [App\Http\Controllers\ShiftController::class, 'getDepartments'])->name('shifts.departments');
        Route::get('shifts/employees', [App\Http\Controllers\ShiftController::class, 'getEmployees'])->name('shifts.employees');
        Route::resource('shifts', App\Http\Controllers\ShiftController::class);
        
        // Leave Management
        Route::get('leave', [App\Http\Controllers\HR\LeaveController::class, 'index'])->name('leave.index');
        
        // Payroll
        Route::get('payroll', [App\Http\Controllers\HR\PayrollController::class, 'index'])->name('payroll.index');
        
        // Recruitment
        Route::get('recruitment', [App\Http\Controllers\HR\RecruitmentController::class, 'index'])->name('recruitment.index');
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
        Route::get('calendar-page', 'calendar')->name('calendar');
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
});

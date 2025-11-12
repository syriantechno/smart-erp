<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Company;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Shift;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class EmployeeManagementTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;
    protected $company;
    protected $department;
    protected $hrManager;
    protected $employee;

    protected function setUp(): void
    {
        parent::setUp();

        // إنشاء بيانات الاختبار الأساسية
        $this->company = Company::factory()->create();
        $this->department = Department::factory()->create(['company_id' => $this->company->id]);

        // مدير الموارد البشرية
        $this->hrManager = User::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
        ]);

        // الموظف
        $this->employee = User::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
        ]);

        // المستخدم الحالي (مدير الموارد البشرية)
        $this->user = $this->hrManager;
        $this->actingAs($this->user);
    }

    /**
     * اختبار صفحة قائمة الموظفين
     */
    public function test_employees_index_page_loads()
    {
        $response = $this->get(route('employees.index'));

        $response->assertStatus(200);
        $response->assertViewHas('pageTitle', 'إدارة الموظفين');
        $response->assertViewIs('employees.index');
    }

    /**
     * اختبار إنشاء موظف جديد
     */
    public function test_create_employee()
    {
        $employeeData = [
            'user_id' => $this->employee->id,
            'employee_code' => 'EMP-001',
            'first_name' => 'أحمد',
            'last_name' => 'محمد',
            'email' => 'ahmed@example.com',
            'phone' => '0501234567',
            'department_id' => $this->department->id,
            'position' => 'مطور برمجيات',
            'employment_type' => 'full_time',
            'salary' => 8000.00,
            'hire_date' => now()->format('Y-m-d'),
            'status' => 'active',
            'company_id' => $this->company->id,
        ];

        $response = $this->post(route('employees.store'), $employeeData);

        $response->assertRedirect(route('employees.index'));
        $response->assertSessionHas('success', 'تم حفظ بيانات الموظف بنجاح');

        $this->assertDatabaseHas('employees', [
            'employee_code' => 'EMP-001',
            'first_name' => 'أحمد',
            'last_name' => 'محمد',
            'position' => 'مطور برمجيات',
            'company_id' => $this->company->id,
        ]);
    }

    /**
     * اختبار عرض تفاصيل الموظف
     */
    public function test_employee_show_page()
    {
        $employee = Employee::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
            'user_id' => $this->employee->id,
        ]);

        $response = $this->get(route('employees.show', $employee));

        $response->assertStatus(200);
        $response->assertViewHas('employee', $employee);
        $response->assertViewIs('employees.show');
    }

    /**
     * اختبار تحديث بيانات الموظف
     */
    public function test_employee_update()
    {
        $employee = Employee::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
            'user_id' => $this->employee->id,
        ]);

        $updateData = [
            'first_name' => 'أحمد المحدث',
            'last_name' => 'محمد المحدث',
            'position' => 'كبير المطورين',
            'salary' => 12000.00,
            'status' => 'active',
        ];

        $response = $this->put(route('employees.update', $employee), $updateData);

        $response->assertRedirect(route('employees.show', $employee));
        $response->assertSessionHas('success', 'تم تحديث بيانات الموظف بنجاح');

        $this->assertDatabaseHas('employees', [
            'id' => $employee->id,
            'first_name' => 'أحمد المحدث',
            'position' => 'كبير المطورين',
            'salary' => 12000.00,
        ]);
    }

    /**
     * اختبار تسجيل الحضور
     */
    public function test_record_attendance()
    {
        $employee = Employee::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
            'user_id' => $this->employee->id,
        ]);

        $attendanceData = [
            'employee_id' => $employee->id,
            'date' => now()->format('Y-m-d'),
            'check_in_time' => now()->format('H:i:s'),
            'check_out_time' => now()->addHours(8)->format('H:i:s'),
            'status' => 'present',
            'work_hours' => 8.00,
            'overtime_hours' => 0.00,
            'notes' => 'يوم عمل عادي',
            'company_id' => $this->company->id,
        ];

        $response = $this->post(route('employees.attendance.store', $employee), $attendanceData);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'تم تسجيل الحضور بنجاح');

        $this->assertDatabaseHas('attendances', [
            'employee_id' => $employee->id,
            'date' => now()->format('Y-m-d'),
            'status' => 'present',
            'work_hours' => 8.00,
        ]);
    }

    /**
     * اختبار تسجيل الإجازة
     */
    public function test_record_leave()
    {
        $employee = Employee::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
            'user_id' => $this->employee->id,
        ]);

        $leaveData = [
            'employee_id' => $employee->id,
            'leave_type' => 'annual',
            'start_date' => now()->addDays(1)->format('Y-m-d'),
            'end_date' => now()->addDays(5)->format('Y-m-d'),
            'days_count' => 5,
            'reason' => 'إجازة سنوية',
            'status' => 'approved',
            'approved_by' => $this->hrManager->id,
            'company_id' => $this->company->id,
        ];

        $response = $this->post(route('employees.leaves.store', $employee), $leaveData);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'تم تسجيل الإجازة بنجاح');

        $this->assertDatabaseHas('leaves', [
            'employee_id' => $employee->id,
            'leave_type' => 'annual',
            'days_count' => 5,
            'status' => 'approved',
        ]);
    }

    /**
     * اختبار إنشاء تقييم الأداء
     */
    public function test_create_performance_review()
    {
        $employee = Employee::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
            'user_id' => $this->employee->id,
        ]);

        $reviewData = [
            'employee_id' => $employee->id,
            'review_date' => now()->format('Y-m-d'),
            'review_period' => '2024-Q1',
            'overall_rating' => 4.5,
            'performance_score' => 85,
            'reviewer_id' => $this->hrManager->id,
            'comments' => 'أداء ممتاز في المشاريع الموكلة إليه',
            'goals_achieved' => 'تم إنجاز جميع الأهداف المحددة',
            'areas_for_improvement' => 'تحسين التواصل مع الفريق',
            'development_plan' => 'دورات تدريبية في إدارة الفرق',
            'company_id' => $this->company->id,
        ];

        $response = $this->post(route('employees.reviews.store', $employee), $reviewData);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'تم حفظ تقييم الأداء بنجاح');

        $this->assertDatabaseHas('performance_reviews', [
            'employee_id' => $employee->id,
            'review_period' => '2024-Q1',
            'overall_rating' => 4.5,
            'performance_score' => 85,
        ]);
    }

    /**
     * اختبار إدارة الورديات
     */
    public function test_manage_shifts()
    {
        $shiftData = [
            'name' => 'وردية الصباح',
            'start_time' => '08:00:00',
            'end_time' => '16:00:00',
            'break_duration' => 60, // دقيقة
            'work_days' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'],
            'is_active' => true,
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
        ];

        $response = $this->post(route('employees.shifts.store'), $shiftData);

        $response->assertRedirect(route('employees.shifts.index'));
        $response->assertSessionHas('success', 'تم حفظ الوردية بنجاح');

        $this->assertDatabaseHas('shifts', [
            'name' => 'وردية الصباح',
            'start_time' => '08:00:00',
            'end_time' => '16:00:00',
            'company_id' => $this->company->id,
        ]);
    }

    /**
     * اختبار تعيين موظف لوردية
     */
    public function test_assign_employee_to_shift()
    {
        $employee = Employee::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
            'user_id' => $this->employee->id,
        ]);

        $shift = Shift::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
        ]);

        $assignmentData = [
            'employee_id' => $employee->id,
            'shift_id' => $shift->id,
            'start_date' => now()->format('Y-m-d'),
            'end_date' => now()->addMonths(1)->format('Y-m-d'),
            'is_active' => true,
        ];

        $response = $this->post(route('employees.shift-assignments.store'), $assignmentData);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'تم تعيين الوردية بنجاح');

        $this->assertDatabaseHas('employee_shift_assignments', [
            'employee_id' => $employee->id,
            'shift_id' => $shift->id,
            'is_active' => true,
        ]);
    }

    /**
     * اختبار حساب ساعات العمل الشهرية
     */
    public function test_calculate_monthly_work_hours()
    {
        $employee = Employee::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
            'user_id' => $this->employee->id,
        ]);

        // إنشاء سجلات حضور لمدة شهر
        for ($i = 1; $i <= 22; $i++) { // 22 يوم عمل
            Attendance::factory()->create([
                'employee_id' => $employee->id,
                'date' => now()->subDays($i),
                'work_hours' => 8.00,
                'status' => 'present',
                'company_id' => $this->company->id,
            ]);
        }

        // حساب ساعات العمل الشهرية
        $monthlyHours = Attendance::where('employee_id', $employee->id)
            ->whereMonth('date', now()->month)
            ->sum('work_hours');

        $this->assertEquals(176.00, $monthlyHours); // 22 يوم × 8 ساعات
    }

    /**
     * اختبار إنشاء طلب إجازة
     */
    public function test_create_leave_request()
    {
        $this->actingAs($this->employee); // تغيير للموظف العادي

        $leaveRequestData = [
            'leave_type' => 'sick',
            'start_date' => now()->addDays(2)->format('Y-m-d'),
            'end_date' => now()->addDays(3)->format('Y-m-d'),
            'days_count' => 2,
            'reason' => 'مرض مؤقت',
            'emergency_contact' => '0509876543',
            'company_id' => $this->company->id,
        ];

        $response = $this->post(route('employees.leave-requests.store'), $leaveRequestData);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'تم إرسال طلب الإجازة بنجاح');

        $this->assertDatabaseHas('leave_requests', [
            'user_id' => $this->employee->id,
            'leave_type' => 'sick',
            'days_count' => 2,
            'status' => 'pending', // يجب أن يكون معلق للموافقة
        ]);
    }

    /**
     * اختبار موافقة طلب الإجازة
     */
    public function test_approve_leave_request()
    {
        $this->actingAs($this->hrManager); // العودة لمدير الموارد البشرية

        // إنشاء طلب إجازة
        $leaveRequest = \App\Models\LeaveRequest::factory()->create([
            'user_id' => $this->employee->id,
            'company_id' => $this->company->id,
            'status' => 'pending',
            'days_count' => 3,
        ]);

        $approvalData = [
            'status' => 'approved',
            'approved_by' => $this->hrManager->id,
            'approval_notes' => 'تمت الموافقة على الإجازة',
        ];

        $response = $this->put(route('employees.leave-requests.update', $leaveRequest), $approvalData);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'تم تحديث طلب الإجازة بنجاح');

        $this->assertDatabaseHas('leave_requests', [
            'id' => $leaveRequest->id,
            'status' => 'approved',
            'approved_by' => $this->hrManager->id,
        ]);
    }

    /**
     * اختبار إنشاء خطة التدريب
     */
    public function test_create_training_plan()
    {
        $employee = Employee::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
            'user_id' => $this->employee->id,
        ]);

        $trainingData = [
            'employee_id' => $employee->id,
            'title' => 'دورة تطوير المهارات القيادية',
            'description' => 'دورة شاملة في تطوير المهارات القيادية',
            'training_type' => 'external',
            'provider' => 'معهد القيادة المتقدمة',
            'start_date' => now()->addWeeks(2)->format('Y-m-d'),
            'end_date' => now()->addWeeks(4)->format('Y-m-d'),
            'duration_hours' => 40,
            'cost' => 2500.00,
            'status' => 'planned',
            'company_id' => $this->company->id,
        ];

        $response = $this->post(route('employees.trainings.store', $employee), $trainingData);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'تم حفظ خطة التدريب بنجاح');

        $this->assertDatabaseHas('employee_trainings', [
            'employee_id' => $employee->id,
            'title' => 'دورة تطوير المهارات القيادية',
            'training_type' => 'external',
            'status' => 'planned',
        ]);
    }

    /**
     * اختبار البحث في الموظفين
     */
    public function test_employee_search_functionality()
    {
        Employee::factory()->create([
            'first_name' => 'أحمد',
            'last_name' => 'العلي',
            'employee_code' => 'EMP-001',
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
        ]);

        Employee::factory()->create([
            'first_name' => 'فاطمة',
            'last_name' => 'الزهراء',
            'employee_code' => 'EMP-002',
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
        ]);

        $response = $this->get(route('employees.index', ['search' => 'أحمد']));

        $response->assertStatus(200);
        $response->assertSee('أحمد العلي');
        $response->assertDontSee('فاطمة الزهراء');
    }

    /**
     * اختبار تصفية الموظفين حسب القسم
     */
    public function test_employee_department_filtering()
    {
        $otherDepartment = Department::factory()->create([
            'name' => 'قسم المبيعات',
            'company_id' => $this->company->id
        ]);

        Employee::factory()->create([
            'first_name' => 'سعد',
            'department_id' => $this->department->id,
            'company_id' => $this->company->id,
        ]);

        Employee::factory()->create([
            'first_name' => 'ليلى',
            'department_id' => $otherDepartment->id,
            'company_id' => $this->company->id,
        ]);

        $response = $this->get(route('employees.index', ['department_id' => $this->department->id]));

        $response->assertStatus(200);
        $response->assertSee('سعد');
        $response->assertDontSee('ليلى');
    }

    /**
     * اختبار إنشاء تقرير الموظفين
     */
    public function test_generate_employee_report()
    {
        // إنشاء عدة موظفين
        Employee::factory()->count(5)->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
        ]);

        $reportData = [
            'report_type' => 'employee_list',
            'department_id' => $this->department->id,
            'status' => 'active',
            'company_id' => $this->company->id,
        ];

        $response = $this->post(route('employees.reports.generate'), $reportData);

        $response->assertStatus(200);
        $response->assertViewHas('employees');
        $response->assertViewHas('reportData');
        $response->assertViewIs('employees.reports.employee_list');
    }

    /**
     * اختبار حساب رصيد الإجازات
     */
    public function test_calculate_leave_balance()
    {
        $employee = Employee::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
            'user_id' => $this->employee->id,
            'hire_date' => now()->subYears(1), // موظف منذ سنة
        ]);

        // افتراض أن الموظف يحصل على 30 يوم إجازة سنوية
        $annualLeaveEntitlement = 30;

        // إنشاء إجازات مستخدمة
        \App\Models\Leave::factory()->count(5)->create([
            'employee_id' => $employee->id,
            'leave_type' => 'annual',
            'days_count' => 1, // يوم واحد لكل إجازة
            'status' => 'approved',
            'company_id' => $this->company->id,
        ]);

        // حساب رصيد الإجازات
        $usedLeave = \App\Models\Leave::where('employee_id', $employee->id)
            ->where('leave_type', 'annual')
            ->where('status', 'approved')
            ->sum('days_count');

        $remainingLeave = $annualLeaveEntitlement - $usedLeave;

        $this->assertEquals(25, $remainingLeave); // 30 - 5 = 25
    }

    /**
     * اختبار إنشاء جدول الرواتب
     */
    public function test_generate_payroll()
    {
        $employee = Employee::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
            'user_id' => $this->employee->id,
            'salary' => 8000.00,
        ]);

        // إنشاء سجلات حضور للشهر
        for ($i = 1; $i <= 22; $i++) {
            Attendance::factory()->create([
                'employee_id' => $employee->id,
                'date' => now()->startOfMonth()->addDays($i - 1),
                'work_hours' => 8.00,
                'status' => 'present',
                'company_id' => $this->company->id,
            ]);
        }

        $payrollData = [
            'employee_id' => $employee->id,
            'pay_period' => now()->format('Y-m'),
            'basic_salary' => 8000.00,
            'worked_hours' => 176.00, // 22 يوم × 8 ساعات
            'overtime_hours' => 0.00,
            'deductions' => 400.00, // استقطاعات
            'bonuses' => 200.00, // مكافآت
            'net_salary' => 7800.00,
            'company_id' => $this->company->id,
        ];

        $response = $this->post(route('employees.payroll.store'), $payrollData);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'تم حفظ بيانات الراتب بنجاح');

        $this->assertDatabaseHas('payrolls', [
            'employee_id' => $employee->id,
            'pay_period' => now()->format('Y-m'),
            'basic_salary' => 8000.00,
            'net_salary' => 7800.00,
        ]);
    }

    /**
     * اختبار إدارة المهارات والكفاءات
     */
    public function test_manage_employee_skills()
    {
        $employee = Employee::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
            'user_id' => $this->employee->id,
        ]);

        $skillData = [
            'employee_id' => $employee->id,
            'skill_name' => 'PHP Programming',
            'proficiency_level' => 'expert',
            'certification_name' => 'Zend Certified PHP Engineer',
            'certification_date' => now()->subYears(2)->format('Y-m-d'),
            'expiry_date' => now()->addYears(2)->format('Y-m-d'),
            'company_id' => $this->company->id,
        ];

        $response = $this->post(route('employees.skills.store', $employee), $skillData);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'تم حفظ المهارة بنجاح');

        $this->assertDatabaseHas('employee_skills', [
            'employee_id' => $employee->id,
            'skill_name' => 'PHP Programming',
            'proficiency_level' => 'expert',
        ]);
    }

    /**
     * اختبار تصدير بيانات الموظفين
     */
    public function test_export_employee_data()
    {
        Employee::factory()->count(10)->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
        ]);

        $exportData = [
            'format' => 'excel',
            'department_id' => $this->department->id,
            'status' => 'active',
            'include_attendance' => true,
            'include_salaries' => false, // لأسباب أمنية
        ];

        $response = $this->post(route('employees.export'), $exportData);

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->assertHeader('Content-Disposition', 'attachment; filename*=UTF-8\'\'employees-' . now()->format('Y-m-d') . '.xlsx');
    }
}

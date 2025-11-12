<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Company;
use App\Models\Department;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class ProjectManagementTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;
    protected $company;
    protected $department;
    protected $projectManager;
    protected $teamMember;

    protected function setUp(): void
    {
        parent::setUp();

        // إنشاء بيانات الاختبار الأساسية
        $this->company = Company::factory()->create();
        $this->department = Department::factory()->create(['company_id' => $this->company->id]);

        // مدير المشاريع
        $this->projectManager = User::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
        ]);

        // عضو الفريق
        $this->teamMember = User::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
        ]);

        // المستخدم الحالي
        $this->user = $this->projectManager;
        $this->actingAs($this->user);
    }

    /**
     * اختبار صفحة قائمة المشاريع
     */
    public function test_projects_index_page_loads()
    {
        $response = $this->get(route('projects.index'));

        $response->assertStatus(200);
        $response->assertViewHas('pageTitle', 'إدارة المشاريع');
        $response->assertViewIs('projects.index');
    }

    /**
     * اختبار إنشاء مشروع جديد
     */
    public function test_create_project()
    {
        $projectData = [
            'name' => 'مشروع تطوير نظام ERP',
            'description' => 'مشروع تطوير نظام إدارة موارد شامل',
            'project_code' => 'ERP-001',
            'status' => 'planning',
            'priority' => 'high',
            'start_date' => now()->format('Y-m-d'),
            'end_date' => now()->addMonths(6)->format('Y-m-d'),
            'budget' => 50000.00,
            'estimated_hours' => 1000,
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
            'project_manager_id' => $this->projectManager->id,
            'team_members' => [$this->teamMember->id],
        ];

        $response = $this->post(route('projects.store'), $projectData);

        $response->assertRedirect(route('projects.index'));
        $response->assertSessionHas('success', 'تم حفظ المشروع بنجاح');

        $this->assertDatabaseHas('projects', [
            'name' => 'مشروع تطوير نظام ERP',
            'project_code' => 'ERP-001',
            'status' => 'planning',
            'company_id' => $this->company->id,
            'project_manager_id' => $this->projectManager->id,
        ]);

        // التحقق من إضافة أعضاء الفريق
        $project = Project::where('project_code', 'ERP-001')->first();
        $this->assertDatabaseHas('project_team_members', [
            'project_id' => $project->id,
            'user_id' => $this->teamMember->id,
        ]);
    }

    /**
     * اختبار عرض تفاصيل المشروع
     */
    public function test_project_show_page()
    {
        $project = Project::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
            'project_manager_id' => $this->projectManager->id,
        ]);

        $response = $this->get(route('projects.show', $project));

        $response->assertStatus(200);
        $response->assertViewHas('project', $project);
        $response->assertViewIs('projects.show');
    }

    /**
     * اختبار تحديث المشروع
     */
    public function test_project_update()
    {
        $project = Project::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
            'project_manager_id' => $this->projectManager->id,
        ]);

        $updateData = [
            'name' => 'اسم المشروع المحدث',
            'description' => 'وصف محدث للمشروع',
            'status' => 'in_progress',
            'priority' => 'critical',
            'progress_percentage' => 25,
            'actual_hours' => 200,
        ];

        $response = $this->put(route('projects.update', $project), $updateData);

        $response->assertRedirect(route('projects.show', $project));
        $response->assertSessionHas('success', 'تم تحديث المشروع بنجاح');

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'name' => 'اسم المشروع المحدث',
            'status' => 'in_progress',
            'priority' => 'critical',
            'progress_percentage' => 25,
        ]);
    }

    /**
     * اختبار حذف المشروع
     */
    public function test_project_destroy()
    {
        $project = Project::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
            'project_manager_id' => $this->projectManager->id,
        ]);

        $response = $this->delete(route('projects.destroy', $project));

        $response->assertRedirect(route('projects.index'));
        $response->assertSessionHas('success', 'تم حذف المشروع بنجاح');

        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }

    /**
     * اختبار إنشاء مهمة جديدة في المشروع
     */
    public function test_create_project_task()
    {
        $project = Project::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
            'project_manager_id' => $this->projectManager->id,
        ]);

        $taskData = [
            'project_id' => $project->id,
            'title' => 'تطوير واجهة المستخدم',
            'description' => 'تصميم وتطوير واجهة المستخدم للنظام',
            'priority' => 'high',
            'status' => 'todo',
            'estimated_hours' => 40,
            'due_date' => now()->addWeeks(2)->format('Y-m-d'),
            'assigned_to' => $this->teamMember->id,
            'created_by' => $this->projectManager->id,
        ];

        $response = $this->post(route('projects.tasks.store', $project), $taskData);

        $response->assertRedirect(route('projects.show', $project));
        $response->assertSessionHas('success', 'تم حفظ المهمة بنجاح');

        $this->assertDatabaseHas('tasks', [
            'project_id' => $project->id,
            'title' => 'تطوير واجهة المستخدم',
            'assigned_to' => $this->teamMember->id,
            'status' => 'todo',
        ]);
    }

    /**
     * اختبار تحديث حالة المهمة
     */
    public function test_update_task_status()
    {
        $project = Project::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
            'project_manager_id' => $this->projectManager->id,
        ]);

        $task = Task::factory()->create([
            'project_id' => $project->id,
            'assigned_to' => $this->teamMember->id,
            'status' => 'todo',
        ]);

        $statusUpdate = [
            'status' => 'in_progress',
            'actual_hours' => 10,
            'progress_percentage' => 50,
        ];

        $response = $this->put(route('projects.tasks.update', [$project, $task]), $statusUpdate);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'تم تحديث المهمة بنجاح');

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => 'in_progress',
            'actual_hours' => 10,
            'progress_percentage' => 50,
        ]);
    }

    /**
     * اختبار إضافة تعليق على المهمة
     */
    public function test_add_task_comment()
    {
        $project = Project::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
            'project_manager_id' => $this->projectManager->id,
        ]);

        $task = Task::factory()->create([
            'project_id' => $project->id,
            'assigned_to' => $this->teamMember->id,
        ]);

        $commentData = [
            'task_id' => $task->id,
            'comment' => 'تم إكمال الجزء الأول من المهمة',
            'user_id' => $this->teamMember->id,
        ];

        $response = $this->post(route('projects.tasks.comments.store', [$project, $task]), $commentData);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'تم إضافة التعليق بنجاح');

        $this->assertDatabaseHas('task_comments', [
            'task_id' => $task->id,
            'comment' => 'تم إكمال الجزء الأول من المهمة',
            'user_id' => $this->teamMember->id,
        ]);
    }

    /**
     * اختبار إنشاء تقرير المشروع
     */
    public function test_generate_project_report()
    {
        $project = Project::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
            'project_manager_id' => $this->projectManager->id,
            'start_date' => now()->subDays(30),
            'end_date' => now()->addDays(30),
        ]);

        // إنشاء بعض المهام
        Task::factory()->count(5)->create([
            'project_id' => $project->id,
            'assigned_to' => $this->teamMember->id,
        ]);

        $reportData = [
            'project_id' => $project->id,
            'report_type' => 'progress',
            'start_date' => now()->subDays(30)->format('Y-m-d'),
            'end_date' => now()->format('Y-m-d'),
        ];

        $response = $this->post(route('projects.reports.generate'), $reportData);

        $response->assertStatus(200);
        $response->assertViewHas('project');
        $response->assertViewHas('reportData');
        $response->assertViewIs('projects.reports.progress');
    }

    /**
     * اختبار حساب تقدم المشروع تلقائياً
     */
    public function test_project_progress_calculation()
    {
        $project = Project::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
            'project_manager_id' => $this->projectManager->id,
        ]);

        // إنشاء 4 مهام
        $tasks = Task::factory()->count(4)->create([
            'project_id' => $project->id,
            'assigned_to' => $this->teamMember->id,
            'estimated_hours' => 10,
        ]);

        // إكمال 2 مهام
        $tasks[0]->update(['status' => 'completed', 'progress_percentage' => 100]);
        $tasks[1]->update(['status' => 'completed', 'progress_percentage' => 100]);

        // تحديث تقدم المشروع
        $project->recalculateProgress();

        $this->assertEquals(50, $project->fresh()->progress_percentage); // 2 من 4 مهام مكتملة
    }

    /**
     * اختبار البحث في المشاريع
     */
    public function test_project_search_functionality()
    {
        Project::factory()->create([
            'name' => 'مشروع تطوير الموقع',
            'description' => 'تطوير موقع إلكتروني',
            'company_id' => $this->company->id,
            'project_manager_id' => $this->projectManager->id,
        ]);

        Project::factory()->create([
            'name' => 'مشروع التطبيق المحمول',
            'description' => 'تطوير تطبيق محمول',
            'company_id' => $this->company->id,
            'project_manager_id' => $this->projectManager->id,
        ]);

        $response = $this->get(route('projects.index', ['search' => 'موقع']));

        $response->assertStatus(200);
        $response->assertSee('مشروع تطوير الموقع');
        $response->assertDontSee('مشروع التطبيق المحمول');
    }

    /**
     * اختبار تصفية المشاريع حسب الحالة
     */
    public function test_project_status_filtering()
    {
        Project::factory()->create([
            'name' => 'مشروع مكتمل',
            'status' => 'completed',
            'company_id' => $this->company->id,
            'project_manager_id' => $this->projectManager->id,
        ]);

        Project::factory()->create([
            'name' => 'مشروع قيد التنفيذ',
            'status' => 'in_progress',
            'company_id' => $this->company->id,
            'project_manager_id' => $this->projectManager->id,
        ]);

        $response = $this->get(route('projects.index', ['status' => 'completed']));

        $response->assertStatus(200);
        $response->assertSee('مشروع مكتمل');
        $response->assertDontSee('مشروع قيد التنفيذ');
    }

    /**
     * اختبار إدارة أعضاء الفريق
     */
    public function test_manage_team_members()
    {
        $project = Project::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
            'project_manager_id' => $this->projectManager->id,
        ]);

        // إضافة عضو جديد للفريق
        $newMember = User::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
        ]);

        $teamData = [
            'user_id' => $newMember->id,
            'role' => 'developer',
            'allocation_percentage' => 50,
        ];

        $response = $this->post(route('projects.team.store', $project), $teamData);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'تم إضافة العضو للفريق بنجاح');

        $this->assertDatabaseHas('project_team_members', [
            'project_id' => $project->id,
            'user_id' => $newMember->id,
            'role' => 'developer',
        ]);
    }

    /**
     * اختبار إنشاء معالم المشروع (Milestones)
     */
    public function test_create_project_milestone()
    {
        $project = Project::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
            'project_manager_id' => $this->projectManager->id,
        ]);

        $milestoneData = [
            'project_id' => $project->id,
            'title' => 'إكمال المرحلة الأولى',
            'description' => 'إكمال جميع المهام في المرحلة الأولى',
            'due_date' => now()->addWeeks(4)->format('Y-m-d'),
            'status' => 'pending',
            'progress_percentage' => 0,
        ];

        $response = $this->post(route('projects.milestones.store', $project), $milestoneData);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'تم إنشاء المعلم بنجاح');

        $this->assertDatabaseHas('project_milestones', [
            'project_id' => $project->id,
            'title' => 'إكمال المرحلة الأولى',
            'status' => 'pending',
        ]);
    }

    /**
     * اختبار إنشاء مخطط جانت للمشروع
     */
    public function test_generate_gantt_chart()
    {
        $project = Project::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
            'project_manager_id' => $this->projectManager->id,
        ]);

        // إنشاء مهام مع تواريخ مختلفة
        Task::factory()->create([
            'project_id' => $project->id,
            'title' => 'مهمة مبكرة',
            'start_date' => now()->addDays(1),
            'due_date' => now()->addDays(7),
            'assigned_to' => $this->teamMember->id,
        ]);

        Task::factory()->create([
            'project_id' => $project->id,
            'title' => 'مهمة متأخرة',
            'start_date' => now()->addDays(14),
            'due_date' => now()->addDays(21),
            'assigned_to' => $this->teamMember->id,
        ]);

        $response = $this->get(route('projects.gantt', $project));

        $response->assertStatus(200);
        $response->assertViewHas('project');
        $response->assertViewHas('tasks');
        $response->assertViewIs('projects.gantt');
    }

    /**
     * اختبار حساب التكاليف الفعلية للمشروع
     */
    public function test_project_cost_tracking()
    {
        $project = Project::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
            'project_manager_id' => $this->projectManager->id,
            'budget' => 10000.00,
        ]);

        // إنشاء مهام مع تكاليف
        Task::factory()->create([
            'project_id' => $project->id,
            'title' => 'مهمة مدفوعة',
            'actual_cost' => 1500.00,
            'assigned_to' => $this->teamMember->id,
        ]);

        Task::factory()->create([
            'project_id' => $project->id,
            'title' => 'مهمة أخرى مدفوعة',
            'actual_cost' => 2300.00,
            'assigned_to' => $this->teamMember->id,
        ]);

        // حساب التكلفة الإجمالية
        $totalCost = $project->tasks()->sum('actual_cost');

        $this->assertEquals(3800.00, $totalCost);

        // التحقق من نسبة الإنفاق
        $spendingRatio = ($totalCost / $project->budget) * 100;
        $this->assertEquals(38.00, round($spendingRatio, 2));
    }

    /**
     * اختبار إشعارات المشروع
     */
    public function test_project_notifications()
    {
        $project = Project::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
            'project_manager_id' => $this->projectManager->id,
            'end_date' => now()->addDays(2), // قريب من الانتهاء
        ]);

        // محاولة الحصول على الإشعارات
        $response = $this->get(route('projects.notifications', $project));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'notifications' => [
                '*' => [
                    'type',
                    'message',
                    'priority'
                ]
            ]
        ]);
    }

    /**
     * اختبار تصدير بيانات المشروع
     */
    public function test_export_project_data()
    {
        $project = Project::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
            'project_manager_id' => $this->projectManager->id,
        ]);

        Task::factory()->count(5)->create([
            'project_id' => $project->id,
            'assigned_to' => $this->teamMember->id,
        ]);

        $exportData = [
            'project_id' => $project->id,
            'format' => 'excel',
            'include_tasks' => true,
            'include_comments' => true,
        ];

        $response = $this->post(route('projects.export'), $exportData);

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->assertHeader('Content-Disposition', 'attachment; filename*=UTF-8\'\'project-' . $project->project_code . '-' . now()->format('Y-m-d') . '.xlsx');
    }
}

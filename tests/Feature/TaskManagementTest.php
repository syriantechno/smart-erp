<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Company;
use App\Models\Department;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class TaskManagementTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;
    protected $company;
    protected $department;
    protected $project;
    protected $teamMember;

    protected function setUp(): void
    {
        parent::setUp();

        // إنشاء بيانات الاختبار الأساسية
        $this->company = Company::factory()->create();
        $this->department = Department::factory()->create(['company_id' => $this->company->id]);
        $this->project = Project::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
        ]);

        $this->user = User::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
        ]);

        $this->teamMember = User::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
        ]);

        // تسجيل الدخول
        $this->actingAs($this->user);
    }

    /**
     * اختبار صفحة قائمة المهام
     */
    public function test_tasks_index_page_loads()
    {
        $response = $this->get(route('tasks.index'));

        $response->assertStatus(200);
        $response->assertViewHas('pageTitle', 'إدارة المهام');
        $response->assertViewIs('tasks.index');
    }

    /**
     * اختبار إنشاء مهمة جديدة
     */
    public function test_create_task()
    {
        $taskData = [
            'title' => 'تطوير واجهة المستخدم',
            'description' => 'تصميم وتطوير واجهة المستخدم الجديدة للنظام',
            'project_id' => $this->project->id,
            'priority' => 'high',
            'status' => 'todo',
            'estimated_hours' => 40,
            'due_date' => now()->addWeeks(2)->format('Y-m-d'),
            'assigned_to' => $this->teamMember->id,
            'created_by' => $this->user->id,
            'tags' => 'frontend,ui,ux',
            'company_id' => $this->company->id,
        ];

        $response = $this->post(route('tasks.store'), $taskData);

        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHas('success', 'تم حفظ المهمة بنجاح');

        $this->assertDatabaseHas('tasks', [
            'title' => 'تطوير واجهة المستخدم',
            'project_id' => $this->project->id,
            'assigned_to' => $this->teamMember->id,
            'created_by' => $this->user->id,
            'status' => 'todo',
            'priority' => 'high',
        ]);
    }

    /**
     * اختبار عرض تفاصيل المهمة
     */
    public function test_task_show_page()
    {
        $task = Task::factory()->create([
            'project_id' => $this->project->id,
            'assigned_to' => $this->teamMember->id,
            'created_by' => $this->user->id,
            'company_id' => $this->company->id,
        ]);

        $response = $this->get(route('tasks.show', $task));

        $response->assertStatus(200);
        $response->assertViewHas('task', $task);
        $response->assertViewIs('tasks.show');
    }

    /**
     * اختبار تحديث المهمة
     */
    public function test_task_update()
    {
        $task = Task::factory()->create([
            'project_id' => $this->project->id,
            'assigned_to' => $this->teamMember->id,
            'created_by' => $this->user->id,
            'company_id' => $this->company->id,
        ]);

        $updateData = [
            'title' => 'العنوان المحدث',
            'description' => 'الوصف المحدث',
            'priority' => 'critical',
            'status' => 'in_progress',
            'progress_percentage' => 25,
            'actual_hours' => 10,
        ];

        $response = $this->put(route('tasks.update', $task), $updateData);

        $response->assertRedirect(route('tasks.show', $task));
        $response->assertSessionHas('success', 'تم تحديث المهمة بنجاح');

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'العنوان المحدث',
            'priority' => 'critical',
            'status' => 'in_progress',
            'progress_percentage' => 25,
            'actual_hours' => 10,
        ]);
    }

    /**
     * اختبار حذف المهمة
     */
    public function test_task_destroy()
    {
        $task = Task::factory()->create([
            'project_id' => $this->project->id,
            'assigned_to' => $this->teamMember->id,
            'created_by' => $this->user->id,
            'company_id' => $this->company->id,
        ]);

        $response = $this->delete(route('tasks.destroy', $task));

        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHas('success', 'تم حذف المهمة بنجاح');

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    /**
     * اختبار إضافة تعليق على المهمة
     */
    public function test_add_task_comment()
    {
        $task = Task::factory()->create([
            'project_id' => $this->project->id,
            'assigned_to' => $this->teamMember->id,
            'created_by' => $this->user->id,
            'company_id' => $this->company->id,
        ]);

        $commentData = [
            'task_id' => $task->id,
            'comment' => 'تم إكمال المرحلة الأولى من المهمة بنجاح',
            'user_id' => $this->teamMember->id,
            'is_internal' => false,
            'company_id' => $this->company->id,
        ];

        $response = $this->post(route('tasks.comments.store', $task), $commentData);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'تم إضافة التعليق بنجاح');

        $this->assertDatabaseHas('task_comments', [
            'task_id' => $task->id,
            'comment' => 'تم إكمال المرحلة الأولى من المهمة بنجاح',
            'user_id' => $this->teamMember->id,
            'is_internal' => false,
        ]);
    }

    /**
     * اختبار رفع مرفق للمهمة
     */
    public function test_attach_file_to_task()
    {
        Storage::fake('public');

        $task = Task::factory()->create([
            'project_id' => $this->project->id,
            'assigned_to' => $this->teamMember->id,
            'created_by' => $this->user->id,
            'company_id' => $this->company->id,
        ]);

        $file = UploadedFile::fake()->create('task-attachment.pdf', 1024);

        $attachmentData = [
            'task_id' => $task->id,
            'file_name' => 'task-attachment.pdf',
            'file_path' => 'task-attachments/task-attachment.pdf',
            'file_type' => 'pdf',
            'file_size' => 1024,
            'mime_type' => 'application/pdf',
            'uploaded_by' => $this->user->id,
            'company_id' => $this->company->id,
        ];

        // محاكاة رفع الملف
        Storage::disk('public')->put('task-attachments/task-attachment.pdf', 'fake content');

        $response = $this->post(route('tasks.attachments.store', $task), $attachmentData);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'تم رفع المرفق بنجاح');

        $this->assertDatabaseHas('task_attachments', [
            'task_id' => $task->id,
            'file_name' => 'task-attachment.pdf',
            'uploaded_by' => $this->user->id,
        ]);
    }

    /**
     * اختبار تحديث حالة المهمة
     */
    public function test_update_task_status()
    {
        $task = Task::factory()->create([
            'project_id' => $this->project->id,
            'assigned_to' => $this->teamMember->id,
            'created_by' => $this->user->id,
            'status' => 'todo',
            'company_id' => $this->company->id,
        ]);

        $statusData = [
            'status' => 'in_progress',
            'progress_percentage' => 50,
            'actual_hours' => 20,
            'notes' => 'بدأت العمل على المهمة',
        ];

        $response = $this->put(route('tasks.status.update', $task), $statusData);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'تم تحديث حالة المهمة بنجاح');

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => 'in_progress',
            'progress_percentage' => 50,
            'actual_hours' => 20,
        ]);
    }

    /**
     * اختبار إعادة تعيين المهمة لمستخدم آخر
     */
    public function test_reassign_task()
    {
        $task = Task::factory()->create([
            'project_id' => $this->project->id,
            'assigned_to' => $this->teamMember->id,
            'created_by' => $this->user->id,
            'company_id' => $this->company->id,
        ]);

        $newAssignee = User::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
        ]);

        $reassignData = [
            'assigned_to' => $newAssignee->id,
            'reassignment_reason' => 'التوزيع الأمثل للمهام',
        ];

        $response = $this->put(route('tasks.reassign', $task), $reassignData);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'تم إعادة تعيين المهمة بنجاح');

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'assigned_to' => $newAssignee->id,
        ]);

        // التحقق من تسجيل إعادة التعيين
        $this->assertDatabaseHas('task_reassignments', [
            'task_id' => $task->id,
            'old_assignee_id' => $this->teamMember->id,
            'new_assignee_id' => $newAssignee->id,
            'reason' => 'التوزيع الأمثل للمهام',
        ]);
    }

    /**
     * اختبار إنشاء مهمة فرعية
     */
    public function test_create_subtask()
    {
        $parentTask = Task::factory()->create([
            'project_id' => $this->project->id,
            'assigned_to' => $this->teamMember->id,
            'created_by' => $this->user->id,
            'company_id' => $this->company->id,
        ]);

        $subtaskData = [
            'title' => 'مهمة فرعية 1',
            'description' => 'مهمة فرعية للمهمة الأساسية',
            'parent_id' => $parentTask->id,
            'project_id' => $this->project->id,
            'priority' => 'medium',
            'status' => 'todo',
            'estimated_hours' => 8,
            'assigned_to' => $this->teamMember->id,
            'created_by' => $this->user->id,
            'company_id' => $this->company->id,
        ];

        $response = $this->post(route('tasks.store'), $subtaskData);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'تم حفظ المهمة بنجاح');

        $this->assertDatabaseHas('tasks', [
            'title' => 'مهمة فرعية 1',
            'parent_id' => $parentTask->id,
            'project_id' => $this->project->id,
        ]);
    }

    /**
     * اختبار البحث في المهام
     */
    public function test_task_search_functionality()
    {
        Task::factory()->create([
            'title' => 'تطوير نظام المبيعات',
            'description' => 'تطوير شامل لنظام إدارة المبيعات',
            'project_id' => $this->project->id,
            'assigned_to' => $this->teamMember->id,
            'company_id' => $this->company->id,
        ]);

        Task::factory()->create([
            'title' => 'تصميم واجهة المستخدم',
            'description' => 'تصميم جذاب لواجهة المستخدم',
            'project_id' => $this->project->id,
            'assigned_to' => $this->teamMember->id,
            'company_id' => $this->company->id,
        ]);

        $response = $this->get(route('tasks.index', ['search' => 'تطوير']));

        $response->assertStatus(200);
        $response->assertSee('تطوير نظام المبيعات');
        $response->assertDontSee('تصميم واجهة المستخدم');
    }

    /**
     * اختبار تصفية المهام حسب الحالة
     */
    public function test_task_status_filtering()
    {
        Task::factory()->create([
            'title' => 'مهمة مكتملة',
            'status' => 'completed',
            'project_id' => $this->project->id,
            'assigned_to' => $this->teamMember->id,
            'company_id' => $this->company->id,
        ]);

        Task::factory()->create([
            'title' => 'مهمة قيد التنفيذ',
            'status' => 'in_progress',
            'project_id' => $this->project->id,
            'assigned_to' => $this->teamMember->id,
            'company_id' => $this->company->id,
        ]);

        $response = $this->get(route('tasks.index', ['status' => 'completed']));

        $response->assertStatus(200);
        $response->assertSee('مهمة مكتملة');
        $response->assertDontSee('مهمة قيد التنفيذ');
    }

    /**
     * اختبار تصفية المهام حسب المشروع
     */
    public function test_task_project_filtering()
    {
        $otherProject = Project::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
        ]);

        Task::factory()->create([
            'title' => 'مهمة في المشروع الأول',
            'project_id' => $this->project->id,
            'assigned_to' => $this->teamMember->id,
            'company_id' => $this->company->id,
        ]);

        Task::factory()->create([
            'title' => 'مهمة في المشروع الثاني',
            'project_id' => $otherProject->id,
            'assigned_to' => $this->teamMember->id,
            'company_id' => $this->company->id,
        ]);

        $response = $this->get(route('tasks.index', ['project_id' => $this->project->id]));

        $response->assertStatus(200);
        $response->assertSee('مهمة في المشروع الأول');
        $response->assertDontSee('مهمة في المشروع الثاني');
    }

    /**
     * اختبار تصفية المهام حسب المستخدم المكلف
     */
    public function test_task_assignee_filtering()
    {
        $otherUser = User::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
        ]);

        Task::factory()->create([
            'title' => 'مهمة للعضو الأول',
            'assigned_to' => $this->teamMember->id,
            'project_id' => $this->project->id,
            'company_id' => $this->company->id,
        ]);

        Task::factory()->create([
            'title' => 'مهمة للعضو الثاني',
            'assigned_to' => $otherUser->id,
            'project_id' => $this->project->id,
            'company_id' => $this->company->id,
        ]);

        $response = $this->get(route('tasks.index', ['assigned_to' => $this->teamMember->id]));

        $response->assertStatus(200);
        $response->assertSee('مهمة للعضو الأول');
        $response->assertDontSee('مهمة للعضو الثاني');
    }

    /**
     * اختبار حساب تقدم المشروع من المهام
     */
    public function test_project_progress_from_tasks()
    {
        // إنشاء مشروع جديد
        $testProject = Project::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
        ]);

        // إنشاء 4 مهام للمشروع
        $tasks = Task::factory()->count(4)->create([
            'project_id' => $testProject->id,
            'assigned_to' => $this->teamMember->id,
            'company_id' => $this->company->id,
            'estimated_hours' => 10,
        ]);

        // إكمال 2 مهام
        $tasks[0]->update(['status' => 'completed', 'progress_percentage' => 100]);
        $tasks[1]->update(['status' => 'completed', 'progress_percentage' => 100]);

        // إعادة حساب تقدم المشروع
        $testProject->recalculateProgress();

        $this->assertEquals(50, $testProject->fresh()->progress_percentage); // 2 من 4 مهام مكتملة
    }

    /**
     * اختبار إنشاء تقرير المهام
     */
    public function test_generate_task_report()
    {
        // إنشاء مهام متعددة
        Task::factory()->count(10)->create([
            'project_id' => $this->project->id,
            'assigned_to' => $this->teamMember->id,
            'company_id' => $this->company->id,
        ]);

        $reportData = [
            'project_id' => $this->project->id,
            'report_type' => 'task_summary',
            'start_date' => now()->startOfMonth()->format('Y-m-d'),
            'end_date' => now()->endOfMonth()->format('Y-m-d'),
            'status' => 'all',
        ];

        $response = $this->post(route('tasks.reports.generate'), $reportData);

        $response->assertStatus(200);
        $response->assertViewHas('tasks');
        $response->assertViewHas('reportData');
        $response->assertViewIs('tasks.reports.task_summary');
    }

    /**
     * اختبار إضافة وقت للمهمة (Time Tracking)
     */
    public function test_add_time_entry_to_task()
    {
        $task = Task::factory()->create([
            'project_id' => $this->project->id,
            'assigned_to' => $this->teamMember->id,
            'created_by' => $this->user->id,
            'company_id' => $this->company->id,
        ]);

        $timeEntryData = [
            'task_id' => $task->id,
            'user_id' => $this->teamMember->id,
            'date' => now()->format('Y-m-d'),
            'hours' => 4.5,
            'description' => 'العمل على تطوير الميزة الجديدة',
            'billable' => true,
            'company_id' => $this->company->id,
        ];

        $response = $this->post(route('tasks.time-entries.store', $task), $timeEntryData);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'تم تسجيل الوقت بنجاح');

        $this->assertDatabaseHas('task_time_entries', [
            'task_id' => $task->id,
            'user_id' => $this->teamMember->id,
            'hours' => 4.5,
            'billable' => true,
        ]);

        // التحقق من تحديث ساعات العمل الفعلية للمهمة
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'actual_hours' => 4.5,
        ]);
    }

    /**
     * اختبار إنشاء قالب مهمة
     */
    public function test_create_task_template()
    {
        $templateData = [
            'name' => 'قالب تطوير الميزة',
            'description' => 'قالب لمهام تطوير الميزات الجديدة',
            'category' => 'development',
            'estimated_hours' => 40,
            'priority' => 'high',
            'checklist_items' => [
                'تحليل المتطلبات',
                'تصميم الحل',
                'كتابة الكود',
                'الاختبار',
                'التوثيق'
            ],
            'company_id' => $this->company->id,
            'created_by' => $this->user->id,
        ];

        $response = $this->post(route('tasks.templates.store'), $templateData);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'تم حفظ القالب بنجاح');

        $this->assertDatabaseHas('task_templates', [
            'name' => 'قالب تطوير الميزة',
            'category' => 'development',
            'company_id' => $this->company->id,
        ]);
    }

    /**
     * اختبار إنشاء مهمة من قالب
     */
    public function test_create_task_from_template()
    {
        // إنشاء قالب أولاً
        $template = \App\Models\TaskTemplate::factory()->create([
            'company_id' => $this->company->id,
            'created_by' => $this->user->id,
        ]);

        $taskData = [
            'template_id' => $template->id,
            'title' => 'ميزة جديدة من القالب',
            'project_id' => $this->project->id,
            'assigned_to' => $this->teamMember->id,
            'due_date' => now()->addWeeks(3)->format('Y-m-d'),
            'company_id' => $this->company->id,
        ];

        $response = $this->post(route('tasks.create-from-template'), $taskData);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'تم إنشاء المهمة من القالب بنجاح');

        $this->assertDatabaseHas('tasks', [
            'title' => 'ميزة جديدة من القالب',
            'project_id' => $this->project->id,
            'assigned_to' => $this->teamMember->id,
        ]);
    }

    /**
     * اختبار إشعارات المهام
     */
    public function test_task_notifications()
    {
        $task = Task::factory()->create([
            'title' => 'مهمة قريبة من الموعد النهائي',
            'due_date' => now()->addDays(1), // غداً
            'assigned_to' => $this->teamMember->id,
            'project_id' => $this->project->id,
            'company_id' => $this->company->id,
        ]);

        // محاولة الحصول على الإشعارات
        $response = $this->get(route('tasks.notifications', $this->teamMember));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'notifications' => [
                '*' => [
                    'type',
                    'message',
                    'task_id',
                    'priority'
                ]
            ]
        ]);
    }

    /**
     * اختبار تصدير بيانات المهام
     */
    public function test_export_task_data()
    {
        Task::factory()->count(15)->create([
            'project_id' => $this->project->id,
            'assigned_to' => $this->teamMember->id,
            'company_id' => $this->company->id,
        ]);

        $exportData = [
            'project_id' => $this->project->id,
            'format' => 'excel',
            'start_date' => now()->startOfMonth()->format('Y-m-d'),
            'end_date' => now()->endOfMonth()->format('Y-m-d'),
            'include_comments' => true,
            'include_attachments' => false,
        ];

        $response = $this->post(route('tasks.export'), $exportData);

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->assertHeader('Content-Disposition', 'attachment; filename*=UTF-8\'\'tasks-' . $this->project->project_code . '-' . now()->format('Y-m-d') . '.xlsx');
    }
}

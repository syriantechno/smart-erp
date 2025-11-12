<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Company;
use App\Models\Department;
use App\Models\ElectronicMail;
use App\Models\EmailTemplate;
use App\Models\EmailSignature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class ElectronicMailTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;
    protected $company;
    protected $department;
    protected $recipient;

    protected function setUp(): void
    {
        parent::setUp();

        // إنشاء بيانات الاختبار الأساسية
        $this->company = Company::factory()->create();
        $this->department = Department::factory()->create(['company_id' => $this->company->id]);

        $this->user = User::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
        ]);

        $this->recipient = User::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
        ]);

        // تسجيل الدخول
        $this->actingAs($this->user);
    }

    /**
     * اختبار صفحة قائمة البريد الإلكتروني
     */
    public function test_email_index_page_loads()
    {
        $response = $this->get(route('electronic-mail.index'));

        $response->assertStatus(200);
        $response->assertViewHas('pageTitle', 'البريد الإلكتروني');
        $response->assertViewIs('electronic-mail.index');
    }

    /**
     * اختبار صفحة إنشاء بريد إلكتروني جديد
     */
    public function test_email_compose_page_loads()
    {
        $response = $this->get(route('electronic-mail.compose'));

        $response->assertStatus(200);
        $response->assertViewIs('electronic-mail.compose');
    }

    /**
     * اختبار إرسال بريد إلكتروني جديد
     */
    public function test_send_email()
    {
        Mail::fake();

        $emailData = [
            'to' => [$this->recipient->email],
            'cc' => [],
            'bcc' => [],
            'subject' => 'رسالة تجريبية',
            'body' => 'هذا هو محتوى الرسالة التجريبية',
            'priority' => 'normal',
            'has_attachments' => false,
            'sender_id' => $this->user->id,
            'company_id' => $this->company->id,
        ];

        $response = $this->post(route('electronic-mail.send'), $emailData);

        $response->assertRedirect(route('electronic-mail.sent'));
        $response->assertSessionHas('success', 'تم إرسال البريد الإلكتروني بنجاح');

        $this->assertDatabaseHas('electronic_mails', [
            'subject' => 'رسالة تجريبية',
            'sender_id' => $this->user->id,
            'folder' => 'sent',
        ]);

        // التحقق من إرسال البريد
        Mail::assertSent(\App\Mail\SendEmail::class, function ($mail) {
            return $mail->hasTo($this->recipient->email) &&
                   $mail->subject === 'رسالة تجريبية';
        });
    }

    /**
     * اختبار إرسال بريد إلكتروني مع مرفق
     */
    public function test_send_email_with_attachment()
    {
        Mail::fake();
        Storage::fake('public');

        $file = UploadedFile::fake()->create('attachment.pdf', 1024);

        $emailData = [
            'to' => [$this->recipient->email],
            'cc' => [],
            'bcc' => [],
            'subject' => 'بريد مع مرفق',
            'body' => 'هذا البريد يحتوي على مرفق',
            'priority' => 'high',
            'has_attachments' => true,
            'attachments' => [$file],
            'sender_id' => $this->user->id,
            'company_id' => $this->company->id,
        ];

        $response = $this->post(route('electronic-mail.send'), $emailData);

        $response->assertRedirect(route('electronic-mail.sent'));
        $response->assertSessionHas('success', 'تم إرسال البريد الإلكتروني بنجاح');

        // التحقق من حفظ المرفق
        $email = ElectronicMail::where('subject', 'بريد مع مرفق')->first();
        $this->assertNotNull($email);

        $this->assertDatabaseHas('email_attachments', [
            'email_id' => $email->id,
            'file_name' => 'attachment.pdf',
        ]);
    }

    /**
     * اختبار عرض بريد إلكتروني
     */
    public function test_email_show_page()
    {
        $email = ElectronicMail::factory()->create([
            'sender_id' => $this->user->id,
            'company_id' => $this->company->id,
            'folder' => 'inbox',
        ]);

        $response = $this->get(route('electronic-mail.show', $email));

        $response->assertStatus(200);
        $response->assertViewHas('email', $email);
        $response->assertViewIs('electronic-mail.show');
    }

    /**
     * اختبار حذف بريد إلكتروني
     */
    public function test_email_destroy()
    {
        $email = ElectronicMail::factory()->create([
            'sender_id' => $this->user->id,
            'company_id' => $this->company->id,
        ]);

        $response = $this->delete(route('electronic-mail.destroy', $email));

        $response->assertRedirect(route('electronic-mail.index'));
        $response->assertSessionHas('success', 'تم حذف البريد الإلكتروني بنجاح');

        $this->assertDatabaseMissing('electronic_mails', ['id' => $email->id]);
    }

    /**
     * اختبار نقل بريد إلكتروني إلى مجلد آخر
     */
    public function test_move_email_to_folder()
    {
        $email = ElectronicMail::factory()->create([
            'sender_id' => $this->user->id,
            'company_id' => $this->company->id,
            'folder' => 'inbox',
        ]);

        $moveData = [
            'folder' => 'archive',
        ];

        $response = $this->put(route('electronic-mail.move', $email), $moveData);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'تم نقل البريد الإلكتروني بنجاح');

        $this->assertDatabaseHas('electronic_mails', [
            'id' => $email->id,
            'folder' => 'archive',
        ]);
    }

    /**
     * اختبار وضع علامة على البريد الإلكتروني
     */
    public function test_star_email()
    {
        $email = ElectronicMail::factory()->create([
            'sender_id' => $this->user->id,
            'company_id' => $this->company->id,
            'is_starred' => false,
        ]);

        $response = $this->post(route('electronic-mail.star', $email));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'تم تحديث حالة النجمة',
        ]);

        $this->assertDatabaseHas('electronic_mails', [
            'id' => $email->id,
            'is_starred' => true,
        ]);
    }

    /**
     * اختبار وضع علامة مقروء/غير مقروء
     */
    public function test_mark_email_as_read()
    {
        $email = ElectronicMail::factory()->create([
            'sender_id' => $this->user->id,
            'company_id' => $this->company->id,
            'is_read' => false,
        ]);

        $response = $this->post(route('electronic-mail.mark-read', $email));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'تم تحديث حالة القراءة',
        ]);

        $this->assertDatabaseHas('electronic_mails', [
            'id' => $email->id,
            'is_read' => true,
        ]);
    }

    /**
     * اختبار البحث في البريد الإلكتروني
     */
    public function test_email_search_functionality()
    {
        ElectronicMail::factory()->create([
            'subject' => 'تقرير المبيعات الشهري',
            'body' => 'هذا التقرير يحتوي على تحليل المبيعات',
            'sender_id' => $this->user->id,
            'company_id' => $this->company->id,
        ]);

        ElectronicMail::factory()->create([
            'subject' => 'فاتورة الشراء',
            'body' => 'تفاصيل الفاتورة والمبلغ المستحق',
            'sender_id' => $this->user->id,
            'company_id' => $this->company->id,
        ]);

        $response = $this->get(route('electronic-mail.index', ['search' => 'تقرير']));

        $response->assertStatus(200);
        $response->assertSee('تقرير المبيعات الشهري');
        $response->assertDontSee('فاتورة الشراء');
    }

    /**
     * اختبار تصفية البريد حسب المجلد
     */
    public function test_email_folder_filtering()
    {
        ElectronicMail::factory()->create([
            'subject' => 'بريد في الوارد',
            'folder' => 'inbox',
            'sender_id' => $this->user->id,
            'company_id' => $this->company->id,
        ]);

        ElectronicMail::factory()->create([
            'subject' => 'بريد مرسل',
            'folder' => 'sent',
            'sender_id' => $this->user->id,
            'company_id' => $this->company->id,
        ]);

        $response = $this->get(route('electronic-mail.index', ['folder' => 'inbox']));

        $response->assertStatus(200);
        $response->assertSee('بريد في الوارد');
        $response->assertDontSee('بريد مرسل');
    }

    /**
     * اختبار إنشاء توقيع بريد إلكتروني
     */
    public function test_create_email_signature()
    {
        $signatureData = [
            'name' => 'التوقيع الرسمي',
            'content' => '<p>مع خالص التحية<br>مدير قسم تقنية المعلومات<br>شركة تجريبية</p>',
            'is_default' => true,
            'user_id' => $this->user->id,
            'company_id' => $this->company->id,
        ];

        $response = $this->post(route('electronic-mail.signatures.store'), $signatureData);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'تم حفظ التوقيع بنجاح');

        $this->assertDatabaseHas('email_signatures', [
            'name' => 'التوقيع الرسمي',
            'user_id' => $this->user->id,
            'is_default' => true,
        ]);
    }

    /**
     * اختبار إنشاء قالب بريد إلكتروني
     */
    public function test_create_email_template()
    {
        $templateData = [
            'name' => 'قالب الرد على الاستفسارات',
            'subject' => 'رد على استفساركم',
            'content' => '<p>عزيزي العميل،</p><p>نشكركم على تواصلكم معنا.</p><p>مع خالص التحية</p>',
            'category' => 'customer_service',
            'is_public' => true,
            'user_id' => $this->user->id,
            'company_id' => $this->company->id,
        ];

        $response = $this->post(route('electronic-mail.templates.store'), $templateData);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'تم حفظ القالب بنجاح');

        $this->assertDatabaseHas('email_templates', [
            'name' => 'قالب الرد على الاستفسارات',
            'category' => 'customer_service',
            'is_public' => true,
        ]);
    }

    /**
     * اختبار استخدام قالب في إرسال بريد
     */
    public function test_send_email_using_template()
    {
        Mail::fake();

        // إنشاء قالب
        $template = EmailTemplate::factory()->create([
            'user_id' => $this->user->id,
            'company_id' => $this->company->id,
        ]);

        $emailData = [
            'template_id' => $template->id,
            'to' => [$this->recipient->email],
            'cc' => [],
            'bcc' => [],
            'sender_id' => $this->user->id,
            'company_id' => $this->company->id,
        ];

        $response = $this->post(route('electronic-mail.send-template'), $emailData);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'تم إرسال البريد الإلكتروني بنجاح');

        $this->assertDatabaseHas('electronic_mails', [
            'sender_id' => $this->user->id,
            'template_id' => $template->id,
        ]);
    }

    /**
     * اختبار إنشاء مجلد مخصص
     */
    public function test_create_custom_folder()
    {
        $folderData = [
            'name' => 'مشروع ERP',
            'color' => '#FF5733',
            'icon' => 'folder',
            'parent_id' => null,
            'user_id' => $this->user->id,
            'company_id' => $this->company->id,
        ];

        $response = $this->post(route('electronic-mail.folders.store'), $folderData);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'تم إنشاء المجلد بنجاح');

        $this->assertDatabaseHas('email_folders', [
            'name' => 'مشروع ERP',
            'user_id' => $this->user->id,
            'color' => '#FF5733',
        ]);
    }

    /**
     * اختبار إنشاء قاعدة تصفية تلقائية
     */
    public function test_create_filter_rule()
    {
        $ruleData = [
            'name' => 'رسائل العملاء',
            'conditions' => [
                ['field' => 'from', 'operator' => 'contains', 'value' => '@customer.com'],
            ],
            'actions' => [
                ['type' => 'move_to_folder', 'folder' => 'customers'],
                ['type' => 'mark_as_read', 'value' => true],
            ],
            'is_active' => true,
            'user_id' => $this->user->id,
            'company_id' => $this->company->id,
        ];

        $response = $this->post(route('electronic-mail.filters.store'), $ruleData);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'تم حفظ قاعدة التصفية بنجاح');

        $this->assertDatabaseHas('email_filters', [
            'name' => 'رسائل العملاء',
            'user_id' => $this->user->id,
            'is_active' => true,
        ]);
    }

    /**
     * اختبار إرسال بريد جماعي
     */
    public function test_send_bulk_email()
    {
        Mail::fake();

        // إنشاء عدة مستلمين
        $recipients = User::factory()->count(5)->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
        ]);

        $bulkEmailData = [
            'recipients' => $recipients->pluck('email')->toArray(),
            'subject' => 'إعلان مهم',
            'body' => 'نود إبلاغكم بتحديث مهم في النظام',
            'priority' => 'high',
            'sender_id' => $this->user->id,
            'company_id' => $this->company->id,
        ];

        $response = $this->post(route('electronic-mail.send-bulk'), $bulkEmailData);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'تم إرسال البريد الجماعي بنجاح');

        // التحقق من إرسال البريد لجميع المستلمين
        Mail::assertSent(\App\Mail\SendEmail::class, 5);
    }

    /**
     * اختبار جدولة إرسال بريد إلكتروني
     */
    public function test_schedule_email()
    {
        $scheduleData = [
            'to' => [$this->recipient->email],
            'subject' => 'بريد مجدول',
            'body' => 'هذا البريد سيتم إرساله لاحقاً',
            'scheduled_at' => now()->addHours(2)->format('Y-m-d H:i:s'),
            'priority' => 'normal',
            'sender_id' => $this->user->id,
            'company_id' => $this->company->id,
        ];

        $response = $this->post(route('electronic-mail.schedule'), $scheduleData);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'تم جدولة البريد الإلكتروني بنجاح');

        $this->assertDatabaseHas('scheduled_emails', [
            'subject' => 'بريد مجدول',
            'sender_id' => $this->user->id,
            'status' => 'scheduled',
        ]);
    }

    /**
     * اختبار إنشاء رد تلقائي
     */
    public function test_create_auto_reply()
    {
        $autoReplyData = [
            'name' => 'رد تلقائي للإجازة',
            'conditions' => [
                'subject_contains' => 'إجازة',
            ],
            'reply_subject' => 'رد على طلب الإجازة',
            'reply_body' => 'تم استلام طلب إجازتكم وسيتم مراجعته قريباً',
            'is_active' => true,
            'user_id' => $this->user->id,
            'company_id' => $this->company->id,
        ];

        $response = $this->post(route('electronic-mail.auto-replies.store'), $autoReplyData);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'تم حفظ الرد التلقائي بنجاح');

        $this->assertDatabaseHas('email_auto_replies', [
            'name' => 'رد تلقائي للإجازة',
            'user_id' => $this->user->id,
            'is_active' => true,
        ]);
    }

    /**
     * اختبار إنشاء إشعار بريد إلكتروني
     */
    public function test_create_email_notification()
    {
        $notificationData = [
            'name' => 'إشعار البريد الجديد',
            'trigger_type' => 'new_email',
            'conditions' => [
                'priority' => 'high',
            ],
            'notification_methods' => ['browser', 'email'],
            'is_active' => true,
            'user_id' => $this->user->id,
            'company_id' => $this->company->id,
        ];

        $response = $this->post(route('electronic-mail.notifications.store'), $notificationData);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'تم حفظ إعدادات الإشعار بنجاح');

        $this->assertDatabaseHas('email_notifications', [
            'name' => 'إشعار البريد الجديد',
            'user_id' => $this->user->id,
            'trigger_type' => 'new_email',
            'is_active' => true,
        ]);
    }

    /**
     * اختبار إنشاء تقرير البريد الإلكتروني
     */
    public function test_generate_email_report()
    {
        // إنشاء رسائل بريد متعددة
        ElectronicMail::factory()->count(10)->create([
            'sender_id' => $this->user->id,
            'company_id' => $this->company->id,
        ]);

        ElectronicMail::factory()->count(15)->create([
            'sender_id' => $this->recipient->id,
            'company_id' => $this->company->id,
        ]);

        $reportData = [
            'report_type' => 'email_traffic',
            'start_date' => now()->startOfMonth()->format('Y-m-d'),
            'end_date' => now()->endOfMonth()->format('Y-m-d'),
            'user_id' => $this->user->id,
            'company_id' => $this->company->id,
        ];

        $response = $this->post(route('electronic-mail.reports.generate'), $reportData);

        $response->assertStatus(200);
        $response->assertViewHas('reportData');
        $response->assertViewIs('electronic-mail.reports.email_traffic');
    }

    /**
     * اختبار تصدير بيانات البريد الإلكتروني
     */
    public function test_export_email_data()
    {
        ElectronicMail::factory()->count(20)->create([
            'sender_id' => $this->user->id,
            'company_id' => $this->company->id,
        ]);

        $exportData = [
            'start_date' => now()->startOfMonth()->format('Y-m-d'),
            'end_date' => now()->endOfMonth()->format('Y-m-d'),
            'folder' => 'all',
            'format' => 'excel',
            'include_attachments' => false,
        ];

        $response = $this->post(route('electronic-mail.export'), $exportData);

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->assertHeader('Content-Disposition', 'attachment; filename*=UTF-8\'\'emails-' . now()->format('Y-m-d') . '.xlsx');
    }

    /**
     * اختبار أرشفة البريد القديم
     */
    public function test_archive_old_emails()
    {
        // إنشاء رسائل قديمة
        ElectronicMail::factory()->count(5)->create([
            'sender_id' => $this->user->id,
            'company_id' => $this->company->id,
            'created_at' => now()->subMonths(6),
            'folder' => 'inbox',
        ]);

        $archiveData = [
            'older_than_months' => 3,
            'folders' => ['inbox', 'sent'],
        ];

        $response = $this->post(route('electronic-mail.archive'), $archiveData);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'تم أرشفة البريد القديم بنجاح');

        // التحقق من أن الرسائل القديمة تم نقلها للأرشيف
        $archivedCount = ElectronicMail::where('folder', 'archive')->count();
        $this->assertGreaterThan(0, $archivedCount);
    }

    /**
     * اختبار إحصائيات البريد الإلكتروني
     */
    public function test_email_statistics()
    {
        // إنشاء بيانات للإحصائيات
        ElectronicMail::factory()->count(10)->create([
            'sender_id' => $this->user->id,
            'company_id' => $this->company->id,
            'folder' => 'sent',
        ]);

        ElectronicMail::factory()->count(8)->create([
            'sender_id' => $this->recipient->id,
            'company_id' => $this->company->id,
            'folder' => 'inbox',
        ]);

        $response = $this->get(route('electronic-mail.statistics'));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'total_emails',
            'sent_emails',
            'received_emails',
            'unread_emails',
            'folder_distribution',
            'monthly_trend',
        ]);
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\Company;
use App\Models\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class DocumentModalTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;
    protected $company;
    protected $department;
    protected $category;

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

        $this->category = DocumentCategory::factory()->create(['company_id' => $this->company->id]);

        // تسجيل الدخول
        $this->actingAs($this->user);
    }

    /**
     * اختبار فتح مودال إضافة مستند جديد
     */
    public function test_open_create_document_modal()
    {
        $response = $this->get(route('documents.create'));

        $response->assertStatus(200);
        $response->assertViewIs('documents.create');

        // التحقق من وجود عناصر المودال في الصفحة
        $response->assertSee('إضافة مستند جديد', false);
        $response->assertSee('modal', false);
        $response->assertSee('document-form', false);
    }

    /**
     * اختبار فتح مودال تعديل مستند
     */
    public function test_open_edit_document_modal()
    {
        $document = Document::factory()->create([
            'company_id' => $this->company->id,
            'document_category_id' => $this->category->id,
            'department_id' => $this->department->id,
            'uploaded_by' => $this->user->id,
        ]);

        // افتراض وجود route للتعديل
        $response = $this->get(route('documents.show', $document));

        $response->assertStatus(200);
        $response->assertViewIs('documents.show');
        $response->assertViewHas('document', $document);
    }

    /**
     * اختبار إضافة مستند من خلال المودال
     */
    public function test_create_document_via_modal()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('test-document.pdf', 1024);

        $formData = [
            'title' => 'مستند تجريبي من المودال',
            'description' => 'وصف المستند المضاف من خلال المودال',
            'document_category_id' => $this->category->id,
            'department_id' => $this->department->id,
            'access_level' => 'department',
            'status' => 'active',
            'file' => $file,
        ];

        // محاكاة إرسال النموذج من خلال AJAX
        $response = $this->postJson(route('documents.store'), $formData);

        $response->assertStatus(302); // Redirect after success

        // التحقق من حفظ المستند
        $this->assertDatabaseHas('documents', [
            'title' => 'مستند تجريبي من المودال',
            'document_category_id' => $this->category->id,
            'department_id' => $this->department->id,
            'uploaded_by' => $this->user->id,
        ]);

        // التحقق من حفظ الملف
        $document = Document::where('title', 'مستند تجريبي من المودال')->first();
        Storage::disk('public')->assertExists($document->file_path);
    }

    /**
     * اختبار تحديث مستند من خلال المودال
     */
    public function test_update_document_via_modal()
    {
        Storage::fake('public');

        $document = Document::factory()->create([
            'title' => 'المستند الأصلي',
            'company_id' => $this->company->id,
            'document_category_id' => $this->category->id,
            'department_id' => $this->department->id,
            'uploaded_by' => $this->user->id,
        ]);

        $newCategory = DocumentCategory::factory()->create(['company_id' => $this->company->id]);

        $updateData = [
            'title' => 'المستند المحدث من المودال',
            'description' => 'الوصف المحدث من خلال المودال',
            'document_category_id' => $newCategory->id,
            'access_level' => 'company',
            'status' => 'archived',
        ];

        $response = $this->putJson(route('documents.update', $document), $updateData);

        $response->assertStatus(302); // Redirect after success

        // التحقق من تحديث البيانات
        $this->assertDatabaseHas('documents', [
            'id' => $document->id,
            'title' => 'المستند المحدث من المودال',
            'document_category_id' => $newCategory->id,
            'access_level' => 'company',
            'status' => 'archived',
        ]);
    }

    /**
     * اختبار حذف مستند من خلال المودال (تأكيد الحذف)
     */
    public function test_delete_document_via_modal()
    {
        Storage::fake('public');

        $document = Document::factory()->create([
            'company_id' => $this->company->id,
            'document_category_id' => $this->category->id,
            'department_id' => $this->department->id,
            'uploaded_by' => $this->user->id,
        ]);

        // محاكاة تأكيد الحذف من المودال
        $response = $this->deleteJson(route('documents.destroy', $document));

        $response->assertStatus(302); // Redirect after success

        // التحقق من حذف المستند
        $this->assertDatabaseMissing('documents', ['id' => $document->id]);

        // التحقق من حذف الملف
        Storage::disk('public')->assertMissing($document->file_path);
    }

    /**
     * اختبار إضافة مستند مع ملف كبير (اختبار حدود الملف)
     */
    public function test_create_document_with_large_file()
    {
        Storage::fake('public');

        // إنشاء ملف كبير (20MB) - قد يتجاوز الحد المسموح
        $largeFile = UploadedFile::fake()->create('large-document.pdf', 20480); // 20MB

        $formData = [
            'title' => 'مستند كبير',
            'description' => 'اختبار رفع ملف كبير',
            'document_category_id' => $this->category->id,
            'department_id' => $this->department->id,
            'access_level' => 'department',
            'status' => 'active',
            'file' => $largeFile,
        ];

        $response = $this->postJson(route('documents.store'), $formData);

        // قد يفشل حسب إعدادات PHP/Laravel للتحميل
        // هذا الاختبار يتحقق من معالجة الأخطاء
        if ($response->getStatusCode() === 302) {
            // نجح التحميل
            $this->assertDatabaseHas('documents', [
                'title' => 'مستند كبير',
            ]);
        } else {
            // فشل التحميل بسبب حجم الملف
            $response->assertStatus(419); // أو أي كود خطأ آخر
        }
    }

    /**
     * اختبار إضافة مستند مع نوع ملف غير مسموح
     */
    public function test_create_document_with_invalid_file_type()
    {
        Storage::fake('public');

        // إنشاء ملف بامتداد غير مسموح (مثل .exe)
        $invalidFile = UploadedFile::fake()->create('malicious.exe', 1024);

        $formData = [
            'title' => 'ملف ضار',
            'description' => 'اختبار رفع ملف غير آمن',
            'document_category_id' => $this->category->id,
            'department_id' => $this->department->id,
            'access_level' => 'department',
            'status' => 'active',
            'file' => $invalidFile,
        ];

        $response = $this->postJson(route('documents.store'), $formData);

        // يجب أن يفشل بسبب نوع الملف غير المسموح
        $response->assertStatus(302); // Redirect with errors
        $response->assertSessionHasErrors('file');

        // التأكد من عدم حفظ المستند
        $this->assertDatabaseMissing('documents', [
            'title' => 'ملف ضار',
        ]);
    }

    /**
     * اختبار إضافة مستند بدون ملء الحقول المطلوبة
     */
    public function test_create_document_with_missing_required_fields()
    {
        $formData = [
            // بدون title
            'description' => 'وصف بدون عنوان',
            // بدون document_category_id
            'department_id' => $this->department->id,
            'access_level' => 'department',
            'status' => 'active',
            // بدون file
        ];

        $response = $this->postJson(route('documents.store'), $formData);

        $response->assertStatus(302); // Redirect with validation errors
        $response->assertSessionHasErrors(['title', 'document_category_id', 'file']);
    }

    /**
     * اختبار إضافة مستند مع فئة غير موجودة
     */
    public function test_create_document_with_nonexistent_category()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('test.pdf', 1024);

        $formData = [
            'title' => 'مستند بفئة غير موجودة',
            'description' => 'اختبار فئة غير موجودة',
            'document_category_id' => 99999, // فئة غير موجودة
            'department_id' => $this->department->id,
            'access_level' => 'department',
            'status' => 'active',
            'file' => $file,
        ];

        $response = $this->postJson(route('documents.store'), $formData);

        // يجب أن يفشل بسبب الفئة غير الموجودة
        $response->assertStatus(302);
        $response->assertSessionHasErrors('document_category_id');
    }

    /**
     * اختبار تحديث مستند بواسطة مستخدم آخر (غير مسموح)
     */
    public function test_update_document_by_unauthorized_user()
    {
        $otherUser = User::factory()->create();
        $this->actingAs($otherUser);

        $document = Document::factory()->create([
            'company_id' => $this->company->id,
            'document_category_id' => $this->category->id,
            'department_id' => $this->department->id,
            'uploaded_by' => $this->user->id, // مستند للمستخدم الأصلي
        ]);

        $updateData = [
            'title' => 'محاولة تعديل غير مسموحة',
            'description' => 'يجب أن تفشل',
        ];

        $response = $this->putJson(route('documents.update', $document), $updateData);

        // يجب أن يفشل بسبب عدم الصلاحية
        $response->assertStatus(403); // Forbidden
    }

    /**
     * اختبار إضافة مستند مع اسم ملف يحتوي على أحرف خاصة
     */
    public function test_create_document_with_special_characters_in_filename()
    {
        Storage::fake('public');

        // ملف بأحرف خاصة في الاسم
        $specialFile = UploadedFile::fake()->create('مستند مع فراغات و@#$%^&().pdf', 1024);

        $formData = [
            'title' => 'مستند بأحرف خاصة',
            'description' => 'اختبار الملفات ذات الأسماء الخاصة',
            'document_category_id' => $this->category->id,
            'department_id' => $this->department->id,
            'access_level' => 'department',
            'status' => 'active',
            'file' => $specialFile,
        ];

        $response = $this->postJson(route('documents.store'), $formData);

        $response->assertStatus(302);

        // التحقق من حفظ المستند
        $this->assertDatabaseHas('documents', [
            'title' => 'مستند بأحرف خاصة',
        ]);
    }

    /**
     * اختبار إضافة عدة مستندات بنفس البيانات (التحقق من عدم التكرار)
     */
    public function test_create_multiple_documents_with_same_data()
    {
        Storage::fake('public');

        $file1 = UploadedFile::fake()->create('doc1.pdf', 1024);
        $file2 = UploadedFile::fake()->create('doc2.pdf', 1024);

        // إضافة أول مستند
        $formData1 = [
            'title' => 'مستند متكرر',
            'description' => 'النسخة الأولى',
            'document_category_id' => $this->category->id,
            'department_id' => $this->department->id,
            'access_level' => 'department',
            'status' => 'active',
            'file' => $file1,
        ];

        $response1 = $this->postJson(route('documents.store'), $formData1);
        $response1->assertStatus(302);

        // إضافة ثاني مستند بنفس البيانات
        $formData2 = [
            'title' => 'مستند متكرر',
            'description' => 'النسخة الثانية',
            'document_category_id' => $this->category->id,
            'department_id' => $this->department->id,
            'access_level' => 'department',
            'status' => 'active',
            'file' => $file2,
        ];

        $response2 = $this->postJson(route('documents.store'), $formData2);
        $response2->assertStatus(302);

        // التحقق من وجود مستندين
        $documents = Document::where('title', 'مستند متكرر')->get();
        $this->assertCount(2, $documents);

        // التحقق من أن الأكواد مختلفة
        $this->assertNotEquals($documents[0]->document_code, $documents[1]->document_code);
    }
}

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
use App\Services\DocumentCodeGenerator;

class DocumentManagementTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;
    protected $company;
    protected $department;

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

        // تسجيل الدخول
        $this->actingAs($this->user);
    }

    /**
     * اختبار صفحة قائمة المستندات
     */
    public function test_documents_index_page_loads()
    {
        $response = $this->get(route('documents.index'));

        $response->assertStatus(200);
        $response->assertViewHas('pageTitle', 'إدارة المستندات');
        $response->assertViewIs('documents.index');
    }

    /**
     * اختبار صفحة إنشاء مستند جديد
     */
    public function test_documents_create_page_loads()
    {
        $response = $this->get(route('documents.create'));

        $response->assertStatus(200);
        $response->assertViewIs('documents.create');
    }

    /**
     * اختبار حفظ مستند جديد مع ملف
     */
    public function test_document_store_with_file()
    {
        Storage::fake('public');

        $category = DocumentCategory::factory()->create(['company_id' => $this->company->id]);
        $file = UploadedFile::fake()->create('document.pdf', 1024);

        $data = [
            'title' => 'مستند تجريبي',
            'description' => 'وصف المستند التجريبي',
            'document_category_id' => $category->id,
            'department_id' => $this->department->id,
            'access_level' => 'department',
            'status' => 'active',
            'file' => $file,
        ];

        $response = $this->post(route('documents.store'), $data);

        $response->assertRedirect(route('documents.index'));
        $response->assertSessionHas('success', 'تم حفظ المستند بنجاح');

        $this->assertDatabaseHas('documents', [
            'title' => 'مستند تجريبي',
            'document_category_id' => $category->id,
            'department_id' => $this->department->id,
            'uploaded_by' => $this->user->id,
        ]);

        // التحقق من حفظ الملف
        $document = Document::where('title', 'مستند تجريبي')->first();
        Storage::disk('public')->assertExists($document->file_path);
    }

    /**
     * اختبار حفظ مستند بدون ملف (خطأ)
     */
    public function test_document_store_without_file_fails()
    {
        $category = DocumentCategory::factory()->create(['company_id' => $this->company->id]);

        $data = [
            'title' => 'مستند بدون ملف',
            'description' => 'وصف المستند',
            'document_category_id' => $category->id,
            'department_id' => $this->department->id,
            'access_level' => 'department',
            'status' => 'active',
        ];

        $response = $this->post(route('documents.store'), $data);

        $response->assertRedirect();
        $response->assertSessionHasErrors('file');
    }

    /**
     * اختبار عرض تفاصيل المستند
     */
    public function test_document_show_page()
    {
        Storage::fake('public');

        $category = DocumentCategory::factory()->create(['company_id' => $this->company->id]);
        $document = Document::factory()->create([
            'company_id' => $this->company->id,
            'document_category_id' => $category->id,
            'department_id' => $this->department->id,
            'uploaded_by' => $this->user->id,
        ]);

        $response = $this->get(route('documents.show', $document));

        $response->assertStatus(200);
        $response->assertViewHas('document', $document);
        $response->assertViewIs('documents.show');
    }

    /**
     * اختبار تحديث المستند
     */
    public function test_document_update()
    {
        Storage::fake('public');

        $category = DocumentCategory::factory()->create(['company_id' => $this->company->id]);
        $document = Document::factory()->create([
            'company_id' => $this->company->id,
            'document_category_id' => $category->id,
            'department_id' => $this->department->id,
            'uploaded_by' => $this->user->id,
        ]);

        $newCategory = DocumentCategory::factory()->create(['company_id' => $this->company->id]);

        $updateData = [
            'title' => 'العنوان المحدث',
            'description' => 'الوصف المحدث',
            'document_category_id' => $newCategory->id,
            'access_level' => 'company',
            'status' => 'archived',
        ];

        $response = $this->put(route('documents.update', $document), $updateData);

        $response->assertRedirect(route('documents.show', $document));
        $response->assertSessionHas('success', 'تم تحديث المستند بنجاح');

        $this->assertDatabaseHas('documents', [
            'id' => $document->id,
            'title' => 'العنوان المحدث',
            'description' => 'الوصف المحدث',
            'document_category_id' => $newCategory->id,
            'access_level' => 'company',
            'status' => 'archived',
        ]);
    }

    /**
     * اختبار حذف المستند
     */
    public function test_document_destroy()
    {
        Storage::fake('public');

        $category = DocumentCategory::factory()->create(['company_id' => $this->company->id]);
        $document = Document::factory()->create([
            'company_id' => $this->company->id,
            'document_category_id' => $category->id,
            'department_id' => $this->department->id,
            'uploaded_by' => $this->user->id,
        ]);

        // التحقق من وجود الملف قبل الحذف
        Storage::disk('public')->assertExists($document->file_path);

        $response = $this->delete(route('documents.destroy', $document));

        $response->assertRedirect(route('documents.index'));
        $response->assertSessionHas('success', 'تم حذف المستند بنجاح');

        // التحقق من حذف المستند من قاعدة البيانات
        $this->assertDatabaseMissing('documents', ['id' => $document->id]);

        // التحقق من حذف الملف
        Storage::disk('public')->assertMissing($document->file_path);
    }

    /**
     * اختبار عدم إمكانية حذف مستند لمستخدم آخر
     */
    public function test_document_destroy_unauthorized()
    {
        $otherUser = User::factory()->create();
        $this->actingAs($otherUser);

        $category = DocumentCategory::factory()->create(['company_id' => $this->company->id]);
        $document = Document::factory()->create([
            'company_id' => $this->company->id,
            'document_category_id' => $category->id,
            'department_id' => $this->department->id,
            'uploaded_by' => $this->user->id, // مستند للمستخدم الأصلي
        ]);

        $response = $this->delete(route('documents.destroy', $document));

        $response->assertStatus(403); // Forbidden
    }
}

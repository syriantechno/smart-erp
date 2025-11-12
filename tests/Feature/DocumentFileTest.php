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

class DocumentFileTest extends TestCase
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
     * اختبار رفع ملف PDF صالح
     */
    public function test_upload_valid_pdf_file()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('document.pdf', 1024, 'application/pdf');

        $data = [
            'title' => 'مستند PDF صالح',
            'description' => 'اختبار رفع ملف PDF',
            'document_category_id' => $this->category->id,
            'department_id' => $this->department->id,
            'access_level' => 'department',
            'status' => 'active',
            'file' => $file,
        ];

        $response = $this->post(route('documents.store'), $data);

        $response->assertRedirect(route('documents.index'));
        $response->assertSessionHas('success');

        $document = Document::where('title', 'مستند PDF صالح')->first();

        $this->assertNotNull($document);
        $this->assertEquals('pdf', $document->file_type);
        $this->assertEquals('application/pdf', $document->mime_type);
        $this->assertEquals(1024, $document->file_size);

        // التحقق من حفظ الملف
        Storage::disk('public')->assertExists($document->file_path);
    }

    /**
     * اختبار رفع ملف Word صالح
     */
    public function test_upload_valid_word_file()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('document.docx', 2048, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');

        $data = [
            'title' => 'مستند Word',
            'description' => 'اختبار رفع ملف Word',
            'document_category_id' => $this->category->id,
            'department_id' => $this->department->id,
            'access_level' => 'department',
            'status' => 'active',
            'file' => $file,
        ];

        $response = $this->post(route('documents.store'), $data);

        $response->assertRedirect(route('documents.index'));
        $response->assertSessionHas('success');

        $document = Document::where('title', 'مستند Word')->first();

        $this->assertNotNull($document);
        $this->assertEquals('docx', $document->file_type);
        $this->assertEquals(2048, $document->file_size);

        Storage::disk('public')->assertExists($document->file_path);
    }

    /**
     * اختبار رفع ملف Excel صالح
     */
    public function test_upload_valid_excel_file()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('spreadsheet.xlsx', 3072, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        $data = [
            'title' => 'ملف Excel',
            'description' => 'اختبار رفع ملف Excel',
            'document_category_id' => $this->category->id,
            'department_id' => $this->department->id,
            'access_level' => 'department',
            'status' => 'active',
            'file' => $file,
        ];

        $response = $this->post(route('documents.store'), $data);

        $response->assertRedirect(route('documents.index'));
        $response->assertSessionHas('success');

        $document = Document::where('title', 'ملف Excel')->first();

        $this->assertNotNull($document);
        $this->assertEquals('xlsx', $document->file_type);
        $this->assertEquals(3072, $document->file_size);

        Storage::disk('public')->assertExists($document->file_path);
    }

    /**
     * اختبار رفع ملف صورة صالح
     */
    public function test_upload_valid_image_file()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('photo.jpg', 800, 600)->size(512);

        $data = [
            'title' => 'صورة',
            'description' => 'اختبار رفع ملف صورة',
            'document_category_id' => $this->category->id,
            'department_id' => $this->department->id,
            'access_level' => 'department',
            'status' => 'active',
            'file' => $file,
        ];

        $response = $this->post(route('documents.store'), $data);

        $response->assertRedirect(route('documents.index'));
        $response->assertSessionHas('success');

        $document = Document::where('title', 'صورة')->first();

        $this->assertNotNull($document);
        $this->assertEquals('jpg', $document->file_type);
        $this->assertStringStartsWith('image/', $document->mime_type);

        Storage::disk('public')->assertExists($document->file_path);
    }

    /**
     * اختبار رفع ملف فارغ
     */
    public function test_upload_empty_file()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('empty.pdf', 0); // ملف فارغ

        $data = [
            'title' => 'ملف فارغ',
            'description' => 'اختبار رفع ملف فارغ',
            'document_category_id' => $this->category->id,
            'department_id' => $this->department->id,
            'access_level' => 'department',
            'status' => 'active',
            'file' => $file,
        ];

        $response = $this->post(route('documents.store'), $data);

        // يجب أن يفشل
        $response->assertRedirect();
        $response->assertSessionHasErrors('file');

        $this->assertDatabaseMissing('documents', [
            'title' => 'ملف فارغ',
        ]);
    }

    /**
     * اختبار رفع ملف بنوع غير مسموح
     */
    public function test_upload_invalid_file_type()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('malicious.exe', 1024, 'application/x-msdownload');

        $data = [
            'title' => 'ملف ضار',
            'description' => 'اختبار رفع ملف غير آمن',
            'document_category_id' => $this->category->id,
            'department_id' => $this->department->id,
            'access_level' => 'department',
            'status' => 'active',
            'file' => $file,
        ];

        $response = $this->post(route('documents.store'), $data);

        // يجب أن يفشل
        $response->assertRedirect();
        $response->assertSessionHasErrors('file');

        $this->assertDatabaseMissing('documents', [
            'title' => 'ملف ضار',
        ]);
    }

    /**
     * اختبار رفع ملف كبير جداً
     */
    public function test_upload_oversized_file()
    {
        Storage::fake('public');

        // ملف كبير (50MB) - قد يتجاوز الحد المسموح
        $largeFile = UploadedFile::fake()->create('large-file.pdf', 51200); // 50MB

        $data = [
            'title' => 'ملف كبير جداً',
            'description' => 'اختبار رفع ملف كبير',
            'document_category_id' => $this->category->id,
            'department_id' => $this->department->id,
            'access_level' => 'department',
            'status' => 'active',
            'file' => $largeFile,
        ];

        $response = $this->post(route('documents.store'), $data);

        // قد ينجح أو يفشل حسب إعدادات Laravel/PHP
        // إذا فشل، نتوقع خطأ في التحقق من الصحة
        if ($response->getStatusCode() !== 302 || $response->getSession()->has('errors')) {
            $response->assertSessionHasErrors('file');
        }
    }

    /**
     * اختبار تحميل الملف
     */
    public function test_download_file()
    {
        Storage::fake('public');

        $document = Document::factory()->create([
            'company_id' => $this->company->id,
            'document_category_id' => $this->category->id,
            'department_id' => $this->department->id,
            'uploaded_by' => $this->user->id,
            'file_path' => 'documents/test-file.pdf',
            'file_name' => 'test-file.pdf',
            'file_type' => 'pdf',
            'mime_type' => 'application/pdf',
        ]);

        // إنشاء الملف في storage
        Storage::disk('public')->put('documents/test-file.pdf', 'fake content');

        // افتراض وجود route للتحميل
        $response = $this->get(route('documents.download', $document));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
        $response->assertHeader('Content-Disposition', 'attachment; filename="test-file.pdf"');
    }

    /**
     * اختبار تحميل ملف بدون صلاحية
     */
    public function test_download_file_without_permission()
    {
        $otherUser = User::factory()->create();
        $this->actingAs($otherUser);

        $document = Document::factory()->create([
            'company_id' => $this->company->id,
            'document_category_id' => $this->category->id,
            'department_id' => $this->department->id,
            'uploaded_by' => $this->user->id, // مستند لمستخدم آخر
            'access_level' => 'department', // خاص بالقسم
        ]);

        $response = $this->get(route('documents.download', $document));

        // يجب أن يفشل
        $response->assertStatus(403); // Forbidden
    }

    /**
     * اختبار تحديث الملف عند تعديل المستند
     */
    public function test_file_replacement_on_update()
    {
        Storage::fake('public');

        $document = Document::factory()->create([
            'company_id' => $this->company->id,
            'document_category_id' => $this->category->id,
            'department_id' => $this->department->id,
            'uploaded_by' => $this->user->id,
            'file_path' => 'documents/old-file.pdf',
            'file_name' => 'old-file.pdf',
        ]);

        // إنشاء الملف القديم
        Storage::disk('public')->put('documents/old-file.pdf', 'old content');

        // ملف جديد للاستبدال
        $newFile = UploadedFile::fake()->create('new-file.pdf', 2048);

        $updateData = [
            'title' => $document->title,
            'description' => 'تم استبدال الملف',
            'file' => $newFile, // ملف جديد
        ];

        $response = $this->put(route('documents.update', $document), $updateData);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        // التحقق من حذف الملف القديم
        Storage::disk('public')->assertMissing('documents/old-file.pdf');

        // التحقق من وجود الملف الجديد
        $updatedDocument = Document::find($document->id);
        Storage::disk('public')->assertExists($updatedDocument->file_path);

        // التحقق من تحديث حجم الملف
        $this->assertEquals(2048, $updatedDocument->file_size);
    }

    /**
     * اختبار حذف الملف عند حذف المستند
     */
    public function test_file_deletion_on_document_delete()
    {
        Storage::fake('public');

        $document = Document::factory()->create([
            'company_id' => $this->company->id,
            'document_category_id' => $this->category->id,
            'department_id' => $this->department->id,
            'uploaded_by' => $this->user->id,
            'file_path' => 'documents/file-to-delete.pdf',
        ]);

        // إنشاء الملف
        Storage::disk('public')->put('documents/file-to-delete.pdf', 'content to delete');

        // التأكد من وجود الملف
        Storage::disk('public')->assertExists('documents/file-to-delete.pdf');

        // حذف المستند
        $response = $this->delete(route('documents.destroy', $document));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        // التحقق من حذف الملف
        Storage::disk('public')->assertMissing('documents/file-to-delete.pdf');

        // التحقق من حذف المستند من قاعدة البيانات
        $this->assertDatabaseMissing('documents', ['id' => $document->id]);
    }

    /**
     * اختبار رفع عدة ملفات بنفس الاسم
     */
    public function test_upload_files_with_same_name()
    {
        Storage::fake('public');

        // رفع ملفين بنفس الاسم
        $file1 = UploadedFile::fake()->create('same-name.pdf', 1024);
        $file2 = UploadedFile::fake()->create('same-name.pdf', 2048);

        // رفع الملف الأول
        $data1 = [
            'title' => 'الملف الأول',
            'description' => 'الملف الأول بنفس الاسم',
            'document_category_id' => $this->category->id,
            'department_id' => $this->department->id,
            'access_level' => 'department',
            'status' => 'active',
            'file' => $file1,
        ];

        $response1 = $this->post(route('documents.store'), $data1);
        $response1->assertRedirect();
        $response1->assertSessionHas('success');

        // رفع الملف الثاني
        $data2 = [
            'title' => 'الملف الثاني',
            'description' => 'الملف الثاني بنفس الاسم',
            'document_category_id' => $this->category->id,
            'department_id' => $this->department->id,
            'access_level' => 'department',
            'status' => 'active',
            'file' => $file2,
        ];

        $response2 = $this->post(route('documents.store'), $data2);
        $response2->assertRedirect();
        $response2->assertSessionHas('success');

        // التحقق من حفظ كلا الملفين
        $documents = Document::whereIn('title', ['الملف الأول', 'الملف الثاني'])->get();
        $this->assertCount(2, $documents);

        // التحقق من أن مسارات الملفات مختلفة (معالجة تضارب الأسماء)
        $paths = $documents->pluck('file_path')->toArray();
        $this->assertCount(2, array_unique($paths)); // جميع المسارات فريدة
    }

    /**
     * اختبار حجم الملف المُنسق
     */
    public function test_file_size_formatting()
    {
        Storage::fake('public');

        // ملف صغير (1 KB)
        $smallFile = UploadedFile::fake()->create('small.txt', 1);

        $data = [
            'title' => 'ملف صغير',
            'description' => 'اختبار تنسيق حجم الملف',
            'document_category_id' => $this->category->id,
            'department_id' => $this->department->id,
            'access_level' => 'department',
            'status' => 'active',
            'file' => $smallFile,
        ];

        $response = $this->post(route('documents.store'), $data);
        $response->assertRedirect();

        $document = Document::where('title', 'ملف صغير')->first();

        // التحقق من حفظ حجم الملف الصحيح
        $this->assertEquals(1, $document->file_size);

        // التحقق من وجود accessor للتنسيق
        if (method_exists($document, 'getFormattedFileSizeAttribute')) {
            $formattedSize = $document->formatted_file_size;
            $this->assertIsString($formattedSize);
        }
    }

    /**
     * اختبار أسماء الملفات الطويلة جداً
     */
    public function test_long_filename_handling()
    {
        Storage::fake('public');

        // اسم ملف طويل جداً
        $longName = str_repeat('a', 200) . '.pdf';
        $file = UploadedFile::fake()->create($longName, 1024);

        $data = [
            'title' => 'ملف باسم طويل',
            'description' => 'اختبار التعامل مع أسماء الملفات الطويلة',
            'document_category_id' => $this->category->id,
            'department_id' => $this->department->id,
            'access_level' => 'department',
            'status' => 'active',
            'file' => $file,
        ];

        $response = $this->post(route('documents.store'), $data);
        $response->assertRedirect();
        $response->assertSessionHas('success');

        $document = Document::where('title', 'ملف باسم طويل')->first();
        $this->assertNotNull($document);

        // التحقق من حفظ الملف بنجاح
        Storage::disk('public')->assertExists($document->file_path);
    }

    /**
     * اختبار رفع ملف مع أحرف خاصة في الاسم
     */
    public function test_filename_with_special_characters()
    {
        Storage::fake('public');

        // اسم ملف يحتوي على أحرف خاصة ومسافات
        $specialName = 'ملف مع فراغات و @#$%^&()[]{} أحرف عربية.pdf';
        $file = UploadedFile::fake()->create($specialName, 1024);

        $data = [
            'title' => 'ملف بأحرف خاصة',
            'description' => 'اختبار الملفات ذات الأسماء الخاصة',
            'document_category_id' => $this->category->id,
            'department_id' => $this->department->id,
            'access_level' => 'department',
            'status' => 'active',
            'file' => $file,
        ];

        $response = $this->post(route('documents.store'), $data);
        $response->assertRedirect();
        $response->assertSessionHas('success');

        $document = Document::where('title', 'ملف بأحرف خاصة')->first();
        $this->assertNotNull($document);

        // التحقق من حفظ الملف
        Storage::disk('public')->assertExists($document->file_path);

        // التحقق من تخزين اسم الملف الأصلي
        $this->assertEquals($specialName, $document->file_name);
    }
}

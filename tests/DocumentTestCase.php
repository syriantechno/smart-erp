<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Company;
use App\Models\Department;
use App\Models\DocumentCategory;

abstract class DocumentTestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    protected $user;
    protected $company;
    protected $department;
    protected $category;

    protected function setUp(): void
    {
        parent::setUp();

        // استخدام Fake Storage للملفات
        Storage::fake('public');

        // إنشاء بيانات الاختبار الأساسية
        $this->company = Company::create([
            'name' => 'شركة تجريبية',
            'email' => 'test@company.com',
            'phone' => '123456789',
            'address' => 'العنوان التجريبي',
            'city' => 'المدينة',
            'country' => 'البلد',
            'is_active' => true,
        ]);

        $this->department = Department::create([
            'name' => 'قسم تقنية المعلومات',
            'company_id' => $this->company->id,
            'is_active' => true,
        ]);

        $this->user = User::create([
            'name' => 'مستخدم تجريبي',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
            'email_verified_at' => now(),
        ]);

        $this->category = DocumentCategory::create([
            'name' => 'فئة تجريبية',
            'description' => 'فئة للاختبارات',
            'company_id' => $this->company->id,
            'is_active' => true,
        ]);

        // تسجيل الدخول
        $this->actingAs($this->user);
    }

    protected function tearDown(): void
    {
        // تنظيف البيانات بعد كل اختبار
        Storage::fake('public'); // إعادة تهيئة Fake Storage
        parent::tearDown();
    }

    /**
     * إنشاء مستند تجريبي
     */
    protected function createTestDocument($attributes = [])
    {
        return \App\Models\Document::create(array_merge([
            'title' => 'مستند تجريبي',
            'description' => 'وصف المستند التجريبي',
            'document_category_id' => $this->category->id,
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
            'uploaded_by' => $this->user->id,
            'access_level' => 'department',
            'status' => 'active',
            'document_code' => app(\App\Services\DocumentCodeGenerator::class)->generate('documents'),
            'file_name' => 'test-document.pdf',
            'file_path' => 'documents/test-document.pdf',
            'file_type' => 'pdf',
            'mime_type' => 'application/pdf',
            'file_size' => 1024,
        ], $attributes));
    }

    /**
     * إنشاء فئة مستندات تجريبية
     */
    protected function createTestCategory($attributes = [])
    {
        return DocumentCategory::create(array_merge([
            'name' => 'فئة تجريبية جديدة',
            'description' => 'وصف الفئة التجريبية',
            'company_id' => $this->company->id,
            'parent_id' => null,
            'is_active' => true,
        ], $attributes));
    }

    /**
     * إنشاء مستخدم آخر للاختبارات
     */
    protected function createAnotherUser($attributes = [])
    {
        return User::create(array_merge([
            'name' => 'مستخدم آخر',
            'email' => 'another@example.com',
            'password' => bcrypt('password'),
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
            'email_verified_at' => now(),
        ], $attributes));
    }
}

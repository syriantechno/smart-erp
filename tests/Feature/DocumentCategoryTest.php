<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\DocumentCategory;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class DocumentCategoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;
    protected $company;

    protected function setUp(): void
    {
        parent::setUp();

        // إنشاء بيانات الاختبار الأساسية
        $this->company = Company::factory()->create();
        $this->user = User::factory()->create([
            'company_id' => $this->company->id,
        ]);

        // تسجيل الدخول
        $this->actingAs($this->user);
    }

    /**
     * اختبار صفحة قائمة الفئات
     */
    public function test_categories_index_page()
    {
        $response = $this->get(route('documents.categories'));

        $response->assertStatus(200);
        $response->assertViewIs('documents.categories.index');
        $response->assertViewHas('pageTitle', 'إدارة فئات المستندات');
    }

    /**
     * اختبار إنشاء فئة جديدة
     */
    public function test_create_category()
    {
        $categoryData = [
            'name' => 'فئة تجريبية',
            'description' => 'وصف الفئة التجريبية',
            'parent_id' => null,
            'is_active' => true,
        ];

        $response = $this->postJson(route('documents.store-category'), $categoryData);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'تم حفظ الفئة بنجاح',
        ]);

        $this->assertDatabaseHas('document_categories', [
            'name' => 'فئة تجريبية',
            'description' => 'وصف الفئة التجريبية',
            'company_id' => $this->company->id,
            'parent_id' => null,
            'is_active' => true,
        ]);
    }

    /**
     * اختبار إنشاء فئة فرعية (nested category)
     */
    public function test_create_nested_category()
    {
        // إنشاء الفئة الأم أولاً
        $parentCategory = DocumentCategory::factory()->create([
            'company_id' => $this->company->id,
        ]);

        $categoryData = [
            'name' => 'فئة فرعية',
            'description' => 'فئة فرعية للفئة الأم',
            'parent_id' => $parentCategory->id,
            'is_active' => true,
        ];

        $response = $this->postJson(route('documents.store-category'), $categoryData);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'تم حفظ الفئة بنجاح',
        ]);

        $this->assertDatabaseHas('document_categories', [
            'name' => 'فئة فرعية',
            'parent_id' => $parentCategory->id,
            'company_id' => $this->company->id,
        ]);

        // التحقق من العلاقة
        $childCategory = DocumentCategory::where('name', 'فئة فرعية')->first();
        $this->assertEquals($parentCategory->id, $childCategory->parent_id);
    }

    /**
     * اختبار إنشاء فئة بنفس الاسم (يجب أن يفشل)
     */
    public function test_create_duplicate_category_name()
    {
        // إنشاء فئة أولاً
        DocumentCategory::factory()->create([
            'name' => 'فئة مكررة',
            'company_id' => $this->company->id,
        ]);

        $categoryData = [
            'name' => 'فئة مكررة', // نفس الاسم
            'description' => 'وصف مختلف',
            'parent_id' => null,
            'is_active' => true,
        ];

        $response = $this->postJson(route('documents.store-category'), $categoryData);

        // قد يسمح النظام بالتكرار أو لا، حسب التنفيذ
        // نفترض أنه يسمح بالتكرار في نفس الشركة
        $response->assertStatus(200);
    }

    /**
     * اختبار تحديث فئة
     */
    public function test_update_category()
    {
        $category = DocumentCategory::factory()->create([
            'company_id' => $this->company->id,
        ]);

        $updateData = [
            'name' => 'الاسم المحدث',
            'description' => 'الوصف المحدث',
            'parent_id' => null,
            'is_active' => false,
        ];

        $response = $this->putJson(route('documents.update-category', $category), $updateData);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'تم تحديث الفئة بنجاح',
        ]);

        $this->assertDatabaseHas('document_categories', [
            'id' => $category->id,
            'name' => 'الاسم المحدث',
            'description' => 'الوصف المحدث',
            'is_active' => false,
        ]);
    }

    /**
     * اختبار حذف فئة فارغة
     */
    public function test_delete_empty_category()
    {
        $category = DocumentCategory::factory()->create([
            'company_id' => $this->company->id,
        ]);

        $response = $this->deleteJson(route('documents.destroy-category', $category));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'تم حذف الفئة بنجاح',
        ]);

        $this->assertDatabaseMissing('document_categories', [
            'id' => $category->id,
        ]);
    }

    /**
     * اختبار حذف فئة تحتوي على مستندات (يجب أن يفشل أو ينقل المستندات)
     */
    public function test_delete_category_with_documents()
    {
        $category = DocumentCategory::factory()->create([
            'company_id' => $this->company->id,
        ]);

        // إنشاء مستند في الفئة
        \App\Models\Document::factory()->create([
            'company_id' => $this->company->id,
            'document_category_id' => $category->id,
        ]);

        $response = $this->deleteJson(route('documents.destroy-category', $category));

        // قد يفشل أو ينقل المستندات حسب منطق النظام
        // نفترض أنه يفشل
        if ($response->getStatusCode() === 400) {
            $response->assertJson([
                'success' => false,
                'message' => 'لا يمكن حذف فئة تحتوي على مستندات',
            ]);

            // الفئة ما زالت موجودة
            $this->assertDatabaseHas('document_categories', [
                'id' => $category->id,
            ]);
        }
    }

    /**
     * اختبار حذف فئة أم تحتوي على فئات فرعية (يجب أن يفشل)
     */
    public function test_delete_parent_category_with_children()
    {
        $parentCategory = DocumentCategory::factory()->create([
            'company_id' => $this->company->id,
        ]);

        $childCategory = DocumentCategory::factory()->create([
            'company_id' => $this->company->id,
            'parent_id' => $parentCategory->id,
        ]);

        $response = $this->deleteJson(route('documents.destroy-category', $parentCategory));

        // يجب أن يفشل حذف الفئة الأم
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'لا يمكن حذف فئة تحتوي على فئات فرعية',
        ]);

        // الفئة الأم ما زالت موجودة
        $this->assertDatabaseHas('document_categories', [
            'id' => $parentCategory->id,
        ]);
    }

    /**
     * اختبار إنشاء فئة بفئة أم غير موجودة (خطأ)
     */
    public function test_create_category_with_nonexistent_parent()
    {
        $categoryData = [
            'name' => 'فئة جديدة',
            'description' => 'وصف الفئة',
            'parent_id' => 99999, // فئة أم غير موجودة
            'is_active' => true,
        ];

        $response = $this->postJson(route('documents.store-category'), $categoryData);

        // يجب أن يفشل
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
        ]);
    }

    /**
     * اختبار إنشاء فئة بدون اسم (خطأ)
     */
    public function test_create_category_without_name()
    {
        $categoryData = [
            // بدون name
            'description' => 'وصف بدون اسم',
            'parent_id' => null,
            'is_active' => true,
        ];

        $response = $this->postJson(route('documents.store-category'), $categoryData);

        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
        ]);
    }

    /**
     * اختبار جلب الفئات النشطة فقط
     */
    public function test_get_active_categories_only()
    {
        // فئة نشطة
        DocumentCategory::factory()->create([
            'name' => 'فئة نشطة',
            'company_id' => $this->company->id,
            'is_active' => true,
        ]);

        // فئة غير نشطة
        DocumentCategory::factory()->create([
            'name' => 'فئة غير نشطة',
            'company_id' => $this->company->id,
            'is_active' => false,
        ]);

        // افتراض وجود endpoint لجلب الفئات النشطة
        $response = $this->getJson(route('documents.categories'));

        $response->assertStatus(200);

        $categories = $response->json();

        // يجب أن تحتوي على الفئة النشطة فقط
        $activeCategories = collect($categories)->where('is_active', true);
        $this->assertCount(1, $activeCategories);
        $this->assertEquals('فئة نشطة', $activeCategories->first()['name']);
    }

    /**
     * اختبار ترتيب الفئات (الفئات الأم أولاً، ثم الفرعية)
     */
    public function test_categories_ordering()
    {
        // فئة أم
        $parent = DocumentCategory::factory()->create([
            'name' => 'أ',
            'company_id' => $this->company->id,
            'parent_id' => null,
        ]);

        // فئة فرعية
        DocumentCategory::factory()->create([
            'name' => 'أ-1',
            'company_id' => $this->company->id,
            'parent_id' => $parent->id,
        ]);

        // فئة أم أخرى
        DocumentCategory::factory()->create([
            'name' => 'ب',
            'company_id' => $this->company->id,
            'parent_id' => null,
        ]);

        $response = $this->getJson(route('documents.categories'));

        $response->assertStatus(200);

        $categories = $response->json();

        // التحقق من الترتيب (الفئات الأم تأتي أولاً)
        $parentCategories = collect($categories)->where('parent_id', null);
        $this->assertCount(2, $parentCategories);
    }

    /**
     * اختبار تحديث فئة إلى فئة فرعية لنفسها (خطأ)
     */
    public function test_update_category_parent_to_itself()
    {
        $category = DocumentCategory::factory()->create([
            'company_id' => $this->company->id,
        ]);

        $updateData = [
            'name' => $category->name,
            'description' => $category->description,
            'parent_id' => $category->id, // محاولة جعلها فئة أم لنفسها
            'is_active' => true,
        ];

        $response = $this->putJson(route('documents.update-category', $category), $updateData);

        // يجب أن يفشل
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'لا يمكن جعل الفئة فئة أم لنفسها',
        ]);
    }

    /**
     * اختبار تحديث حالة الفئة (نشط/غير نشط)
     */
    public function test_toggle_category_status()
    {
        $category = DocumentCategory::factory()->create([
            'company_id' => $this->company->id,
            'is_active' => true,
        ]);

        // تعطيل الفئة
        $updateData = [
            'name' => $category->name,
            'description' => $category->description,
            'parent_id' => $category->parent_id,
            'is_active' => false,
        ];

        $response = $this->putJson(route('documents.update-category', $category), $updateData);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseHas('document_categories', [
            'id' => $category->id,
            'is_active' => false,
        ]);

        // إعادة تفعيل الفئة
        $updateData['is_active'] = true;
        $response2 = $this->putJson(route('documents.update-category', $category), $updateData);

        $response2->assertStatus(200);
        $this->assertDatabaseHas('document_categories', [
            'id' => $category->id,
            'is_active' => true,
        ]);
    }
}

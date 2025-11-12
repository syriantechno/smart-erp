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

class DocumentDataTableTest extends TestCase
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
     * اختبار تحميل بيانات DataTable
     */
    public function test_datatable_data_loading()
    {
        // إنشاء بعض المستندات التجريبية
        Document::factory()->count(3)->create([
            'company_id' => $this->company->id,
            'document_category_id' => $this->category->id,
            'department_id' => $this->department->id,
            'uploaded_by' => $this->user->id,
        ]);

        $response = $this->getJson(route('documents.datatable'));

        $response->assertStatus(200);

        $data = $response->json();

        // التحقق من وجود البيانات
        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('recordsTotal', $data);
        $this->assertArrayHasKey('recordsFiltered', $data);

        // التحقق من عدد السجلات
        $this->assertEquals(3, $data['recordsTotal']);
        $this->assertEquals(3, $data['recordsFiltered']);
        $this->assertCount(3, $data['data']);
    }

    /**
     * اختبار البحث في DataTable
     */
    public function test_datatable_search_functionality()
    {
        // إنشاء مستندات بأسماء مختلفة
        Document::factory()->create([
            'title' => 'تقرير المبيعات',
            'company_id' => $this->company->id,
            'document_category_id' => $this->category->id,
            'department_id' => $this->department->id,
            'uploaded_by' => $this->user->id,
        ]);

        Document::factory()->create([
            'title' => 'عقد التوظيف',
            'company_id' => $this->company->id,
            'document_category_id' => $this->category->id,
            'department_id' => $this->department->id,
            'uploaded_by' => $this->user->id,
        ]);

        Document::factory()->create([
            'title' => 'فاتورة شراء',
            'company_id' => $this->company->id,
            'document_category_id' => $this->category->id,
            'department_id' => $this->department->id,
            'uploaded_by' => $this->user->id,
        ]);

        // البحث عن "تقرير"
        $response = $this->getJson(route('documents.datatable', [
            'search' => ['value' => 'تقرير']
        ]));

        $response->assertStatus(200);
        $data = $response->json();

        $this->assertEquals(1, $data['recordsFiltered']);
        $this->assertCount(1, $data['data']);
        $this->assertEquals('تقرير المبيعات', $data['data'][0]['title']);
    }

    /**
     * اختبار ترتيب البيانات في DataTable
     */
    public function test_datatable_sorting()
    {
        // إنشاء مستندات بترتيب زمني عكسي
        $oldDoc = Document::factory()->create([
            'title' => 'مستند قديم',
            'company_id' => $this->company->id,
            'document_category_id' => $this->category->id,
            'department_id' => $this->department->id,
            'uploaded_by' => $this->user->id,
            'created_at' => now()->subDays(2),
        ]);

        $newDoc = Document::factory()->create([
            'title' => 'مستند جديد',
            'company_id' => $this->company->id,
            'document_category_id' => $this->category->id,
            'department_id' => $this->department->id,
            'uploaded_by' => $this->user->id,
            'created_at' => now(),
        ]);

        // ترتيب تصاعدي حسب التاريخ (الأقدم أولاً)
        $response = $this->getJson(route('documents.datatable', [
            'order' => [['column' => 4, 'dir' => 'asc']] // عمود التاريخ
        ]));

        $response->assertStatus(200);
        $data = $response->json();

        $this->assertCount(2, $data['data']);
        $this->assertEquals('مستند قديم', $data['data'][0]['title']);
        $this->assertEquals('مستند جديد', $data['data'][1]['title']);
    }

    /**
     * اختبار تصفية البيانات حسب الفئة
     */
    public function test_datatable_category_filtering()
    {
        $category2 = DocumentCategory::factory()->create([
            'name' => 'العقود',
            'company_id' => $this->company->id
        ]);

        // مستند في الفئة الأولى
        Document::factory()->create([
            'title' => 'تقرير المبيعات',
            'company_id' => $this->company->id,
            'document_category_id' => $this->category->id,
            'department_id' => $this->department->id,
            'uploaded_by' => $this->user->id,
        ]);

        // مستند في الفئة الثانية
        Document::factory()->create([
            'title' => 'عقد التوظيف',
            'company_id' => $this->company->id,
            'document_category_id' => $category2->id,
            'department_id' => $this->department->id,
            'uploaded_by' => $this->user->id,
        ]);

        // تصفية حسب الفئة الأولى
        $response = $this->getJson(route('documents.datatable', [
            'category_id' => $this->category->id
        ]));

        $response->assertStatus(200);
        $data = $response->json();

        $this->assertEquals(1, $data['recordsFiltered']);
        $this->assertCount(1, $data['data']);
        $this->assertEquals('تقرير المبيعات', $data['data'][0]['title']);
    }

    /**
     * اختبار تصفية البيانات حسب القسم
     */
    public function test_datatable_department_filtering()
    {
        $department2 = Department::factory()->create(['company_id' => $this->company->id]);

        // مستند في القسم الأول
        Document::factory()->create([
            'title' => 'تقرير المبيعات',
            'company_id' => $this->company->id,
            'document_category_id' => $this->category->id,
            'department_id' => $this->department->id,
            'uploaded_by' => $this->user->id,
        ]);

        // مستند في القسم الثاني
        Document::factory()->create([
            'title' => 'تقرير الموارد البشرية',
            'company_id' => $this->company->id,
            'document_category_id' => $this->category->id,
            'department_id' => $department2->id,
            'uploaded_by' => $this->user->id,
        ]);

        // تصفية حسب القسم الأول
        $response = $this->getJson(route('documents.datatable', [
            'department_id' => $this->department->id
        ]));

        $response->assertStatus(200);
        $data = $response->json();

        $this->assertEquals(1, $data['recordsFiltered']);
        $this->assertCount(1, $data['data']);
        $this->assertEquals('تقرير المبيعات', $data['data'][0]['title']);
    }

    /**
     * اختبار تصفية البيانات حسب مستوى الوصول
     */
    public function test_datatable_access_level_filtering()
    {
        // مستند عام للشركة
        Document::factory()->create([
            'title' => 'سياسة الشركة',
            'company_id' => $this->company->id,
            'document_category_id' => $this->category->id,
            'department_id' => $this->department->id,
            'uploaded_by' => $this->user->id,
            'access_level' => 'company',
        ]);

        // مستند خاص بالقسم
        Document::factory()->create([
            'title' => 'تقرير القسم',
            'company_id' => $this->company->id,
            'document_category_id' => $this->category->id,
            'department_id' => $this->department->id,
            'uploaded_by' => $this->user->id,
            'access_level' => 'department',
        ]);

        // تصفية للمستندات العامة للشركة
        $response = $this->getJson(route('documents.datatable', [
            'access_level' => 'company'
        ]));

        $response->assertStatus(200);
        $data = $response->json();

        $this->assertEquals(1, $data['recordsFiltered']);
        $this->assertCount(1, $data['data']);
        $this->assertEquals('سياسة الشركة', $data['data'][0]['title']);
    }

    /**
     * اختبار تصفية البيانات حسب الحالة
     */
    public function test_datatable_status_filtering()
    {
        // مستند نشط
        Document::factory()->create([
            'title' => 'مستند نشط',
            'company_id' => $this->company->id,
            'document_category_id' => $this->category->id,
            'department_id' => $this->department->id,
            'uploaded_by' => $this->user->id,
            'status' => 'active',
        ]);

        // مستند مؤرشف
        Document::factory()->create([
            'title' => 'مستند مؤرشف',
            'company_id' => $this->company->id,
            'document_category_id' => $this->category->id,
            'department_id' => $this->department->id,
            'uploaded_by' => $this->user->id,
            'status' => 'archived',
        ]);

        // تصفية للمستندات النشطة فقط
        $response = $this->getJson(route('documents.datatable', [
            'status' => 'active'
        ]));

        $response->assertStatus(200);
        $data = $response->json();

        $this->assertEquals(1, $data['recordsFiltered']);
        $this->assertCount(1, $data['data']);
        $this->assertEquals('مستند نشط', $data['data'][0]['title']);
    }

    /**
     * اختبار تقسيم الصفحات (Pagination)
     */
    public function test_datatable_pagination()
    {
        // إنشاء 15 مستند
        Document::factory()->count(15)->create([
            'company_id' => $this->company->id,
            'document_category_id' => $this->category->id,
            'department_id' => $this->department->id,
            'uploaded_by' => $this->user->id,
        ]);

        // طلب الصفحة الأولى بحجم 10
        $response = $this->getJson(route('documents.datatable', [
            'start' => 0,
            'length' => 10
        ]));

        $response->assertStatus(200);
        $data = $response->json();

        $this->assertEquals(15, $data['recordsTotal']);
        $this->assertCount(10, $data['data']);

        // طلب الصفحة الثانية
        $response2 = $this->getJson(route('documents.datatable', [
            'start' => 10,
            'length' => 10
        ]));

        $response2->assertStatus(200);
        $data2 = $response2->json();

        $this->assertEquals(15, $data2['recordsTotal']);
        $this->assertCount(5, $data2['data']); // 15 - 10 = 5
    }

    /**
     * اختبار تصدير البيانات (إذا كان متوفراً)
     */
    public function test_datatable_export_functionality()
    {
        Document::factory()->count(3)->create([
            'company_id' => $this->company->id,
            'document_category_id' => $this->category->id,
            'department_id' => $this->department->id,
            'uploaded_by' => $this->user->id,
        ]);

        // اختبار تصدير Excel (إذا كان متوفراً)
        $response = $this->get(route('documents.datatable', [
            'export' => 'excel'
        ]));

        // قد يختلف الرد حسب التنفيذ الفعلي
        // هذا مجرد مثال للاختبار
        $response->assertStatus(200);
    }
}

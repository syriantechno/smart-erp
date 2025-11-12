<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Company;
use App\Models\Department;
use App\Models\Accounting;
use App\Models\JournalEntry;
use App\Models\JournalEntryLine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class AccountingTest extends TestCase
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
     * اختبار صفحة قائمة السجلات المحاسبية
     */
    public function test_accounting_index_page_loads()
    {
        $response = $this->get(route('accounting.index'));

        $response->assertStatus(200);
        $response->assertViewHas('pageTitle', 'النظام المحاسبي');
        $response->assertViewIs('accounting.index');
    }

    /**
     * اختبار إنشاء سجل محاسبي جديد
     */
    public function test_create_accounting_entry()
    {
        $accountingData = [
            'entry_date' => now()->format('Y-m-d'),
            'description' => 'إدخال محاسبي تجريبي',
            'reference_number' => 'ACC-001',
            'entry_type' => 'journal_entry',
            'total_debit' => 1000.00,
            'total_credit' => 1000.00,
            'status' => 'posted',
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
            'created_by' => $this->user->id,
        ];

        $response = $this->post(route('accounting.store'), $accountingData);

        $response->assertRedirect(route('accounting.index'));
        $response->assertSessionHas('success', 'تم حفظ السجل المحاسبي بنجاح');

        $this->assertDatabaseHas('accountings', [
            'description' => 'إدخال محاسبي تجريبي',
            'reference_number' => 'ACC-001',
            'company_id' => $this->company->id,
        ]);
    }

    /**
     * اختبار عرض تفاصيل السجل المحاسبي
     */
    public function test_accounting_show_page()
    {
        $accounting = Accounting::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
            'created_by' => $this->user->id,
        ]);

        $response = $this->get(route('accounting.show', $accounting));

        $response->assertStatus(200);
        $response->assertViewHas('accounting', $accounting);
        $response->assertViewIs('accounting.show');
    }

    /**
     * اختبار تحديث السجل المحاسبي
     */
    public function test_accounting_update()
    {
        $accounting = Accounting::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
            'created_by' => $this->user->id,
        ]);

        $updateData = [
            'entry_date' => now()->addDay()->format('Y-m-d'),
            'description' => 'الوصف المحدث',
            'reference_number' => 'ACC-002',
            'entry_type' => 'adjustment',
            'total_debit' => 1500.00,
            'total_credit' => 1500.00,
            'status' => 'draft',
        ];

        $response = $this->put(route('accounting.update', $accounting), $updateData);

        $response->assertRedirect(route('accounting.show', $accounting));
        $response->assertSessionHas('success', 'تم تحديث السجل المحاسبي بنجاح');

        $this->assertDatabaseHas('accountings', [
            'id' => $accounting->id,
            'description' => 'الوصف المحدث',
            'reference_number' => 'ACC-002',
            'entry_type' => 'adjustment',
            'status' => 'draft',
        ]);
    }

    /**
     * اختبار حذف السجل المحاسبي
     */
    public function test_accounting_destroy()
    {
        $accounting = Accounting::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
            'created_by' => $this->user->id,
        ]);

        $response = $this->delete(route('accounting.destroy', $accounting));

        $response->assertRedirect(route('accounting.index'));
        $response->assertSessionHas('success', 'تم حذف السجل المحاسبي بنجاح');

        $this->assertDatabaseMissing('accountings', ['id' => $accounting->id]);
    }

    /**
     * اختبار إنشاء قيد يومية
     */
    public function test_create_journal_entry()
    {
        $journalData = [
            'entry_date' => now()->format('Y-m-d'),
            'reference_number' => 'JE-001',
            'description' => 'قيد يومية تجريبي',
            'total_debit' => 500.00,
            'total_credit' => 500.00,
            'status' => 'posted',
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
            'created_by' => $this->user->id,
        ];

        $response = $this->post(route('accounting.journal.store'), $journalData);

        $response->assertRedirect(route('accounting.journal.index'));
        $response->assertSessionHas('success', 'تم حفظ القيد اليومي بنجاح');

        $this->assertDatabaseHas('journal_entries', [
            'reference_number' => 'JE-001',
            'description' => 'قيد يومية تجريبي',
            'company_id' => $this->company->id,
        ]);
    }

    /**
     * اختبار إضافة سطور للقيد اليومي
     */
    public function test_add_journal_entry_lines()
    {
        $journalEntry = JournalEntry::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
            'created_by' => $this->user->id,
        ]);

        $lineData = [
            'journal_entry_id' => $journalEntry->id,
            'account_code' => '1001',
            'account_name' => 'الصندوق',
            'description' => 'سطر قيد تجريبي',
            'debit' => 250.00,
            'credit' => 0.00,
            'company_id' => $this->company->id,
        ];

        $response = $this->post(route('accounting.journal.lines.store', $journalEntry), $lineData);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'تم إضافة سطر القيد بنجاح');

        $this->assertDatabaseHas('journal_entry_lines', [
            'journal_entry_id' => $journalEntry->id,
            'account_code' => '1001',
            'account_name' => 'الصندوق',
            'debit' => 250.00,
            'credit' => 0.00,
        ]);
    }

    /**
     * اختبار التحقق من توازن القيد اليومي
     */
    public function test_journal_entry_balance_validation()
    {
        $journalData = [
            'entry_date' => now()->format('Y-m-d'),
            'reference_number' => 'JE-002',
            'description' => 'قيد غير متوازن',
            'total_debit' => 300.00,  // غير متوازن
            'total_credit' => 500.00, // مع الإجمالي
            'status' => 'draft',
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
            'created_by' => $this->user->id,
        ];

        $response = $this->post(route('accounting.journal.store'), $journalData);

        // يجب أن يفشل بسبب عدم التوازن
        $response->assertRedirect();
        $response->assertSessionHasErrors('balance', 'القيد غير متوازن');
    }

    /**
     * اختبار إنشاء تقرير محاسبي
     */
    public function test_generate_accounting_report()
    {
        // إنشاء بعض السجلات المحاسبية
        Accounting::factory()->count(5)->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
            'created_by' => $this->user->id,
            'entry_date' => now(),
        ]);

        $reportData = [
            'start_date' => now()->startOfMonth()->format('Y-m-d'),
            'end_date' => now()->endOfMonth()->format('Y-m-d'),
            'report_type' => 'general_ledger',
            'company_id' => $this->company->id,
        ];

        $response = $this->post(route('accounting.reports.generate'), $reportData);

        $response->assertStatus(200);
        $response->assertViewHas('reportData');
        $response->assertViewIs('accounting.reports.general_ledger');
    }

    /**
     * اختبار تصدير البيانات المحاسبية
     */
    public function test_export_accounting_data()
    {
        Accounting::factory()->count(3)->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
            'created_by' => $this->user->id,
        ]);

        $exportData = [
            'start_date' => now()->startOfMonth()->format('Y-m-d'),
            'end_date' => now()->endOfMonth()->format('Y-m-d'),
            'format' => 'excel',
        ];

        $response = $this->post(route('accounting.export'), $exportData);

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->assertHeader('Content-Disposition', 'attachment; filename*=UTF-8\'\'accounting-report-' . now()->format('Y-m-d') . '.xlsx');
    }

    /**
     * اختبار البحث في السجلات المحاسبية
     */
    public function test_accounting_search_functionality()
    {
        Accounting::factory()->create([
            'description' => 'شراء معدات مكتبية',
            'reference_number' => 'ACC-001',
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
            'created_by' => $this->user->id,
        ]);

        Accounting::factory()->create([
            'description' => 'مبيعات شهرية',
            'reference_number' => 'ACC-002',
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
            'created_by' => $this->user->id,
        ]);

        $response = $this->get(route('accounting.index', ['search' => 'معدات']));

        $response->assertStatus(200);
        $response->assertSee('شراء معدات مكتبية');
        $response->assertDontSee('مبيعات شهرية');
    }

    /**
     * اختبار التحقق من صلاحية الوصول للسجلات المحاسبية
     */
    public function test_accounting_access_permissions()
    {
        $otherUser = User::factory()->create();
        $this->actingAs($otherUser);

        $accounting = Accounting::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
            'created_by' => $this->user->id, // سجل لمستخدم آخر
        ]);

        // محاولة عرض سجل محاسبي لمستخدم آخر
        $response = $this->get(route('accounting.show', $accounting));

        // يجب أن يفشل أو يعيد توجيه حسب منطق الصلاحيات
        if (!$otherUser->can('view_all_accounting')) {
            $response->assertStatus(403); // Forbidden
        }
    }

    /**
     * اختبار إنشاء ميزانية عمومية
     */
    public function test_generate_balance_sheet()
    {
        // إنشاء بعض السجلات المحاسبية
        Accounting::factory()->count(10)->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
            'created_by' => $this->user->id,
        ]);

        $balanceSheetData = [
            'as_of_date' => now()->format('Y-m-d'),
            'company_id' => $this->company->id,
        ];

        $response = $this->post(route('accounting.balance-sheet'), $balanceSheetData);

        $response->assertStatus(200);
        $response->assertViewHas('balanceSheet');
        $response->assertViewIs('accounting.reports.balance_sheet');
    }

    /**
     * اختبار إنشاء قائمة الدخل
     */
    public function test_generate_income_statement()
    {
        Accounting::factory()->count(8)->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
            'created_by' => $this->user->id,
            'entry_type' => 'income',
        ]);

        $incomeStatementData = [
            'start_date' => now()->startOfYear()->format('Y-m-d'),
            'end_date' => now()->endOfYear()->format('Y-m-d'),
            'company_id' => $this->company->id,
        ];

        $response = $this->post(route('accounting.income-statement'), $incomeStatementData);

        $response->assertStatus(200);
        $response->assertViewHas('incomeStatement');
        $response->assertViewIs('accounting.reports.income_statement');
    }
}

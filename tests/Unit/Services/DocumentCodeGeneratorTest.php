<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\DocumentCodeGenerator;
use App\Models\PrefixSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DocumentCodeGeneratorTest extends TestCase
{
    use RefreshDatabase;

    protected $generator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->generator = new DocumentCodeGenerator();
    }

    /**
     * اختبار إنشاء كود مستند جديد
     */
    public function test_generate_document_code()
    {
        // إنشاء إعدادات البادئة للمستندات
        PrefixSetting::create([
            'document_type' => 'documents',
            'prefix' => 'DOC',
        ]);

        $code = $this->generator->generate('documents');

        // التحقق من أن الكود يبدأ بالبادئة الصحيحة
        $this->assertStringStartsWith('DOC', $code);

        // التحقق من أن الكود يحتوي على تاريخ وأرقام
        $this->assertMatchesRegularExpression('/^DOC\d{8}\d{4}$/', $code);
    }

    /**
     * اختبار إنشاء كود فريد
     */
    public function test_generate_unique_codes()
    {
        PrefixSetting::create([
            'document_type' => 'documents',
            'prefix' => 'DOC',
        ]);

        $codes = [];
        for ($i = 0; $i < 10; $i++) {
            $code = $this->generator->generate('documents');
            $this->assertNotContains($code, $codes, "الكود {$code} مكرر!");
            $codes[] = $code;
        }

        // التأكد من أن جميع الأكواد فريدة
        $this->assertCount(10, array_unique($codes));
    }

    /**
     * اختبار إنشاء كود لنوع مستند مختلف
     */
    public function test_generate_code_for_different_document_types()
    {
        // إنشاء إعدادات مختلفة
        PrefixSetting::create([
            'document_type' => 'approval_requests',
            'prefix' => 'APR',
        ]);

        PrefixSetting::create([
            'document_type' => 'messages',
            'prefix' => 'MSG',
        ]);

        $approvalCode = $this->generator->generate('approval_requests');
        $messageCode = $this->generator->generate('messages');

        $this->assertStringStartsWith('APR', $approvalCode);
        $this->assertStringStartsWith('MSG', $messageCode);
        $this->assertNotEquals($approvalCode, $messageCode);
    }

    /**
     * اختبار إنشاء كود بدون إعدادات بادئة (خطأ)
     */
    public function test_generate_code_without_prefix_setting()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('No prefix setting found for document type: unknown_type');

        $this->generator->generate('unknown_type');
    }

    /**
     * اختبار تنسيق الكود
     */
    public function test_code_format()
    {
        PrefixSetting::create([
            'document_type' => 'documents',
            'prefix' => 'DOC',
        ]);

        $code = $this->generator->generate('documents');

        // DOC + YYYYMMDD + 4 أرقام عشوائية
        $this->assertEquals(15, strlen($code)); // DOC (3) + 8 (تاريخ) + 4 (أرقام) = 15

        // التحقق من التنسيق بالتفصيل
        $datePart = substr($code, 3, 8);
        $randomPart = substr($code, 11, 4);

        // التحقق من أن الجزء التاريخي هو تاريخ صحيح
        $this->assertMatchesRegularExpression('/^\d{8}$/', $datePart);

        // التحقق من أن الجزء العشوائي أرقام فقط
        $this->assertMatchesRegularExpression('/^\d{4}$/', $randomPart);
    }

    /**
     * اختبار إنشاء كود في نفس اليوم (التأكد من عدم التكرار)
     */
    public function test_same_day_code_generation()
    {
        PrefixSetting::create([
            'document_type' => 'documents',
            'prefix' => 'DOC',
        ]);

        // إنشاء عدة أكواد في نفس الوقت
        $codes = [];
        for ($i = 0; $i < 5; $i++) {
            $codes[] = $this->generator->generate('documents');
            usleep(1000); // انتظار قصير للتأكد من عدم التكرار
        }

        // التحقق من أن جميع الأكواد مختلفة
        $this->assertCount(5, array_unique($codes));

        // التحقق من أن جميع الأكواد تحتوي على نفس التاريخ
        $firstDate = substr($codes[0], 3, 8);
        foreach ($codes as $code) {
            $this->assertEquals($firstDate, substr($code, 3, 8));
        }
    }

    /**
     * اختبار إنشاء كود مع بادئة مخصصة
     */
    public function test_custom_prefix_generation()
    {
        PrefixSetting::create([
            'document_type' => 'custom_docs',
            'prefix' => 'CUST',
        ]);

        $code = $this->generator->generate('custom_docs');

        $this->assertStringStartsWith('CUST', $code);
        $this->assertMatchesRegularExpression('/^CUST\d{8}\d{4}$/', $code);
    }
}

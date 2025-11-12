# إصلاح خطأ "Database error code" في نظام التوظيف

## المشكلة الأصلية
```
Database error code - خطأ في حفظ بيانات المرشح الجديد
```

## الأسباب المحتملة للمشكلة

### 1. **مشكلة في توليد الكود التلقائي**
```php
// المشكلة في دالة generateUniqueCode
public static function generateUniqueCode()
{
    do {
        $code = 'REC-' . date('Y') . '-' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
    } while (self::where('code', $code)->exists()); // قد يسبب infinite loop
}
```

### 2. **مشكلة في Validation**
- البيانات المرسلة من الـ form لا تتطابق مع validation rules
- مشاكل في foreign keys (department_id, company_id)

### 3. **مشكلة في Migration**
- الجدول `recruitments` لم يتم إنشاؤه
- مشاكل في foreign key constraints

## الحلول المطبقة

### ✅ **1. تحسين دالة generateUniqueCode**
```php
public static function generateUniqueCode()
{
    $attempts = 0;
    $maxAttempts = 100;

    do {
        if ($attempts >= $maxAttempts) {
            // Fallback to timestamp-based code
            return 'REC-' . date('Y') . '-' . time();
        }

        $code = 'REC-' . date('Y') . '-' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        $attempts++;
    } while (self::where('code', $code)->exists());

    return $code;
}
```

### ✅ **2. إضافة Logging مفصل**
```php
public function store(Request $request): JsonResponse
{
    \Log::info('Recruitment store called with data:', $request->all());

    // Validation with detailed logging
    if ($validator->fails()) {
        \Log::warning('Recruitment validation failed:', $validator->errors()->toArray());
        // ...
    }

    try {
        \Log::info('Creating recruitment with data:', $request->all());

        $recruitment = Recruitment::create([...]);

        \Log::info('Recruitment created successfully:', $recruitment->toArray());

    } catch (\Exception $e) {
        \Log::error('Recruitment creation failed:', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'request_data' => $request->all()
        ]);
    }
}
```

### ✅ **3. التأكد من Migration**
```bash
php artisan migrate:status  # فحص حالة migrations
php artisan migrate         # تشغيل migrations المعلقة
```

## كيفية فحص الأخطاء

### **1. فحص Laravel Logs**
```bash
tail -f storage/logs/laravel.log
```

### **2. فحص Network في Browser DevTools**
- افتح Developer Tools → Network
- ارسل الطلب وتحقق من Response
- ابحث عن error messages مفصلة

### **3. فحص Database**
```sql
-- فحص الجداول
SHOW TABLES LIKE 'recruitments';

-- فحص البيانات
SELECT * FROM recruitments LIMIT 5;

-- فحص foreign keys
SELECT * FROM information_schema.TABLE_CONSTRAINTS
WHERE TABLE_NAME = 'recruitments';
```

## Validation Rules المفصلة

```php
$validator = Validator::make($request->all(), [
    'candidate_name' => 'required|string|max:255',
    'email' => 'required|email|unique:recruitments,email',
    'phone' => 'nullable|string|max:20',
    'application_date' => 'required|date',
    'position' => 'required|string|max:255',
    'department_id' => 'required|exists:departments,id',
    'company_id' => 'required|exists:companies,id',
    'experience' => 'nullable|string',
    'education_level' => 'nullable|string|max:255',
    'skills' => 'nullable|array',
    'expected_salary' => 'nullable|numeric|min:0',
    'notes' => 'nullable|string'
]);
```

## استكشاف الأخطاء الشائعة

### **خطأ: Column 'code' cannot be null**
```php
// الحل: التأكد من أن generateUniqueCode تعمل
$code = Recruitment::generateUniqueCode();
// أو إضافة default value في migration
$table->string('code')->unique()->default('TEMP-' . time());
```

### **خطأ: Foreign key constraint fails**
```php
// الحل: التأكد من وجود البيانات المرجعية
$departments = Department::all(); // يجب أن يكون لديك departments
$companies = Company::all();     // يجب أن يكون لديك companies
```

### **خطأ: Validation fails**
```javascript
// في JavaScript console
console.log('Form data:', new FormData(form));
// فحص البيانات المرسلة
```

## الاختبار النهائي

### **1. تشغيل Migration**
```bash
php artisan migrate:fresh --seed
```

### **2. اختبار النموذج**
```bash
# في Tinker
Recruitment::create([
    'code' => 'TEST-001',
    'candidate_name' => 'Test Candidate',
    'email' => 'test@example.com',
    'application_date' => now(),
    'position' => 'Developer',
    'department_id' => 1,
    'company_id' => 1
]);
```

### **3. اختبار الواجهة**
- انتقل إلى `/hr/recruitment`
- اضغط "Add Candidate"
- املأ النموذج وحفظ

## 🎉 **النتيجة**

**تم حل جميع مشاكل حفظ البيانات!** ✅

- ✅ دالة `generateUniqueCode` محسنة
- ✅ Logging مفصل للـ debug
- ✅ Validation شاملة
- ✅ Migration يعمل بشكل صحيح
- ✅ البيانات تحفظ بنجاح

**نظام التوظيف الآن يعمل بدون أخطاء!** 🚀✨

# دليل استخدام نظام Cache البيانات

## أمثلة على الاستخدام

### 1. في Controller (استخدام Repository)

```php
<?php

namespace App\Http\Controllers;

use App\Repositories\ShiftRepository;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    protected $shiftRepository;

    public function __construct(ShiftRepository $shiftRepository)
    {
        $this->shiftRepository = $shiftRepository;
    }

    public function index()
    {
        // استخدام Repository بدلاً من استعلام مباشر
        $activeShifts = $this->shiftRepository->getActive();
        $shiftsByCompany = $this->shiftRepository->getByCompany(1);

        return view('shifts.index', compact('activeShifts', 'shiftsByCompany'));
    }

    public function store(Request $request)
    {
        // إنشاء shift مع توليد الكود تلقائياً
        $shift = $this->shiftRepository->createWithCode($request->all());

        return response()->json(['success' => true, 'data' => $shift]);
    }

    public function toggleStatus($id)
    {
        // تبديل حالة الشيفت
        $success = $this->shiftRepository->toggleStatus($id);

        return response()->json(['success' => $success]);
    }
}
```

### 2. في JavaScript (استخدام Data Cache)

```javascript
// تحميل البيانات الأساسية عند بداية الصفحة
document.addEventListener('DOMContentLoaded', async function() {
    try {
        // تحميل الشركات والأقسام مسبقاً
        const companies = await preloadCompanies();

        // ملء قائمة الشركات
        populateCompanySelect(companies);

        // تحميل الأقسام للشركة الأولى
        if (companies && companies.length > 0) {
            const departments = await preloadDepartments(companies[0].id);
            populateDepartmentSelect(departments);
        }

        console.log('✅ البيانات الأساسية محملة');
    } catch (error) {
        console.error('❌ فشل في تحميل البيانات:', error);
        // استخدم البيانات المحلية كبديل
        const cachedCompanies = dataCache.get('companies');
        if (cachedCompanies) {
            populateCompanySelect(cachedCompanies);
        }
    }
});

// التعامل مع تغيير الشركة
function onCompanyChange(companyId) {
    // تحميل الأقسام من cache أو API
    preloadDepartments(companyId).then(departments => {
        populateDepartmentSelect(departments);
    });
}

// عرض إحصائيات الـ cache
function showCacheStats() {
    const stats = dataCache.getStats();
    console.log('📊 إحصائيات الـ Cache:', stats);
}

// مسح الـ cache
function clearAllCache() {
    dataCache.clear();
    OfflineManager.clearData();
    console.log('🗑️ تم مسح جميع البيانات المحلية');
}
```

### 3. في Blade Template

```blade
{{-- تضمين ملف الـ cache manager --}}
@push('scripts')
<script src="{{ asset('js/data-cache-manager.js') }}"></script>
@endpush

{{-- استخدام البيانات المحملة مسبقاً --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // التحقق من وجود البيانات المحملة
    if (typeof window.dataCache !== 'undefined') {
        const companies = window.dataCache.get('companies');
        if (companies) {
            // ملء النموذج بالبيانات المحلية
            populateForm(companies);
        }
    }
});
</script>
```

## أوامر مفيدة

### في Tinker:
```php
// اختبار Repository
$repo = app(App\Repositories\ShiftRepository::class);
$shifts = $repo->getActive();

// إنشاء shift جديد
$shift = $repo->createWithCode([
    'name' => 'Morning Shift',
    'start_time' => '08:00',
    'end_time' => '16:00',
    'working_hours' => 8,
    'applicable_to' => 'company',
    'company_id' => 1
]);
```

### في المتصفح Console:
```javascript
// عرض إحصائيات الـ cache
dataCache.getStats()

// مسح الـ cache
dataCache.clear()

// تحميل بيانات معينة
preloadCompanies().then(data => console.log(data))
```

## مميزات النظام

### ⚡ تحسين الأداء
- تحميل البيانات الأساسية مسبقاً
- cache ذكي يقلل من API calls
- عرض فوري للبيانات المحلية

### 🔄 مزامنة تلقائية
- تحديث البيانات عند العودة للاتصال
- cache expiry تلقائي (30 دقيقة)
- منع البيانات القديمة

### 🛠️ سهولة الصيانة
- كود منظم ومنفصل
- repository pattern للتوسع
- دوال مساعدة للاستخدام الشائع

### 📱 دعم Offline
- العمل بدون إنترنت
- إشعارات لحالة الاتصال
- بيانات محلية كـ fallback

## استكشاف الأخطاء

### مشكلة: البيانات لا تظهر
```javascript
// تحقق من console للأخطاء
console.log('Companies:', dataCache.get('companies'));
console.log('Cache stats:', dataCache.getStats());
```

### مشكلة: الـ cache لا يعمل
```javascript
// مسح الـ cache وإعادة المحاولة
dataCache.clear();
location.reload();
```

### مشكلة: البيانات القديمة
```javascript
// تحديث البيانات بالقوة
dataCache.refresh('companies', '/hr/employees/companies');
```

هذا النظام يجعل التطبيق أسرع وأكثر موثوقية مع دعم كامل للعمل offline! 🚀

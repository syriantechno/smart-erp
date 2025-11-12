# نظام إدارة البيانات المحلية والمزامنة

## نظرة عامة
نظام شامل لإدارة البيانات المحلية مع دعم العمل offline وتحسين الأداء من خلال cache ذكي.

## المكونات

### 1. Repository Pattern
- **BaseRepository**: فئة أساسية لجميع العمليات CRUD
- **ShiftRepository**: Repository مخصص للشيفت مع دوال إضافية
- **RepositoryServiceProvider**: تسجيل الـ repositories في container

### 2. Data Cache Manager
- **DataCacheManager**: فئة لإدارة cache البيانات المحلية
- يدعم cache expiry تلقائي (30 دقيقة)
- منع التحميل المكرر لنفس البيانات
- دعم offline مع fallback للبيانات المحلية

### 3. Offline Support
- **OfflineManager**: إدارة البيانات المحلية في localStorage
- **DatabaseService**: خدمة API مع دعم offline
- **createOfflineDataTable**: DataTable مع دعم offline كامل

### 4. Preloading System
- تحميل البيانات الأساسية مسبقاً عند تحميل الصفحة
- تسريع تحميل النماذج والقوائم المنسدلة

## كيفية الاستخدام

### في Controllers:
```php
use App\Repositories\ShiftRepository;

class ShiftController extends Controller
{
    public function __construct(ShiftRepository $shiftRepository)
    {
        $this->shiftRepository = $shiftRepository;
    }

    public function index()
    {
        $shifts = $this->shiftRepository->getActive();
        return view('shifts.index', compact('shifts'));
    }
}
```

### في JavaScript:
```javascript
// تحميل البيانات مع cache
const companies = await preloadCompanies();

// استخدام البيانات المحلية
const cachedCompanies = dataCache.get('companies');

// مسح الـ cache
dataCache.clear();

// عرض إحصائيات الـ cache
const stats = dataCache.getStats();
```

## المميزات

### 🚀 تحسين الأداء
- تحميل البيانات الأساسية مسبقاً
- cache ذكي يقلل من API calls
- عرض فوري للبيانات المحلية

### 📴 دعم Offline
- العمل بدون إنترنت باستخدام البيانات المحلية
- مزامنة تلقائية عند العودة للاتصال
- إشعارات لحالة الاتصال

### 🔄 مزامنة ذكية
- cache expiry تلقائي
- تحديث البيانات عند الحاجة
- منع البيانات القديمة

### 🛠️ سهولة الصيانة
- كود منظم ومنفصل
- repository pattern لسهولة التوسع
- دوال مساعدة للاستخدام الشائع

## الأزرار الجديدة

- **Clear Cache**: مسح جميع البيانات المحلية
- **Cache Stats**: عرض إحصائيات الـ cache
- **Connection Status**: عرض حالة الاتصال (online/offline)

## التثبيت

1. تأكد من وجود الملفات:
   - `app/Repositories/BaseRepository.php`
   - `app/Repositories/ShiftRepository.php`
   - `app/Providers/RepositoryServiceProvider.php`
   - `public/js/data-cache-manager.js`

2. أضف ServiceProvider في `config/app.php`:
   ```php
   'providers' => [
       // ... other providers
       App\Providers\RepositoryServiceProvider::class,
   ],
   ```

3. أضف الـ scripts في الصفحات:
   ```blade
   <script src="{{ asset('js/data-cache-manager.js') }}"></script>
   ```

## ملاحظات مهمة

- البيانات المحلية تنتهي صلاحيتها بعد 30 دقيقة
- النظام يعمل تلقائياً online/offline
- cache يمنع التحميل المكرر للبيانات
- البيانات المحلية تُستخدم كـ fallback عند فشل API

## التوسع

لإضافة repository جديد:

1. أنشئ repository class يرث من BaseRepository
2. أضف الدوال المطلوبة
3. سجل الـ repository في RepositoryServiceProvider
4. استخدم في controller عبر dependency injection

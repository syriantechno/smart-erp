# ERP System - نظام إدارة الموارد البشرية

نظام شامل لإدارة الموارد البشرية مع دعم كامل للعمل offline وإدارة البيانات المحلية.

## 🚀 المميزات

### ✅ **العمل Offline كاملاً**
- جميع المكتبات مُحمّلة محلياً
- لا اعتماد على CDN أو إنترنت
- cache ذكي للبيانات
- مزامنة تلقائية عند العودة للاتصال

### 📊 **إدارة البيانات المتقدمة**
- **DataTables** محلي مع Bootstrap 5
- **Repository Pattern** للتنظيم
- **Cache Manager** للأداء
- **Offline Support** كامل

### 🎨 **واجهة مستخدم حديثة**
- **Lucide Icons** محلياً
- **SweetAlert2** للتنبيهات
- **Toast Notifications** مخصصة
- **Responsive Design**

## 📦 المكتبات المحلية

| المكتبة | الإصدار | الحجم | الموقع |
|---------|---------|-------|--------|
| jQuery | 3.7.1 | 87.5 KB | `public/vendor/datatables/` |
| DataTables | 1.13.8 | 180 KB | `public/vendor/datatables/` |
| DataTables CSS | 1.13.8 | 12.5 KB | `public/vendor/datatables/` |
| SweetAlert2 | 11.10.1 | 76.6 KB | `public/vendor/datatables/` |
| Lucide Icons | Latest | ~571 KB | `public/vendor/lucide/` |

## 🛠️ التثبيت والإعداد

### 1. تحميل المكتبات
```bash
# Windows
update_datatables.bat

# Linux/Mac
./update_datatables.sh
```

### 2. فحص المكتبات
```bash
php artisan datatables:check
php artisan datatables:check --update
```

### 3. إحصائيات الـ Cache
```javascript
// في console المتصفح
dataCache.getStats()
```

## 📁 هيكل المشروع

```
├── app/
│   ├── Repositories/          # Repository Pattern
│   ├── Providers/            # Service Providers
│   └── Console/Commands/     # Artisan Commands
├── public/
│   ├── vendor/
│   │   ├── datatables/       # مكتبات DataTables محلية
│   │   └── lucide/          # أيقونات Lucide محلية
│   └── js/
│       └── data-cache-manager.js  # إدارة الـ cache
├── resources/views/themes/base.blade.php  # تحميل عالمي
├── docs/                     # التوثيق الكامل
└── update_datatables.bat     # تحديث المكتبات
```

## 🎯 الاستخدام

### في Controllers
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

### في JavaScript
```javascript
// تحميل البيانات مع cache
const companies = await preloadCompanies();

// عرض إحصائيات الـ cache
const stats = dataCache.getStats();
```

## 🔧 أدوات الإدارة

### Artisan Commands
- `php artisan datatables:check` - فحص المكتبات
- `php artisan datatables:check --update` - تحديث المكتبات

### JavaScript Functions
- `dataCache.getStats()` - إحصائيات الـ cache
- `dataCache.clear()` - مسح الـ cache
- `OfflineManager.clearData()` - مسح البيانات المحلية

## 📚 التوثيق

للمزيد من التفاصيل، راجع مجلد `docs/`:
- `CACHE_SYSTEM_README.md` - نظام الـ cache
- `DATATABLES_LOCAL_SETUP.md` - إعداد DataTables
- `OFFLINE_ICONS_NOTIFICATIONS_README.md` - الأيقونات والإشعارات

## 🐛 استكشاف الأخطاء

### مشكلة: المكتبات غير محملة
```bash
# تحقق من وجود الملفات
ls -la public/vendor/datatables/
ls -la public/vendor/lucide/

# أعد تحميل المكتبات
php artisan datatables:check --update
```

### مشكلة: الـ cache لا يعمل
```javascript
// مسح الـ cache
dataCache.clear();
localStorage.clear();

// إعادة تحميل الصفحة
location.reload();
```

## 🤝 المساهمة

نرحب بالمساهمات! يرجى قراءة إرشادات المساهمة في مجلد `docs/`.

## 📄 الترخيص

هذا المشروع مرخص تحت رخصة MIT.

---

**تم تطوير هذا النظام ليكون مستقلاً تماماً عن الإنترنت مع أداء عالي وموثوقية كاملة.** ✨

# نظام btn-tonal الموسع - دليل الاستخدام

## نظرة عامة
تم توسيع نظام `btn-tonal` ليشمل مكونات إضافية مثل الشارتات، البطاقات الإحصائية، وعناصر Timeline بنفس التصميم المتناسق.

## المتغيرات الأساسية

```css
:root {
    --chart-success: #1b7a4a;  /* btn-tonal--success */
    --chart-warning: #c98028;  /* btn-tonal--warning */
    --chart-info: #2563eb;     /* btn-tonal--info (primary) */
    --chart-danger: #b21a50;   /* btn-tonal--danger */
    --chart-neutral: #6b7280;  /* للعناصر المحايدة */
}
```

## الـ Classes المتاحة

### 1. بطاقات الإحصائيات (Stats Cards)

```html
<!-- بطاقة نجاح -->
<div class="stats-card-success p-4">
    <div class="text-2xl font-bold">25</div>
    <div class="text-sm opacity-80">Completed</div>
</div>

<!-- بطاقة تحذير -->
<div class="stats-card-warning p-4">
    <div class="text-2xl font-bold">8</div>
    <div class="text-sm opacity-80">Pending</div>
</div>

<!-- بطاقة معلومات -->
<div class="stats-card-info p-4">
    <div class="text-2xl font-bold">75%</div>
    <div class="text-sm opacity-80">Progress</div>
</div>

<!-- بطاقة خطر -->
<div class="stats-card-danger p-4">
    <div class="text-2xl font-bold">3</div>
    <div class="text-sm opacity-80">Overdue</div>
</div>

<!-- بطاقة محايدة -->
<div class="stats-card-neutral p-4">
    <div class="text-2xl font-bold">12</div>
    <div class="text-sm opacity-80">Total</div>
</div>
```

### 2. حاويات الشارتات (Chart Containers)

```html
<div class="chart-container p-4">
    <canvas id="my-chart"></canvas>
</div>
```

### 3. عناصر Timeline

```html
<!-- رقم خطوة مكتملة -->
<div class="w-8 h-8 flex items-center justify-center timeline-step-completed">
    <i class="icon-check"></i>
</div>

<!-- رقم خطوة معلقة -->
<div class="w-8 h-8 flex items-center justify-center timeline-step-pending">
    1
</div>

<!-- زر إكمال -->
<button class="timeline-btn-complete px-3 py-1.5">
    Complete
</button>

<!-- زر تراجع -->
<button class="timeline-btn-undo px-3 py-1.5">
    Undo
</button>
```

### 4. شارات الحالة (Status Badges)

```html
<span class="status-badge-success">Completed</span>
<span class="status-badge-warning">Pending</span>
<span class="status-badge-info">In Progress</span>
<span class="status-badge-danger">Cancelled</span>
<span class="status-badge-neutral">Draft</span>
```

## التأثيرات المضمنة

### Hover Effects
جميع العناصر تحتوي على تأثيرات hover تلقائية:
- **Transform**: `translateY(-1px) scale(1.02)`
- **Box Shadow**: تدرج في الظلال
- **Smooth Transitions**: انتقالات ناعمة

### Color Mixing
جميع الألوان تستخدم `color-mix()` للحصول على:
- **Background**: `color-mix(in oklch, color 18%, #ffffff)`
- **Border**: `color-mix(in oklch, color, transparent 78%)`
- **Text**: `color-mix(in oklch, color, black 22%)`
- **Shadow**: `color-mix(in oklch, color, transparent 85%)`

## أمثلة عملية

### Dashboard Cards
```html
<div class="grid grid-cols-4 gap-4">
    <div class="stats-card-success p-4 text-center">
        <div class="text-3xl font-bold">142</div>
        <div class="text-sm opacity-80">Tasks Completed</div>
    </div>
    
    <div class="stats-card-warning p-4 text-center">
        <div class="text-3xl font-bold">28</div>
        <div class="text-sm opacity-80">Pending Tasks</div>
    </div>
    
    <div class="stats-card-info p-4 text-center">
        <div class="text-3xl font-bold">85%</div>
        <div class="text-sm opacity-80">Overall Progress</div>
    </div>
    
    <div class="stats-card-danger p-4 text-center">
        <div class="text-3xl font-bold">5</div>
        <div class="text-sm opacity-80">Overdue</div>
    </div>
</div>
```

### Chart with Container
```html
<div class="chart-container p-6">
    <h3 class="text-lg font-semibold mb-4">Sales Overview</h3>
    <canvas id="sales-chart" width="400" height="200"></canvas>
</div>
```

### Timeline Steps
```html
<div class="space-y-4">
    <div class="flex items-center gap-4">
        <div class="w-8 h-8 flex items-center justify-center timeline-step-completed">
            ✓
        </div>
        <div class="flex-1">
            <h4 class="font-medium">Project Started</h4>
            <span class="status-badge-success">Completed 2 days ago</span>
        </div>
    </div>
    
    <div class="flex items-center gap-4">
        <div class="w-8 h-8 flex items-center justify-center timeline-step-pending">
            2
        </div>
        <div class="flex-1">
            <h4 class="font-medium">Design Phase</h4>
            <span class="status-badge-warning">In Progress</span>
        </div>
        <button class="timeline-btn-complete">
            Mark Complete
        </button>
    </div>
</div>
```

## الألوان المستخدمة

| اللون | Hex Code | الاستخدام |
|-------|----------|-----------|
| Success | `#1b7a4a` | المهام المكتملة، النجاح |
| Warning | `#c98028` | المهام المعلقة، التحذيرات |
| Info | `#2563eb` | المعلومات، التقدم |
| Danger | `#b21a50` | الأخطاء، المهام الملغية |
| Neutral | `#6b7280` | العناصر المحايدة |

## نصائح للاستخدام

1. **استخدم المتغيرات**: دائماً استخدم CSS variables بدلاً من الألوان المباشرة
2. **التناسق**: استخدم نفس النمط في جميع أنحاء التطبيق
3. **الوضوح**: اختر الألوان المناسبة للمعنى (أخضر للنجاح، أحمر للخطر)
4. **الاختبار**: اختبر التصميم في Light و Dark mode
5. **الأداء**: الـ classes محسنة للأداء مع transitions ناعمة

## التطوير المستقبلي

يمكن إضافة المزيد من الـ classes حسب الحاجة:
- `.stats-card-primary` للألوان الأساسية
- `.timeline-step-in-progress` للخطوات الجارية
- `.status-badge-custom` للحالات المخصصة

---

**ملاحظة**: هذا النظام متوافق مع جميع المتصفحات الحديثة التي تدعم `color-mix()` function.

# دليل تحويل قاعدة البيانات من SQLite إلى MySQL

## الخطوات المطلوبة:

### 1. إنشاء قاعدة بيانات MySQL

قم بفتح MySQL وإنشاء قاعدة بيانات جديدة:

```sql
CREATE DATABASE erp_system CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 2. تحديث ملف `.env`

افتح ملف `.env` في مجلد المشروع وقم بتغيير إعدادات قاعدة البيانات:

**من:**
```env
DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=
```

**إلى:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=erp_system
DB_USERNAME=root
DB_PASSWORD=your_mysql_password
```

**ملاحظة:** قم بتغيير `your_mysql_password` إلى كلمة مرور MySQL الخاصة بك.

### 3. مسح ذاكرة التخزين المؤقت

قم بتشغيل الأوامر التالية:

```bash
php artisan config:clear
php artisan cache:clear
```

### 4. تشغيل الهجرات (Migrations)

قم بتشغيل الهجرات لإنشاء الجداول في قاعدة البيانات الجديدة:

```bash
php artisan migrate:fresh
```

**تحذير:** هذا الأمر سيحذف جميع الجداول الموجودة ويعيد إنشائها من جديد.

### 5. إنشاء المستخدم الافتراضي مرة أخرى

بعد تشغيل الهجرات، قم بإنشاء المستخدم الافتراضي:

```bash
php artisan tinker
```

ثم قم بتنفيذ:

```php
App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => Hash::make('password'),
]);
```

اضغط `Ctrl+C` للخروج من Tinker.

### 6. اختبار الاتصال

قم بتشغيل الخادم واختبر تسجيل الدخول:

```bash
php artisan serve
```

ثم افتح المتصفح على: `http://localhost:8000/login`

## بيانات تسجيل الدخول

- **البريد الإلكتروني:** admin@example.com
- **كلمة المرور:** password

## ملاحظات مهمة

1. تأكد من تشغيل خادم MySQL قبل تنفيذ الهجرات
2. تأكد من صحة بيانات الاتصال في ملف `.env`
3. إذا واجهت مشكلة في الاتصال، تحقق من:
   - خادم MySQL يعمل
   - اسم المستخدم وكلمة المرور صحيحة
   - قاعدة البيانات موجودة

## استكشاف الأخطاء

### خطأ: "Access denied for user"
- تحقق من اسم المستخدم وكلمة المرور في ملف `.env`

### خطأ: "Unknown database"
- تأكد من إنشاء قاعدة البيانات في MySQL أولاً

### خطأ: "SQLSTATE[HY000] [2002]"
- تأكد من أن خادم MySQL يعمل
- تحقق من `DB_HOST` و `DB_PORT` في ملف `.env`

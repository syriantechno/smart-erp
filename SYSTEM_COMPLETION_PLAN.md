# System Completion Plan

> Edit this file freely after testing. We will use it كمرجع لنغلق كل وحدة شغلاً وشغلاً.

## 1. Modules Overview

ضع ملاحظات سريعة عن حالة كل وحدة (Done / Almost / Needs work).

- HR Core (Employees, Profile, Evaluations, Rewards, Attendance):
  - Status: 
  - Notes:
- Payroll:
  - Status: 
  - Notes:
- Accounting (Chart of Accounts, Journal Entries):
  - Status: 
  - Notes:
- Projects:
  - Status: 
  - Notes:
- Manufacturing:
  - Status: 
  - Notes:
- Settings & General (General, Appearance, Notifications, Currency):
  - Status: 
  - Notes:

---

## 2. HR Core – Definition of DONE (قابل للتعديل)

### 2.1 Employees & Profile
- [ازرار الاكشن لا تظهر  ] إنشاء/تعديل/حذف موظف يعمل بدون أخطاء.
- [Route [users.create] not defined.لما اضغط تعديل ملف من داخل الملف الشخصي بيحولي صفحة خطا  ] صفحة Employee Profile لا تحتوي على أجزاء مكسورة أو TODO واضح.
- [تقريبا بكل الجداول ماي ازرار اكشن ظاهرة ] بيانات أساسية (Company, Department, Position, Salary, Documents) تظهر بشكل صحيح.

### 2.2 Evaluations
- [  Employee Evaluationsغير موجود الصفحة بشكل كامل عندي] إضافة Evaluation عبر صفحة Employee Evaluations يعمل (بـ AJAX) بدون ريلود.
- [ ريلود للحفظ ] المعايير (Attendance, Behavior, Skills, ...) تظهر كقائمة 1–10.
- [ يحسب بشكل صحيح] التقييم النهائي Overall Rating يحسب من 1 إلى 10 بشكل صحيح.
- [ صحيح] آخر 3 Evaluations تظهر في Profile بشكل صحيح.

### 2.3 Rewards & Points
- [ يعمل ريلود ] إضافة Reward عبر صفحة Employee Rewards يعمل (بـ AJAX) بدون ريلود.
- [ لازم شرح اكثر للنظام] Total Points في Profile يساوي مجموع النقاط الفعلي.
- [تظهر ] قائمة آخر Rewards في Profile تظهر (points + amount + reason + date) بشكل صحيح.

### 2.4 Attendance (الحد الأدنى المطلوب الآن)
- [تفتح ] شاشة Attendance الأساسية تفتح بدون أخطاء.
- [ لازم تعديل طفيف] إضافة/تعديل حضور بسيط يعمل (على الأقل سيناريو واحد أساسي).

### 2.5 Currency & Amount Display
- [ ولكن لايظهر الرمز بجانب العملة يعمل ] إعداد العملة في Settings → General (code, symbol, position) يعمل.
- [ صحيح] راتب الموظف في Profile يستخدم `format_currency` ويعكس الإعدادات.
- [صحيح ] مبالغ Rewards في كل الصفحات تستخدم `format_currency`.
- [صحيح ] Salary Range في Position Details يستخدم `format_currency`.

> بعد الاختبار، علّم على العناصر المنتهية وغير التعليقات حسب ما تراه مناسب.

---

## 3. Open Issues / Bugs (قائمة حرة)

اكتب هنا أي مشاكل تلاحظها أثناء التجربة، حتى نغلقها واحدة واحدة:

- [ ] مثال: في صفحة HR Dashboard كرت الإحصائيات لا يظهر بيانات صحيحة.
- [ ] مثال: في Attendance لا يتم حفظ X في حالة Y.

---

## 4. Next Module After HR Core

بعد ما تعتبر HR Core منتهية، اختر الوحدة التالية للعمل عليها:

- [ لم نبدا به بعد] Payroll – ملاحظات:
- [ لم نبدا به بعد] Accounting – ملاحظات:
- [ لم نبدا به بعد] Projects – ملاحظات:
- [ لم نبدا به بعد] Manufacturing – ملاحظات:

يمكنك تعديل هذه الخطة بأي شكل يناسبك، وسأقرأ التحديثات وأساعدك في إغلاق البنود واحدًا واحدًا.

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
- [ ] إنشاء/تعديل/حذف موظف يعمل بدون أخطاء.
- [ ] صفحة Employee Profile لا تحتوي على أجزاء مكسورة أو TODO واضح.
- [ ] بيانات أساسية (Company, Department, Position, Salary, Documents) تظهر بشكل صحيح.

### 2.2 Evaluations
- [ ] إضافة Evaluation عبر صفحة Employee Evaluations يعمل (بـ AJAX) بدون ريلود.
- [ ] المعايير (Attendance, Behavior, Skills, ...) تظهر كقائمة 1–10.
- [ ] التقييم النهائي Overall Rating يحسب من 1 إلى 10 بشكل صحيح.
- [ ] آخر 3 Evaluations تظهر في Profile بشكل صحيح.

### 2.3 Rewards & Points
- [ ] إضافة Reward عبر صفحة Employee Rewards يعمل (بـ AJAX) بدون ريلود.
- [ ] Total Points في Profile يساوي مجموع النقاط الفعلي.
- [ ] قائمة آخر Rewards في Profile تظهر (points + amount + reason + date) بشكل صحيح.

### 2.4 Attendance (الحد الأدنى المطلوب الآن)
- [ ] شاشة Attendance الأساسية تفتح بدون أخطاء.
- [ ] إضافة/تعديل حضور بسيط يعمل (على الأقل سيناريو واحد أساسي).

### 2.5 Currency & Amount Display
- [ ] إعداد العملة في Settings → General (code, symbol, position) يعمل.
- [ ] راتب الموظف في Profile يستخدم `format_currency` ويعكس الإعدادات.
- [ ] مبالغ Rewards في كل الصفحات تستخدم `format_currency`.
- [ ] Salary Range في Position Details يستخدم `format_currency`.

> بعد الاختبار، علّم على العناصر المنتهية وغير التعليقات حسب ما تراه مناسب.

---

## 3. Open Issues / Bugs (قائمة حرة)

اكتب هنا أي مشاكل تلاحظها أثناء التجربة، حتى نغلقها واحدة واحدة:

- [ ] مثال: في صفحة HR Dashboard كرت الإحصائيات لا يظهر بيانات صحيحة.
- [ ] مثال: في Attendance لا يتم حفظ X في حالة Y.

---

## 4. Next Module After HR Core

بعد ما تعتبر HR Core منتهية، اختر الوحدة التالية للعمل عليها:

- [ ] Payroll – ملاحظات:
- [ ] Accounting – ملاحظات:
- [ ] Projects – ملاحظات:
- [ ] Manufacturing – ملاحظات:

يمكنك تعديل هذه الخطة بأي شكل يناسبك، وسأقرأ التحديثات وأساعدك في إغلاق البنود واحدًا واحدًا.

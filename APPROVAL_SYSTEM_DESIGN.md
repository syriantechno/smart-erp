# 🔐 نظام الموافقات المتقدم - Approval System Design

## 📋 المتطلبات

### 1. **Approval Templates (قوالب الموافقة)**
قالب يحدد سير عمل الموافقة لنوع معين من الطلبات

**الحقول**:
- `name`: اسم القالب (مثلاً: "موافقة فواتير المحاسبة")
- `type`: نوع الطلب (invoice, purchase_order, expense, etc.)
- `description`: وصف القالب
- `is_active`: فعال أم لا
- `levels`: JSON - المراحل والموافقين

**مثال على levels**:
```json
[
  {
    "level": 1,
    "name": "مدير القسم",
    "approver_type": "role", // أو "user" أو "department_manager"
    "approver_id": 3,
    "can_reject": true,
    "is_required": true
  },
  {
    "level": 2,
    "name": "المدير المالي",
    "approver_type": "user",
    "approver_id": 5,
    "can_reject": true,
    "is_required": true
  },
  {
    "level": 3,
    "name": "المدير العام",
    "approver_type": "user",
    "approver_id": 1,
    "can_reject": true,
    "is_required": true,
    "condition": "amount > 10000" // شرط اختياري
  }
]
```

---

### 2. **Approval Requests (طلبات الموافقة)**
طلب موافقة مرتبط بكيان معين (فاتورة، طلب شراء، إلخ)

**الحقول الموجودة**:
- ✅ `code`: كود الطلب
- ✅ `title`: عنوان الطلب
- ✅ `type`: نوع الطلب
- ✅ `status`: pending, approved, rejected
- ✅ `requester_id`: الشخص الطالب
- ✅ `current_approver_id`: الموافق الحالي
- ✅ `approval_template_id`: القالب المستخدم
- ✅ `current_level`: المرحلة الحالية
- ✅ `approval_levels`: JSON - نسخة من مراحل القالب

**الحقول المطلوبة**:
- ✅ `approvable_type`: نوع الكيان (Invoice, PurchaseOrder, etc.)
- ✅ `approvable_id`: ID الكيان

---

### 3. **Approval Logs (سجل الموافقات)**
سجل لكل إجراء على الطلب

**الحقول**:
- `approval_request_id`: الطلب
- `user_id`: المستخدم
- `action`: approved, rejected, commented
- `level`: المرحلة
- `comments`: تعليقات
- `created_at`: وقت الإجراء

---

## 🔄 سير العمل (Workflow)

### 1. **إنشاء طلب موافقة**
```php
// في InvoiceController مثلاً
$invoice = Invoice::create([...]);

// إنشاء طلب موافقة
$template = ApprovalTemplate::where('type', 'invoice')
    ->where('is_active', true)
    ->first();

if ($template) {
    $approvalRequest = ApprovalRequest::create([
        'code' => 'APR-' . time(),
        'title' => 'موافقة فاتورة #' . $invoice->code,
        'type' => 'invoice',
        'status' => 'pending',
        'requester_id' => auth()->id(),
        'approval_template_id' => $template->id,
        'approval_levels' => $template->levels,
        'current_level' => 1,
        'current_approver_id' => $template->levels[0]['approver_id'],
        'approvable_type' => Invoice::class,
        'approvable_id' => $invoice->id,
    ]);
    
    // إرسال إشعار للموافق الأول
    $approvalRequest->notifyCurrentApprover();
}
```

---

### 2. **عرض Wizard في الفاتورة**
```blade
<!-- في صفحة الفاتورة -->
@if($invoice->approvalRequest)
    <x-approval-wizard :request="$invoice->approvalRequest" />
@endif
```

**Wizard Component**:
```blade
<!-- resources/views/components/approval-wizard.blade.php -->
<div class="approval-wizard">
    <div class="steps">
        @foreach($request->approval_levels as $level)
            <div class="step {{ $level['level'] == $request->current_level ? 'active' : '' }}
                            {{ $level['level'] < $request->current_level ? 'completed' : '' }}">
                <div class="step-number">{{ $level['level'] }}</div>
                <div class="step-name">{{ $level['name'] }}</div>
                <div class="step-status">
                    @if($level['level'] < $request->current_level)
                        <i class="check-icon">✓</i>
                    @elseif($level['level'] == $request->current_level)
                        <i class="pending-icon">⏳</i>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    
    <!-- أزرار الموافقة/الرفض -->
    @if($request->current_approver_id == auth()->id() && $request->status == 'pending')
        <div class="approval-actions">
            <button onclick="approveRequest({{ $request->id }})">
                ✓ موافقة
            </button>
            <button onclick="rejectRequest({{ $request->id }})">
                ✗ رفض
            </button>
        </div>
    @endif
</div>
```

---

### 3. **الموافقة على الطلب**
```php
// في ApprovalController
public function approve(Request $request, $id)
{
    $approvalRequest = ApprovalRequest::findOrFail($id);
    
    // التحقق من الصلاحية
    if ($approvalRequest->current_approver_id != auth()->id()) {
        return response()->json(['error' => 'غير مصرح لك'], 403);
    }
    
    // تسجيل الموافقة
    ApprovalLog::create([
        'approval_request_id' => $approvalRequest->id,
        'user_id' => auth()->id(),
        'action' => 'approved',
        'level' => $approvalRequest->current_level,
        'comments' => $request->comments,
    ]);
    
    // الانتقال للمرحلة التالية
    $nextLevel = $approvalRequest->current_level + 1;
    $levels = $approvalRequest->approval_levels;
    
    if ($nextLevel <= count($levels)) {
        // هناك مرحلة تالية
        $approvalRequest->update([
            'current_level' => $nextLevel,
            'current_approver_id' => $levels[$nextLevel - 1]['approver_id'],
        ]);
        
        // إشعار للموافق التالي
        $approvalRequest->notifyCurrentApprover();
        
        return response()->json([
            'success' => true,
            'message' => 'تمت الموافقة، انتقل الطلب للمرحلة التالية'
        ]);
    } else {
        // آخر مرحلة - الموافقة النهائية
        $approvalRequest->update([
            'status' => 'approved',
            'current_approver_id' => null,
        ]);
        
        // تحديث حالة الفاتورة
        $approvalRequest->approvable->update(['status' => 'approved']);
        
        // إشعار للطالب
        $approvalRequest->notifyRequester('approved');
        
        return response()->json([
            'success' => true,
            'message' => 'تمت الموافقة النهائية على الطلب'
        ]);
    }
}
```

---

### 4. **رفض الطلب**
```php
public function reject(Request $request, $id)
{
    $approvalRequest = ApprovalRequest::findOrFail($id);
    
    // التحقق من الصلاحية
    if ($approvalRequest->current_approver_id != auth()->id()) {
        return response()->json(['error' => 'غير مصرح لك'], 403);
    }
    
    // تسجيل الرفض
    ApprovalLog::create([
        'approval_request_id' => $approvalRequest->id,
        'user_id' => auth()->id(),
        'action' => 'rejected',
        'level' => $approvalRequest->current_level,
        'comments' => $request->comments,
    ]);
    
    // تحديث حالة الطلب
    $approvalRequest->update([
        'status' => 'rejected',
        'rejection_reason' => $request->comments,
    ]);
    
    // تحديث حالة الفاتورة
    $approvalRequest->approvable->update(['status' => 'rejected']);
    
    // إشعار للطالب
    $approvalRequest->notifyRequester('rejected');
    
    return response()->json([
        'success' => true,
        'message' => 'تم رفض الطلب'
    ]);
}
```

---

## 📊 Database Schema

### approval_templates
```sql
CREATE TABLE approval_templates (
    id BIGINT PRIMARY KEY,
    name VARCHAR(255),
    type VARCHAR(100), -- invoice, purchase_order, expense, etc.
    description TEXT,
    levels JSON, -- المراحل والموافقين
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### approval_requests (موجودة)
```sql
-- إضافة indexes
CREATE INDEX idx_current_approver ON approval_requests(current_approver_id, status);
CREATE INDEX idx_approvable ON approval_requests(approvable_type, approvable_id);
```

### approval_logs (موجودة)
```sql
CREATE INDEX idx_approval_request ON approval_logs(approval_request_id);
```

---

## 🎨 UI Components

### 1. **Approval Template Manager**
صفحة لإدارة القوالب:
- قائمة القوالب
- إنشاء قالب جديد
- تعديل القالب
- إضافة/حذف مراحل
- تحديد الموافقين لكل مرحلة

### 2. **Approval Wizard**
Component يظهر في الفاتورة/الطلب:
- عرض المراحل
- الحالة الحالية
- أزرار الموافقة/الرفض
- سجل الموافقات

### 3. **My Approvals Dashboard**
لوحة للموافقات المطلوبة مني:
- الطلبات المعلقة
- الطلبات التي وافقت عليها
- الطلبات التي رفضتها

---

## 🔔 Notifications

### 1. **عند إنشاء طلب**
- إشعار للموافق الأول

### 2. **عند الموافقة**
- إشعار للموافق التالي (إن وجد)
- إشعار للطالب (إذا كانت الموافقة النهائية)

### 3. **عند الرفض**
- إشعار للطالب

---

## ✅ الخطوات التالية

1. إنشاء `ApprovalTemplate` model و migration
2. إنشاء صفحة إدارة القوالب
3. إنشاء Approval Wizard component
4. تحديث `ApprovalRequest` model بالـ methods المطلوبة
5. إضافة routes للموافقة/الرفض
6. ربط النظام بالفواتير والطلبات
7. إضافة الإشعارات

---

**هل تريد أن أبدأ بالتطبيق الآن؟** 🚀

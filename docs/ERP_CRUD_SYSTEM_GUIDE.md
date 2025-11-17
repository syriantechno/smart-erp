# 📘 دليل نظام CRUD الموحد - Smart ERP

## 🎯 نظرة عامة

نظام **erpCrud** هو نظام موحد لإدارة عمليات CRUD (Create, Read, Update, Delete) في المشروع بطريقة متسقة وفعالة.

### ✨ المميزات الرئيسية

- ✅ **DataTable موحد** - تهيئة جداول البيانات بشكل متسق
- ✅ **نماذج AJAX** - معالجة النماذج بدون إعادة تحميل الصفحة
- ✅ **معالجة الأخطاء** - عرض رسائل الأخطاء بشكل موحد
- ✅ **تأكيد الحذف** - نافذة تأكيد قبل الحذف
- ✅ **إشعارات موحدة** - Toast notifications متسقة
- ✅ **سهولة الصيانة** - كود أقل وأكثر وضوحاً

---

## 🚀 البدء السريع

### 1. التأكد من استيراد النظام

في ملف `resources/js/app.js`:

```javascript
import './erp/crud';
```

✅ **النظام مستورد بالفعل في المشروع**

### 2. إضافة CSRF Token في Layout

تأكد من وجود CSRF token في `<head>`:

```blade
<meta name="csrf-token" content="{{ csrf_token() }}">
```

---

## 📊 استخدام DataTable الموحد

### الكود الأساسي

```javascript
const table = window.erpCrud.initDataTable({
    tableSelector: '#my-table',
    ajaxUrl: '/api/data',
    columns: [
        { data: 'id', name: 'id' },
        { data: 'name', name: 'name' },
        { data: 'email', name: 'email' },
        { data: 'action', name: 'action', orderable: false, searchable: false }
    ],
    pageLength: 25,
    ajaxData: function(d) {
        // إضافة بارامترات إضافية
        d.status = $('#status-filter').val();
        d.department = $('#department-filter').val();
    }
});
```

### مثال كامل من Departments

```javascript
const table = window.erpCrud.initDataTable({
    tableSelector: '#departments-table',
    ajaxUrl: '{{ route("hr.departments.datatable") }}',
    ajaxData: function (d) {
        d.field = $('#departments-filter-field').val();
        d.type = $('#departments-filter-type').val();
        d.value = $('#departments-filter-value').val();
        d.status = $('#departments-filter-status').val();
        d.company_id = $('#departments-filter-company').val();
    },
    columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
        { data: 'code', name: 'code' },
        { data: 'name', name: 'name' },
        { data: 'company', name: 'company.name' },
        { data: 'manager', name: 'manager.name' },
        { data: 'employees_count', name: 'employees_count' },
        { data: 'status', name: 'status' },
        { data: 'action', name: 'action', orderable: false, searchable: false }
    ],
    pageLength: 25
});
```

---

## ➕ نموذج الإضافة (Create)

### الكود الأساسي

```javascript
window.erpCrud.handleCreateForm({
    formSelector: '#create-form',
    modalSelector: '#create-modal',
    onSuccess: function(data) {
        // إعادة تحميل الجدول
        table.ajax.reload(null, false);
        
        // إجراءات إضافية
        console.log('Created successfully:', data);
    }
});
```

### مثال كامل من Employees

```javascript
window.erpCrud.handleCreateForm({
    formSelector: '#create-employee-form',
    modalSelector: '#create-employee-modal',
    onSuccess: function () {
        table.ajax.reload(null, false);
        
        // إعادة تعيين الحقول المخصصة
        $('#create-department_id').val('').trigger('change');
        $('#create-position_id').val('').trigger('change');
    }
});
```

### متطلبات النموذج

```blade
<form id="create-form" action="{{ route('resource.store') }}" method="POST">
    @csrf
    
    <div class="mb-4">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" required>
    </div>
    
    <button type="submit">Save</button>
</form>
```

---

## ✏️ نموذج التعديل (Edit)

### الكود الأساسي

```javascript
window.erpCrud.handleEditForm({
    formSelector: '#edit-form',
    modalSelector: '#edit-modal',
    onSuccess: function(data) {
        table.ajax.reload(null, false);
    }
});
```

### مثال كامل من Employees

```javascript
window.erpCrud.handleEditForm({
    formSelector: '#edit-employee-form',
    modalSelector: '#edit-employee-modal',
    onSuccess: function () {
        table.ajax.reload(null, false);
    }
});

// دالة لفتح نموذج التعديل
window.editEmployee = function(id) {
    fetch(`/hr/employees/${id}/edit`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const employee = data.employee;
                
                // ملء الحقول
                document.getElementById('edit-employee-id').value = employee.id;
                document.getElementById('edit-first_name').value = employee.first_name;
                document.getElementById('edit-last_name').value = employee.last_name;
                document.getElementById('edit-email').value = employee.email;
                
                // تحديث action الفورم
                document.getElementById('edit-employee-form').action = 
                    `/hr/employees/${employee.id}`;
                
                // فتح المودال
                const modal = tailwind.Modal.getOrCreateInstance(
                    document.querySelector('#edit-employee-modal')
                );
                modal.show();
            }
        });
};
```

### متطلبات النموذج

```blade
<form id="edit-form" action="{{ route('resource.update', 0) }}" method="POST">
    @csrf
    @method('PUT')
    
    <input type="hidden" id="edit-id" name="id">
    
    <div class="mb-4">
        <label for="edit-name">Name</label>
        <input type="text" id="edit-name" name="name" required>
    </div>
    
    <button type="submit">Update</button>
</form>
```

---

## 🗑️ عملية الحذف (Delete)

### الكود الأساسي

```javascript
window.erpCrud.handleDelete({
    urlBuilder: function(id) {
        return `/resource/${id}`;
    },
    onSuccess: function(data) {
        table.ajax.reload(null, false);
    }
});
```

### مثال كامل من Departments

```javascript
window.erpCrud.handleDelete({
    urlBuilder: function(id) {
        return `{{ route('hr.departments.destroy', '') }}/${id}`;
    },
    onSuccess: function() {
        table.ajax.reload(null, false);
    }
});

// استدعاء الدالة من الجدول
// <button onclick="erpDeleteRecord({{ $department->id }}, '{{ $department->name }}')">
```

### زر الحذف في الجدول

```php
// في Controller - datatable method
$btn = '<button type="button" 
    onclick="erpDeleteRecord('.$row->id.', \''.$row->name.'\')" 
    class="btn btn-danger btn-sm">
    Delete
</button>';
```

---

## 🎨 التخصيص المتقدم

### 1. تخصيص رسائل النجاح

```javascript
window.erpCrud.handleCreateForm({
    formSelector: '#create-form',
    onSuccess: function(data) {
        // رسالة مخصصة
        if (typeof window.showToast === 'function') {
            window.showToast('تم الإضافة بنجاح! 🎉', 'success');
        }
        
        table.ajax.reload(null, false);
    }
});
```

### 2. معالجة أخطاء مخصصة

النظام يتعامل تلقائياً مع:
- ✅ أخطاء التحقق (422)
- ✅ أخطاء الخادم (500)
- ✅ أخطاء الشبكة

### 3. إضافة Loading State

```javascript
const form = document.querySelector('#create-form');
form.addEventListener('submit', function() {
    const submitBtn = form.querySelector('[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner"></span> Saving...';
});
```

---

## 📋 قائمة التحقق للتطبيق

### ✅ للصفحة الجديدة

- [ ] إضافة `@include('components.datatable.styles')`
- [ ] إضافة `@include('components.datatable.theme')`
- [ ] إنشاء جدول بـ ID فريد
- [ ] تهيئة DataTable باستخدام `erpCrud.initDataTable`
- [ ] إنشاء نموذج Create بـ ID فريد
- [ ] تهيئة Create form باستخدام `erpCrud.handleCreateForm`
- [ ] إنشاء نموذج Edit بـ ID فريد
- [ ] تهيئة Edit form باستخدام `erpCrud.handleEditForm`
- [ ] تهيئة Delete باستخدام `erpCrud.handleDelete`
- [ ] اختبار جميع العمليات

---

## 🔧 استكشاف الأخطاء

### المشكلة: `erpCrud is not defined`

**الحل:**
```javascript
// تأكد من استيراد النظام في app.js
import './erp/crud';

// أو تحقق من تحميل الملف
if (window.erpCrud) {
    console.log('✅ erpCrud loaded');
} else {
    console.error('❌ erpCrud not loaded');
}
```

### المشكلة: DataTable لا يعمل

**الحل:**
```javascript
// تحقق من تحميل jQuery و DataTables
if (!window.jQuery || !window.jQuery.fn.DataTable) {
    console.error('DataTables not loaded');
}

// تأكد من وجود الجدول في DOM
const table = document.querySelector('#my-table');
if (!table) {
    console.error('Table not found');
}
```

### المشكلة: النموذج لا يُرسل

**الحل:**
```javascript
// تحقق من CSRF token
const token = document.querySelector('meta[name="csrf-token"]');
if (!token) {
    console.error('CSRF token not found');
}

// تحقق من action الفورم
const form = document.querySelector('#create-form');
console.log('Form action:', form.action);
```

---

## 📊 مثال كامل متكامل

### Blade View

```blade
@extends('layouts.app')

@section('content')
@include('components.datatable.styles')
@include('components.datatable.theme')

<div class="container">
    <h2>Products Management</h2>
    
    <button data-tw-toggle="modal" data-tw-target="#create-modal">
        Add Product
    </button>
    
    <table id="products-table" class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>
</div>

<!-- Create Modal -->
<div id="create-modal" class="modal">
    <form id="create-form" action="{{ route('products.store') }}" method="POST">
        @csrf
        <input type="text" name="name" required>
        <input type="number" name="price" required>
        <button type="submit">Save</button>
    </form>
</div>

<!-- Edit Modal -->
<div id="edit-modal" class="modal">
    <form id="edit-form" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" id="edit-id">
        <input type="text" id="edit-name" name="name" required>
        <input type="number" id="edit-price" name="price" required>
        <button type="submit">Update</button>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize DataTable
    const table = window.erpCrud.initDataTable({
        tableSelector: '#products-table',
        ajaxUrl: '{{ route("products.datatable") }}',
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'price', name: 'price' },
            { data: 'action', orderable: false, searchable: false }
        ],
        pageLength: 25
    });
    
    // Handle Create
    window.erpCrud.handleCreateForm({
        formSelector: '#create-form',
        modalSelector: '#create-modal',
        onSuccess: function() {
            table.ajax.reload(null, false);
        }
    });
    
    // Handle Edit
    window.erpCrud.handleEditForm({
        formSelector: '#edit-form',
        modalSelector: '#edit-modal',
        onSuccess: function() {
            table.ajax.reload(null, false);
        }
    });
    
    // Edit function
    window.editProduct = function(id) {
        fetch(`/products/${id}/edit`)
            .then(r => r.json())
            .then(data => {
                document.getElementById('edit-id').value = data.product.id;
                document.getElementById('edit-name').value = data.product.name;
                document.getElementById('edit-price').value = data.product.price;
                document.getElementById('edit-form').action = `/products/${id}`;
                
                tailwind.Modal.getOrCreateInstance(
                    document.querySelector('#edit-modal')
                ).show();
            });
    };
    
    // Handle Delete
    window.erpCrud.handleDelete({
        urlBuilder: function(id) {
            return `/products/${id}`;
        },
        onSuccess: function() {
            table.ajax.reload(null, false);
        }
    });
});
</script>
@endpush
@endsection
```

### Controller

```php
<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index()
    {
        return view('products.index');
    }
    
    public function datatable()
    {
        $products = Product::query();
        
        return DataTables::of($products)
            ->addIndexColumn()
            ->addColumn('action', function($row) {
                $btn = '<button onclick="editProduct('.$row->id.')" class="btn-edit">Edit</button>';
                $btn .= '<button onclick="erpDeleteRecord('.$row->id.', \''.$row->name.'\')" class="btn-delete">Delete</button>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);
        
        Product::create($validated);
        
        return response()->json([
            'success' => true,
            'message' => 'Product created successfully'
        ]);
    }
    
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        
        return response()->json([
            'success' => true,
            'product' => $product
        ]);
    }
    
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);
        
        $product = Product::findOrFail($id);
        $product->update($validated);
        
        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully'
        ]);
    }
    
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully'
        ]);
    }
}
```

---

## 🎯 الصفحات المطبقة حالياً

✅ **HR Module:**
- Employees (كامل)
- Departments (كامل)
- Positions (جزئي)

✅ **Warehouse Module:**
- Categories (جزئي)
- Materials (جزئي)
- Purchase Orders (جزئي)
- Sale Orders (جزئي)

✅ **Other Modules:**
- Projects (جزئي)
- Tasks (جزئي)
- Documents (جزئي)
- Approval System (جزئي)

---

## 📝 خطة التطبيق الكامل

### المرحلة 1: إكمال HR Module
- [ ] Positions
- [ ] Shifts
- [ ] Attendance
- [ ] Payroll
- [ ] Recruitment

### المرحلة 2: إكمال Warehouse Module
- [ ] Warehouses
- [ ] Inventory
- [ ] Delivery Orders

### المرحلة 3: إكمال باقي الوحدات
- [ ] Accounting
- [ ] Manufacturing
- [ ] Electronic Mail

---

## 💡 نصائح وأفضل الممارسات

### 1. استخدم IDs فريدة
```javascript
// ✅ جيد
#employees-table
#create-employee-form
#edit-employee-modal

// ❌ سيء
#table
#form
#modal
```

### 2. احتفظ بالـ table instance
```javascript
// ✅ جيد
const table = window.erpCrud.initDataTable({...});

// استخدمه لاحقاً
table.ajax.reload();
```

### 3. استخدم onSuccess للإجراءات الإضافية
```javascript
onSuccess: function(data) {
    table.ajax.reload(null, false);
    updateStatistics();
    refreshChart();
}
```

### 4. تحقق من وجود النظام
```javascript
if (window.erpCrud && window.erpCrud.initDataTable) {
    // استخدم النظام
} else {
    console.error('erpCrud not available');
}
```

---

## 🚀 الخطوات التالية

1. ✅ قراءة هذا الدليل بالكامل
2. ✅ فحص الأمثلة الموجودة (Employees, Departments)
3. ✅ تطبيق النظام على صفحة واحدة كتجربة
4. ✅ تطبيق النظام على باقي الصفحات تدريجياً
5. ✅ اختبار شامل لجميع العمليات

---

**تم إنشاء هذا الدليل في:** {{ date('Y-m-d') }}  
**الإصدار:** 1.0.0  
**المشروع:** Smart ERP System

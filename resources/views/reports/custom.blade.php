@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>{{ __('menu.custom_reports') }} - {{ config('app.name') }}</title>
@endsection

@section('subcontent')
@include('components.global-notifications')

<div class="intro-y mt-6 mb-2 flex flex-col gap-1">
    <div class="flex items-baseline justify-between gap-6">
        <h2 class="flex items-center gap-2 text-2xl md:text-3xl font-semibold text-royalDark tracking-wide">
            <x-base.lucide icon="file-plus" class="w-7 h-7" />
            <span>{{ __('menu.custom_reports') }}</span>
        </h2>
        <a href="{{ route('reports.index') }}" class="btn-royal btn-royal--outline btn-royal--sm">
            <x-base.lucide icon="arrow-left" class="w-4 h-4" /> العودة
        </a>
    </div>
    <p class="text-slate-500 mt-1">أنشئ تقريرك المخصص باختيار الوحدة والفترة الزمنية</p>
</div>

{{-- Report Builder --}}
<div class="mt-5 grid grid-cols-12 gap-6">
    {{-- Configuration Panel --}}
    <div class="intro-y col-span-12 lg:col-span-4">
        <div class="box p-5">
            <h4 class="font-semibold text-slate-700 mb-4">إعدادات التقرير</h4>
            
            <form id="report-form" class="space-y-4">
                {{-- Module Selection --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">اختر الوحدة</label>
                    <select id="module" name="module" class="form-select w-full" required>
                        <option value="">-- اختر --</option>
                        <optgroup label="المالية">
                            <option value="invoices">الفواتير</option>
                            <option value="payments">سندات الصرف</option>
                            <option value="receipts">سندات القبض</option>
                        </optgroup>
                        <optgroup label="الموارد البشرية">
                            <option value="employees">الموظفين</option>
                            <option value="payroll">الرواتب</option>
                            <option value="attendance">الحضور</option>
                            <option value="leave">الإجازات</option>
                        </optgroup>
                        <optgroup label="المخزون">
                            <option value="materials">المواد</option>
                            <option value="purchase_orders">أوامر الشراء</option>
                            <option value="sale_orders">أوامر البيع</option>
                        </optgroup>
                        <optgroup label="العملاء والموردين">
                            <option value="customers">العملاء</option>
                            <option value="vendors">الموردين</option>
                        </optgroup>
                        <optgroup label="المشاريع">
                            <option value="projects">المشاريع</option>
                            <option value="tasks">المهام</option>
                        </optgroup>
                    </select>
                </div>

                {{-- Date Range --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">من تاريخ</label>
                        <input type="date" id="start_date" name="start_date" class="form-control w-full" 
                               value="{{ now()->startOfMonth()->format('Y-m-d') }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">إلى تاريخ</label>
                        <input type="date" id="end_date" name="end_date" class="form-control w-full"
                               value="{{ now()->endOfMonth()->format('Y-m-d') }}">
                    </div>
                </div>

                {{-- Quick Date Presets --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">فترات سريعة</label>
                    <div class="flex flex-wrap gap-2">
                        <button type="button" onclick="setDateRange('today')" class="px-3 py-1 bg-slate-100 hover:bg-slate-200 rounded text-sm">اليوم</button>
                        <button type="button" onclick="setDateRange('week')" class="px-3 py-1 bg-slate-100 hover:bg-slate-200 rounded text-sm">هذا الأسبوع</button>
                        <button type="button" onclick="setDateRange('month')" class="px-3 py-1 bg-slate-100 hover:bg-slate-200 rounded text-sm">هذا الشهر</button>
                        <button type="button" onclick="setDateRange('quarter')" class="px-3 py-1 bg-slate-100 hover:bg-slate-200 rounded text-sm">هذا الربع</button>
                        <button type="button" onclick="setDateRange('year')" class="px-3 py-1 bg-slate-100 hover:bg-slate-200 rounded text-sm">هذه السنة</button>
                    </div>
                </div>

                {{-- Generate Button --}}
                <div class="pt-4 border-t">
                    <button type="submit" class="btn-royal btn-royal--gold w-full">
                        <x-base.lucide icon="play" class="w-4 h-4" /> إنشاء التقرير
                    </button>
                </div>
            </form>
        </div>

        {{-- Export Options --}}
        <div class="box p-5 mt-5">
            <h4 class="font-semibold text-slate-700 mb-4">خيارات التصدير</h4>
            <div class="space-y-2">
                <button type="button" onclick="exportReport('csv')" class="btn-royal btn-royal--outline w-full" disabled id="export-csv">
                    <x-base.lucide icon="file-spreadsheet" class="w-4 h-4" /> تصدير CSV
                </button>
                <button type="button" onclick="exportReport('excel')" class="btn-royal btn-royal--outline w-full" disabled id="export-excel">
                    <x-base.lucide icon="table" class="w-4 h-4" /> تصدير Excel
                </button>
                <button type="button" onclick="window.print()" class="btn-royal btn-royal--outline w-full" disabled id="export-print">
                    <x-base.lucide icon="printer" class="w-4 h-4" /> طباعة
                </button>
            </div>
        </div>
    </div>

    {{-- Results Panel --}}
    <div class="intro-y col-span-12 lg:col-span-8">
        <div class="box p-5">
            <div id="report-placeholder" class="text-center py-16">
                <x-base.lucide icon="file-search" class="w-16 h-16 mx-auto text-slate-300 mb-4" />
                <h4 class="text-lg font-semibold text-slate-500">اختر الوحدة وحدد الفترة الزمنية</h4>
                <p class="text-slate-400 mt-2">ثم اضغط على "إنشاء التقرير" لعرض البيانات</p>
            </div>

            <div id="report-loading" class="text-center py-16 hidden">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary mx-auto mb-4"></div>
                <p class="text-slate-500">جاري تحميل البيانات...</p>
            </div>

            <div id="report-results" class="hidden">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="font-semibold text-slate-700">
                        <span id="report-title">نتائج التقرير</span>
                        <span id="report-count" class="text-sm font-normal text-slate-500 ml-2"></span>
                    </h4>
                </div>
                
                <div class="overflow-x-auto">
                    <table id="report-table" class="w-full text-sm">
                        <thead id="report-thead" class="bg-slate-50">
                        </thead>
                        <tbody id="report-tbody">
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="report-error" class="text-center py-16 hidden">
                <x-base.lucide icon="alert-circle" class="w-16 h-16 mx-auto text-rose-300 mb-4" />
                <h4 class="text-lg font-semibold text-rose-500">حدث خطأ</h4>
                <p class="text-slate-400 mt-2" id="error-message">لم نتمكن من تحميل البيانات</p>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
const moduleColumns = {
    invoices: ['invoice_number', 'customer.name', 'invoice_date', 'total', 'status'],
    payments: ['voucher_number', 'voucher_date', 'total_amount', 'description'],
    receipts: ['voucher_number', 'voucher_date', 'total_amount', 'description'],
    employees: ['employee_number', 'full_name', 'department.name', 'position.name', 'hire_date'],
    payroll: ['employee.full_name', 'pay_date', 'basic_salary', 'net_salary', 'status'],
    attendance: ['employee.full_name', 'date', 'check_in', 'check_out', 'status'],
    leave: ['employee.full_name', 'type', 'start_date', 'end_date', 'status'],
    materials: ['code', 'name', 'category.name', 'quantity', 'unit_price'],
    purchase_orders: ['order_number', 'vendor.name', 'order_date', 'total_amount', 'status'],
    sale_orders: ['order_number', 'customer.name', 'order_date', 'total_amount', 'status'],
    customers: ['name', 'email', 'phone', 'created_at'],
    vendors: ['name', 'email', 'phone', 'created_at'],
    projects: ['name', 'manager.name', 'start_date', 'end_date', 'status'],
    tasks: ['title', 'project.name', 'employee.full_name', 'due_date', 'status']
};

const moduleLabels = {
    invoices: { invoice_number: 'رقم الفاتورة', 'customer.name': 'العميل', invoice_date: 'التاريخ', total: 'المبلغ', status: 'الحالة' },
    payments: { voucher_number: 'رقم السند', voucher_date: 'التاريخ', total_amount: 'المبلغ', description: 'الوصف' },
    receipts: { voucher_number: 'رقم السند', voucher_date: 'التاريخ', total_amount: 'المبلغ', description: 'الوصف' },
    employees: { employee_number: 'الرقم الوظيفي', full_name: 'الاسم', 'department.name': 'القسم', 'position.name': 'المنصب', hire_date: 'تاريخ التعيين' },
    payroll: { 'employee.full_name': 'الموظف', pay_date: 'تاريخ الدفع', basic_salary: 'الراتب الأساسي', net_salary: 'صافي الراتب', status: 'الحالة' },
    attendance: { 'employee.full_name': 'الموظف', date: 'التاريخ', check_in: 'الدخول', check_out: 'الخروج', status: 'الحالة' },
    leave: { 'employee.full_name': 'الموظف', type: 'النوع', start_date: 'من', end_date: 'إلى', status: 'الحالة' },
    materials: { code: 'الكود', name: 'الاسم', 'category.name': 'الفئة', quantity: 'الكمية', unit_price: 'السعر' },
    purchase_orders: { order_number: 'رقم الطلب', 'vendor.name': 'المورد', order_date: 'التاريخ', total_amount: 'المبلغ', status: 'الحالة' },
    sale_orders: { order_number: 'رقم الطلب', 'customer.name': 'العميل', order_date: 'التاريخ', total_amount: 'المبلغ', status: 'الحالة' },
    customers: { name: 'الاسم', email: 'البريد', phone: 'الهاتف', created_at: 'تاريخ الإنشاء' },
    vendors: { name: 'الاسم', email: 'البريد', phone: 'الهاتف', created_at: 'تاريخ الإنشاء' },
    projects: { name: 'المشروع', 'manager.name': 'المدير', start_date: 'البداية', end_date: 'النهاية', status: 'الحالة' },
    tasks: { title: 'المهمة', 'project.name': 'المشروع', 'employee.full_name': 'المسؤول', due_date: 'الاستحقاق', status: 'الحالة' }
};

const moduleTitles = {
    invoices: 'تقرير الفواتير',
    payments: 'تقرير سندات الصرف',
    receipts: 'تقرير سندات القبض',
    employees: 'تقرير الموظفين',
    payroll: 'تقرير الرواتب',
    attendance: 'تقرير الحضور',
    leave: 'تقرير الإجازات',
    materials: 'تقرير المواد',
    purchase_orders: 'تقرير أوامر الشراء',
    sale_orders: 'تقرير أوامر البيع',
    customers: 'تقرير العملاء',
    vendors: 'تقرير الموردين',
    projects: 'تقرير المشاريع',
    tasks: 'تقرير المهام'
};

let currentData = [];
let currentModule = '';

document.getElementById('report-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const module = document.getElementById('module').value;
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    
    if (!module) {
        alert('الرجاء اختيار الوحدة');
        return;
    }
    
    currentModule = module;
    showLoading();
    
    try {
        const response = await fetch('{{ route("reports.custom.generate") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                module: module,
                start_date: startDate,
                end_date: endDate,
                format: 'view'
            })
        });
        
        const result = await response.json();
        
        if (result.success) {
            currentData = result.data;
            renderTable(module, result.data);
            enableExportButtons();
        } else {
            showError(result.message || 'حدث خطأ أثناء تحميل البيانات');
        }
    } catch (error) {
        console.error('Error:', error);
        showError('حدث خطأ في الاتصال بالخادم');
    }
});

function renderTable(module, data) {
    const columns = moduleColumns[module] || [];
    const labels = moduleLabels[module] || {};
    const title = moduleTitles[module] || 'التقرير';
    
    // Set title
    document.getElementById('report-title').textContent = title;
    document.getElementById('report-count').textContent = `(${data.length} سجل)`;
    
    // Build header
    const thead = document.getElementById('report-thead');
    thead.innerHTML = '<tr>' + columns.map(col => 
        `<th class="px-4 py-2 text-right font-medium text-slate-600">${labels[col] || col}</th>`
    ).join('') + '</tr>';
    
    // Build body
    const tbody = document.getElementById('report-tbody');
    tbody.innerHTML = data.map(row => 
        '<tr class="border-b border-slate-100">' + columns.map(col => {
            let value = getNestedValue(row, col);
            if (value === null || value === undefined) value = '-';
            if (typeof value === 'number') value = value.toLocaleString();
            return `<td class="px-4 py-3">${value}</td>`;
        }).join('') + '</tr>'
    ).join('');
    
    showResults();
}

function getNestedValue(obj, path) {
    return path.split('.').reduce((current, key) => current && current[key], obj);
}

function showLoading() {
    document.getElementById('report-placeholder').classList.add('hidden');
    document.getElementById('report-results').classList.add('hidden');
    document.getElementById('report-error').classList.add('hidden');
    document.getElementById('report-loading').classList.remove('hidden');
}

function showResults() {
    document.getElementById('report-placeholder').classList.add('hidden');
    document.getElementById('report-loading').classList.add('hidden');
    document.getElementById('report-error').classList.add('hidden');
    document.getElementById('report-results').classList.remove('hidden');
}

function showError(message) {
    document.getElementById('report-placeholder').classList.add('hidden');
    document.getElementById('report-loading').classList.add('hidden');
    document.getElementById('report-results').classList.add('hidden');
    document.getElementById('report-error').classList.remove('hidden');
    document.getElementById('error-message').textContent = message;
}

function enableExportButtons() {
    document.getElementById('export-csv').disabled = false;
    document.getElementById('export-excel').disabled = false;
    document.getElementById('export-print').disabled = false;
}

function setDateRange(preset) {
    const today = new Date();
    let startDate, endDate;
    
    switch(preset) {
        case 'today':
            startDate = endDate = today;
            break;
        case 'week':
            startDate = new Date(today.setDate(today.getDate() - today.getDay()));
            endDate = new Date();
            break;
        case 'month':
            startDate = new Date(today.getFullYear(), today.getMonth(), 1);
            endDate = new Date(today.getFullYear(), today.getMonth() + 1, 0);
            break;
        case 'quarter':
            const quarter = Math.floor(today.getMonth() / 3);
            startDate = new Date(today.getFullYear(), quarter * 3, 1);
            endDate = new Date(today.getFullYear(), quarter * 3 + 3, 0);
            break;
        case 'year':
            startDate = new Date(today.getFullYear(), 0, 1);
            endDate = new Date(today.getFullYear(), 11, 31);
            break;
    }
    
    document.getElementById('start_date').value = formatDate(startDate);
    document.getElementById('end_date').value = formatDate(endDate);
}

function formatDate(date) {
    return date.toISOString().split('T')[0];
}

function exportReport(format) {
    if (!currentModule || currentData.length === 0) {
        alert('لا توجد بيانات للتصدير');
        return;
    }
    
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    
    window.location.href = `{{ route("reports.custom.generate") }}?module=${currentModule}&start_date=${startDate}&end_date=${endDate}&format=${format}`;
}
</script>
@endpush

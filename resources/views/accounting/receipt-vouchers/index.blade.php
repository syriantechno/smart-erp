@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>سندات القبض - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@push('styles')
<style>
    #receipt-vouchers-table { font-size: 0.95rem; line-height: 1.4; }
    #receipt-vouchers-table tbody tr { height: 2.25rem; }
    #receipt-vouchers-table th { font-size: 0.8rem; font-weight: 700; padding: 0.5rem 1.25rem; }
    #receipt-vouchers-table td { padding: 0.375rem 1.25rem; }
    .icon-hover-rise { transition: transform 200ms ease; }
    .group:hover .icon-hover-rise { transform: translateY(-2px); }
</style>
@endpush

@section('subcontent')
@include('components.global-notifications')

{{-- Header with Stats --}}
<div class="intro-y mt-6 mb-2 flex flex-col gap-1">
    <div class="flex items-baseline justify-between gap-6">
        <h2 class="flex items-center gap-2 text-2xl md:text-3xl font-semibold text-royalDark tracking-wide">
            <x-base.lucide icon="banknote" class="w-7 h-7" />
            <span>سندات القبض</span>
        </h2>

        <div class="flex flex-row items-end gap-8 md:gap-12 justify-end">
            {{-- Draft --}}
            <div class="flex flex-col items-center gap-1">
                <div class="flex items-baseline gap-2">
                    <div class="inline-flex items-center justify-center rounded-full bg-amber-100 px-1.5 py-1">
                        <x-base.lucide icon="clock" class="w-4 h-4 text-amber-600" />
                    </div>
                    <div class="text-5xl md:text-6xl font-semibold tracking-tight text-amber-600">
                        {{ $vouchers->where('status', 'draft')->count() }}
                    </div>
                </div>
                <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">مسودة</div>
            </div>
            {{-- Approved --}}
            <div class="flex flex-col items-center gap-1">
                <div class="flex items-baseline gap-2">
                    <div class="inline-flex items-center justify-center rounded-full bg-emerald-100 px-1.5 py-1">
                        <x-base.lucide icon="check-circle" class="w-4 h-4 text-emerald-600" />
                    </div>
                    <div class="text-5xl md:text-6xl font-semibold tracking-tight text-emerald-600">
                        {{ $vouchers->where('status', 'approved')->count() }}
                    </div>
                </div>
                <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">معتمد</div>
            </div>
            {{-- Total --}}
            <div class="flex flex-col items-center gap-1">
                <div class="flex items-baseline gap-2">
                    <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                        <x-base.lucide icon="file-text" class="w-4 h-4" />
                    </div>
                    <div class="text-5xl md:text-6xl font-semibold tracking-tight" style="color: #303030" id="stat-total">
                        {{ $vouchers->count() }}
                    </div>
                </div>
                <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">الإجمالي</div>
            </div>
            {{-- Amount --}}
            <div class="flex flex-col items-center gap-1">
                <div class="flex items-baseline gap-2">
                    <div class="inline-flex items-center justify-center rounded-full bg-emerald-100 px-1.5 py-1">
                        <x-base.lucide icon="wallet" class="w-4 h-4 text-emerald-600" />
                    </div>
                    <div class="text-4xl md:text-5xl font-semibold tracking-tight text-emerald-600" id="stat-amount">
                        {{ function_exists('format_currency') ? format_currency($vouchers->sum('total_amount')) : number_format($vouchers->sum('total_amount'), 2) }}
                    </div>
                </div>
                <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">المبلغ</div>
            </div>
        </div>
    </div>
</div>

<div class="mt-5 grid grid-cols-12 gap-6">
    <div class="intro-y col-span-12">
        <x-base.preview-component class="intro-y box bg-white/80 border border-slate-200/70 shadow-[0_18px_45px_rgba(15,23,42,0.10)]">
            <div class="p-5">
                {{-- Filters & Actions Toolbar --}}
                <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                    <form id="vouchers-filter-form" class="w-full sm:mr-auto xl:flex">
                        <div class="items-center sm:mr-4 sm:flex">
                            <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial text-slate-500">الحقل</label>
                            <x-base.form-select id="filter-field" class="mt-2 w-full sm:mt-0 sm:w-auto 2xl:w-full">
                                <option value="all">الكل</option>
                                <option value="number">رقم السند</option>
                                <option value="company">الشركة</option>
                                <option value="account">الحساب</option>
                            </x-base.form-select>
                        </div>
                        <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                            <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial text-slate-500">النوع</label>
                            <x-base.form-select id="filter-type" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                <option value="contains">يحتوي</option>
                                <option value="equals">يساوي</option>
                            </x-base.form-select>
                        </div>
                        <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                            <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial text-slate-500">القيمة</label>
                            <x-base.form-input id="filter-value" type="text" placeholder="بحث..." class="mt-2 w-full sm:mt-0 sm:w-48 2xl:w-full" />
                        </div>
                        <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                            <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial text-slate-500">الحالة</label>
                            <x-base.form-select id="filter-status" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                <option value="">الكل</option>
                                <option value="draft">مسودة</option>
                                <option value="posted">مرحّل</option>
                                <option value="approved">معتمد</option>
                            </x-base.form-select>
                        </div>
                        <div class="mt-4 flex flex-wrap gap-2 sm:items-center xl:mt-0">
                            <x-base.tippy content="تطبيق الفلتر" placement="top">
                                <button id="filter-go" type="button" class="btn-royal btn-royal--dark btn-royal--sm w-full sm:w-24 group">
                                    <x-base.lucide icon="search" class="w-4 h-4 icon-hover-rise" />
                                    بحث
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="إعادة تعيين" placement="top">
                                <button id="filter-reset" type="button" class="btn-royal btn-royal--outline btn-royal--sm w-full sm:w-24 group">
                                    <x-base.lucide icon="rotate-ccw" class="w-4 h-4 icon-hover-rise" />
                                    إعادة
                                </button>
                            </x-base.tippy>
                        </div>
                    </form>

                    <div class="mt-5 flex flex-wrap items-center gap-2 sm:mt-0 sm:flex-nowrap">
                        <x-base.tippy content="طباعة" placement="bottom">
                            <button type="button" class="btn-royal btn-royal--outline btn-royal--sm group text-royalDark">
                                <x-base.lucide icon="printer" class="w-5 h-5 icon-hover-rise" />
                            </button>
                        </x-base.tippy>
                        <x-base.tippy content="تصدير Excel" placement="bottom">
                            <button id="export-excel" type="button" class="btn-royal btn-royal--outline btn-royal--sm group text-royalDark">
                                <x-base.lucide icon="file-spreadsheet" class="w-5 h-5 icon-hover-rise" />
                            </button>
                        </x-base.tippy>
                        <x-base.tippy content="تحديث" placement="bottom">
                            <button id="refresh-table" type="button" class="btn-royal btn-royal--outline btn-royal--sm group text-royalDark" onclick="location.reload()">
                                <x-base.lucide icon="refresh-cw" class="w-5 h-5 icon-hover-rise" />
                            </button>
                        </x-base.tippy>
                        {{-- Add Button --}}
                        <x-base.tippy content="إضافة سند قبض جديد" placement="bottom">
                            <button type="button" class="btn-royal btn-royal--gold btn-royal--sm sm:btn-royal--lg group" data-tw-toggle="modal" data-tw-target="#create-receipt-voucher-modal">
                                <x-base.lucide icon="plus-circle" class="w-5 h-5 icon-hover-rise" />
                                <span class="hidden sm:inline">إضافة</span>
                            </button>
                        </x-base.tippy>
                    </div>
                </div>

                <div class="overflow-x-auto sm:overflow-visible mt-5" data-erp-table-wrapper>
                    <table id="receipt-vouchers-table" data-tw-merge data-erp-table class="w-full min-w-full table-auto text-left text-sm">
                        <thead>
                            <tr>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">رقم السند</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">التاريخ</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">الشركة</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">الطريقة</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">الحساب</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-right">المبلغ</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">الحالة</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($vouchers as $v)
                            <tr class="intro-x">
                                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300 font-medium">
                                    RV-{{ str_pad($v->id, 5, '0', STR_PAD_LEFT) }}
                                </td>
                                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300">
                                    {{ $v->voucher_date?->format('Y-m-d') }}
                                </td>
                                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300">
                                    {{ $v->company->name ?? '-' }}
                                </td>
                                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300">
                                    <span class="inline-flex items-center gap-1 text-sm">
                                        @if($v->method === 'cash')
                                            <x-base.lucide icon="wallet" class="w-4 h-4 text-emerald-600" />
                                            <span>نقدي</span>
                                        @else
                                            <x-base.lucide icon="building-2" class="w-4 h-4 text-blue-600" />
                                            <span>بنكي</span>
                                        @endif
                                    </span>
                                </td>
                                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300">
                                    {{ $v->account?->name ?? '-' }}
                                </td>
                                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300 text-right font-semibold text-emerald-600">
                                    {{ function_exists('format_currency') ? format_currency($v->total_amount) : number_format($v->total_amount, 2) }}
                                </td>
                                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300 text-center">
                                    @if($v->status === 'posted')
                                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-emerald-100 text-emerald-600 rounded text-xs font-semibold">
                                            <x-base.lucide icon="check-circle" class="w-3 h-3" /> مرحّل
                                        </span>
                                    @elseif($v->status === 'draft')
                                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-amber-100 text-amber-600 rounded text-xs font-semibold">
                                            <x-base.lucide icon="clock" class="w-3 h-3" /> مسودة
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-slate-100 text-slate-600 rounded text-xs font-semibold">
                                            {{ $v->status }}
                                        </span>
                                    @endif
                                </td>
                                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300 text-center">
                                    <div class="flex justify-center gap-1">
                                        <button class="p-1.5 rounded hover:bg-blue-50 text-blue-600 hover:text-blue-800 transition-colors" title="عرض">
                                            <x-base.lucide icon="eye" class="w-4 h-4" />
                                        </button>
                                        <button class="p-1.5 rounded hover:bg-emerald-50 text-emerald-600 hover:text-emerald-800 transition-colors" title="طباعة">
                                            <x-base.lucide icon="printer" class="w-4 h-4" />
                                        </button>
                                        <button class="btn-delete p-1.5 rounded hover:bg-red-50 text-slate-500 hover:text-red-600 transition-colors" 
                                                data-id="{{ $v->id }}" 
                                                data-name="RV-{{ str_pad($v->id, 5, '0', STR_PAD_LEFT) }}" 
                                                title="حذف">
                                            <x-base.lucide icon="trash-2" class="w-4 h-4" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-5 py-8 text-center text-slate-400">
                                    <x-base.lucide icon="inbox" class="w-12 h-12 mx-auto mb-2 opacity-50" />
                                    لا توجد سندات قبض
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </x-base.preview-component>
    </div>
</div>

{{-- Create Receipt Voucher Modal (Unified Theme) --}}
<x-modal.form id="create-receipt-voucher-modal" title="إنشاء سند قبض جديد">
    <form id="receipt-voucher-form" action="{{ route('accounting.receipt-vouchers.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-12 gap-4 gap-y-4">
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="company_id">الشركة <span class="text-danger">*</span></x-base.form-label>
                <x-base.form-select id="company_id" name="company_id" class="w-full" required>
                    <option value="">اختر الشركة</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                    @endforeach
                </x-base.form-select>
            </div>
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="voucher_date">التاريخ <span class="text-danger">*</span></x-base.form-label>
                <x-base.form-input id="voucher_date" name="voucher_date" type="date" value="{{ now()->toDateString() }}" class="w-full" required />
            </div>

            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="method">طريقة القبض <span class="text-danger">*</span></x-base.form-label>
                <x-base.form-select id="method" name="method" class="w-full" required>
                    <option value="cash">نقدي</option>
                    <option value="bank">بنكي</option>
                </x-base.form-select>
            </div>
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="tax_id">الضريبة</x-base.form-label>
                <x-base.form-select id="tax_id" name="tax_id" class="w-full">
                    <option value="">بدون ضريبة</option>
                    @foreach($taxes as $tax)
                        <option value="{{ $tax->id }}" data-rate="{{ $tax->rate }}">
                            {{ $tax->name }} ({{ number_format($tax->rate, 2) }}%)
                        </option>
                    @endforeach
                </x-base.form-select>
            </div>

            <div class="col-span-12 md:col-span-6" id="cash-box-wrapper">
                <x-base.form-label for="cash_box_id">الصندوق النقدي</x-base.form-label>
                <x-base.form-select id="cash_box_id" name="cash_box_id" class="w-full">
                    <option value="">اختر الصندوق</option>
                    @foreach($cashBoxes as $box)
                        <option value="{{ $box->id }}">{{ $box->name }}</option>
                    @endforeach
                </x-base.form-select>
            </div>

            <div class="col-span-12 md:col-span-6 hidden" id="bank-account-wrapper">
                <x-base.form-label for="bank_account_id">الحساب البنكي</x-base.form-label>
                <x-base.form-select id="bank_account_id" name="bank_account_id" class="w-full">
                    <option value="">اختر الحساب</option>
                    @foreach($bankAccounts as $acc)
                        <option value="{{ $acc->id }}">{{ $acc->name }}</option>
                    @endforeach
                </x-base.form-select>
            </div>

            <div class="col-span-12">
                <x-base.form-label for="account_id">الحساب المقابل <span class="text-danger">*</span></x-base.form-label>
                <x-base.form-select id="account_id" name="account_id" class="w-full" required>
                    <option value="">اختر الحساب</option>
                    @foreach($accounts as $account)
                        <option value="{{ $account->id }}">{{ $account->code }} - {{ $account->name }}</option>
                    @endforeach
                </x-base.form-select>
            </div>

            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="amount">المبلغ <span class="text-danger">*</span></x-base.form-label>
                <x-base.form-input id="amount" name="amount" type="number" min="0" step="0.01" value="0" class="w-full" lang="en" dir="ltr" inputmode="decimal" required />
            </div>
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="reference">المرجع</x-base.form-label>
                <x-base.form-input id="reference" name="reference" type="text" placeholder="رقم الفاتورة أو المرجع" class="w-full" />
            </div>

            <div class="col-span-12">
                <x-base.form-label for="description">الوصف</x-base.form-label>
                <x-base.form-textarea id="description" name="description" rows="2" placeholder="وصف السند..." class="w-full"></x-base.form-textarea>
            </div>

            {{-- Amount Summary --}}
            <div class="col-span-12">
                <div class="p-4 bg-slate-50 rounded-lg border border-slate-200">
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div>
                            <div class="text-xs text-slate-500 uppercase tracking-wider mb-1">المبلغ</div>
                            <div class="text-lg font-semibold" id="display-amount">0.00</div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-500 uppercase tracking-wider mb-1">الضريبة</div>
                            <div class="text-lg font-semibold text-amber-600" id="display-tax">0.00</div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-500 uppercase tracking-wider mb-1">الإجمالي</div>
                            <div class="text-xl font-bold text-emerald-600" id="display-total">0.00</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @slot('footer')
        <div class="flex w-full flex-wrap justify-end gap-2">
            <button type="button" class="btn-royal btn-royal--outline group" data-tw-dismiss="modal">
                <x-base.lucide icon="x-circle" class="w-5 h-5 icon-hover-rise" />
                إلغاء
            </button>
            <button type="button" id="save-voucher-btn" class="btn-royal btn-royal--gold group">
                <x-base.lucide icon="save" class="w-5 h-5 icon-hover-rise" />
                حفظ
            </button>
        </div>
    @endslot
</x-modal.form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const methodSelect = document.getElementById('method');
    const cashWrapper = document.getElementById('cash-box-wrapper');
    const bankWrapper = document.getElementById('bank-account-wrapper');
    const amountInput = document.getElementById('amount');
    const taxSelect = document.getElementById('tax_id');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const form = document.getElementById('receipt-voucher-form');
    const saveBtn = document.getElementById('save-voucher-btn');
    const tableBody = document.querySelector('#receipt-vouchers-table tbody');

    // Method visibility toggle
    function updateMethodVisibility() {
        const method = methodSelect.value;
        if (method === 'cash') {
            cashWrapper.classList.remove('hidden');
            bankWrapper.classList.add('hidden');
        } else {
            cashWrapper.classList.add('hidden');
            bankWrapper.classList.remove('hidden');
        }
    }

    if (methodSelect) {
        methodSelect.addEventListener('change', updateMethodVisibility);
        updateMethodVisibility();
    }

    // Calculate totals
    function calculateTotals() {
        const amount = parseFloat(amountInput.value) || 0;
        const selectedTax = taxSelect.options[taxSelect.selectedIndex];
        const taxRate = selectedTax ? parseFloat(selectedTax.dataset.rate) || 0 : 0;
        const taxAmount = amount * (taxRate / 100);
        const total = amount + taxAmount;

        document.getElementById('display-amount').textContent = amount.toFixed(2);
        document.getElementById('display-tax').textContent = taxAmount.toFixed(2);
        document.getElementById('display-total').textContent = total.toFixed(2);
    }

    if (amountInput) {
        amountInput.addEventListener('input', calculateTotals);
    }
    if (taxSelect) {
        taxSelect.addEventListener('change', calculateTotals);
    }
    calculateTotals();

    // Save voucher via AJAX
    if (saveBtn) {
        saveBtn.addEventListener('click', function() {
            const formData = new FormData(form);
            
            saveBtn.disabled = true;
            saveBtn.innerHTML = '<span class="animate-spin inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full mr-2"></span> جاري الحفظ...';
            
            fetch('{{ route("accounting.receipt-vouchers.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (typeof window.showSuccess === 'function') {
                        window.showSuccess(data.message);
                    }
                    
                    const v = data.voucher;
                    const newRow = `
                        <tr class="intro-x">
                            <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300 font-medium">${v.number}</td>
                            <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300">${v.voucher_date}</td>
                            <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300">${v.company_name}</td>
                            <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300">
                                <span class="inline-flex items-center gap-1 text-sm">
                                    ${v.method === 'cash' ? '<i data-lucide="wallet" class="w-4 h-4 text-emerald-600"></i><span>نقدي</span>' : '<i data-lucide="building-2" class="w-4 h-4 text-blue-600"></i><span>بنكي</span>'}
                                </span>
                            </td>
                            <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300">${v.account_name}</td>
                            <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300 text-right font-semibold text-emerald-600">${v.total_amount}</td>
                            <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300 text-center">
                                <span class="inline-flex items-center gap-1 px-2 py-1 bg-amber-100 text-amber-600 rounded text-xs font-semibold">
                                    <i data-lucide="clock" class="w-3 h-3"></i> مسودة
                                </span>
                            </td>
                            <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300 text-center">
                                <div class="flex justify-center gap-1">
                                    <button class="p-1.5 rounded hover:bg-blue-50 text-blue-600 hover:text-blue-800 transition-colors" title="عرض">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </button>
                                    <button class="p-1.5 rounded hover:bg-emerald-50 text-emerald-600 hover:text-emerald-800 transition-colors" title="طباعة">
                                        <i data-lucide="printer" class="w-4 h-4"></i>
                                    </button>
                                    <button class="btn-delete p-1.5 rounded hover:bg-red-50 text-slate-500 hover:text-red-600 transition-colors" data-id="${v.id}" data-name="${v.number}" title="حذف">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `;
                    
                    const emptyRow = tableBody.querySelector('td[colspan]');
                    if (emptyRow) {
                        emptyRow.closest('tr').remove();
                    }
                    
                    tableBody.insertAdjacentHTML('afterbegin', newRow);
                    
                    if (typeof lucide !== 'undefined') {
                        lucide.createIcons();
                    }
                    
                    const totalEl = document.getElementById('stat-total');
                    const amountEl = document.getElementById('stat-amount');
                    if (totalEl) {
                        totalEl.textContent = parseInt(totalEl.textContent) + 1;
                    }
                    if (amountEl) {
                        const currentAmount = parseFloat(amountEl.textContent.replace(/,/g, '')) || 0;
                        const newAmount = parseFloat(v.total_amount.replace(/,/g, '')) || 0;
                        amountEl.textContent = (currentAmount + newAmount).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    }
                    
                    form.reset();
                    document.getElementById('voucher_date').value = '{{ now()->toDateString() }}';
                    calculateTotals();
                    
                    const modal = tailwind.Modal.getOrCreateInstance(document.getElementById('create-receipt-voucher-modal'));
                    modal.hide();
                    
                    bindDeleteHandlers();
                } else {
                    if (typeof window.showError === 'function') {
                        window.showError(data.message || 'فشل في إنشاء السند');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (typeof window.showError === 'function') {
                    window.showError('حدث خطأ أثناء الحفظ');
                }
            })
            .finally(() => {
                saveBtn.disabled = false;
                saveBtn.innerHTML = '<i data-lucide="save" class="w-4 h-4"></i> حفظ السند';
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            });
        });
    }

    // Delete handlers
    function bindDeleteHandlers() {
        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.removeEventListener('click', handleDelete);
            btn.addEventListener('click', handleDelete);
        });
    }

    function handleDelete() {
        const id = this.dataset.id;
        const name = this.dataset.name;
        const row = this.closest('tr');

        if (typeof window.confirmDelete === 'function') {
            window.confirmDelete(name, () => {
                fetch(`/accounting/receipt-vouchers/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (typeof window.showSuccess === 'function') {
                            window.showSuccess(data.message || 'تم حذف السند بنجاح');
                        }
                        row.remove();
                        
                        const totalEl = document.getElementById('stat-total');
                        if (totalEl) {
                            totalEl.textContent = Math.max(0, parseInt(totalEl.textContent) - 1);
                        }
                    } else {
                        if (typeof window.showError === 'function') {
                            window.showError(data.message || 'فشل في حذف السند');
                        }
                    }
                })
                .catch(() => {
                    if (typeof window.showError === 'function') {
                        window.showError('حدث خطأ أثناء الحذف');
                    }
                });
            });
        }
    }

    bindDeleteHandlers();
});
</script>
@endpush

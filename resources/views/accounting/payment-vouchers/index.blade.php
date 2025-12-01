@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>{{ __('payment_vouchers.page_title') }} - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@push('styles')
<style>
    #payment-vouchers-table { font-size: 0.95rem; line-height: 1.4; }
    #payment-vouchers-table tbody tr { height: 2.25rem; }
    #payment-vouchers-table th { font-size: 0.8rem; font-weight: 700; padding: 0.5rem 1.25rem; }
    #payment-vouchers-table td { padding: 0.375rem 1.25rem; }
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
            <x-base.lucide icon="credit-card" class="w-7 h-7" />
            <span>{{ __('payment_vouchers.page_title') }}</span>
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
                <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">{{ __('payment_vouchers.stats.draft') }}</div>
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
                <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">{{ __('payment_vouchers.stats.approved') }}</div>
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
                <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">{{ __('payment_vouchers.stats.total') }}</div>
            </div>
            {{-- Amount --}}
            <div class="flex flex-col items-center gap-1">
                <div class="flex items-baseline gap-2">
                    <div class="inline-flex items-center justify-center rounded-full bg-rose-100 px-1.5 py-1">
                        <x-base.lucide icon="wallet" class="w-4 h-4 text-rose-600" />
                    </div>
                    <div class="text-4xl md:text-5xl font-semibold tracking-tight text-rose-600" id="stat-amount">
                        {{ function_exists('format_currency') ? format_currency($vouchers->sum('total_amount')) : number_format($vouchers->sum('total_amount'), 2) }}
                    </div>
                </div>
                <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">{{ __('payment_vouchers.stats.amount') }}</div>
            </div>
        </div>
    </div>
</div>

<div class="mt-5 grid grid-cols-12 gap-6">
    <div class="intro-y col-span-12">
        <x-base.preview-component class="intro-y box bg-white/80 border border-slate-200/70 shadow-[0_18px_45px_rgba(15,23,42,0.10)]">
            <div class="p-5">
                {{-- Filters & Actions Toolbar (match Positions layout) --}}
                <div class="flex flex-wrap items-center gap-2 mb-4 md:flex-nowrap">
                    <form id="vouchers-filter-form" class="flex flex-wrap items-center gap-2 w-full md:w-auto">
                        {{-- Search / Value Input --}}
                        <div class="relative min-w-[180px]">
                            <x-base.lucide icon="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" />
                            <x-base.form-input
                                id="filter-value"
                                type="text"
                                placeholder="بحث..."
                                class="pl-9 w-full text-sm py-1.5"
                            />
                        </div>

                        {{-- Field Filter --}}
                        <x-base.form-select id="filter-field" class="w-auto text-sm py-1.5">
                            <option value="all">{{ __('payment_vouchers.filters.all') }}</option>
                            <option value="number">{{ __('payment_vouchers.filters.number') }}</option>
                            <option value="company">{{ __('payment_vouchers.filters.company') }}</option>
                            <option value="account">{{ __('payment_vouchers.filters.account') }}</option>
                        </x-base.form-select>

                        {{-- Type Filter --}}
                        <x-base.form-select id="filter-type" class="w-auto text-sm py-1.5">
                            <option value="contains">{{ __('payment_vouchers.filters.contains') }}</option>
                            <option value="equals">{{ __('payment_vouchers.filters.equals') }}</option>
                        </x-base.form-select>

                        {{-- Status Filter --}}
                        <x-base.form-select id="filter-status" class="w-auto text-sm py-1.5">
                            <option value="">{{ __('payment_vouchers.filters.status_all') }}</option>
                            <option value="draft">{{ __('payment_vouchers.statuses.draft') }}</option>
                            <option value="posted">{{ __('payment_vouchers.statuses.posted') }}</option>
                            <option value="approved">{{ __('payment_vouchers.statuses.approved') }}</option>
                        </x-base.form-select>

                        {{-- Filter Buttons --}}
                        <div class="flex flex-wrap items-center gap-2">
                            <x-base.tippy content="تطبيق الفلتر" placement="top">
                                <button id="filter-go" type="button" class="btn-royal btn-royal--dark btn-royal--sm px-2 group">
                                    <x-base.lucide icon="search" class="w-4 h-4 icon-hover-rise" />
                                    {{ __('payment_vouchers.buttons.filter') }}
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="إعادة تعيين" placement="top">
                                <button id="filter-reset" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2 group">
                                    <x-base.lucide icon="rotate-ccw" class="w-4 h-4 icon-hover-rise" />
                                    {{ __('payment_vouchers.buttons.reset') }}
                                </button>
                            </x-base.tippy>
                        </div>
                    </form>

                    {{-- Spacer like Positions page --}}
                    <div class="flex-1 hidden md:block"></div>

                    {{-- Action Buttons (match Positions sizing) --}}
                    <div class="flex flex-wrap items-center gap-1 md:gap-1.5">
                        <x-base.tippy content="{{ __('payment_vouchers.buttons.print') }}" placement="bottom">
                            <button type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2 group">
                                <x-base.lucide icon="printer" class="w-5 h-5 icon-hover-rise" />
                            </button>
                        </x-base.tippy>
                        <x-base.tippy content="{{ __('payment_vouchers.buttons.export_excel') }}" placement="bottom">
                            <button id="export-excel" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2 group">
                                <x-base.lucide icon="file-spreadsheet" class="w-5 h-5 icon-hover-rise" />
                            </button>
                        </x-base.tippy>
                        <x-base.tippy content="{{ __('payment_vouchers.buttons.refresh') }}" placement="bottom">
                            <button id="refresh-table" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2 group">
                                <x-base.lucide icon="refresh-cw" class="w-5 h-5 icon-hover-rise" />
                            </button>
                        </x-base.tippy>
                        {{-- Add Button --}}
                        <x-base.tippy content="{{ __('payment_vouchers.buttons.create') }}" placement="bottom">
                            <button type="button" class="btn-royal btn-royal--gold btn-royal--sm px-2 group" data-tw-toggle="modal" data-tw-target="#create-payment-voucher-modal">
                                <x-base.lucide icon="plus-circle" class="w-5 h-5 icon-hover-rise" />
                                <span class="hidden sm:inline">{{ __('payment_vouchers.buttons.add') }}</span>
                            </button>
                        </x-base.tippy>
                    </div>
                </div>

                <div class="overflow-x-auto sm:overflow-visible mt-5" data-erp-table-wrapper>
                    <table id="payment-vouchers-table" data-tw-merge data-erp-table class="w-full min-w-full table-auto text-left text-sm">
                        <thead>
                            <tr>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">{{ __('payment_vouchers.table.number') }}</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">{{ __('payment_vouchers.table.date') }}</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">{{ __('payment_vouchers.table.company') }}</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">{{ __('payment_vouchers.table.method') }}</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">{{ __('payment_vouchers.table.account') }}</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-right">{{ __('payment_vouchers.table.amount') }}</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">{{ __('payment_vouchers.table.status') }}</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">{{ __('payment_vouchers.table.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </x-base.preview-component>
    </div>
</div>

{{-- Create Payment Voucher Modal (Unified Theme) --}}
<x-modal.form id="create-payment-voucher-modal" title="إنشاء سند صرف جديد">
    <form id="payment-voucher-form" action="{{ route('accounting.payment-vouchers.store') }}" method="POST">
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
                <x-base.form-label for="method">طريقة الدفع <span class="text-danger">*</span></x-base.form-label>
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
                            <div class="text-xl font-bold text-rose-600" id="display-total">0.00</div>
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

@include('components.datatable.scripts')

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const methodSelect = document.getElementById('method');
    const cashWrapper = document.getElementById('cash-box-wrapper');
    const bankWrapper = document.getElementById('bank-account-wrapper');
    const amountInput = document.getElementById('amount');
    const taxSelect = document.getElementById('tax_id');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const form = document.getElementById('payment-voucher-form');
    const saveBtn = document.getElementById('save-voucher-btn');
    const filterField = document.getElementById('filter-field');
    const filterType = document.getElementById('filter-type');
    const filterValue = document.getElementById('filter-value');
    const filterStatus = document.getElementById('filter-status');
    const filterGoBtn = document.getElementById('filter-go');
    const filterResetBtn = document.getElementById('filter-reset');
    const refreshBtn = document.getElementById('refresh-table');
    let searchTimeout = null;
    const table = window.erpCrud && window.erpCrud.initDataTable ? window.erpCrud.initDataTable({
        tableSelector: '#payment-vouchers-table',
        ajaxUrl: '{{ route("accounting.payment-vouchers.datatable") }}',
        ajaxData: function (d) {
            d.filter_field = filterField ? filterField.value : 'all';
            d.filter_type = filterType ? filterType.value : 'contains';
            d.filter_value = filterValue ? filterValue.value : '';
            d.filter_status = filterStatus ? filterStatus.value : '';
        },
        pageLength: 25,
        columns: [
            { data: 'number', name: 'number', className: 'px-5 py-3 border-b dark:border-darkmode-300 font-medium' },
            { data: 'voucher_date', name: 'voucher_date', className: 'px-5 py-3 border-b dark:border-darkmode-300' },
            { data: 'company_name', name: 'company_name', className: 'px-5 py-3 border-b dark:border-darkmode-300' },
            { data: 'method_label', name: 'method', className: 'px-5 py-3 border-b dark:border-darkmode-300' },
            { data: 'account_name', name: 'account_name', className: 'px-5 py-3 border-b dark:border-darkmode-300' },
            { data: 'amount_formatted', name: 'total_amount', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-right font-semibold text-rose-600' },
            { data: 'status_badge', name: 'status', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center' },
            { data: 'actions', name: 'actions', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center', orderable: false, searchable: false }
        ],
        drawCallback: function () {
            if (typeof window.Lucide !== 'undefined') {
                window.Lucide.createIcons();
            } else if (typeof lucide !== 'undefined' && typeof lucide.createIcons === 'function') {
                lucide.createIcons();
            }

            if (typeof bindDeleteHandlers === 'function') {
                bindDeleteHandlers();
            }
        }
    }) : null;

    if (table) {
        window.paymentVouchersTable = table;

        if (filterGoBtn) {
            filterGoBtn.addEventListener('click', function () {
                window.paymentVouchersTable.ajax.reload(null, false);
            });
        }

        if (filterResetBtn) {
            filterResetBtn.addEventListener('click', function () {
                if (filterField) filterField.value = 'all';
                if (filterType) filterType.value = 'contains';
                if (filterValue) filterValue.value = '';
                if (filterStatus) filterStatus.value = '';

                window.paymentVouchersTable.ajax.reload(null, false);
            });
        }

        // Debounced search similar to employees page
        if (filterValue) {
            filterValue.addEventListener('input', function () {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function () {
                    window.paymentVouchersTable.ajax.reload(null, false);
                }, 400);
            });
        }

        // Auto reload on status change
        if (filterStatus) {
            filterStatus.addEventListener('change', function () {
                window.paymentVouchersTable.ajax.reload(null, false);
            });
        }

        // Refresh button uses DataTable reload
        if (refreshBtn) {
            refreshBtn.addEventListener('click', function () {
                window.paymentVouchersTable.ajax.reload(null, false);
            });
        }
    }

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
            
            // Disable button
            saveBtn.disabled = true;
            saveBtn.innerHTML = '<span class="animate-spin inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full mr-2"></span> جاري الحفظ...';
            
            fetch('{{ route("accounting.payment-vouchers.store") }}', {
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
                    const v = data.voucher;
                    // Show success message
                    if (typeof window.showSuccess === 'function') {
                        window.showSuccess(data.message);
                    }
                    
                    // Reload table data instead of manual row injection
                    if (window.paymentVouchersTable) {
                        window.paymentVouchersTable.ajax.reload(null, false);
                    }

                    // Update stats
                    const totalEl = document.getElementById('stat-total');
                    const amountEl = document.getElementById('stat-amount');
                    if (totalEl) {
                        totalEl.textContent = parseInt(totalEl.textContent) + 1;
                    }
                    if (amountEl && v && v.total_amount) {
                        const currentAmount = parseFloat(amountEl.textContent.replace(/,/g, '')) || 0;
                        const newAmount = parseFloat(String(v.total_amount).replace(/,/g, '')) || 0;
                        amountEl.textContent = (currentAmount + newAmount).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    }
                    
                    // Reset form and close modal
                    form.reset();
                    document.getElementById('voucher_date').value = '{{ now()->toDateString() }}';
                    calculateTotals();
                    
                    const modal = tailwind.Modal.getOrCreateInstance(document.getElementById('create-payment-voucher-modal'));
                    modal.hide();
                    
                    // Rebind delete handlers
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

    // Delete handlers (for legacy buttons) - kept for backward compatibility
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

        runDeleteRequest(id, name, row);
    }

    function runDeleteRequest(id, name, row) {
        if (typeof window.confirmDelete === 'function') {
            window.confirmDelete(name, () => {
                fetch(`/accounting/payment-vouchers/${id}`, {
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

                        // Remove row if provided (legacy mode)
                        if (row && row.remove) {
                            row.remove();
                        }

                        // Reload DataTable if available
                        if (window.paymentVouchersTable) {
                            window.paymentVouchersTable.ajax.reload(null, false);
                        }

                        // Update stats
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

    // Expose helpers similar to Positions page style
    window.viewPaymentVoucher = function (id) {
        // Placeholder: later can open a detailed view modal
        if (typeof window.showInfo === 'function') {
            window.showInfo('عرض تفاصيل السند قادم قريباً');
        }
    };

    window.printPaymentVoucher = function (id) {
        // Placeholder: hook into real print route when available
        if (typeof window.showInfo === 'function') {
            window.showInfo('طباعة سند الصرف قيد التنفيذ');
        }
    };

    window.deletePaymentVoucher = function (id, number) {
        runDeleteRequest(id, number, null);
    };

    bindDeleteHandlers();
});
</script>
@endpush

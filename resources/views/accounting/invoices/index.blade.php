@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>الفواتير - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@section('subcontent')
@include('components.global-notifications')

{{-- Header with Stats --}}
<div class="intro-y mt-6 mb-2 flex flex-col gap-1">
    <div class="flex items-baseline justify-between gap-6">
        <h2 class="flex items-center gap-2 text-2xl md:text-3xl font-semibold text-royalDark tracking-wide">
            <x-base.lucide icon="receipt" class="w-7 h-7" />
            <span>الفواتير</span>
        </h2>

        <div class="flex flex-row items-end gap-6 md:gap-10 justify-end">
            {{-- Overdue --}}
            <div class="flex flex-col items-center gap-1">
                <div class="flex items-baseline gap-2">
                    <div class="inline-flex items-center justify-center rounded-full bg-rose-100 px-1.5 py-1">
                        <x-base.lucide icon="alert-triangle" class="w-4 h-4 text-rose-600" />
                    </div>
                    <div class="text-4xl md:text-5xl font-semibold tracking-tight text-rose-600">
                        {{ $overdueInvoices ?? 0 }}
                    </div>
                </div>
                <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">متأخرة</div>
            </div>

            {{-- Pending --}}
            <div class="flex flex-col items-center gap-1">
                <div class="flex items-baseline gap-2">
                    <div class="inline-flex items-center justify-center rounded-full bg-amber-100 px-1.5 py-1">
                        <x-base.lucide icon="clock" class="w-4 h-4 text-amber-600" />
                    </div>
                    <div class="text-4xl md:text-5xl font-semibold tracking-tight text-amber-600">
                        {{ $pendingInvoices ?? 0 }}
                    </div>
                </div>
                <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">معلقة</div>
            </div>

            {{-- Paid --}}
            <div class="flex flex-col items-center gap-1">
                <div class="flex items-baseline gap-2">
                    <div class="inline-flex items-center justify-center rounded-full bg-emerald-100 px-1.5 py-1">
                        <x-base.lucide icon="check-circle-2" class="w-4 h-4 text-emerald-600" />
                    </div>
                    <div class="text-4xl md:text-5xl font-semibold tracking-tight text-emerald-600">
                        {{ $paidInvoices ?? 0 }}
                    </div>
                </div>
                <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">مدفوعة</div>
            </div>

            {{-- Total --}}
            <div class="flex flex-col items-center gap-1">
                <div class="flex items-baseline gap-2">
                    <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                        <x-base.lucide icon="receipt" class="w-4 h-4" />
                    </div>
                    <div class="text-4xl md:text-5xl font-semibold tracking-tight" style="color: #303030">
                        {{ $totalInvoices ?? 0 }}
                    </div>
                </div>
                <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">الإجمالي</div>
            </div>
        </div>
    </div>
</div>

<div class="mt-5 grid grid-cols-12 gap-6">
    {{-- Create Invoice Form --}}
    <div class="intro-y col-span-12 lg:col-span-4">
        <x-base.preview-component class="intro-y box bg-white/80 border border-slate-200/70 shadow-[0_18px_45px_rgba(15,23,42,0.10)]">
            <div class="p-5">
                <h3 class="mb-4 text-lg font-semibold flex items-center gap-2">
                    <x-base.lucide icon="plus-circle" class="w-5 h-5 text-primary" />
                    إنشاء فاتورة جديدة
                </h3>

                <form method="POST" action="{{ route('accounting.invoices.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <x-base.form-label for="customer_id">العميل <span class="text-danger">*</span></x-base.form-label>
                        <x-base.form-select id="customer_id" name="customer_id" required>
                            <option value="">اختر العميل</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" @selected(old('customer_id') == $customer->id)>
                                    {{ $customer->code }} - {{ $customer->name }}
                                </option>
                            @endforeach
                        </x-base.form-select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-base.form-label for="type">النوع <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-select id="type" name="type" required>
                                <option value="sales" @selected(old('type') == 'sales')>فاتورة مبيعات</option>
                                <option value="purchase" @selected(old('type') == 'purchase')>فاتورة مشتريات</option>
                            </x-base.form-select>
                        </div>
                        <div>
                            <x-base.form-label for="tax_id">الضريبة</x-base.form-label>
                            <x-base.form-select id="tax_id" name="tax_id">
                                <option value="">بدون ضريبة</option>
                                @foreach($taxes as $tax)
                                    <option value="{{ $tax->id }}" data-rate="{{ $tax->rate }}" @selected(old('tax_id') == $tax->id)>
                                        {{ $tax->name }} ({{ number_format($tax->rate, 2) }}%)
                                    </option>
                                @endforeach
                            </x-base.form-select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-base.form-label for="invoice_date">تاريخ الفاتورة <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-input id="invoice_date" name="invoice_date" type="date" value="{{ old('invoice_date', now()->toDateString()) }}" required />
                        </div>
                        <div>
                            <x-base.form-label for="due_date">تاريخ الاستحقاق</x-base.form-label>
                            <x-base.form-input id="due_date" name="due_date" type="date" value="{{ old('due_date') }}" />
                        </div>
                    </div>

                    <div>
                        <x-base.form-label for="reference">المرجع</x-base.form-label>
                        <x-base.form-input id="reference" name="reference" type="text" value="{{ old('reference') }}" placeholder="رقم أمر الشراء أو المرجع" />
                    </div>

                    <div>
                        <x-base.form-label for="notes">ملاحظات</x-base.form-label>
                        <x-base.form-textarea id="notes" name="notes" rows="2" placeholder="ملاحظات إضافية...">{{ old('notes') }}</x-base.form-textarea>
                    </div>

                    {{-- Invoice Line --}}
                    <div class="p-3 bg-slate-50 rounded-lg">
                        <x-base.form-label class="font-semibold">بنود الفاتورة <span class="text-danger">*</span></x-base.form-label>
                        <div class="space-y-3 mt-2" id="invoice-lines">
                            <div class="grid grid-cols-12 gap-2 invoice-line-row">
                                <div class="col-span-12">
                                    <x-base.form-select name="lines[0][account_id]" required class="text-sm">
                                        <option value="">اختر الحساب</option>
                                        @foreach($accounts as $account)
                                            <option value="{{ $account->id }}">
                                                {{ $account->code }} - {{ $account->name }}
                                            </option>
                                        @endforeach
                                    </x-base.form-select>
                                </div>
                                <div class="col-span-12">
                                    <x-base.form-input name="lines[0][description]" type="text" placeholder="الوصف" class="text-sm" />
                                </div>
                                <div class="col-span-6">
                                    <x-base.form-input name="lines[0][quantity]" type="number" min="0" step="0.001" value="1" placeholder="الكمية" class="text-sm" />
                                </div>
                                <div class="col-span-6">
                                    <x-base.form-input name="lines[0][unit_price]" type="number" min="0" step="0.01" value="0" placeholder="السعر" class="text-sm" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="btn-royal btn-royal--gold w-full">
                            <x-base.lucide icon="save" class="w-4 h-4" /> حفظ الفاتورة
                        </button>
                    </div>
                </form>
            </div>
        </x-base.preview-component>
    </div>

    {{-- Invoices Table --}}
    <div class="intro-y col-span-12 lg:col-span-8">
        <x-base.preview-component class="intro-y box bg-white/80 border border-slate-200/70 shadow-[0_18px_45px_rgba(15,23,42,0.10)]">
            <div class="p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold flex items-center gap-2">
                        <x-base.lucide icon="list" class="w-5 h-5 text-primary" />
                        قائمة الفواتير
                    </h3>
                    <div class="flex flex-wrap items-center gap-2">
                        <button id="invoices-export" type="button" class="btn-royal btn-royal--outline btn-royal--sm">
                            <x-base.lucide icon="file-spreadsheet" class="w-4 h-4" /> تصدير
                        </button>
                        <button id="invoices-refresh" type="button" class="btn-royal btn-royal--outline btn-royal--sm" onclick="location.reload()">
                            <x-base.lucide icon="refresh-cw" class="w-4 h-4" />
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto sm:overflow-visible" data-erp-table-wrapper>
                    <table id="invoices-table" data-tw-merge data-erp-table class="w-full min-w-full table-auto text-left text-sm">
                        <thead>
                            <tr>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">رقم الفاتورة</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">العميل</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">النوع</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">التاريخ</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-right">المبلغ</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">الحالة</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($invoices as $invoice)
                            <tr class="intro-x">
                                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300">
                                    <div class="font-semibold">{{ $invoice->number }}</div>
                                    @if($invoice->reference)
                                        <div class="text-xs text-slate-500">المرجع: {{ $invoice->reference }}</div>
                                    @endif
                                </td>
                                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300">
                                    {{ $invoice->customer->name ?? '-' }}
                                </td>
                                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300">
                                    @if($invoice->type === 'sales')
                                        <span class="inline-flex items-center gap-1 text-emerald-600">
                                            <x-base.lucide icon="trending-up" class="w-4 h-4" /> مبيعات
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-blue-600">
                                            <x-base.lucide icon="trending-down" class="w-4 h-4" /> مشتريات
                                        </span>
                                    @endif
                                </td>
                                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300">
                                    {{ $invoice->invoice_date?->format('Y-m-d') }}
                                </td>
                                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300 text-right font-semibold">
                                    {{ number_format($invoice->total, 2) }}
                                </td>
                                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300 text-center">
                                    @if($invoice->status === 'paid')
                                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-emerald-100 text-emerald-600 rounded text-xs font-semibold">
                                            <x-base.lucide icon="check-circle" class="w-3 h-3" /> مدفوعة
                                        </span>
                                    @elseif($invoice->status === 'pending')
                                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-amber-100 text-amber-600 rounded text-xs font-semibold">
                                            <x-base.lucide icon="clock" class="w-3 h-3" /> معلقة
                                        </span>
                                    @elseif($invoice->status === 'overdue')
                                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-rose-100 text-rose-600 rounded text-xs font-semibold">
                                            <x-base.lucide icon="alert-triangle" class="w-3 h-3" /> متأخرة
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-slate-100 text-slate-600 rounded text-xs font-semibold">
                                            {{ $invoice->status }}
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
                                                data-id="{{ $invoice->id }}" 
                                                data-name="{{ $invoice->number }}" 
                                                title="حذف">
                                            <x-base.lucide icon="trash-2" class="w-4 h-4" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-5 py-8 text-center text-slate-400">
                                    <x-base.lucide icon="inbox" class="w-12 h-12 mx-auto mb-2 opacity-50" />
                                    لا توجد فواتير
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
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // PDF export
            const pdfBtn = document.getElementById('invoices-pdf');
            if (pdfBtn) {
                pdfBtn.addEventListener('click', function () {
                    showToast('PDF export functionality not implemented yet', 'info');
                });
            }

            // Export functionality
            const exportBtn = document.getElementById('invoices-export');
            if (exportBtn) {
                exportBtn.addEventListener('click', function () {
                    // Simple CSV export for now
                    const rows = [];
                    const headers = ['Number', 'Customer', 'Type', 'Date', 'Total', 'Status'];
                    rows.push(headers.join(','));

                    @foreach($invoices as $invoice)
                        const row = [
                            '"{{ $invoice->number }}"',
                            '"{{ $invoice->customer->name ?? '-' }}"',
                            '"{{ $invoice->type_label }}"',
                            '"{{ $invoice->invoice_date?->format('Y-m-d') }}"',
                            '{{ $invoice->total }}',
                            '"{{ $invoice->status }}"'
                        ];
                        rows.push(row.join(','));
                    @endforeach

                    const csvContent = '\ufeff' + rows.join('\n');
                    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
                    const link = document.createElement('a');
                    link.href = URL.createObjectURL(blob);
                    link.download = 'invoices_' + new Date().toISOString().split('T')[0] + '.csv';
                    link.click();
                    URL.revokeObjectURL(link);

                    if (typeof showToast === 'function') {
                        showToast('Invoices exported successfully', 'success');
                    }
                });
            }

            // Refresh functionality
            const refreshBtn = document.getElementById('invoices-refresh');
            if (refreshBtn) {
                refreshBtn.addEventListener('click', function () {
                    window.location.reload();
                    if (typeof showToast === 'function') {
                        showToast('Page refreshed', 'success');
                    }
                });
            }
        });
    </script>
@endpush

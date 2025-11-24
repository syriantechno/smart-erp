@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Invoices - {{ config('app.name') }}</title>
@endsection

@section('subcontent')
    @include('components.global-notifications')

    {{-- Heading + top stats strip on the same row (Departments template matches Positions) --}}
    <div class="intro-y mt-6 mb-2 flex flex-col gap-1 text-[#3a2a1a]">
        <div class="flex items-baseline justify-between gap-6">
            <h2 class="flex items-center gap-2 text-2xl md:text-3xl font-semibold text-royalDark tracking-wide">
                <x-base.lucide icon="receipt" class="w-7 h-7" />
                <span>Invoices</span>
            </h2>

            <div class="flex flex-row items-end gap-8 md:gap-12 justify-end">
                {{-- Overdue --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="alert-triangle" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $overdueInvoices ?? '—' }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Overdue
                    </div>
                </div>

                {{-- Pending --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="clock" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $pendingInvoices ?? '—' }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Pending
                    </div>
                </div>

                {{-- Paid --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="check-circle-2" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $paidInvoices ?? '—' }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Paid
                    </div>
                </div>

                {{-- Total --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="receipt" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $totalInvoices ?? '—' }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Total
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <!-- Create Invoice -->
        <div class="intro-y col-span-12 lg:col-span-5">
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    <h3 class="mb-4 text-base font-semibold">Create New Invoice</h3>

                    <form method="POST" action="{{ route('accounting.invoices.store') }}" class="space-y-4">
                        @csrf

                        <div>
                            <x-base.form-label for="customer_id">Customer <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-select id="customer_id" name="customer_id" required>
                                <option value="">Select customer</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" @selected(old('customer_id') == $customer->id)>
                                        {{ $customer->code }} - {{ $customer->name }}
                                    </option>
                                @endforeach
                            </x-base.form-select>
                        </div>

                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-6">
                                <x-base.form-label for="type">Type <span class="text-danger">*</span></x-base.form-label>
                                <x-base.form-select id="type" name="type" required>
                                    <option value="sales" @selected(old('type') == 'sales')>Sales Invoice</option>
                                    <option value="purchase" @selected(old('type') == 'purchase')>Purchase Invoice</option>
                                </x-base.form-select>
                            </div>
                            <div class="col-span-6">
                                <x-base.form-label for="tax_id">Tax</x-base.form-label>
                                <x-base.form-select id="tax_id" name="tax_id">
                                    <option value="">No tax</option>
                                    @foreach($taxes as $tax)
                                        <option value="{{ $tax->id }}" @selected(old('tax_id') == $tax->id)>
                                            {{ $tax->name }} ({{ number_format($tax->rate, 3) }}%)
                                        </option>
                                    @endforeach
                                </x-base.form-select>
                            </div>
                        </div>

                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-6">
                                <x-base.form-label for="invoice_date">Invoice Date <span class="text-danger">*</span></x-base.form-label>
                                <x-base.form-input id="invoice_date" name="invoice_date" type="date" value="{{ old('invoice_date', now()->toDateString()) }}" required />
                            </div>
                            <div class="col-span-6">
                                <x-base.form-label for="due_date">Due Date</x-base.form-label>
                                <x-base.form-input id="due_date" name="due_date" type="date" value="{{ old('due_date') }}" />
                            </div>
                        </div>

                        <div>
                            <x-base.form-label for="reference">Reference</x-base.form-label>
                            <x-base.form-input id="reference" name="reference" type="text" value="{{ old('reference') }}" />
                        </div>

                        <div>
                            <x-base.form-label for="notes">Notes</x-base.form-label>
                            <x-base.form-textarea id="notes" name="notes" rows="2">{{ old('notes') }}</x-base.form-textarea>
                        </div>

                        <div>
                            <x-base.form-label>Lines <span class="text-danger">*</span></x-base.form-label>

                            <div class="space-y-3" id="invoice-lines">
                                <div class="grid grid-cols-12 gap-2 invoice-line-row">
                                    <div class="col-span-12">
                                        <x-base.form-label>Account</x-base.form-label>
                                        <x-base.form-select name="lines[0][account_id]" required>
                                            <option value="">Select account</option>
                                            @foreach($accounts as $account)
                                                <option value="{{ $account->id }}">
                                                    {{ $account->code }} - {{ $account->name }}
                                                </option>
                                            @endforeach
                                        </x-base.form-select>
                                    </div>
                                    <div class="col-span-12">
                                        <x-base.form-label>Description</x-base.form-label>
                                        <x-base.form-input name="lines[0][description]" type="text" />
                                    </div>
                                    <div class="col-span-6">
                                        <x-base.form-label>Quantity</x-base.form-label>
                                        <x-base.form-input name="lines[0][quantity]" type="number" min="0" step="0.001" value="1" />
                                    </div>
                                    <div class="col-span-6">
                                        <x-base.form-label>Unit Price</x-base.form-label>
                                        <x-base.form-input name="lines[0][unit_price]" type="number" min="0" step="0.01" value="0" />
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3 text-xs text-slate-500">
                                For now, one line is enough for testing. Later we can enhance with dynamic rows.
                            </div>
                        </div>

                        <div class="pt-2 text-right">
                            <x-base.button type="submit" variant="primary">
                                Save Invoice
                            </x-base.button>
                        </div>
                    </form>
                </div>
            </x-base.preview-component>
        </div>

        <!-- Invoices List -->
        <div class="intro-y col-span-12 lg:col-span-7">
            <x-base.preview-component class="intro-y box bg-white/80 border border-slate-200/70 shadow-[0_18px_45px_rgba(15,23,42,0.10)]">
                <div class="p-5">
                    <div class="flex flex-col sm:flex-row sm:items-end xl:items-start mb-4">
                        <div class="flex flex-wrap items-center gap-2 sm:mt-0 sm:flex-nowrap">
                            <x-base.tippy content="Export PDF" placement="bottom">
                                <button id="invoices-pdf" type="button" class="btn-royal btn-royal--outline btn-royal--sm btn-tonal--icon group text-royalDark">
                                    <x-base.lucide icon="file-text" class="w-5 h-5 icon-hover-rise" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Export" placement="bottom">
                                <button id="invoices-export" type="button" class="btn-royal btn-royal--outline btn-royal--sm btn-tonal--icon group text-royalDark">
                                    <x-base.lucide icon="file-spreadsheet" class="w-5 h-5 icon-hover-rise" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Refresh" placement="bottom">
                                <button id="invoices-refresh" type="button" class="btn-royal btn-royal--outline btn-royal--sm btn-tonal--icon group text-royalDark">
                                    <x-base.lucide icon="refresh-cw" class="w-5 h-5 icon-hover-rise" />
                                </button>
                            </x-base.tippy>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-gradient-to-r from-royalDark to-gray-800 text-white">
                                <tr>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">#</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Number</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Customer</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Type</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Date</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Total</th>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($invoices as $invoice)
                                    <tr class="border-b border-slate-100 text-xs text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-darkmode-600">
                                        <td class="px-5 py-3">{{ $loop->iteration }}</td>
                                        <td class="px-5 py-3">
                                            <div class="font-semibold">{{ $invoice->number }}</div>
                                            @if($invoice->reference)
                                                <div class="text-[11px] text-slate-500">Ref: {{ $invoice->reference }}</div>
                                            @endif
                                        </td>
                                        <td class="px-5 py-3">{{ $invoice->customer->name ?? '-' }}</td>
                                        <td class="px-5 py-3">{{ $invoice->type_label }}</td>
                                        <td class="px-5 py-3">{{ $invoice->invoice_date?->format('Y-m-d') }}</td>
                                        <td class="px-5 py-3">{{ number_format($invoice->total, 2) }}</td>
                                        <td class="px-5 py-3 text-center">
                                            <span class="rounded-full bg-slate-100 px-2 py-0.5 text-[11px] font-semibold text-slate-700 capitalize">
                                                {{ $invoice->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-5 py-8 text-center text-xs text-slate-500">
                                            No invoices found.
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

@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Customer Statement - {{ $customer->name }} - {{ config('app.name') }}</title>
@endsection

@section('subcontent')
    @include('components.global-notifications')

    {{-- Header with stats (similar style to other pages) --}}
    <div class="intro-y mt-6 mb-2 flex flex-col gap-1">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
            <div class="flex flex-col gap-1">
                <h2 class="flex items-center gap-2 text-2xl md:text-3xl font-semibold text-royalDark tracking-wide">
                    <x-base.lucide icon="user" class="w-7 h-7" />
                    <span>Customer Statement</span>
                </h2>
                <div class="text-sm text-slate-600 flex flex-col gap-0.5">
                    <div>
                        <span class="font-semibold">Customer:</span>
                        {{ $customer->code ?? '-' }} - {{ $customer->name }}
                    </div>
                    <div>
                        <span class="font-semibold">Account:</span>
                        @if($account)
                            {{ $account->code }} - {{ $account->name }}
                        @else
                            <span class="text-slate-400">No linked account</span>
                        @endif
                    </div>
                    <div>
                        <span class="font-semibold">Period:</span>
                        @if($dateFrom || $dateTo)
                            {{ $dateFrom ?: 'Beginning' }} - {{ $dateTo ?: 'Today' }}
                        @else
                            All dates
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <div class="rounded-xl bg-slate-50 border border-slate-200 px-3 py-2 flex flex-col gap-1">
                    <div class="text-xs uppercase tracking-[0.15em] text-slate-500">Opening Balance</div>
                    <div class="text-lg font-semibold text-slate-800">
                        {{ format_currency($openingBalance) }}
                    </div>
                </div>
                <div class="rounded-xl bg-emerald-50 border border-emerald-100 px-3 py-2 flex flex-col gap-1">
                    <div class="text-xs uppercase tracking-[0.15em] text-emerald-700">Debits</div>
                    <div class="text-lg font-semibold text-emerald-800">
                        {{ format_currency($totalDebit) }}
                    </div>
                </div>
                <div class="rounded-xl bg-sky-50 border border-sky-100 px-3 py-2 flex flex-col gap-1">
                    <div class="text-xs uppercase tracking-[0.15em] text-sky-700">Credits</div>
                    <div class="text-lg font-semibold text-sky-800">
                        {{ format_currency($totalCredit) }}
                    </div>
                </div>
                <div class="rounded-xl bg-amber-50 border border-amber-100 px-3 py-2 flex flex-col gap-1">
                    <div class="text-xs uppercase tracking-[0.15em] text-amber-700">Closing Balance</div>
                    <div class="text-lg font-semibold text-amber-800 flex items-baseline gap-1">
                        {{ format_currency($closingBalanceAbs) }}
                        @if($closingBalanceType)
                            <span class="text-xs font-semibold uppercase tracking-wide">
                                {{ $closingBalanceType === 'debit' ? 'DR' : 'CR' }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <x-base.preview-component class="intro-y box bg-white/80 border border-slate-200/70 shadow-[0_18px_45px_rgba(15,23,42,0.10)]">
                <div class="p-5">
                    {{-- Filters & Actions in One Row (match Departments layout) --}}
                    <div class="flex flex-wrap items-center gap-2 mb-4">
                        {{-- Date From --}}
                        <x-base.litepicker
                            id="statement-date-from"
                            name="date_from"
                            class="w-auto text-sm py-1.5"
                            value="{{ $dateFrom }}"
                            placeholder="From date"
                            autocomplete="off"
                        />

                        {{-- Date To --}}
                        <x-base.litepicker
                            id="statement-date-to"
                            name="date_to"
                            class="w-auto text-sm py-1.5"
                            value="{{ $dateTo }}"
                            placeholder="To date"
                            autocomplete="off"
                        />

                        {{-- Reset Button (like departments) --}}
                        <x-base.tippy
                            as="button"
                            id="statement-filter-reset"
                            type="button"
                            content="Reset filters"
                            class="btn-royal btn-royal--outline btn-royal--sm px-2"
                        >
                            <x-base.lucide icon="x" class="w-4 h-4" />
                        </x-base.tippy>

                        {{-- Spacer --}}
                        <div class="flex-1"></div>

                        {{-- Action Buttons (Print / PDF / Back) --}}
                        <div class="flex items-center gap-1">
                            <x-base.tippy content="Print" placement="bottom">
                                <button type="button" id="statement-print" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="printer" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>

                            <x-base.tippy content="Export PDF" placement="bottom">
                                <button type="button" id="statement-export-pdf" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="file-text" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>

                            <x-base.tippy content="Back to Customers" placement="bottom">
                                <a href="{{ route('customers.index') }}" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="arrow-left" class="w-4 h-4" />
                                </a>
                            </x-base.tippy>
                        </div>
                    </div>

                    {{-- Statement table --}}
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-full table-auto text-sm border-collapse">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 border-b text-left text-xs font-semibold text-slate-500">Date</th>
                                    <th class="px-4 py-2 border-b text-left text-xs font-semibold text-slate-500">Reference</th>
                                    <th class="px-4 py-2 border-b text-left text-xs font-semibold text-slate-500">Description</th>
                                    <th class="px-4 py-2 border-b text-right text-xs font-semibold text-slate-500">Debit</th>
                                    <th class="px-4 py-2 border-b text-right text-xs font-semibold text-slate-500">Credit</th>
                                    <th class="px-4 py-2 border-b text-right text-xs font-semibold text-slate-500">Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="px-4 py-2 border-b text-slate-500 text-xs">
                                        {{ $dateFrom ?: 'Opening' }}
                                    </td>
                                    <td class="px-4 py-2 border-b text-slate-500 text-xs">&mdash;</td>
                                    <td class="px-4 py-2 border-b text-slate-500 text-xs">Opening balance</td>
                                    <td class="px-4 py-2 border-b text-right text-slate-500 text-xs">&mdash;</td>
                                    <td class="px-4 py-2 border-b text-right text-slate-500 text-xs">&mdash;</td>
                                    <td class="px-4 py-2 border-b text-right text-slate-700 text-xs font-semibold">
                                        {{ format_currency($openingBalance) }}
                                    </td>
                                </tr>

                                @forelse($transactions as $row)
                                    <tr>
                                        <td class="px-4 py-1.5 border-b whitespace-nowrap">{{ $row['date'] }}</td>
                                        <td class="px-4 py-1.5 border-b whitespace-nowrap">{{ $row['reference'] }}</td>
                                        <td class="px-4 py-1.5 border-b">{{ $row['description'] }}</td>
                                        <td class="px-4 py-1.5 border-b text-right">
                                            {{ $row['debit'] > 0 ? format_currency($row['debit']) : '' }}
                                        </td>
                                        <td class="px-4 py-1.5 border-b text-right">
                                            {{ $row['credit'] > 0 ? format_currency($row['credit']) : '' }}
                                        </td>
                                        <td class="px-4 py-1.5 border-b text-right font-semibold">
                                            {{ format_currency($row['balance']) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-6 text-center text-slate-400 text-sm">
                                            No transactions found for the selected period.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="px-4 py-2 text-right text-xs font-semibold text-slate-600">Totals</td>
                                    <td class="px-4 py-2 text-right text-xs font-semibold text-emerald-700">
                                        {{ format_currency($totalDebit) }}
                                    </td>
                                    <td class="px-4 py-2 text-right text-xs font-semibold text-sky-700">
                                        {{ format_currency($totalCredit) }}
                                    </td>
                                    <td class="px-4 py-2 text-right text-xs font-semibold text-amber-700">
                                        {{ format_currency($closingBalance) }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </x-base.preview-component>
        </div>
    </div>

    {{-- Hidden form for PDF export --}}
    <form
        id="customer-statement-pdf-form"
        action="{{ route('customers.statement.pdf', $customer) }}"
        method="POST"
        target="_blank"
        class="hidden"
    >
        @csrf
        <input type="hidden" name="date_from" id="statement-pdf-date-from">
        <input type="hidden" name="date_to" id="statement-pdf-date-to">
    </form>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const printBtn = document.getElementById('statement-print');
        const exportPdfBtn = document.getElementById('statement-export-pdf');
        const pdfForm = document.getElementById('customer-statement-pdf-form');
        const pdfDateFrom = document.getElementById('statement-pdf-date-from');
        const pdfDateTo = document.getElementById('statement-pdf-date-to');
        const dateFromInput = document.getElementById('statement-date-from');
        const dateToInput = document.getElementById('statement-date-to');
        const resetBtn = document.getElementById('statement-filter-reset');

        if (printBtn) {
            printBtn.addEventListener('click', function () {
                window.print();
            });
        }

        if (exportPdfBtn && pdfForm) {
            exportPdfBtn.addEventListener('click', function () {
                if (pdfDateFrom && dateFromInput) {
                    pdfDateFrom.value = dateFromInput.value || '';
                }
                if (pdfDateTo && dateToInput) {
                    pdfDateTo.value = dateToInput.value || '';
                }
                pdfForm.submit();
            });
        }

        if (resetBtn) {
            resetBtn.addEventListener('click', function () {
                const baseUrl = "{{ route('customers.statement', $customer) }}";
                window.location.href = baseUrl;
            });
        }

        // Optional: auto-apply on date change similar to other pages
        [dateFromInput, dateToInput].forEach(function (input) {
            if (!input) return;
            input.addEventListener('change', function () {
                const params = new URLSearchParams();
                if (dateFromInput && dateFromInput.value) {
                    params.append('date_from', dateFromInput.value);
                }
                if (dateToInput && dateToInput.value) {
                    params.append('date_to', dateToInput.value);
                }
                const baseUrl = "{{ route('customers.statement', $customer) }}";
                const url = params.toString() ? baseUrl + '?' + params.toString() : baseUrl;
                window.location.href = url;
            });
        });
    });
</script>
@endpush

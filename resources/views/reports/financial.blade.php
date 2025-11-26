@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>{{ __('menu.financial_reports') }} - {{ config('app.name') }}</title>
@endsection

@section('subcontent')
@include('components.global-notifications')

<div class="intro-y mt-6 mb-2 flex flex-col gap-1">
    <div class="flex items-baseline justify-between gap-6">
        <h2 class="flex items-center gap-2 text-2xl md:text-3xl font-semibold text-royalDark tracking-wide">
            <x-base.lucide icon="trending-up" class="w-7 h-7" />
            <span>{{ __('menu.financial_reports') }}</span>
        </h2>
        <a href="{{ route('reports.index') }}" class="btn-royal btn-royal--outline btn-royal--sm">
            <x-base.lucide icon="arrow-left" class="w-4 h-4" /> العودة
        </a>
    </div>
</div>

{{-- Date Filter --}}
<div class="mt-5 box p-5">
    <form method="GET" action="{{ route('reports.financial') }}" class="flex flex-wrap items-end gap-4">
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">من تاريخ</label>
            <input type="date" name="start_date" value="{{ $startDate }}" class="form-control w-40">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">إلى تاريخ</label>
            <input type="date" name="end_date" value="{{ $endDate }}" class="form-control w-40">
        </div>
        <button type="submit" class="btn-royal btn-royal--dark btn-royal--sm">
            <x-base.lucide icon="search" class="w-4 h-4" /> تطبيق
        </button>
        <div class="flex gap-2 ml-auto">
            <button type="button" onclick="exportReport('csv')" class="btn-royal btn-royal--outline btn-royal--sm">
                <x-base.lucide icon="file-spreadsheet" class="w-4 h-4" /> CSV
            </button>
            <button type="button" onclick="exportReport('pdf')" class="btn-royal btn-royal--outline btn-royal--sm">
                <x-base.lucide icon="file-text" class="w-4 h-4" /> PDF
            </button>
            <button type="button" onclick="window.print()" class="btn-royal btn-royal--outline btn-royal--sm">
                <x-base.lucide icon="printer" class="w-4 h-4" /> طباعة
            </button>
        </div>
    </form>
</div>

{{-- Summary Cards --}}
<div class="mt-5 grid grid-cols-12 gap-6">
    <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
        <div class="box p-5">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-emerald-100 flex items-center justify-center">
                    <x-base.lucide icon="trending-up" class="w-6 h-6 text-emerald-600" />
                </div>
                <div>
                    <div class="text-slate-500 text-sm">الإيرادات</div>
                    <div class="text-2xl font-bold text-emerald-600">{{ number_format($revenue, 2) }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
        <div class="box p-5">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-rose-100 flex items-center justify-center">
                    <x-base.lucide icon="trending-down" class="w-6 h-6 text-rose-600" />
                </div>
                <div>
                    <div class="text-slate-500 text-sm">المصروفات</div>
                    <div class="text-2xl font-bold text-rose-600">{{ number_format($expenses, 2) }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
        <div class="box p-5">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                    <x-base.lucide icon="wallet" class="w-6 h-6 text-blue-600" />
                </div>
                <div>
                    <div class="text-slate-500 text-sm">المقبوضات</div>
                    <div class="text-2xl font-bold text-blue-600">{{ number_format($receipts, 2) }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
        <div class="box p-5">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg {{ $netProfit >= 0 ? 'bg-emerald-100' : 'bg-rose-100' }} flex items-center justify-center">
                    <x-base.lucide icon="calculator" class="w-6 h-6 {{ $netProfit >= 0 ? 'text-emerald-600' : 'text-rose-600' }}" />
                </div>
                <div>
                    <div class="text-slate-500 text-sm">صافي الربح</div>
                    <div class="text-2xl font-bold {{ $netProfit >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                        {{ number_format($netProfit, 2) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Charts --}}
<div class="mt-5 grid grid-cols-12 gap-6">
    {{-- Revenue vs Expenses Chart --}}
    <div class="intro-y col-span-12 lg:col-span-8">
        <div class="box p-5">
            <h4 class="font-semibold text-slate-700 mb-4">الإيرادات مقابل المصروفات</h4>
            <canvas id="revenueExpenseChart" height="300"></canvas>
        </div>
    </div>

    {{-- Profit Margin --}}
    <div class="intro-y col-span-12 lg:col-span-4">
        <div class="box p-5">
            <h4 class="font-semibold text-slate-700 mb-4">هامش الربح</h4>
            <canvas id="profitChart" height="300"></canvas>
        </div>
    </div>
</div>

{{-- Top Customers & Expense Categories --}}
<div class="mt-5 grid grid-cols-12 gap-6">
    {{-- Top Customers --}}
    <div class="intro-y col-span-12 lg:col-span-6">
        <div class="box p-5">
            <h4 class="font-semibold text-slate-700 mb-4">أفضل العملاء حسب الإيرادات</h4>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50">
                            <th class="px-4 py-2 text-right font-medium text-slate-600">#</th>
                            <th class="px-4 py-2 text-right font-medium text-slate-600">العميل</th>
                            <th class="px-4 py-2 text-left font-medium text-slate-600">الإيرادات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topCustomers as $index => $item)
                        <tr class="border-b border-slate-100">
                            <td class="px-4 py-3 text-slate-500">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 font-medium">{{ $item->customer->name ?? 'N/A' }}</td>
                            <td class="px-4 py-3 text-emerald-600 font-semibold">{{ number_format($item->total_revenue, 2) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-4 py-8 text-center text-slate-400">لا توجد بيانات</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Expense Categories --}}
    <div class="intro-y col-span-12 lg:col-span-6">
        <div class="box p-5">
            <h4 class="font-semibold text-slate-700 mb-4">المصروفات حسب الحساب</h4>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50">
                            <th class="px-4 py-2 text-right font-medium text-slate-600">#</th>
                            <th class="px-4 py-2 text-right font-medium text-slate-600">الحساب</th>
                            <th class="px-4 py-2 text-left font-medium text-slate-600">المبلغ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expensesByAccount as $index => $item)
                        <tr class="border-b border-slate-100">
                            <td class="px-4 py-3 text-slate-500">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 font-medium">{{ $item->account->name ?? 'N/A' }}</td>
                            <td class="px-4 py-3 text-rose-600 font-semibold">{{ number_format($item->total, 2) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-4 py-8 text-center text-slate-400">لا توجد بيانات</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Monthly Breakdown --}}
<div class="mt-5">
    <div class="intro-y box p-5">
        <h4 class="font-semibold text-slate-700 mb-4">التفصيل الشهري</h4>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="px-4 py-2 text-right font-medium text-slate-600">الشهر</th>
                        <th class="px-4 py-2 text-left font-medium text-slate-600">الإيرادات</th>
                        <th class="px-4 py-2 text-left font-medium text-slate-600">المصروفات</th>
                        <th class="px-4 py-2 text-left font-medium text-slate-600">صافي الربح</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($monthlyData as $month)
                    @php $monthProfit = $month['revenue'] - $month['expenses']; @endphp
                    <tr class="border-b border-slate-100">
                        <td class="px-4 py-3 font-medium">{{ $month['month'] }}</td>
                        <td class="px-4 py-3 text-emerald-600">{{ number_format($month['revenue'], 2) }}</td>
                        <td class="px-4 py-3 text-rose-600">{{ number_format($month['expenses'], 2) }}</td>
                        <td class="px-4 py-3 font-semibold {{ $monthProfit >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                            {{ number_format($monthProfit, 2) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Revenue vs Expenses Chart
    const monthlyData = @json($monthlyData);
    
    new Chart(document.getElementById('revenueExpenseChart'), {
        type: 'bar',
        data: {
            labels: monthlyData.map(m => m.month),
            datasets: [
                {
                    label: 'الإيرادات',
                    data: monthlyData.map(m => m.revenue),
                    backgroundColor: 'rgba(16, 185, 129, 0.8)',
                    borderRadius: 4,
                },
                {
                    label: 'المصروفات',
                    data: monthlyData.map(m => m.expenses),
                    backgroundColor: 'rgba(244, 63, 94, 0.8)',
                    borderRadius: 4,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Profit Chart
    const revenue = {{ $revenue }};
    const expenses = {{ $expenses }};
    
    new Chart(document.getElementById('profitChart'), {
        type: 'doughnut',
        data: {
            labels: ['الإيرادات', 'المصروفات'],
            datasets: [{
                data: [revenue, expenses],
                backgroundColor: [
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(244, 63, 94, 0.8)'
                ],
                borderWidth: 0,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
});

function exportReport(format) {
    const startDate = document.querySelector('input[name="start_date"]').value;
    const endDate = document.querySelector('input[name="end_date"]').value;
    
    window.location.href = `{{ route('reports.custom.generate') }}?module=invoices&start_date=${startDate}&end_date=${endDate}&format=${format}`;
}
</script>
@endpush

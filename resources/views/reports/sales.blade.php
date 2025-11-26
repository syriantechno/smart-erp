@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>{{ __('menu.sales_reports') }} - {{ config('app.name') }}</title>
@endsection

@section('subcontent')
@include('components.global-notifications')

<div class="intro-y mt-6 mb-2 flex flex-col gap-1">
    <div class="flex items-baseline justify-between gap-6">
        <h2 class="flex items-center gap-2 text-2xl md:text-3xl font-semibold text-royalDark tracking-wide">
            <x-base.lucide icon="shopping-cart" class="w-7 h-7" />
            <span>{{ __('menu.sales_reports') }}</span>
        </h2>
        <a href="{{ route('reports.index') }}" class="btn-royal btn-royal--outline btn-royal--sm">
            <x-base.lucide icon="arrow-left" class="w-4 h-4" /> العودة
        </a>
    </div>
</div>

{{-- Date Filter --}}
<div class="mt-5 box p-5">
    <form method="GET" action="{{ route('reports.sales') }}" class="flex flex-wrap items-end gap-4">
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
                    <div class="text-slate-500 text-sm">إجمالي المبيعات</div>
                    <div class="text-2xl font-bold text-emerald-600">{{ number_format($totalSales, 2) }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
        <div class="box p-5">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                    <x-base.lucide icon="file-text" class="w-6 h-6 text-blue-600" />
                </div>
                <div>
                    <div class="text-slate-500 text-sm">عدد الفواتير</div>
                    <div class="text-2xl font-bold text-blue-600">{{ $invoicesStats['total'] }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
        <div class="box p-5">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-emerald-100 flex items-center justify-center">
                    <x-base.lucide icon="check-circle" class="w-6 h-6 text-emerald-600" />
                </div>
                <div>
                    <div class="text-slate-500 text-sm">فواتير مدفوعة</div>
                    <div class="text-2xl font-bold text-emerald-600">{{ $invoicesStats['paid'] }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
        <div class="box p-5">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-amber-100 flex items-center justify-center">
                    <x-base.lucide icon="clock" class="w-6 h-6 text-amber-600" />
                </div>
                <div>
                    <div class="text-slate-500 text-sm">فواتير معلقة</div>
                    <div class="text-2xl font-bold text-amber-600">{{ $invoicesStats['pending'] }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Sales Trend Chart --}}
<div class="mt-5 grid grid-cols-12 gap-6">
    <div class="intro-y col-span-12 lg:col-span-8">
        <div class="box p-5">
            <h4 class="font-semibold text-slate-700 mb-4">اتجاه المبيعات</h4>
            <canvas id="salesTrendChart" height="300"></canvas>
        </div>
    </div>

    {{-- Sales Distribution --}}
    <div class="intro-y col-span-12 lg:col-span-4">
        <div class="box p-5">
            <h4 class="font-semibold text-slate-700 mb-4">حالة الفواتير</h4>
            <canvas id="invoiceStatusChart" height="300"></canvas>
        </div>
    </div>
</div>

{{-- Top Customers --}}
<div class="mt-5">
    <div class="intro-y box p-5">
        <h4 class="font-semibold text-slate-700 mb-4">أفضل العملاء</h4>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="px-4 py-2 text-right font-medium text-slate-600">#</th>
                        <th class="px-4 py-2 text-right font-medium text-slate-600">العميل</th>
                        <th class="px-4 py-2 text-center font-medium text-slate-600">عدد الطلبات</th>
                        <th class="px-4 py-2 text-left font-medium text-slate-600">إجمالي المبيعات</th>
                        <th class="px-4 py-2 text-center font-medium text-slate-600">النسبة</th>
                    </tr>
                </thead>
                <tbody>
                    @php $totalAllSales = $topCustomers->sum('total_sales'); @endphp
                    @foreach($topCustomers as $index => $customer)
                    @php $percentage = $totalAllSales > 0 ? ($customer->total_sales / $totalAllSales) * 100 : 0; @endphp
                    <tr class="border-b border-slate-100">
                        <td class="px-4 py-3 text-slate-500">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 font-medium">{{ $customer->customer->name ?? 'N/A' }}</td>
                        <td class="px-4 py-3 text-center">{{ $customer->orders_count }}</td>
                        <td class="px-4 py-3 text-emerald-600 font-semibold">{{ number_format($customer->total_sales, 2) }}</td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center gap-2">
                                <div class="flex-1 h-2 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-emerald-500 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                                <span class="text-xs text-slate-500">{{ number_format($percentage, 1) }}%</span>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Recent Sales --}}
<div class="mt-5">
    <div class="intro-y box p-5">
        <h4 class="font-semibold text-slate-700 mb-4">آخر المبيعات</h4>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="px-4 py-2 text-right font-medium text-slate-600">رقم الفاتورة</th>
                        <th class="px-4 py-2 text-right font-medium text-slate-600">العميل</th>
                        <th class="px-4 py-2 text-center font-medium text-slate-600">التاريخ</th>
                        <th class="px-4 py-2 text-left font-medium text-slate-600">المبلغ</th>
                        <th class="px-4 py-2 text-center font-medium text-slate-600">الحالة</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentSales as $sale)
                    <tr class="border-b border-slate-100">
                        <td class="px-4 py-3 font-medium">{{ $sale->invoice_number ?? 'INV-' . $sale->id }}</td>
                        <td class="px-4 py-3">{{ $sale->customer->name ?? 'N/A' }}</td>
                        <td class="px-4 py-3 text-center">{{ $sale->invoice_date?->format('Y-m-d') }}</td>
                        <td class="px-4 py-3 text-emerald-600 font-semibold">{{ number_format($sale->total, 2) }}</td>
                        <td class="px-4 py-3 text-center">
                            @if($sale->status === 'paid')
                            <span class="px-2 py-1 bg-emerald-100 text-emerald-600 rounded text-xs font-semibold">مدفوعة</span>
                            @elseif($sale->status === 'pending')
                            <span class="px-2 py-1 bg-amber-100 text-amber-600 rounded text-xs font-semibold">معلقة</span>
                            @else
                            <span class="px-2 py-1 bg-slate-100 text-slate-600 rounded text-xs font-semibold">{{ $sale->status }}</span>
                            @endif
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
    const monthlySales = @json($monthlySales);
    
    // Sales Trend Chart
    new Chart(document.getElementById('salesTrendChart'), {
        type: 'line',
        data: {
            labels: monthlySales.map(m => m.month),
            datasets: [{
                label: 'المبيعات',
                data: monthlySales.map(m => m.sales),
                borderColor: 'rgba(16, 185, 129, 1)',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                fill: true,
                tension: 0.4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
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

    // Invoice Status Chart
    new Chart(document.getElementById('invoiceStatusChart'), {
        type: 'doughnut',
        data: {
            labels: ['مدفوعة', 'معلقة'],
            datasets: [{
                data: [{{ $invoicesStats['paid'] }}, {{ $invoicesStats['pending'] }}],
                backgroundColor: [
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(245, 158, 11, 0.8)'
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
</script>
@endpush

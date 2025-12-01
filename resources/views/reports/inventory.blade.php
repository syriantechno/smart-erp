@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>{{ __('menu.inventory_reports') }} - {{ config('app.name') }}</title>
@endsection

@section('subcontent')
@include('components.global-notifications')

<div class="intro-y mt-6 mb-2 flex flex-col gap-1">
    <div class="flex items-baseline justify-between gap-6">
        <h2 class="flex items-center gap-2 text-2xl md:text-3xl font-semibold text-royalDark tracking-wide">
            <x-base.lucide icon="package" class="w-7 h-7" />
            <span>{{ __('menu.inventory_reports') }}</span>
        </h2>
        <a href="{{ route('reports.index') }}" class="btn-royal btn-royal--outline btn-royal--sm">
            <x-base.lucide icon="arrow-left" class="w-4 h-4" /> العودة
        </a>
    </div>
</div>

{{-- Date Filter --}}
<div class="mt-5 box p-5">
    <form method="GET" action="{{ route('reports.inventory') }}" class="flex flex-wrap items-end gap-4">
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
                <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                    <x-base.lucide icon="box" class="w-6 h-6 text-blue-600" />
                </div>
                <div>
                    <div class="text-slate-500 text-sm">إجمالي المواد</div>
                    <div class="text-2xl font-bold text-blue-600">{{ $totalMaterials }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
        <div class="box p-5">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-rose-100 flex items-center justify-center">
                    <x-base.lucide icon="alert-triangle" class="w-6 h-6 text-rose-600" />
                </div>
                <div>
                    <div class="text-slate-500 text-sm">مواد منخفضة</div>
                    <div class="text-2xl font-bold text-rose-600">{{ $lowStockMaterials }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
        <div class="box p-5">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-emerald-100 flex items-center justify-center">
                    <x-base.lucide icon="wallet" class="w-6 h-6 text-emerald-600" />
                </div>
                <div>
                    <div class="text-slate-500 text-sm">قيمة المخزون</div>
                    <div class="text-2xl font-bold text-emerald-600">{{ function_exists('format_currency') ? format_currency($inventoryValue) : number_format($inventoryValue, 2) }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
        <div class="box p-5">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-amber-100 flex items-center justify-center">
                    <x-base.lucide icon="shopping-cart" class="w-6 h-6 text-amber-600" />
                </div>
                <div>
                    <div class="text-slate-500 text-sm">أوامر الشراء</div>
                    <div class="text-2xl font-bold text-amber-600">{{ $purchaseOrdersStats['total'] }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Purchase Orders Stats --}}
<div class="mt-5 grid grid-cols-12 gap-6">
    <div class="intro-y col-span-12 lg:col-span-6">
        <div class="box p-5">
            <h4 class="font-semibold text-slate-700 mb-4">إحصائيات أوامر الشراء</h4>
            <div class="grid grid-cols-2 gap-4">
                <div class="p-4 bg-slate-50 rounded-lg text-center">
                    <div class="text-3xl font-bold text-slate-700">{{ $purchaseOrdersStats['total'] }}</div>
                    <div class="text-sm text-slate-500 mt-1">إجمالي الأوامر</div>
                </div>
                <div class="p-4 bg-emerald-50 rounded-lg text-center">
                    <div class="text-3xl font-bold text-emerald-600">{{ function_exists('format_currency') ? format_currency($purchaseOrdersStats['total_value']) : number_format($purchaseOrdersStats['total_value'], 2) }}</div>
                    <div class="text-sm text-slate-500 mt-1">القيمة الإجمالية</div>
                </div>
                <div class="p-4 bg-amber-50 rounded-lg text-center">
                    <div class="text-3xl font-bold text-amber-600">{{ $purchaseOrdersStats['pending'] }}</div>
                    <div class="text-sm text-slate-500 mt-1">قيد الانتظار</div>
                </div>
                <div class="p-4 bg-blue-50 rounded-lg text-center">
                    <div class="text-3xl font-bold text-blue-600">{{ $purchaseOrdersStats['completed'] }}</div>
                    <div class="text-sm text-slate-500 mt-1">مكتملة</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Materials by Category --}}
    <div class="intro-y col-span-12 lg:col-span-6">
        <div class="box p-5">
            <h4 class="font-semibold text-slate-700 mb-4">المواد حسب الفئة</h4>
            <canvas id="categoryChart" height="200"></canvas>
        </div>
    </div>
</div>

{{-- Low Stock Alerts --}}
@if($lowStockAlerts->count() > 0)
<div class="mt-5">
    <div class="intro-y box p-5 border-l-4 border-rose-500">
        <h4 class="font-semibold text-rose-600 mb-4 flex items-center gap-2">
            <x-base.lucide icon="alert-triangle" class="w-5 h-5" />
            تنبيهات نقص المخزون
        </h4>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-rose-50">
                        <th class="px-4 py-2 text-right font-medium text-slate-600">المادة</th>
                        <th class="px-4 py-2 text-right font-medium text-slate-600">الفئة</th>
                        <th class="px-4 py-2 text-center font-medium text-slate-600">الكمية الحالية</th>
                        <th class="px-4 py-2 text-center font-medium text-slate-600">الحد الأدنى</th>
                        <th class="px-4 py-2 text-center font-medium text-slate-600">الحالة</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lowStockAlerts as $material)
                    <tr class="border-b border-slate-100">
                        <td class="px-4 py-3 font-medium">{{ $material->name }}</td>
                        <td class="px-4 py-3">{{ $material->category->name ?? 'N/A' }}</td>
                        <td class="px-4 py-3 text-center text-rose-600 font-semibold">{{ $material->quantity }}</td>
                        <td class="px-4 py-3 text-center">{{ $material->minimum_quantity }}</td>
                        <td class="px-4 py-3 text-center">
                            @if($material->quantity == 0)
                            <span class="px-2 py-1 bg-rose-100 text-rose-600 rounded text-xs font-semibold">نفذ</span>
                            @else
                            <span class="px-2 py-1 bg-amber-100 text-amber-600 rounded text-xs font-semibold">منخفض</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

{{-- Top Materials --}}
<div class="mt-5">
    <div class="intro-y box p-5">
        <h4 class="font-semibold text-slate-700 mb-4">أعلى المواد من حيث الكمية</h4>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="px-4 py-2 text-right font-medium text-slate-600">#</th>
                        <th class="px-4 py-2 text-right font-medium text-slate-600">المادة</th>
                        <th class="px-4 py-2 text-right font-medium text-slate-600">الفئة</th>
                        <th class="px-4 py-2 text-center font-medium text-slate-600">الكمية</th>
                        <th class="px-4 py-2 text-left font-medium text-slate-600">القيمة</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topMaterials as $index => $material)
                    <tr class="border-b border-slate-100">
                        <td class="px-4 py-3 text-slate-500">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 font-medium">{{ $material->name }}</td>
                        <td class="px-4 py-3">{{ $material->category->name ?? 'N/A' }}</td>
                        <td class="px-4 py-3 text-center font-semibold">{{ number_format($material->quantity) }}</td>
                        <td class="px-4 py-3 text-emerald-600 font-semibold">{{ function_exists('format_currency') ? format_currency($material->quantity * $material->unit_price) : number_format($material->quantity * $material->unit_price, 2) }}</td>
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
    const categoryData = @json($materialsByCategory);
    
    new Chart(document.getElementById('categoryChart'), {
        type: 'pie',
        data: {
            labels: categoryData.map(c => c.category?.name || 'غير محدد'),
            datasets: [{
                data: categoryData.map(c => c.count),
                backgroundColor: [
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(244, 63, 94, 0.8)',
                    'rgba(139, 92, 246, 0.8)',
                    'rgba(236, 72, 153, 0.8)',
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

@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>{{ __('menu.reports_dashboard') }} - {{ config('app.name') }}</title>
@endsection

@section('subcontent')
@include('components.global-notifications')

<div class="intro-y mt-6 mb-2 flex flex-col gap-1">
    <div class="flex items-baseline justify-between gap-6">
        <h2 class="flex items-center gap-2 text-2xl md:text-3xl font-semibold text-royalDark tracking-wide">
            <x-base.lucide icon="bar-chart-3" class="w-7 h-7" />
            <span>{{ __('menu.reports_dashboard') }}</span>
        </h2>
    </div>
    <p class="text-slate-500 mt-1">نظرة شاملة على أداء الشركة والتقارير المتاحة</p>
</div>

{{-- Quick Stats --}}
<div class="mt-5 grid grid-cols-12 gap-6">
    <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
        <div class="box p-5 bg-gradient-to-br from-emerald-500 to-emerald-600 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-3xl font-bold">{{ function_exists('format_currency') ? format_currency($stats['total_revenue']) : number_format($stats['total_revenue'], 2) }}</div>
                    <div class="text-emerald-100 mt-1">إجمالي الإيرادات</div>
                </div>
                <x-base.lucide icon="trending-up" class="w-12 h-12 opacity-50" />
            </div>
        </div>
    </div>
    <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
        <div class="box p-5 bg-gradient-to-br from-rose-500 to-rose-600 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-3xl font-bold">{{ function_exists('format_currency') ? format_currency($stats['total_expenses']) : number_format($stats['total_expenses'], 2) }}</div>
                    <div class="text-rose-100 mt-1">إجمالي المصروفات</div>
                </div>
                <x-base.lucide icon="trending-down" class="w-12 h-12 opacity-50" />
            </div>
        </div>
    </div>
    <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
        <div class="box p-5 bg-gradient-to-br from-blue-500 to-blue-600 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-3xl font-bold">{{ $stats['total_employees'] }}</div>
                    <div class="text-blue-100 mt-1">الموظفين النشطين</div>
                </div>
                <x-base.lucide icon="users" class="w-12 h-12 opacity-50" />
            </div>
        </div>
    </div>
    <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
        <div class="box p-5 bg-gradient-to-br from-amber-500 to-amber-600 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-3xl font-bold">{{ $stats['pending_tasks'] }}</div>
                    <div class="text-amber-100 mt-1">المهام المعلقة</div>
                </div>
                <x-base.lucide icon="clock" class="w-12 h-12 opacity-50" />
            </div>
        </div>
    </div>
</div>

{{-- Report Categories --}}
<div class="mt-8">
    <h3 class="text-lg font-semibold text-slate-700 mb-4">التقارير المتاحة</h3>
    <div class="grid grid-cols-12 gap-6">
        {{-- Financial Reports --}}
        <div class="intro-y col-span-12 sm:col-span-6 lg:col-span-4">
            <a href="{{ route('reports.financial') }}" class="box p-5 block hover:shadow-lg transition-shadow group">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-xl bg-emerald-100 flex items-center justify-center group-hover:bg-emerald-200 transition-colors">
                        <x-base.lucide icon="trending-up" class="w-7 h-7 text-emerald-600" />
                    </div>
                    <div>
                        <div class="font-semibold text-slate-700 group-hover:text-emerald-600 transition-colors">التقارير المالية</div>
                        <div class="text-sm text-slate-500">الإيرادات، المصروفات، الأرباح</div>
                    </div>
                </div>
                <div class="mt-4 flex flex-wrap gap-2">
                    <span class="px-2 py-1 bg-slate-100 rounded text-xs text-slate-600">الإيرادات</span>
                    <span class="px-2 py-1 bg-slate-100 rounded text-xs text-slate-600">المصروفات</span>
                    <span class="px-2 py-1 bg-slate-100 rounded text-xs text-slate-600">الأرباح</span>
                </div>
            </a>
        </div>

        {{-- HR Reports --}}
        <div class="intro-y col-span-12 sm:col-span-6 lg:col-span-4">
            <a href="{{ route('reports.hr') }}" class="box p-5 block hover:shadow-lg transition-shadow group">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-xl bg-blue-100 flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                        <x-base.lucide icon="users" class="w-7 h-7 text-blue-600" />
                    </div>
                    <div>
                        <div class="font-semibold text-slate-700 group-hover:text-blue-600 transition-colors">تقارير الموارد البشرية</div>
                        <div class="text-sm text-slate-500">الرواتب، الحضور، الإجازات</div>
                    </div>
                </div>
                <div class="mt-4 flex flex-wrap gap-2">
                    <span class="px-2 py-1 bg-slate-100 rounded text-xs text-slate-600">الرواتب</span>
                    <span class="px-2 py-1 bg-slate-100 rounded text-xs text-slate-600">الحضور</span>
                    <span class="px-2 py-1 bg-slate-100 rounded text-xs text-slate-600">الإجازات</span>
                </div>
            </a>
        </div>

        {{-- Inventory Reports --}}
        <div class="intro-y col-span-12 sm:col-span-6 lg:col-span-4">
            <a href="{{ route('reports.inventory') }}" class="box p-5 block hover:shadow-lg transition-shadow group">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-xl bg-amber-100 flex items-center justify-center group-hover:bg-amber-200 transition-colors">
                        <x-base.lucide icon="package" class="w-7 h-7 text-amber-600" />
                    </div>
                    <div>
                        <div class="font-semibold text-slate-700 group-hover:text-amber-600 transition-colors">تقارير المخزون</div>
                        <div class="text-sm text-slate-500">المواد، المشتريات، التنبيهات</div>
                    </div>
                </div>
                <div class="mt-4 flex flex-wrap gap-2">
                    <span class="px-2 py-1 bg-slate-100 rounded text-xs text-slate-600">المواد</span>
                    <span class="px-2 py-1 bg-slate-100 rounded text-xs text-slate-600">المشتريات</span>
                    <span class="px-2 py-1 bg-slate-100 rounded text-xs text-slate-600">النقص</span>
                </div>
            </a>
        </div>

        {{-- Sales Reports --}}
        <div class="intro-y col-span-12 sm:col-span-6 lg:col-span-4">
            <a href="{{ route('reports.sales') }}" class="box p-5 block hover:shadow-lg transition-shadow group">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-xl bg-purple-100 flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                        <x-base.lucide icon="shopping-cart" class="w-7 h-7 text-purple-600" />
                    </div>
                    <div>
                        <div class="font-semibold text-slate-700 group-hover:text-purple-600 transition-colors">تقارير المبيعات</div>
                        <div class="text-sm text-slate-500">الفواتير، العملاء، الاتجاهات</div>
                    </div>
                </div>
                <div class="mt-4 flex flex-wrap gap-2">
                    <span class="px-2 py-1 bg-slate-100 rounded text-xs text-slate-600">الفواتير</span>
                    <span class="px-2 py-1 bg-slate-100 rounded text-xs text-slate-600">العملاء</span>
                    <span class="px-2 py-1 bg-slate-100 rounded text-xs text-slate-600">الاتجاهات</span>
                </div>
            </a>
        </div>

        {{-- Project Reports --}}
        <div class="intro-y col-span-12 sm:col-span-6 lg:col-span-4">
            <a href="{{ route('reports.projects') }}" class="box p-5 block hover:shadow-lg transition-shadow group">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-xl bg-indigo-100 flex items-center justify-center group-hover:bg-indigo-200 transition-colors">
                        <x-base.lucide icon="folder" class="w-7 h-7 text-indigo-600" />
                    </div>
                    <div>
                        <div class="font-semibold text-slate-700 group-hover:text-indigo-600 transition-colors">تقارير المشاريع</div>
                        <div class="text-sm text-slate-500">المشاريع، المهام، التقدم</div>
                    </div>
                </div>
                <div class="mt-4 flex flex-wrap gap-2">
                    <span class="px-2 py-1 bg-slate-100 rounded text-xs text-slate-600">المشاريع</span>
                    <span class="px-2 py-1 bg-slate-100 rounded text-xs text-slate-600">المهام</span>
                    <span class="px-2 py-1 bg-slate-100 rounded text-xs text-slate-600">التقدم</span>
                </div>
            </a>
        </div>

        {{-- Custom Reports --}}
        <div class="intro-y col-span-12 sm:col-span-6 lg:col-span-4">
            <a href="{{ route('reports.custom') }}" class="box p-5 block hover:shadow-lg transition-shadow group border-2 border-dashed border-slate-200 hover:border-slate-300">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-xl bg-slate-100 flex items-center justify-center group-hover:bg-slate-200 transition-colors">
                        <x-base.lucide icon="file-plus" class="w-7 h-7 text-slate-600" />
                    </div>
                    <div>
                        <div class="font-semibold text-slate-700 group-hover:text-slate-800 transition-colors">تقارير مخصصة</div>
                        <div class="text-sm text-slate-500">أنشئ تقريرك الخاص</div>
                    </div>
                </div>
                <div class="mt-4 flex flex-wrap gap-2">
                    <span class="px-2 py-1 bg-slate-100 rounded text-xs text-slate-600">مخصص</span>
                    <span class="px-2 py-1 bg-slate-100 rounded text-xs text-slate-600">تصدير</span>
                    <span class="px-2 py-1 bg-slate-100 rounded text-xs text-slate-600">فلترة</span>
                </div>
            </a>
        </div>
    </div>
</div>

{{-- Recent Activity --}}
<div class="mt-8 grid grid-cols-12 gap-6">
    {{-- Recent Invoices --}}
    <div class="intro-y col-span-12 lg:col-span-4">
        <div class="box p-5">
            <div class="flex items-center justify-between mb-4">
                <h4 class="font-semibold text-slate-700">آخر الفواتير</h4>
                <a href="{{ route('accounting.invoices.index') }}" class="text-sm text-primary hover:underline">عرض الكل</a>
            </div>
            <div class="space-y-3">
                @forelse($recentInvoices as $invoice)
                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                    <div>
                        <div class="font-medium text-slate-700">{{ $invoice->invoice_number ?? 'INV-' . $invoice->id }}</div>
                        <div class="text-sm text-slate-500">{{ $invoice->customer->name ?? 'N/A' }}</div>
                    </div>
                    <div class="text-right">
                        <div class="font-semibold {{ $invoice->status === 'paid' ? 'text-emerald-600' : 'text-amber-600' }}">
                            {{ function_exists('format_currency') ? format_currency($invoice->total) : number_format($invoice->total, 2) }}
                        </div>
                        <div class="text-xs text-slate-400">{{ $invoice->invoice_date?->format('M d') }}</div>
                    </div>
                </div>
                @empty
                <div class="text-center text-slate-400 py-4">لا توجد فواتير</div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Recent Payments --}}
    <div class="intro-y col-span-12 lg:col-span-4">
        <div class="box p-5">
            <div class="flex items-center justify-between mb-4">
                <h4 class="font-semibold text-slate-700">آخر المدفوعات</h4>
                <a href="{{ route('accounting.payment-vouchers.index') }}" class="text-sm text-primary hover:underline">عرض الكل</a>
            </div>
            <div class="space-y-3">
                @forelse($recentPayments as $payment)
                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                    <div>
                        <div class="font-medium text-slate-700">{{ $payment->voucher_number ?? 'PV-' . $payment->id }}</div>
                        <div class="text-sm text-slate-500">{{ Str::limit($payment->description, 20) }}</div>
                    </div>
                    <div class="text-right">
                        <div class="font-semibold text-rose-600">-{{ function_exists('format_currency') ? format_currency($payment->total_amount) : number_format($payment->total_amount, 2) }}</div>
                        <div class="text-xs text-slate-400">{{ $payment->voucher_date?->format('M d') }}</div>
                    </div>
                </div>
                @empty
                <div class="text-center text-slate-400 py-4">لا توجد مدفوعات</div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Recent Receipts --}}
    <div class="intro-y col-span-12 lg:col-span-4">
        <div class="box p-5">
            <div class="flex items-center justify-between mb-4">
                <h4 class="font-semibold text-slate-700">آخر المقبوضات</h4>
                <a href="{{ route('accounting.receipt-vouchers.index') }}" class="text-sm text-primary hover:underline">عرض الكل</a>
            </div>
            <div class="space-y-3">
                @forelse($recentReceipts as $receipt)
                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                    <div>
                        <div class="font-medium text-slate-700">{{ $receipt->voucher_number ?? 'RV-' . $receipt->id }}</div>
                        <div class="text-sm text-slate-500">{{ Str::limit($receipt->description, 20) }}</div>
                    </div>
                    <div class="text-right">
                        <div class="font-semibold text-emerald-600">+{{ function_exists('format_currency') ? format_currency($receipt->total_amount) : number_format($receipt->total_amount, 2) }}</div>
                        <div class="text-xs text-slate-400">{{ $receipt->voucher_date?->format('M d') }}</div>
                    </div>
                </div>
                @empty
                <div class="text-center text-slate-400 py-4">لا توجد مقبوضات</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection

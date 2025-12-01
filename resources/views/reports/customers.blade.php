@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Customer Reports - {{ config('app.name') }}</title>
@endsection

@section('subcontent')
@include('components.global-notifications')

<div class="intro-y mt-6 mb-2 flex flex-col gap-1">
    <div class="flex items-baseline justify-between gap-6">
        <h2 class="flex items-center gap-2 text-2xl md:text-3xl font-semibold text-royalDark tracking-wide">
            <x-base.lucide icon="users" class="w-7 h-7" />
            <span>Customer Reports</span>
        </h2>
        <a href="{{ route('reports.index') }}" class="btn-royal btn-royal--outline btn-royal--sm">
            <x-base.lucide icon="arrow-left" class="w-4 h-4" /> Back
        </a>
    </div>
</div>

{{-- Date Filter --}}
<div class="mt-5 box p-5">
    <form method="GET" action="{{ route('reports.customers') }}" class="flex flex-wrap items-end gap-4">
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">From date</label>
            <input type="date" name="start_date" value="{{ $startDate }}" class="form-control w-40">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">To date</label>
            <input type="date" name="end_date" value="{{ $endDate }}" class="form-control w-40">
        </div>
        <button type="submit" class="btn-royal btn-royal--dark btn-royal--sm">
            <x-base.lucide icon="search" class="w-4 h-4" /> Apply
        </button>
        <div class="flex gap-2 ml-auto">
            <button type="button" onclick="window.print()" class="btn-royal btn-royal--outline btn-royal--sm">
                <x-base.lucide icon="printer" class="w-4 h-4" /> Print
            </button>
        </div>
    </form>
</div>

{{-- Summary Cards --}}
<div class="mt-5 grid grid-cols-12 gap-6">
    <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
        <div class="box p-5">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-slate-100 flex items-center justify-center">
                    <x-base.lucide icon="users" class="w-6 h-6 text-slate-600" />
                </div>
                <div>
                    <div class="text-slate-500 text-sm">Total Customers</div>
                    <div class="text-2xl font-bold text-slate-800">{{ $totalCustomers }}</div>
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
                    <div class="text-slate-500 text-sm">Active</div>
                    <div class="text-2xl font-bold text-emerald-700">{{ $activeCustomers }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
        <div class="box p-5">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-rose-100 flex items-center justify-center">
                    <x-base.lucide icon="pause-circle" class="w-6 h-6 text-rose-600" />
                </div>
                <div>
                    <div class="text-slate-500 text-sm">Inactive</div>
                    <div class="text-2xl font-bold text-rose-700">{{ $inactiveCustomers }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
        <div class="box p-5">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-amber-100 flex items-center justify-center">
                    <x-base.lucide icon="user-plus" class="w-6 h-6 text-amber-600" />
                </div>
                <div>
                    <div class="text-slate-500 text-sm">New in Period</div>
                    <div class="text-2xl font-bold text-amber-700">{{ $newCustomers->count() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Top Customers by Revenue --}}
<div class="mt-5">
    <div class="intro-y box p-5">
        <h4 class="font-semibold text-slate-700 mb-4">Top Customers by Revenue (Selected Period)</h4>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="px-4 py-2 text-right font-medium text-slate-600">#</th>
                        <th class="px-4 py-2 text-right font-medium text-slate-600">Customer</th>
                        <th class="px-4 py-2 text-center font-medium text-slate-600">Invoices</th>
                        <th class="px-4 py-2 text-left font-medium text-slate-600">Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    @php $totalAllRevenue = $topCustomers->sum('total_revenue'); @endphp
                    @forelse($topCustomers as $index => $item)
                        <tr class="border-b border-slate-100">
                            <td class="px-4 py-3 text-slate-500">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 font-medium">
                                {{ $item->customer->code ?? '' }}
                                {{ $item->customer->name ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-3 text-center">{{ $item->invoices_count }}</td>
                            <td class="px-4 py-3 text-emerald-600 font-semibold">{{ number_format($item->total_revenue, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-slate-400">No data for the selected period.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- New Customers in Period --}}
<div class="mt-5">
    <div class="intro-y box p-5">
        <h4 class="font-semibold text-slate-700 mb-4">New Customers in Period</h4>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="px-4 py-2 text-right font-medium text-slate-600">Code</th>
                        <th class="px-4 py-2 text-right font-medium text-slate-600">Name</th>
                        <th class="px-4 py-2 text-center font-medium text-slate-600">Type</th>
                        <th class="px-4 py-2 text-center font-medium text-slate-600">Status</th>
                        <th class="px-4 py-2 text-center font-medium text-slate-600">Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($newCustomers as $customer)
                        <tr class="border-b border-slate-100">
                            <td class="px-4 py-3 font-medium">{{ $customer->code }}</td>
                            <td class="px-4 py-3">{{ $customer->name }}</td>
                            <td class="px-4 py-3 text-center capitalize">{{ $customer->customer_type }}</td>
                            <td class="px-4 py-3 text-center capitalize">{{ $customer->status }}</td>
                            <td class="px-4 py-3 text-center">{{ $customer->created_at?->format('Y-m-d') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-slate-400">No new customers in this period.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

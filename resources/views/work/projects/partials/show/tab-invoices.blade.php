{{-- Invoices Tab --}}
@php
    // Get sale orders as invoices
    try {
        $invoices = \App\Models\Warehouse\SaleOrder::latest()->take(10)->get();
    } catch (\Exception $e) {
        $invoices = collect();
    }
    $totalValue = $invoices->sum('total_amount') ?? 0;
    $paidCount = $invoices->where('status', 'paid')->count();
    $pendingCount = $invoices->where('status', 'pending')->count();
    $overdueCount = $invoices->filter(fn($i) => $i->status === 'pending' && $i->due_date && $i->due_date < now())->count();
@endphp

<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-semibold text-[#303030]">Project Invoices</h2>
            <p class="text-sm text-slate-500 mt-1">Manage billing and invoices</p>
        </div>
        <div class="flex items-center gap-2">
            <button class="h-10 rounded-full px-5 flex items-center justify-center text-xs font-semibold text-slate-600 border border-slate-300 hover:bg-white/80 transition-all">
                <x-base.lucide icon="download" class="w-4 h-4 mr-2" /> Export
            </button>
            <a href="{{ route('warehouse.sale-orders.index') }}" class="h-10 rounded-full px-5 flex items-center justify-center text-xs font-semibold text-white bg-[#303030] hover:bg-[#404040] transition-all">
                <x-base.lucide icon="plus" class="w-4 h-4 mr-2" /> Create Invoice
            </a>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-5 gap-4">
        <div class="rounded-2xl bg-gradient-to-br from-slate-800 to-slate-900 p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="receipt" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">{{ $invoices->count() }}</div>
                    <div class="text-xs text-slate-300 mt-1">Total Invoices</div>
                </div>
            </div>
        </div>
        <div class="rounded-2xl p-5 shadow-lg" style="background: linear-gradient(135deg, #f7e08a 0%, #d49a24 100%);">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/30 flex items-center justify-center">
                    <x-base.lucide icon="clock" class="w-6 h-6 text-[#3a2a1a]" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-[#3a2a1a]">{{ $pendingCount }}</div>
                    <div class="text-xs text-[#5a4a2a] mt-1">Pending</div>
                </div>
            </div>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-green-500 to-green-600 p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="check-circle" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">{{ $paidCount }}</div>
                    <div class="text-xs text-green-100 mt-1">Paid</div>
                </div>
            </div>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-red-500 to-red-600 p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="alert-circle" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">{{ $overdueCount }}</div>
                    <div class="text-xs text-red-100 mt-1">Overdue</div>
                </div>
            </div>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="wallet" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-2xl font-bold text-white">${{ number_format($totalValue/1000, 1) }}K</div>
                    <div class="text-xs text-purple-100 mt-1">Total Value</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Financial Summary --}}
    <div class="grid grid-cols-3 gap-4">
        <div class="rounded-2xl bg-gradient-to-br from-slate-800 to-slate-900 p-6 shadow-lg">
            <div class="flex items-center gap-3 mb-4">
                <div class="h-10 w-10 rounded-lg bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="target" class="w-5 h-5 text-white" />
                </div>
                <div class="text-sm text-slate-400">Project Budget</div>
            </div>
            <div class="text-3xl font-bold text-white">${{ number_format($project->budget ?? 0) }}</div>
            <div class="mt-4 text-xs text-slate-400">Total allocated budget</div>
        </div>
        <div class="rounded-2xl bg-white p-6 shadow-lg border border-slate-200/60">
            <div class="flex items-center gap-3 mb-4">
                <div class="h-10 w-10 rounded-lg bg-blue-100 flex items-center justify-center">
                    <x-base.lucide icon="file-text" class="w-5 h-5 text-blue-600" />
                </div>
                <div class="text-sm text-slate-500">Invoiced Amount</div>
            </div>
            <div class="text-3xl font-bold text-[#303030]">${{ number_format($totalValue) }}</div>
            <div class="mt-4 flex items-center gap-2">
                <div class="flex-1 h-2 bg-slate-200 rounded-full overflow-hidden">
                    <div class="h-full bg-blue-500 rounded-full" style="width: {{ $project->budget > 0 ? min(($totalValue/$project->budget)*100, 100) : 0 }}%"></div>
                </div>
                <span class="text-xs font-medium text-slate-500">{{ $project->budget > 0 ? round(($totalValue/$project->budget)*100) : 0 }}%</span>
            </div>
        </div>
        <div class="rounded-2xl bg-white p-6 shadow-lg border border-slate-200/60">
            <div class="flex items-center gap-3 mb-4">
                <div class="h-10 w-10 rounded-lg bg-green-100 flex items-center justify-center">
                    <x-base.lucide icon="check-circle" class="w-5 h-5 text-green-600" />
                </div>
                <div class="text-sm text-slate-500">Collected Amount</div>
            </div>
            <div class="text-3xl font-bold text-green-600">${{ number_format($invoices->where('status', 'paid')->sum('total_amount') ?? 0) }}</div>
            <div class="mt-4 flex items-center gap-2">
                <div class="flex-1 h-2 bg-slate-200 rounded-full overflow-hidden">
                    <div class="h-full bg-green-500 rounded-full" style="width: {{ $totalValue > 0 ? ($invoices->where('status', 'paid')->sum('total_amount')/$totalValue)*100 : 0 }}%"></div>
                </div>
                <span class="text-xs font-medium text-slate-500">{{ $totalValue > 0 ? round(($invoices->where('status', 'paid')->sum('total_amount')/$totalValue)*100) : 0 }}%</span>
            </div>
        </div>
    </div>

    {{-- Invoices Table --}}
    <div class="rounded-2xl bg-white shadow-lg overflow-hidden border border-slate-200/60">
        <table class="w-full">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Invoice #</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Title</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Date</th>
                    <th class="text-center px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Status</th>
                    <th class="text-right px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Amount</th>
                    <th class="px-6 py-4"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($invoices as $invoice)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <span class="font-mono font-medium text-[#303030]">{{ $invoice->code }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-700">{{ $invoice->title ?? 'Sale Order' }}</td>
                    <td class="px-6 py-4 text-sm text-slate-600">{{ $invoice->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex px-3 py-1.5 rounded-full text-xs font-semibold
                            @if($invoice->status === 'paid' || $invoice->status === 'completed') bg-green-100 text-green-700
                            @elseif($invoice->status === 'pending') bg-amber-100 text-amber-700
                            @else bg-slate-100 text-slate-600 @endif">
                            {{ ucfirst($invoice->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right font-semibold text-slate-700">${{ number_format($invoice->total_amount ?? 0, 2) }}</td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('warehouse.sale-orders.show', $invoice) }}" class="inline-flex items-center justify-center h-8 w-8 rounded-full hover:bg-slate-100 text-slate-400 hover:text-[#303030] transition-all">
                            <x-base.lucide icon="chevron-right" class="w-5 h-5" />
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center">
                        <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-slate-100 mb-4">
                            <x-base.lucide icon="receipt" class="w-8 h-8 text-slate-400" />
                        </div>
                        <p class="text-slate-600 font-medium">No invoices yet</p>
                        <p class="text-sm text-slate-400 mt-1">Create your first invoice</p>
                        <a href="{{ route('warehouse.sale-orders.index') }}" class="inline-flex items-center mt-4 px-5 py-2.5 rounded-full bg-[#303030] text-white text-sm font-semibold hover:bg-[#404040] transition-all">
                            <x-base.lucide icon="plus" class="w-4 h-4 mr-2" /> Create Invoice
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Delivery Notes Tab --}}
@php
    try {
        $deliveryNotes = \App\Models\Warehouse\DeliveryOrder::with('items')->latest()->take(10)->get();
    } catch (\Exception $e) {
        $deliveryNotes = collect();
    }
    $deliveredCount = $deliveryNotes->where('status', 'delivered')->count();
    $pendingCount = $deliveryNotes->where('status', 'pending')->count();
    $totalItems = $deliveryNotes->sum(fn($d) => $d->items->count());
@endphp

<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-semibold text-[#303030]">Delivery Notes</h2>
            <p class="text-sm text-slate-500 mt-1">Track deliveries and shipments</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('warehouse.delivery-orders.index') }}" class="h-10 rounded-full px-5 flex items-center justify-center text-xs font-semibold text-slate-600 border border-slate-300 hover:bg-white/80 transition-all">
                <x-base.lucide icon="external-link" class="w-4 h-4 mr-2" /> View All
            </a>
            <a href="{{ route('warehouse.delivery-orders.index') }}" class="h-10 rounded-full px-5 flex items-center justify-center text-xs font-semibold text-white bg-[#303030] hover:bg-[#404040] transition-all">
                <x-base.lucide icon="plus" class="w-4 h-4 mr-2" /> New Delivery
            </a>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-4 gap-4">
        <div class="rounded-2xl bg-gradient-to-br from-slate-800 to-slate-900 p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="truck" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">{{ $deliveryNotes->count() }}</div>
                    <div class="text-xs text-slate-300 mt-1">Total Deliveries</div>
                </div>
            </div>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-green-500 to-green-600 p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="check-circle" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">{{ $deliveredCount }}</div>
                    <div class="text-xs text-green-100 mt-1">Delivered</div>
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
        <div class="rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="package" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">{{ $totalItems }}</div>
                    <div class="text-xs text-purple-100 mt-1">Total Items</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Delivery Notes Table --}}
    <div class="rounded-2xl bg-white shadow-lg overflow-hidden border border-slate-200/60">
        <table class="w-full">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Delivery #</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Title</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Date</th>
                    <th class="text-center px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Items</th>
                    <th class="text-center px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($deliveryNotes as $note)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <span class="font-mono font-medium text-[#303030]">{{ $note->code }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-700">{{ $note->title ?? 'Delivery Order' }}</td>
                    <td class="px-6 py-4 text-sm text-slate-600">{{ $note->delivery_date?->format('M d, Y') ?? $note->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center justify-center h-7 min-w-[28px] px-2 rounded-full bg-slate-100 text-sm font-medium text-slate-700">
                            {{ $note->items->count() }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex px-3 py-1.5 rounded-full text-xs font-semibold
                            @if($note->status === 'delivered') bg-green-100 text-green-700
                            @elseif($note->status === 'pending') bg-amber-100 text-amber-700
                            @elseif($note->status === 'in_transit') bg-blue-100 text-blue-700
                            @else bg-slate-100 text-slate-600 @endif">
                            {{ ucfirst(str_replace('_', ' ', $note->status ?? 'pending')) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('warehouse.delivery-orders.show', $note) }}" class="inline-flex items-center justify-center h-8 w-8 rounded-full hover:bg-slate-100 text-slate-400 hover:text-[#303030] transition-all">
                            <x-base.lucide icon="chevron-right" class="w-5 h-5" />
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center">
                        <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-slate-100 mb-4">
                            <x-base.lucide icon="truck" class="w-8 h-8 text-slate-400" />
                        </div>
                        <p class="text-slate-600 font-medium">No delivery notes yet</p>
                        <p class="text-sm text-slate-400 mt-1">Create a delivery note to track shipments</p>
                        <a href="{{ route('warehouse.delivery-orders.index') }}" class="inline-flex items-center mt-4 px-5 py-2.5 rounded-full bg-[#303030] text-white text-sm font-semibold hover:bg-[#404040] transition-all">
                            <x-base.lucide icon="plus" class="w-4 h-4 mr-2" /> Create Delivery Note
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

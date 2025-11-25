@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Production Orders - Manufacturing</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('subcontent')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-800">Production Orders</h1>
            <p class="text-sm text-slate-500 mt-1">Manage all production orders</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('manufacturing.index') }}" class="h-10 rounded-full px-5 flex items-center justify-center text-xs font-semibold text-slate-600 border border-slate-300 hover:bg-white/80 transition-all">
                <x-base.lucide icon="arrow-left" class="w-4 h-4 mr-2" /> Back
            </a>
            <a href="{{ route('manufacturing.orders.create') }}" class="h-10 rounded-full px-5 flex items-center justify-center text-xs font-semibold text-white bg-[#303030] hover:bg-[#404040] transition-all">
                <x-base.lucide icon="plus" class="w-4 h-4 mr-2" /> New Order
            </a>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-5 gap-4">
        <div class="rounded-2xl bg-gradient-to-br from-slate-800 to-slate-900 p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="clipboard-list" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">{{ $orders->total() }}</div>
                    <div class="text-xs text-slate-300 mt-1">Total Orders</div>
                </div>
            </div>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="file-text" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">{{ $orders->where('status', 'draft')->count() }}</div>
                    <div class="text-xs text-blue-100 mt-1">Draft</div>
                </div>
            </div>
        </div>
        <div class="rounded-2xl p-5 shadow-lg" style="background: linear-gradient(135deg, #f7e08a 0%, #d49a24 100%);">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/30 flex items-center justify-center">
                    <x-base.lucide icon="loader" class="w-6 h-6 text-[#3a2a1a]" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-[#3a2a1a]">{{ $orders->where('status', 'in_progress')->count() }}</div>
                    <div class="text-xs text-[#5a4a2a] mt-1">In Progress</div>
                </div>
            </div>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-green-500 to-green-600 p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="check-circle" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">{{ $orders->where('status', 'completed')->count() }}</div>
                    <div class="text-xs text-green-100 mt-1">Completed</div>
                </div>
            </div>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-red-500 to-red-600 p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="x-circle" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">{{ $orders->where('status', 'cancelled')->count() }}</div>
                    <div class="text-xs text-red-100 mt-1">Cancelled</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Orders Table --}}
    <div class="rounded-2xl bg-white shadow-lg overflow-hidden border border-slate-200/60">
        <table class="w-full">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Order #</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Product</th>
                    <th class="text-center px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Quantity</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Start Date</th>
                    <th class="text-center px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Priority</th>
                    <th class="text-center px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Status</th>
                    <th class="text-right px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Total Cost</th>
                    <th class="px-6 py-4"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($orders as $order)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <a href="{{ route('manufacturing.orders.show', $order) }}" class="font-mono font-semibold text-[#303030] hover:text-blue-600 transition-colors">{{ $order->order_number }}</a>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-slate-700">{{ $order->product_name }}</div>
                        @if($order->description)
                        <div class="text-xs text-slate-500 mt-0.5 truncate max-w-xs">{{ Str::limit($order->description, 50) }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center font-medium text-slate-700">{{ number_format($order->quantity) }}</td>
                    <td class="px-6 py-4 text-sm text-slate-600">{{ $order->start_date->format('M d, Y') }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex px-3 py-1.5 rounded-full text-xs font-semibold
                            @if($order->priority === 'urgent') bg-red-100 text-red-700
                            @elseif($order->priority === 'high') bg-orange-100 text-orange-700
                            @elseif($order->priority === 'medium') bg-amber-100 text-amber-700
                            @else bg-slate-100 text-slate-600 @endif">
                            {{ ucfirst($order->priority) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex px-3 py-1.5 rounded-full text-xs font-semibold
                            @if($order->status === 'completed') bg-green-100 text-green-700
                            @elseif($order->status === 'in_progress') bg-blue-100 text-blue-700
                            @elseif($order->status === 'confirmed') bg-purple-100 text-purple-700
                            @elseif($order->status === 'cancelled') bg-red-100 text-red-700
                            @else bg-slate-100 text-slate-600 @endif">
                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right font-semibold text-slate-700">${{ number_format($order->total_cost, 2) }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-end gap-1">
                            <a href="{{ route('manufacturing.orders.show', $order) }}" class="h-8 w-8 rounded-full flex items-center justify-center hover:bg-slate-100 text-slate-400 hover:text-blue-600 transition-all" title="View">
                                <x-base.lucide icon="eye" class="w-4 h-4" />
                            </a>
                            <a href="{{ route('manufacturing.orders.edit', $order) }}" class="h-8 w-8 rounded-full flex items-center justify-center hover:bg-slate-100 text-slate-400 hover:text-amber-600 transition-all" title="Edit">
                                <x-base.lucide icon="edit" class="w-4 h-4" />
                            </a>
                            <form action="{{ route('manufacturing.orders.destroy', $order) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="h-8 w-8 rounded-full flex items-center justify-center hover:bg-slate-100 text-slate-400 hover:text-red-600 transition-all" title="Delete">
                                    <x-base.lucide icon="trash-2" class="w-4 h-4" />
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-16 text-center">
                        <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-slate-100 mb-4">
                            <x-base.lucide icon="factory" class="w-8 h-8 text-slate-400" />
                        </div>
                        <p class="text-slate-600 font-medium">No production orders yet</p>
                        <p class="text-sm text-slate-400 mt-1">Create your first production order</p>
                        <a href="{{ route('manufacturing.orders.create') }}" class="inline-flex items-center mt-4 px-5 py-2.5 rounded-full bg-[#303030] text-white text-sm font-semibold hover:bg-[#404040] transition-all">
                            <x-base.lucide icon="plus" class="w-4 h-4 mr-2" /> Create Order
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        @if($orders->hasPages())
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $orders->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

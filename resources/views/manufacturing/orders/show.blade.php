@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>{{ $order->order_number }} - Production Order</title>
@endsection

@section('subcontent')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="font-mono text-sm text-slate-500 bg-slate-100 px-3 py-1 rounded-full">{{ $order->order_number }}</span>
                <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold
                    @if($order->status === 'completed') bg-green-100 text-green-700
                    @elseif($order->status === 'in_progress') bg-blue-100 text-blue-700
                    @elseif($order->status === 'confirmed') bg-purple-100 text-purple-700
                    @elseif($order->status === 'cancelled') bg-red-100 text-red-700
                    @else bg-slate-100 text-slate-600 @endif">
                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                </span>
                <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold
                    @if($order->priority === 'urgent') bg-red-100 text-red-700
                    @elseif($order->priority === 'high') bg-orange-100 text-orange-700
                    @elseif($order->priority === 'medium') bg-amber-100 text-amber-700
                    @else bg-slate-100 text-slate-600 @endif">
                    {{ ucfirst($order->priority) }} Priority
                </span>
            </div>
            <h1 class="text-2xl font-semibold text-slate-800">{{ $order->product_name }}</h1>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('manufacturing.orders.edit', $order) }}" class="h-10 rounded-full px-5 flex items-center justify-center text-xs font-semibold text-slate-600 border border-slate-300 hover:bg-white/80 transition-all">
                <x-base.lucide icon="edit" class="w-4 h-4 mr-2" /> Edit
            </a>
            <a href="{{ route('manufacturing.orders.index') }}" class="h-10 rounded-full px-5 flex items-center justify-center text-xs font-semibold text-white bg-[#303030] hover:bg-[#404040] transition-all">
                <x-base.lucide icon="arrow-left" class="w-4 h-4 mr-2" /> Back
            </a>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-4 gap-4">
        <div class="rounded-2xl bg-gradient-to-br from-slate-800 to-slate-900 p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="package" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">{{ number_format($order->quantity) }}</div>
                    <div class="text-xs text-slate-300 mt-1">Quantity</div>
                </div>
            </div>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="dollar-sign" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-2xl font-bold text-white">${{ number_format($order->unit_cost, 2) }}</div>
                    <div class="text-xs text-blue-100 mt-1">Unit Cost</div>
                </div>
            </div>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-green-500 to-green-600 p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="wallet" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-2xl font-bold text-white">${{ number_format($order->total_cost, 2) }}</div>
                    <div class="text-xs text-green-100 mt-1">Total Cost</div>
                </div>
            </div>
        </div>
        <div class="rounded-2xl p-5 shadow-lg" style="background: linear-gradient(135deg, #f7e08a 0%, #d49a24 100%);">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/30 flex items-center justify-center">
                    <x-base.lucide icon="calendar" class="w-6 h-6 text-[#3a2a1a]" />
                </div>
                <div>
                    <div class="text-lg font-bold text-[#3a2a1a]">{{ $order->start_date->format('M d') }}</div>
                    <div class="text-xs text-[#5a4a2a] mt-1">Start Date</div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-6">
        {{-- Order Details --}}
        <div class="col-span-2 space-y-6">
            <div class="rounded-2xl bg-white shadow-lg border border-slate-200/60 overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-[#303030]">Order Information</h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm text-slate-500">Order Number</dt>
                            <dd class="mt-1 font-mono font-semibold text-slate-800">{{ $order->order_number }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-slate-500">Product Name</dt>
                            <dd class="mt-1 font-semibold text-slate-800">{{ $order->product_name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-slate-500">Start Date</dt>
                            <dd class="mt-1 text-slate-800">{{ $order->start_date->format('F d, Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-slate-500">End Date</dt>
                            <dd class="mt-1 text-slate-800">{{ $order->end_date?->format('F d, Y') ?? 'Not set' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-slate-500">Created By</dt>
                            <dd class="mt-1 text-slate-800">{{ $order->createdBy?->name ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-slate-500">Created At</dt>
                            <dd class="mt-1 text-slate-800">{{ $order->created_at->format('F d, Y H:i') }}</dd>
                        </div>
                    </dl>
                    
                    @if($order->description)
                    <div class="mt-6 pt-6 border-t border-slate-200">
                        <dt class="text-sm text-slate-500 mb-2">Description</dt>
                        <dd class="text-slate-700">{{ $order->description }}</dd>
                    </div>
                    @endif
                    
                    @if($order->notes)
                    <div class="mt-6 pt-6 border-t border-slate-200">
                        <dt class="text-sm text-slate-500 mb-2">Notes</dt>
                        <dd class="text-slate-700">{{ $order->notes }}</dd>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Production Stages --}}
            <div class="rounded-2xl bg-white shadow-lg border border-slate-200/60 overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-[#303030]">Production Stages</h3>
                    <button class="h-8 rounded-full px-4 flex items-center justify-center text-xs font-semibold text-white bg-[#303030] hover:bg-[#404040] transition-all">
                        <x-base.lucide icon="plus" class="w-3 h-3 mr-1" /> Add Stage
                    </button>
                </div>
                <div class="p-6">
                    @if($order->details && $order->details->count() > 0)
                        <div class="space-y-4">
                            @foreach($order->details as $detail)
                            <div class="flex items-center gap-4 p-4 rounded-xl bg-slate-50">
                                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-semibold">
                                    {{ $loop->iteration }}
                                </div>
                                <div class="flex-1">
                                    <div class="font-medium text-slate-800">{{ $detail->stage?->name ?? 'Stage' }}</div>
                                    <div class="text-sm text-slate-500">{{ $detail->completed_quantity }}/{{ $detail->quantity }} completed</div>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if($detail->status === 'completed') bg-green-100 text-green-700
                                    @elseif($detail->status === 'in_progress') bg-blue-100 text-blue-700
                                    @else bg-slate-100 text-slate-600 @endif">
                                    {{ ucfirst($detail->status) }}
                                </span>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <x-base.lucide icon="layers" class="w-12 h-12 mx-auto text-slate-300 mb-3" />
                            <p class="text-slate-500">No production stages added yet</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Materials --}}
            <div class="rounded-2xl bg-white shadow-lg border border-slate-200/60 overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-[#303030]">Materials</h3>
                    <button class="h-8 rounded-full px-4 flex items-center justify-center text-xs font-semibold text-white bg-[#303030] hover:bg-[#404040] transition-all">
                        <x-base.lucide icon="plus" class="w-3 h-3 mr-1" /> Add Material
                    </button>
                </div>
                <div class="p-6">
                    @if($order->materials && $order->materials->count() > 0)
                        <table class="w-full">
                            <thead>
                                <tr class="text-left text-xs text-slate-500 uppercase">
                                    <th class="pb-3">Material</th>
                                    <th class="pb-3 text-center">Required</th>
                                    <th class="pb-3 text-center">Used</th>
                                    <th class="pb-3 text-right">Cost</th>
                                    <th class="pb-3 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($order->materials as $material)
                                <tr>
                                    <td class="py-3 font-medium text-slate-700">{{ $material->material_name }}</td>
                                    <td class="py-3 text-center">{{ $material->required_quantity }}</td>
                                    <td class="py-3 text-center">{{ $material->used_quantity }}</td>
                                    <td class="py-3 text-right">${{ number_format($material->total_cost, 2) }}</td>
                                    <td class="py-3 text-center">
                                        <span class="px-2 py-1 rounded-full text-xs font-medium
                                            @if($material->status === 'used') bg-green-100 text-green-700
                                            @elseif($material->status === 'allocated') bg-blue-100 text-blue-700
                                            @else bg-slate-100 text-slate-600 @endif">
                                            {{ ucfirst($material->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center py-8">
                            <x-base.lucide icon="package" class="w-12 h-12 mx-auto text-slate-300 mb-3" />
                            <p class="text-slate-500">No materials added yet</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Quick Actions --}}
            <div class="rounded-2xl bg-white shadow-lg border border-slate-200/60 overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-[#303030]">Quick Actions</h3>
                </div>
                <div class="p-4 space-y-2">
                    @if($order->status === 'draft')
                    <button class="w-full h-10 rounded-xl flex items-center justify-center text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 transition-all">
                        <x-base.lucide icon="check" class="w-4 h-4 mr-2" /> Confirm Order
                    </button>
                    @endif
                    @if($order->status === 'confirmed')
                    <button class="w-full h-10 rounded-xl flex items-center justify-center text-sm font-semibold text-white bg-green-600 hover:bg-green-700 transition-all">
                        <x-base.lucide icon="play" class="w-4 h-4 mr-2" /> Start Production
                    </button>
                    @endif
                    @if($order->status === 'in_progress')
                    <button class="w-full h-10 rounded-xl flex items-center justify-center text-sm font-semibold text-white bg-green-600 hover:bg-green-700 transition-all">
                        <x-base.lucide icon="check-circle" class="w-4 h-4 mr-2" /> Mark Complete
                    </button>
                    @endif
                    <button class="w-full h-10 rounded-xl flex items-center justify-center text-sm font-semibold text-slate-600 border border-slate-300 hover:bg-slate-50 transition-all">
                        <x-base.lucide icon="printer" class="w-4 h-4 mr-2" /> Print Order
                    </button>
                </div>
            </div>

            {{-- Quality Checks --}}
            <div class="rounded-2xl bg-white shadow-lg border border-slate-200/60 overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-[#303030]">Quality Checks</h3>
                    <span class="text-xs text-slate-500">{{ $order->qualityChecks?->count() ?? 0 }} checks</span>
                </div>
                <div class="p-4">
                    @if($order->qualityChecks && $order->qualityChecks->count() > 0)
                        <div class="space-y-3">
                            @foreach($order->qualityChecks->take(3) as $check)
                            <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50">
                                <div class="h-8 w-8 rounded-full flex items-center justify-center
                                    @if($check->status === 'passed') bg-green-100 text-green-600
                                    @elseif($check->status === 'failed') bg-red-100 text-red-600
                                    @else bg-amber-100 text-amber-600 @endif">
                                    @if($check->status === 'passed')
                                        <x-base.lucide icon="check" class="w-4 h-4" />
                                    @elseif($check->status === 'failed')
                                        <x-base.lucide icon="x" class="w-4 h-4" />
                                    @else
                                        <x-base.lucide icon="clock" class="w-4 h-4" />
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-sm font-medium text-slate-700 truncate">{{ $check->check_name }}</div>
                                    <div class="text-xs text-slate-500">{{ $check->checked_at?->format('M d, Y') }}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-6">
                            <x-base.lucide icon="shield-check" class="w-10 h-10 mx-auto text-slate-300 mb-2" />
                            <p class="text-sm text-slate-500">No quality checks yet</p>
                        </div>
                    @endif
                    <button class="w-full mt-3 h-9 rounded-xl flex items-center justify-center text-xs font-semibold text-slate-600 border border-slate-300 hover:bg-slate-50 transition-all">
                        <x-base.lucide icon="plus" class="w-3 h-3 mr-1" /> Add Check
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

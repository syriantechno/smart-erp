@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>{{ $order->code }} - Manufacturing Order</title>
@endsection

@section('subcontent')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="font-mono text-sm text-slate-500 bg-slate-100 px-3 py-1 rounded-full">{{ $order->code }}</span>
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
            <h1 class="text-2xl font-semibold text-slate-800">{{ $order->bomTemplate->outputMaterial->name ?? 'Manufacturing Order' }}</h1>
            <p class="text-sm text-slate-500 mt-1">Based on: {{ $order->bomTemplate->name ?? 'N/A' }}</p>
        </div>
        <a href="{{ route('manufacturing.mo.index') }}" class="h-10 rounded-full px-5 flex items-center justify-center text-xs font-semibold text-white bg-[#303030] hover:bg-[#404040] transition-all">
            <x-base.lucide icon="arrow-left" class="w-4 h-4 mr-2" /> Back
        </a>
    </div>

    {{-- Progress Card --}}
    <div class="rounded-2xl bg-gradient-to-r from-blue-500 to-blue-600 p-6 shadow-lg text-white">
        <div class="flex items-center justify-between mb-4">
            <div>
                <div class="text-sm text-blue-100">Production Progress</div>
                <div class="text-3xl font-bold">{{ $order->completed_quantity }} / {{ $order->quantity }}</div>
            </div>
            <div class="text-right">
                <div class="text-5xl font-bold">{{ $order->progress_percentage }}%</div>
            </div>
        </div>
        <div class="h-4 bg-white/20 rounded-full overflow-hidden">
            <div class="h-full bg-white rounded-full transition-all duration-500" style="width: {{ $order->progress_percentage }}%"></div>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-4 gap-4">
        <div class="rounded-2xl bg-white p-5 shadow-lg border border-slate-200/60">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-blue-100 flex items-center justify-center">
                    <x-base.lucide icon="target" class="w-6 h-6 text-blue-600" />
                </div>
                <div>
                    <div class="text-2xl font-bold text-slate-800">{{ number_format($order->quantity) }}</div>
                    <div class="text-xs text-slate-500">Target Quantity</div>
                </div>
            </div>
        </div>
        <div class="rounded-2xl bg-white p-5 shadow-lg border border-slate-200/60">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-green-100 flex items-center justify-center">
                    <x-base.lucide icon="check-circle" class="w-6 h-6 text-green-600" />
                </div>
                <div>
                    <div class="text-2xl font-bold text-green-600">{{ number_format($order->completed_quantity) }}</div>
                    <div class="text-xs text-slate-500">Completed</div>
                </div>
            </div>
        </div>
        <div class="rounded-2xl bg-white p-5 shadow-lg border border-slate-200/60">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-amber-100 flex items-center justify-center">
                    <x-base.lucide icon="dollar-sign" class="w-6 h-6 text-amber-600" />
                </div>
                <div>
                    <div class="text-2xl font-bold text-slate-800">${{ number_format($order->estimated_cost, 2) }}</div>
                    <div class="text-xs text-slate-500">Estimated Cost</div>
                </div>
            </div>
        </div>
        <div class="rounded-2xl bg-white p-5 shadow-lg border border-slate-200/60">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-purple-100 flex items-center justify-center">
                    <x-base.lucide icon="calendar" class="w-6 h-6 text-purple-600" />
                </div>
                <div>
                    <div class="text-lg font-bold text-slate-800">{{ $order->planned_start_date->format('M d') }}</div>
                    <div class="text-xs text-slate-500">Planned Start</div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-6">
        {{-- Materials Required --}}
        <div class="col-span-2 rounded-2xl bg-white shadow-lg border border-slate-200/60 overflow-hidden">
            <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-[#303030]">Materials Required</h3>
            </div>
            <div class="p-6">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-xs text-slate-500 uppercase border-b border-slate-200">
                            <th class="pb-3 font-semibold">Material</th>
                            <th class="pb-3 text-center font-semibold">Required</th>
                            <th class="pb-3 text-center font-semibold">Consumed</th>
                            <th class="pb-3 text-center font-semibold">Status</th>
                            <th class="pb-3 text-right font-semibold">Cost</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($order->materials as $material)
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-4">
                                <div class="font-medium text-slate-800">{{ $material->material->name ?? 'N/A' }}</div>
                                <div class="text-xs text-slate-500">{{ $material->material->code ?? '' }}</div>
                            </td>
                            <td class="py-4 text-center font-medium">{{ number_format($material->required_quantity, 2) }}</td>
                            <td class="py-4 text-center">{{ number_format($material->consumed_quantity, 2) }}</td>
                            <td class="py-4 text-center">
                                <span class="inline-flex px-2 py-1 rounded-full text-xs font-medium
                                    @if($material->status === 'consumed') bg-green-100 text-green-700
                                    @elseif($material->status === 'reserved') bg-blue-100 text-blue-700
                                    @else bg-slate-100 text-slate-600 @endif">
                                    {{ ucfirst($material->status) }}
                                </span>
                            </td>
                            <td class="py-4 text-right font-medium">${{ number_format($material->total_cost, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Actions & Info --}}
        <div class="space-y-6">
            {{-- Quick Actions --}}
            <div class="rounded-2xl bg-white shadow-lg border border-slate-200/60 overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-[#303030]">Actions</h3>
                </div>
                <div class="p-4 space-y-2">
                    @if($order->status === 'draft')
                    <form action="{{ route('manufacturing.mo.confirm', $order) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full h-10 rounded-xl flex items-center justify-center text-sm font-semibold text-white bg-purple-600 hover:bg-purple-700 transition-all">
                            <x-base.lucide icon="check" class="w-4 h-4 mr-2" /> Confirm Order
                        </button>
                    </form>
                    @endif
                    
                    @if($order->status === 'confirmed')
                    <form action="{{ route('manufacturing.mo.start', $order) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full h-10 rounded-xl flex items-center justify-center text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 transition-all">
                            <x-base.lucide icon="play" class="w-4 h-4 mr-2" /> Start Production
                        </button>
                    </form>
                    @endif
                    
                    @if($order->status === 'in_progress')
                    <button onclick="document.getElementById('complete-modal').classList.remove('hidden')" class="w-full h-10 rounded-xl flex items-center justify-center text-sm font-semibold text-white bg-green-600 hover:bg-green-700 transition-all">
                        <x-base.lucide icon="check-circle" class="w-4 h-4 mr-2" /> Record Production
                    </button>
                    @endif
                    
                    <button class="w-full h-10 rounded-xl flex items-center justify-center text-sm font-semibold text-slate-600 border border-slate-300 hover:bg-slate-50 transition-all">
                        <x-base.lucide icon="printer" class="w-4 h-4 mr-2" /> Print Order
                    </button>
                </div>
            </div>

            {{-- Warehouses --}}
            <div class="rounded-2xl bg-white shadow-lg border border-slate-200/60 overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-[#303030]">Warehouses</h3>
                </div>
                <div class="p-4 space-y-4">
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-red-50">
                        <div class="h-10 w-10 rounded-lg bg-red-100 flex items-center justify-center">
                            <x-base.lucide icon="log-out" class="w-5 h-5 text-red-600" />
                        </div>
                        <div>
                            <div class="text-xs text-red-600">Source (Materials)</div>
                            <div class="font-medium text-red-800">{{ $order->sourceWarehouse->name ?? 'Not set' }}</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-green-50">
                        <div class="h-10 w-10 rounded-lg bg-green-100 flex items-center justify-center">
                            <x-base.lucide icon="log-in" class="w-5 h-5 text-green-600" />
                        </div>
                        <div>
                            <div class="text-xs text-green-600">Destination (Products)</div>
                            <div class="font-medium text-green-800">{{ $order->destinationWarehouse->name ?? 'Not set' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Info --}}
            <div class="rounded-2xl bg-white shadow-lg border border-slate-200/60 overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-[#303030]">Information</h3>
                </div>
                <div class="p-4 space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Created By</span>
                        <span class="font-medium">{{ $order->createdBy->name ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Created At</span>
                        <span class="font-medium">{{ $order->created_at->format('M d, Y') }}</span>
                    </div>
                    @if($order->approvedBy)
                    <div class="flex justify-between">
                        <span class="text-slate-500">Approved By</span>
                        <span class="font-medium">{{ $order->approvedBy->name }}</span>
                    </div>
                    @endif
                    @if($order->actual_start_date)
                    <div class="flex justify-between">
                        <span class="text-slate-500">Started At</span>
                        <span class="font-medium">{{ $order->actual_start_date->format('M d, Y H:i') }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Production Outputs --}}
    @if($order->outputs->count() > 0)
    <div class="rounded-2xl bg-white shadow-lg border border-slate-200/60 overflow-hidden">
        <div class="px-6 py-4 bg-green-50 border-b border-green-200">
            <h3 class="text-lg font-semibold text-green-800">Production Outputs</h3>
        </div>
        <div class="p-6">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-xs text-slate-500 uppercase border-b border-slate-200">
                        <th class="pb-3 font-semibold">Product</th>
                        <th class="pb-3 text-center font-semibold">Total</th>
                        <th class="pb-3 text-center font-semibold">Good</th>
                        <th class="pb-3 text-center font-semibold">Defects</th>
                        <th class="pb-3 text-center font-semibold">Quality Rate</th>
                        <th class="pb-3 text-left font-semibold">Produced At</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($order->outputs as $output)
                    <tr>
                        <td class="py-4 font-medium text-slate-800">{{ $output->material->name ?? 'N/A' }}</td>
                        <td class="py-4 text-center font-semibold">{{ $output->quantity }}</td>
                        <td class="py-4 text-center text-green-600 font-medium">{{ $output->good_quantity }}</td>
                        <td class="py-4 text-center text-red-600">{{ $output->defect_quantity }}</td>
                        <td class="py-4 text-center">
                            <span class="inline-flex px-2 py-1 rounded-full text-xs font-medium {{ $output->quality_rate >= 95 ? 'bg-green-100 text-green-700' : ($output->quality_rate >= 80 ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700') }}">
                                {{ $output->quality_rate }}%
                            </span>
                        </td>
                        <td class="py-4 text-slate-600">{{ $output->produced_at?->format('M d, Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>

{{-- Complete Production Modal --}}
<div id="complete-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-black/50" onclick="document.getElementById('complete-modal').classList.add('hidden')"></div>
        <div class="relative bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
            <h3 class="text-lg font-semibold text-[#303030] mb-4">Record Production</h3>
            <form action="{{ route('manufacturing.mo.complete', $order) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Good Quantity *</label>
                    <input type="number" name="good_quantity" required min="0" max="{{ $order->quantity - $order->completed_quantity }}"
                        class="w-full h-10 px-3 rounded-lg border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
                    <p class="text-xs text-slate-500 mt-1">Remaining: {{ $order->quantity - $order->completed_quantity }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Defect Quantity</label>
                    <input type="number" name="defect_quantity" value="0" min="0"
                        class="w-full h-10 px-3 rounded-lg border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
                </div>
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" onclick="document.getElementById('complete-modal').classList.add('hidden')" class="h-10 px-5 rounded-full text-sm font-semibold text-slate-600 border border-slate-300 hover:bg-slate-50">Cancel</button>
                    <button type="submit" class="h-10 px-5 rounded-full text-sm font-semibold text-white bg-green-600 hover:bg-green-700">Record</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

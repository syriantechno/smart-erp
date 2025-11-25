@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Quality Control - Manufacturing</title>
@endsection

@section('subcontent')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-800">Quality Control</h1>
            <p class="text-sm text-slate-500 mt-1">Manage quality checks and inspections</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('manufacturing.index') }}" class="h-10 rounded-full px-5 flex items-center justify-center text-xs font-semibold text-slate-600 border border-slate-300 hover:bg-white/80 transition-all">
                <x-base.lucide icon="arrow-left" class="w-4 h-4 mr-2" /> Back
            </a>
            <button onclick="document.getElementById('add-check-modal').classList.remove('hidden')" class="h-10 rounded-full px-5 flex items-center justify-center text-xs font-semibold text-white bg-[#303030] hover:bg-[#404040] transition-all">
                <x-base.lucide icon="plus" class="w-4 h-4 mr-2" /> New Check
            </button>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-4 gap-4">
        <div class="rounded-2xl bg-gradient-to-br from-slate-800 to-slate-900 p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="shield-check" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">{{ $checks->total() }}</div>
                    <div class="text-xs text-slate-300 mt-1">Total Checks</div>
                </div>
            </div>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-green-500 to-green-600 p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="check-circle" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">{{ $checks->where('status', 'passed')->count() }}</div>
                    <div class="text-xs text-green-100 mt-1">Passed</div>
                </div>
            </div>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-red-500 to-red-600 p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="x-circle" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">{{ $checks->where('status', 'failed')->count() }}</div>
                    <div class="text-xs text-red-100 mt-1">Failed</div>
                </div>
            </div>
        </div>
        <div class="rounded-2xl p-5 shadow-lg" style="background: linear-gradient(135deg, #f7e08a 0%, #d49a24 100%);">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/30 flex items-center justify-center">
                    <x-base.lucide icon="clock" class="w-6 h-6 text-[#3a2a1a]" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-[#3a2a1a]">{{ $checks->where('status', 'pending')->count() }}</div>
                    <div class="text-xs text-[#5a4a2a] mt-1">Pending</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Quality Checks Table --}}
    <div class="rounded-2xl bg-white shadow-lg overflow-hidden border border-slate-200/60">
        <table class="w-full">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Check Name</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Order</th>
                    <th class="text-center px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Type</th>
                    <th class="text-center px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Sample Size</th>
                    <th class="text-center px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Defects</th>
                    <th class="text-center px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Status</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Checked By</th>
                    <th class="px-6 py-4"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($checks as $check)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-medium text-[#303030]">{{ $check->check_name }}</div>
                        @if($check->description)
                        <div class="text-xs text-slate-500 mt-0.5 truncate max-w-xs">{{ Str::limit($check->description, 40) }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($check->productionOrder)
                        <a href="{{ route('manufacturing.orders.show', $check->productionOrder) }}" class="font-mono text-sm text-blue-600 hover:underline">
                            {{ $check->productionOrder->order_number }}
                        </a>
                        @else
                        <span class="text-slate-400">—</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex px-2 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600 capitalize">
                            {{ str_replace('_', ' ', $check->check_type) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center font-medium text-slate-700">{{ $check->sample_size ?? '—' }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="font-medium {{ $check->defect_count > 0 ? 'text-red-600' : 'text-green-600' }}">
                            {{ $check->defect_count }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex px-3 py-1.5 rounded-full text-xs font-semibold
                            @if($check->status === 'passed') bg-green-100 text-green-700
                            @elseif($check->status === 'failed') bg-red-100 text-red-700
                            @elseif($check->status === 'rework_required') bg-amber-100 text-amber-700
                            @else bg-slate-100 text-slate-600 @endif">
                            {{ ucfirst(str_replace('_', ' ', $check->status)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-slate-700">{{ $check->checkedBy?->name ?? 'N/A' }}</div>
                        <div class="text-xs text-slate-500">{{ $check->checked_at?->format('M d, Y') }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-end gap-1">
                            <button class="h-8 w-8 rounded-full flex items-center justify-center hover:bg-slate-100 text-slate-400 hover:text-blue-600 transition-all">
                                <x-base.lucide icon="eye" class="w-4 h-4" />
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-16 text-center">
                        <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-slate-100 mb-4">
                            <x-base.lucide icon="shield-check" class="w-8 h-8 text-slate-400" />
                        </div>
                        <p class="text-slate-600 font-medium">No quality checks yet</p>
                        <p class="text-sm text-slate-400 mt-1">Create quality checks for production orders</p>
                        <button onclick="document.getElementById('add-check-modal').classList.remove('hidden')" class="inline-flex items-center mt-4 px-5 py-2.5 rounded-full bg-[#303030] text-white text-sm font-semibold hover:bg-[#404040] transition-all">
                            <x-base.lucide icon="plus" class="w-4 h-4 mr-2" /> New Check
                        </button>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        @if($checks->hasPages())
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $checks->links() }}
        </div>
        @endif
    </div>
</div>

{{-- Add Check Modal --}}
<div id="add-check-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-black/50" onclick="document.getElementById('add-check-modal').classList.add('hidden')"></div>
        <div class="relative bg-white rounded-2xl shadow-xl max-w-lg w-full p-6">
            <h3 class="text-lg font-semibold text-[#303030] mb-4">New Quality Check</h3>
            <form action="{{ route('manufacturing.quality.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Production Order *</label>
                    <select name="production_order_id" required class="w-full h-10 px-3 rounded-lg border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
                        <option value="">Select Order</option>
                        @foreach(\App\Models\Manufacturing\ProductionOrder::where('status', '!=', 'cancelled')->latest()->get() as $order)
                        <option value="{{ $order->id }}">{{ $order->order_number }} - {{ $order->product_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Check Name *</label>
                    <input type="text" name="check_name" required class="w-full h-10 px-3 rounded-lg border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200" placeholder="e.g., Final Inspection">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Check Type *</label>
                        <select name="check_type" required class="w-full h-10 px-3 rounded-lg border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
                            <option value="incoming">Incoming</option>
                            <option value="in_process">In Process</option>
                            <option value="final" selected>Final</option>
                            <option value="random">Random</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Status *</label>
                        <select name="status" required class="w-full h-10 px-3 rounded-lg border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
                            <option value="pending">Pending</option>
                            <option value="passed">Passed</option>
                            <option value="failed">Failed</option>
                            <option value="rework_required">Rework Required</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Sample Size</label>
                        <input type="number" name="sample_size" min="1" class="w-full h-10 px-3 rounded-lg border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Defect Count *</label>
                        <input type="number" name="defect_count" required min="0" value="0" class="w-full h-10 px-3 rounded-lg border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Findings</label>
                    <textarea name="findings" rows="2" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200"></textarea>
                </div>
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" onclick="document.getElementById('add-check-modal').classList.add('hidden')" class="h-10 px-5 rounded-full text-sm font-semibold text-slate-600 border border-slate-300 hover:bg-slate-50">Cancel</button>
                    <button type="submit" class="h-10 px-5 rounded-full text-sm font-semibold text-white bg-[#303030] hover:bg-[#404040]">Save Check</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

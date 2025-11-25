@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>{{ $bom->code }} - BOM Template</title>
@endsection

@section('subcontent')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="font-mono text-sm text-slate-500 bg-slate-100 px-3 py-1 rounded-full">{{ $bom->code }}</span>
                <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold
                    @if($bom->status === 'active') bg-green-100 text-green-700
                    @elseif($bom->status === 'inactive') bg-slate-100 text-slate-600
                    @else bg-amber-100 text-amber-700 @endif">
                    {{ ucfirst($bom->status) }}
                </span>
            </div>
            <h1 class="text-2xl font-semibold text-slate-800">{{ $bom->name }}</h1>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('manufacturing.mo.create', ['bom' => $bom->id]) }}" class="h-10 rounded-full px-5 flex items-center justify-center text-xs font-semibold text-white bg-green-600 hover:bg-green-700 transition-all">
                <x-base.lucide icon="play" class="w-4 h-4 mr-2" /> Create Manufacturing Order
            </a>
            <a href="{{ route('manufacturing.bom.edit', $bom) }}" class="h-10 rounded-full px-5 flex items-center justify-center text-xs font-semibold text-slate-600 border border-slate-300 hover:bg-white/80 transition-all">
                <x-base.lucide icon="edit" class="w-4 h-4 mr-2" /> Edit
            </a>
            <a href="{{ route('manufacturing.bom.index') }}" class="h-10 rounded-full px-5 flex items-center justify-center text-xs font-semibold text-white bg-[#303030] hover:bg-[#404040] transition-all">
                <x-base.lucide icon="arrow-left" class="w-4 h-4 mr-2" /> Back
            </a>
        </div>
    </div>

    {{-- Output Product Card --}}
    <div class="rounded-2xl bg-gradient-to-r from-green-500 to-green-600 p-6 shadow-lg text-white">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="h-16 w-16 rounded-2xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="package-check" class="w-8 h-8 text-white" />
                </div>
                <div>
                    <div class="text-sm text-green-100">Output Product</div>
                    <div class="text-2xl font-bold">{{ $bom->outputMaterial->name ?? 'N/A' }}</div>
                    <div class="text-sm text-green-100 mt-1">{{ $bom->outputMaterial->code ?? '' }}</div>
                </div>
            </div>
            <div class="text-right">
                <div class="text-4xl font-bold">{{ $bom->output_quantity }}</div>
                <div class="text-sm text-green-100">units per batch</div>
            </div>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-4 gap-4">
        <div class="rounded-2xl bg-white p-5 shadow-lg border border-slate-200/60">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-blue-100 flex items-center justify-center">
                    <x-base.lucide icon="list" class="w-6 h-6 text-blue-600" />
                </div>
                <div>
                    <div class="text-2xl font-bold text-slate-800">{{ $bom->components->count() }}</div>
                    <div class="text-xs text-slate-500">Components</div>
                </div>
            </div>
        </div>
        <div class="rounded-2xl bg-white p-5 shadow-lg border border-slate-200/60">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-green-100 flex items-center justify-center">
                    <x-base.lucide icon="dollar-sign" class="w-6 h-6 text-green-600" />
                </div>
                <div>
                    <div class="text-2xl font-bold text-green-600">${{ number_format($bom->total_unit_cost, 2) }}</div>
                    <div class="text-xs text-slate-500">Unit Cost</div>
                </div>
            </div>
        </div>
        <div class="rounded-2xl bg-white p-5 shadow-lg border border-slate-200/60">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-amber-100 flex items-center justify-center">
                    <x-base.lucide icon="clock" class="w-6 h-6 text-amber-600" />
                </div>
                <div>
                    <div class="text-2xl font-bold text-slate-800">{{ $bom->estimated_time_minutes }}</div>
                    <div class="text-xs text-slate-500">Minutes</div>
                </div>
            </div>
        </div>
        <div class="rounded-2xl bg-white p-5 shadow-lg border border-slate-200/60">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-purple-100 flex items-center justify-center">
                    <x-base.lucide icon="factory" class="w-6 h-6 text-purple-600" />
                </div>
                <div>
                    <div class="text-2xl font-bold text-slate-800">{{ $bom->manufacturingOrders->count() }}</div>
                    <div class="text-xs text-slate-500">Orders Created</div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-6">
        {{-- Components List --}}
        <div class="col-span-2 rounded-2xl bg-white shadow-lg border border-slate-200/60 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white">
                <h3 class="text-lg font-semibold flex items-center gap-2">
                    <x-base.lucide icon="list" class="w-5 h-5" />
                    Required Components
                </h3>
            </div>
            <div class="p-6">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-xs text-slate-500 uppercase border-b border-slate-200">
                            <th class="pb-3 font-semibold">#</th>
                            <th class="pb-3 font-semibold">Material</th>
                            <th class="pb-3 text-center font-semibold">Quantity</th>
                            <th class="pb-3 text-center font-semibold">Waste %</th>
                            <th class="pb-3 text-center font-semibold">Actual Qty</th>
                            <th class="pb-3 text-right font-semibold">Unit Cost</th>
                            <th class="pb-3 text-right font-semibold">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($bom->components as $component)
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-4 text-slate-500">{{ $loop->iteration }}</td>
                            <td class="py-4">
                                <div class="font-medium text-slate-800">{{ $component->material->name ?? 'N/A' }}</div>
                                <div class="text-xs text-slate-500">{{ $component->material->code ?? '' }}</div>
                            </td>
                            <td class="py-4 text-center font-medium">{{ $component->quantity }}</td>
                            <td class="py-4 text-center">
                                @if($component->waste_percentage > 0)
                                <span class="text-amber-600">{{ $component->waste_percentage }}%</span>
                                @else
                                <span class="text-slate-400">—</span>
                                @endif
                            </td>
                            <td class="py-4 text-center font-medium text-blue-600">{{ number_format($component->actual_quantity, 4) }}</td>
                            <td class="py-4 text-right text-slate-600">${{ number_format($component->material->price ?? 0, 2) }}</td>
                            <td class="py-4 text-right font-semibold text-green-600">${{ number_format($component->cost, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="border-t-2 border-slate-200">
                        <tr>
                            <td colspan="6" class="py-4 text-right font-semibold text-slate-600">Materials Cost:</td>
                            <td class="py-4 text-right font-bold text-slate-800">${{ number_format($bom->components_cost, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="6" class="py-2 text-right text-slate-500">Labor Cost:</td>
                            <td class="py-2 text-right text-slate-600">${{ number_format($bom->labor_cost, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="6" class="py-2 text-right text-slate-500">Overhead Cost:</td>
                            <td class="py-2 text-right text-slate-600">${{ number_format($bom->overhead_cost, 2) }}</td>
                        </tr>
                        <tr class="bg-slate-50">
                            <td colspan="6" class="py-4 text-right font-bold text-lg text-slate-800">Total Unit Cost:</td>
                            <td class="py-4 text-right font-bold text-lg text-green-600">${{ number_format($bom->total_unit_cost, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Quick Calculator --}}
            <div class="rounded-2xl bg-white shadow-lg border border-slate-200/60 overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-[#303030]">Quick Calculator</h3>
                </div>
                <div class="p-6">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Quantity to Produce</label>
                        <input type="number" id="calc-quantity" value="10" min="1"
                            class="w-full h-11 px-4 rounded-xl border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all"
                            onchange="calculateCost()">
                    </div>
                    <div id="calc-result" class="space-y-3 pt-4 border-t border-slate-200">
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">Materials Cost:</span>
                            <span id="calc-materials" class="font-medium">$0.00</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">Labor Cost:</span>
                            <span id="calc-labor" class="font-medium">$0.00</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">Overhead:</span>
                            <span id="calc-overhead" class="font-medium">$0.00</span>
                        </div>
                        <div class="flex justify-between text-lg pt-3 border-t border-slate-200">
                            <span class="font-semibold text-slate-800">Total Cost:</span>
                            <span id="calc-total" class="font-bold text-green-600">$0.00</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Info --}}
            <div class="rounded-2xl bg-white shadow-lg border border-slate-200/60 overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-[#303030]">Information</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <span class="text-sm text-slate-500">Created By</span>
                        <div class="font-medium text-slate-800">{{ $bom->createdBy->name ?? 'N/A' }}</div>
                    </div>
                    <div>
                        <span class="text-sm text-slate-500">Created At</span>
                        <div class="font-medium text-slate-800">{{ $bom->created_at->format('M d, Y H:i') }}</div>
                    </div>
                    @if($bom->description)
                    <div>
                        <span class="text-sm text-slate-500">Description</span>
                        <div class="text-slate-700 mt-1">{{ $bom->description }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const bomData = {
    componentsCost: {{ $bom->components_cost }},
    laborCost: {{ $bom->labor_cost ?? 0 }},
    overheadCost: {{ $bom->overhead_cost ?? 0 }},
    outputQuantity: {{ $bom->output_quantity }}
};

function calculateCost() {
    const qty = parseInt(document.getElementById('calc-quantity').value) || 0;
    const batches = qty / bomData.outputQuantity;
    
    const materials = bomData.componentsCost * batches;
    const labor = bomData.laborCost * batches;
    const overhead = bomData.overheadCost * batches;
    const total = materials + labor + overhead;
    
    document.getElementById('calc-materials').textContent = '$' + materials.toFixed(2);
    document.getElementById('calc-labor').textContent = '$' + labor.toFixed(2);
    document.getElementById('calc-overhead').textContent = '$' + overhead.toFixed(2);
    document.getElementById('calc-total').textContent = '$' + total.toFixed(2);
}

document.addEventListener('DOMContentLoaded', calculateCost);
</script>
@endsection

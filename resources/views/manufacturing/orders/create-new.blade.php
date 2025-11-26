@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Create Manufacturing Order</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('subcontent')
<div class="max-w-5xl mx-auto space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-800">Create Manufacturing Order</h1>
            <p class="text-sm text-slate-500 mt-1">Start production based on a BOM template</p>
        </div>
        <a href="{{ route('manufacturing.mo.index') }}" class="h-10 rounded-full px-5 flex items-center justify-center text-xs font-semibold text-slate-600 border border-slate-300 hover:bg-white/80 transition-all">
            <x-base.lucide icon="arrow-left" class="w-4 h-4 mr-2" /> Back
        </a>
    </div>

    <form action="{{ route('manufacturing.mo.store') }}" method="POST" class="space-y-6">
        @csrf
        
        {{-- BOM Selection --}}
        <div class="rounded-2xl bg-white shadow-lg border border-slate-200/60 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white">
                <h3 class="text-lg font-semibold flex items-center gap-2">
                    <x-base.lucide icon="layers" class="w-5 h-5" />
                    Select BOM Template
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">BOM Template <span class="text-red-500">*</span></label>
                        <select name="bom_template_id" id="bom-select" required onchange="loadBomDetails()"
                            class="w-full h-11 px-4 rounded-xl border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all">
                            <option value="">Select a BOM template...</option>
                            @foreach($templates as $template)
                            <option value="{{ $template->id }}" {{ request('bom') == $template->id ? 'selected' : '' }}>
                                {{ $template->code }} - {{ $template->name }} ({{ $template->outputMaterial->name ?? 'N/A' }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Quantity to Produce <span class="text-red-500">*</span></label>
                        <input type="number" name="quantity" id="quantity-input" value="{{ old('quantity', 1) }}" required min="1"
                            class="w-full h-11 px-4 rounded-xl border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all"
                            onchange="calculateMaterials()">
                    </div>
                </div>

                {{-- BOM Preview --}}
                <div id="bom-preview" class="mt-6 hidden">
                    <div class="p-4 rounded-xl bg-green-50 border border-green-200">
                        <div class="flex items-center gap-4">
                            <div class="h-12 w-12 rounded-xl bg-green-500 flex items-center justify-center">
                                <x-base.lucide icon="package-check" class="w-6 h-6 text-white" />
                            </div>
                            <div>
                                <div class="text-sm text-green-600">Output Product</div>
                                <div class="text-lg font-semibold text-green-800" id="output-product">-</div>
                            </div>
                            <div class="ml-auto text-right">
                                <div class="text-sm text-green-600">Will Produce</div>
                                <div class="text-2xl font-bold text-green-800" id="output-quantity">0</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Materials Required --}}
        <div class="rounded-2xl bg-white shadow-lg border border-slate-200/60 overflow-hidden">
            <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-[#303030]">Materials Required</h3>
            </div>
            <div class="p-6">
                <div id="materials-loading" class="hidden text-center py-8">
                    <div class="animate-spin h-8 w-8 border-4 border-blue-500 border-t-transparent rounded-full mx-auto"></div>
                    <p class="text-slate-500 mt-2">Calculating materials...</p>
                </div>
                
                <div id="materials-empty" class="text-center py-8 text-slate-500">
                    <x-base.lucide icon="package" class="w-12 h-12 mx-auto text-slate-300 mb-3" />
                    <p>Select a BOM template to see required materials</p>
                </div>

                <table id="materials-table" class="w-full hidden">
                    <thead>
                        <tr class="text-left text-xs text-slate-500 uppercase border-b border-slate-200">
                            <th class="pb-3 font-semibold">Material</th>
                            <th class="pb-3 text-center font-semibold">Required</th>
                            <th class="pb-3 text-center font-semibold">Available</th>
                            <th class="pb-3 text-center font-semibold">Status</th>
                            <th class="pb-3 text-right font-semibold">Cost</th>
                        </tr>
                    </thead>
                    <tbody id="materials-body" class="divide-y divide-slate-100">
                    </tbody>
                    <tfoot class="border-t-2 border-slate-200">
                        <tr>
                            <td colspan="4" class="py-3 text-right text-slate-500">Materials Cost:</td>
                            <td class="py-3 text-right font-semibold" id="materials-cost">$0.00</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="py-2 text-right text-slate-500">Labor Cost:</td>
                            <td class="py-2 text-right" id="labor-cost">$0.00</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="py-2 text-right text-slate-500">Overhead:</td>
                            <td class="py-2 text-right" id="overhead-cost">$0.00</td>
                        </tr>
                        <tr class="bg-slate-50">
                            <td colspan="4" class="py-4 text-right font-bold text-lg">Total Estimated Cost:</td>
                            <td class="py-4 text-right font-bold text-lg text-green-600" id="total-cost">$0.00</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- Order Details --}}
        <div class="rounded-2xl bg-white shadow-lg border border-slate-200/60 overflow-hidden">
            <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-[#303030]">Order Details</h3>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Planned Start Date <span class="text-red-500">*</span></label>
                        <input type="date" name="planned_start_date" value="{{ old('planned_start_date', date('Y-m-d')) }}" required
                            class="w-full h-11 px-4 rounded-xl border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Planned End Date</label>
                        <input type="date" name="planned_end_date" value="{{ old('planned_end_date') }}"
                            class="w-full h-11 px-4 rounded-xl border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all">
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Priority <span class="text-red-500">*</span></label>
                        <select name="priority" required
                            class="w-full h-11 px-4 rounded-xl border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all">
                            <option value="low">Low</option>
                            <option value="medium" selected>Medium</option>
                            <option value="high">High</option>
                            <option value="urgent">Urgent</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Source Warehouse <span class="text-red-500">*</span></label>
                        <select name="source_warehouse_id" required
                            class="w-full h-11 px-4 rounded-xl border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all">
                            <option value="">Select warehouse...</option>
                            @foreach($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-slate-500 mt-1">Where raw materials will be taken from</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Destination Warehouse <span class="text-red-500">*</span></label>
                        <select name="destination_warehouse_id" required
                            class="w-full h-11 px-4 rounded-xl border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all">
                            <option value="">Select warehouse...</option>
                            @foreach($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-slate-500 mt-1">Where finished products will be stored</p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Notes</label>
                    <textarea name="notes" rows="3"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all"
                        placeholder="Additional notes...">{{ old('notes') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('manufacturing.mo.index') }}" class="h-11 rounded-full px-6 flex items-center justify-center text-sm font-semibold text-slate-600 border border-slate-300 hover:bg-white/80 transition-all">
                Cancel
            </a>
            <button type="submit" class="h-11 rounded-full px-6 flex items-center justify-center text-sm font-semibold text-white bg-[#303030] hover:bg-[#404040] transition-all">
                <x-base.lucide icon="factory" class="w-4 h-4 mr-2" /> Create Manufacturing Order
            </button>
        </div>
    </form>
</div>

<script>
function loadBomDetails() {
    const bomId = document.getElementById('bom-select').value;
    if (!bomId) {
        document.getElementById('bom-preview').classList.add('hidden');
        document.getElementById('materials-table').classList.add('hidden');
        document.getElementById('materials-empty').classList.remove('hidden');
        return;
    }
    calculateMaterials();
}

function calculateMaterials() {
    const bomId = document.getElementById('bom-select').value;
    const quantity = document.getElementById('quantity-input').value;
    
    if (!bomId || !quantity) return;
    
    document.getElementById('materials-loading').classList.remove('hidden');
    document.getElementById('materials-empty').classList.add('hidden');
    document.getElementById('materials-table').classList.add('hidden');
    
    fetch('{{ route("manufacturing.mo.calculate") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ bom_template_id: bomId, quantity: quantity })
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('materials-loading').classList.add('hidden');
        document.getElementById('bom-preview').classList.remove('hidden');
        document.getElementById('materials-table').classList.remove('hidden');
        
        // Update output preview
        document.getElementById('output-product').textContent = data.output_product;
        document.getElementById('output-quantity').textContent = data.output_quantity + ' units';
        
        // Update materials table
        const tbody = document.getElementById('materials-body');
        tbody.innerHTML = '';
        
        data.materials.forEach(m => {
            const row = document.createElement('tr');
            row.className = 'hover:bg-slate-50/50';
            row.innerHTML = `
                <td class="py-3">
                    <div class="font-medium text-slate-700">${m.name}</div>
                    <div class="text-xs text-slate-500">${m.code}</div>
                </td>
                <td class="py-3 text-center font-medium">${m.required_quantity}</td>
                <td class="py-3 text-center ${m.sufficient ? 'text-green-600' : 'text-red-600'}">${m.available_quantity}</td>
                <td class="py-3 text-center">
                    ${m.sufficient 
                        ? '<span class="inline-flex items-center text-sm font-semibold text-lime-600"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>Available</span>'
                        : '<span class="inline-flex items-center text-sm font-semibold text-rose-500"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>Insufficient</span>'
                    }
                </td>
                <td class="py-3 text-right font-medium">$${m.total_cost.toFixed(2)}</td>
            `;
            tbody.appendChild(row);
        });
        
        // Update costs
        document.getElementById('materials-cost').textContent = '$' + data.materials_cost.toFixed(2);
        document.getElementById('labor-cost').textContent = '$' + data.labor_cost.toFixed(2);
        document.getElementById('overhead-cost').textContent = '$' + data.overhead_cost.toFixed(2);
        document.getElementById('total-cost').textContent = '$' + data.total_cost.toFixed(2);
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('materials-loading').classList.add('hidden');
        document.getElementById('materials-empty').classList.remove('hidden');
    });
}

// Auto-load if BOM is pre-selected
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('bom-select').value) {
        loadBomDetails();
    }
});
</script>
@endsection

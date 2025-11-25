@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Manufacturing Orders</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('subcontent')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-800">Manufacturing Orders</h1>
            <p class="text-sm text-slate-500 mt-1">Manage production orders based on BOM templates</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('manufacturing.index') }}" class="h-10 rounded-full px-5 flex items-center justify-center text-xs font-semibold text-slate-600 border border-slate-300 hover:bg-white/80 transition-all">
                <x-base.lucide icon="arrow-left" class="w-4 h-4 mr-2" /> Back
            </a>
            <button onclick="openCreateOrderModal()" class="h-10 rounded-full px-5 flex items-center justify-center text-xs font-semibold text-white bg-[#303030] hover:bg-[#404040] transition-all">
                <x-base.lucide icon="plus" class="w-4 h-4 mr-2" /> New Order
            </button>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-4 gap-4">
        <div class="rounded-2xl bg-gradient-to-br from-slate-800 to-slate-900 p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="factory" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">{{ $stats['total'] }}</div>
                    <div class="text-xs text-slate-300 mt-1">Total Orders</div>
                </div>
            </div>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="loader" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">{{ $stats['in_progress'] }}</div>
                    <div class="text-xs text-blue-100 mt-1">In Progress</div>
                </div>
            </div>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-green-500 to-green-600 p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="check-circle" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">{{ $stats['completed'] }}</div>
                    <div class="text-xs text-green-100 mt-1">Completed</div>
                </div>
            </div>
        </div>
        <div class="rounded-2xl p-5 shadow-lg" style="background: linear-gradient(135deg, #f7e08a 0%, #d49a24 100%);">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/30 flex items-center justify-center">
                    <x-base.lucide icon="clock" class="w-6 h-6 text-[#3a2a1a]" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-[#3a2a1a]">{{ $stats['pending'] }}</div>
                    <div class="text-xs text-[#5a4a2a] mt-1">Pending</div>
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
                    <th class="text-center px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Progress</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Planned Date</th>
                    <th class="text-center px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Priority</th>
                    <th class="text-center px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Status</th>
                    <th class="text-right px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Est. Cost</th>
                    <th class="px-6 py-4"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($orders as $order)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <a href="{{ route('manufacturing.mo.show', $order) }}" class="font-mono font-semibold text-[#303030] hover:text-blue-600 transition-colors">
                            {{ $order->code }}
                        </a>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-slate-700">{{ $order->bomTemplate->outputMaterial->name ?? 'N/A' }}</div>
                        <div class="text-xs text-slate-500">{{ $order->bomTemplate->name ?? '' }}</div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="font-semibold text-slate-700">{{ number_format($order->quantity) }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <div class="w-20 h-2 bg-slate-200 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-blue-400 to-blue-600 rounded-full" style="width: {{ $order->progress_percentage }}%"></div>
                            </div>
                            <span class="text-xs font-medium text-slate-600">{{ $order->progress_percentage }}%</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600">{{ $order->planned_start_date->format('M d, Y') }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold
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
                    <td class="px-6 py-4 text-right font-semibold text-slate-700">${{ number_format($order->estimated_cost, 2) }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('manufacturing.mo.show', $order) }}" class="h-8 w-8 rounded-full flex items-center justify-center hover:bg-slate-100 text-slate-400 hover:text-blue-600 transition-all">
                            <x-base.lucide icon="eye" class="w-4 h-4" />
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-6 py-16 text-center">
                        <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-slate-100 mb-4">
                            <x-base.lucide icon="factory" class="w-8 h-8 text-slate-400" />
                        </div>
                        <p class="text-slate-600 font-medium">No manufacturing orders yet</p>
                        <p class="text-sm text-slate-400 mt-1">Create your first order from a BOM template</p>
                        <a href="{{ route('manufacturing.mo.create') }}" class="inline-flex items-center mt-4 px-5 py-2.5 rounded-full bg-[#303030] text-white text-sm font-semibold hover:bg-[#404040] transition-all">
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

{{-- Create Manufacturing Order Modal --}}
<div id="create-order-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 py-8">
        <div class="fixed inset-0 bg-black/50 transition-opacity" onclick="closeCreateOrderModal()"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-hidden">
            {{-- Modal Header --}}
            <div class="px-6 py-4 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white flex items-center justify-between">
                <h3 class="text-lg font-semibold flex items-center gap-2">
                    <x-base.lucide icon="factory" class="w-5 h-5" />
                    Create Manufacturing Order
                </h3>
                <button onclick="closeCreateOrderModal()" class="h-8 w-8 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-all">
                    <x-base.lucide icon="x" class="w-5 h-5" />
                </button>
            </div>
            
            {{-- Modal Body --}}
            <div class="p-6 overflow-y-auto max-h-[calc(90vh-140px)]">
                <form id="create-order-form" class="space-y-5">
                    {{-- BOM Selection --}}
                    <div class="p-4 rounded-xl bg-blue-50 border border-blue-200">
                        <h4 class="font-semibold text-blue-800 mb-3 flex items-center gap-2">
                            <x-base.lucide icon="layers" class="w-5 h-5" />
                            Select BOM Template
                        </h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-blue-700 mb-1">BOM Template <span class="text-red-500">*</span></label>
                                <select name="bom_template_id" id="mo-bom-select" required onchange="loadBomMaterials()"
                                    class="w-full h-10 px-3 rounded-lg border border-blue-300 focus:border-blue-500 text-sm bg-white">
                                    <option value="">Select a BOM template...</option>
                                    @foreach(\App\Models\Manufacturing\BomTemplate::where('status', 'active')->with('outputMaterial')->get() as $bom)
                                    <option value="{{ $bom->id }}" data-product="{{ $bom->outputMaterial->name ?? 'N/A' }}">
                                        {{ $bom->code }} - {{ $bom->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-blue-700 mb-1">Quantity to Produce <span class="text-red-500">*</span></label>
                                <input type="number" name="quantity" id="mo-quantity" value="1" required min="1" onchange="loadBomMaterials()"
                                    class="w-full h-10 px-3 rounded-lg border border-blue-300 focus:border-blue-500 text-sm">
                            </div>
                        </div>
                        
                        {{-- Output Preview --}}
                        <div id="mo-output-preview" class="hidden mt-4 p-3 bg-green-100 rounded-lg border border-green-300">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-lg bg-green-500 flex items-center justify-center">
                                        <x-base.lucide icon="package-check" class="w-5 h-5 text-white" />
                                    </div>
                                    <div>
                                        <div class="text-xs text-green-600">Will Produce</div>
                                        <div class="font-semibold text-green-800" id="mo-output-product">-</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-green-800" id="mo-output-qty">0</div>
                                    <div class="text-xs text-green-600">units</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Materials Preview --}}
                    <div id="mo-materials-section" class="hidden p-4 rounded-xl bg-slate-50 border border-slate-200">
                        <h4 class="font-semibold text-slate-700 mb-3">Materials Required</h4>
                        <div id="mo-materials-list" class="space-y-2 max-h-40 overflow-y-auto">
                            {{-- Materials will be loaded here --}}
                        </div>
                        <div class="mt-3 pt-3 border-t border-slate-200 flex justify-between font-semibold">
                            <span>Estimated Cost:</span>
                            <span id="mo-total-cost" class="text-green-600">$0.00</span>
                        </div>
                    </div>

                    {{-- Order Details --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Planned Start Date <span class="text-red-500">*</span></label>
                            <input type="date" name="planned_start_date" value="{{ date('Y-m-d') }}" required
                                class="w-full h-10 px-3 rounded-lg border border-slate-200 focus:border-emerald-400 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Planned End Date</label>
                            <input type="date" name="planned_end_date"
                                class="w-full h-10 px-3 rounded-lg border border-slate-200 focus:border-emerald-400 text-sm">
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Priority</label>
                            <select name="priority" class="w-full h-10 px-3 rounded-lg border border-slate-200 focus:border-emerald-400 text-sm">
                                <option value="low">Low</option>
                                <option value="medium" selected>Medium</option>
                                <option value="high">High</option>
                                <option value="urgent">Urgent</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Source Warehouse <span class="text-red-500">*</span></label>
                            <select name="source_warehouse_id" required class="w-full h-10 px-3 rounded-lg border border-slate-200 focus:border-emerald-400 text-sm">
                                <option value="">Select...</option>
                                @foreach(\App\Models\Warehouse\Warehouse::where('is_active', true)->get() as $wh)
                                <option value="{{ $wh->id }}">{{ $wh->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Destination Warehouse <span class="text-red-500">*</span></label>
                            <select name="destination_warehouse_id" required class="w-full h-10 px-3 rounded-lg border border-slate-200 focus:border-emerald-400 text-sm">
                                <option value="">Select...</option>
                                @foreach(\App\Models\Warehouse\Warehouse::where('is_active', true)->get() as $wh)
                                <option value="{{ $wh->id }}">{{ $wh->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Notes</label>
                        <textarea name="notes" rows="2" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-emerald-400 text-sm" placeholder="Additional notes..."></textarea>
                    </div>
                </form>
            </div>

            {{-- Modal Footer --}}
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex items-center justify-end gap-3">
                <button type="button" onclick="closeCreateOrderModal()" class="h-10 px-5 rounded-full text-sm font-semibold text-slate-600 border border-slate-300 hover:bg-white transition-all">
                    Cancel
                </button>
                <button type="button" onclick="saveOrder()" id="save-order-btn" class="h-10 px-5 rounded-full text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 transition-all flex items-center gap-2">
                    <x-base.lucide icon="factory" class="w-4 h-4" />
                    <span>Create Order</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function openCreateOrderModal() {
    document.getElementById('create-order-modal').classList.remove('hidden');
    document.getElementById('create-order-form').reset();
    document.getElementById('mo-output-preview').classList.add('hidden');
    document.getElementById('mo-materials-section').classList.add('hidden');
}

function closeCreateOrderModal() {
    document.getElementById('create-order-modal').classList.add('hidden');
}

function loadBomMaterials() {
    const bomId = document.getElementById('mo-bom-select').value;
    const quantity = document.getElementById('mo-quantity').value;
    
    if (!bomId || !quantity) {
        document.getElementById('mo-output-preview').classList.add('hidden');
        document.getElementById('mo-materials-section').classList.add('hidden');
        return;
    }
    
    // Show output preview
    const selectedOption = document.getElementById('mo-bom-select').selectedOptions[0];
    document.getElementById('mo-output-product').textContent = selectedOption.dataset.product || 'Product';
    document.getElementById('mo-output-qty').textContent = quantity;
    document.getElementById('mo-output-preview').classList.remove('hidden');
    
    // Load materials
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
        const list = document.getElementById('mo-materials-list');
        list.innerHTML = '';
        
        data.materials.forEach(m => {
            const div = document.createElement('div');
            div.className = 'flex items-center justify-between py-2 px-3 bg-white rounded-lg text-sm';
            div.innerHTML = `
                <div class="flex items-center gap-2">
                    <span class="${m.sufficient ? 'text-green-600' : 'text-red-600'}">${m.sufficient ? '✓' : '✗'}</span>
                    <span class="font-medium">${m.name}</span>
                </div>
                <div class="text-slate-600">${m.required_quantity} needed (${m.available_quantity} available)</div>
            `;
            list.appendChild(div);
        });
        
        document.getElementById('mo-total-cost').textContent = '$' + data.total_cost.toFixed(2);
        document.getElementById('mo-materials-section').classList.remove('hidden');
    });
}

function saveOrder() {
    const form = document.getElementById('create-order-form');
    const formData = new FormData(form);
    
    // Validate
    if (!formData.get('bom_template_id') || !formData.get('quantity') || !formData.get('source_warehouse_id') || !formData.get('destination_warehouse_id')) {
        showNotification('Please fill all required fields', 'error');
        return;
    }
    
    const data = {
        bom_template_id: formData.get('bom_template_id'),
        quantity: formData.get('quantity'),
        planned_start_date: formData.get('planned_start_date'),
        planned_end_date: formData.get('planned_end_date'),
        priority: formData.get('priority'),
        source_warehouse_id: formData.get('source_warehouse_id'),
        destination_warehouse_id: formData.get('destination_warehouse_id'),
        notes: formData.get('notes')
    };
    
    const btn = document.getElementById('save-order-btn');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Creating...';
    btn.disabled = true;
    
    fetch('{{ route("manufacturing.mo.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        btn.innerHTML = originalText;
        btn.disabled = false;
        
        if (result.success || result.id) {
            showNotification('Manufacturing Order created successfully!', 'success');
            closeCreateOrderModal();
            setTimeout(() => location.reload(), 1000);
        } else {
            showNotification(result.message || 'Error creating order', 'error');
        }
    })
    .catch(error => {
        btn.innerHTML = originalText;
        btn.disabled = false;
        showNotification('Error: ' + error.message, 'error');
    });
}

function showNotification(message, type = 'info') {
    const colors = { success: 'bg-green-500', error: 'bg-red-500', info: 'bg-blue-500' };
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-[100] px-6 py-3 rounded-xl text-white font-medium shadow-lg ${colors[type]}`;
    notification.textContent = message;
    document.body.appendChild(notification);
    setTimeout(() => { notification.style.opacity = '0'; setTimeout(() => notification.remove(), 300); }, 3000);
}
</script>
@endsection

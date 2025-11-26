@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>BOM Templates - Manufacturing</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('subcontent')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-800">Bill of Materials (BOM)</h1>
            <p class="text-sm text-slate-500 mt-1">Define product recipes and material requirements</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('manufacturing.index') }}" class="h-10 rounded-full px-5 flex items-center justify-center text-xs font-semibold text-slate-600 border border-slate-300 hover:bg-white/80 transition-all">
                <x-base.lucide icon="arrow-left" class="w-4 h-4 mr-2" /> Back
            </a>
            <button onclick="openCreateModal()" class="h-10 rounded-full px-5 flex items-center justify-center text-xs font-semibold text-white bg-[#303030] hover:bg-[#404040] transition-all">
                <x-base.lucide icon="plus" class="w-4 h-4 mr-2" /> New BOM
            </button>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-3 gap-4">
        <div class="rounded-2xl bg-gradient-to-br from-slate-800 to-slate-900 p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="layers" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">{{ $stats['total'] }}</div>
                    <div class="text-xs text-slate-300 mt-1">Total Templates</div>
                </div>
            </div>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-green-500 to-green-600 p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="check-circle" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">{{ $stats['active'] }}</div>
                    <div class="text-xs text-green-100 mt-1">Active</div>
                </div>
            </div>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-slate-400 to-slate-500 p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="pause-circle" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">{{ $stats['inactive'] }}</div>
                    <div class="text-xs text-slate-200 mt-1">Inactive</div>
                </div>
            </div>
        </div>
    </div>

    {{-- BOM Templates Grid --}}
    <div class="grid grid-cols-3 gap-6">
        @forelse($templates as $template)
        <div class="rounded-2xl bg-white shadow-lg border border-slate-200/60 overflow-hidden hover:shadow-xl transition-all group">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="h-14 w-14 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg">
                        <x-base.lucide icon="box" class="w-7 h-7 text-white" />
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                        @if($template->status === 'active') bg-green-100 text-green-700
                        @elseif($template->status === 'inactive') bg-slate-100 text-slate-600
                        @else bg-amber-100 text-amber-700 @endif">
                        {{ ucfirst($template->status) }}
                    </span>
                </div>
                
                <div class="mb-2">
                    <span class="font-mono text-xs text-slate-500 bg-slate-100 px-2 py-0.5 rounded">{{ $template->code }}</span>
                </div>
                <h3 class="text-lg font-semibold text-[#303030]">{{ $template->name }}</h3>
                
                @if($template->outputMaterial)
                <div class="mt-2 flex items-center gap-2 text-sm text-slate-600">
                    <x-base.lucide icon="arrow-right" class="w-4 h-4" />
                    <span>Produces: <strong>{{ $template->outputMaterial->name }}</strong></span>
                </div>
                @endif
                
                <div class="mt-4 pt-4 border-t border-slate-100">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-slate-500">Components</span>
                        <span class="font-semibold text-slate-700">{{ $template->components->count() }} items</span>
                    </div>
                    <div class="flex items-center justify-between text-sm mt-2">
                        <span class="text-slate-500">Est. Cost</span>
                        <span class="font-semibold text-green-600">${{ number_format($template->total_unit_cost, 2) }}</span>
                    </div>
                    @if($template->estimated_time_minutes > 0)
                    <div class="flex items-center justify-between text-sm mt-2">
                        <span class="text-slate-500">Est. Time</span>
                        <span class="font-semibold text-slate-700">{{ $template->estimated_time_minutes }} min</span>
                    </div>
                    @endif
                </div>
            </div>
            <div class="px-6 py-3 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
                <a href="{{ route('manufacturing.mo.create', ['bom' => $template->id]) }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700">
                    <x-base.lucide icon="play" class="w-4 h-4 inline mr-1" /> Create Order
                </a>
                <div class="flex items-center gap-1">
                    <a href="{{ route('manufacturing.bom.show', $template) }}" class="h-8 w-8 rounded-full flex items-center justify-center hover:bg-white text-slate-400 hover:text-blue-600 transition-all">
                        <x-base.lucide icon="eye" class="w-4 h-4" />
                    </a>
                    <a href="{{ route('manufacturing.bom.edit', $template) }}" class="h-8 w-8 rounded-full flex items-center justify-center hover:bg-white text-slate-400 hover:text-amber-600 transition-all">
                        <x-base.lucide icon="edit" class="w-4 h-4" />
                    </a>
                    <form action="{{ route('manufacturing.bom.destroy', $template) }}" method="POST" class="inline delete-form" data-name="{{ $template->name }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="h-8 w-8 rounded-full flex items-center justify-center hover:bg-white text-slate-400 hover:text-red-600 transition-all">
                            <x-base.lucide icon="trash-2" class="w-4 h-4" />
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 rounded-2xl bg-white shadow-lg border border-slate-200/60 p-16 text-center">
            <div class="inline-flex items-center justify-center h-20 w-20 rounded-full bg-slate-100 mb-4">
                <x-base.lucide icon="layers" class="w-10 h-10 text-slate-400" />
            </div>
            <h3 class="text-lg font-semibold text-slate-700">No BOM Templates Yet</h3>
            <p class="text-sm text-slate-400 mt-2 max-w-md mx-auto">
                Create your first Bill of Materials template to define product recipes and automate material calculations.
            </p>
            <a href="{{ route('manufacturing.bom.create') }}" class="inline-flex items-center mt-6 px-6 py-3 rounded-full bg-[#303030] text-white text-sm font-semibold hover:bg-[#404040] transition-all">
                <x-base.lucide icon="plus" class="w-4 h-4 mr-2" /> Create First BOM
            </a>
        </div>
        @endforelse
    </div>

    @if($templates->hasPages())
    <div class="flex justify-center">
        {{ $templates->links() }}
    </div>
    @endif
</div>

{{-- Create BOM Modal --}}
<div id="create-bom-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 py-8">
        <div class="fixed inset-0 bg-black/50 transition-opacity" onclick="closeCreateModal()"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
            {{-- Modal Header --}}
            <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white flex items-center justify-between">
                <h3 class="text-lg font-semibold flex items-center gap-2">
                    <x-base.lucide icon="layers" class="w-5 h-5" />
                    Create BOM Template
                </h3>
                <button onclick="closeCreateModal()" class="h-8 w-8 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-all">
                    <x-base.lucide icon="x" class="w-5 h-5" />
                </button>
            </div>
            
            {{-- Modal Body --}}
            <div class="p-6 overflow-y-auto max-h-[calc(90vh-140px)]">
                <form id="create-bom-form" class="space-y-6">
                    {{-- Basic Info --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">BOM Code</label>
                            <input type="text" id="bom-code" name="code" readonly
                                class="w-full h-10 px-3 rounded-lg border border-slate-200 bg-slate-50 text-slate-600 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Template Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" required
                                class="w-full h-10 px-3 rounded-lg border border-slate-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-200 text-sm"
                                placeholder="e.g., Wooden Door Assembly">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Description</label>
                        <textarea name="description" rows="2"
                            class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-200 text-sm"
                            placeholder="Brief description..."></textarea>
                    </div>

                    {{-- Output Product --}}
                    <div class="p-4 rounded-xl bg-green-50 border border-green-200">
                        <h4 class="font-semibold text-green-800 mb-3 flex items-center gap-2">
                            <x-base.lucide icon="package-check" class="w-5 h-5" />
                            Output Product (What You Produce)
                        </h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-green-700 mb-1">Output Product <span class="text-red-500">*</span></label>
                                <select name="output_material_id" required
                                    class="w-full h-10 px-3 rounded-lg border border-green-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 text-sm bg-white">
                                    <option value="">Select finished product...</option>
                                    @foreach(\App\Models\Warehouse\Material::where('is_active', true)->orderBy('name')->get() as $material)
                                    <option value="{{ $material->id }}">{{ $material->code }} - {{ $material->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-green-700 mb-1">Output Quantity <span class="text-red-500">*</span></label>
                                <input type="number" name="output_quantity" value="1" required min="1"
                                    class="w-full h-10 px-3 rounded-lg border border-green-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 text-sm">
                            </div>
                        </div>
                    </div>

                    {{-- Components --}}
                    <div class="p-4 rounded-xl bg-blue-50 border border-blue-200">
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="font-semibold text-blue-800 flex items-center gap-2">
                                <x-base.lucide icon="list" class="w-5 h-5" />
                                Components (Raw Materials)
                            </h4>
                            <button type="button" onclick="addComponentRow()" class="h-8 px-3 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold transition-all">
                                <x-base.lucide icon="plus" class="w-4 h-4 inline mr-1" /> Add
                            </button>
                        </div>
                        <div id="components-container" class="space-y-3">
                            {{-- Component rows will be added here --}}
                        </div>
                        <div id="no-components-msg" class="text-center py-4 text-blue-600 text-sm">
                            Click "Add" to add raw materials
                        </div>
                    </div>

                    {{-- Additional Costs --}}
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Labor Cost ($)</label>
                            <input type="number" name="labor_cost" value="0" min="0" step="0.01"
                                class="w-full h-10 px-3 rounded-lg border border-slate-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-200 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Overhead Cost ($)</label>
                            <input type="number" name="overhead_cost" value="0" min="0" step="0.01"
                                class="w-full h-10 px-3 rounded-lg border border-slate-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-200 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Est. Time (minutes)</label>
                            <input type="number" name="estimated_time_minutes" value="0" min="0"
                                class="w-full h-10 px-3 rounded-lg border border-slate-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-200 text-sm">
                        </div>
                    </div>
                </form>
            </div>

            {{-- Modal Footer --}}
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex items-center justify-end gap-3">
                <button type="button" onclick="closeCreateModal()" class="h-10 px-5 rounded-full text-sm font-semibold text-slate-600 border border-slate-300 hover:bg-white transition-all">
                    Cancel
                </button>
                <button type="button" onclick="saveBom()" id="save-bom-btn" class="h-10 px-5 rounded-full text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition-all flex items-center gap-2">
                    <x-base.lucide icon="save" class="w-4 h-4" />
                    <span>Save</span>
                </button>
            </div>
        </div>
    </div>
</div>

@php
$materialsJson = \App\Models\Warehouse\Material::where('is_active', true)->orderBy('name')->get(['id', 'code', 'name', 'price'])->toJson();
@endphp

<script>
const materials = {!! $materialsJson !!};
let componentIndex = 0;

function openCreateModal() {
    document.getElementById('create-bom-modal').classList.remove('hidden');
    document.getElementById('create-bom-form').reset();
    document.getElementById('components-container').innerHTML = '';
    document.getElementById('no-components-msg').style.display = 'block';
    componentIndex = 0;
    
    // Generate new code
    fetch('{{ route("manufacturing.bom.index") }}')
        .then(() => {
            document.getElementById('bom-code').value = 'BOM-' + String({{ \App\Models\Manufacturing\BomTemplate::count() + 1 }}).padStart(4, '0');
        });
    
    addComponentRow(); // Add first row
}

function closeCreateModal() {
    document.getElementById('create-bom-modal').classList.add('hidden');
}

function addComponentRow() {
    document.getElementById('no-components-msg').style.display = 'none';
    const container = document.getElementById('components-container');
    
    const row = document.createElement('div');
    row.className = 'flex items-center gap-3 p-3 bg-white rounded-lg border border-blue-100 component-row';
    row.innerHTML = `
        <div class="flex-1">
            <select name="components[${componentIndex}][material_id]" required
                class="w-full h-9 px-2 rounded-lg border border-slate-200 focus:border-blue-400 text-sm">
                <option value="">Select material...</option>
                ${materials.map(m => `<option value="${m.id}" data-price="${m.price || 0}">${m.code} - ${m.name}</option>`).join('')}
            </select>
        </div>
        <div class="w-24">
            <input type="number" name="components[${componentIndex}][quantity]" required min="0.0001" step="0.0001" placeholder="Qty"
                class="w-full h-9 px-2 rounded-lg border border-slate-200 focus:border-blue-400 text-sm text-center">
        </div>
        <div class="w-20">
            <input type="number" name="components[${componentIndex}][waste_percentage]" value="0" min="0" max="100" step="0.1" placeholder="Waste%"
                class="w-full h-9 px-2 rounded-lg border border-slate-200 focus:border-blue-400 text-sm text-center">
        </div>
        <button type="button" onclick="removeComponentRow(this)" class="h-9 w-9 rounded-lg flex items-center justify-center text-slate-400 hover:text-red-600 hover:bg-red-50 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    `;
    container.appendChild(row);
    componentIndex++;
}

function removeComponentRow(btn) {
    btn.closest('.component-row').remove();
    if (document.querySelectorAll('.component-row').length === 0) {
        document.getElementById('no-components-msg').style.display = 'block';
    }
}

function saveBom() {
    const form = document.getElementById('create-bom-form');
    const formData = new FormData(form);
    
    // Validate
    if (!formData.get('name') || !formData.get('output_material_id')) {
        showNotification('Please fill all required fields', 'error');
        return;
    }
    
    if (document.querySelectorAll('.component-row').length === 0) {
        showNotification('Please add at least one component', 'error');
        return;
    }
    
    // Build data object
    const data = {
        code: document.getElementById('bom-code').value,
        name: formData.get('name'),
        description: formData.get('description'),
        output_material_id: formData.get('output_material_id'),
        output_quantity: formData.get('output_quantity'),
        labor_cost: formData.get('labor_cost'),
        overhead_cost: formData.get('overhead_cost'),
        estimated_time_minutes: formData.get('estimated_time_minutes'),
        components: []
    };
    
    // Collect components
    document.querySelectorAll('.component-row').forEach((row, index) => {
        const materialSelect = row.querySelector('select[name^="components"]');
        const qtyInput = row.querySelector('input[name*="quantity"]');
        const wasteInput = row.querySelector('input[name*="waste_percentage"]');
        
        if (materialSelect.value && qtyInput.value) {
            data.components.push({
                material_id: materialSelect.value,
                quantity: qtyInput.value,
                waste_percentage: wasteInput.value || 0
            });
        }
    });
    
    // Show loading
    const btn = document.getElementById('save-bom-btn');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Saving...';
    btn.disabled = true;
    
    fetch('{{ route("manufacturing.bom.store") }}', {
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
            showNotification('BOM Template created successfully!', 'success');
            closeCreateModal();
            setTimeout(() => location.reload(), 1000);
        } else {
            showNotification(result.message || 'Error creating BOM', 'error');
        }
    })
    .catch(error => {
        btn.innerHTML = originalText;
        btn.disabled = false;
        showNotification('Error: ' + error.message, 'error');
    });
}

function showNotification(message, type = 'info') {
    const colors = {
        success: 'bg-green-500',
        error: 'bg-red-500',
        info: 'bg-blue-500'
    };
    
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-[100] px-6 py-3 rounded-xl text-white font-medium shadow-lg ${colors[type]} transform transition-all duration-300`;
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.opacity = '0';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Delete confirmation with SweetAlert
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const name = this.dataset.name || 'this BOM template';
            if (typeof window.confirmDelete === 'function') {
                window.confirmDelete(name, () => this.submit());
            } else {
                this.submit();
            }
        });
    });
});
</script>
@endsection

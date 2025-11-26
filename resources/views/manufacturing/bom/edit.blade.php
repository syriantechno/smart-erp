@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Edit {{ $bom->code }} - BOM Template</title>
@endsection

@section('subcontent')
<div class="max-w-5xl mx-auto space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-800">Edit BOM Template</h1>
            <p class="text-sm text-slate-500 mt-1">{{ $bom->code }}</p>
        </div>
        <a href="{{ route('manufacturing.bom.show', $bom) }}" class="h-10 rounded-full px-5 flex items-center justify-center text-xs font-semibold text-slate-600 border border-slate-300 hover:bg-white/80 transition-all">
            <x-base.lucide icon="arrow-left" class="w-4 h-4 mr-2" /> Back
        </a>
    </div>

    <form action="{{ route('manufacturing.bom.update', $bom) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        {{-- Basic Info --}}
        <div class="rounded-2xl bg-white shadow-lg border border-slate-200/60 overflow-hidden">
            <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-[#303030]">Basic Information</h3>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">BOM Code</label>
                        <input type="text" value="{{ $bom->code }}" readonly
                            class="w-full h-11 px-4 rounded-xl border border-slate-200 bg-slate-50 text-slate-600">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Template Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $bom->name) }}" required
                            class="w-full h-11 px-4 rounded-xl border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                        <select name="status" class="w-full h-11 px-4 rounded-xl border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all">
                            <option value="active" {{ $bom->status === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $bom->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="draft" {{ $bom->status === 'draft' ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Description</label>
                    <textarea name="description" rows="2"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all">{{ old('description', $bom->description) }}</textarea>
                </div>
            </div>
        </div>

        {{-- Output Product --}}
        <div class="rounded-2xl bg-white shadow-lg border border-slate-200/60 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-green-500 to-green-600 text-white">
                <h3 class="text-lg font-semibold">Output Product</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Output Product <span class="text-red-500">*</span></label>
                        <select name="output_material_id" required
                            class="w-full h-11 px-4 rounded-xl border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all">
                            @foreach($materials as $material)
                            <option value="{{ $material->id }}" {{ $bom->output_material_id == $material->id ? 'selected' : '' }}>
                                {{ $material->code }} - {{ $material->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Output Quantity <span class="text-red-500">*</span></label>
                        <input type="number" name="output_quantity" value="{{ old('output_quantity', $bom->output_quantity) }}" required min="1"
                            class="w-full h-11 px-4 rounded-xl border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all">
                    </div>
                </div>
            </div>
        </div>

        {{-- Components --}}
        <div class="rounded-2xl bg-white shadow-lg border border-slate-200/60 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white flex items-center justify-between">
                <h3 class="text-lg font-semibold">Components</h3>
                <button type="button" onclick="addComponent()" class="h-8 px-4 rounded-full bg-white/20 hover:bg-white/30 text-sm font-semibold transition-all">
                    <x-base.lucide icon="plus" class="w-4 h-4 inline mr-1" /> Add
                </button>
            </div>
            <div class="p-6">
                <div id="components-container" class="space-y-4">
                    @foreach($bom->components as $index => $component)
                    <div class="flex items-start gap-4 p-4 rounded-xl bg-slate-50 component-row">
                        <div class="flex-1">
                            <label class="block text-xs font-medium text-slate-600 mb-1">Material</label>
                            <select name="components[{{ $index }}][material_id]" required
                                class="w-full h-10 px-3 rounded-lg border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200 text-sm">
                                @foreach($materials as $material)
                                <option value="{{ $material->id }}" {{ $component->material_id == $material->id ? 'selected' : '' }}>
                                    {{ $material->code }} - {{ $material->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-32">
                            <label class="block text-xs font-medium text-slate-600 mb-1">Quantity</label>
                            <input type="number" name="components[{{ $index }}][quantity]" value="{{ $component->quantity }}" required min="0.0001" step="0.0001"
                                class="w-full h-10 px-3 rounded-lg border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200 text-sm">
                        </div>
                        <div class="w-28">
                            <label class="block text-xs font-medium text-slate-600 mb-1">Waste %</label>
                            <input type="number" name="components[{{ $index }}][waste_percentage]" value="{{ $component->waste_percentage }}" min="0" max="100" step="0.1"
                                class="w-full h-10 px-3 rounded-lg border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200 text-sm">
                        </div>
                        <div class="pt-6">
                            <button type="button" onclick="removeComponent(this)" class="h-10 w-10 rounded-lg flex items-center justify-center text-slate-400 hover:text-red-600 hover:bg-red-50 transition-all">
                                <x-base.lucide icon="trash-2" class="w-5 h-5" />
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Additional Costs --}}
        <div class="rounded-2xl bg-white shadow-lg border border-slate-200/60 overflow-hidden">
            <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-[#303030]">Additional Costs & Time</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Labor Cost ($)</label>
                        <input type="number" name="labor_cost" value="{{ old('labor_cost', $bom->labor_cost) }}" min="0" step="0.01"
                            class="w-full h-11 px-4 rounded-xl border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Overhead Cost ($)</label>
                        <input type="number" name="overhead_cost" value="{{ old('overhead_cost', $bom->overhead_cost) }}" min="0" step="0.01"
                            class="w-full h-11 px-4 rounded-xl border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Estimated Time (minutes)</label>
                        <input type="number" name="estimated_time_minutes" value="{{ old('estimated_time_minutes', $bom->estimated_time_minutes) }}" min="0"
                            class="w-full h-11 px-4 rounded-xl border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all">
                    </div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('manufacturing.bom.show', $bom) }}" class="h-11 rounded-full px-6 flex items-center justify-center text-sm font-semibold text-slate-600 border border-slate-300 hover:bg-white/80 transition-all">
                Cancel
            </a>
            <button type="submit" class="h-11 rounded-full px-6 flex items-center justify-center text-sm font-semibold text-white bg-[#303030] hover:bg-[#404040] transition-all">
                <x-base.lucide icon="save" class="w-4 h-4 mr-2" /> Save
            </button>
        </div>
    </form>
</div>

<script>
const materials = @json($materials);
let componentIndex = {{ $bom->components->count() }};

function addComponent() {
    const container = document.getElementById('components-container');
    const row = document.createElement('div');
    row.className = 'flex items-start gap-4 p-4 rounded-xl bg-slate-50 component-row';
    row.innerHTML = `
        <div class="flex-1">
            <label class="block text-xs font-medium text-slate-600 mb-1">Material</label>
            <select name="components[${componentIndex}][material_id]" required
                class="w-full h-10 px-3 rounded-lg border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200 text-sm">
                <option value="">Select material...</option>
                ${materials.map(m => `<option value="${m.id}">${m.code} - ${m.name}</option>`).join('')}
            </select>
        </div>
        <div class="w-32">
            <label class="block text-xs font-medium text-slate-600 mb-1">Quantity</label>
            <input type="number" name="components[${componentIndex}][quantity]" required min="0.0001" step="0.0001"
                class="w-full h-10 px-3 rounded-lg border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200 text-sm">
        </div>
        <div class="w-28">
            <label class="block text-xs font-medium text-slate-600 mb-1">Waste %</label>
            <input type="number" name="components[${componentIndex}][waste_percentage]" value="0" min="0" max="100" step="0.1"
                class="w-full h-10 px-3 rounded-lg border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200 text-sm">
        </div>
        <div class="pt-6">
            <button type="button" onclick="removeComponent(this)" class="h-10 w-10 rounded-lg flex items-center justify-center text-slate-400 hover:text-red-600 hover:bg-red-50 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </button>
        </div>
    `;
    container.appendChild(row);
    componentIndex++;
}

function removeComponent(btn) {
    if (document.querySelectorAll('.component-row').length > 1) {
        btn.closest('.component-row').remove();
    } else {
        alert('At least one component is required');
    }
}
</script>
@endsection

@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Production Machines - Manufacturing</title>
@endsection

@section('subcontent')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-800">Production Machines</h1>
            <p class="text-sm text-slate-500 mt-1">Manage manufacturing equipment</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('manufacturing.index') }}" class="h-10 rounded-full px-5 flex items-center justify-center text-xs font-semibold text-slate-600 border border-slate-300 hover:bg-white/80 transition-all">
                <x-base.lucide icon="arrow-left" class="w-4 h-4 mr-2" /> Back
            </a>
            <button onclick="document.getElementById('add-machine-modal').classList.remove('hidden')" class="h-10 rounded-full px-5 flex items-center justify-center text-xs font-semibold text-white bg-[#303030] hover:bg-[#404040] transition-all">
                <x-base.lucide icon="plus" class="w-4 h-4 mr-2" /> Add Machine
            </button>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-4 gap-4">
        <div class="rounded-2xl bg-gradient-to-br from-slate-800 to-slate-900 p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="settings" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">{{ $machines->total() }}</div>
                    <div class="text-xs text-slate-300 mt-1">Total Machines</div>
                </div>
            </div>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-green-500 to-green-600 p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="check-circle" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">{{ $machines->where('status', 'active')->count() }}</div>
                    <div class="text-xs text-green-100 mt-1">Active</div>
                </div>
            </div>
        </div>
        <div class="rounded-2xl p-5 shadow-lg" style="background: linear-gradient(135deg, #f7e08a 0%, #d49a24 100%);">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/30 flex items-center justify-center">
                    <x-base.lucide icon="wrench" class="w-6 h-6 text-[#3a2a1a]" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-[#3a2a1a]">{{ $machines->where('status', 'maintenance')->count() }}</div>
                    <div class="text-xs text-[#5a4a2a] mt-1">Maintenance</div>
                </div>
            </div>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-red-500 to-red-600 p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="alert-triangle" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">{{ $machines->where('status', 'out_of_order')->count() }}</div>
                    <div class="text-xs text-red-100 mt-1">Out of Order</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Machines Grid --}}
    <div class="grid grid-cols-3 gap-6">
        @forelse($machines as $machine)
        <div class="rounded-2xl bg-white shadow-lg border border-slate-200/60 overflow-hidden hover:shadow-xl transition-all">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="h-14 w-14 rounded-2xl flex items-center justify-center
                        @if($machine->status === 'active') bg-gradient-to-br from-green-400 to-green-600
                        @elseif($machine->status === 'maintenance') bg-gradient-to-br from-amber-400 to-amber-600
                        @else bg-gradient-to-br from-red-400 to-red-600 @endif">
                        <x-base.lucide icon="cog" class="w-7 h-7 text-white" />
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                        @if($machine->status === 'active') bg-green-100 text-green-700
                        @elseif($machine->status === 'maintenance') bg-amber-100 text-amber-700
                        @elseif($machine->status === 'out_of_order') bg-red-100 text-red-700
                        @else bg-slate-100 text-slate-600 @endif">
                        {{ ucfirst(str_replace('_', ' ', $machine->status)) }}
                    </span>
                </div>
                <h3 class="text-lg font-semibold text-[#303030]">{{ $machine->name }}</h3>
                <p class="text-sm text-slate-500 mt-1">{{ $machine->code }}</p>
                
                <div class="mt-4 pt-4 border-t border-slate-100 grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-slate-500">Type</span>
                        <div class="font-medium text-slate-700 capitalize">{{ str_replace('_', ' ', $machine->type) }}</div>
                    </div>
                    <div>
                        <span class="text-slate-500">Hourly Rate</span>
                        <div class="font-medium text-slate-700">${{ number_format($machine->hourly_rate, 2) }}</div>
                    </div>
                    <div>
                        <span class="text-slate-500">Capacity/Hour</span>
                        <div class="font-medium text-slate-700">{{ $machine->capacity_per_hour }} units</div>
                    </div>
                    <div>
                        <span class="text-slate-500">Next Maintenance</span>
                        <div class="font-medium {{ $machine->next_maintenance && $machine->next_maintenance <= now() ? 'text-red-600' : 'text-slate-700' }}">
                            {{ $machine->next_maintenance?->format('M d, Y') ?? 'Not set' }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-6 py-3 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2">
                <button class="h-8 w-8 rounded-full flex items-center justify-center hover:bg-white text-slate-400 hover:text-blue-600 transition-all">
                    <x-base.lucide icon="eye" class="w-4 h-4" />
                </button>
                <button class="h-8 w-8 rounded-full flex items-center justify-center hover:bg-white text-slate-400 hover:text-amber-600 transition-all">
                    <x-base.lucide icon="edit" class="w-4 h-4" />
                </button>
                <form action="{{ route('manufacturing.machines.destroy', $machine) }}" method="POST" class="inline delete-form" data-name="{{ $machine->name }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="h-8 w-8 rounded-full flex items-center justify-center hover:bg-white text-slate-400 hover:text-red-600 transition-all">
                        <x-base.lucide icon="trash-2" class="w-4 h-4" />
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-3 rounded-2xl bg-white shadow-lg border border-slate-200/60 p-16 text-center">
            <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-slate-100 mb-4">
                <x-base.lucide icon="settings" class="w-8 h-8 text-slate-400" />
            </div>
            <p class="text-slate-600 font-medium">No machines added yet</p>
            <p class="text-sm text-slate-400 mt-1">Add your first production machine</p>
            <button onclick="document.getElementById('add-machine-modal').classList.remove('hidden')" class="inline-flex items-center mt-4 px-5 py-2.5 rounded-full bg-[#303030] text-white text-sm font-semibold hover:bg-[#404040] transition-all">
                <x-base.lucide icon="plus" class="w-4 h-4 mr-2" /> Add Machine
            </button>
        </div>
        @endforelse
    </div>

    @if($machines->hasPages())
    <div class="flex justify-center">
        {{ $machines->links() }}
    </div>
    @endif
</div>

{{-- Add Machine Modal --}}
<div id="add-machine-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-black/50" onclick="document.getElementById('add-machine-modal').classList.add('hidden')"></div>
        <div class="relative bg-white rounded-2xl shadow-xl max-w-lg w-full p-6">
            <h3 class="text-lg font-semibold text-[#303030] mb-4">Add New Machine</h3>
            <form action="{{ route('manufacturing.machines.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Name *</label>
                        <input type="text" name="name" required class="w-full h-10 px-3 rounded-lg border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Code *</label>
                        <input type="text" name="code" required class="w-full h-10 px-3 rounded-lg border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Model</label>
                    <input type="text" name="model" class="w-full h-10 px-3 rounded-lg border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Type *</label>
                        <select name="type" required class="w-full h-10 px-3 rounded-lg border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
                            <option value="manual">Manual</option>
                            <option value="semi_automatic">Semi Automatic</option>
                            <option value="automatic">Automatic</option>
                            <option value="cnc">CNC</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Hourly Rate ($) *</label>
                        <input type="number" name="hourly_rate" required min="0" step="0.01" class="w-full h-10 px-3 rounded-lg border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Capacity/Hour *</label>
                        <input type="number" name="capacity_per_hour" required min="1" class="w-full h-10 px-3 rounded-lg border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Purchase Date</label>
                        <input type="date" name="purchase_date" class="w-full h-10 px-3 rounded-lg border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Description</label>
                    <textarea name="description" rows="2" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200"></textarea>
                </div>
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" onclick="document.getElementById('add-machine-modal').classList.add('hidden')" class="h-10 px-5 rounded-full text-sm font-semibold text-slate-600 border border-slate-300 hover:bg-slate-50">Cancel</button>
                    <button type="submit" class="h-10 px-5 rounded-full text-sm font-semibold text-white bg-[#303030] hover:bg-[#404040]">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const name = this.dataset.name || 'this machine';
            if (typeof window.confirmDelete === 'function') {
                window.confirmDelete(name, () => this.submit());
            } else {
                this.submit();
            }
        });
    });
});
</script>
@endpush
@endsection

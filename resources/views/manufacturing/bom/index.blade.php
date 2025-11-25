@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>BOM Templates - Manufacturing</title>
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
            <a href="{{ route('manufacturing.bom.create') }}" class="h-10 rounded-full px-5 flex items-center justify-center text-xs font-semibold text-white bg-[#303030] hover:bg-[#404040] transition-all">
                <x-base.lucide icon="plus" class="w-4 h-4 mr-2" /> New BOM
            </a>
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
                    <form action="{{ route('manufacturing.bom.destroy', $template) }}" method="POST" class="inline" onsubmit="return confirm('Delete this BOM template?')">
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
@endsection

@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Production Stages - Manufacturing</title>
@endsection

@section('subcontent')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-800">Production Stages</h1>
            <p class="text-sm text-slate-500 mt-1">Define manufacturing workflow stages</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('manufacturing.index') }}" class="h-10 rounded-full px-5 flex items-center justify-center text-xs font-semibold text-slate-600 border border-slate-300 hover:bg-white/80 transition-all">
                <x-base.lucide icon="arrow-left" class="w-4 h-4 mr-2" /> Back
            </a>
            <button onclick="document.getElementById('add-stage-modal').classList.remove('hidden')" class="h-10 rounded-full px-5 flex items-center justify-center text-xs font-semibold text-white bg-[#303030] hover:bg-[#404040] transition-all">
                <x-base.lucide icon="plus" class="w-4 h-4 mr-2" /> Add Stage
            </button>
        </div>
    </div>

    {{-- Stages List --}}
    <div class="rounded-2xl bg-white shadow-lg border border-slate-200/60 overflow-hidden">
        <div class="p-6">
            @if($stages->count() > 0)
            <div class="space-y-4">
                @foreach($stages as $stage)
                <div class="flex items-center gap-4 p-4 rounded-xl bg-slate-50 hover:bg-slate-100 transition-all group">
                    <div class="h-12 w-12 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold text-lg shadow-lg">
                        {{ $stage->sequence }}
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <h3 class="font-semibold text-[#303030]">{{ $stage->name }}</h3>
                            @if(!$stage->is_active)
                            <span class="px-2 py-0.5 rounded-full text-xs bg-slate-200 text-slate-600">Inactive</span>
                            @endif
                        </div>
                        <p class="text-sm text-slate-500 mt-0.5">{{ $stage->description ?? 'No description' }}</p>
                    </div>
                    <div class="text-center px-4">
                        <div class="text-lg font-semibold text-slate-700">{{ $stage->estimated_hours }}h</div>
                        <div class="text-xs text-slate-500">Est. Time</div>
                    </div>
                    <div class="text-center px-4">
                        <div class="text-lg font-semibold text-green-600">${{ number_format($stage->stage_cost, 2) }}</div>
                        <div class="text-xs text-slate-500">Cost</div>
                    </div>
                    <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button class="h-8 w-8 rounded-full flex items-center justify-center hover:bg-white text-slate-400 hover:text-amber-600 transition-all">
                            <x-base.lucide icon="edit" class="w-4 h-4" />
                        </button>
                        <form action="{{ route('manufacturing.stages.destroy', $stage->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this stage?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="h-8 w-8 rounded-full flex items-center justify-center hover:bg-white text-slate-400 hover:text-red-600 transition-all">
                                <x-base.lucide icon="trash-2" class="w-4 h-4" />
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-16">
                <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-slate-100 mb-4">
                    <x-base.lucide icon="layers" class="w-8 h-8 text-slate-400" />
                </div>
                <p class="text-slate-600 font-medium">No production stages defined</p>
                <p class="text-sm text-slate-400 mt-1">Create stages to define your manufacturing workflow</p>
                <button onclick="document.getElementById('add-stage-modal').classList.remove('hidden')" class="inline-flex items-center mt-4 px-5 py-2.5 rounded-full bg-[#303030] text-white text-sm font-semibold hover:bg-[#404040] transition-all">
                    <x-base.lucide icon="plus" class="w-4 h-4 mr-2" /> Add Stage
                </button>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Add Stage Modal --}}
<div id="add-stage-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-black/50" onclick="document.getElementById('add-stage-modal').classList.add('hidden')"></div>
        <div class="relative bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
            <h3 class="text-lg font-semibold text-[#303030] mb-4">Add Production Stage</h3>
            <form action="{{ route('manufacturing.stages.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Stage Name *</label>
                    <input type="text" name="name" required class="w-full h-10 px-3 rounded-lg border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200" placeholder="e.g., Assembly">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Description</label>
                    <textarea name="description" rows="2" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200" placeholder="Stage description..."></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Estimated Hours *</label>
                        <input type="number" name="estimated_hours" required min="1" class="w-full h-10 px-3 rounded-lg border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200" placeholder="8">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Stage Cost ($) *</label>
                        <input type="number" name="stage_cost" required min="0" step="0.01" class="w-full h-10 px-3 rounded-lg border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200" placeholder="100.00">
                    </div>
                </div>
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" onclick="document.getElementById('add-stage-modal').classList.add('hidden')" class="h-10 px-5 rounded-full text-sm font-semibold text-slate-600 border border-slate-300 hover:bg-slate-50">Cancel</button>
                    <button type="submit" class="h-10 px-5 rounded-full text-sm font-semibold text-white bg-[#303030] hover:bg-[#404040]">Add Stage</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

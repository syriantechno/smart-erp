{{-- Risks Tab --}}
@php
    // Sample risks data
    $risks = [
        ['name' => 'Budget Overrun', 'category' => 'Financial', 'probability' => 'medium', 'impact' => 'high', 'status' => 'active', 'mitigation' => 'Regular budget reviews and cost tracking'],
        ['name' => 'Schedule Delay', 'category' => 'Schedule', 'probability' => 'high', 'impact' => 'medium', 'status' => 'monitoring', 'mitigation' => 'Buffer time in schedule, regular progress tracking'],
        ['name' => 'Resource Shortage', 'category' => 'Resource', 'probability' => 'low', 'impact' => 'high', 'status' => 'mitigated', 'mitigation' => 'Cross-training team members, backup resources identified'],
    ];
    $criticalCount = collect($risks)->filter(fn($r) => $r['probability'] === 'high' && $r['impact'] === 'high')->count();
    $highCount = collect($risks)->filter(fn($r) => $r['probability'] === 'high' || $r['impact'] === 'high')->count();
    $mitigatedCount = collect($risks)->where('status', 'mitigated')->count();
@endphp

<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-semibold text-[#303030]">Risk Management</h2>
            <p class="text-sm text-slate-500 mt-1">Identify, assess, and mitigate project risks</p>
        </div>
        <button class="h-10 rounded-full px-5 flex items-center justify-center text-xs font-semibold text-white bg-[#303030] hover:bg-[#404040] transition-all">
            <x-base.lucide icon="plus" class="w-4 h-4 mr-2" /> Add Risk
        </button>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-4 gap-4">
        <div class="rounded-2xl bg-gradient-to-br from-slate-800 to-slate-900 p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="shield" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">{{ count($risks) }}</div>
                    <div class="text-xs text-slate-300 mt-1">Total Risks</div>
                </div>
            </div>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-red-500 to-red-600 p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="alert-octagon" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">{{ $criticalCount }}</div>
                    <div class="text-xs text-red-100 mt-1">Critical</div>
                </div>
            </div>
        </div>
        <div class="rounded-2xl p-5 shadow-lg" style="background: linear-gradient(135deg, #f7e08a 0%, #d49a24 100%);">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/30 flex items-center justify-center">
                    <x-base.lucide icon="alert-triangle" class="w-6 h-6 text-[#3a2a1a]" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-[#3a2a1a]">{{ $highCount }}</div>
                    <div class="text-xs text-[#5a4a2a] mt-1">High Priority</div>
                </div>
            </div>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-green-500 to-green-600 p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="shield-check" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">{{ $mitigatedCount }}</div>
                    <div class="text-xs text-green-100 mt-1">Mitigated</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Risk Matrix --}}
    <div class="grid grid-cols-3 gap-6">
        <div class="col-span-2 rounded-2xl bg-white p-6 shadow-lg border border-slate-200/60">
            <h3 class="text-lg font-semibold text-[#303030] mb-4">Risk Matrix</h3>
            <div class="grid grid-cols-5 gap-1 text-center text-xs">
                <div class="p-2"></div>
                <div class="p-2 font-semibold text-slate-600">Rare</div>
                <div class="p-2 font-semibold text-slate-600">Unlikely</div>
                <div class="p-2 font-semibold text-slate-600">Possible</div>
                <div class="p-2 font-semibold text-slate-600">Likely</div>
                
                <div class="p-2 font-semibold text-slate-600 text-right">Critical</div>
                <div class="h-12 rounded-lg bg-amber-300 flex items-center justify-center font-medium">M</div>
                <div class="h-12 rounded-lg bg-red-300 flex items-center justify-center font-medium">H</div>
                <div class="h-12 rounded-lg bg-red-400 flex items-center justify-center font-medium text-white">H</div>
                <div class="h-12 rounded-lg bg-red-500 flex items-center justify-center font-medium text-white">C</div>
                
                <div class="p-2 font-semibold text-slate-600 text-right">High</div>
                <div class="h-12 rounded-lg bg-green-200 flex items-center justify-center font-medium">L</div>
                <div class="h-12 rounded-lg bg-amber-300 flex items-center justify-center font-medium">M</div>
                <div class="h-12 rounded-lg bg-red-300 flex items-center justify-center font-medium">H</div>
                <div class="h-12 rounded-lg bg-red-400 flex items-center justify-center font-medium text-white">H</div>
                
                <div class="p-2 font-semibold text-slate-600 text-right">Medium</div>
                <div class="h-12 rounded-lg bg-green-100 flex items-center justify-center font-medium">L</div>
                <div class="h-12 rounded-lg bg-green-200 flex items-center justify-center font-medium">L</div>
                <div class="h-12 rounded-lg bg-amber-300 flex items-center justify-center font-medium">M</div>
                <div class="h-12 rounded-lg bg-red-300 flex items-center justify-center font-medium">H</div>
                
                <div class="p-2 font-semibold text-slate-600 text-right">Low</div>
                <div class="h-12 rounded-lg bg-green-50 flex items-center justify-center font-medium text-slate-500">Min</div>
                <div class="h-12 rounded-lg bg-green-100 flex items-center justify-center font-medium">L</div>
                <div class="h-12 rounded-lg bg-green-200 flex items-center justify-center font-medium">L</div>
                <div class="h-12 rounded-lg bg-amber-300 flex items-center justify-center font-medium">M</div>
            </div>
            <div class="mt-4 flex justify-center gap-4 text-xs">
                <span class="flex items-center gap-1.5"><span class="w-4 h-4 rounded bg-green-100"></span> Low</span>
                <span class="flex items-center gap-1.5"><span class="w-4 h-4 rounded bg-amber-300"></span> Medium</span>
                <span class="flex items-center gap-1.5"><span class="w-4 h-4 rounded bg-red-300"></span> High</span>
                <span class="flex items-center gap-1.5"><span class="w-4 h-4 rounded bg-red-500"></span> Critical</span>
            </div>
        </div>

        {{-- Project Risk Notes --}}
        <div class="rounded-2xl bg-gradient-to-br from-amber-50 to-amber-100 p-6 shadow-lg border border-amber-200">
            <div class="flex items-start gap-3 mb-4">
                <div class="h-10 w-10 rounded-lg bg-amber-200 flex items-center justify-center">
                    <x-base.lucide icon="alert-triangle" class="w-5 h-5 text-amber-700" />
                </div>
                <div>
                    <h4 class="font-semibold text-amber-800">Risk Notes</h4>
                    <p class="text-xs text-amber-600 mt-1">Project-specific concerns</p>
                </div>
            </div>
            <p class="text-sm text-amber-800 leading-relaxed">{{ $project->risks ?? 'No specific risk notes documented for this project. Add risk notes in project settings.' }}</p>
        </div>
    </div>

    {{-- Risks Table --}}
    <div class="rounded-2xl bg-white shadow-lg overflow-hidden border border-slate-200/60">
        <table class="w-full">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Risk</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Category</th>
                    <th class="text-center px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Probability</th>
                    <th class="text-center px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Impact</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Mitigation</th>
                    <th class="text-center px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($risks as $risk)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4 font-medium text-[#303030]">{{ $risk['name'] }}</td>
                    <td class="px-6 py-4 text-sm text-slate-600">{{ $risk['category'] }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex px-3 py-1.5 rounded-full text-xs font-semibold
                            @if($risk['probability'] === 'high') bg-red-100 text-red-700
                            @elseif($risk['probability'] === 'medium') bg-amber-100 text-amber-700
                            @else bg-green-100 text-green-700 @endif">
                            {{ ucfirst($risk['probability']) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex px-3 py-1.5 rounded-full text-xs font-semibold
                            @if($risk['impact'] === 'high') bg-red-100 text-red-700
                            @elseif($risk['impact'] === 'medium') bg-amber-100 text-amber-700
                            @else bg-green-100 text-green-700 @endif">
                            {{ ucfirst($risk['impact']) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600 max-w-xs truncate">{{ $risk['mitigation'] }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex px-3 py-1.5 rounded-full text-xs font-semibold
                            @if($risk['status'] === 'mitigated') bg-green-100 text-green-700
                            @elseif($risk['status'] === 'monitoring') bg-blue-100 text-blue-700
                            @else bg-amber-100 text-amber-700 @endif">
                            {{ ucfirst($risk['status']) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

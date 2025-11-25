{{-- Costs Tab --}}
@php
    $budget = $project->budget ?? 0;
    $actualCost = $project->actual_cost ?? 0;
    $budgetUsed = $budget > 0 ? round(($actualCost / $budget) * 100) : 0;
    $remaining = max(0, $budget - $actualCost);
    
    // Sample cost breakdown
    $costBreakdown = [
        ['category' => 'Labor', 'amount' => $actualCost * 0.45, 'percentage' => 45, 'color' => 'blue'],
        ['category' => 'Materials', 'amount' => $actualCost * 0.30, 'percentage' => 30, 'color' => 'green'],
        ['category' => 'Equipment', 'amount' => $actualCost * 0.15, 'percentage' => 15, 'color' => 'purple'],
        ['category' => 'Other', 'amount' => $actualCost * 0.10, 'percentage' => 10, 'color' => 'amber'],
    ];
@endphp

<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-semibold text-[#303030]">Cost Management</h2>
            <p class="text-sm text-slate-500 mt-1">Track budget and expenses</p>
        </div>
        <div class="flex items-center gap-2">
            <button class="h-10 rounded-full px-5 flex items-center justify-center text-xs font-semibold text-slate-600 border border-slate-300 hover:bg-white/80 transition-all">
                <x-base.lucide icon="download" class="w-4 h-4 mr-2" /> Export Report
            </button>
            <button class="h-10 rounded-full px-5 flex items-center justify-center text-xs font-semibold text-white bg-[#303030] hover:bg-[#404040] transition-all">
                <x-base.lucide icon="plus" class="w-4 h-4 mr-2" /> Add Expense
            </button>
        </div>
    </div>

    {{-- Main Budget Cards --}}
    <div class="grid grid-cols-4 gap-4">
        <div class="rounded-2xl bg-gradient-to-br from-slate-800 to-slate-900 p-6 shadow-lg">
            <div class="flex items-center gap-4 mb-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="target" class="w-6 h-6 text-white" />
                </div>
                <div class="text-sm text-slate-400">Total Budget</div>
            </div>
            <div class="text-3xl font-bold text-white">${{ number_format($budget) }}</div>
            <div class="mt-3 text-xs text-slate-400">Allocated budget for project</div>
        </div>
        <div class="rounded-2xl p-6 shadow-lg" style="background: linear-gradient(135deg, #f7e08a 0%, #d49a24 100%);">
            <div class="flex items-center gap-4 mb-4">
                <div class="h-12 w-12 rounded-xl bg-white/30 flex items-center justify-center">
                    <x-base.lucide icon="trending-up" class="w-6 h-6 text-[#3a2a1a]" />
                </div>
                <div class="text-sm text-[#5a4a2a]">Spent</div>
            </div>
            <div class="text-3xl font-bold text-[#3a2a1a]">${{ number_format($actualCost) }}</div>
            <div class="mt-3 h-2 bg-white/40 rounded-full overflow-hidden">
                <div class="h-full bg-[#3a2a1a] rounded-full" style="width: {{ $budgetUsed }}%"></div>
            </div>
            <div class="mt-2 text-xs text-[#5a4a2a]">{{ $budgetUsed }}% of budget used</div>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-green-500 to-green-600 p-6 shadow-lg">
            <div class="flex items-center gap-4 mb-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="wallet" class="w-6 h-6 text-white" />
                </div>
                <div class="text-sm text-green-100">Remaining</div>
            </div>
            <div class="text-3xl font-bold text-white">${{ number_format($remaining) }}</div>
            <div class="mt-3 text-xs text-green-100">{{ 100 - $budgetUsed }}% remaining</div>
        </div>
        <div class="rounded-2xl bg-gradient-to-br {{ $budgetUsed > 100 ? 'from-red-500 to-red-600' : 'from-blue-500 to-blue-600' }} p-6 shadow-lg">
            <div class="flex items-center gap-4 mb-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="{{ $budgetUsed > 100 ? 'alert-triangle' : 'check-circle' }}" class="w-6 h-6 text-white" />
                </div>
                <div class="text-sm text-white/80">Status</div>
            </div>
            <div class="text-2xl font-bold text-white">{{ $budgetUsed > 100 ? 'Over Budget' : ($budgetUsed > 80 ? 'Warning' : 'On Track') }}</div>
            <div class="mt-3 text-xs text-white/80">{{ $budgetUsed > 100 ? 'Exceeded by $' . number_format($actualCost - $budget) : 'Within budget limits' }}</div>
        </div>
    </div>

    {{-- Cost Breakdown --}}
    <div class="grid grid-cols-3 gap-6">
        <div class="col-span-2 rounded-2xl bg-white p-6 shadow-lg border border-slate-200/60">
            <h3 class="text-lg font-semibold text-[#303030] mb-6">Cost Breakdown</h3>
            <div class="space-y-4">
                @foreach($costBreakdown as $item)
                <div class="flex items-center gap-4">
                    <div class="w-24 text-sm font-medium text-slate-700">{{ $item['category'] }}</div>
                    <div class="flex-1">
                        <div class="h-8 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full rounded-full flex items-center justify-end pr-3 text-xs font-semibold text-white transition-all
                                @if($item['color'] === 'blue') bg-gradient-to-r from-blue-400 to-blue-600
                                @elseif($item['color'] === 'green') bg-gradient-to-r from-green-400 to-green-600
                                @elseif($item['color'] === 'purple') bg-gradient-to-r from-purple-400 to-purple-600
                                @else bg-gradient-to-r from-amber-400 to-amber-600 @endif" 
                                style="width: {{ $item['percentage'] }}%">
                                {{ $item['percentage'] }}%
                            </div>
                        </div>
                    </div>
                    <div class="w-28 text-right font-semibold text-slate-700">${{ number_format($item['amount']) }}</div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Budget Health --}}
        <div class="rounded-2xl bg-white p-6 shadow-lg border border-slate-200/60">
            <h3 class="text-lg font-semibold text-[#303030] mb-6">Budget Health</h3>
            <div class="relative">
                <div class="w-40 h-40 mx-auto">
                    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                        <circle cx="50" cy="50" r="40" fill="none" stroke="#e2e8f0" stroke-width="12"/>
                        <circle cx="50" cy="50" r="40" fill="none" 
                            stroke="{{ $budgetUsed > 100 ? '#ef4444' : ($budgetUsed > 80 ? '#f59e0b' : '#22c55e') }}" 
                            stroke-width="12" 
                            stroke-linecap="round"
                            stroke-dasharray="{{ min($budgetUsed, 100) * 2.51 }} 251"
                            class="transition-all duration-1000"/>
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-[#303030]">{{ $budgetUsed }}%</div>
                            <div class="text-xs text-slate-500">Used</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-6 space-y-2">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-slate-500">Budget</span>
                    <span class="font-semibold text-slate-700">${{ number_format($budget) }}</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-slate-500">Spent</span>
                    <span class="font-semibold text-slate-700">${{ number_format($actualCost) }}</span>
                </div>
                <div class="flex items-center justify-between text-sm pt-2 border-t border-slate-200">
                    <span class="text-slate-500">Remaining</span>
                    <span class="font-semibold {{ $remaining > 0 ? 'text-green-600' : 'text-red-600' }}">${{ number_format($remaining) }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Expenses --}}
    <div class="rounded-2xl bg-white shadow-lg overflow-hidden border border-slate-200/60">
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-[#303030]">Recent Expenses</h3>
            <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">View All</a>
        </div>
        <table class="w-full">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Description</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Category</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Date</th>
                    <th class="text-right px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="4" class="px-6 py-16 text-center">
                        <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-slate-100 mb-4">
                            <x-base.lucide icon="receipt" class="w-8 h-8 text-slate-400" />
                        </div>
                        <p class="text-slate-600 font-medium">No expenses recorded yet</p>
                        <p class="text-sm text-slate-400 mt-1">Add expenses to track project costs</p>
                        <button class="inline-flex items-center mt-4 px-5 py-2.5 rounded-full bg-[#303030] text-white text-sm font-semibold hover:bg-[#404040] transition-all">
                            <x-base.lucide icon="plus" class="w-4 h-4 mr-2" /> Add Expense
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

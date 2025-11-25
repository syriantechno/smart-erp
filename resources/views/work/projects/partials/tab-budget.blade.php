<!-- Budget Tab -->
<div id="tab-budget" class="tab-content">
    <h3 class="text-lg font-semibold mb-4">Budget Overview</h3>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Budget Cards -->
        <div class="space-y-4">
            <!-- Total Budget -->
            <div class="p-5 rounded-xl bg-gradient-to-r from-purple-50 to-indigo-50 border border-purple-100">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center">
                            <x-base.lucide icon="wallet" class="w-6 h-6 text-purple-600" />
                        </div>
                        <div>
                            <div class="text-sm text-slate-600">Total Budget</div>
                            <div class="text-2xl font-bold text-slate-800">${{ number_format($project->budget ?? 0, 2) }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actual Cost -->
            <div class="p-5 rounded-xl bg-gradient-to-r from-blue-50 to-cyan-50 border border-blue-100">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
                            <x-base.lucide icon="credit-card" class="w-6 h-6 text-blue-600" />
                        </div>
                        <div>
                            <div class="text-sm text-slate-600">Actual Cost</div>
                            <div class="text-2xl font-bold text-slate-800">${{ number_format($project->actual_cost ?? 0, 2) }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Remaining -->
            @php
                $remaining = ($project->budget ?? 0) - ($project->actual_cost ?? 0);
                $isOverBudget = $remaining < 0;
            @endphp
            <div class="p-5 rounded-xl {{ $isOverBudget ? 'bg-gradient-to-r from-red-50 to-orange-50 border-red-100' : 'bg-gradient-to-r from-green-50 to-emerald-50 border-green-100' }} border">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl {{ $isOverBudget ? 'bg-red-100' : 'bg-green-100' }} flex items-center justify-center">
                            <x-base.lucide icon="{{ $isOverBudget ? 'alert-triangle' : 'piggy-bank' }}" class="w-6 h-6 {{ $isOverBudget ? 'text-red-600' : 'text-green-600' }}" />
                        </div>
                        <div>
                            <div class="text-sm text-slate-600">{{ $isOverBudget ? 'Over Budget' : 'Remaining' }}</div>
                            <div class="text-2xl font-bold {{ $isOverBudget ? 'text-red-600' : 'text-green-600' }}">${{ number_format(abs($remaining), 2) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Budget Analysis -->
        <div class="space-y-4">
            <div class="p-5 rounded-xl bg-slate-50 border border-slate-200">
                <h4 class="font-medium mb-4">Budget Usage</h4>
                
                <!-- Progress Bar -->
                <div class="mb-4">
                    <div class="flex justify-between text-sm mb-2">
                        <span>Used</span>
                        <span class="{{ $budgetUsed > 100 ? 'text-red-500' : ($budgetUsed > 80 ? 'text-amber-500' : 'text-green-500') }} font-medium">{{ $budgetUsed }}%</span>
                    </div>
                    <div class="w-full bg-slate-200 rounded-full h-4">
                        <div class="h-4 rounded-full transition-all {{ $budgetUsed > 100 ? 'bg-red-500' : ($budgetUsed > 80 ? 'bg-amber-500' : 'bg-green-500') }}" style="width: {{ min($budgetUsed, 100) }}%"></div>
                    </div>
                </div>

                <!-- Stats -->
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-600">Budget per Task</span>
                        <span class="font-medium">${{ $totalTasks > 0 ? number_format(($project->budget ?? 0) / $totalTasks, 2) : '0.00' }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-600">Cost per Task</span>
                        <span class="font-medium">${{ $totalTasks > 0 ? number_format(($project->actual_cost ?? 0) / $totalTasks, 2) : '0.00' }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-600">Cost per Day</span>
                        <span class="font-medium">${{ $daysPassed > 0 ? number_format(($project->actual_cost ?? 0) / $daysPassed, 2) : '0.00' }}</span>
                    </div>
                    <hr class="border-slate-200">
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-600">Budget Status</span>
                        @if($budgetUsed > 100)
                            <span class="text-red-500 font-medium">Over Budget</span>
                        @elseif($budgetUsed > 80)
                            <span class="text-amber-500 font-medium">Near Limit</span>
                        @else
                            <span class="text-green-500 font-medium">Within Budget</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Projected Cost -->
            @if($project->progress_percentage > 0 && $project->progress_percentage < 100)
            @php
                $projectedCost = ($project->actual_cost ?? 0) / ($project->progress_percentage / 100);
            @endphp
            <div class="p-4 rounded-xl {{ $projectedCost > ($project->budget ?? 0) ? 'bg-red-50 border-red-200' : 'bg-blue-50 border-blue-200' }} border">
                <div class="flex items-center gap-2 mb-2">
                    <x-base.lucide icon="trending-up" class="w-5 h-5 {{ $projectedCost > ($project->budget ?? 0) ? 'text-red-600' : 'text-blue-600' }}" />
                    <span class="font-medium {{ $projectedCost > ($project->budget ?? 0) ? 'text-red-700' : 'text-blue-700' }}">Projected Final Cost</span>
                </div>
                <div class="text-2xl font-bold {{ $projectedCost > ($project->budget ?? 0) ? 'text-red-600' : 'text-blue-600' }}">
                    ${{ number_format($projectedCost, 2) }}
                </div>
                <div class="text-xs {{ $projectedCost > ($project->budget ?? 0) ? 'text-red-500' : 'text-blue-500' }} mt-1">
                    Based on current spending rate
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

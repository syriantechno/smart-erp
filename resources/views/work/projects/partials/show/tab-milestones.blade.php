{{-- Milestones Tab --}}
@php
    // Sample milestones - would come from project_milestones table
    $milestones = [
        ['name' => 'Project Kickoff', 'status' => 'completed', 'date' => $project->start_date, 'progress' => 100, 'description' => 'Initial project setup and team onboarding'],
        ['name' => 'Planning Phase', 'status' => $project->progress_percentage >= 25 ? 'completed' : 'in_progress', 'date' => $project->start_date?->addDays(14), 'progress' => min(100, $project->progress_percentage * 4), 'description' => 'Complete planning documents and specifications'],
        ['name' => 'Development Phase', 'status' => $project->progress_percentage >= 50 ? 'completed' : ($project->progress_percentage >= 25 ? 'in_progress' : 'pending'), 'date' => $project->start_date?->addDays(45), 'progress' => max(0, min(100, ($project->progress_percentage - 25) * 4)), 'description' => 'Core development and implementation'],
        ['name' => 'Testing & QA', 'status' => $project->progress_percentage >= 75 ? 'completed' : ($project->progress_percentage >= 50 ? 'in_progress' : 'pending'), 'date' => $project->start_date?->addDays(75), 'progress' => max(0, min(100, ($project->progress_percentage - 50) * 4)), 'description' => 'Quality assurance and testing'],
        ['name' => 'Project Delivery', 'status' => $project->progress_percentage >= 100 ? 'completed' : 'pending', 'date' => $project->end_date, 'progress' => $project->progress_percentage >= 100 ? 100 : 0, 'description' => 'Final delivery and handover'],
    ];
    $completedMilestones = collect($milestones)->where('status', 'completed')->count();
    $inProgressMilestones = collect($milestones)->where('status', 'in_progress')->count();
@endphp

<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-semibold text-[#303030]">Project Milestones</h2>
            <p class="text-sm text-slate-500 mt-1">Track key project deliverables and deadlines</p>
        </div>
        <button class="h-10 rounded-full px-5 flex items-center justify-center text-xs font-semibold text-white bg-[#303030] hover:bg-[#404040] transition-all">
            <x-base.lucide icon="plus" class="w-4 h-4 mr-2" /> Add Milestone
        </button>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-4 gap-4">
        <div class="rounded-2xl bg-gradient-to-br from-slate-800 to-slate-900 p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="flag" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">{{ count($milestones) }}</div>
                    <div class="text-xs text-slate-300 mt-1">Total Milestones</div>
                </div>
            </div>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-green-500 to-green-600 p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="check-circle" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">{{ $completedMilestones }}</div>
                    <div class="text-xs text-green-100 mt-1">Completed</div>
                </div>
            </div>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="loader" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">{{ $inProgressMilestones }}</div>
                    <div class="text-xs text-blue-100 mt-1">In Progress</div>
                </div>
            </div>
        </div>
        <div class="rounded-2xl p-5 shadow-lg" style="background: linear-gradient(135deg, #f7e08a 0%, #d49a24 100%);">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/30 flex items-center justify-center">
                    <x-base.lucide icon="clock" class="w-6 h-6 text-[#3a2a1a]" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-[#3a2a1a]">{{ count($milestones) - $completedMilestones - $inProgressMilestones }}</div>
                    <div class="text-xs text-[#5a4a2a] mt-1">Upcoming</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Timeline Progress --}}
    <div class="rounded-2xl bg-white p-6 shadow-lg border border-slate-200/60">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-[#303030]">Timeline Progress</h3>
            <div class="flex gap-4 text-xs">
                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-green-500"></span> Completed</span>
                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-blue-500"></span> In Progress</span>
                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-slate-300"></span> Upcoming</span>
            </div>
        </div>
        <div class="relative">
            <div class="h-3 bg-slate-200 rounded-full overflow-hidden">
                <div class="h-full rounded-full transition-all" style="width: {{ $project->progress_percentage }}%; background: linear-gradient(to right, #22c55e, #3b82f6, #f7e08a);"></div>
            </div>
            <div class="flex justify-between mt-2 text-xs text-slate-500">
                <span>{{ $project->start_date?->format('M d, Y') ?? 'Start' }}</span>
                <span>{{ $project->end_date?->format('M d, Y') ?? 'End' }}</span>
            </div>
        </div>
    </div>

    {{-- Milestones List --}}
    <div class="rounded-2xl bg-white shadow-lg border border-slate-200/60 overflow-hidden">
        <div class="divide-y divide-slate-100">
            @foreach($milestones as $index => $milestone)
            <div class="p-5 hover:bg-slate-50/50 transition-colors">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center shadow-lg
                            @if($milestone['status'] === 'completed') bg-gradient-to-br from-green-400 to-green-600
                            @elseif($milestone['status'] === 'in_progress') bg-gradient-to-br from-blue-400 to-blue-600
                            @else bg-slate-300 @endif">
                            @if($milestone['status'] === 'completed')
                                <x-base.lucide icon="check" class="w-6 h-6 text-white" />
                            @elseif($milestone['status'] === 'in_progress')
                                <x-base.lucide icon="loader" class="w-6 h-6 text-white animate-spin" />
                            @else
                                <x-base.lucide icon="circle" class="w-6 h-6 text-white" />
                            @endif
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <h4 class="font-semibold text-[#303030]">{{ $milestone['name'] }}</h4>
                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold
                                @if($milestone['status'] === 'completed') bg-green-100 text-green-700
                                @elseif($milestone['status'] === 'in_progress') bg-blue-100 text-blue-700
                                @else bg-slate-100 text-slate-600 @endif">
                                {{ ucfirst(str_replace('_', ' ', $milestone['status'])) }}
                            </span>
                        </div>
                        <p class="text-sm text-slate-600 mt-1">{{ $milestone['description'] }}</p>
                        <div class="flex items-center gap-4 mt-3">
                            <span class="flex items-center gap-1.5 text-xs text-slate-500">
                                <x-base.lucide icon="calendar" class="w-3.5 h-3.5" />
                                {{ $milestone['date']?->format('M d, Y') ?? 'TBD' }}
                            </span>
                            @if($milestone['status'] !== 'pending')
                            <div class="flex items-center gap-2 flex-1 max-w-[200px]">
                                <div class="flex-1 h-2 bg-slate-200 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full transition-all
                                        @if($milestone['status'] === 'completed') bg-green-500
                                        @else bg-blue-500 @endif" 
                                        style="width: {{ $milestone['progress'] }}%"></div>
                                </div>
                                <span class="text-xs font-medium text-slate-600">{{ $milestone['progress'] }}%</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

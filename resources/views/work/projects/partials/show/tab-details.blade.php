{{-- Details Tab --}}
<div class="flex flex-col gap-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-semibold text-[#303030]">Project Details</h2>
            <p class="text-sm text-slate-500 mt-1">Complete project information</p>
        </div>
        <a href="{{ route('project-management.projects.edit', $project) }}" class="h-10 rounded-full px-5 flex items-center justify-center text-xs font-semibold text-white bg-[#303030] hover:bg-[#404040]">
            <x-base.lucide icon="edit" class="w-4 h-4 mr-2" /> Edit Project
        </a>
    </div>

    <div class="grid grid-cols-3 gap-6">
        {{-- Basic Information --}}
        <div class="rounded-[24px] bg-white/60 shadow-[0_24px_50px_rgba(15,15,20,0.10)] p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="h-10 w-10 rounded-xl bg-blue-100 flex items-center justify-center">
                    <x-base.lucide icon="info" class="w-5 h-5 text-blue-600" />
                </div>
                <div class="text-lg font-semibold text-[#303030]">Basic Information</div>
            </div>
            
            <div class="space-y-4">
                <div>
                    <div class="text-xs text-slate-500 uppercase tracking-wider mb-1">Project Code</div>
                    <div class="font-mono font-medium text-[#303030]">{{ $project->code }}</div>
                </div>
                <div>
                    <div class="text-xs text-slate-500 uppercase tracking-wider mb-1">Project Name</div>
                    <div class="font-medium text-[#303030]">{{ $project->name }}</div>
                </div>
                <div>
                    <div class="text-xs text-slate-500 uppercase tracking-wider mb-1">Company</div>
                    <div class="font-medium text-[#303030]">{{ $project->company?->name ?? 'N/A' }}</div>
                </div>
                <div>
                    <div class="text-xs text-slate-500 uppercase tracking-wider mb-1">Department</div>
                    <div class="font-medium text-[#303030]">{{ $project->department?->name ?? 'N/A' }}</div>
                </div>
                <div>
                    <div class="text-xs text-slate-500 uppercase tracking-wider mb-1">Project Manager</div>
                    <div class="font-medium text-[#303030]">{{ $project->manager ? $project->manager->first_name . ' ' . $project->manager->last_name : 'N/A' }}</div>
                </div>
            </div>
        </div>

        {{-- Status & Priority --}}
        <div class="rounded-[24px] bg-white/60 shadow-[0_24px_50px_rgba(15,15,20,0.10)] p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="h-10 w-10 rounded-xl bg-amber-100 flex items-center justify-center">
                    <x-base.lucide icon="flag" class="w-5 h-5 text-amber-600" />
                </div>
                <div class="text-lg font-semibold text-[#303030]">Status & Priority</div>
            </div>
            
            <div class="space-y-4">
                <div>
                    <div class="text-xs text-slate-500 uppercase tracking-wider mb-2">Status</div>
                    <span class="inline-flex px-4 py-2 rounded-full text-sm font-medium
                        @if($project->status === 'active') bg-amber-100 text-amber-700
                        @elseif($project->status === 'completed') bg-green-100 text-green-700
                        @elseif($project->status === 'planning') bg-blue-100 text-blue-700
                        @elseif($project->status === 'on_hold') bg-slate-100 text-slate-700
                        @else bg-red-100 text-red-700 @endif">
                        {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                    </span>
                </div>
                <div>
                    <div class="text-xs text-slate-500 uppercase tracking-wider mb-2">Priority</div>
                    <span class="inline-flex px-4 py-2 rounded-full text-sm font-medium
                        @if($project->priority === 'critical') bg-red-100 text-red-700
                        @elseif($project->priority === 'high') bg-orange-100 text-orange-700
                        @elseif($project->priority === 'medium') bg-blue-100 text-blue-700
                        @else bg-slate-100 text-slate-600 @endif">
                        {{ ucfirst($project->priority) }}
                    </span>
                </div>
                <div>
                    <div class="text-xs text-slate-500 uppercase tracking-wider mb-1">Progress</div>
                    <div class="flex items-center gap-3">
                        <div class="flex-1 h-3 bg-slate-200 rounded-full overflow-hidden">
                            <div class="h-full rounded-full" style="width: {{ $project->progress_percentage }}%; background: linear-gradient(to right, #f7e08a, #d49a24);"></div>
                        </div>
                        <span class="font-bold text-[#303030]">{{ $project->progress_percentage }}%</span>
                    </div>
                </div>
                <div>
                    <div class="text-xs text-slate-500 uppercase tracking-wider mb-1">Active</div>
                    <span class="inline-flex items-center gap-2">
                        @if($project->is_active)
                            <span class="h-2 w-2 rounded-full bg-green-500"></span>
                            <span class="text-green-600 font-medium">Yes</span>
                        @else
                            <span class="h-2 w-2 rounded-full bg-red-500"></span>
                            <span class="text-red-600 font-medium">No</span>
                        @endif
                    </span>
                </div>
            </div>
        </div>

        {{-- Timeline --}}
        <div class="rounded-[24px] bg-white/60 shadow-[0_24px_50px_rgba(15,15,20,0.10)] p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="h-10 w-10 rounded-xl bg-green-100 flex items-center justify-center">
                    <x-base.lucide icon="calendar" class="w-5 h-5 text-green-600" />
                </div>
                <div class="text-lg font-semibold text-[#303030]">Timeline</div>
            </div>
            
            <div class="space-y-4">
                <div>
                    <div class="text-xs text-slate-500 uppercase tracking-wider mb-1">Start Date</div>
                    <div class="font-medium text-[#303030]">{{ $project->start_date?->format('F d, Y') ?? 'Not set' }}</div>
                </div>
                <div>
                    <div class="text-xs text-slate-500 uppercase tracking-wider mb-1">End Date</div>
                    <div class="font-medium text-[#303030]">{{ $project->end_date?->format('F d, Y') ?? 'Not set' }}</div>
                </div>
                <div>
                    <div class="text-xs text-slate-500 uppercase tracking-wider mb-1">Actual End Date</div>
                    <div class="font-medium text-[#303030]">{{ $project->actual_end_date?->format('F d, Y') ?? 'Not completed' }}</div>
                </div>
                <div>
                    <div class="text-xs text-slate-500 uppercase tracking-wider mb-1">Duration</div>
                    <div class="font-medium text-[#303030]">{{ $totalDays }} days</div>
                </div>
                <div>
                    <div class="text-xs text-slate-500 uppercase tracking-wider mb-1">Days Remaining</div>
                    <div class="font-medium {{ $daysRemaining !== null && $daysRemaining < 7 ? 'text-red-600' : 'text-[#303030]' }}">{{ $daysRemaining ?? '∞' }} days</div>
                </div>
            </div>
        </div>

        {{-- Budget --}}
        <div class="rounded-[24px] bg-white/60 shadow-[0_24px_50px_rgba(15,15,20,0.10)] p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="h-10 w-10 rounded-xl bg-purple-100 flex items-center justify-center">
                    <x-base.lucide icon="wallet" class="w-5 h-5 text-purple-600" />
                </div>
                <div class="text-lg font-semibold text-[#303030]">Budget</div>
            </div>
            
            <div class="space-y-4">
                <div>
                    <div class="text-xs text-slate-500 uppercase tracking-wider mb-1">Total Budget</div>
                    <div class="text-2xl font-bold text-[#303030]">${{ number_format($project->budget ?? 0, 2) }}</div>
                </div>
                <div>
                    <div class="text-xs text-slate-500 uppercase tracking-wider mb-1">Actual Cost</div>
                    <div class="text-2xl font-bold text-[#303030]">${{ number_format($project->actual_cost ?? 0, 2) }}</div>
                </div>
                <div>
                    <div class="text-xs text-slate-500 uppercase tracking-wider mb-1">Budget Used</div>
                    <div class="flex items-center gap-3">
                        <div class="flex-1 h-3 bg-slate-200 rounded-full overflow-hidden">
                            <div class="h-full {{ $budgetUsed > 90 ? 'bg-red-500' : ($budgetUsed > 70 ? 'bg-amber-500' : 'bg-green-500') }} rounded-full" style="width: {{ min($budgetUsed, 100) }}%"></div>
                        </div>
                        <span class="font-bold">{{ $budgetUsed }}%</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Description --}}
        <div class="col-span-2 rounded-[24px] bg-white/60 shadow-[0_24px_50px_rgba(15,15,20,0.10)] p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="h-10 w-10 rounded-xl bg-slate-100 flex items-center justify-center">
                    <x-base.lucide icon="file-text" class="w-5 h-5 text-slate-600" />
                </div>
                <div class="text-lg font-semibold text-[#303030]">Description & Notes</div>
            </div>
            
            <div class="space-y-6">
                @if($project->description)
                <div>
                    <div class="text-xs text-slate-500 uppercase tracking-wider mb-2">Description</div>
                    <p class="text-slate-600 leading-relaxed">{{ $project->description }}</p>
                </div>
                @endif
                
                @if($project->objectives)
                <div>
                    <div class="text-xs text-slate-500 uppercase tracking-wider mb-2">Objectives</div>
                    <p class="text-slate-600 leading-relaxed">{{ $project->objectives }}</p>
                </div>
                @endif
                
                @if($project->deliverables)
                <div>
                    <div class="text-xs text-slate-500 uppercase tracking-wider mb-2">Deliverables</div>
                    <p class="text-slate-600 leading-relaxed">{{ $project->deliverables }}</p>
                </div>
                @endif
                
                @if($project->risks)
                <div>
                    <div class="text-xs text-slate-500 uppercase tracking-wider mb-2">Risks</div>
                    <p class="text-slate-600 leading-relaxed">{{ $project->risks }}</p>
                </div>
                @endif
                
                @if($project->notes)
                <div>
                    <div class="text-xs text-slate-500 uppercase tracking-wider mb-2">Notes</div>
                    <p class="text-slate-600 leading-relaxed">{{ $project->notes }}</p>
                </div>
                @endif
                
                @if(!$project->description && !$project->objectives && !$project->deliverables && !$project->risks && !$project->notes)
                <p class="text-slate-400 text-center py-6">No additional information provided</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Timestamps --}}
    <div class="rounded-[24px] bg-slate-50 p-4 flex items-center justify-between text-sm text-slate-500">
        <div>Created: {{ $project->created_at?->format('F d, Y \a\t h:i A') }}</div>
        <div>Last Updated: {{ $project->updated_at?->format('F d, Y \a\t h:i A') }}</div>
    </div>
</div>

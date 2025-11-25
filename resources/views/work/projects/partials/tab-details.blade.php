<!-- Details Tab -->
<div id="tab-details" class="tab-content">
    <h3 class="text-lg font-semibold mb-4">Project Details</h3>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Basic Info -->
        <div class="space-y-4">
            <div class="p-5 rounded-xl bg-slate-50 border border-slate-200">
                <h4 class="font-medium mb-4 flex items-center gap-2">
                    <x-base.lucide icon="info" class="w-4 h-4 text-slate-500" />
                    Basic Information
                </h4>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-slate-600">Project Code</span>
                        <span class="font-mono font-medium">{{ $project->code }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-600">Project Name</span>
                        <span class="font-medium">{{ $project->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-600">Company</span>
                        <span class="font-medium">{{ $project->company?->name ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-600">Department</span>
                        <span class="font-medium">{{ $project->department?->name ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-600">Manager</span>
                        <span class="font-medium">{{ $project->manager ? $project->manager->first_name . ' ' . $project->manager->last_name : 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-600">Status</span>
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                            @if($project->status === 'active') bg-amber-100 text-amber-700
                            @elseif($project->status === 'completed') bg-green-100 text-green-700
                            @else bg-slate-100 text-slate-700 @endif">
                            {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-600">Priority</span>
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                            @if($project->priority === 'critical') bg-red-100 text-red-700
                            @elseif($project->priority === 'high') bg-orange-100 text-orange-700
                            @else bg-blue-100 text-blue-700 @endif">
                            {{ ucfirst($project->priority) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Description -->
            @if($project->description)
            <div class="p-5 rounded-xl bg-slate-50 border border-slate-200">
                <h4 class="font-medium mb-3 flex items-center gap-2">
                    <x-base.lucide icon="file-text" class="w-4 h-4 text-slate-500" />
                    Description
                </h4>
                <p class="text-slate-600 text-sm leading-relaxed">{{ $project->description }}</p>
            </div>
            @endif

            <!-- Objectives -->
            @if($project->objectives)
            <div class="p-5 rounded-xl bg-blue-50 border border-blue-200">
                <h4 class="font-medium mb-3 flex items-center gap-2 text-blue-700">
                    <x-base.lucide icon="target" class="w-4 h-4" />
                    Objectives
                </h4>
                <p class="text-blue-600 text-sm leading-relaxed">{{ $project->objectives }}</p>
            </div>
            @endif
        </div>

        <!-- Additional Info -->
        <div class="space-y-4">
            <!-- Deliverables -->
            @if($project->deliverables)
            <div class="p-5 rounded-xl bg-green-50 border border-green-200">
                <h4 class="font-medium mb-3 flex items-center gap-2 text-green-700">
                    <x-base.lucide icon="package" class="w-4 h-4" />
                    Deliverables
                </h4>
                <p class="text-green-600 text-sm leading-relaxed">{{ $project->deliverables }}</p>
            </div>
            @endif

            <!-- Risks -->
            @if($project->risks)
            <div class="p-5 rounded-xl bg-red-50 border border-red-200">
                <h4 class="font-medium mb-3 flex items-center gap-2 text-red-700">
                    <x-base.lucide icon="alert-triangle" class="w-4 h-4" />
                    Risks
                </h4>
                <p class="text-red-600 text-sm leading-relaxed">{{ $project->risks }}</p>
            </div>
            @endif

            <!-- Notes -->
            @if($project->notes)
            <div class="p-5 rounded-xl bg-amber-50 border border-amber-200">
                <h4 class="font-medium mb-3 flex items-center gap-2 text-amber-700">
                    <x-base.lucide icon="sticky-note" class="w-4 h-4" />
                    Notes
                </h4>
                <p class="text-amber-600 text-sm leading-relaxed">{{ $project->notes }}</p>
            </div>
            @endif

            <!-- Timestamps -->
            <div class="p-5 rounded-xl bg-slate-50 border border-slate-200">
                <h4 class="font-medium mb-3 flex items-center gap-2">
                    <x-base.lucide icon="clock" class="w-4 h-4 text-slate-500" />
                    Timestamps
                </h4>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-600">Created</span>
                        <span class="font-medium">{{ $project->created_at?->format('M d, Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-600">Last Updated</span>
                        <span class="font-medium">{{ $project->updated_at?->format('M d, Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Timeline Tab -->
<div id="tab-timeline" class="tab-content">
    <h3 class="text-lg font-semibold mb-4">Project Timeline</h3>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Timeline Visual -->
        <div class="space-y-4">
            <!-- Start -->
            <div class="flex items-start gap-4">
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                        <x-base.lucide icon="play" class="w-5 h-5 text-green-600" />
                    </div>
                    <div class="w-0.5 h-16 bg-slate-200"></div>
                </div>
                <div class="flex-1 pb-4">
                    <div class="font-medium">Project Started</div>
                    <div class="text-sm text-slate-500">{{ $project->start_date?->format('F d, Y') ?? 'Not set' }}</div>
                    @if($project->start_date)
                        <div class="text-xs text-slate-400 mt-1">{{ $project->start_date->diffForHumans() }}</div>
                    @endif
                </div>
            </div>

            <!-- Current -->
            <div class="flex items-start gap-4">
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                        <x-base.lucide icon="clock" class="w-5 h-5 text-blue-600" />
                    </div>
                    <div class="w-0.5 h-16 bg-slate-200"></div>
                </div>
                <div class="flex-1 pb-4">
                    <div class="font-medium">Current Progress</div>
                    <div class="text-sm text-slate-500">Day {{ $daysPassed }} of {{ $totalDays }}</div>
                    <div class="mt-2">
                        <div class="flex justify-between text-xs mb-1">
                            <span>Time Progress</span>
                            <span class="{{ $timeProgress > $project->progress_percentage ? 'text-red-500' : 'text-green-500' }}">{{ $timeProgress }}%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="h-2 rounded-full {{ $timeProgress > $project->progress_percentage ? 'bg-red-500' : 'bg-blue-500' }}" style="width: {{ $timeProgress }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- End -->
            <div class="flex items-start gap-4">
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full {{ $daysRemaining !== null && $daysRemaining < 7 ? 'bg-red-100' : 'bg-amber-100' }} flex items-center justify-center">
                        <x-base.lucide icon="flag" class="w-5 h-5 {{ $daysRemaining !== null && $daysRemaining < 7 ? 'text-red-600' : 'text-amber-600' }}" />
                    </div>
                </div>
                <div class="flex-1">
                    <div class="font-medium">Target Completion</div>
                    <div class="text-sm text-slate-500">{{ $project->end_date?->format('F d, Y') ?? 'Not set' }}</div>
                    @if($daysRemaining !== null)
                        <div class="text-xs mt-1 {{ $daysRemaining < 7 ? 'text-red-500 font-medium' : 'text-slate-400' }}">
                            {{ $daysRemaining }} days remaining
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="space-y-4">
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                <h4 class="font-medium mb-3">Timeline Analysis</h4>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-slate-600">Total Duration</span>
                        <span class="font-medium">{{ $totalDays }} days</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-600">Days Passed</span>
                        <span class="font-medium">{{ $daysPassed }} days</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-600">Days Remaining</span>
                        <span class="font-medium {{ $daysRemaining !== null && $daysRemaining < 7 ? 'text-red-500' : '' }}">{{ $daysRemaining ?? '∞' }} days</span>
                    </div>
                    <hr class="border-slate-200">
                    <div class="flex justify-between">
                        <span class="text-slate-600">Time Progress</span>
                        <span class="font-medium">{{ $timeProgress }}%</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-600">Work Progress</span>
                        <span class="font-medium">{{ $project->progress_percentage }}%</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-600">Status</span>
                        @if($timeProgress > $project->progress_percentage + 10)
                            <span class="text-red-500 font-medium">Behind Schedule</span>
                        @elseif($project->progress_percentage > $timeProgress + 10)
                            <span class="text-green-500 font-medium">Ahead of Schedule</span>
                        @else
                            <span class="text-blue-500 font-medium">On Track</span>
                        @endif
                    </div>
                </div>
            </div>

            @if($project->actual_end_date)
            <div class="p-4 rounded-xl bg-green-50 border border-green-200">
                <div class="flex items-center gap-2 mb-2">
                    <x-base.lucide icon="check-circle" class="w-5 h-5 text-green-600" />
                    <span class="font-medium text-green-700">Project Completed</span>
                </div>
                <div class="text-sm text-green-600">
                    Actual completion: {{ $project->actual_end_date->format('F d, Y') }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

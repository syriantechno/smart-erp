<!-- Overview Tab -->
<div id="tab-overview" class="tab-content active">
    <div class="grid grid-cols-12 gap-6">
        <!-- Progress Section -->
        <div class="col-span-12 lg:col-span-8">
            <h3 class="text-lg font-semibold mb-4">Project Progress</h3>
            
            <!-- Main Progress Bar -->
            <div class="mb-6 p-4 rounded-xl bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-slate-700">Overall Completion</span>
                    <span class="text-lg font-bold text-blue-600">{{ $project->progress_percentage }}%</span>
                </div>
                <div class="w-full bg-blue-100 rounded-full h-3">
                    <div class="h-3 rounded-full bg-gradient-to-r from-blue-500 to-indigo-500 transition-all" style="width: {{ $project->progress_percentage }}%"></div>
                </div>
            </div>

            <!-- Task Status Breakdown -->
            <div class="grid grid-cols-4 gap-3 mb-6">
                <div class="text-center p-3 rounded-lg bg-green-50 border border-green-100">
                    <div class="text-2xl font-bold text-green-600">{{ $completedTasks }}</div>
                    <div class="text-xs text-green-700">Completed</div>
                </div>
                <div class="text-center p-3 rounded-lg bg-blue-50 border border-blue-100">
                    <div class="text-2xl font-bold text-blue-600">{{ $inProgressTasks }}</div>
                    <div class="text-xs text-blue-700">In Progress</div>
                </div>
                <div class="text-center p-3 rounded-lg bg-amber-50 border border-amber-100">
                    <div class="text-2xl font-bold text-amber-600">{{ $pendingTasks }}</div>
                    <div class="text-xs text-amber-700">Pending</div>
                </div>
                <div class="text-center p-3 rounded-lg {{ $overdueTasks > 0 ? 'bg-red-50 border-red-100' : 'bg-slate-50 border-slate-100' }}">
                    <div class="text-2xl font-bold {{ $overdueTasks > 0 ? 'text-red-600' : 'text-slate-400' }}">{{ $overdueTasks }}</div>
                    <div class="text-xs {{ $overdueTasks > 0 ? 'text-red-700' : 'text-slate-500' }}">Overdue</div>
                </div>
            </div>

            <!-- Recent Tasks -->
            <h4 class="font-medium text-slate-700 mb-3">Recent Tasks</h4>
            <div class="space-y-2">
                @forelse($project->tasks->sortByDesc('updated_at')->take(5) as $task)
                    <a href="{{ route('tasks.show', $task) }}" class="flex items-center justify-between p-3 rounded-lg border border-slate-200 hover:border-blue-300 hover:bg-blue-50/30 transition-all group">
                        <div class="flex items-center gap-3">
                            @if($task->status === 'completed')
                                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                    <x-base.lucide icon="check" class="w-4 h-4 text-green-600" />
                                </div>
                            @elseif($task->status === 'in_progress')
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                    <x-base.lucide icon="play" class="w-4 h-4 text-blue-600" />
                                </div>
                            @else
                                <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center">
                                    <x-base.lucide icon="circle" class="w-4 h-4 text-slate-400" />
                                </div>
                            @endif
                            <div>
                                <div class="font-medium text-sm group-hover:text-blue-600">{{ $task->title }}</div>
                                <div class="text-xs text-slate-500">{{ $task->code }} • {{ $task->employee?->full_name ?? 'Unassigned' }}</div>
                            </div>
                        </div>
                        <x-base.lucide icon="chevron-right" class="w-4 h-4 text-slate-400 group-hover:text-blue-500" />
                    </a>
                @empty
                    <div class="text-center py-8 text-slate-500">
                        <x-base.lucide icon="inbox" class="w-12 h-12 mx-auto mb-2 text-slate-300" />
                        <p>No tasks yet</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-span-12 lg:col-span-4 space-y-4">
            <!-- Project Manager -->
            @if($project->manager)
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                <div class="text-xs text-slate-500 mb-2">Project Manager</div>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-500 flex items-center justify-center text-white font-semibold">
                        {{ strtoupper(substr($project->manager->first_name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="font-medium">{{ $project->manager->first_name }} {{ $project->manager->last_name }}</div>
                        <div class="text-xs text-slate-500">{{ $project->manager->position ?? 'Manager' }}</div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Timeline -->
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                <div class="text-xs text-slate-500 mb-3">Timeline</div>
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-600">Start Date</span>
                        <span class="font-medium">{{ $project->start_date?->format('M d, Y') ?? 'Not set' }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-600">End Date</span>
                        <span class="font-medium">{{ $project->end_date?->format('M d, Y') ?? 'Not set' }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-600">Duration</span>
                        <span class="font-medium">{{ $totalDays }} days</span>
                    </div>
                    @if($timeProgress > 0)
                    <div class="pt-2">
                        <div class="flex justify-between text-xs mb-1">
                            <span>Time Elapsed</span>
                            <span>{{ $timeProgress }}%</span>
                        </div>
                        <div class="w-full bg-slate-200 rounded-full h-2">
                            <div class="h-2 rounded-full {{ $timeProgress > $project->progress_percentage ? 'bg-red-500' : 'bg-emerald-500' }}" style="width: {{ $timeProgress }}%"></div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                <div class="text-xs text-slate-500 mb-3">Quick Actions</div>
                <div class="space-y-2">
                    <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}" class="flex items-center gap-2 p-2 rounded-lg hover:bg-white transition-colors text-sm">
                        <x-base.lucide icon="plus" class="w-4 h-4 text-blue-500" />
                        <span>Add Task</span>
                    </a>
                    <a href="{{ route('tasks.index', ['project_id' => $project->id]) }}" class="flex items-center gap-2 p-2 rounded-lg hover:bg-white transition-colors text-sm">
                        <x-base.lucide icon="list" class="w-4 h-4 text-slate-500" />
                        <span>View All Tasks</span>
                    </a>
                    <a href="{{ route('project-management.projects.edit', $project) }}" class="flex items-center gap-2 p-2 rounded-lg hover:bg-white transition-colors text-sm">
                        <x-base.lucide icon="settings" class="w-4 h-4 text-slate-500" />
                        <span>Project Settings</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Tasks Tab --}}
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-semibold text-[#303030]">Project Tasks</h2>
            <p class="text-sm text-slate-500 mt-1">{{ $totalTasks }} tasks • {{ $completedTasks }} completed</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('tasks.index', ['project_id' => $project->id]) }}" class="h-10 rounded-full px-5 flex items-center justify-center text-xs font-semibold text-slate-600 border border-slate-300 hover:bg-white/80 transition-all">
                <x-base.lucide icon="external-link" class="w-4 h-4 mr-2" /> View All
            </a>
            <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}" class="h-10 rounded-full px-5 flex items-center justify-center text-xs font-semibold text-white bg-[#303030] hover:bg-[#404040] transition-all">
                <x-base.lucide icon="plus" class="w-4 h-4 mr-2" /> Add Task
            </a>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-5 gap-4">
        <div class="rounded-2xl bg-gradient-to-br from-slate-800 to-slate-900 p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="list-todo" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">{{ $totalTasks }}</div>
                    <div class="text-xs text-slate-300 mt-1">Total Tasks</div>
                </div>
            </div>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-green-500 to-green-600 p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="check-circle" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">{{ $completedTasks }}</div>
                    <div class="text-xs text-green-100 mt-1">Completed</div>
                </div>
            </div>
            <div class="mt-3 h-1.5 bg-white/30 rounded-full"><div class="h-full bg-white rounded-full" style="width: {{ $totalTasks > 0 ? ($completedTasks/$totalTasks)*100 : 0 }}%"></div></div>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="loader" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">{{ $inProgressTasks }}</div>
                    <div class="text-xs text-blue-100 mt-1">In Progress</div>
                </div>
            </div>
            <div class="mt-3 h-1.5 bg-white/30 rounded-full"><div class="h-full bg-white rounded-full" style="width: {{ $totalTasks > 0 ? ($inProgressTasks/$totalTasks)*100 : 0 }}%"></div></div>
        </div>
        <div class="rounded-2xl p-5 shadow-lg" style="background: linear-gradient(135deg, #f7e08a 0%, #d49a24 100%);">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/30 flex items-center justify-center">
                    <x-base.lucide icon="clock" class="w-6 h-6 text-[#3a2a1a]" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-[#3a2a1a]">{{ $pendingTasks }}</div>
                    <div class="text-xs text-[#5a4a2a] mt-1">Pending</div>
                </div>
            </div>
            <div class="mt-3 h-1.5 bg-white/40 rounded-full"><div class="h-full bg-[#3a2a1a] rounded-full" style="width: {{ $totalTasks > 0 ? ($pendingTasks/$totalTasks)*100 : 0 }}%"></div></div>
        </div>
        <div class="rounded-2xl bg-gradient-to-br {{ $overdueTasks > 0 ? 'from-red-500 to-red-600' : 'from-slate-400 to-slate-500' }} p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="alert-triangle" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">{{ $overdueTasks }}</div>
                    <div class="text-xs text-white/80 mt-1">Overdue</div>
                </div>
            </div>
            @if($overdueTasks > 0)<div class="mt-3 h-1.5 bg-white/30 rounded-full"><div class="h-full bg-white rounded-full animate-pulse" style="width: 100%"></div></div>@endif
        </div>
    </div>

    {{-- Tasks Table --}}
    <div class="rounded-2xl bg-white shadow-lg overflow-hidden border border-slate-200/60">
        <table class="w-full">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Task</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Assigned To</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Status</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Priority</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Due Date</th>
                    <th class="text-center px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Progress</th>
                    <th class="px-6 py-4"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($project->tasks->sortByDesc('created_at') as $task)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <a href="{{ route('tasks.show', $task) }}" class="font-medium text-[#303030] hover:text-blue-600 transition-colors">{{ $task->title }}</a>
                        <div class="text-xs text-slate-500 mt-0.5">{{ $task->code }}</div>
                    </td>
                    <td class="px-6 py-4">
                        @if($task->employee)
                        <div class="flex items-center gap-2">
                            <div class="h-8 w-8 rounded-full bg-gradient-to-br from-slate-600 to-slate-800 flex items-center justify-center text-white text-xs font-semibold">
                                {{ strtoupper(substr($task->employee->first_name, 0, 1)) }}
                            </div>
                            <span class="text-sm text-slate-700">{{ $task->employee->full_name }}</span>
                        </div>
                        @else
                        <span class="text-sm text-slate-400 italic">Unassigned</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex px-3 py-1.5 rounded-full text-xs font-semibold
                            @if($task->status === 'completed') bg-green-100 text-green-700
                            @elseif($task->status === 'in_progress') bg-blue-100 text-blue-700
                            @elseif($task->status === 'pending') bg-amber-100 text-amber-700
                            @else bg-slate-100 text-slate-600 @endif">
                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex px-3 py-1.5 rounded-full text-xs font-semibold
                            @if($task->priority === 'high' || $task->priority === 'critical') bg-red-100 text-red-700
                            @elseif($task->priority === 'medium') bg-amber-100 text-amber-700
                            @else bg-slate-100 text-slate-600 @endif">
                            {{ ucfirst($task->priority) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($task->due_date)
                        <span class="text-sm {{ $task->due_date->isPast() && $task->status !== 'completed' ? 'text-red-600 font-semibold' : 'text-slate-600' }}">
                            {{ $task->due_date->format('M d, Y') }}
                        </span>
                        @else
                        <span class="text-sm text-slate-400">—</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <div class="w-20 h-2 bg-slate-200 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-blue-500 to-blue-600 rounded-full transition-all" style="width: {{ $task->progress_percentage ?? 0 }}%"></div>
                            </div>
                            <span class="text-xs font-medium text-slate-600">{{ $task->progress_percentage ?? 0 }}%</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('tasks.show', $task) }}" class="inline-flex items-center justify-center h-8 w-8 rounded-full hover:bg-slate-100 text-slate-400 hover:text-[#303030] transition-all">
                            <x-base.lucide icon="chevron-right" class="w-5 h-5" />
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-16 text-center">
                        <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-slate-100 mb-4">
                            <x-base.lucide icon="clipboard-list" class="w-8 h-8 text-slate-400" />
                        </div>
                        <p class="text-slate-600 font-medium">No tasks yet</p>
                        <p class="text-sm text-slate-400 mt-1">Create your first task to get started</p>
                        <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}" class="inline-flex items-center mt-4 px-5 py-2.5 rounded-full bg-[#303030] text-white text-sm font-semibold hover:bg-[#404040] transition-all">
                            <x-base.lucide icon="plus" class="w-4 h-4 mr-2" /> Create Task
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

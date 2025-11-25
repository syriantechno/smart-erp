<!-- Tasks Tab -->
<div id="tab-tasks" class="tab-content">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold">All Tasks ({{ $totalTasks }})</h3>
        <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}" class="btn-royal btn-royal--gold btn-royal--sm">
            <x-base.lucide icon="plus" class="w-4 h-4 mr-1" /> Add Task
        </a>
    </div>
    
    @if($totalTasks > 0)
        <!-- Filter Buttons -->
        <div class="flex flex-wrap gap-2 mb-4">
            <button class="task-filter-btn px-3 py-1.5 rounded-full text-sm font-medium bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors active" data-filter="all">
                All ({{ $totalTasks }})
            </button>
            <button class="task-filter-btn px-3 py-1.5 rounded-full text-sm font-medium bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors" data-filter="completed">
                Completed ({{ $completedTasks }})
            </button>
            <button class="task-filter-btn px-3 py-1.5 rounded-full text-sm font-medium bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors" data-filter="in_progress">
                In Progress ({{ $inProgressTasks }})
            </button>
            <button class="task-filter-btn px-3 py-1.5 rounded-full text-sm font-medium bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors" data-filter="pending">
                Pending ({{ $pendingTasks }})
            </button>
            @if($overdueTasks > 0)
            <button class="task-filter-btn px-3 py-1.5 rounded-full text-sm font-medium bg-red-100 text-red-700 hover:bg-red-200 transition-colors" data-filter="overdue">
                Overdue ({{ $overdueTasks }})
            </button>
            @endif
        </div>

        <div class="space-y-2" id="tasks-list">
            @foreach($project->tasks->sortByDesc('created_at') as $task)
                @php
                    $isOverdue = $task->due_date && $task->due_date->isPast() && !in_array($task->status, ['completed', 'cancelled']);
                @endphp
                <a href="{{ route('tasks.show', $task) }}" 
                   class="task-item flex items-center justify-between p-4 rounded-lg border border-slate-200 hover:border-blue-300 hover:shadow-sm transition-all group"
                   data-status="{{ $task->status }}"
                   data-overdue="{{ $isOverdue ? 'true' : 'false' }}">
                    <div class="flex items-center gap-4 flex-1">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center
                            @if($task->status === 'completed') bg-green-100
                            @elseif($task->status === 'in_progress') bg-blue-100
                            @else bg-slate-100 @endif">
                            @if($task->status === 'completed')
                                <x-base.lucide icon="check-circle" class="w-5 h-5 text-green-600" />
                            @elseif($task->status === 'in_progress')
                                <x-base.lucide icon="loader" class="w-5 h-5 text-blue-600" />
                            @else
                                <x-base.lucide icon="circle" class="w-5 h-5 text-slate-400" />
                            @endif
                        </div>
                        <div class="flex-1">
                            <div class="font-medium group-hover:text-blue-600">{{ $task->title }}</div>
                            <div class="text-xs text-slate-500 flex items-center gap-3 mt-1">
                                <span class="font-mono">{{ $task->code }}</span>
                                @if($task->employee)
                                    <span><x-base.lucide icon="user" class="w-3 h-3 inline" /> {{ $task->employee->full_name }}</span>
                                @endif
                                @if($task->due_date)
                                    <span class="{{ $isOverdue ? 'text-red-500 font-medium' : '' }}">
                                        <x-base.lucide icon="calendar" class="w-3 h-3 inline" /> {{ $task->due_date->format('M d') }}
                                        @if($isOverdue) (Overdue) @endif
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                            @if($task->priority === 'high') bg-red-100 text-red-700
                            @elseif($task->priority === 'medium') bg-amber-100 text-amber-700
                            @else bg-slate-100 text-slate-600 @endif">
                            {{ ucfirst($task->priority) }}
                        </span>
                        <x-base.lucide icon="chevron-right" class="w-4 h-4 text-slate-400" />
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <x-base.lucide icon="clipboard-list" class="w-16 h-16 mx-auto mb-4 text-slate-300" />
            <h4 class="text-lg font-medium text-slate-600 mb-2">No tasks yet</h4>
            <p class="text-slate-500 mb-4">Start by creating your first task for this project</p>
            <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}" class="btn-royal btn-royal--gold">
                <x-base.lucide icon="plus" class="w-4 h-4 mr-1" /> Create First Task
            </a>
        </div>
    @endif
</div>

@push('scripts')
<script>
document.querySelectorAll('.task-filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.task-filter-btn').forEach(b => b.classList.remove('active', 'bg-blue-500', 'text-white'));
        this.classList.add('active', 'bg-blue-500', 'text-white');
        
        const filter = this.dataset.filter;
        document.querySelectorAll('.task-item').forEach(item => {
            if (filter === 'all') {
                item.style.display = 'flex';
            } else if (filter === 'overdue') {
                item.style.display = item.dataset.overdue === 'true' ? 'flex' : 'none';
            } else {
                item.style.display = item.dataset.status === filter ? 'flex' : 'none';
            }
        });
    });
});
</script>
@endpush

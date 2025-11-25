@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>{{ $project->name }} - {{ config('app.name') }}</title>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">
@endpush

@section('subcontent')
    @include('components.global-notifications')

    <div class="mt-8 grid grid-cols-12 gap-6">
        <!-- Project Header -->
        <div class="col-span-12">
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-4">
                            <h2 class="text-2xl font-medium">{{ $project->name }}</h2>
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-semibold
                                @if($project->status === 'active') stats-card-warning
                                @elseif($project->status === 'planning') stats-card-info
                                @elseif($project->status === 'on_hold') stats-card-neutral
                                @elseif($project->status === 'completed') stats-card-success
                                @else stats-card-danger
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                            </span>
                        </div>
                        <div class="flex gap-2">
                            <button
                                class="btn-royal btn-royal--outline btn-royal--sm"
                                onclick="window.location.href='{{ route('work.projects.edit', $project) }}'"
                            >
                                <x-base.lucide icon="edit" class="w-4 h-4 mr-2" />
                                Edit
                            </button>
                            <button
                                class="btn-royal btn-royal--dark btn-royal--sm"
                                onclick="window.location.href='{{ route('work.projects.index') }}'"
                            >
                                <x-base.lucide icon="arrow-left" class="w-4 h-4 mr-2" />
                                Back
                            </button>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="mb-6 p-4 rounded-lg" style="background-color: color-mix(in oklch, #2563eb 5%, #ffffff); border: 1px solid color-mix(in oklch, #2563eb, transparent 90%);">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm font-medium" style="color: color-mix(in oklch, #2563eb, black 22%);">Project Progress</span>
                            <span class="text-sm font-semibold px-2 py-1 rounded-full" style="background-color: color-mix(in oklch, #2563eb 15%, #ffffff); color: color-mix(in oklch, #2563eb, black 30%);">{{ $project->progress_percentage }}%</span>
                        </div>
                        <div class="w-full rounded-full h-3" style="background-color: color-mix(in oklch, #2563eb, transparent 85%);">
                            <div class="h-3 rounded-full transition-all duration-500 ease-out" 
                                 style="width: {{ $project->progress_percentage }}%; 
                                        background: linear-gradient(90deg, 
                                            @if($project->progress_percentage >= 75) color-mix(in oklch, #1b7a4a 70%, #ffffff), color-mix(in oklch, #1b7a4a 90%, #ffffff)
                                            @elseif($project->progress_percentage >= 50) color-mix(in oklch, #c98028 70%, #ffffff), color-mix(in oklch, #c98028 90%, #ffffff)
                                            @else color-mix(in oklch, #b21a50 70%, #ffffff), color-mix(in oklch, #b21a50 90%, #ffffff)
                                            @endif);"></div>
                        </div>
                        <div class="flex items-center justify-between mt-2 text-xs">
                            <span style="color: color-mix(in oklch, #2563eb, black 35%);">
                                @if($project->progress_percentage >= 75) Excellent Progress
                                @elseif($project->progress_percentage >= 50) Good Progress
                                @elseif($project->progress_percentage > 0) Getting Started
                                @else Not Started
                                @endif
                            </span>
                            <span class="px-2 py-1 rounded-full text-xs" style="
                                @if($project->progress_percentage >= 75) background-color: color-mix(in oklch, #1b7a4a 15%, #ffffff); color: color-mix(in oklch, #1b7a4a, black 30%);
                                @elseif($project->progress_percentage >= 50) background-color: color-mix(in oklch, #c98028 15%, #ffffff); color: color-mix(in oklch, #c98028, black 30%);
                                @else background-color: color-mix(in oklch, #b21a50 15%, #ffffff); color: color-mix(in oklch, #b21a50, black 30%);
                                @endif">
                                @if($project->progress_percentage >= 75) On Track
                                @elseif($project->progress_percentage >= 50) In Progress
                                @else Needs Attention
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </x-base.preview-component>
        </div>

        <!-- Project Details -->
        <div class="col-span-12 lg:col-span-8">
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    <h3 class="text-lg font-medium mb-6">Project Details</h3>

                    <div class="grid grid-cols-12 gap-6">
                        <!-- Basic Info -->
                        <div class="col-span-12 md:col-span-6">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Project Code</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $project->code }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Project Name</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $project->name }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Company</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $project->company?->name ?? 'N/A' }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Department</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $project->department?->name ?? 'N/A' }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Project Manager</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $project->manager?->name ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Timeline & Budget -->
                        <div class="col-span-12 md:col-span-6">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Date</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $project->start_date?->format('M d, Y') }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">End Date</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $project->end_date?->format('M d, Y') ?? 'Not set' }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Priority</label>
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold
                                        @if($project->priority === 'critical') bg-red-100 text-red-700
                                        @elseif($project->priority === 'high') bg-orange-100 text-orange-700
                                        @elseif($project->priority === 'medium') bg-blue-100 text-blue-700
                                        @else bg-gray-100 text-gray-700
                                        @endif">
                                        {{ ucfirst($project->priority) }}
                                    </span>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Budget</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">${{ number_format($project->budget ?? 0, 2) }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Actual Cost</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">${{ number_format($project->actual_cost ?? 0, 2) }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        @if($project->description)
                        <div class="col-span-12">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $project->description }}</p>
                            </div>
                        </div>
                        @endif

                        <!-- Objectives -->
                        @if($project->objectives)
                        <div class="col-span-12 md:col-span-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Objectives</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $project->objectives }}</p>
                            </div>
                        </div>
                        @endif

                        <!-- Deliverables -->
                        @if($project->deliverables)
                        <div class="col-span-12 md:col-span-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deliverables</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $project->deliverables }}</p>
                            </div>
                        </div>
                        @endif

                        <!-- Risks -->
                        @if($project->risks)
                        <div class="col-span-12">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Risks</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $project->risks }}</p>
                            </div>
                        </div>
                        @endif

                        <!-- Notes -->
                        @if($project->notes)
                        <div class="col-span-12">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Notes</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $project->notes }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </x-base.preview-component>
        </div>

        <!-- Sidebar -->
        <div class="col-span-12 lg:col-span-4">
            <!-- Quick Actions -->
            <x-base.preview-component class="intro-y box mb-6">
                <div class="p-5">
                    <h3 class="text-lg font-medium mb-4">Quick Actions</h3>
                    <div class="space-y-3">
                        <button
                            class="btn-royal btn-royal--outline btn-royal--sm w-full justify-start"
                            onclick="editProject({{ $project->id }})"
                        >
                            <x-base.lucide icon="edit" class="w-4 h-4 mr-2" />
                            Edit Project
                        </button>

                        <button
                            class="btn-royal btn-royal--action btn-royal--danger w-full justify-start"
                            onclick="deleteProject({{ $project->id }}, '{{ addslashes($project->name) }}')"
                        >
                            <x-base.lucide icon="trash-2" class="w-4 h-4 mr-2" />
                            Delete Project
                        </button>
                    </div>
                </div>
            </x-base.preview-component>

            <!-- Project Stats -->
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    <h3 class="text-lg font-medium mb-4">Project Stats</h3>
                    <div class="space-y-4">
                        <div class="stats-card-info p-3 rounded-lg">
                            <div class="flex justify-between items-center">
                                <span class="text-sm opacity-80">Total Tasks</span>
                                <span class="text-lg font-bold">{{ $project->tasks->count() }}</span>
                            </div>
                        </div>

                        <div class="stats-card-success p-3 rounded-lg">
                            <div class="flex justify-between items-center">
                                <span class="text-sm opacity-80">Completed Tasks</span>
                                <span class="text-lg font-bold">{{ $project->tasks->where('status', 'completed')->count() }}</span>
                            </div>
                        </div>

                        <div class="stats-card-warning p-3 rounded-lg">
                            <div class="flex justify-between items-center">
                                <span class="text-sm opacity-80">Days Remaining</span>
                                <span class="text-lg font-bold">
                                    @if($project->end_date)
                                        {{ max(0, now()->diffInDays($project->end_date, false)) }}
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div class="stats-card-neutral p-3 rounded-lg">
                            <div class="flex justify-between items-center">
                                <span class="text-sm opacity-80">Days Passed</span>
                                <span class="text-lg font-bold">{{ $project->start_date ? now()->diffInDays($project->start_date) : 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </x-base.preview-component>

            <!-- Project Tasks Chart -->
            @php
                $totalTasks = $project->tasks->count();
                $completedTasks = $project->tasks->where('status', 'completed')->count();
                $inProgressTasks = $project->tasks->where('status', 'in_progress')->count();
                $pendingTasks = $project->tasks->where('status', 'pending')->count();
                $overdueTasks = $project->tasks->filter(fn($t) => $t->due_date && $t->due_date->isPast() && !in_array($t->status, ['completed', 'cancelled']))->count();
            @endphp
            @if($totalTasks > 0)
                <x-base.preview-component class="intro-y box mt-6">
                    <div class="p-5">
                        <h3 class="text-lg font-medium mb-4">Tasks Overview</h3>
                        <div class="chart-container p-4">
                            <canvas id="project-tasks-chart" width="300" height="300"></canvas>
                        </div>
                        
                        <!-- Task Stats -->
                        <div class="mt-4 space-y-2">
                            <div class="flex items-center justify-between text-sm">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full" style="background-color: color-mix(in oklch, #1b7a4a 70%, #ffffff);"></div>
                                    <span>Completed</span>
                                </div>
                                <span class="font-medium">{{ $completedTasks }}</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full" style="background-color: color-mix(in oklch, #2563eb 70%, #ffffff);"></div>
                                    <span>In Progress</span>
                                </div>
                                <span class="font-medium">{{ $inProgressTasks }}</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full" style="background-color: color-mix(in oklch, #c98028 70%, #ffffff);"></div>
                                    <span>Pending</span>
                                </div>
                                <span class="font-medium">{{ $pendingTasks }}</span>
                            </div>
                            @if($overdueTasks > 0)
                            <div class="flex items-center justify-between text-sm">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full" style="background-color: color-mix(in oklch, #b21a50 70%, #ffffff);"></div>
                                    <span>Overdue</span>
                                </div>
                                <span class="font-medium text-red-600">{{ $overdueTasks }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </x-base.preview-component>
            @endif
        </div>

        <!-- Project Tasks List - Full Width -->
        <div class="col-span-12">
            <x-base.preview-component class="intro-y box">
                <div class="flex items-center justify-between border-b border-slate-200/60 px-5 py-4 dark:border-darkmode-400">
                    <h3 class="text-lg font-medium flex items-center gap-2">
                        <x-base.lucide icon="check-square" class="w-5 h-5" />
                        Project Tasks
                        <span class="text-sm font-normal text-slate-500">({{ $totalTasks }} total)</span>
                    </h3>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('tasks.index', ['project_id' => $project->id]) }}" class="btn-royal btn-royal--outline btn-royal--sm">
                            <x-base.lucide icon="external-link" class="w-4 h-4 mr-1" />
                            View All
                        </a>
                        <button type="button" class="btn-royal btn-royal--gold btn-royal--sm" data-tw-toggle="modal" data-tw-target="#create-task-modal">
                            <x-base.lucide icon="plus" class="w-4 h-4 mr-1" />
                            Add Task
                        </button>
                    </div>
                </div>
                <div class="p-5">
                    @if($project->tasks->count() > 0)
                        <div class="space-y-3">
                            @foreach($project->tasks->sortByDesc('created_at')->take(10) as $task)
                                <a href="{{ route('tasks.show', $task) }}" class="flex items-center justify-between p-4 border border-slate-200/60 rounded-lg dark:border-darkmode-400 hover:bg-slate-50 dark:hover:bg-darkmode-600 transition-colors cursor-pointer hover:border-primary/30 group">
                                    <div class="flex items-center flex-1">
                                        @if($task->color)
                                            <div class="w-3 h-3 rounded-full mr-3 border border-white shadow-sm" style="background-color: {{ $task->color }}"></div>
                                        @else
                                            <x-base.lucide class="h-4 w-4 text-slate-400 mr-3 {{ $task->type_color }}" icon="{{ $task->type_icon }}" />
                                        @endif
                                        <div class="flex-1">
                                            <div class="font-medium text-sm group-hover:text-primary transition-colors flex items-center gap-2">
                                                {{ $task->title }}
                                                @if($task->hasSubtasks())
                                                    <span class="text-xs text-slate-400">({{ $task->subtasks->where('status', 'completed')->count() }}/{{ $task->subtasks->count() }})</span>
                                                @endif
                                            </div>
                                            <div class="text-xs text-slate-500 mt-1 flex items-center gap-3">
                                                <span class="font-mono">{{ $task->code }}</span>
                                                @if($task->employee)
                                                    <span class="flex items-center gap-1">
                                                        <x-base.lucide icon="user" class="w-3 h-3" />
                                                        {{ $task->employee->full_name }}
                                                    </span>
                                                @endif
                                                @if($task->due_date)
                                                    <span class="flex items-center gap-1 {{ $task->isOverdue() ? 'text-red-500' : '' }}">
                                                        <x-base.lucide icon="calendar" class="w-3 h-3" />
                                                        {{ $task->due_date->format('M d') }}
                                                        @if($task->isOverdue())
                                                            <span class="text-red-500 font-medium">(Overdue)</span>
                                                        @endif
                                                    </span>
                                                @endif
                                                @if($task->estimated_hours)
                                                    <span class="flex items-center gap-1">
                                                        <x-base.lucide icon="clock" class="w-3 h-3" />
                                                        {{ $task->actual_hours ?? 0 }}/{{ $task->estimated_hours }}h
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <!-- Progress -->
                                        @if($task->progress_percentage > 0)
                                            <div class="w-16 h-2 bg-slate-200 rounded-full overflow-hidden">
                                                <div class="h-full bg-primary rounded-full" style="width: {{ $task->progress_percentage }}%"></div>
                                            </div>
                                            <span class="text-xs text-slate-500 w-8">{{ $task->progress_percentage }}%</span>
                                        @endif
                                        
                                        <!-- Priority Badge -->
                                        @php
                                            $priorityClass = match($task->priority) {
                                                'high' => 'bg-red-100 text-red-700',
                                                'medium' => 'bg-yellow-100 text-yellow-700',
                                                'low' => 'bg-green-100 text-green-700',
                                                default => 'bg-gray-100 text-gray-700'
                                            };
                                        @endphp
                                        <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-semibold {{ $priorityClass }}">
                                            {{ ucfirst($task->priority) }}
                                        </span>
                                        
                                        <!-- Status Badge -->
                                        @php
                                            $statusClass = match($task->status) {
                                                'completed' => 'bg-green-100 text-green-700',
                                                'in_progress' => 'bg-blue-100 text-blue-700',
                                                'pending' => 'bg-yellow-100 text-yellow-700',
                                                'cancelled' => 'bg-red-100 text-red-700',
                                                default => 'bg-gray-100 text-gray-700'
                                            };
                                        @endphp
                                        <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-semibold {{ $statusClass }}">
                                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                        </span>
                                        
                                        <x-base.lucide class="h-4 w-4 text-slate-400 group-hover:text-primary transition-colors" icon="chevron-right" />
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        
                        @if($project->tasks->count() > 10)
                            <div class="mt-4 text-center">
                                <a href="{{ route('tasks.index', ['project_id' => $project->id]) }}" class="text-primary hover:text-primary/80 text-sm">
                                    View all {{ $project->tasks->count() }} tasks →
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="flex flex-col items-center justify-center py-10">
                            <x-base.lucide class="h-12 w-12 text-slate-400 mb-4" icon="check-square" />
                            <div class="text-slate-500 text-center mb-2">No tasks yet</div>
                            <button type="button" class="btn-royal btn-royal--gold btn-royal--sm" data-tw-toggle="modal" data-tw-target="#create-task-modal">
                                <x-base.lucide icon="plus" class="w-4 h-4 mr-1" />
                                Create First Task
                            </button>
                        </div>
                    @endif
                </div>
            </x-base.preview-component>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Project Tasks Chart
            const tasksChart = document.getElementById('project-tasks-chart');
            if (tasksChart) {
                initProjectTasksChart();
            }
        });

        function initProjectTasksChart() {
            const ctx = document.getElementById('project-tasks-chart').getContext('2d');
            
            const completedTasks = {{ $completedTasks ?? 0 }};
            const inProgressTasks = {{ $inProgressTasks ?? 0 }};
            const pendingTasks = {{ $pendingTasks ?? 0 }};
            
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Completed', 'In Progress', 'Pending'],
                    datasets: [{
                        data: [completedTasks, inProgressTasks, pendingTasks],
                        backgroundColor: [
                            'color-mix(in oklch, #1b7a4a 18%, #ffffff)', // success
                            'color-mix(in oklch, #2563eb 18%, #ffffff)',  // info
                            'color-mix(in oklch, #c98028 18%, #ffffff)'   // warning
                        ],
                        borderColor: [
                            'color-mix(in oklch, #1b7a4a, transparent 78%)',
                            'color-mix(in oklch, #2563eb, transparent 78%)',
                            'color-mix(in oklch, #c98028, transparent 78%)'
                        ],
                        borderWidth: 2,
                        hoverBackgroundColor: [
                            'color-mix(in oklch, #1b7a4a 25%, #ffffff)',
                            'color-mix(in oklch, #2563eb 25%, #ffffff)',
                            'color-mix(in oklch, #c98028 25%, #ffffff)'
                        ],
                        hoverBorderWidth: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                font: {
                                    size: 12
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    },
                    cutout: '60%',
                    animation: {
                        animateRotate: true,
                        duration: 1000
                    }
                }
            });
        }
        function editProject(id) {
            window.location.href = `{{ url('work/projects') }}/${id}/edit`;
        }

        function deleteProject(id, name) {
            if (typeof window.confirmDelete === 'function') {
                window.confirmDelete(name, function() {
                    $.ajax({
                        url: `{{ url('work/projects') }}/${id}`,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                if (typeof window.showSuccess === 'function') {
                                    window.showSuccess(response.message || 'Project deleted successfully');
                                }
                                setTimeout(() => {
                                    window.location.href = '{{ route("work.projects.index") }}';
                                }, 1500);
                            } else if (typeof window.showError === 'function') {
                                window.showError(response.message || 'Failed to delete project');
                            }
                        },
                        error: function(xhr) {
                            const msg = xhr.responseJSON?.message || 'Failed to delete project';
                            if (typeof window.showError === 'function') {
                                window.showError(msg);
                            }
                        }
                    });
                });
            }
        }
    </script>
@endpush

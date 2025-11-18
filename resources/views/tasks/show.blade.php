@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>{{ $task->title }} - Task Details</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Task Details</h2>
        <div class="flex items-center gap-2">
            <x-base.button as="a" href="{{ route('tasks.index') }}" variant="outline-secondary">
                <x-base.lucide icon="ArrowLeft" class="w-4 h-4 mr-2" />
                Back to Tasks
            </x-base.button>
            <x-base.button as="a" href="{{ route('tasks.edit', $task) }}" variant="primary">
                <x-base.lucide icon="Edit" class="w-4 h-4 mr-2" />
                Edit Task
            </x-base.button>
        </div>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <!-- Task Information -->
        <div class="col-span-12 lg:col-span-8">
            <div class="intro-y box">
                <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400">
                    <div class="flex items-center gap-3">
                        @if($task->color)
                            <div class="w-4 h-4 rounded-full border border-white shadow-sm" style="background-color: {{ $task->color }}"></div>
                        @endif
                        <h2 class="mr-auto text-lg font-medium">{{ $task->title }}</h2>
                    </div>
                    <div class="flex items-center gap-2">
                        <!-- Priority Badge -->
                        @php
                            $priorityClass = match($task->priority) {
                                'high' => 'bg-red-100 text-red-700',
                                'medium' => 'bg-yellow-100 text-yellow-700',
                                'low' => 'bg-green-100 text-green-700',
                                default => 'bg-gray-100 text-gray-700'
                            };
                        @endphp
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-semibold {{ $priorityClass }}">
                            {{ ucfirst($task->priority) }} Priority
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
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-semibold {{ $statusClass }}">
                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                        </span>
                    </div>
                </div>
                
                <div class="p-5">
                    <!-- Task Code -->
                    <div class="mb-6">
                        <div class="text-sm text-slate-500 mb-1">Task Code</div>
                        <div class="font-mono text-lg">{{ $task->code }}</div>
                    </div>

                    <!-- Description -->
                    @if($task->description)
                        <div class="mb-6">
                            <div class="text-sm text-slate-500 mb-2">Description</div>
                            <div class="prose max-w-none">
                                {!! nl2br(e($task->description)) !!}
                            </div>
                        </div>
                    @endif

                    <!-- Task Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Due Date -->
                        @if($task->due_date)
                            <div>
                                <div class="text-sm text-slate-500 mb-1">Due Date</div>
                                <div class="flex items-center gap-2">
                                    <x-base.lucide icon="Calendar" class="w-4 h-4 text-slate-400" />
                                    <span class="font-medium">{{ $task->due_date->format('M d, Y') }}</span>
                                    @if($task->due_date->isPast() && $task->status !== 'completed')
                                        <span class="text-red-500 text-sm">(Overdue)</span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Estimated Hours -->
                        @if($task->estimated_hours)
                            <div>
                                <div class="text-sm text-slate-500 mb-1">Estimated Hours</div>
                                <div class="flex items-center gap-2">
                                    <x-base.lucide icon="Clock" class="w-4 h-4 text-slate-400" />
                                    <span class="font-medium">{{ $task->estimated_hours }} hours</span>
                                </div>
                            </div>
                        @endif

                        <!-- Tags -->
                        @if($task->tags)
                            <div class="md:col-span-2">
                                <div class="text-sm text-slate-500 mb-2">Tags</div>
                                <div class="flex flex-wrap gap-2">
                                    @foreach(explode(',', $task->tags) as $tag)
                                        <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700">
                                            {{ trim($tag) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Created/Updated Info -->
                    <div class="border-t border-slate-200/60 pt-4 dark:border-darkmode-400">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-slate-500">
                            <div>
                                <span class="font-medium">Created:</span> {{ $task->created_at->format('M d, Y \a\t H:i') }}
                            </div>
                            <div>
                                <span class="font-medium">Last Updated:</span> {{ $task->updated_at->format('M d, Y \a\t H:i') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Task Timeline -->
            @if($task->steps->count() > 0)
                <div class="intro-y box mt-6">
                    <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400">
                        <h2 class="mr-auto text-lg font-medium">Task Timeline</h2>
                    </div>
                    <div class="p-5">
                        <x-task-timeline :task="$task" />
                    </div>
                </div>
            @endif

            <!-- Task Comments -->
            <div class="intro-y box mt-6">
                <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400">
                    <h2 class="mr-auto text-lg font-medium">Comments</h2>
                    <span class="text-sm text-slate-500">{{ $task->taskComments->count() }} comments</span>
                </div>
                <div class="p-5">
                    <!-- Add Comment Form -->
                    <div class="mb-6">
                        <form id="add-comment-form" class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                    Add your comment
                                </label>
                                <x-base.classic-editor id="comment-editor">
                                    <p>Write your comment here...</p>
                                </x-base.classic-editor>
                            </div>
                            <div class="flex items-center justify-between">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="is_internal" class="rounded border-slate-300 text-primary shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-slate-600 dark:text-slate-400">Internal comment (not visible to client)</span>
                                </label>
                                <x-base.button type="submit" variant="primary" size="sm">
                                    <x-base.lucide icon="Send" class="w-4 h-4 mr-1" />
                                    Add Comment
                                </x-base.button>
                            </div>
                        </form>
                    </div>

                    <!-- Comments List -->
                    <div id="comments-list" class="space-y-4">
                        @forelse($task->taskComments as $comment)
                            <div class="comment-item flex gap-3 p-4 bg-slate-50 dark:bg-darkmode-600 rounded-lg">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center text-sm font-semibold">
                                        {{ strtoupper(substr($comment->user->name ?? 'U', 0, 1)) }}
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="font-medium text-sm text-slate-700 dark:text-slate-300">
                                            {{ $comment->user->name ?? 'Unknown User' }}
                                        </span>
                                        <span class="text-xs text-slate-500">{{ $comment->time_ago }}</span>
                                        @if($comment->is_internal)
                                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Internal
                                            </span>
                                        @endif
                                    </div>
                                    <div class="text-sm text-slate-600 dark:text-slate-400 prose prose-sm max-w-none">
                                        {!! $comment->comment !!}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-slate-500">
                                <x-base.lucide icon="MessageSquare" class="w-12 h-12 mx-auto mb-2 text-slate-300" />
                                <p>No comments yet. Be the first to add a comment!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-span-12 lg:col-span-4">
            <!-- Assignment Info -->
            <div class="intro-y box mb-6">
                <div class="flex items-center border-b border-slate-200/60 px-5 py-3 dark:border-darkmode-400">
                    <h3 class="text-base font-medium">Assignment</h3>
                </div>
                <div class="p-5 space-y-4">
                    <!-- Assigned Employee -->
                    @if($task->employee)
                        <div>
                            <div class="text-sm text-slate-500 mb-2">Assigned To</div>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center">
                                    <x-base.lucide icon="User" class="w-4 h-4 text-slate-500" />
                                </div>
                                <div>
                                    <div class="font-medium">{{ $task->employee->full_name }}</div>
                                    @if($task->employee->department)
                                        <div class="text-xs text-slate-500">{{ $task->employee->department->name }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Project -->
                    @if($task->project)
                        <div>
                            <div class="text-sm text-slate-500 mb-2">Project</div>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center">
                                    <x-base.lucide icon="Folder" class="w-4 h-4 text-slate-500" />
                                </div>
                                <div>
                                    <div class="font-medium">{{ $task->project->name }}</div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Assigned By -->
                    @if($task->assignedBy)
                        <div>
                            <div class="text-sm text-slate-500 mb-2">Assigned By</div>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center">
                                    <x-base.lucide icon="UserCheck" class="w-4 h-4 text-slate-500" />
                                </div>
                                <div>
                                    <div class="font-medium">{{ $task->assignedBy->name }}</div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Task Progress Chart -->
            @if($task->steps->count() > 0)
                <div class="intro-y box mb-6">
                    <div class="flex items-center border-b border-slate-200/60 px-5 py-3 dark:border-darkmode-400">
                        <h3 class="text-base font-medium">Progress Overview</h3>
                    </div>
                    <div class="p-5">
                        <div class="w-auto h-[400px] chart-container p-4">
                            <canvas class="chart donut-chart" id="task-progress-chart"></canvas>
                        </div>
                        
                        @php
                            $totalSteps = $task->steps->count();
                            $completedSteps = $task->steps->where('is_completed', true)->count();
                            $pendingSteps = $totalSteps - $completedSteps;
                            $progressPercentage = $totalSteps > 0 ? round(($completedSteps / $totalSteps) * 100) : 0;
                        @endphp
                        
                        <!-- Progress Stats -->
                        <div class="mt-4 grid grid-cols-3 gap-4 text-center">
                            <div class="p-3 rounded-lg stats-card-success">
                                <div class="text-2xl font-bold">{{ $completedSteps }}</div>
                                <div class="text-xs opacity-80">Completed</div>
                            </div>
                            <div class="p-3 rounded-lg stats-card-warning">
                                <div class="text-2xl font-bold">{{ $pendingSteps }}</div>
                                <div class="text-xs opacity-80">Pending</div>
                            </div>
                            <div class="p-3 rounded-lg stats-card-info">
                                <div class="text-2xl font-bold">{{ $progressPercentage }}%</div>
                                <div class="text-xs opacity-80">Progress</div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Task Status Chart (when no steps) -->
                <div class="intro-y box mb-6">
                    <div class="flex items-center border-b border-slate-200/60 px-5 py-3 dark:border-darkmode-400">
                        <h3 class="text-base font-medium">Task Status</h3>
                    </div>
                    <div class="p-5">
                        <div class="w-auto h-[300px] chart-container p-4">
                            <canvas class="chart donut-chart" id="task-status-chart"></canvas>
                        </div>
                        
                        <!-- Status Info -->
                        <div class="mt-4 text-center">
                            <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium
                                @if($task->status === 'completed') stats-card-success
                                @elseif($task->status === 'in_progress') stats-card-info
                                @elseif($task->status === 'pending') stats-card-warning
                                @elseif($task->status === 'cancelled') stats-card-danger
                                @else stats-card-neutral
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Quick Actions -->
            <div class="intro-y box">
                <div class="flex items-center border-b border-slate-200/60 px-5 py-3 dark:border-darkmode-400">
                    <h3 class="text-base font-medium">Quick Actions</h3>
                </div>
                <div class="p-5 space-y-3">
                    @if($task->status !== 'completed')
                        <x-base.button 
                            variant="success" 
                            class="w-full complete-task-btn" 
                            data-task-id="{{ $task->id }}"
                        >
                            <x-base.lucide icon="Check" class="w-4 h-4 mr-2" />
                            Mark as Completed
                        </x-base.button>
                    @endif
                    
                    @if($task->status === 'pending')
                        <x-base.button 
                            variant="primary" 
                            class="w-full start-task-btn"
                            data-task-id="{{ $task->id }}"
                        >
                            <x-base.lucide icon="Play" class="w-4 h-4 mr-2" />
                            Start Working
                        </x-base.button>
                    @endif

                    <x-base.button 
                        variant="outline-secondary" 
                        class="w-full add-comment-btn"
                        data-task-id="{{ $task->id }}"
                    >
                        <x-base.lucide icon="MessageSquare" class="w-4 h-4 mr-2" />
                        Add Comment
                    </x-base.button>

                    <x-base.button 
                        variant="outline-secondary" 
                        class="w-full share-task-btn"
                        data-task-id="{{ $task->id }}"
                    >
                        <x-base.lucide icon="Share" class="w-4 h-4 mr-2" />
                        Share Task
                    </x-base.button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    /* Chart Colors - Using btn-tonal colors */
    :root {
        --chart-success: #1b7a4a;
        --chart-warning: #c98028;
        --chart-info: #2563eb;
        --chart-danger: #b21a50;
        --chart-neutral: #6b7280;
    }
    
    /* Tonal background styles for stats cards */
    .stats-card-success {
        background-color: color-mix(in oklch, var(--chart-success) 18%, #ffffff);
        border: 1px solid color-mix(in oklch, var(--chart-success), transparent 78%);
        color: color-mix(in oklch, var(--chart-success), black 22%);
    }
    
    .stats-card-warning {
        background-color: color-mix(in oklch, var(--chart-warning) 18%, #ffffff);
        border: 1px solid color-mix(in oklch, var(--chart-warning), transparent 78%);
        color: color-mix(in oklch, var(--chart-warning), black 22%);
    }
    
    .stats-card-info {
        background-color: color-mix(in oklch, var(--chart-info) 18%, #ffffff);
        border: 1px solid color-mix(in oklch, var(--chart-info), transparent 78%);
        color: color-mix(in oklch, var(--chart-info), black 22%);
    }
    
    .stats-card-danger {
        background-color: color-mix(in oklch, var(--chart-danger) 18%, #ffffff);
        border: 1px solid color-mix(in oklch, var(--chart-danger), transparent 78%);
        color: color-mix(in oklch, var(--chart-danger), black 22%);
    }
    
    .stats-card-neutral {
        background-color: color-mix(in oklch, var(--chart-neutral) 18%, #ffffff);
        border: 1px solid color-mix(in oklch, var(--chart-neutral), transparent 78%);
        color: color-mix(in oklch, var(--chart-neutral), black 22%);
    }
    
    /* Chart containers with btn-tonal styling */
    .chart-container {
        background-color: color-mix(in oklch, var(--chart-info) 5%, #ffffff);
        border: 1px solid color-mix(in oklch, var(--chart-info), transparent 90%);
        border-radius: 0.5rem;
        box-shadow: 0 4px 12px color-mix(in oklch, var(--chart-info), transparent 90%);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .chart-container:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 20px color-mix(in oklch, var(--chart-info), transparent 85%);
    }

    /* Comment prose styling */
    .comment-item .prose {
        color: inherit;
    }
    
    .comment-item .prose p {
        margin: 0.5em 0;
    }
    
    .comment-item .prose p:first-child {
        margin-top: 0;
    }
    
    .comment-item .prose p:last-child {
        margin-bottom: 0;
    }
    
    .comment-item .prose strong {
        font-weight: 600;
        color: inherit;
    }
    
    .comment-item .prose em {
        font-style: italic;
    }
    
    .comment-item .prose ul,
    .comment-item .prose ol {
        margin: 0.5em 0;
        padding-left: 1.5em;
    }
    
    .comment-item .prose li {
        margin: 0.25em 0;
    }
    
    .comment-item .prose blockquote {
        border-left: 4px solid #e2e8f0;
        padding-left: 1em;
        margin: 0.5em 0;
        font-style: italic;
        color: #64748b;
    }
    
    .comment-item .prose code {
        background-color: #f1f5f9;
        padding: 0.125em 0.25em;
        border-radius: 0.25rem;
        font-size: 0.875em;
        font-family: ui-monospace, SFMono-Regular, "SF Mono", Consolas, "Liberation Mono", Menlo, monospace;
    }
    
    .dark .comment-item .prose blockquote {
        border-left-color: #475569;
        color: #94a3b8;
    }
    
    .dark .comment-item .prose code {
        background-color: #334155;
        color: #e2e8f0;
    }
</style>
@endpush

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('🎯 Task details page loaded');

    // Wait for CKEditor to be ready
    let editorReady = false;
    let commentEditor = null;

    // Check for CKEditor initialization
    const checkEditor = setInterval(() => {
        const editorElement = document.querySelector('#comment-editor .ck-editor');
        if (editorElement && window.ClassicEditor) {
            // Try to find the editor instance
            const editorContainer = document.querySelector('#comment-editor .editor');
            if (editorContainer && editorContainer.ckeditorInstance) {
                commentEditor = editorContainer.ckeditorInstance;
                editorReady = true;
                console.log('✅ CKEditor ready');
                clearInterval(checkEditor);
            }
        }
    }, 500);

    // Clear interval after 10 seconds to avoid infinite checking
    setTimeout(() => {
        clearInterval(checkEditor);
        if (!editorReady) {
            console.log('⚠️ CKEditor not found, using fallback');
        }
    }, 10000);

    // Initialize Task Progress Chart
    const progressChart = document.getElementById('task-progress-chart');
    if (progressChart) {
        initTaskProgressChart();
    }

    // Initialize Task Status Chart (for tasks without steps)
    const statusChart = document.getElementById('task-status-chart');
    if (statusChart) {
        initTaskStatusChart();
    }

    function initTaskProgressChart() {
        // Get task progress data from PHP
        const totalSteps = {{ $task->steps->count() ?? 0 }};
        const completedSteps = {{ $task->steps->where('is_completed', true)->count() ?? 0 }};
        const pendingSteps = totalSteps - completedSteps;

        if (totalSteps === 0) {
            // Show "No Steps" message
            const chartContainer = progressChart.parentElement;
            chartContainer.innerHTML = `
                <div class="flex items-center justify-center h-[400px] text-slate-500">
                    <div class="text-center">
                        <svg class="w-16 h-16 mx-auto mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <p class="text-lg font-medium">No Timeline Steps</p>
                        <p class="text-sm">Add steps to see progress visualization</p>
                    </div>
                </div>
            `;
            return;
        }

        // Chart.js configuration
        const ctx = progressChart.getContext('2d');
        
        // Check if Chart.js is available
        if (typeof Chart === 'undefined') {
            console.error('Chart.js not found');
            return;
        }

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Completed Steps', 'Pending Steps'],
                datasets: [{
                    data: [completedSteps, pendingSteps],
                    backgroundColor: [
                        'color-mix(in oklch, #1b7a4a 18%, #ffffff)', // btn-tonal success background
                        'color-mix(in oklch, #c98028 18%, #ffffff)'  // btn-tonal warning background
                    ],
                    borderColor: [
                        'color-mix(in oklch, #1b7a4a, transparent 78%)', // btn-tonal success border
                        'color-mix(in oklch, #c98028, transparent 78%)'  // btn-tonal warning border
                    ],
                    borderWidth: 2,
                    hoverBackgroundColor: [
                        'color-mix(in oklch, #1b7a4a 25%, #ffffff)', // darker on hover
                        'color-mix(in oklch, #c98028 25%, #ffffff)'  // darker on hover
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
                                size: 14
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
                cutout: '60%', // Makes it a donut chart
                animation: {
                    animateRotate: true,
                    duration: 1000
                }
            }
        });

        console.log('📊 Task progress chart initialized');
    }

    function initTaskStatusChart() {
        const taskStatus = '{{ $task->status }}';
        const ctx = statusChart.getContext('2d');
        
        // Check if Chart.js is available
        if (typeof Chart === 'undefined') {
            console.error('Chart.js not found');
            return;
        }

        // Define status colors and data
        let chartData, chartColors;
        
        // Define btn-tonal style colors with color-mix
        const neutralColor = '#e5e7eb';
        
        switch(taskStatus) {
            case 'completed':
                chartData = [100, 0, 0, 0];
                chartColors = [
                    'color-mix(in oklch, #1b7a4a 18%, #ffffff)', // success background
                    neutralColor, neutralColor, neutralColor
                ];
                break;
            case 'in_progress':
                chartData = [0, 100, 0, 0];
                chartColors = [
                    neutralColor, 
                    'color-mix(in oklch, #2563eb 18%, #ffffff)', // info background
                    neutralColor, neutralColor
                ];
                break;
            case 'pending':
                chartData = [0, 0, 100, 0];
                chartColors = [
                    neutralColor, neutralColor, 
                    'color-mix(in oklch, #c98028 18%, #ffffff)', // warning background
                    neutralColor
                ];
                break;
            case 'cancelled':
                chartData = [0, 0, 0, 100];
                chartColors = [
                    neutralColor, neutralColor, neutralColor, 
                    'color-mix(in oklch, #b21a50 18%, #ffffff)' // danger background
                ];
                break;
            default:
                chartData = [0, 0, 100, 0];
                chartColors = [
                    neutralColor, neutralColor, 
                    'color-mix(in oklch, #c98028 18%, #ffffff)', // warning background
                    neutralColor
                ];
        }

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'In Progress', 'Pending', 'Cancelled'],
                datasets: [{
                    data: chartData,
                    backgroundColor: chartColors,
                    borderColor: chartColors.map(color => {
                        if (color === '#e5e7eb') return '#d1d5db';
                        if (color.includes('#1b7a4a')) return 'color-mix(in oklch, #1b7a4a, transparent 78%)';
                        if (color.includes('#2563eb')) return 'color-mix(in oklch, #2563eb, transparent 78%)';
                        if (color.includes('#c98028')) return 'color-mix(in oklch, #c98028, transparent 78%)';
                        if (color.includes('#b21a50')) return 'color-mix(in oklch, #b21a50, transparent 78%)';
                        return color;
                    }),
                    borderWidth: 2,
                    hoverBackgroundColor: chartColors.map(color => {
                        if (color === '#e5e7eb') return '#d1d5db';
                        if (color.includes('#1b7a4a')) return 'color-mix(in oklch, #1b7a4a 25%, #ffffff)';
                        if (color.includes('#2563eb')) return 'color-mix(in oklch, #2563eb 25%, #ffffff)';
                        if (color.includes('#c98028')) return 'color-mix(in oklch, #c98028 25%, #ffffff)';
                        if (color.includes('#b21a50')) return 'color-mix(in oklch, #b21a50 25%, #ffffff)';
                        return color;
                    }),
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
                                size: 14
                            },
                            filter: function(legendItem, chartData) {
                                // Only show the active status in legend
                                const index = legendItem.index;
                                return chartData.datasets[0].data[index] > 0;
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + (context.parsed > 0 ? 'Active' : 'Inactive');
                            }
                        }
                    }
                },
                cutout: '70%', // Makes it a donut chart
                animation: {
                    animateRotate: true,
                    duration: 1000
                }
            }
        });

        console.log('📊 Task status chart initialized');
    }

    // Complete Task Button
    const completeTaskBtn = document.querySelector('.complete-task-btn');
    if (completeTaskBtn) {
        completeTaskBtn.addEventListener('click', function() {
            const taskId = this.getAttribute('data-task-id');
            console.log('✅ Complete task clicked:', taskId);
            
            if (confirm('Are you sure you want to mark this task as completed?')) {
                updateTaskStatus(taskId, 'completed');
            }
        });
    }

    // Start Task Button
    const startTaskBtn = document.querySelector('.start-task-btn');
    if (startTaskBtn) {
        startTaskBtn.addEventListener('click', function() {
            const taskId = this.getAttribute('data-task-id');
            console.log('▶️ Start task clicked:', taskId);
            
            updateTaskStatus(taskId, 'in_progress');
        });
    }

    // Add Comment Button
    const addCommentBtn = document.querySelector('.add-comment-btn');
    if (addCommentBtn) {
        addCommentBtn.addEventListener('click', function() {
            const taskId = this.getAttribute('data-task-id');
            console.log('💬 Add comment clicked:', taskId);
            
            showCommentModal(taskId);
        });
    }

    // Share Task Button
    const shareTaskBtn = document.querySelector('.share-task-btn');
    if (shareTaskBtn) {
        shareTaskBtn.addEventListener('click', function() {
            const taskId = this.getAttribute('data-task-id');
            console.log('📤 Share task clicked:', taskId);
            
            shareTask(taskId);
        });
    }

    // Update Task Status Function
    function updateTaskStatus(taskId, status) {
        fetch(`/tasks/${taskId}/update-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (typeof showToast === 'function') {
                    showToast(data.message || 'Task status updated successfully', 'success');
                }
                // Reload page to show updated status
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                if (typeof showToast === 'function') {
                    showToast(data.message || 'Failed to update task status', 'error');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (typeof showToast === 'function') {
                showToast('An error occurred while updating task status', 'error');
            }
        });
    }

    // Show Comment Modal Function
    function showCommentModal(taskId) {
        // Simple prompt for now - can be enhanced with a proper modal later
        const comment = prompt('Add your comment:');
        if (comment && comment.trim()) {
            addTaskComment(taskId, comment.trim());
        }
    }

    // Add Task Comment Function
    function addTaskComment(taskId, comment, isInternal = false) {
        fetch(`/tasks/${taskId}/comments`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ 
                comment: comment,
                is_internal: isInternal
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (typeof showToast === 'function') {
                    showToast(data.message || 'Comment added successfully', 'success');
                }
                // Reload page to show new comment
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                if (typeof showToast === 'function') {
                    showToast(data.message || 'Failed to add comment', 'error');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (typeof showToast === 'function') {
                showToast('An error occurred while adding comment', 'error');
            }
        });
    }

    // Handle comment form submission
    const commentForm = document.getElementById('add-comment-form');
    if (commentForm) {
        commentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get comment content from CKEditor
            let comment = '';
            
            if (commentEditor && editorReady) {
                // Use the stored editor instance
                comment = commentEditor.getData().trim();
            } else {
                // Fallback: try to find editor instance
                const editorElement = document.querySelector('#comment-editor .ck-editor__editable');
                if (editorElement) {
                    comment = editorElement.innerHTML.trim();
                } else {
                    // Last resort: get from any editor element
                    const fallbackElement = document.querySelector('#comment-editor .editor');
                    if (fallbackElement) {
                        comment = fallbackElement.innerHTML.trim();
                    }
                }
            }
            
            const isInternalCheckbox = document.querySelector('input[name="is_internal"]');
            const isInternal = isInternalCheckbox.checked;
            
            // Remove empty paragraph tags
            const cleanComment = comment.replace(/<p><\/p>/g, '').replace(/<p><br><\/p>/g, '').trim();
            
            if (cleanComment && cleanComment !== '<p>Write your comment here...</p>') {
                const taskId = document.querySelector('.complete-task-btn, .start-task-btn, .add-comment-btn')?.getAttribute('data-task-id');
                if (taskId) {
                    addTaskComment(taskId, cleanComment, isInternal);
                    
                    // Clear editor content
                    if (commentEditor && editorReady) {
                        commentEditor.setData('<p>Write your comment here...</p>');
                    } else {
                        // Fallback: clear editor content
                        const editorElement = document.querySelector('#comment-editor .ck-editor__editable');
                        if (editorElement) {
                            editorElement.innerHTML = '<p>Write your comment here...</p>';
                        }
                    }
                    
                    isInternalCheckbox.checked = false;
                }
            } else {
                if (typeof showToast === 'function') {
                    showToast('Please enter a comment', 'warning');
                }
            }
        });
    }

    // Share Task Function
    function shareTask(taskId) {
        const taskUrl = window.location.href;
        
        if (navigator.share) {
            // Use Web Share API if available
            navigator.share({
                title: 'Task Details',
                text: 'Check out this task',
                url: taskUrl
            }).then(() => {
                console.log('📤 Task shared successfully');
            }).catch(err => {
                console.log('📤 Share cancelled');
            });
        } else {
            // Fallback: copy to clipboard
            navigator.clipboard.writeText(taskUrl).then(() => {
                if (typeof showToast === 'function') {
                    showToast('Task link copied to clipboard!', 'success');
                }
            }).catch(err => {
                console.error('Failed to copy: ', err);
                if (typeof showToast === 'function') {
                    showToast('Failed to copy link', 'error');
                }
            });
        }
    }
});
</script>
@endpush

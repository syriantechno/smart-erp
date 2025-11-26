@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>{{ $task->title }} - Task Details</title>
@endsection

@php
    $priorityClass = match($task->priority) {
        'high' => 'bg-red-100 text-red-700',
        'medium' => 'bg-yellow-100 text-yellow-700',
        'low' => 'bg-green-100 text-green-700',
        default => 'bg-gray-100 text-gray-700'
    };
    $statusClass = match($task->status) {
        'completed' => 'bg-green-100 text-green-700',
        'in_progress' => 'bg-blue-100 text-blue-700',
        'pending' => 'bg-yellow-100 text-yellow-700',
        'cancelled' => 'bg-red-100 text-red-700',
        default => 'bg-gray-100 text-gray-700'
    };
    $totalSteps = $task->steps->count();
    $completedSteps = $task->steps->where('is_completed', true)->count();
    $pendingSteps = $totalSteps - $completedSteps;
    $progressPercentage = $totalSteps > 0 ? round(($completedSteps / $totalSteps) * 100) : 0;
@endphp

@section('subcontent')
    <div class="intro-y mt-8 space-y-6">
        <!-- Header -->
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Task Details</p>
                <h1 class="text-2xl font-semibold text-slate-800 dark:text-slate-100">
                    {{ $task->code }} — {{ $task->title }}
                </h1>
            </div>
<a href="{{ route('tasks.index') }}" class="btn-royal btn-royal--outline btn-royal--sm">
                Back to list
            </a>
        </div>

        <!-- Main Content Box -->
        <x-base.preview-component class="box">
            <div class="space-y-6 p-5">
                <!-- Task Header Info -->
                <div class="flex flex-col gap-3 rounded-2xl border border-slate-200/70 bg-slate-50/60 p-4 dark:border-darkmode-400 dark:bg-darkmode-600/30">
                    <div class="flex flex-wrap items-center gap-3">
                        @if($task->color)
                            <div class="w-6 h-6 rounded-full border-2 border-white shadow-sm" style="background-color: {{ $task->color }}"></div>
                        @endif
                        <div class="flex-1 min-w-[200px]">
                            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">Task</p>
                            <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100">{{ $task->title }}</h3>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-semibold {{ $priorityClass }}">
                                {{ ucfirst($task->priority) }}
                            </span>
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-semibold {{ $statusClass }}">
                                {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-12 gap-6">
                    <!-- Left Column -->
                    <div class="col-span-12 lg:col-span-8 space-y-6">
                        <!-- General Information -->
                        <div class="rounded-xl border border-slate-200/70 p-5 dark:border-darkmode-400">
                            <h2 class="text-sm font-semibold text-slate-600 mb-4">General Information</h2>
                            <div class="grid flex-1 grid-cols-1 gap-4 text-sm md:grid-cols-2">
                                <div>
                                    <p class="text-xs text-slate-500">Task Code</p>
                                    <p class="font-medium font-mono">{{ $task->code }}</p>
                                </div>
                                @if($task->due_date)
                                    <div>
                                        <p class="text-xs text-slate-500">Due Date</p>
                                        <p class="font-medium">{{ $task->due_date->format('M d, Y') }}
                                            @if($task->due_date->isPast() && $task->status !== 'completed')
                                                <span class="text-red-500 text-xs">(Overdue)</span>
                                            @endif
                                        </p>
                                    </div>
                                @endif
                                @if($task->estimated_hours)
                                    <div>
                                        <p class="text-xs text-slate-500">Estimated Hours</p>
                                        <p class="font-medium">{{ $task->estimated_hours }} hours</p>
                                    </div>
                                @endif
                                @if($task->employee)
                                    <div>
                                        <p class="text-xs text-slate-500">Assigned To</p>
                                        <a href="{{ route('hr.employees.show', $task->employee) }}" 
                                           class="font-medium text-primary hover:text-primary/80 hover:underline transition-colors"
                                           target="_blank">
                                            {{ $task->employee->full_name }}
                                            <x-base.lucide icon="external-link" class="w-3 h-3 inline-block ml-1" />
                                        </a>
                                    </div>
                                @endif
                                @if($task->project)
                                    <div>
                                        <p class="text-xs text-slate-500">Project</p>
                                        <p class="font-medium">{{ $task->project->name }}</p>
                                    </div>
                                @endif
                                @if($task->assignedBy)
                                    <div>
                                        <p class="text-xs text-slate-500">Assigned By</p>
                                        <p class="font-medium">{{ $task->assignedBy->name }}</p>
                                    </div>
                                @endif
                            </div>

                            @if($task->description)
                                <div class="mt-4 pt-4 border-t border-slate-200/60">
                                    <p class="text-xs text-slate-500 mb-2">Description</p>
                                    <p class="text-slate-600">{{ $task->description }}</p>
                                </div>
                            @endif

                            @if($task->tags)
                                <div class="mt-4 pt-4 border-t border-slate-200/60">
                                    <p class="text-xs text-slate-500 mb-2">Tags</p>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach(explode(',', $task->tags) as $tag)
                                            <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700">{{ trim($tag) }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Task Timeline -->
                        @if($task->steps->count() > 0)
                            <div class="rounded-xl border border-slate-200/70 p-5 dark:border-darkmode-400">
                                <h2 class="text-sm font-semibold text-slate-600 mb-4">Task Timeline</h2>
                                <x-task-timeline :task="$task" />
                            </div>
                        @endif

                        <!-- Task Comments -->
                        <div class="rounded-xl border border-slate-200/70 p-5 dark:border-darkmode-400">
                            <h2 class="text-sm font-semibold text-slate-600 mb-4">Comments ({{ $task->taskComments->count() }})</h2>
                            
                            <!-- Add Comment Form -->
                            <div class="mb-6">
                                <form id="add-comment-form" class="space-y-3">
                                    @csrf
                                    <textarea 
                                        id="comment-text" 
                                        name="comment" 
                                        rows="3" 
                                        placeholder="Write your comment here..."
                                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-darkmode-400 dark:bg-darkmode-700 resize-none"
                                        required
                                    ></textarea>
                                    <div class="flex items-center justify-between">
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="is_internal" id="is_internal" class="rounded border-slate-300 text-primary">
                                            <span class="ml-2 text-sm text-slate-600">Internal comment</span>
                                        </label>
<button type="submit" class="btn-royal btn-royal--gold btn-royal--sm">Add Comment</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Comments List -->
                            <div id="comments-list" class="space-y-4">
                                @forelse($task->taskComments->sortByDesc('created_at') as $comment)
                                    <div class="comment-item flex gap-3 p-4 bg-slate-50 dark:bg-darkmode-600 rounded-lg" data-comment-id="{{ $comment->id }}">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 bg-gradient-to-br from-primary to-primary/70 text-white rounded-full flex items-center justify-center text-sm font-semibold shadow-md">
                                                {{ strtoupper(substr($comment->user->name ?? 'U', 0, 1)) }}
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between mb-2">
                                                <div class="flex items-center gap-2 flex-wrap">
                                                    <span class="font-semibold text-sm text-slate-800 dark:text-slate-200">
                                                        {{ $comment->user->name ?? 'Unknown User' }}
                                                    </span>
                                                    <span class="text-xs text-slate-500">{{ $comment->time_ago }}</span>
                                                    @if($comment->is_internal)
                                                        <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium bg-yellow-100 text-yellow-800">
                                                            Internal
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
<div class="text-sm text-slate-600 dark:text-slate-400 mb-3">
                                                {!! nl2br(e($comment->comment)) !!}
                                            </div>
                                            <!-- Comment Reactions -->
                                            <div class="flex items-center gap-3">
                                                <button type="button" 
                                                        class="reaction-btn flex items-center gap-1 px-2 py-1 rounded-full text-xs transition-all {{ $comment->user_reaction === 'like' ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600 hover:bg-green-50 hover:text-green-600' }}"
                                                        data-comment-id="{{ $comment->id }}"
                                                        data-type="like">
                                                    <x-base.lucide icon="thumbs-up" class="w-3.5 h-3.5" />
                                                    <span class="likes-count">{{ $comment->likes_count }}</span>
                                                </button>
                                                <button type="button" 
                                                        class="reaction-btn flex items-center gap-1 px-2 py-1 rounded-full text-xs transition-all {{ $comment->user_reaction === 'dislike' ? 'bg-red-100 text-red-700' : 'bg-slate-100 text-slate-600 hover:bg-red-50 hover:text-red-600' }}"
                                                        data-comment-id="{{ $comment->id }}"
                                                        data-type="dislike">
                                                    <x-base.lucide icon="thumbs-down" class="w-3.5 h-3.5" />
                                                    <span class="dislikes-count">{{ $comment->dislikes_count }}</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div id="no-comments-message" class="text-center py-8 text-slate-500">
                                        <x-base.lucide icon="message-square" class="w-12 h-12 mx-auto mb-2 text-slate-300" />
                                        <p>No comments yet. Be the first to add a comment!</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Right Column (Sidebar) -->
                    <div class="col-span-12 lg:col-span-4 space-y-6">
                        <!-- Summary -->
                        <div class="rounded-xl border border-slate-200/70 p-5 dark:border-darkmode-400">
                            <h2 class="text-sm font-semibold text-slate-600 mb-4">Summary</h2>
                            <dl class="space-y-3 text-sm">
                                <div class="flex justify-between">
                                    <dt>Status</dt>
                                    <dd class="font-semibold capitalize">{{ str_replace('_', ' ', $task->status) }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt>Priority</dt>
                                    <dd class="font-semibold capitalize">{{ $task->priority }}</dd>
                                </div>
                                @if($totalSteps > 0)
                                    <div class="flex justify-between">
                                        <dt>Progress</dt>
                                        <dd class="font-semibold">{{ $progressPercentage }}%</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt>Steps</dt>
                                        <dd class="font-semibold">{{ $completedSteps }}/{{ $totalSteps }}</dd>
                                    </div>
                                @endif
                            </dl>
                        </div>

                        <!-- Like Task -->
                        <div class="rounded-xl border border-slate-200/70 p-5 dark:border-darkmode-400">
                            <h2 class="text-sm font-semibold text-slate-600 mb-4">Rate This Task</h2>
                            <div class="flex flex-col items-center gap-3">
                                <button type="button" 
                                        id="task-like-btn"
                                        class="task-like-btn flex items-center gap-2 px-6 py-3 rounded-xl text-lg font-semibold transition-all {{ $task->is_liked_by_user ? 'bg-gradient-to-r from-pink-500 to-red-500 text-white shadow-lg' : 'bg-slate-100 text-slate-600 hover:bg-pink-50 hover:text-pink-600' }}"
                                        data-task-id="{{ $task->id }}">
                                    <x-base.lucide icon="heart" class="w-6 h-6 {{ $task->is_liked_by_user ? 'fill-current' : '' }}" />
                                    <span id="task-likes-count">{{ $task->likes_count }}</span>
                                </button>
                                <p class="text-xs text-slate-500">Like this task to appreciate the work!</p>
                                @if($task->employee)
                                    <p class="text-xs text-slate-400">Points go to: 
                                        <a href="{{ route('hr.employees.show', $task->employee) }}" 
                                           class="font-semibold text-primary hover:underline" 
                                           target="_blank">{{ $task->employee->full_name }}</a>
                                    </p>
                                @endif
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="rounded-xl border border-slate-200/70 p-5 dark:border-darkmode-400">
                            <h2 class="text-sm font-semibold text-slate-600 mb-4">Quick Actions</h2>
                            <div class="space-y-3">
                                @if($task->status !== 'completed')
                                    <button type="button" class="btn-royal btn-royal--gold w-full complete-task-btn" data-task-id="{{ $task->id }}">
                                        <x-base.lucide icon="check" class="w-4 h-4 mr-2" />
                                        Mark as Completed
                                    </button>
                                @endif
                                
                                @if($task->status === 'pending')
                                    <button type="button" class="btn-royal btn-royal--outline w-full start-task-btn" data-task-id="{{ $task->id }}">
                                        <x-base.lucide icon="play" class="w-4 h-4 mr-2" />
                                        Start Working
                                    </button>
                                @endif

                                <button type="button" class="btn-royal btn-royal--outline w-full share-task-btn" data-task-id="{{ $task->id }}">
                                    <x-base.lucide icon="share" class="w-4 h-4 mr-2" />
                                    Share Task
                                </button>

                                @if($task->due_date && $task->status !== 'completed')
                                    <button type="button" 
                                            class="btn-royal btn-royal--outline w-full request-extension-btn" 
                                            data-task-id="{{ $task->id }}"
                                            data-due-date="{{ $task->due_date->format('Y-m-d') }}"
                                            data-has-pending="{{ $task->hasPendingExtensionRequest() ? 'true' : 'false' }}">
                                        <x-base.lucide icon="clock" class="w-4 h-4 mr-2" />
                                        طلب تمديد الوقت
                                    </button>
                                @endif
                            </div>
                        </div>

                        <!-- Activity Log -->
                        <div class="rounded-xl border border-slate-200/70 p-5 dark:border-darkmode-400">
                            <h2 class="text-sm font-semibold text-slate-600 mb-4">Activity</h2>
                            <div class="space-y-3 text-sm">
                                <div class="flex items-start gap-3">
                                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full text-xs font-semibold bg-blue-100 text-blue-700">C</span>
                                    <div>
                                        <p class="font-semibold">Created</p>
                                        <p class="text-xs text-slate-500">{{ $task->created_at->format('M d, Y H:i') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full text-xs font-semibold bg-green-100 text-green-700">U</span>
                                    <div>
                                        <p class="font-semibold">Last Updated</p>
                                        <p class="text-xs text-slate-500">{{ $task->updated_at->format('M d, Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-base.preview-component>
    </div>
    <!-- Extension Request Modal -->
    @include('tasks.modals.extension-request')
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const taskId = {{ $task->id }};
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Add Comment Form Handler
    const addCommentForm = document.getElementById('add-comment-form');
    if (addCommentForm) {
        addCommentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const commentText = document.getElementById('comment-text').value.trim();
            const isInternal = document.getElementById('is_internal').checked;
            
            if (!commentText) {
                window.showWarning && showWarning('Please enter a comment');
                return;
            }
            
            fetch(`/tasks/${taskId}/comments`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    comment: commentText,
                    is_internal: isInternal
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.showSuccess && showSuccess('Comment added successfully');
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    window.showError && showError(data.message || 'Failed to add comment');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                window.showError && showError('Failed to add comment');
            });
        });
    }

    // Complete Task Button
    document.querySelectorAll('.complete-task-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const taskId = this.getAttribute('data-task-id');
            fetch(`/tasks/${taskId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ status: 'completed' })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.showSuccess && showSuccess('Task marked as completed!');
                    setTimeout(() => window.location.reload(), 1000);
                }
            });
        });
    });

    // Start Task Button
    document.querySelectorAll('.start-task-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const taskId = this.getAttribute('data-task-id');
            fetch(`/tasks/${taskId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ status: 'in_progress' })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.showSuccess && showSuccess('Task started!');
                    setTimeout(() => window.location.reload(), 1000);
                }
            });
        });
    });

    // Share Task Button
    document.querySelectorAll('.share-task-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            navigator.clipboard.writeText(window.location.href).then(() => {
                window.showSuccess && showSuccess('Task link copied to clipboard!');
            });
        });
    });

    // Request Extension Button
    document.querySelectorAll('.request-extension-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const taskId = this.getAttribute('data-task-id');
            const dueDate = this.getAttribute('data-due-date');
            const hasPending = this.getAttribute('data-has-pending') === 'true';
            
            if (typeof openExtensionRequestModal === 'function') {
                openExtensionRequestModal(taskId, dueDate, hasPending);
            }
        });
    });

    // Task Like Button
    const taskLikeBtn = document.getElementById('task-like-btn');
    if (taskLikeBtn) {
        taskLikeBtn.addEventListener('click', function() {
            const id = this.getAttribute('data-task-id');
            
            fetch(`/tasks/${id}/like`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Handle both data.data and direct data structure
                const responseData = data.data || data;
                
                if (data.success) {
                    const likesCount = document.getElementById('task-likes-count');
                    likesCount.textContent = responseData.likes_count;
                    
                    if (responseData.is_liked) {
                        taskLikeBtn.classList.remove('bg-slate-100', 'text-slate-600', 'hover:bg-pink-50', 'hover:text-pink-600');
                        taskLikeBtn.classList.add('bg-gradient-to-r', 'from-pink-500', 'to-red-500', 'text-white', 'shadow-lg');
                        taskLikeBtn.querySelector('svg').classList.add('fill-current');
                        window.showSuccess && showSuccess('You liked this task! ❤️');
                    } else {
                        taskLikeBtn.classList.add('bg-slate-100', 'text-slate-600', 'hover:bg-pink-50', 'hover:text-pink-600');
                        taskLikeBtn.classList.remove('bg-gradient-to-r', 'from-pink-500', 'to-red-500', 'text-white', 'shadow-lg');
                        taskLikeBtn.querySelector('svg').classList.remove('fill-current');
                        window.showInfo && showInfo('Like removed');
                    }
                } else {
                    window.showError && showError(data.message || 'Failed to update like');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                window.showError && showError('Failed to update like');
            });
        });
    }

    // Comment Reaction Buttons
    document.querySelectorAll('.reaction-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const commentId = this.getAttribute('data-comment-id');
            const type = this.getAttribute('data-type');
            const button = this;
            
            fetch(`/tasks/comments/${commentId}/reaction`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ type: type })
            })
            .then(response => response.json())
            .then(data => {
                // Handle both data.data and direct data structure
                const responseData = data.data || data;
                
                if (data.success) {
                    // Update counts
                    const commentItem = button.closest('.comment-item');
                    commentItem.querySelector('.likes-count').textContent = responseData.likes_count;
                    commentItem.querySelector('.dislikes-count').textContent = responseData.dislikes_count;
                    
                    // Update button styles
                    const likeBtn = commentItem.querySelector('[data-type="like"]');
                    const dislikeBtn = commentItem.querySelector('[data-type="dislike"]');
                    
                    // Reset both buttons
                    likeBtn.classList.remove('bg-green-100', 'text-green-700');
                    likeBtn.classList.add('bg-slate-100', 'text-slate-600');
                    dislikeBtn.classList.remove('bg-red-100', 'text-red-700');
                    dislikeBtn.classList.add('bg-slate-100', 'text-slate-600');
                    
                    // Apply active style
                    if (responseData.user_reaction === 'like') {
                        likeBtn.classList.remove('bg-slate-100', 'text-slate-600');
                        likeBtn.classList.add('bg-green-100', 'text-green-700');
                    } else if (responseData.user_reaction === 'dislike') {
                        dislikeBtn.classList.remove('bg-slate-100', 'text-slate-600');
                        dislikeBtn.classList.add('bg-red-100', 'text-red-700');
                    }
                } else {
                    window.showError && showError(data.message || 'Failed to update reaction');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                window.showError && showError('Failed to update reaction');
            });
        });
    });
});
</script>
@endpush

{{-- Activity Tab --}}
@php
    $recentTasks = $project->tasks->sortByDesc('updated_at')->take(10);
    $activityCount = $recentTasks->count() + 2; // +2 for project created/updated
@endphp

<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-semibold text-[#303030]">Activity Log</h2>
            <p class="text-sm text-slate-500 mt-1">Track all project activities and changes</p>
        </div>
        <div class="flex items-center gap-2">
            <select class="h-10 px-4 rounded-full border border-slate-200 text-sm focus:outline-none focus:border-slate-400 transition-all">
                <option>All Activities</option>
                <option>Tasks</option>
                <option>Comments</option>
                <option>Documents</option>
                <option>Status Changes</option>
            </select>
            <button class="h-10 rounded-full px-5 flex items-center justify-center text-xs font-semibold text-slate-600 border border-slate-300 hover:bg-white/80 transition-all">
                <x-base.lucide icon="download" class="w-4 h-4 mr-2" /> Export Log
            </button>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-4 gap-4">
        <div class="rounded-2xl bg-gradient-to-br from-slate-800 to-slate-900 p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="activity" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">{{ $activityCount }}</div>
                    <div class="text-xs text-slate-300 mt-1">Total Activities</div>
                </div>
            </div>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="clock" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">{{ $project->updated_at->diffInDays(now()) }}</div>
                    <div class="text-xs text-blue-100 mt-1">Days Since Update</div>
                </div>
            </div>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-green-500 to-green-600 p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="users" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">{{ $teamMembers->count() }}</div>
                    <div class="text-xs text-green-100 mt-1">Contributors</div>
                </div>
            </div>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="message-square" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">0</div>
                    <div class="text-xs text-purple-100 mt-1">Comments</div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-6">
        {{-- Activity Timeline --}}
        <div class="col-span-2 rounded-2xl bg-white shadow-lg border border-slate-200/60 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                <h3 class="text-lg font-semibold text-[#303030]">Recent Activity</h3>
            </div>
            <div class="p-6 space-y-6 max-h-[600px] overflow-y-auto">
                {{-- Project Created --}}
                <div class="flex gap-4">
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center shadow-lg">
                            <x-base.lucide icon="plus-circle" class="w-5 h-5 text-white" />
                        </div>
                        <div class="w-0.5 flex-1 bg-slate-200 mt-2"></div>
                    </div>
                    <div class="flex-1 pb-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="font-semibold text-[#303030]">Project Created</span>
                                @if($project->manager)
                                <span class="text-slate-500"> by </span>
                                <span class="font-medium text-[#303030]">{{ $project->manager->first_name }}</span>
                                @endif
                            </div>
                            <span class="text-xs text-slate-400 bg-slate-100 px-2 py-1 rounded-full">{{ $project->created_at->format('M d, Y H:i') }}</span>
                        </div>
                        <p class="text-sm text-slate-500 mt-1">Project "{{ $project->name }}" was created</p>
                    </div>
                </div>

                {{-- Recent Tasks --}}
                @foreach($recentTasks as $task)
                <div class="flex gap-4">
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center shadow-lg
                            @if($task->status === 'completed') bg-gradient-to-br from-green-400 to-green-600
                            @elseif($task->status === 'in_progress') bg-gradient-to-br from-blue-400 to-blue-600
                            @else bg-gradient-to-br from-amber-400 to-amber-600 @endif">
                            @if($task->status === 'completed')
                                <x-base.lucide icon="check" class="w-5 h-5 text-white" />
                            @elseif($task->status === 'in_progress')
                                <x-base.lucide icon="loader" class="w-5 h-5 text-white" />
                            @else
                                <x-base.lucide icon="clipboard-list" class="w-5 h-5 text-white" />
                            @endif
                        </div>
                        <div class="w-0.5 flex-1 bg-slate-200 mt-2"></div>
                    </div>
                    <div class="flex-1 pb-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="font-semibold text-[#303030]">Task {{ $task->status === 'completed' ? 'Completed' : ($task->status === 'in_progress' ? 'Started' : 'Created') }}</span>
                                @if($task->employee)
                                <span class="text-slate-500"> by </span>
                                <span class="font-medium text-[#303030]">{{ $task->employee->first_name }}</span>
                                @endif
                            </div>
                            <span class="text-xs text-slate-400 bg-slate-100 px-2 py-1 rounded-full">{{ $task->updated_at->format('M d, Y H:i') }}</span>
                        </div>
                        <p class="text-sm text-slate-500 mt-1">{{ $task->title }}</p>
                    </div>
                </div>
                @endforeach

                {{-- Last Update --}}
                @if($project->updated_at != $project->created_at)
                <div class="flex gap-4">
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center shadow-lg" style="background: linear-gradient(135deg, #f7e08a, #d49a24);">
                            <x-base.lucide icon="edit" class="w-5 h-5 text-[#3a2a1a]" />
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <span class="font-semibold text-[#303030]">Project Updated</span>
                            <span class="text-xs text-slate-400 bg-slate-100 px-2 py-1 rounded-full">{{ $project->updated_at->format('M d, Y H:i') }}</span>
                        </div>
                        <p class="text-sm text-slate-500 mt-1">Project details were modified</p>
                    </div>
                </div>
                @endif

                @if($recentTasks->isEmpty())
                <div class="text-center py-8">
                    <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-slate-100 mb-4">
                        <x-base.lucide icon="activity" class="w-8 h-8 text-slate-400" />
                    </div>
                    <p class="text-slate-600 font-medium">No recent activity</p>
                    <p class="text-sm text-slate-400 mt-1">Activities will appear here as the project progresses</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Activity by Team Member --}}
        <div class="rounded-2xl bg-white shadow-lg border border-slate-200/60 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                <h3 class="text-lg font-semibold text-[#303030]">Team Activity</h3>
            </div>
            <div class="p-4 space-y-3 max-h-[600px] overflow-y-auto">
                @forelse($teamMembers->take(10) as $member)
                @php
                    $memberTasks = $project->tasks->where('employee_id', $member->id);
                    $completedCount = $memberTasks->where('status', 'completed')->count();
                @endphp
                <div class="flex items-center gap-4 p-3 rounded-xl hover:bg-slate-50 transition-all">
                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-slate-600 to-slate-800 flex items-center justify-center text-white text-sm font-semibold shadow-lg">
                        {{ strtoupper(substr($member->first_name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="font-medium text-[#303030] truncate">{{ $member->first_name }} {{ $member->last_name }}</div>
                        <div class="text-xs text-slate-500">{{ $memberTasks->count() }} tasks assigned</div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm font-semibold text-green-600">{{ $completedCount }}</div>
                        <div class="text-xs text-slate-400">done</div>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <div class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-slate-100 mb-3">
                        <x-base.lucide icon="users" class="w-6 h-6 text-slate-400" />
                    </div>
                    <p class="text-slate-500 text-sm">No team members yet</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

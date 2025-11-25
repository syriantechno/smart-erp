@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>{{ $project->name }} - Project Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@php
    $totalTasks = $project->tasks->count();
    $completedTasks = $project->tasks->where('status', 'completed')->count();
    $inProgressTasks = $project->tasks->where('status', 'in_progress')->count();
    $pendingTasks = $project->tasks->where('status', 'pending')->count();
    $overdueTasks = $project->tasks->filter(fn($t) => $t->due_date && $t->due_date->isPast() && !in_array($t->status, ['completed', 'cancelled']))->count();
    $daysRemaining = $project->end_date ? max(0, now()->diffInDays($project->end_date, false)) : null;
    $daysPassed = $project->start_date ? now()->diffInDays($project->start_date) : 0;
    $totalDays = $project->start_date && $project->end_date ? $project->start_date->diffInDays($project->end_date) : 0;
    $timeProgress = $totalDays > 0 ? min(100, round(($daysPassed / $totalDays) * 100)) : 0;
    $budgetUsed = $project->budget > 0 ? round(($project->actual_cost / $project->budget) * 100) : 0;
    $taskProgress = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
    $teamMembers = $project->tasks->pluck('employee')->filter()->unique('id');
@endphp

@section('subcontent')
    <div class="mt-6 ml-1 sm:ml-2 md:ml-3 lg:ml-4">
        {{-- Header --}}
        <div class="flex items-start justify-between">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <span class="text-xs font-mono tracking-wider text-slate-500 bg-white/60 px-3 py-1 rounded-full">{{ $project->code }}</span>
                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold
                        @if($project->status === 'active') bg-[#f7e08a] text-[#3a2a1a]
                        @elseif($project->status === 'completed') bg-green-100 text-green-700
                        @elseif($project->status === 'planning') bg-blue-100 text-blue-700
                        @else bg-slate-200 text-slate-700 @endif">
                        {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                    </span>
                    <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-semibold
                        @if($project->priority === 'critical') bg-red-100 text-red-700
                        @elseif($project->priority === 'high') bg-orange-100 text-orange-700
                        @else bg-slate-100 text-slate-600 @endif">
                        {{ ucfirst($project->priority) }}
                    </span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-semibold tracking-tight text-slate-900">{{ $project->name }}</h1>
                <div class="mt-3 flex items-center gap-3 text-sm text-slate-700">
                    @if($project->company)<span>{{ $project->company->name }}</span>@endif
                    @if($project->department)<span class="text-slate-400">•</span><span>{{ $project->department->name }}</span>@endif
                    @if($project->start_date)
                        <span class="text-slate-400">•</span>
                        <span class="flex items-center gap-1"><x-base.lucide icon="calendar" class="w-4 h-4" /> {{ $project->start_date->format('M d') }} - {{ $project->end_date?->format('M d, Y') ?? 'Ongoing' }}</span>
                    @endif
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('project-management.projects.edit', $project) }}" class="h-10 rounded-full px-5 flex items-center justify-center text-xs font-semibold text-[#3a2a1a] border border-slate-300 hover:bg-white/80 transition-all">
                    <x-base.lucide icon="edit" class="w-4 h-4 mr-2" /> Edit
                </a>
                <a href="{{ route('project-management.projects.index') }}" class="h-10 rounded-full px-5 flex items-center justify-center text-xs font-semibold text-white bg-[#303030] hover:bg-[#404040] transition-all">
                    <x-base.lucide icon="arrow-left" class="w-4 h-4 mr-2" /> Back
                </a>
            </div>
        </div>

        {{-- Stats Row --}}
        <div class="mt-8 flex gap-10 text-right justify-end">
            <div>
                <div class="flex items-baseline justify-end gap-2 text-[#3a2a1a]">
                    <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1"><x-base.lucide icon="trending-up" class="w-4 h-4" /></div>
                    <div class="text-6xl font-semibold tracking-tight">{{ $project->progress_percentage }}%</div>
                </div>
                <div class="mt-1 text-xs uppercase tracking-[0.25em] text-slate-600">Progress</div>
            </div>
            <div>
                <div class="flex items-baseline justify-end gap-2 text-[#3a2a1a]">
                    <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1"><x-base.lucide icon="check-square" class="w-4 h-4" /></div>
                    <div class="text-6xl font-semibold tracking-tight">{{ $completedTasks }}/{{ $totalTasks }}</div>
                </div>
                <div class="mt-1 text-xs uppercase tracking-[0.25em] text-slate-600">Tasks</div>
            </div>
            <div>
                <div class="flex items-baseline justify-end gap-2 text-[#3a2a1a]">
                    <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1"><x-base.lucide icon="calendar" class="w-4 h-4" /></div>
                    <div class="text-6xl font-semibold tracking-tight">{{ $daysRemaining ?? '∞' }}</div>
                </div>
                <div class="mt-1 text-xs uppercase tracking-[0.25em] text-slate-600">Days Left</div>
            </div>
            <div>
                <div class="flex items-baseline justify-end gap-2 text-[#3a2a1a]">
                    <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1"><x-base.lucide icon="users" class="w-4 h-4" /></div>
                    <div class="text-6xl font-semibold tracking-tight">{{ $teamMembers->count() }}</div>
                </div>
                <div class="mt-1 text-xs uppercase tracking-[0.25em] text-slate-600">Team</div>
            </div>
            <div>
                <div class="flex items-baseline justify-end gap-2 text-[#3a2a1a]">
                    <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1"><x-base.lucide icon="wallet" class="w-4 h-4" /></div>
                    <div class="text-6xl font-semibold tracking-tight">${{ number_format(($project->budget ?? 0)/1000) }}K</div>
                </div>
                <div class="mt-1 text-xs uppercase tracking-[0.25em] text-slate-600">Budget</div>
            </div>
        </div>

        {{-- Tabs Navigation --}}
        <div class="mt-10 flex items-center gap-1 border-b border-slate-200/60 overflow-x-auto pb-px">
            <button class="project-tab active px-4 py-3 text-sm font-semibold text-[#303030] border-b-2 border-[#303030] -mb-px whitespace-nowrap" data-tab="overview">
                <x-base.lucide icon="layout-dashboard" class="w-4 h-4 inline mr-1" />Overview
            </button>
            <button class="project-tab px-4 py-3 text-sm font-medium text-slate-500 hover:text-slate-700 border-b-2 border-transparent -mb-px whitespace-nowrap" data-tab="tasks">
                <x-base.lucide icon="check-square" class="w-4 h-4 inline mr-1" />Tasks
                <span class="ml-1 px-1.5 py-0.5 rounded-full bg-slate-200 text-xs">{{ $totalTasks }}</span>
            </button>
            <button class="project-tab px-4 py-3 text-sm font-medium text-slate-500 hover:text-slate-700 border-b-2 border-transparent -mb-px whitespace-nowrap" data-tab="milestones">
                <x-base.lucide icon="flag" class="w-4 h-4 inline mr-1" />Milestones
            </button>
            <button class="project-tab px-4 py-3 text-sm font-medium text-slate-500 hover:text-slate-700 border-b-2 border-transparent -mb-px whitespace-nowrap" data-tab="team">
                <x-base.lucide icon="users" class="w-4 h-4 inline mr-1" />Team
                <span class="ml-1 px-1.5 py-0.5 rounded-full bg-slate-200 text-xs">{{ $teamMembers->count() }}</span>
            </button>
            <button class="project-tab px-4 py-3 text-sm font-medium text-slate-500 hover:text-slate-700 border-b-2 border-transparent -mb-px whitespace-nowrap" data-tab="materials">
                <x-base.lucide icon="package" class="w-4 h-4 inline mr-1" />Materials
            </button>
            <button class="project-tab px-4 py-3 text-sm font-medium text-slate-500 hover:text-slate-700 border-b-2 border-transparent -mb-px whitespace-nowrap" data-tab="requests">
                <x-base.lucide icon="clipboard-list" class="w-4 h-4 inline mr-1" />Requests
            </button>
            <button class="project-tab px-4 py-3 text-sm font-medium text-slate-500 hover:text-slate-700 border-b-2 border-transparent -mb-px whitespace-nowrap" data-tab="delivery">
                <x-base.lucide icon="truck" class="w-4 h-4 inline mr-1" />Delivery
            </button>
            <button class="project-tab px-4 py-3 text-sm font-medium text-slate-500 hover:text-slate-700 border-b-2 border-transparent -mb-px whitespace-nowrap" data-tab="invoices">
                <x-base.lucide icon="receipt" class="w-4 h-4 inline mr-1" />Invoices
            </button>
            <button class="project-tab px-4 py-3 text-sm font-medium text-slate-500 hover:text-slate-700 border-b-2 border-transparent -mb-px whitespace-nowrap" data-tab="documents">
                <x-base.lucide icon="folder" class="w-4 h-4 inline mr-1" />Documents
            </button>
            <button class="project-tab px-4 py-3 text-sm font-medium text-slate-500 hover:text-slate-700 border-b-2 border-transparent -mb-px whitespace-nowrap" data-tab="costs">
                <x-base.lucide icon="calculator" class="w-4 h-4 inline mr-1" />Costs
            </button>
            <button class="project-tab px-4 py-3 text-sm font-medium text-slate-500 hover:text-slate-700 border-b-2 border-transparent -mb-px whitespace-nowrap" data-tab="risks">
                <x-base.lucide icon="alert-triangle" class="w-4 h-4 inline mr-1" />Risks
            </button>
            <button class="project-tab px-4 py-3 text-sm font-medium text-slate-500 hover:text-slate-700 border-b-2 border-transparent -mb-px whitespace-nowrap" data-tab="activity">
                <x-base.lucide icon="activity" class="w-4 h-4 inline mr-1" />Activity
            </button>
            <button class="project-tab px-4 py-3 text-sm font-medium text-slate-500 hover:text-slate-700 border-b-2 border-transparent -mb-px whitespace-nowrap" data-tab="details">
                <x-base.lucide icon="info" class="w-4 h-4 inline mr-1" />Details
            </button>
        </div>

        {{-- Tab Contents --}}
        <div class="mt-6">
            {{-- Overview Tab --}}
            <div id="tab-overview" class="tab-content">
                @include('work.projects.partials.show.tab-overview')
            </div>

            {{-- Tasks Tab --}}
            <div id="tab-tasks" class="tab-content hidden">
                @include('work.projects.partials.show.tab-tasks')
            </div>

            {{-- Milestones Tab --}}
            <div id="tab-milestones" class="tab-content hidden">
                @include('work.projects.partials.show.tab-milestones')
            </div>

            {{-- Team Tab --}}
            <div id="tab-team" class="tab-content hidden">
                @include('work.projects.partials.show.tab-team')
            </div>

            {{-- Materials Tab --}}
            <div id="tab-materials" class="tab-content hidden">
                @include('work.projects.partials.show.tab-materials')
            </div>

            {{-- Material Requests Tab --}}
            <div id="tab-requests" class="tab-content hidden">
                @include('work.projects.partials.show.tab-requests')
            </div>

            {{-- Delivery Notes Tab --}}
            <div id="tab-delivery" class="tab-content hidden">
                @include('work.projects.partials.show.tab-delivery')
            </div>

            {{-- Invoices Tab --}}
            <div id="tab-invoices" class="tab-content hidden">
                @include('work.projects.partials.show.tab-invoices')
            </div>

            {{-- Documents Tab --}}
            <div id="tab-documents" class="tab-content hidden">
                @include('work.projects.partials.show.tab-documents')
            </div>

            {{-- Costs Tab --}}
            <div id="tab-costs" class="tab-content hidden">
                @include('work.projects.partials.show.tab-costs')
            </div>

            {{-- Risks Tab --}}
            <div id="tab-risks" class="tab-content hidden">
                @include('work.projects.partials.show.tab-risks')
            </div>

            {{-- Activity Tab --}}
            <div id="tab-activity" class="tab-content hidden">
                @include('work.projects.partials.show.tab-activity')
            </div>

            {{-- Details Tab --}}
            <div id="tab-details" class="tab-content hidden">
                @include('work.projects.partials.show.tab-details')
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.project-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            // Remove active from all tabs
            document.querySelectorAll('.project-tab').forEach(t => {
                t.classList.remove('active', 'text-[#303030]', 'border-[#303030]');
                t.classList.add('text-slate-500', 'border-transparent');
            });
            // Hide all content
            document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
            
            // Activate clicked tab
            this.classList.add('active', 'text-[#303030]', 'border-[#303030]');
            this.classList.remove('text-slate-500', 'border-transparent');
            
            // Show content
            document.getElementById('tab-' + this.dataset.tab).classList.remove('hidden');
        });
    });
});
</script>
@endpush

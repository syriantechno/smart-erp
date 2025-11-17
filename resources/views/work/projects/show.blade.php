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
                                @if($project->status === 'active') bg-green-100 text-green-700
                                @elseif($project->status === 'planning') bg-blue-100 text-blue-700
                                @elseif($project->status === 'on_hold') bg-yellow-100 text-yellow-700
                                @elseif($project->status === 'completed') bg-gray-100 text-gray-700
                                @else bg-red-100 text-red-700
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                            </span>
                        </div>
                        <div class="flex gap-2">
                            <x-base.button
                                variant="outline-primary"
                                onclick="window.location.href='{{ route('work.projects.edit', $project) }}'"
                            >
                                <x-base.lucide icon="Edit" class="w-4 h-4 mr-2" />
                                Edit
                            </x-base.button>
                            <x-base.button
                                variant="outline-secondary"
                                onclick="window.location.href='{{ route('work.projects.index') }}'"
                            >
                                <x-base.lucide icon="ArrowLeft" class="w-4 h-4 mr-2" />
                                Back
                            </x-base.button>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium">Progress</span>
                            <span class="text-sm text-gray-600">{{ $project->progress_percentage }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-{{ $project->progress_percentage >= 75 ? 'green' : ($project->progress_percentage >= 50 ? 'yellow' : 'red') }}-500 h-3 rounded-full transition-all duration-300"
                                 style="width: {{ $project->progress_percentage }}%"></div>
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
                        <x-base.button
                            variant="outline-primary"
                            class="w-full justify-start"
                            onclick="editProject({{ $project->id }})"
                        >
                            <x-base.lucide icon="Edit" class="w-4 h-4 mr-2" />
                            Edit Project
                        </x-base.button>

                        <x-base.button
                            variant="outline-danger"
                            class="w-full justify-start"
                            onclick="deleteProject({{ $project->id }}, '{{ addslashes($project->name) }}')"
                        >
                            <x-base.lucide icon="Trash" class="w-4 h-4 mr-2" />
                            Delete Project
                        </x-base.button>
                    </div>
                </div>
            </x-base.preview-component>

            <!-- Project Stats -->
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    <h3 class="text-lg font-medium mb-4">Project Stats</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Total Tasks</span>
                            <span class="text-sm font-medium">{{ $project->tasks->count() }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Completed Tasks</span>
                            <span class="text-sm font-medium">{{ $project->tasks->where('status', 'completed')->count() }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Days Remaining</span>
                            <span class="text-sm font-medium">
                                @if($project->end_date)
                                    {{ max(0, now()->diffInDays($project->end_date, false)) }}
                                @else
                                    N/A
                                @endif
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Days Passed</span>
                            <span class="text-sm font-medium">{{ $project->start_date ? now()->diffInDays($project->start_date) : 0 }}</span>
                        </div>
                    </div>
                </div>
            </x-base.preview-component>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>

    <script>
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

@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Projects Management - {{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
@endpush

@section('subcontent')
    @include('components.global-notifications')

    <div class="mt-8 grid grid-cols-12 gap-6">
        <div class="col-span-12">
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-medium">Projects Management</h2>
                        <button
                            class="btn-tonal btn-tonal--success"
                            onclick="openCreateModal()"
                        >
                            <x-base.lucide icon="plus" class="w-4 h-4 mr-2" />
                            Add New Project
                        </button>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-12 gap-6 mb-6">
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3">
                            <div class="stats-card-info p-5 text-center">
                                <div class="text-3xl font-bold mb-2">{{ $stats['total'] }}</div>
                                <div class="flex items-center justify-center gap-2 text-sm opacity-80">
                                    <x-base.lucide icon="trending-up" class="w-4 h-4" />
                                    Total Projects
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3">
                            <div class="stats-card-warning p-5 text-center">
                                <div class="text-3xl font-bold mb-2">{{ $stats['active'] }}</div>
                                <div class="flex items-center justify-center gap-2 text-sm opacity-80">
                                    <x-base.lucide icon="activity" class="w-4 h-4" />
                                    Active Projects
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3">
                            <div class="stats-card-success p-5 text-center">
                                <div class="text-3xl font-bold mb-2">{{ $stats['completed'] }}</div>
                                <div class="flex items-center justify-center gap-2 text-sm opacity-80">
                                    <x-base.lucide icon="check-circle" class="w-4 h-4" />
                                    Completed
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3">
                            <div class="stats-card-danger p-5 text-center">
                                <div class="text-3xl font-bold mb-2">{{ $stats['overdue'] }}</div>
                                <div class="flex items-center justify-center gap-2 text-sm opacity-80">
                                    <x-base.lucide icon="alert-circle" class="w-4 h-4" />
                                    Overdue
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filters -->
                    <div class="flex flex-col sm:flex-row gap-4 mb-6">
                        <div class="flex-1">
                            <x-base.form-select id="company-filter" class="w-full">
                                <option value="">All Companies</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </x-base.form-select>
                        </div>
                        <div class="flex-1">
                            <x-base.form-select id="department-filter" class="w-full">
                                <option value="">All Departments</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </x-base.form-select>
                        </div>
                        <div class="flex-1">
                            <x-base.form-select id="status-filter" class="w-full">
                                <option value="">All Status</option>
                                <option value="planning">Planning</option>
                                <option value="active">Active</option>
                                <option value="on_hold">On Hold</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </x-base.form-select>
                        </div>
                    </div>

                    <div class="overflow-x-auto sm:overflow-visible" data-erp-table-wrapper>
                        <table
                            id="projects-table"
                            data-tw-merge
                            data-erp-table
                            data-projects-datatable-url="{{ route('project-management.projects.datatable') }}"
                            data-projects-delete-url-base="{{ url('project-management/projects') }}"
                            class="datatable-default w-full min-w-full table-auto text-left text-sm"
                        >
                            <thead>
                                <tr>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">#</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Code</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Project Name</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Company / Department</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Manager</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Status</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Priority</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Progress</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </x-base.preview-component>
        </div>
    </div>
@endsection

<!-- Modals -->
@include('work.projects.partials.create-modal')

@include('components.datatable.scripts')

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>
@endpush

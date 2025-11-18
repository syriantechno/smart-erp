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
    <style>
        /* Make projects table rows more compact */
        #projects-table tbody tr {
            height: 2.25rem; /* ~36px */
        }

        #projects-table td {
            padding-top: 0.375rem;  /* 6px */
            padding-bottom: 0.375rem;
        }
        
        .custom-modal {
            position: fixed;
            inset: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(15, 23, 42, 0.6);
            display: none;
            z-index: 1050;
            animation: fadeIn 0.25s ease-out;
        }
        .custom-modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .custom-modal-dialog {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.45);
            max-width: 1100px;
            width: 95%;
            max-height: 90vh;
            overflow-y: auto;
            animation: slideIn 0.25s ease-out;
        }
        .custom-modal-header {
            padding: 1rem 1.75rem;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .custom-modal-body {
            padding: 1.5rem 1.75rem;
        }
        .custom-modal-footer {
            padding: 1rem 1.75rem;
            border-top: 1px solid #e5e7eb;
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
        }
        .custom-modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #0f172a;
        }
        .btn-close-custom {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #6b7280;
            cursor: pointer;
            padding: 0.25rem;
            border-radius: 999px;
            line-height: 1;
        }
        .btn-close-custom:hover {
            background-color: #e5e7eb;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes slideIn {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>
@endpush

@section('subcontent')
    @include('components.global-notifications')

    <div class="mt-8 grid grid-cols-12 gap-6">
        <div class="col-span-12">
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-medium">Projects Management</h2>
                        <x-base.button
                            variant="primary"
                            onclick="openCreateModal()"
                        >
                            <x-base.lucide icon="Plus" class="w-4 h-4 mr-2" />
                            Add New Project
                        </x-base.button>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-12 gap-6 mb-6">
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3">
                            <div class="stats-card-info p-5 text-center">
                                <div class="text-3xl font-bold mb-2">{{ $stats['total'] }}</div>
                                <div class="flex items-center justify-center gap-2 text-sm opacity-80">
                                    <x-base.lucide icon="TrendingUp" class="w-4 h-4" />
                                    Total Projects
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3">
                            <div class="stats-card-warning p-5 text-center">
                                <div class="text-3xl font-bold mb-2">{{ $stats['active'] }}</div>
                                <div class="flex items-center justify-center gap-2 text-sm opacity-80">
                                    <x-base.lucide icon="Activity" class="w-4 h-4" />
                                    Active Projects
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3">
                            <div class="stats-card-success p-5 text-center">
                                <div class="text-3xl font-bold mb-2">{{ $stats['completed'] }}</div>
                                <div class="flex items-center justify-center gap-2 text-sm opacity-80">
                                    <x-base.lucide icon="CheckCircle" class="w-4 h-4" />
                                    Completed
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3">
                            <div class="stats-card-danger p-5 text-center">
                                <div class="text-3xl font-bold mb-2">{{ $stats['overdue'] }}</div>
                                <div class="flex items-center justify-center gap-2 text-sm opacity-80">
                                    <x-base.lucide icon="AlertTriangle" class="w-4 h-4" />
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
                        <table id="projects-table" data-tw-merge data-erp-table class="datatable-default w-full min-w-full table-auto text-left text-sm">
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

    <script>
        // Wait for jQuery and DataTables to be available
        function initializeProjectsTable() {
            if (typeof window.jQuery === 'undefined' || typeof window.$ === 'undefined') {
                console.error('jQuery is not loaded');
                setTimeout(initializeProjectsTable, 100);
                return;
            }

            if (typeof window.erpCrud === 'undefined' || typeof window.erpCrud.initDataTable === 'undefined') {
                console.error('erpCrud.initDataTable function is not available');
                setTimeout(initializeProjectsTable, 100);
                return;
            }

            const $ = window.jQuery;
            
            // Initialize DataTable using erpCrud
            const table = window.erpCrud.initDataTable({
                tableSelector: '#projects-table',
                ajaxUrl: '{{ route("project-management.projects.datatable") }}',
                ajaxData: function (d) {
                    // Add filter data
                    d.company_id = $('#company-filter').val();
                    d.department_id = $('#department-filter').val();
                    d.status = $('#status-filter').val();
                    return d;
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center font-medium', orderable: false },
                    { data: 'code', name: 'code', className: 'px-5 py-3 border-b dark:border-darkmode-300 font-medium text-slate-700 whitespace-nowrap' },
                    { data: 'name', name: 'name', className: 'px-5 py-3 border-b dark:border-darkmode-300 font-medium text-slate-700 datatable-cell-wrap' },
                    { data: 'company_department', name: 'company_department', className: 'px-5 py-3 border-b dark:border-darkmode-300 datatable-cell-wrap', orderable: false },
                    { data: 'manager', name: 'manager', className: 'px-5 py-3 border-b dark:border-darkmode-300 datatable-cell-wrap', orderable: false },
                    { data: 'status', name: 'status', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center', orderable: false },
                    { data: 'priority', name: 'priority', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center', orderable: false },
                    { data: 'progress_percentage', name: 'progress_percentage', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center', orderable: false },
                    { data: 'actions', name: 'actions', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center', orderable: false, searchable: false }
                ],
                order: [[1, 'asc']],
                pageLength: 25,
                dom: "t<'datatable-footer flex flex-col md:flex-row md:items-center md:justify-between mt-5 gap-4'<'datatable-info text-slate-500'i><'datatable-pagination'p>>"
            });

            // Check if table was initialized successfully
            if (!table) {
                console.error('Failed to initialize projects table');
                return;
            }

            // Apply filters
            $('#company-filter, #department-filter, #status-filter').on('change', function() {
                if (table && table.ajax) {
                    table.ajax.reload();
                }
            });

            // Delete project
            window.deleteProject = function(id, name) {
                if (typeof window.confirmDelete === 'function') {
                    window.confirmDelete(name, function() {
                        $.ajax({
                            url: '/project-management/projects/' + id,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if (response.success) {
                                    table.ajax.reload();
                                    if (typeof window.showSuccess === 'function') {
                                        window.showSuccess(response.message || 'Project deleted successfully');
                                    }
                                } else if (typeof window.showError === 'function') {
                                    window.showError(response.message || 'Failed to delete project');
                                }
                            },
                            error: function(xhr) {
                                const msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Failed to delete project';
                                if (typeof window.showError === 'function') {
                                    window.showError(msg);
                                }
                            }
                        });
                    });
                }
            };
        }

        // Start initialization when document is ready
        $(document).ready(function() {
            initializeProjectsTable();
        });

        // Function to open create modal
        window.openCreateModal = function() {
            const modal = document.getElementById('create-project-modal');
            if (modal) {
                modal.classList.add('show');
                document.body.style.overflow = 'hidden';
            }
        };

        // Function to close create modal
        window.closeCreateModal = function() {
            const modal = document.getElementById('create-project-modal');
            if (modal) {
                modal.classList.remove('show');
                document.body.style.overflow = '';
            }
        };
    </script>
@endpush

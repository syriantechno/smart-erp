@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Projects Management - {{ config('app.name') }}</title>
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
        /* CRUD Table Styles */
        #projects-table tbody tr {
            background: transparent !important;
        }
        
        #projects-table tbody tr td {
            vertical-align: middle;
            position: relative;
        }
        
        #projects-table tbody tr:hover td {
            transform: translateY(-1px);
            transition: transform 0.2s ease;
        }
        
        /* Box shadows for table cells */
        .table-cell-box {
            box-shadow: 5px 3px 5px rgba(0,0,0,0.02);
            background: white;
            border: 1px solid rgba(226, 232, 240, 0.6);
            transition: all 0.2s ease;
        }
        
        .table-cell-box:hover {
            box-shadow: 5px 3px 15px rgba(0,0,0,0.1);
        }
        
        /* Dark mode support */
        .dark .table-cell-box {
            background: rgb(var(--color-darkmode-600));
            border-color: rgba(var(--color-darkmode-400), 0.6);
        }
        
        /* DataTable search styling */
        .dataTables_filter input {
            border-radius: 0.375rem !important;
            border: 1px solid #e2e8f0 !important;
            padding: 0.5rem 1rem !important;
            background: white !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1) !important;
        }
        
        .dataTables_filter input:focus {
            border-color: var(--color-primary) !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
        }
        
        /* DataTable length select styling */
        .dataTables_length select {
            border-radius: 0.375rem !important;
            border: 1px solid #e2e8f0 !important;
            padding: 0.375rem 2rem 0.375rem 0.75rem !important;
            background: white !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1) !important;
        }
        
        /* Pagination styling */
        .dataTables_paginate .paginate_button {
            border-radius: 0.375rem !important;
            margin: 0 2px !important;
            padding: 0.5rem 0.75rem !important;
            border: 1px solid #e2e8f0 !important;
            background: white !important;
            color: #64748b !important;
            transition: all 0.2s ease !important;
        }
        
        .dataTables_paginate .paginate_button:hover {
            background: var(--color-primary) !important;
            color: white !important;
            border-color: var(--color-primary) !important;
            transform: translateY(-1px) !important;
        }
        
        .dataTables_paginate .paginate_button.current {
            background: var(--color-primary) !important;
            color: white !important;
            border-color: var(--color-primary) !important;
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

                    <!-- Projects Table -->
                    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                        <x-base.table id="projects-table" class="-mt-2 border-separate border-spacing-y-[10px]">
                            <x-base.table.thead>
                                <x-base.table.tr>
                                    <x-base.table.th class="whitespace-nowrap border-b-0">
                                        PROJECT CODE
                                    </x-base.table.th>
                                    <x-base.table.th class="whitespace-nowrap border-b-0">
                                        PROJECT NAME
                                    </x-base.table.th>
                                    <x-base.table.th class="whitespace-nowrap border-b-0">
                                        COMPANY
                                    </x-base.table.th>
                                    <x-base.table.th class="whitespace-nowrap border-b-0">
                                        MANAGER
                                    </x-base.table.th>
                                    <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                                        STATUS
                                    </x-base.table.th>
                                    <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                                        PRIORITY
                                    </x-base.table.th>
                                    <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                                        PROGRESS
                                    </x-base.table.th>
                                    <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                                        ACTIONS
                                    </x-base.table.th>
                                </x-base.table.tr>
                            </x-base.table.thead>
                            <x-base.table.tbody>
                                <!-- Data will be loaded via AJAX -->
                            </x-base.table.tbody>
                        </x-base.table>
                    </div>
                </div>
            </x-base.preview-component>
        </div>
    </div>
@endsection

<!-- Modals -->
@include('work.projects.partials.create-modal')

@push('scripts')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.tailwindcss.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            const table = $('#projects-table').DataTable({
                serverSide: true,
                ajax: {
                    url: '{{ route("work.projects.datatable") }}',
                    type: 'GET'
                },
                columns: [
                    { 
                        data: 'code', 
                        orderable: true,
                        render: function(data, type, row) {
                            return `
                                <div class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600 p-4">
                                    <a href="/work/projects/${row.id}" class="font-medium text-primary hover:underline">${data}</a>
                                </div>
                            `;
                        }
                    },
                    { 
                        data: 'name', 
                        orderable: true,
                        render: function(data, type, row) {
                            return `
                                <div class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600 p-4">
                                    <a href="/work/projects/${row.id}" class="whitespace-nowrap font-medium">${data}</a>
                                    <div class="mt-0.5 whitespace-nowrap text-xs text-slate-500">${row.department || 'No Department'}</div>
                                </div>
                            `;
                        }
                    },
                    { 
                        data: 'company', 
                        orderable: false,
                        render: function(data) {
                            return `
                                <div class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600 p-4">
                                    ${data || 'N/A'}
                                </div>
                            `;
                        }
                    },
                    { 
                        data: 'manager', 
                        orderable: false,
                        render: function(data) {
                            return `
                                <div class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600 p-4">
                                    ${data || 'Unassigned'}
                                </div>
                            `;
                        }
                    },
                    {
                        data: 'status',
                        orderable: false,
                        render: function(data) {
                            const statusClasses = {
                                'planning': 'stats-card-info',
                                'active': 'stats-card-warning', 
                                'on_hold': 'stats-card-neutral',
                                'completed': 'stats-card-success',
                                'cancelled': 'stats-card-danger'
                            };
                            const statusClass = statusClasses[data] || 'stats-card-neutral';
                            return `
                                <div class="box w-40 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600 p-4">
                                    <div class="flex items-center justify-center">
                                        <span class="${statusClass} px-3 py-1 rounded-full text-xs font-medium">
                                            ${data.charAt(0).toUpperCase() + data.slice(1).replace('_', ' ')}
                                        </span>
                                    </div>
                                </div>
                            `;
                        }
                    },
                    {
                        data: 'priority',
                        orderable: false,
                        render: function(data) {
                            const priorityClasses = {
                                'low': 'stats-card-neutral',
                                'medium': 'stats-card-info',
                                'high': 'stats-card-warning',
                                'critical': 'stats-card-danger'
                            };
                            const priorityClass = priorityClasses[data] || 'stats-card-neutral';
                            return `
                                <div class="box w-32 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600 p-4">
                                    <div class="flex items-center justify-center">
                                        <span class="${priorityClass} px-2 py-1 rounded-full text-xs font-medium">
                                            ${data.charAt(0).toUpperCase() + data.slice(1)}
                                        </span>
                                    </div>
                                </div>
                            `;
                        }
                    },
                    {
                        data: 'progress_percentage',
                        orderable: false,
                        render: function(data) {
                            const progressColor = data >= 75 ? '#1b7a4a' : (data >= 50 ? '#c98028' : '#b21a50');
                            return `
                                <div class="box w-40 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600 p-4">
                                    <div class="flex flex-col items-center">
                                        <div class="w-full bg-slate-200 rounded-full h-2 mb-2">
                                            <div class="h-2 rounded-full transition-all duration-300" 
                                                 style="width: ${data}%; background: linear-gradient(90deg, color-mix(in oklch, ${progressColor} 70%, #ffffff), color-mix(in oklch, ${progressColor} 90%, #ffffff));"></div>
                                        </div>
                                        <span class="text-xs font-medium">${data}%</span>
                                    </div>
                                </div>
                            `;
                        }
                    },
                    { 
                        data: 'actions', 
                        orderable: false, 
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                                <div class="box w-56 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600 p-4 before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 before:dark:bg-darkmode-400">
                                    <div class="flex items-center justify-center gap-3">
                                        <a href="/work/projects/${row.id}" class="flex items-center text-primary hover:text-primary/80">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            View
                                        </a>
                                        <a href="/work/projects/${row.id}/edit" class="flex items-center text-warning hover:text-warning/80">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Edit
                                        </a>
                                        <a href="#" onclick="deleteProject(${row.id}, '${row.name}')" class="flex items-center text-danger hover:text-danger/80">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Delete
                                        </a>
                                    </div>
                                </div>
                            `;
                        }
                    }
                ],
                order: [[0, 'asc']],
                pageLength: 10,
                responsive: true,
                dom: '<"flex flex-col sm:flex-row gap-4 mb-6"<"flex-1"f><"flex-shrink-0"l>>rtip',
                language: {
                    emptyTable: "No projects found",
                    search: "",
                    searchPlaceholder: "Search projects...",
                    lengthMenu: "Show _MENU_ projects",
                    info: "Showing _START_ to _END_ of _TOTAL_ projects",
                    paginate: {
                        first: "First",
                        last: "Last", 
                        next: "Next",
                        previous: "Previous"
                    }
                },
                drawCallback: function() {
                    // Add intro-x animation to new rows
                    $('#projects-table tbody tr').addClass('intro-x');
                },
                columnDefs: [
                    { targets: '_all', className: 'align-middle' }
                ]
            });

            // Apply filters
            $('#company-filter, #department-filter, #status-filter').on('change', function() {
                table.ajax.reload();
            });

            // Delete project
            window.deleteProject = function(id, name) {
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
                                    table.ajax.reload();
                                    if (typeof window.showSuccess === 'function') {
                                        window.showSuccess(response.message || 'Project deleted successfully');
                                    }
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
            };

            // Edit project
            window.editProject = function(id) {
                window.location.href = `{{ url('work/projects') }}/${id}/edit`;
            };

            // View project
            window.viewProject = function(id) {
                window.location.href = `{{ url('work/projects') }}/${id}`;
            };

            // === Create Project Modal: Company -> Department linkage ===
            const companySelect = document.getElementById('create-company_id');
            const departmentSelect = document.getElementById('create-department_id');

            if (companySelect && departmentSelect) {
                companySelect.addEventListener('change', function () {
                    const companyId = this.value;

                    departmentSelect.innerHTML = '<option value="">Loading departments...</option>';

                    if (!companyId) {
                        departmentSelect.innerHTML = '<option value="">Select Department</option>';
                        departmentSelect.disabled = false;
                        return;
                    }

                    fetch(`/hr/departments/api/company/${companyId}`, {
                        credentials: 'same-origin',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            departmentSelect.innerHTML = '<option value="">Select Department</option>';

                            if (Array.isArray(data)) {
                                data.forEach(dept => {
                                    const option = document.createElement('option');
                                    option.value = dept.id;
                                    option.textContent = dept.name;
                                    departmentSelect.appendChild(option);
                                });
                            }

                            departmentSelect.disabled = false;
                        })
                        .catch(error => {
                            console.error('Error loading departments for company:', error);
                            departmentSelect.innerHTML = '<option value="">Error loading departments</option>';
                            departmentSelect.disabled = false;
                        });
                });
            }
        });

        // Function to open create modal
        window.openCreateModal = function() {
            // Just show the modal; project code is generated server-side in the Blade
            const modal = document.getElementById('create-project-modal');
            if (modal) {
                modal.classList.add('show');
                document.body.style.overflow = 'hidden'; // Prevent background scrolling
            }
        };

        // Function to close create modal
        window.closeCreateModal = function() {
            const modal = document.getElementById('create-project-modal');
            if (modal) {
                modal.classList.remove('show');
                document.body.style.overflow = ''; // Restore background scrolling
            }
        };

        // Close modal when clicking on backdrop
        document.addEventListener('click', function(e) {
            const modal = document.getElementById('create-project-modal');
            if (modal && e.target === modal) {
                closeCreateModal();
            }
        });

        // Handle create form submission
        $(document).on('submit', '#create-project-form', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitBtn = $('#create-project-btn');
            const originalText = submitBtn.html();

            submitBtn.prop('disabled', true).html('<svg class="w-4 h-4 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>Creating...');

            fetch('{{ route("work.projects.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Close modal
                    closeCreateModal();

                    // Reset form
                    $('#create-project-form')[0].reset();

                    // Reload table
                    table.ajax.reload();

                    // Show success message
                    if (typeof window.showSuccess === 'function') {
                        window.showSuccess(data.message || 'Project created successfully');
                    }
                } else {
                    if (data.errors) {
                        const errors = Object.values(data.errors).flat().join('\n');
                        if (typeof window.showError === 'function') {
                            window.showError(errors);
                        }
                    } else if (typeof window.showError === 'function') {
                        window.showError(data.message || 'Failed to create project');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (typeof window.showError === 'function') {
                    window.showError('An error occurred while creating the project');
                }
            })
            .finally(() => {
                submitBtn.prop('disabled', false).html(originalText);
            });
        });
    </script>
@endpush

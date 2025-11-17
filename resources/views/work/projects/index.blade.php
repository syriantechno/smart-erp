@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Projects Management - {{ config('app.name') }}</title>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.tailwindcss.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">

    <!-- Custom Modal Styles -->
    <style>
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
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex items-center">
                                    <div class="text-2xl font-bold leading-8">{{ $stats['total'] }}</div>
                                        <div class="ml-auto">
                                            <div class="flex items-center text-success">
                                                <x-base.lucide icon="TrendingUp" class="w-4 h-4 mr-1" />
                                                Total Projects
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex items-center">
                                        <div class="text-2xl font-bold leading-8">{{ $stats['active'] }}</div>
                                        <div class="ml-auto">
                                            <div class="flex items-center text-primary">
                                                <x-base.lucide icon="Activity" class="w-4 h-4 mr-1" />
                                                Active
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex items-center">
                                        <div class="text-2xl font-bold leading-8">{{ $stats['completed'] }}</div>
                                        <div class="ml-auto">
                                            <div class="flex items-center text-success">
                                                <x-base.lucide icon="CheckCircle" class="w-4 h-4 mr-1" />
                                                Completed
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex items-center">
                                        <div class="text-2xl font-bold leading-8">{{ $stats['overdue'] }}</div>
                                        <div class="ml-auto">
                                            <div class="flex items-center text-danger">
                                                <x-base.lucide icon="AlertTriangle" class="w-4 h-4 mr-1" />
                                                Overdue
                                            </div>
                                        </div>
                                    </div>
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
                    <div class="overflow-x-auto">
                        <table id="projects-table" class="table table-report -mt-2">
                            <thead>
                                <tr>
                                    <th class="whitespace-nowrap">Code</th>
                                    <th class="whitespace-nowrap">Name</th>
                                    <th class="whitespace-nowrap">Company</th>
                                    <th class="whitespace-nowrap">Department</th>
                                    <th class="whitespace-nowrap">Manager</th>
                                    <th class="whitespace-nowrap">Status</th>
                                    <th class="whitespace-nowrap">Priority</th>
                                    <th class="whitespace-nowrap">Progress</th>
                                    <th class="whitespace-nowrap">Start Date</th>
                                    <th class="whitespace-nowrap">End Date</th>
                                    <th class="whitespace-nowrap">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be loaded via AJAX -->
                            </tbody>
                        </table>
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
                    { data: 'code', orderable: true },
                    { data: 'name', orderable: true },
                    { data: 'company', orderable: false },
                    { data: 'department', orderable: false },
                    { data: 'manager', orderable: false },
                    {
                        data: 'status',
                        orderable: false,
                        render: function(data) {
                            const colors = {
                                'planning': 'bg-blue-100 text-blue-700',
                                'active': 'bg-green-100 text-green-700',
                                'on_hold': 'bg-yellow-100 text-yellow-700',
                                'completed': 'bg-gray-100 text-gray-700',
                                'cancelled': 'bg-red-100 text-red-700'
                            };
                            return `<span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ${colors[data] || 'bg-gray-100 text-gray-700'}">${data.charAt(0).toUpperCase() + data.slice(1)}</span>`;
                        }
                    },
                    {
                        data: 'priority',
                        orderable: false,
                        render: function(data) {
                            const colors = {
                                'low': 'bg-gray-100 text-gray-700',
                                'medium': 'bg-blue-100 text-blue-700',
                                'high': 'bg-orange-100 text-orange-700',
                                'critical': 'bg-red-100 text-red-700'
                            };
                            return `<span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ${colors[data] || 'bg-gray-100 text-gray-700'}">${data.charAt(0).toUpperCase() + data.slice(1)}</span>`;
                        }
                    },
                    {
                        data: 'progress_percentage',
                        orderable: false,
                        render: function(data) {
                            const color = data >= 75 ? 'bg-green-500' : (data >= 50 ? 'bg-yellow-500' : 'bg-red-500');
                            return `<div class="w-full bg-gray-200 rounded-full h-2"><div class="${color} h-2 rounded-full" style="width: ${data}%"></div></div><span class="text-xs text-gray-600">${data}%</span>`;
                        }
                    },
                    { data: 'start_date', orderable: true },
                    { data: 'end_date', orderable: true },
                    { data: 'actions', orderable: false, searchable: false }
                ],
                order: [[0, 'asc']],
                pageLength: 15,
                responsive: true,
                language: {
                    emptyTable: "No projects found"
                }
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

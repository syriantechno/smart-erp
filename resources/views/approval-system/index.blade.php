@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Approval System - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">
@endpush

@section('subcontent')
    @include('components.global-notifications')

    <div class="mt-8 grid grid-cols-12 gap-6">
        <!-- Stats Cards -->
        <div class="col-span-12">
            <div class="grid grid-cols-12 gap-6">
                <!-- My Requests -->
                <div class="col-span-12 sm:col-span-6 xl:col-span-3">
                    <x-base.preview-component class="intro-y box">
                        <div class="flex items-center p-5">
                            <div class="image-fit h-12 w-12">
                                <x-base.lucide icon="FileText" class="h-8 w-8 text-blue-500" />
                            </div>
                            <div class="ml-4 mr-auto">
                                <div class="text-base font-medium text-slate-600 dark:text-slate-300">{{ $myRequestsCount }}</div>
                                <div class="text-slate-500 text-xs">My Requests</div>
                            </div>
                        </div>
                    </x-base.preview-component>
                </div>

                <!-- Pending Approval -->
                <div class="col-span-12 sm:col-span-6 xl:col-span-3">
                    <x-base.preview-component class="intro-y box">
                        <div class="flex items-center p-5">
                            <div class="image-fit h-12 w-12">
                                <x-base.lucide icon="Clock" class="h-8 w-8 text-yellow-500" />
                            </div>
                            <div class="ml-4 mr-auto">
                                <div class="text-base font-medium text-slate-600 dark:text-slate-300">{{ $pendingApprovalCount }}</div>
                                <div class="text-slate-500 text-xs">Pending Approval</div>
                            </div>
                        </div>
                    </x-base.preview-component>
                </div>

                <!-- Approved -->
                <div class="col-span-12 sm:col-span-6 xl:col-span-3">
                    <x-base.preview-component class="intro-y box">
                        <div class="flex items-center p-5">
                            <div class="image-fit h-12 w-12">
                                <x-base.lucide icon="CheckCircle" class="h-8 w-8 text-green-500" />
                            </div>
                            <div class="ml-4 mr-auto">
                                <div class="text-base font-medium text-slate-600 dark:text-slate-300">{{ $approvedCount }}</div>
                                <div class="text-slate-500 text-xs">Approved</div>
                            </div>
                        </div>
                    </x-base.preview-component>
                </div>

                <!-- Rejected -->
                <div class="col-span-12 sm:col-span-6 xl:col-span-3">
                    <x-base.preview-component class="intro-y box">
                        <div class="flex items-center p-5">
                            <div class="image-fit h-12 w-12">
                                <x-base.lucide icon="XCircle" class="h-8 w-8 text-red-500" />
                            </div>
                            <div class="ml-4 mr-auto">
                                <div class="text-base font-medium text-slate-600 dark:text-slate-300">{{ $rejectedCount }}</div>
                                <div class="text-slate-500 text-xs">Rejected</div>
                            </div>
                        </div>
                    </x-base.preview-component>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-span-12">
            <x-base.preview-component class="intro-y box">
                <!-- Tabs -->
                <div class="p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <div class="flex flex-col sm:flex-row items-center">
                        <h2 class="mr-5 text-lg font-medium">Approval Requests</h2>
                        <div class="flex items-center">
                            <x-base.button
                                variant="primary"
                                class="mr-2 shadow-md"
                                onclick="window.location.href='{{ route('approval-system.create') }}'"
                            >
                                <x-base.lucide icon="Plus" class="w-4 h-4 mr-2" />
                                New Request
                            </x-base.button>
                        </div>
                    </div>

                    <!-- Tab Navigation -->
                    <div class="mt-5">
                        <div class="nav nav-tabs flex-col sm:flex-row" role="tablist">
                            <a href="{{ route('approval-system.index', ['tab' => 'my-requests']) }}"
                               class="nav-link {{ $currentTab === 'my-requests' ? 'active' : '' }}">
                                <x-base.lucide icon="FileText" class="w-4 h-4 mr-2" />
                                My Requests
                                @if($myRequestsCount > 0)
                                    <span class="ml-2 bg-blue-500 text-white rounded-full px-2 py-1 text-xs">{{ $myRequestsCount }}</span>
                                @endif
                            </a>
                            <a href="{{ route('approval-system.index', ['tab' => 'pending-approval']) }}"
                               class="nav-link {{ $currentTab === 'pending-approval' ? 'active' : '' }}">
                                <x-base.lucide icon="Clock" class="w-4 h-4 mr-2" />
                                Pending Approval
                                @if($pendingApprovalCount > 0)
                                    <span class="ml-2 bg-yellow-500 text-white rounded-full px-2 py-1 text-xs">{{ $pendingApprovalCount }}</span>
                                @endif
                            </a>
                            <a href="{{ route('approval-system.index', ['tab' => 'approved']) }}"
                               class="nav-link {{ $currentTab === 'approved' ? 'active' : '' }}">
                                <x-base.lucide icon="CheckCircle" class="w-4 h-4 mr-2" />
                                Approved
                                @if($approvedCount > 0)
                                    <span class="ml-2 bg-green-500 text-white rounded-full px-2 py-1 text-xs">{{ $approvedCount }}</span>
                                @endif
                            </a>
                            <a href="{{ route('approval-system.index', ['tab' => 'rejected']) }}"
                               class="nav-link {{ $currentTab === 'rejected' ? 'active' : '' }}">
                                <x-base.lucide icon="XCircle" class="w-4 h-4 mr-2" />
                                Rejected
                                @if($rejectedCount > 0)
                                    <span class="ml-2 bg-red-500 text-white rounded-full px-2 py-1 text-xs">{{ $rejectedCount }}</span>
                                @endif
                            </a>
                            <a href="{{ route('approval-system.index', ['tab' => 'all']) }}"
                               class="nav-link {{ $currentTab === 'all' ? 'active' : '' }}">
                                <x-base.lucide icon="List" class="w-4 h-4 mr-2" />
                                All Requests
                            </a>
                        </div>
                    </div>

                    <!-- Filters -->
                    <div class="mt-5 grid grid-cols-12 gap-4">
                        <div class="col-span-12 md:col-span-3">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Type</label>
                            <select id="type-filter" class="w-full form-select">
                                <option value="">All Types</option>
                                <option value="leave_request">Leave Request</option>
                                <option value="purchase_request">Purchase Request</option>
                                <option value="expense_claim">Expense Claim</option>
                                <option value="loan_request">Loan Request</option>
                                <option value="overtime_request">Overtime Request</option>
                                <option value="training_request">Training Request</option>
                                <option value="equipment_request">Equipment Request</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="col-span-12 md:col-span-3">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Status</label>
                            <select id="status-filter" class="w-full form-select">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="col-span-12 md:col-span-3">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Priority</label>
                            <select id="priority-filter" class="w-full form-select">
                                <option value="">All Priorities</option>
                                <option value="low">Low</option>
                                <option value="normal">Normal</option>
                                <option value="high">High</option>
                                <option value="urgent">Urgent</option>
                            </select>
                        </div>
                        <div class="col-span-12 md:col-span-3 flex items-end">
                            <button onclick="applyFilters()" class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                                Apply Filters
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Data Table -->
                <div class="p-5">
                    <table id="approval-requests-table" class="table table-report -mt-2">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Requester</th>
                                <th>Approver</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </x-base.preview-component>
        </div>
    </div>

    <!-- View Request Modal -->
    <div id="view-request-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto" id="request-title"></h2>
                    <button type="button" class="text-slate-400 hover:text-slate-600" data-tw-dismiss="modal">
                        <x-base.lucide icon="X" class="w-6 h-6" />
                    </button>
                </div>
                <div class="modal-body p-6">
                    <div id="request-details"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Approve/Reject Modals -->
    <div id="approve-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Approve Request</h2>
                    <button type="button" class="text-slate-400 hover:text-slate-600" data-tw-dismiss="modal">
                        <x-base.lucide icon="X" class="w-6 h-6" />
                    </button>
                </div>
                <div class="modal-body p-6">
                    <form id="approve-form">
                        <div class="mb-4">
                            <label class="form-label">Comments (Optional)</label>
                            <textarea id="approve-comments" name="comments" rows="3" class="form-control" placeholder="Add approval comments..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-tw-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" onclick="submitApproval()">Approve</button>
                </div>
            </div>
        </div>
    </div>

    <div id="reject-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Reject Request</h2>
                    <button type="button" class="text-slate-400 hover:text-slate-600" data-tw-dismiss="modal">
                        <x-base.lucide icon="X" class="w-6 h-6" />
                    </button>
                </div>
                <div class="modal-body p-6">
                    <form id="reject-form">
                        <div class="mb-4">
                            <label class="form-label">Rejection Reason <span class="text-red-500">*</span></label>
                            <textarea id="reject-reason" name="reason" rows="3" class="form-control" placeholder="Please provide the reason for rejection..." required></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Comments (Optional)</label>
                            <textarea id="reject-comments" name="comments" rows="2" class="form-control" placeholder="Additional comments..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-tw-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" onclick="submitRejection()">Reject</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>

    <script>
        let approvalTable;
        let currentRequestId = null;

        $(document).ready(function() {
            initializeDataTable();
            setupEventListeners();
        });

        function initializeDataTable() {
            approvalTable = $('#approval-requests-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("approval-system.datatable") }}',
                    data: function(d) {
                        d.tab = '{{ $currentTab }}';
                        d.type_filter = $('#type-filter').val();
                        d.status_filter = $('#status-filter').val();
                        d.priority_filter = $('#priority-filter').val();
                    }
                },
                columns: [
                    { data: 'code', name: 'code' },
                    { data: 'title', name: 'title' },
                    { data: 'type_badge', name: 'type_badge' },
                    { data: 'priority_badge', name: 'priority_badge' },
                    { data: 'status_badge', name: 'status_badge' },
                    { data: 'requester_name', name: 'requester_name' },
                    { data: 'approver_name', name: 'approver_name' },
                    { data: 'amount_formatted', name: 'amount_formatted' },
                    { data: 'date', name: 'date' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ],
                pageLength: 25,
                responsive: true,
                dom: '<"flex flex-col sm:flex-row items-center gap-4"<"flex-1"l><"flex-1"f><"flex-1"B>>rt<"flex flex-col sm:flex-row items-center gap-4"<"flex-1"i><"flex-1"p>>',
                buttons: [
                    {
                        extend: 'excel',
                        text: '<i class="w-4 h-4 mr-2" data-lucide="file-spreadsheet"></i> Export Excel',
                        className: 'btn btn-success',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                        }
                    }
                ]
            });

            approvalTable.on('draw', function() {
                lucide.createIcons();
            });
        }

        function setupEventListeners() {
            // Filters
            $('#type-filter, #status-filter, #priority-filter').on('change', function() {
                approvalTable.ajax.reload();
            });
        }

        function applyFilters() {
            approvalTable.ajax.reload();
        }

        // Global functions
        window.viewRequest = function(id) {
            $.get('{{ route("approval-system.show", ":id") }}'.replace(':id', id))
                .done(function(response) {
                    if (response.success) {
                        displayRequestDetails(response.request);
                        $('#view-request-modal').modal('show');
                    }
                });
        };

        window.approveRequest = function(id) {
            currentRequestId = id;
            $('#approve-modal').modal('show');
        };

        window.rejectRequest = function(id) {
            currentRequestId = id;
            $('#reject-modal').modal('show');
        };

        window.submitApproval = function() {
            const comments = $('#approve-comments').val();

            $.post('{{ route("approval-system.approve", ":id") }}'.replace(':id', currentRequestId), {
                comments: comments,
                _token: '{{ csrf_token() }}'
            })
            .done(function(response) {
                if (response.success) {
                    $('#approve-modal').modal('hide');
                    approvalTable.ajax.reload();
                    Swal.fire('Success!', response.message, 'success');
                } else {
                    Swal.fire('Error!', response.message, 'error');
                }
            })
            .fail(function() {
                Swal.fire('Error!', 'Failed to approve request', 'error');
            });
        };

        window.submitRejection = function() {
            const reason = $('#reject-reason').val();
            const comments = $('#reject-comments').val();

            if (!reason.trim()) {
                Swal.fire('Error!', 'Please provide a rejection reason', 'error');
                return;
            }

            $.post('{{ route("approval-system.reject", ":id") }}'.replace(':id', currentRequestId), {
                reason: reason,
                comments: comments,
                _token: '{{ csrf_token() }}'
            })
            .done(function(response) {
                if (response.success) {
                    $('#reject-modal').modal('hide');
                    approvalTable.ajax.reload();
                    Swal.fire('Success!', response.message, 'success');
                } else {
                    Swal.fire('Error!', response.message, 'error');
                }
            })
            .fail(function() {
                Swal.fire('Error!', 'Failed to reject request', 'error');
            });
        };

        function displayRequestDetails(request) {
            $('#request-title').text(request.title);

            let logsHtml = '';
            if (request.logs && request.logs.length > 0) {
                logsHtml = '<div class="mt-6"><h4 class="font-semibold mb-3">Approval History</h4><div class="space-y-2">';
                request.logs.forEach(log => {
                    logsHtml += `
                        <div class="flex items-start gap-3 p-3 bg-slate-50 rounded">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-medium">
                                    ${log.user ? log.user.name.charAt(0).toUpperCase() : 'U'}
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="font-medium">${log.user ? log.user.name : 'Unknown'}</div>
                                <div class="text-sm text-slate-600">${log.action_label} - ${log.formatted_date}</div>
                                ${log.comments ? `<div class="text-sm mt-1">${log.comments}</div>` : ''}
                            </div>
                        </div>
                    `;
                });
                logsHtml += '</div></div>';
            }

            const details = `
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div><strong>Code:</strong> ${request.code}</div>
                    <div><strong>Type:</strong> <span class="px-2 py-1 text-xs font-medium rounded-full ${request.type_badge_class}">${request.type_label}</span></div>
                    <div><strong>Priority:</strong> <span class="px-2 py-1 text-xs font-medium rounded-full ${request.priority_badge_class}">${request.priority}</span></div>
                    <div><strong>Status:</strong> <span class="px-2 py-1 text-xs font-medium rounded-full ${request.status_badge_class}">${request.status}</span></div>
                    <div><strong>Requester:</strong> ${request.requester ? request.requester.name : 'Unknown'}</div>
                    <div><strong>Department:</strong> ${request.department ? request.department.name : 'N/A'}</div>
                    ${request.amount ? `<div><strong>Amount:</strong> $${request.amount}</div>` : ''}
                    ${request.start_date ? `<div><strong>Start Date:</strong> ${request.start_date}</div>` : ''}
                    ${request.end_date ? `<div><strong>End Date:</strong> ${request.end_date}</div>` : ''}
                    ${request.duration_days ? `<div><strong>Duration:</strong> ${request.duration_days} days</div>` : ''}
                </div>

                <div class="mb-6">
                    <h4 class="font-semibold mb-2">Description</h4>
                    <div class="bg-slate-50 p-3 rounded">
                        ${request.description || 'No description provided'}
                    </div>
                </div>

                ${request.rejection_reason ? `
                    <div class="mb-6">
                        <h4 class="font-semibold mb-2 text-red-600">Rejection Reason</h4>
                        <div class="bg-red-50 p-3 rounded border border-red-200">
                            ${request.rejection_reason}
                        </div>
                    </div>
                ` : ''}

                ${logsHtml}
            `;

            $('#request-details').html(details);
        }
    </script>
@endpush

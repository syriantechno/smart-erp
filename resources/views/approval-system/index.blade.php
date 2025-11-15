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
        @if(false)
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
        @endif

        <!-- Main Content -->
        <div class="col-span-12">
            <x-base.preview-component class="intro-y box">
                <!-- Tabs -->
                <div class="p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <div class="flex flex-col sm:flex-row items-center">
                        <h2 class="mr-5 text-lg font-medium">Approval Requests</h2>
                        <div class="flex items-center">
                            <x-base.button
                                id="new-request-btn"
                                variant="primary"
                                class="mr-2 shadow-md"
                                type="button"
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

                    @if(false)
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
                    @endif
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

    <!-- Create Request Modal -->
    <div
        id="create-request-modal"
        class="fixed inset-0 z-[9999] flex items-center justify-center bg-slate-900/70 hidden"
        tabindex="-1"
        aria-hidden="true"
    >
        <div class="modal-dialog w-full max-w-4xl mx-4">
            <div class="modal-content bg-white dark:bg-darkmode-600 rounded-lg shadow-xl overflow-hidden">
                <div class="modal-header flex items-center justify-between border-b border-slate-200/60 dark:border-darkmode-400 px-5 py-3">
                    <h2 class="font-medium text-base mr-auto">Create New Approval Request</h2>
                    <button
                        type="button"
                        class="text-slate-400 hover:text-slate-600"
                        onclick="closeModal('create-request-modal')"
                    >
                        <x-base.lucide icon="X" class="w-6 h-6" />
                    </button>
                </div>
                <div class="modal-body p-6 max-h-[80vh] overflow-auto">
                    <form id="create-request-form" enctype="multipart/form-data">
                        @csrf

                        <!-- Request Type & Priority -->
                        <div class="grid grid-cols-12 gap-4 mb-6">
                            <div class="col-span-12 md:col-span-6">
                                <label class="form-label">Request Type <span class="text-danger">*</span></label>
                                <select id="request-type" name="type" class="w-full form-select" required>
                                    <option value="">Select Request Type</option>
                                    <option value="leave_request">Leave Request</option>
                                    <option value="purchase_request">Purchase Request</option>
                                    <option value="expense_claim">Expense Claim</option>
                                    <option value="loan_request">Loan Request</option>
                                    <option value="overtime_request">Overtime Request</option>
                                    <option value="training_request">Training Request</option>
                                    <option value="equipment_request">Equipment Request</option>
                                    <option value="other">Other Request</option>
                                </select>
                            </div>

                            <div class="col-span-12 md:col-span-6">
                                <label class="form-label">Priority <span class="text-danger">*</span></label>
                                <select id="request-priority" name="priority" class="w-full form-select" required>
                                    <option value="normal">Normal</option>
                                    <option value="low">Low</option>
                                    <option value="high">High</option>
                                    <option value="urgent">Urgent</option>
                                </select>
                            </div>
                        </div>

                        <!-- Basic Information -->
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4">Basic Information</h4>

                            <div class="grid grid-cols-12 gap-4">
                                <div class="col-span-12">
                                    <label class="form-label">Title <span class="text-danger">*</span></label>
                                    <input id="request-title" name="title" type="text" class="w-full form-control" placeholder="Enter request title" required />
                                </div>

                                <div class="col-span-12">
                                    <label class="form-label">Description <span class="text-danger">*</span></label>
                                    <textarea id="request-description" name="description" rows="4" class="w-full form-control" placeholder="Describe your request in detail" required></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Financial Information -->
                        <div id="financial-section" class="mb-6" style="display: none;">
                            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4">Financial Information</h4>

                            <div class="grid grid-cols-12 gap-4">
                                <div class="col-span-12 md:col-span-6">
                                    <label class="form-label">Amount ($)</label>
                                    <input id="request-amount" name="amount" type="number" step="0.01" min="0" class="w-full form-control" placeholder="0.00" />
                                </div>
                            </div>
                        </div>

                        <!-- Date Information -->
                        <div id="date-section" class="mb-6" style="display: none;">
                            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4">Date Information</h4>

                            <div class="grid grid-cols-12 gap-4">
                                <div class="col-span-12 md:col-span-6">
                                    <label class="form-label">Start Date</label>
                                    <div class="relative mx-auto w-56">
                                        <div
                                            class="absolute flex h-full w-10 items-center justify-center rounded-l border bg-slate-100 text-slate-500 dark:border-darkmode-800 dark:bg-darkmode-700 dark:text-slate-400">
                                            <x-base.lucide icon="calendar" class="stroke-1.5 w-5 h-5"></x-base.lucide>
                                        </div>
                                        <x-base.litepicker
                                            id="request-start-date"
                                            name="start_date"
                                            class="pl-12"
                                            data-single-mode="true"
                                        />
                                    </div>
                                </div>

                                <div class="col-span-12 md:col-span-6">
                                    <label class="form-label">End Date</label>
                                    <div class="relative mx-auto w-56">
                                        <div
                                            class="absolute flex h-full w-10 items-center justify-center rounded-l border bg-slate-100 text-slate-500 dark:border-darkmode-800 dark:bg-darkmode-700 dark:text-slate-400">
                                            <x-base.lucide icon="calendar" class="stroke-1.5 w-5 h-5"></x-base.lucide>
                                        </div>
                                        <x-base.litepicker
                                            id="request-end-date"
                                            name="end_date"
                                            class="pl-12"
                                            data-single-mode="true"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Organization -->
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4">Organization</h4>

                            <div class="grid grid-cols-12 gap-4">
                                <div class="col-span-12 md:col-span-6">
                                    <label class="form-label">Company</label>
                                    <select id="request-company" name="company_id" class="w-full form-select">
                                        <option value="">Select Company</option>
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-span-12 md:col-span-6">
                                    <label class="form-label">Department</label>
                                    <select id="request-department" name="department_id" class="w-full form-select">
                                        <option value="">Select Department</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Attachments -->
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4">Attachments</h4>

                            <div class="border-2 border-dashed border-slate-300 dark:border-darkmode-400 rounded-lg p-4">
                                <div class="text-center">
                                    <x-base.lucide icon="Upload" class="w-12 h-12 text-slate-400 mx-auto mb-2" />
                                    <p class="text-slate-600 dark:text-slate-400 mb-2">Drop files here or click to browse</p>
                                    <p class="text-xs text-slate-500 mb-4">Supported: PDF, DOC, DOCX, XLS, XLSX, JPG, PNG (Max 10MB each)</p>
                                    <input type="file" id="attachments" name="attachments[]" multiple class="hidden" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png" />
                                    <x-base.button
                                        variant="outline-primary"
                                        type="button"
                                        onclick="document.getElementById('attachments').click()"
                                    >
                                        Choose Files
                                    </x-base.button>
                                </div>
                                <div id="file-list" class="mt-4 space-y-2"></div>
                            </div>
                        </div>

                        <!-- Preview -->
                        <div id="preview-section" class="mb-6" style="display: none;">
                            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4">Approval Preview</h4>

                            <div class="bg-slate-50 dark:bg-darkmode-600 p-4 rounded-lg">
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div><strong>Approver:</strong> <span id="preview-approver">Loading...</span></div>
                                    <div><strong>Level:</strong> <span id="preview-level">1</span></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer flex justify-end gap-2 border-t border-slate-200/60 dark:border-darkmode-400 px-5 py-3">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        onclick="closeModal('create-request-modal')"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="btn btn-primary"
                        id="submit-request-btn"
                        form="create-request-form"
                    >
                        Submit Request
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Request Modal -->
    <div
        id="view-request-modal"
        class="fixed inset-0 z-[9999] flex items-center justify-center bg-slate-900/70 hidden"
        tabindex="-1"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-xl w-full max-w-5xl mx-4">
            <div class="modal-content bg-white dark:bg-darkmode-600 rounded-lg shadow-xl overflow-hidden">
                <div class="modal-header flex items-center justify-between border-b border-slate-200/60 dark:border-darkmode-400 px-5 py-3">
                    <h2 class="font-medium text-base mr-auto" id="request-title"></h2>
                    <button
                        type="button"
                        class="text-slate-400 hover:text-slate-600"
                        onclick="closeModal('view-request-modal')"
                    >
                        <x-base.lucide icon="X" class="w-6 h-6" />
                    </button>
                </div>
                <div class="modal-body p-6 max-h-[70vh] overflow-auto">
                    <div id="request-details"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Approve/Reject Modals -->
    <div
        id="approve-modal"
        class="fixed inset-0 z-[9999] flex items-center justify-center bg-slate-900/70 hidden"
        tabindex="-1"
        aria-hidden="true"
    >
        <div class="modal-dialog w-full max-w-lg mx-4">
            <div class="modal-content bg-white dark:bg-darkmode-600 rounded-lg shadow-xl overflow-hidden">
                <div class="modal-header flex items-center justify-between border-b border-slate-200/60 dark:border-darkmode-400 px-5 py-3">
                    <h2 class="font-medium text-base mr-auto">Approve Request</h2>
                    <button
                        type="button"
                        class="text-slate-400 hover:text-slate-600"
                        onclick="closeModal('approve-modal')"
                    >
                        <x-base.lucide icon="X" class="w-6 h-6" />
                    </button>
                </div>
                <div class="modal-body p-6">
                    <form id="approve-form">
                        <div class="mb-4">
                            <label class="form-label">Comments (Optional)</label>
                            <textarea
                                id="approve-comments"
                                name="comments"
                                rows="3"
                                class="form-control"
                                placeholder="Add approval comments..."
                            ></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer flex justify-end gap-2 border-t border-slate-200/60 dark:border-darkmode-400 px-5 py-3">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        onclick="closeModal('approve-modal')"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="btn btn-success"
                        onclick="submitApproval()"
                    >
                        Approve
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div
        id="reject-modal"
        class="fixed inset-0 z-[9999] flex items-center justify-center bg-slate-900/70 hidden"
        tabindex="-1"
        aria-hidden="true"
    >
        <div class="modal-dialog w-full max-w-lg mx-4">
            <div class="modal-content bg-white dark:bg-darkmode-600 rounded-lg shadow-xl overflow-hidden">
                <div class="modal-header flex items-center justify-between border-b border-slate-200/60 dark:border-darkmode-400 px-5 py-3">
                    <h2 class="font-medium text-base mr-auto">Reject Request</h2>
                    <button
                        type="button"
                        class="text-slate-400 hover:text-slate-600"
                        onclick="closeModal('reject-modal')"
                    >
                        <x-base.lucide icon="X" class="w-6 h-6" />
                    </button>
                </div>
                <div class="modal-body p-6">
                    <form id="reject-form">
                        <div class="mb-4">
                            <label class="form-label">Rejection Reason <span class="text-red-500">*</span></label>
                            <textarea
                                id="reject-reason"
                                name="reason"
                                rows="3"
                                class="form-control"
                                placeholder="Please provide the reason for rejection..."
                                required
                            ></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Comments (Optional)</label>
                            <textarea
                                id="reject-comments"
                                name="comments"
                                rows="2"
                                class="form-control"
                                placeholder="Additional comments..."
                            ></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer flex justify-end gap-2 border-t border-slate-200/60 dark:border-darkmode-400 px-5 py-3">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        onclick="closeModal('reject-modal')"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="btn btn-danger"
                        onclick="submitRejection()"
                    >
                        Reject
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('components.datatable.scripts')

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>

    <script>
        let approvalTable;
        let currentRequestId = null;

        window.openModal = function (id) {
            const modal = document.getElementById(id);
            if (!modal) return;
            modal.classList.remove('hidden');
        };

        window.closeModal = function (id) {
            const modal = document.getElementById(id);
            if (!modal) return;
            modal.classList.add('hidden');
        };

        window.openCreateRequestModal = function () {
            const form = document.getElementById('create-request-form');
            if (form) {
                form.reset();
            }
            const fileList = document.getElementById('file-list');
            if (fileList) {
                fileList.innerHTML = '';
            }
            const financialSection = document.getElementById('financial-section');
            const dateSection = document.getElementById('date-section');
            const previewSection = document.getElementById('preview-section');
            if (financialSection) financialSection.style.display = 'none';
            if (dateSection) dateSection.style.display = 'none';
            if (previewSection) previewSection.style.display = 'none';

            openModal('create-request-modal');
        };

        $(document).ready(function() {
            initializeDataTable();
            setupEventListeners();
            setupCreateRequestModal();
        });

        function initializeDataTable() {
            if (typeof window.initDataTable !== 'function') {
                console.error('initDataTable helper is not available.');
                return;
            }

            approvalTable = window.initDataTable('#approval-requests-table', {
                ajax: {
                    url: '{{ route("approval-system.datatable") }}',
                    data: function(d) {
                        d.tab = '{{ $currentTab }}';

                        const typeEl = document.getElementById('type-filter');
                        const statusEl = document.getElementById('status-filter');
                        const priorityEl = document.getElementById('priority-filter');

                        d.type_filter = typeEl ? typeEl.value : '';
                        d.status_filter = statusEl ? statusEl.value : '';
                        d.priority_filter = priorityEl ? priorityEl.value : '';
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

            if (!approvalTable) {
                console.error('Failed to initialise approval requests DataTable.');
                return;
            }

            approvalTable.on('draw', function() {
                if (window.lucide && typeof window.lucide.createIcons === 'function') {
                    window.lucide.createIcons();
                }
            });
        }

        function setupEventListeners() {
            // Filters
            $('#type-filter, #status-filter, #priority-filter').on('change', function() {
                approvalTable.ajax.reload();
            });

            const newRequestBtn = document.getElementById('new-request-btn');
            if (newRequestBtn) {
                newRequestBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    openCreateRequestModal();
                });
            }
        }

        function setupCreateRequestModal() {
            const requestType = document.getElementById('request-type');
            const fileInput = document.getElementById('attachments');
            const fileList = document.getElementById('file-list');
            const companySelect = document.getElementById('request-company');
            const departmentSelect = document.getElementById('request-department');
            const form = document.getElementById('create-request-form');
            const submitBtn = document.getElementById('submit-request-btn');

            if (requestType) {
                requestType.addEventListener('change', function() {
                    const financialSection = document.getElementById('financial-section');
                    const dateSection = document.getElementById('date-section');
                    const previewSection = document.getElementById('preview-section');

                    const showFinancial = ['purchase_request', 'expense_claim', 'loan_request', 'equipment_request'].includes(this.value);
                    const showDate = ['leave_request', 'training_request'].includes(this.value);

                    if (financialSection) financialSection.style.display = showFinancial ? 'block' : 'none';
                    if (dateSection) dateSection.style.display = showDate ? 'block' : 'none';
                    if (previewSection) previewSection.style.display = this.value ? 'block' : 'none';

                    if (this.value) {
                        document.getElementById('preview-approver').textContent = 'Department Manager';
                        document.getElementById('preview-level').textContent = '1';
                    }
                });
            }

            if (fileInput && fileList) {
                fileInput.addEventListener('change', function(e) {
                    fileList.innerHTML = '';
                    Array.from(e.target.files).forEach((file, index) => {
                        const fileItem = document.createElement('div');
                        fileItem.className = 'flex items-center justify-between bg-slate-50 dark:bg-darkmode-600 p-2 rounded';
                        fileItem.innerHTML = `
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <span class="text-sm">${file.name}</span>
                            </div>
                        `;
                        fileList.appendChild(fileItem);
                    });
                });
            }

            if (companySelect && departmentSelect) {
                companySelect.addEventListener('change', function() {
                    const value = this.value;
                    departmentSelect.innerHTML = '<option value="">Select Department</option>';
                    @foreach($departments as $department)
                        (function() {
                            const deptCompanyId = {{ $department->company_id ?? 'null' }};
                            if (!value || String(deptCompanyId) === value) {
                                const opt = document.createElement('option');
                                opt.value = '{{ $department->id }}';
                                opt.textContent = '{{ $department->name }}';
                                departmentSelect.appendChild(opt);
                            }
                        })();
                    @endforeach
                });
            }

            if (form && submitBtn) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(form);
                    const originalText = submitBtn.innerHTML;

                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<svg class="w-4 h-4 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>Submitting...';

                    fetch('{{ route("approval-system.store") }}', {
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
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Approval request submitted successfully',
                                timer: 3000,
                                showConfirmButton: false
                            }).then(() => {
                                closeModal('create-request-modal');
                                if (approvalTable) {
                                    approvalTable.ajax.reload();
                                }
                            });
                        } else {
                            let errorMessage = 'Failed to submit request';
                            if (data.errors) {
                                errorMessage = Object.values(data.errors).flat().join('\n');
                            } else if (data.message) {
                                errorMessage = data.message;
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: errorMessage
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'An error occurred while submitting the request'
                        });
                    })
                    .finally(() => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                    });
                });
            }
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
                        openModal('view-request-modal');
                    }
                });
        };

        window.approveRequest = function(id) {
            currentRequestId = id;
            openModal('approve-modal');
        };

        window.rejectRequest = function(id) {
            currentRequestId = id;
            openModal('reject-modal');
        };

        window.submitApproval = function() {
            const comments = $('#approve-comments').val();

            $.post('{{ route("approval-system.approve", ":id") }}'.replace(':id', currentRequestId), {
                comments: comments,
                _token: '{{ csrf_token() }}'
            })
            .done(function(response) {
                if (response.success) {
                    closeModal('approve-modal');
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
                    closeModal('reject-modal');
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

@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Create Approval Request - {{ config('app.name') }}</title>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">
@endpush

@section('subcontent')
    @include('components.global-notifications')

    <div class="mt-8 grid grid-cols-12 gap-6">
        <div class="col-span-12">
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-medium">Create New Approval Request</h2>
                        <x-base.button
                            variant="outline-secondary"
                            onclick="window.location.href='{{ route('approval-system.index') }}'"
                        >
                            <x-base.lucide icon="ArrowLeft" class="w-4 h-4 mr-2" />
                            Back to Requests
                        </x-base.button>
                    </div>

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
                                    <input id="request-start-date" name="start_date" type="date" class="w-full form-control" />
                                </div>

                                <div class="col-span-12 md:col-span-6">
                                    <label class="form-label">End Date</label>
                                    <input id="request-end-date" name="end_date" type="date" class="w-full form-control" />
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

                        <!-- Actions -->
                        <div class="flex justify-end gap-2 pt-6 border-t">
                            <x-base.button
                                variant="outline-secondary"
                                type="button"
                                onclick="window.location.href='{{ route('approval-system.index') }}'"
                            >
                                Cancel
                            </x-base.button>
                            <x-base.button
                                variant="primary"
                                type="submit"
                                id="submit-request-btn"
                            >
                                <x-base.lucide icon="Send" class="w-4 h-4 mr-2" />
                                Submit Request
                            </x-base.button>
                        </div>
                    </form>
                </div>
            </x-base.preview-component>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setupRequestTypeToggle();
            setupFileUpload();
            setupFormSubmission();
            setupCompanyDepartmentFilter();
        });

        function setupRequestTypeToggle() {
            const requestType = document.getElementById('request-type');

            requestType.addEventListener('change', function() {
                const financialSection = document.getElementById('financial-section');
                const dateSection = document.getElementById('date-section');
                const previewSection = document.getElementById('preview-section');

                // Show/hide sections based on request type
                const showFinancial = ['purchase_request', 'expense_claim', 'loan_request', 'equipment_request'].includes(this.value);
                const showDate = ['leave_request', 'training_request'].includes(this.value);

                financialSection.style.display = showFinancial ? 'block' : 'none';
                dateSection.style.display = showDate ? 'block' : 'none';
                previewSection.style.display = this.value ? 'block' : 'none';

                // Update preview
                if (this.value) {
                    updateApprovalPreview(this.value);
                }
            });
        }

        function updateApprovalPreview(requestType) {
            // This would typically make an AJAX call to get approval workflow
            // For now, we'll show a simple preview
            document.getElementById('preview-approver').textContent = 'Department Manager';
            document.getElementById('preview-level').textContent = '1';
        }

        function setupFileUpload() {
            const fileInput = document.getElementById('attachments');
            const fileList = document.getElementById('file-list');

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
                            <span class="text-xs text-slate-500">(${formatFileSize(file.size)})</span>
                        </div>
                        <button type="button" onclick="removeFile(${index})" class="text-red-500 hover:text-red-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    `;
                    fileList.appendChild(fileItem);
                });
            });
        }

        function setupFormSubmission() {
            const form = document.getElementById('create-request-form');
            const submitBtn = document.getElementById('submit-request-btn');

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
                            window.location.href = '{{ route("approval-system.index") }}';
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

        function setupCompanyDepartmentFilter() {
            const companySelect = document.getElementById('request-company');
            const departmentSelect = document.getElementById('request-department');

            companySelect.addEventListener('change', function() {
                departmentSelect.innerHTML = '<option value="">Select Department</option>';
                @foreach($departments as $department)
                    const deptOption = document.createElement('option');
                    deptOption.value = '{{ $department->id }}';
                    deptOption.textContent = '{{ $department->name }}';
                    if ({{ $department->company_id }} == this.value || this.value === '') {
                        departmentSelect.appendChild(deptOption);
                    }
                @endforeach
            });
        }

        function removeFile(index) {
            const fileInput = document.getElementById('attachments');
            const dt = new DataTransfer();
            const files = Array.from(fileInput.files);

            files.splice(index, 1);

            files.forEach(file => dt.items.add(file));
            fileInput.files = dt.files;

            // Trigger change event to update file list
            fileInput.dispatchEvent(new Event('change'));
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
    </script>
@endpush

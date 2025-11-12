@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Compose Mail - {{ config('app.name') }}</title>
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
                        <h2 class="text-lg font-medium">Compose New Mail</h2>
                        <x-base.button
                            variant="outline-secondary"
                            onclick="window.location.href='{{ route('electronic-mail.index') }}'"
                        >
                            <x-base.lucide icon="ArrowLeft" class="w-4 h-4 mr-2" />
                            Back to Inbox
                        </x-base.button>
                    </div>

                    <form id="compose-mail-form" enctype="multipart/form-data">
                        @csrf

                        <!-- Mail Type & Priority -->
                        <div class="grid grid-cols-12 gap-4 mb-6">
                            <div class="col-span-12 md:col-span-6">
                                <label class="form-label">Mail Type <span class="text-danger">*</span></label>
                                <x-base.form-select id="mail-type" name="type" class="w-full" required>
                                    <option value="outgoing">Outgoing (Send)</option>
                                    <option value="incoming">Incoming (Receive)</option>
                                </x-base.form-select>
                            </div>

                            <div class="col-span-12 md:col-span-6">
                                <label class="form-label">Priority <span class="text-danger">*</span></label>
                                <x-base.form-select id="mail-priority" name="priority" class="w-full" required>
                                    <option value="normal">Normal</option>
                                    <option value="low">Low</option>
                                    <option value="high">High</option>
                                    <option value="urgent">Urgent</option>
                                </x-base.form-select>
                            </div>
                        </div>

                        <!-- Recipients -->
                        <div id="recipients-section" class="mb-6">
                            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4">Recipients</h4>

                            <div class="grid grid-cols-12 gap-4">
                                <div class="col-span-12 md:col-span-6">
                                    <label class="form-label">Recipient Name</label>
                                    <x-base.form-input
                                        id="recipient-name"
                                        name="recipient_name"
                                        type="text"
                                        placeholder="Enter recipient name"
                                        class="w-full"
                                    />
                                </div>

                                <div class="col-span-12 md:col-span-6">
                                    <label class="form-label">Recipient Email</label>
                                    <x-base.form-input
                                        id="recipient-email"
                                        name="recipient_email"
                                        type="email"
                                        placeholder="Enter recipient email"
                                        class="w-full"
                                    />
                                </div>

                                <div class="col-span-12 md:col-span-6">
                                    <label class="form-label">Internal User (Optional)</label>
                                    <x-base.form-select id="recipient-user-id" name="recipient_user_id" class="w-full">
                                        <option value="">Select internal user</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                        @endforeach
                                    </x-base.form-select>
                                </div>

                                <div class="col-span-12 md:col-span-6">
                                    <label class="form-label">CC (Optional)</label>
                                    <x-base.form-input
                                        id="cc"
                                        name="cc[]"
                                        type="email"
                                        placeholder="Add CC email"
                                        class="w-full"
                                        multiple
                                    />
                                </div>
                            </div>
                        </div>

                        <!-- Sender (for incoming mails) -->
                        <div id="sender-section" class="mb-6" style="display: none;">
                            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4">Sender Information</h4>

                            <div class="grid grid-cols-12 gap-4">
                                <div class="col-span-12 md:col-span-6">
                                    <label class="form-label">Sender Name</label>
                                    <x-base.form-input
                                        id="sender-name"
                                        name="sender_name"
                                        type="text"
                                        placeholder="Enter sender name"
                                        class="w-full"
                                    />
                                </div>

                                <div class="col-span-12 md:col-span-6">
                                    <label class="form-label">Sender Email</label>
                                    <x-base.form-input
                                        id="sender-email"
                                        name="sender_email"
                                        type="email"
                                        placeholder="Enter sender email"
                                        class="w-full"
                                    />
                                </div>
                            </div>
                        </div>

                        <!-- Mail Content -->
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4">Mail Content</h4>

                            <div class="grid grid-cols-12 gap-4">
                                <div class="col-span-12">
                                    <label class="form-label">Subject <span class="text-danger">*</span></label>
                                    <x-base.form-input
                                        id="mail-subject"
                                        name="subject"
                                        type="text"
                                        placeholder="Enter mail subject"
                                        class="w-full"
                                        required
                                    />
                                </div>

                                <div class="col-span-12">
                                    <label class="form-label">Content <span class="text-danger">*</span></label>
                                    <x-base.form-textarea
                                        id="mail-content"
                                        name="content"
                                        rows="8"
                                        placeholder="Enter mail content..."
                                        class="w-full"
                                        required
                                    ></x-base.form-textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Organization -->
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4">Organization</h4>

                            <div class="grid grid-cols-12 gap-4">
                                <div class="col-span-12 md:col-span-6">
                                    <label class="form-label">Company</label>
                                    <x-base.form-select id="company-id" name="company_id" class="w-full">
                                        <option value="">Select Company</option>
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </x-base.form-select>
                                </div>

                                <div class="col-span-12 md:col-span-6">
                                    <label class="form-label">Department</label>
                                    <x-base.form-select id="department-id" name="department_id" class="w-full">
                                        <option value="">Select Department</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    </x-base.form-select>
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
                                    <input type="file" id="attachments" name="attachments[]" multiple class="hidden" accept=".pdf,.doc,.docx,.txt,.jpg,.jpeg,.png,.gif,.zip,.rar">
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

                        <!-- Status -->
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4">Status</h4>

                            <div class="flex items-center gap-4">
                                <label class="flex items-center">
                                    <input type="radio" name="status" value="draft" checked class="mr-2">
                                    <span class="text-slate-600 dark:text-slate-400">Save as Draft</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="status" value="sent" class="mr-2">
                                    <span class="text-slate-600 dark:text-slate-400">Send Now</span>
                                </label>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex justify-end gap-2 pt-6 border-t">
                            <x-base.button
                                variant="outline-secondary"
                                type="button"
                                onclick="window.location.href='{{ route('electronic-mail.index') }}'"
                            >
                                Cancel
                            </x-base.button>
                            <x-base.button
                                variant="primary"
                                type="submit"
                                id="send-mail-btn"
                            >
                                <x-base.lucide icon="Send" class="w-4 h-4 mr-2" />
                                Send Mail
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
            setupMailTypeToggle();
            setupFileUpload();
            setupFormSubmission();
            setupCompanyDepartmentFilter();
        });

        function setupMailTypeToggle() {
            const mailType = document.getElementById('mail-type');
            const recipientsSection = document.getElementById('recipients-section');
            const senderSection = document.getElementById('sender-section');

            mailType.addEventListener('change', function() {
                if (this.value === 'incoming') {
                    recipientsSection.style.display = 'none';
                    senderSection.style.display = 'block';
                } else {
                    recipientsSection.style.display = 'block';
                    senderSection.style.display = 'none';
                }
            });
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
            const form = document.getElementById('compose-mail-form');
            const submitBtn = document.getElementById('send-mail-btn');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(form);
                const originalText = submitBtn.innerHTML;

                submitBtn.disabled = true;
                submitBtn.innerHTML = '<svg class="w-4 h-4 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>Sending...';

                fetch('{{ route("electronic-mail.store") }}', {
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
                            text: data.message,
                            timer: 3000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = '{{ route("electronic-mail.index") }}';
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: data.message || 'Failed to send mail'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'An error occurred while sending the mail'
                    });
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                });
            });
        }

        function setupCompanyDepartmentFilter() {
            const companySelect = document.getElementById('company-id');
            const departmentSelect = document.getElementById('department-id');

            companySelect.addEventListener('change', function() {
                departmentSelect.innerHTML = '<option value="">Select Department</option>';
                @foreach($departments as $department)
                    if ({{ $department->company_id }} == this.value || this.value === '') {
                        const option = document.createElement('option');
                        option.value = '{{ $department->id }}';
                        option.textContent = '{{ $department->name }}';
                        departmentSelect.appendChild(option);
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

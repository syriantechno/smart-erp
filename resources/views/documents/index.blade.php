@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Document Management - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">
    <style>
        .category-item {
            transition: all 0.2s ease;
            cursor: pointer;
        }
        .category-item:hover {
            transform: translateX(4px);
        }
        .category-item.active {
            background-color: #dbeafe;
            border-left: 3px solid #3b82f6;
        }
        .document-item {
            transition: background-color 0.2s ease;
        }
        .document-item:hover {
            background-color: #f9fafb;
        }
        .file-icon {
            width: 2rem;
            height: 2rem;
            border-radius: 0.375rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .nested-category {
            margin-left: 1rem;
            border-left: 1px solid #e5e7eb;
            padding-left: 1rem;
        }
        .upload-area {
            border: 2px dashed #d1d5db;
            border-radius: 0.5rem;
            transition: border-color 0.2s ease;
        }
        .upload-area:hover {
            border-color: #3b82f6;
        }
        .upload-area.dragover {
            border-color: #10b981;
            background-color: #f0fdf4;
        }
    </style>
@endpush

@section('subcontent')
    @include('components.global-notifications')

    <div class="mt-8 grid grid-cols-12 gap-6">
        <!-- Sidebar with Categories (styled like file manager menu) -->
        <div class="col-span-12 lg:col-span-3 2xl:col-span-2">
            <h2 class="intro-y mr-auto mt-2 text-lg font-medium">
                Document Catalog
            </h2>

            <!-- BEGIN: Catalog Menu (similar to file-manager sidebar) -->
            <div class="intro-y box mt-6 p-4">
                <!-- Root entries -->
                <div class="space-y-1">
                    <!-- All Documents -->
                    <a
                        href="javascript:;"
                        class="category-item flex items-center rounded-md px-3 py-2 text-sm {{ !$currentCategory ? 'bg-primary text-white' : 'text-slate-700 hover:bg-slate-100' }}"
                        onclick="filterByCategory('')"
                    >
                        <x-base.lucide
                            icon="Folder"
                            class="mr-2 h-4 w-4 {{ !$currentCategory ? 'text-white' : 'text-blue-600' }}"
                        />
                        <span class="flex-1">All Documents</span>
                    </a>

                    <!-- Uncategorized -->
                    <a
                        href="javascript:;"
                        class="category-item flex items-center rounded-md px-3 py-2 text-sm {{ $currentCategory === 'uncategorized' ? 'bg-primary text-white' : 'text-slate-700 hover:bg-slate-100' }}"
                        onclick="filterByCategory('uncategorized')"
                    >
                        <x-base.lucide
                            icon="FolderX"
                            class="mr-2 h-4 w-4 {{ $currentCategory === 'uncategorized' ? 'text-white' : 'text-slate-500' }}"
                        />
                        <div class="flex-1">
                            <span>Uncategorized</span>
                            <span class="ml-1 text-[11px] text-slate-400">Files without category</span>
                        </div>
                    </a>
                </div>

                <!-- Categories Tree -->
                <div class="mt-4 border-t border-slate-200 pt-4 dark:border-darkmode-400 max-h-72 overflow-y-auto">
                    @foreach($categories as $category)
                        @include('documents.partials.category-item', ['category' => $category, 'level' => 0])
                    @endforeach
                </div>

                <!-- Add Category Button -->
                <div class="mt-4 pt-3 border-t border-dashed border-slate-200 dark:border-darkmode-400">
                    <x-base.button
                        variant="outline-primary"
                        size="sm"
                        class="w-full flex items-center justify-center"
                        data-tw-toggle="modal"
                        data-tw-target="#category-modal"
                    >
                        <x-base.lucide icon="Plus" class="mr-2 h-4 w-4" />
                        Manage Categories
                    </x-base.button>
                </div>
            </div>
            <!-- END: Catalog Menu -->

            <!-- Quick Stats (kept but styled under catalog) -->
            <div class="intro-y box mt-6 p-4">
                <h3 class="mb-3 flex items-center text-sm font-semibold text-slate-800 dark:text-slate-100">
                    <x-base.lucide icon="BarChart3" class="mr-2 h-4 w-4 text-blue-600" />
                    Quick Stats
                </h3>
                <div class="space-y-2 text-xs">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-600">Total Files</span>
                        <span class="font-semibold text-blue-600" id="total-files">-</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-600">This Month</span>
                        <span class="font-semibold text-emerald-600" id="monthly-files">-</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-600">Storage Used</span>
                        <span class="font-semibold text-purple-600" id="storage-used">-</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-span-12 lg:col-span-9 2xl:col-span-10">
            <div class="bg-white rounded-lg shadow-sm border">
                <!-- Header -->
                <div class="p-5 border-b border-slate-200/60">
                    <div class="flex flex-col sm:flex-row items-center justify-between">
                        <div class="flex items-center mb-4 sm:mb-0">
                            <x-base.lucide icon="file-text" class="w-6 h-6 mr-3 text-gray-600" />
                            <div>
                                <h2 class="text-xl font-semibold">Document Library</h2>
                                <p class="text-sm text-gray-600">Manage and organize your documents</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <!-- Page Length -->
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-slate-600">Show</span>
                                <x-base.form-select id="documents-length" class="w-20 text-sm">
                                    <option value="10">10</option>
                                    <option value="25" selected>25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </x-base.form-select>
                                <span class="text-sm text-slate-600">entries</span>
                            </div>

                            <!-- Search -->
                            <div class="relative w-64">
                                <x-base.lucide icon="Search" class="w-4 h-4 absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-400" />
                                <x-base.form-input
                                    id="document-search"
                                    type="text"
                                    placeholder="Search documents..."
                                    class="pl-10 w-full"
                                />
                            </div>
                            <!-- Upload Button -->
                            <x-base.button
                                type="button"
                                variant="primary"
                                class="flex items-center"
                                data-tw-toggle="modal"
                                data-tw-target="#upload-modal"
                            >
                                <x-base.lucide icon="Upload" class="w-4 h-4 mr-2" />
                                Upload
                            </x-base.button>
                        </div>
                    </div>

                    <!-- Filters (styled like Tasks page) -->
                    <div class="grid grid-cols-12 gap-4 mt-4">
                        <div class="col-span-12 md:col-span-4">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Document Type
                            </label>
                            <x-base.form-select id="type-filter" class="w-full text-sm">
                                <option value="">All Types</option>
                                <option value="contract">Contracts</option>
                                <option value="invoice">Invoices</option>
                                <option value="report">Reports</option>
                                <option value="certificate">Certificates</option>
                                <option value="license">Licenses</option>
                                <option value="agreement">Agreements</option>
                                <option value="policy">Policies</option>
                                <option value="manual">Manuals</option>
                                <option value="other">Other</option>
                            </x-base.form-select>
                        </div>

                        <div class="col-span-12 md:col-span-4">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Status
                            </label>
                            <x-base.form-select id="status-filter" class="w-full text-sm">
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="archived">Archived</option>
                            </x-base.form-select>
                        </div>

                        <div class="col-span-12 md:col-span-4">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Access Level
                            </label>
                            <x-base.form-select id="access-filter" class="w-full text-sm">
                                <option value="">All Access Levels</option>
                                <option value="public">Public</option>
                                <option value="internal">Internal</option>
                                <option value="confidential">Confidential</option>
                                <option value="restricted">Restricted</option>
                            </x-base.form-select>
                        </div>

                        <div class="col-span-12 flex justify-end mt-2">
                            <x-base.button
                                type="button"
                                variant="primary"
                                size="sm"
                                onclick="applyFilters()"
                            >
                                <x-base.lucide icon="Search" class="w-4 h-4 mr-2" />
                                Apply Filters
                            </x-base.button>
                        </div>
                    </div>
                </div>

                <!-- Documents Table -->
                <div class="p-5">
                    <div class="overflow-x-auto sm:overflow-visible" data-erp-table-wrapper>
                        <table
                            id="documents-table"
                            data-tw-merge
                            data-erp-table
                            class="datatable-default w-full min-w-full table-auto text-left text-sm"
                        >
                            <thead>
                                <tr>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Document</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Type</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Category</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Access Level</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Size</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Uploaded</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('documents.modals.create-document')
    @include('documents.modals.create-category')
    @include('documents.modals.edit-document')
    @include('documents.modals.view-document')

    {{-- Hidden triggers so JS can open modals using the same mechanism as the Upload button --}}
    <x-base.button
        type="button"
        id="open-view-document-modal-btn"
        class="hidden"
        data-tw-toggle="modal"
        data-tw-target="#view-document-modal"
    >
        Open View Document Modal
    </x-base.button>

    <x-base.button
        type="button"
        id="open-edit-document-modal-btn"
        class="hidden"
        data-tw-toggle="modal"
        data-tw-target="#edit-document-modal"
    >
        Open Edit Document Modal
    </x-base.button>
    @stack('modals')
@endsection

@include('components.datatable.scripts')

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>
@endpush

@push('scripts')
    <script>
        let documentsTable;
        let selectedFile = null;
        let currentCategoryId = '{{ $currentCategory }}';

        $(document).ready(function() {
            initializeDataTable();
            setupEventListeners();
            setupFileUpload();
            updateStats();
        });

        function initializeDataTable() {
            documentsTable = window.initDataTable('#documents-table', {
                ajax: {
                    url: '{{ route("documents.datatable") }}',
                    data: function(d) {
                        d.category_id = currentCategoryId === 'uncategorized' ? null : currentCategoryId;
                        d.type_filter = $('#type-filter').val();
                        d.status_filter = $('#status-filter').val();
                        d.access_filter = $('#access-filter').val();
                        d.search = $('#document-search').val();
                    }
                },
                columns: [
                    { data: 'file_info', name: 'file_info', orderable: false },
                    { data: 'type_badge', name: 'type_badge', orderable: false },
                    { data: 'category_name', name: 'category_name' },
                    { data: 'access_badge', name: 'access_badge', orderable: false },
                    { data: 'file_size_formatted', name: 'file_size_formatted' },
                    { data: 'formatted_date', name: 'formatted_date' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ],
                pageLength: 25,
                lengthChange: false,
                searching: false,
                responsive: true,
                dom:
                    "t<'datatable-footer flex flex-col md:flex-row md:items-center md:justify-between mt-5 gap-4" +
                    "'<'datatable-info text-slate-500'i><'datatable-pagination'p>>",
                drawCallback: function () {
                    if (typeof window.Lucide !== 'undefined') {
                        window.Lucide.createIcons();
                    } else if (typeof lucide !== 'undefined' && typeof lucide.createIcons === 'function') {
                        lucide.createIcons();
                    }
                }
            });
        }

        function setupEventListeners() {
            // Search (custom themed input)
            $('#document-search').on('keypress', function(e) {
                if (e.which === 13) {
                    if (documentsTable) {
                        documentsTable.ajax.reload();
                    }
                }
            });

            // Page length (custom themed select)
            $('#documents-length').on('change', function () {
                if (!documentsTable) return;
                const length = parseInt($(this).val(), 10) || 25;
                documentsTable.page.len(length).draw();
            });

            // Filters
            $('#type-filter, #status-filter, #access-filter').on('change', function() {
                if (documentsTable) {
                    documentsTable.ajax.reload();
                }
            });
        }

        function setupFileUpload() {
            const uploadArea = document.getElementById('upload-area');
            const fileInput = document.getElementById('document-file');

            // Drag and drop
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                uploadArea.addEventListener(eventName, preventDefaults, false);
            });

            ['dragenter', 'dragover'].forEach(eventName => {
                uploadArea.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                uploadArea.addEventListener(eventName, unhighlight, false);
            });

            uploadArea.addEventListener('drop', handleDrop, false);
            fileInput.addEventListener('change', handleFileSelect);

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            function highlight() {
                uploadArea.classList.add('dragover');
            }

            function unhighlight() {
                uploadArea.classList.remove('dragover');
            }

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                handleFiles(files);
            }

            function handleFileSelect(e) {
                const files = e.target.files;
                handleFiles(files);
            }

            function handleFiles(files) {
                if (files.length > 0) {
                    const file = files[0];
                    selectedFile = file;
                    updateFileInfo(file);
                }
            }
        }

        function updateFileInfo(file) {
            const jq = window.jQuery;
            if (!jq) {
                console.error('jQuery is not available; cannot update file info.');
                return;
            }

            jq('#file-info').removeClass('hidden');
            jq('#file-name').text(file.name);
            jq('#file-details').text(`${formatFileSize(file.size)} • ${file.type || 'Unknown type'}`);
            jq('#upload-btn').prop('disabled', false);
        }

        function clearFile() {
            const jq = window.jQuery;
            if (!jq) {
                console.error('jQuery is not available; cannot clear file.');
                return;
            }

            selectedFile = null;
            jq('#document-file').val('');
            jq('#file-info').addClass('hidden');
            jq('#upload-btn').prop('disabled', true);
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        function filterByCategory(categoryId) {
            currentCategoryId = categoryId;
            $('.category-item').removeClass('active');
            $(`.category-item[onclick*="${categoryId}"]`).addClass('active');
            documentsTable.ajax.reload();
        }

        function applyFilters() {
            documentsTable.ajax.reload();
        }

        function closeModalById(id) {
            const modalEl = document.getElementById(id);
            if (!modalEl) return;
            const dismissTrigger = modalEl.querySelector('[data-tw-dismiss="modal"]');
            if (dismissTrigger) {
                dismissTrigger.click();
            }
        }

        function uploadDocument() {
            const jq = window.jQuery;
            if (!jq) {
                console.error('jQuery is not available; cannot upload document.');
                if (typeof window.showError === 'function') {
                    window.showError('jQuery is not loaded; cannot upload document.');
                }
                return;
            }

            const formData = new FormData();

            // Add file
            if (!selectedFile) {
                if (typeof window.showError === 'function') {
                    window.showError('Please select a file to upload');
                }
                return;
            }
            formData.append('file', selectedFile);

            // Add form data (explicit mapping: field name -> DOM selector)
            const fieldSelectors = {
                title: '#document-title',
                description: '#document-description',
                document_type: '#document-type',
                category_id: '#document-category',
                access_level: '#document-access',
                expiry_date: '#document-expiry',
                department_id: '#document-department',
            };

            Object.entries(fieldSelectors).forEach(([field, selector]) => {
                const el = jq(selector);
                if (!el.length) return;
                let value = el.val();
                if (!value) return;

                // Normalize expiry_date to YYYY-MM-DD for backend validation
                if (field === 'expiry_date') {
                    const parsed = new Date(value);
                    if (!isNaN(parsed.getTime())) {
                        const year = parsed.getFullYear();
                        const month = String(parsed.getMonth() + 1).padStart(2, '0');
                        const day = String(parsed.getDate()).padStart(2, '0');
                        value = `${year}-${month}-${day}`;
                    }
                }

                formData.append(field, value);
            });

            // Add tags
            const tagsInput = jq('#document-tags');
            if (tagsInput.length) {
                const rawTags = tagsInput.val() || '';
                const tags = rawTags.split(',').map(tag => tag.trim()).filter(tag => tag);
                if (tags.length > 0) {
                    tags.forEach(tag => formData.append('tags[]', tag));
                }
            }

            formData.append('_token', '{{ csrf_token() }}');

            jq('#upload-btn').prop('disabled', true).text('Uploading...');

            jq.ajax({
                url: '{{ route("documents.store") }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        closeModalById('upload-modal');
                        clearFile();
                        if (response.success) {
                            documentsTable.ajax.reload();
                            updateStats();
                            if (typeof window.showSuccess === 'function') {
                                window.showSuccess(response.message || 'Document uploaded successfully');
                            }
                        } else if (typeof window.showError === 'function') {
                            window.showError(response.message || 'Failed to upload document');
                        }
                    },
                },
                error: function(xhr) {
                    const error = xhr.responseJSON?.message || 'Upload failed';
                    if (typeof window.showError === 'function') {
                        window.showError(error);
                    }
                },
                complete: function() {
                    jq('#upload-btn').prop('disabled', false).text('Upload Document');
                }
            });
        }

        function showCreateCategoryModal() {
            $('#category-modal-title').text('Create Category');
            $('#category-form')[0].reset();
            document.getElementById('category-modal').dispatchEvent(new CustomEvent('open-modal'));
        }

        function saveCategory() {
            const jq = window.jQuery;
            if (!jq) {
                console.error('jQuery is not available; cannot save category.');
                if (typeof window.showError === 'function') {
                    window.showError('jQuery is not loaded; cannot save category.');
                }
                return;
            }

            const formData = {
                name: jq('#category-name').val(),
                description: jq('#category-description').val(),
                color: jq('#category-color').val(),
                icon: jq('#category-icon').val(),
                parent_id: jq('#category-parent').val(),
                _token: '{{ csrf_token() }}'
            };

            if (!formData.name) {
                if (typeof window.showError === 'function') {
                    window.showError('Category name is required');
                }
                return;
            }

            jq.ajax({
                url: '{{ route("documents.store-category") }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        closeModalById('category-modal');
                        location.reload(); // Reload to show new category
                        if (typeof window.showSuccess === 'function') {
                            window.showSuccess(response.message || 'Category saved successfully');
                        }
                    } else if (typeof window.showError === 'function') {
                        window.showError(response.message || 'Failed to save category');
                    }
                },
                error: function() {
                    if (typeof window.showError === 'function') {
                        window.showError('Failed to save category');
                    }
                }
            });
        }

        function updateStats() {
            const jq = window.jQuery;
            if (!jq) {
                console.error('jQuery is not available; cannot load stats.');
                return;
            }

            jq('#total-files').text('...');
            jq('#monthly-files').text('...');
            jq('#storage-used').text('...');

            jq.get('{{ route("documents.stats") }}')
                .done(function (response) {
                    if (!response.success) {
                        return;
                    }

                    jq('#total-files').text(response.data.total_files ?? '-');
                    jq('#monthly-files').text(response.data.monthly_files ?? '-');
                    jq('#storage-used').text(response.data.storage_used_formatted ?? '-');
                })
                .fail(function () {
                    jq('#total-files').text('-');
                    jq('#monthly-files').text('-');
                    jq('#storage-used').text('-');
                });
        }

        // Global functions for table actions
        window.viewDocument = function(id) {
            const jq = window.jQuery;
            if (!jq) {
                console.error('jQuery is not available; cannot load document.');
                return;
            }

            jq.get('{{ route("documents.show", ":id") }}'.replace(':id', id))
                .done(function(response) {
                    if (!response.success) {
                        if (typeof window.showError === 'function') {
                            window.showError(response.message || 'Unable to load document details.');
                        }
                        return;
                    }

                    const doc = response.document || {};

                    // Fill modal fields
                    jq('#view-doc-title').text(doc.title || doc.file_name || 'Document');
                    jq('#view-doc-code').text(doc.code || '');

                    const typeLabel = (doc.document_type || '').replace('_', ' ');
                    jq('#view-doc-type').text(typeLabel ? typeLabel.charAt(0).toUpperCase() + typeLabel.slice(1) : '');

                    // Status badge
                    let statusClass = '';
                    if (doc.status === 'active') {
                        statusClass = 'bg-green-100 text-green-700';
                    } else if (doc.status === 'archived') {
                        statusClass = 'bg-yellow-100 text-yellow-700';
                    }
                    jq('#view-doc-status').attr('class', 'inline-flex items-center px-2 py-0.5 rounded-full text-[11px] ' + statusClass)
                        .text(doc.status ? doc.status.charAt(0).toUpperCase() + doc.status.slice(1) : '');

                    // Relations
                    jq('#view-doc-uploader').text(doc.uploader?.name || 'Unknown uploader');
                    jq('#view-doc-company').text(doc.company?.name || 'No company');
                    jq('#view-doc-department').text(doc.department?.name || 'No department');

                    // Dates
                    jq('#view-doc-created').text(doc.created_at || '-');

                    if (doc.expiry_date) {
                        let expiryText = doc.expiry_date;
                        if (typeof doc.days_until_expiry === 'number') {
                            expiryText += ` (${doc.days_until_expiry <= 0 ? 'Expired' : doc.days_until_expiry + ' days left'})`;
                        }
                        jq('#view-doc-expiry').text(expiryText);
                    } else {
                        jq('#view-doc-expiry').text('No expiry date');
                    }

                    // Size
                    jq('#view-doc-size').text(doc.file_size_formatted || '-');

                    // Description
                    jq('#view-doc-description').text(doc.description || '-');

                    // Access level info
                    let accessLabel = doc.access_level ? doc.access_level.charAt(0).toUpperCase() + doc.access_level.slice(1) : 'Unknown';
                    jq('#view-doc-access').text('Access: ' + accessLabel);

                    // Download button
                    const downloadUrl = doc.file_url || '#';
                    jq('#view-doc-download-btn')
                        .off('click')
                        .on('click', function () {
                            if (downloadUrl && downloadUrl !== '#') {
                                window.open(downloadUrl, '_blank');
                            }
                        });

                    // Open modal via hidden trigger button (same behaviour as Upload button)
                    const trigger = document.getElementById('open-view-document-modal-btn');
                    if (trigger) {
                        trigger.click();
                    }
                })
                .fail(function(xhr) {
                    const msg = xhr.responseJSON?.message || 'Unable to load document details.';
                    if (typeof window.showError === 'function') {
                        window.showError(msg);
                    }
                });
        };

        window.editDocument = function(id) {
            const jq = window.jQuery;
            if (!jq) {
                console.error('jQuery is not available; cannot load document for editing.');
                return;
            }

            jq.get('{{ route("documents.show", ":id") }}'.replace(':id', id))
                .done(function(response) {
                    if (!response.success) {
                        Swal.fire('Error', response.message || 'Unable to load document details.', 'error');
                        return;
                    }

                    const doc = response.document || {};

                    // Fill edit form fields
                    jq('#edit-document-id').val(doc.id);
                    jq('#edit-document-title').val(doc.title || '');
                    jq('#edit-document-description').val(doc.description || '');
                    jq('#edit-document-type').val(doc.document_type || '');
                    jq('#edit-document-category').val(doc.category_id || '');
                    jq('#edit-document-access').val(doc.access_level || 'internal');
                    jq('#edit-document-department').val(doc.department_id || '');
                    jq('#edit-document-status').val(doc.status || 'active');

                    // Expiry date: normalize to YYYY-MM-DD for nicer display with Litepicker
                    if (doc.expiry_date) {
                        let rawExpiry = doc.expiry_date;
                        // If ISO string with time, cut to date part
                        if (typeof rawExpiry === 'string') {
                            if (rawExpiry.includes('T')) {
                                rawExpiry = rawExpiry.split('T')[0];
                            } else if (rawExpiry.includes(' ')) {
                                rawExpiry = rawExpiry.split(' ')[0];
                            }
                        }
                        jq('#edit-document-expiry').val(rawExpiry);
                    } else {
                        jq('#edit-document-expiry').val('');
                    }

                    // Tags: convert array to comma-separated string (for single-line input)
                    if (Array.isArray(doc.tags)) {
                        const tagsString = doc.tags
                            .map(function (t) { return (t || '').toString().trim(); })
                            .filter(function (t) { return t.length > 0; })
                            .join(', ');
                        jq('#edit-document-tags').val(tagsString);
                    } else if (typeof doc.tags === 'string') {
                        jq('#edit-document-tags').val(doc.tags);
                    } else {
                        jq('#edit-document-tags').val('');
                    }

                    const trigger = document.getElementById('open-edit-document-modal-btn');
                    if (trigger) {
                        trigger.click();
                    }
                })
                .fail(function(xhr) {
                    const msg = xhr.responseJSON?.message || 'Unable to load document details.';
                    Swal.fire('Error', msg, 'error');
                });
        };

        function updateDocument() {
            const jq = window.jQuery;
            if (!jq) {
                console.error('jQuery is not available; cannot update document.');
                if (typeof window.showError === 'function') {
                    window.showError('jQuery is not loaded; cannot update document.');
                }
                return;
            }

            const id = jq('#edit-document-id').val();
            if (!id) {
                if (typeof window.showError === 'function') {
                    window.showError('Document ID is missing.');
                }
                return;
            }

            const payload = {
                _token: '{{ csrf_token() }}',
                _method: 'PUT',
                title: jq('#edit-document-title').val(),
                description: jq('#edit-document-description').val(),
                document_type: jq('#edit-document-type').val(),
                category_id: jq('#edit-document-category').val() || null,
                access_level: jq('#edit-document-access').val(),
                department_id: jq('#edit-document-department').val() || null,
                status: jq('#edit-document-status').val() || 'active',
                expiry_date: jq('#edit-document-expiry').val() || null,
            };

            // Tags -> array as expected by backend (tags[])
            const rawTags = jq('#edit-document-tags').val() || '';
            const tags = rawTags.split(',').map(t => t.trim()).filter(t => t);
            if (tags.length) {
                payload['tags'] = tags;
            }

            const url = '{{ route("documents.update", ":id") }}'.replace(':id', id);

            jq('#edit-document-save-btn').prop('disabled', true).text('Saving...');

            jq.ajax({
                url: url,
                type: 'POST',
                data: payload,
                success: function(response) {
                    if (response.success) {
                        closeModalById('edit-document-modal');
                        if (documentsTable) {
                            documentsTable.ajax.reload(null, false);
                        }
                        updateStats();
                        if (typeof window.showSuccess === 'function') {
                            window.showSuccess(response.message || 'Document updated successfully');
                        }
                    } else if (typeof window.showError === 'function') {
                        window.showError(response.message || 'Failed to update document');
                    }
                },
                error: function(xhr) {
                    const msg = xhr.responseJSON?.message || 'Failed to update document';
                    if (typeof window.showError === 'function') {
                        window.showError(msg);
                    }
                },
                complete: function() {
                    jq('#edit-document-save-btn').prop('disabled', false).text('Save Changes');
                }
            });
        }

        window.deleteDocument = function(id, title) {
            const jq = window.jQuery;
            if (!jq) {
                console.error('jQuery is not available; cannot delete document.');
                if (typeof window.showError === 'function') {
                    window.showError('jQuery is not loaded; cannot delete document.');
                }
                return;
            }

            if (typeof window.confirmDelete === 'function') {
                window.confirmDelete(title, function() {
                    jq.ajax({
                        url: '{{ route("documents.destroy", ":id") }}'.replace(':id', id),
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                documentsTable.ajax.reload();
                                updateStats();
                                if (typeof window.showSuccess === 'function') {
                                    window.showSuccess(response.message || 'Document deleted successfully');
                                }
                            }
                        },
                        error: function(xhr) {
                            if (typeof window.showError === 'function') {
                                window.showError('Failed to delete document.');
                            }
                        }
                    });
                });
            }
        }
;
    </script>
@endpush

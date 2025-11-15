@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Document Management - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@push('styles')
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
        <!-- Sidebar with Categories -->
        <div class="col-span-12 lg:col-span-3 2xl:col-span-2">
            <div class="bg-white rounded-lg shadow-sm border">
                <!-- Header -->
                <div class="p-5 border-b border-slate-200/60">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-medium">Categories</h2>
                        <button onclick="showCreateCategoryModal()" class="btn btn-primary btn-sm">
                            <x-base.lucide icon="Plus" class="w-4 h-4 mr-1" />
                            Add
                        </button>
                    </div>
                </div>

                <!-- Categories Tree -->
                <div class="p-2 max-h-96 overflow-y-auto">
                    <!-- All Documents -->
                    <div class="category-item p-3 rounded-lg mb-1 {{ !$currentCategory ? 'active' : '' }}"
                         onclick="filterByCategory('')">
                        <div class="flex items-center">
                            <x-base.lucide icon="folder" class="w-5 h-5 mr-3 text-blue-600" />
                            <div class="flex-1">
                                <div class="font-medium">All Documents</div>
                                <div class="text-xs text-gray-500">All files</div>
                            </div>
                        </div>
                    </div>

                    <!-- Categories -->
                    @foreach($categories as $category)
                        @include('documents.partials.category-item', ['category' => $category, 'level' => 0])
                    @endforeach

                    <!-- Uncategorized -->
                    <div class="category-item p-3 rounded-lg mb-1 {{ $currentCategory === 'uncategorized' ? 'active' : '' }}"
                         onclick="filterByCategory('uncategorized')">
                        <div class="flex items-center">
                            <x-base.lucide icon="folder-x" class="w-5 h-5 mr-3 text-gray-600" />
                            <div class="flex-1">
                                <div class="font-medium">Uncategorized</div>
                                <div class="text-xs text-gray-500">Files without category</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-white rounded-lg shadow-sm border mt-6">
                <div class="p-5">
                    <h3 class="font-semibold mb-4 flex items-center">
                        <x-base.lucide icon="bar-chart-3" class="w-5 h-5 mr-2 text-blue-600" />
                        Quick Stats
                    </h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Total Files</span>
                            <span class="font-semibold text-blue-600" id="total-files">-</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">This Month</span>
                            <span class="font-semibold text-green-600" id="monthly-files">-</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Storage Used</span>
                            <span class="font-semibold text-purple-600" id="storage-used">-</span>
                        </div>
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
                            <!-- Search -->
                            <div class="relative">
                                <x-base.lucide icon="search" class="w-4 h-4 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" />
                                <input
                                    type="text"
                                    id="document-search"
                                    placeholder="Search documents..."
                                    class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                />
                            </div>
                            <!-- Upload Button -->
                            <button onclick="showUploadModal()" class="btn btn-primary">
                                <x-base.lucide icon="upload" class="w-4 h-4 mr-2" />
                                Upload
                            </button>
                        </div>
                    </div>

                    <!-- Filters -->
                    <div class="flex flex-wrap gap-3 mt-4">
                        <select id="type-filter" class="form-select text-sm">
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
                        </select>

                        <select id="status-filter" class="form-select text-sm">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="archived">Archived</option>
                        </select>

                        <select id="access-filter" class="form-select text-sm">
                            <option value="">All Access Levels</option>
                            <option value="public">Public</option>
                            <option value="internal">Internal</option>
                            <option value="confidential">Confidential</option>
                            <option value="restricted">Restricted</option>
                        </select>

                        <button onclick="applyFilters()" class="btn btn-outline-primary btn-sm">
                            Apply Filters
                        </button>
                    </div>
                </div>

                <!-- Documents Table -->
                <div class="p-5">
                    <table id="documents-table" class="table table-report -mt-2">
                        <thead>
                            <tr>
                                <th>Document</th>
                                <th>Type</th>
                                <th>Category</th>
                                <th>Access Level</th>
                                <th>Size</th>
                                <th>Uploaded</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Upload Modal -->
    <div id="upload-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto flex items-center">
                        <x-base.lucide icon="upload" class="w-5 h-5 mr-2 text-blue-600" />
                        Upload Document
                    </h2>
                    <button type="button" class="text-slate-400 hover:text-slate-600" data-tw-dismiss="modal">
                        <x-base.lucide icon="X" class="w-6 h-6" />
                    </button>
                </div>
                <div class="modal-body p-6">
                    <form id="upload-form" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-12 gap-4">
                            <!-- File Upload Area -->
                            <div class="col-span-12">
                                <label class="form-label">Document File <span class="text-danger">*</span></label>
                                <div class="upload-area p-8 text-center" id="upload-area">
                                    <x-base.lucide icon="upload" class="w-12 h-12 text-gray-400 mx-auto mb-4" />
                                    <p class="text-lg font-medium text-gray-700 mb-2">Drop files here or click to browse</p>
                                    <p class="text-sm text-gray-500 mb-4">
                                        Supports: PDF, DOC, DOCX, XLS, XLSX, TXT, JPG, PNG, GIF<br>
                                        Maximum size: 50MB per file
                                    </p>
                                    <input type="file" id="document-file" name="file" class="hidden" accept=".pdf,.doc,.docx,.xls,.xlsx,.txt,.jpg,.jpeg,.png,.gif" />
                                    <x-base.button
                                        variant="outline-primary"
                                        type="button"
                                        onclick="document.getElementById('document-file').click()"
                                    >
                                        Choose File
                                    </x-base.button>
                                </div>
                                <div id="file-info" class="mt-3 hidden">
                                    <div class="flex items-center p-3 bg-blue-50 rounded-lg">
                                        <x-base.lucide icon="file" class="w-5 h-5 text-blue-600 mr-3" />
                                        <div class="flex-1">
                                            <p class="font-medium text-blue-900" id="file-name"></p>
                                            <p class="text-sm text-blue-700" id="file-details"></p>
                                        </div>
                                        <button type="button" onclick="clearFile()" class="text-red-600 hover:text-red-800">
                                            <x-base.lucide icon="x" class="w-5 h-5" />
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Document Details -->
                            <div class="col-span-12 md:col-span-6">
                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                <input id="document-title" name="title" type="text" class="form-control" placeholder="Enter document title" />
                            </div>

                            <div class="col-span-12 md:col-span-6">
                                <label class="form-label">Type <span class="text-danger">*</span></label>
                                <select id="document-type" name="document_type" class="form-select">
                                    <option value="">Select Type</option>
                                    <option value="contract">Contract</option>
                                    <option value="invoice">Invoice</option>
                                    <option value="report">Report</option>
                                    <option value="certificate">Certificate</option>
                                    <option value="license">License</option>
                                    <option value="agreement">Agreement</option>
                                    <option value="policy">Policy</option>
                                    <option value="manual">Manual</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div class="col-span-12">
                                <label class="form-label">Description</label>
                                <textarea id="document-description" name="description" rows="3" class="form-control" placeholder="Enter document description"></textarea>
                            </div>

                            <div class="col-span-12 md:col-span-6">
                                <label class="form-label">Category</label>
                                <select id="document-category" name="category_id" class="form-select">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-span-12 md:col-span-6">
                                <label class="form-label">Access Level <span class="text-danger">*</span></label>
                                <select id="document-access" name="access_level" class="form-select">
                                    <option value="internal">Internal (Company)</option>
                                    <option value="confidential">Confidential (Department)</option>
                                    <option value="restricted">Restricted (Specific Users)</option>
                                    <option value="public">Public (All Users)</option>
                                </select>
                            </div>

                            <div class="col-span-12 md:col-span-6">
                                <label class="form-label">Expiry Date</label>
                                <div class="relative mx-auto w-56">
                                    <div
                                        class="absolute flex h-full w-10 items-center justify-center rounded-l border bg-slate-100 text-slate-500 dark:border-darkmode-800 dark:bg-darkmode-700 dark:text-slate-400">
                                        <x-base.lucide icon="calendar" class="stroke-1.5 w-5 h-5"></x-base.lucide>
                                    </div>
                                    <x-base.litepicker
                                        id="document-expiry"
                                        name="expiry_date"
                                        class="pl-12"
                                        data-single-mode="true"
                                    />
                                </div>
                            </div>

                            <div class="col-span-12 md:col-span-6">
                                <label class="form-label">Department</label>
                                <select id="document-department" name="department_id" class="form-select">
                                    <option value="">Select Department</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-span-12">
                                <label class="form-label">Tags</label>
                                <input id="document-tags" name="tags[]" type="text" class="form-control" placeholder="Enter tags separated by commas" />
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-tw-dismiss="modal">Cancel</button>
                    <button type="button" id="upload-btn" class="btn btn-primary" onclick="uploadDocument()" disabled>
                        <x-base.lucide icon="upload" class="w-4 h-4 mr-2" />
                        Upload Document
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Modal -->
    <div id="category-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto" id="category-modal-title">Create Category</h2>
                    <button type="button" class="text-slate-400 hover:text-slate-600" data-tw-dismiss="modal">
                        <x-base.lucide icon="X" class="w-6 h-6" />
                    </button>
                </div>
                <div class="modal-body p-6">
                    <form id="category-form">
                        <div class="mb-4">
                            <label class="form-label">Category Name <span class="text-danger">*</span></label>
                            <input id="category-name" name="name" type="text" class="form-control" placeholder="Enter category name" />
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Description</label>
                            <textarea id="category-description" name="description" rows="2" class="form-control" placeholder="Enter category description"></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Color</label>
                            <input id="category-color" name="color" type="color" class="form-control" value="#3b82f6" />
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Icon</label>
                            <select id="category-icon" name="icon" class="form-select">
                                <option value="folder">Folder</option>
                                <option value="file-text">File Text</option>
                                <option value="archive">Archive</option>
                                <option value="briefcase">Briefcase</option>
                                <option value="clipboard">Clipboard</option>
                                <option value="book">Book</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Parent Category</label>
                            <select id="category-parent" name="parent_id" class="form-select">
                                <option value="">Root Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-tw-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveCategory()">Save Category</button>
                </div>
            </div>
        </div>
    </div>
@endsection

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
            documentsTable = $('#documents-table').DataTable({
                processing: true,
                serverSide: true,
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
                responsive: true,
                dom: '<"flex flex-col sm:flex-row items-center gap-4"<"flex-1"l><"flex-1"f><"flex-1"B>>rt<"flex flex-col sm:flex-row items-center gap-4"<"flex-1"i><"flex-1"p>>',
                buttons: [
                    {
                        extend: 'excel',
                        text: '<i class="w-4 h-4 mr-2" data-lucide="file-spreadsheet"></i> Export Excel',
                        className: 'btn btn-success',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        }
                    }
                ]
            });

            documentsTable.on('draw', function() {
                lucide.createIcons();
            });
        }

        function setupEventListeners() {
            // Search
            $('#document-search').on('keypress', function(e) {
                if (e.which === 13) {
                    documentsTable.ajax.reload();
                }
            });

            // Filters
            $('#type-filter, #status-filter, #access-filter').on('change', function() {
                documentsTable.ajax.reload();
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
            $('#file-info').removeClass('hidden');
            $('#file-name').text(file.name);
            $('#file-details').text(`${formatFileSize(file.size)} • ${file.type || 'Unknown type'}`);
            $('#upload-btn').prop('disabled', false);
        }

        function clearFile() {
            selectedFile = null;
            $('#document-file').val('');
            $('#file-info').addClass('hidden');
            $('#upload-btn').prop('disabled', true);
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

        function showUploadModal() {
            $('#upload-modal').modal('show');
        }

        function uploadDocument() {
            const formData = new FormData();

            // Add file
            if (!selectedFile) {
                Swal.fire('Error', 'Please select a file to upload', 'error');
                return;
            }
            formData.append('file', selectedFile);

            // Add form data
            const formFields = ['title', 'description', 'document_type', 'category_id', 'access_level', 'expiry_date', 'department_id'];
            formFields.forEach(field => {
                const value = $(`#document-${field}`).val();
                if (value) formData.append(field, value);
            });

            // Add tags
            const tags = $('#document-tags').val().split(',').map(tag => tag.trim()).filter(tag => tag);
            if (tags.length > 0) {
                tags.forEach(tag => formData.append('tags[]', tag));
            }

            formData.append('_token', '{{ csrf_token() }}');

            $('#upload-btn').prop('disabled', true).text('Uploading...');

            $.ajax({
                url: '{{ route("documents.store") }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        $('#upload-modal').modal('hide');
                        clearFile();
                        documentsTable.ajax.reload();
                        updateStats();
                        Swal.fire('Success', response.message, 'success');
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                },
                error: function(xhr) {
                    const error = xhr.responseJSON?.message || 'Upload failed';
                    Swal.fire('Error', error, 'error');
                },
                complete: function() {
                    $('#upload-btn').prop('disabled', false).text('Upload Document');
                }
            });
        }

        function showCreateCategoryModal() {
            $('#category-modal-title').text('Create Category');
            $('#category-form')[0].reset();
            $('#category-modal').modal('show');
        }

        function saveCategory() {
            const formData = {
                name: $('#category-name').val(),
                description: $('#category-description').val(),
                color: $('#category-color').val(),
                icon: $('#category-icon').val(),
                parent_id: $('#category-parent').val(),
                _token: '{{ csrf_token() }}'
            };

            if (!formData.name) {
                Swal.fire('Error', 'Category name is required', 'error');
                return;
            }

            $.post('{{ route("documents.store-category") }}', formData)
                .done(function(response) {
                    if (response.success) {
                        $('#category-modal').modal('hide');
                        location.reload(); // Reload to show new category
                        Swal.fire('Success', response.message, 'success');
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                })
                .fail(function() {
                    Swal.fire('Error', 'Failed to save category', 'error');
                });
        }

        function updateStats() {
            // This would fetch actual stats from server
            $('#total-files').text('Loading...');
            $('#monthly-files').text('Loading...');
            $('#storage-used').text('Loading...');

            // For demo purposes, you can implement actual stats fetching
        }

        // Global functions for table actions
        window.viewDocument = function(id) {
            $.get('{{ route("documents.show", ":id") }}'.replace(':id', id))
                .done(function(response) {
                    if (response.success) {
                        // Show document details modal or redirect
                        console.log('Document details:', response.document);
                    }
                });
        };

        window.editDocument = function(id) {
            // Implement edit functionality
            console.log('Edit document:', id);
        };

        window.deleteDocument = function(id, title) {
            Swal.fire({
                title: 'Delete Document',
                text: `Are you sure you want to delete "${title}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("documents.destroy", ":id") }}'.replace(':id', id),
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                documentsTable.ajax.reload();
                                updateStats();
                                Swal.fire('Deleted!', response.message, 'success');
                            }
                        },
                        error: function(xhr) {
                            Swal.fire('Error!', 'Failed to delete document.', 'error');
                        }
                    });
                }
            });
        };
    </script>
@endpush

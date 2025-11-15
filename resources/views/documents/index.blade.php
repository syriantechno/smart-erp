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
                        <x-base.button
                            variant="primary"
                            size="sm"
                            class="ml-2"
                            data-tw-toggle="modal"
                            data-tw-target="#category-modal"
                        >
                            <x-base.lucide icon="Plus" class="w-4 h-4 mr-1" />
                            Add
                        </x-base.button>
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
    @stack('modals')
@endsection

@include('components.datatable.scripts')

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

        function closeModalById(id) {
            const modalEl = document.getElementById(id);
            if (!modalEl) return;
            const dismissTrigger = modalEl.querySelector('[data-tw-dismiss="modal"]');
            if (dismissTrigger) {
                dismissTrigger.click();
            }
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
                        closeModalById('upload-modal');
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
            document.getElementById('category-modal').dispatchEvent(new CustomEvent('open-modal'));
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
                        closeModalById('category-modal');
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

<x-modal.form id="upload-modal" title="Upload Document" size="xl">
    <form id="upload-form" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-12 gap-4 gap-y-4">
            <!-- File Upload Area -->
            <div class="col-span-12">
                <x-base.form-label for="document-file">Document File <span class="text-danger">*</span></x-base.form-label>
                <div class="upload-area p-8 text-center" id="upload-area">
                    <x-base.lucide icon="upload" class="w-12 h-12 text-gray-400 mx-auto mb-4" />
                    <p class="text-lg font-medium text-gray-700 mb-2">Drop files here or click to browse</p>
                    <p class="text-sm text-gray-500 mb-4">
                        Supports: PDF, DOC, DOCX, XLS, XLSX, TXT, JPG, PNG, GIF<br>
                        Maximum size: 50MB per file
                    </p>
                    <input
                        type="file"
                        id="document-file"
                        name="file"
                        class="hidden"
                        accept=".pdf,.doc,.docx,.xls,.xlsx,.txt,.jpg,.jpeg,.png,.gif"
                    />
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
                <x-base.form-label for="document-title">Title <span class="text-danger">*</span></x-base.form-label>
                <x-base.form-input
                    id="document-title"
                    name="title"
                    type="text"
                    class="w-full"
                    placeholder="Enter document title"
                    required
                />
            </div>

            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="document-type">Type <span class="text-danger">*</span></x-base.form-label>
                <x-base.form-select id="document-type" name="document_type" class="w-full" required>
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
                </x-base.form-select>
            </div>

            <div class="col-span-12">
                <x-base.form-label for="document-description">Description</x-base.form-label>
                <x-base.form-textarea
                    id="document-description"
                    name="description"
                    rows="3"
                    class="w-full"
                    placeholder="Enter document description"
                ></x-base.form-textarea>
            </div>

            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="document-category">Category</x-base.form-label>
                <x-base.form-select id="document-category" name="category_id" class="w-full">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </x-base.form-select>
            </div>

            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="document-access">Access Level <span class="text-danger">*</span></x-base.form-label>
                <x-base.form-select id="document-access" name="access_level" class="w-full" required>
                    <option value="internal">Internal (Company)</option>
                    <option value="confidential">Confidential (Department)</option>
                    <option value="restricted">Restricted (Specific Users)</option>
                    <option value="public">Public (All Users)</option>
                </x-base.form-select>
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
                <x-base.form-label for="document-department">Department</x-base.form-label>
                <x-base.form-select id="document-department" name="department_id" class="w-full">
                    <option value="">Select Department</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </x-base.form-select>
            </div>

            <div class="col-span-12">
                <x-base.form-label for="document-tags">Tags</x-base.form-label>
                <x-base.form-input
                    id="document-tags"
                    name="tags[]"
                    type="text"
                    class="w-full"
                    placeholder="Enter tags separated by commas"
                />
            </div>
        </div>
    </form>

    @slot('footer')
        <div class="flex justify-end gap-2 w-full">
            <x-base.button
                class="w-24"
                data-tw-dismiss="modal"
                type="button"
                variant="outline-secondary"
            >
                Cancel
            </x-base.button>
            <x-base.button
                class="w-32"
                type="button"
                id="upload-btn"
                onclick="uploadDocument()"
                variant="primary"
            >
                <x-base.lucide icon="Save" class="w-4 h-4 mr-2" />
                Save
            </x-base.button>
        </div>
    @endslot
</x-modal.form>

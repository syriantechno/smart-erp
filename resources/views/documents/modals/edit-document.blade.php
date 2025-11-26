<x-modal.form id="edit-document-modal" title="Edit Document" size="xl">
    <form id="edit-document-form" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" id="edit-document-id" name="document_id" />

        <div class="grid grid-cols-12 gap-4 gap-y-4">
            <!-- Document Details -->
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="edit-document-title">Title <span class="text-danger">*</span></x-base.form-label>
                <x-base.form-input
                    id="edit-document-title"
                    name="title"
                    type="text"
                    class="w-full"
                    placeholder="Enter document title"
                    required
                />
            </div>

            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="edit-document-type">Type <span class="text-danger">*</span></x-base.form-label>
                <x-base.form-select id="edit-document-type" name="document_type" class="w-full" required>
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
                <x-base.form-label for="edit-document-description">Description</x-base.form-label>
                <x-base.form-textarea
                    id="edit-document-description"
                    name="description"
                    rows="3"
                    class="w-full"
                    placeholder="Enter document description"
                ></x-base.form-textarea>
            </div>

            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="edit-document-category">Category</x-base.form-label>
                <x-base.form-select id="edit-document-category" name="category_id" class="w-full">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </x-base.form-select>
            </div>

            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="edit-document-access">Access Level <span class="text-danger">*</span></x-base.form-label>
                <x-base.form-select id="edit-document-access" name="access_level" class="w-full" required>
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
                        id="edit-document-expiry"
                        name="expiry_date"
                        class="pl-12"
                        data-single-mode="true"
                    />
                </div>
            </div>

            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="edit-document-department">Department</x-base.form-label>
                <x-base.form-select id="edit-document-department" name="department_id" class="w-full">
                    <option value="">Select Department</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </x-base.form-select>
            </div>

            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="edit-document-status">Status <span class="text-danger">*</span></x-base.form-label>
                <x-base.form-select id="edit-document-status" name="status" class="w-full" required>
                    <option value="active">Active</option>
                    <option value="archived">Archived</option>
                </x-base.form-select>
            </div>

            <div class="col-span-12">
                <x-base.form-label for="edit-document-tags">Tags</x-base.form-label>
                <x-base.form-input
                    id="edit-document-tags"
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
                id="edit-document-save-btn"
                onclick="updateDocument()"
                variant="primary"
            >
                <x-base.lucide icon="Save" class="w-4 h-4 mr-2" />
                Save
            </x-base.button>
        </div>
    @endslot
</x-modal.form>

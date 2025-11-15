<x-modal.form id="category-modal" title="Create Category" size="lg">
    <form id="category-form">
        <div class="grid grid-cols-12 gap-4 gap-y-4">
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="category-name">Category Name <span class="text-danger">*</span></x-base.form-label>
                <x-base.form-input
                    id="category-name"
                    name="name"
                    type="text"
                    class="w-full"
                    placeholder="Enter category name"
                    required
                />
            </div>

            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="category-parent">Parent Category</x-base.form-label>
                <x-base.form-select id="category-parent" name="parent_id" class="w-full">
                    <option value="">Root Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </x-base.form-select>
            </div>

            <div class="col-span-12">
                <x-base.form-label for="category-description">Description</x-base.form-label>
                <x-base.form-textarea
                    id="category-description"
                    name="description"
                    rows="3"
                    class="w-full"
                    placeholder="Enter category description"
                ></x-base.form-textarea>
            </div>

            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="category-color">Color</x-base.form-label>
                <x-base.form-input
                    id="category-color"
                    name="color"
                    type="color"
                    class="w-full h-10 p-1"
                    value="#3b82f6"
                />
            </div>

            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="category-icon">Icon</x-base.form-label>
                <x-base.form-select id="category-icon" name="icon" class="w-full">
                    <option value="folder">Folder</option>
                    <option value="file-text">File Text</option>
                    <option value="archive">Archive</option>
                    <option value="briefcase">Briefcase</option>
                    <option value="clipboard">Clipboard</option>
                    <option value="book">Book</option>
                </x-base.form-select>
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
                onclick="saveCategory()"
                variant="primary"
            >
                <x-base.lucide icon="Save" class="w-4 h-4 mr-2" />
                Save
            </x-base.button>
        </div>
    @endslot
</x-modal.form>

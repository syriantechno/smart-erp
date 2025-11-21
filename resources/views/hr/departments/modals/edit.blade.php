@php
    $companies = $companies ?? \App\Models\Setting\Company::active()->get();
    $managers = $managers ?? \App\Models\HR\Employee::active()->get();
    $departments = $departments ?? \App\Models\HR\Department::active()->get();
@endphp

@push('modals')
    <x-modal.form id="edit-department-modal" title="Edit Department" class="hidden">
        <form
            id="edit-department-form"
            action=""
            method="POST"
            data-update-url-base="{{ url('hr/departments') }}"
        >
            @csrf
            @method('PUT')
            <input type="hidden" id="edit-department-current-id" />

            <div class="grid grid-cols-12 gap-4 gap-y-4">
                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="edit-department-name">Department Name <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-input
                        id="edit-department-name"
                        name="name"
                        type="text"
                        placeholder="Enter department name"
                        class="w-full"
                        required
                    />
                </div>

                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="edit-department-company">Company <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-select
                        id="edit-department-company"
                        name="company_id"
                        class="w-full"
                        disabled
                    >
                        <option value="">Select Company</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>

                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="edit-department-parent">Parent Department</x-base.form-label>
                    <x-base.form-select
                        id="edit-department-parent"
                        name="parent_id"
                        class="w-full"
                    >
                        <option value="">Select Parent Department (Optional)</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" data-company="{{ $dept->company_id }}">{{ $dept->name }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>

                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="edit-department-manager">Department Manager</x-base-form-label>
                    <x-base.form-select
                        id="edit-department-manager"
                        name="manager_id"
                        class="w-full"
                    >
                        <option value="">Select Manager (Optional)</option>
                        @foreach($managers as $manager)
                            <option value="{{ $manager->id }}">{{ $manager->full_name }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>

                <div class="col-span-12">
                    <x-base.form-label for="edit-department-description">Description</x-base.form-label>
                    <x-base.form-textarea
                        id="edit-department-description"
                        name="description"
                        rows="3"
                        placeholder="Enter department description"
                        class="w-full"
                    ></x-base.form-textarea>
                </div>
            </div>
        </form>

        @slot('footer')
            <div class="flex w-full flex-wrap justify-end gap-2">
                <button
                    type="button"
                    class="btn-tonal btn-tonal--neutral group"
                    data-tw-dismiss="modal"
                >
                    <x-base.lucide icon="x-circle" class="w-5 h-5 icon-hover-rise" />
                    Cancel
                </button>
                <button
                    type="submit"
                    id="update-department-btn"
                    form="edit-department-form"
                    class="btn-tonal btn-tonal--success group"
                >
                    <x-base.lucide icon="save" class="w-5 h-5 icon-hover-rise" />
                    Update Department
                </button>
            </div>
        @endslot
    </x-modal.form>
@endpush

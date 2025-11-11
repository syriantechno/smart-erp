@php
    $companies = $companies ?? \App\Models\Company::active()->get();
    $managers = $managers ?? \App\Models\Employee::active()->get();
    $departments = $departments ?? \App\Models\Department::active()->get();
@endphp

@push('modals')
    <x-modal.form id="create-department-modal" title="Create New Department">
        <form id="create-department-form" action="{{ route('hr.departments.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-12 gap-4 gap-y-4">
                <!-- Department Information -->
                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="code">Department Code</x-base.form-label>
                    <x-base.form-input id="code" name="code" type="text" class="w-full" readonly />
                </div>

                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="name">Department Name <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-input id="name" name="name" type="text" placeholder="Enter department name" class="w-full" required />
                </div>
                
                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="company_id">Company <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-select id="company_id" name="company_id" class="w-full" required>
                        <option value="">Select Company</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>
                
                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="parent_id">Parent Department</x-base.form-label>
                    <x-base.form-select id="parent_id" name="parent_id" class="w-full">
                        <option value="">Select Parent Department (Optional)</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>
                
                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="manager_id">Department Manager</x-base.form-label>
                    <x-base.form-select id="manager_id" name="manager_id" class="w-full">
                        <option value="">Select Manager (Optional)</option>
                        @foreach($managers as $manager)
                            <option value="{{ $manager->id }}">{{ $manager->full_name }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>
                
                <div class="col-span-12">
                    <x-base.form-label for="description">Description</x-base.form-label>
                    <x-base.form-textarea 
                        id="description" 
                        name="description" 
                        rows="3" 
                        placeholder="Enter department description"
                        class="w-full"
                    ></x-base.form-textarea>
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
                    type="submit"
                    form="create-department-form"
                    variant="primary"
                >
                    <x-base.lucide icon="Save" class="w-4 h-4 mr-2" />
                    Save
                </x-base.button>
            </div>
        @endslot
    </x-modal.form>
@endpush

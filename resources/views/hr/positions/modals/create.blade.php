@php
    $departments = \App\Models\Department::active()->get();
@endphp

@push('modals')
    <x-modal.form id="create-position-modal" title="Create New Position">
        <form id="create-position-form" action="{{ route('hr.positions.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-12 gap-4 gap-y-4">
                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="position-code">Position Code</x-base.form-label>
                    <x-base.form-input id="position-code" name="code" type="text" class="w-full" readonly />
                </div>

                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="title">Position Title <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-input id="title" name="title" type="text" placeholder="Enter position title" class="w-full" required />
                </div>

                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="department_id">Department <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-select id="department_id" name="department_id" class="w-full" required>
                        <option value="">Select Department</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>

                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="salary_range_min">Minimum Salary</x-base.form-label>
                    <x-base.form-input id="salary_range_min" name="salary_range_min" type="number" step="0.01" min="0" class="w-full" />
                </div>

                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="salary_range_max">Maximum Salary</x-base.form-label>
                    <x-base.form-input id="salary_range_max" name="salary_range_max" type="number" step="0.01" min="0" class="w-full" />
                </div>

                <div class="col-span-12">
                    <x-base.form-label for="description">Description</x-base.form-label>
                    <x-base.form-textarea id="description" name="description" rows="3" placeholder="Enter position description" class="w-full"></x-base.form-textarea>


                <div class="col-span-12">
                    <x-base.form-label for="requirements">Requirements</x-base.form-label>
                    <x-base.form-textarea id="requirements" name="requirements" rows="3" placeholder="Enter requirements" class="w-full"></x-base.form-textarea>
                </div>

                <div class="col-span-12">
                    <x-base.form-check
                        id="position_is_active"
                        name="is_active"
                        label="Active"
                        :checked="true"
                        type="checkbox"
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
                    type="submit"
                    form="create-position-form"
                    variant="primary"
                >
                    <x-base.lucide icon="Save" class="w-4 h-4 mr-2" />
                    Save
                </x-base.button>
            </div>
        @endslot
    </x-modal.form>
@endpush

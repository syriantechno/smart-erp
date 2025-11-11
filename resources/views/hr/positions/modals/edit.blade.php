@php
    $departments = \App\Models\Department::active()->get();
@endphp

@push('modals')
<x-modal.form id="edit-position-modal-{{ $position->id }}" title="Edit Position: {{ $position->title }}">
    <form id="edit-position-form-{{ $position->id }}" action="{{ route('hr.positions.update', $position) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-12 gap-4 gap-y-4">
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="position-code-{{ $position->id }}">Position Code</x-base.form-label>
                <x-base.form-input id="position-code-{{ $position->id }}" value="{{ $position->code }}" type="text" class="w-full" readonly />
            </div>

            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="title-{{ $position->id }}">Position Title <span class="text-danger">*</span></x-base.form-label>
                <x-base.form-input
                    id="title-{{ $position->id }}"
                    name="title"
                    type="text"
                    value="{{ old('title', $position->title) }}"
                    placeholder="Enter position title"
                    class="w-full"
                    required
                />
            </div>

            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="department_id-{{ $position->id }}">Department <span class="text-danger">*</span></x-base.form-label>
                <x-base.tom-select
                    id="department_id-{{ $position->id }}"
                    name="department_id"
                    class="w-full"
                    required
                >
                    <option value="">Select Department</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}" {{ $position->department_id == $department->id ? 'selected' : '' }}>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </x-base.tom-select>
            </div>

            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="minimum_salary-{{ $position->id }}">Minimum Salary</x-base.form-label>
                <x-base.form-input
                    id="minimum_salary-{{ $position->id }}"
                    name="minimum_salary"
                    type="number"
                    step="0.01"
                    min="0"
                    value="{{ old('minimum_salary', $position->salary_range_min) }}"
                    class="w-full"
                />
            </div>

            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="maximum_salary-{{ $position->id }}">Maximum Salary</x-base.form-label>
                <x-base.form-input
                    id="maximum_salary-{{ $position->id }}"
                    name="maximum_salary"
                    type="number"
                    step="0.01"
                    min="0"
                    value="{{ old('maximum_salary', $position->salary_range_max) }}"
                    class="w-full"
                />
            </div>

            <div class="col-span-12">
                <x-base.form-label for="description-{{ $position->id }}">Description</x-base.form-label>
                <x-base.form-textarea
                    id="description-{{ $position->id }}"
                    name="description"
                    rows="3"
                    placeholder="Enter position description"
                    class="w-full"
                >{{ old('description', $position->description) }}</x-base.form-textarea>
            </div>

            <div class="col-span-12">
                <x-base.form-label for="requirements-{{ $position->id }}">Requirements</x-base.form-label>
                <x-base.form-textarea
                    id="requirements-{{ $position->id }}"
                    name="requirements"
                    rows="3"
                    placeholder="Enter requirements"
                    class="w-full"
                >{{ old('requirements', $position->requirements) }}</x-base.form-textarea>
            </div>

            <div class="col-span-12">
                <x-base.form-check
                    id="position_is_active_{{ $position->id }}"
                    name="is_active"
                    label="Active"
                    :checked="old('is_active', $position->is_active)"
                    type="checkbox"
                />
            </div>
        </div>
    </form>

    @slot('footer')
        <div class="flex justify-end gap-2 w-full">
            <x-base.button
                type="button"
                data-tw-dismiss="modal"
                variant="outline-secondary"
            >
                Cancel
            </x-base.button>
            <x-base.button
                type="submit"
                form="edit-position-form-{{ $position->id }}"
                variant="primary"
            >
                <x-base.lucide icon="Save" class="w-4 h-4 mr-2" />
                Update
            </x-base.button>
        </div>
    @endslot
</x-modal.form>
@endpush

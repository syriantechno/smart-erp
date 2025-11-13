@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Edit Department - {{ $department->name }} - {{ config('app.name') }}</title>
@endsection

@section('subcontent')
    @include('components.global-notifications')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="text-lg font-medium ml-3">Edit Department: {{ $department->name }}</h2>
        <x-base.button
            variant="outline-secondary"
            class="mr-auto"
            href="{{ route('hr.departments.index') }}"
        >
            <x-base.lucide icon="ArrowRight" class="w-4 h-4 ml-2" />
            Back
        </x-base.button>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="col-span-12 lg:col-span-6">
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    <form action="{{ route('hr.departments.update', $department) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-base.form-label for="name">Department Name <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-input
                                id="name"
                                name="name"
                                type="text"
                                value="{{ old('name', $department->name) }}"
                                placeholder="Enter department name"
                                required
                            />
                            @error('name')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <x-base.form-label for="description">Description</x-base.form-label>
                            <x-base.form-textarea
                                id="description"
                                name="description"
                                rows="3"
                                placeholder="Enter department description"
                            >{{ old('description', $department->description) }}</x-base.form-textarea>
                            @error('description')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-12">
                                <x-base.form-label for="parent_id">Parent Department</x-base.form-label>
                                <x-base.form-select id="parent_id" name="parent_id">
                                    <option value="">Select parent department</option>
                                    @foreach($departments as $dept)
                                        @if($dept->id !== $department->id) {{-- Avoid selecting current department as parent --}}
                                        <option value="{{ $dept->id }}" {{ old('parent_id', $department->parent_id) == $dept->id ? 'selected' : '' }}>
                                            {{ $dept->name }}
                                        </option>
                                        @endif
                                    @endforeach
                                </x-base.form-select>
                                @error('parent_id')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-span-12">
                                <x-base.form-label for="manager_id">Department Manager</x-base.form-label>
                                <x-base.form-select id="manager_id" name="manager_id">
                                    <option value="">Select manager</option>
                                    @if($department->manager)
                                        <option value="{{ $department->manager->id }}" selected>
                                            {{ $department->manager->full_name }}
                                        </option>
                                    @endif
                                </x-base.form-select>
                                @error('manager_id')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-between mt-6">
                            <x-base.button
                                variant="outline-secondary"
                                type="button"
                                onclick="window.history.back()"
                            >
                                Cancel
                            </x-base.button>
                            <x-base.button
                                variant="primary"
                                type="submit"
                            >
                                <x-base.lucide icon="Save" class="w-4 h-4 ml-2" />
                                Save Changes
                            </x-base.button>
                        </div>
                    </form>
                </div>
            </x-base.preview-component>
        </div>

        <div class="col-span-12 lg:col-span-6">
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    <div class="flex items-center border-b border-slate-200/60 pb-3 mb-4">
                        <x-base.lucide icon="Users" class="w-5 h-5 text-slate-500 ml-2" />
                        <h2 class="font-medium text-base">Department Employees</h2>
                        <x-base.button
                            variant="outline-secondary"
                            size="sm"
                            class="mr-auto"
                            href="{{ route('hr.employees.create', ['department_id' => $department->id]) }}"
                        >
                            <x-base.lucide icon="Plus" class="w-4 h-4 ml-1" />
                            Add Employee
                        </x-base.button>
                    </div>

                    @if($department->employees->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th class="whitespace-nowrap">Name</th>
                                        <th class="whitespace-nowrap">Position</th>
                                        <th class="whitespace-nowrap">Hire Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($department->employees as $employee)
                                    <tr>
                                        <td>
                                            <a href="{{ route('hr.employees.show', $employee) }}" class="font-medium hover:text-primary">
                                                {{ $employee->full_name }}
                                            </a>
                                        </td>
                                        <td>{{ $employee->position }}</td>
                                        <td>{{ $employee->hire_date->format('Y-m-d') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center text-slate-500 py-4">
                            <x-base.lucide icon="Users" class="w-8 h-8 mx-auto mb-2 opacity-50" />
                            No employees in this department
                        </div>
                    @endif
                </div>
            </x-base.preview-component>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Load managers based on department selection
        const departmentSelect = document.getElementById('parent_id');
        const managerSelect = document.getElementById('manager_id');

        function loadManagers(departmentId) {
            if (!departmentId) {
                managerSelect.innerHTML = '<option value="">Select manager</option>';
                return;
            }

            // Show loading state
            managerSelect.innerHTML = '<option value="">Loading...</option>';

            // Fetch employees for the selected department
            fetch(`/api/departments/${departmentId}/employees`)
                .then(response => response.json())
                .then(data => {
                    managerSelect.innerHTML = '<option value="">Select manager</option>';
                    data.forEach(employee => {
                        const option = document.createElement('option');
                        option.value = employee.id;
                        option.textContent = employee.full_name;

                        // Select the current manager if exists
                        if ({{ $department->manager_id ?? 'null' }} === employee.id) {
                            option.selected = true;
                        }

                        managerSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    managerSelect.innerHTML = '<option value="">Error loading managers</option>';
                    showError('Error loading department managers');
                });
        }

        // Load managers when department changes
        if (departmentSelect) {
            departmentSelect.addEventListener('change', function() {
                loadManagers(this.value);
            });

            // Load managers for the current department on page load
            @if($department->parent_id)
                loadManagers({{ $department->parent_id }});
            @endif
        }
    });
</script>
@endpush

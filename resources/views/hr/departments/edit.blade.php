@extends('layouts.app')

@section('title', 'تعديل قسم')

@section('content')
<div class="content">
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium ml-3">تعديل قسم: {{ $department->name }}</h2>
        <a href="{{ route('hr.departments.index') }}" class="btn btn-outline-secondary ml-auto">
            <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i> رجوع
        </a>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="col-span-12 lg:col-span-6">
            <div class="intro-y box p-5">
                <form action="{{ route('hr.departments.update', $department) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="name" class="form-label">اسم القسم <span class="text-danger">*</span></label>
                        <input id="name" name="name" type="text" class="form-control" 
                               value="{{ old('name', $department->name) }}" required>
                        @error('name')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label">الوصف</label>
                        <textarea id="description" name="description" class="form-control" rows="3">{{ old('description', $department->description) }}</textarea>
                        @error('description')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-6">
                            <label for="parent_id" class="form-label">القسم التابع له</label>
                            <select id="parent_id" name="parent_id" class="form-select">
                                <option value="">اختر القسم الرئيسي</option>
                                @foreach($departments as $dept)
                                    @if($dept->id !== $department->id) {{-- تجنب اختيار القسم الحالي كأب --}}
                                    <option value="{{ $dept->id }}" {{ old('parent_id', $department->parent_id) == $dept->id ? 'selected' : '' }}>
                                        {{ $dept->name }}
                                    </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('parent_id')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-span-6">
                            <label for="manager_id" class="form-label">المدير المسؤول</label>
                            <select id="manager_id" name="manager_id" class="form-select">
                                <option value="">اختر المدير</option>
                                @if($department->manager)
                                    <option value="{{ $department->manager->id }}" selected>
                                        {{ $department->manager->full_name }}
                                    </option>
                                @endif
                            </select>
                            @error('manager_id')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="form-check form-switch">
                            <input id="is_active" name="is_active" class="form-check-input" type="checkbox" 
                                   {{ old('is_active', $department->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">نشط</label>
                        </div>
                    </div>

                    <div class="flex justify-between mt-6">
                        <a href="{{ route('hr.departments.index') }}" class="btn btn-outline-secondary w-24">إلغاء</a>
                        <button type="submit" class="btn btn-primary w-24">حفظ التغييرات</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="col-span-12 lg:col-span-6">
            <div class="intro-y box p-5">
                <div class="flex items-center border-b border-slate-200/60 pb-3 mb-4">
                    <h2 class="font-medium text-base">الموظفون في هذا القسم</h2>
                    <a href="{{ route('hr.employees.create', ['department_id' => $department->id]) }}" 
                       class="btn btn-outline-secondary btn-sm ml-auto">
                        <i data-lucide="plus" class="w-4 h-4 ml-1"></i> إضافة موظف
                    </a>
                </div>
                
                @if($department->employees->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th class="whitespace-nowrap">الاسم</th>
                                    <th class="whitespace-nowrap">الوظيفة</th>
                                    <th class="whitespace-nowrap">تاريخ التعيين</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($department->employees as $employee)
                                <tr>
                                    <td>
                                        <a href="{{ route('hr.employees.show', $employee) }}" class="font-medium">
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
                    <div class="text-center text-slate-500 py-4">لا يوجد موظفين في هذا القسم</div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // AJAX to load managers based on department selection
    document.addEventListener('DOMContentLoaded', function() {
        const departmentSelect = document.getElementById('parent_id');
        const managerSelect = document.getElementById('manager_id');

        function loadManagers(departmentId) {
            if (!departmentId) return;
            
            // Show loading state
            managerSelect.innerHTML = '<option value="">جاري التحميل...</option>';
            
            // Fetch employees for the selected department
            fetch(`/api/departments/${departmentId}/employees`)
                .then(response => response.json())
                .then(data => {
                    managerSelect.innerHTML = '<option value="">اختر المدير</option>';
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
                    managerSelect.innerHTML = '<option value="">حدث خطأ أثناء التحميل</option>';
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
@endsection

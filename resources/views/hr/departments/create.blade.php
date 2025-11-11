@extends('layouts.app')

@section('title', 'إضافة قسم جديد')

@section('content')
<div class="content">
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium ml-3">إضافة قسم جديد</h2>
        <a href="{{ route('hr.departments.index') }}" class="btn btn-outline-secondary ml-auto">
            <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i> رجوع
        </a>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="col-span-12 lg:col-span-6">
            <div class="intro-y box p-5">
                <form action="{{ route('hr.departments.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="form-label">اسم القسم <span class="text-danger">*</span></label>
                        <input id="name" name="name" type="text" class="form-control" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label">الوصف</label>
                        <textarea id="description" name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
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
                                    <option value="{{ $dept->id }}" {{ old('parent_id') == $dept->id ? 'selected' : '' }}>
                                        {{ $dept->name }}
                                    </option>
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
                                {{-- سيتم تعبئة هذا الحقل عبر AJAX بناءً على القسم المحدد --}}
                            </select>
                            @error('manager_id')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="form-check form-switch">
                            <input id="is_active" name="is_active" class="form-check-input" type="checkbox" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">نشط</label>
                        </div>
                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="submit" class="btn btn-primary w-24">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // AJAX to load managers based on department selection
    document.addEventListener('DOMContentLoaded', function() {
        const departmentSelect = document.getElementById('department_id');
        const managerSelect = document.getElementById('manager_id');

        if (departmentSelect) {
            departmentSelect.addEventListener('change', function() {
                const departmentId = this.value;
                
                // Clear current options
                managerSelect.innerHTML = '<option value="">اختر المدير</option>';
                
                if (!departmentId) return;
                
                // Fetch employees for the selected department
                fetch(`/api/departments/${departmentId}/employees`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(employee => {
                            const option = document.createElement('option');
                            option.value = employee.id;
                            option.textContent = employee.full_name;
                            managerSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error:', error));
            });
        }
    });
</script>
@endpush
@endsection

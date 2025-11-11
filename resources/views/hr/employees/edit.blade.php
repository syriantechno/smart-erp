@extends('layouts.app')

@section('title', 'Edit Employee: ' . $employee->full_name)

{{--
    Employee Edit View
    This view allows editing employee information
    @var \App\Models\Employee $employee
    @var \Illuminate\Database\Eloquent\Collection $departments
    @var \Illuminate\Database\Eloquent\Collection $companies
--}}

@section('content')
<div class="content">
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium ml-3">Edit Employee: {{ $employee->full_name }}</h2>
        <a href="{{ route('hr.employees.show', $employee) }}" class="btn btn-outline-secondary ml-auto">
            <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i> Back to Details
        </a>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="col-span-12 lg:col-span-8">
            <div class="intro-y box p-5"]
                <form action="{{ route('hr.employees.update', $employee) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-12 gap-4">
                        <!-- Personal Information -->
                        <div class="col-span-12">
                            <div class="border-b border-slate-200/60 pb-4 mb-4">
                                <h2 class="text-lg font-medium">المعلومات الشخصية</h2>
                            </div>
                        </div>
                        
                        <div class="col-span-12 sm:col-span-6">
                            <label for="first_name" class="form-label">الاسم الأول <span class="text-danger">*</span></label>
                            <input id="first_name" name="first_name" type="text" class="form-control" 
                                   value="{{ old('first_name', $employee->first_name) }}" required>
                            @error('first_name')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-span-12 sm:col-span-6">
                            <label for="middle_name" class="form-label">اسم الأب</label>
                            <input id="middle_name" name="middle_name" type="text" class="form-control" 
                                   value="{{ old('middle_name', $employee->middle_name) }}">
                            @error('middle_name')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-span-12 sm:col-span-6">
                            <label for="last_name" class="form-label">اسم العائلة <span class="text-danger">*</span></label>
                            <input id="last_name" name="last_name" type="text" class="form-control" 
                                   value="{{ old('last_name', $employee->last_name) }}" required>
                            @error('last_name')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-span-12 sm:col-span-6">
                            <label for="birth_date" class="form-label">تاريخ الميلاد</label>
                            <input id="birth_date" name="birth_date" type="date" class="form-control" 
                                   value="{{ old('birth_date', optional($employee->birth_date)->format('Y-m-d')) }}">
                            @error('birth_date')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-span-12 sm:col-span-6">
                            <label for="gender" class="form-label">الجنس</label>
                            <select id="gender" name="gender" class="form-select">
                                <option value="">اختر الجنس</option>
                                <option value="male" {{ old('gender', $employee->gender) == 'male' ? 'selected' : '' }}>ذكر</option>
                                <option value="female" {{ old('gender', $employee->gender) == 'female' ? 'selected' : '' }}>أنثى</option>
                                <option value="other" {{ old('gender', $employee->gender) == 'other' ? 'selected' : '' }}>أخرى</option>
                            </select>
                            @error('gender')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-span-12 sm:col-span-6">
                            <label for="photo" class="form-label">صورة شخصية</label>
                            <input id="photo" name="photo" type="file" class="form-control" accept="image/*">
                            @if($employee->photo_url)
                                <div class="mt-2">
                                    <img src="{{ $employee->photo_url }}" alt="صورة الموظف" class="w-20 h-20 rounded-full object-cover">
                                </div>
                            @endif
                            @error('photo')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Contact Information -->
                        <div class="col-span-12 mt-6">
                            <div class="border-b border-slate-200/60 pb-4 mb-4">
                                <h2 class="text-lg font-medium">معلومات الاتصال</h2>
                            </div>
                        </div>
                        
                        <div class="col-span-12 sm:col-span-6">
                            <label for="email" class="form-label">البريد الإلكتروني <span class="text-danger">*</span></label>
                            <input id="email" name="email" type="email" class="form-control" 
                                   value="{{ old('email', $employee->email) }}" required>
                            @error('email')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-span-12 sm:col-span-6">
                            <label for="phone" class="form-label">رقم الجوال</label>
                            <input id="phone" name="phone" type="tel" class="form-control" 
                                   value="{{ old('phone', $employee->phone) }}">
                            @error('phone')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-span-12">
                            <label for="address" class="form-label">العنوان</label>
                            <textarea id="address" name="address" class="form-control" rows="2">{{ old('address', $employee->address) }}</textarea>
                            @error('address')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-span-12 sm:col-span-4">
                            <label for="city" class="form-label">المدينة</label>
                            <input id="city" name="city" type="text" class="form-control" 
                                   value="{{ old('city', $employee->city) }}">
                            @error('city')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-span-12 sm:col-span-4">
                            <label for="country" class="form-label">الدولة</label>
                            <input id="country" name="country" type="text" class="form-control" 
                                   value="{{ old('country', $employee->country ?? 'السعودية') }}">
                            @error('country')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-span-12 sm:col-span-4">
                            <label for="postal_code" class="form-label">الرمز البريدي</label>
                            <input id="postal_code" name="postal_code" type="text" class="form-control" 
                                   value="{{ old('postal_code', $employee->postal_code) }}">
                            @error('postal_code')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Employment Information -->
                        <div class="col-span-12 mt-6">
                            <div class="border-b border-slate-200/60 pb-4 mb-4">
                                <h2 class="text-lg font-medium">معلومات التوظيف</h2>
                            </div>
                        </div>
                        
                        <div class="col-span-12 sm:col-span-6">
                            <label for="employee_id" class="form-label">رقم الموظف</label>
                            <input id="employee_id" name="employee_id" type="text" class="form-control" 
                                   value="{{ old('employee_id', $employee->employee_id) }}" readonly>
                            <div class="text-xs text-slate-500 mt-1">لا يمكن تعديل رقم الموظف</div>
                            @error('employee_id')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-span-12 sm:col-span-6">
                            <label for="position" class="form-label">الوظيفة <span class="text-danger">*</span></label>
                            <input id="position" name="position" type="text" class="form-control" 
                                   value="{{ old('position', $employee->position) }}" required>
                            @error('position')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-span-12 sm:col-span-6">
                            <label for="department_id" class="form-label">القسم <span class="text-danger">*</span></label>
                            <select id="department_id" name="department_id" class="form-select" required>
                                <option value="">اختر القسم</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" 
                                        {{ old('department_id', $employee->department_id) == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('department_id')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-span-12 sm:col-span-6">
                            <label for="company_id" class="form-label">الشركة <span class="text-danger">*</span></label>
                            <select id="company_id" name="company_id" class="form-select" required>
                                <option value="">اختر الشركة</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}" 
                                        {{ old('company_id', $employee->company_id) == $company->id ? 'selected' : '' }}>
                                        {{ $company->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('company_id')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-span-12 sm:col-span-6">
                            <label for="hire_date" class="form-label">تاريخ التعيين <span class="text-danger">*</span></label>
                            <input id="hire_date" name="hire_date" type="date" class="form-control" 
                                   value="{{ old('hire_date', $employee->hire_date->format('Y-m-d')) }}" required>
                            @error('hire_date')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-span-12 sm:col-span-6">
                            <label for="salary" class="form-label">الراتب الأساسي <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input id="salary" name="salary" type="number" step="0.01" class="form-control" 
                                       value="{{ old('salary', $employee->salary) }}" required>
                                <div class="input-group-text">{{ config('app.currency', 'USD') }}</div>
                            </div>
                            @error('salary')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-span-12 mt-3">
                            <div class="form-check form-switch">
                                <input id="is_active" name="is_active" class="form-check-input" type="checkbox" 
                                       {{ old('is_active', $employee->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">حساب نشط</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-between mt-6">
                        <a href="{{ route('hr.employees.show', $employee) }}" class="btn btn-outline-secondary w-24">إلغاء</a>
                        <button type="submit" class="btn btn-primary w-24">حفظ التغييرات</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="col-span-12 lg:col-span-4">
            <div class="intro-y box p-5">
                <div class="border-b border-slate-200/60 pb-4 mb-4">
                    <h2 class="text-lg font-medium">صورة الملف الشخصي</h2>
                    <div class="text-xs text-slate-500 mt-1">الحد الأقصى لحجم الملف 2 ميجابايت. الأنواع المسموحة: jpg, jpeg, png.</div>
                </div>
                
                <div class="border-2 border-dashed rounded-md p-5 text-center">
                    <div id="image-preview" class="mx-auto w-40 h-40 mb-4 rounded-full overflow-hidden bg-slate-100">
                        <img id="preview-image" 
                             src="{{ $employee->photo_url ?? asset('dist/images/profile-1.jpg') }}" 
                             alt="صورة الملف الشخصي" 
                             class="w-full h-full object-cover">
                    </div>
                    <div class="text-slate-500 text-xs mt-2">انقر لتحميل صورة جديدة</div>
                </div>
            </div>
            
            @if($employee->user)
            <div class="intro-y box p-5 mt-5">
                <div class="border-b border-slate-200/60 pb-4 mb-4">
                    <h2 class="text-lg font-medium">حساب المستخدم</h2>
                    <div class="text-xs text-slate-500 mt-1">إدارة حساب المستخدم المرتبط بهذا الموظف</div>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <div class="text-slate-500 text-xs">اسم المستخدم</div>
                        <div class="font-medium">{{ $employee->user->name }}</div>
                    </div>
                    
                    <div>
                        <div class="text-slate-500 text-xs">البريد الإلكتروني</div>
                        <div class="font-medium">{{ $employee->user->email }}</div>
                    </div>
                    
                    <div>
                        <div class="text-slate-500 text-xs">حالة الحساب</div>
                        <div class="font-medium">
                            <span class="px-2 py-1 text-xs rounded-full {{ $employee->user->is_active ? 'bg-success/10 text-success' : 'bg-danger/10 text-danger' }}">
                                {{ $employee->user->is_active ? 'نشط' : 'معطل' }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="pt-4 mt-4 border-t border-slate-200/60">
                        <a href="{{ route('users.edit', $employee->user) }}" class="btn btn-outline-primary w-full">
                            <i data-lucide="edit-3" class="w-4 h-4 ml-2"></i> تعديل حساب المستخدم
                        </a>
                    </div>
                </div>
            </div>
            @else
            <div class="intro-y box p-5 mt-5">
                <div class="border-b border-slate-200/60 pb-4 mb-4">
                    <h2 class="text-lg font-medium">إنشاء حساب مستخدم</h2>
                    <div class="text-xs text-slate-500 mt-1">يمكنك إنشاء حساب مستخدم لهذا الموظف</div>
                </div>
                
                <a href="{{ route('users.create', ['employee_id' => $employee->id]) }}" class="btn btn-primary w-full">
                    <i data-lucide="user-plus" class="w-4 h-4 ml-2"></i> إنشاء حساب مستخدم
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    /**
     * Initialize employee form functionality
     */
    document.addEventListener('DOMContentLoaded', function() {
        // Handle image preview functionality
        const photoInput = document.getElementById('photo');
        const previewImage = document.getElementById('preview-image');
        
        if (photoInput && previewImage) {
            photoInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
        
        // Auto-generate email if empty
        const emailInput = document.getElementById('email');
        if (emailInput && !emailInput.value) {
            const firstName = document.getElementById('first_name')?.value.toLowerCase() || '';
            const lastName = document.getElementById('last_name')?.value.toLowerCase() || '';
            if (firstName && lastName) {
                emailInput.value = `${firstName}.${lastName}@example.com`;
            }
        }

        // Initialize select2 if used
        if (typeof $ !== 'undefined' && $.fn.select2) {
            $('.select2').select2({
                theme: 'tailwind',
                width: '100%',
                placeholder: 'Select an option'
            });
        }
    });
</script>
@endpush
@endsection

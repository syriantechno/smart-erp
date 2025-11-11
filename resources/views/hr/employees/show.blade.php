@extends('layouts.app')

{{--
    Employee Show View
    Displays detailed information about an employee
    @var \App\Models\Employee $employee
--}}

@section('title', $employee->full_name)

@section('content')
<div class="content">
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium ml-3">
            تفاصيل الموظف: {{ $employee->full_name }}
        </h2>
        <div class="flex w-full sm:w-auto flex-col sm:flex-row sm:mr-auto mt-3 sm:mt-0">
            <a href="{{ route('hr.employees.edit', $employee) }}" class="btn btn-primary shadow-md mr-2">
                <i data-lucide="edit-3" class="w-4 h-4 ml-2"></i> تعديل البيانات
            </a>
            <a href="{{ route('hr.employees.index') }}" class="btn btn-outline-secondary">
                <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i> رجوع
            </a>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">
        <!-- Left Column -->
        <div class="col-span-12 lg:col-span-4 2xl:col-span-3">
            <div class="intro-y box p-5">
                <div class="flex flex-col items-center">
                    <div class="w-40 h-40 image-fit rounded-full overflow-hidden">
                        <img alt="{{ $employee->full_name }}" class="rounded-full" 
                             src="{{ $employee->photo_url ?? asset('dist/images/profile-1.jpg') }}">
                    </div>
                    <div class="text-center mt-4">
                        <h3 class="text-lg font-medium">{{ $employee->full_name }}</h3>
                        <div class="text-slate-500">{{ $employee->position }}</div>
                        <div class="mt-1">
                            <span class="px-2 py-1 text-xs rounded-full {{ $employee->is_active ? 'bg-success/10 text-success' : 'bg-danger/10 text-danger' }}">
                                {{ $employee->is_active ? 'نشط' : 'غير نشط' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="border-t border-slate-200/60 mt-5 pt-5">
                    <div class="flex items-center mb-3">
                        <i data-lucide="mail" class="w-4 h-4 ml-2 text-slate-500"></i>
                        <a href="mailto:{{ $employee->email }}" class="text-slate-600">
                            {{ $employee->email }}
                        </a>
                    </div>
                    @if($employee->phone)
                    <div class="flex items-center mb-3">
                        <i data-lucide="phone" class="w-4 h-4 ml-2 text-slate-500"></i>
                        <a href="tel:{{ $employee->phone }}" class="text-slate-600">
                            {{ $employee->phone }}
                        </a>
                    </div>
                    @endif
                    @if($employee->department)
                    <div class="flex items-center mb-3">
                        <i data-lucide="building-2" class="w-4 h-4 ml-2 text-slate-500"></i>
                        <span class="text-slate-600">{{ $employee->department->name }}</span>
                    </div>
                    @endif
                    @if($employee->hire_date)
                    <div class="flex items-center mb-3">
                        <i data-lucide="calendar" class="w-4 h-4 ml-2 text-slate-500"></i>
                        <span class="text-slate-600">
                            تاريخ التعيين: {{ $employee->hire_date->format('Y-m-d') }}
                            <span class="text-xs text-slate-400">({{ $employee->hire_date->diffForHumans() }})</span>
                        </span>
                    </div>
                    @endif
                    @if($employee->salary)
                    <div class="flex items-center">
                        <i data-lucide="dollar-sign" class="w-4 h-4 ml-2 text-slate-500"></i>
                        <span class="text-slate-600">
                            الراتب: {{ number_format($employee->salary, 2) }} {{ config('app.currency', 'USD') }}
                        </span>
                    </div>
                    @endif
                </div>

                @if($employee->address || $employee->city || $employee->country)
                <div class="border-t border-slate-200/60 mt-5 pt-5">
                    <h4 class="text-slate-500 text-xs uppercase font-medium mb-3">العنوان</h4>
                    <div class="text-slate-600">
                        @if($employee->address)
                            <div>{{ $employee->address }}</div>
                        @endif
                        <div>
                            @if($employee->city)
                                <span>{{ $employee->city }}</span>،
                            @endif
                            @if($employee->country)
                                <span>{{ $employee->country }}</span>
                            @endif
                            @if($employee->postal_code)
                                <div>الرمز البريدي: {{ $employee->postal_code }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                @if($employee->user)
                <div class="border-t border-slate-200/60 mt-5 pt-5">
                    <h4 class="text-slate-500 text-xs uppercase font-medium mb-3">حساب المستخدم</h4>
                    <div class="flex items-center">
                        <div class="w-2 h-2 rounded-full bg-success mr-2"></div>
                        <span class="text-slate-600">
                            {{ $employee->user->name }}
                            <span class="text-slate-400 text-xs">({{ $employee->user->email }})</span>
                        </span>
                    </div>
                    <div class="mt-2">
                        @foreach($employee->user->roles as $role)
                            <span class="px-2 py-1 text-xs rounded-full bg-primary/10 text-primary">
                                {{ $role->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-span-12 lg:col-span-8 2xl:col-span-9">
            <div class="intro-y box p-5">
                <ul class="nav nav-boxed-tabs" role="tablist">
                    <li class="nav-item flex-1" role="presentation">
                        <button class="nav-link w-full py-2 active" data-tw-toggle="tab" data-tw-target="#personal-info" type="button" role="tab" aria-controls="personal-info" aria-selected="true">
                            <i data-lucide="user" class="w-4 h-4 ml-2"></i> المعلومات الشخصية
                        </button>
                    </li>
                    <li class="nav-item flex-1" role="presentation">
                        <button class="nav-link w-full py-2" data-tw-toggle="tab" data-tw-target="#employment" type="button" role="tab" aria-controls="employment" aria-selected="false">
                            <i data-lucide="briefcase" class="w-4 h-4 ml-2"></i> معلومات التوظيف
                        </button>
                    </li>
                    <li class="nav-item flex-1" role="presentation">
                        <button class="nav-link w-full py-2" data-tw-toggle="tab" data-tw-target="#documents" type="button" role="tab" aria-controls="documents" aria-selected="false">
                            <i data-lucide="file-text" class="w-4 h-4 ml-2"></i> المستندات
                        </button>
                    </li>
                    <li class="nav-item flex-1" role="presentation">
                        <button class="nav-link w-full py-2" data-tw-toggle="tab" data-tw-target="#leaves" type="button" role="tab" aria-controls="leaves" aria-selected="false">
                            <i data-lucide="calendar-off" class="w-4 h-4 ml-2"></i> الإجازات
                        </button>
                    </li>
                </ul>

                <div class="tab-content mt-5">
                    <!-- Personal Info Tab -->
                    <div id="personal-info" class="tab-pane active" role="tabpanel" aria-labelledby="personal-info-tab">
                        <div class="grid grid-cols-12 gap-6">
                            <div class="col-span-12 sm:col-span-6">
                                <div class="border-b border-slate-200/60 pb-3 mb-3">
                                    <h4 class="text-slate-500 text-xs uppercase font-medium">المعلومات الشخصية</h4>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="col-span-1">
                                        <div class="text-slate-500 text-xs">الاسم الأول</div>
                                        <div class="font-medium">{{ $employee->first_name }}</div>
                                    </div>
                                    <div class="col-span-1">
                                        <div class="text-slate-500 text-xs">اسم الأب</div>
                                        <div class="font-medium">{{ $employee->middle_name ?? '-' }}</div>
                                    </div>
                                    <div class="col-span-1">
                                        <div class="text-slate-500 text-xs">اسم العائلة</div>
                                        <div class="font-medium">{{ $employee->last_name }}</div>
                                    </div>
                                    <div class="col-span-1">
                                        <div class="text-slate-500 text-xs">الجنس</div>
                                        <div class="font-medium">
                                            @if($employee->gender == 'male')
                                                ذكر
                                            @elseif($employee->gender == 'female')
                                                أنثى
                                            @elseif($employee->gender == 'other')
                                                أخرى
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </div>
                                    @if($employee->birth_date)
                                    <div class="col-span-1">
                                        <div class="text-slate-500 text-xs">تاريخ الميلاد</div>
                                        <div class="font-medium">
                                            {{ $employee->birth_date->format('Y-m-d') }}
                                            <span class="text-slate-400 text-xs">({{ $employee->age }} سنة)</span>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-span-12 sm:col-span-6">
                                <div class="border-b border-slate-200/60 pb-3 mb-3">
                                    <h4 class="text-slate-500 text-xs uppercase font-medium">معلومات الاتصال</h4>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <div class="text-slate-500 text-xs">البريد الإلكتروني</div>
                                        <div class="font-medium">
                                            <a href="mailto:{{ $employee->email }}" class="text-primary">
                                                {{ $employee->email }}
                                            </a>
                                        </div>
                                    </div>
                                    @if($employee->phone)
                                    <div>
                                        <div class="text-slate-500 text-xs">رقم الجوال</div>
                                        <div class="font-medium">
                                            <a href="tel:{{ $employee->phone }}" class="text-primary">
                                                {{ $employee->phone }}
                                            </a>
                                        </div>
                                    </div>
                                    @endif
                                    @if($employee->address || $employee->city || $employee->country)
                                    <div>
                                        <div class="text-slate-500 text-xs">العنوان</div>
                                        <div class="font-medium">
                                            @if($employee->address)
                                                <div>{{ $employee->address }}</div>
                                            @endif
                                            <div>
                                                @if($employee->city)
                                                    <span>{{ $employee->city }}</span>،
                                                @endif
                                                @if($employee->country)
                                                    <span>{{ $employee->country }}</span>
                                                @endif
                                                @if($employee->postal_code)
                                                    <div>الرمز البريدي: {{ $employee->postal_code }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Employment Tab -->
                    <div id="employment" class="tab-pane" role="tabpanel" aria-labelledby="employment-tab">
                        <div class="grid grid-cols-12 gap-6">
                            <div class="col-span-12 sm:col-span-6">
                                <div class="border-b border-slate-200/60 pb-3 mb-3">
                                    <h4 class="text-slate-500 text-xs uppercase font-medium">معلومات التوظيف</h4>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <div class="text-slate-500 text-xs">رقم الموظف</div>
                                        <div class="font-medium">{{ $employee->employee_id }}</div>
                                    </div>
                                    <div>
                                        <div class="text-slate-500 text-xs">الوظيفة</div>
                                        <div class="font-medium">{{ $employee->position }}</div>
                                    </div>
                                    @if($employee->department)
                                    <div>
                                        <div class="text-slate-500 text-xs">القسم</div>
                                        <div class="font-medium">
                                            <a href="{{ route('hr.departments.edit', $employee->department) }}" class="text-primary">
                                                {{ $employee->department->name }}
                                            </a>
                                        </div>
                                    </div>
                                    @endif
                                    @if($employee->company)
                                    <div>
                                        <div class="text-slate-500 text-xs">الشركة</div>
                                        <div class="font-medium">{{ $employee->company->name }}</div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-span-12 sm:col-span-6">
                                <div class="border-b border-slate-200/60 pb-3 mb-3">
                                    <h4 class="text-slate-500 text-xs uppercase font-medium">المعلومات المالية</h4>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <div class="text-slate-500 text-xs">تاريخ التعيين</div>
                                        <div class="font-medium">
                                            {{ $employee->hire_date->format('Y-m-d') }}
                                            <span class="text-slate-400 text-xs">({{ $employee->hire_date->diffForHumans() }})</span>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="text-slate-500 text-xs">الراتب الأساسي</div>
                                        <div class="font-medium">
                                            {{ number_format($employee->salary, 2) }} {{ config('app.currency', 'USD') }}
                                        </div>
                                    </div>
                                    <div>
                                        <div class="text-slate-500 text-xs">حالة التوظيف</div>
                                        <div class="font-medium">
                                            <span class="px-2 py-1 text-xs rounded-full {{ $employee->is_active ? 'bg-success/10 text-success' : 'bg-danger/10 text-danger' }}">
                                                {{ $employee->is_active ? 'نشط' : 'غير نشط' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Documents Tab -->
                    <div id="documents" class="tab-pane" role="tabpanel" aria-labelledby="documents-tab">
                        <div class="flex flex-col items-center justify-center py-10 text-center">
                            <i data-lucide="file-text" class="w-16 h-16 text-slate-400 mb-3"></i>
                            <h3 class="text-lg font-medium">لا توجد مستندات</h3>
                            <p class="text-slate-500 mt-1">لا توجد مستندات مرفقة لهذا الموظف حتى الآن.</p>
                            <button class="btn btn-primary mt-4">
                                <i data-lucide="plus" class="w-4 h-4 ml-2"></i> إضافة مستند
                            </button>
                        </div>
                    </div>

                    <!-- Leaves Tab -->
                    <div id="leaves" class="tab-pane" role="tabpanel" aria-labelledby="leaves-tab">
                        <div class="flex flex-col items-center justify-center py-10 text-center">
                            <i data-lucide="calendar-off" class="w-16 h-16 text-slate-400 mb-3"></i>
                            <h3 class="text-lg font-medium">لا توجد طلبات إجازة</h3>
                            <p class="text-slate-500 mt-1">لا توجد طلبات إجازة مسجلة لهذا الموظف حتى الآن.</p>
                            <button class="btn btn-primary mt-4">
                                <i data-lucide="plus" class="w-4 h-4 ml-2"></i> طلب إجازة جديدة
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    /**
     * Initialize tab functionality for employee details
     */
    document.addEventListener('DOMContentLoaded', function() {
        // Get all tab buttons
        const tabButtons = document.querySelectorAll('[data-tw-toggle="tab"]');
        
        // Add click event listeners to each tab button
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-tw-target');
                const targetTab = document.querySelector(targetId);
                
                // Hide all tab panes
                document.querySelectorAll('.tab-pane').forEach(pane => {
                    pane.classList.remove('active');
                });
                
                // Deactivate all tab buttons
                tabButtons.forEach(btn => {
                    btn.classList.remove('active');
                });
                
                // Show target tab pane and activate button
                if (targetTab) {
                    targetTab.classList.add('active');
                    this.classList.add('active');
                    
                    // Optional: Save the active tab to localStorage
                    localStorage.setItem('employeeTab', targetId);
                }
            });
        });

        // Restore active tab from localStorage if available
        const savedTab = localStorage.getItem('employeeTab');
        if (savedTab) {
            const tabToActivate = document.querySelector(`[data-tw-toggle="tab"][data-tw-target="${savedTab}"]`);
            if (tabToActivate) {
                tabToActivate.click();
            }
        }
    });
</script>
@endpush
@endsection

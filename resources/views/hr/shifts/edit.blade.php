@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>تعديل الشيفتة: {{ $shift->name }} - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">تعديل الشيفتة: {{ $shift->name }}</h2>
        <a href="{{ route('hr.shifts.index') }}" class="btn btn-secondary ml-2">
            <x-base.lucide icon="ArrowLeft" class="w-4 h-4 mr-2" />
            العودة للقائمة
        </a>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 lg:col-span-8">
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    @if (session('success'))
                        <x-base.alert class="mb-4" variant="success">
                            <div class="flex items-center">
                                <x-base.lucide icon="CheckCircle" class="w-5 h-5 mr-2" />
                                {{ session('success') }}
                            </div>
                        </x-base.alert>
                    @endif

                    @if (session('error'))
                        <x-base.alert class="mb-4" variant="danger">
                            <div class="flex items-center">
                                <x-base.lucide icon="AlertTriangle" class="w-5 h-5 mr-2" />
                                {{ session('error') }}
                            </div>
                        </x-base.alert>
                    @endif

                    <form id="edit-shift-form" action="{{ route('hr.shifts.update', $shift) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Basic Information -->
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                                <x-base.lucide icon="Info" class="h-5 w-5"></x-base.lucide>
                                المعلومات الأساسية
                            </h4>
                            <div class="grid grid-cols-12 gap-4 gap-y-4">
                                <!-- Code -->
                                <div class="col-span-12 md:col-span-6">
                                    <x-base.form-label for="shift-code">الكود <span class="text-danger">*</span></x-base.form-label>
                                    <x-base.form-input id="shift-code" name="code" type="text" class="w-full" value="{{ old('code', $shift->code) }}" readonly required />
                                    <small class="text-slate-500">لا يمكن تعديل الكود</small>
                                </div>

                                <!-- Name -->
                                <div class="col-span-12 md:col-span-6">
                                    <x-base.form-label for="shift-name">اسم الشيفتة <span class="text-danger">*</span></x-base.form-label>
                                    <x-base.form-input id="shift-name" name="name" type="text" placeholder="مثال: الشيفتة الصباحية" class="w-full" value="{{ old('name', $shift->name) }}" required />
                                </div>

                                <!-- Description -->
                                <div class="col-span-12">
                                    <x-base.form-label for="shift-description">الوصف</x-base.form-label>
                                    <x-base.form-textarea id="shift-description" name="description" rows="3" placeholder="وصف الشيفتة..." class="w-full">{{ old('description', $shift->description) }}</x-base.form-textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Working Hours -->
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                                <x-base.lucide icon="Clock" class="h-5 w-5"></x-base.lucide>
                                أوقات العمل
                            </h4>
                            <div class="grid grid-cols-12 gap-4 gap-y-4">
                                <!-- Start Time -->
                                <div class="col-span-12 md:col-span-4">
                                    <x-base.form-label for="start-time">وقت البداية <span class="text-danger">*</span></x-base.form-label>
                                    <x-base.form-input id="start-time" name="start_time" type="time" class="w-full" value="{{ old('start_time', $shift->start_time) }}" required />
                                </div>

                                <!-- End Time -->
                                <div class="col-span-12 md:col-span-4">
                                    <x-base.form-label for="end-time">وقت النهاية <span class="text-danger">*</span></x-base.form-label>
                                    <x-base.form-input id="end-time" name="end_time" type="time" class="w-full" value="{{ old('end_time', $shift->end_time) }}" required />
                                </div>

                                <!-- Working Hours -->
                                <div class="col-span-12 md:col-span-4">
                                    <x-base.form-label for="working-hours">ساعات العمل <span class="text-danger">*</span></x-base.form-label>
                                    <x-base.form-input id="working-hours" name="working_hours" type="number" step="0.5" min="0" max="24" class="w-full" value="{{ old('working_hours', $shift->working_hours) }}" required />
                                </div>

                                <!-- Color -->
                                <div class="col-span-12 md:col-span-6">
                                    <x-base.form-label for="shift-color">لون الشيفتة <span class="text-danger">*</span></x-base.form-label>
                                    <div class="flex items-center gap-3">
                                        <x-base.form-input id="shift-color" name="color" type="color" value="{{ old('color', $shift->color) }}" class="w-16 h-10 border rounded" required />
                                        <small class="text-slate-500">اختر لوناً مميزاً للشيفتة</small>
                                    </div>
                                </div>

                                <!-- Active Status -->
                                <div class="col-span-12 md:col-span-6">
                                    <x-base.form-label for="is-active">الحالة</x-base.form-label>
                                    <div class="flex items-center">
                                        <input type="checkbox" id="is-active" name="is_active" value="1" {{ old('is_active', $shift->is_active) ? 'checked' : '' }} class="form-check-input">
                                        <label for="is-active" class="ml-2">نشط</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Break Time -->
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                                <x-base.lucide icon="Coffee" class="h-5 w-5"></x-base.lucide>
                                وقت الراحة
                            </h4>
                            <div class="grid grid-cols-12 gap-4 gap-y-4">
                                <!-- Break Start -->
                                <div class="col-span-12 md:col-span-4">
                                    <x-base.form-label for="break-start">بداية الراحة</x-base.form-label>
                                    <x-base.form-input id="break-start" name="break_start" type="time" class="w-full" value="{{ old('break_start', $shift->break_start) }}" />
                                </div>

                                <!-- Break End -->
                                <div class="col-span-12 md:col-span-4">
                                    <x-base.form-label for="break-end">نهاية الراحة</x-base.form-label>
                                    <x-base.form-input id="break-end" name="break_end" type="time" class="w-full" value="{{ old('break_end', $shift->break_end) }}" />
                                </div>

                                <!-- Break Hours -->
                                <div class="col-span-12 md:col-span-4">
                                    <x-base.form-label for="break-hours">ساعات الراحة</x-base.form-label>
                                    <x-base.form-input id="break-hours" name="break_hours" type="number" step="0.5" min="0" max="8" value="{{ old('break_hours', $shift->break_hours) }}" class="w-full" />
                                </div>
                            </div>
                        </div>

                        <!-- Work Days -->
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                                <x-base.lucide icon="Calendar" class="h-5 w-5"></x-base.lucide>
                                أيام العمل
                            </h4>
                            <div class="grid grid-cols-12 gap-4 gap-y-4">
                                <div class="col-span-12">
                                    <label class="flex items-center mb-3">
                                        <input type="checkbox" id="select-all-days" class="form-check-input">
                                        <span class="ml-2">جميع الأيام</span>
                                    </label>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                        @php
                                            $days = ['monday' => 'الاثنين', 'tuesday' => 'الثلاثاء', 'wednesday' => 'الأربعاء', 'thursday' => 'الخميس', 'friday' => 'الجمعة', 'saturday' => 'السبت', 'sunday' => 'الأحد'];
                                            $workDays = old('work_days', $shift->work_days ?? []);
                                        @endphp
                                        @foreach($days as $key => $label)
                                            <label class="flex items-center">
                                                <input type="checkbox" name="work_days[]" value="{{ $key }}" {{ in_array($key, $workDays) ? 'checked' : '' }} class="form-check-input work-day-checkbox">
                                                <span class="ml-2">{{ $label }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                    <small class="text-slate-500 mt-2 block">إذا لم تختر أي يوم، ستكون الشيفتة لجميع الأيام</small>
                                </div>
                            </div>
                        </div>

                        <!-- Applicability -->
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                                <x-base.lucide icon="Target" class="h-5 w-5"></x-base.lucide>
                                تطبيق الشيفتة على
                            </h4>
                            <div class="grid grid-cols-12 gap-4 gap-y-4">
                                <!-- Applicable To -->
                                <div class="col-span-12 md:col-span-4">
                                    <x-base.form-label for="applicable-to">التطبيق على <span class="text-danger">*</span></x-base.form-label>
                                    <x-base.form-select id="applicable-to" name="applicable_to" class="w-full" required>
                                        <option value="company" {{ old('applicable_to', $shift->applicable_to) == 'company' ? 'selected' : '' }}>الشركة كاملة</option>
                                        <option value="department" {{ old('applicable_to', $shift->applicable_to) == 'department' ? 'selected' : '' }}>قسم محدد</option>
                                        <option value="employee" {{ old('applicable_to', $shift->applicable_to) == 'employee' ? 'selected' : '' }}>موظف محدد</option>
                                    </x-base.form-select>
                                </div>

                                <!-- Company Selection -->
                                <div class="col-span-12 md:col-span-4" id="company-selection">
                                    <x-base.form-label for="company-id">الشركة <span class="text-danger">*</span></x-base.form-label>
                                    <x-base.form-select id="company-id" name="company_id" class="w-full" required>
                                        <option value="">اختر الشركة</option>
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}" {{ old('company_id', $shift->company_id) == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                                        @endforeach
                                    </x-base.form-select>
                                </div>

                                <!-- Department Selection -->
                                <div class="col-span-12 md:col-span-4" id="shift-department-selection" style="display: {{ old('applicable_to', $shift->applicable_to) == 'department' || old('applicable_to', $shift->applicable_to) == 'employee' ? 'block' : 'none' }};">
                                    <x-base.form-label for="department-id">القسم</x-base.form-label>
                                    <x-base.form-select id="department-id" name="department_id" class="w-full">
                                        <option value="">اختر القسم</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}" {{ old('department_id', $shift->department_id) == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                        @endforeach
                                    </x-base.form-select>
                                </div>

                                <!-- Employee Selection -->
                                <div class="col-span-12 md:col-span-4" id="shift-employee-selection" style="display: {{ old('applicable_to', $shift->applicable_to) == 'employee' ? 'block' : 'none' }};">
                                    <x-base.form-label for="employee-id">الموظف</x-base.form-label>
                                    <x-base.form-select id="employee-id" name="employee_id" class="w-full">
                                        <option value="">اختر الموظف</option>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}" {{ old('employee_id', $shift->employee_id) == $employee->id ? 'selected' : '' }}>{{ $employee->full_name }}</option>
                                        @endforeach
                                    </x-base.form-select>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end gap-2 pt-4 border-t">
                            <a href="{{ route('hr.shifts.index') }}" class="btn btn-outline-secondary">
                                <x-base.lucide icon="X" class="w-4 h-4 mr-2" />
                                إلغاء
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <x-base.lucide icon="Save" class="w-4 h-4 mr-2" />
                                حفظ التغييرات
                            </button>
                        </div>
                    </form>
                </div>
            </x-base.preview-component>
        </div>

        <!-- Statistics Sidebar -->
        <div class="intro-y col-span-12 lg:col-span-4">
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4">إحصائيات الشيفتة</h4>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between py-3 border-b border-slate-200 dark:border-darkmode-400">
                            <span class="text-slate-600 dark:text-slate-300">عدد الموظفين</span>
                            <span class="font-semibold">{{ $shift->attendances()->count() }}</span>
                        </div>

                        <div class="flex items-center justify-between py-3 border-b border-slate-200 dark:border-darkmode-400">
                            <span class="text-slate-600 dark:text-slate-300">أيام العمل</span>
                            <span class="font-semibold">{{ $shift->work_days_text }}</span>
                        </div>

                        <div class="flex items-center justify-between py-3 border-b border-slate-200 dark:border-darkmode-400">
                            <span class="text-slate-600 dark:text-slate-300">ساعات العمل</span>
                            <span class="font-semibold">{{ $shift->working_hours }} ساعة</span>
                        </div>

                        <div class="flex items-center justify-between py-3 border-b border-slate-200 dark:border-darkmode-400">
                            <span class="text-slate-600 dark:text-slate-300">وقت الراحة</span>
                            <span class="font-semibold">{{ $shift->break_hours ?? 0 }} ساعة</span>
                        </div>

                        <div class="flex items-center justify-between py-3">
                            <span class="text-slate-600 dark:text-slate-300">الحالة</span>
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $shift->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $shift->is_active ? 'نشط' : 'غير نشط' }}
                            </span>
                        </div>
                    </div>
                </div>
            </x-base.preview-component>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle applicable to changes
    document.getElementById('applicable-to').addEventListener('change', function() {
        const applicableTo = this.value;
        const companySelection = document.getElementById('company-selection');
        const departmentSelection = document.getElementById('shift-department-selection');
        const employeeSelection = document.getElementById('shift-employee-selection');
        const companyField = document.getElementById('company-id');
        const departmentField = document.getElementById('department-id');
        const employeeField = document.getElementById('employee-id');

        // Reset all
        companySelection.style.display = 'block';
        departmentSelection.style.display = 'none';
        employeeSelection.style.display = 'none';
        companyField.required = false;
        departmentField.required = false;
        employeeField.required = false;

        if (applicableTo === 'company') {
            companyField.required = true;
        } else if (applicableTo === 'department') {
            companySelection.style.display = 'block';
            departmentSelection.style.display = 'block';
            companyField.required = true;
            departmentField.required = true;

            // Load departments when company changes
            document.getElementById('company-id').addEventListener('change', function() {
                loadDepartments(this.value);
            });
        } else if (applicableTo === 'employee') {
            companySelection.style.display = 'block';
            departmentSelection.style.display = 'block';
            employeeSelection.style.display = 'block';
            companyField.required = true;
            departmentField.required = true;
            employeeField.required = true;

            // Load departments and employees
            document.getElementById('company-id').addEventListener('change', function() {
                loadDepartments(this.value);
            });
            document.getElementById('department-id').addEventListener('change', function() {
                loadEmployees(this.value);
            });
        }
    });

    // Select all days
    document.getElementById('select-all-days').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.work-day-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Handle form submission
    document.getElementById('edit-shift-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const data = Object.fromEntries(formData);

        // Validate work days
        const workDays = formData.getAll('work_days[]');
        if (workDays.length > 0) {
            data.work_days = workDays;
        }

        fetch('{{ route("hr.shifts.update", $shift) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast(data.message || 'تم تحديث الشيفتة بنجاح', 'success');
                setTimeout(() => {
                    window.location.href = '{{ route("hr.shifts.index") }}';
                }, 1000);
            } else {
                showToast(data.message || 'فشل في تحديث الشيفتة', 'error');
            }
        })
        .catch(error => {
            console.error('Error updating shift:', error);
            showToast('حدث خطأ أثناء التحديث', 'error');
        });
    });

    function loadDepartments(companyId) {
        fetch(`{{ route('hr.shifts.departments') }}?company_id=${companyId}`)
            .then(response => response.json())
            .then(data => {
                const departmentSelect = document.getElementById('department-id');
                departmentSelect.innerHTML = '<option value="">اختر القسم</option>';

                if (data.success) {
                    data.data.forEach(department => {
                        const option = document.createElement('option');
                        option.value = department.id;
                        option.textContent = department.name;
                        departmentSelect.appendChild(option);
                    });
                }
            })
            .catch(error => {
                console.error('Error loading departments:', error);
            });
    }

    function loadEmployees(departmentId) {
        fetch(`{{ route('hr.shifts.employees') }}?department_id=${departmentId}`)
            .then(response => response.json())
            .then(data => {
                const employeeSelect = document.getElementById('employee-id');
                employeeSelect.innerHTML = '<option value="">اختر الموظف</option>';

                if (data.success) {
                    data.data.forEach(employee => {
                        const option = document.createElement('option');
                        option.value = employee.id;
                        option.textContent = employee.full_name;
                        employeeSelect.appendChild(option);
                    });
                }
            })
            .catch(error => {
                console.error('Error loading employees:', error);
            });
    }

    // Initialize based on current applicable_to value
    const currentApplicableTo = '{{ $shift->applicable_to }}';
    if (currentApplicableTo === 'department' || currentApplicableTo === 'employee') {
        loadDepartments(document.getElementById('company-id').value);
        if (currentApplicableTo === 'employee') {
            loadEmployees(document.getElementById('department-id').value);
        }
    }
});
</script>
@endpush

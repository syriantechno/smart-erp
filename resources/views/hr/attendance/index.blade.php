@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>الحضور والغياب - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
@endpush

@section('subcontent')
    @include('components.global-notifications')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">📊 الحضور والغياب</h2>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <!-- Statistics Cards -->
        <div class="intro-y col-span-12">
            <div class="grid grid-cols-12 gap-6">
                <div class="col-span-12 sm:col-span-6 xl:col-span-3">
                    <x-base.preview-component class="intro-y box">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 mr-3">
                                    <x-base.lucide icon="Calendar" class="h-8 w-8 text-success" />
                                </div>
                                <div class="flex-grow">
                                    <h6 class="mb-1">إجمالي الأيام</h6>
                                    <h4 class="mb-0 font-bold" id="total-days">0</h4>
                                </div>
                            </div>
                        </div>
                    </x-base.preview-component>
                </div>
                <div class="col-span-12 sm:col-span-6 xl:col-span-3">
                    <x-base.preview-component class="intro-y box">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 mr-3">
                                    <x-base.lucide icon="UserCheck" class="h-8 w-8 text-primary" />
                                </div>
                                <div class="flex-grow">
                                    <h6 class="mb-1">الحضور</h6>
                                    <h4 class="mb-0 font-bold text-success" id="total-present">0</h4>
                                </div>
                            </div>
                        </div>
                    </x-base.preview-component>
                </div>
                <div class="col-span-12 sm:col-span-6 xl:col-span-3">
                    <x-base.preview-component class="intro-y box">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 mr-3">
                                    <x-base.lucide icon="UserX" class="h-8 w-8 text-danger" />
                                </div>
                                <div class="flex-grow">
                                    <h6 class="mb-1">الغياب</h6>
                                    <h4 class="mb-0 font-bold text-danger" id="total-absent">0</h4>
                                </div>
                            </div>
                        </div>
                    </x-base.preview-component>
                </div>
                <div class="col-span-12 sm:col-span-6 xl:col-span-3">
                    <x-base.preview-component class="intro-y box">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 mr-3">
                                    <x-base.lucide icon="Sun" class="h-8 w-8 text-info" />
                                </div>
                                <div class="flex-grow">
                                    <h6 class="mb-1">الإجازات</h6>
                                    <h4 class="mb-0 font-bold text-info" id="total-vacation">0</h4>
                                </div>
                            </div>
                        </div>
                    </x-base.preview-component>
                </div>
            </div>
        </div>

        <!-- Attendance Table -->
        <div class="intro-y col-span-12">
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    <div class="flex flex-col sm:flex-row sm:items-end xl:items-start justify-between mb-4">
                        <div class="flex items-center gap-2 mb-4 sm:mb-0">
                            <h5 class="font-semibold">جدول الحضور والغياب - {{ \Carbon\Carbon::create($year, $month)->locale('ar')->monthName }} {{ $year }}</h5>
                        </div>
                        <div class="flex gap-2">
                            <!-- Month/Year Selector -->
                            <div class="flex gap-2">
                                <select class="form-select w-20" id="year-select">
                                    @for($y = 2024; $y <= 2026; $y++)
                                        <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>
                                <select class="form-select w-24" id="month-select">
                                    @for($m = 1; $m <= 12; $m++)
                                        <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::create()->month($m)->locale('ar')->monthName }}
                                        </option>
                                    @endfor
                                </select>
                                <x-base.button variant="primary" size="sm" id="load-month-btn">
                                    <x-base.lucide icon="RefreshCw" class="w-4 h-4 mr-1" />
                                    تحديث
                                </x-base.button>
                            </div>
                            <x-base.button variant="primary" size="sm" id="add-attendance-btn">
                                <x-base.lucide icon="Plus" class="w-4 h-4 mr-1" />
                                إضافة حضور
                            </x-base.button>
                            <x-base.button variant="outline-primary" size="sm" id="export-btn">
                                <x-base.lucide icon="Download" class="w-4 h-4 mr-1" />
                                تصدير
                            </x-base.button>
                        </div>
                    </div>

                    <div class="overflow-x-auto xl:overflow-visible" data-erp-table-wrapper>
                        <table class="datatable-default w-full min-w-full table-auto text-left text-sm" id="attendance-table">
                            <thead>
                                <tr>
                                    <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center align-middle" style="min-width: 200px;">الموظف</th>
                                    @for($day = 1; $day <= 31; $day++)
                                        <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 text-center" style="width: 40px; font-size: 12px;">{{ $day }}</th>
                                    @endfor
                                </tr>
                                <tr>
                                    @for($day = 1; $day <= 31; $day++)
                                        <th class="px-5 py-3 border-b dark:border-darkmode-300 text-center p-1" style="font-size: 10px; width: 40px;">
                                            {{ \Carbon\Carbon::createFromDate($year, $month, $day)->locale('ar')->dayName }}
                                        </th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($employees as $employee)
                            <tr data-employee-id="{{ $employee->id }}">
                                <td class="font-medium text-slate-700 whitespace-nowrap px-5 py-3 border-b dark:border-darkmode-300">
                                    <div class="flex items-center">
                                        <div class="avatar avatar-sm mr-2">
                                            @if($employee->profile_picture_url)
                                                <img src="{{ $employee->profile_picture_url }}" alt="{{ $employee->full_name }}" class="rounded-full w-full h-full object-cover" style="width: 32px; height: 32px;">
                                            @else
                                                <span class="avatar-initial bg-primary rounded-full">{{ substr($employee->first_name, 0, 1) }}</span>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-bold">{{ $employee->full_name }}</div>
                                            <small class="text-slate-500">{{ $employee->position ?? 'غير محدد' }}</small>
                                        </div>
                                    </div>
                                </td>
                                @for($day = 1; $day <= 31; $day++)
                                    @php
                                        $date = \Carbon\Carbon::createFromDate($year, $month, $day)->format('Y-m-d');
                                        $attendanceKey = $employee->id . '_' . $date;
                                        $attendance = $attendances->get($attendanceKey);
                                        $isValidDate = \Carbon\Carbon::createFromDate($year, $month, $day)->isValid() &&
                                                      \Carbon\Carbon::createFromDate($year, $month, $day)->format('m') == $month;
                                    @endphp
                                    <td class="px-5 py-3 border-b dark:border-darkmode-300 text-center {{ !$isValidDate ? 'bg-slate-100 dark:bg-darkmode-600' : '' }}"
                                        data-date="{{ $date }}"
                                        data-employee-id="{{ $employee->id }}">
                                        @if($isValidDate)
                                            @php
                                                $statusSymbol = match($attendance?->status ?? '') {
                                                    'present' => '✓',
                                                    'absent' => '✗',
                                                    'vacation' => '🏖️',
                                                    'travel' => '✈️',
                                                    'half_day' => '½',
                                                    'holiday' => '🎉',
                                                    default => ''
                                                };
                                                $statusColor = match($attendance?->status ?? '') {
                                                    'present' => 'text-success',
                                                    'absent' => 'text-danger',
                                                    'vacation' => 'text-info',
                                                    'travel' => 'text-warning',
                                                    'half_day' => 'text-secondary',
                                                    'holiday' => 'text-primary',
                                                    default => 'text-slate-400'
                                                };
                                            @endphp
                                            <span class="attendance-status-display {{ $statusColor }} font-semibold cursor-pointer relative"
                                                  data-employee-id="{{ $employee->id }}"
                                                  data-date="{{ $date }}"
                                                  data-status="{{ $attendance?->status ?? '' }}"
                                                  title="{{ $attendance?->status ? __('attendance.' . $attendance->status) : '' }}">
                                                {{ $statusSymbol }}
                                                @if($attendance && $attendance->status === 'absent')
                                                    <span class="absolute -top-1 -right-1 text-xs text-red-500 font-bold">✕</span>
                                                @endif
                                            </span>
                                        @else
                                            <span class="text-slate-400">-</span>
                                        @endif
                                    </td>
                                @endfor
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </x-base.preview-component>
        </div>
    </div>

    <!-- Attendance Entry Modal -->
    <x-modal.form id="attendanceEntryModal" title="إضافة حضور" size="lg" style="z-index: 99999 !important;">
        <form id="attendance-form" action="{{ route('hr.attendance.store') }}" method="POST">
            @csrf

            <!-- Entry Type Section -->
            <div class="mb-6">
                <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                    <x-base.lucide icon="Settings" class="h-5 w-5"></x-base.lucide>
                    نوع الإدخال
                </h4>
                <div class="grid grid-cols-12 gap-4 gap-y-4">
                    <div class="col-span-12">
                        <div class="flex gap-6">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="entry_type" value="individual" checked class="form-check-input">
                                <span class="ml-3 text-slate-700 dark:text-slate-300">فردي</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="entry_type" value="department" class="form-check-input">
                                <span class="ml-3 text-slate-700 dark:text-slate-300">للقسم كاملاً</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Selection Section -->
            <div class="mb-6">
                <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                    <x-base.lucide icon="Users" class="h-5 w-5"></x-base.lucide>
                    الاختيار
                </h4>
                <div class="grid grid-cols-12 gap-4 gap-y-4">
                    <!-- Employee Selection (for individual) -->
                    <div class="col-span-12" id="employee-selection">
                        <x-base.form-label for="employee_id">الموظف <span class="text-danger">*</span></x-base.form-label>
                        <x-base.form-select id="employee_id" name="employee_id" class="w-full" required>
                            <option value="">اختر الموظف</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->full_name }} - {{ $employee->position ?? 'غير محدد' }}</option>
                            @endforeach
                        </x-base.form-select>
                    </div>

                    <!-- Department Selection (for department) -->
                    <div class="col-span-12" id="department-selection" style="display: none;">
                        <x-base.form-label for="department_id">القسم <span class="text-danger">*</span></x-base.form-label>
                        <x-base.form-select id="department_id" name="department_id" class="w-full">
                            <option value="">اختر القسم</option>
                            @foreach($employees->pluck('department')->unique() as $department)
                                @if($department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endif
                            @endforeach
                        </x-base.form-select>
                    </div>
                </div>
            </div>

            <!-- Attendance Details Section -->
            <div class="mb-6">
                <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                    <x-base.lucide icon="Calendar" class="h-5 w-5"></x-base.lucide>
                    تفاصيل الحضور
                </h4>
                <div class="grid grid-cols-12 gap-4 gap-y-4">
                    <!-- Date -->
                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="attendance_date">التاريخ <span class="text-danger">*</span></x-base.form-label>
                        <x-base.form-input id="attendance_date" name="attendance_date" type="date" class="w-full" required />
                    </div>

                    <!-- Status -->
                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="status">الحالة <span class="text-danger">*</span></x-base.form-label>
                        <x-base.form-select id="status" name="status" class="w-full" required>
                            <option value="present">حاضر</option>
                            <option value="absent">غائب</option>
                            <option value="vacation">إجازة</option>
                            <option value="travel">سفر</option>
                            <option value="half_day">نصف يوم</option>
                            <option value="holiday">عطلة</option>
                        </x-base.form-select>
                    </div>

                    <!-- Check In Time -->
                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="check_in">وقت الدخول</x-base.form-label>
                        <x-base.form-input id="check_in" name="check_in" type="time" class="w-full" />
                    </div>

                    <!-- Check Out Time -->
                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="check_out">وقت الخروج</x-base.form-label>
                        <x-base.form-input id="check_out" name="check_out" type="time" class="w-full" />
                    </div>
                </div>
            </div>

            <!-- Notes Section -->
            <div class="mb-6">
                <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                    <x-base.lucide icon="FileText" class="h-5 w-5"></x-base.lucide>
                    ملاحظات
                </h4>
                <div class="grid grid-cols-12 gap-4 gap-y-4">
                    <div class="col-span-12">
                        <x-base.form-textarea id="notes" name="notes" rows="3" placeholder="أضف ملاحظات إضافية..." class="w-full"></x-base.form-textarea>
                    </div>
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
                    إلغاء
                </x-base.button>
                <x-base.button
                    class="w-32"
                    type="submit"
                    form="attendance-form"
                    variant="primary"
                    id="save-attendance-btn"
                >
                    <x-base.lucide icon="Save" class="w-4 h-4 mr-2" />
                    حفظ
                </x-base.button>
            </div>
        @endslot
    </x-modal.form>

    <!-- Status Legend Modal -->
    <x-modal.form id="statusLegendModal" title="دليل الحالات" size="sm" style="z-index: 99999 !important;">
        <div class="grid grid-cols-2 gap-3">
            <div class="flex items-center mb-2">
                <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-semibold bg-success text-white mr-2">✓</span>
                <small>حاضر</small>
            </div>
            <div class="flex items-center mb-2">
                <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-semibold bg-danger text-white mr-2">✗</span>
                <small>غائب</small>
            </div>
            <div class="flex items-center mb-2">
                <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-semibold bg-info text-white mr-2">🏖️</span>
                <small>إجازة</small>
            </div>
            <div class="flex items-center mb-2">
                <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-semibold bg-warning text-white mr-2">✈️</span>
                <small>سفر</small>
            </div>
            <div class="flex items-center mb-2">
                <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-semibold bg-secondary text-white mr-2">½</span>
                <small>نصف يوم</small>
            </div>
            <div class="flex items-center mb-2">
                <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-semibold bg-primary text-white mr-2">🎉</span>
                <small>عطلة</small>
            </div>
        </div>

        @slot('footer')
            <div class="flex justify-end w-full">
                <x-base.button
                    variant="secondary"
                    size="sm"
                    data-tw-dismiss="modal"
                >
                    إغلاق
                </x-base.button>
            </div>
        @endslot
    </x-modal.form>
@endsection

@push('styles')
<style>
/* Force modal to appear above all elements */
#attendanceEntryModal,
#statusLegendModal {
    z-index: 99999 !important;
    position: fixed !important;
}

.modal-backdrop {
    z-index: 99998 !important;
}

/* Ensure modal content is above everything */
#attendanceEntryModal .modal-content,
#statusLegendModal .modal-content {
    z-index: 100000 !important;
    position: relative !important;
}

/* Force modal overlay to be on top */
.modal.show {
    z-index: 99999 !important;
}
</style>
@endpush

@include('components.datatable.scripts')

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    try {
        console.log('🚀 تحميل صفحة الحضور...');

        // Attendance status display click handler
        document.querySelectorAll('.attendance-status-display').forEach(span => {
            span.addEventListener('click', function() {
                const employeeId = this.dataset.employeeId;
                const date = this.dataset.date;
                const status = this.dataset.status;

                // Open modal for editing
                openAttendanceModal(employeeId, date, status);
            });
        });

        // Month/Year change handler
        const loadMonthBtn = document.getElementById('load-month-btn');
        if (loadMonthBtn) {
            loadMonthBtn.addEventListener('click', function() {
                const year = document.getElementById('year-select')?.value;
                const month = document.getElementById('month-select')?.value;
                if (year && month) {
                    window.location.href = `{{ route('hr.attendance.index') }}?year=${year}&month=${month}`;
                }
            });
        }

        // Add attendance button handler
        const addAttendanceBtn = document.getElementById('add-attendance-btn');
        if (addAttendanceBtn) {
            addAttendanceBtn.addEventListener('click', function() {
                openAttendanceModal();
            });
        }

        // Handle form submission
        const attendanceForm = document.getElementById('attendance-form');
        if (attendanceForm) {
            attendanceForm.addEventListener('submit', function(e) {
                e.preventDefault();
                saveAttendance();
            });
        }

        // Entry type change handler
        document.querySelectorAll('input[name="entry_type"]').forEach(radio => {
            radio.addEventListener('change', function() {
                toggleEntryType(this.value);
            });
        });

        // Export handler
        const exportBtn = document.getElementById('export-btn');
        if (exportBtn) {
            exportBtn.addEventListener('click', function() {
                const year = document.getElementById('year-select')?.value;
                const month = document.getElementById('month-select')?.value;

                if (!year || !month) {
                    showToast('يرجى اختيار السنة والشهر', 'error');
                    return;
                }

                // Create CSV content
                let csv = 'الموظف,';
                for (let day = 1; day <= 31; day++) {
                    csv += day + ',';
                }
                csv += '\n';

                document.querySelectorAll('#attendance-table tbody tr').forEach(row => {
                    const employeeName = row.querySelector('td:first-child .fw-bold')?.textContent?.trim() || '';
                    csv += '"' + employeeName + '",';

                    row.querySelectorAll('td:not(:first-child)').forEach(cell => {
                        const span = cell.querySelector('.attendance-status-display');
                        if (span) {
                            const status = span.dataset.status;
                            const statusMap = {
                                'present': 'حاضر',
                                'absent': 'غائب',
                                'vacation': 'إجازة',
                                'travel': 'سفر',
                                'half_day': 'نصف يوم',
                                'holiday': 'عطلة'
                            };
                            csv += '"' + (statusMap[status] || '') + '",';
                        } else {
                            csv += '"-",';
                        }
                    });
                    csv += '\n';
                });

                // Download CSV
                const blob = new Blob(['\ufeff' + csv], { type: 'text/csv;charset=utf-8;' });
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = `attendance_${year}_${month}.csv`;
                link.click();
                URL.revokeObjectURL(link);

                showToast('تم تصدير البيانات بنجاح', 'success');
            });
        }

        console.log('✅ تم تحميل جميع مكونات صفحة الحضور بنجاح');

    } catch (error) {
        console.error('❌ خطأ في تحميل صفحة الحضور:', error);
    }
});

    function openAttendanceModal(employeeId = null, date = null, status = null) {
        console.log('🚀 بدء فتح مودال الحضور...');
        console.log('المعاملات المرسلة:', { employeeId, date, status });

        const modal = document.getElementById('attendanceEntryModal');
        const form = document.getElementById('attendance-form');

        if (!modal) {
            console.error('❌ لم يتم العثور على عنصر المودال في الصفحة!');
            console.log('العناصر الموجودة في الصفحة:', document.querySelectorAll('[id*="modal"]').length);
            return;
        }
        console.log('✅ تم العثور على عنصر المودال بنجاح');

        // Reset form and set defaults
        if (form) {
            form.reset();
            // Ensure individual entry type is selected by default
            const individualRadio = form.querySelector('input[name="entry_type"][value="individual"]');
            if (individualRadio) {
                individualRadio.checked = true;
                // Trigger the toggle to show correct fields
                toggleEntryType('individual');
            }
            console.log('✅ تم إعادة تعيين النموذج وتعيين الإعدادات الافتراضية');
        } else {
            console.warn('⚠️ لم يتم العثور على النموذج');
        }

        // Set default date to today if not provided
        if (form && form.attendance_date) {
            if (!date) {
                const today = new Date().toISOString().split('T')[0];
                form.attendance_date.value = today;
                console.log('📅 تعيين التاريخ الافتراضي:', today);
            } else {
                form.attendance_date.value = date;
                console.log('📅 تعيين التاريخ المحدد:', date);
            }
        }

        // If editing existing attendance
        if (employeeId && date && form) {
            if (form.employee_id) {
                form.employee_id.value = employeeId;
                console.log('👤 تعيين رقم الموظف:', employeeId);
            }
            if (form.status) {
                form.status.value = status || 'present';
                console.log('📊 تعيين حالة الحضور:', status || 'present');
            }
        }

        // Show modal using proper methods
        console.log('🎯 محاولة فتح المودال...');
        console.log('window.twModal موجود:', typeof window.twModal);
        console.log('window.twModal.show موجود:', typeof window.twModal?.show);

        if (typeof window.twModal !== 'undefined' && typeof window.twModal.show === 'function') {
            console.log('🎯 استخدام twModal API');
            try {
                // Reduce z-index of other elements
                const mainContent = document.querySelector('.intro-y');
                if (mainContent) {
                    mainContent.style.zIndex = '1';
                }

                window.twModal.show(modal);
                // Force high z-index
                modal.style.zIndex = '99999';
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.style.zIndex = '99998';
                }
                console.log('✅ تم فتح المودال باستخدام twModal');
            } catch (error) {
                console.error('❌ خطأ في فتح المودال باستخدام twModal:', error);
            }
        } else {
            console.log('🔧 استخدام الطريقة اليدوية لفتح المودال');

            // Reduce z-index of other elements
            const mainContent = document.querySelector('.intro-y');
            if (mainContent) {
                mainContent.style.zIndex = '1';
            }

            // Force show modal
            modal.style.display = 'block';
            modal.classList.add('show');
            modal.setAttribute('aria-hidden', 'false');
            modal.style.zIndex = '99999'; // Force high z-index
            document.body.classList.add('modal-open');

            // Add backdrop manually
            let backdrop = document.querySelector('.modal-backdrop');
            if (!backdrop) {
                backdrop = document.createElement('div');
                backdrop.className = 'modal-backdrop fade show';
                backdrop.style.zIndex = '99998'; // Just below modal
                document.body.appendChild(backdrop);
                console.log('✅ تمت إضافة خلفية المودال يدوياً');
            }

            // Force focus to modal
            setTimeout(() => {
                modal.focus();
                console.log('✅ تم التركيز على المودال');
            }, 100);
        }
    }

    function toggleEntryType(type) {
        console.log('🔄 بدء تبديل نوع الإدخال إلى:', type);

        const employeeSelection = document.getElementById('employee-selection');
        const departmentSelection = document.getElementById('department-selection');
        const employeeField = document.querySelector('[name="employee_id"]');
        const departmentField = document.querySelector('[name="department_id"]');

        console.log('العناصر الموجودة:', {
            employeeSelection: !!employeeSelection,
            departmentSelection: !!departmentSelection,
            employeeField: !!employeeField,
            departmentField: !!departmentField
        });

        if (type === 'individual') {
            // Show employee selection, hide department selection
            if (employeeSelection) {
                employeeSelection.style.display = 'block';
            }
            if (departmentSelection) {
                departmentSelection.style.display = 'none';
            }

            // Make employee field required and remove required from department field
            if (employeeField) {
                employeeField.required = true;
                employeeField.style.display = 'block';
                console.log('✅ تم تفعيل حقل الموظف');
            }
            if (departmentField) {
                departmentField.required = false;
                departmentField.style.display = 'none';
                console.log('✅ تم إلغاء تفعيل حقل القسم');
            }

            console.log('🔄 تم تبديل إلى الإدخال الفردي بنجاح');
        } else {
            // Show department selection, hide employee selection
            if (employeeSelection) {
                employeeSelection.style.display = 'none';
            }
            if (departmentSelection) {
                departmentSelection.style.display = 'block';
            }

            // Make department field required and remove required from employee field
            if (departmentField) {
                departmentField.required = true;
                departmentField.style.display = 'block';
                console.log('✅ تم تفعيل حقل القسم');
            }
            if (employeeField) {
                employeeField.required = false;
                employeeField.style.display = 'none';
                console.log('✅ تم إلغاء تفعيل حقل الموظف');
            }

            console.log('🔄 تم تبديل إلى الإدخال القسمي بنجاح');
        }
    }

    function saveAttendance() {
        const form = document.getElementById('attendance-form');
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);

        console.log('📤 البيانات المرسلة:', data);
        console.log('📊 تفاصيل البيانات:');
        console.log('- entry_type:', data.entry_type);
        console.log('- employee_id:', data.employee_id);
        console.log('- department_id:', data.department_id);
        console.log('- attendance_date:', data.attendance_date);
        console.log('- status:', data.status);

        // Validate based on entry type
        if (data.entry_type === 'individual') {
            console.log('🔍 التحقق من الإدخال الفردي...');
            if (!data.employee_id || data.employee_id.trim() === '') {
                console.error('❌ خطأ: لم يتم اختيار الموظف');
                showToast('يرجى اختيار الموظف', 'error');
                return;
            }
            console.log('✅ تم اختيار الموظف:', data.employee_id);
        } else if (data.entry_type === 'department') {
            console.log('🔍 التحقق من الإدخال القسمي...');
            if (!data.department_id || data.department_id.trim() === '') {
                console.error('❌ خطأ: لم يتم اختيار القسم');
                showToast('يرجى اختيار القسم', 'error');
                return;
            }
            console.log('✅ تم اختيار القسم:', data.department_id);
        } else {
            console.error('❌ خطأ: نوع الإدخال غير محدد:', data.entry_type);
            showToast('يرجى اختيار نوع الإدخال', 'error');
            return;
        }

        console.log('🚀 بدء إرسال البيانات إلى الخادم...');

        // Additional validation before sending
        if (!data.attendance_date || data.attendance_date.trim() === '') {
            console.error('❌ خطأ: التاريخ مطلوب');
            showToast('يرجى اختيار التاريخ', 'error');
            return;
        }

        if (!data.status || data.status.trim() === '') {
            console.error('❌ خطأ: الحالة مطلوبة');
            showToast('يرجى اختيار الحالة', 'error');
            return;
        }

        // Ensure CSRF token is available
        const csrfToken = '{{ csrf_token() }}';
        if (!csrfToken) {
            console.error('❌ خطأ: رمز CSRF غير متوفر');
            showToast('حدث خطأ في الأمان، يرجى إعادة تحميل الصفحة', 'error');
            return;
        }

        console.log('✅ تم التحقق من صحة البيانات، جاري الإرسال...');

        fetch('{{ route('hr.attendance.store') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            console.log('📡 استجابة الخادم:', response.status, response.statusText);
            return response.json();
        })
        .then(data => {
            console.log('📨 بيانات الاستجابة:', data);
            if (data.success) {
                console.log('✅ تم حفظ البيانات بنجاح');
                showToast(data.message || 'تم حفظ الحضور بنجاح', 'success');
                // Close modal using tw-starter API
                const modal = document.getElementById('attendanceEntryModal');
                if (window.twModal) {
                    window.twModal.hide(modal);
                } else {
                    // Fallback
                    modal.classList.remove('show');
                    modal.style.display = 'none';
                    document.body.classList.remove('modal-open');
                }
                // Reload page to refresh data
                setTimeout(() => location.reload(), 1000);
            } else {
                console.error('❌ فشل في حفظ البيانات:', data);
                showToast(data.message || 'فشل في حفظ الحضور', 'error');
                if (data.errors) {
                    console.error('تفاصيل الأخطاء:', data.errors);
                }
            }
        })
        .catch(error => {
            console.error('💥 خطأ في الشبكة:', error);
            showToast('حدث خطأ أثناء الحفظ', 'error');
        });
    }

    // Remove statistics functions since columns are removed
    // updateEmployeeStats and updateGlobalStats are no longer needed
</script>
@endpush

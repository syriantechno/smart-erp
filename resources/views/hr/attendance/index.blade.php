@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Attendance - {{ config('app.name') }}</title>
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
        <h2 class="mr-auto text-lg font-medium">📊 Attendance</h2>
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
                                    <h6 class="mb-1">Total Days</h6>
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
                                    <h6 class="mb-1">Present</h6>
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
                                    <h6 class="mb-1">Absent</h6>
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
                                    <h6 class="mb-1">Vacation</h6>
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
                            <h5 class="font-semibold">Attendance Table - {{ \Carbon\Carbon::create($year, $month)->locale('ar')->monthName }} {{ $year }}</h5>
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
                                    Refresh
                                </x-base.button>
                            </div>
                            <x-base.button variant="primary" size="sm" id="add-attendance-btn">
                                <x-base.lucide icon="Plus" class="w-4 h-4 mr-1" />
                                Add Attendance
                            </x-base.button>
                            <x-base.button variant="outline-primary" size="sm" id="export-btn">
                                <x-base.lucide icon="Download" class="w-4 h-4 mr-1" />
                                Export
                            </x-base.button>
                        </div>
                    </div>

                    <div class="mt-4 flex flex-wrap items-center gap-4 text-xs bg-slate-800 text-slate-100 dark:bg-slate-800 dark:text-slate-100 rounded-lg px-4 py-3">
                        <div class="flex items-center gap-2">
                            <span class="text-base">✓</span>
                            <span>Present (Full Day)</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-base">✗</span>
                            <span>Absent</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-base">🏖️</span>
                            <span>Vacation</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-base">✈️</span>
                            <span>Travel</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-base">½</span>
                            <span>Half Day</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-base">🎉</span>
                            <span>Weekend & Holidays</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-base">❌</span>
                            <span>Not Recorded</span>
                        </div>
                    </div>

                    <div class="mt-4 overflow-x-auto" data-erp-table-wrapper>
                        <table class="datatable-default w-full min-w-full table-auto text-left text-sm" id="attendance-table">
                            <thead>
                                <tr>
                                    <th class="font-medium px-3 py-12 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center align-middle" style="min-width: 200px;">Employee</th>
                                    @for($day = 1; $day <= 31; $day++)
                                        <th class="font-medium px-2 py-3 border-b-2 dark:border-darkmode-300 text-center" style="width: 24px; font-size: 13px;">{{ $day }}</th>
                                    @endfor
                                </tr>
                                <tr>
                                    @for($day = 1; $day <= 31; $day++)
                                        <th class="px-2 py-3 border-b dark:border-darkmode-300 text-center p-0.5" style="font-size: 12px; width: 24px;">
                                            {{ \Carbon\Carbon::createFromDate($year, $month, $day)->format('D') }}
                                        </th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($employees as $employee)
                            <tr data-employee-id="{{ $employee->id }}">
                                <td class="font-medium text-slate-700 whitespace-nowrap px-3 py-4 border-b dark:border-darkmode-300">
                                    <div class="flex items-center">
                                        <div class="avatar avatar-sm mr-2">
                                            @if($employee->profile_picture_url)
                                                <img src="{{ $employee->profile_picture_url }}" alt="{{ $employee->full_name }}" class="rounded-full w-full h-full object-cover" style="width: 28px; height: 28px;">
                                            @else
                                                <span class="avatar-initial bg-primary rounded-full text-xs">{{ substr($employee->first_name, 0, 1) }}</span>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-bold text-xs">{{ $employee->full_name }}</div>
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
                                    <td class="px-2 py-2 border-b dark:border-darkmode-300 text-center {{ !$isValidDate ? 'bg-slate-100 dark:bg-darkmode-600' : '' }}"
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
                                                    default => '❌'
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
                                            <span class="attendance-status-display {{ $statusColor }} font-semibold cursor-pointer text-center block"
                                                  data-employee-id="{{ $employee->id }}"
                                                  data-date="{{ $date }}"
                                                  data-status="{{ $attendance?->status ?? '' }}"
                                                  title="{{ $attendance?->status ? __('attendance.' . $attendance->status) : 'Not Recorded' }}">
                                                {{ $statusSymbol }}
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
    <x-modal.form id="attendanceEntryModal" title="Add Attendance" size="lg" style="z-index: 99999 !important;">
        <form id="attendance-form" action="{{ route('hr.attendance.store') }}" method="POST">
            @csrf

            <!-- Entry Type Section -->
            <div class="mb-6">
                <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                    <x-base.lucide icon="Settings" class="h-5 w-5"></x-base.lucide>
                    Entry Type
                </h4>
                <div class="grid grid-cols-12 gap-4 gap-y-4">
                    <div class="col-span-12">
                        <div class="flex gap-6">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="entry_type" value="individual" checked class="form-check-input">
                                <span class="ml-3 text-slate-700 dark:text-slate-300">Individual</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="entry_type" value="department" class="form-check-input">
                                <span class="ml-3 text-slate-700 dark:text-slate-300">For Entire Department</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Selection Section -->
            <div class="mb-6">
                <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                    <x-base.lucide icon="Users" class="h-5 w-5"></x-base.lucide>
                    Selection
                </h4>
                <div class="grid grid-cols-12 gap-4 gap-y-4">
                    <!-- Employee Selection (for individual) -->
                    <div class="col-span-12" id="employee-selection">
                        <x-base.form-label for="employee_id">Employee <span class="text-danger">*</span></x-base.form-label>
                        <x-base.form-select id="employee_id" name="employee_id" class="w-full" required>
                            <option value="">Select Employee</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->full_name }} - {{ $employee->position ?? 'Not Specified' }}</option>
                            @endforeach
                        </x-base.form-select>
                    </div>

                    <!-- Department Selection (for department) -->
                    <div class="col-span-12" id="department-selection" style="display: none;">
                        <x-base.form-label for="department_id">Department <span class="text-danger">*</span></x-base.form-label>
                        <x-base.form-select id="department_id" name="department_id" class="w-full">
                            <option value="">Select Department</option>
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
                    Attendance Details
                </h4>
                <div class="grid grid-cols-12 gap-4 gap-y-4">
                    <!-- Date -->
                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="attendance_date">Date <span class="text-danger">*</span></x-base.form-label>
                        <x-base.form-input id="attendance_date" name="attendance_date" type="date" class="w-full" required />
                    </div>

                    <!-- Status -->
                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="status">Status <span class="text-danger">*</span></x-base.form-label>
                        <x-base.form-select id="status" name="status" class="w-full" required>
                            <option value="present">Present</option>
                            <option value="absent">Absent</option>
                            <option value="vacation">Vacation</option>
                            <option value="travel">Travel</option>
                            <option value="half_day">Half Day</option>
                            <option value="holiday">Holiday</option>
                        </x-base.form-select>
                    </div>

                    <!-- Check In Time -->
                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="check_in">Check In Time</x-base.form-label>
                        <x-base.form-input id="check_in" name="check_in" type="time" class="w-full" />
                    </div>

                    <!-- Check Out Time -->
                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="check_out">Check Out Time</x-base.form-label>
                        <x-base.form-input id="check_out" name="check_out" type="time" class="w-full" />
                    </div>
                </div>
            </div>

            <!-- Notes Section -->
            <div class="mb-6">
                <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                    <x-base.lucide icon="FileText" class="h-5 w-5"></x-base.lucide>
                    Notes
                </h4>
                <div class="grid grid-cols-12 gap-4 gap-y-4">
                    <div class="col-span-12">
                        <x-base.form-textarea id="notes" name="notes" rows="3" placeholder="Add additional notes..." class="w-full"></x-base.form-textarea>
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
                    Cancel
                </x-base.button>
                <x-base.button
                    class="w-32"
                    type="submit"
                    form="attendance-form"
                    variant="primary"
                    id="save-attendance-btn"
                >
                    <x-base.lucide icon="Save" class="w-4 h-4 mr-2" />
                    Save
                </x-base.button>
            </div>
        @endslot
    </x-modal.form>

    <!-- Status Legend Modal -->
    <x-modal.form id="statusLegendModal" title="Status Legend" size="sm" style="z-index: 99999 !important;">
        <div class="grid grid-cols-2 gap-3">
            <div class="flex items-center mb-2">
                <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-semibold bg-success text-white mr-2">✓</span>
                <small>Present</small>
            </div>
            <div class="flex items-center mb-2">
                <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-semibold bg-danger text-white mr-2">✗</span>
                <small>Absent</small>
            </div>
            <div class="flex items-center mb-2">
                <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-semibold bg-info text-white mr-2">🏖️</span>
                <small>Vacation</small>
            </div>
            <div class="flex items-center mb-2">
                <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-semibold bg-warning text-white mr-2">✈️</span>
                <small>Travel</small>
            </div>
            <div class="flex items-center mb-2">
                <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-semibold bg-secondary text-white mr-2">½</span>
                <small>Half Day</small>
            </div>
            <div class="flex items-center mb-2">
                <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-semibold bg-primary text-white mr-2">🎉</span>
                <small>Holiday</small>
            </div>
            <div class="flex items-center mb-2">
                <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-semibold bg-slate-100 text-slate-400 mr-2">❌</span>
                <small>Not Recorded</small>
        </div>

        @slot('footer')
            <div class="flex justify-end w-full">
                <x-base.button
                    variant="secondary"
                    size="sm"
                    data-tw-dismiss="modal"
                >
                    Close
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

/* Ultra-compact table styling */
#attendance-table {
    line-height: 2.5 !important;
}

#attendance-table th,
#attendance-table td {
    line-height: 2.2 !important;
    margin: 0 !important;
    padding-top: 0 !important;
    padding-bottom: 0 !important;
}

#attendance-table .avatar {
    margin: 0 !important;
    margin-right: 0.5rem !important; /* 8px */
}

#attendance-table .font-bold {
    margin: 0 !important;
    line-height: 2.8 !important;
}
</style>
@endpush

@include('components.datatable.scripts')

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    try {
        console.log('🚀 Loading attendance page...');

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
                    showToast('Please select year and month', 'error');
                    return;
                }

                // Create CSV content
                let csv = 'Employee,';
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
                                'present': 'Present',
                                'absent': 'Absent',
                                'vacation': 'Vacation',
                                'travel': 'Travel',
                                'half_day': 'Half Day',
                                'holiday': 'Holiday',
                                '': 'Not Recorded'
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

                showToast('Data exported successfully', 'success');
            });
        }

        console.log('✅ All attendance page components loaded successfully');

    } catch (error) {
        console.error('❌ Error loading attendance page:', error);
    }
});

    function openAttendanceModal(employeeId = null, date = null, status = null) {
        console.log('🚀 Starting to open attendance modal...');
        console.log('Parameters received:', { employeeId, date, status });

        const modal = document.getElementById('attendanceEntryModal');
        const form = document.getElementById('attendance-form');

        if (!modal) {
            console.error('❌ Modal element not found on the page!');
            console.log('Available elements:', document.querySelectorAll('[id*="modal"]').length);
            return;
        }
        console.log('✅ Modal element found successfully');

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
            console.log('✅ Form reset and default settings applied');
        } else {
            console.warn('⚠️ Form not found');
        }

        // Set default date to today if not provided
        if (form && form.attendance_date) {
            if (!date) {
                const today = new Date().toISOString().split('T')[0];
                form.attendance_date.value = today;
                console.log('📅 Setting default date:', today);
            } else {
                form.attendance_date.value = date;
                console.log('📅 Setting specified date:', date);
            }
        }

        // If editing existing attendance
        if (employeeId && date && form) {
            if (form.employee_id) {
                form.employee_id.value = employeeId;
                console.log('👤 Setting employee ID:', employeeId);
            }
            if (form.status) {
                form.status.value = status || 'present';
                console.log('📊 Setting attendance status:', status || 'present');
            }
        }

        // Show modal using proper methods
        console.log('🎯 Attempting to open modal...');
        console.log('window.twModal available:', typeof window.twModal);
        console.log('window.twModal.show available:', typeof window.twModal?.show);

        if (typeof window.twModal !== 'undefined' && typeof window.twModal.show === 'function') {
            console.log('🎯 Using twModal API');
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
                console.log('✅ Modal opened using twModal');
            } catch (error) {
                console.error('❌ Error opening modal with twModal:', error);
            }
        } else {
            console.log('🔧 Using manual method to open modal');

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
                console.log('✅ Modal backdrop added manually');
            }

            // Force focus to modal
            setTimeout(() => {
                modal.focus();
                console.log('✅ Modal focused');
            }, 100);
        }
    }

    function toggleEntryType(type) {
        console.log('🔄 Starting to toggle entry type to:', type);

        const employeeSelection = document.getElementById('employee-selection');
        const departmentSelection = document.getElementById('department-selection');
        const employeeField = document.querySelector('[name="employee_id"]');
        const departmentField = document.querySelector('[name="department_id"]');

        console.log('Available elements:', {
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
                console.log('✅ Employee field activated');
            }
            if (departmentField) {
                departmentField.required = false;
                departmentField.style.display = 'none';
                console.log('✅ Department field deactivated');
            }

            console.log('🔄 Successfully switched to individual entry');
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
                console.log('✅ Department field activated');
            }
            if (employeeField) {
                employeeField.required = false;
                employeeField.style.display = 'none';
                console.log('✅ Employee field deactivated');
            }

            console.log('🔄 Successfully switched to department entry');
        }
    }

    function saveAttendance() {
        const form = document.getElementById('attendance-form');
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);

        console.log('📤 Data being sent:', data);
        console.log('📊 Data details:');
        console.log('- entry_type:', data.entry_type);
        console.log('- employee_id:', data.employee_id);
        console.log('- department_id:', data.department_id);
        console.log('- attendance_date:', data.attendance_date);
        console.log('- status:', data.status);

        // Validate based on entry type
        if (data.entry_type === 'individual') {
            console.log('🔍 Validating individual entry...');
            if (!data.employee_id || data.employee_id.trim() === '') {
                console.error('❌ Error: Employee not selected');
                showToast('Please select an employee', 'error');
                return;
            }
            console.log('✅ Employee selected:', data.employee_id);
        } else if (data.entry_type === 'department') {
            console.log('🔍 Validating department entry...');
            if (!data.department_id || data.department_id.trim() === '') {
                console.error('❌ Error: Department not selected');
                showToast('Please select a department', 'error');
                return;
            }
            console.log('✅ Department selected:', data.department_id);
        } else {
            console.error('❌ Error: Entry type not defined:', data.entry_type);
            showToast('Please select entry type', 'error');
            return;
        }

        console.log('🚀 Starting to send data to server...');

        // Additional validation before sending
        if (!data.attendance_date || data.attendance_date.trim() === '') {
            console.error('❌ Error: Date is required');
            showToast('Please select a date', 'error');
            return;
        }

        if (!data.status || data.status.trim() === '') {
            console.error('❌ Error: Status is required');
            showToast('Please select a status', 'error');
            return;
        }

        // Ensure CSRF token is available
        const csrfToken = '{{ csrf_token() }}';
        if (!csrfToken) {
            console.error('❌ Error: CSRF token not available');
            showToast('Security error occurred, please reload the page', 'error');
            return;
        }

        console.log('✅ Data validation completed, sending...');

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
            console.log('📡 Server response:', response.status, response.statusText);
            return response.json();
        })
        .then(data => {
            console.log('📨 Response data:', data);
            if (data.success) {
                console.log('✅ Data saved successfully');
                showToast(data.message || 'Attendance saved successfully', 'success');
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
                console.error('❌ Failed to save data:', data);
                showToast(data.message || 'Failed to save attendance', 'error');
                if (data.errors) {
                    console.error('Error details:', data.errors);
                }
            }
        })
        .catch(error => {
            console.error('💥 Network error:', error);
            showToast('Error occurred while saving', 'error');
        });
    }

    // Remove statistics functions since columns are removed
    // updateEmployeeStats and updateGlobalStats are no longer needed
</script>
@endpush

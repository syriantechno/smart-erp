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
    <div
        id="attendance-page"
        data-attendance-index-url="{{ route('hr.attendance.index') }}"
        data-attendance-store-url="{{ route('hr.attendance.store') }}"
    >
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
                        <div class="flex gap-2 flex-wrap justify-end">
                            <!-- Month/Year Selector -->
                            <div class="flex gap-2">
                                <select
                                    id="year-select"
                                    class="disabled:bg-slate-100 disabled:cursor-not-allowed disabled:dark:bg-darkmode-800/50 [&[readonly]]:bg-slate-100 [&[readonly]]:cursor-not-allowed [&[readonly]]:dark:bg-darkmode-800/50 transition duration-200 ease-in-out text-sm border-slate-200 shadow-sm rounded-md py-2 px-3 pr-8 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 group-[.form-inline]:flex-1 mt-2 w-full sm:mt-0 sm:w-auto 2xl:w-full"
                                >
                                    @for($y = 2024; $y <= 2026; $y++)
                                        <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>

                                <select
                                    id="month-select"
                                    class="disabled:bg-slate-100 disabled:cursor-not-allowed disabled:dark:bg-darkmode-800/50 [&[readonly]]:bg-slate-100 [&[readonly]]:cursor-not-allowed [&[readonly]]:dark:bg-darkmode-800/50 transition duration-200 ease-in-out text-sm border-slate-200 shadow-sm rounded-md py-2 px-3 pr-8 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 group-[.form-inline]:flex-1 mt-2 w-full sm:mt-0 sm:w-auto 2xl:w-full"
                                >
                                    @for($m = 1; $m <= 12; $m++)
                                        <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::create()->month($m)->locale('ar')->monthName }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <div class="flex flex-wrap gap-2">
                                <button
                                    id="export-btn"
                                    type="button"
                                    class="btn-tonal btn-tonal--lime btn-tonal--icon group"
                                    title="Export attendance"
                                >
                                    <x-base.lucide icon="file-spreadsheet" class="w-5 h-5 icon-hover-rise" />
                                </button>

                                <button
                                    id="load-month-btn"
                                    type="button"
                                    class="btn-tonal btn-tonal--sky btn-tonal--icon group"
                                    title="Refresh month"
                                >
                                    <x-base.lucide icon="refresh-cw" class="w-5 h-5 icon-hover-rise" />
                                </button>

                                <button
                                    id="add-attendance-btn"
                                    type="button"
                                    class="btn-tonal btn-tonal--success group"
                                >
                                    <x-base.lucide icon="plus" class="w-5 h-5 icon-hover-rise" />
                                    Add Attendance
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="legend-banner mt-4 flex flex-wrap items-center gap-4 text-xs">
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
                        <table
                            class="datatable-default w-full min-w-full table-auto text-left text-sm"
                            id="attendance-table"
                            data-attendance-month="{{ $month }}"
                            data-attendance-year="{{ $year }}"
                        >
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
    <x-modal.form id="attendanceEntryModal" title="Add Attendance" size="lg">
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
                        <div class="relative w-full">
                            <div
                                class="absolute flex h-full w-10 items-center justify-center rounded-l border bg-slate-100 text-slate-500 dark:border-darkmode-800 dark:bg-darkmode-700 dark:text-slate-400">
                                <x-base.lucide icon="Calendar" class="stroke-1.5 w-5 h-5"></x-base.lucide>
                            </div>
                            <x-base.litepicker
                                id="attendance_date"
                                name="attendance_date"
                                class="pl-12 w-full"
                                data-single-mode="true"
                                required
                            />
                        </div>
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
                        <div class="relative w-full">
                            <div
                                class="absolute flex h-full w-10 items-center justify-center rounded-l border bg-slate-100 text-slate-500 dark:border-darkmode-800 dark:bg-darkmode-700 dark:text-slate-400">
                                <x-base.lucide icon="Clock" class="stroke-1.5 w-5 h-5"></x-base.lucide>
                            </div>
                            <x-base.form-input id="check_in" name="check_in" type="time" class="w-full pl-12" />
                        </div>
                    </div>

                    <!-- Check Out Time -->
                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="check_out">Check Out Time</x-base.form-label>
                        <div class="relative w-full">
                            <div
                                class="absolute flex h-full w-10 items-center justify-center rounded-l border bg-slate-100 text-slate-500 dark:border-darkmode-800 dark:bg-darkmode-700 dark:text-slate-400">
                                <x-base.lucide icon="Clock" class="stroke-1.5 w-5 h-5"></x-base.lucide>
                            </div>
                            <x-base.form-input id="check_out" name="check_out" type="time" class="w-full pl-12" />
                        </div>
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
    <x-modal.form id="statusLegendModal" title="Status Legend" size="sm">
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

</div>
@endsection

@include('components.datatable.scripts')

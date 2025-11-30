@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Attendance Management - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@push('styles')
<style>
    /* Make filters more compact */
    #filter-month, #filter-year, #filter-company, #filter-department {
        min-width: auto;
    }
    
    .icon-hover-rise {
        transition: transform 200ms ease;
    }
    
    .group:hover .icon-hover-rise {
        transform: translateY(-2px);
    }
</style>
@endpush

@section('subcontent')
    @include('components.global-notifications')

    {{-- Page Header with Stats --}}
    <div class="intro-y mt-6 mb-2 flex flex-col gap-1">
        <div class="flex items-baseline justify-between gap-6">
            <h2 class="flex items-center gap-2 text-2xl md:text-3xl font-semibold text-royalDark tracking-wide">
                <x-base.lucide icon="calendar-check" class="w-7 h-7" />
                <span>Attendance Management</span>
            </h2>

            <div class="flex flex-row items-end gap-8 md:gap-12 justify-end">
                {{-- Present Today --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="user-check" class="w-4 h-4" />
                        </div>
                        <div class="text-5xl md:text-6xl font-semibold tracking-tight" style="color: #303030" id="stat-present">
                            0
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Present
                    </div>
                </div>

                {{-- Absent Today --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="user-x" class="w-4 h-4" />
                        </div>
                        <div class="text-5xl md:text-6xl font-semibold tracking-tight" style="color: #303030" id="stat-absent">
                            0
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Absent
                    </div>
                </div>

                {{-- On Leave --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="plane" class="w-4 h-4" />
                        </div>
                        <div class="text-5xl md:text-6xl font-semibold tracking-tight" style="color: #303030" id="stat-leave">
                            0
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        On Leave
                    </div>
                </div>

                {{-- Total Employees --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="users" class="w-4 h-4" />
                        </div>
                        <div class="text-5xl md:text-6xl font-semibold tracking-tight" style="color: #303030" id="stat-total">
                            {{ $employees->count() }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Total
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <x-base.preview-component class="intro-y box bg-white/80 border border-slate-200/70 shadow-[0_18px_45px_rgba(15,23,42,0.10)]">
                <div class="p-5">
                    {{-- Filters & Actions in One Row --}}
                    <div class="flex flex-wrap items-center gap-2 mb-4">
                        {{-- Search Input --}}
                        <div class="relative min-w-[180px]">
                            <x-base.lucide icon="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" />
                            <x-base.form-input 
                                id="filter-search" 
                                type="text" 
                                placeholder="Search employee..." 
                                class="pl-9 w-full text-sm py-1.5"
                            />
                        </div>

                        {{-- Month Filter --}}
                        <x-base.form-select id="filter-month" class="w-auto text-sm py-1.5">
                            @for($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($m)->format('M') }}
                                </option>
                            @endfor
                        </x-base.form-select>

                        {{-- Year Filter --}}
                        <x-base.form-select id="filter-year" class="w-auto text-sm py-1.5">
                            @for($y = now()->year - 2; $y <= now()->year + 1; $y++)
                                <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </x-base.form-select>

                        {{-- Company Filter --}}
                        <x-base.form-select id="filter-company" class="w-auto text-sm py-1.5">
                            <option value="">All Companies</option>
                            @foreach($companies ?? [] as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </x-base.form-select>

                        {{-- Department Filter --}}
                        <x-base.form-select id="filter-department" class="w-auto text-sm py-1.5">
                            <option value="">All Depts</option>
                            @foreach($departments ?? [] as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                            @endforeach
                        </x-base.form-select>

                        {{-- Shift Filter --}}
                        <x-base.form-select id="filter-shift" class="w-auto text-sm py-1.5">
                            <option value="">All Shifts</option>
                            @foreach($shifts ?? [] as $shift)
                                <option value="{{ $shift->id }}">{{ $shift->name }}</option>
                            @endforeach
                        </x-base.form-select>

                        {{-- Reset Button --}}
                        <x-base.tippy as="button" id="btn-reset" type="button" content="Reset filters" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                            <x-base.lucide icon="x" class="w-4 h-4" />
                        </x-base.tippy>

                        {{-- Spacer --}}
                        <div class="flex-1"></div>

                        {{-- Action Buttons --}}
                        <div class="flex items-center gap-1">
                            <x-base.tippy content="Print" placement="bottom">
                                <button id="btn-print" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="printer" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Export Excel" placement="bottom">
                                <button id="btn-export" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="file-spreadsheet" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Refresh" placement="bottom">
                                <button id="btn-refresh" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="refresh-cw" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Bulk Entry" placement="bottom">
                                <button id="btn-bulk" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="users" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>

                            {{-- Add Attendance Button --}}
                            <x-base.tippy content="Add attendance" placement="bottom">
                                <button id="btn-add" type="button" class="btn-royal btn-royal--gold btn-royal--sm">
                                    <x-base.lucide icon="plus-circle" class="w-4 h-4 mr-2" />
                                    <span class="hidden sm:inline">Add</span>
                                </button>
                            </x-base.tippy>
                        </div>
                    </div>

                    {{-- Status Legend --}}
                    <div class="flex flex-wrap items-center gap-4 mb-4 p-3 bg-slate-50 rounded-lg text-xs">
                        <span class="font-semibold text-slate-600">Legend:</span>
                        <div class="flex items-center gap-1">
                            <span class="w-6 h-6 rounded bg-green-100 text-green-600 flex items-center justify-center font-bold">✓</span>
                            <span>Present</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <span class="w-6 h-6 rounded bg-red-100 text-red-600 flex items-center justify-center font-bold">✗</span>
                            <span>Absent</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <span class="w-6 h-6 rounded bg-blue-100 text-blue-600 flex items-center justify-center font-bold">🏖</span>
                            <span>Vacation</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <span class="w-6 h-6 rounded bg-yellow-100 text-yellow-600 flex items-center justify-center font-bold">✈</span>
                            <span>Travel</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <span class="w-6 h-6 rounded bg-orange-100 text-orange-600 flex items-center justify-center font-bold">½</span>
                            <span>Half Day</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <span class="w-6 h-6 rounded bg-purple-100 text-purple-600 flex items-center justify-center font-bold">🎉</span>
                            <span>Weekend/Holiday</span>
                        </div>
                    </div>

                    {{-- DataTable --}}
                    <div class="overflow-x-auto" data-erp-table-wrapper>
                        <table id="attendance-table" class="datatable-default w-full min-w-full table-auto text-left text-sm">
                            <thead>
                                <tr>
                                    <th class="font-medium px-3 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap sticky left-0 bg-white z-10" style="min-width: 200px;">
                                        Employee
                                    </th>
                                    @php
                                        $actualDaysInMonth = \Carbon\Carbon::create($year, $month)->daysInMonth;
                                    @endphp
                                    @for($day = 1; $day <= 31; $day++)
                                        @php
                                            $isValidDay = $day <= $actualDaysInMonth;
                                            $date = $isValidDay ? \Carbon\Carbon::create($year, $month, $day) : null;
                                            $isWeekend = $date ? in_array($date->dayOfWeek, [5, 6]) : false;
                                        @endphp
                                        <th class="font-medium px-1 py-2 border-b-2 dark:border-darkmode-300 text-center {{ $isWeekend ? 'bg-slate-100' : '' }} {{ !$isValidDay ? 'bg-slate-50 text-slate-300' : '' }}" style="min-width: 36px;">
                                            <div class="text-xs">{{ $day }}</div>
                                            <div class="text-[10px] text-slate-400">{{ $date ? $date->format('D') : '-' }}</div>
                                        </th>
                                    @endfor
                                    <th class="font-medium px-3 py-3 border-b-2 dark:border-darkmode-300 text-center bg-green-50" style="min-width: 50px;">✓</th>
                                    <th class="font-medium px-3 py-3 border-b-2 dark:border-darkmode-300 text-center bg-red-50" style="min-width: 50px;">✗</th>
                                    <th class="font-medium px-3 py-3 border-b-2 dark:border-darkmode-300 text-center bg-blue-50" style="min-width: 50px;">🏖</th>
                                    <th class="font-medium px-3 py-3 border-b-2 dark:border-darkmode-300 text-center bg-amber-50" style="min-width: 60px;">OT</th>
                                    <th class="font-medium px-3 py-3 border-b-2 dark:border-darkmode-300 text-center" style="min-width: 80px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Data loaded via AJAX --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </x-base.preview-component>
        </div>
    </div>

    {{-- Add/Edit Attendance Modal --}}
    @include('hr.attendance.modals.form')

    {{-- Bulk Entry Modal --}}
    @include('hr.attendance.modals.bulk')

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // URLs
    const urls = {
        index: '{{ route("hr.attendance.index") }}',
        store: '{{ route("hr.attendance.store") }}',
        data: '{{ route("hr.attendance.data") }}',
    };

    // Current filters
    let currentMonth = {{ $month }};
    let currentYear = {{ $year }};
    const daysInMonth = {{ \Carbon\Carbon::create($year, $month)->daysInMonth }};

    // Load attendance data
    function loadAttendanceData() {
        const tbody = document.querySelector('#attendance-table tbody');
        tbody.innerHTML = '<tr><td colspan="100" class="text-center py-8">Loading...</td></tr>';

        const params = new URLSearchParams({
            month: currentMonth,
            year: currentYear,
            company_id: document.getElementById('filter-company')?.value || '',
            department_id: document.getElementById('filter-department')?.value || '',
            shift_id: document.getElementById('filter-shift')?.value || '',
            search_term: document.getElementById('filter-search')?.value || ''
        });

        fetch(urls.data + '?' + params.toString(), {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(json => {
            // Update stats
            if (json.stats) {
                document.getElementById('stat-present').textContent = json.stats.present || 0;
                document.getElementById('stat-absent').textContent = json.stats.absent || 0;
                document.getElementById('stat-leave').textContent = json.stats.vacation || 0;
                document.getElementById('stat-total').textContent = json.stats.total || 0;
            }

            // Render table
            renderTable(json.data || [], json.meta?.days_in_month || daysInMonth);
        })
        .catch(error => {
            console.error('Error loading data:', error);
            tbody.innerHTML = '<tr><td colspan="100" class="text-center py-8 text-red-500">Error loading data</td></tr>';
        });
    }

    function renderTable(data, daysCount) {
        const tbody = document.querySelector('#attendance-table tbody');
        
        if (!data.length) {
            tbody.innerHTML = '<tr><td colspan="100" class="text-center py-8 text-slate-500">No employees found</td></tr>';
            return;
        }

        let html = '';
        data.forEach(row => {
            html += '<tr class="border-b hover:bg-slate-50">';
            
            // Employee column
            const avatar = row.employee.photo 
                ? '<img src="' + row.employee.photo + '" class="w-8 h-8 rounded-full object-cover" alt="">'
                : '<div class="w-8 h-8 rounded-full bg-slate-600 flex items-center justify-center text-white text-xs font-bold">' + row.employee.initials + '</div>';
            
            html += '<td class="px-3 py-2 sticky left-0 bg-white z-10">' +
                '<div class="flex items-center gap-2">' + avatar +
                '<div><div class="font-semibold text-slate-800">' + row.employee.name + '</div>' +
                '<div class="text-xs text-slate-500">' + (row.employee.position || '') + '</div></div></div></td>';

            // Day columns
            for (let day = 1; day <= daysCount; day++) {
                const dayData = row.days[day];
                if (dayData) {
                    const statusClass = getStatusClass(dayData.status);
                    const statusLabel = getStatusLabel(dayData.status);
                    const dateStr = currentYear + '-' + String(currentMonth).padStart(2, '0') + '-' + String(day).padStart(2, '0');
                    html += '<td class="px-1 py-2 text-center">' +
                        '<span class="attendance-cell cursor-pointer inline-block w-6 h-6 rounded text-xs font-bold leading-6 ' + statusClass + '" ' +
                        'data-employee="' + row.id + '" data-date="' + dateStr + '" data-status="' + dayData.status + '" ' +
                        'title="' + dayData.status + '">' + statusLabel + '</span></td>';
                } else {
                    html += '<td class="px-1 py-2 text-center"><span class="text-slate-300">-</span></td>';
                }
            }

            // Summary columns
            html += '<td class="px-2 py-2 text-center font-bold text-green-600 bg-green-50">' + (row.summary.present || 0) + '</td>';
            html += '<td class="px-2 py-2 text-center font-bold text-red-600 bg-red-50">' + (row.summary.absent || 0) + '</td>';
            html += '<td class="px-2 py-2 text-center font-bold text-blue-600 bg-blue-50">' + (row.summary.vacation || 0) + '</td>';
            
            // Overtime column
            const overtime = parseFloat(row.summary.overtime) || 0;
            const overtimeDisplay = overtime > 0 ? '+' + overtime.toFixed(1) + 'h' : '0h';
            const overtimeClass = overtime > 0 ? 'text-green-600 bg-green-50' : 'text-amber-600 bg-amber-50';
            html += '<td class="px-2 py-2 text-center font-bold ' + overtimeClass + '">' + overtimeDisplay + '</td>';

            // Actions column
            html += '<td class="px-2 py-2 text-center">' +
                '<button type="button" class="btn-action btn-action--view" data-id="' + row.id + '" title="View">' +
                '👁</button></td>';

            html += '</tr>';
        });

        tbody.innerHTML = html;
        
        // Re-init lucide icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }

    function getStatusClass(status) {
        const classes = {
            'present': 'bg-green-100 text-green-600',
            'absent': 'bg-red-100 text-red-600',
            'vacation': 'bg-blue-100 text-blue-600',
            'travel': 'bg-yellow-100 text-yellow-600',
            'half_day': 'bg-orange-100 text-orange-600',
            'holiday': 'bg-purple-100 text-purple-600',
        };
        return classes[status] || 'bg-slate-100 text-slate-400';
    }

    function getStatusLabel(status) {
        const labels = {
            'present': '✓',
            'absent': '✗',
            'vacation': '🏖',
            'travel': '✈',
            'half_day': '½',
            'holiday': '🎉',
        };
        return labels[status] || '-';
    }

    // Initial load
    loadAttendanceData();

    // Auto-filter on change
    ['filter-month', 'filter-year', 'filter-company', 'filter-department', 'filter-shift'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('change', function() {
                currentMonth = document.getElementById('filter-month').value;
                currentYear = document.getElementById('filter-year').value;
                loadAttendanceData();
            });
        }
    });

    // Search on Enter or after typing
    let searchTimeout;
    document.getElementById('filter-search')?.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => loadAttendanceData(), 500);
    });

    // Reset filters
    document.getElementById('btn-reset').addEventListener('click', function() {
        document.getElementById('filter-month').value = {{ now()->month }};
        document.getElementById('filter-year').value = {{ now()->year }};
        document.getElementById('filter-company').value = '';
        document.getElementById('filter-department').value = '';
        document.getElementById('filter-shift').value = '';
        document.getElementById('filter-search').value = '';
        currentMonth = {{ now()->month }};
        currentYear = {{ now()->year }};
        loadAttendanceData();
    });

    // Refresh button
    document.getElementById('btn-refresh')?.addEventListener('click', function() {
        loadAttendanceData();
    });

    // Add attendance button
    document.getElementById('btn-add').addEventListener('click', function() {
        openAttendanceModal();
    });

    // Bulk entry button
    document.getElementById('btn-bulk').addEventListener('click', function() {
        openBulkModal();
    });

    // Click on attendance cell to edit
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('attendance-cell')) {
            const employeeId = e.target.dataset.employee;
            const date = e.target.dataset.date;
            const status = e.target.dataset.status;
            openAttendanceModal(employeeId, date, status);
        }
    });

    // Modal functions
    function openAttendanceModal(employeeId, date, status) {
        const modalEl = document.getElementById('attendance-modal');
        const modal = tailwind.Modal.getOrCreateInstance(modalEl);
        const form = document.getElementById('attendance-form');
        
        // Reset form
        form.reset();
        form.querySelector('input[name="id"]').value = '';
        
        if (employeeId) {
            form.querySelector('select[name="employee_id"]').value = employeeId;
            form.querySelector('input[name="attendance_date"]').value = date;
            form.querySelector('select[name="status"]').value = status || 'present';
        } else {
            form.querySelector('input[name="attendance_date"]').value = '{{ now()->format("Y-m-d") }}';
        }
        
        modal.show();
    }

    function openBulkModal() {
        const modalEl = document.getElementById('bulk-modal');
        const modal = tailwind.Modal.getOrCreateInstance(modalEl);
        document.getElementById('bulk-form').reset();
        modal.show();
    }

    // Save attendance
    document.getElementById('attendance-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const btn = document.getElementById('btn-save-attendance');
        btn.disabled = true;
        btn.innerHTML = 'Saving...';

        fetch(urls.store, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.showSuccess && showSuccess(data.message || 'Attendance saved successfully');
                tailwind.Modal.getInstance(document.getElementById('attendance-modal')).hide();
                loadAttendanceData();
            } else {
                window.showError && showError(data.message || 'Failed to save attendance');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            window.showError && showError('An error occurred while saving');
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = '<i data-lucide="save" class="w-4 h-4 mr-2"></i> Save Attendance';
            if (typeof lucide !== 'undefined') lucide.createIcons();
        });
    });

    // Use global notification system (from global-notifications.blade.php)
    // showSuccess and showError are already defined globally
});
</script>
@endpush

@include('components.datatable.scripts')

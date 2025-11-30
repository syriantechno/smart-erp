@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Shift Reports - {{ config('app.name') }}</title>
@endsection

@push('styles')
<style>
    .report-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }
    .report-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    }
    .stat-value {
        font-size: 2.5rem;
        font-weight: 700;
        line-height: 1;
    }
    .progress-bar {
        height: 8px;
        border-radius: 4px;
        background: #e2e8f0;
        overflow: hidden;
    }
    .progress-fill {
        height: 100%;
        border-radius: 4px;
        transition: width 0.5s ease;
    }
</style>
@endpush

@section('subcontent')
    @include('components.global-notifications')

    {{-- Header --}}
    <div class="intro-y mt-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="flex items-center gap-2 text-2xl md:text-3xl font-semibold text-royalDark tracking-wide">
                    <x-base.lucide icon="bar-chart-3" class="w-7 h-7" />
                    <span>Shift Reports</span>
                </h2>
                <p class="text-slate-500 mt-1">Analyze shift compliance, overtime, and attendance patterns</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('hr.shifts.index') }}" class="btn-royal btn-royal--outline btn-royal--sm">
                    <x-base.lucide icon="arrow-left" class="w-4 h-4 mr-2" />
                    Back to Shifts
                </a>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="intro-y mb-6">
        <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-100">
            <div class="flex flex-wrap items-center gap-3">
                <x-base.form-select id="report-month" class="w-auto text-sm py-1.5">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $m == now()->month ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                        </option>
                    @endfor
                </x-base.form-select>

                <x-base.form-select id="report-year" class="w-auto text-sm py-1.5">
                    @for($y = now()->year - 2; $y <= now()->year; $y++)
                        <option value="{{ $y }}" {{ $y == now()->year ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </x-base.form-select>

                <x-base.form-select id="report-shift" class="w-auto text-sm py-1.5">
                    <option value="">All Shifts</option>
                    @foreach($shifts ?? [] as $shift)
                        <option value="{{ $shift->id }}">{{ $shift->name }}</option>
                    @endforeach
                </x-base.form-select>

                <button type="button" id="btn-generate" class="btn-royal btn-royal--gold btn-royal--sm">
                    <x-base.lucide icon="refresh-cw" class="w-4 h-4 mr-2" />
                    Generate Report
                </button>
            </div>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        {{-- Total Employees --}}
        <div class="report-card">
            <div class="flex items-center justify-between mb-3">
                <span class="text-slate-500 text-sm font-medium">Total Employees</span>
                <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                    <x-base.lucide icon="users" class="w-5 h-5 text-blue-600" />
                </div>
            </div>
            <div class="stat-value text-slate-800" id="stat-employees">0</div>
            <p class="text-slate-400 text-sm mt-2">With assigned shifts</p>
        </div>

        {{-- Compliance Rate --}}
        <div class="report-card">
            <div class="flex items-center justify-between mb-3">
                <span class="text-slate-500 text-sm font-medium">Compliance Rate</span>
                <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center">
                    <x-base.lucide icon="check-circle" class="w-5 h-5 text-green-600" />
                </div>
            </div>
            <div class="stat-value text-green-600" id="stat-compliance">0%</div>
            <div class="progress-bar mt-3">
                <div class="progress-fill bg-green-500" id="compliance-bar" style="width: 0%"></div>
            </div>
        </div>

        {{-- Late Arrivals --}}
        <div class="report-card">
            <div class="flex items-center justify-between mb-3">
                <span class="text-slate-500 text-sm font-medium">Late Arrivals</span>
                <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center">
                    <x-base.lucide icon="clock" class="w-5 h-5 text-amber-600" />
                </div>
            </div>
            <div class="stat-value text-amber-600" id="stat-late">0</div>
            <p class="text-slate-400 text-sm mt-2">This month</p>
        </div>

        {{-- Total Overtime --}}
        <div class="report-card">
            <div class="flex items-center justify-between mb-3">
                <span class="text-slate-500 text-sm font-medium">Total Overtime</span>
                <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center">
                    <x-base.lucide icon="timer" class="w-5 h-5 text-purple-600" />
                </div>
            </div>
            <div class="stat-value text-purple-600" id="stat-overtime">0h</div>
            <p class="text-slate-400 text-sm mt-2">Extra hours worked</p>
        </div>
    </div>

    {{-- Detailed Reports --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Shift Distribution --}}
        <div class="report-card">
            <h3 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                <x-base.lucide icon="pie-chart" class="w-5 h-5 text-primary" />
                Shift Distribution
            </h3>
            <div id="shift-distribution" class="space-y-3">
                {{-- Will be populated by JS --}}
                <div class="text-center py-8 text-slate-400">
                    <x-base.lucide icon="loader-2" class="w-8 h-8 mx-auto animate-spin" />
                    <p class="mt-2">Loading...</p>
                </div>
            </div>
        </div>

        {{-- Top Overtime Employees --}}
        <div class="report-card">
            <h3 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                <x-base.lucide icon="trending-up" class="w-5 h-5 text-primary" />
                Top Overtime Employees
            </h3>
            <div id="top-overtime" class="space-y-3">
                {{-- Will be populated by JS --}}
                <div class="text-center py-8 text-slate-400">
                    <x-base.lucide icon="loader-2" class="w-8 h-8 mx-auto animate-spin" />
                    <p class="mt-2">Loading...</p>
                </div>
            </div>
        </div>

        {{-- Late Arrivals by Shift --}}
        <div class="report-card">
            <h3 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                <x-base.lucide icon="alert-triangle" class="w-5 h-5 text-amber-500" />
                Late Arrivals by Shift
            </h3>
            <div id="late-by-shift" class="space-y-3">
                {{-- Will be populated by JS --}}
                <div class="text-center py-8 text-slate-400">
                    <x-base.lucide icon="loader-2" class="w-8 h-8 mx-auto animate-spin" />
                    <p class="mt-2">Loading...</p>
                </div>
            </div>
        </div>

        {{-- Attendance Summary --}}
        <div class="report-card">
            <h3 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                <x-base.lucide icon="calendar-check" class="w-5 h-5 text-primary" />
                Attendance Summary
            </h3>
            <div id="attendance-summary" class="space-y-3">
                {{-- Will be populated by JS --}}
                <div class="text-center py-8 text-slate-400">
                    <x-base.lucide icon="loader-2" class="w-8 h-8 mx-auto animate-spin" />
                    <p class="mt-2">Loading...</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const monthSelect = document.getElementById('report-month');
    const yearSelect = document.getElementById('report-year');
    const shiftSelect = document.getElementById('report-shift');
    const generateBtn = document.getElementById('btn-generate');

    // Load initial data
    loadReportData();

    generateBtn.addEventListener('click', loadReportData);

    function loadReportData() {
        const params = new URLSearchParams({
            month: monthSelect.value,
            year: yearSelect.value,
            shift_id: shiftSelect.value
        });

        fetch('{{ route("hr.shifts.report-data") }}?' + params.toString(), {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateStats(data.stats);
                updateShiftDistribution(data.distribution);
                updateTopOvertime(data.topOvertime);
                updateLateByShift(data.lateByShift);
                updateAttendanceSummary(data.attendanceSummary);
            }
        })
        .catch(error => {
            console.error('Error loading report data:', error);
        });
    }

    function updateStats(stats) {
        document.getElementById('stat-employees').textContent = stats.totalEmployees || 0;
        document.getElementById('stat-compliance').textContent = (stats.complianceRate || 0) + '%';
        document.getElementById('compliance-bar').style.width = (stats.complianceRate || 0) + '%';
        document.getElementById('stat-late').textContent = stats.lateArrivals || 0;
        document.getElementById('stat-overtime').textContent = (stats.totalOvertime || 0) + 'h';
    }

    function updateShiftDistribution(distribution) {
        const container = document.getElementById('shift-distribution');
        if (!distribution || distribution.length === 0) {
            container.innerHTML = '<p class="text-center text-slate-400 py-4">No data available</p>';
            return;
        }

        const total = distribution.reduce((sum, item) => sum + item.count, 0);
        container.innerHTML = distribution.map(item => {
            const percentage = total > 0 ? Math.round((item.count / total) * 100) : 0;
            return `
                <div class="flex items-center gap-3">
                    <div class="w-3 h-3 rounded-full" style="background-color: ${item.color || '#6366f1'}"></div>
                    <div class="flex-1">
                        <div class="flex justify-between mb-1">
                            <span class="text-sm font-medium text-slate-700">${item.name}</span>
                            <span class="text-sm text-slate-500">${item.count} employees (${percentage}%)</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: ${percentage}%; background-color: ${item.color || '#6366f1'}"></div>
                        </div>
                    </div>
                </div>
            `;
        }).join('');
    }

    function updateTopOvertime(employees) {
        const container = document.getElementById('top-overtime');
        if (!employees || employees.length === 0) {
            container.innerHTML = '<p class="text-center text-slate-400 py-4">No overtime recorded</p>';
            return;
        }

        container.innerHTML = employees.map((emp, index) => `
            <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-slate-50">
                <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 font-bold text-sm">
                    ${index + 1}
                </div>
                <div class="flex-1">
                    <p class="font-medium text-slate-700">${emp.name}</p>
                    <p class="text-xs text-slate-400">${emp.department || 'N/A'}</p>
                </div>
                <div class="text-right">
                    <p class="font-bold text-purple-600">+${emp.overtime}h</p>
                </div>
            </div>
        `).join('');
    }

    function updateLateByShift(shifts) {
        const container = document.getElementById('late-by-shift');
        if (!shifts || shifts.length === 0) {
            container.innerHTML = '<p class="text-center text-slate-400 py-4">No late arrivals</p>';
            return;
        }

        container.innerHTML = shifts.map(shift => `
            <div class="flex items-center justify-between p-3 rounded-lg bg-slate-50">
                <div class="flex items-center gap-3">
                    <div class="w-3 h-3 rounded-full" style="background-color: ${shift.color || '#f59e0b'}"></div>
                    <span class="font-medium text-slate-700">${shift.name}</span>
                </div>
                <span class="px-3 py-1 rounded-full text-sm font-semibold ${shift.count > 5 ? 'bg-red-100 text-red-600' : 'bg-amber-100 text-amber-600'}">
                    ${shift.count} late
                </span>
            </div>
        `).join('');
    }

    function updateAttendanceSummary(summary) {
        const container = document.getElementById('attendance-summary');
        if (!summary) {
            container.innerHTML = '<p class="text-center text-slate-400 py-4">No data available</p>';
            return;
        }

        const items = [
            { label: 'Present', value: summary.present || 0, color: 'bg-green-500', bgColor: 'bg-green-100' },
            { label: 'Absent', value: summary.absent || 0, color: 'bg-red-500', bgColor: 'bg-red-100' },
            { label: 'Vacation', value: summary.vacation || 0, color: 'bg-blue-500', bgColor: 'bg-blue-100' },
            { label: 'Half Day', value: summary.half_day || 0, color: 'bg-orange-500', bgColor: 'bg-orange-100' },
        ];

        const total = items.reduce((sum, item) => sum + item.value, 0);

        container.innerHTML = items.map(item => {
            const percentage = total > 0 ? Math.round((item.value / total) * 100) : 0;
            return `
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg ${item.bgColor} flex items-center justify-center">
                        <span class="font-bold text-slate-700">${item.value}</span>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between mb-1">
                            <span class="text-sm font-medium text-slate-700">${item.label}</span>
                            <span class="text-sm text-slate-500">${percentage}%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill ${item.color}" style="width: ${percentage}%"></div>
                        </div>
                    </div>
                </div>
            `;
        }).join('');
    }

    // Initialize Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});
</script>
@endpush

@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>{{ __('menu.hr_reports') }} - {{ config('app.name') }}</title>
@endsection

@section('subcontent')
@include('components.global-notifications')

<div class="intro-y mt-6 mb-2 flex flex-col gap-1">
    <div class="flex items-baseline justify-between gap-6">
        <h2 class="flex items-center gap-2 text-2xl md:text-3xl font-semibold text-royalDark tracking-wide">
            <x-base.lucide icon="users" class="w-7 h-7" />
            <span>{{ __('menu.hr_reports') }}</span>
        </h2>
        <a href="{{ route('reports.index') }}" class="btn-royal btn-royal--outline btn-royal--sm">
            <x-base.lucide icon="arrow-left" class="w-4 h-4" /> العودة
        </a>
    </div>
</div>

{{-- Date Filter --}}
<div class="mt-5 box p-5">
    <form method="GET" action="{{ route('reports.hr') }}" class="flex flex-wrap items-end gap-4">
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">من تاريخ</label>
            <input type="date" name="start_date" value="{{ $startDate }}" class="form-control w-40">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">إلى تاريخ</label>
            <input type="date" name="end_date" value="{{ $endDate }}" class="form-control w-40">
        </div>
        <button type="submit" class="btn-royal btn-royal--dark btn-royal--sm">
            <x-base.lucide icon="search" class="w-4 h-4" /> تطبيق
        </button>
        <div class="flex gap-2 ml-auto">
            <button type="button" onclick="window.print()" class="btn-royal btn-royal--outline btn-royal--sm">
                <x-base.lucide icon="printer" class="w-4 h-4" /> طباعة
            </button>
        </div>
    </form>
</div>

{{-- Summary Cards --}}
<div class="mt-5 grid grid-cols-12 gap-6">
    <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
        <div class="box p-5">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                    <x-base.lucide icon="users" class="w-6 h-6 text-blue-600" />
                </div>
                <div>
                    <div class="text-slate-500 text-sm">إجمالي الموظفين</div>
                    <div class="text-2xl font-bold text-blue-600">{{ $totalEmployees }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
        <div class="box p-5">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-emerald-100 flex items-center justify-center">
                    <x-base.lucide icon="user-plus" class="w-6 h-6 text-emerald-600" />
                </div>
                <div>
                    <div class="text-slate-500 text-sm">موظفين جدد</div>
                    <div class="text-2xl font-bold text-emerald-600">{{ $newHires }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
        <div class="box p-5">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-amber-100 flex items-center justify-center">
                    <x-base.lucide icon="wallet" class="w-6 h-6 text-amber-600" />
                </div>
                <div>
                    <div class="text-slate-500 text-sm">إجمالي الرواتب</div>
                    <div class="text-2xl font-bold text-amber-600">{{ number_format($totalPayroll, 2) }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
        <div class="box p-5">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-rose-100 flex items-center justify-center">
                    <x-base.lucide icon="alert-triangle" class="w-6 h-6 text-rose-600" />
                </div>
                <div>
                    <div class="text-slate-500 text-sm">العقوبات المالية</div>
                    <div class="text-2xl font-bold text-rose-600">{{ number_format($totalPenalties, 2) }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Attendance & Leave --}}
<div class="mt-5 grid grid-cols-12 gap-6">
    {{-- Attendance Stats --}}
    <div class="intro-y col-span-12 lg:col-span-6">
        <div class="box p-5">
            <h4 class="font-semibold text-slate-700 mb-4">إحصائيات الحضور</h4>
            <div class="grid grid-cols-3 gap-4 mb-4">
                <div class="text-center p-4 bg-emerald-50 rounded-lg">
                    <div class="text-3xl font-bold text-emerald-600">{{ $attendanceStats['total_present'] }}</div>
                    <div class="text-sm text-slate-500 mt-1">حاضر</div>
                </div>
                <div class="text-center p-4 bg-rose-50 rounded-lg">
                    <div class="text-3xl font-bold text-rose-600">{{ $attendanceStats['total_absent'] }}</div>
                    <div class="text-sm text-slate-500 mt-1">غائب</div>
                </div>
                <div class="text-center p-4 bg-amber-50 rounded-lg">
                    <div class="text-3xl font-bold text-amber-600">{{ $attendanceStats['total_late'] }}</div>
                    <div class="text-sm text-slate-500 mt-1">متأخر</div>
                </div>
            </div>
            <canvas id="attendanceChart" height="200"></canvas>
        </div>
    </div>

    {{-- Leave Stats --}}
    <div class="intro-y col-span-12 lg:col-span-6">
        <div class="box p-5">
            <h4 class="font-semibold text-slate-700 mb-4">إحصائيات الإجازات</h4>
            <div class="space-y-3">
                @forelse($leaveStats as $leave)
                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                            <x-base.lucide icon="calendar" class="w-5 h-5 text-blue-600" />
                        </div>
                        <span class="font-medium">{{ ucfirst($leave->type) }}</span>
                    </div>
                    <span class="text-xl font-bold text-blue-600">{{ $leave->count }}</span>
                </div>
                @empty
                <div class="text-center text-slate-400 py-8">لا توجد إجازات</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- Employees by Department --}}
<div class="mt-5">
    <div class="intro-y box p-5">
        <h4 class="font-semibold text-slate-700 mb-4">الموظفين حسب القسم</h4>
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 lg:col-span-8">
                <canvas id="departmentChart" height="300"></canvas>
            </div>
            <div class="col-span-12 lg:col-span-4">
                <div class="space-y-2">
                    @foreach($employeesByDepartment as $dept)
                    <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                        <span class="font-medium">{{ $dept->department->name ?? 'غير محدد' }}</span>
                        <span class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-sm font-semibold">{{ $dept->count }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Advances Summary --}}
<div class="mt-5 grid grid-cols-12 gap-6">
    <div class="intro-y col-span-12 lg:col-span-6">
        <div class="box p-5">
            <h4 class="font-semibold text-slate-700 mb-4">ملخص السلف</h4>
            <div class="flex items-center gap-4 p-4 bg-amber-50 rounded-lg">
                <div class="w-16 h-16 rounded-xl bg-amber-100 flex items-center justify-center">
                    <x-base.lucide icon="hand-coins" class="w-8 h-8 text-amber-600" />
                </div>
                <div>
                    <div class="text-sm text-slate-500">إجمالي السلف المصروفة</div>
                    <div class="text-3xl font-bold text-amber-600">{{ number_format($totalAdvances, 2) }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="intro-y col-span-12 lg:col-span-6">
        <div class="box p-5">
            <h4 class="font-semibold text-slate-700 mb-4">ملخص العقوبات</h4>
            <div class="flex items-center gap-4 p-4 bg-rose-50 rounded-lg">
                <div class="w-16 h-16 rounded-xl bg-rose-100 flex items-center justify-center">
                    <x-base.lucide icon="alert-triangle" class="w-8 h-8 text-rose-600" />
                </div>
                <div>
                    <div class="text-sm text-slate-500">إجمالي العقوبات المالية</div>
                    <div class="text-3xl font-bold text-rose-600">{{ number_format($totalPenalties, 2) }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Attendance Chart
    new Chart(document.getElementById('attendanceChart'), {
        type: 'doughnut',
        data: {
            labels: ['حاضر', 'غائب', 'متأخر'],
            datasets: [{
                data: [
                    {{ $attendanceStats['total_present'] }},
                    {{ $attendanceStats['total_absent'] }},
                    {{ $attendanceStats['total_late'] }}
                ],
                backgroundColor: [
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(244, 63, 94, 0.8)',
                    'rgba(245, 158, 11, 0.8)'
                ],
                borderWidth: 0,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });

    // Department Chart
    const deptData = @json($employeesByDepartment);
    
    new Chart(document.getElementById('departmentChart'), {
        type: 'bar',
        data: {
            labels: deptData.map(d => d.department?.name || 'غير محدد'),
            datasets: [{
                label: 'عدد الموظفين',
                data: deptData.map(d => d.count),
                backgroundColor: 'rgba(59, 130, 246, 0.8)',
                borderRadius: 4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y',
            plugins: {
                legend: {
                    display: false,
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                }
            }
        }
    });
});
</script>
@endpush

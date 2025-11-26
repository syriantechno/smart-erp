@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>{{ __('menu.project_reports') }} - {{ config('app.name') }}</title>
@endsection

@section('subcontent')
@include('components.global-notifications')

<div class="intro-y mt-6 mb-2 flex flex-col gap-1">
    <div class="flex items-baseline justify-between gap-6">
        <h2 class="flex items-center gap-2 text-2xl md:text-3xl font-semibold text-royalDark tracking-wide">
            <x-base.lucide icon="folder" class="w-7 h-7" />
            <span>{{ __('menu.project_reports') }}</span>
        </h2>
        <a href="{{ route('reports.index') }}" class="btn-royal btn-royal--outline btn-royal--sm">
            <x-base.lucide icon="arrow-left" class="w-4 h-4" /> العودة
        </a>
    </div>
</div>

{{-- Summary Cards --}}
<div class="mt-5 grid grid-cols-12 gap-6">
    <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
        <div class="box p-5">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                    <x-base.lucide icon="folder" class="w-6 h-6 text-blue-600" />
                </div>
                <div>
                    <div class="text-slate-500 text-sm">إجمالي المشاريع</div>
                    <div class="text-2xl font-bold text-blue-600">{{ $projectsStats['total'] }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
        <div class="box p-5">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-amber-100 flex items-center justify-center">
                    <x-base.lucide icon="play-circle" class="w-6 h-6 text-amber-600" />
                </div>
                <div>
                    <div class="text-slate-500 text-sm">قيد التنفيذ</div>
                    <div class="text-2xl font-bold text-amber-600">{{ $projectsStats['active'] }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
        <div class="box p-5">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-emerald-100 flex items-center justify-center">
                    <x-base.lucide icon="check-circle" class="w-6 h-6 text-emerald-600" />
                </div>
                <div>
                    <div class="text-slate-500 text-sm">مكتملة</div>
                    <div class="text-2xl font-bold text-emerald-600">{{ $projectsStats['completed'] }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
        <div class="box p-5">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-indigo-100 flex items-center justify-center">
                    <x-base.lucide icon="percent" class="w-6 h-6 text-indigo-600" />
                </div>
                <div>
                    <div class="text-slate-500 text-sm">نسبة الإنجاز</div>
                    <div class="text-2xl font-bold text-indigo-600">{{ $completionRate }}%</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Tasks Summary --}}
<div class="mt-5 grid grid-cols-12 gap-6">
    <div class="intro-y col-span-12 lg:col-span-6">
        <div class="box p-5">
            <h4 class="font-semibold text-slate-700 mb-4">إحصائيات المهام</h4>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="p-4 bg-slate-50 rounded-lg text-center">
                    <div class="text-3xl font-bold text-slate-700">{{ $tasksStats['total'] }}</div>
                    <div class="text-sm text-slate-500 mt-1">إجمالي المهام</div>
                </div>
                <div class="p-4 bg-emerald-50 rounded-lg text-center">
                    <div class="text-3xl font-bold text-emerald-600">{{ $tasksStats['completed'] }}</div>
                    <div class="text-sm text-slate-500 mt-1">مكتملة</div>
                </div>
                <div class="p-4 bg-blue-50 rounded-lg text-center">
                    <div class="text-3xl font-bold text-blue-600">{{ $tasksStats['in_progress'] }}</div>
                    <div class="text-sm text-slate-500 mt-1">قيد التنفيذ</div>
                </div>
                <div class="p-4 bg-amber-50 rounded-lg text-center">
                    <div class="text-3xl font-bold text-amber-600">{{ $tasksStats['pending'] }}</div>
                    <div class="text-sm text-slate-500 mt-1">معلقة</div>
                </div>
            </div>
            <canvas id="tasksChart" height="200"></canvas>
        </div>
    </div>

    {{-- Projects by Status --}}
    <div class="intro-y col-span-12 lg:col-span-6">
        <div class="box p-5">
            <h4 class="font-semibold text-slate-700 mb-4">المشاريع حسب الحالة</h4>
            <canvas id="projectsStatusChart" height="300"></canvas>
        </div>
    </div>
</div>

{{-- Overdue Tasks --}}
@if($overdueTasks->count() > 0)
<div class="mt-5">
    <div class="intro-y box p-5 border-l-4 border-rose-500">
        <h4 class="font-semibold text-rose-600 mb-4 flex items-center gap-2">
            <x-base.lucide icon="alert-triangle" class="w-5 h-5" />
            المهام المتأخرة
        </h4>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-rose-50">
                        <th class="px-4 py-2 text-right font-medium text-slate-600">المهمة</th>
                        <th class="px-4 py-2 text-right font-medium text-slate-600">المشروع</th>
                        <th class="px-4 py-2 text-right font-medium text-slate-600">المسؤول</th>
                        <th class="px-4 py-2 text-center font-medium text-slate-600">تاريخ الاستحقاق</th>
                        <th class="px-4 py-2 text-center font-medium text-slate-600">التأخير</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($overdueTasks as $task)
                    @php $daysOverdue = now()->diffInDays($task->due_date); @endphp
                    <tr class="border-b border-slate-100">
                        <td class="px-4 py-3 font-medium">{{ $task->title }}</td>
                        <td class="px-4 py-3">{{ $task->project->name ?? 'N/A' }}</td>
                        <td class="px-4 py-3">{{ $task->employee->full_name ?? 'N/A' }}</td>
                        <td class="px-4 py-3 text-center">{{ $task->due_date?->format('Y-m-d') }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-2 py-1 bg-rose-100 text-rose-600 rounded text-xs font-semibold">
                                {{ $daysOverdue }} يوم
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

{{-- Recent Projects --}}
<div class="mt-5">
    <div class="intro-y box p-5">
        <h4 class="font-semibold text-slate-700 mb-4">آخر المشاريع</h4>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="px-4 py-2 text-right font-medium text-slate-600">المشروع</th>
                        <th class="px-4 py-2 text-right font-medium text-slate-600">المدير</th>
                        <th class="px-4 py-2 text-center font-medium text-slate-600">المهام</th>
                        <th class="px-4 py-2 text-center font-medium text-slate-600">الحالة</th>
                        <th class="px-4 py-2 text-center font-medium text-slate-600">التقدم</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentProjects as $project)
                    @php 
                        $totalTasks = $project->tasks->count();
                        $completedTasks = $project->tasks->where('status', 'completed')->count();
                        $progress = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;
                    @endphp
                    <tr class="border-b border-slate-100">
                        <td class="px-4 py-3 font-medium">{{ $project->name }}</td>
                        <td class="px-4 py-3">{{ $project->manager->name ?? 'N/A' }}</td>
                        <td class="px-4 py-3 text-center">{{ $completedTasks }}/{{ $totalTasks }}</td>
                        <td class="px-4 py-3 text-center">
                            @if($project->status === 'completed')
                            <span class="px-2 py-1 bg-emerald-100 text-emerald-600 rounded text-xs font-semibold">مكتمل</span>
                            @elseif($project->status === 'in_progress')
                            <span class="px-2 py-1 bg-blue-100 text-blue-600 rounded text-xs font-semibold">قيد التنفيذ</span>
                            @elseif($project->status === 'on_hold')
                            <span class="px-2 py-1 bg-amber-100 text-amber-600 rounded text-xs font-semibold">متوقف</span>
                            @else
                            <span class="px-2 py-1 bg-slate-100 text-slate-600 rounded text-xs font-semibold">{{ $project->status }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <div class="flex-1 h-2 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-emerald-500 rounded-full" style="width: {{ $progress }}%"></div>
                                </div>
                                <span class="text-xs text-slate-500">{{ number_format($progress, 0) }}%</span>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tasks Chart
    new Chart(document.getElementById('tasksChart'), {
        type: 'doughnut',
        data: {
            labels: ['مكتملة', 'قيد التنفيذ', 'معلقة'],
            datasets: [{
                data: [
                    {{ $tasksStats['completed'] }},
                    {{ $tasksStats['in_progress'] }},
                    {{ $tasksStats['pending'] }}
                ],
                backgroundColor: [
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(59, 130, 246, 0.8)',
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

    // Projects Status Chart
    const projectsByStatus = @json($projectsByStatus);
    const statusLabels = {
        'in_progress': 'قيد التنفيذ',
        'completed': 'مكتمل',
        'on_hold': 'متوقف',
        'pending': 'معلق',
        'cancelled': 'ملغي'
    };
    
    new Chart(document.getElementById('projectsStatusChart'), {
        type: 'bar',
        data: {
            labels: projectsByStatus.map(p => statusLabels[p.status] || p.status),
            datasets: [{
                label: 'عدد المشاريع',
                data: projectsByStatus.map(p => p.count),
                backgroundColor: [
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(139, 92, 246, 0.8)',
                    'rgba(244, 63, 94, 0.8)'
                ],
                borderRadius: 4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>
@endpush

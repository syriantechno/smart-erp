@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>HR Dashboard - Smart ERP</title>
@endsection

@section('subcontent')
    @php
        $attendanceStatuses = [
            'present' => ['label' => __('Present'), 'color' => 'emerald'],
            'absent' => ['label' => __('Absent'), 'color' => 'rose'],
            'vacation' => ['label' => __('Vacation'), 'color' => 'sky'],
            'travel' => ['label' => __('Travel'), 'color' => 'amber'],
            'half_day' => ['label' => __('Half Day'), 'color' => 'purple'],
            'holiday' => ['label' => __('Holiday'), 'color' => 'lime'],
        ];

        $getExpiryTone = function (?int $daysLeft) {
            if (is_null($daysLeft)) {
                return [
                    'class' => 'btn-tonal btn-tonal--neutral !px-3 !py-1 text-[0.7rem] font-semibold',
                    'label' => __('No date'),
                ];
            }

            if ($daysLeft <= 0) {
                return [
                    'class' => 'btn-tonal btn-tonal--rose !px-3 !py-1 text-[0.7rem] font-semibold',
                    'label' => __('Expired'),
                ];
            }

            if ($daysLeft <= 10) {
                return [
                    'class' => 'btn-tonal btn-tonal--danger !px-3 !py-1 text-[0.7rem] font-semibold',
                    'label' => __('Urgent'),
                ];
            }

            if ($daysLeft <= 20) {
                return [
                    'class' => 'btn-tonal btn-tonal--amber !px-3 !py-1 text-[0.7rem] font-semibold',
                    'label' => __('Soon'),
                ];
            }

            return [
                'class' => 'btn-tonal btn-tonal--sky !px-3 !py-1 text-[0.7rem] font-semibold',
                'label' => __('Upcoming'),
            ];
        };
    @endphp

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 2xl:col-span-9 space-y-6">
            <!-- Hero summary -->
            <div class="intro-y mt-6">
                <div
                    class="rounded-2xl border border-white/10 text-white shadow-[0_25px_60px_rgba(15,31,61,0.35)]"
                    style="background: linear-gradient(135deg, var(--primary-color, #0f1f3d) 0%, var(--secondary-color, #1d3d8f) 45%, var(--accent-color, #0998d6) 100%);"
                >
                    <div class="flex flex-col gap-4 p-6 lg:flex-row lg:items-center">
                        <div class="flex-1">
                            <p class="text-sm uppercase tracking-[0.35em] text-white/80">HR Control Center</p>
                            <h2 class="mt-2 text-2xl font-semibold leading-tight lg:text-3xl">
                                People pulse for {{ config('app.name') }}
                            </h2>
                            <p class="mt-3 text-sm text-white/80">
                                {{ $activeEmployees }} active team members · {{ $departmentsCount }} departments · {{ $openPositions }} open roles
                            </p>
                        </div>
                        <div class="flex flex-col gap-3 text-sm font-medium lg:text-base">
                            <div class="flex items-center gap-2">
                                <x-base.lucide icon="Activity" class="h-5 w-5 text-lime-200" />
                                Presence rate
                                <span class="ml-auto rounded-full bg-white/20 px-3 py-1 text-sm font-semibold">
                                    {{ $presenceRate }}%
                                </span>
                            </div>
                            <div class="flex items-center gap-2">
                                <x-base.lucide icon="Clock8" class="h-5 w-5 text-amber-200" />
                                Present today
                                <span class="ml-auto text-white/90">{{ $presentToday }} / {{ $activeEmployees }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <x-base.lucide icon="Sun" class="h-5 w-5 text-rose-200" />
                                On leave today
                                <span class="ml-auto text-white/90">{{ $onLeaveToday }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="grid gap-4 border-t border-white/10 p-6 sm:grid-cols-2 lg:grid-cols-4">
                        <div class="rounded-2xl border border-white/15 bg-white/10 p-4 backdrop-blur-md shadow-lg shadow-primary/20">
                            <div class="flex items-center gap-4">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/20 text-white">
                                    <x-base.lucide icon="Users" class="h-6 w-6" />
                                </div>
                                <div>
                                    <p class="text-xs uppercase tracking-wide text-white/70">{{ __('Total Employees') }}</p>
                                    <p class="mt-1 text-2xl font-semibold">{{ number_format($totalEmployees) }}</p>
                                    <span class="text-xs text-white/60">{{ $activeEmployees }} {{ __('active') }} · {{ max(0, $totalEmployees - $activeEmployees) }} {{ __('inactive') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="rounded-2xl border border-white/15 bg-white/10 p-4 backdrop-blur-md shadow-lg shadow-sky-500/20">
                            <div class="flex items-center gap-4">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/20 text-white">
                                    <x-base.lucide icon="Briefcase" class="h-6 w-6" />
                                </div>
                                <div>
                                    <p class="text-xs uppercase tracking-wide text-white/70">{{ __('Open Positions') }}</p>
                                    <p class="mt-1 text-2xl font-semibold">{{ $openPositions }}</p>
                                    <span class="text-xs text-white/60">{{ $departmentsCount }} {{ __('departments hiring') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="rounded-2xl border border-white/15 bg-white/10 p-4 backdrop-blur-md shadow-lg shadow-rose-500/20">
                            <div class="flex items-center gap-4">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/20 text-white">
                                    <x-base.lucide icon="ClipboardList" class="h-6 w-6" />
                                </div>
                                <div>
                                    <p class="text-xs uppercase tracking-wide text-white/70">{{ __('Pending Approvals') }}</p>
                                    <p class="mt-1 text-2xl font-semibold">{{ $pendingApprovals }}</p>
                                    <span class="text-xs text-white/60">{{ __('Awaiting HR action') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="rounded-2xl border border-white/15 bg-white/10 p-4 backdrop-blur-md shadow-lg shadow-emerald-500/20">
                            <div class="flex items-center gap-4">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/20 text-white">
                                    <x-base.lucide icon="UserPlus" class="h-6 w-6" />
                                </div>
                                <div>
                                    <p class="text-xs uppercase tracking-wide text-white/70">{{ __('New Hires') }} ({{ now()->format('M') }})</p>
                                    <p class="mt-1 text-2xl font-semibold">{{ $newHiresThisMonth->count() }}</p>
                                    <span class="text-xs text-white/60">{{ __('Welcome aboard!') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- HR Analytics Charts -->
            <div class="grid grid-cols-12 gap-6">
                <div class="intro-y col-span-12 xl:col-span-8">
                    <div class="box h-full rounded-2xl p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-base font-semibold">Attendance Trend</h3>
                                <p class="text-xs text-slate-500">Last {{ ($attendanceTrendLabels ?? []) ? count($attendanceTrendLabels) : 7 }} days</p>
                            </div>
                            <x-base.lucide icon="Activity" class="h-5 w-5 text-emerald-500" />
                        </div>
                        <div class="mt-5 h-[260px]">
                            <canvas id="hr-attendance-chart" class="w-full h-full"></canvas>
                        </div>
                    </div>
                </div>

                <div class="intro-y col-span-12 xl:col-span-4">
                    <div class="box h-full rounded-2xl p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-base font-semibold">Workforce by Department</h3>
                                <p class="text-xs text-slate-500">Active employees distribution</p>
                            </div>
                            <x-base.lucide icon="PieChart" class="h-5 w-5 text-sky-500" />
                        </div>
                        <div class="mt-5 h-[260px]">
                            <canvas id="hr-departments-chart" class="w-full h-full"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-12 gap-6">
                <!-- Attendance snapshot -->
                <div class="intro-y col-span-12 xl:col-span-6">
                    <div class="box h-full rounded-2xl p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-base font-semibold">Attendance Snapshot</h3>
                                <p class="text-xs text-slate-500">{{ now()->format(setting('date_format', 'Y-m-d')) }}</p>
                            </div>
                            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600 dark:bg-darkmode-600 dark:text-slate-300">
                                {{ $presenceRate }}% presence
                            </span>
                        </div>
                        <div class="mt-5 space-y-3">
                            @foreach($attendanceStatuses as $status => $meta)
                                @php
                                    $value = (int) ($attendanceSummary[$status] ?? 0);
                                    $percent = $activeEmployees > 0 ? round(($value / $activeEmployees) * 100) : 0;
                                @endphp
                                <div>
                                    <div class="flex items-center text-sm font-medium text-slate-600 dark:text-slate-200">
                                        <span class="flex items-center gap-2 capitalize">
                                            <span class="h-2.5 w-2.5 rounded-full bg-{{ $meta['color'] }}-500/80"></span>
                                            {{ $meta['label'] }}
                                        </span>
                                        <span class="ml-auto text-sm text-slate-500">{{ $value }} · {{ $percent }}%</span>
                                    </div>
                                    <div class="mt-2 h-2 rounded-full bg-slate-100 dark:bg-darkmode-600">
                                        <div class="h-full rounded-full bg-{{ $meta['color'] }}-500" style="width: {{ $percent }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- New hires -->
                <div class="intro-y col-span-12 xl:col-span-6">
                    <div class="box h-full rounded-2xl p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-base font-semibold">New hires this month</h3>
                                <p class="text-xs text-slate-500">{{ $newHiresThisMonth->count() }} team members joined</p>
                            </div>
                            <x-base.lucide icon="Sparkles" class="h-5 w-5 text-amber-400" />
                        </div>
                        @if($newHiresThisMonth->isNotEmpty())
                            <div class="mt-5 space-y-4">
                                @foreach($newHiresThisMonth as $employee)
                                    <div class="flex items-center justify-between rounded-2xl border border-slate-100 px-3 py-2 shadow-sm dark:border-darkmode-500">
                                        <div class="flex items-center gap-3">
                                            <div class="h-12 w-12 overflow-hidden rounded-full ring-2 ring-slate-100 dark:ring-darkmode-400">
                                                <img
                                                    src="{{ $employee->profile_picture_url }}"
                                                    alt="{{ $employee->full_name }}"
                                                    class="h-full w-full object-cover"
                                                />
                                            </div>
                                            <div>
                                                <p class="font-semibold text-slate-800 dark:text-slate-100">{{ $employee->full_name }}</p>
                                                <p class="text-xs text-slate-500">
                                                    {{ $employee->position ?? '—' }}
                                                    @if($employee->department)
                                                        · {{ $employee->department->name }}
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-right text-xs text-slate-500">
                                            <p>Joined</p>
                                            <p class="font-semibold text-slate-700 dark:text-slate-200">
                                                {{ optional($employee->hire_date)->format(setting('date_format', 'Y-m-d')) ?? '—' }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="mt-10 text-center text-sm text-slate-500">
                                No new hires recorded this month.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Talent highlights -->
            <div class="grid grid-cols-12 gap-6">
                <div class="intro-y col-span-12 xl:col-span-6">
                    <div class="box rounded-2xl p-5">
                        <div class="flex items-center gap-2">
                            <x-base.lucide icon="Star" class="h-5 w-5 text-amber-400" />
                            <h3 class="text-base font-semibold">Top Rated Employees</h3>
                        </div>
                        @if(isset($topRatedEmployees) && $topRatedEmployees->count())
                            <div class="mt-5 space-y-4">
                                @foreach($topRatedEmployees as $emp)
                                    @php $rating = $emp->avg_rating ? round($emp->avg_rating, 1) : null; @endphp
                                    <div class="flex items-center justify-between rounded-2xl border border-slate-100 px-3 py-2 dark:border-darkmode-500">
                                        <div class="flex items-center gap-3">
                                            <div class="h-12 w-12 overflow-hidden rounded-full">
                                                <img src="{{ $emp->profile_picture_url ?? asset('build/assets/profile-1-0441b45e.jpg') }}" alt="{{ $emp->full_name }}" class="h-full w-full object-cover" />
                                            </div>
                                            <div>
                                                <p class="font-semibold">{{ $emp->full_name }}</p>
                                                <p class="text-xs text-slate-500">
                                                    {{ $emp->position ?? 'Employee' }}
                                                    @if($emp->department)
                                                        · {{ $emp->department->name }}
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="flex items-center justify-end text-xs">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @php $filled = $rating && $rating >= $i - 0.25; @endphp
                                                    <x-base.lucide icon="Star" class="h-4 w-4 {{ $filled ? 'text-amber-400 fill-amber-400/60' : 'text-slate-300 dark:text-slate-600' }}" />
                                                @endfor
                                            </div>
                                            <p class="text-xs text-slate-500">{{ $rating ? $rating . ' / 5' : 'Not rated' }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="mt-6 text-sm text-slate-500">No evaluations yet.</div>
                        @endif
                    </div>
                </div>

                <div class="intro-y col-span-12 xl:col-span-6">
                    <div class="box rounded-2xl p-5">
                        <div class="flex items-center gap-2">
                            <x-base.lucide icon="Award" class="h-5 w-5 text-emerald-500" />
                            <h3 class="text-base font-semibold">Top Rewarded Employees</h3>
                        </div>
                        @if(isset($topRewardedEmployees) && $topRewardedEmployees->count())
                            <div class="mt-5 space-y-4">
                                @foreach($topRewardedEmployees as $emp)
                                    @php $points = (int) ($emp->total_points ?? 0); @endphp
                                    <div class="flex items-center justify-between rounded-2xl border border-slate-100 px-3 py-2 dark:border-darkmode-500">
                                        <div class="flex items-center gap-3">
                                            <div class="h-12 w-12 overflow-hidden rounded-full">
                                                <img src="{{ $emp->profile_picture_url ?? asset('build/assets/profile-1-0441b45e.jpg') }}" alt="{{ $emp->full_name }}" class="h-full w-full object-cover" />
                                            </div>
                                            <div>
                                                <p class="font-semibold">{{ $emp->full_name }}</p>
                                                <p class="text-xs text-slate-500">
                                                    {{ $emp->position ?? 'Employee' }}
                                                    @if($emp->department)
                                                        · {{ $emp->department->name }}
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-semibold text-emerald-600 dark:text-emerald-400">{{ $points }} pts</p>
                                            <div class="mt-1 h-1.5 w-24 rounded-full bg-slate-100 dark:bg-darkmode-600">
                                                @php $progress = min(100, $points); @endphp
                                                <div class="h-full rounded-full bg-emerald-500" style="width: {{ $progress }}%"></div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="mt-6 text-sm text-slate-500">No rewards recorded yet.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-span-12 2xl:col-span-3 space-y-6">
            <!-- Quick shortcuts -->
            <div class="intro-y box mt-6 rounded-2xl p-5">
                <div class="flex items-center justify-between">
                    <h3 class="text-base font-semibold">Quick Shortcuts</h3>
                    <x-base.lucide icon="Zap" class="h-5 w-5 text-warning" />
                </div>
                <div class="mt-4 space-y-3 text-sm">
                    <a href="{{ route('hr.employees.index') }}" class="flex items-center justify-between rounded-xl bg-slate-50 px-3 py-2 text-slate-700 hover:bg-slate-100 dark:bg-darkmode-600 dark:text-slate-200">
                        <span class="flex items-center gap-2">
                            <x-base.lucide icon="Users" class="h-4 w-4" /> Employees
                        </span>
                        <x-base.lucide icon="ArrowUpRight" class="h-4 w-4" />
                    </a>
                    <a href="{{ route('hr.attendance.index') }}" class="flex items-center justify-between rounded-xl bg-slate-50 px-3 py-2 text-slate-700 hover:bg-slate-100 dark:bg-darkmode-600 dark:text-slate-200">
                        <span class="flex items-center gap-2">
                            <x-base.lucide icon="Clock" class="h-4 w-4" /> Attendance
                        </span>
                        <x-base.lucide icon="ArrowUpRight" class="h-4 w-4" />
                    </a>
                    <a href="{{ route('hr.payroll.index') }}" class="flex items-center justify-between rounded-xl bg-slate-50 px-3 py-2 text-slate-700 hover:bg-slate-100 dark:bg-darkmode-600 dark:text-slate-200">
                        <span class="flex items-center gap-2">
                            <x-base.lucide icon="Wallet" class="h-4 w-4" /> Payroll
                        </span>
                        <x-base.lucide icon="ArrowUpRight" class="h-4 w-4" />
                    </a>
                </div>
            </div>

            <!-- Upcoming birthdays -->
            <div class="intro-y box rounded-2xl p-5">
                <div class="flex items-center justify-between">
                    <h3 class="text-base font-semibold">Upcoming Birthdays</h3>
                    <x-base.lucide icon="Cake" class="h-5 w-5 text-pink-400" />
                </div>
                @if($upcomingBirthdays->isNotEmpty())
                    <div class="mt-4 space-y-4 text-sm">
                        @foreach($upcomingBirthdays as $employee)
                            @php
                                $birthday = $employee->birth_date?->copy()->setYear(now()->year);
                                if($birthday && $birthday->isBefore(now())) {
                                    $birthday = $birthday->copy()->addYear();
                                }
                                $days = $birthday ? now()->diffInDays($birthday) : null;
                            @endphp
                            <div class="flex items-center justify-between rounded-2xl border border-slate-100 px-3 py-2 dark:border-darkmode-500">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 overflow-hidden rounded-full">
                                        <img src="{{ $employee->profile_picture_url }}" alt="{{ $employee->full_name }}" class="h-full w-full object-cover" />
                                    </div>
                                    <div>
                                        <p class="font-semibold">{{ $employee->full_name }}</p>
                                        <p class="text-xs text-slate-500">{{ optional($employee->department)->name ?? '—' }}</p>
                                    </div>
                                </div>
                                <div class="text-right text-xs text-slate-500">
                                    <p>{{ optional($employee->birth_date)->format('M d') }}</p>
                                    <p class="font-semibold text-slate-600">{{ $days === 0 ? 'Today' : $days . ' days' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="mt-6 text-sm text-slate-500">No birthdays in the coming days.</div>
                @endif
            </div>

            <!-- Documents expiring -->
            <div class="intro-y box rounded-2xl p-5">
                <div class="flex items-center justify-between">
                    <h3 class="text-base font-semibold flex items-center gap-2">
                        <x-base.lucide icon="FileWarning" class="h-5 w-5 text-warning" />
                        Company Documents
                    </h3>
                    <span class="text-xs text-slate-500">Next {{ $hrExpiryDays }} days</span>
                </div>
                @if(isset($hrExpiringDocuments) && $hrExpiringDocuments->count())
                    <div class="mt-4 space-y-3 text-sm max-h-72 overflow-y-auto">
                        @foreach($hrExpiringDocuments as $doc)
                            @php $days = $doc->days_until_expiry; @endphp
                            <div class="rounded-2xl border border-slate-100 p-3 dark:border-darkmode-500">
                                <p class="font-semibold text-slate-800 dark:text-slate-100 truncate">{{ $doc->title ?? $doc->file_name }}</p>
                                <div class="mt-1 flex items-center text-xs text-slate-500">
                                    <x-base.lucide icon="Calendar" class="mr-1 h-3.5 w-3.5" />
                                    {{ optional($doc->expiry_date)->format(setting('date_format', 'Y-m-d')) }}
                                    <span class="ml-auto rounded-full px-2 py-0.5 text-[11px]
                                        @if($days <= 0)
                                            bg-red-100 text-red-700
                                        @elseif($days <= 7)
                                            bg-orange-100 text-orange-700
                                        @else
                                            bg-amber-100 text-amber-700
                                        @endif
                                    ">
                                        @if($days <= 0)
                                            Expired
                                        @else
                                            {{ $days }} days left
                                        @endif
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="mt-6 text-sm text-slate-500">No expiring documents.</div>
                @endif
            </div>

            <!-- Employee documents expiring -->
            <div class="intro-y box rounded-2xl p-5">
                <div class="flex items-center justify-between">
                    <h3 class="text-base font-semibold flex items-center gap-2">
                        <x-base.lucide icon="IdCard" class="h-5 w-5 text-sky-500" />
                        Employee Documents
                    </h3>
                    <span class="text-xs text-slate-500">Next {{ $hrEmployeeExpiryDays }} days</span>
                </div>
                @if(isset($hrEmployeeExpiringDocuments) && $hrEmployeeExpiringDocuments->count())
                    <div class="mt-4 space-y-3 text-sm max-h-72 overflow-y-auto">
                        @foreach($hrEmployeeExpiringDocuments as $doc)
                            @php
                                $days = $doc->expiry_date ? $doc->expiry_date->diffInDays(now(), false) : null;
                                $employee = $doc->employee;
                            @endphp
                            <div class="flex items-start gap-3 rounded-2xl border border-slate-100 p-3 dark:border-darkmode-500">
                                <div class="h-10 w-10 flex-none overflow-hidden rounded-full">
                                    @if($employee)
                                        <img src="{{ $employee->profile_picture_url }}" alt="{{ $employee->full_name }}" class="h-full w-full object-cover" />
                                    @else
                                        <div class="flex h-full w-full items-center justify-center bg-slate-100 text-xs text-slate-500">N/A</div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-slate-800 dark:text-slate-100">{{ $doc->document_name }}</p>
                                    <p class="text-xs text-slate-500">
                                    @if($employee)
                                        {{ $employee->full_name }}
                                        @if($employee->department)
                                            · {{ $employee->department->name }}
                                        @endif
                                    @else
                                        Unknown employee
                                    @endif
                                    </p>
                                    <div class="mt-1 flex items-center text-xs text-slate-500">
                                        <x-base.lucide icon="Calendar" class="mr-1 h-3.5 w-3.5" />
                                        {{ optional($doc->expiry_date)->format(setting('date_format', 'Y-m-d')) }}
                                        @if(!is_null($days))
                                            <span class="ml-auto rounded-full px-2 py-0.5 text-[11px]
                                                @if($days <= 0)
                                                    bg-red-100 text-red-700
                                                @elseif($days <= 7)
                                                    bg-orange-100 text-orange-700
                                                @else
                                                    bg-amber-100 text-amber-700
                                                @endif
                                            ">
                                                @if($days <= 0)
                                                    Expired
                                                @else
                                                    {{ $days }} days left
                                                @endif
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                @if($employee)
                                    <a href="{{ route('hr.employees.documents.index', $employee->id) }}" class="btn-tonal btn-tonal--icon btn-tonal--info" title="View documents">
                                        <x-base.lucide icon="ExternalLink" class="h-4 w-4" />
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="mt-6 text-sm text-slate-500">No employee documents expiring soon.</div>
                @endif
            </div>
        </div>

        <!-- Passport & Visa expiry trackers -->
        <div class="col-span-12">
            <div class="grid grid-cols-12 gap-6">
                <div class="intro-y col-span-12 lg:col-span-6">
                    <div class="box rounded-2xl p-5 h-full">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-base font-semibold flex items-center gap-2">
                                    <x-base.lucide icon="Globe" class="h-5 w-5 text-sky-500" />
                                    {{ __('Passports Expiring Soon') }}
                                </h3>
                                <p class="text-xs text-slate-500">{{ __('Nearest 10 passports to expire') }}</p>
                            </div>
                            <x-base.lucide icon="AlertTriangle" class="h-5 w-5 text-amber-400" />
                        </div>
                        @if($upcomingPassports->isNotEmpty())
                            <div class="mt-5 space-y-4">
                                @foreach($upcomingPassports as $passport)
                                    @php
                                        $daysLeft = $passport->expiry_date ? now()->diffInDays($passport->expiry_date, false) : null;
                                        $tone = $getExpiryTone($daysLeft);
                                        $employee = $passport->employee;
                                    @endphp
                                    <div class="flex items-start gap-3 rounded-2xl border border-slate-100 p-3 dark:border-darkmode-500">
                                        <div class="h-11 w-11 flex-none overflow-hidden rounded-full">
                                            @if($employee)
                                                <img src="{{ $employee->profile_picture_url }}" alt="{{ $employee->full_name }}" class="h-full w-full object-cover" />
                                            @else
                                                <div class="flex h-full w-full items-center justify-center bg-slate-100 text-xs text-slate-500">N/A</div>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2">
                                                <p class="font-semibold text-sm text-slate-800 dark:text-slate-100">
                                                    {{ $employee->full_name ?? __('Unknown Employee') }}
                                                </p>
                                                <span class="inline-flex items-center gap-1 rounded-full {{ $tone['class'] }}">
                                                    <x-base.lucide icon="Timer" class="h-3.5 w-3.5" />
                                                    @if(is_null($daysLeft))
                                                        {{ $tone['label'] }}
                                                    @elseif($daysLeft <= 0)
                                                        {{ __('Expired') }}
                                                    @else
                                                        {{ $daysLeft }} {{ __('days') }}
                                                    @endif
                                                </span>
                                            </div>
                                            <p class="text-xs text-slate-500">
                                                {{ __('Passport') }} · {{ optional($passport->expiry_date)->format(setting('date_format', 'Y-m-d')) }}
                                                @if($employee && $employee->department)
                                                    · {{ $employee->department->name }}
                                                @endif
                                            </p>
                                        </div>
                                        <div class="text-xs text-slate-500 text-right">
                                            <p class="font-semibold">{{ $passport->document_number ?? __('No number') }}</p>
                                            <p>{{ __('Code:') }} {{ $employee->code ?? '—' }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="mt-10 text-center text-sm text-slate-500">
                                {{ __('No passports nearing expiry.') }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="intro-y col-span-12 lg:col-span-6">
                    <div class="box rounded-2xl p-5 h-full">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-base font-semibold flex items-center gap-2">
                                    <x-base.lucide icon="Plane" class="h-5 w-5 text-emerald-500" />
                                    {{ __('Visas Expiring Soon') }}
                                </h3>
                                <p class="text-xs text-slate-500">{{ __('Nearest 10 visas to expire') }}</p>
                            </div>
                            <x-base.lucide icon="AlertTriangle" class="h-5 w-5 text-rose-400" />
                        </div>
                        @if($upcomingVisas->isNotEmpty())
                            <div class="mt-5 space-y-4">
                                @foreach($upcomingVisas as $visa)
                                    @php
                                        $daysLeft = $visa->expiry_date ? now()->diffInDays($visa->expiry_date, false) : null;
                                        $tone = $getExpiryTone($daysLeft);
                                        $employee = $visa->employee;
                                    @endphp
                                    <div class="flex items-start gap-3 rounded-2xl border border-slate-100 p-3 dark:border-darkmode-500">
                                        <div class="h-11 w-11 flex-none overflow-hidden rounded-full">
                                            @if($employee)
                                                <img src="{{ $employee->profile_picture_url }}" alt="{{ $employee->full_name }}" class="h-full w-full object-cover" />
                                            @else
                                                <div class="flex h-full w-full items-center justify-center bg-slate-100 text-xs text-slate-500">N/A</div>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2">
                                                <p class="font-semibold text-sm text-slate-800 dark:text-slate-100">
                                                    {{ $employee->full_name ?? __('Unknown Employee') }}
                                                </p>
                                                <span class="inline-flex items-center gap-1 rounded-full {{ $tone['class'] }}">
                                                    <x-base.lucide icon="Timer" class="h-3.5 w-3.5" />
                                                    @if(is_null($daysLeft))
                                                        {{ $tone['label'] }}
                                                    @elseif($daysLeft <= 0)
                                                        {{ __('Expired') }}
                                                    @else
                                                        {{ $daysLeft }} {{ __('days') }}
                                                    @endif
                                                </span>
                                            </div>
                                            <p class="text-xs text-slate-500">
                                                {{ __('Visa') }} · {{ optional($visa->expiry_date)->format(setting('date_format', 'Y-m-d')) }}
                                                @if($employee && $employee->department)
                                                    · {{ $employee->department->name }}
                                                @endif
                                            </p>
                                        </div>
                                        <div class="text-xs text-slate-500 text-right">
                                            <p class="font-semibold">{{ $visa->document_number ?? __('No number') }}</p>
                                            <p>{{ __('Code:') }} {{ $employee->code ?? '—' }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="mt-10 text-center text-sm text-slate-500">
                                {{ __('No visas nearing expiry.') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Attendance trend line chart
            const attendanceCanvas = document.getElementById('hr-attendance-chart');
            if (attendanceCanvas && typeof Chart !== 'undefined') {
                const attendanceLabels = @json($attendanceTrendLabels ?? []);
                const attendanceData = @json($attendanceTrendData ?? []);

                if (attendanceLabels.length && attendanceData.length) {
                    const ctx = attendanceCanvas.getContext('2d');

                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: attendanceLabels,
                            datasets: [
                                {
                                    label: 'Presence rate %',
                                    data: attendanceData,
                                    borderColor: 'rgba(34, 197, 94, 1)', // emerald-500
                                    backgroundColor: 'rgba(34, 197, 94, 0.15)',
                                    borderWidth: 2,
                                    fill: true,
                                    tension: 0.35,
                                    pointRadius: 3,
                                    pointBackgroundColor: 'rgba(34, 197, 94, 1)',
                                },
                            ],
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    max: 100,
                                    ticks: {
                                        callback: function (value) {
                                            return value + '%';
                                        },
                                    },
                                },
                            },
                            plugins: {
                                legend: {
                                    display: false,
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function (context) {
                                            return context.parsed.y + '% presence';
                                        },
                                    },
                                },
                            },
                        },
                    });
                }
            }

            // Workforce by department donut chart
            const departmentCanvas = document.getElementById('hr-departments-chart');
            if (departmentCanvas && typeof Chart !== 'undefined') {
                const departmentLabels = @json($departmentDistributionLabels ?? []);
                const departmentData = @json($departmentDistributionData ?? []);

                if (departmentLabels.length && departmentData.length) {
                    const ctx = departmentCanvas.getContext('2d');

                    const baseColors = [
                        '#0ea5e9', // sky-500
                        '#6366f1', // indigo-500
                        '#f97316', // orange-500
                        '#22c55e', // green-500
                        '#ec4899', // pink-500
                        '#eab308', // yellow-500
                    ];

                    const colors = departmentLabels.map((_, index) => {
                        return baseColors[index % baseColors.length];
                    });

                    new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: departmentLabels,
                            datasets: [
                                {
                                    data: departmentData,
                                    backgroundColor: colors.map(color => color + 'CC'),
                                    borderColor: colors,
                                    borderWidth: 2,
                                },
                            ],
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        usePointStyle: true,
                                        padding: 16,
                                    },
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function (context) {
                                            const label = context.label || '';
                                            const value = context.parsed;
                                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                            const percentage = total ? Math.round((value / total) * 100) : 0;
                                            return `${label}: ${value} (${percentage}%)`;
                                        },
                                    },
                                },
                            },
                            cutout: '65%',
                        },
                    });
                }
            }
        });
    </script>
@endpush

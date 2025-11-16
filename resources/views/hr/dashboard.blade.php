@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>HR Dashboard - Smart ERP</title>
@endsection

@section('subcontent')
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 xl:col-span-9">
            <div class="intro-y flex items-center mt-6 mb-4">
                <h2 class="mr-5 text-lg font-medium">Human Resources Overview</h2>
            </div>
            <div class="grid grid-cols-12 gap-6">
                <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                    <div class="box p-5">
                        <div class="flex items-center">
                            <x-base.lucide icon="Users" class="w-6 h-6 text-primary" />
                            <span class="ml-auto text-xs text-slate-500">Employees</span>
                        </div>
                        <div class="mt-4 text-3xl font-semibold">--</div>
                        <div class="mt-1 text-xs text-slate-500">Active employees</div>
                    </div>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                    <div class="box p-5">
                        <div class="flex items-center">
                            <x-base.lucide icon="Clock" class="w-6 h-6 text-warning" />
                            <span class="ml-auto text-xs text-slate-500">Attendance</span>
                        </div>
                        <div class="mt-4 text-3xl font-semibold">--</div>
                        <div class="mt-1 text-xs text-slate-500">Today status</div>
                    </div>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                    <div class="box p-5">
                        <div class="flex items-center">
                            <x-base.lucide icon="Calendar" class="w-6 h-6 text-success" />
                            <span class="ml-auto text-xs text-slate-500">Leave</span>
                        </div>
                        <div class="mt-4 text-3xl font-semibold">--</div>
                        <div class="mt-1 text-xs text-slate-500">On leave today</div>
                    </div>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                    <div class="box p-5">
                        <div class="flex items-center">
                            <x-base.lucide icon="DollarSign" class="w-6 h-6 text-info" />
                            <span class="ml-auto text-xs text-slate-500">Payroll</span>
                        </div>
                        <div class="mt-4 text-3xl font-semibold">--</div>
                        <div class="mt-1 text-xs text-slate-500">Current cycle</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-span-12 xl:col-span-3 mt-6 xl:mt-6">
            <div class="intro-y box p-5">
                <div class="flex items-center mb-3">
                    <h2 class="text-base font-medium">HR Shortcuts</h2>
                </div>
                <div class="space-y-2 text-sm">
                    <a href="{{ route('hr.employees.index') }}" class="flex items-center px-3 py-2 rounded-lg bg-slate-50 hover:bg-slate-100 dark:bg-darkmode-600 dark:hover:bg-darkmode-500">
                        <x-base.lucide icon="Users" class="w-4 h-4 mr-2" />
                        Employees
                    </a>
                    <a href="{{ route('hr.attendance.index') }}" class="flex items-center px-3 py-2 rounded-lg bg-slate-50 hover:bg-slate-100 dark:bg-darkmode-600 dark:hover:bg-darkmode-500">
                        <x-base.lucide icon="Clock" class="w-4 h-4 mr-2" />
                        Attendance
                    </a>
                    <a href="{{ route('hr.payroll.index') }}" class="flex items-center px-3 py-2 rounded-lg bg-slate-50 hover:bg-slate-100 dark:bg-darkmode-600 dark:hover:bg-darkmode-500">
                        <x-base.lucide icon="DollarSign" class="w-4 h-4 mr-2" />
                        Payroll
                    </a>
                </div>
            </div>
            
            <!-- Documents expiring soon -->
            <div class="intro-y box p-5 mt-6">
                <div class="flex items-center mb-3">
                    <h2 class="text-base font-medium flex items-center">
                        <x-base.lucide icon="FileWarning" class="w-4 h-4 mr-2 text-warning" />
                        Documents expiring soon
                    </h2>
                    <span class="ml-auto text-xs text-slate-500">Next {{ $hrExpiryDays }} days</span>
                </div>

                @if(isset($hrExpiringDocuments) && $hrExpiringDocuments->count())
                    <div class="space-y-3 text-sm max-h-64 overflow-y-auto">
                        @foreach($hrExpiringDocuments as $doc)
                            <div class="flex items-start justify-between">
                                <div class="mr-2">
                                    <div class="font-medium text-slate-800 dark:text-slate-100 truncate max-w-[180px]">
                                        {{ $doc->title ?? $doc->file_name }}
                                    </div>
                                    <div class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-2 mt-0.5">
                                        <span>{{ optional($doc->expiry_date)->format(setting('date_format', 'Y-m-d')) }}</span>
                                        @php $days = $doc->days_until_expiry; @endphp
                                        <span class="px-2 py-0.5 rounded-full text-[11px]
                                            @if($days <= 0)
                                                bg-red-100 text-red-700
                                            @elseif($days <= 7)
                                                bg-orange-100 text-orange-700
                                            @else
                                                bg-yellow-100 text-yellow-700
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
                                <a
                                    href="{{ $doc->file_url }}"
                                    target="_blank"
                                    class="flex items-center text-xs text-primary hover:text-primary/80"
                                >
                                    <x-base.lucide icon="ExternalLink" class="w-4 h-4" />
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-xs text-slate-500 dark:text-slate-400">
                        No documents are expiring in the next {{ $hrExpiryDays }} days.
                    </div>
                @endif
            </div>

            <!-- Employee documents expiring soon -->
            <div class="intro-y box p-5 mt-6">
                <div class="flex items-center mb-3">
                    <h2 class="text-base font-medium flex items-center">
                        <x-base.lucide icon="IdCard" class="w-4 h-4 mr-2 text-warning" />
                        Employee documents expiring soon
                    </h2>
                    <span class="ml-auto text-xs text-slate-500">Next {{ $hrEmployeeExpiryDays }} days</span>
                </div>

                @if(isset($hrEmployeeExpiringDocuments) && $hrEmployeeExpiringDocuments->count())
                    <div class="space-y-3 text-sm max-h-64 overflow-y-auto">
                        @foreach($hrEmployeeExpiringDocuments as $doc)
                            <div class="flex items-start justify-between">
                                <div class="mr-2">
                                    <div class="font-medium text-slate-800 dark:text-slate-100 truncate max-w-[180px]">
                                        {{ $doc->document_name }}
                                    </div>
                                    <div class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                        <span class="font-medium">{{ $doc->employee->full_name ?? 'Unknown employee' }}</span>
                                    </div>
                                    <div class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-2 mt-0.5">
                                        <span>{{ optional($doc->expiry_date)->format(setting('date_format', 'Y-m-d')) }}</span>
                                        @php
                                            $days = $doc->expiry_date ? $doc->expiry_date->diffInDays(now(), false) : null;
                                        @endphp
                                        @if(!is_null($days))
                                            <span class="px-2 py-0.5 rounded-full text-[11px]
                                                @if($days <= 0)
                                                    bg-red-100 text-red-700
                                                @elseif($days <= 7)
                                                    bg-orange-100 text-orange-700
                                                @else
                                                    bg-yellow-100 text-yellow-700
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
                                <a
                                    href="{{ route('hr.employees.documents.index', $doc->employee_id) }}"
                                    class="flex items-center text-xs text-primary hover:text-primary/80"
                                >
                                    <x-base.lucide icon="ExternalLink" class="w-4 h-4" />
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-xs text-slate-500 dark:text-slate-400">
                        No employee documents are expiring in the next {{ $hrEmployeeExpiryDays }} days.
                    </div>
                @endif
            </div>

            <!-- Top Rated Employees -->
            <div class="intro-y box p-5 mt-6">
                <div class="flex items-center mb-3">
                    <h2 class="text-base font-medium flex items-center">
                        <x-base.lucide icon="Star" class="w-4 h-4 mr-2 text-amber-400" />
                        Top Rated Employees
                    </h2>
                </div>

                @if(isset($topRatedEmployees) && $topRatedEmployees->count())
                    <div class="space-y-3 text-sm">
                        @foreach($topRatedEmployees as $emp)
                            @php $rating = $emp->avg_rating ? round($emp->avg_rating, 1) : null; @endphp
                            <div class="flex items-center justify-between rounded-lg border border-slate-200/60 px-3 py-2 dark:border-darkmode-400 hover:bg-slate-50 dark:hover:bg-darkmode-600 transition-colors">
                                <div class="mr-2">
                                    <div class="font-medium text-slate-800 dark:text-slate-100 text-sm truncate max-w-[140px]">
                                        {{ $emp->full_name }}
                                    </div>
                                    <div class="text-[11px] text-slate-500 dark:text-slate-400">
                                        {{ $emp->position ?? 'Employee' }}
                                        @if($emp->department)
                                            · {{ $emp->department->name }}
                                        @endif
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="flex items-center justify-end text-xs">
                                        @for($i = 1; $i <= 5; $i++)
                                            @php $filled = $rating && $rating >= $i - 0.25; @endphp
                                            <x-base.lucide icon="Star" class="w-3 h-3 ml-0.5 {{ $filled ? 'text-amber-400 fill-amber-300/80' : 'text-slate-300 dark:text-slate-600' }}" />
                                        @endfor
                                    </div>
                                    <div class="text-[11px] text-slate-400 mt-0.5">{{ $rating ? $rating . ' / 5' : 'Not rated' }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-xs text-slate-500 dark:text-slate-400">
                        No evaluations yet.
                    </div>
                @endif
            </div>

            <!-- Top Rewarded Employees -->
            <div class="intro-y box p-5 mt-6">
                <div class="flex items-center mb-3">
                    <h2 class="text-base font-medium flex items-center">
                        <x-base.lucide icon="Award" class="w-4 h-4 mr-2 text-emerald-500" />
                        Top Rewarded Employees
                    </h2>
                </div>

                @if(isset($topRewardedEmployees) && $topRewardedEmployees->count())
                    <div class="space-y-3 text-sm">
                        @foreach($topRewardedEmployees as $emp)
                            @php $points = (int) ($emp->total_points ?? 0); @endphp
                            <div class="flex items-center justify-between rounded-lg border border-slate-200/60 px-3 py-2 dark:border-darkmode-400 hover:bg-slate-50 dark:hover:bg-darkmode-600 transition-colors">
                                <div class="mr-2">
                                    <div class="font-medium text-slate-800 dark:text-slate-100 text-sm truncate max-w-[140px]">
                                        {{ $emp->full_name }}
                                    </div>
                                    <div class="text-[11px] text-slate-500 dark:text-slate-400">
                                        {{ $emp->position ?? 'Employee' }}
                                        @if($emp->department)
                                            · {{ $emp->department->name }}
                                        @endif
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-xs font-semibold text-emerald-600 dark:text-emerald-400">{{ $points }} pts</div>
                                    <div class="mt-1 h-1.5 w-16 overflow-hidden rounded-full bg-slate-100 dark:bg-darkmode-600">
                                        @php $progress = min(100, ($points / 100) * 100); @endphp
                                        <div class="h-full rounded-full bg-emerald-500 transition-all duration-500" style="width: {{ $progress }}%"></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-xs text-slate-500 dark:text-slate-400">
                        No rewards yet.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

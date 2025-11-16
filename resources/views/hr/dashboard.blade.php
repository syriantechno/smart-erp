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
        </div>
    </div>
@endsection

@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Reward Details - {{ $reward->employee->full_name ?? 'Employee' }}</title>
@endsection

@section('subcontent')
    @include('components.global-notifications')

    {{-- Page Header --}}
    <div class="intro-y mt-6 mb-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <h2 class="text-2xl font-semibold text-royalDark flex items-center gap-2">
            <x-base.lucide icon="gift" class="w-7 h-7" style="color: #303030;" />
            Reward Details
        </h2>
        <div class="flex items-center gap-2">
            <a href="{{ route('hr.employee-rewards.index') }}" class="btn-royal btn-royal--outline btn-royal--sm">
                <x-base.lucide icon="arrow-left" class="w-4 h-4 mr-1" />
                Back
            </a>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="grid grid-cols-12 gap-6">
        {{-- Left Column - Employee Profile Card --}}
        <div class="col-span-12 lg:col-span-4 2xl:col-span-3">
            {{-- Employee Profile Card --}}
            <div class="intro-y box overflow-hidden">
                <!-- Cover Image & Profile Picture -->
                <div class="relative">
                    <div class="h-32 bg-gradient-to-r from-emerald-400 via-teal-400 to-cyan-400">
                        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20100%20100%22%3E%3Ccircle%20cx%3D%2250%22%20cy%3D%2250%22%20r%3D%2240%22%20fill%3D%22none%22%20stroke%3D%22rgba(255%2C255%2C255%2C0.2)%22%20stroke-width%3D%222%22%2F%3E%3Ccircle%20cx%3D%2250%22%20cy%3D%2250%22%20r%3D%2230%22%20fill%3D%22none%22%20stroke%3D%22rgba(255%2C255%2C255%2C0.15)%22%20stroke-width%3D%222%22%2F%3E%3Ccircle%20cx%3D%2250%22%20cy%3D%2250%22%20r%3D%2220%22%20fill%3D%22none%22%20stroke%3D%22rgba(255%2C255%2C255%2C0.1)%22%20stroke-width%3D%222%22%2F%3E%3C%2Fsvg%3E')] bg-cover opacity-50"></div>
                    </div>
                    <div class="absolute -bottom-12 left-1/2 -translate-x-1/2">
                        <div class="h-24 w-24 rounded-full border-4 border-white dark:border-darkmode-600 overflow-hidden shadow-lg bg-white">
                            @if($reward->employee->profile_picture)
                                <img class="h-full w-full object-cover" src="{{ asset('storage/' . $reward->employee->profile_picture) }}" alt="{{ $reward->employee->full_name }}" />
                            @else
                                <div class="h-full w-full flex items-center justify-center bg-slate-100">
                                    <x-base.lucide icon="user" class="w-10 h-10 text-slate-400" />
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Name & Position -->
                <div class="pt-14 pb-5 px-5 text-center">
                    <a href="{{ route('hr.employees.show', $reward->employee) }}" class="text-xl font-semibold text-slate-800 dark:text-white hover:text-primary">
                        {{ $reward->employee->full_name ?? 'N/A' }}
                    </a>
                    <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">{{ $reward->employee->position ?? 'Employee' }}</p>
                    <div class="flex items-center justify-center gap-2 mt-2">
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300">
                            {{ $reward->employee->code ?? $reward->employee->employee_id ?? '-' }}
                        </span>
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $reward->employee->is_active ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' }}">
                            {{ $reward->employee->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>

                <!-- Employment Information -->
                <div class="border-t border-slate-200/60 dark:border-darkmode-400 px-5 py-5">
                    <h4 class="text-base font-semibold text-slate-800 dark:text-white mb-4">Employment Info</h4>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-slate-600 dark:text-slate-400">
                                <x-base.lucide icon="building-2" class="w-4 h-4 mr-3 text-slate-400" />
                                <span class="text-sm">Department</span>
                            </div>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300 truncate max-w-[120px]">{{ $reward->employee->department->name ?? '-' }}</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-slate-600 dark:text-slate-400">
                                <x-base.lucide icon="briefcase" class="w-4 h-4 mr-3 text-slate-400" />
                                <span class="text-sm">Position</span>
                            </div>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300 truncate max-w-[120px]">{{ $reward->employee->position ?? '-' }}</span>
                        </div>

                        @if($reward->employee->phone)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-slate-600 dark:text-slate-400">
                                <x-base.lucide icon="phone" class="w-4 h-4 mr-3 text-slate-400" />
                                <span class="text-sm">Phone</span>
                            </div>
                            <a href="tel:{{ $reward->employee->phone }}" class="text-sm font-medium text-primary hover:underline">{{ $reward->employee->phone }}</a>
                        </div>
                        @endif

                        @if($reward->employee->email)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-slate-600 dark:text-slate-400">
                                <x-base.lucide icon="mail" class="w-4 h-4 mr-3 text-slate-400" />
                                <span class="text-sm">Email</span>
                            </div>
                            <a href="mailto:{{ $reward->employee->email }}" class="text-sm font-medium text-primary hover:underline truncate max-w-[120px]">{{ $reward->employee->email }}</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column - Reward Details --}}
        <div class="col-span-12 lg:col-span-8 2xl:col-span-9">
            {{-- Reward Summary Card --}}
            <div class="intro-y box p-5 mb-5">
                <h4 class="text-sm font-semibold text-slate-600 dark:text-slate-300 mb-4 flex items-center gap-2">
                    <x-base.lucide icon="gift" class="w-4 h-4" />
                    Reward Summary
                </h4>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    {{-- Points --}}
                    <div class="text-center p-4 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800">
                        <div class="text-4xl font-bold text-green-600 dark:text-green-400">
                            +{{ $reward->points }}
                        </div>
                        <div class="text-sm text-green-700 dark:text-green-300 mt-1">Points Earned</div>
                    </div>
                    
                    {{-- Amount --}}
                    <div class="text-center p-4 rounded-lg bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800">
                        <div class="text-4xl font-bold text-amber-600 dark:text-amber-400">
                            {{ $reward->amount ? number_format($reward->amount, 2) : '-' }}
                        </div>
                        <div class="text-sm text-amber-700 dark:text-amber-300 mt-1">Bonus Amount</div>
                    </div>
                    
                    {{-- Type --}}
                    <div class="text-center p-4 rounded-lg bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800">
                        <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                            {{ ucfirst($reward->type ?? 'General') }}
                        </div>
                        <div class="text-sm text-blue-700 dark:text-blue-300 mt-1">Reward Type</div>
                    </div>
                </div>
            </div>

            {{-- Reward Details Card --}}
            <div class="intro-y box p-5 mb-5">
                <h4 class="text-sm font-semibold text-slate-600 dark:text-slate-300 mb-4 flex items-center gap-2">
                    <x-base.lucide icon="info" class="w-4 h-4" />
                    Reward Details
                </h4>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                        <div class="flex items-center text-slate-600 dark:text-slate-400">
                            <x-base.lucide icon="calendar" class="w-4 h-4 mr-3 text-slate-400" />
                            <span>Date Granted</span>
                        </div>
                        <span class="font-medium text-slate-700 dark:text-slate-300">
                            {{ optional($reward->granted_at ?? $reward->created_at)->format('F d, Y') }}
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-between py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                        <div class="flex items-center text-slate-600 dark:text-slate-400">
                            <x-base.lucide icon="user-check" class="w-4 h-4 mr-3 text-slate-400" />
                            <span>Granted By</span>
                        </div>
                        <span class="font-medium text-slate-700 dark:text-slate-300">
                            {{ $reward->granter->name ?? 'System' }}
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-between py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                        <div class="flex items-center text-slate-600 dark:text-slate-400">
                            <x-base.lucide icon="clock" class="w-4 h-4 mr-3 text-slate-400" />
                            <span>Created At</span>
                        </div>
                        <span class="font-medium text-slate-700 dark:text-slate-300">
                            {{ $reward->created_at->format('F d, Y h:i A') }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Reason Card --}}
            @if($reward->reason)
            <div class="intro-y box p-5">
                <h4 class="text-sm font-semibold text-slate-600 dark:text-slate-300 mb-4 flex items-center gap-2">
                    <x-base.lucide icon="message-square" class="w-4 h-4" />
                    Reason / Notes
                </h4>
                
                <div class="p-4 rounded-lg bg-slate-50 dark:bg-darkmode-600/50">
                    <p class="text-slate-700 dark:text-slate-300 whitespace-pre-wrap">{{ $reward->reason }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection

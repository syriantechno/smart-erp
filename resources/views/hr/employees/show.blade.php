@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>{{ $employee->full_name }} - Employee Profile</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">{{ $employee->full_name }} Profile</h2>
    </div>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <!-- BEGIN: Profile Card -->
        <div class="col-span-12 flex flex-col-reverse lg:col-span-4 lg:block 2xl:col-span-3">
            <div class="intro-y box mt-5 lg:mt-0 overflow-hidden">
                <!-- Cover Image & Profile Picture -->
                <div class="relative">
                    <div class="h-32 bg-gradient-to-r from-amber-400 via-orange-400 to-yellow-300">
                        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20100%20100%22%3E%3Ccircle%20cx%3D%2250%22%20cy%3D%2250%22%20r%3D%2240%22%20fill%3D%22none%22%20stroke%3D%22rgba(255%2C255%2C255%2C0.2)%22%20stroke-width%3D%222%22%2F%3E%3Ccircle%20cx%3D%2250%22%20cy%3D%2250%22%20r%3D%2230%22%20fill%3D%22none%22%20stroke%3D%22rgba(255%2C255%2C255%2C0.15)%22%20stroke-width%3D%222%22%2F%3E%3Ccircle%20cx%3D%2250%22%20cy%3D%2250%22%20r%3D%2220%22%20fill%3D%22none%22%20stroke%3D%22rgba(255%2C255%2C255%2C0.1)%22%20stroke-width%3D%222%22%2F%3E%3C%2Fsvg%3E')] bg-cover opacity-50"></div>
                    </div>
                    <div class="absolute -bottom-12 left-1/2 -translate-x-1/2">
                        <div class="h-24 w-24 rounded-full border-4 border-white dark:border-darkmode-600 overflow-hidden shadow-lg bg-white">
                            <img
                                class="h-full w-full object-cover"
                                src="{{ $employee->profile_picture_url }}"
                                alt="{{ $employee->full_name }}"
                            />
                        </div>
                    </div>
                </div>

                <!-- Name & Position -->
                <div class="pt-14 pb-5 px-5 text-center">
                    <h3 class="text-xl font-semibold text-slate-800 dark:text-white">{{ $employee->full_name }}</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">{{ $employee->positionRelation->title ?? $employee->position ?? 'Employee' }}</p>
                    <div class="flex items-center justify-center gap-2 mt-2">
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300">
                            {{ $employee->code ?? $employee->employee_id }}
                        </span>
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $employee->is_active ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' }}">
                            {{ $employee->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>

                <!-- Employment Information -->
                <div class="border-t border-slate-200/60 dark:border-darkmode-400 px-5 py-5">
                    <h4 class="text-base font-semibold text-slate-800 dark:text-white mb-4">Employment Info</h4>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-slate-600 dark:text-slate-400">
                                <x-base.lucide icon="hash" class="w-4 h-4 mr-3 text-slate-400" />
                                <span class="text-sm">Employee Code</span>
                            </div>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ $employee->code ?? $employee->employee_id ?? '-' }}</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-slate-600 dark:text-slate-400">
                                <x-base.lucide icon="briefcase" class="w-4 h-4 mr-3 text-slate-400" />
                                <span class="text-sm">Position</span>
                            </div>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300 truncate max-w-[140px]" title="{{ $employee->positionRelation->title ?? $employee->position ?? '-' }}">{{ $employee->positionRelation->title ?? $employee->position ?? '-' }}</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-slate-600 dark:text-slate-400">
                                <x-base.lucide icon="building-2" class="w-4 h-4 mr-3 text-slate-400" />
                                <span class="text-sm">Department</span>
                            </div>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300 truncate max-w-[140px]" title="{{ $employee->department->name ?? '-' }}">{{ $employee->department->name ?? '-' }}</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-slate-600 dark:text-slate-400">
                                <x-base.lucide icon="building" class="w-4 h-4 mr-3 text-slate-400" />
                                <span class="text-sm">Company</span>
                            </div>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300 truncate max-w-[140px]" title="{{ $employee->company->name ?? '-' }}">{{ $employee->company->name ?? '-' }}</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-slate-600 dark:text-slate-400">
                                <x-base.lucide icon="banknote" class="w-4 h-4 mr-3 text-slate-400" />
                                <span class="text-sm">Salary</span>
                            </div>
                            <span class="text-sm font-medium text-emerald-600 dark:text-emerald-400">{{ $employee->salary ? number_format($employee->salary, 2) : '-' }}</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-slate-600 dark:text-slate-400">
                                <x-base.lucide icon="calendar" class="w-4 h-4 mr-3 text-slate-400" />
                                <span class="text-sm">Hire Date</span>
                            </div>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ $employee->hire_date ? $employee->hire_date->format('d M Y') : '-' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Basic Information -->
                <div class="border-t border-slate-200/60 dark:border-darkmode-400 px-5 py-5">
                    <h4 class="text-base font-semibold text-slate-800 dark:text-white mb-4">Personal Info</h4>
                    <div class="space-y-3">
                        @if($employee->birth_date)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-slate-600 dark:text-slate-400">
                                <x-base.lucide icon="cake" class="w-4 h-4 mr-3 text-slate-400" />
                                <span class="text-sm">Birthday</span>
                            </div>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ $employee->birth_date->format('d M Y') }}</span>
                        </div>
                        @endif

                        @if($employee->gender)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-slate-600 dark:text-slate-400">
                                <x-base.lucide icon="user" class="w-4 h-4 mr-3 text-slate-400" />
                                <span class="text-sm">Gender</span>
                            </div>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ ucfirst($employee->gender) }}</span>
                        </div>
                        @endif

                        @if($employee->phone)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-slate-600 dark:text-slate-400">
                                <x-base.lucide icon="phone" class="w-4 h-4 mr-3 text-slate-400" />
                                <span class="text-sm">Phone</span>
                            </div>
                            <a href="tel:{{ $employee->phone }}" class="text-sm font-medium text-primary hover:underline">{{ $employee->phone }}</a>
                        </div>
                        @endif

                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-slate-600 dark:text-slate-400">
                                <x-base.lucide icon="mail" class="w-4 h-4 mr-3 text-slate-400" />
                                <span class="text-sm">E-Mail</span>
                            </div>
                            <a href="mailto:{{ $employee->email }}" class="text-sm font-medium text-primary hover:underline truncate max-w-[140px]" title="{{ $employee->email }}">{{ $employee->email }}</a>
                        </div>

                        @if($employee->nationality)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-slate-600 dark:text-slate-400">
                                <x-base.lucide icon="flag" class="w-4 h-4 mr-3 text-slate-400" />
                                <span class="text-sm">Nationality</span>
                            </div>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ $employee->nationality }}</span>
                        </div>
                        @endif

                        @if($employee->city || $employee->country)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-slate-600 dark:text-slate-400">
                                <x-base.lucide icon="map-pin" class="w-4 h-4 mr-3 text-slate-400" />
                                <span class="text-sm">Location</span>
                            </div>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ implode(', ', array_filter([$employee->city, $employee->country])) }}</span>
                        </div>
                        @endif

                        @if($employee->address)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-slate-600 dark:text-slate-400">
                                <x-base.lucide icon="home" class="w-4 h-4 mr-3 text-slate-400" />
                                <span class="text-sm">Address</span>
                            </div>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300 truncate max-w-[140px]" title="{{ $employee->address }}">{{ $employee->address }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Documents Section -->
                @php
                    $documents = $employee->documents()->latest()->take(4)->get();
                @endphp
                @if($documents->count() > 0)
                <div class="border-t border-slate-200/60 dark:border-darkmode-400 px-5 py-5">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-base font-semibold text-slate-800 dark:text-white">Documents</h4>
                        <a href="{{ route('hr.employees.documents.index', ['employee' => $employee->id]) }}" class="text-xs text-primary hover:underline">View All</a>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach($documents as $doc)
                        @php
                            $extension = strtolower(pathinfo($doc->file_name ?? $doc->original_name ?? '', PATHINFO_EXTENSION));
                            $iconBg = match($extension) {
                                'pdf' => 'bg-red-100 dark:bg-red-900/30',
                                'doc', 'docx' => 'bg-blue-100 dark:bg-blue-900/30',
                                'xls', 'xlsx' => 'bg-green-100 dark:bg-green-900/30',
                                'ppt', 'pptx' => 'bg-orange-100 dark:bg-orange-900/30',
                                'jpg', 'jpeg', 'png', 'gif' => 'bg-purple-100 dark:bg-purple-900/30',
                                default => 'bg-slate-100 dark:bg-slate-700'
                            };
                            $iconColor = match($extension) {
                                'pdf' => 'text-red-600 dark:text-red-400',
                                'doc', 'docx' => 'text-blue-600 dark:text-blue-400',
                                'xls', 'xlsx' => 'text-green-600 dark:text-green-400',
                                'ppt', 'pptx' => 'text-orange-600 dark:text-orange-400',
                                'jpg', 'jpeg', 'png', 'gif' => 'text-purple-600 dark:text-purple-400',
                                default => 'text-slate-600 dark:text-slate-400'
                            };
                            $fileSize = $doc->file_size ? round($doc->file_size / 1024, 1) . ' KB' : '';
                        @endphp
                        <a href="{{ $doc->file_url ?? '#' }}" target="_blank" class="flex items-center gap-3 p-3 rounded-xl {{ $iconBg }} hover:opacity-80 transition-opacity">
                            <div class="flex-shrink-0">
                                <x-base.lucide icon="file-text" class="w-6 h-6 {{ $iconColor }}" />
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-medium text-slate-700 dark:text-slate-300 truncate">{{ $doc->title ?? $doc->document_type ?? 'Document' }}</p>
                                @if($fileSize)
                                <p class="text-[10px] text-slate-500 dark:text-slate-400">{{ $fileSize }}</p>
                                @endif
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Statistics Section -->
                <div class="border-t border-slate-200/60 dark:border-darkmode-400 px-5 py-5">
                    <h4 class="text-base font-semibold text-slate-800 dark:text-white mb-4">Statistics</h4>
                    @php
                        $taskStats = [
                            'total' => $employee->assignedTasks()->count(),
                            'completed' => $employee->assignedTasks()->where('status', 'completed')->count(),
                        ];
                        // Calculate years and months of service properly
                        $yearsOfService = 0;
                        $monthsOfService = 0;
                        $daysOfService = 0;
                        if ($employee->hire_date) {
                            $hireDate = $employee->hire_date;
                            $now = now();
                            $yearsOfService = (int) $hireDate->diffInYears($now);
                            $monthsOfService = (int) $hireDate->copy()->addYears($yearsOfService)->diffInMonths($now);
                            $daysOfService = (int) $hireDate->diffInDays($now);
                        }
                        $leavesTaken = (int) ($employee->leaves()->where('status', 'approved')->sum('days_count') ?? 0);
                    @endphp

                    <div class="space-y-4">
                        <!-- Years of Service -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-slate-600 dark:text-slate-400">Years of Service</span>
                                <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">
                                    @if($yearsOfService > 0)
                                        {{ $yearsOfService }} yr{{ $yearsOfService > 1 ? 's' : '' }} {{ $monthsOfService }} mo
                                    @elseif($monthsOfService > 0)
                                        {{ $monthsOfService }} month{{ $monthsOfService > 1 ? 's' : '' }}
                                    @else
                                        {{ $daysOfService }} day{{ $daysOfService > 1 ? 's' : '' }}
                                    @endif
                                </span>
                            </div>
                            <div class="h-2 w-full overflow-hidden rounded-full bg-slate-200 dark:bg-darkmode-600">
                                <div class="h-full rounded-full bg-gradient-to-r from-amber-400 to-orange-500" style="width: {{ min(100, max(5, $yearsOfService * 10 + $monthsOfService)) }}%"></div>
                            </div>
                        </div>

                        <!-- Tasks Completed -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-slate-600 dark:text-slate-400">Tasks Completed</span>
                                <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $taskStats['completed'] }}/{{ $taskStats['total'] }}</span>
                            </div>
                            <div class="h-2 w-full overflow-hidden rounded-full bg-slate-200 dark:bg-darkmode-600">
                                @php $taskPercent = $taskStats['total'] > 0 ? ($taskStats['completed'] / $taskStats['total']) * 100 : 0; @endphp
                                <div class="h-full rounded-full bg-gradient-to-r from-emerald-400 to-green-500" style="width: {{ $taskPercent }}%"></div>
                            </div>
                        </div>

                        <!-- Leaves Taken -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-slate-600 dark:text-slate-400">Leaves Taken</span>
                                <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $leavesTaken }} day{{ $leavesTaken != 1 ? 's' : '' }}</span>
                            </div>
                            <div class="h-2 w-full overflow-hidden rounded-full bg-slate-200 dark:bg-darkmode-600">
                                <div class="h-full rounded-full bg-gradient-to-r from-blue-400 to-indigo-500" style="width: {{ min(100, $leavesTaken * 3) }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="border-t border-slate-200/60 dark:border-darkmode-400 p-4 flex gap-2">
                    <a href="{{ route('hr.employees.edit', $employee) }}" class="flex-1 btn-tonal btn-tonal--warning text-center py-2 rounded-lg text-sm font-medium">
                        <x-base.lucide icon="edit" class="w-4 h-4 inline mr-1" />
                        Edit
                    </a>
                    <a href="mailto:{{ $employee->email }}" class="flex-1 btn-tonal btn-tonal--info text-center py-2 rounded-lg text-sm font-medium">
                        <x-base.lucide icon="mail" class="w-4 h-4 inline mr-1" />
                        Email
                    </a>
                </div>
            </div>
        </div>
        <!-- END: Profile Card -->
        <div class="col-span-12 lg:col-span-8 2xl:col-span-9">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: Performance & Rewards -->
                <div class="intro-y box col-span-12 2xl:col-span-6" id="performance-rewards">
                    <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
                        <h2 class="mr-auto text-base font-medium flex items-center">
                            <x-base.lucide icon="Star" class="w-5 h-5 mr-2 text-amber-400" />
                            Performance & Rewards
                        </h2>
                    </div>
                    <div class="p-5">
                        <div class="grid grid-cols-12 gap-4">
                            <!-- Rating card -->
                            <div class="col-span-12">
                                <div class="rounded-lg border border-slate-200/60 p-4 dark:border-darkmode-400 bg-gradient-to-br from-amber-50/80 to-white dark:from-darkmode-600 dark:to-darkmode-700">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="text-sm font-medium text-slate-700 dark:text-slate-100">Overall Rating</div>
                                        @php $avgRating = $employee->average_rating; @endphp
                                        <div class="text-xs text-slate-500 dark:text-slate-400">
                                            {{ $avgRating ? $avgRating . ' / 10' : 'Not rated yet' }}
                                        </div>
                                    </div>
                                    <div class="flex items-center mb-3">
                                        @for ($i = 1; $i <= 10; $i++)
                                            @php $filled = $avgRating && $avgRating >= $i; @endphp
                                            <div class="transition-transform duration-200 hover:scale-110">
                                                <x-base.lucide
                                                    icon="Star"
                                                    class="w-5 h-5 mr-1 {{ $filled ? 'text-amber-400 fill-amber-300/80' : 'text-slate-300 dark:text-slate-600' }}"
                                                />
                                            </div>
                                        @endfor
                                        <span class="ml-2 text-xs text-slate-500 dark:text-slate-400">
                                            {{ $avgRating ? $avgRating . ' / 10' : 'Not rated yet' }}
                                        </span>
                                    </div>
                                    @php
                                        $latestEvaluations = $employee->evaluations()->latest('evaluated_at')->latest()->take(3)->get();
                                    @endphp
                                    @if($latestEvaluations->count())
                                        <div class="space-y-2 max-h-40 overflow-y-auto text-xs">
                                            @foreach($latestEvaluations as $eval)
                                                <div class="flex items-start justify-between rounded-md bg-white/60 dark:bg-darkmode-600/80 px-3 py-2">
                                                    <div class="mr-2">
                                                        <div class="font-medium text-slate-800 dark:text-slate-100">
                                                            {{ $eval->overall_rating }} ★
                                                        </div>
                                                        @if($eval->comments)
                                                            <div class="text-[11px] text-slate-500 dark:text-slate-400 line-clamp-2">{{ $eval->comments }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="text-right text-[11px] text-slate-400">
                                                        @if($eval->evaluated_at)
                                                            <div>{{ $eval->evaluated_at->format('Y-m-d') }}</div>
                                                        @endif
                                                        @if($eval->evaluator)
                                                            <div>by {{ $eval->evaluator->name }}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-xs text-slate-500 dark:text-slate-400">
                                            No evaluations recorded yet.
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Rewards card -->
                            <div class="col-span-12">
                                <div class="rounded-lg border border-slate-200/60 p-4 dark:border-darkmode-400 bg-gradient-to-br from-emerald-50/80 to-white dark:from-darkmode-600 dark:to-darkmode-700">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="text-sm font-medium text-slate-700 dark:text-slate-100 flex items-center">
                                            <x-base.lucide icon="Gift" class="w-4 h-4 mr-2 text-emerald-500" />
                                            Rewards & Points
                                        </div>
                                    </div>
                                    @php
                                        $totalPoints = $employee->total_points;
                                        $rewards = $employee->rewards()->latest('granted_at')->latest()->take(3)->get();
                                    @endphp
                                    <div class="mb-3">
                                        <div class="flex items-center justify-between text-xs text-slate-500 dark:text-slate-400 mb-1">
                                            <span>Total Points</span>
                                            <span class="font-semibold text-emerald-600 dark:text-emerald-400">{{ $totalPoints }}</span>
                                        </div>
                                        <div class="h-2 w-full overflow-hidden rounded-full bg-slate-100 dark:bg-darkmode-600">
                                            @php $progress = min(100, ($totalPoints / 100) * 100); @endphp
                                            <div class="h-full rounded-full bg-emerald-500 transition-all duration-500" style="width: {{ $progress }}%"></div>
                                        </div>
                                    </div>

                                    @if($rewards->count())
                                        <div class="space-y-2 max-h-40 overflow-y-auto text-xs">
                                            @foreach($rewards as $reward)
                                                <div class="flex items-start justify-between rounded-md bg-white/60 dark:bg-darkmode-600/80 px-3 py-2">
                                                    <div class="mr-2">
                                                        <div class="font-medium text-slate-800 dark:text-slate-100 flex items-center">
                                                            <span class="mr-1">+{{ $reward->points }} pts</span>
                                                            @if($reward->amount)
                                                                <span class="text-[11px] text-emerald-600">({{ format_currency($reward->amount, 2) }})</span>
                                                            @endif
                                                        </div>
                                                        @if($reward->reason)
                                                            <div class="text-[11px] text-slate-500 dark:text-slate-400 line-clamp-2">{{ $reward->reason }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="text-right text-[11px] text-slate-400">
                                                        @if($reward->granted_at)
                                                            <div>{{ $reward->granted_at->format('Y-m-d') }}</div>
                                                        @endif
                                                        @if($reward->granter)
                                                            <div>by {{ $reward->granter->name }}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-xs text-slate-500 dark:text-slate-400">
                                            No rewards recorded yet.
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Task Likes card -->
                            <div class="col-span-12">
                                <div class="rounded-lg border border-slate-200/60 p-4 dark:border-darkmode-400 bg-gradient-to-br from-pink-50/80 to-white dark:from-darkmode-600 dark:to-darkmode-700">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="text-sm font-medium text-slate-700 dark:text-slate-100 flex items-center">
                                            <x-base.lucide icon="heart" class="w-4 h-4 mr-2 text-pink-500" />
                                            Task Likes
                                        </div>
                                    </div>
                                    @php
                                        $taskLikesCount = $employee->task_likes_count ?? 0;
                                        $taskLikesPoints = $employee->task_likes_points ?? 0;
                                        $totalPointsWithLikes = $employee->total_points_with_likes ?? $totalPoints;
                                    @endphp
                                    <div class="grid grid-cols-3 gap-3 mb-3">
                                        <div class="text-center p-3 rounded-lg bg-white/60 dark:bg-darkmode-600/80">
                                            <div class="text-2xl font-bold text-pink-500">{{ $taskLikesCount }}</div>
                                            <div class="text-[11px] text-slate-500">Total Likes</div>
                                        </div>
                                        <div class="text-center p-3 rounded-lg bg-white/60 dark:bg-darkmode-600/80">
                                            <div class="text-2xl font-bold text-emerald-500">+{{ $taskLikesPoints }}</div>
                                            <div class="text-[11px] text-slate-500">Points from Likes</div>
                                        </div>
                                        <div class="text-center p-3 rounded-lg bg-white/60 dark:bg-darkmode-600/80">
                                            <div class="text-2xl font-bold text-amber-500">{{ $totalPointsWithLikes }}</div>
                                            <div class="text-[11px] text-slate-500">Total Points</div>
                                        </div>
                                    </div>
                                    <div class="text-xs text-slate-500 dark:text-slate-400 text-center">
                                        <x-base.lucide icon="info" class="w-3 h-3 inline mr-1" />
                                        Each like on completed tasks adds 1 point to the employee's score
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Performance & Rewards -->

                <!-- BEGIN: Approval Signature -->
                <div class="intro-y box col-span-12 2xl:col-span-6" id="approval-signature">
                    <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
                        <h2 class="mr-auto text-base font-medium flex items-center gap-2">
                            <x-base.lucide icon="PenSquare" class="h-4 w-4 text-primary" />
                            Approval Signature
                        </h2>
                    </div>
                    <div class="p-5">
                        @php
                            $linkedUser = $employee->user;
                            $signatureUrl = $linkedUser?->signature_url;
                            $canManageSignature = $linkedUser && $linkedUser->id === auth()->id();
                        @endphp

                        @if(!$linkedUser)
                            <div class="rounded-md border border-slate-200/60 bg-slate-50 px-4 py-3 text-sm text-slate-600 dark:border-darkmode-400 dark:bg-darkmode-600 dark:text-slate-300">
                                This employee is not linked to a system user, so no signature can be stored.
                            </div>
                        @else
                            <div class="rounded-lg border-2 border-dashed border-slate-200/80 bg-white/60 p-5 text-center dark:border-darkmode-400 dark:bg-darkmode-700/40">
                                @if ($signatureUrl)
                                    <img
                                        src="{{ $signatureUrl }}"
                                        alt="{{ $employee->full_name }} signature"
                                        class="mx-auto max-h-32"
                                    />
                                    <div class="mt-2 text-xs text-slate-500">Stored on {{ $linkedUser->updated_at?->format('Y-m-d') ?? '—' }}</div>
                                @else
                                    <div class="text-sm font-medium text-slate-500 dark:text-slate-300">
                                        No signature on file yet
                                    </div>
                                @endif
                            </div>

                            @if ($canManageSignature)
                                <form
                                    class="mt-5 space-y-4"
                                    action="{{ route('profile.signature.update') }}"
                                    method="POST"
                                    enctype="multipart/form-data"
                                >
                                    @csrf
                                    <div class="text-left">
                                        <x-base.form-label class="text-xs uppercase tracking-wide text-slate-500" for="signature">
                                            Upload New Signature (PNG / JPG / WEBP up to 2MB)
                                        </x-base.form-label>
                                        <x-base.form-input
                                            id="signature"
                                            name="signature"
                                            type="file"
                                            accept="image/png,image/jpeg,image/webp,image/svg+xml"
                                        />
                                        @error('signature', 'profileSignature')
                                            <p class="mt-2 text-xs text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="flex flex-wrap gap-2">
                                        <x-base.button type="submit" variant="primary">
                                            Save Signature
                                        </x-base.button>

                                        @if ($linkedUser->signature_path)
                                            <button
                                                type="submit"
                                                name="remove_signature"
                                                value="1"
                                                class="btn btn-danger"
                                            >
                                                Remove Signature
                                            </button>
                                        @endif
                                    </div>

                                    @if (session('profile_signature_status'))
                                        <div class="rounded border border-success/40 bg-success/10 px-3 py-2 text-xs text-success">
                                            {{ session('profile_signature_status') }}
                                        </div>
                                    @endif
                                </form>
                            @else
                                <div class="mt-4 rounded-md bg-slate-100/80 px-4 py-3 text-sm text-slate-600 dark:bg-darkmode-600 dark:text-slate-300">
                                    Only the employee can update their stored signature. Ask {{ $employee->full_name }} to sign in and upload it here.
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
                <!-- END: Approval Signature -->

                <!-- BEGIN: Documents -->
                <div class="intro-y box col-span-12 2xl:col-span-6" id="documents">
                    <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
                        <h2 class="mr-auto text-base font-medium">Documents</h2>
                        <x-base.button as="a" href="{{ route('hr.employees.documents.index', ['employee' => $employee->id]) }}" variant="outline-secondary">
                            <x-base.lucide class="mr-2 h-4 w-4" icon="ExternalLink" />
                            Manage
                        </x-base.button>
                    </div>
                    <div class="p-5">
                        @php
                            $recentDocuments = $employee->documents()->active()->latest()->take(3)->get();
                        @endphp

                        @if($recentDocuments->count() > 0)
                            <div class="space-y-3">
                                @foreach($recentDocuments as $document)
                                    <div class="flex items-center justify-between p-3 border border-slate-200/60 rounded-lg dark:border-darkmode-400">
                                        <div class="flex items-center">
                                            <x-base.lucide class="h-8 w-8 text-slate-400 mr-3" icon="FileText" />
                                            <div>
                                                <div class="font-medium text-sm">{{ $document->document_name }}</div>
                                                <div class="text-xs text-slate-500">{{ $document->document_type_formatted }}</div>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            @if($document->file_path)
                                                <x-base.button as="a" href="{{ route('hr.employees.documents.download', ['employee' => $employee->id, 'document' => $document->id]) }}" variant="outline-secondary" size="xs" title="Download">
                                                    <x-base.lucide icon="Download" class="w-3 h-3" />
                                                </x-base.button>
                                            @endif
                                            @if($document->expiry_date && $document->is_expired)
                                                <span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded">Expired</span>
                                            @elseif($document->expiry_date && $document->is_expiring_soon)
                                                <span class="px-2 py-1 text-xs bg-orange-100 text-orange-700 rounded">Expiring Soon</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @if($employee->documents()->active()->count() > 3)
                                <div class="mt-4 text-center">
                                    <a href="{{ route('hr.employees.documents.index', ['employee' => $employee->id]) }}"
                                       class="text-primary hover:text-primary/80 text-sm">
                                        View all {{ $employee->documents()->active()->count() }} documents
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="flex flex-col items-center justify-center py-10">
                                <x-base.lucide class="h-12 w-12 text-slate-400 mb-4" icon="FileText" />
                                <div class="text-slate-500 text-center mb-2">No documents uploaded</div>
                                <a href="{{ route('hr.employees.documents.index', ['employee' => $employee->id]) }}"
                                   class="text-primary hover:text-primary/80 text-sm">
                                    Add first document
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                <!-- END: Documents -->

                <!-- BEGIN: Assigned Tasks (New Design) -->
                <div class="intro-y box col-span-12" id="assigned-tasks">
                    <div class="flex items-center border-b border-slate-200/60 px-5 py-4 dark:border-darkmode-400">
                        <h2 class="mr-auto text-base font-semibold text-slate-800 dark:text-white flex items-center">
                            <x-base.lucide icon="clipboard-list" class="w-5 h-5 mr-2 text-amber-500" />
                            Assigned Tasks
                        </h2>
                        <span class="text-xs text-slate-500 mr-3">{{ $employee->assignedTasks()->count() }} tasks</span>
                        <a href="{{ route('tasks.index', ['employee_id' => $employee->id]) }}" class="btn-royal btn-royal--outline btn-royal--sm">
                            <x-base.lucide class="mr-1 h-3 w-3" icon="external-link" />
                            View All
                        </a>
                    </div>
                    <div class="p-5">
                        @php
                            $assignedTasks = $employee->assignedTasks()->with(['project', 'assignee'])->latest()->take(8)->get();
                        @endphp

                        @if($assignedTasks->count() > 0)
                            <div class="space-y-4">
                                @foreach($assignedTasks as $task)
                                    @php
                                        $progress = $task->progress_percentage ?? 0;
                                        $progressColor = $progress >= 100 ? 'bg-slate-800' : ($progress >= 50 ? 'bg-amber-400' : 'bg-slate-300');
                                    @endphp
                                    <a href="{{ route('tasks.show', $task) }}" class="flex items-center gap-4 p-3 rounded-xl bg-slate-50/50 dark:bg-darkmode-600/50 hover:bg-slate-100/80 dark:hover:bg-darkmode-500/50 transition-colors cursor-pointer group">
                                        <div class="flex-shrink-0">
                                            @if($task->assignee && $task->assignee->profile_picture_url)
                                                <img src="{{ $task->assignee->profile_picture_url }}" alt="{{ $task->assignee->full_name }}" class="h-12 w-12 rounded-full object-cover border-2 border-white shadow-sm" />
                                            @else
                                                <div class="h-12 w-12 rounded-full bg-gradient-to-br from-amber-100 to-orange-100 dark:from-amber-900/30 dark:to-orange-900/30 flex items-center justify-center border-2 border-white shadow-sm">
                                                    <x-base.lucide icon="check-square" class="w-5 h-5 text-amber-600 dark:text-amber-400" />
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between mb-1">
                                                <span class="font-semibold text-slate-800 dark:text-white group-hover:text-primary truncate transition-colors">
                                                    {{ $task->title }}
                                                </span>
                                                @if($task->status === 'completed')
                                                    <span class="text-xs px-2 py-0.5 rounded-full bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 flex-shrink-0 ml-2">Done</span>
                                                @elseif($task->status === 'in_progress')
                                                    <span class="text-xs px-2 py-0.5 rounded-full bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 flex-shrink-0 ml-2">In Progress</span>
                                                @else
                                                    <span class="text-xs px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-400 flex-shrink-0 ml-2">{{ ucfirst($task->status) }}</span>
                                                @endif
                                            </div>
                                            <p class="text-sm text-slate-500 dark:text-slate-400 mb-2 truncate">{{ $task->project->name ?? 'No Project' }}</p>
                                            <div class="flex items-center gap-3">
                                                <div class="flex-1 h-2 rounded-full bg-slate-200 dark:bg-darkmode-400 overflow-hidden">
                                                    <div class="h-full rounded-full {{ $progressColor }} transition-all duration-300" style="width: {{ $progress }}%"></div>
                                                </div>
                                                <span class="text-xs font-medium text-slate-600 dark:text-slate-400 w-10 text-right">{{ $progress }}%</span>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                            
                            @php
                                $totalTasks = $employee->assignedTasks()->count();
                                $completedTasks = $employee->assignedTasks()->where('status', 'completed')->count();
                                $pendingTasks = $employee->assignedTasks()->where('status', 'pending')->count();
                                $inProgressTasks = $employee->assignedTasks()->where('status', 'in_progress')->count();
                            @endphp
                            
                            @if($totalTasks > 5)
                                <div class="mt-4 text-center">
                                    <a href="{{ route('tasks.index', ['employee_id' => $employee->id]) }}"
                                       class="text-primary hover:text-primary/80 text-sm">
                                        View all {{ $totalTasks }} tasks
                                    </a>
                                </div>
                            @endif
                            
                            <!-- Task Statistics -->
                            <div class="mt-6 grid grid-cols-4 gap-4 pt-4 border-t border-slate-200/60 dark:border-darkmode-400">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-slate-700 dark:text-slate-300">{{ $totalTasks }}</div>
                                    <div class="text-xs text-slate-500">Total</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-green-600">{{ $completedTasks }}</div>
                                    <div class="text-xs text-slate-500">Completed</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-blue-600">{{ $inProgressTasks }}</div>
                                    <div class="text-xs text-slate-500">In Progress</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-yellow-600">{{ $pendingTasks }}</div>
                                    <div class="text-xs text-slate-500">Pending</div>
                                </div>
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center py-10">
                                <x-base.lucide class="h-12 w-12 text-slate-400 mb-4" icon="CheckSquare" />
                                <div class="text-slate-500 text-center mb-2">No tasks assigned</div>
                                <a href="{{ route('tasks.create', ['employee_id' => $employee->id]) }}"
                                   class="text-primary hover:text-primary/80 text-sm">
                                    Assign first task
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                <!-- END: Assigned Tasks -->

                <!-- BEGIN: Recent Activities -->
                <div class="intro-y box col-span-12">
                    <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
                        <h2 class="mr-auto text-base font-medium">Recent Activities</h2>
                    </div>
                    <div class="p-5">
                        <div class="flex flex-col items-center justify-center py-10">
                            <x-base.lucide class="h-12 w-12 text-slate-400 mb-4" icon="Activity" />
                            <div class="text-slate-500 text-center">
                                No recent activities
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Recent Activities -->
            </div>
        </div>
    </div>
@endsection

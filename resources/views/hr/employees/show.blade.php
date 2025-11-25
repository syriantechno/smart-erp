@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>{{ $employee->full_name }} - Employee Profile</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">{{ $employee->full_name }} Profile</h2>
    </div>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <!-- BEGIN: Profile Menu -->
        <div class="col-span-12 flex flex-col-reverse lg:col-span-4 lg:block 2xl:col-span-3">
            <div class="intro-y box mt-5 lg:mt-0">
                <div class="relative flex items-center p-5">
                    <div class="image-fit h-12 w-12">
                        <img
                            class="rounded-full"
                            src="{{ $employee->profile_picture_url }}"
                            alt="{{ $employee->full_name }}"
                        />
                    </div>
                    <div class="ml-4 mr-auto">
                        <div class="text-base font-medium">
                            {{ $employee->full_name }}
                        </div>
                        <div class="text-slate-500">{{ $employee->position ?? 'Employee' }}</div>
                    </div>
                    <x-base.menu>
                        <x-base.menu.button
                            class="block h-5 w-5"
                            href="#"
                            tag="a"
                        >
                            <x-base.lucide
                                class="h-5 w-5 text-slate-500"
                                icon="MoreHorizontal"
                            />
                        </x-base.menu.button>
                        <x-base.menu.items class="w-56">
                            <x-base.menu.header>Actions</x-base.menu.header>
                            <x-base.menu.divider />
                            <x-base.menu.item>
                                <a href="{{ route('hr.employees.edit', $employee) }}" class="flex items-center">
                                    <x-base.lucide class="mr-2 h-4 w-4" icon="Edit" />
                                    Edit Profile
                                </a>
                            </x-base.menu.item>
                            <x-base.menu.item>
                                <a href="mailto:{{ $employee->email }}" class="flex items-center">
                                    <x-base.lucide class="mr-2 h-4 w-4" icon="Mail" />
                                    Send Email
                                </a>
                            </x-base.menu.item>
                            <x-base.menu.divider />
                            <x-base.menu.footer>
                                <x-base.button
                                    class="px-2 py-1"
                                    type="button"
                                    variant="primary"
                                >
                                    <x-base.lucide class="mr-2 h-4 w-4" icon="Download" />
                                    Export
                                </x-base.button>
                                <x-base.button
                                    class="ml-auto px-2 py-1"
                                    type="button"
                                    variant="secondary"
                                >
                                    <x-base.lucide class="mr-2 h-4 w-4" icon="Share" />
                                    Share
                                </x-base.button>
                            </x-base.menu.footer>
                        </x-base.menu.items>
                    </x-base.menu>
                </div>
                <div class="border-t border-slate-200/60 p-5 dark:border-darkmode-400">
                    <a
                        class="flex items-center font-medium text-primary"
                        href="#personal-info"
                    >
                        <x-base.lucide
                            class="mr-2 h-4 w-4"
                            icon="User"
                        /> Personal Information
                    </a>
                    <a
                        class="mt-5 flex items-center"
                        href="#employment-info"
                    >
                        <x-base.lucide
                            class="mr-2 h-4 w-4"
                            icon="Briefcase"
                        /> Employment Details
                    </a>
                    <a
                        class="mt-5 flex items-center"
                        href="#contact-info"
                    >
                        <x-base.lucide
                            class="mr-2 h-4 w-4"
                            icon="Phone"
                        /> Contact Information
                    </a>
                    <a
                        class="mt-5 flex items-center"
                        href="{{ route('hr.employees.documents.index', ['employee' => $employee->id]) }}"
                    >
                        <x-base.lucide
                            class="mr-2 h-4 w-4"
                            icon="FileText"
                        /> Documents
                    </a>
                    <a
                        class="mt-5 flex items-center"
                        href="#assigned-tasks"
                    >
                        <x-base.lucide
                            class="mr-2 h-4 w-4"
                            icon="CheckSquare"
                        /> Assigned Tasks
                    </a>
                </div>
                <div class="border-t border-slate-200/60 p-5 dark:border-darkmode-400">
                    <div class="text-sm">
                        <div class="font-medium mb-2">Employee ID</div>
                        <div class="text-slate-500">{{ $employee->employee_id }}</div>
                    </div>
                    <div class="text-sm mt-4">
                        <div class="font-medium mb-2">Department</div>
                        <div class="text-slate-500">{{ $employee->department->name ?? 'N/A' }}</div>
                    </div>
                    <div class="text-sm mt-4">
                        <div class="font-medium mb-2">Hire Date</div>
                        <div class="text-slate-500">{{ $employee->hire_date ? $employee->hire_date->format('M d, Y') : 'N/A' }}</div>
                    </div>
                    <div class="text-sm mt-4">
                        <div class="font-medium mb-2">Status</div>
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $employee->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $employee->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
                <div class="flex border-t border-slate-200/60 p-5 dark:border-darkmode-400">
                    <x-base.button
                        class="px-2 py-1"
                        type="button"
                        variant="primary"
                    >
                        <x-base.lucide class="mr-2 h-4 w-4" icon="MessageSquare" />
                        Message
                    </x-base.button>
                    <x-base.button
                        class="ml-auto px-2 py-1"
                        type="button"
                        variant="outline-secondary"
                    >
                        <x-base.lucide class="mr-2 h-4 w-4" icon="Calendar" />
                        Schedule
                    </x-base.button>
                </div>
            </div>
            <div class="intro-y box mt-5 bg-primary p-5 text-white">
                <div class="flex items-center">
                    <div class="text-lg font-medium">Employee Stats</div>
                    <div class="ml-auto rounded-md bg-white px-1 text-xs text-slate-700 dark:bg-primary dark:text-white">
                        Info
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex justify-between items-center mb-2">
                        <span>Years of Service</span>
                        <span>{{ $employee->hire_date ? $employee->hire_date->diffInYears(now()) : 0 }} years</span>
                    </div>
                    <div class="flex justify-between items-center mb-2">
                        <span>Department</span>
                        <span>{{ $employee->department->name ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between items-center mb-2">
                        <span>Position</span>
                        <span>{{ $employee->position ?? 'N/A' }}</span>
                    </div>
                    @php
                        $taskStats = [
                            'total' => $employee->assignedTasks()->count(),
                            'completed' => $employee->assignedTasks()->where('status', 'completed')->count(),
                        ];
                    @endphp
                    <div class="flex justify-between items-center">
                        <span>Tasks Completed</span>
                        <span>{{ $taskStats['completed'] }}/{{ $taskStats['total'] }}</span>
                    </div>
                </div>
                <div class="mt-5 flex font-medium">
                    <x-base.button
                        class="border-white px-2 py-1 text-white dark:border-darkmode-400 dark:bg-darkmode-400 dark:text-slate-300"
                        type="button"
                    >
                        View Details
                    </x-base.button>
                    <x-base.button
                        class="ml-auto border-transparent px-2 py-1 text-white dark:border-transparent"
                        type="button"
                    >
                        Back to List
                    </x-base.button>
                </div>
            </div>
        </div>
        <!-- END: Profile Menu -->
        <div class="col-span-12 lg:col-span-8 2xl:col-span-9">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: Personal Information -->
                <div class="intro-y box col-span-12 2xl:col-span-6" id="personal-info">
                    <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
                        <h2 class="mr-auto text-base font-medium">Personal Information</h2>
                    </div>
                    <div class="p-5">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <div class="text-slate-500 text-sm">First Name</div>
                                <div class="font-medium">{{ $employee->first_name }}</div>
                            </div>
                            <div>
                                <div class="text-slate-500 text-sm">Last Name</div>
                                <div class="font-medium">{{ $employee->last_name }}</div>
                            </div>
                            <div>
                                <div class="text-slate-500 text-sm">Middle Name</div>
                                <div class="font-medium">{{ $employee->middle_name ?? '-' }}</div>
                            </div>
                            <div>
                                <div class="text-slate-500 text-sm">Gender</div>
                                <div class="font-medium">
                                    @if($employee->gender == 'male') Male
                                    @elseif($employee->gender == 'female') Female
                                    @elseif($employee->gender == 'other') Other
                                    @else -
                                    @endif
                                </div>
                            </div>
                            @if($employee->birth_date)
                            <div>
                                <div class="text-slate-500 text-sm">Date of Birth</div>
                                <div class="font-medium">{{ $employee->birth_date->format('M d, Y') }}</div>
                            </div>
                            <div>
                                <div class="text-slate-500 text-sm">Age</div>
                                <div class="font-medium">{{ $employee->age ?? '-' }} years</div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- END: Personal Information -->

                <!-- BEGIN: Employment Information -->
                <div class="intro-y box col-span-12 2xl:col-span-6" id="employment-info">
                    <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
                        <h2 class="mr-auto text-base font-medium">Employment Information</h2>
                    </div>
                    <div class="p-5">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <div class="text-slate-500 text-sm">Employee ID</div>
                                <div class="font-medium">{{ $employee->employee_id }}</div>
                            </div>
                            <div>
                                <div class="text-slate-500 text-sm">Position</div>
                                <div class="font-medium">{{ $employee->position ?? '-' }}</div>
                            </div>
                            <div>
                                <div class="text-slate-500 text-sm">Department</div>
                                <div class="font-medium">{{ $employee->department->name ?? '-' }}</div>
                            </div>
                            <div>
                                <div class="text-slate-500 text-sm">Company</div>
                                <div class="font-medium">{{ $employee->company->name ?? '-' }}</div>
                            </div>
                            <div>
                                <div class="text-slate-500 text-sm">Hire Date</div>
                                <div class="font-medium">{{ $employee->hire_date ? $employee->hire_date->format('M d, Y') : '-' }}</div>
                            </div>
                            <div>
                                <div class="text-slate-500 text-sm">Salary</div>
                                <div class="font-medium">{{ format_currency($employee->salary, 2) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Employment Information -->

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

                <!-- BEGIN: Contact Information -->
                <div class="intro-y box col-span-12 2xl:col-span-6" id="contact-info">
                    <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
                        <h2 class="mr-auto text-base font-medium">Contact Information</h2>
                    </div>
                    <div class="p-5">
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <x-base.lucide class="h-4 w-4 text-slate-500 mr-3" icon="Mail" />
                                <div>
                                    <div class="text-slate-500 text-sm">Email</div>
                                    <a href="mailto:{{ $employee->email }}" class="font-medium text-primary">{{ $employee->email }}</a>
                                </div>
                            </div>
                            @if($employee->phone)
                            <div class="flex items-center">
                                <x-base.lucide class="h-4 w-4 text-slate-500 mr-3" icon="Phone" />
                                <div>
                                    <div class="text-slate-500 text-sm">Phone</div>
                                    <a href="tel:{{ $employee->phone }}" class="font-medium text-primary">{{ $employee->phone }}</a>
                                </div>
                            </div>
                            @endif
                            @if($employee->address || $employee->city || $employee->country)
                            <div class="flex items-start">
                                <x-base.lucide class="h-4 w-4 text-slate-500 mr-3 mt-1" icon="MapPin" />
                                <div>
                                    <div class="text-slate-500 text-sm">Address</div>
                                    <div class="font-medium">
                                        @if($employee->address)
                                            <div>{{ $employee->address }}</div>
                                        @endif
                                        <div>
                                            @if($employee->city) {{ $employee->city }}, @endif
                                            @if($employee->country) {{ $employee->country }} @endif
                                            @if($employee->postal_code) {{ $employee->postal_code }} @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- END: Contact Information -->

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

                <!-- BEGIN: Assigned Tasks -->
                <div class="intro-y box col-span-12" id="assigned-tasks">
                    <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
                        <h2 class="mr-auto text-base font-medium">Assigned Tasks</h2>
                        <x-base.button as="a" href="{{ route('tasks.index', ['employee_id' => $employee->id]) }}" variant="outline-secondary">
                            <x-base.lucide class="mr-2 h-4 w-4" icon="ExternalLink" />
                            View All
                        </x-base.button>
                    </div>
                    <div class="p-5">
                        @php
                            $assignedTasks = $employee->assignedTasks()->with(['project'])->latest()->take(5)->get();
                        @endphp

                        @if($assignedTasks->count() > 0)
                            <div class="space-y-3">
                                @foreach($assignedTasks as $task)
                                    <a href="{{ route('tasks.show', $task) }}" class="flex items-center justify-between p-4 border border-slate-200/60 rounded-lg dark:border-darkmode-400 hover:bg-slate-50 dark:hover:bg-darkmode-600 transition-colors cursor-pointer hover:border-primary/30 group">
                                        <div class="flex items-center flex-1">
                                            @if($task->color)
                                                <div class="w-3 h-3 rounded-full mr-3 border border-white shadow-sm" style="background-color: {{ $task->color }}"></div>
                                            @else
                                                <x-base.lucide class="h-4 w-4 text-slate-400 mr-3" icon="CheckSquare" />
                                            @endif
                                            <div class="flex-1">
                                                <div class="font-medium text-sm group-hover:text-primary transition-colors">{{ $task->title }}</div>
                                                <div class="text-xs text-slate-500 mt-1">
                                                    <span class="mr-3">{{ $task->code }}</span>
                                                    @if($task->project)
                                                        <span class="mr-3">{{ $task->project->name }}</span>
                                                    @endif
                                                    @if($task->due_date)
                                                        <span>Due: {{ $task->due_date->format('M d, Y') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <!-- Click Indicator -->
                                            <x-base.lucide class="h-4 w-4 text-slate-400 group-hover:text-primary transition-colors" icon="ExternalLink" />
                                            
                                            <!-- Priority Badge -->
                                            @php
                                                $priorityClass = match($task->priority) {
                                                    'high' => 'bg-red-100 text-red-700',
                                                    'medium' => 'bg-yellow-100 text-yellow-700',
                                                    'low' => 'bg-green-100 text-green-700',
                                                    default => 'bg-gray-100 text-gray-700'
                                                };
                                            @endphp
                                            <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-semibold {{ $priorityClass }}">
                                                {{ ucfirst($task->priority) }}
                                            </span>
                                            
                                            <!-- Status Badge -->
                                            @php
                                                $statusClass = match($task->status) {
                                                    'completed' => 'bg-green-100 text-green-700',
                                                    'in_progress' => 'bg-blue-100 text-blue-700',
                                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                                    'cancelled' => 'bg-red-100 text-red-700',
                                                    default => 'bg-gray-100 text-gray-700'
                                                };
                                            @endphp
                                            <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-semibold {{ $statusClass }}">
                                                {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                            </span>
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

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
                    <div class="flex justify-between items-center">
                        <span>Position</span>
                        <span>{{ $employee->position ?? 'N/A' }}</span>
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
                                <div class="font-medium">${{ number_format($employee->salary, 2) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Employment Information -->

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

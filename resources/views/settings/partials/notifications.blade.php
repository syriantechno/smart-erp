<!-- Notification Settings Content Loaded -->
<div class="bg-white dark:bg-darkmode-600 rounded-lg shadow-sm border border-slate-200/60 dark:border-darkmode-400 mt-5">
    <div class="flex items-center border-b border-slate-200/60 p-5 dark:border-darkmode-400">
        <h2 class="mr-auto text-base font-medium flex items-center">
            <x-base.lucide icon="Bell" class="w-5 h-5 mr-2 text-yellow-500" />
            Notification Settings
        </h2>
    </div>

    @php
        $notificationSettings = [
            // Departments
            'notifications.department.created' => [
                'label' => 'Department Created',
                'description' => 'Send a bell notification when a new department is created.',
                'value' => \App\Models\Setting::get('notifications.department.created', true),
            ],
            'notifications.department.updated' => [
                'label' => 'Department Updated',
                'description' => 'Send a bell notification when a department is updated.',
                'value' => \App\Models\Setting::get('notifications.department.updated', true),
            ],
            'notifications.department.deleted' => [
                'label' => 'Department Deleted',
                'description' => 'Send a bell notification when a department is deleted.',
                'value' => \App\Models\Setting::get('notifications.department.deleted', true),
            ],

            // Positions
            'notifications.position.created' => [
                'label' => 'Position Created',
                'description' => 'Send a bell notification when a new position is created.',
                'value' => \App\Models\Setting::get('notifications.position.created', true),
            ],
            'notifications.position.updated' => [
                'label' => 'Position Updated',
                'description' => 'Send a bell notification when a position is updated.',
                'value' => \App\Models\Setting::get('notifications.position.updated', true),
            ],
            'notifications.position.deleted' => [
                'label' => 'Position Deleted',
                'description' => 'Send a bell notification when a position is deleted.',
                'value' => \App\Models\Setting::get('notifications.position.deleted', true),
            ],

            // Employees
            'notifications.employee.created' => [
                'label' => 'Employee Created',
                'description' => 'Send a bell notification when a new employee is created.',
                'value' => \App\Models\Setting::get('notifications.employee.created', true),
            ],
            'notifications.employee.deleted' => [
                'label' => 'Employee Deleted',
                'description' => 'Send a bell notification when an employee is deleted.',
                'value' => \App\Models\Setting::get('notifications.employee.deleted', true),
            ],
        ];
    @endphp

    <form id="notification-settings-form" action="{{ route('settings.notifications.update') }}" method="POST" class="p-5">
        @csrf
        <div class="grid grid-cols-12 gap-6">
            <!-- HR - Departments -->
            <div class="col-span-12 md:col-span-6 lg:col-span-4">
                <h3 class="mb-3 flex items-center text-sm font-semibold text-slate-800 dark:text-slate-100">
                    <x-base.lucide icon="Building" class="w-4 h-4 mr-2 text-primary" />
                    HR - Departments
                </h3>
                @foreach (['notifications.department.created', 'notifications.department.updated', 'notifications.department.deleted'] as $key)
                    @php 
                        $field = $notificationSettings[$key];
                        $fieldName = str_replace('.', '_', $key);
                    @endphp
                    <div class="mb-4 flex items-center justify-between">
                        <div class="flex-1">
                            <div class="font-medium text-sm text-slate-800 dark:text-slate-100">{{ $field['label'] }}</div>
                            <div class="text-xs text-slate-500 dark:text-slate-400">{{ $field['description'] }}</div>
                        </div>
                        <input type="hidden" name="{{ $fieldName }}" value="0">
                        <input
                            id="{{ $fieldName }}"
                            name="{{ $fieldName }}"
                            type="checkbox"
                            value="1"
                            {{ $field['value'] ? 'checked' : '' }}
                            class="transition-all duration-100 ease-in-out shadow-sm border-slate-200 cursor-pointer focus:ring-4 focus:ring-offset-0 focus:ring-primary focus:ring-opacity-20 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&[type='radio']]:checked:bg-primary [&[type='radio']]:checked:border-primary [&[type='radio']]:checked:border-opacity-10 [&[type='checkbox']]:checked:bg-primary [&[type='checkbox']]:checked:border-primary [&[type='checkbox']]:checked:border-opacity-10 [&:disabled:not(:checked)]:bg-slate-100 [&:disabled:not(:checked)]:cursor-not-allowed [&:disabled:not(:checked)]:dark:bg-darkmode-800/50 [&:disabled:checked]:opacity-70 [&:disabled:checked]:cursor-not-allowed [&:disabled:checked]:dark:bg-darkmode-800/50 w-[38px] h-[24px] p-px rounded-full relative before:w-[20px] before:h-[20px] before:shadow-[1px_1px_3px_rgba(0,0,0,0.25)] before:transition-[margin-left] before:duration-200 before:ease-in-out before:absolute before:inset-y-0 before:my-auto before:rounded-full before:dark:bg-darkmode-600 checked:bg-primary checked:border-primary checked:bg-none before:checked:ml-[14px] before:checked:bg-white ml-3 mr-0"
                        />
                    </div>
                @endforeach
            </div>

            <!-- HR - Positions -->
            <div class="col-span-12 md:col-span-6 lg:col-span-4">
                <h3 class="mb-3 flex items-center text-sm font-semibold text-slate-800 dark:text-slate-100">
                    <x-base.lucide icon="Briefcase" class="w-4 h-4 mr-2 text-primary" />
                    HR - Positions
                </h3>
                @foreach (['notifications.position.created', 'notifications.position.updated', 'notifications.position.deleted'] as $key)
                    @php 
                        $field = $notificationSettings[$key];
                        $fieldName = str_replace('.', '_', $key);
                    @endphp
                    <div class="mb-4 flex items-center justify-between">
                        <div class="flex-1">
                            <div class="font-medium text-sm text-slate-800 dark:text-slate-100">{{ $field['label'] }}</div>
                            <div class="text-xs text-slate-500 dark:text-slate-400">{{ $field['description'] }}</div>
                        </div>
                        <input type="hidden" name="{{ $fieldName }}" value="0">
                        <input
                            id="{{ $fieldName }}"
                            name="{{ $fieldName }}"
                            type="checkbox"
                            value="1"
                            {{ $field['value'] ? 'checked' : '' }}
                            class="transition-all duration-100 ease-in-out shadow-sm border-slate-200 cursor-pointer focus:ring-4 focus:ring-offset-0 focus:ring-primary focus:ring-opacity-20 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&[type='radio']]:checked:bg-primary [&[type='radio']]:checked:border-primary [&[type='radio']]:checked:border-opacity-10 [&[type='checkbox']]:checked:bg-primary [&[type='checkbox']]:checked:border-primary [&[type='checkbox']]:checked:border-opacity-10 [&:disabled:not(:checked)]:bg-slate-100 [&:disabled:not(:checked)]:cursor-not-allowed [&:disabled:not(:checked)]:dark:bg-darkmode-800/50 [&:disabled:checked]:opacity-70 [&:disabled:checked]:cursor-not-allowed [&:disabled:checked]:dark:bg-darkmode-800/50 w-[38px] h-[24px] p-px rounded-full relative before:w-[20px] before:h-[20px] before:shadow-[1px_1px_3px_rgba(0,0,0,0.25)] before:transition-[margin-left] before:duration-200 before:ease-in-out before:absolute before:inset-y-0 before:my-auto before:rounded-full before:dark:bg-darkmode-600 checked:bg-primary checked:border-primary checked:bg-none before:checked:ml-[14px] before:checked:bg-white ml-3 mr-0"
                        />
                    </div>
                @endforeach
            </div>

            <!-- HR - Employees -->
            <div class="col-span-12 md:col-span-6 lg:col-span-4">
                <h3 class="mb-3 flex items-center text-sm font-semibold text-slate-800 dark:text-slate-100">
                    <x-base.lucide icon="User" class="w-4 h-4 mr-2 text-primary" />
                    HR - Employees
                </h3>
                @foreach (['notifications.employee.created', 'notifications.employee.deleted'] as $key)
                    @php 
                        $field = $notificationSettings[$key];
                        $fieldName = str_replace('.', '_', $key);
                    @endphp
                    <div class="mb-4 flex items-center justify-between">
                        <div class="flex-1">
                            <div class="font-medium text-sm text-slate-800 dark:text-slate-100">{{ $field['label'] }}</div>
                            <div class="text-xs text-slate-500 dark:text-slate-400">{{ $field['description'] }}</div>
                        </div>
                        <input type="hidden" name="{{ $fieldName }}" value="0">
                        <input
                            id="{{ $fieldName }}"
                            name="{{ $fieldName }}"
                            type="checkbox"
                            value="1"
                            {{ $field['value'] ? 'checked' : '' }}
                            class="transition-all duration-100 ease-in-out shadow-sm border-slate-200 cursor-pointer focus:ring-4 focus:ring-offset-0 focus:ring-primary focus:ring-opacity-20 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&[type='radio']]:checked:bg-primary [&[type='radio']]:checked:border-primary [&[type='radio']]:checked:border-opacity-10 [&[type='checkbox']]:checked:bg-primary [&[type='checkbox']]:checked:border-primary [&[type='checkbox']]:checked:border-opacity-10 [&:disabled:not(:checked)]:bg-slate-100 [&:disabled:not(:checked)]:cursor-not-allowed [&:disabled:not(:checked)]:dark:bg-darkmode-800/50 [&:disabled:checked]:opacity-70 [&:disabled:checked]:cursor-not-allowed [&:disabled:checked]:dark:bg-darkmode-800/50 w-[38px] h-[24px] p-px rounded-full relative before:w-[20px] before:h-[20px] before:shadow-[1px_1px_3px_rgba(0,0,0,0.25)] before:transition-[margin-left] before:duration-200 before:ease-in-out before:absolute before:inset-y-0 before:my-auto before:rounded-full before:dark:bg-darkmode-600 checked:bg-primary checked:border-primary checked:bg-none before:checked:ml-[14px] before:checked:bg-white ml-3 mr-0"
                        />
                    </div>
                @endforeach
            </div>
        </div>
        <div class="mt-5 flex justify-end">
            <x-base.button type="submit" variant="primary" class="w-32">
                Save Notifications
            </x-base.button>
        </div>
    </form>
</div>

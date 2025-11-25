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
                'value' => \App\Models\Setting\Setting::get('notifications.department.created', true),
            ],
            'notifications.department.updated' => [
                'label' => 'Department Updated',
                'description' => 'Send a bell notification when a department is updated.',
                'value' => \App\Models\Setting\Setting::get('notifications.department.updated', true),
            ],
            'notifications.department.deleted' => [
                'label' => 'Department Deleted',
                'description' => 'Send a bell notification when a department is deleted.',
                'value' => \App\Models\Setting\Setting::get('notifications.department.deleted', true),
            ],

            // Positions
            'notifications.position.created' => [
                'label' => 'Position Created',
                'description' => 'Send a bell notification when a new position is created.',
                'value' => \App\Models\Setting\Setting::get('notifications.position.created', true),
            ],
            'notifications.position.updated' => [
                'label' => 'Position Updated',
                'description' => 'Send a bell notification when a position is updated.',
                'value' => \App\Models\Setting\Setting::get('notifications.position.updated', true),
            ],
            'notifications.position.deleted' => [
                'label' => 'Position Deleted',
                'description' => 'Send a bell notification when a position is deleted.',
                'value' => \App\Models\Setting\Setting::get('notifications.position.deleted', true),
            ],

            // Employees
            'notifications.employee.created' => [
                'label' => 'Employee Created',
                'description' => 'Send a bell notification when a new employee is created.',
                'value' => \App\Models\Setting\Setting::get('notifications.employee.created', true),
            ],
            'notifications.employee.deleted' => [
                'label' => 'Employee Deleted',
                'description' => 'Send a bell notification when an employee is deleted.',
                'value' => \App\Models\Setting\Setting::get('notifications.employee.deleted', true),
            ],
        ];

        $documentsExpiryReminderDays = \App\Models\Setting\Setting::get('notifications.documents.expiry_reminder_days', 30);
        $employeeDocumentsExpiryReminderDays = \App\Models\Setting\Setting::get('notifications.employee_documents.expiry_reminder_days', 30);
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
            
            <!-- Documents expiry reminder -->
            <div class="col-span-12 md:col-span-6 lg:col-span-4">
                <h3 class="mb-3 flex items-center text-sm font-semibold text-slate-800 dark:text-slate-100">
                    <x-base.lucide icon="FileWarning" class="w-4 h-4 mr-2 text-primary" />
                    Documents
                </h3>

                <div class="mb-4">
                    <div class="font-medium text-sm text-slate-800 dark:text-slate-100">
                        Expiry reminder (days before)
                    </div>
                    <div class="text-xs text-slate-500 dark:text-slate-400 mb-2">
                        Number of days before a document's expiry date to start showing reminders.
                    </div>
                    <x-base.form-input
                        type="number"
                        min="1"
                        max="365"
                        name="notifications_documents_expiry_reminder_days"
                        value="{{ $documentsExpiryReminderDays }}"
                        class="w-32"
                    />
                </div>

                <div class="mt-4 mb-2 border-t border-dashed border-slate-200 dark:border-darkmode-400 pt-4">
                    <div class="font-medium text-sm text-slate-800 dark:text-slate-100 flex items-center">
                        <x-base.lucide icon="IdCard" class="w-4 h-4 mr-2 text-primary" />
                        Employee documents expiry (days before)
                    </div>
                    <div class="text-xs text-slate-500 dark:text-slate-400 mb-2">
                        Number of days before an employee document expiry date (passport, visa, ID, etc.) to start showing reminders.
                    </div>
                    <x-base.form-input
                        type="number"
                        min="1"
                        max="365"
                        name="notifications_employee_documents_expiry_reminder_days"
                        value="{{ $employeeDocumentsExpiryReminderDays }}"
                        class="w-32"
                    />
                </div>
            </div>
                        <input type="hidden" name="{{ $fieldName }}" value="0">
                        <label class="inline-flex cursor-pointer items-center ml-3">
                            <input
                            id="{{ $fieldName }}"
                            name="{{ $fieldName }}"
                            type="checkbox"
                            value="1"
                            {{ $field['value'] ? 'checked' : '' }}
                            class="sr-only peer"
                            />
                            <div class="relative w-11 h-6 rounded-full bg-slate-200 transition-colors duration-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/25 dark:bg-darkmode-600 peer-checked:bg-primary after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition-all after:duration-200 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full"></div>
                        </label>
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
                        <label class="inline-flex cursor-pointer items-center ml-3">
                            <input
                            id="{{ $fieldName }}"
                            name="{{ $fieldName }}"
                            type="checkbox"
                            value="1"
                            {{ $field['value'] ? 'checked' : '' }}
                            class="sr-only peer"
                            />
                            <div class="relative w-11 h-6 rounded-full bg-slate-200 transition-colors duration-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/25 dark:bg-darkmode-600 peer-checked:bg-primary after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition-all after:duration-200 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full"></div>
                        </label>
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
                        <label class="inline-flex cursor-pointer items-center ml-3">
                            <input
                            id="{{ $fieldName }}"
                            name="{{ $fieldName }}"
                            type="checkbox"
                            value="1"
                            {{ $field['value'] ? 'checked' : '' }}
                            class="sr-only peer"
                            />
                            <div class="relative w-11 h-6 rounded-full bg-slate-200 transition-colors duration-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/25 dark:bg-darkmode-600 peer-checked:bg-primary after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition-all after:duration-200 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full"></div>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="mt-5 flex justify-end">
            <button type="submit" class="btn-royal btn-royal--gold btn-royal--sm w-48">
                <x-base.lucide icon="save" class="w-4 h-4 mr-2" />
                Save Notifications
            </button>
        </div>
    </form>
</div>

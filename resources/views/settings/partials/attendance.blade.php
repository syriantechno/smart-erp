@php
    // Attendance Settings
    $attendanceSettings = [
        'attendance.working_hours_per_day' => [
            'value' => \App\Models\Setting::get('attendance.working_hours_per_day', '8'),
            'type' => 'number',
            'label' => 'Working Hours Per Day',
            'description' => 'Number of working hours in a full day',
            'placeholder' => '8',
            'min' => '1',
            'max' => '24'
        ],
        'attendance.half_day_hours' => [
            'value' => \App\Models\Setting::get('attendance.half_day_hours', '4'),
            'type' => 'number',
            'label' => 'Half Day Hours',
            'description' => 'Number of hours required to consider the day as half day',
            'placeholder' => '4',
            'min' => '1',
            'max' => '12'
        ],
        'attendance.grace_period_minutes' => [
            'value' => \App\Models\Setting::get('attendance.grace_period_minutes', '15'),
            'type' => 'number',
            'label' => 'Grace Period (Minutes)',
            'description' => 'Allowed delay time before considering it as absence',
            'placeholder' => '15',
            'min' => '0',
            'max' => '120'
        ],
        'attendance.auto_checkout_time' => [
            'value' => \App\Models\Setting::get('attendance.auto_checkout_time', '18:00'),
            'type' => 'time',
            'label' => 'Auto Checkout Time',
            'description' => 'Automatic checkout time if employee doesn\'t log their checkout',
            'placeholder' => '18:00'
        ],
        'attendance.minimum_working_hours' => [
            'value' => \App\Models\Setting::get('attendance.minimum_working_hours', '6'),
            'type' => 'number',
            'label' => 'Minimum Working Hours',
            'description' => 'Minimum hours required to consider the day as complete',
            'placeholder' => '6',
            'min' => '1',
            'max' => '24'
        ],
        'attendance.enable_auto_attendance' => [
            'value' => \App\Models\Setting::get('attendance.enable_auto_attendance', '0'),
            'type' => 'checkbox',
            'label' => 'Enable Auto Attendance',
            'description' => 'Enable automatic attendance check-in and check-out recording'
        ],
        'attendance.allow_mobile_checkin' => [
            'value' => \App\Models\Setting::get('attendance.allow_mobile_checkin', '1'),
            'type' => 'checkbox',
            'label' => 'Allow Mobile Check-in',
            'description' => 'Allow employees to check-in through mobile applications'
        ],
        'attendance.require_location' => [
            'value' => \App\Models\Setting::get('attendance.require_location', '0'),
            'type' => 'checkbox',
            'label' => 'Require Location',
            'description' => 'Require employee location verification during check-in'
        ],
        'attendance.notify_late_arrival' => [
            'value' => \App\Models\Setting::get('attendance.notify_late_arrival', '1'),
            'type' => 'checkbox',
            'label' => 'Late Arrival Notification',
            'description' => 'Send notification when employee arrives late'
        ],
        'attendance.notify_early_departure' => [
            'value' => \App\Models\Setting::get('attendance.notify_early_departure', '1'),
            'type' => 'checkbox',
            'label' => 'Early Departure Notification',
            'description' => 'Send notification when employee leaves early'
        ],
        'attendance.weekend_days' => [
            'value' => \App\Models\Setting::get('attendance.weekend_days', '5,6'),
            'type' => 'text',
            'label' => 'Weekend Days',
            'description' => 'Weekend day numbers (0=Sunday, 1=Monday, etc). Comma separated',
            'placeholder' => '5,6'
        ],
        'attendance.holidays' => [
            'value' => \App\Models\Setting::get('attendance.holidays', ''),
            'type' => 'textarea',
            'label' => 'Official Holidays',
            'description' => 'Official holiday dates (YYYY-MM-DD), each date on a separate line',
            'placeholder' => '2025-01-01' . "\n" . '2025-12-25'
        ]
    ];
@endphp

<!-- Attendance Settings Content Loaded -->
<div class="bg-white dark:bg-darkmode-600 rounded-lg shadow-sm border border-slate-200/60 dark:border-darkmode-400 mt-5">
    <div class="flex items-center border-b border-slate-200/60 p-5 dark:border-darkmode-400">
        <h2 class="mr-auto text-base font-medium flex items-center">
            <x-base.lucide icon="Clock" class="w-5 h-5 mr-2 text-blue-500" />
            Attendance Settings
        </h2>
        <x-base.button type="submit" form="attendance-settings-form" variant="primary">
            <x-base.lucide icon="Save" class="w-4 h-4 mr-2" />
            Save Settings
        </x-base.button>
    </div>

    <form id="attendance-settings-form" action="{{ route('settings.attendance.update') }}" method="POST" class="p-5">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-12 gap-6">
            <!-- Working Hours Per Day -->
            <div class="col-span-12 md:col-span-6 lg:col-span-4">
                    <x-base.form-label for="attendance.working_hours_per_day">
                        {{ $attendanceSettings['attendance.working_hours_per_day']['label'] }}
                        <span class="text-danger">*</span>
                    </x-base.form-label>
                    <x-base.form-input
                        id="attendance.working_hours_per_day"
                        name="attendance.working_hours_per_day"
                        type="number"
                        value="{{ $attendanceSettings['attendance.working_hours_per_day']['value'] }}"
                        placeholder="{{ $attendanceSettings['attendance.working_hours_per_day']['placeholder'] }}"
                        min="{{ $attendanceSettings['attendance.working_hours_per_day']['min'] }}"
                        max="{{ $attendanceSettings['attendance.working_hours_per_day']['max'] }}"
                        class="w-full"
                        required
                    />
                    <div class="text-sm text-slate-500 mt-1">
                        {{ $attendanceSettings['attendance.working_hours_per_day']['description'] }}
                    </div>
                </div>

                <!-- Half Day Hours -->
                <div class="col-span-12 md:col-span-6 lg:col-span-4">
                    <x-base.form-label for="attendance.half_day_hours">
                        {{ $attendanceSettings['attendance.half_day_hours']['label'] }}
                        <span class="text-danger">*</span>
                    </x-base.form-label>
                    <x-base.form-input
                        id="attendance.half_day_hours"
                        name="attendance.half_day_hours"
                        type="number"
                        value="{{ $attendanceSettings['attendance.half_day_hours']['value'] }}"
                        placeholder="{{ $attendanceSettings['attendance.half_day_hours']['placeholder'] }}"
                        min="{{ $attendanceSettings['attendance.half_day_hours']['min'] }}"
                        max="{{ $attendanceSettings['attendance.half_day_hours']['max'] }}"
                        class="w-full"
                        required
                    />
                    <div class="text-sm text-slate-500 mt-1">
                        {{ $attendanceSettings['attendance.half_day_hours']['description'] }}
                    </div>
                </div>

                <!-- Minimum Working Hours -->
                <div class="col-span-12 md:col-span-6 lg:col-span-4">
                    <x-base.form-label for="attendance.minimum_working_hours">
                        {{ $attendanceSettings['attendance.minimum_working_hours']['label'] }}
                        <span class="text-danger">*</span>
                    </x-base.form-label>
                    <x-base.form-input
                        id="attendance.minimum_working_hours"
                        name="attendance.minimum_working_hours"
                        type="number"
                        value="{{ $attendanceSettings['attendance.minimum_working_hours']['value'] }}"
                        placeholder="{{ $attendanceSettings['attendance.minimum_working_hours']['placeholder'] }}"
                        min="{{ $attendanceSettings['attendance.minimum_working_hours']['min'] }}"
                        max="{{ $attendanceSettings['attendance.minimum_working_hours']['max'] }}"
                        class="w-full"
                        required
                    />
                    <div class="text-sm text-slate-500 mt-1">
                        {{ $attendanceSettings['attendance.minimum_working_hours']['description'] }}
                    </div>
                </div>

                <!-- Grace Period -->
                <div class="col-span-12 md:col-span-6 lg:col-span-4">
                    <x-base.form-label for="attendance.grace_period_minutes">
                        {{ $attendanceSettings['attendance.grace_period_minutes']['label'] }}
                        <span class="text-danger">*</span>
                    </x-base.form-label>
                    <x-base.form-input
                        id="attendance.grace_period_minutes"
                        name="attendance.grace_period_minutes"
                        type="number"
                        value="{{ $attendanceSettings['attendance.grace_period_minutes']['value'] }}"
                        placeholder="{{ $attendanceSettings['attendance.grace_period_minutes']['placeholder'] }}"
                        min="{{ $attendanceSettings['attendance.grace_period_minutes']['min'] }}"
                        max="{{ $attendanceSettings['attendance.grace_period_minutes']['max'] }}"
                        class="w-full"
                        required
                    />
                    <div class="text-sm text-slate-500 mt-1">
                        {{ $attendanceSettings['attendance.grace_period_minutes']['description'] }}
                    </div>
                </div>

                <!-- Auto Checkout Time -->
                <div class="col-span-12 md:col-span-6 lg:col-span-4">
                    <x-base.form-label for="attendance.auto_checkout_time">
                        {{ $attendanceSettings['attendance.auto_checkout_time']['label'] }}
                        <span class="text-danger">*</span>
                    </x-base.form-label>
                    <x-base.form-input
                        id="attendance.auto_checkout_time"
                        name="attendance.auto_checkout_time"
                        type="time"
                        value="{{ $attendanceSettings['attendance.auto_checkout_time']['value'] }}"
                        placeholder="{{ $attendanceSettings['attendance.auto_checkout_time']['placeholder'] }}"
                        class="w-full"
                        required
                    />
                    <div class="text-sm text-slate-500 mt-1">
                        {{ $attendanceSettings['attendance.auto_checkout_time']['description'] }}
                    </div>
                </div>

                <!-- Enable Auto Attendance -->
                <div class="col-span-12 md:col-span-6 lg:col-span-4">
                    <label class="flex items-center">
                        <input type="hidden" name="attendance.enable_auto_attendance" value="0">
                        <input
                            type="checkbox"
                            name="attendance.enable_auto_attendance"
                            value="1"
                            {{ $attendanceSettings['attendance.enable_auto_attendance']['value'] ? 'checked' : '' }}
                            class="form-check-input mr-3"
                        >
                        <div>
                            <div class="font-medium">{{ $attendanceSettings['attendance.enable_auto_attendance']['label'] }}</div>
                            <div class="text-sm text-slate-500">{{ $attendanceSettings['attendance.enable_auto_attendance']['description'] }}</div>
                        </div>
                    </label>
                </div>

                <!-- Allow Mobile Check-in -->
                <div class="col-span-12 md:col-span-6 lg:col-span-4">
                    <label class="flex items-center">
                        <input type="hidden" name="attendance.allow_mobile_checkin" value="0">
                        <input
                            type="checkbox"
                            name="attendance.allow_mobile_checkin"
                            value="1"
                            {{ $attendanceSettings['attendance.allow_mobile_checkin']['value'] ? 'checked' : '' }}
                            class="form-check-input mr-3"
                        >
                        <div>
                            <div class="font-medium">{{ $attendanceSettings['attendance.allow_mobile_checkin']['label'] }}</div>
                            <div class="text-sm text-slate-500">{{ $attendanceSettings['attendance.allow_mobile_checkin']['description'] }}</div>
                        </div>
                    </label>
                </div>

                <!-- Require Location -->
                <div class="col-span-12 md:col-span-6 lg:col-span-4">
                    <label class="flex items-center">
                        <input type="hidden" name="attendance.require_location" value="0">
                        <input
                            type="checkbox"
                            name="attendance.require_location"
                            value="1"
                            {{ $attendanceSettings['attendance.require_location']['value'] ? 'checked' : '' }}
                            class="form-check-input mr-3"
                        >
                        <div>
                            <div class="font-medium">{{ $attendanceSettings['attendance.require_location']['label'] }}</div>
                            <div class="text-sm text-slate-500">{{ $attendanceSettings['attendance.require_location']['description'] }}</div>
                        </div>
                    </label>
                </div>

                <!-- Notify Late Arrival -->
                <div class="col-span-12 md:col-span-6 lg:col-span-4">
                    <label class="flex items-center">
                        <input type="hidden" name="attendance.notify_late_arrival" value="0">
                        <input
                            type="checkbox"
                            name="attendance.notify_late_arrival"
                            value="1"
                            {{ $attendanceSettings['attendance.notify_late_arrival']['value'] ? 'checked' : '' }}
                            class="form-check-input mr-3"
                        >
                        <div>
                            <div class="font-medium">{{ $attendanceSettings['attendance.notify_late_arrival']['label'] }}</div>
                            <div class="text-sm text-slate-500">{{ $attendanceSettings['attendance.notify_late_arrival']['description'] }}</div>
                        </div>
                    </label>
                </div>

                <!-- Notify Early Departure -->
                <div class="col-span-12 md:col-span-6 lg:col-span-4">
                    <label class="flex items-center">
                        <input type="hidden" name="attendance.notify_early_departure" value="0">
                        <input
                            type="checkbox"
                            name="attendance.notify_early_departure"
                            value="1"
                            {{ $attendanceSettings['attendance.notify_early_departure']['value'] ? 'checked' : '' }}
                            class="form-check-input mr-3"
                        >
                        <div>
                            <div class="font-medium">{{ $attendanceSettings['attendance.notify_early_departure']['label'] }}</div>
                            <div class="text-sm text-slate-500">{{ $attendanceSettings['attendance.notify_early_departure']['description'] }}</div>
                        </div>
                    </label>
                </div>

                <!-- Weekend Days -->
                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="attendance.weekend_days">
                        {{ $attendanceSettings['attendance.weekend_days']['label'] }}
                    </x-base.form-label>
                    <x-base.form-input
                        id="attendance.weekend_days"
                        name="attendance.weekend_days"
                        type="text"
                        value="{{ $attendanceSettings['attendance.weekend_days']['value'] }}"
                        placeholder="{{ $attendanceSettings['attendance.weekend_days']['placeholder'] }}"
                        class="w-full"
                    />
                    <div class="text-sm text-slate-500 mt-1">
                        {{ $attendanceSettings['attendance.weekend_days']['description'] }}
                    </div>
                </div>

                <!-- Holidays -->
                <div class="col-span-12">
                    <x-base.form-label for="attendance.holidays">
                        {{ $attendanceSettings['attendance.holidays']['label'] }}
                    </x-base.form-label>
                    <x-base.form-textarea
                        id="attendance.holidays"
                        name="attendance.holidays"
                        rows="4"
                        placeholder="{{ $attendanceSettings['attendance.holidays']['placeholder'] }}"
                        class="w-full"
                    >{{ $attendanceSettings['attendance.holidays']['value'] }}</x-base.form-textarea>
                    <div class="text-sm text-slate-500 mt-1">
                        {{ $attendanceSettings['attendance.holidays']['description'] }}
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5 flex justify-end">
            <x-base.button
                type="submit"
                variant="primary"
                class="w-32"
            >
                Save Attendance
            </x-base.button>
        </div>
    </form>

    <!-- Fallback content in case the form doesn't load -->
    <div id="attendance-fallback" class="hidden p-5 text-center">
        <x-base.lucide icon="AlertCircle" class="h-16 w-16 text-orange-500 mx-auto mb-4" />
        <h3 class="text-lg font-semibold text-slate-800 dark:text-white mb-2">Loading Attendance Settings</h3>
        <p class="text-slate-600 dark:text-slate-400 mb-4">
            If the settings don't appear, please reload the page or contact technical support.
        </p>
        <x-base.button onclick="window.location.reload()" variant="primary">
            <x-base.lucide icon="RefreshCw" class="w-4 h-4 mr-2" />
            Reload Page
        </x-base.button>
    </div>
</div>

<script>
    // Show fallback content after 3 seconds if main content is not visible
    setTimeout(function() {
        const mainContent = document.querySelector('#attendance-settings-form');
        const fallbackContent = document.querySelector('#attendance-fallback');

        if (mainContent && fallbackContent && mainContent.offsetParent === null) {
            fallbackContent.classList.remove('hidden');
        }
    }, 3000);
</script>

@php
    // Attendance Settings
    $attendanceSettings = [
        'attendance.working_hours_per_day' => [
            'value' => \App\Models\Setting::get('attendance.working_hours_per_day', '8'),
            'type' => 'number',
            'label' => 'ساعات العمل اليومية',
            'description' => 'عدد ساعات العمل في اليوم الكامل',
            'placeholder' => '8',
            'min' => '1',
            'max' => '24'
        ],
        'attendance.half_day_hours' => [
            'value' => \App\Models\Setting::get('attendance.half_day_hours', '4'),
            'type' => 'number',
            'label' => 'ساعات نصف اليوم',
            'description' => 'عدد الساعات المطلوبة لاعتبار اليوم نصف يوم',
            'placeholder' => '4',
            'min' => '1',
            'max' => '12'
        ],
        'attendance.grace_period_minutes' => [
            'value' => \App\Models\Setting::get('attendance.grace_period_minutes', '15'),
            'type' => 'number',
            'label' => 'فترة السماح (دقائق)',
            'description' => 'الوقت المسموح به للتأخير قبل اعتبار الغياب',
            'placeholder' => '15',
            'min' => '0',
            'max' => '120'
        ],
        'attendance.auto_checkout_time' => [
            'value' => \App\Models\Setting::get('attendance.auto_checkout_time', '18:00'),
            'type' => 'time',
            'label' => 'وقت الخروج التلقائي',
            'description' => 'وقت الخروج التلقائي إذا لم يسجل الموظف خروجه',
            'placeholder' => '18:00'
        ],
        'attendance.minimum_working_hours' => [
            'value' => \App\Models\Setting::get('attendance.minimum_working_hours', '6'),
            'type' => 'number',
            'label' => 'الحد الأدنى لساعات العمل',
            'description' => 'الحد الأدنى من الساعات المطلوبة ليتم اعتبار اليوم كاملاً',
            'placeholder' => '6',
            'min' => '1',
            'max' => '24'
        ],
        'attendance.enable_auto_attendance' => [
            'value' => \App\Models\Setting::get('attendance.enable_auto_attendance', '0'),
            'type' => 'checkbox',
            'label' => 'تفعيل التسجيل التلقائي',
            'description' => 'تفعيل تسجيل الحضور والانصراف تلقائياً'
        ],
        'attendance.allow_mobile_checkin' => [
            'value' => \App\Models\Setting::get('attendance.allow_mobile_checkin', '1'),
            'type' => 'checkbox',
            'label' => 'السماح بالتسجيل عبر الهاتف',
            'description' => 'السماح للموظفين بالتسجيل عبر تطبيقات الهاتف'
        ],
        'attendance.require_location' => [
            'value' => \App\Models\Setting::get('attendance.require_location', '0'),
            'type' => 'checkbox',
            'label' => 'طلب تحديد الموقع',
            'description' => 'طلب تحديد موقع الموظف عند التسجيل'
        ],
        'attendance.notify_late_arrival' => [
            'value' => \App\Models\Setting::get('attendance.notify_late_arrival', '1'),
            'type' => 'checkbox',
            'label' => 'إشعار التأخير',
            'description' => 'إرسال إشعار عند تأخر الموظف'
        ],
        'attendance.notify_early_departure' => [
            'value' => \App\Models\Setting::get('attendance.notify_early_departure', '1'),
            'type' => 'checkbox',
            'label' => 'إشعار المغادرة المبكرة',
            'description' => 'إرسال إشعار عند مغادرة الموظف مبكراً'
        ],
        'attendance.weekend_days' => [
            'value' => \App\Models\Setting::get('attendance.weekend_days', '5,6'),
            'type' => 'text',
            'label' => 'أيام نهاية الأسبوع',
            'description' => 'أرقام أيام نهاية الأسبوع (0=الأحد, 1=الاثنين, إلخ). مفصولة بفواصل',
            'placeholder' => '5,6'
        ],
        'attendance.holidays' => [
            'value' => \App\Models\Setting::get('attendance.holidays', ''),
            'type' => 'textarea',
            'label' => 'العطلات الرسمية',
            'description' => 'تواريخ العطلات الرسمية (YYYY-MM-DD)، كل تاريخ في سطر منفصل',
            'placeholder' => '2025-01-01' . "\n" . '2025-12-25'
        ]
    ];
@endphp

<!-- Attendance Settings Content Loaded -->
<div class="intro-y box">
    <div class="flex items-center border-b border-slate-200/60 p-5 dark:border-darkmode-400">
        <h2 class="mr-auto text-base font-medium flex items-center">
            <x-base.lucide icon="Clock" class="w-5 h-5 mr-2 text-blue-500" />
            إعدادات الحضور والغياب
        </h2>
        <x-base.button type="submit" form="attendance-settings-form" variant="primary">
            <x-base.lucide icon="Save" class="w-4 h-4 mr-2" />
            حفظ الإعدادات
        </x-base.button>
    </div>

    <!-- Success Message -->
    <div class="p-5 bg-green-50 border-l-4 border-green-400 text-green-700">
        <div class="flex">
            <div class="flex-shrink-0">
                <x-base.lucide icon="CheckCircle" class="h-5 w-5 text-green-400" />
            </div>
            <div class="ml-3">
                <p class="text-sm">
                    <strong>تم تحميل إعدادات الحضور والغياب بنجاح!</strong>
                    يمكنك الآن تخصيص إعدادات نظام الحضور والغياب لشركتك.
                </p>
            </div>
        </div>
    </div>

    <form id="attendance-settings-form" action="{{ route('settings.attendance.update') }}" method="POST" class="p-5">
        @csrf
        @method('PUT')

        <!-- Instructions -->
        <div class="mb-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <div class="flex items-start">
                <x-base.lucide icon="Info" class="h-5 w-5 text-blue-400 mt-0.5 mr-3 flex-shrink-0" />
                <div>
                    <h4 class="text-sm font-medium text-blue-800 mb-2">تعليمات إعداد نظام الحضور والغياب</h4>
                    <ul class="text-sm text-blue-700 space-y-1">
                        <li>• <strong>ساعات العمل اليومية:</strong> عدد الساعات الكاملة في اليوم العملي</li>
                        <li>• <strong>ساعات نصف اليوم:</strong> الحد الأدنى لاعتبار اليوم نصف يوم</li>
                        <li>• <strong>فترة السماح:</strong> الوقت المسموح به للتأخير قبل الغياب</li>
                        <li>• <strong>وقت الخروج التلقائي:</strong> وقت إغلاق النظام تلقائياً</li>
                        <li>• <strong>أيام نهاية الأسبوع:</strong> أرقام الأيام (0=الأحد, 1=الاثنين, ...)</li>
                        <li>• <strong>العطلات الرسمية:</strong> تاريخ واحد في كل سطر (YYYY-MM-DD)</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Working Hours Settings -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center">
                <x-base.lucide icon="Clock" class="h-5 w-5 mr-2 text-blue-500" />
                إعدادات ساعات العمل
            </h3>
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
            </div>
        </div>

        <!-- Auto Attendance Settings -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center">
                <x-base.lucide icon="Zap" class="h-5 w-5 mr-2 text-green-500" />
                إعدادات التسجيل التلقائي
            </h3>
            <div class="grid grid-cols-12 gap-6">
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
            </div>
        </div>

        <!-- Features & Notifications -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center">
                <x-base.lucide icon="Settings" class="h-5 w-5 mr-2 text-purple-500" />
                المميزات والإشعارات
            </h3>
            <div class="grid grid-cols-12 gap-6">
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
            </div>
        </div>

        <!-- Schedule Settings -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center">
                <x-base.lucide icon="Calendar" class="h-5 w-5 mr-2 text-orange-500" />
                إعدادات الجدول الزمني
            </h3>
            <div class="grid grid-cols-12 gap-6">
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
    </form>

    <!-- Fallback content in case the form doesn't load -->
    <div id="attendance-fallback" class="hidden p-5 text-center">
        <x-base.lucide icon="AlertCircle" class="h-16 w-16 text-orange-500 mx-auto mb-4" />
        <h3 class="text-lg font-semibold text-slate-800 dark:text-white mb-2">تحميل إعدادات الحضور والغياب</h3>
        <p class="text-slate-600 dark:text-slate-400 mb-4">
            إذا لم تظهر الإعدادات، يرجى إعادة تحميل الصفحة أو التواصل مع الدعم الفني.
        </p>
        <x-base.button onclick="window.location.reload()" variant="primary">
            <x-base.lucide icon="RefreshCw" class="w-4 h-4 mr-2" />
            إعادة تحميل الصفحة
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

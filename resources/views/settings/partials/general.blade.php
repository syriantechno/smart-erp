<!-- General Settings Content Loaded -->
<div class="bg-white dark:bg-darkmode-600 rounded-lg shadow-sm border border-slate-200/60 dark:border-darkmode-400 mt-5">
    <div class="flex items-center border-b border-slate-200/60 p-5 dark:border-darkmode-400">
        <h2 class="mr-auto text-base font-medium flex items-center">
            <x-base.lucide icon="Settings" class="w-5 h-5 mr-2 text-gray-500" />
            General Settings
        </h2>
        <x-base.button type="submit" form="generalSettingsForm" variant="primary">
            <x-base.lucide icon="Save" class="w-4 h-4 mr-2" />
            Save Changes
        </x-base.button>
    </div>

    <form id="generalSettingsForm" action="{{ route('settings.update') }}" method="POST" class="p-5">
        @csrf

        <div class="grid grid-cols-12 gap-6">
            <!-- App Name -->
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="app_name">
                    Application Name <span class="text-danger">*</span>
                </x-base.form-label>
                <x-base.form-input
                    id="app_name"
                    name="app_name"
                    type="text"
                    class="w-full"
                    placeholder="Enter application name"
                    value="{{ old('app_name', $settings['app_name'] ?? config('app.name', 'ERP System')) }}"
                    required
                />
                <div class="text-sm text-slate-500 mt-1">
                    The name of your application as it appears throughout the system.
                </div>
            </div>

            <!-- Default Language -->
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="default_language">
                    Default Language
                </x-base.form-label>
                <select
                    id="default_language"
                    name="default_language"
                    class="form-select w-full"
                >
                    <option value="en" {{ old('default_language', $settings['app.locale'] ?? config('app.locale', 'en')) == 'en' ? 'selected' : '' }}>English</option>
                    <option value="ar" {{ old('default_language', $settings['app.locale'] ?? config('app.locale', 'en')) == 'ar' ? 'selected' : '' }}>العربية</option>
                </select>
                <div class="text-sm text-slate-500 mt-1">
                    The default language for the application interface.
                </div>
            </div>

            <!-- Timezone -->
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="timezone">
                    Timezone
                </x-base.form-label>
                <select
                    id="timezone"
                    name="timezone"
                    class="form-select w-full"
                >
                    <option value="UTC" {{ old('timezone', $settings['app.timezone'] ?? config('app.timezone', 'UTC')) == 'UTC' ? 'selected' : '' }}>UTC</option>
                    <option value="Asia/Riyadh" {{ old('timezone', $settings['app.timezone'] ?? config('app.timezone', 'UTC')) == 'Asia/Riyadh' ? 'selected' : '' }}>Asia/Riyadh (Saudi Arabia)</option>
                    <option value="Asia/Dubai" {{ old('timezone', $settings['app.timezone'] ?? config('app.timezone', 'UTC')) == 'Asia/Dubai' ? 'selected' : '' }}>Asia/Dubai (UAE)</option>
                </select>
                <div class="text-sm text-slate-500 mt-1">
                    The timezone for date and time display.
                </div>
            </div>

            <!-- Date Format -->
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="date_format">
                    Date Format
                </x-base.form-label>
                <select
                    id="date_format"
                    name="date_format"
                    class="form-select w-full"
                >
                    <option value="Y-m-d" {{ old('date_format', $settings['date_format'] ?? 'Y-m-d') == 'Y-m-d' ? 'selected' : '' }}>YYYY-MM-DD</option>
                    <option value="d/m/Y" {{ old('date_format', $settings['date_format'] ?? 'Y-m-d') == 'd/m/Y' ? 'selected' : '' }}>DD/MM/YYYY</option>
                    <option value="m/d/Y" {{ old('date_format', $settings['date_format'] ?? 'Y-m-d') == 'm/d/Y' ? 'selected' : '' }}>MM/DD/YYYY</option>
                </select>
                <div class="text-sm text-slate-500 mt-1">
                    How dates are displayed throughout the system.
                </div>
            </div>

            <!-- Enable Maintenance Mode -->
            <div class="col-span-12 md:col-span-6">
                <label class="flex items-center">
                    <input type="hidden" name="maintenance_mode" value="0">
                    <input
                        type="checkbox"
                        name="maintenance_mode"
                        value="1"
                        {{ old('maintenance_mode', $settings['maintenance_mode'] ?? 0) ? 'checked' : '' }}
                        class="form-check-input mr-3"
                    >
                    <div>
                        <div class="font-medium">Maintenance Mode</div>
                        <div class="text-sm text-slate-500">Enable maintenance mode to prevent user access</div>
                    </div>
                </label>
            </div>

            <!-- Debug Mode -->
            <div class="col-span-12 md:col-span-6">
                <label class="flex items-center">
                    <input type="hidden" name="debug_mode" value="0">
                    <input
                        type="checkbox"
                        name="debug_mode"
                        value="1"
                        {{ old('debug_mode', $settings['app.debug'] ?? config('app.debug', false)) ? 'checked' : '' }}
                        class="form-check-input mr-3"
                    >
                    <div>
                        <div class="font-medium">Debug Mode</div>
                        <div class="text-sm text-slate-500">Show detailed error messages (only enable in development)</div>
                    </div>
                </label>
            </div>
        </div>

        <div class="mt-5 flex justify-end">
            <x-base.button
                type="submit"
                variant="primary"
                class="w-32"
            >
                Save Settings
            </x-base.button>
        </div>
    </form>
</div>

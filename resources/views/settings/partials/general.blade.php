<!-- General Settings Content Loaded -->
<div class="bg-white dark:bg-darkmode-600 rounded-lg shadow-sm border border-slate-200/60 dark:border-darkmode-400 mt-5">
    <div class="flex items-center border-b border-slate-200/60 p-5 dark:border-darkmode-400">
        <h2 class="mr-auto text-base font-medium flex items-center">
            <x-base.lucide icon="Settings" class="w-5 h-5 mr-2 text-gray-500" />
            General Settings
        </h2>
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
                <x-base.form-select
                    id="default_language"
                    name="default_language"
                    class="w-full"
                >
                    <option value="en" {{ old('default_language', $settings['app.locale'] ?? config('app.locale', 'en')) == 'en' ? 'selected' : '' }}>English</option>
                    <option value="ar" {{ old('default_language', $settings['app.locale'] ?? config('app.locale', 'en')) == 'ar' ? 'selected' : '' }}>العربية</option>
                </x-base.form-select>
                <div class="text-sm text-slate-500 mt-1">
                    The default language for the application interface.
                </div>
            </div>

            <!-- Timezone -->
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="timezone">
                    Timezone
                </x-base.form-label>
                <x-base.form-select
                    id="timezone"
                    name="timezone"
                    class="w-full"
                >
                    <option value="UTC" {{ old('timezone', $settings['app.timezone'] ?? config('app.timezone', 'UTC')) == 'UTC' ? 'selected' : '' }}>UTC</option>
                    <option value="Asia/Riyadh" {{ old('timezone', $settings['app.timezone'] ?? config('app.timezone', 'UTC')) == 'Asia/Riyadh' ? 'selected' : '' }}>Asia/Riyadh (Saudi Arabia)</option>
                    <option value="Asia/Dubai" {{ old('timezone', $settings['app.timezone'] ?? config('app.timezone', 'UTC')) == 'Asia/Dubai' ? 'selected' : '' }}>Asia/Dubai (UAE)</option>
                </x-base.form-select>
                <div class="text-sm text-slate-500 mt-1">
                    The timezone for date and time display.
                </div>
            </div>

            <!-- Date Format -->
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="date_format">
                    Date Format
                </x-base.form-label>
                <x-base.form-select
                    id="date_format"
                    name="date_format"
                    class="w-full"
                >
                    <option value="Y-m-d" {{ old('date_format', $settings['date_format'] ?? 'Y-m-d') == 'Y-m-d' ? 'selected' : '' }}>YYYY-MM-DD</option>
                    <option value="d/m/Y" {{ old('date_format', $settings['date_format'] ?? 'Y-m-d') == 'd/m/Y' ? 'selected' : '' }}>DD/MM/YYYY</option>
                    <option value="m/d/Y" {{ old('date_format', $settings['date_format'] ?? 'Y-m-d') == 'm/d/Y' ? 'selected' : '' }}>MM/DD/YYYY</option>
                </x-base.form-select>
                <div class="text-sm text-slate-500 mt-1">
                    How dates are displayed throughout the system.
                </div>
            </div>

            <!-- Currency Code -->
            <div class="col-span-12 md:col-span-4">
                <x-base.form-label for="currency_code">
                    Currency Code
                </x-base.form-label>
                <x-base.form-input
                    id="currency_code"
                    name="currency_code"
                    type="text"
                    class="w-full"
                    placeholder="e.g. USD, SAR"
                    value="{{ old('currency_code', $settings['currency.code'] ?? 'USD') }}"
                />
                <div class="text-sm text-slate-500 mt-1">
                    ISO currency code used for reports (e.g. USD, SAR).
                </div>
            </div>

            <!-- Currency Symbol -->
            <div class="col-span-12 md:col-span-4">
                <x-base.form-label for="currency_symbol">
                    Currency Symbol
                </x-base.form-label>
                <x-base.form-input
                    id="currency_symbol"
                    name="currency_symbol"
                    type="text"
                    class="w-full"
                    placeholder="$, SAR, د.إ"
                    value="{{ old('currency_symbol', $settings['currency.symbol'] ?? '$') }}"
                />
                <div class="text-sm text-slate-500 mt-1">
                    Symbol shown with amounts (e.g. $, SAR, د.إ).
                </div>
            </div>

            <!-- Currency Position -->
            <div class="col-span-12 md:col-span-4">
                <x-base.form-label for="currency_position">
                    Currency Position
                </x-base.form-label>
                <x-base.form-select
                    id="currency_position"
                    name="currency_position"
                    class="w-full"
                >
                    @php $currencyPosition = old('currency_position', $settings['currency.position'] ?? 'before'); @endphp
                    <option value="before" {{ $currencyPosition === 'before' ? 'selected' : '' }}>Before amount (e.g. $100)</option>
                    <option value="after" {{ $currencyPosition === 'after' ? 'selected' : '' }}>After amount (e.g. 100$)</option>
                </x-base.form-select>
                <div class="text-sm text-slate-500 mt-1">
                    Where to display the currency symbol relative to the amount.
                </div>
            </div>

            <!-- Enable Maintenance Mode -->
            <div class="col-span-12 md:col-span-6">
                <div class="flex items-center mt-2">
                    <div>
                        <div class="font-medium">Maintenance Mode</div>
                        <div class="text-sm text-slate-500">Enable maintenance mode to prevent user access.</div>
                    </div>
                    <div class="ml-auto">
                        <input type="hidden" name="maintenance_mode" value="0">
                        <input
                            type="checkbox"
                            name="maintenance_mode"
                            value="1"
                            {{ old('maintenance_mode', $settings['maintenance_mode'] ?? 0) ? 'checked' : '' }}
                            class="transition-all duration-100 ease-in-out shadow-sm border-slate-200 cursor-pointer focus:ring-4 focus:ring-offset-0 focus:ring-primary focus:ring-opacity-20 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&[type='radio']]:checked:bg-primary [&[type='radio']]:checked:border-primary [&[type='radio']]:checked:border-opacity-10 [&[type='checkbox']]:checked:bg-primary [&[type='checkbox']]:checked:border-primary [&[type='checkbox']]:checked:border-opacity-10 [&:disabled:not(:checked)]:bg-slate-100 [&:disabled:not(:checked)]:cursor-not-allowed [&:disabled:not(:checked)]:dark:bg-darkmode-800/50 [&:disabled:checked]:opacity-70 [&:disabled:checked]:cursor-not-allowed [&:disabled:checked]:dark:bg-darkmode-800/50 w-[38px] h-[24px] p-px rounded-full relative before:w-[20px] before:h-[20px] before:shadow-[1px_1px_3px_rgba(0,0,0,0.25)] before:transition-[margin-left] before:duration-200 before:ease-in-out before:absolute before:inset-y-0 before:my-auto before:rounded-full before:dark:bg-darkmode-600 checked:bg-primary checked:border-primary checked:bg-none before:checked:ml-[14px] before:checked:bg-white"
                        >
                    </div>
                </div>
            </div>

            <!-- Debug Mode -->
            <div class="col-span-12 md:col-span-6">
                <div class="flex items-center mt-2">
                    <div>
                        <div class="font-medium">Debug Mode</div>
                        <div class="text-sm text-slate-500">Show detailed error messages (only enable in development).</div>
                    </div>
                    <div class="ml-auto">
                        <input type="hidden" name="debug_mode" value="0">
                        <input
                            type="checkbox"
                            name="debug_mode"
                            value="1"
                            {{ old('debug_mode', $settings['app.debug'] ?? config('app.debug', false)) ? 'checked' : '' }}
                            class="transition-all duration-100 ease-in-out shadow-sm border-slate-200 cursor-pointer focus:ring-4 focus:ring-offset-0 focus:ring-primary focus:ring-opacity-20 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&[type='radio']]:checked:bg-primary [&[type='radio']]:checked:border-primary [&[type='radio']]:checked:border-opacity-10 [&[type='checkbox']]:checked:bg-primary [&[type='checkbox']]:checked:border-primary [&[type='checkbox']]:checked:border-opacity-10 [&:disabled:not(:checked)]:bg-slate-100 [&:disabled:not(:checked)]:cursor-not-allowed [&:disabled:not(:checked)]:dark:bg-darkmode-800/50 [&:disabled:checked]:opacity-70 [&:disabled:checked]:cursor-not-allowed [&:disabled:checked]:dark:bg-darkmode-800/50 w-[38px] h-[24px] p-px rounded-full relative before:w-[20px] before:h-[20px] before:shadow-[1px_1px_3px_rgba(0,0,0,0.25)] before:transition-[margin-left] before:duration-200 before:ease-in-out before:absolute before:inset-y-0 before:my-auto before:rounded-full before:dark:bg-darkmode-600 checked:bg-primary checked:border-primary checked:bg-none before:checked:ml-[14px] before:checked:bg-white"
                        >
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
                <x-base.lucide icon="Save" class="w-4 h-4 mr-2 animate-pulse" />
                Save
            </x-base.button>
        </div>
    </form>
</div>

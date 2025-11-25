<!-- General Settings Content Loaded -->
<div class="bg-white dark:bg-darkmode-600 rounded-lg shadow-sm border border-slate-200/60 dark:border-darkmode-400 mt-5">
    <div class="flex items-center border-b border-slate-200/60 p-5 dark:border-darkmode-400">
        <h2 class="mr-auto text-base font-medium flex items-center">
            <x-base.lucide icon="Settings" class="w-5 h-5 mr-2 text-gray-500" />
            General Settings
        </h2>
    </div>

    <form id="generalSettingsForm" action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" class="p-5">
        @csrf

        @php
            $appBrandLogoUrl = $appBrandLogoUrl ?? null;
        @endphp

        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 lg:col-span-8">
                <div class="grid grid-cols-12 gap-5">
                    <!-- App Name -->
                    <div class="col-span-12 sm:col-span-6 lg:col-span-4">
                        <x-base.form-label for="app_name" class="flex items-center justify-between">
                            <span>Application Name <span class="text-danger">*</span></span>
                            <span class="text-xs text-slate-500"></span>
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
                            Update this to match the brand name that should appear across the ERP.
                        </div>
                    </div>

                    <!-- Default Language -->
                    <div class="col-span-12 sm:col-span-6 lg:col-span-4">
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
                    <div class="col-span-12 sm:col-span-6 lg:col-span-4">
                        <x-base.form-label for="timezone">
                            Timezone
                        </x-base-form-label>
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
                    <div class="col-span-12 sm:col-span-6 lg:col-span-4">
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
                    <div class="col-span-12 sm:col-span-6 lg:col-span-4">
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
                    <div class="col-span-12 sm:col-span-6 lg:col-span-4">
                        <x-base.form-label for="currency_symbol">
                            Currency Symbol
                        </x-base-form-label>
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
                    <div class="col-span-12 sm:col-span-6 lg:col-span-4">
                        <x-base.form-label for="currency_position">
                            Currency Position
                        </x-base-form-label>
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

                    <!-- Maintenance Mode -->
                    <div class="col-span-12 sm:col-span-6 lg:col-span-4">
                        <div class="flex h-full items-center">
                            <div>
                                <div class="font-medium">Maintenance Mode</div>
                                <div class="text-sm text-slate-500">Temporarily restrict user access while you update the system.</div>
                            </div>
                            <div class="ml-auto">
                                <input type="hidden" name="maintenance_mode" value="0">
                                <label class="inline-flex cursor-pointer items-center">
                                    <input
                                        type="checkbox"
                                        name="maintenance_mode"
                                        value="1"
                                        {{ old('maintenance_mode', $settings['maintenance_mode'] ?? 0) ? 'checked' : '' }}
                                        class="sr-only peer"
                                    />
                                    <div class="relative h-6 w-11 rounded-full bg-slate-200 transition-colors duration-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/25 dark:bg-darkmode-600 peer-checked:bg-primary after:absolute after:top-0.5 after:start-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition-all after:duration-200 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full"></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Debug Mode -->
                    <div class="col-span-12 sm:col-span-6 lg:col-span-4">
                        <div class="flex h-full items-center">
                            <div>
                                <div class="font-medium">Debug Mode</div>
                                <div class="text-sm text-slate-500">Shows detailed error messages (recommended only on staging).</div>
                            </div>
                            <div class="ml-auto">
                                <input type="hidden" name="debug_mode" value="0">
                                <label class="inline-flex cursor-pointer items-center">
                                    <input
                                        type="checkbox"
                                        name="debug_mode"
                                        value="1"
                                        {{ old('debug_mode', $settings['app.debug'] ?? config('app.debug', false)) ? 'checked' : '' }}
                                        class="sr-only peer"
                                    />
                                    <div class="relative h-6 w-11 rounded-full bg-slate-200 transition-colors duration-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/25 dark:bg-darkmode-600 peer-checked:bg-primary after:absolute after:top-0.5 after:start-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition-all after:duration-200 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-12 lg:col-span-4 lg:col-start-9">
                <div class="rounded-2xl border border-dashed border-slate-200/80 bg-slate-50/70 px-6 py-7 shadow-sm transition hover:border-primary/60 dark:border-darkmode-400 dark:bg-darkmode-600/40">
                    <x-base.form-label for="app_logo" class="flex items-center justify-between">
                        <span>Application Logo</span>
                        <span class="text-xs font-medium text-slate-400">PNG, JPG, SVG • Max 4MB</span>
                    </x-base.form-label>

                    <div class="mt-4 flex flex-col items-center gap-4">
                        <div class="flex flex-col items-center">
                            <img
                                id="app-logo-preview"
                                data-initial-src="{{ $appBrandLogoUrl }}"
                                src="{{ $appBrandLogoUrl }}"
                                class="h-20 w-20 rounded-2xl object-cover shadow {{ $appBrandLogoUrl ? '' : 'hidden' }}"
                                alt="Application Logo Preview"
                            >
                            <div
                                id="app-logo-placeholder"
                                class="flex h-20 w-20 items-center justify-center rounded-2xl bg-white shadow-inner dark:bg-darkmode-500 {{ $appBrandLogoUrl ? 'hidden' : '' }}"
                            >
                                <x-base.lucide icon="Monitor" class="h-7 w-7 text-slate-400" />
                            </div>
                        </div>

                        <div class="text-center">
                            <p class="text-sm font-medium text-slate-700 dark:text-slate-200">Shown in sidebar & documents</p>
                            <p class="text-xs text-slate-500">Use a square transparent logo (≥ 256×256).</p>
                        </div>

                        <div class="flex w-full flex-col gap-2">
                            <label
                                for="app_logo"
                                class="inline-flex w-full items-center justify-center rounded-lg border border-primary/20 bg-primary/10 px-4 py-2 text-sm font-semibold text-primary transition hover:bg-primary/20"
                            >
                                <x-base.lucide icon="UploadCloud" class="mr-2 h-4 w-4" />
                                Choose Logo
                            </label>
                            <button
                                type="button"
                                id="app-logo-reset"
                                class="inline-flex w-full items-center justify-center rounded-lg border border-slate-200 px-4 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 dark:border-darkmode-400 dark:text-slate-300"
                            >
                                <x-base.lucide icon="RotateCcw" class="mr-2 h-4 w-4" />
                                Reset Logo
                            </button>
                        </div>

                        <input type="hidden" name="reset_app_logo" id="reset_app_logo" value="0">
                        <input id="app_logo" name="app_logo" type="file" class="sr-only" accept="image/*" />
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5 flex justify-end">
            <button type="submit" class="btn-royal btn-royal--gold btn-royal--sm w-32">
                <x-base.lucide icon="save" class="w-4 h-4 mr-2" />
                Save
            </button>
        </div>
    </form>
</div>

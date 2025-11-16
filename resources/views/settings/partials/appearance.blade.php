<div class="bg-white dark:bg-darkmode-600 rounded-lg shadow-sm border border-slate-200/60 dark:border-darkmode-400 mt-5 intro-y">
    <div class="flex items-center border-b border-slate-200/60 p-5 dark:border-darkmode-400">
        <h2 class="mr-auto text-base font-medium flex items-center">
            <x-base.lucide icon="Palette" class="w-5 h-5 mr-2 text-gray-500" />
            Appearance & Theme
        </h2>
    </div>

    <form
        id="appearance-settings-form"
        action="{{ route('settings.appearance.update') }}"
        method="POST"
        class="p-5"
    >
        @csrf

        <div class="grid grid-cols-12 gap-6">
            <!-- Dark Mode -->
            <div class="col-span-12 md:col-span-6">
                <div class="flex items-center mt-2">
                    <div>
                        <div class="font-medium">Dark Mode</div>
                        <div class="text-xs text-slate-500">Toggle dark mode for the application UI.</div>
                    </div>
                    <div class="ml-auto">
                        <input type="hidden" name="dark_mode" value="0">
                        <input
                            type="checkbox"
                            name="dark_mode"
                            value="1"
                            id="appearance-dark-mode-toggle"
                            {{ setting('dark_mode', false) ? 'checked' : '' }}
                            class="transition-all duration-100 ease-in-out shadow-sm border-slate-200 cursor-pointer focus:ring-4 focus:ring-offset-0 focus:ring-primary focus:ring-opacity-20 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&[type='radio']]:checked:bg-primary [&[type='radio']]:checked:border-primary [&[type='radio']]:checked:border-opacity-10 [&[type='checkbox']]:checked:bg-primary [&[type='checkbox']]:checked:border-primary [&[type='checkbox']]:checked:border-opacity-10 [&:disabled:not(:checked)]:bg-slate-100 [&:disabled:not(:checked)]:cursor-not-allowed [&:disabled:not(:checked)]:dark:bg-darkmode-800/50 [&:disabled:checked]:opacity-70 [&:disabled:checked]:cursor-not-allowed [&:disabled:checked]:dark:bg-darkmode-800/50 w-[38px] h-[24px] p-px rounded-full relative before:w-[20px] before:h-[20px] before:shadow-[1px_1px_3px_rgba(0,0,0,0.25)] before:transition-[margin-left] before:duration-200 before:ease-in-out before:absolute before:inset-y-0 before:my-auto before:rounded-full before:dark:bg-darkmode-600 checked:bg-primary checked:border-primary checked:bg-none before:checked:ml-[14px] before:checked:bg-white"
                        >
                    </div>
                </div>
            </div>

            <!-- Animations -->
            <div class="col-span-12 md:col-span-6">
                <div class="flex items-center mt-2">
                    <div>
                        <div class="font-medium">Animations</div>
                        <div class="text-xs text-slate-500">Enable or disable UI animations.</div>
                    </div>
                    <div class="ml-auto">
                        <input type="hidden" name="animations_enabled" value="0">
                        <input
                            type="checkbox"
                            name="animations_enabled"
                            value="1"
                            id="appearance-animations-toggle"
                            {{ setting('animations_enabled', true) ? 'checked' : '' }}
                            class="transition-all duration-100 ease-in-out shadow-sm border-slate-200 cursor-pointer focus:ring-4 focus:ring-offset-0 focus:ring-primary focus:ring-opacity-20 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&[type='radio']]:checked:bg-primary [&[type='radio']]:checked:border-primary [&[type='radio']]:checked:border-opacity-10 [&[type='checkbox']]:checked:bg-primary [&[type='checkbox']]:checked:border-primary [&[type='checkbox']]:checked:border-opacity-10 [&:disabled:not(:checked)]:bg-slate-100 [&:disabled:not(:checked)]:cursor-not-allowed [&:disabled:not(:checked)]:dark:bg-darkmode-800/50 [&:disabled:checked]:opacity-70 [&:disabled:checked]:cursor-not-allowed [&:disabled:checked]:dark:bg-darkmode-800/50 w-[38px] h-[24px] p-px rounded-full relative before:w-[20px] before:h-[20px] before:shadow-[1px_1px_3px_rgba(0,0,0,0.25)] before:transition-[margin-left] before:duration-200 before:ease-in-out before:absolute before:inset-y-0 before:my-auto before:rounded-full before:dark:bg-darkmode-600 checked:bg-primary checked:border-primary checked:bg-none before:checked:ml-[14px] before:checked:bg-white"
                        >
                    </div>
                </div>
            </div>

            <!-- Primary Color -->
            <div class="col-span-12 md:col-span-4">
                <x-base.form-label>Primary Color</x-base.form-label>
                <div class="flex items-center gap-2 mt-2">
                    <input
                        type="color"
                        name="primary_color_swatch"
                        class="w-12 h-9 rounded-md border border-slate-200 dark:border-darkmode-400"
                        value="{{ primary_color() }}"
                    >
                    <x-base.form-input
                        type="text"
                        name="primary_color"
                        class="w-full"
                        value="{{ primary_color() }}"
                    />
                </div>
            </div>

            <!-- Secondary Color -->
            <div class="col-span-12 md:col-span-4">
                <x-base.form-label>Secondary Color</x-base.form-label>
                <div class="flex items-center gap-2 mt-2">
                    <input
                        type="color"
                        name="secondary_color_swatch"
                        class="w-12 h-9 rounded-md border border-slate-200 dark:border-darkmode-400"
                        value="{{ secondary_color() }}"
                    >
                    <x-base.form-input
                        type="text"
                        name="secondary_color"
                        class="w-full"
                        value="{{ secondary_color() }}"
                    />
                </div>
            </div>

            <!-- Accent Color -->
            <div class="col-span-12 md:col-span-4">
                <x-base.form-label>Accent Color</x-base.form-label>
                <div class="flex items-center gap-2 mt-2">
                    <input
                        type="color"
                        name="accent_color_swatch"
                        class="w-12 h-9 rounded-md border border-slate-200 dark:border-darkmode-400"
                        value="{{ accent_color() }}"
                    >
                    <x-base.form-input
                        type="text"
                        name="accent_color"
                        class="w-full"
                        value="{{ accent_color() }}"
                    />
                </div>
            </div>

            <!-- Font Size -->
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label>Font Size</x-base.form-label>
                @php $fontSize = setting('font_size', 'medium'); @endphp
                <x-base.form-select name="font_size" class="w-full mt-2"> 
                    <option value="small" {{ $fontSize === 'small' ? 'selected' : '' }}>Small</option>
                    <option value="medium" {{ $fontSize === 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="large" {{ $fontSize === 'large' ? 'selected' : '' }}>Large</option>
                    <option value="extra-large" {{ $fontSize === 'extra-large' ? 'selected' : '' }}>Extra Large</option>
                </x-base.form-select>
            </div>
        </div>

        <div class="mt-5 flex items-center justify-between">
            <x-base.button type="submit" variant="primary" class="w-40">
                <x-base.lucide icon="Save" class="w-4 h-4 mr-2 animate-pulse" />
                Save Appearance
            </x-base.button>

            <x-base.button
                type="button"
                variant="secondary"
                class="text-xs"
                onclick="event.preventDefault(); if (confirm('Reset theme colors to default values?')) window.resetThemeSettings && window.resetThemeSettings();"
            >
                Reset Theme Colors
            </x-base.button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        function bindColorPair(swatchName, textName) {
            const swatch = document.querySelector(`input[name="${swatchName}"]`);
            const text   = document.querySelector(`input[name="${textName}"]`);

            if (!swatch || !text) return;

            // From color picker to text input
            swatch.addEventListener('input', function () {
                text.value = this.value;
            });

            // From text input to color picker (when valid hex)
            text.addEventListener('input', function () {
                const val = this.value.trim();
                if (/^#[0-9A-F]{6}$/i.test(val)) {
                    swatch.value = val;
                }
            });
        }

        bindColorPair('primary_color_swatch',   'primary_color');
        bindColorPair('secondary_color_swatch', 'secondary_color');
        bindColorPair('accent_color_swatch',    'accent_color');
    });
</script>

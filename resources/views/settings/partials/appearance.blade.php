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

        @php
            $palettes = config('theme.palettes', []);
            $activePalette = setting('theme_palette', config('theme.default_palette'));
        @endphp

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
                        <label class="inline-flex cursor-pointer items-center">
                            <input
                                type="checkbox"
                                name="dark_mode"
                                value="1"
                                id="appearance-dark-mode-toggle"
                                {{ setting('dark_mode', false) ? 'checked' : '' }}
                                class="sr-only peer"
                            />
                            <div class="relative w-11 h-6 rounded-full bg-slate-200 transition-colors duration-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/25 dark:bg-darkmode-600 peer-checked:bg-primary after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition-all after:duration-200 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full"></div>
                        </label>
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
                        <label class="inline-flex cursor-pointer items-center">
                            <input
                                type="checkbox"
                                name="animations_enabled"
                                value="1"
                                id="appearance-animations-toggle"
                                {{ setting('animations_enabled', true) ? 'checked' : '' }}
                                class="sr-only peer"
                            />
                            <div class="relative w-11 h-6 rounded-full bg-slate-200 transition-colors duration-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/25 dark:bg-darkmode-600 peer-checked:bg-primary after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition-all after:duration-200 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full"></div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Theme palettes -->
            <div class="col-span-12">
                <x-base.form-label>Accent Colors</x-base.form-label>
                <p class="text-xs text-slate-500 mb-3">Choose a curated palette to keep the UI consistent.</p>
                <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                    @foreach($palettes as $key => $palette)
                        @php
                            $isActive = $activePalette === $key;
                            $gradient = "linear-gradient(120deg, {$palette['primary']} 0%, {$palette['secondary']} 50%, {$palette['accent']} 100%)";
                        @endphp
                        <label
                            class="relative flex cursor-pointer flex-col rounded-2xl border border-slate-200/80 bg-slate-50 p-4 transition hover:border-primary/60 hover:shadow-lg dark:border-darkmode-500 dark:bg-darkmode-600"
                            data-palette-card
                        >
                            <input
                                type="radio"
                                name="theme_palette"
                                value="{{ $key }}"
                                class="sr-only"
                                data-palette-input
                                {{ $isActive ? 'checked' : '' }}
                            >
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-semibold text-slate-700 dark:text-slate-100">{{ $palette['label'] }}</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">{{ $palette['description'] }}</p>
                                </div>
                                <div class="rounded-xl border border-white/70 shadow-inner" style="background-image: {{ $gradient }}; width: 72px; height: 32px"></div>
                            </div>
                            <div class="mt-4 flex gap-2">
                                <span class="flex-1 rounded-lg border border-white/60 bg-white/80 py-1 text-center text-[11px] font-semibold text-slate-600 dark:text-slate-200" style="color: {{ $palette['primary'] }}">
                                    {{ $palette['primary'] }}
                                </span>
                                <span class="flex-1 rounded-lg border border-white/60 bg-white/80 py-1 text-center text-[11px] font-semibold text-slate-600 dark:text-slate-200" style="color: {{ $palette['secondary'] }}">
                                    {{ $palette['secondary'] }}
                                </span>
                                <span class="flex-1 rounded-lg border border-white/60 bg-white/80 py-1 text-center text-[11px] font-semibold text-slate-600 dark:text-slate-200" style="color: {{ $palette['accent'] }}">
                                    {{ $palette['accent'] }}
                                </span>
                            </div>
                            <span class="pointer-events-none absolute right-4 top-4 rounded-full border border-primary/20 bg-white/80 p-1 text-primary opacity-0 scale-90 transition" data-palette-check>
                                <x-base.lucide icon="Check" class="h-4 w-4" />
                            </span>
                        </label>
                    @endforeach
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
            <button type="submit" class="btn-royal btn-royal--gold btn-royal--sm w-40">
                <x-base.lucide icon="save" class="w-4 h-4 mr-2" />
                Save Appearance
            </button>

            <button type="button" class="btn-royal btn-royal--outline btn-royal--sm" onclick="event.preventDefault(); if (confirm('Reset theme colors to default values?')) window.resetThemeSettings && window.resetThemeSettings();">
                Reset Theme
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const paletteInputs = document.querySelectorAll('[data-palette-input]');
        const paletteCards = document.querySelectorAll('[data-palette-card]');

        function updatePaletteState() {
            paletteCards.forEach(card => {
                const input = card.querySelector('[data-palette-input]');
                const check = card.querySelector('[data-palette-check]');
                const isActive = input?.checked;

                card.classList.toggle('ring-2', !!isActive);
                card.classList.toggle('ring-primary/60', !!isActive);
                card.classList.toggle('bg-slate-100/80', !!isActive);
                card.classList.toggle('dark:bg-darkmode-500/80', !!isActive);
                if (check) {
                    check.classList.toggle('opacity-100', !!isActive);
                    check.classList.toggle('opacity-0', !isActive);
                    check.classList.toggle('scale-100', !!isActive);
                    check.classList.toggle('scale-90', !isActive);
                }
            });
        }

        paletteInputs.forEach(input => {
            input.addEventListener('change', () => {
                paletteInputs.forEach(other => {
                    if (other !== input) {
                        other.checked = false;
                    }
                });
                input.checked = true;
                updatePaletteState();
            });
        });

        updatePaletteState();
    });
</script>

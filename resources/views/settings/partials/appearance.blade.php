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

        <div class="mt-5 flex items-center justify-end">
            <button type="submit" class="btn-royal btn-royal--gold btn-royal--sm w-40">
                <x-base.lucide icon="save" class="w-4 h-4 mr-2" />
                Save Appearance
            </button>
        </div>
    </form>
</div>

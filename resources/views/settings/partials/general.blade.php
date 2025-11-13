<!-- General Settings Content Loaded -->
<div class="intro-y box mt-5">
    <div class="flex items-center border-b border-slate-200/60 p-5 dark:border-darkmode-400">
        <h2 class="mr-auto text-base font-medium">General Settings</h2>
    </div>
    <div class="p-5">
        <form method="POST" action="{{ route('settings.update') }}" id="generalSettingsForm">
            @csrf
            
            <div class="grid grid-cols-12 gap-6">
                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="unified_code">
                        Unified Code
                    </x-base.form-label>
                    <x-base.form-input
                        id="unified_code"
                        name="unified_code"
                        type="text"
                        class="w-full"
                        placeholder="Enter unified code"
                        value="{{ old('unified_code', $unified_code) }}"
                        required
                    />
                    <div class="mt-2 text-xs text-slate-500">
                        The unified code for the system
                    </div>
                </div>
            </div>

            <div class="mt-5 flex justify-end">
                <x-base.button
                    type="submit"
                    variant="primary"
                    class="w-24"
                >
                    Save
                </x-base.button>
            </div>
        </form>
    </div>
</div>

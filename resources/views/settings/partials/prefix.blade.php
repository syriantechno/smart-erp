<!-- Prefix Settings Content Loaded -->
<div class="bg-white dark:bg-darkmode-600 rounded-lg shadow-sm border border-slate-200/60 dark:border-darkmode-400 mt-5">
    <div class="flex items-center border-b border-slate-200/60 p-5 dark:border-darkmode-400">
        <h2 class="mr-auto text-base font-medium flex items-center">
            <x-base.lucide icon="Hash" class="w-5 h-5 mr-2 text-purple-500" />
            Prefix Settings
        </h2>
        <x-base.button type="submit" form="prefixForm" variant="primary">
            <x-base.lucide icon="Save" class="w-4 h-4 mr-2" />
            Save Changes
        </x-base.button>
    </div>

    <form id="prefixForm" action="{{ route('settings.prefix.update') }}" method="POST" class="p-5">
        @csrf
            
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b dark:border-darkmode-400">
                                <th class="px-2 py-3 font-medium">Document Type</th>
                                <th class="px-2 py-3 font-medium">Prefix</th>
                                <th class="px-2 py-3 font-medium">Padding</th>
                                <th class="px-2 py-3 font-medium">Start Number</th>
                                <th class="px-2 py-3 font-medium">Include Year</th>
                                <th class="px-2 py-3 font-medium">Preview</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($prefixSettings as $setting)
                            <tr class="border-b dark:border-darkmode-400">
                                <td class="px-2 py-3">
                                    <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $setting->document_type)) }}</span>
                                </td>
                                <td class="px-2 py-3">
                                    <x-base.form-input
                                        name="prefixes[{{ $setting->id }}][prefix]"
                                        type="text"
                                        class="w-24 prefix-input"
                                        value="{{ $setting->prefix }}"
                                        data-id="{{ $setting->id }}"
                                        required
                                    />
                                </td>
                                <td class="px-2 py-3">
                                    <x-base.form-input
                                        name="prefixes[{{ $setting->id }}][padding]"
                                        type="number"
                                        class="w-20 padding-input"
                                        value="{{ $setting->padding }}"
                                        min="1"
                                        max="10"
                                        data-id="{{ $setting->id }}"
                                        required
                                    />
                                </td>
                                <td class="px-2 py-3">
                                    <x-base.form-input
                                        name="prefixes[{{ $setting->id }}][start_number]"
                                        type="number"
                                        class="w-24 start-number-input"
                                        value="{{ $setting->start_number }}"
                                        min="1"
                                        data-id="{{ $setting->id }}"
                                        required
                                    />
                                </td>
                                <td class="px-2 py-3 text-center">
                                    <input
                                        name="prefixes[{{ $setting->id }}][include_year]"
                                        type="checkbox"
                                        class="include-year-input form-check-input"
                                        value="1"
                                        data-id="{{ $setting->id }}"
                                        {{ $setting->include_year ? 'checked' : '' }}
                                    />
                                </td>
                                <td class="px-2 py-3">
                                    <span class="preview-code font-mono text-sm font-medium text-primary" id="preview-{{ $setting->id }}">
                                        {{ $setting->previewCode() }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-5 flex justify-end">
            <x-base.button
                type="submit"
                variant="primary"
                class="w-32"
            >
                Save Prefixes
            </x-base.button>
        </div>
    </form>
</div>

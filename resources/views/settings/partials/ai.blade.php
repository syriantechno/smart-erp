<div class="bg-white dark:bg-darkmode-600 rounded-lg shadow-sm border border-slate-200/60 dark:border-darkmode-400 mt-5">
    <div class="flex items-center border-b border-slate-200/60 p-5 dark:border-darkmode-400">
        <h2 class="mr-auto text-base font-medium flex items-center gap-2">
            <x-base.lucide icon="Bot" class="w-5 h-5" />
            AI Settings
        </h2>
        <div class="flex items-center gap-2">
            <x-base.button type="button" id="ai-test-connection-btn" variant="outline-secondary">
                <x-base.lucide icon="Activity" class="w-4 h-4 mr-2" />
                Test AI Connection
            </x-base.button>
            <x-base.button type="submit" form="ai-settings-form" variant="primary">
                <x-base.lucide icon="Save" class="w-4 h-4 mr-2" />
                Save AI Settings
            </x-base.button>
        </div>
    </div>

    <form id="ai-settings-form" class="p-5">
        @csrf

        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 lg:col-span-6">
                <x-base.form-label for="ai_provider">AI Provider</x-base.form-label>
                <x-base.form-select id="ai_provider" name="provider" class="w-full">
                    @php
                        $currentProvider = $settings['ai.provider'] ?? config('ai.provider', 'openai');
                    @endphp
                    <option value="openai" {{ $currentProvider === 'openai' ? 'selected' : '' }}>External (OpenAI)</option>
                    <option value="ollama" {{ $currentProvider === 'ollama' ? 'selected' : '' }}>Local (Ollama)</option>
                </x-base.form-select>
                <div class="mt-2 text-xs text-slate-500">
                    Choose whether to use OpenAI cloud API or a local Ollama server.
                </div>
            </div>

            <!-- OpenAI Settings -->
            <div class="col-span-12" id="openai-settings">
                <div class="border rounded-md p-4 bg-slate-50 dark:bg-darkmode-700/50">
                    <h3 class="font-medium mb-3 flex items-center gap-2">
                        <x-base.lucide icon="Cloud" class="w-4 h-4" />
                        OpenAI Settings
                    </h3>
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12 lg:col-span-6">
                            <x-base.form-label for="openai_api_key">API Key</x-base.form-label>
                            <x-base.form-input
                                id="openai_api_key"
                                name="openai_api_key"
                                type="password"
                                class="w-full"
                                placeholder="sk-..."
                                value="{{ $settings['ai.api_key'] ?? '' }}"
                            />
                        </div>
                        <div class="col-span-12 lg:col-span-6">
                            <x-base.form-label for="openai_model">Model</x-base.form-label>
                            <x-base.form-input
                                id="openai_model"
                                name="openai_model"
                                type="text"
                                class="w-full"
                                placeholder="gpt-3.5-turbo"
                                value="{{ $settings['ai.model'] ?? config('ai.model', 'gpt-3.5-turbo') }}"
                            />
                        </div>
                        <div class="col-span-12 lg:col-span-6">
                            <x-base.form-label for="openai_max_tokens">Max Tokens</x-base.form-label>
                            <x-base.form-input
                                id="openai_max_tokens"
                                name="openai_max_tokens"
                                type="number"
                                min="1"
                                class="w-full"
                                value="{{ $settings['ai.max_tokens'] ?? config('ai.max_tokens', 2000) }}"
                            />
                        </div>
                        <div class="col-span-12 lg:col-span-6">
                            <x-base.form-label for="openai_temperature">Temperature</x-base.form-label>
                            <x-base.form-input
                                id="openai_temperature"
                                name="openai_temperature"
                                type="number"
                                step="0.1"
                                min="0"
                                max="2"
                                class="w-full"
                                value="{{ $settings['ai.temperature'] ?? config('ai.temperature', 0.7) }}"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ollama Settings -->
            <div class="col-span-12" id="ollama-settings">
                <div class="border rounded-md p-4 bg-slate-50 dark:bg-darkmode-700/50">
                    <h3 class="font-medium mb-3 flex items-center gap-2">
                        <x-base.lucide icon="Server" class="w-4 h-4" />
                        Ollama Settings (Local)
                    </h3>
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12 lg:col-span-8">
                            <x-base.form-label for="ollama_base_url">Base URL</x-base.form-label>
                            <x-base.form-input
                                id="ollama_base_url"
                                name="ollama_base_url"
                                type="text"
                                class="w-full"
                                placeholder="http://127.0.0.1:11434"
                                value="{{ $settings['ai.ollama_base_url'] ?? config('ai.ollama_base_url', 'http://127.0.0.1:11434') }}"
                            />
                        </div>
                        <div class="col-span-12 lg:col-span-4">
                            <x-base.form-label for="ollama_model">Model</x-base.form-label>
                            <x-base.form-input
                                id="ollama_model"
                                name="ollama_model"
                                type="text"
                                class="w-full"
                                placeholder="llama3"
                                value="{{ $settings['ai.ollama_model'] ?? config('ai.ollama_model', 'llama3') }}"
                            />
                        </div>
                    </div>
                    <div class="mt-2 text-xs text-slate-500">
                        Make sure the Ollama server is running locally and the model is pulled.
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

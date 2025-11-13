<!-- Appearance Settings Content Loaded -->
@pushonce('styles')
<style>
/* الوضع المظلم */
.dark .form-select,
.dark .form-control {
    background-color: #374151;
    border-color: #4b5563;
    color: white;
}

.dark .btn-outline-secondary {
    background-color: #374151;
    color: #d1d5db;
    border-color: #4b5563;
}

.dark .btn-outline-secondary:hover {
    background-color: #4b5563;
    border-color: #6b7280;
}
</style>
@endpushonce

<div class="intro-y box mt-5">
    <div class="p-5">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-medium text-slate-800 dark:text-slate-200">Theme & Color Settings</h2>
            <div class="text-xs text-slate-500 dark:text-slate-400">
                Customize your interface appearance and colors
            </div>
        </div>

        <form action="{{ route('settings.appearance.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Dark Mode Toggle -->
            <div class="bg-slate-50 dark:bg-darkmode-800 p-4 rounded-lg border border-slate-200 dark:border-darkmode-400">
                <div class="flex items-center justify-between">
                    <div>
                        <label class="text-sm font-medium text-slate-800 dark:text-slate-200 mb-1 block">
                            Dark Mode
                        </label>
                        <p class="text-xs text-slate-600 dark:text-slate-400">
                            Toggle between light and dark themes
                        </p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox"
                               name="dark_mode"
                               value="1"
                               {{ old('dark_mode', setting('dark_mode', false)) ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-darkmode-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-darkmode-600 peer-checked:bg-blue-600"></div>
                    </label>
                </div>
            </div>

            <!-- Color Settings -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Primary Color -->
                <div class="bg-slate-50 dark:bg-darkmode-800 p-4 rounded-lg border border-slate-200 dark:border-darkmode-400">
                    <label class="block text-sm font-medium text-slate-800 dark:text-slate-200 mb-3">
                        Primary Color
                    </label>
                    <div class="space-y-3">
                        <div class="flex items-center space-x-3">
                            <input type="color"
                                   name="primary_color"
                                   value="{{ old('primary_color', setting('primary_color', '#1e40af')) }}"
                                   class="w-12 h-12 border border-slate-300 dark:border-darkmode-400 rounded-lg cursor-pointer">
                            <input type="text"
                                   name="primary_color_hex"
                                   value="{{ old('primary_color_hex', setting('primary_color', '#1e40af')) }}"
                                   class="flex-1 px-3 py-2 border border-slate-300 dark:border-darkmode-400 rounded-lg bg-white dark:bg-darkmode-700 text-slate-800 dark:text-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <p class="text-xs text-slate-600 dark:text-slate-400">
                            Used for buttons, links, and primary elements
                        </p>
                    </div>
                </div>

                <!-- Secondary Color -->
                <div class="bg-slate-50 dark:bg-darkmode-800 p-4 rounded-lg border border-slate-200 dark:border-darkmode-400">
                    <label class="block text-sm font-medium text-slate-800 dark:text-slate-200 mb-3">
                        Secondary Color
                    </label>
                    <div class="space-y-3">
                        <div class="flex items-center space-x-3">
                            <input type="color"
                                   name="secondary_color"
                                   value="{{ old('secondary_color', setting('secondary_color', '#7c3aed')) }}"
                                   class="w-12 h-12 border border-slate-300 dark:border-darkmode-400 rounded-lg cursor-pointer">
                            <input type="text"
                                   name="secondary_color_hex"
                                   value="{{ old('secondary_color_hex', setting('secondary_color', '#7c3aed')) }}"
                                   class="flex-1 px-3 py-2 border border-slate-300 dark:border-darkmode-400 rounded-lg bg-white dark:bg-darkmode-700 text-slate-800 dark:text-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <p class="text-xs text-slate-600 dark:text-slate-400">
                            Used for secondary elements and accents
                        </p>
                    </div>
                </div>

                <!-- Accent Color -->
                <div class="bg-slate-50 dark:bg-darkmode-800 p-4 rounded-lg border border-slate-200 dark:border-darkmode-400">
                    <label class="block text-sm font-medium text-slate-800 dark:text-slate-200 mb-3">
                        Accent Color
                    </label>
                    <div class="space-y-3">
                        <div class="flex items-center space-x-3">
                            <input type="color"
                                   name="accent_color"
                                   value="{{ old('accent_color', setting('accent_color', '#06b6d4')) }}"
                                   class="w-12 h-12 border border-slate-300 dark:border-darkmode-400 rounded-lg cursor-pointer">
                            <input type="text"
                                   name="accent_color_hex"
                                   value="{{ old('accent_color_hex', setting('accent_color', '#06b6d4')) }}"
                                   class="flex-1 px-3 py-2 border border-slate-300 dark:border-darkmode-400 rounded-lg bg-white dark:bg-darkmode-700 text-slate-800 dark:text-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <p class="text-xs text-slate-600 dark:text-slate-400">
                            Used for highlights and interactive elements
                        </p>
                    </div>
                </div>
            </div>

            <!-- Font Size -->
            <div class="bg-slate-50 dark:bg-darkmode-800 p-4 rounded-lg border border-slate-200 dark:border-darkmode-400">
                <label class="block text-sm font-medium text-slate-800 dark:text-slate-200 mb-3">
                    Font Size
                </label>
                <select name="font_size" class="w-full px-3 py-2 border border-slate-300 dark:border-darkmode-400 rounded-lg bg-white dark:bg-darkmode-700 text-slate-800 dark:text-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="small" {{ setting('font_size', 'medium') == 'small' ? 'selected' : '' }}>Small</option>
                    <option value="medium" {{ setting('font_size', 'medium') == 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="large" {{ setting('font_size', 'medium') == 'large' ? 'selected' : '' }}>Large</option>
                    <option value="extra-large" {{ setting('font_size', 'medium') == 'extra-large' ? 'selected' : '' }}>Extra Large</option>
                </select>
                <p class="text-xs text-slate-600 dark:text-slate-400 mt-2">
                    Choose your preferred text size for better readability
                </p>
            </div>

            <!-- Additional Settings -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Sidebar Collapsed -->
                <div class="bg-slate-50 dark:bg-darkmode-800 p-4 rounded-lg border border-slate-200 dark:border-darkmode-400">
                    <div class="flex items-center justify-between">
                        <div>
                            <label class="text-sm font-medium text-slate-800 dark:text-slate-200 mb-1 block">
                                Collapsed Sidebar
                            </label>
                            <p class="text-xs text-slate-600 dark:text-slate-400">
                                Minimize sidebar for more content space
                            </p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox"
                                   name="sidebar_collapsed"
                                   value="1"
                                   {{ old('sidebar_collapsed', setting('sidebar_collapsed', false)) ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-darkmode-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-darkmode-600 peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                </div>

                <!-- Animations Enabled -->
                <div class="bg-slate-50 dark:bg-darkmode-800 p-4 rounded-lg border border-slate-200 dark:border-darkmode-400">
                    <div class="flex items-center justify-between">
                        <div>
                            <label class="text-sm font-medium text-slate-800 dark:text-slate-200 mb-1 block">
                                Enable Animations
                            </label>
                            <p class="text-xs text-slate-600 dark:text-slate-400">
                                Smooth transitions and animations
                            </p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox"
                                   name="animations_enabled"
                                   value="1"
                                   {{ old('animations_enabled', setting('animations_enabled', true)) ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-darkmode-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-darkmode-600 peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Color Preview -->
            <div class="bg-slate-50 dark:bg-darkmode-800 p-4 rounded-lg border border-slate-200 dark:border-darkmode-400">
                <label class="block text-sm font-medium text-slate-800 dark:text-slate-200 mb-4">
                    Color Preview
                </label>
                <div class="grid grid-cols-3 gap-4">
                    <div class="text-center">
                        <div class="w-full h-16 rounded-lg border-4 border-slate-200 dark:border-darkmode-400 mb-3" id="preview-primary"></div>
                        <span class="text-xs font-medium text-slate-600 dark:text-slate-400">Primary Color</span>
                    </div>
                    <div class="text-center">
                        <div class="w-full h-16 rounded-lg border-4 border-slate-200 dark:border-darkmode-400 mb-3" id="preview-secondary"></div>
                        <span class="text-xs font-medium text-slate-600 dark:text-slate-400">Secondary Color</span>
                    </div>
                    <div class="text-center">
                        <div class="w-full h-16 rounded-lg border-4 border-slate-200 dark:border-darkmode-400 mb-3" id="preview-accent"></div>
                        <span class="text-xs font-medium text-slate-600 dark:text-slate-400">Accent Color</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between pt-6 border-t border-slate-200 dark:border-darkmode-400">
                <button type="button"
                        onclick="resetToDefaults()"
                        class="px-4 py-2 text-sm font-medium text-slate-600 dark:text-slate-400 bg-slate-100 dark:bg-darkmode-600 hover:bg-slate-200 dark:hover:bg-darkmode-500 rounded-lg transition-colors duration-200 flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    <span>Reset to Defaults</span>
                </button>

                <div class="flex space-x-3">
                    <button type="button"
                            onclick="previewChanges()"
                            class="px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 bg-white dark:bg-darkmode-700 border border-slate-300 dark:border-darkmode-400 hover:bg-slate-50 dark:hover:bg-darkmode-600 rounded-lg transition-colors duration-200">
                        Preview Changes
                    </button>
                    <button type="submit"
                            class="px-6 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Save Changes</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@pushonce('scripts')
<script>
function resetToDefaults() {
    // إعادة تعيين القيم الافتراضية
    document.querySelector('input[name="primary_color"]').value = '#1e40af';
    document.querySelector('input[name="primary_color_hex"]').value = '#1e40af';
    document.querySelector('input[name="secondary_color"]').value = '#7c3aed';
    document.querySelector('input[name="secondary_color_hex"]').value = '#7c3aed';
    document.querySelector('input[name="accent_color"]').value = '#06b6d4';
    document.querySelector('input[name="accent_color_hex"]').value = '#06b6d4';
    document.querySelector('select[name="font_size"]').value = 'medium';
    document.querySelector('input[name="dark_mode"]').checked = false;
    document.querySelector('input[name="sidebar_collapsed"]').checked = false;
    document.querySelector('input[name="animations_enabled"]').checked = true;

    // تحديث المعاينة
    updatePreview();
}

function updatePreview() {
    const primaryColor = document.querySelector('input[name="primary_color"]')?.value || '#1e40af';
    const secondaryColor = document.querySelector('input[name="secondary_color"]')?.value || '#7c3aed';
    const accentColor = document.querySelector('input[name="accent_color"]')?.value || '#06b6d4';

    const primaryPreviews = document.querySelectorAll('#preview-primary');
    const secondaryPreviews = document.querySelectorAll('#preview-secondary');
    const accentPreviews = document.querySelectorAll('#preview-accent');

    primaryPreviews.forEach(el => el.style.backgroundColor = primaryColor);
    secondaryPreviews.forEach(el => el.style.backgroundColor = secondaryColor);
    accentPreviews.forEach(el => el.style.backgroundColor = accentColor);
}

// تحديث المعاينة عند تغيير الألوان
document.addEventListener('input', function(e) {
    if (e.target.type === 'color') {
        const hexInput = e.target.name + '_hex';
        const hexElement = document.querySelector(`input[name="${hexInput}"]`);
        if (hexElement) {
            hexElement.value = e.target.value;
        }
        updatePreview();
    }
});

// تحديث color picker عند كتابة hex
document.addEventListener('input', function(e) {
    if (e.target.name && e.target.name.endsWith('_hex')) {
        const colorInput = e.target.name.replace('_hex', '');
        const colorElement = document.querySelector(`input[name="${colorInput}"]`);
        if (colorElement) {
            colorElement.value = e.target.value;
        }
        updatePreview();
    }
});

// تفعيل/إلغاء تفعيل الوضع المظلم
document.addEventListener('change', function(e) {
    if (e.target.name === 'dark_mode') {
        const body = document.body;
        if (e.target.checked) {
            body.classList.add('dark');
        } else {
            body.classList.remove('dark');
        }
    }
});

// تهيئة المعاينة عند تحميل الصفحة
document.addEventListener('DOMContentLoaded', function() {
    updatePreview();

    // تطبيق الوضع المظلم الحالي
    const darkModeCheckbox = document.querySelector('input[name="dark_mode"]');
    if (darkModeCheckbox && darkModeCheckbox.checked) {
        document.body.classList.add('dark');
    }
});
</script>
@endpushonce

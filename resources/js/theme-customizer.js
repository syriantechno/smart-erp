/**
 * Theme Customizer - إدارة إعدادات المظهر والألوان
 */

(function () {
    "use strict";

    // إعدادات الثيم الافتراضية
    const defaultSettings = {
        darkMode: false,
        primaryColor: '#1e40af',
        secondaryColor: '#7c3aed',
        accentColor: '#06b6d4',
        theme: 'icewall',
        layout: 'side-menu',
        fontSize: 'medium',
        sidebarCollapsed: false,
        animationsEnabled: true
    };

    // تحميل الإعدادات المحفوظة
    function loadSettings() {
        const settings = {};
        Object.keys(defaultSettings).forEach(key => {
            const stored = localStorage.getItem(`theme_${key}`);
            settings[key] = stored !== null ? JSON.parse(stored) : defaultSettings[key];
        });
        return settings;
    }

    // حفظ الإعدادات
    function saveSetting(key, value) {
        localStorage.setItem(`theme_${key}`, JSON.stringify(value));
    }

    // تطبيق الإعدادات على الصفحة
    function applySettings(settings) {
        const root = document.documentElement;

        // تطبيق الوضع المظلم
        if (settings.darkMode) {
            document.body.classList.add('dark');
        } else {
            document.body.classList.remove('dark');
        }

        // تطبيق الألوان المخصصة
        if (settings.primaryColor && settings.primaryColor !== defaultSettings.primaryColor) {
            root.style.setProperty('--primary-color', settings.primaryColor);
        }

        if (settings.secondaryColor && settings.secondaryColor !== defaultSettings.secondaryColor) {
            root.style.setProperty('--secondary-color', settings.secondaryColor);
        }

        if (settings.accentColor && settings.accentColor !== defaultSettings.accentColor) {
            root.style.setProperty('--accent-color', settings.accentColor);
        }

        // تطبيق حجم الخط
        document.body.classList.remove('text-sm', 'text-base', 'text-lg', 'text-xl');
        switch (settings.fontSize) {
            case 'small':
                document.body.classList.add('text-sm');
                break;
            case 'large':
                document.body.classList.add('text-lg');
                break;
            case 'extra-large':
                document.body.classList.add('text-xl');
                break;
            default:
                document.body.classList.add('text-base');
        }

        // تطبيق حالة القائمة الجانبية
        const sidebar = document.querySelector('.side-nav');
        if (sidebar) {
            if (settings.sidebarCollapsed) {
                sidebar.classList.add('side-nav--collapsed');
            } else {
                sidebar.classList.remove('side-nav--collapsed');
            }
        }

        // تطبيق الرسوم المتحركة
        if (!settings.animationsEnabled) {
            root.style.setProperty('--animation-duration', '0s');
        } else {
            root.style.removeProperty('--animation-duration');
        }
    }

    // تحديث ملف CSS المخصص
    function updateCustomCSS(settings) {
        const css = `
:root {
    --primary-color: ${settings.primaryColor};
    --secondary-color: ${settings.secondaryColor};
    --accent-color: ${settings.accentColor};
}

.theme-primary { background-color: var(--primary-color) !important; }
.theme-secondary { background-color: var(--secondary-color) !important; }
.theme-accent { background-color: var(--accent-color) !important; }

.btn-primary {
    background-color: var(--primary-color) !important;
    border-color: var(--primary-color) !important;
}

.btn-primary:hover {
    background-color: ${adjustBrightness(settings.primaryColor, -20)} !important;
    border-color: ${adjustBrightness(settings.primaryColor, -20)} !important;
}
        `;

        // إنشاء أو تحديث ملف CSS
        let style = document.getElementById('custom-theme-styles');
        if (!style) {
            style = document.createElement('style');
            style.id = 'custom-theme-styles';
            document.head.appendChild(style);
        }
        style.textContent = css;
    }

    // تعديل سطوع اللون
    function adjustBrightness(hex, steps) {
        hex = hex.replace('#', '');
        if (hex.length !== 6) return '#000000';

        const r = Math.max(0, Math.min(255, parseInt(hex.substr(0, 2), 16) + steps));
        const g = Math.max(0, Math.min(255, parseInt(hex.substr(2, 2), 16) + steps));
        const b = Math.max(0, Math.min(255, parseInt(hex.substr(4, 2), 16) + steps));

        return `#${r.toString(16).padStart(2, '0')}${g.toString(16).padStart(2, '0')}${b.toString(16).padStart(2, '0')}`;
    }

    // تحويل hex إلى RGB
    function hexToRgb(hex) {
        hex = hex.replace('#', '');
        if (hex.length !== 6) return '0, 0, 0';

        const r = parseInt(hex.substr(0, 2), 16);
        const g = parseInt(hex.substr(2, 2), 16);
        const b = parseInt(hex.substr(4, 2), 16);

        return `${r}, ${g}, ${b}`;
    }

    // إرسال الإعدادات إلى الخادم
    async function saveToServer(settings) {
        try {
            const response = await fetch('/settings/appearance', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(settings)
            });

            const result = await response.json();

            if (result.success) {
                // إظهار رسالة نجاح
                showNotification('تم حفظ الإعدادات بنجاح!', 'success');
            } else {
                throw new Error(result.message || 'حدث خطأ أثناء الحفظ');
            }
        } catch (error) {
            console.error('Error saving settings:', error);
            showNotification('حدث خطأ أثناء حفظ الإعدادات', 'error');
        }
    }

    // إظهار الإشعارات
    function showNotification(message, type = 'info') {
        // يمكن استخدام مكتبة إشعارات أو إنشاء إشعار بسيط
        const notification = document.createElement('div');
        notification.className = `notification notification--${type}`;
        notification.textContent = message;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
        }, 3000);
    }

    // تهيئة النظام
    function init() {
        const settings = loadSettings();
        applySettings(settings);
        updateCustomCSS(settings);

        // إضافة event listeners للنموذج
        setupFormListeners();

        console.log('🎨 Theme Customizer initialized');
    }

    // إعداد event listeners للنموذج
    function setupFormListeners() {
        // الوضع المظلم
        const darkModeToggle = document.querySelector('input[name="dark_mode"]');
        if (darkModeToggle) {
            darkModeToggle.addEventListener('change', function(e) {
                applySettings({ darkMode: e.target.checked });
                saveSetting('darkMode', e.target.checked);
            });
        }

        // ألوان الثيم
        const colorInputs = document.querySelectorAll('input[type="color"]');
        colorInputs.forEach(input => {
            input.addEventListener('input', function(e) {
                const settings = loadSettings();
                settings.primaryColor = document.querySelector('input[name="primary_color"]')?.value || settings.primaryColor;
                settings.secondaryColor = document.querySelector('input[name="secondary_color"]')?.value || settings.secondaryColor;
                settings.accentColor = document.querySelector('input[name="accent_color"]')?.value || settings.accentColor;

                applySettings(settings);
                updateCustomCSS(settings);
            });
        });

        // اختيار الثيم
        const themeSelect = document.querySelector('select[name="theme"]');
        if (themeSelect) {
            themeSelect.addEventListener('change', function(e) {
                saveSetting('theme', e.target.value);
                // إعادة تحميل الصفحة لتطبيق الثيم الجديد
                if (confirm('سيتم إعادة تحميل الصفحة لتطبيق الثيم الجديد. هل تريد المتابعة؟')) {
                    window.location.reload();
                }
            });
        }

        // حجم الخط
        const fontSizeSelect = document.querySelector('select[name="font_size"]');
        if (fontSizeSelect) {
            fontSizeSelect.addEventListener('change', function(e) {
                applySettings({ fontSize: e.target.value });
                saveSetting('fontSize', e.target.value);
            });
        }

        // الرسوم المتحركة
        const animationsToggle = document.querySelector('input[name="animations_enabled"]');
        if (animationsToggle) {
            animationsToggle.addEventListener('change', function(e) {
                applySettings({ animationsEnabled: e.target.checked });
                saveSetting('animationsEnabled', e.target.checked);
            });
        }

        // تصغير القائمة
        const sidebarToggle = document.querySelector('input[name="sidebar_collapsed"]');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('change', function(e) {
                applySettings({ sidebarCollapsed: e.target.checked });
                saveSetting('sidebarCollapsed', e.target.checked);
            });
        }
    }

    // تحديث المعاينة
    function updatePreview() {
        const primaryColor = document.querySelector('input[name="primary_color"]')?.value || '#1e40af';
        const secondaryColor = document.querySelector('input[name="secondary_color"]')?.value || '#7c3aed';
        const accentColor = document.querySelector('input[name="accent_color"]')?.value || '#06b6d4';

        const primaryPreviews = document.querySelectorAll('.preview-primary');
        const secondaryPreviews = document.querySelectorAll('.preview-secondary');
        const accentPreviews = document.querySelectorAll('.preview-accent');

        primaryPreviews.forEach(el => el.style.backgroundColor = primaryColor);
        secondaryPreviews.forEach(el => el.style.backgroundColor = secondaryColor);
        accentPreviews.forEach(el => el.style.backgroundColor = accentColor);
    }

    // إضافة وظيفة إعادة التعيين
    window.resetThemeSettings = function() {
        // إعادة القيم الافتراضية
        const defaults = {
            darkMode: false,
            primaryColor: '#1e40af',
            secondaryColor: '#7c3aed',
            accentColor: '#06b6d4',
            theme: 'icewall',
            layout: 'side-menu',
            fontSize: 'medium',
            sidebarCollapsed: false,
            animationsEnabled: true
        };

        // تطبيق الإعدادات الافتراضية
        applySettings(defaults);
        updateCustomCSS(defaults);

        // حفظ الإعدادات الافتراضية
        Object.keys(defaults).forEach(key => {
            saveSetting(key, defaults[key]);
        });

        // تحديث النموذج
        updateFormValues(defaults);
        updatePreview();

        console.log('🔄 Theme settings reset to defaults');
    };

    // تحديث قيم النموذج
    function updateFormValues(settings) {
        const darkModeToggle = document.querySelector('input[name="dark_mode"]');
        if (darkModeToggle) darkModeToggle.checked = settings.darkMode;

        const primaryInput = document.querySelector('input[name="primary_color"]');
        if (primaryInput) primaryInput.value = settings.primaryColor;

        const secondaryInput = document.querySelector('input[name="secondary_color"]');
        if (secondaryInput) secondaryInput.value = settings.secondaryColor;

        const accentInput = document.querySelector('input[name="accent_color"]');
        if (accentInput) accentInput.value = settings.accentColor;

        const themeSelect = document.querySelector('select[name="theme"]');
        if (themeSelect) themeSelect.value = settings.theme;

        const fontSizeSelect = document.querySelector('select[name="font_size"]');
        if (fontSizeSelect) fontSizeSelect.value = settings.fontSize;

        const animationsToggle = document.querySelector('input[name="animations_enabled"]');
        if (animationsToggle) animationsToggle.checked = settings.animationsEnabled;

        const sidebarToggle = document.querySelector('input[name="sidebar_collapsed"]');
        if (sidebarToggle) sidebarToggle.checked = settings.sidebarCollapsed;
    }

    // تشغيل النظام عند تحميل الصفحة
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // تصدير الوظائف للاستخدام العام
    window.ThemeCustomizer = {
        loadSettings,
        saveSetting,
        applySettings,
        updateCustomCSS,
        saveToServer
    };

})();

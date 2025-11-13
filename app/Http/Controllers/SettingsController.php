<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\PrefixSetting;
use App\Models\Company;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class SettingsController extends Controller
{
    public function index(): View
    {
        $settings = Setting::all()->pluck('value', 'key');
        $prefixSettings = PrefixSetting::all();
        $company = Company::first();

        return view('settings.index', [
            'settings' => $settings,
            'prefixSettings' => $prefixSettings,
            'company' => $company,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string|max:255',
            'default_language' => 'nullable|string|in:en,ar',
            'timezone' => 'nullable|string',
            'date_format' => 'nullable|string|in:Y-m-d,d/m/Y,m/d/Y',
            'maintenance_mode' => 'nullable|boolean',
            'debug_mode' => 'nullable|boolean',
        ]);

        // حفظ الإعدادات في قاعدة البيانات
        Setting::set('app_name', $request->app_name, 'string', 'Application name');
        Setting::set('app.locale', $request->default_language ?? 'en', 'string', 'Default application locale');
        Setting::set('app.timezone', $request->timezone ?? 'UTC', 'string', 'Application timezone');
        Setting::set('date_format', $request->date_format ?? 'Y-m-d', 'string', 'Date format');
        Setting::set('maintenance_mode', $request->boolean('maintenance_mode'), 'boolean', 'Maintenance mode');
        Setting::set('app.debug', $request->boolean('debug_mode'), 'boolean', 'Debug mode');

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Settings updated successfully!'
            ]);
        }

        return redirect()->route('settings.index')->with('success', 'Settings updated successfully!');
    }

    public function updatePrefix(Request $request)
    {
        $request->validate([
            'prefixes' => 'required|array',
            'prefixes.*.prefix' => 'required|string|max:10',
            'prefixes.*.padding' => 'required|integer|min:1|max:10',
            'prefixes.*.start_number' => 'required|integer|min:1',
            'prefixes.*.include_year' => 'boolean',
        ]);

        foreach ($request->prefixes as $id => $data) {
            PrefixSetting::where('id', $id)->update([
                'prefix' => $data['prefix'],
                'padding' => $data['padding'],
                'start_number' => $data['start_number'],
                'current_number' => $data['start_number'],
                'include_year' => isset($data['include_year']) ? true : false,
            ]);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Prefix settings updated successfully!'
            ]);
        }

        return redirect()->route('settings.index')->with('success', 'Prefix settings updated successfully!');
    }

    public function updateCompany(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'nullable|string',
            'commercial_registration' => 'nullable|string|max:255',
            'tax_number' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'country' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:255',
        ]);

        $company = Company::first();
        
        $data = $request->except('logo');
        
        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('companies', 'public');
            $data['logo'] = $logoPath;
            
            // Delete old logo if exists
            if ($company && $company->logo) {
                \Storage::disk('public')->delete($company->logo);
            }
        }

        if ($company) {
            $company->update($data);
        } else {
            Company::create($data);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Company settings updated successfully!'
            ]);
        }

        return redirect()->route('settings.index')->with('success', 'Company settings updated successfully!');
    }

    public function updateAppearance(Request $request)
    {
        $request->validate([
            'dark_mode' => 'nullable|boolean',
            'primary_color' => 'nullable|string|regex:/^#[a-fA-F0-9]{6}$/',
            'secondary_color' => 'nullable|string|regex:/^#[a-fA-F0-9]{6}$/',
            'accent_color' => 'nullable|string|regex:/^#[a-fA-F0-9]{6}$/',
            'font_size' => 'nullable|string|in:small,medium,large,extra-large',
            'sidebar_collapsed' => 'nullable|boolean',
            'animations_enabled' => 'nullable|boolean',
        ]);

        // حفظ إعدادات المظهر
        Setting::set('dark_mode', $request->boolean('dark_mode'), 'boolean', 'Enable dark mode');
        Setting::set('primary_color', $request->primary_color ?? '#1e40af', 'string', 'Primary theme color');
        Setting::set('secondary_color', $request->secondary_color ?? '#7c3aed', 'string', 'Secondary theme color');
        Setting::set('accent_color', $request->accent_color ?? '#06b6d4', 'string', 'Accent theme color');
        Setting::set('font_size', $request->font_size ?? 'medium', 'string', 'Font size preference');
        Setting::set('sidebar_collapsed', $request->boolean('sidebar_collapsed'), 'boolean', 'Sidebar collapsed state');
        Setting::set('animations_enabled', $request->boolean('animations_enabled', true), 'boolean', 'Enable animations');

        // إنشاء CSS مخصص للألوان
        $this->generateCustomCSS();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'تم حفظ إعدادات المظهر بنجاح!'
            ]);
        }

        return redirect()->route('settings.index')->with('success', 'تم حفظ إعدادات المظهر بنجاح!');
    }

    public function updateAttendance(Request $request)
    {
        $request->validate([
            'attendance.working_hours_per_day' => 'required|numeric|min:1|max:24',
            'attendance.half_day_hours' => 'required|numeric|min:1|max:12',
            'attendance.grace_period_minutes' => 'required|numeric|min:0|max:120',
            'attendance.auto_checkout_time' => 'required|date_format:H:i',
            'attendance.minimum_working_hours' => 'required|numeric|min:1|max:24',
            'attendance.enable_auto_attendance' => 'nullable|boolean',
            'attendance.allow_mobile_checkin' => 'nullable|boolean',
            'attendance.require_location' => 'nullable|boolean',
            'attendance.notify_late_arrival' => 'nullable|boolean',
            'attendance.notify_early_departure' => 'nullable|boolean',
            'attendance.weekend_days' => 'nullable|string|max:255',
            'attendance.holidays' => 'nullable|string',
        ]);

        // حفظ إعدادات ساعات العمل
        Setting::set('attendance.working_hours_per_day', $request->input('attendance.working_hours_per_day'), 'number', 'عدد ساعات العمل اليومية');
        Setting::set('attendance.half_day_hours', $request->input('attendance.half_day_hours'), 'number', 'ساعات نصف اليوم');
        Setting::set('attendance.grace_period_minutes', $request->input('attendance.grace_period_minutes'), 'number', 'فترة السماح (دقائق)');
        Setting::set('attendance.auto_checkout_time', $request->input('attendance.auto_checkout_time'), 'time', 'وقت الخروج التلقائي');
        Setting::set('attendance.minimum_working_hours', $request->input('attendance.minimum_working_hours'), 'number', 'الحد الأدنى لساعات العمل');

        // حفظ إعدادات المميزات
        Setting::set('attendance.enable_auto_attendance', $request->boolean('attendance.enable_auto_attendance'), 'boolean', 'تفعيل التسجيل التلقائي');
        Setting::set('attendance.allow_mobile_checkin', $request->boolean('attendance.allow_mobile_checkin'), 'boolean', 'السماح بالتسجيل عبر الهاتف');
        Setting::set('attendance.require_location', $request->boolean('attendance.require_location'), 'boolean', 'طلب تحديد الموقع');
        Setting::set('attendance.notify_late_arrival', $request->boolean('attendance.notify_late_arrival'), 'boolean', 'إشعار التأخير');
        Setting::set('attendance.notify_early_departure', $request->boolean('attendance.notify_early_departure'), 'boolean', 'إشعار المغادرة المبكرة');

        // حفظ إعدادات الجدول الزمني
        Setting::set('attendance.weekend_days', $request->input('attendance.weekend_days'), 'text', 'أيام نهاية الأسبوع');
        Setting::set('attendance.holidays', $request->input('attendance.holidays'), 'textarea', 'العطلات الرسمية');

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'تم حفظ إعدادات الحضور والغياب بنجاح!'
            ]);
        }

        return redirect()->route('settings.index')->with('success', 'تم حفظ إعدادات الحضور والغياب بنجاح!');
    }

    /**
     * إنشاء ملف CSS مخصص للألوان المختارة
     */
    private function generateCustomCSS()
    {
        $primaryColor = setting('primary_color', '#1e40af');
        $secondaryColor = setting('secondary_color', '#7c3aed');
        $accentColor = setting('accent_color', '#06b6d4');

        $css = "
/* Custom Theme Colors */
:root {
    --primary-color: {$primaryColor};
    --secondary-color: {$secondaryColor};
    --accent-color: {$accentColor};
    --primary-rgb: " . $this->hexToRgb($primaryColor) . ";
    --secondary-rgb: " . $this->hexToRgb($secondaryColor) . ";
    --accent-rgb: " . $this->hexToRgb($accentColor) . ";
}

/* Override theme colors */
.theme-primary { background-color: var(--primary-color) !important; }
.theme-secondary { background-color: var(--secondary-color) !important; }
.theme-accent { background-color: var(--accent-color) !important; }

/* Button overrides */
.btn-primary {
    background-color: var(--primary-color) !important;
    border-color: var(--primary-color) !important;
}

.btn-primary:hover {
    background-color: " . $this->adjustBrightness($primaryColor, -20) . " !important;
    border-color: " . $this->adjustBrightness($primaryColor, -20) . " !important;
}

/* Link overrides */
.text-primary { color: var(--primary-color) !important; }
.text-secondary { color: var(--secondary-color) !important; }
.text-accent { color: var(--accent-color) !important; }

/* Background overrides */
.bg-primary { background-color: var(--primary-color) !important; }
.bg-secondary { background-color: var(--secondary-color) !important; }
.bg-accent { background-color: var(--accent-color) !important; }

/* Border overrides */
.border-primary { border-color: var(--primary-color) !important; }
.border-secondary { border-color: var(--secondary-color) !important; }
.border-accent { border-color: var(--accent-color) !important; }

/* إزالة Navigation bar overrides - إعادة للألوان الأصلية */
/* .side-nav { background-color: var(--primary-color) !important; } */
/* .side-nav__item:hover { background-color: var(--secondary-color) !important; } */
/* .side-nav__item--active { background-color: var(--accent-color) !important; } */

/* Top navigation overrides - إعادة للأبيض */
.top-nav { background-color: #ffffff !important; }
.top-nav__item:hover { background-color: #f8fafc !important; }
.top-nav__item--active { background-color: var(--primary-color) !important; }
";

        // حفظ ملف CSS المخصص
        $cssPath = public_path('css/custom-theme.css');
        if (!file_exists(dirname($cssPath))) {
            mkdir(dirname($cssPath), 0755, true);
        }
        file_put_contents($cssPath, $css);
    }

    /**
     * تحويل لون hex إلى RGB
     */
    private function hexToRgb($hex)
    {
        $hex = str_replace('#', '', $hex);
        if (strlen($hex) != 6) {
            return '0, 0, 0';
        }

        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        return "{$r}, {$g}, {$b}";
    }

    /**
     * تعديل سطوع اللون
     */
    private function adjustBrightness($hex, $steps)
    {
        $hex = str_replace('#', '', $hex);
        if (strlen($hex) != 6) {
            return '#000000';
        }

        $r = max(0, min(255, hexdec(substr($hex, 0, 2)) + $steps));
        $g = max(0, min(255, hexdec(substr($hex, 2, 2)) + $steps));
        $b = max(0, min(255, hexdec(substr($hex, 4, 2)) + $steps));

        return sprintf("#%02x%02x%02x", $r, $g, $b);
    }
}

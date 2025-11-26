<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting\Setting;
use App\Models\Setting\PrefixSetting;
use App\Models\Setting\Company;
use App\Models\Accounting\Accounting;
use App\Models\Accounting\Tax;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SettingsController extends Controller
{
    public function index(): View
    {
        $settings = Setting::all()->pluck('value', 'key');
        $prefixSettings = PrefixSetting::all();
        $companies = Company::orderBy('name')->get();
        $company = $companies->first();
        $taxes = Tax::with(['company', 'salesAccount', 'purchaseAccount'])->orderBy('name')->get();
        $accounts = Accounting::orderBy('code')->get();
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();

        return view('settings.index', [
            'settings' => $settings,
            'prefixSettings' => $prefixSettings,
            'company' => $company,
            'companies' => $companies,
            'roles' => $roles,
            'permissions' => $permissions,
            'taxes' => $taxes,
            'accounts' => $accounts,
        ]);
    }

    public function storeTax(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'company_id' => ['nullable', 'exists:companies,id'],
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:50'],
            'rate' => ['required', 'numeric', 'min:0', 'max:100'],
            'type' => ['required', 'in:value_added,withholding,other'],
            'sales_account_id' => ['nullable', 'exists:accountings,id'],
            'purchase_account_id' => ['nullable', 'exists:accountings,id'],
            'is_default' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string'],
        ]);

        // Store rate as percentage value (e.g. 15 = 15%)
        $data['is_default'] = $request->boolean('is_default', false);
        $data['is_active'] = $request->boolean('is_active', true);

        // If a default tax is set, unset previous defaults for the same company (or global)
        if ($data['is_default']) {
            Tax::where('company_id', $data['company_id'] ?? null)->update(['is_default' => false]);
        }

        $tax = Tax::create($data);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'تم إضافة الضريبة بنجاح',
                'tax' => $tax
            ]);
        }

        return redirect()->route('settings.index')->with('success', 'Tax created successfully.');
    }

    /**
     * Update a specific tax
     */
    public function updateTax(Request $request, Tax $tax)
    {
        $data = $request->validate([
            'company_id' => ['nullable', 'exists:companies,id'],
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:50'],
            'rate' => ['required', 'numeric', 'min:0', 'max:100'],
            'type' => ['required', 'in:value_added,withholding,other'],
            'sales_account_id' => ['nullable', 'exists:accountings,id'],
            'purchase_account_id' => ['nullable', 'exists:accountings,id'],
            'is_default' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string'],
        ]);

        $data['is_default'] = $request->boolean('is_default', false);
        $data['is_active'] = $request->boolean('is_active', false);

        // If a default tax is set, unset previous defaults for the same company (or global)
        if ($data['is_default']) {
            Tax::where('company_id', $data['company_id'] ?? null)
                ->where('id', '!=', $tax->id)
                ->update(['is_default' => false]);
        }

        $tax->update($data);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'تم تحديث الضريبة بنجاح',
                'tax' => $tax->fresh()
            ]);
        }

        return redirect()->route('settings.index')->with('success', 'تم تحديث الضريبة بنجاح');
    }

    /**
     * Delete a tax
     */
    public function destroyTax(Tax $tax)
    {
        try {
            $tax->delete();

            return response()->json([
                'success' => true,
                'message' => 'تم حذف الضريبة بنجاح'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'فشل في حذف الضريبة: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string|max:255',
            'app_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'default_language' => 'nullable|string|in:en,ar',
            'timezone' => 'nullable|string',
            'date_format' => 'nullable|string|in:Y-m-d,d/m/Y,m/d/Y',
            'maintenance_mode' => 'nullable|boolean',
            'debug_mode' => 'nullable|boolean',
            'currency_code' => 'nullable|string|max:10',
            'currency_symbol' => 'nullable|string|max:10',
            'currency_position' => 'nullable|string|in:before,after',
        ]);

        // حفظ الإعدادات في قاعدة البيانات
        Setting::set('app_name', $request->app_name, 'string', 'Application name');

        $selectedLocale = $request->default_language ?? 'en';
        Setting::set('app.locale', $selectedLocale, 'string', 'Default application locale');

        session(['locale' => $selectedLocale]);
        app()->setLocale($selectedLocale);

        Setting::set('app.timezone', $request->timezone ?? 'UTC', 'string', 'Application timezone');
        Setting::set('date_format', $request->date_format ?? 'Y-m-d', 'string', 'Date format');
        Setting::set('maintenance_mode', $request->boolean('maintenance_mode'), 'boolean', 'Maintenance mode');
        Setting::set('app.debug', $request->boolean('debug_mode'), 'boolean', 'Debug mode');

        // إعدادات العملة العامة
        Setting::set('currency.code', $request->currency_code ?? 'USD', 'string', 'Default currency code');
        Setting::set('currency.symbol', $request->currency_symbol ?? '$', 'string', 'Default currency symbol');
        Setting::set('currency.position', $request->currency_position ?? 'before', 'string', 'Currency symbol position (before or after amount)');

        $existingLogo = Setting::get('app.logo');

        if ($request->hasFile('app_logo')) {
            $newLogoPath = $request->file('app_logo')->store('branding', 'public');
            Setting::set('app.logo', $newLogoPath, 'string', 'Application logo');

            if ($existingLogo) {
                Storage::disk('public')->delete($existingLogo);
            }
        } elseif ($request->boolean('reset_app_logo') && $existingLogo) {
            Storage::disk('public')->delete($existingLogo);
            Setting::set('app.logo', null, 'string', 'Application logo');
        }

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

    /**
     * Store a new company
     */
    public function storeCompany(Request $request)
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
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->except('logo');
        $data['is_active'] = $request->boolean('is_active', true);
        
        // Handle logo upload
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('companies', 'public');
        }

        $company = Company::create($data);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'تم إضافة الشركة بنجاح',
                'company' => $company
            ]);
        }

        return redirect()->route('settings.index')->with('success', 'تم إضافة الشركة بنجاح');
    }

    /**
     * Update a specific company
     */
    public function updateCompanyById(Request $request, Company $company)
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
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->except(['logo', '_token', '_method']);
        $data['is_active'] = $request->boolean('is_active', false);
        
        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($company->logo) {
                Storage::disk('public')->delete($company->logo);
            }
            $data['logo'] = $request->file('logo')->store('companies', 'public');
        }

        $company->update($data);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'تم تحديث الشركة بنجاح',
                'company' => $company->fresh()
            ]);
        }

        return redirect()->route('settings.index')->with('success', 'تم تحديث الشركة بنجاح');
    }

    /**
     * Delete a company
     */
    public function destroyCompany(Company $company)
    {
        try {
            // Delete logo if exists
            if ($company->logo) {
                Storage::disk('public')->delete($company->logo);
            }
            
            $company->delete();

            return response()->json([
                'success' => true,
                'message' => 'تم حذف الشركة بنجاح'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'فشل في حذف الشركة: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateAppearance(Request $request)
    {
        $palettes = config('theme.palettes', []);
        $paletteKeys = implode(',', array_keys($palettes));

        $request->validate([
            'dark_mode' => 'nullable|boolean',
            'theme_palette' => $paletteKeys ? 'nullable|string|in:' . $paletteKeys : 'nullable|string',
            'font_size' => 'nullable|string|in:small,medium,large,extra-large',
            'sidebar_collapsed' => 'nullable|boolean',
            // Allow any value here; we'll normalize it via $request->boolean()
            'animations_enabled' => 'nullable',
        ]);

        $selectedPaletteKey = $request->input('theme_palette', setting('theme_palette', config('theme.default_palette')));
        if (!$palettes || !array_key_exists($selectedPaletteKey, $palettes)) {
            $selectedPaletteKey = config('theme.default_palette');
        }
        $selectedPalette = $palettes[$selectedPaletteKey];

        // حفظ إعدادات المظهر
        Setting::set('dark_mode', $request->boolean('dark_mode'), 'boolean', 'Enable dark mode');
        Setting::set('theme_palette', $selectedPaletteKey, 'string', 'Selected theme palette');
        Setting::set('primary_color', $selectedPalette['primary'], 'string', 'Primary theme color');
        Setting::set('secondary_color', $selectedPalette['secondary'], 'string', 'Secondary theme color');
        Setting::set('accent_color', $selectedPalette['accent'], 'string', 'Accent theme color');
        Setting::set('font_size', $request->font_size ?? 'medium', 'string', 'Font size preference');
        Setting::set('sidebar_collapsed', $request->boolean('sidebar_collapsed'), 'boolean', 'Sidebar collapsed state');
        Setting::set('animations_enabled', $request->boolean('animations_enabled', true), 'boolean', 'Enable animations');

        // إنشاء CSS مخصص للألوان
        $this->generateCustomCSS();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Appearance settings updated successfully!',
            ]);
        }

        return redirect()
            ->route('settings.index')
            ->with('success', 'Appearance settings updated successfully!');
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

    public function updateAiSettings(Request $request)
    {
        $request->validate([
            'provider' => 'required|in:openai,ollama',
            'openai_api_key' => 'nullable|string',
            'openai_model' => 'nullable|string',
            'openai_max_tokens' => 'nullable|integer|min:1',
            'openai_temperature' => 'nullable|numeric|min:0|max:2',
            'ollama_base_url' => 'nullable|string',
            'ollama_model' => 'nullable|string',
        ]);

        $provider = $request->input('provider', 'openai');
        Setting::set('ai.provider', $provider, 'string', 'AI provider (openai or ollama)');

        // OpenAI settings
        Setting::set('ai.api_key', $request->input('openai_api_key'), 'string', 'OpenAI API key');
        Setting::set('ai.model', $request->input('openai_model', 'gpt-3.5-turbo'), 'string', 'OpenAI model');
        Setting::set('ai.max_tokens', $request->input('openai_max_tokens', 2000), 'number', 'OpenAI max tokens');
        Setting::set('ai.temperature', $request->input('openai_temperature', 0.7), 'number', 'OpenAI temperature');

        // Ollama settings
        Setting::set('ai.ollama_base_url', $request->input('ollama_base_url', 'http://127.0.0.1:11434'), 'string', 'Ollama base URL');
        Setting::set('ai.ollama_model', $request->input('ollama_model', 'llama3'), 'string', 'Ollama model');

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'AI settings updated successfully!',
            ]);
        }

        return redirect()->route('settings.index', ['#ai'])->with('success', 'AI settings updated successfully!');
    }

    public function updateNotifications(Request $request)
    {
        // Notification Channels
        $channelKeys = [
            'notifications.channels.database' => 'In-app notifications enabled',
            'notifications.channels.mail' => 'Email notifications enabled',
        ];

        foreach ($channelKeys as $key => $description) {
            $fieldName = str_replace('.', '_', $key);
            $value = $request->boolean($fieldName);
            Setting::set($key, $value, 'boolean', $description);
        }

        // Task Notifications
        $taskKeys = [
            'notifications.task.assigned' => 'Notify when a task is assigned',
            'notifications.task.started' => 'Notify when a task is started',
            'notifications.task.completed' => 'Notify when a task is completed',
            'notifications.task.updated' => 'Notify when a task is updated',
            'notifications.task.commented' => 'Notify when a comment is added',
            'notifications.task.liked' => 'Notify when a task is liked',
        ];

        foreach ($taskKeys as $key => $description) {
            $fieldName = str_replace('.', '_', $key);
            $value = $request->boolean($fieldName);
            Setting::set($key, $value, 'boolean', $description);
        }

        // Task Extension Notifications
        $extensionKeys = [
            'notifications.task_extension.requested' => 'Notify when extension is requested',
            'notifications.task_extension.approved' => 'Notify when extension is approved',
            'notifications.task_extension.rejected' => 'Notify when extension is rejected',
        ];

        foreach ($extensionKeys as $key => $description) {
            $fieldName = str_replace('.', '_', $key);
            $value = $request->boolean($fieldName);
            Setting::set($key, $value, 'boolean', $description);
        }

        // HR Notifications
        $hrKeys = [
            'notifications.department.created' => 'Notify when a department is created',
            'notifications.employee.created' => 'Notify when an employee is created',
        ];

        foreach ($hrKeys as $key => $description) {
            $fieldName = str_replace('.', '_', $key);
            $value = $request->boolean($fieldName);
            Setting::set($key, $value, 'boolean', $description);
        }

        // Documents expiry reminder days (numeric setting)
        if ($request->filled('notifications_documents_expiry_reminder_days')) {
            $days = (int) $request->input('notifications_documents_expiry_reminder_days', 30);
            $days = max(1, min(365, $days));
            Setting::set(
                'notifications.documents.expiry_reminder_days',
                $days,
                'number',
                'Days before a document expiry to trigger reminders'
            );
        }

        // Clear cache to apply new settings
        \Artisan::call('cache:clear');

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Notification settings updated successfully!',
            ]);
        }

        return redirect()->route('settings.index')->with('success', 'Notification settings updated successfully!');
    }

    /**
     * إنشاء ملف CSS مخصص للألوان المختارة
     */
    private function generateCustomCSS()
    {
        $primaryColor = setting('primary_color', '#1e40af');
        $secondaryColor = setting('secondary_color', '#7c3aed');
        $accentColor = setting('accent_color', '#06b6d4');

        $primaryRgb = $this->hexToRgb($primaryColor);
        $secondaryRgb = $this->hexToRgb($secondaryColor);
        $accentRgb = $this->hexToRgb($accentColor);

        $css = <<<CSS
/* Custom Theme Colors */
:root {
    --primary-color: {$primaryColor};
    --secondary-color: {$secondaryColor};
    --accent-color: {$accentColor};
    --primary-rgb: {$primaryRgb};
    --secondary-rgb: {$secondaryRgb};
    --accent-rgb: {$accentRgb};
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
    background-color: {$this->adjustBrightness($primaryColor, -20)} !important;
    border-color: {$this->adjustBrightness($primaryColor, -20)} !important;
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

/* Top navigation overrides - HR pulse gradient */
.top-nav {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 45%, var(--accent-color) 100%) !important;
    color: #f8fafc !important;
    box-shadow: 0 10px 30px rgba(var(--primary-rgb), 0.25);
}

.top-nav__item {
    color: #e2e8f0 !important;
}

.top-nav__item:hover,
.top-nav__item--active {
    background-color: rgba(255, 255, 255, 0.12) !important;
    color: #ffffff !important;
}

/* Top bar background */
.top-bar-pattern {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 45%, var(--accent-color) 100%) !important;
    position: relative;
    overflow: hidden;
    box-shadow: 0 35px 80px rgba(var(--primary-rgb), 0.35);
}

.top-bar-pattern::before {
    content: "";
    position: absolute;
    inset: 0;
    pointer-events: none;
    background: radial-gradient(circle at 12% 120%, rgba(255, 255, 255, 0.18), transparent 55%),
        radial-gradient(circle at 70% 130%, rgba(255, 255, 255, 0.1), transparent 50%);
    opacity: 0.6;
}

.top-bar-pattern::after {
    content: "";
    position: absolute;
    inset: 0;
    pointer-events: none;
    background: radial-gradient(circle at 65% 35%, rgba(255, 255, 255, 0.12), transparent 50%);
    mix-blend-mode: screen;
}
CSS;

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

    /**
     * Get role permissions for editing
     */
    public function getRolePermissions(Role $role)
    {
        $permissions = Permission::all()->groupBy(function($permission) {
            $parts = explode(' ', $permission->name);
            return end($parts);
        });

        return response()->json([
            'success' => true,
            'role' => [
                'id' => $role->id,
                'name' => ucwords(str_replace('-', ' ', $role->name)),
            ],
            'permissions_grouped' => $permissions,
            'role_permissions' => $role->permissions->pluck('id')->toArray(),
        ]);
    }

    /**
     * Update role permissions
     */
    public function updateRolePermissions(Request $request, Role $role)
    {
        if ($role->name === 'super-admin') {
            return response()->json([
                'success' => false,
                'message' => 'Cannot modify super-admin permissions',
            ], 403);
        }

        $permissionIds = $request->input('permissions', []);
        $permissions = Permission::whereIn('id', $permissionIds)->get();
        
        $role->syncPermissions($permissions);
        
        // Clear permission cache
        app()['cache']->forget('spatie.permission.cache');

        return response()->json([
            'success' => true,
            'message' => 'Role permissions updated successfully!',
        ]);
    }

    /**
     * Store a new role
     */
    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'copy_from' => 'nullable|exists:roles,id',
        ]);

        $role = Role::create([
            'name' => strtolower(str_replace(' ', '-', $request->name)),
            'guard_name' => 'web',
        ]);

        // Copy permissions from another role if specified
        if ($request->filled('copy_from')) {
            $sourceRole = Role::find($request->copy_from);
            if ($sourceRole) {
                $role->syncPermissions($sourceRole->permissions);
            }
        }

        // Clear permission cache
        app()['cache']->forget('spatie.permission.cache');

        return response()->json([
            'success' => true,
            'message' => 'Role created successfully!',
            'role' => $role,
        ]);
    }

    /**
     * Assign roles to a user
     */
    public function assignUserRoles(Request $request, \App\Models\User $user)
    {
        $roleIds = $request->input('roles', []);
        $roles = Role::whereIn('id', $roleIds)->get();
        
        $user->syncRoles($roles);
        
        // Clear permission cache
        app()['cache']->forget('spatie.permission.cache');

        return response()->json([
            'success' => true,
            'message' => 'User roles updated successfully!',
        ]);
    }

    /**
     * Update expiry notification settings
     */
    public function updateExpiryNotifications(Request $request)
    {
        $settings = $request->input('settings', []);

        foreach ($settings as $settingData) {
            $setting = \App\Models\Setting\ExpiryNotificationSetting::find($settingData['id']);
            if ($setting) {
                $setting->update([
                    'enabled' => $settingData['enabled'] ?? false,
                    'days_before' => $settingData['days_before'] ?? 30,
                    'notify_roles' => $settingData['notify_roles'] ?? [],
                    'notify_super_admin' => $settingData['notify_super_admin'] ?? false,
                    'notify_owner' => $settingData['notify_owner'] ?? false,
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Expiry notification settings updated successfully!',
        ]);
    }
}

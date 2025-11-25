<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" {{ app()->getLocale() === 'ar' ? 'dir="rtl"' : '' }}>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.welcome') }} - {{ config('app.name') }}</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; direction: {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}; }
        .section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
        .section h3 { margin-top: 0; color: #333; }
        .item { margin: 5px 0; }
        .highlight { background: #f0f0f0; padding: 2px 4px; border-radius: 3px; }
    </style>
</head>
<body>
    <h1>{{ __('messages.welcome') }} - {{ config('app.name') }}</h1>
    <p>{{ __('messages.current_language') }}: <strong>{{ app()->getLocale() }}</strong></p>
    <p>Session Locale: <strong>{{ session('locale', 'not set') }}</strong></p>
    <p>App Locale: <strong>{{ config('app.locale') }}</strong></p>

    @if(isset($debug))
    <div style="background: #f0f0f0; padding: 10px; margin: 10px 0; border-radius: 5px;">
        <h4>Debug Info:</h4>
        <p>App Locale: {{ $debug['app_locale'] }}</p>
        <p>Session Locale: {{ $debug['session_locale'] }}</p>
        <p>Config Locale: {{ $debug['config_locale'] }}</p>
    </div>
    @endif

    <div style="margin: 20px 0;">
        <a href="{{ route('lang.switch', 'en') }}" style="margin: 0 10px;">🇺🇸 English</a> |
        <a href="{{ route('lang.switch', 'ar') }}" style="margin: 0 10px;">🇸🇦 العربية</a>
    </div>

    <div class="section">
        <h3>📋 {{ __('menu.dashboard') }}</h3>
        <div class="item"><strong>{{ __('actions.save') }}</strong> | <strong>{{ __('actions.delete') }}</strong> | <strong>{{ __('actions.edit') }}</strong></div>
    </div>

    <div class="section">
        <h3>🏢 {{ __('menu.warehouse') }}</h3>
        <div class="item">{{ __('menu.purchase_orders') }} | {{ __('menu.material_requests') }} | {{ __('menu.materials') }}</div>
    </div>

    <div class="section">
        <h3>👥 {{ __('menu.customers') }}</h3>
        <div class="item">{{ __('menu.suppliers') }} | {{ __('menu.vendors') }}</div>
    </div>

    <div class="section">
        <h3>👨‍💼 {{ __('menu.hr') }}</h3>
        <div class="item">{{ __('menu.employees') }} | {{ __('menu.departments') }} | {{ __('menu.attendance') }}</div>
    </div>

    <div class="section">
        <h3>📊 {{ __('menu.accounts') }}</h3>
        <div class="item">{{ __('menu.invoices') }} | {{ __('menu.payments') }} | {{ __('menu.reports') }}</div>
    </div>

    <div class="section">
        <h3>📝 {{ __('status.active') }} / {{ __('status.inactive') }}</h3>
        <div class="item">{{ __('status.pending') }} | {{ __('status.approved') }} | {{ __('status.completed') }}</div>
    </div>

    <div class="section">
        <h3>💬 {{ __('messages.success_saved') }}</h3>
        <div class="item">{{ __('messages.success_saved') }}</div>
        <div class="item">{{ __('messages.error_occurred') }}</div>
        <div class="item">{{ __('messages.loading') }}</div>
        <div class="item">{{ __('messages.confirm_delete') }}</div>
    </div>

    <div class="section">
        <h3>🧪 Test Translations</h3>
        <div class="item">Direct: {{ __('menu.crm') }}</div>
        <div class="item">Trans Helper: {{ trans('menu.crm') }}</div>
    </div>
</body>
</html>

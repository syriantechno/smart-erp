<?php

namespace App\Providers;

use App\Models\Setting\Company;
use App\Models\Setting\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register view composers
        View::composer('*', \App\View\Composers\ThemeComposer::class);
        View::composer('*', \App\View\Composers\LayoutComposer::class);
        View::composer('*', \App\View\Composers\MenuComposer::class);

        // Share primary company info globally (logo/name for branding)
        $primaryCompany = Company::first();
        View::share('appCompany', $primaryCompany);
        View::share('appCompanyLogoUrl', $primaryCompany && $primaryCompany->logo
            ? asset('storage/' . $primaryCompany->logo)
            : null);

        $appBrandName = Setting::get('app_name', config('app.name', 'ERP System'));
        $appLogoPath = Setting::get('app.logo');
        $appBrandLogoUrl = $appLogoPath ? asset('storage/' . $appLogoPath) : null;

        View::share('appBrandName', $appBrandName);
        View::share('appBrandLogoUrl', $appBrandLogoUrl);
    }
}

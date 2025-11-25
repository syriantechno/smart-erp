<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Base locale: session value or app config
        $locale = Session::get('locale', config('app.locale', 'en'));

        // Optional manual override via ?locale= parameter
        if ($request->has('locale')) {
            $localeParam = $request->input('locale');
            if (in_array($localeParam, ['en', 'ar'])) {
                $locale = $localeParam;
                Session::put('locale', $locale);
            }
        }

        // Apply locale
        App::setLocale($locale);

        // For RTL support in Arabic
        if ($locale === 'ar') {
            // Add RTL direction to HTML
            $response = $next($request);
            if ($response instanceof \Illuminate\Http\Response) {
                $content = $response->getContent();
                if (str_contains($content, '<html')) {
                    $content = str_replace('<html', '<html dir="rtl" lang="ar"', $content);
                    $response->setContent($content);
                }
            }
            return $response;
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class SetDefaultTheme
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Always set the theme to 'smart-erp' for all requests
        if (!Session::has('activeTheme')) {
            Session::put('activeTheme', 'smart-erp');
        }
        
        return $next($request);
    }
}

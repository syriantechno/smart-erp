<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class OptimizeDatabase
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Enable query caching for read operations
        if ($request->isMethod('GET')) {
            DB::enableQueryLog();
        }

        $response = $next($request);

        // Log slow queries in development
        if (app()->environment('local')) {
            $queries = DB::getQueryLog();
            foreach ($queries as $query) {
                if ($query['time'] > 100) { // Log queries taking more than 100ms
                    \Log::warning('Slow Query Detected', [
                        'sql' => $query['query'],
                        'bindings' => $query['bindings'],
                        'time' => $query['time'] . 'ms'
                    ]);
                }
            }
        }

        return $response;
    }
}

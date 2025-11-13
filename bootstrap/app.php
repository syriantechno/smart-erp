<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\OptimizePerformance::class,
        ]);
    })
    ->withSchedule(function ($schedule) {
        // معالجة الخروج التلقائي يومياً
        $schedule->job(\App\Jobs\ProcessAutoCheckout::class)
            ->dailyAt(setting('attendance.auto_checkout_time', '18:00'))
            ->when(function () {
                return setting('attendance.enable_auto_attendance', false);
            });

        // إنشاء سجلات الحضور التلقائية يومياً
        $schedule->command('attendance:generate-auto')
            ->daily()
            ->when(function () {
                return setting('attendance.enable_auto_attendance', false);
            });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

<?php

namespace App\Providers;

use App\Events\DomainNotificationEvent;
use App\Listeners\DispatchNotificationChannels;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        DomainNotificationEvent::class => [
            DispatchNotificationChannels::class,
        ],
    ];
}

<?php

namespace App\Listeners;

use App\Events\DomainNotificationEvent;
use App\Jobs\SendNotificationToChannel;
use Illuminate\Contracts\Queue\ShouldQueue;

class DispatchNotificationChannels implements ShouldQueue
{
    public function handle(DomainNotificationEvent $event): void
    {
        $channels = config('notification_channels.event_channels.' . $event->eventKey)
            ?? config('notification_channels.default_channels', ['database']);

        foreach ($channels as $channel) {
            if (!config('notification_channels.channels.' . $channel . '.enabled', false)) {
                continue;
            }

            SendNotificationToChannel::dispatch(
                $channel,
                $event->eventKey,
                $event->title,
                $event->message,
                $event->recipientIds,
                $event->actionUrl,
                $event->icon,
                $event->data
            );
        }
    }
}

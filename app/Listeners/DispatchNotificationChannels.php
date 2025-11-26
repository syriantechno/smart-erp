<?php

namespace App\Listeners;

use App\Events\DomainNotificationEvent;
use App\Jobs\SendNotificationToChannel;
use App\Models\Setting\Setting;

class DispatchNotificationChannels
{
    public function handle(DomainNotificationEvent $event): void
    {
        // Check if this notification type is enabled in settings
        $settingKey = 'notifications.' . str_replace('.', '.', $event->eventKey);
        if (!Setting::get($settingKey, true)) {
            return; // Notification type is disabled
        }

        // Get available channels for this event
        $eventChannels = config('notification_channels.event_channels.' . $event->eventKey)
            ?? config('notification_channels.default_channels', ['database']);

        foreach ($eventChannels as $channel) {
            // Check if channel is enabled in settings (database takes priority)
            $channelEnabled = Setting::get('notifications.channels.' . $channel, null);
            
            // If not set in database, fall back to config
            if ($channelEnabled === null) {
                $channelEnabled = config('notification_channels.channels.' . $channel . '.enabled', false);
            }

            if (!$channelEnabled) {
                continue;
            }

            // Run synchronously for immediate notifications
            SendNotificationToChannel::dispatchSync(
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

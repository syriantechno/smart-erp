<?php

namespace App\Services\Notifications;

use App\Events\DomainNotificationEvent;
use App\Models\User;

class NotificationDispatcher
{
    public static function toAllUsers(
        string $eventKey,
        string $title,
        string $message,
        ?string $actionUrl = null,
        ?string $icon = null,
        array $data = []
    ): void {
        $userIds = User::pluck('id')->all();
        self::toUsers($userIds, $eventKey, $title, $message, $actionUrl, $icon, $data);
    }

    public static function toUser(
        int $userId,
        string $eventKey,
        string $title,
        string $message,
        ?string $actionUrl = null,
        ?string $icon = null,
        array $data = []
    ): void {
        self::toUsers([$userId], $eventKey, $title, $message, $actionUrl, $icon, $data);
    }

    public static function toUsers(
        array $userIds,
        string $eventKey,
        string $title,
        string $message,
        ?string $actionUrl = null,
        ?string $icon = null,
        array $data = []
    ): void {
        $recipientIds = array_values(array_unique(array_filter($userIds)));
        if (empty($recipientIds)) {
            return;
        }

        event(new DomainNotificationEvent(
            $eventKey,
            $title,
            $message,
            $recipientIds,
            $actionUrl,
            $icon,
            $data
        ));
    }
}

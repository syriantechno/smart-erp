<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DomainNotificationEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $eventKey;
    public string $title;
    public string $message;
    public array $recipientIds;
    public ?string $actionUrl;
    public ?string $icon;
    public array $data;

    public function __construct(
        string $eventKey,
        string $title,
        string $message,
        array $recipientIds,
        ?string $actionUrl = null,
        ?string $icon = null,
        array $data = []
    ) {
        $this->eventKey = $eventKey;
        $this->title = $title;
        $this->message = $message;
        $this->recipientIds = array_values(array_unique($recipientIds));
        $this->actionUrl = $actionUrl;
        $this->icon = $icon;
        $this->data = $data;
    }
}

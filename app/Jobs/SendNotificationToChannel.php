<?php

namespace App\Jobs;

use App\Http\Controllers\NotificationController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendNotificationToChannel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $channel;
    public string $eventKey;
    public string $title;
    public string $message;
    public array $recipientIds;
    public ?string $actionUrl;
    public ?string $icon;
    public array $data;

    public function __construct(
        string $channel,
        string $eventKey,
        string $title,
        string $message,
        array $recipientIds,
        ?string $actionUrl = null,
        ?string $icon = null,
        array $data = []
    ) {
        $this->channel = $channel;
        $this->eventKey = $eventKey;
        $this->title = $title;
        $this->message = $message;
        $this->recipientIds = $recipientIds;
        $this->actionUrl = $actionUrl;
        $this->icon = $icon;
        $this->data = $data;
    }

    public function handle(): void
    {
        switch ($this->channel) {
            case 'database':
                $this->sendInApp();
                break;
            case 'mail':
                $this->sendMail();
                break;
            case 'sms':
                $this->sendSms();
                break;
            case 'webpush':
                $this->sendWebPush();
                break;
            default:
                Log::warning('Unknown notification channel: ' . $this->channel);
        }
    }

    protected function sendInApp(): void
    {
        foreach ($this->recipientIds as $userId) {
            NotificationController::sendToUser(
                $userId,
                $this->title,
                $this->message,
                'info',
                $this->actionUrl,
                $this->icon
            );
        }
    }

    protected function sendMail(): void
    {
        foreach ($this->recipientIds as $userId) {
            $user = \App\Models\User::find($userId);
            if (!$user || !$user->email) {
                continue;
            }

            Mail::raw($this->message, function ($mail) use ($user) {
                $mail->to($user->email)
                    ->subject($this->title);
            });
        }
    }

    protected function sendSms(): void
    {
        foreach ($this->recipientIds as $userId) {
            $user = \App\Models\User::find($userId);
            if (!$user || !$user->phone) {
                continue;
            }

            Log::info('[SMS] ' . $user->phone . ': ' . $this->title . ' - ' . $this->message);
        }
    }

    protected function sendWebPush(): void
    {
        foreach ($this->recipientIds as $userId) {
            Log::info('[WebPush] User ' . $userId . ': ' . $this->title);
        }
    }
}

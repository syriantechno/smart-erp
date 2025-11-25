<?php

namespace App\Notifications;

use App\Models\Work\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class TaskStatusChangedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected Task $task;
    protected string $oldStatus;
    protected string $newStatus;
    protected string $changedByName;

    public function __construct(Task $task, string $oldStatus, string $newStatus, string $changedByName)
    {
        $this->task = $task;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
        $this->changedByName = $changedByName;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Task Status Updated: ' . $this->task->title)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line($this->changedByName . ' changed the status of a task you\'re watching.')
            ->line('**Task:** ' . $this->task->title)
            ->line('**Status:** ' . ucfirst(str_replace('_', ' ', $this->oldStatus)) . ' → ' . ucfirst(str_replace('_', ' ', $this->newStatus)))
            ->action('View Task', route('tasks.show', $this->task));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'task_status_changed',
            'task_id' => $this->task->id,
            'task_code' => $this->task->code,
            'task_title' => $this->task->title,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'changed_by' => $this->changedByName,
            'message' => "{$this->changedByName} changed task status to " . ucfirst(str_replace('_', ' ', $this->newStatus)) . ": {$this->task->title}",
            'url' => route('tasks.show', $this->task),
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'type' => 'task_status_changed',
            'task_id' => $this->task->id,
            'task_title' => $this->task->title,
            'new_status' => $this->newStatus,
        ]);
    }
}

<?php

namespace App\Notifications;

use App\Models\Work\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class TaskAssignedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected Task $task;
    protected string $assignedByName;

    public function __construct(Task $task, string $assignedByName)
    {
        $this->task = $task;
        $this->assignedByName = $assignedByName;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database', 'broadcast'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Task Assigned: ' . $this->task->title)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line($this->assignedByName . ' has assigned you a new task.')
            ->line('**Task:** ' . $this->task->title)
            ->line('**Priority:** ' . ucfirst($this->task->priority))
            ->line('**Due Date:** ' . ($this->task->due_date ? $this->task->due_date->format('M d, Y') : 'Not set'))
            ->action('View Task', route('tasks.show', $this->task))
            ->line('Thank you for using Smart ERP!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'task_assigned',
            'task_id' => $this->task->id,
            'task_code' => $this->task->code,
            'task_title' => $this->task->title,
            'task_priority' => $this->task->priority,
            'assigned_by' => $this->assignedByName,
            'message' => $this->assignedByName . ' assigned you a task: ' . $this->task->title,
            'url' => route('tasks.show', $this->task),
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'type' => 'task_assigned',
            'task_id' => $this->task->id,
            'task_title' => $this->task->title,
            'message' => $this->assignedByName . ' assigned you a task: ' . $this->task->title,
        ]);
    }
}

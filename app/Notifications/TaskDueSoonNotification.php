<?php

namespace App\Notifications;

use App\Models\Work\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class TaskDueSoonNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected Task $task;
    protected int $daysUntilDue;

    public function __construct(Task $task, int $daysUntilDue)
    {
        $this->task = $task;
        $this->daysUntilDue = $daysUntilDue;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database', 'broadcast'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $urgency = $this->daysUntilDue <= 0 ? 'OVERDUE' : ($this->daysUntilDue === 1 ? 'Due Tomorrow' : "Due in {$this->daysUntilDue} days");
        
        return (new MailMessage)
            ->subject("Task {$urgency}: " . $this->task->title)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line("Your task is {$urgency}!")
            ->line('**Task:** ' . $this->task->title)
            ->line('**Due Date:** ' . $this->task->due_date->format('M d, Y'))
            ->line('**Priority:** ' . ucfirst($this->task->priority))
            ->action('View Task', route('tasks.show', $this->task))
            ->line('Please complete this task as soon as possible.');
    }

    public function toArray(object $notifiable): array
    {
        $message = $this->daysUntilDue <= 0 
            ? "Task overdue: {$this->task->title}"
            : ($this->daysUntilDue === 1 
                ? "Task due tomorrow: {$this->task->title}"
                : "Task due in {$this->daysUntilDue} days: {$this->task->title}");

        return [
            'type' => 'task_due_soon',
            'task_id' => $this->task->id,
            'task_code' => $this->task->code,
            'task_title' => $this->task->title,
            'days_until_due' => $this->daysUntilDue,
            'due_date' => $this->task->due_date->format('Y-m-d'),
            'message' => $message,
            'url' => route('tasks.show', $this->task),
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'type' => 'task_due_soon',
            'task_id' => $this->task->id,
            'task_title' => $this->task->title,
            'days_until_due' => $this->daysUntilDue,
        ]);
    }
}

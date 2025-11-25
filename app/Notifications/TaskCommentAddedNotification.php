<?php

namespace App\Notifications;

use App\Models\Work\Task;
use App\Models\Work\TaskComment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class TaskCommentAddedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected Task $task;
    protected TaskComment $comment;
    protected string $commenterName;

    public function __construct(Task $task, TaskComment $comment, string $commenterName)
    {
        $this->task = $task;
        $this->comment = $comment;
        $this->commenterName = $commenterName;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Comment on Task: ' . $this->task->title)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line($this->commenterName . ' commented on a task you\'re watching.')
            ->line('**Task:** ' . $this->task->title)
            ->line('**Comment:** ' . \Str::limit($this->comment->comment, 100))
            ->action('View Task', route('tasks.show', $this->task));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'task_comment_added',
            'task_id' => $this->task->id,
            'task_code' => $this->task->code,
            'task_title' => $this->task->title,
            'comment_id' => $this->comment->id,
            'comment_preview' => \Str::limit($this->comment->comment, 50),
            'commenter' => $this->commenterName,
            'message' => "{$this->commenterName} commented on: {$this->task->title}",
            'url' => route('tasks.show', $this->task),
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'type' => 'task_comment_added',
            'task_id' => $this->task->id,
            'task_title' => $this->task->title,
            'commenter' => $this->commenterName,
        ]);
    }
}

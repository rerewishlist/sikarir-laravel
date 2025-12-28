<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewForumNotification extends Notification
{
    use Queueable;

    private $forum;

    public function __construct($forum)
    {
        $this->forum = $forum;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'forum',
            'forum_id' => $this->forum->id,
            'judul' => $this->forum->judul,
            'content' => $this->forum->content,
            'created_at' => $this->forum->created_at,
        ];
    }
}

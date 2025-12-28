<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewMateriNotification extends Notification
{
    use Queueable;

    private $materi;

    public function __construct($materi)
    {
        $this->materi = $materi;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'materi',
            'materi_id' => $this->materi->id,
            'judul' => $this->materi->judul,
            'content' => $this->materi->content,
            'created_at' => $this->materi->created_at,
        ];
    }
}

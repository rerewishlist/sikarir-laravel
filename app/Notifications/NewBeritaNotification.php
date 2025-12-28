<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewBeritaNotification extends Notification
{
    use Queueable;

    private $berita;

    public function __construct($berita)
    {
        $this->berita = $berita;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'berita',
            'berita_id' => $this->berita->id,
            'slug' => $this->berita->slug,
            'judul' => $this->berita->judul,
            'content' => $this->berita->content,
            'created_at' => $this->berita->created_at,
        ];
    }
}

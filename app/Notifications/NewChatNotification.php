<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\Admin; // Assuming Admin model exists
use App\Models\User; // Assuming User model exists

class NewChatNotification extends Notification
{
    use Queueable;

    protected $chat;
    protected $from_name;

    public function __construct($chat)
    {
        $this->chat = $chat;
        $senderDetails = $this->getSenderDetails();
        $this->from_name = $senderDetails['from_name'];
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    protected function getSenderDetails()
    {
        $from_id = $this->chat->from_user_id ?? $this->chat->from_admin_id;
        if ($this->chat->from_user_id) {
            $user = User::find($from_id);
            return [
                'from_name' => $user->nama ?? 'Unknown',
            ];
        } else {
            $admin = Admin::find($from_id);
            return [
                'from_name' => $admin->nama ?? 'Unknown',
            ];
        }
    }

    public function toArray($notifiable)
    {
        return [
            'chat_id' => $this->chat->id,
            'message' => $this->chat->message,
            'from' => $this->chat->from_user_id ? 'Siswa' : 'Admin',
            'from_id' => $this->chat->from_user_id ?? $this->chat->from_admin_id,
            'to_id' => $this->chat->to_user_id ?? $this->chat->to_admin_id,
            'from_name' => $this->from_name,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'chat_id' => $this->chat->id,
            'message' => $this->chat->message,
            'from' => $this->chat->from_user_id ? 'Siswa' : 'Admin',
            'from_id' => $this->chat->from_user_id ?? $this->chat->from_admin_id,
            'to_id' => $this->chat->to_user_id ?? $this->chat->to_admin_id,
            'from_name' => $this->from_name,
        ]);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'nama',
        'username',
        'level',
        'password',
        'nohp',
        'foto',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function beritas()
    {
        return $this->hasMany(Berita::class);
    }

    public function materis()
    {
        return $this->hasMany(Materi::class);
    }

    public function fromChats()
    {
        return $this->hasMany(Chat::class, 'from_admin_id');
    }

    public function toChats()
    {
        return $this->hasMany(Chat::class, 'to_admin_id');
    }

    public function markNotificationAsRead($notificationId)
    {
        $this->notifications()->where('id', $notificationId)->update(['read_at' => now()]);
    }
}

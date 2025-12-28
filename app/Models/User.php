<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nis',
        'nama',
        'level',
        'password',
        'jurusan_id',
        'kelas',
        'subkelas',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'nohp',
        'foto',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function jurusans()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    public function fromChats()
    {
        return $this->hasMany(Chat::class, 'from_user_id');
    }

    public function toChats()
    {
        return $this->hasMany(Chat::class, 'to_user_id');
    }

    public function markNotificationAsRead($notificationId)
    {
        $this->notifications()->where('id', $notificationId)->update(['read_at' => now()]);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }
}

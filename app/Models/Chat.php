<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_admin_id',
        'from_user_id',
        'to_admin_id',
        'to_user_id',
        'message',
    ];

    public function fromAdmin()
    {
        return $this->belongsTo(Admin::class, 'from_admin_id');
    }

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function toAdmin()
    {
        return $this->belongsTo(Admin::class, 'to_admin_id');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $table = 'results';

    protected $fillable = [
        'user_id',
        'kode_riasec',
        'skor',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

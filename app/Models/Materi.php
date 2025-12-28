<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'deskripsi',
        'admin_id',
        'content',
        'file_pendukung',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}

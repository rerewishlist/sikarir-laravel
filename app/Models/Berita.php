<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'slug',
        'admin_id',
        'content',
        'gambar',
        'lokasi',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function kategoris()
    {
        return $this->belongsToMany(Kategori::class, 'berita_kategoris');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerSuggestion extends Model
{
    protected $table = 'career_suggestions';

    protected $fillable = [
        'kode_riasec',
        'karir',
        'deskripsi',
    ];
}

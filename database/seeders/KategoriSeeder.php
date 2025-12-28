<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kategoris = [
            'Software Development',
            'Cybersecurity',
            'Data Management and Analytics',
            'Networking and Infrastructure',
            'Digital Product Development',
            'Artificial Intelligence & Machine Learning',
            'Blockchain',
            'Industri Kreatif dan Multimedia',
            'Tech Education and Training',
            'Perkuliahan',
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create([
                'nama' => $kategori,
                'slug' => Str::slug($kategori),
            ]);
        }
    }
}

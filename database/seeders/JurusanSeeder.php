<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jurusan = [
            ['nama' => 'Rekayasa Perangkat Lunak', 'deskripsi' => 'Jurusan yang memfokuskan pada pengembangan perangkat lunak.'],
        ];
        // $jurusan = [
        //     ['nama' => 'Rekayasa Perangkat Lunak', 'deskripsi' => 'Jurusan yang memfokuskan pada pengembangan perangkat lunak.'],
        //     ['nama' => 'Multimedia', 'deskripsi' => 'Jurusan  yang mengajarkan tentang desain grafis dan multimedia.'],
        //     ['nama' => 'Teknik Komputer dan Jaringan', 'deskripsi' => 'Jurusan yang fokus pada teknik komputer dan jaringan.'],
        //     ['nama' => 'Animasi', 'deskripsi' => 'Jurusan yang mengajarkan tentang pembuatan animasi dan efek visual.'],
        //     ['nama' => 'Tata Busana', 'deskripsi' => 'Jurusan yang mempelajari desain dan produksi busana.'],
        //     ['nama' => 'Kriya Kayu', 'deskripsi' => 'Jurusan yang fokus pada kerajinan dan seni kayu.'],
        //     ['nama' => 'Kriya Keramik', 'deskripsi' => 'Jurusan yang mempelajari seni dan kerajinan keramik.'],
        //     ['nama' => 'Kriya Tekstil', 'deskripsi' => 'Jurusan yang fokus pada seni dan kerajinan tekstil.'],
        // ];

        // Insert data ke dalam tabel 'jurusans'
        DB::table('jurusans')->insert($jurusan);
    }
}

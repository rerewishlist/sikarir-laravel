<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Informasi;
use Illuminate\Database\Seeder;

class InformasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $informasi = [
            'instansi' => 'SMKN 5 Malang',
            'alamat' => 'Jl. Terusan Ikan Piranha Atas No.50, Tunjungsekar, Kec. Lowokwaru, Kota Malang, Jawa Timur 65142',
            'nohp' => '0341478195',
            'email' => 'smkn5malang@gmail.com',
            'deskripsi' => 'SMK Negeri 5 malang berdiri pada tahun 1998 di atas tanah seluas 13.816 m2  dengan luas bangunan 3.343 m2 terletak di lokasi strategis dalam wilayah Kota Malang.',
            'videoyt' => 'https://www.youtube.com/watch?v=JseutjhRdB4',
            'facebook' => 'smkn5malang',
            'instagram' => 'smkn.5.malang',
            'twitter' => 'smkn5malang',
            'youtube' => 'SMKN5MALANG-VH5',
            'tiktok' => 'smkn5malang',
        ];
    }
}

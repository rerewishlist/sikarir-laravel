<?php

namespace Database\Seeders;

use App\Models\Materi;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class MateriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        $admins = [1, 2, 3, 4, 5];

        // Daftar kata untuk judul
        $judulKata = ['Materi', 'Bimbingan', 'Konseling', 'Karir', 'Mental', 'Health', 'Sosial', 'Pendidikan'];
        // Daftar kalimat untuk konten
        $kontenKalimat = [
            'Ini adalah contoh konten materi.',
            'Konten ini berisi materi terbaru.',
            'Anda dapat menemukan detail lebih lanjut di sini.',
            'Materi ini sangat penting untuk diketahui.',
            'Kami akan terus mengabari Anda dengan materi terbaru.',
            'Pastikan untuk mengikuti perkembangan materi terbaru.',
            'Terima kasih telah membaca materi ini.',
            'Materi ini sangat bermanfaat.',
            'Tetap terhubung untuk update materi selanjutnya.'
        ];

        for ($i = 1; $i <= 4; $i++) {
            $judul = implode(' ', $faker->randomElements($judulKata, 3));

            // Membuat konten dengan panjang sekitar 10,000 karakter
            $deskripsi = '';
            while (strlen($deskripsi) < 50) {
                $deskripsi .= ' ' . $faker->randomElement($kontenKalimat);
            }
            $deskripsi = substr($deskripsi, 0, 50); // Memastikan panjang konten tidak melebihi 10,000 karakter

            // Membuat konten dengan panjang sekitar 10,000 karakter
            $content = '';
            while (strlen($content) < 1500) {
                $content .= ' ' . $faker->randomElement($kontenKalimat);
            }
            $content = substr($content, 0, 1500); // Memastikan panjang konten tidak melebihi 10,000 karakter

            Materi::create([
                'judul' => $judul,
                'deskripsi' => $deskripsi,
                'admin_id' => $faker->randomElement($admins),
                'content' => $content,
                'file_pendukung' => null,  // Mengatur gambar menjadi null
                'created_at' => $faker->dateTimeBetween('2023-01-01', '2023-12-31'),  // Tanggal acak dalam tahun yang sama
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}

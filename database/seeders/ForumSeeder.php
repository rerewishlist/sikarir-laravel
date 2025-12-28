<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ForumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID'); // Menggunakan locale Indonesia

        // Daftar kata untuk judul
        $judulKata = ['Sekolah', 'Pengumuman', 'Acara', 'Event', 'Artikel', 'Teknologi', 'Kegiatan', 'Sosial', 'Pendidikan', 'Webinar'];
        // Daftar kalimat untuk konten
        $kontenKalimat = [
            'Ini adalah contoh konten berita.',
            'Konten ini berisi informasi terbaru.',
            'Anda dapat menemukan detail lebih lanjut di sini.',
            'Berita ini sangat penting untuk diketahui.',
            'Kami akan terus mengabari Anda dengan informasi terbaru.',
            'Pastikan untuk mengikuti perkembangan terbaru.',
            'Event ini akan diadakan dalam waktu dekat.',
            'Terima kasih telah membaca berita ini.',
            'Informasi ini sangat bermanfaat.',
            'Tetap terhubung untuk update selanjutnya.'
        ];

        for ($i = 0; $i < 20; $i++) {
            $judul = implode(' ', $faker->randomElements($judulKata, 3));

            // Membuat konten dengan panjang sekitar 10,000 karakter
            $content = '';
            while (strlen($content) < 2500) {
                $content .= ' ' . $faker->randomElement($kontenKalimat);
            }
            $content = substr($content, 0, 2500); // Memastikan panjang konten tidak melebihi 10,000 karakter

            $adminOrUser = $faker->boolean; // 50% kemungkinan

            DB::table('forums')->insert([
                'admin_id' => $adminOrUser ? $faker->randomElement(DB::table('admins')->pluck('id')->toArray()) : null,
                'user_id' => !$adminOrUser ? $faker->randomElement(DB::table('users')->pluck('id')->toArray()) : null,
                'judul' => $judul,
                'gambar' => null,
                'content' => $content,
                'created_at' => $faker->dateTimeBetween('2023-01-01', '2023-12-31'),  // Tanggal acak dalam tahun yang sama
                'updated_at' => now(),
            ]);
        }
    }
}

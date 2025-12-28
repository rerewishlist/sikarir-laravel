<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Berita;
use App\Models\Kategori;
use Carbon\Carbon;
use Faker\Factory as Faker;

class BeritaSeeder extends Seeder
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
        $kategoriNames = Kategori::pluck('nama')->toArray();

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

        for ($i = 1; $i <= 50; $i++) {
            $judul = implode(' ', $faker->randomElements($judulKata, 3));

            // Membuat konten dengan panjang sekitar 10,000 karakter
            $content = '';
            while (strlen($content) < 2500) {
                $content .= ' ' . $faker->randomElement($kontenKalimat);
            }
            $content = substr($content, 0, 2500); // Memastikan panjang konten tidak melebihi 10,000 karakter

            $berita = Berita::create([
                'judul' => $judul,
                'slug' => Str::slug($judul),
                'admin_id' => $faker->randomElement($admins),
                'content' => $content,
                'gambar' => null,  // Mengatur gambar menjadi null
                'lokasi' => $faker->city,
                'created_at' => $faker->dateTimeBetween('2023-01-01', '2023-12-31'),  // Tanggal acak dalam tahun yang sama
                'updated_at' => Carbon::now(),
            ]);

            $kategoriIds = Kategori::whereIn('nama', $faker->randomElements($kategoriNames, rand(1, 3)))->pluck('id')->toArray();
            $berita->kategoris()->sync($kategoriIds);
        }
    }


    // Input Manual
    // $beritas = [
    //     [
    //         'judul' => 'Berita Acara Sekolah',
    //         'admin_id' => 1,
    //         'content' => 'Isi berita acara sekolah...',
    //         'gambar' => 'gambar1.jpg',
    //         'lokasi' => 'Sekolah',
    //         'kategori' => ['Berita Acara', 'Pengumuman'],
    //     ],
    //     [
    //         'judul' => 'Pengumuman Libur',
    //         'admin_id' => 1,
    //         'content' => 'Isi pengumuman libur...',
    //         'gambar' => 'gambar2.jpg',
    //         'lokasi' => 'Sekolah',
    //         'kategori' => ['Pengumuman'],
    //     ],
    // ];

    // foreach ($beritas as $data) {
    //     $berita = Berita::create([
    //         'judul' => $data['judul'],
    //         'slug' => Str::slug($data['judul']),
    //         'admin_id' => $data['admin_id'],
    //         'content' => $data['content'],
    //         'gambar' => $data['gambar'],
    //         'lokasi' => $data['lokasi'],
    //     ]);
    //     $kategoriIds = Kategori::whereIn('nama', $data['kategori'])->pluck('id')->toArray();
    //     $berita->kategoris()->sync($kategoriIds);
    // }
}

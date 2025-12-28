<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID'); // Menggunakan locale Indonesia

        // Ambil semua ID forum yang ada
        $forumIds = DB::table('forums')->pluck('id')->toArray();
        $userIds = DB::table('users')->pluck('id')->toArray();
        $adminIds = DB::table('admins')->pluck('id')->toArray();

        foreach ($forumIds as $forumId) {
            // Menentukan jumlah komentar untuk setiap forum
            $numComments = rand(1, 20); // Misalnya, 1-5 komentar per forum

            for ($i = 0; $i < $numComments; $i++) {
                // Pilih secara acak apakah komentar berasal dari admin atau user
                $isAdminComment = $faker->boolean;

                DB::table('comments')->insert([
                    'forum_id' => $forumId,
                    'admin_id' => $isAdminComment ? $faker->randomElement($adminIds) : null,
                    'user_id' => !$isAdminComment ? $faker->randomElement($userIds) : null,
                    'body' => $faker->text(200), // Panjang teks komentar
                    'created_at' => $faker->dateTimeBetween('2023-01-01', '2023-12-31'),  // Tanggal acak dalam tahun yang sama
                    'updated_at' => now(),
                ]);
            }
        }
    }
}

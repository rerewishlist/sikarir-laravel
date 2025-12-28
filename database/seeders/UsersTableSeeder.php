<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use App\Models\Jurusan;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            DB::table('users')->insert([
                'nis' => $faker->unique()->randomNumber($nbDigits = 8),
                'nama' => $faker->name,
                'level' => 'siswa',
                'password' => Hash::make('123'), // Set password statis
                'jurusan_id' => Jurusan::inRandomOrder()->first()->id, // Ambil ID jurusan secara acak
                'kelas' => $faker->numberBetween($min = 10, $max = 12),
                'subkelas' => $faker->randomElement(['A', 'B', 'C']),
                'jenis_kelamin' => $faker->randomElement(['L', 'P']),
                'tempat_lahir' => $faker->city,
                'tanggal_lahir' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'alamat' => $faker->address,
                'nohp' => '08' . $faker->numerify('##########'),
                'foto' => null, // jika Anda tidak ingin menyertakan foto
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

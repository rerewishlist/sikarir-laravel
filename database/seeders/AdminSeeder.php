<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $admins = [
            [
                'nama' => 'Muhammad Raihansyah Firdaus',
                'username' => 'admin1',
                'password' => Hash::make('admin123'),
                'nohp' => '089' . $faker->numerify('#########'),
                'level' => 'admin',
                'foto' => null,
                'remember_token' => null,
            ],
            [
                'nama' => $faker->name,
                'username' => 'admin2',
                'password' => Hash::make('admin123'),
                'nohp' => '089' . $faker->numerify('#########'),
                'level' => 'admin',
                'foto' => null,
                'remember_token' => null,
            ],
            [
                'nama' => $faker->name,
                'username' => 'admin3',
                'password' => Hash::make('admin123'),
                'nohp' => '089' . $faker->numerify('#########'),
                'level' => 'admin',
                'foto' => null,
                'remember_token' => null,
            ],
            [
                'nama' => $faker->name,
                'username' => 'admin4',
                'password' => Hash::make('admin123'),
                'nohp' => '089' . $faker->numerify('#########'),
                'level' => 'admin',
                'foto' => null,
                'remember_token' => null,
            ],
            [
                'nama' => $faker->name,
                'username' => 'admin5',
                'password' => Hash::make('admin123'),
                'nohp' => '089' . $faker->numerify('#########'),
                'level' => 'admin',
                'foto' => null,
                'remember_token' => null,
            ],
        ];

        foreach ($admins as $admin) {
            Admin::create($admin);
        }
    }
}

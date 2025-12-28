<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(JurusanSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(KategoriSeeder::class);
        $this->call(BeritaSeeder::class);
        $this->call(ForumSeeder::class);
        $this->call(CommentSeeder::class);
        // $this->call(MateriSeeder::class);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}

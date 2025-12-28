<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CareerSuggestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('career_suggestions')->insert([
        ['kode_riasec' => 'R', 'karir' => 'Network engineer, teknisi komputer, teknisi jaringan, support hardware, IT helpdesk', 'deskripsi' => 'Suka kerja teknis seperti instalasi hardware, jaringan, atau perakitan komputer.'],
        ['kode_riasec' => 'I', 'karir' => 'Software developer, data analyst, AI engineer, machine learning engineer, QA tester', 'deskripsi' => 'Suka coding, debugging, mencari solusi masalah program, eksplorasi teknologi baru.'],
        ['kode_riasec' => 'A', 'karir' => 'UI/UX designer, game developer, graphic designer, multimedia specialist, web designer', 'deskripsi' => 'Suka mendesain UI/UX, membuat ilustrasi, animasi, video, atau konten digital.'],
        ['kode_riasec' => 'S', 'karir' => 'IT trainer, technical writer, project coordinator, customer support, community manager', 'deskripsi' => 'Suka berbagi pengetahuan coding, mendampingi teman, bekerja tim, membuat tutorial.'],
        ['kode_riasec' => 'E', 'karir' => 'Startup founder, product manager, IT consultant, sales engineer, bisnis digital', 'deskripsi' => 'Suka memimpin tim proyek, presentasi ide, mencari peluang bisnis di bidang IT.'],
        ['kode_riasec' => 'C', 'karir' => 'Database administrator, IT administrator, sistem analis, technical document specialist, data entry', 'deskripsi' => 'Suka mengorganisir file, membuat laporan, mengelola database, dokumentasi teknis.'],
    ]);
    }
}

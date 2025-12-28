<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('questions')->insert([
        ['kode_riasec' => 'R', 'faktor' => 'realistic', 'pertanyaan' => 'Saya senang memperbaiki komputer/laptop yang rusak.'],
        ['kode_riasec' => 'R', 'faktor' => 'realistic', 'pertanyaan' => 'Saya suka merakit komputer dan meng-upgrade komponen.'],
        ['kode_riasec' => 'R', 'faktor' => 'realistic', 'pertanyaan' => 'Saya tertarik memasang dan mengatur jaringan LAN/WiFi.'],
        ['kode_riasec' => 'R', 'faktor' => 'realistic', 'pertanyaan' => 'Saya suka mencoba instal ulang OS atau aplikasi.'],
        ['kode_riasec' => 'R', 'faktor' => 'realistic', 'pertanyaan' => 'Saya senang mengatur kabel, server, atau peralatan jaringan.'],
        ['kode_riasec' => 'R', 'faktor' => 'realistic', 'pertanyaan' => 'Saya tertarik mencoba perangkat baru seperti router, Raspberry Pi, Arduino.'],
        ['kode_riasec' => 'I', 'faktor' => 'investigative', 'pertanyaan' => 'Saya suka memecahkan masalah error atau bug dalam program.'],
        ['kode_riasec' => 'I', 'faktor' => 'investigative', 'pertanyaan' => 'Saya tertarik belajar bahasa pemrograman baru.'],
        ['kode_riasec' => 'I', 'faktor' => 'investigative', 'pertanyaan' => 'Saya senang mencari tahu cara kerja algoritma.'],
        ['kode_riasec' => 'I', 'faktor' => 'investigative', 'pertanyaan' => 'Saya suka melakukan debugging untuk mencari kesalahan program.'],
        ['kode_riasec' => 'I', 'faktor' => 'investigative', 'pertanyaan' => 'Saya tertarik belajar AI, machine learning, atau data science.'],
        ['kode_riasec' => 'I', 'faktor' => 'investigative', 'pertanyaan' => 'Saya menikmati membaca artikel atau buku pemrograman.'],
        ['kode_riasec' => 'A', 'faktor' => 'artistic', 'pertanyaan' => 'Saya senang mendesain antarmuka aplikasi atau website.'],
        ['kode_riasec' => 'A', 'faktor' => 'artistic', 'pertanyaan' => 'Saya suka membuat animasi, ilustrasi digital, atau desain grafis.'],
        ['kode_riasec' => 'A', 'faktor' => 'artistic', 'pertanyaan' => 'Saya tertarik membuat game sederhana.'],
        ['kode_riasec' => 'A', 'faktor' => 'artistic', 'pertanyaan' => 'Saya senang membuat proyek kreatif di GitHub/media sosial.'],
        ['kode_riasec' => 'A', 'faktor' => 'artistic', 'pertanyaan' => 'Saya menikmati eksperimen dengan warna, font, dan layout.'],
        ['kode_riasec' => 'A', 'faktor' => 'artistic', 'pertanyaan' => 'Saya suka membuat video, konten media, atau musik digital.'],
        ['kode_riasec' => 'S', 'faktor' => 'social', 'pertanyaan' => 'Saya senang membantu teman memahami materi coding.'],
        ['kode_riasec' => 'S', 'faktor' => 'social', 'pertanyaan' => 'Saya suka mengajarkan teman membuat aplikasi sederhana.'],
        ['kode_riasec' => 'S', 'faktor' => 'social', 'pertanyaan' => 'Saya tertarik ikut lomba coding/hackathon bersama tim.'],
        ['kode_riasec' => 'S', 'faktor' => 'social', 'pertanyaan' => 'Saya senang berdiskusi dan berbagi ide pemrograman.'],
        ['kode_riasec' => 'S', 'faktor' => 'social', 'pertanyaan' => 'Saya suka membuat dokumentasi/tutorial.'],
        ['kode_riasec' => 'S', 'faktor' => 'social', 'pertanyaan' => 'Saya tertarik bekerja di tim mengembangkan proyek.'],
        ['kode_riasec' => 'E', 'faktor' => 'enterprising', 'pertanyaan' => 'Saya tertarik membuat aplikasi untuk dijual.'],
        ['kode_riasec' => 'E', 'faktor' => 'enterprising', 'pertanyaan' => 'Saya suka memimpin tim proyek TI.'],
        ['kode_riasec' => 'E', 'faktor' => 'enterprising', 'pertanyaan' => 'Saya senang mempresentasikan ide aplikasi/website.'],
        ['kode_riasec' => 'E', 'faktor' => 'enterprising', 'pertanyaan' => 'Saya bermimpi membangun startup teknologi.'],
        ['kode_riasec' => 'E', 'faktor' => 'enterprising', 'pertanyaan' => 'Saya tertarik mencari peluang bisnis IT.'],
        ['kode_riasec' => 'E', 'faktor' => 'enterprising', 'pertanyaan' => 'Saya senang ikut lomba wirausaha atau ide bisnis.'],
        ['kode_riasec' => 'C', 'faktor' => 'conventional', 'pertanyaan' => 'Saya senang membuat dokumentasi teknis.'],
        ['kode_riasec' => 'C', 'faktor' => 'conventional', 'pertanyaan' => 'Saya suka mengorganisir file proyek.'],
        ['kode_riasec' => 'C', 'faktor' => 'conventional', 'pertanyaan' => 'Saya tertarik mempelajari database.'],
        ['kode_riasec' => 'C', 'faktor' => 'conventional', 'pertanyaan' => 'Saya senang membuat laporan hasil kerja.'],
        ['kode_riasec' => 'C', 'faktor' => 'conventional', 'pertanyaan' => 'Saya teliti dalam menulis kode yang rapi.'],
        ['kode_riasec' => 'C', 'faktor' => 'conventional', 'pertanyaan' => 'Saya tertarik mengelola data & membuat laporan otomatis.'],
    ]);
    }
}

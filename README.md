# SIKARIR – Sistem Informasi Karier

**SIKARIR** adalah sebuah platform berbasis web yang dirancang untuk membantu siswa Sekolah Menengah Kejuruan (SMK) dalam mengeksplorasi, merencanakan, dan mempersiapkan karier mereka secara mandiri, kapan saja dan di mana saja.

Platform ini berfokus pada penyediaan informasi karier serta layanan konsultasi, khususnya bagi siswa jurusan **Pengembangan Perangkat Lunak dan Gim (PPLG)**.  
SIKARIR dapat diakses melalui **komputer, laptop, maupun smartphone**, sehingga mendukung fleksibilitas penggunaan bagi siswa dan guru.

---

## 🎯 Tujuan Pengembangan
SIKARIR dikembangkan untuk:
- Membantu siswa SMK memahami pilihan karier dan pendidikan lanjutan
- Menyediakan ruang konsultasi karier antara siswa dan guru
- Memberikan akses informasi karier yang mudah, terpusat, dan berkelanjutan

---

## 🛠️ Tech Stack
- Laravel
- PHP
- MySQL
- HTML, CSS, JavaScript
- Bootstrap *(jika digunakan)*

---

## ✨ Fitur Utama

SIKARIR menyediakan beberapa fitur inti, antara lain:
1. **Berita (News)**  
   Menyajikan informasi terbaru seputar dunia kerja, peluang karier, serta pendidikan lanjutan.
2. **Forum Diskusi**  
   Wadah diskusi antara guru dan siswa untuk membahas topik karier, pendidikan, dan pengembangan diri.
3. **Chat Konsultasi**  
   Fitur komunikasi satu lawan satu antara siswa dan guru untuk konsultasi karier secara langsung.
4. **Tes Minat Karier**  
   Tes minat karier berbasis teori **RIASEC** dari *Dr. John L. Holland* untuk membantu siswa mengenali kecenderungan minat dan kepribadian mereka.

---

## 🧠 Metode RIASEC

RIASEC merupakan teori minat karier yang mengelompokkan kepribadian ke dalam enam tipe utama:

- **R – Realistic** (Praktis)  
- **I – Investigative** (Analitis)  
- **A – Artistic** (Kreatif)  
- **S – Social** (Berorientasi pada interaksi sosial)  
- **E – Enterprising** (Persuasif dan kepemimpinan)  
- **C – Conventional** (Terstruktur dan terorganisir)

Metode ini digunakan untuk membantu siswa memahami kecocokan minat mereka dengan pilihan karier yang tersedia.

---

## 🔗 Project Links
- Repository GitHub: https://github.com/rerewishlist/sikarir-laravel  
- Demo Aplikasi: *Coming Soon*

---

## ⚙️ Instalasi (Local Development)

```bash
git clone https://github.com/USERNAME_GITHUB/sikarir-laravel
cd sikarir-laravel
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve

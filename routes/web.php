<?php

use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileAdminController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AdminController;

use App\Http\Controllers\ForumController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\JurusanController;
// use App\Http\Controllers\MateriController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TesMinatController;
use App\Http\Livewire\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [GuestController::class, 'landing'])->name('landing');
Route::get('/berita', [GuestController::class, 'berita'])->name('berita.menu');
Route::get('/berita/{slug}', [GuestController::class, 'beritaDetail'])->name('berita.detail.menu');
Route::get('/forum', [GuestController::class, 'forum'])->name('forum.menu');
Route::get('/contact', [GuestController::class, 'contact'])->name('contact.menu');
Route::get('/perusahaan', [GuestController::class, 'perusahaan'])->name('perusahaan.menu');

Route::prefix('siswa')->middleware('auth', 'nocache')->group(function () {
    Route::get('/dashboard', [GuestController::class, 'landing'])->name('dashboard'); //clear

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/password', [PasswordController::class, 'edit'])->name('password.edit');

    // Route::get('/materi', [MateriController::class, 'index'])->name('user.materi');
    // Route::get('/materi/detail/{id}', [MateriController::class, 'detail'])->name('user.materi.detail');

    Route::get('/forum', [ForumController::class, 'index'])->name('user.dataforum.view'); //clear
    Route::get('/forum/create', [ForumController::class, 'create'])->name('user.dataforum.create'); //clear
    Route::post('/forum/store', [ForumController::class, 'store'])->name('user.dataforum.store'); //clear
    Route::get('/forum/detail/{id}', [ForumController::class, 'detail'])->name('user.dataforum.detail'); //clear

    Route::get('/berita', [GuestController::class, 'berita'])->name('user.berita.view'); //clear
    Route::get('/berita/{slug}', [GuestController::class, 'beritaDetail'])->name('user.berita.detail'); //clear

    Route::get('/perusahaan', [GuestController::class, 'perusahaan'])->name('user.perusahaan.view'); //clear

    // Menampilkan halaman tes minat
    Route::get('/tes-minat', [TesMinatController::class, 'index'])->name('tes-minat.index');
    // Menyimpan jawaban
    Route::post('/tes-minat', [TesMinatController::class, 'store'])->name('tes-minat.store');
    // Menampilkan hasil
    Route::get('/tes-minat/hasil', [TesMinatController::class, 'hasil'])->name('tes-minat.hasil');
    // Menghapus hasil
    Route::delete('/tes-minat/ulang', [TesMinatController::class, 'ulangTes'])->name('tes-minat.ulang');


    Route::post('/datacomment/store/{forum}', [CommentController::class, 'store'])->name('user.datacomment.store'); //clear

    Route::get('/chat', [AdminController::class, 'index'])->name('user.chat.view'); //clear
    Route::get('/chat/{id}', [ChatController::class, 'detail'])->name('user.chat.detail'); //clear
    Route::post('/chat/{id}', [ChatController::class, 'store'])->name('user.chat.store'); //clear

    Route::get('/notifications', [NotificationController::class, 'index'])->name('user.notifications.view');
});

require __DIR__ . '/auth.php';


Route::prefix('admin')->middleware('auth:admin', 'nocache')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/profile', [ProfileAdminController::class, 'edit'])->name('profile.admin.edit');
    Route::patch('/profile', [ProfileAdminController::class, 'update'])->name('profile.admin.update');
    Route::delete('/profile', [ProfileAdminController::class, 'destroy'])->name('profile.destroy');

    Route::get('/informasi', [InformasiController::class, 'edit'])->name('informasi.edit');
    Route::post('/informasi/create', [InformasiController::class, 'store'])->name('informasi.create');
    Route::patch('/informasi/update', [InformasiController::class, 'update'])->name('informasi.update');

    Route::get('/datasiswa', [SiswaController::class, 'index'])->name('datasiswa.view');
    Route::post('/adddatasiswa', [SiswaController::class, 'store'])->name('datasiswa.store');
    Route::post('/uploaddatasiswa', [SiswaController::class, 'upload'])->name('datasiswa.upload');
    Route::put('/editdatasiswa/{id}', [SiswaController::class, 'update'])->name('datasiswa.update');
    Route::delete('/deletedatasiswa/{id}', [SiswaController::class, 'destroy'])->name('datasiswa.destroy');

    Route::get('/dataadmin', [AdminController::class, 'index'])->name('dataadmin.view');
    Route::post('/adddataadmin', [AdminController::class, 'store'])->name('dataadmin.store');
    Route::put('/editdataadmin/{id}', [AdminController::class, 'update'])->name('dataadmin.update');
    Route::delete('/deletedataadmin/{id}', [AdminController::class, 'destroy'])->name('dataadmin.destroy');

    Route::get('/datajurusan', [JurusanController::class, 'index'])->name('datajurusan.view');
    Route::post('/datajurusan/store', [JurusanController::class, 'store'])->name('datajurusan.store');
    Route::put('/datajurusan/update/{id}', [JurusanController::class, 'update'])->name('datajurusan.update');
    Route::delete('/datajurusan/delete/{id}', [JurusanController::class, 'destroy'])->name('datajurusan.destroy');

    Route::get('/datakategori', [KategoriController::class, 'index'])->name('datakategori.view');
    Route::post('/datakategori/store', [KategoriController::class, 'store'])->name('datakategori.store');
    Route::put('/datakategori/update/{id}', [KategoriController::class, 'update'])->name('datakategori.update');
    Route::delete('/datakategori/delete/{id}', [KategoriController::class, 'destroy'])->name('datakategori.destroy');

    Route::get('/databerita', [BeritaController::class, 'index'])->name('databerita.view');
    Route::get('/databerita/create', [BeritaController::class, 'create'])->name('databerita.create');
    Route::post('/databerita/store', [BeritaController::class, 'store'])->name('databerita.store');
    Route::get('/databerita/detail/{id}', [BeritaController::class, 'detail'])->name('databerita.detail');
    Route::get('/databerita/edit/{id}', [BeritaController::class, 'edit'])->name('databerita.edit');
    Route::put('/databerita/update/{id}', [BeritaController::class, 'update'])->name('databerita.update');
    Route::delete('/deleteberita/{id}', [BeritaController::class, 'destroy'])->name('databerita.destroy');

    Route::get('/dataforum', [ForumController::class, 'index'])->name('admin.dataforum.view');
    Route::get('/dataforum/create', [ForumController::class, 'create'])->name('admin.dataforum.create');
    Route::post('/dataforum/store', [ForumController::class, 'store'])->name('admin.dataforum.store');
    Route::get('/dataforum/detail/{id}', [ForumController::class, 'detail'])->name('admin.dataforum.detail');
    Route::get('/dataforum/edit/{id}', [ForumController::class, 'edit'])->name('admin.dataforum.edit');
    Route::put('/dataforum/update/{id}', [ForumController::class, 'update'])->name('dataforum.update');
    Route::delete('/dataforum/{id}', [ForumController::class, 'destroy'])->name('dataforum.destroy');

    Route::post('/datacomment/store/{forum}', [CommentController::class, 'store'])->name('admin.datacomment.store');

    Route::get('/chat', [ChatController::class, 'index'])->name('admin.chat.view');
    Route::get('/chat/{id}', [ChatController::class, 'detail'])->name('admin.chat.detail');
    Route::post('/chat/{id}', [ChatController::class, 'store'])->name('admin.chat.store');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('admin.notifications.view');
});


require __DIR__ . '/adminauth.php';

// Route::get('/chat/{user}', Chat::class)->name('chat');

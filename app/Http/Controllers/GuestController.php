<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Berita;
use App\Models\Kategori;
use App\Models\Forum;
use App\Models\Perusahaan;
use App\Models\Informasi;
use App\Models\Jurusan;
use App\Models\Materi;
use Illuminate\Support\Facades\Auth;

class GuestController extends Controller
{
    public function landing(Request $request)
    {
        $informasi = Informasi::first();

        $totalSiswa = User::where('level', 'siswa')->count();
        $totalBerita = Berita::all()->count();
        $totalJurusan = Jurusan::all()->count();
        $totalForum = Forum::all()->count();
        $totalMateri = Materi::all()->count();

        $beritas = Berita::orderBy('created_at', 'desc')->take(3)->get();
        $materis = Materi::orderBy('created_at', 'desc')->take(5)->get();

        // Inisialisasi variabel untuk notifikasi
        $beritaforummateriNotifications = collect();
        $chatNotifications = collect();

        // Periksa apakah pengguna sudah login
        if (auth()->check()) {
            $userNotif = auth()->user();

            // Ambil notifikasi berita dan forum
            $beritaforummateriNotifications = $userNotif->notifications()
                ->whereIn('type', ['App\Notifications\NewBeritaNotification', 'App\Notifications\NewForumNotification', 'App\Notifications\NewMateriNotification'])
                ->latest()
                ->take(5)
                ->get();

            // Ambil notifikasi chat
            $chatNotifications = $userNotif->notifications()
                ->where('type', 'App\Notifications\NewChatNotification')
                ->latest()
                ->get()
                ->unique('data.from_id');
        }

        return view('welcome', [
            'currentUser' => auth()->user(),
            'informasi' => $informasi,
            'totalSiswa' => $totalSiswa,
            'totalJurusan' => $totalJurusan,
            'totalBerita' => $totalBerita,
            'totalForum' => $totalForum,
            'totalMateri' => $totalMateri,
            'beritas' => $beritas,
            'materis' => $materis,
            'beritaforummateriNotifications' => $beritaforummateriNotifications,
            'chatNotifications' => $chatNotifications,
        ]);
    }

    public function berita(Request $request)
    {
        $informasi = Informasi::first();

        // Buat query untuk kategori
        $query = Berita::query();
        // Ambil daftar kategori
        $kategoris = Kategori::all();

        $search_berita = $request->input('search_berita');
        $filterTanggal = $request->input('filter_tanggal');

        // Filter berdasarkan judul berita
        if ($search_berita) {
            $query->where('judul', 'like', "%{$search_berita}%");
        }

        // Ambil tanggal unik dari kolom created_at
        $dates = Berita::selectRaw('DATE(created_at) as date')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->pluck('date')
            ->toArray();

        if ($filterTanggal) {
            list($year, $month) = explode('-', $filterTanggal);
            $query->whereYear('created_at', $year)
                ->whereMonth('created_at', $month);
        }

        // Cek apakah ada parameter kategori_id
        if ($request->has('kategori_id')) {
            $kategoriId = $request->get('kategori_id');

            // Filter berita berdasarkan kategori_id
            $query->whereHas('kategoris', function ($q) use ($kategoriId) {
                $q->where('kategoris.id', $kategoriId);
            });
        }

        // Dapatkan hasil pencarian dengan paginasi
        $beritas = $query->orderBy('created_at', 'desc')->paginate(10);


        // Inisialisasi variabel untuk notifikasi
        $beritaforummateriNotifications = collect();
        $chatNotifications = collect();

        // Periksa apakah pengguna sudah login
        if (auth()->check()) {
            $userNotif = auth()->user();

            // Ambil notifikasi berita dan forum
            $beritaforummateriNotifications = $userNotif->notifications()
                ->whereIn('type', ['App\Notifications\NewBeritaNotification', 'App\Notifications\NewForumNotification', 'App\Notifications\NewMateriNotification'])
                ->latest()
                ->take(5)
                ->get();

            // Ambil notifikasi chat
            $chatNotifications = $userNotif->notifications()
                ->where('type', 'App\Notifications\NewChatNotification')
                ->latest()
                ->get()
                ->unique('data.from_id');
        }

        return view('menu-berita', [
            'currentUser' => auth()->user(),
            'informasi' => $informasi,
            'dates' => $dates,
            'beritaforummateriNotifications' => $beritaforummateriNotifications,
            'chatNotifications' => $chatNotifications,
            'beritas' => $beritas,
            'kategoris' => $kategoris,
        ]);
    }

    public function beritaDetail($slug)
    {
        $informasi = Informasi::first();

        $berita = Berita::with('kategoris')->where('slug', $slug)->firstOrFail();

        $beritaNotifications = collect(); // Default sebagai koleksi kosong
        $beritaforummateriNotifications = collect(); // Default sebagai koleksi kosong
        $chatNotifications = collect(); // Default sebagai koleksi kosong

        // Periksa apakah pengguna sudah login
        if (auth()->check()) {
            $currentUser = auth()->user();

            // Menandai notifikasi berita sebagai sudah dibaca untuk pengirim yang sama
            $beritaNotifications = $currentUser->notifications()
                ->where('type', 'App\Notifications\NewBeritaNotification')
                ->whereNull('read_at') // Hanya yang belum dibaca
                ->where('data->slug', $slug)
                ->get();

            foreach ($beritaNotifications as $notification) {
                $notification->delete(); // Hapus notifikasi
            }

            // Ambil notifikasi berita dan forum
            $beritaforummateriNotifications = $currentUser->notifications()
                ->whereIn('type', ['App\Notifications\NewBeritaNotification', 'App\Notifications\NewForumNotification', 'App\Notifications\NewMateriNotification'])
                ->latest()
                ->take(5)
                ->get();

            // Ambil notifikasi chat
            $chatNotifications = $currentUser->notifications()
                ->where('type', 'App\Notifications\NewChatNotification')
                ->latest()
                ->get()
                ->unique('data.from_id');
        }

        return view('menu-berita-detail', [
            'currentUser' => auth()->user(),
            'informasi' => $informasi,
            'beritaforummateriNotifications' => $beritaforummateriNotifications,
            'chatNotifications' => $chatNotifications,
            'berita' => $berita,
        ]);
    }

    public function forum(Request $request)
    {
        $informasi = Informasi::first();

        // Buat query untuk kategori
        $query = Forum::query();

        $search_forum = $request->input('search_forum');
        // Filter berdasarkan judul berita
        if ($search_forum) {
            $query->where('judul', 'like', "%{$search_forum}%");
        }

        // Tambahkan eager loading untuk menghitung jumlah komentar
        $forums = $query->withCount('comments')
            ->orderBy('comments_count', 'desc') // Urutkan berdasarkan jumlah komentar
            ->orderBy('created_at', 'desc') // Urutkan berdasarkan tanggal dibuat sebagai cadangan
            ->paginate(10);

        return view('menu-forum', [
            'currentUser' => auth()->user(),
            'informasi' => $informasi,
            'forums' => $forums,
        ]);
    }

    public function contact(Request $request)
    {
        $informasi = Informasi::first();

        // Inisialisasi variabel untuk notifikasi
        $beritaforummateriNotifications = collect();
        $chatNotifications = collect();

        // Periksa apakah pengguna sudah login
        if (auth()->check()) {
            $userNotif = auth()->user();

            // Ambil notifikasi berita dan forum
            $beritaforummateriNotifications = $userNotif->notifications()
                ->whereIn('type', ['App\Notifications\NewBeritaNotification', 'App\Notifications\NewForumNotification', 'App\Notifications\NewMateriNotification'])
                ->latest()
                ->take(5)
                ->get();

            // Ambil notifikasi chat
            $chatNotifications = $userNotif->notifications()
                ->where('type', 'App\Notifications\NewChatNotification')
                ->latest()
                ->get()
                ->unique('data.from_id');
        }

        return view('menu-contact', [
            'currentUser' => auth()->user(),
            'beritaforummateriNotifications' => $beritaforummateriNotifications,
            'chatNotifications' => $chatNotifications,
            'informasi' => $informasi,
        ]);
    }

    public function perusahaan(Request $request)
    {
        $informasi = Informasi::first();

        // Buat query untuk kategori
        $query = Perusahaan::query();

        $search_perusahaan = $request->input('search_perusahaan');

        // Filter berdasarkan judul berita
        if ($search_perusahaan) {
            $query->where('nama_industri', 'like', "%{$search_perusahaan}%");
        }

        // Inisialisasi variabel untuk notifikasi
        $beritaforummateriNotifications = collect();
        $chatNotifications = collect();

        $search_forum = $request->input('search_forum');
        // Filter berdasarkan judul berita
        if ($search_forum) {
            $query->where('judul', 'like', "%{$search_forum}%");
        }

        // Periksa apakah pengguna sudah login
        if (auth()->check()) {
            $userNotif = auth()->user();

            // Ambil notifikasi berita dan forum
            $beritaforummateriNotifications = $userNotif->notifications()
                ->whereIn('type', ['App\Notifications\NewBeritaNotification', 'App\Notifications\NewForumNotification', 'App\Notifications\NewMateriNotification'])
                ->latest()
                ->take(5)
                ->get();

            // Ambil notifikasi chat
            $chatNotifications = $userNotif->notifications()
                ->where('type', 'App\Notifications\NewChatNotification')
                ->latest()
                ->get()
                ->unique('data.from_id');
        }

        $perusahaans = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('menu-perusahaan', [
            'currentUser' => auth()->user(),
            'informasi' => $informasi,
            'perusahaans' => $perusahaans,
            'beritaforummateriNotifications' => $beritaforummateriNotifications,
            'chatNotifications' => $chatNotifications,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Admin; // Assuming Admin model exists
use App\Models\User; // Assuming User model exists
use App\Models\Jurusan; // Assuming Jurusan model exists
use App\Models\Berita; // Assuming Berita model exists
use App\Models\Forum; // Assuming Forum model exists
use App\Models\Kategori; // Assuming Forum model exists
use App\Models\Materi;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalAdmin = Admin::where('level', 'admin')->count();
        $totalSiswa = User::where('level', 'siswa')->count();
        $totalMateri = Materi::count();
        $totalBerita = Berita::count();
        $totalForum = Forum::count();

        // Dapatkan ID admin yang sedang login
        $currentAdminId = auth()->user()->id;
        $query = User::join('jurusans', 'users.jurusan_id', '=', 'jurusans.id')
            ->select('users.*', 'jurusans.nama as nama_jurusan');
        // Tambahkan kondisi untuk memfilter users berdasarkan chat dengan admin yang sedang login
        $query->where(function ($q) use ($currentAdminId) {
            $q->whereIn('users.id', function ($subquery) use ($currentAdminId) {
                $subquery->select('to_user_id')
                    ->from('chats')
                    ->where('from_admin_id', $currentAdminId);
            })->orWhereIn('users.id', function ($subquery) use ($currentAdminId) {
                $subquery->select('from_user_id')
                    ->from('chats')
                    ->where('to_admin_id', $currentAdminId);
            });
        });
        $totalChatLive = $query->count();

        // Mengambil tiga berita terbaru
        $recentBerita = Berita::latest()->take(3)->get();

        // Mengumpulkan data jumlah siswa per kelas
        $siswaPerKelas = User::where('level', 'siswa')
            ->select('kelas', DB::raw('count(*) as total'))
            ->groupBy('kelas')
            ->pluck('total', 'kelas')
            ->toArray();

        // Mengumpulkan data jumlah siswa per jurusan
        $siswaPerJurusan = User::where('level', 'siswa')
            ->join('jurusans', 'users.jurusan_id', '=', 'jurusans.id')
            ->select('jurusans.nama as jurusan', DB::raw('count(*) as total'))
            ->groupBy('jurusans.nama')
            ->pluck('total', 'jurusan')
            ->toArray();

        // Mengumpulkan data aktivitas berita per bulan
        $beritaPerBulan = Berita::select(DB::raw('MONTH(created_at) as bulan'), DB::raw('count(*) as total'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('total', 'bulan')
            ->toArray();

        $forumPerBulan = Forum::select(DB::raw('MONTH(created_at) as bulan'), DB::raw('count(*) as total'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('total', 'bulan')
            ->toArray();

        //Filter
        $queryFilter = Berita::query();
        $kategoris = Kategori::all();

        $search_berita = $request->input('search_berita');
        $filterKategori = $request->input('filter_kategori');

        // Filter berdasarkan judul berita
        if ($search_berita) {
            $queryFilter->where('judul', 'like', "%{$search_berita}%");
        }
        // Filter berdasarkan kategori
        if ($filterKategori) {
            // Gunakan alias untuk kolom yang sama jika ada ambiguitas
            $queryFilter->whereHas('kategoris', function ($q) use ($filterKategori) {
                $q->where('kategoris.id', $filterKategori); // Gunakan alias tabel jika diperlukan
            });
        }

        // Mengambil notifikasi
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

        $allBerita = $queryFilter->orderBy('created_at', 'desc')->paginate(5);

        return view('dashboard', [
            'currentUser' => auth()->user(),
            'totalAdmin' => $totalAdmin,
            'totalSiswa' => $totalSiswa,
            'totalMateri' => $totalMateri,
            'totalBerita' => $totalBerita,
            'totalForum' => $totalForum,
            'totalChatLive' => $totalChatLive,
            'recentBerita' => $recentBerita,
            'siswaPerKelas' => $siswaPerKelas,
            'siswaPerJurusan' => $siswaPerJurusan,
            'beritaPerBulan' => $beritaPerBulan,
            'forumPerBulan' => $forumPerBulan,
            'allBerita' => $allBerita,
            'kategoris' => $kategoris,
            'beritaforummateriNotifications' => $beritaforummateriNotifications,
            'chatNotifications' => $chatNotifications,
        ]);
    }
}

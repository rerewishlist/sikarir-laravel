<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Berita;
use App\Models\Kategori;
use App\Models\User;
use App\Notifications\NewBeritaNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter pencarian dari request
        $search_berita = $request->input('search_berita');
        $filterTanggal = $request->input('filter_tanggal');
        $filterKategori = $request->input('filter_kategori');

        // Ambil tanggal unik dari kolom created_at
        $dates = Berita::selectRaw('DATE(created_at) as date')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->pluck('date')
            ->toArray();

        // Buat query untuk kategori
        $query = Berita::query();
        // Ambil daftar kategori
        $kategoris = Kategori::all();

        // Filter berdasarkan judul berita
        if ($search_berita) {
            $query->where('judul', 'like', "%{$search_berita}%");
        }

        if ($filterTanggal) {
            list($year, $month) = explode('-', $filterTanggal);
            $query->whereYear('created_at', $year)
                ->whereMonth('created_at', $month);
        }

        // Filter berdasarkan kategori
        if ($filterKategori) {
            // Gunakan alias untuk kolom yang sama jika ada ambiguitas
            $query->whereHas('kategoris', function ($q) use ($filterKategori) {
                $q->where('kategoris.id', $filterKategori); // Gunakan alias tabel jika diperlukan
            });
        }

        // Dapatkan hasil pencarian dengan paginasi
        $beritas = $query->orderBy('created_at', 'desc')->paginate(10);

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

        // Kirim data ke view
        return view('berita.data-berita', [
            'currentUser' => auth()->user(),
            'beritas' => $beritas,
            'dates' => $dates,
            'kategoris' => $kategoris,
            'beritaforummateriNotifications' => $beritaforummateriNotifications,
            'chatNotifications' => $chatNotifications,
        ]);
    }

    public function detail($id)
    {
        $berita = Berita::with('kategoris')->findOrFail($id);

        $currentUser = Auth::user();

        // Menandai notifikasi chat sebagai sudah dibaca untuk pengirim yang sama
        $beritaNotifications = $currentUser->notifications()
            ->where('type', 'App\Notifications\NewBeritaNotification')
            ->whereNull('read_at') // Hanya yang belum dibaca
            ->where('data->berita_id', $id)
            ->get();

        foreach ($beritaNotifications as $notification) {
            $notification->delete(); // Hapus notifikasi
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

        return view('berita.detail-berita', [
            'currentUser' => auth()->user(),
            'berita' => $berita,
            'beritaforummateriNotifications' => $beritaforummateriNotifications,
            'chatNotifications' => $chatNotifications,
        ]);
    }

    public function create()
    {
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

        return view('berita.modal.tambah', [
            'currentUser' => auth()->user(),
            'beritas' => Berita::paginate(10),
            'kategoris' => Kategori::all(),
            'admins' => Admin::all(),
            'beritaforummateriNotifications' => $beritaforummateriNotifications,
            'chatNotifications' => $chatNotifications,
        ]);
    }

//     public function store(Request $request)
//     {
//         // Ambil konten dari form
//         $content = $request->input('content');
    
//         // Cek apakah URL menggunakan https, dan tambahkan <a> jika ya
//         $content = preg_replace_callback(
//     '/(https:\/\/[^\s<]+)/',
//     function ($matches) {
//         $url = $matches[1];
//         return '<a href="' . $url . '" target="_blank" rel="noopener noreferrer">' . $url . '</a>';
//     },
//     $content
// );
    
//         // Bersihkan konten (jika perlu)
//         $content = $this->cleanQuillContent($content);
    
//         // Merger konten yang sudah dibersihkan dan ditambahkan <a> ke request
//         $request->merge(['content' => $content]);
    
//         // Validasi input
//         $request->validate([
//             'judul' => 'required|string|max:255',
//             'kategori_id' => 'required|array',
//             'kategori_id.*' => 'exists:kategoris,id',
//             'gambar' => 'required|image|mimes:jpeg,png,jpg,gif',
//             'content' => 'required|string',
//             'lokasi' => 'required|string',
//         ]);
    
//         $slug = $this->createSlug($request->judul);
    
//         // Simpan data berita
//         $berita = new Berita();
//         $berita->judul = $request->input('judul');
//         $berita->admin_id = Auth::id();
//         $berita->slug = $slug;
//         $berita->content = $request->input('content');
//         $berita->lokasi = $request->input('lokasi');
    
//         // Simpan foto jika ada
//         if ($request->hasFile('gambar')) {
//             $extension = $request->file('gambar')->getClientOriginalExtension();
//             $fotoName = $slug . '-' . Str::uuid() . '.' . $extension;
//             $request->file('gambar')->storeAs('public/berita', $fotoName);
//             $berita->gambar = $fotoName;
//         }
    
//         $berita->save();
    
//         // Sinkronkan kategori
//         $berita->kategoris()->sync($request->input('kategori_id'));
    
//         // Kirim notifikasi
//         $admins = Admin::all();
//         $users = User::all();
//         Notification::send($admins, new NewBeritaNotification($berita));
//         Notification::send($users, new NewBeritaNotification($berita));
    
//         // Redirect
//         return redirect()->route('databerita.view')->with('success', "Sukses menambah Berita $berita->judul !!!");
//     }
    
    public function store(Request $request)
    {
        $content = $this->cleanQuillContent($request->input('content'));

        $request->merge(['content' => $content]);
        // dd($request->all());
        // Validasi input
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori_id' => 'required|array',
            'kategori_id.*' => 'exists:kategoris,id',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif',
            'content' => 'required|string',
            'lokasi' => 'required|string',
        ]);

        $slug = $this->createSlug($request->judul);

        // Simpan data berita

        $berita = new Berita();
        $berita->judul = $request->input('judul');
        $berita->admin_id = Auth::id();
        $berita->slug = $slug;
        $berita->content = $request->input('content');
        $berita->lokasi = $request->input('lokasi');

        // Simpan foto jika ada
        if ($request->hasFile('gambar')) {
            // Buat nama file baru berdasarkan username dan waktu unggah
            $extension = $request->file('gambar')->getClientOriginalExtension();
            $fotoName = $slug . '-' . Str::uuid() . '.' . $extension;
            // Simpan foto dengan nama baru
            $request->file('gambar')->storeAs('public/berita', $fotoName);
            $berita->gambar = $fotoName;
        }

        $berita->save();

        // Sinkronkan kategori
        $berita->kategoris()->sync($request->input('kategori_id'));

        // Kirim notifikasi ke semua admin
        $admins = Admin::all();
        $users = User::all();
        Notification::send($admins, new NewBeritaNotification($berita));
        Notification::send($users, new NewBeritaNotification($berita));

        // Redirect dengan pesan sukses
        return redirect()->route('databerita.view')->with('success', "Sukses menambah Berita $berita->judul !!!");
    }

    public function edit($id)
    {
        $berita = Berita::findOrFail($id); // Mengambil data berita berdasarkan ID

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

        return view('berita.modal.edit', [
            'currentUser' => auth()->user(),
            'berita' => $berita,
            'kategoris' => Kategori::all(),
            'admins' => Admin::all(),
            'beritaforummateriNotifications' => $beritaforummateriNotifications,
            'chatNotifications' => $chatNotifications,
        ]);
    }

    public function update(Request $request, $id)
    {

        $content = $this->cleanQuillContent($request->input('content'));

        $request->merge(['content' => $content]);

        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori_id' => 'required|array',
            'kategori_id.*' => 'exists:kategoris,id',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'content' => 'required|string',
            'lokasi' => 'required|string',
        ]);

        $berita = Berita::findOrFail($id);

        $slug = $this->createSlug($request->judul);

        $berita->judul = $request->input('judul');
        $berita->slug = $slug;
        $berita->content = $request->input('content');
        $berita->lokasi = $request->input('lokasi');

        // Simpan foto jika ada
        if ($request->hasFile('gambar')) {
            // Hapus foto lama jika ada
            if ($berita->gambar) {
                Storage::delete('public/berita/' . $berita->gambar);
            }

            // Buat nama file baru
            $extension = $request->file('gambar')->getClientOriginalExtension();
            $fotoName = $slug . '-' . Str::uuid() . '.' . $extension;
            // Simpan foto dengan nama baru
            $request->file('gambar')->storeAs('public/berita', $fotoName);
            $berita->gambar = $fotoName;
        }

        $berita->save();

        // Sinkronkan kategori
        $berita->kategoris()->sync($request->input('kategori_id'));

        return redirect()->route('databerita.view')->with('success', "Sukses memperbarui Berita $berita->judul !!!");
    }

//     private function cleanQuillContent($content)
// {
//     // Remove unnecessary tags and whitespace
//     $content = trim($content);

//     // Jika konten kosong atau hanya placeholder Quill, kembalikan kosong
//     if ($content === '<p><br></p>' || $content === '<div><br></div>' || $content === '') {
//         return '';
//     }

//     // Anda bisa menambahkan logika lain untuk membersihkan atau menjaga tag tertentu
//     // Contoh: Mengizinkan tag <a> tetap ada
//     // Menghapus semua tag selain <a> dan beberapa tag yang diinginkan
//     $allowedTags = '<a>';
//     return strip_tags($content, $allowedTags);
// }

    private function cleanQuillContent($content)
    {
        // Remove unnecessary tags and whitespace
        $content = trim($content);
        // Check if content is empty or only contains a Quill empty placeholder
        if ($content === '<p><br></p>' || $content === '<div><br></div>' || $content === '') {
            return '';
        }
        return $content;
    }

    public function destroy($id)
    {
        // Cari item berdasarkan NIS
        $item = Berita::find($id);

        // Periksa apakah item ditemukan
        if (!$item) {
            return back()->with('error', "Data Berita tidak ditemukan.");
        }

        // Hapus semua notifikasi yang terkait dengan berita ini untuk seluruh pengguna
        DB::table('notifications')
            ->where('type', 'App\Notifications\NewBeritaNotification')
            ->whereNull('read_at') // Hanya notifikasi yang belum dibaca
            ->where('data->berita_id', $id)
            ->delete();

        if ($item->gambar) {
            Storage::delete('public/berita/' . $item->gambar);
        }

        // Hapus item
        $item->delete();

        // Redirect atau berikan response sesuai kebutuhan
        return back()->with('success', "Sukses hapus data Berita!!!");
    }

    /**
     * Membuat slug dari nama.
     *
     * @param  string  $nama
     * @return string
     */
    protected function createSlug($nama)
    {
        // Gunakan slugify untuk membuat slug yang unik
        $slug = Str::slug($nama);

        // Pastikan slug unik di database
        $count = Kategori::where('slug', 'like', $slug . '%')->count();

        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1);
        }

        return $slug;
    }
}

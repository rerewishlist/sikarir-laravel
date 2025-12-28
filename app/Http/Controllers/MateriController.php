<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Informasi;
use App\Models\Materi;
use App\Models\User;
use App\Notifications\NewMateriNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class MateriController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter pencarian dari request
        $search_materi = $request->input('search_materi');
        $filterTanggal = $request->input('filter_tanggal');

        // Ambil tanggal unik dari kolom created_at
        $dates = Materi::selectRaw('DATE(created_at) as date')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->pluck('date')
            ->toArray();

        $query = Materi::query();

        // Filter berdasarkan judul berita
        if ($search_materi) {
            $query->where('judul', 'like', "%{$search_materi}%");
        }

        if ($filterTanggal) {
            list($year, $month) = explode('-', $filterTanggal);
            $query->whereYear('created_at', $year)
                ->whereMonth('created_at', $month);
        }

        // Dapatkan hasil pencarian dengan paginasi
        $materis = $query->orderBy('created_at', 'desc')->paginate(10);

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

        if (auth()->user()->level == 'admin') {
            return view('materi.data-materi', [
                'currentUser' => auth()->user(),
                'materis' => $materis,
                'dates' => $dates,
                'beritaforummateriNotifications' => $beritaforummateriNotifications,
                'chatNotifications' => $chatNotifications,
            ]);
        } else if (auth()->user()->level == 'siswa') {
            $informasi = Informasi::first();
            return view('menu-materi', [
                'currentUser' => auth()->user(),
                'informasi' => $informasi,
                'materis' => $materis,
                'dates' => $dates,
                'beritaforummateriNotifications' => $beritaforummateriNotifications,
                'chatNotifications' => $chatNotifications,
            ]);
        }
    }

    public function detail($id)
    {
        $materi = Materi::findOrFail($id);

        $currentUser = Auth::user();

        // Menandai notifikasi chat sebagai sudah dibaca untuk pengirim yang sama
        $materiNotifications = $currentUser->notifications()
            ->where('type', 'App\Notifications\NewMateriNotification')
            ->whereNull('read_at') // Hanya yang belum dibaca
            ->where('data->materi_id', $id)
            ->get();

        foreach ($materiNotifications as $notification) {
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

        if (auth()->user()->level == 'admin') {
            return view('materi.detail-materi', [
                'currentUser' => auth()->user(),
                'materi' => $materi,
                'beritaforummateriNotifications' => $beritaforummateriNotifications,
                'chatNotifications' => $chatNotifications,
            ]);
        } else if (auth()->user()->level == 'siswa') {
            $informasi = Informasi::first();
            return view('materi.modal.detail-siswa', [
                'currentUser' => auth()->user(),
                'informasi' => $informasi,
                'materi' => $materi,
                'beritaforummateriNotifications' => $beritaforummateriNotifications,
                'chatNotifications' => $chatNotifications,
            ]);
        }
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

        return view('materi.modal.tambah', [
            'currentUser' => auth()->user(),
            'materis' => Materi::paginate(10),
            'admins' => Admin::all(),
            'beritaforummateriNotifications' => $beritaforummateriNotifications,
            'chatNotifications' => $chatNotifications,
        ]);
    }

    public function store(Request $request)
    {
        $content = $this->cleanQuillContent($request->input('content'));

        $request->merge(['content' => $content]);
        // dd($request->all());
        // Validasi input
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
            'content' => 'required|string',
            'file_pendukung' => 'nullable|file|mimes:pdf,doc,docx,zip,jpeg,png,jpg,gif',
        ]);

        // Simpan data materi
        $materi = new Materi();
        $materi->judul = $request->input('judul');
        $materi->deskripsi = $request->input('deskripsi');
        $materi->content = $request->input('content');
        $materi->admin_id = Auth::id();

        // Simpan foto jika ada
        if ($request->hasFile('file_pendukung')) {
            // Buat nama file baru berdasarkan username dan waktu unggah
            $fileName = time() . '-' . $request->file('file_pendukung')->getClientOriginalName();
            // Simpan foto dengan nama baru
            $request->file('file_pendukung')->storeAs('public/materi', $fileName);
            $materi->file_pendukung = $fileName;
        }

        $materi->save();

        // Kirim notifikasi ke semua admin
        $admins = Admin::all();
        $users = User::all();
        Notification::send($admins, new NewMateriNotification($materi));
        Notification::send($users, new NewMateriNotification($materi));

        // Redirect dengan pesan sukses
        return redirect()->route('datamateri.view')->with('success', "Sukses menambah Materi $materi->judul !!!");
    }

    public function edit($id)
    {
        $materi = Materi::findOrFail($id); // Mengambil data berita berdasarkan ID

        // Mengambil notifikasi
        $userNotif = auth()->user();
        // Ambil notifikasi berita dan forum
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

        return view('materi.modal.edit', [
            'currentUser' => auth()->user(),
            'materi' => $materi,
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
            'deskripsi' => 'required|string|max:255',
            'content' => 'required|string',
            'file_pendukung' => 'nullable|file|mimes:pdf,doc,docx,zip,jpeg,png,jpg,gif',
        ]);

        $materi = Materi::findOrFail($id);

        $materi->judul = $request->input('judul');
        $materi->deskripsi = $request->input('deskripsi');
        $materi->content = $request->input('content');

        // Simpan foto jika ada
        if ($request->hasFile('file_pendukung')) {
            // Hapus foto lama jika ada
            if ($materi->file_pendukung) {
                Storage::delete('public/materi/' . $materi->file_pendukung);
            }

            // Buat nama file baru
            $fileName = time() . '-' . $request->file('file_pendukung')->getClientOriginalName();
            // Simpan foto dengan nama baru
            $request->file('file_pendukung')->storeAs('public/materi', $fileName);
            $materi->file_pendukung = $fileName;
        }

        $materi->save();

        return redirect()->route('datamateri.view')->with('success', "Sukses memperbarui Materi $materi->judul !!!");
    }

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
        $item = Materi::find($id);

        // Periksa apakah item ditemukan
        if (!$item) {
            return back()->with('error', "Data Materi tidak ditemukan.");
        }

        // Hapus semua notifikasi yang terkait dengan berita ini untuk seluruh pengguna
        DB::table('notifications')
            ->where('type', 'App\Notifications\NewMateriNotification')
            ->whereNull('read_at') // Hanya notifikasi yang belum dibaca
            ->where('data->materi_id', $id)
            ->delete();

        if ($item->file_pendukung) {
            Storage::delete('public/materi/' . $item->file_pendukung);
        }

        // Hapus item
        $item->delete();

        // Redirect atau berikan response sesuai kebutuhan
        return back()->with('success', "Sukses hapus data Materi!!!");
    }
}

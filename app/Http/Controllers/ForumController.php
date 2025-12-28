<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Forum;
use App\Models\Informasi;
use App\Models\User;
use App\Notifications\NewForumNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class ForumController extends Controller
{
    public function index(Request $request)
    {
        // Ambil nilai pencarian dari request
        $search_forum = $request->input('search_forum');
        $filterTanggal = $request->input('filter_tanggal');

        // Buat query untuk kategori
        $query = Forum::query();

        // Ambil tanggal unik dari kolom created_at
        $dates = Forum::selectRaw('DATE(created_at) as date')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->pluck('date')
            ->toArray();

        // Jika ada parameter pencarian, tambahkan kondisi pencarian
        if ($search_forum) {
            $query->where('judul', 'like', "%{$search_forum}%");
        }

        if ($filterTanggal) {
            list($year, $month) = explode('-', $filterTanggal);
            $query->whereYear('created_at', $year)
                ->whereMonth('created_at', $month);
        }

        // Dapatkan hasil pencarian dengan paginasi
        $forums = $query->orderBy('created_at', 'desc')->paginate(10);

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

        if (auth()->user()->level == 'superadmin') {
            return view('forum.data-forum', [
                'currentUser' => auth()->user(),
                'forums' => $forums,
                'dates' => $dates,
                'beritaforummateriNotifications' => $beritaforummateriNotifications,
                'chatNotifications' => $chatNotifications,
            ]);
        } else if (auth()->user()->level == 'admin') {
            return view('forum.data-forum', [
                'currentUser' => auth()->user(),
                'forums' => $forums,
                'dates' => $dates,
                'beritaforummateriNotifications' => $beritaforummateriNotifications,
                'chatNotifications' => $chatNotifications,
            ]);
        } else if (auth()->user()->level == 'siswa') {
            $informasi = Informasi::first();
            return view('menu-forum', [
                'currentUser' => auth()->user(),
                'informasi' => $informasi,
                'forums' => $forums,
                'dates' => $dates,
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

        if (auth()->user()->level == 'superadmin') {
            return view('forum.modal.tambah', [
                'currentUser' => auth()->user(),
                'beritaforummateriNotifications' => $beritaforummateriNotifications,
                'chatNotifications' => $chatNotifications,
            ]);
        } else if (auth()->user()->level == 'admin') {
            return view('forum.modal.tambah', [
                'currentUser' => auth()->user(),
                'beritaforummateriNotifications' => $beritaforummateriNotifications,
                'chatNotifications' => $chatNotifications,
            ]);
        } else if (auth()->user()->level == 'siswa') {
            $informasi = Informasi::first();
            return view('forum.modal.tambah-siswa', [
                'currentUser' => auth()->user(),
                'informasi' => $informasi,
                'beritaforummateriNotifications' => $beritaforummateriNotifications,
                'chatNotifications' => $chatNotifications,
            ]);
        }
    }

    public function store(Request $request)
    {
        $content = $this->cleanQuillContent($request->input('content'));

        $request->merge(['content' => $content]);
        // dd($request->all());
        // Validasi input
        $request->validate([
            'judul_forum' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'content' => 'required|string',
        ]);

        $now = Carbon::now('Asia/Jakarta')->format('d-m-Y');

        // Simpan data forum
        $forum = new Forum();
        $forum->judul = $request->input('judul_forum');
        $forum->content = $request->input('content');

        // Simpan foto jika ada
        if ($request->hasFile('gambar')) {
            // Buat nama file baru berdasarkan username dan waktu unggah
            $extension = $request->file('gambar')->getClientOriginalExtension();
            $fotoName = $now . '-' . Str::uuid() . '.' . $extension;
            // Simpan foto dengan nama baru
            $request->file('gambar')->storeAs('public/forum', $fotoName);
            $forum->gambar = $fotoName;
        }

        if (auth()->user()->level == 'superadmin') {
            $forum->admin_id = auth()->id();
            $forum->save();
            // Kirim notifikasi ke admin
            Notification::send(Admin::all(), new NewForumNotification($forum));
            Notification::send(User::all(), new NewForumNotification($forum));
            return redirect()->route('admin.dataforum.view')->with('success', "Sukses menambah Forum $forum->judul !!!");
        } else if (auth()->user()->level == 'admin') {
            $forum->admin_id = auth()->id();
            $forum->save();
            // Kirim notifikasi ke admin
            Notification::send(Admin::all(), new NewForumNotification($forum));
            Notification::send(User::all(), new NewForumNotification($forum));
            return redirect()->route('admin.dataforum.view')->with('success', "Sukses menambah Forum $forum->judul !!!");
        } else if (auth()->user()->level == 'siswa') {
            $forum->user_id = auth()->id();
            $forum->save();
            // Kirim notifikasi ke user
            Notification::send(Admin::all(), new NewForumNotification($forum));
            Notification::send(User::all(), new NewForumNotification($forum));
            return redirect()->route('user.dataforum.view')->with('success', "Sukses menambah Forum $forum->judul !!!");
        }
    }

    public function detail($id)
    {
        $forum = Forum::with('comments.admin', 'comments.user')->findOrFail($id); // Mengambil data forum beserta komentar yang berelasi

        $currentUser = Auth::user();

        // Menandai notifikasi chat sebagai sudah dibaca untuk pengirim yang sama
        $forumNotifications = $currentUser->notifications()
            ->where('type', 'App\Notifications\NewForumNotification')
            ->whereNull('read_at') // Hanya yang belum dibaca
            ->where('data->forum_id', $id)
            ->get();

        foreach ($forumNotifications as $notification) {
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

        if (auth()->user()->level == 'superadmin') {
            return view('forum.modal.detail', [
                'currentUser' => auth()->user(),
                'forum' => $forum,
                'beritaforummateriNotifications' => $beritaforummateriNotifications,
                'chatNotifications' => $chatNotifications,
            ]);
        } else if (auth()->user()->level == 'admin') {
            return view('forum.modal.detail', [
                'currentUser' => auth()->user(),
                'forum' => $forum,
                'beritaforummateriNotifications' => $beritaforummateriNotifications,
                'chatNotifications' => $chatNotifications,
            ]);
        } else if (auth()->user()->level == 'siswa') {
            $informasi = Informasi::first();
            return view('forum.modal.detail-siswa', [
                'currentUser' => auth()->user(),
                'informasi' => $informasi,
                'forum' => $forum,
                'beritaforummateriNotifications' => $beritaforummateriNotifications,
                'chatNotifications' => $chatNotifications,
            ]);
        }
    }

    public function edit($id)
    {
        $forum = Forum::findOrFail($id); // Mengambil data berita berdasarkan ID

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

        return view('forum.modal.edit', [
            'currentUser' => auth()->user(),
            'beritaforummateriNotifications' => $beritaforummateriNotifications,
            'chatNotifications' => $chatNotifications,
            'forum' => $forum,
        ]);
    }

    public function update(Request $request, $id)
    {
        $content = $this->cleanQuillContent($request->input('content'));

        $request->merge(['content' => $content]);

        $request->validate([
            'judul_forum' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'content' => 'required|string',
        ]);

        $now = Carbon::now('Asia/Jakarta')->format('d-m-Y');

        $forum = Forum::findOrFail($id);

        $forum->judul = $request->input('judul_forum');
        $forum->content = $request->input('content');

        // Simpan foto jika ada
        if ($request->hasFile('gambar')) {
            // Hapus foto lama jika ada
            if ($forum->gambar) {
                Storage::delete('public/forum/' . $forum->gambar);
            }

            // Buat nama file baru
            $extension = $request->file('gambar')->getClientOriginalExtension();
            $fotoName = $now . '-' . Str::uuid() . '.' . $extension;
            // Simpan foto dengan nama baru
            $request->file('gambar')->storeAs('public/forum', $fotoName);
            $forum->gambar = $fotoName;
        }

        $forum->save();

        return redirect()->route('admin.dataforum.view')->with('success', "Sukses memperbarui Forum $forum->judul !!!");
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
        // Cari item berdasarkan ID
        $item = Forum::find($id);

        // Periksa apakah item ditemukan
        if (!$item) {
            return back()->with('error', "Data Forum tidak ditemukan.");
        }

        // Hapus semua notifikasi yang terkait dengan berita ini untuk seluruh pengguna
        DB::table('notifications')
            ->where('type', 'App\Notifications\NewForumNotification')
            ->whereNull('read_at') // Hanya notifikasi yang belum dibaca
            ->where('data->forum_id', $id)
            ->delete();

        // Hapus file gambar dari storage jika ada
        if ($item->gambar) {
            Storage::delete('public/forum/' . $item->gambar);
        }

        // Hapus item dari database
        $item->delete();

        // Redirect atau berikan response sesuai kebutuhan
        return back()->with('success', "Sukses hapus data Forum!!!");
    }
}

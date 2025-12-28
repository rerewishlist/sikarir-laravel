<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use App\Models\Chat;
use App\Models\Informasi;
use App\Models\Jurusan;
use App\Notifications\NewChatNotification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter pencarian dari request
        $search = $request->input('search');
        $kelasFilter = $request->input('kelas');
        $jurusanFilter = $request->input('jurusan');

        // Dapatkan ID admin yang sedang login
        $currentAdminId = auth()->user()->id;

        // Buat query untuk mengambil data users dan jurusans
        $query = User::join('jurusans', 'users.jurusan_id', '=', 'jurusans.id')
            ->select('users.*', 'jurusans.nama as nama_jurusan');

        // Jika ada parameter pencarian, tambahkan kondisi pencarian di beberapa kolom
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('users.nama', 'like', '%' . $search . '%');
            });
        }

        // Jika ada filter kelas, jurusan, tambahkan kondisi filter kelas/jurusan
        if ($kelasFilter) {
            $query->where('users.kelas', $kelasFilter);
        }
        if ($jurusanFilter) {
            $query->where('users.jurusan_id', $jurusanFilter);
        }

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

        // Ambil daftar kelas/jurusan untuk dropdown
        $kelasOptions = User::pluck('kelas')->unique()->sort()->toArray();
        $jurusanOptions = Jurusan::all(); // Ambil semua jurusan

        // Urutkan dan paginasi hasilnya
        $users = $query->orderBy('users.id', 'asc')->paginate(10);

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

        // Kembalikan view dengan data yang diperlukan
        return view('chat.data-chat', [
            'currentUser' => auth()->user(),
            'users' => $users,
            'jurusans' => Jurusan::all(),
            'search' => $search, // Pastikan parameter pencarian diteruskan ke view
            'kelasOptions' => $kelasOptions, // Daftar kelas untuk dropdown
            'jurusanOptions' => $jurusanOptions, // Daftar jurusan untuk dropdown
            'beritaforummateriNotifications' => $beritaforummateriNotifications,
            'chatNotifications' => $chatNotifications,
        ]);
    }

    public function detail($id)
    {
        // Dapatkan user yang sedang login
        $currentUser = Auth::user();
        $targetUser = null;

        if ($currentUser->level == 'superadmin') {
            $targetUser = User::find($id);
            if (!$targetUser) {
                return redirect()->back()->with('error', 'User tidak ditemukan.');
            }
        } else if ($currentUser->level == 'admin') {
            $targetUser = User::find($id);
            if (!$targetUser) {
                return redirect()->back()->with('error', 'User tidak ditemukan.');
            }
        } else if ($currentUser->level == 'siswa') {
            $targetUser = Admin::find($id);
            if (!$targetUser) {
                return redirect()->back()->with('error', 'User tidak ditemukan.');
            }
        } else {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Dapatkan pesan chat antara pengguna yang login dan target user
        $chats = Chat::where(function ($query) use ($targetUser) {
            if (auth()->user()->level == 'superadmin') {
                $query->where(function ($q) use ($targetUser) {
                    $q->where('from_admin_id', auth()->user()->id)
                        ->where('to_user_id', $targetUser->id);
                })->orWhere(function ($q) use ($targetUser) {
                    $q->where('from_user_id', $targetUser->id)
                        ->where('to_admin_id', auth()->user()->id);
                });
            } elseif (auth()->user()->level == 'admin') {
                $query->where(function ($q) use ($targetUser) {
                    $q->where('from_admin_id', auth()->user()->id)
                        ->where('to_user_id', $targetUser->id);
                })->orWhere(function ($q) use ($targetUser) {
                    $q->where('from_user_id', $targetUser->id)
                        ->where('to_admin_id', auth()->user()->id);
                });
            } elseif (auth()->user()->level == 'siswa') {
                $query->where(function ($q) use ($targetUser) {
                    $q->where('from_user_id', auth()->user()->id)
                        ->where('to_admin_id', $targetUser->id);
                })->orWhere(function ($q) use ($targetUser) {
                    $q->where('from_admin_id', $targetUser->id)
                        ->where('to_user_id', auth()->user()->id);
                });
            }
        })->get();

        // Menandai notifikasi chat sebagai sudah dibaca untuk pengirim yang sama
        $chatNotifications = $currentUser->notifications()
            ->where('type', 'App\Notifications\NewChatNotification')
            ->whereNull('read_at') // Hanya yang belum dibaca
            ->where('data->from_id', $targetUser->id)
            ->get();

        // foreach ($chatNotifications as $notification) {
        //     $notification->markAsRead();
        // }

        foreach ($chatNotifications as $notification) {
            $notification->delete(); // Hapus notifikasi
        }

        // Mengambil notifikasi
        $userNotif = auth()->user();
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
            return view('chat.modal.detail', [
                // 'currentUser' => auth()->user(),
                'currentUser' => $currentUser,
                'targetUser' => $targetUser,
                'chats' => $chats,
                'beritaforummateriNotifications' => $beritaforummateriNotifications,
                'chatNotifications' => $chatNotifications,
            ]);
        } else if (auth()->user()->level == 'admin') {
            return view('chat.modal.detail', [
                // 'currentUser' => auth()->user(),
                'currentUser' => $currentUser,
                'targetUser' => $targetUser,
                'chats' => $chats,
                'beritaforummateriNotifications' => $beritaforummateriNotifications,
                'chatNotifications' => $chatNotifications,
            ]);
        } else if (auth()->user()->level == 'siswa') {
            $informasi = Informasi::first();
            // Buat query untuk mengambil data admins
            $query = Admin::query();
            // Urutkan dan paginasi hasilnya
            $admins = $query->orderBy('id', 'asc')->paginate(10);
            return view('chat.modal.detail-siswa', [
                // 'currentUser' => auth()->user(),
                'informasi' => $informasi,
                'admins' => $admins,
                'currentUser' => $currentUser,
                'targetUser' => $targetUser,
                'chats' => $chats,
                'beritaforummateriNotifications' => $beritaforummateriNotifications,
                'chatNotifications' => $chatNotifications,
            ]);
        }
    }


    public function store(Request $request, $id)
    {
        $targetUser = null;

        if (auth()->user()->level == 'superadmin') {
            $targetUser = User::find($id);
        } else if (auth()->user()->level == 'admin') {
            $targetUser = User::find($id);
        } else if (auth()->user()->level == 'siswa') {
            $targetUser = Admin::find($id);
        }

        if (!$targetUser) {
            return redirect()->back()->with('error', 'Target user tidak ditemukan.');
        }

        // Validasi pesan chat
        $request->validate([
            'message' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $now = Carbon::now('Asia/Jakarta')->format('d-m-Y');

        // Buat pesan chat baru
        $chat = new Chat();
        $chat->message = $request->message;

        // Simpan foto jika ada
        if ($request->hasFile('gambar')) {
            // Buat nama file baru berdasarkan username dan waktu unggah
            $extension = $request->file('gambar')->getClientOriginalExtension();
            $fotoName = $now . '-' . Str::uuid() . '.' . $extension;
            // Simpan foto dengan nama baru
            $request->file('gambar')->storeAs('public/chat', $fotoName);
            $chat->gambar = $fotoName;
        }

        if (auth()->user()->level == 'superadmin') {
            $chat->from_admin_id = auth()->id();
            $chat->to_user_id = $targetUser->id;
            $chat->save();

            // Kirim notifikasi ke user
            $targetUser->notify(new NewChatNotification($chat));

            return redirect()->route('admin.chat.detail', $id);
        } else if (auth()->user()->level == 'admin') {
            $chat->from_admin_id = auth()->id();
            $chat->to_user_id = $targetUser->id;
            $chat->save();

            // Kirim notifikasi ke user
            $targetUser->notify(new NewChatNotification($chat));

            return redirect()->route('admin.chat.detail', $id);
        } else if (auth()->user()->level == 'siswa') {
            $chat->from_user_id = auth()->id();
            $chat->to_admin_id = $targetUser->id;
            $chat->save();

            // Kirim notifikasi ke admin
            $targetUser->notify(new NewChatNotification($chat));

            return redirect()->route('user.chat.detail', $id);
        }
    }
}

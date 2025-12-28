<?php

namespace App\Http\Controllers;

use App\Models\Informasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
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

        // Ambil notifikasi berita dan forum dengan pagination
        $databeritaforummateriNotifications = $userNotif->notifications()
            ->whereIn('type', ['App\Notifications\NewBeritaNotification', 'App\Notifications\NewForumNotification', 'App\Notifications\NewMateriNotification'])
            ->latest()
            ->get(); // Ganti 10 dengan jumlah notifikasi per halaman yang diinginkan

        if (auth()->user()->level == 'superadmin') {
            return view('notification', [
                'currentUser' => auth()->user(),
                'beritaforummateriNotifications' => $beritaforummateriNotifications,
                'chatNotifications' => $chatNotifications,
                'databeritaforummateriNotifications' => $databeritaforummateriNotifications,
            ]);
        } else if (auth()->user()->level == 'admin') {
            return view('notification', [
                'currentUser' => auth()->user(),
                'beritaforummateriNotifications' => $beritaforummateriNotifications,
                'chatNotifications' => $chatNotifications,
                'databeritaforummateriNotifications' => $databeritaforummateriNotifications,
            ]);
        } else if (auth()->user()->level == 'siswa') {
            $informasi = Informasi::first();
            return view('notification-siswa', [
                'currentUser' => auth()->user(),
                'informasi' => $informasi,
                'beritaforummateriNotifications' => $beritaforummateriNotifications,
                'chatNotifications' => $chatNotifications,
                'databeritaforummateriNotifications' => $databeritaforummateriNotifications,
            ]);
        }
    }
}

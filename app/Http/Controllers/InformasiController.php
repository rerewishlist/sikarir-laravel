<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Models\Informasi;

class InformasiController extends Controller
{
    public function edit()
    {
        $informasi = Informasi::first(); // Ambil entri pertama dari tabel

        // Mengambil notifikasi
        $userNotif = auth()->user();
        // Ambil notifikasi berita dan forum
        $beritaforummateriNotifications = $userNotif->notifications()
            ->whereIn('type', ['App\Notifications\NewBeritaNotification', 'App\Notifications\NewForumNotification' , 'App\Notifications\NewMateriNotification'])
            ->latest()
            ->take(5)
            ->get();

        // Ambil notifikasi chat
        $chatNotifications = $userNotif->notifications()
            ->where('type', 'App\Notifications\NewChatNotification')
            ->latest()
            ->get()
            ->unique('data.from_id');

        if ($informasi) {
            // Jika data ada, tampilkan halaman edit
            return view('informasi.edit', [
                'currentUser' => auth()->user(),
                'beritaforummateriNotifications' => $beritaforummateriNotifications,
                'chatNotifications' => $chatNotifications,
                'informasi' => $informasi,
            ]);
        } else {
            // Jika data tidak ada, arahkan ke halaman create
            return view('informasi.tambah', [
                'currentUser' => auth()->user(),
                'beritaforummateriNotifications' => $beritaforummateriNotifications,
                'chatNotifications' => $chatNotifications,
            ]);
        }
    }

    public function store(Request $request)
    {
        // Validasi data yang dikirimkan
        $validatedData = $request->validate([
            'instansi' => 'required|string',
            'alamat' => 'required|string',
            'nohp' => 'required|string',
            'email' => 'required|email',
            'deskripsi' => 'nullable|string',
            'videoyt' => 'nullable|string',
            'facebook' => 'nullable|string',
            'instagram' => 'nullable|string',
            'twitter' => 'nullable|string',
            'youtube' => 'nullable|string',
            'tiktok' => 'nullable|string',
        ]);

        // Buat entri baru di tabel Informasi dengan hanya data yang terverifikasi
        Informasi::create($validatedData);

        // Redirect atau tampilkan notifikasi
        return redirect()->route('informasi.edit')->with('success', 'Informasi telah dibuat.');
    }

    public function update(Request $request)
    {
        // Validasi data yang dikirimkan
        $validatedData = $request->validate([
            'instansi' => 'required|string',
            'alamat' => 'required|string',
            'nohp' => 'required|string',
            'email' => 'required|email',
            'deskripsi' => 'nullable|string',
            'videoyt' => 'nullable|string',
            'facebook' => 'nullable|string',
            'instagram' => 'nullable|string',
            'twitter' => 'nullable|string',
            'youtube' => 'nullable|string',
            'tiktok' => 'nullable|string',
        ]);

        $informasi = Informasi::first(); // Ambil entri pertama dari tabel

        $informasi->update($validatedData);

        // Redirect atau tampilkan notifikasi
        return redirect()->route('informasi.edit')->with('success', 'Informasi telah diperbarui.');
    }
}

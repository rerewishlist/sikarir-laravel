<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Informasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Jurusan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
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

        $currentUser = auth()->user();
        $jurusan = Jurusan::where('id', $currentUser->jurusan_id)->value('nama');
        $informasi = Informasi::first();
        return view('profile-siswa', [
            'informasi' => $informasi,
            'currentUser' => $currentUser,
            'user' => $request->user(),
            'jurusan' => $jurusan,
            'beritaforummateriNotifications' => $beritaforummateriNotifications,
            'chatNotifications' => $chatNotifications,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Validasi dan menyimpan data pengguna kecuali foto
        $user = $request->user();
        $user->fill($request->validated());

        // Mengelola upload foto jika ada
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto) {
                Storage::delete('public/foto/' . $user->foto);
            }

            // Buat nama file baru berdasarkan username dan waktu unggah
            $extension = $request->file('foto')->getClientOriginalExtension();
            $fotoName = $user->nis . '-' . Str::uuid() . '.' . $extension;
            // Simpan foto dengan nama baru
            $request->file('foto')->storeAs('public/foto', $fotoName);
            $user->foto = $fotoName;
        }

        // Menyimpan perubahan pengguna
        $request->user()->save();

        return Redirect::route('profile.edit')->with('success', 'Sukses simpan data profile baru!!!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

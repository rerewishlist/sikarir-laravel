<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Informasi;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter pencarian dari request
        $search = $request->input('search');
        // Buat query untuk mengambil data admins
        $query = Admin::query();
        // Urutkan dan paginasi hasilnya
        $alladmins = $query->orderBy('id', 'asc')->paginate(10);

        // Ambil admin_id dari request
        $adminId = $request->get('admin_id');

        // Jika ada admin_id dalam request, filter berdasarkan admin_id
        if ($adminId) {
            $admins = Admin::where('id', $adminId)->get(); // Ambil admin yang dipilih
        } else {
            $admins = collect(); // Tidak ada admin yang ditampilkan jika tidak ada admin_id
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
            return view('admin.data-tabel-admin', [
                'currentUser' => auth()->user(),
                'admins' => $admins,
                'alladmins' => $alladmins,
                'beritaforummateriNotifications' => $beritaforummateriNotifications,
                'chatNotifications' => $chatNotifications,
            ]);
        } else if (auth()->user()->level == 'admin') {
            return view('admin.data-tabel-admin', [
                'currentUser' => auth()->user(),
                'admins' => $admins,
                'alladmins' => $alladmins,
                'beritaforummateriNotifications' => $beritaforummateriNotifications,
                'chatNotifications' => $chatNotifications,
            ]);
        } else if (auth()->user()->level == 'siswa') {
            $informasi = Informasi::first();
            $alladminsnotsuper = $query->where('level', 'admin')->orderBy('id', 'asc')->paginate(10);
            // Kembalikan view dengan data yang diperlukan
            return view('chat.data-chat-siswa', [
                'currentUser' => auth()->user(),
                'informasi' => $informasi,
                'admins' => $admins,
                'alladmins' => $alladminsnotsuper,
                'beritaforummateriNotifications' => $beritaforummateriNotifications,
                'chatNotifications' => $chatNotifications,
            ]);
        }
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'nama' => ['required', 'string', 'min:5', 'max:255'],
            'username' => ['required', 'string', 'min:5', 'max:255', 'unique:admins,username'],
            'nohp' => ['required', 'string', 'digits_between:12,15'],
            // 'foto' => ['string'],
        ]);

        $admin = Admin::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'level' => 'admin',
            'password' => Hash::make('admin123'),
            'nohp' => $request->nohp,
            // 'foto' => $request->foto,
        ]);

        $successMessage = "Sukses menambah data $admin->nama !!!";

        if ($request->ajax()) {
            session()->flash('success', $successMessage);
            return response()->json(['success' => true, 'redirect' => route('dataadmin.view')]);
        }

        return Redirect::route('dataadmin.view')->with('success', $successMessage);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'namaupdate' => ['required', 'string', 'min:5', 'max:255'],
            'usernameupdate' => ['required', 'string', 'min:5', 'max:255', 'unique:admins,username,' . $id],
            'nohpupdate' => ['required', 'string', 'digits_between:12,15'],
        ]);
        // dd($validatedData);

        $admin = Admin::findOrFail($id);
        $admin->update([
            'nama' => $request->namaupdate,
            'username' => $request->usernameupdate,
            'nohp' => $request->nohpupdate,
        ]);

        $successMessage = "Sukses edit data $admin->nama!!!";

        if ($request->ajax()) {
            session()->flash('success', $successMessage);
            return response()->json(['success' => true, 'redirect' => route('dataadmin.view')]);
        }

        return Redirect::route('dataadmin.view')->with('success', $successMessage);
    }

    public function destroy($id)
    {
        // Cari item berdasarkan NIS
        $item = Admin::where('id', $id)->first();

        // Hapus item
        $item->delete();

        // Redirect atau berikan response sesuai kebutuhan
        return back()->with('success', "Sukses hapus data Admin!!!");
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function index(Request $request)
    {
        // Ambil nilai pencarian dari request
        $search_jurusan = $request->input('search_jurusan');

        // Buat query untuk jurusans
        $query = Jurusan::query();

        // Jika ada parameter pencarian, tambahkan kondisi pencarian
        if ($search_jurusan) {
            $query->where('nama', 'like', "%{$search_jurusan}%");
        }

        // Dapatkan hasil pencarian dengan paginasi
        $jurusans = $query->paginate(10);

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
            ->take(4)
            ->get();

        // Kirim data ke view
        return view('jurusan.data-jurusan', [
            'currentUser' => auth()->user(),
            'jurusans' => $jurusans,
            'beritaforummateriNotifications' => $beritaforummateriNotifications,
            'chatNotifications' => $chatNotifications,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255', 'unique:' . Jurusan::class],
            'deskripsi' => ['nullable', 'string'],
        ]);

        $jurusan = Jurusan::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('datajurusan.view')->with('success', "Sukses menambah jurusan $jurusan->nama !!!");
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'namaupdate' => ['required', 'string', 'max:255', 'unique:jurusans,nama,' . $id],
            'deskripsiupdate' => ['nullable', 'string'],
        ]);

        $jurusan = Jurusan::findOrFail($id);

        $jurusan->update([
            'nama' =>  $request->namaupdate,
            'deskripsi' =>  $request->deskripsiupdate,
        ]);

        $successMessage = "Sukses edit data $jurusan->nama!!!";

        if ($request->ajax()) {
            session()->flash('success', $successMessage);
            return response()->json(['success' => true, 'redirect' => route('datajurusan.view')]);
        }

        return redirect()->route('datajurusan.view')->with('success', $successMessage);
    }


    public function destroy($id)
    {
        // Cari item berdasarkan NIS
        $item = Jurusan::where('id', $id)->first();

        // Hapus item
        $item->delete();

        // Redirect atau berikan response sesuai kebutuhan
        return back()->with('success', "Sukses hapus data Jurusan!!!");
    }
}

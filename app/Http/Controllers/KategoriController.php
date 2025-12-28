<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        // Ambil nilai pencarian dari request
        $search_kategori = $request->input('search_kategori');

        // Buat query untuk kategori
        $query = Kategori::query();

        // Jika ada parameter pencarian, tambahkan kondisi pencarian
        if ($search_kategori) {
            $query->where('nama', 'like', "%{$search_kategori}%");
        }

        // Dapatkan hasil pencarian dengan paginasi
        $kategoris = $query->paginate(10);

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
        return view('kategori.data-kategori', [
            'currentUser' => auth()->user(),
            'kategoris' => $kategoris,
            'beritaforummateriNotifications' => $beritaforummateriNotifications,
            'chatNotifications' => $chatNotifications,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255', 'unique:' . Kategori::class],
        ]);

        $slug = $this->createSlug($request->nama);

        $kategori = Kategori::create([
            'nama' => $request->nama,
            'slug' => $slug,
        ]);

        return redirect()->route('datakategori.view')->with('success', "Sukses menambah kategori $kategori->nama !!!");
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'namaupdate' => ['required', 'string', 'max:255', 'unique:kategoris,nama,' . $id],
        ]);

        $kategori = Kategori::findOrFail($id);

        $slug = $this->createSlug($request->namaupdate);

        $kategori->update([
            'nama' =>  $request->namaupdate,
            'slug' =>  $slug,
        ]);

        $successMessage = "Sukses edit data $kategori->nama!!!";

        if ($request->ajax()) {
            session()->flash('success', $successMessage);
            return response()->json(['success' => true, 'redirect' => route('datakategori.view')]);
        }

        return redirect()->route('datakategori.view')->with('success', $successMessage);
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

    public function destroy($id)
    {
        // Cari item berdasarkan NIS
        $item = Kategori::where('id', $id)->first();

        // Hapus item
        $item->delete();

        // Redirect atau berikan response sesuai kebutuhan
        return back()->with('success', "Sukses hapus data Kategori!!!");
    }
}

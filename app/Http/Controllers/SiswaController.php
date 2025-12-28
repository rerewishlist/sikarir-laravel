<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Registered;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Jurusan;
use Shuchkin\SimpleXLSX;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter pencarian dari request
        $search = $request->input('search');
        $kelasFilter = $request->input('kelas');
        $jurusanFilter = $request->input('jurusan');

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
        return view('siswa.data-siswa', [
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


    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'nis' => ['required', 'string', 'max:255', 'unique:' . User::class],
            'nama' => ['required', 'string', 'min:5', 'max:255'],
            'level' => ['required', 'string', 'max:255'],
            // 'password' => ['required', 'min:8', 'max:255'],
            'jurusan_id' => ['required'],
            'kelas' => ['required', 'integer', 'max:255'],
            'subkelas' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'string', 'max:255'],
            'tempat_lahir' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date'],
            'alamat' => ['required'],
            'nohp' => ['required', 'string', 'digits_between:12,15'],
            'foto' => ['string'],
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'nis' => $request->nis,
            'level' => $request->level,
            // 'password' => Hash::make($request->password),
            'password' => Hash::make('123'),
            'jurusan_id' => $request->jurusan_id,
            'kelas' => $request->kelas,
            'subkelas' => $request->subkelas,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'nohp' => $request->nohp,
            'foto' => $request->foto,
        ]);

        event(new Registered($user));

        $successMessage = "Sukses menambah data $user->nama !!!";

        if ($request->ajax()) {
            session()->flash('success', $successMessage);
            return response()->json(['success' => true, 'redirect' => route('datasiswa.view')]);
        }

        return Redirect::route('datasiswa.view')->with('success', $successMessage);
    }

    public function upload(Request $request)
    {
        // Validasi file upload
        $request->validate([
            'file' => 'required|file|mimes:xlsx|max:2048',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file')->getRealPath();

            // Coba untuk mem-parsing file Excel
            try {
                if ($xlsx = SimpleXLSX::parse($file)) {
                    $rows = $xlsx->rows();

                    // Pastikan file memiliki lebih dari satu baris data (tidak hanya header)
                    if (count($rows) > 1) {
                        $errors = [];
                        $isValid = true; // Flag untuk mengecek apakah semua data valid

                        // Asumsi baris pertama adalah header
                        foreach ($rows as $index => $row) {
                            // Lewati baris header
                            if ($index == 0) {
                                continue;
                            }

                            // Ekstraksi data dari setiap baris
                            $nis = $row[0] ?? null;
                            $nama = $row[1] ?? null;
                            $jurusanName = $row[2] ?? null;
                            $kelas = $row[3] ?? null;
                            $subkelas = $row[4] ?? null;
                            $jenisKelamin = $row[5] ?? null;
                            $tempatLahir = $row[6] ?? null;
                            $tanggalLahir = $row[7] ?? null;
                            $alamat = $row[8] ?? null;
                            $nohp = $row[9] ?? null;

                            // Validasi data
                            if (empty($nis) || !is_numeric($nis)) {
                                $isValid = false;
                            }
                            if (empty($nama)) {
                                $isValid = false;
                            }
                            if (empty($jurusanName)) {
                                $isValid = false;
                            }
                            if ($tanggalLahir) {
                                try {
                                    \Carbon\Carbon::parse($tanggalLahir)->format('Y-m-d');
                                } catch (\Exception $e) {
                                    $isValid = false;
                                }
                            }

                            if ($isValid) {
                                // Temukan jurusan_id berdasarkan nama jurusan
                                $jurusan = Jurusan::where('nama', $jurusanName)->first();
                                $jurusanId = $jurusan ? $jurusan->id : null;

                                // Buat pengguna baru
                                User::create([
                                    'nis' => $nis,
                                    'nama' => $nama,
                                    'level' => 'siswa',
                                    'password' => Hash::make('123'), // Password hashed with '123'
                                    'jurusan_id' => $jurusanId,
                                    'kelas' => $kelas,
                                    'subkelas' => $subkelas,
                                    'jenis_kelamin' => $jenisKelamin,
                                    'tempat_lahir' => $tempatLahir,
                                    'tanggal_lahir' => \Carbon\Carbon::parse($tanggalLahir)->format('Y-m-d'),
                                    'alamat' => $alamat,
                                    'nohp' => $nohp,
                                ]);
                            } else {
                                $errors[] = "Format data pada baris ke-$index tidak sesuai.";
                            }
                        }

                        if (!empty($errors)) {
                            // Jika ada kesalahan, kembalikan ke halaman sebelumnya dengan pesan kesalahan umum
                            return redirect()->back()->withErrors(['file' => 'Data tidak sesuai. Download link diatas']);
                        }

                        return redirect()->back()->with('success', 'Data berhasil di-upload.');
                    } else {
                        return back()->withErrors('File Excel tidak memiliki data.');
                    }
                } else {
                    return back()->withErrors('Gagal mem-parsing file Excel.');
                }
            } catch (\Exception $e) {
                // Tangani pengecualian dengan pesan umum
                return back()->withErrors(['file' => 'Format data pada file tidak sesuai.']);
            }
        }

        return back()->withErrors('Tidak ada file yang di-upload.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nisupdate' => ['required', 'string', 'max:255', 'unique:users,nis,' . $id],
            'namaupdate' => ['required', 'string', 'min:5', 'max:255'],
            'levelupdate' => ['required', 'string', 'max:255'],
            'jurusan_idupdate' => ['required'],
            'kelasupdate' => ['required', 'integer', 'max:255'],
            'subkelasupdate' => ['required', 'string', 'max:255'],
            'jenis_kelaminupdate' => ['required', 'string', 'max:255'],
            'tempat_lahirupdate' => ['required', 'string', 'max:255'],
            'tanggal_lahirupdate' => ['required', 'date'],
            'alamatupdate' => ['required'],
            'nohpupdate' => ['required', 'string', 'digits_between:12,15'],
        ]);
        // dd($validatedData);

        $user = User::findOrFail($id);
        $user->update([
            'nama' => $request->namaupdate,
            'nis' => $request->nisupdate,
            'level' => $request->levelupdate,
            'jurusan_id' => $request->jurusan_idupdate,
            'kelas' => $request->kelasupdate,
            'subkelas' => $request->subkelasupdate,
            'jenis_kelamin' => $request->jenis_kelaminupdate,
            'tempat_lahir' => $request->tempat_lahirupdate,
            'tanggal_lahir' => $request->tanggal_lahirupdate,
            'alamat' => $request->alamatupdate,
            'nohp' => $request->nohpupdate,
        ]);

        $successMessage = "Sukses edit data $user->nama!!!";

        if ($request->ajax()) {
            session()->flash('success', $successMessage);
            return response()->json(['success' => true, 'redirect' => route('datasiswa.view')]);
        }

        return Redirect::route('datasiswa.view')->with('success', $successMessage);
    }

    public function destroy($id)
    {
        // Cari item berdasarkan NIS
        $item = User::where('id', $id)->first();

        // Hapus item
        $item->delete();

        // Redirect atau berikan response sesuai kebutuhan
        return back()->with('success', "Sukses hapus data Siswa!!!");
    }
}

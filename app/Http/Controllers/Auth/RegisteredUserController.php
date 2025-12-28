<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('siswa.auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // dd($request->all());
        $request->validate([
            'nis' => ['required', 'string', 'max:255', 'unique:' . User::class],
            'nama' => ['required', 'string', 'min:5', 'max:255'],
            'level' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'jurusan' => ['required', 'string', 'max:255'],
            'kelas' => ['required', 'integer', 'max:255'],
            'subkelas' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'string', 'max:255'],
            'tempat_lahir' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date'],
            'alamat' => ['required', 'text'],
            'nohp' => ['required', 'string', 'max:255'],
            'foto' => ['string'],
        ]);

        $user = User::create([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'level' => $request->level,
            'password' => Hash::make($request->password),
            // 'password' => Hash::make('123'),
            'jurusan' => $request->jurusan,
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

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}

<?php

namespace App\Http\Controllers\AdminAuth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
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
        return view('admin.auth.register');
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
            'nama' => ['required', 'string', 'min:5', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:' . Admin::class],
            'level' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nohp' => ['required', 'string', 'max:255'],
            'foto' => ['string'],
        ]);

        $user = Admin::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'level' => $request->level,
            'password' => Hash::make($request->password),
            'nohp' => $request->nohp,
            'foto' => $request->foto,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::ADMIN_DASHBOARD);
    }
}

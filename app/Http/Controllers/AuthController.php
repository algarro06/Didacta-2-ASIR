<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Userr;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'mail' => 'required|email',
            'password' => 'required'
        ]);

        $user = Userr::where('mail', $request->mail)->first();

        if (!$user) {
            return back()->with('error', 'Credenciales incorrectas');
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Credenciales incorrectas');
        }

        if ($user->status === 'Pendiente') {
            return back()->with('error', 'Tu cuenta está pendiente de autorización');
        }

        if ($user->status === 'Inactivo') {
            return back()->with('error', 'Tu cuenta está inactiva');
        }

        Auth::login($user);

        $request->session()->regenerate();

        return redirect('/')->with('success', 'Inicio de sesión correcto');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}

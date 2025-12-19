<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required'
        ]);

        $login = $request->input('username');
        // allow either email or username; if value contains @ treat as email
        if (strpos($login, '@') !== false) {
            $credentials = ['email' => $login, 'password' => $request->password];
        } else {
            $credentials = ['username' => $login, 'password' => $request->password];
        }

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->is_admin) {
                $request->session()->regenerate();
                return redirect()->intended('/admin');
            }

            Auth::logout();
            return back()->withErrors(['username' => 'Akun tidak memiliki hak admin']);
        }

        return back()->withErrors(['username' => 'Kredensial tidak valid']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }
}

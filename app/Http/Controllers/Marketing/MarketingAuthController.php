<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarketingAuthController extends Controller
{
    public function showLogin()
    {
        return view('marketing.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required'
        ]);

        $login = $request->input('username');
        if (strpos($login, '@') !== false) {
            $credentials = ['email' => $login, 'password' => $request->password];
        } else {
            $credentials = ['username' => $login, 'password' => $request->password];
        }

        if (Auth::guard('marketing')->attempt($credentials)) {
            $user = Auth::guard('marketing')->user();
            if ($user->is_marketing) {
                $request->session()->regenerate();
                return redirect()->intended('/marketing/dashboard');
            }
            Auth::guard('marketing')->logout();
            return back()->withErrors(['username' => 'Akun tidak memiliki hak marketing']);
        }

        return back()->withErrors(['username' => 'Kredensial tidak valid']);
    }

    public function logout(Request $request)
    {
        Auth::guard('marketing')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/marketing/login');
    }
}

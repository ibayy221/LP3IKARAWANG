<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PendaftarAuthController extends Controller
{
    public function showLogin()
    {
        return view('pendaftar.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($data)) {
            $user = Auth::user();
            if (!$user->is_applicant) {
                Auth::logout();
                return back()->withErrors(['email' => 'Akun bukan pendaftar.']);
            }
            $request->session()->regenerate();
            return redirect()->route('pendaftar.dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('pendaftar.login');
    }
}
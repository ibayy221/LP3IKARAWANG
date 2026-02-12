<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    // Show forgot password form
    public function showForgotForm()
    {
        return view('pendaftar.forgot_password');
    }

    // Send reset code to email
    public function sendResetCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.exists' => 'Email tidak terdaftar'
        ]);

        try {
            $user = User::where('email', $request->email)->first();

            // Create password reset record
            $passwordReset = PasswordReset::createReset($user->id, $user->email);

            // Send email with code
            Mail::send('emails.password_reset_code', [
                'user' => $user,
                'code' => $passwordReset->code
            ], function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Kode Reset Password LP3I Karawang');
            });

            session(['reset_email' => $user->email]);

            return redirect()->route('pendaftar.verify-code')
                           ->with('success', 'Kode reset telah dikirim ke email Anda');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim kode: ' . $e->getMessage());
        }
    }

    // Show verify code form
    public function showVerifyForm()
    {
        $email = session('reset_email');
        if (!$email) {
            return redirect()->route('pendaftar.forgot-password');
        }
        return view('pendaftar.verify_code', compact('email'));
    }

    // Verify reset code
    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6'
        ], [
            'code.required' => 'Kode harus diisi',
            'code.digits' => 'Kode harus 6 angka'
        ]);

        $email = session('reset_email');
        if (!$email) {
            return redirect()->route('pendaftar.forgot-password');
        }

        $passwordReset = PasswordReset::where('email', $email)
                                     ->where('code', $request->code)
                                     ->valid()
                                     ->first();

        if (!$passwordReset) {
            return back()->with('error', 'Kode tidak valid atau sudah kadaluarsa');
        }

        session(['reset_token' => $passwordReset->id]);
        return redirect()->route('pendaftar.reset-password')
                        ->with('success', 'Kode terverifikasi');
    }

    // Show reset password form
    public function showResetForm()
    {
        $resetToken = session('reset_token');
        if (!$resetToken) {
            return redirect()->route('pendaftar.forgot-password');
        }

        return view('pendaftar.reset_password');
    }

    // Update password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required'
        ], [
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
            'password_confirmation.required' => 'Konfirmasi password harus diisi'
        ]);

        $resetToken = session('reset_token');
        if (!$resetToken) {
            return redirect()->route('pendaftar.forgot-password');
        }

        $passwordReset = PasswordReset::find($resetToken);
        if (!$passwordReset || !$passwordReset->isValid()) {
            return redirect()->route('pendaftar.forgot-password')
                           ->with('error', 'Session expired');
        }

        try {
            $user = User::find($passwordReset->user_id);
            $user->update([
                'password' => Hash::make($request->password)
            ]);

            // Mark code as used
            $passwordReset->update(['used' => true]);

            // Clear session
            session()->forget(['reset_email', 'reset_token']);

            return redirect()->route('pendaftar.login')
                           ->with('success', 'Password berhasil direset. Silakan login dengan password baru');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mereset password: ' . $e->getMessage());
        }
    }
}

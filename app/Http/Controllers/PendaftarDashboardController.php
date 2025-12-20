<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftarDashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $calon = $user->mahasiswa ?? $user->mahasiswas ?? \App\Models\Mahasiswa::where('user_id', $user->id)->first();

        // If there's no calon, just render the view — the Blade template shows a friendly message for missing data
        if (!$calon) {
            return view('pendaftar.dashboard', compact('calon'));
        }

        // Derive simple status flags for the view
        $verif = $calon->status_verifikasi ?? 'pending';
        // Normalize known synonyms
        if (!in_array($verif, ['verified','rejected','pending'])) {
            $verif = $verif === 'accepted' ? 'verified' : 'pending';
        }

        $payment = $calon->payment_status ?? 'unpaid';
        $amount = $calon->payment_amount ?? 350000;

        // Compute step classes
        $step1 = 'completed';

        if ($verif === 'verified') {
            $step2 = 'completed';
            $step3 = $payment === 'paid' ? 'completed' : 'active';
        } elseif ($verif === 'pending') {
            $step2 = 'active';
            $step3 = 'inactive';
        } elseif ($verif === 'rejected') {
            $step2 = 'rejected';
            $step3 = 'inactive';
        } else {
            $step2 = 'inactive';
            $step3 = 'inactive';
        }

        $step4 = ($verif === 'verified' && $payment === 'paid') ? 'completed' : 'inactive';

        return view('pendaftar.dashboard', compact('calon','verif','payment','amount','step1','step2','step3','step4'));
    }

    public function markPaid(Request $request)
    {
        $user = Auth::user();
        $calon = \App\Models\Mahasiswa::where('user_id', $user->id)->first();
        if (!$calon) return back()->with('error','Data pendaftar tidak ditemukan.');
        $calon->payment_status = 'paid';
        $calon->save();
        return back()->with('success','Pembayaran tercatat. Terima kasih.');
    }

    public function payment()
    {
        $user = Auth::user();
        $calon = \App\Models\Mahasiswa::where('user_id', $user->id)->first();
        if (!$calon) return redirect()->route('pendaftar.dashboard')->with('error','Data pendaftar tidak ditemukan.');
        return view('pendaftar.payment', compact('calon'));
    }
}
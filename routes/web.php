<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\CarouselController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;

use App\Http\Middleware\EnsureAdmin;

Route::get('/', [CarouselController::class, 'showCarousel']);
Route::get('/carousel-view', [CarouselController::class, 'showCarousel']);

// Sambutan (static page)
Route::view('/sambutan', 'sambutan')->name('sambutan');
// Sejarah (static page)
Route::view('/sejarah', 'sejarah')->name('sejarah');
// Struktur organisasi
Route::view('/struktur', 'struktur')->name('struktur');
// Office Administration automatization (static program page)
Route::view('/oaa', 'oaa')->name('oaa');
Route::view('/ais', 'ais')->name('ais');
// ASE page under `resources/views/pendaftar/ase.blade.php`
Route::view('/ase', 'ase')->name('ase');
Route::view('/penempatan', 'penempatan')->name('penempatan');
// Virtual campus / tour page
Route::view('/virtual', 'virtual')->name('virtual');

// Pedoman download: serve local PDF as an attachment when available,
// otherwise redirect to the external page.
Route::get('/pedoman/download', function () {
    $local = storage_path('app/public/docs/Pedoman-Kuliah-Kerja-Industri-Politeknik-LP3I-2023-2024.pdf');
    if (file_exists($local)) {
        return response()->download($local, 'Pedoman-Kuliah-Kerja-Industri-Politeknik-LP3I-2023-2024.pdf');
    }
    return redirect('https://plb.ac.id/id/pedoman-kuliah-kerja-industri/');
})->name('pedoman.download');

// Mahasiswa registration
Route::get('/mahasiswa/create', [MahasiswaController::class, 'create'])->name('mahasiswa.create');
Route::post('/mahasiswa', [MahasiswaController::class, 'store'])->name('mahasiswa.store');

// Pendaftar (Applicant) public auth & dashboard
use App\Http\Controllers\PendaftarAuthController;
use App\Http\Controllers\PendaftarDashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Models\Mahasiswa;

Route::prefix('pendaftar')->name('pendaftar.')->group(function () {
    Route::get('/login', [PendaftarAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [PendaftarAuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [PendaftarAuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [PendaftarDashboardController::class, 'dashboard'])->middleware(\App\Http\Middleware\EnsureApplicant::class)->name('dashboard');
        Route::post('/payment/mark-paid', [PendaftarDashboardController::class, 'markPaid'])->middleware(\App\Http\Middleware\EnsureApplicant::class)->name('payment.markPaid');
        Route::get('/payment', [PendaftarDashboardController::class, 'payment'])->middleware(\App\Http\Middleware\EnsureApplicant::class)->name('payment.show');
        Route::post('/payment/upload', [PendaftarDashboardController::class, 'uploadPaymentProof'])->middleware(\App\Http\Middleware\EnsureApplicant::class)->name('payment.upload');

        // Biodata pages: show, edit, update
        Route::get('/biodata', [PendaftarDashboardController::class, 'showBiodata'])->middleware(\App\Http\Middleware\EnsureApplicant::class)->name('biodata.show');
        Route::get('/biodata/edit', [PendaftarDashboardController::class, 'editBiodata'])->middleware(\App\Http\Middleware\EnsureApplicant::class)->name('biodata.edit');
        Route::post('/biodata', [PendaftarDashboardController::class, 'updateBiodata'])->middleware(\App\Http\Middleware\EnsureApplicant::class)->name('biodata.update');

        // Receipt download (only available after payment is marked 'paid')
        Route::get('/kuitansi', [PendaftarDashboardController::class, 'downloadReceipt'])->middleware(\App\Http\Middleware\EnsureApplicant::class)->name('receipt');

        // Account pages (simple closures returning views). Pages use EnsureApplicant middleware.
        Route::get('/akun/email', function () { return view('pendaftar.account.email'); })->middleware(\App\Http\Middleware\EnsureApplicant::class)->name('akun.email');
        Route::post('/akun/email', function (Request $r) {
            $r->validate(['email'=>'required|email']);
            $user = Auth::user();
            if (!$user) return redirect()->route('pendaftar.login');
            // ensure unique email
            $exists = \App\Models\User::where('email', $r->email)->where('id','<>',$user->id)->exists();
            if ($exists) return back()->with('error','Email sudah digunakan oleh akun lain.');
            $user->email = $r->email;
            $user->save();
            // also update mahasiswa email if exists
            $m = Mahasiswa::where('user_id', $user->id)->first();
            if ($m) { $m->email = $r->email; $m->save(); }
            return back()->with('success','Email diperbarui.');
        })->middleware(\App\Http\Middleware\EnsureApplicant::class)->name('akun.email.update');

        Route::get('/akun/password', function () { return view('pendaftar.account.password'); })->middleware(\App\Http\Middleware\EnsureApplicant::class)->name('akun.password');
        Route::post('/akun/password', function (Request $r) {
            $r->validate(['password'=>'required|confirmed|min:8']);
            $user = Auth::user();
            if (!$user) return redirect()->route('pendaftar.login');
            $user->password = Hash::make($r->password);
            $user->save();
            return back()->with('success','Password diperbarui.');
        })->middleware(\App\Http\Middleware\EnsureApplicant::class)->name('akun.password.update');

        Route::get('/akun/phone', function () { return view('pendaftar.account.phone'); })->middleware(\App\Http\Middleware\EnsureApplicant::class)->name('akun.phone');
        Route::post('/akun/phone', function (Request $r) {
            $r->validate(['phone'=>'required|string|max:50']);
            $user = Auth::user();
            if (!$user) return redirect()->route('pendaftar.login');
            $m = Mahasiswa::where('user_id', $user->id)->first();
            if (!$m) return back()->with('error','Data pendaftar tidak ditemukan.');
            $m->no_hp = $r->phone;
            $m->save();
            return back()->with('success','Nomor telepon diperbarui.');
        })->middleware(\App\Http\Middleware\EnsureApplicant::class)->name('akun.phone.update');

        Route::get('/akun/whatsapp', function () { return view('pendaftar.account.whatsapp'); })->middleware(\App\Http\Middleware\EnsureApplicant::class)->name('akun.whatsapp');
        Route::post('/akun/whatsapp', function (Request $r) {
            $r->validate(['whatsapp'=>'required|string|max:50']);
            $user = Auth::user();
            if (!$user) return redirect()->route('pendaftar.login');
            $m = Mahasiswa::where('user_id', $user->id)->first();
            if (!$m) return back()->with('error','Data pendaftar tidak ditemukan.');
            // Save WhatsApp into `whatsapp` column if exists, else save into no_hp
            if (Schema::hasColumn('mahasiswas','whatsapp')) {
                $m->whatsapp = $r->whatsapp;
            } else {
                $m->no_hp = $r->whatsapp;
            }
            $m->save();
            return back()->with('success','Nomor WhatsApp diperbarui.');
        })->middleware(\App\Http\Middleware\EnsureApplicant::class)->name('akun.whatsapp.update');
});

// News routes (legacy view expects query param `id`, so closure sets `$_GET['id']`)
Route::get('/news', function () {
	return view('news');
})->name('news.index');

Route::get('/news/{id?}', function ($id = null) {
	if ($id !== null) {
		// Ensure legacy view reading from $_GET works when route parameter is used
		$_GET['id'] = $id;
	}
	return view('news');
})->name('news.show');

// Admin auth routes (simple admin login)
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin panel routes (protected by admin middleware). Legacy link to admin.php still supported.
Route::middleware([EnsureAdmin::class])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin.php', [AdminController::class, 'index']);
    Route::post('/admin/action', [AdminController::class, 'handleAction'])->name('admin.action');
});

// Marketing (Smart Presenter) - separate from Admin CMS
use App\Http\Controllers\Marketing\MarketingAuthController as MarketingAuthController;
use App\Http\Controllers\Marketing\MarketingPendaftarController as MarketingPendaftarController;

Route::prefix('marketing')->name('marketing.')->group(function () {
    // public marketing auth
    Route::get('/login', [MarketingAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [MarketingAuthController::class, 'login']);
    Route::post('/logout', [MarketingAuthController::class, 'logout'])->name('logout');

    // protected marketing routes (dashboard & pendaftar)
    Route::middleware([\App\Http\Middleware\EnsureMarketing::class])->group(function () {
        Route::get('/dashboard', [MarketingPendaftarController::class, 'dashboard'])->name('dashboard');
        Route::get('/pendaftar', [MarketingPendaftarController::class, 'index'])->name('pendaftar.index');
        Route::post('/pendaftar/list', [MarketingPendaftarController::class, 'list'])->name('pendaftar.list');
        Route::post('/pendaftar/update', [MarketingPendaftarController::class, 'updateStatus'])->name('pendaftar.update');

        // New marketing pendaftar features
        Route::get('/pendaftar/create', [MarketingPendaftarController::class, 'create'])->name('pendaftar.create');
        Route::post('/pendaftar', [MarketingPendaftarController::class, 'store'])->name('pendaftar.store');
        Route::get('/pendaftar/{id}', [MarketingPendaftarController::class, 'show'])->name('pendaftar.show');
        Route::get('/pendaftar/{id}/ktp', [MarketingPendaftarController::class, 'downloadKtp'])->name('pendaftar.ktp');
        Route::get('/pendaftar/{id}/ijazah', [MarketingPendaftarController::class, 'downloadIjazah'])->name('pendaftar.ijazah');
        Route::get('/pendaftar/{id}/akte', [MarketingPendaftarController::class, 'downloadAkte'])->name('pendaftar.akte');
        Route::get('/pendaftar/{id}/surat-bekerja', [MarketingPendaftarController::class, 'downloadSuratBekerja'])->name('pendaftar.surat_bekerja');
        Route::post('/pendaftar/{id}/note', [MarketingPendaftarController::class, 'updateNote'])->name('pendaftar.note');
        Route::post('/pendaftar/{id}/payment', [MarketingPendaftarController::class, 'updatePayment'])->name('pendaftar.payment');
        Route::get('/pendaftar/export', [MarketingPendaftarController::class, 'exportCsv'])->name('pendaftar.export');
        Route::get('/pendaftar/print', [MarketingPendaftarController::class, 'print'])->name('pendaftar.print');

        // Trash & development helpers
        Route::get('/pendaftar/trash', [MarketingPendaftarController::class, 'trash'])->name('pendaftar.trash');
        Route::delete('/pendaftar', [MarketingPendaftarController::class, 'destroyAll'])->name('pendaftar.destroyAll');
    });
});



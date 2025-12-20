<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\CarouselController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;

use App\Http\Middleware\EnsureAdmin;

Route::get('/', [CarouselController::class, 'showCarousel']);
Route::get('/carousel-view', [CarouselController::class, 'showCarousel']);

// Mahasiswa registration
Route::get('/mahasiswa/create', [MahasiswaController::class, 'create'])->name('mahasiswa.create');
Route::post('/mahasiswa', [MahasiswaController::class, 'store'])->name('mahasiswa.store');

// Pendaftar (Applicant) public auth & dashboard
use App\Http\Controllers\PendaftarAuthController;
use App\Http\Controllers\PendaftarDashboardController;

Route::prefix('pendaftar')->name('pendaftar.')->group(function () {
    Route::get('/login', [PendaftarAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [PendaftarAuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [PendaftarAuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [PendaftarDashboardController::class, 'dashboard'])->middleware(\App\Http\Middleware\EnsureApplicant::class)->name('dashboard');
    Route::post('/payment/mark-paid', [PendaftarDashboardController::class, 'markPaid'])->middleware(\App\Http\Middleware\EnsureApplicant::class)->name('payment.markPaid');
    Route::get('/payment', [PendaftarDashboardController::class, 'payment'])->middleware(\App\Http\Middleware\EnsureApplicant::class)->name('payment.show');
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
        Route::post('/pendaftar/{id}/note', [MarketingPendaftarController::class, 'updateNote'])->name('pendaftar.note');
        Route::post('/pendaftar/{id}/payment', [MarketingPendaftarController::class, 'updatePayment'])->name('pendaftar.payment');
        Route::get('/pendaftar/export', [MarketingPendaftarController::class, 'exportCsv'])->name('pendaftar.export');
        Route::get('/pendaftar/print', [MarketingPendaftarController::class, 'print'])->name('pendaftar.print');

        // Trash & development helpers
        Route::get('/pendaftar/trash', [MarketingPendaftarController::class, 'trash'])->name('pendaftar.trash');
        Route::delete('/pendaftar', [MarketingPendaftarController::class, 'destroyAll'])->name('pendaftar.destroyAll');
    });
});



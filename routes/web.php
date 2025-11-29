<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\CarouselController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\AdminController;
Route::get('/', [CarouselController::class, 'showCarousel']);
Route::get('/carousel-view', [CarouselController::class, 'showCarousel']);

// Mahasiswa registration
Route::get('/mahasiswa/create', [MahasiswaController::class, 'create'])->name('mahasiswa.create');
Route::post('/mahasiswa', [MahasiswaController::class, 'store'])->name('mahasiswa.store');

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

// Admin panel routes
Route::get('/admin', [AdminController::class, 'index']);
Route::post('/admin/action', [AdminController::class, 'handleAction']);

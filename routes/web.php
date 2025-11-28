<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\CarouselController;
use App\Http\Controllers\MahasiswaController;
Route::get('/', [CarouselController::class, 'showCarousel']);
Route::get('/carousel-view', [CarouselController::class, 'showCarousel']);

// Mahasiswa registration
Route::get('/mahasiswa/create', [MahasiswaController::class, 'create'])->name('mahasiswa.create');
Route::post('/mahasiswa', [MahasiswaController::class, 'store'])->name('mahasiswa.store');

<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\CarouselController;
use App\Http\Controllers\MahasiswaController;
Route::get('/', [CarouselController::class, 'showCarousel']);
Route::get('/carousel-view', [CarouselController::class, 'showCarousel']);
<<<<<<< HEAD
use App\Http\Controllers\AdminController;

// Admin routes (development)
Route::get('/admin', [AdminController::class, 'index']);
Route::post('/admin/action', [AdminController::class, 'handleAction']);
=======

// Mahasiswa registration
Route::get('/mahasiswa/create', [MahasiswaController::class, 'create'])->name('mahasiswa.create');
Route::post('/mahasiswa', [MahasiswaController::class, 'store'])->name('mahasiswa.store');
>>>>>>> c87860c1fd2bf2a199d5aec53708995f74bbba70

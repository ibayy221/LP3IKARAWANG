<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\CarouselController;
Route::get('/', [CarouselController::class, 'showCarousel']);
Route::get('/carousel-view', [CarouselController::class, 'showCarousel']);
use App\Http\Controllers\AdminController;

// Admin routes (development)
Route::get('/admin', [AdminController::class, 'index']);
Route::post('/admin/action', [AdminController::class, 'handleAction']);

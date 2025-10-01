<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\CarouselController;
Route::get('/', [CarouselController::class, 'showCarousel']);
Route::get('/carousel-view', [CarouselController::class, 'showCarousel']);

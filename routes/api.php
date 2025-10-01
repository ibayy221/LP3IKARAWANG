<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarouselController;

Route::get('/carousel', [CarouselController::class, 'index']);

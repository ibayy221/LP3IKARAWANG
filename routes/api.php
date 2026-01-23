<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarouselController;
use App\Http\Controllers\StrukturOrganisasiController;

Route::get('/carousel', [CarouselController::class, 'index']);
Route::get('/struktur-organisasi', [StrukturOrganisasiController::class, 'apiIndex']);

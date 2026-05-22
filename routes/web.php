<?php

use App\Http\Controllers\DestinationController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/destinations', [DestinationController::class, 'index'])->name('destinations.index');
Route::get('/destinations/{destination}/packages/{packageSlug}', [DestinationController::class, 'packageShow'])
    ->name('destinations.packages.show');
Route::get('/destinations/{destination}/packages/{packageSlug}/pdf', [DestinationController::class, 'packagePdf'])
    ->name('destinations.packages.pdf');
Route::get('/destinations/{destination}', [DestinationController::class, 'show'])->name('destinations.show');

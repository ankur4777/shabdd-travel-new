<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/blogs', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blogs/{destination}/{blog}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/destinations', [DestinationController::class, 'index'])->name('destinations.index');
Route::get('/packages', [DestinationController::class, 'packages'])->name('packages.index');
Route::get('/destinations/{destination}/packages/{packageSlug}', [DestinationController::class, 'packageShow'])
    ->name('destinations.packages.show');
Route::get('/destinations/{destination}/packages/{packageSlug}/pdf', [DestinationController::class, 'packagePdf'])
    ->name('destinations.packages.pdf');
Route::get('/destinations/{destination}', [DestinationController::class, 'show'])->name('destinations.show');

Route::view('/honeymoon', 'honeymoon')->name('honeymoon');
Route::get('/honeymoon', [HomeController::class, 'honeymoon'])
    ->name('honeymoon');
    Route::get('/packages/{slug}', [HomeController::class, 'packageDetails'])
    ->name('packages.show');

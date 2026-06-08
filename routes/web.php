<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search/live', [SearchController::class, 'live'])->name('search.live');
Route::get('/blogs', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blogs/{destination}/{blog}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/destinations', [DestinationController::class, 'index'])->name('destinations.index');
Route::get('/packages', [DestinationController::class, 'packages'])->name('packages.index');
Route::get('/destinations/{destination}/packages/{packageSlug}', [DestinationController::class, 'packageShow'])
    ->name('destinations.packages.show');
Route::get('/destinations/{destination}', [DestinationController::class, 'show'])->name('destinations.show');

Route::view('/honeymoon', 'honeymoon')->name('honeymoon');
Route::get('/honeymoon', [HomeController::class, 'honeymoon'])
    ->name('honeymoon');
Route::get('/package/{slug}', [DestinationController::class, 'packageShowBySlug'])
    ->name('packages.show');
Route::view('/destination-detail', 'destination.sections.destination-detail');
Route::get('/family-trips', [HomeController::class, 'familyTrips'])
    ->name('family-trips');
Route::get('/religious', [HomeController::class, 'religious'])->name('religious');

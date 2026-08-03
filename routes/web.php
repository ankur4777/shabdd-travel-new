<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\DomesticTourController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InternationalTourController;
use App\Http\Controllers\MostBookedTourController;
use App\Http\Controllers\PremiumJourneyController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\SeasonalJourneyController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
Route::get('/search/live', [SearchController::class, 'live'])->name('search.live');
Route::view('/contact', 'contact')->name('contact');
Route::view('/travel-agent-join-us', 'travel-agent-join-us')->name('travel-agent.join');
Route::get('/blogs', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blogs/{destination}/{blog}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/destinations', [DestinationController::class, 'index'])->name('destinations.index');
Route::get('/packages', [DestinationController::class, 'packages'])->name('packages.index');
Route::get('/destinations/{destination}/packages/{packageSlug}', [DestinationController::class, 'packageShow'])
    ->name('destinations.packages.show');
Route::get('/destinations/{destination}', [DestinationController::class, 'show'])->name('destinations.show');

Route::get('/honeymoon', [HomeController::class, 'honeymoon'])
    ->name('honeymoon');
Route::get('/package/{slug}', [DestinationController::class, 'packageShowBySlug'])
    ->name('packages.show');
Route::view('/destination-detail', 'destination.sections.destination-detail');
Route::get('/family-trips', [HomeController::class, 'familyTrips'])
    ->name('family-trips');
Route::get('/religious', [HomeController::class, 'religious'])->name('religious');
Route::get('/budget-friendly', [HomeController::class, 'budgetFriendly'])->name('budget-friendly');
Route::get('/beach-escapes', [HomeController::class, 'beachEscapes'])->name('beach-escapes');
Route::get('/hill-station-retreats', [HomeController::class, 'hillStationRetreats'])->name('hill-station-retreats');
Route::get('/island-getaways', [HomeController::class, 'islandGetaways'])->name('island-getaways');
Route::get('/desert-adventures', [HomeController::class, 'desertAdventures'])->name('desert-adventures');

Route::get('/under-25k', [DomesticTourController::class, 'under25k'])
    ->name('under-25k');

Route::get('/summer-vacation-specials', [DomesticTourController::class, 'summerVacationSpecials'])
    ->name('summer-vacation-specials');

Route::get('/winter-vacation-specials', [DomesticTourController::class, 'winterVacationSpecials'])
    ->name('winter-vacation-specials');

Route::get('/monsoon-specials', [DomesticTourController::class, 'monsoonSpecials'])
    ->name('monsoon-specials');

Route::get('/honeymoon-picks', [DomesticTourController::class, 'honeymoonPicks'])
    ->name('honeymoon-picks');

Route::get('/all-domestic', [DomesticTourController::class, 'allDomestic'])
    ->name('all-domestic');

Route::get('/international-tours', [InternationalTourController::class, 'index'])
    ->name('international-tours.index');
Route::get('/visa-assistance', [InternationalTourController::class, 'visaAssistance'])
    ->name('international-tours.visa-assistance');
Route::get('/group-departures', [InternationalTourController::class, 'groupDepartures'])
    ->name('international-tours.group-departures');
Route::get('/fixed-departure-dates', [InternationalTourController::class, 'fixedDepartureDates'])
    ->name('international-tours.fixed-departure-dates');

Route::get('/most-booked/{slug}', [MostBookedTourController::class, 'show'])
    ->whereIn('slug', [
        'dubai-dream-holidays',
        'thailand-beach-journeys',
        'bali-island-escape',
        'singapore-family-fun',
    ])
    ->name('most-booked.show');

Route::get('/premium-journeys/{slug}', [PremiumJourneyController::class, 'show'])
    ->whereIn('slug', [
        'europe-signature-circuits',
        'swiss-alpine-luxury',
        'japan-seasonal-trails',
        'turkey-and-greece',
    ])
    ->name('premium-journeys.show');

Route::get('/seasonal-journeys/{slug}', [SeasonalJourneyController::class, 'show'])->name('seasonal-journeys.show');
Route::post('/chat', [ChatController::class, 'chat'])
    ->name('chat');

Route::get('/chatbot/destinations/{style}', [ChatController::class, 'destinations']);
Route::get('/chatbot/themes', [ChatController::class, 'themes']);
Route::get('/chatbot/travel-styles', [ChatController::class, 'travelStyles']);
Route::post('/chatbot/save-lead', [ChatController::class, 'saveLead']);
Route::get('/chatbot/search-destinations', [ChatController::class, 'searchDestinations']);

Route::get("/about-page",function(){
    return view("about");
});

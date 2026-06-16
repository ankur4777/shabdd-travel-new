<?php

namespace App\Providers;

use App\Models\Destination;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    // public function register(): void
    // {
    //     //
    // }

    /**
     * Bootstrap any application services.
     */
    // public function boot(): void {}


    public function boot(): void
    {
        // URL::forceScheme('https');

        View::composer('partials.header', function ($view): void {
            $topDomesticDestinations = Destination::query()
                ->active()
                ->whereRaw('LOWER(COALESCE(category, \'\')) = ?', ['popular'])
                ->orderByDesc('rating')
                ->orderByDesc('id')
                ->limit(4)
                ->get(['name', 'slug', 'country', 'category', 'is_trending', 'rating']);

            $view->with('topDomesticDestinations', $topDomesticDestinations);
        });
    }
}

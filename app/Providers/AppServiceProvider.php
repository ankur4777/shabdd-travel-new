<?php

namespace App\Providers;

use App\Models\Destination;
use Filament\Forms\Components\FileUpload;
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
        
    // }

    /**
     * Bootstrap any application services.
     */
    // public function boot(): void {}


    public function boot(): void
    {
        FileUpload::configureUsing(function (FileUpload $component): void {
            $component
                ->imagePreviewHeight('120')
                ->panelLayout('compact')
                ->itemPanelAspectRatio(null);
        });

        if ($this->app->environment('production') || str_starts_with((string) config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }

        View::composer('partials.header', function ($view): void {
            $topDomesticDestinations = Destination::query()
                ->active()
                ->domestic()
                ->whereRaw('LOWER(COALESCE(category, \'\')) = ?', ['popular'])
                ->orderByDesc('rating')
                ->orderByDesc('id')
                ->limit(4)
                ->get(['name', 'slug', 'country', 'type', 'category', 'is_trending', 'rating']);

            $view->with('topDomesticDestinations', $topDomesticDestinations);
        });
    }
}

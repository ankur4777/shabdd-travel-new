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
    public function register(): void
    {
        
    }
//  Bootstrap any application services.
    //  public function boot(): void {}


    public function boot(): void
    {
        FileUpload::configureUsing(function (FileUpload $component): void {
            $component
                ->imagePreviewHeight('120')
                ->panelLayout('compact')
                ->itemPanelAspectRatio(null);
        });

        // if ($this->app->environment('production') || str_starts_with((string) config('app.url'), 'https://')) {
        //     URL::forceScheme('https');
        // }

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

        View::composer('partials.footer', function ($view): void {
            $footerTravelStyleDefinitions = [
                [
                    'id' => 'honeymoon',
                    'label' => 'Honeymoon',
                    'keys' => ['honeymoon'],
                ],
                [
                    'id' => 'religious',
                    'label' => 'Religious',
                    'keys' => ['religiuos', 'religious'],
                ],
                [
                    'id' => 'family',
                    'label' => 'Family',
                    'keys' => ['family'],
                ],
                [
                    'id' => 'adventure',
                    'label' => 'Adventure',
                    'keys' => ['adventure'],
                ],
                [
                    'id' => 'friends',
                    'label' => 'Friends',
                    'keys' => ['friends'],
                ],
                [
                    'id' => 'corporate-tour',
                    'label' => 'Corporate Tour',
                    'keys' => ['corporate tour'],
                ],
                [
                    'id' => 'solo',
                    'label' => 'Solo',
                    'keys' => ['solo'],
                ],
                [
                    'id' => 'nature',
                    'label' => 'Nature',
                    'keys' => ['nature'],
                ],
                [
                    'id' => 'wildlife',
                    'label' => 'Wildlife',
                    'keys' => ['wildlife'],
                ],
                [
                    'id' => 'water-activities',
                    'label' => 'Water Activities',
                    'keys' => ['water activities'],
                ],
            ];

            $footerDestinationsByTravelStyle = function (array $keys) {
                return Destination::query()
                    ->active()
                    ->where(function ($query) use ($keys): void {
                        foreach ($keys as $key) {
                            $query->orWhereJsonContains('travel_styles', $key);
                        }
                    })
                    ->orderByDesc('rating')
                    ->orderByDesc('id')
                    ->limit(30)
                    ->get(['name', 'slug', 'country', 'type', 'rating', 'travel_styles']);
            };

            $footerTravelStyleTabs = collect($footerTravelStyleDefinitions)
                ->map(function (array $style) use ($footerDestinationsByTravelStyle): array {
                    $style['destinations'] = $footerDestinationsByTravelStyle($style['keys']);

                    return $style;
                })
                ->all();

            $footerDomesticDestinations = Destination::query()
                ->active()
                ->domestic()
                ->orderByDesc('rating')
                ->orderByDesc('id')
                ->limit(30)
                ->get(['name', 'slug', 'country', 'type', 'rating']);

            $footerInternationalDestinations = Destination::query()
                ->active()
                ->international()
                ->orderByDesc('rating')
                ->orderByDesc('id')
                ->limit(30)
                ->get(['name', 'slug', 'country', 'type', 'rating']);

            $view->with([
                'footerDomesticDestinations' => $footerDomesticDestinations,
                'footerInternationalDestinations' => $footerInternationalDestinations,
                'footerTravelStyleTabs' => $footerTravelStyleTabs,
            ]);
        });
    }
}

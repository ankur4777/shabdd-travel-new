<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class DomesticTourController extends Controller
{
    public function under25k()
    {
        // Fetch packages under 25k
        $packages = Package::where('type', 'domestic')
            ->where('price', '<=', 25000)
            ->get();

        return view('domestic-tours.under-25k', compact('packages'));
    }

    public function summerVacationSpecials(Request $request): View
    {
        return $this->renderSeasonSpecials($request, 'summer_vacation_special', 'summer');
    }

    public function winterVacationSpecials(Request $request): View
    {
        return $this->renderSeasonSpecials($request, 'winter_vacation_special', 'winter');
    }

    public function monsoonSpecials(Request $request): View
    {
        return $this->renderSeasonSpecials($request, 'monsoon_special', 'monsoon');
    }

    public function honeymoonPicks()
    {
        // Fetch honeymoon category packages
        $packages = Package::where('type', 'domestic')
            ->where('category', 'honeymoon')
            ->get();

        return view('domestic-tours.honeymoon-picks', compact('packages'));
    }

    public function allDomestic()
    {
        $packages = Package::where('type', 'domestic')->get();

        return view('domestic-tours.all-domestic', compact('packages'));
    }

    private function renderSeasonSpecials(Request $request, string $seasonColumn, string $seasonKey): View
    {
        $baseQuery = $this->seasonPackagesQuery($seasonColumn);

        $allPackages = (clone $baseQuery)
            ->orderByDesc('featured')
            ->orderBy('price')
            ->get();

        $filteredQuery = clone $baseQuery;
        $this->applySeasonFilters($filteredQuery, $request);

        $packages = $filteredQuery
            ->orderByDesc('featured')
            ->orderBy('price')
            ->get();

        return view('domestic-tours.seasonal-specials', array_merge(
            $this->seasonPageConfig($seasonKey),
            [
                'packages' => $packages,
                'allPackages' => $allPackages,
                'destinationOptions' => $this->buildDestinationOptions($allPackages),
                'travelStyleOptions' => $this->buildTravelStyleOptions($allPackages),
                'durationOptions' => $this->durationOptions(),
                'selectedMinPrice' => (string) $request->input('min_price', ''),
                'selectedMaxPrice' => (string) $request->input('max_price', ''),
                'selectedDestination' => (string) $request->input('destination', ''),
                'selectedTravelStyle' => (string) $request->input('travel_style', ''),
                'selectedDuration' => (string) $request->input('duration', ''),
                'seasonTabs' => $this->seasonTabs($seasonKey),
            ]
        ));
    }

    private function seasonPackagesQuery(string $seasonColumn): Builder
    {
        return Package::query()
            ->whereRaw('LOWER(COALESCE(type, \'\')) = ?', ['domestic'])
            ->where($seasonColumn, true);
    }

    private function applySeasonFilters(Builder $query, Request $request): void
    {
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $destination = trim((string) $request->input('destination', ''));
        $travelStyle = trim((string) $request->input('travel_style', ''));
        $duration = trim((string) $request->input('duration', ''));

        if ($minPrice !== null && $minPrice !== '') {
            $query->where('price', '>=', (int) $minPrice);
        }

        if ($maxPrice !== null && $maxPrice !== '') {
            $query->where('price', '<=', (int) $maxPrice);
        }

        if ($destination !== '') {
            $normalizedDestination = strtolower($destination);

            $query->where(function (Builder $locationQuery) use ($normalizedDestination) {
                $locationQuery
                    ->whereRaw('LOWER(COALESCE(city, \'\')) = ?', [$normalizedDestination])
                    ->orWhereRaw('LOWER(COALESCE(state, \'\')) = ?', [$normalizedDestination])
                    ->orWhereRaw('LOWER(COALESCE(country, \'\')) = ?', [$normalizedDestination]);
            });
        }

        if ($travelStyle !== '') {
            $query->whereRaw('LOWER(COALESCE(travel_style, \'\')) = ?', [strtolower($travelStyle)]);
        }

        if ($duration !== '') {
            $query->where(function (Builder $durationQuery) use ($duration) {
                match ($duration) {
                    'short' => $durationQuery->where('days', '<=', 3),
                    'medium' => $durationQuery->whereBetween('days', [4, 6]),
                    'long' => $durationQuery->where('days', '>=', 7),
                    default => null,
                };
            });
        }
    }

    private function buildDestinationOptions(Collection $packages): array
    {
        return $packages
            ->map(fn (Package $package) => collect([
                trim((string) $package->city),
                trim((string) $package->state),
                trim((string) $package->country),
            ])->filter()->first())
            ->filter()
            ->unique(fn (string $value) => strtolower($value))
            ->sort()
            ->values()
            ->all();
    }

    private function buildTravelStyleOptions(Collection $packages): array
    {
        return $packages
            ->pluck('travel_style')
            ->filter()
            ->map(fn ($style) => [
                'value' => strtolower((string) $style),
                'label' => str($style)->headline()->toString(),
            ])
            ->unique('value')
            ->sortBy('label')
            ->values()
            ->all();
    }

    private function durationOptions(): array
    {
        return [
            ['value' => '', 'label' => 'Any duration'],
            ['value' => 'short', 'label' => '1 to 3 days'],
            ['value' => 'medium', 'label' => '4 to 6 days'],
            ['value' => 'long', 'label' => '7+ days'],
        ];
    }

    private function seasonTabs(string $seasonKey): array
    {
        return [
            [
                'label' => 'Summer Vacation Specials',
                'route' => route('summer-vacation-specials'),
                'active' => $seasonKey === 'summer',
            ],
            [
                'label' => 'Winter Vacation Specials',
                'route' => route('winter-vacation-specials'),
                'active' => $seasonKey === 'winter',
            ],
            [
                'label' => 'Monsoon Specials',
                'route' => route('monsoon-specials'),
                'active' => $seasonKey === 'monsoon',
            ],
        ];
    }

    private function seasonPageConfig(string $seasonKey): array
    {
        $configs = [
            'summer' => [
                'pageTitle' => 'Summer Vacation Specials',
                'heroKicker' => 'Sun-drenched escapes',
                'heroSubtitle' => 'Bright, breezy packages for school holidays, long weekends, and easy summer breaks.',
                'heroHighlight' => 'Perfect for families, friends, and cool hill-station escapes.',
                'heroBadge' => 'Summer pick',
                'heroImage' => asset('images/all-domestic-hero.jpg'),
                'accent' => '#f97316',
                'accentSoft' => 'rgba(249, 115, 22, 0.16)',
                'accentGlow' => 'rgba(14, 165, 233, 0.18)',
                'heroStatValue' => 'Summer',
                'heroStatLabel' => 'Vacation-ready packages',
                'heroStatSecondValue' => 'Fresh',
                'heroStatSecondLabel' => 'Top handpicked deals',
                'heroStatThirdValue' => 'Flexible',
                'heroStatThirdLabel' => 'Budget to premium options',
                'introTitle' => 'Build Your Summer Escape',
                'introText' => 'Use the filters to narrow down packages that fit your budget, destination preference, and trip length.',
                'essentialTitle' => 'Summer Travel Essentials',
                'essentialLead' => 'Quick guidance to help you choose the right summer package before you book.',
                'essentialCards' => [
                    ['icon' => 'bi bi-sun-fill', 'title' => 'Best for', 'text' => 'Hill stations, beaches, and relaxed family itineraries with cooler climates.'],
                    ['icon' => 'bi bi-bag-check-fill', 'title' => 'Pack smart', 'text' => 'Cotton layers, sunscreen, sunglasses, a light jacket, and comfortable shoes.'],
                    ['icon' => 'bi bi-calendar-heart-fill', 'title' => 'Ideal window', 'text' => 'School vacations, May to June breaks, and any long weekend that needs a quick reset.'],
                ],
                'ctaTitle' => 'Need a custom summer plan?',
                'ctaText' => 'Share your budget and preferred destination, and we will shape a package around your travel dates.',
            ],
            'winter' => [
                'pageTitle' => 'Winter Vacation Specials',
                'heroKicker' => 'Snow-kissed escapes',
                'heroSubtitle' => 'Warm stays, mountain views, and festive itineraries curated for the cooler months.',
                'heroHighlight' => 'Great for hill stations, scenic drives, and cozy family getaways.',
                'heroBadge' => 'Winter pick',
                'heroImage' => asset('images/kerala.avif'),
                'accent' => '#2563eb',
                'accentSoft' => 'rgba(37, 99, 235, 0.16)',
                'accentGlow' => 'rgba(59, 130, 246, 0.18)',
                'heroStatValue' => 'Winter',
                'heroStatLabel' => 'Seasonal escapes',
                'heroStatSecondValue' => 'Cozy',
                'heroStatSecondLabel' => 'Comfort-focused trips',
                'heroStatThirdValue' => 'Scenic',
                'heroStatThirdLabel' => 'Snow and mountain views',
                'introTitle' => 'Plan Your Winter Break',
                'introText' => 'Filter for the best cold-weather packages and make the most of festive travel windows.',
                'essentialTitle' => 'Winter Travel Essentials',
                'essentialLead' => 'A quick guide for choosing comfortable winter packages.',
                'essentialCards' => [
                    ['icon' => 'bi bi-snow', 'title' => 'Best for', 'text' => 'Snow lovers, mountain resorts, and festive season holidays.'],
                    ['icon' => 'bi bi-bag-check-fill', 'title' => 'Pack smart', 'text' => 'Thermals, jackets, gloves, warm socks, and slip-resistant shoes.'],
                    ['icon' => 'bi bi-calendar-heart-fill', 'title' => 'Ideal window', 'text' => 'November to February for most pleasant winter travel plans.'],
                ],
                'ctaTitle' => 'Looking for a winter holiday?',
                'ctaText' => 'Tell us your dates and we will shortlist the best winter package options for your trip.',
            ],
            'monsoon' => [
                'pageTitle' => 'Monsoon Specials',
                'heroKicker' => 'Rainwashed getaways',
                'heroSubtitle' => 'Green landscapes, quieter stays, and value-focused itineraries for the rainy season.',
                'heroHighlight' => 'Best for lush scenery, romantic breaks, and budget-friendly travel windows.',
                'heroBadge' => 'Monsoon pick',
                'heroImage' => asset('images/dubai.jpg'),
                'accent' => '#0f766e',
                'accentSoft' => 'rgba(15, 118, 110, 0.16)',
                'accentGlow' => 'rgba(14, 165, 233, 0.18)',
                'heroStatValue' => 'Monsoon',
                'heroStatLabel' => 'Green-season deals',
                'heroStatSecondValue' => 'Calm',
                'heroStatSecondLabel' => 'Lower crowd travel',
                'heroStatThirdValue' => 'Fresh',
                'heroStatThirdLabel' => 'Scenic rain-soaked views',
                'introTitle' => 'Plan a Monsoon Escape',
                'introText' => 'Choose packages that feel right for rain-friendly sightseeing, romance, and value.',
                'essentialTitle' => 'Monsoon Travel Essentials',
                'essentialLead' => 'Useful tips for booking and packing when the weather turns rainy.',
                'essentialCards' => [
                    ['icon' => 'bi bi-cloud-rain-fill', 'title' => 'Best for', 'text' => 'Nature lovers, couples, and travelers who enjoy lush, quieter destinations.'],
                    ['icon' => 'bi bi-bag-check-fill', 'title' => 'Pack smart', 'text' => 'Light rainwear, quick-dry clothes, waterproof footwear, and a compact umbrella.'],
                    ['icon' => 'bi bi-calendar-heart-fill', 'title' => 'Ideal window', 'text' => 'June to September for the classic monsoon travel mood.'],
                ],
                'ctaTitle' => 'Want a rain-friendly itinerary?',
                'ctaText' => 'We can help you choose destinations and stays that work well in the monsoon season.',
            ],
        ];

        return $configs[$seasonKey] ?? $configs['summer'];
    }
}

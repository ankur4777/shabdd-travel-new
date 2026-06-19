<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class DomesticTourController extends Controller
{
    public function under25k(Request $request): View
    {
        $baseQuery = Package::query()
            ->where('price', '>', 0)
            ->where('price', '<=', 25000);

        $this->applyDomesticScope($baseQuery);

        $allPackages = (clone $baseQuery)
            ->orderByDesc('featured')
            ->orderByDesc('rating')
            ->orderBy('price')
            ->get();

        $filteredQuery = clone $baseQuery;
        $selectedDestination = trim((string) $request->input('destination', ''));
        $selectedDuration = trim((string) $request->input('duration', ''));
        $selectedMonth = trim((string) $request->input('month', ''));
        $selectedSort = trim((string) $request->input('sort', 'popularity'));

        $this->applyUnder25kFilters($filteredQuery, $selectedDestination, $selectedDuration, $selectedMonth);
        $this->applyUnder25kSort($filteredQuery, $selectedSort);

        $packages = $filteredQuery->get();
        $destinationOptions = $this->buildUnder25kDestinationOptions($allPackages);
        $popularDestinations = $this->buildUnder25kPopularDestinations($allPackages);
        $budgetCategories = $this->buildUnder25kBudgetCategories($allPackages);

        return view('domestic-tours.under-25k', [
            'packages' => $packages,
            'allPackages' => $allPackages,
            'destinationOptions' => $destinationOptions,
            'popularDestinations' => $popularDestinations,
            'budgetCategories' => $budgetCategories,
            'monthOptions' => $this->under25kMonthOptions(),
            'selectedDestination' => $selectedDestination,
            'selectedDuration' => $selectedDuration,
            'selectedMonth' => $selectedMonth,
            'selectedSort' => $selectedSort,
            'packageCount' => $packages->count(),
            'startingPrice' => (int) ($allPackages->min('price') ?? 0),
            'maxPrice' => (int) ($allPackages->max('price') ?? 25000),
        ]);
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

    private function applyUnder25kFilters(
        Builder $query,
        string $selectedDestination,
        string $selectedDuration,
        string $selectedMonth
    ): void {
        if ($selectedDestination !== '') {
            $search = '%' . strtolower($selectedDestination) . '%';

            $query->where(function (Builder $locationQuery) use ($search) {
                $locationQuery
                    ->whereRaw('LOWER(COALESCE(title, \'\')) LIKE ?', [$search])
                    ->orWhereRaw('LOWER(COALESCE(city, \'\')) LIKE ?', [$search])
                    ->orWhereRaw('LOWER(COALESCE(state, \'\')) LIKE ?', [$search])
                    ->orWhereRaw('LOWER(COALESCE(country, \'\')) LIKE ?', [$search]);
            });
        }

        if ($selectedDuration !== '') {
            match ($selectedDuration) {
                '2-4' => $query->whereBetween('days', [2, 4]),
                '4-6' => $query->whereBetween('days', [4, 6]),
                '6-8' => $query->whereBetween('days', [6, 8]),
                '8+' => $query->where('days', '>=', 8),
                default => null,
            };
        }

        $seasonColumn = $this->under25kMonthSeasonColumn($selectedMonth);

        if ($seasonColumn !== null && $this->packageHasColumn($seasonColumn)) {
            $query->where(function (Builder $seasonQuery) use ($seasonColumn) {
                $seasonQuery
                    ->where($seasonColumn, true)
                    ->orWhere(function (Builder $fallbackQuery) {
                        $fallbackQuery
                            ->where(function (Builder $innerQuery) {
                                $innerQuery
                                    ->whereNull('summer_vacation_special')
                                    ->orWhere('summer_vacation_special', false);
                            })
                            ->where(function (Builder $innerQuery) {
                                $innerQuery
                                    ->whereNull('winter_vacation_special')
                                    ->orWhere('winter_vacation_special', false);
                            })
                            ->where(function (Builder $innerQuery) {
                                $innerQuery
                                    ->whereNull('monsoon_special')
                                    ->orWhere('monsoon_special', false);
                            });
                    });
            });
        }
    }

    private function applyUnder25kSort(Builder $query, string $selectedSort): void
    {
        match ($selectedSort) {
            'price_low' => $query->orderBy('price')->orderByDesc('rating')->orderByDesc('id'),
            'duration' => $query->orderBy('days')->orderBy('price')->orderByDesc('id'),
            default => $query->orderByDesc('featured')->orderByDesc('rating')->orderBy('price')->orderByDesc('id'),
        };
    }

    private function buildUnder25kDestinationOptions(Collection $packages): array
    {
        return $packages
            ->map(function (Package $package): ?string {
                return collect([
                    trim((string) $package->city),
                    trim((string) $package->state),
                    trim((string) $package->country),
                ])->filter()->first();
            })
            ->filter()
            ->unique(fn (string $value) => strtolower($value))
            ->sort()
            ->values()
            ->all();
    }

    private function buildUnder25kPopularDestinations(Collection $packages): Collection
    {
        $priorityNames = [
            'Manali',
            'Shimla',
            'Kashmir',
            'Goa',
            'Jaipur',
            'Udaipur',
            'Kerala',
            'Rishikesh',
            'Varanasi',
            'Darjeeling',
        ];

        return collect($priorityNames)
            ->map(function (string $name) use ($packages): ?array {
                $matching = $packages->filter(function (Package $package) use ($name): bool {
                    $haystack = strtolower(implode(' ', array_filter([
                        $package->title,
                        $package->city,
                        $package->state,
                        $package->country,
                    ])));

                    return str_contains($haystack, strtolower($name));
                })->values();

                if ($matching->isEmpty()) {
                    return null;
                }

                /** @var Package $primaryPackage */
                $primaryPackage = $matching->sort(function (Package $left, Package $right): int {
                    $leftRank = [
                        (int) $left->featured,
                        (float) ($left->rating ?? 0),
                        -1 * (int) ($left->price ?? PHP_INT_MAX),
                    ];
                    $rightRank = [
                        (int) $right->featured,
                        (float) ($right->rating ?? 0),
                        -1 * (int) ($right->price ?? PHP_INT_MAX),
                    ];

                    return $rightRank <=> $leftRank;
                })->first();

                return [
                    'name' => $name,
                    'count' => $matching->count(),
                    'starting_price' => (int) ($matching->min('price') ?? 0),
                    'image' => $this->packageImageUrl($primaryPackage),
                    'url' => route('packages.show', $primaryPackage->slug),
                ];
            })
            ->filter()
            ->values();
    }

    private function buildUnder25kBudgetCategories(Collection $packages): array
    {
        $bands = [
            ['label' => 'Under ₹10,000', 'min' => 0, 'max' => 10000],
            ['label' => '₹10,000 - ₹15,000', 'min' => 10001, 'max' => 15000],
            ['label' => '₹15,000 - ₹20,000', 'min' => 15001, 'max' => 20000],
            ['label' => '₹20,000 - ₹25,000', 'min' => 20001, 'max' => 25000],
        ];

        return collect($bands)
            ->map(function (array $band) use ($packages): array {
                $matching = $packages->whereBetween('price', [$band['min'], $band['max']])->values();

                return [
                    'label' => $band['label'],
                    'count' => $matching->count(),
                    'starting_price' => (int) ($matching->min('price') ?? 0),
                    'destinations' => $matching
                        ->map(fn (Package $package) => trim((string) ($package->city ?: $package->state ?: $package->country)))
                        ->filter()
                        ->unique(fn (string $value) => strtolower($value))
                        ->take(3)
                        ->values()
                        ->all(),
                ];
            })
            ->all();
    }

    private function under25kMonthOptions(): array
    {
        return [
            ['value' => '', 'label' => 'Any month'],
            ['value' => 'january', 'label' => 'January'],
            ['value' => 'february', 'label' => 'February'],
            ['value' => 'march', 'label' => 'March'],
            ['value' => 'april', 'label' => 'April'],
            ['value' => 'may', 'label' => 'May'],
            ['value' => 'june', 'label' => 'June'],
            ['value' => 'july', 'label' => 'July'],
            ['value' => 'august', 'label' => 'August'],
            ['value' => 'september', 'label' => 'September'],
            ['value' => 'october', 'label' => 'October'],
            ['value' => 'november', 'label' => 'November'],
            ['value' => 'december', 'label' => 'December'],
        ];
    }

    private function under25kMonthSeasonColumn(string $selectedMonth): ?string
    {
        return match ($selectedMonth) {
            'march', 'april', 'may', 'june' => 'summer_vacation_special',
            'july', 'august', 'september' => 'monsoon_special',
            'october', 'november', 'december', 'january', 'february' => 'winter_vacation_special',
            default => null,
        };
    }

    private function packageImageUrl(Package $package): string
    {
        if (blank($package->image)) {
            return asset('images/couple-bg.jpg');
        }

        if (Str::startsWith($package->image, ['http://', 'https://'])) {
            return $package->image;
        }

        return asset('storage/' . ltrim((string) $package->image, '/'));
    }

    private function applyDomesticScope(Builder $query): void
    {
        if ($this->packageHasColumn('type')) {
            $query->whereRaw('LOWER(COALESCE(type, \'\')) = ?', ['domestic']);

            return;
        }

        if ($this->packageHasColumn('country')) {
            $query->where(function (Builder $countryQuery) {
                $countryQuery
                    ->whereNull('country')
                    ->orWhereRaw('TRIM(COALESCE(country, \'\')) = ?', [''])
                    ->orWhereRaw('LOWER(TRIM(COALESCE(country, \'\'))) = ?', ['india']);
            });
        }
    }

    private function packageHasColumn(string $column): bool
    {
        static $columns;

        $columns ??= array_flip(Schema::getColumnListing('packages'));

        return isset($columns[$column]);
    }
}

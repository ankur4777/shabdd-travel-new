<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Package;
use App\Support\MediaUrl;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Models\SeasonalJourney;

class HomeController extends Controller
{
    public function index(): View
    {
        $destinations = Destination::query()
            ->active()
            ->whereRaw("LOWER(TRIM(COALESCE(category, ''))) = ?", ['trending'])
            ->latest()
            ->take(12)
            ->get();

        $popularDestinations = Destination::query()
            ->active()
            ->whereRaw("LOWER(TRIM(COALESCE(category, ''))) = ?", ['popular'])
            ->orderByDesc('rating')
            ->latest()
            ->take(12)
            ->get();

        $packagesForPriceDisplay = Package::query()
            ->whereNotNull('price')
            ->where('price', '>', 0)
            ->get(['title', 'country', 'state', 'city', 'price']);

        $this->attachLowestPackagePrices($destinations, $packagesForPriceDisplay);
        $this->attachLowestPackagePrices($popularDestinations, $packagesForPriceDisplay);

        $blogController = new BlogController();
        $blogs = $blogController->buildBlogCollection()->take(6);
        $seasonalJourneys = SeasonalJourney::active()->get();
        $discoverDestinations = $this->homeDiscoverDestinations();
        $discoverDestinationOptions = $discoverDestinations
            ->map(fn(Destination $destination) => [
                'slug' => $destination->slug,
                'name' => $destination->name,
            ])
            ->values();
        $discoverDestinationCards = $discoverDestinations
            ->map(fn(Destination $destination) => $this->homeDiscoverDestinationCard($destination))
            ->values();

        return view('home', compact(
            'destinations',
            'popularDestinations',
            'blogs',
            'seasonalJourneys',
            'discoverDestinationOptions',
            'discoverDestinationCards'
        ));
    }

    private function attachLowestPackagePrices(Collection $destinations, Collection $packages): void
    {
        $destinations->each(function (Destination $destination) use ($packages): void {
            $lowestPackagePrice = $this->lowestPackagePriceForDestination($destination, $packages);
            $displayPrice = $lowestPackagePrice ?: (int) ($destination->price_from ?? 0);

            $destination->setAttribute('home_price_from', $displayPrice);
            $destination->setAttribute(
                'home_price_label',
                $displayPrice > 0 ? '₹' . number_format($displayPrice) : 'On Request'
            );
        });
    }

    private function lowestPackagePriceForDestination(Destination $destination, Collection $packages): ?int
    {
        $terms = collect([
            $destination->name,
            Str::of((string) $destination->slug)->replace('-', ' ')->value(),
            $destination->country && strtolower(trim((string) $destination->country)) !== 'india'
                ? $destination->country
                : null,
        ])
            ->map(fn($term) => strtolower(trim((string) $term)))
            ->filter(fn(string $term) => $term !== '')
            ->unique()
            ->values();

        if ($terms->isEmpty()) {
            return null;
        }

        return $packages
            ->filter(function (Package $package) use ($terms): bool {
                $haystack = strtolower(trim(collect([
                    $package->title,
                    $package->country,
                    $package->state,
                    $package->city,
                ])->filter()->implode(' ')));

                return $haystack !== ''
                    && $terms->contains(fn(string $term) => Str::contains($haystack, $term));
            })
            ->min('price');
    }

    private function homeDiscoverDestinations(): Collection
    {
        return Destination::query()
            ->active()
            ->orderByDesc('is_trending')
            ->orderByDesc('rating')
            ->latest('id')
            ->take(12)
            ->get();
    }

    private function homeDiscoverDestinationCard(Destination $destination): array
    {
        $durationLabel = (string) ($destination->ideal_duration ?: $destination->ideal_days ?: 'Flexible Duration');
        $durationKey = $this->homeDiscoverDurationKey($durationLabel);
        $travelTags = $this->homeDiscoverTravelTags($destination);
        $highlights = $this->homeDiscoverHighlights($destination, $durationLabel);
        $badge = $this->homeDiscoverBadge($destination);

        return [
            'slug' => $destination->slug,
            'name' => $destination->name,
            'location' => $destination->location ?: $destination->country ?: 'India',
            'image' => $this->homeDiscoverImage($destination),
            'rating' => $destination->rating ? number_format((float) $destination->rating, 1) : '4.5',
            'price' => (int) ($destination->price_from ?? 0),
            'price_label' => $destination->formatted_price ?: ((int) ($destination->price_from ?? 0) > 0 ? '₹' . number_format((int) $destination->price_from) : 'On Request'),
            'duration_label' => $durationLabel,
            'duration_key' => $durationKey,
            'category_key' => Str::slug((string) ($destination->category ?: $badge['sort_tag'])),
            'travel_tags' => $travelTags,
            'highlights' => $highlights,
            'destination_type' => $this->homeDiscoverDestinationType($destination),
            'season_keys' => $this->homeDiscoverSeasonKeys($destination),
            'badge' => $badge,
            'url' => route('destinations.show', $destination),
        ];
    }

    private function homeDiscoverImage(Destination $destination): string
    {
        return MediaUrl::asset($destination->image_url ?: $destination->hero_image);
    }

    private function homeDiscoverDurationKey(string $durationLabel): string
    {
        $days = (int) (Str::of($durationLabel)->match('/\d+/')->value() ?? 0);

        return match (true) {
            $days > 0 && $days <= 2 => 'weekend',
            $days >= 3 && $days <= 5 => '3-5',
            $days >= 6 && $days <= 7 => '5-7',
            $days >= 8 => '7+',
            default => '5-7',
        };
    }

    private function homeDiscoverTravelTags(Destination $destination): Collection
    {
        $travelStyleOptions = $this->homeTravelStyleOptions();

        return $this->homeDiscoverTextCollection($destination->travel_styles ?? [])
            ->map(fn($value) => trim((string) $value))
            ->filter(fn(string $value) => array_key_exists($value, $travelStyleOptions))
            ->map(fn(string $value) => $travelStyleOptions[$value])
            ->unique()
            ->values();
    }

    private function homeTravelStyleOptions(): array
    {
        return [
            'honeymoon' => 'Honeymoon',
            'religiuos' => 'Religious',
            'religious' => 'Religious',
            'family' => 'Family',
            'adventure' => 'Adventure',
            'friends' => 'Friends',
            'corporate tour' => 'Corporate Tour',
            'solo' => 'Solo',
            'nature' => 'Nature',
            'wildlife' => 'Wildlife',
            'water activities' => 'Water Activities',
        ];
    }

    private function homeDiscoverHighlights(Destination $destination, string $durationLabel): Collection
    {
        $items = collect([$durationLabel])
            ->merge($this->homeDiscoverTextCollection($destination->highlights ?? [])->take(2))
            ->merge($this->homeDiscoverTextCollection($destination->places ?? [])->take(2))
            ->merge($this->homeDiscoverTextCollection($destination->features ?? [])->take(2))
            ->merge($this->homeDiscoverTravelTags($destination))
            ->filter()
            ->map(fn($value) => trim(strip_tags((string) $value)))
            ->filter()
            ->unique()
            ->take(3)
            ->values();

        return $items->isNotEmpty()
            ? $items
            : collect([$durationLabel, 'Curated Stay', 'Local Highlights'])->take(3)->values();
    }

    private function homeDiscoverDestinationType(Destination $destination): string
    {
        $type = strtolower(trim((string) $destination->type));

        if (in_array($type, ['domestic', 'international'], true)) {
            return $type;
        }

        $country = strtolower(trim((string) $destination->country));

        return in_array($country, ['', 'india'], true) ? 'domestic' : 'international';
    }

    private function homeDiscoverSeasonKeys(Destination $destination): string
    {
        $terms = $this->homeDiscoverTextCollection(
            $destination->seasons ?? [],
            $destination->recommended_months ?? [],
            [$destination->best_season]
        )
            ->map(fn($value) => strtolower($value))
            ->implode(' ');

        $keys = collect();

        if (Str::contains($terms, ['summer', 'april', 'may', 'june'])) {
            $keys->push('summer');
        }

        if (Str::contains($terms, ['winter', 'november', 'december', 'january', 'february'])) {
            $keys->push('winter');
        }

        if (Str::contains($terms, ['monsoon', 'rain', 'july', 'august', 'september'])) {
            $keys->push('monsoon');
        }

        if (Str::contains($terms, ['december'])) {
            $keys->push('december');
        }

        return $keys->filter()->unique()->values()->implode(',');
    }

    private function homeDiscoverTextCollection(mixed ...$sources): Collection
    {
        return collect($sources)
            ->flatMap(fn($source) => $this->homeDiscoverNormalizeTextValues($source))
            ->filter()
            ->values();
    }

    private function homeDiscoverNormalizeTextValues(mixed $value): Collection
    {
        if ($value instanceof Collection) {
            return $value->flatMap(fn($item) => $this->homeDiscoverNormalizeTextValues($item));
        }

        if (is_array($value)) {
            if ($this->homeDiscoverIsAssoc($value)) {
                foreach (['name', 'title', 'label', 'value', 'season', 'month'] as $key) {
                    if (!empty($value[$key])) {
                        return $this->homeDiscoverNormalizeTextValues($value[$key]);
                    }
                }
            }

            return collect($value)->flatMap(fn($item) => $this->homeDiscoverNormalizeTextValues($item));
        }

        $text = trim(strip_tags((string) $value));

        return $text === '' ? collect() : collect([$text]);
    }

    private function homeDiscoverIsAssoc(array $value): bool
    {
        return array_keys($value) !== range(0, count($value) - 1);
    }

    private function homeDiscoverBadge(Destination $destination): array
    {
        $label = trim((string) ($destination->badge_label ?: ''));
        $type = strtolower(trim((string) ($destination->badge_type ?: '')));
        $categoryLabel = trim((string) ($destination->category ?: ''));
        $category = strtolower($categoryLabel);
        $displayLabel = $categoryLabel !== '' ? $categoryLabel : $label;

        if ($category === 'trending' || ($categoryLabel === '' && $destination->is_trending)) {
            return [
                'label' => $displayLabel !== '' ? $displayLabel : 'Trending',
                'class' => 'df-badge--trending',
                'sort_tag' => 'trending',
            ];
        }

        if (in_array($category, ['premium', 'luxury'], true) || ($categoryLabel === '' && $type === 'luxury')) {
            return [
                'label' => $displayLabel !== '' ? $displayLabel : 'Luxury',
                'class' => 'df-badge--luxury',
                'sort_tag' => 'luxury',
            ];
        }

        if ($displayLabel !== '' && in_array($type, ['trending', 'bestseller', 'luxury'], true)) {
            return [
                'label' => $displayLabel,
                'class' => 'df-badge--' . $type,
                'sort_tag' => $type,
            ];
        }

        return [
            'label' => $displayLabel !== '' ? $displayLabel : 'Bestseller',
            'class' => 'df-badge--bestseller',
            'sort_tag' => Str::slug($categoryLabel !== '' ? $categoryLabel : 'bestseller'),
        ];
    }

    public function familyTrips(Request $request): View
    {
        return $this->packageListing($request, 'family', 'family-trips');
    }

    public function honeymoon(Request $request): View
    {
        return $this->packageListing($request, 'honeymoon', 'honeymoon');
    }

    public function religious(Request $request): View
    {
        return $this->packageListing($request, 'religious', 'religious');
    }

    public function budgetFriendly(Request $request): View
    {
        return $this->packageCategoryListing($request, 'Budget Friendly', 'budget-friendly');
    }

    public function beachEscapes(Request $request): View|JsonResponse
    {
        $allBeachDestinations = $this->beachThemeDestinations();
        $destinationOptions = $this->beachDestinationOptions($allBeachDestinations);
        $budgetOptions = $this->beachBudgetOptions();
        $priceBounds = $this->beachPriceBounds($allBeachDestinations);
        $selectedDestination = trim((string) $request->input('destination', ''));
        $selectedBudget = trim((string) $request->input('budget', ''));
        $selectedDuration = trim((string) $request->input('duration', ''));
        $selectedTravelStyles = collect($request->input('travel_styles', []))
            ->map(fn($value) => trim((string) $value))
            ->filter()
            ->unique()
            ->values()
            ->all();
        $selectedSeasons = collect($request->input('seasons', []))
            ->map(fn($value) => trim((string) $value))
            ->filter()
            ->unique()
            ->values()
            ->all();
        [$selectedMinPrice, $selectedMaxPrice] = $this->beachBudgetRange($selectedBudget, $priceBounds);

        $beachDestinations = $this->filterBeachDestinations(
            $allBeachDestinations,
            $selectedDestination,
            $selectedMinPrice,
            $selectedMaxPrice,
            $selectedDuration,
            $selectedTravelStyles,
            $selectedSeasons
        );

        $beachTravelStyleOptions = $this->beachTravelStyleOptions($allBeachDestinations);
        $seasonOptions = $this->themeSeasonOptions();
        $beachPackages = $this->popularBeachPackages();

        $viewData = [
            'beachDestinations' => $beachDestinations,
            'destinationOptions' => $destinationOptions,
            'budgetOptions' => $budgetOptions,
            'beachTravelStyleOptions' => $beachTravelStyleOptions,
            'priceBounds' => $priceBounds,
            'selectedMinPrice' => $selectedMinPrice,
            'selectedMaxPrice' => $selectedMaxPrice,
            'selectedDestination' => $selectedDestination,
            'selectedBudget' => $selectedBudget,
            'selectedDuration' => $selectedDuration,
            'selectedTravelStyles' => $selectedTravelStyles,
            'selectedSeasons' => $selectedSeasons,
            'seasonOptions' => $seasonOptions,
            'beachPackages' => $beachPackages,
            'beachDestinationCount' => $beachDestinations->count(),
            'beachPackageCount' => $beachPackages->count(),
        ];

        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.beach-destination-results', $viewData)->render(),
            ]);
        }

        return view('beach-escapes', $viewData);
    }

    public function hillStationRetreats(Request $request): View|JsonResponse
    {
        return $this->travelThemePage($request, 'hill');
    }

    public function islandGetaways(Request $request): View|JsonResponse
    {
        return $this->travelThemePage($request, 'island');
    }

    public function desertAdventures(Request $request): View|JsonResponse
    {
        return $this->travelThemePage($request, 'desert');
    }

    private function travelThemePage(Request $request, string $themeKey): View|JsonResponse
    {
        $themeConfig = $this->travelThemeConfig($themeKey);

        if (empty($themeConfig)) {
            abort(404);
        }

        $allThemeDestinations = $this->buildTravelThemeDestinations($themeKey);
        $destinationOptions = $this->beachDestinationOptions($allThemeDestinations);
        $budgetOptions = $this->beachBudgetOptions();
        $priceBounds = $this->beachPriceBounds($allThemeDestinations);
        $selectedDestination = trim((string) $request->input('destination', ''));
        $selectedBudget = trim((string) $request->input('budget', ''));
        $selectedDuration = trim((string) $request->input('duration', ''));
        $selectedTravelStyles = collect($request->input('travel_styles', []))
            ->map(fn($value) => trim((string) $value))
            ->filter()
            ->unique()
            ->values()
            ->all();
        $selectedSeasons = collect($request->input('seasons', []))
            ->map(fn($value) => trim((string) $value))
            ->filter()
            ->unique()
            ->values()
            ->all();
        [$selectedMinPrice, $selectedMaxPrice] = $this->beachBudgetRange($selectedBudget, $priceBounds);

        $filteredDestinations = $this->filterBeachDestinations(
            $allThemeDestinations,
            $selectedDestination,
            $selectedMinPrice,
            $selectedMaxPrice,
            $selectedDuration,
            $selectedTravelStyles,
            $selectedSeasons
        );

        $travelStyleOptions = $this->beachTravelStyleOptions($allThemeDestinations);
        $seasonOptions = $this->themeSeasonOptions();
        $themePackages = $this->buildTravelThemePackages($themeKey);
        $listingRoute = route($this->travelThemeRouteName($themeKey));

        $viewData = array_merge($themeConfig, [
            'themeKey' => $themeKey,
            'themeName' => $themeConfig['hero']['title'] ?? Str::headline($themeKey),
            'listingRoute' => $listingRoute,
            'beachDestinations' => $filteredDestinations,
            'destinationOptions' => $destinationOptions,
            'budgetOptions' => $budgetOptions,
            'beachTravelStyleOptions' => $travelStyleOptions,
            'priceBounds' => $priceBounds,
            'selectedMinPrice' => $selectedMinPrice,
            'selectedMaxPrice' => $selectedMaxPrice,
            'selectedDestination' => $selectedDestination,
            'selectedBudget' => $selectedBudget,
            'selectedDuration' => $selectedDuration,
            'selectedTravelStyles' => $selectedTravelStyles,
            'selectedSeasons' => $selectedSeasons,
            'seasonOptions' => $seasonOptions,
            'beachPackages' => $themePackages,
            'beachDestinationCount' => $filteredDestinations->count(),
            'beachPackageCount' => $themePackages->count(),
        ]);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.travel-theme-destination-results', $viewData)->render(),
            ]);
        }

        return view('travel-theme', $viewData);
    }

    private function packageListing(Request $request, string $travelStyle, string $view): View
    {
        $baseQuery = Package::query()
            ->where('travel_style', $travelStyle);

        return $this->buildPackageListing($request, $baseQuery, $view);
    }

    private function packageCategoryListing(Request $request, string $category, string $view): View
    {
        $baseQuery = Package::query()
            ->where('category', $category);

        return $this->buildPackageListing($request, $baseQuery, $view);
    }

    private function buildPackageListing(Request $request, Builder $baseQuery, string $view, array $extraData = []): View
    {
        $priceStats = (clone $baseQuery)
            ->selectRaw('COALESCE(MIN(price), 0) as min_price, COALESCE(MAX(price), 0) as max_price')
            ->first();

        $priceBounds = [
            'min' => (int) ($priceStats->min_price ?? 0),
            'max' => (int) ($priceStats->max_price ?? 0),
        ];

        if ($priceBounds['max'] < $priceBounds['min']) {
            $priceBounds['max'] = $priceBounds['min'];
        }

        $selectedMinPrice = $this->sanitizePrice(
            $request->input('min_price'),
            $priceBounds['min'],
            $priceBounds['min'],
            $priceBounds['max']
        );

        $selectedMaxPrice = $this->sanitizePrice(
            $request->input('max_price'),
            $priceBounds['max'],
            $priceBounds['min'],
            $priceBounds['max']
        );

        if ($selectedMinPrice > $selectedMaxPrice) {
            [$selectedMinPrice, $selectedMaxPrice] = [$selectedMaxPrice, $selectedMinPrice];
        }

        $packagesQuery = clone $baseQuery;

        $this->applyPackageFilters($packagesQuery, $request, $selectedMinPrice, $selectedMaxPrice);
        $this->applyPackageSort($packagesQuery, (string) $request->input('sort', 'newest'));

        $packages = $packagesQuery->get();
        $packageCount = $packages->count();
        $destinations = Destination::query()
            ->active()
            ->orderBy('name')
            ->get(['name', 'slug', 'country']);

        return view($view, array_merge(compact(
            'packages',
            'packageCount',
            'destinations',
            'priceBounds',
            'selectedMinPrice',
            'selectedMaxPrice'
        ), $extraData));
    }

    private function applyPackageFilters(
        Builder $query,
        Request $request,
        int $selectedMinPrice,
        int $selectedMaxPrice
    ): void {
        $query->whereBetween('price', [$selectedMinPrice, $selectedMaxPrice]);

        if ($request->filled('destination')) {
            $destination = Destination::query()
                ->active()
                ->where('slug', $request->input('destination'))
                ->first();

            if ($destination) {
                $destinationName = '%' . $destination->name . '%';

                $query->where(function (Builder $query) use ($destinationName) {
                    $query
                        ->where('title', 'like', $destinationName)
                        ->orWhere('country', 'like', $destinationName)
                        ->orWhere('state', 'like', $destinationName)
                        ->orWhere('city', 'like', $destinationName);
                });
            }
        }

        if ($request->filled('rating')) {
            $rating = (int) $request->input('rating');

            if (in_array($rating, [3, 4, 5], true)) {
                $query->where('rating', '>=', $rating);
            }
        }

        if ($request->filled('duration')) {
            match ($request->input('duration')) {
                '1-3' => $query->whereBetween('days', [1, 3]),
                '4-6' => $query->whereBetween('days', [4, 6]),
                '7-plus' => $query->where('days', '>=', 7),
                default => null,
            };
        }
    }

    private function applyPackageSort(Builder $query, string $sort): void
    {
        match ($sort) {
            'low_to_high' => $query->orderBy('price')->orderByDesc('id'),
            'high_to_low' => $query->orderByDesc('price')->orderByDesc('id'),
            'highest_rated' => $query->orderByDesc('rating')->orderByDesc('id'),
            'most_popular' => $query->orderByDesc('featured')->orderByDesc('rating')->orderByDesc('id'),
            default => $query->latest(),
        };
    }

    private function beachThemeDestinations(): Collection
    {
        return Destination::query()
            ->active()
            ->whereRaw('LOWER(COALESCE(theme, \'\')) = ?', ['beach'])
            ->orderByDesc('rating')
            ->orderByDesc('is_trending')
            ->orderBy('name')
            ->get()
            ->map(function (Destination $destination): array {
                return [
                    'name' => $destination->name,
                    'slug' => $destination->slug,
                    'country' => $destination->country ?: 'India',
                    'duration' => $destination->ideal_duration ?: '3 to 5 Days',
                    'price_from' => (int) ($destination->price_from ?? 0),
                    'rating' => $destination->rating ? (float) $destination->rating : null,
                    'travel_styles' => collect($destination->travel_styles ?? [])
                        ->filter()
                        ->values()
                        ->all(),
                    'season_keys' => $this->themeDestinationSeasonKeys($destination),
                    'description' => $destination->short_description ?: 'A beach destination curated from the admin panel.',
                    'image' => $this->resolveMediaUrl($destination->image_url ?: $destination->hero_image),
                    'url' => route('destinations.show', $destination->slug),
                ];
            });
    }

    private function beachPriceBounds(Collection $destinations): array
    {
        $minPrice = (int) ($destinations->min('price_from') ?? 0);
        $maxPrice = (int) ($destinations->max('price_from') ?? 0);

        if ($maxPrice < $minPrice) {
            $maxPrice = $minPrice;
        }

        return [
            'min' => $minPrice,
            'max' => $maxPrice,
        ];
    }

    private function beachDestinationOptions(Collection $destinations): Collection
    {
        return $destinations
            ->sortBy('name')
            ->map(fn(array $destination) => [
                'value' => $destination['slug'],
                'label' => $destination['name'],
            ])
            ->values();
    }

    private function beachBudgetOptions(): array
    {
        return [
            ['value' => 'under_25k', 'label' => 'Under ₹25K'],
            ['value' => '25k_50k', 'label' => '₹25K – ₹50K'],
            ['value' => '50k_1l', 'label' => '₹50K – ₹1L'],
            ['value' => 'luxury_1l_plus', 'label' => 'Luxury ₹1L+'],
        ];
    }

    private function beachBudgetRange(string $budget, array $priceBounds): array
    {
        return match ($budget) {
            'under_25k' => [0, 25000],
            '25k_50k' => [25000, 50000],
            '50k_1l' => [50000, 100000],
            'luxury_1l_plus' => [100000, PHP_INT_MAX],
            default => [$priceBounds['min'], $priceBounds['max']],
        };
    }

    private function beachTravelStyleOptions(Collection $destinations): Collection
    {
        return $destinations
            ->flatMap(fn(array $destination) => $destination['travel_styles'] ?? [])
            ->map(fn($style) => trim((string) $style))
            ->filter()
            ->unique(fn(string $style) => Str::slug($style))
            ->sort()
            ->values();
    }

    private function filterBeachDestinations(
        Collection $destinations,
        string $selectedDestination,
        int $selectedMinPrice,
        int $selectedMaxPrice,
        string $selectedDuration,
        array $selectedTravelStyles,
        array $selectedSeasons = []
    ): Collection {
        return $destinations
            ->filter(function (array $destination) use (
                $selectedDestination,
                $selectedMinPrice,
                $selectedMaxPrice,
                $selectedDuration,
                $selectedTravelStyles,
                $selectedSeasons
            ) {
                if ($selectedDestination !== '' && $destination['slug'] !== $selectedDestination) {
                    return false;
                }

                $price = (int) ($destination['price_from'] ?? 0);

                if ($price < $selectedMinPrice || $price > $selectedMaxPrice) {
                    return false;
                }

                if ($selectedDuration !== '' && !$this->beachDestinationMatchesDuration($destination, $selectedDuration)) {
                    return false;
                }

                if (!empty($selectedTravelStyles)) {
                    $destinationStyles = collect($destination['travel_styles'] ?? [])
                        ->map(fn($style) => Str::slug((string) $style))
                        ->filter()
                        ->values()
                        ->all();

                    $matchesStyle = collect($selectedTravelStyles)
                        ->map(fn($style) => Str::slug((string) $style))
                        ->filter()
                        ->contains(fn(string $style) => in_array($style, $destinationStyles, true));

                    if (!$matchesStyle) {
                        return false;
                    }
                }

                if (!empty($selectedSeasons)) {
                    $destinationSeasons = collect($destination['season_keys'] ?? [])
                        ->map(fn($season) => Str::slug((string) $season))
                        ->filter()
                        ->values()
                        ->all();

                    $matchesSeason = collect($selectedSeasons)
                        ->map(fn($season) => Str::slug((string) $season))
                        ->filter()
                        ->contains(fn(string $season) => in_array($season, $destinationSeasons, true));

                    if (!$matchesSeason) {
                        return false;
                    }
                }

                return true;
            })
            ->values();
    }

    private function beachDestinationMatchesDuration(array $destination, string $selectedDuration): bool
    {
        $dayCount = $this->beachDestinationDayCount($destination);

        return match ($selectedDuration) {
            'weekend' => $dayCount > 0 && $dayCount <= 3,
            '3-5' => $dayCount >= 3 && $dayCount <= 5,
            '5-7' => $dayCount >= 5 && $dayCount <= 7,
            '7+' => $dayCount >= 7,
            default => true,
        };
    }

    private function beachDestinationDayCount(array $destination): int
    {
        $duration = trim((string) ($destination['duration'] ?? $destination['ideal_duration'] ?? ''));

        if ($duration === '') {
            return 0;
        }

        if (preg_match('/(\d+)\s*(?:-|–|to)\s*(\d+)/i', $duration, $matches)) {
            return (int) $matches[2];
        }

        if (preg_match('/(\d+)/', $duration, $matches)) {
            return (int) $matches[1];
        }

        return 0;
    }

    private function popularBeachPackages(): Collection
    {
        return Package::query()
            ->whereRaw('LOWER(COALESCE(theme, \'\')) = ?', ['beach'])
            ->whereRaw('LOWER(COALESCE(category, \'\')) = ?', ['popular'])
            ->orderByDesc('featured')
            ->orderByDesc('rating')
            ->orderBy('price')
            ->take(8)
            ->get();
    }

    private function resolveMediaUrl(?string $path): string
    {
        return MediaUrl::asset($path);
    }

    private function travelThemeConfig(string $themeKey): array
    {
        return config("travel_themes.{$themeKey}", []);
    }

    private function travelThemeRouteName(string $themeKey): string
    {
        return match ($themeKey) {
            'hill' => 'hill-station-retreats',
            'island' => 'island-getaways',
            'desert' => 'desert-adventures',
            default => 'beach-escapes',
        };
    }

    private function buildTravelThemeDestinations(string $themeKey): Collection
    {
        $themeValues = $this->travelThemeQueryValues($themeKey);

        return Destination::query()
            ->active()
            ->whereRaw('LOWER(TRIM(COALESCE(theme, \'\'))) IN (' . implode(',', array_fill(0, count($themeValues), '?')) . ')', $themeValues)
            ->orderByDesc('rating')
            ->orderByDesc('is_trending')
            ->orderBy('name')
            ->get()
            ->map(fn(Destination $destination) => $this->normalizeThemeDestinationFromModel($destination, []))
            ->values();
    }

    private function buildTravelThemePackages(string $themeKey): Collection
    {
        $themeValues = $this->travelThemeQueryValues($themeKey);

        return Package::query()
            ->whereRaw('LOWER(TRIM(COALESCE(theme, \'\'))) IN (' . implode(',', array_fill(0, count($themeValues), '?')) . ')', $themeValues)
            ->whereRaw('LOWER(TRIM(COALESCE(category, \'\'))) = ?', ['popular'])
            ->orderByDesc('featured')
            ->orderByDesc('rating')
            ->orderByDesc('id')
            ->get()
            ->map(fn(Package $package) => $this->normalizeThemePackageFromModel($package, [], $themeKey))
            ->values();
    }

    private function normalizeThemeDestinationFromModel(Destination $destination, array $definition): array
    {
        return [
            'name' => $destination->name,
            'slug' => $destination->slug,
            'country' => $destination->country ?: ($definition['country'] ?? 'India'),
            'duration' => $destination->ideal_duration ?: ($definition['duration'] ?? '3-5 Days'),
            'price_from' => (int) ($destination->price_from ?? ($definition['price_from'] ?? 0)),
            'rating' => $destination->rating ? (float) $destination->rating : ($definition['rating'] ?? null),
            'travel_styles' => collect($destination->travel_styles ?? ($definition['travel_styles'] ?? []))
                ->filter()
                ->values()
                ->all(),
            'season_keys' => $this->themeDestinationSeasonKeys($destination),
            'description' => $destination->short_description ?: ($definition['description'] ?? 'A curated destination for this travel theme.'),
            'image' => $this->resolveMediaUrl($destination->image_url ?: $destination->hero_image ?: ($definition['image'] ?? null)),
            'url' => route('destinations.show', $destination->slug),
        ];
    }

    private function themeSeasonOptions(): array
    {
        return [
            ['value' => 'summer', 'label' => 'Summer', 'icon' => 'bi bi-sun'],
            ['value' => 'winter', 'label' => 'Winter', 'icon' => 'bi bi-snow2'],
            ['value' => 'monsoon', 'label' => 'Monsoon', 'icon' => 'bi bi-cloud-rain'],
            ['value' => 'december', 'label' => 'December', 'icon' => 'bi bi-calendar-heart'],
        ];
    }

    private function themeDestinationSeasonKeys(Destination $destination): array
    {
        $terms = $this->homeDiscoverTextCollection(
            $destination->seasons ?? [],
            $destination->recommended_months ?? [],
            [$destination->best_season]
        )
            ->map(fn($value) => strtolower($value))
            ->implode(' ');

        $keys = collect();

        if (Str::contains($terms, ['summer', 'april', 'may', 'june'])) {
            $keys->push('summer');
        }

        if (Str::contains($terms, ['winter', 'november', 'december', 'january', 'february'])) {
            $keys->push('winter');
        }

        if (Str::contains($terms, ['monsoon', 'rain', 'july', 'august', 'september'])) {
            $keys->push('monsoon');
        }

        if (Str::contains($terms, ['december'])) {
            $keys->push('december');
        }

        return $keys->filter()->unique()->values()->all();
    }

    private function normalizeThemePackageFromModel(Package $package, array $definition, string $themeKey): array
    {
        return [
            'title' => $package->title,
            'country' => $package->country ?: ($definition['country'] ?? 'India'),
            'location' => $package->city ?: $package->state ?: $package->country ?: ($definition['location'] ?? 'India'),
            'duration' => $package->duration_text ?: (($package->days ?? null) ? $package->days . ' Days' : ($definition['duration'] ?? 'Flexible duration')),
            'price' => (int) ($package->price ?? ($definition['price'] ?? 0)),
            'rating' => $package->rating ? (float) $package->rating : ($definition['rating'] ?? null),
            'theme' => $this->normalizeThemeLabel($package->theme ?: ($definition['theme'] ?? null), $themeKey),
            'description' => $package->feature_1 ?: ($definition['description'] ?? 'Premium travel experience with curated stays and smooth transfers.'),
            'image' => $this->resolveMediaUrl($package->image ?: ($definition['image'] ?? null)),
            'url' => route('packages.show', $package->slug),
        ];
    }

    private function travelThemeQueryValues(string $themeKey): array
    {
        return match ($themeKey) {
            'hill' => ['hill', 'mountain'],
            'desert' => ['desert', 'dessert'],
            default => [Str::lower($themeKey)],
        };
    }

    private function normalizeThemeLabel(?string $value, string $themeKey): string
    {
        $normalizedValue = strtolower(trim((string) $value));

        return match ($normalizedValue) {
            'beach' => 'Beach',
            'hill', 'mountain' => 'Hill',
            'island' => 'Island',
            'desert', 'dessert' => 'Desert',
            default => Str::headline($value ?: $themeKey),
        };
    }

    private function sanitizePrice(mixed $value, int $fallback, int $min, int $max): int
    {
        if (!is_numeric($value)) {
            return $fallback;
        }

        return max($min, min((int) $value, $max));
    }

    public function packageDetails($slug): View
    {
        $package = Package::where('slug', $slug)->firstOrFail();

        return view('package-details', compact('package'));
    }
}

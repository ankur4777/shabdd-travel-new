<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Package;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
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

        $blogController = new BlogController();
        $blogs = $blogController->buildBlogCollection()->take(6);
        $seasonalJourneys = SeasonalJourney::active()->get();

        return view('home', compact(
            'destinations',
            'popularDestinations',
            'blogs',
            'seasonalJourneys'   // ✅ ADD THIS TOO
        ));
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

    public function beachEscapes(Request $request): View
    {
        $allBeachDestinations = $this->beachThemeDestinations();
        $priceBounds = $this->beachPriceBounds($allBeachDestinations);
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

        $selectedTravelStyles = collect(Arr::wrap($request->input('travel_styles', [])))
            ->map(fn($value) => trim((string) $value))
            ->filter()
            ->unique()
            ->values()
            ->all();
        $selectedTripType = (string) $request->input('trip_type', 'all');
        $selectedRating = $this->sanitizeBeachRating($request->input('rating'));
        $selectedSort = (string) $request->input('sort', 'newest');

        $beachDestinations = $this->filterBeachDestinations(
            $allBeachDestinations,
            $selectedMinPrice,
            $selectedMaxPrice,
            $selectedTravelStyles,
            $selectedTripType,
            $selectedRating
        );

        $beachDestinations = $this->sortBeachDestinations($beachDestinations, $selectedSort);
        $beachTravelStyleOptions = $this->beachTravelStyleOptions($allBeachDestinations);
        $beachPackages = $this->popularBeachPackages();

        return view('beach-escapes', [
            'beachDestinations' => $beachDestinations,
            'beachTravelStyleOptions' => $beachTravelStyleOptions,
            'priceBounds' => $priceBounds,
            'selectedMinPrice' => $selectedMinPrice,
            'selectedMaxPrice' => $selectedMaxPrice,
            'selectedTravelStyles' => $selectedTravelStyles,
            'selectedTripType' => $selectedTripType,
            'selectedRating' => $selectedRating,
            'selectedSort' => $selectedSort,
            'beachPackages' => $beachPackages,
            'beachDestinationCount' => $beachDestinations->count(),
            'beachPackageCount' => $beachPackages->count(),
        ]);
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
        int $selectedMinPrice,
        int $selectedMaxPrice,
        array $selectedTravelStyles,
        string $selectedTripType,
        ?float $selectedRating
    ): Collection {
        return $destinations
            ->filter(function (array $destination) use (
                $selectedMinPrice,
                $selectedMaxPrice,
                $selectedTravelStyles,
                $selectedTripType,
                $selectedRating
            ) {
                $price = (int) ($destination['price_from'] ?? 0);

                if ($price < $selectedMinPrice || $price > $selectedMaxPrice) {
                    return false;
                }

                if ($selectedTripType !== 'all' && $selectedTripType !== '') {
                    $destinationTripType = $this->beachDestinationTripType($destination);

                    if ($destinationTripType !== $selectedTripType) {
                        return false;
                    }
                }

                if ($selectedRating !== null) {
                    $rating = (float) ($destination['rating'] ?? 0);

                    if ($rating < $selectedRating) {
                        return false;
                    }
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

                return true;
            })
            ->values();
    }

    private function sortBeachDestinations(Collection $destinations, string $sort): Collection
    {
        return match ($sort) {
            'low_to_high' => $destinations->sortBy('price_from')->values(),
            'high_to_low' => $destinations->sortByDesc('price_from')->values(),
            'highest_rated' => $destinations->sortByDesc('rating')->values(),
            'most_popular' => $destinations
                ->sortByDesc(fn(array $destination) => ((float) ($destination['rating'] ?? 0) * 100000000) + (int) ($destination['price_from'] ?? 0))
                ->values(),
            default => $destinations->values(),
        };
    }

    private function beachDestinationTripType(array $destination): string
    {
        $country = Str::lower(trim((string) ($destination['country'] ?? '')));

        return $country !== '' && !Str::contains($country, 'india')
            ? 'international'
            : 'domestic';
    }

    private function sanitizeBeachRating(mixed $value): ?float
    {
        if (!is_numeric($value)) {
            return null;
        }

        $rating = (float) $value;

        return in_array($rating, [3.0, 4.0, 4.5, 5.0], true) ? $rating : null;
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
        if (!$path) {
            return asset('images/couple-bg.jpg');
        }

        if (preg_match('/^(https?:)?\\/\\//', $path)) {
            return $path;
        }

        return asset('storage/' . ltrim($path, '/'));
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

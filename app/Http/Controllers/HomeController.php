<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Package;
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
        [$selectedMinPrice, $selectedMaxPrice] = $this->beachBudgetRange($selectedBudget, $priceBounds);

        $beachDestinations = $this->filterBeachDestinations(
            $allBeachDestinations,
            $selectedDestination,
            $selectedMinPrice,
            $selectedMaxPrice,
            $selectedDuration,
            $selectedTravelStyles
        );

        $beachTravelStyleOptions = $this->beachTravelStyleOptions($allBeachDestinations);
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
        array $selectedTravelStyles
    ): Collection {
        return $destinations
            ->filter(function (array $destination) use (
                $selectedDestination,
                $selectedMinPrice,
                $selectedMaxPrice,
                $selectedDuration,
                $selectedTravelStyles
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

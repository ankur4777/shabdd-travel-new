<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Package;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $destinations = Destination::query()
            ->active()
            ->trending()
            ->latest()
            ->take(12)
            ->get();

        $trendingPackages = Package::where('category', 'Trending')
            ->latest()
            ->take(8)
            ->get();

        $blogController = new BlogController();
        $blogs = $blogController->buildBlogCollection()->take(6);

        return view('home', compact(
            'destinations',
            'blogs',
            'trendingPackages'
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

    private function packageListing(Request $request, string $travelStyle, string $view): View
    {
        $baseQuery = Package::query()
            ->where('travel_style', $travelStyle);

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

        return view($view, compact(
            'packages',
            'packageCount',
            'destinations',
            'priceBounds',
            'selectedMinPrice',
            'selectedMaxPrice'
        ));
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

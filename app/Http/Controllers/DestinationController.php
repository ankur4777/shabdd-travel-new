<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class DestinationController extends Controller
{
    public function index(Request $request): View
    {
        $destinations = Destination::query()
            ->active()
            ->latest()
            ->get();

        $destinationOptions = $this->buildDestinationOptions($destinations);
        $travelStyleOptions = $this->travelStyleOptions();
        $categoryOptions = $this->categoryOptions();
        $destinationsForPriceRange = $this->filterDestinationCollection(
            $destinations,
            $request,
            includePrice: false
        );

        $priceBounds = [
            'min' => (int) ($destinationsForPriceRange->min('price_from') ?? 0),
            'max' => (int) ($destinationsForPriceRange->max('price_from') ?? 0),
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

        $filteredDestinations = $this->filterDestinationCollection(
            $destinations,
            $request,
            includePrice: true,
            selectedMinPrice: $selectedMinPrice,
            selectedMaxPrice: $selectedMaxPrice
        );

        $destinationCards = $this->buildAdminDestinationCards(
            $filteredDestinations,
            (string) $request->input('sort', 'newest')
        );
        $destinationCount = $destinationCards->count();

        return view('destination.index', compact(
            'destinationCards',
            'destinationCount',
            'destinationOptions',
            'travelStyleOptions',
            'categoryOptions',
            'priceBounds',
            'selectedMinPrice',
            'selectedMaxPrice'
        ));
    }

    private function categoryOptions(): array
    {
        return [
            'Trending' => 'Trending',
            'Popular' => 'Popular',
            'Budget Friendly' => 'Budget Friendly',
            'Premium' => 'Premium',
        ];
    }

    private function travelStyleOptions(): array
    {
        return [
            'honeymoon' => 'Honeymoon',
            'religiuos' => 'Religious',
            'family' => 'Family',
            'adventure' => 'Adventure',
            'friends' => 'Friends',
            'solo' => 'Solo',
            'nature' => 'Nature',
            'wildlife' => 'Wildlife',
            'water activities' => 'Water Activities',
        ];
    }

    private function buildDestinationOptions(Collection $destinations): Collection
    {
        return $destinations
            ->map(fn (Destination $destination) => [
                'name' => $destination->name,
                'slug' => $destination->slug,
                'country' => $destination->country,
            ])
            ->sortBy('name')
            ->values();
    }

    private function filterDestinationCollection(
        Collection $destinations,
        Request $request,
        bool $includePrice,
        int $selectedMinPrice = 0,
        int $selectedMaxPrice = 0
    ): Collection {
        return $destinations
            ->when($request->filled('destination'), function (Collection $destinations) use ($request) {
                return $destinations->filter(
                    fn (Destination $destination) => $destination->slug === $request->input('destination')
                );
            })
            ->when($request->filled('category'), function (Collection $destinations) use ($request) {
                $category = (string) $request->input('category');

                if (!array_key_exists($category, $this->categoryOptions())) {
                    return $destinations;
                }

                return $destinations->filter(
                    fn (Destination $destination) => (string) $destination->category === $category
                );
            })
            ->when($request->filled('travel_style'), function (Collection $destinations) use ($request) {
                $travelStyle = (string) $request->input('travel_style');

                if (!array_key_exists($travelStyle, $this->travelStyleOptions())) {
                    return $destinations;
                }

                return $destinations->filter(
                    fn (Destination $destination) => $this->destinationMatchesTravelStyle($destination, $travelStyle)
                );
            })
            ->when($request->filled('rating'), function (Collection $destinations) use ($request) {
                $rating = (int) $request->input('rating');

                if (!in_array($rating, [3, 4, 5], true)) {
                    return $destinations;
                }

                return $destinations->filter(fn (Destination $destination) => (float) $destination->rating >= $rating);
            })
            ->when($request->filled('duration'), function (Collection $destinations) use ($request) {
                return match ($request->input('duration')) {
                    '1-3' => $destinations->filter(fn (Destination $destination) => $this->destinationDayCount($destination) >= 1 && $this->destinationDayCount($destination) <= 3),
                    '4-6' => $destinations->filter(fn (Destination $destination) => $this->destinationDayCount($destination) >= 4 && $this->destinationDayCount($destination) <= 6),
                    '7-plus' => $destinations->filter(fn (Destination $destination) => $this->destinationDayCount($destination) >= 7),
                    default => $destinations,
                };
            })
            ->when($includePrice, function (Collection $destinations) use ($selectedMinPrice, $selectedMaxPrice) {
                return $destinations->filter(
                    fn (Destination $destination) => (int) $destination->price_from >= $selectedMinPrice
                        && (int) $destination->price_from <= $selectedMaxPrice
                );
            })
            ->values();
    }

    private function destinationMatchesTravelStyle(Destination $destination, string $travelStyle): bool
    {
        $needle = Str::slug($travelStyle);

        return collect()
            ->merge($destination->travel_styles ?? [])
            ->merge($destination->popular_for ?? [])
            ->merge($destination->tags ?? [])
            ->filter()
            ->map(fn ($value) => Str::slug((string) $value))
            ->contains($needle);
    }

    private function destinationDayCount(Destination $destination): int
    {
        $duration = (string) ($destination->ideal_duration ?: $destination->ideal_days);

        return $duration !== '' ? $this->extractDayCount($duration) : 0;
    }

    private function buildAdminDestinationCards(Collection $destinations, string $sort): Collection
    {
        $cards = $destinations
            ->map(fn (Destination $destination) => [
                'name' => $destination->name,
                'slug' => $destination->slug,
                'country' => $destination->location ?: $destination->country,
                'category' => $destination->category,
                'image' => $this->destinationImageUrl($destination),
                'rating' => $destination->rating ? (float) $destination->rating : null,
                'package_count' => $this->destinationPackageCount($destination),
                'min_price' => (int) $destination->price_from,
                'max_price' => (int) $destination->price_from,
                'min_days' => $this->destinationDayCount($destination),
                'max_days' => $this->destinationDayCount($destination),
                'travel_styles' => $this->destinationTravelStyles($destination),
                'detail_url' => route('destinations.show', $destination),
                'latest_package_id' => (int) $destination->id,
                'featured_score' => $destination->category === 'Trending' ? 1 : 0,
            ])
            ->values();

        return $this->sortDestinationCards($cards, $sort);
    }

    private function destinationImageUrl(Destination $destination): string
    {
        $path = $destination->image_url ?: $destination->hero_image;

        if (!$path) {
            return asset('images/couple-bg.jpg');
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        if (Str::startsWith($path, ['storage/', 'images/'])) {
            return asset(ltrim($path, '/'));
        }

        return asset('storage/' . ltrim($path, '/'));
    }

    private function destinationPackageCount(Destination $destination): int
    {
        $packages = collect($destination->packages ?? [])->filter();

        return max(1, $packages->count());
    }

    private function destinationTravelStyles(Destination $destination): Collection
    {
        return collect($destination->travel_styles ?? [])
            ->merge($destination->popular_for ?? [])
            ->merge($destination->tags ?? [])
            ->filter()
            ->unique()
            ->take(2)
            ->values();
    }

    private function sortDestinationCards(Collection $cards, string $sort): Collection
    {
        return match ($sort) {
            'low_to_high' => $cards->sortBy('min_price')->values(),
            'high_to_low' => $cards->sortByDesc('min_price')->values(),
            'highest_rated' => $cards->sortByDesc('rating')->values(),
            'most_popular' => $cards
                ->sortByDesc('latest_package_id')
                ->sortByDesc('featured_score')
                ->values(),
            default => $cards->sortByDesc('latest_package_id')->values(),
        };
    }

    private function buildPackageDestinationOptions(Collection $packages): Collection
    {
        return $packages
            ->map(function (Package $package) {
                $name = $this->packageDestinationName($package);

                return [
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'country' => $package->country,
                ];
            })
            ->unique('slug')
            ->sortBy('name')
            ->values();
    }

    private function buildPackageDestinationCards(Collection $packages, string $sort): Collection
    {
        $cards = $packages
            ->groupBy(fn (Package $package) => $this->packageDestinationSlug($package))
            ->map(function (Collection $destinationPackages) {
                $sortedByPrice = $destinationPackages->sortBy('price')->values();
                $representative = $sortedByPrice->first();
                $destinationName = $this->packageDestinationName($representative);
                $minPrice = (int) $destinationPackages->min('price');
                $maxPrice = (int) $destinationPackages->max('price');
                $minDays = (int) $destinationPackages->filter(fn (Package $package) => $package->days)->min('days');
                $maxDays = (int) $destinationPackages->filter(fn (Package $package) => $package->days)->max('days');
                $travelStyles = $destinationPackages
                    ->pluck('travel_style')
                    ->filter()
                    ->unique()
                    ->take(3)
                    ->values();

                return [
                    'name' => $destinationName,
                    'slug' => Str::slug($destinationName),
                    'country' => $representative->country,
                    'image' => $representative->image
                        ? asset('storage/' . $representative->image)
                        : asset('images/couple-bg.jpg'),
                    'rating' => round((float) $destinationPackages->avg('rating'), 1),
                    'package_count' => $destinationPackages->count(),
                    'min_price' => $minPrice,
                    'max_price' => $maxPrice,
                    'min_days' => $minDays,
                    'max_days' => $maxDays,
                    'travel_styles' => $travelStyles,
                    'featured_package_slug' => $representative->slug,
                    'latest_package_id' => (int) $destinationPackages->max('id'),
                    'featured_score' => (int) $destinationPackages->max('featured'),
                ];
            })
            ->values();

        return match ($sort) {
            'low_to_high' => $cards->sortBy('min_price')->values(),
            'high_to_low' => $cards->sortByDesc('max_price')->values(),
            'highest_rated' => $cards->sortByDesc('rating')->values(),
            'most_popular' => $cards
                ->sortByDesc('latest_package_id')
                ->sortByDesc('featured_score')
                ->values(),
            default => $cards->sortByDesc('latest_package_id')->values(),
        };
    }

    private function packageDestinationName(Package $package): string
    {
        $location = collect([
            $package->city,
            $package->state,
            $package->country,
        ])
            ->map(fn ($value) => trim((string) $value))
            ->first(fn (string $value) => $value !== '');

        return $location ?: $package->title;
    }

    private function packageDestinationSlug(Package $package): string
    {
        return Str::slug($this->packageDestinationName($package));
    }

    private function sanitizePrice(mixed $value, int $fallback, int $min, int $max): int
    {
        if (!is_numeric($value)) {
            return $fallback;
        }

        return max($min, min((int) $value, $max));
    }

    public function packages(): View
    {
        $destinations = Destination::query()
            ->active()
            ->latest()
            ->get();

        $allPackages = [];

        foreach ($destinations as $destination) {
            $destinationProfile = $this->buildDestinationProfile($destination);
            $packages = $this->resolvePackageCollection($destination, $destinationProfile);

            foreach ($packages as $package) {
                $allPackages[] = array_merge($package, [
                    'destination' => $destination,
                    'destination_name' => $destination->name,
                    'destination_country' => $destination->country,
                ]);
            }
        }

        return view('destination.packages', compact('allPackages'));
    }

    public function show(string $destination): View
    {
        $destination = $this->resolveDestinationForDetailPage($destination);

        abort_unless($destination->is_active, 404);

        $locationOptions = $this->getLocationOptions($destination);
        $monthOptions = collect(range(0, 11))
            ->map(fn (int $offset) => now()->startOfMonth()->addMonths($offset)->format('F, Y'))
            ->all();

        $relatedDestinations = Destination::query()
            ->active()
            ->where('country', $destination->country)
            ->where('id', '!=', $destination->id)
            ->latest()
            ->take(4)
            ->get();

        if ($relatedDestinations->isEmpty()) {
            $relatedDestinations = Destination::query()
                ->active()
                ->where('id', '!=', $destination->id)
                ->latest()
                ->take(4)
                ->get();
        }

        $destinationProfile = $this->buildDestinationProfile($destination);
        $destinationPackages = $this->resolvePackageCollection($destination, $destinationProfile);

        return view('destination.show', compact(
            'destination',
            'relatedDestinations',
            'locationOptions',
            'monthOptions',
            'destinationProfile',
            'destinationPackages'
        ));
    }

    private function resolveDestinationForDetailPage(string $slug): Destination
    {
        $destination = Destination::query()
            ->where('slug', $slug)
            ->first();

        if ($destination) {
            return $destination;
        }

        $destinationCard = $this->buildPackageDestinationCards(
            Package::query()->whereNotNull('price')->get(),
            'newest'
        )->firstWhere('slug', $slug);

        abort_if($destinationCard === null, 404);

        return $this->makeSyntheticDestination($destinationCard);
    }

    private function makeSyntheticDestination(array $destinationCard): Destination
    {
        $destination = new Destination();
        $travelStyles = collect($destinationCard['travel_styles'] ?? [])
            ->filter()
            ->values()
            ->all();
        $durationLabel = !empty($destinationCard['min_days']) && !empty($destinationCard['max_days'])
            ? $destinationCard['min_days'] . '-' . $destinationCard['max_days'] . ' Days'
            : null;

        $destination->forceFill([
            'name' => $destinationCard['name'],
            'slug' => $destinationCard['slug'],
            'country' => $destinationCard['country'] ?: 'Curated destination',
            'image_url' => $destinationCard['image'] ?? asset('images/couple-bg.jpg'),
            'badge_label' => 'Popular',
            'badge_type' => 'hot',
            'rating' => $destinationCard['rating'] ?: 4.5,
            'tags' => array_values(array_filter(array_merge($travelStyles, [$durationLabel]))),
            'price_from' => (int) ($destinationCard['min_price'] ?? 0),
            'price_unit' => '/Adult',
            'short_description' => 'Curated package collection for ' . $destinationCard['name'] . '.',
            'about' => 'Discover curated tours for ' . $destinationCard['name'] . ' with flexible stays, sightseeing, and trip styles that match different budgets and travel moods.',
            'highlights' => [
                $destinationCard['package_count'] . ' package options',
                'Starting from ₹' . number_format((int) ($destinationCard['min_price'] ?? 0)),
                ucfirst((string) ($travelStyles[0] ?? 'Curated travel')),
            ],
            'is_trending' => true,
            'is_active' => true,
        ]);

        return $destination;
    }

    public function packageShow(Destination $destination, string $packageSlug): View
    {
        abort_unless($destination->is_active, 404);

        $destinationProfile = $this->buildDestinationProfile($destination);
        $destinationPackages = $this->resolvePackageCollection($destination, $destinationProfile);
        $selectedPackage = collect($destinationPackages)->firstWhere('package_slug', $packageSlug);

        abort_if($selectedPackage === null, 404);

        $packagePageData = $this->buildPackagePageData(
            $destination,
            $destinationProfile,
            $selectedPackage,
            $destinationPackages
        );

        return view('destination.package-show', compact(
            'destination',
            'destinationProfile',
            'destinationPackages',
            'selectedPackage',
            'packagePageData'
        ));
    }

    private function buildDestinationProfile(Destination $destination): array
    {
        $slug = Str::lower($destination->slug ?: $destination->name);

        foreach ($this->destinationProfiles() as $keyword => $profile) {
            if (Str::contains($slug, $keyword)) {
                return $this->normalizeProfile($profile, $destination);
            }
        }

        return $this->normalizeProfile($this->genericProfile($destination), $destination);
    }

    private function normalizeProfile(array $profile, Destination $destination): array
    {
        $cityPackages = collect($profile['city_packages'] ?? [$destination->name])
            ->map(function ($city) {
                if (is_array($city)) {
                    $name = $city['city_name'] ?? '';

                    return [
                        'city_name' => $name,
                        'url' => $city['url'] ?? route('destinations.index', ['city' => Str::slug($name)]),
                    ];
                }

                return [
                    'city_name' => $city,
                    'url' => route('destinations.index', ['city' => Str::slug((string) $city)]),
                ];
            })
            ->filter(fn (array $city) => !empty($city['city_name']))
            ->values()
            ->all();

        $places = collect($profile['places'] ?? [])
            ->map(function (array $place) use ($destination) {
                $place['image'] = $place['image'] ?? $destination->image_url;

                return $place;
            })
            ->values()
            ->all();

        $packages = collect($profile['packages'] ?? [])
            ->map(function (array $package) use ($destination) {
                $package['image'] = $package['image'] ?? $destination->image_url;
                $package['url'] = $package['url'] ?? '#';

                return $package;
            })
            ->values()
            ->all();

        $blogs = collect($profile['blogs'] ?? [])
            ->map(function (array $blog) use ($destination) {
                $blog['image'] = $blog['image'] ?? $destination->image_url;
                $blog['url'] = $blog['url'] ?? '#';

                return $blog;
            })
            ->values()
            ->all();

        return [
            'primary_color' => $profile['primary_color'] ?? '#2563eb',
            'ideal_days' => $profile['ideal_days'] ?? '5-7 Days',
            'best_season' => $profile['best_season'] ?? 'All year',
            'overview' => $profile['overview'] ?? '',
            'popular_for' => $profile['popular_for'] ?? ['Culture', 'Sightseeing'],
            'city_packages' => $cityPackages,
            'places' => $places,
            'packages' => $packages,
            'features' => array_values($profile['features'] ?? []),
            'seasons' => array_values($profile['seasons'] ?? []),
            'blogs' => $blogs,
            'testimonials' => array_values($profile['testimonials'] ?? []),
            'faqs' => array_values($profile['faqs'] ?? []),
        ];
    }

    private function resolvePackageCollection(Destination $destination, array $destinationProfile): array
    {
        $rawPackages = !empty($destination->packages)
            ? $destination->packages
            : ($destinationProfile['packages'] ?? []);

        $usedSlugs = [];

        return collect($rawPackages)
            ->values()
            ->map(function ($package, int $index) use ($destination, &$usedSlugs) {
                $packageData = is_array($package) ? $package : ['name' => (string) $package];
                $packageName = trim((string) ($packageData['name'] ?? 'Package ' . ($index + 1)));
                $baseSlug = Str::slug($packageName) ?: 'package-' . ($index + 1);
                $packageSlug = $baseSlug;
                $counter = 2;

                while (isset($usedSlugs[$packageSlug])) {
                    $packageSlug = $baseSlug . '-' . $counter;
                    $counter++;
                }

                $usedSlugs[$packageSlug] = true;

                $packageData['name'] = $packageName;
                $packageData['duration'] = $packageData['duration'] ?? '5D/4N';
                $packageData['price'] = $packageData['price'] ?? ($destination->formatted_price ?: '₹39,999');
                $packageData['discounted_price'] = $packageData['discounted price'] ?? ($packageData['discounted_price'] ?? '');
                $packageData['image'] = $packageData['image'] ?? $destination->image_url;
                $packageData['package_slug'] = $packageSlug;
                $packageData['detail_url'] = route('destinations.packages.show', [
                    'destination' => $destination,
                    'packageSlug' => $packageSlug,
                ]);

                return $packageData;
            })
            ->all();
    }

    private function buildPackagePageData(
        Destination $destination,
        array $destinationProfile,
        array $selectedPackage,
        array $destinationPackages
    ): array {
        $places = !empty($destination->places) ? $destination->places : ($destinationProfile['places'] ?? []);
        $features = !empty($destination->features) ? $destination->features : ($destinationProfile['features'] ?? []);
        $overview = trim((string) ($selectedPackage['overview'] ?? $destination->about ?? $destinationProfile['overview'] ?? ''));
        $duration = (string) ($selectedPackage['duration'] ?? '5D/4N');
        $dayCount = $this->extractDayCount($duration);
        $nightCount = max(1, $dayCount - 1);

        if ($overview === '') {
            $overview = $selectedPackage['name'] . ' is a curated tour package for ' . $destination->name .
                ' covering top highlights with smooth stays, transfers, and guided local experiences.';
        }

        $galleryImages = collect([$selectedPackage['image'] ?? null, $destination->image_url ?? null])
            ->merge(
                collect($places)
                    ->map(fn ($place) => is_array($place) ? ($place['image'] ?? null) : null)
                    ->filter()
                    ->take(3)
            )
            ->filter()
            ->unique()
            ->take(4)
            ->values()
            ->all();

        $itinerary = $this->resolvePackageItinerary($selectedPackage, $destination, $places, $dayCount);
        $inclusions = $this->normalizeStringList($selectedPackage['inclusions'] ?? []);
        $exclusions = $this->normalizeStringList($selectedPackage['exclusions'] ?? []);

        if (empty($inclusions)) {
            $inclusions = [
                $nightCount . ' nights hotel stay with breakfast',
                'Airport and intercity transfers',
                'Sightseeing as per itinerary',
                'Experienced trip coordination support',
            ];
        }

        if (empty($exclusions)) {
            $exclusions = [
                'Flights, train tickets, and visa fees',
                'Meals not listed in itinerary',
                'Personal expenses, shopping, and tips',
                'Anything not explicitly mentioned in inclusions',
            ];
        }

        $hotelName = trim((string) ($selectedPackage['hotel_name'] ?? ($destination->name . ' Signature Stay')));
        $hotelArea = trim((string) ($selectedPackage['hotel_area'] ?? ($destination->name . ' Central Area')));
        $hotelCategory = trim((string) ($selectedPackage['hotel_category'] ?? '4 Star Hotel'));
        $hotelHighlights = $this->normalizeStringList($selectedPackage['hotel_highlights'] ?? []);

        if (empty($hotelHighlights)) {
            $hotelHighlights = [
                'Well-rated rooms with daily housekeeping',
                'Easy access to key sightseeing locations',
                'Comfortable stay curated by our travel experts',
            ];
        }

        $destinationTagline = $destination->country
            ? $destination->name . ', ' . $destination->country
            : $destination->name;

        $startingPrice = (string) ($selectedPackage['discounted_price'] ?: $selectedPackage['price'] ?: $destination->formatted_price);
        $originalPrice = (string) ($selectedPackage['price'] ?? '');
        $rating = number_format((float) ($selectedPackage['rating'] ?? $destination->rating ?? 4.6), 1);
        $reviewCount = (int) ($selectedPackage['review_count'] ?? (400 + ($dayCount * 53)));
        $highlights = collect($features)
            ->map(fn ($feature) => is_array($feature) ? ($feature['title'] ?? null) : null)
            ->filter()
            ->take(4)
            ->values()
            ->all();

        if (empty($highlights)) {
            $highlights = [
                'Handpicked sightseeing route',
                'Balanced travel pace',
                'Reliable local support',
                'Comfort-focused stay options',
            ];
        }

        // Extract attractions from places and itinerary
        $attractions = array_merge(
            collect($places)
                ->map(fn ($place) => is_array($place) ? ($place['name'] ?? null) : null)
                ->filter()
                ->take(5)
                ->all(),
            collect($places)
                ->map(fn ($place) => is_array($place) ? 
                    (collect($place['attractions'] ?? [])->first() ?? null) : null)
                ->filter()
                ->take(2)
                ->all()
        );
        $attractions = array_values(array_unique(array_filter($attractions)));
        if (empty($attractions)) {
            $attractions = ['Scenic landscapes', 'Cultural heritage', 'Local experiences', 'Adventure activities', 'Comfortable stays'];
        }

        // Get seasons info
        $seasonsInfo = $this->getDestinationSeasons($destinationProfile);
        
        // Build difficulty level based on day count
        $difficulty = $this->buildDifficultyLevel($dayCount);

        // Distance placeholder (can be enhanced based on destination)
        $distance = $this->calculateEstimatedDistance($destination->name, $dayCount);

        return [
            'destination_tagline' => $destinationTagline,
            'package_title' => $selectedPackage['name'],
            'package_duration' => $duration,
            'day_count' => $dayCount,
            'night_count' => $nightCount,
            'starting_price' => $startingPrice,
            'original_price' => $originalPrice,
            'package_rating' => $rating,
            'review_count' => $reviewCount,
            'overview_text' => $overview,
            'gallery_images' => $galleryImages,
            'itinerary_items' => $itinerary,
            'inclusions' => $inclusions,
            'exclusions' => $exclusions,
            'hotel_name' => $hotelName,
            'hotel_area' => $hotelArea,
            'hotel_category' => $hotelCategory,
            'hotel_highlights' => $hotelHighlights,
            'highlight_points' => $highlights,
            'attractions' => $attractions,
            'difficulty' => $difficulty,
            'seasons' => $seasonsInfo,
            'distance' => $distance,
            'why_visit' => $this->buildWhyVisit($destination, $selectedPackage, $dayCount),
            'main_image' => $galleryImages[0] ?? $destination->image_url,
            'contact_phone' => '+91-98280-65555',
            'contact_email' => 'support@shabddtravel.com',
            'other_packages' => collect($destinationPackages)
                ->reject(fn (array $package) => ($package['package_slug'] ?? '') === ($selectedPackage['package_slug'] ?? ''))
                ->take(3)
                ->values()
                ->all(),
        ];
    }

    private function buildDifficultyLevel(int $dayCount): string
    {
        if ($dayCount <= 3) {
            return 'Easy - Relaxed pace';
        } elseif ($dayCount <= 5) {
            return 'Moderate - Balanced pace';
        } elseif ($dayCount <= 8) {
            return 'Moderate to challenging';
        }
        return 'Challenging - Active exploration';
    }

    private function getDestinationSeasons(array $destinationProfile): array
    {
        $seasons = $destinationProfile['seasons'] ?? [];
        if (empty($seasons)) {
            return [
                ['name' => 'April to June', 'note' => 'Best - Pleasant weather'],
                ['name' => 'September to October', 'note' => 'Ideal - Comfortable temperatures'],
            ];
        }
        return array_slice(
            array_map(fn ($s) => ['name' => $s['name'] ?? '', 'note' => $s['recommendation'] ?? ''], $seasons),
            0,
            2
        );
    }

    private function calculateEstimatedDistance(string $destination, int $dayCount): string
    {
        $baseDistances = [
            'bali' => 200,
            'maldives' => 150,
            'kashmir' => 400,
            'santorini' => 350,
            'iceland' => 628,
            'switzerland' => 280,
            'thailand' => 320,
            'goa' => 250,
        ];

        $dest = Str::lower($destination);
        $base = 0;
        foreach (array_keys($baseDistances) as $key) {
            if (Str::contains($dest, $key)) {
                $base = $baseDistances[$key];
                break;
            }
        }

        return $base > 0 ? number_format($base) . ' Miles' : ($dayCount * 120) . ' Miles (approx)';
    }

    private function buildWhyVisit(Destination $destination, array $selectedPackage, int $dayCount): string
    {
        $overview = $selectedPackage['why_visit'] ?? null;
        
        if ($overview) {
            return $overview;
        }

        $destinationName = $destination->name;
        $packageName = $selectedPackage['name'] ?? 'This package';
        
        return "$packageName offers an unparalleled opportunity to experience {$destinationName}'s diverse landscapes, rich culture, and authentic local experiences in a single journey. Over {$dayCount} days, you'll discover hidden gems, iconic landmarks, and create lasting memories with expert guidance and comfortable stays throughout your adventure.";
    }

    private function resolvePackageItinerary(array $selectedPackage, Destination $destination, array $places, int $dayCount): array
    {
        $existingItinerary = $selectedPackage['itinerary'] ?? [];

        if (is_array($existingItinerary) && !empty($existingItinerary)) {
            return collect($existingItinerary)
                ->values()
                ->map(function ($item, int $index) {
                    if (is_string($item)) {
                        return [
                            'day' => $index + 1,
                            'title' => 'Day ' . ($index + 1),
                            'summary' => $item,
                        ];
                    }

                    return [
                        'day' => $item['day'] ?? ($index + 1),
                        'title' => $item['title'] ?? ('Day ' . ($index + 1)),
                        'summary' => $item['summary'] ?? ($item['description'] ?? 'Guided activities as per planned itinerary.'),
                    ];
                })
                ->all();
        }

        $placeNames = collect($places)
            ->map(fn ($place) => is_array($place) ? ($place['name'] ?? null) : null)
            ->filter()
            ->values()
            ->all();

        if (empty($placeNames)) {
            $placeNames = [$destination->name];
        }

        $itinerary = [];
        $lastDay = max(2, $dayCount);

        for ($day = 1; $day <= $lastDay; $day++) {
            if ($day === 1) {
                $itinerary[] = [
                    'day' => 1,
                    'title' => 'Arrival and Local Welcome Tour',
                    'summary' => 'Arrive in ' . $destination->name . ', hotel check-in, and a relaxed local orientation with nearby sightseeing.',
                ];

                continue;
            }

            if ($day === $lastDay) {
                $itinerary[] = [
                    'day' => $day,
                    'title' => 'Departure Day',
                    'summary' => 'After breakfast, check out and proceed for return transfer with beautiful trip memories.',
                ];

                continue;
            }

            $placeName = $placeNames[($day - 2) % count($placeNames)];

            $itinerary[] = [
                'day' => $day,
                'title' => $placeName . ' Sightseeing',
                'summary' => 'Explore top highlights in ' . $placeName . ' with guided stops, flexible photo breaks, and local leisure time.',
            ];
        }

        return $itinerary;
    }

    private function normalizeStringList($items): array
    {
        if (is_string($items)) {
            $items = array_filter(array_map('trim', preg_split('/[\r\n,]+/', $items)));
        }

        if (!is_array($items)) {
            return [];
        }

        return collect($items)
            ->map(fn ($item) => trim((string) $item))
            ->filter()
            ->values()
            ->all();
    }

    private function extractDayCount(string $duration): int
    {
        if (preg_match('/(\d+)\s*D/i', $duration, $matches)) {
            return max(2, (int) $matches[1]);
        }

        if (preg_match('/(\d+)\s*day/i', $duration, $matches)) {
            return max(2, (int) $matches[1]);
        }

        return 5;
    }

    private function destinationProfiles(): array
    {
        return [
            'santorini' => [
                'primary_color' => '#f97316',
                'ideal_days' => '5-6 Days',
                'best_season' => 'Apr-Jun, Sep-Oct',
                'popular_for' => ['Sunsets', 'Honeymoon', 'Luxury'],
                'overview' => 'Santorini is the definition of postcard-perfect Greece, with whitewashed villages balanced on volcanic cliffs and sweeping caldera views that glow at sunset. The island combines romance and elegance with authentic local culture, from family-run tavernas to winding blue-domed lanes in Oia and Fira. Whether you want a relaxed honeymoon, a premium couple escape, or a slower Mediterranean holiday, Santorini gives you the right mix of scenic moments and curated comfort. Beyond photos, travelers love the island for its volcanic beaches, boutique stays, and smooth day tours to nearby islands. With the right plan, you can enjoy both iconic attractions and hidden local corners without rushing.',
                'city_packages' => ['Oia', 'Fira', 'Imerovigli', 'Kamari', 'Perissa'],
                'places' => [
                    ['name' => 'Oia', 'description' => 'Famous for sunset terraces, boutique cave hotels, and romantic cliff walks.', 'attractions' => ['Oia Castle', 'Amoudi Bay', 'Blue Domes'], 'duration' => '2 Days', 'tags' => ['Romantic', 'Scenic']],
                    ['name' => 'Fira', 'description' => 'The lively island capital with shopping lanes, cafes, and caldera viewpoints.', 'attractions' => ['Fira Cable Car', 'Three Bells', 'Cliffside Promenade'], 'duration' => '1-2 Days', 'tags' => ['City Vibe', 'Shopping']],
                    ['name' => 'Akrotiri', 'description' => 'Historic excavations and dramatic coastline for culture-focused travelers.', 'attractions' => ['Akrotiri Ruins', 'Red Beach', 'Lighthouse'], 'duration' => '1 Day', 'tags' => ['History', 'Coastal']],
                ],
                'packages' => [
                    ['name' => 'Santorini Romance Escape', 'duration' => '5D/4N', 'rating' => 4.9, 'price' => '₹1,89,999', 'discounted price' => '₹1,59,999'],
                    ['name' => 'Santorini Premium Stay', 'duration' => '6D/5N', 'rating' => 4.8, 'price' => '₹2,14,999', 'discounted price' => '₹1,89,999'],
                    ['name' => 'Greek Island Combo', 'duration' => '7D/6N', 'rating' => 4.7, 'price' => '₹2,39,999', 'discounted price' => '₹2,09,999'],
                ],
                'features' => [
                    ['icon' => 'bi bi-stars', 'title' => 'Iconic Sunsets', 'desc' => 'Caldera sunsets and golden-hour viewpoints every evening.'],
                    ['icon' => 'bi bi-heart-fill', 'title' => 'Couple Friendly', 'desc' => 'Private dinners, honeymoon stays, and serene sea-view experiences.'],
                    ['icon' => 'bi bi-cup-hot-fill', 'title' => 'Mediterranean Dining', 'desc' => 'Local seafood, cliff cafes, and curated culinary spots.'],
                    ['icon' => 'bi bi-camera2', 'title' => 'Photogenic Spots', 'desc' => 'White-blue architecture and dramatic island panoramas.'],
                    ['icon' => 'bi bi-water', 'title' => 'Volcanic Beaches', 'desc' => 'Unique black and red sand beaches with calm water activities.'],
                    ['icon' => 'bi bi-building', 'title' => 'Boutique Stays', 'desc' => 'Premium cave suites and luxury caldera-facing hotels.'],
                ],
                'seasons' => [
                    ['name' => 'April to June', 'weather' => 'Pleasant spring (18°C to 27°C)', 'activities' => ['Sightseeing', 'Sunset cruises', 'Photography'], 'recommendation' => 'Great weather with manageable crowds.', 'icon' => 'bi bi-sun-fill'],
                    ['name' => 'July to August', 'weather' => 'Warm peak season (24°C to 32°C)', 'activities' => ['Beach clubs', 'Island hopping', 'Nightlife'], 'recommendation' => 'Best for vibrant energy and events.', 'icon' => 'bi bi-brightness-high-fill'],
                    ['name' => 'September to October', 'weather' => 'Comfortable autumn (20°C to 29°C)', 'activities' => ['Honeymoon', 'Leisure stays', 'Local experiences'], 'recommendation' => 'Ideal for couples and premium vacations.', 'icon' => 'bi bi-cloud-sun-fill'],
                ],
                'blogs' => [
                    ['title' => 'Santorini In 5 Days: Perfect Itinerary', 'excerpt' => 'Plan viewpoints, local lanes, and cruise experiences without rushing.', 'date' => '2026-03-04'],
                    ['title' => 'Where To Stay In Santorini', 'excerpt' => 'Best areas and hotel styles for couples, families, and luxury travelers.', 'date' => '2026-02-16'],
                    ['title' => 'Santorini Budget Vs Luxury Guide', 'excerpt' => 'How to balance premium moments with practical planning.', 'date' => '2026-01-28'],
                ],
                'testimonials' => [
                    ['name' => 'Riya Kapoor', 'rating' => 5, 'text' => 'Our Santorini plan felt perfectly paced and every sunset spot was magical.', 'location' => 'Mumbai', 'image' => 'https://i.pravatar.cc/100?img=25'],
                    ['name' => 'Arjun Nair', 'rating' => 4.9, 'text' => 'Excellent hotel selection and smooth local transfers throughout the trip.', 'location' => 'Bengaluru', 'image' => 'https://i.pravatar.cc/100?img=31'],
                    ['name' => 'Sneha Rao', 'rating' => 4.8, 'text' => 'The itinerary balanced iconic places and peaceful hidden corners beautifully.', 'location' => 'Pune', 'image' => 'https://i.pravatar.cc/100?img=47'],
                ],
                'faqs' => [
                    ['q' => 'How many days are ideal for Santorini?', 'a' => 'A 5 to 6 day trip covers Oia, Fira, beaches, and a cruise comfortably.'],
                    ['q' => 'Is Santorini suitable for honeymoon?', 'a' => 'Yes, it is one of the best honeymoon islands with sunset views and premium stays.'],
                    ['q' => 'Which month is best to visit Santorini?', 'a' => 'April to June and September to October offer the best weather and experience balance.'],
                    ['q' => 'Can families also enjoy Santorini?', 'a' => 'Yes, families can enjoy beach areas, local tours, and scenic stays with easy planning.'],
                ],
            ],
            'bali' => [
                'primary_color' => '#10b981',
                'ideal_days' => '6-7 Days',
                'best_season' => 'Apr-Oct',
                'popular_for' => ['Temples', 'Waterfalls', 'Beach Clubs'],
                'overview' => 'Bali is one of the most versatile island destinations in Asia, giving travelers a rare blend of culture, wellness, beaches, and nightlife in a single itinerary. From Ubud rice terraces and temple ceremonies to Uluwatu cliffs and Seminyak beach clubs, every region feels distinct and adds a new mood to the trip. Bali works equally well for couples, friends, remote workers, and families because it offers both value-friendly stays and premium villas. Travelers often choose Bali for the freedom to mix adventure days with slow relaxation, whether that means chasing waterfalls, riding through jungle roads, enjoying spa rituals, or ending the evening with sunset dining by the sea.',
                'city_packages' => ['Ubud', 'Seminyak', 'Kuta', 'Nusa Penida', 'Uluwatu'],
                'places' => [
                    ['name' => 'Ubud', 'description' => 'Cultural center known for rice terraces, cafes, and wellness retreats.', 'attractions' => ['Tegalalang', 'Monkey Forest', 'Ubud Market'], 'duration' => '2 Days', 'tags' => ['Culture', 'Nature']],
                    ['name' => 'Nusa Penida', 'description' => 'Dramatic coastlines and crystal waters ideal for day adventures.', 'attractions' => ['Kelingking Beach', 'Angel Billabong', 'Crystal Bay'], 'duration' => '1 Day', 'tags' => ['Island', 'Adventure']],
                    ['name' => 'Uluwatu', 'description' => 'Cliff temples, surf beaches, and premium sunset experiences.', 'attractions' => ['Uluwatu Temple', 'Padang Padang', 'Kecak Show'], 'duration' => '1-2 Days', 'tags' => ['Sunset', 'Luxury']],
                ],
                'packages' => [
                    ['name' => 'Bali Explorer Package', 'duration' => '6D/5N', 'rating' => 4.8, 'price' => '₹64,999', 'discounted price' => '₹54,999'],
                    ['name' => 'Bali Honeymoon Retreat', 'duration' => '7D/6N', 'rating' => 4.9, 'price' => '₹82,999', 'discounted price' => '₹72,999'],
                    ['name' => 'Bali Friends Getaway', 'duration' => '5D/4N', 'rating' => 4.7, 'price' => '₹56,999', 'discounted price' => '₹46,999'],
                ],
                'features' => [
                    ['icon' => 'bi bi-tree-fill', 'title' => 'Jungle Escapes', 'desc' => 'Lush landscapes, waterfalls, and scenic countryside routes.'],
                    ['icon' => 'bi bi-moon-stars-fill', 'title' => 'Beach Nightlife', 'desc' => 'Sunset clubs, live music, and vibrant evening scenes.'],
                    ['icon' => 'bi bi-flower1', 'title' => 'Wellness & Spa', 'desc' => 'World-class spa rituals and mindful wellness experiences.'],
                    ['icon' => 'bi bi-house-heart-fill', 'title' => 'Private Villas', 'desc' => 'Pool villas from value stays to luxury properties.'],
                    ['icon' => 'bi bi-sign-turn-right-fill', 'title' => 'Easy Day Tours', 'desc' => 'Flexible routes covering temples, beaches, and viewpoints.'],
                    ['icon' => 'bi bi-currency-exchange', 'title' => 'Great Value', 'desc' => 'Strong value-for-money across food, stays, and activities.'],
                ],
                'seasons' => [
                    ['name' => 'April to June', 'weather' => 'Dry and comfortable (24°C to 31°C)', 'activities' => ['Temple tours', 'Waterfalls', 'Ubud stays'], 'recommendation' => 'Ideal start to Bali dry season.', 'icon' => 'bi bi-sun-fill'],
                    ['name' => 'July to September', 'weather' => 'Peak dry season (23°C to 30°C)', 'activities' => ['Beach clubs', 'Island tours', 'Surfing'], 'recommendation' => 'Best for lively holiday energy.', 'icon' => 'bi bi-umbrella-fill'],
                    ['name' => 'October to March', 'weather' => 'Tropical rains (24°C to 31°C)', 'activities' => ['Spa retreats', 'Cafe culture', 'Flexible sightseeing'], 'recommendation' => 'Good for slower, budget-aware travel.', 'icon' => 'bi bi-cloud-rain-heavy-fill'],
                ],
                'blogs' => [
                    ['title' => 'Bali 7-Day Route For First Timers', 'excerpt' => 'A balanced island plan covering Ubud, beaches, and Nusa Penida.', 'date' => '2026-02-22'],
                    ['title' => 'Best Bali Areas To Stay', 'excerpt' => 'Understand Ubud, Seminyak, Kuta, and Uluwatu before booking.', 'date' => '2026-02-03'],
                    ['title' => 'Bali Travel Budget Planner', 'excerpt' => 'Estimate total costs for stays, transfers, and top activities.', 'date' => '2026-01-11'],
                ],
                'testimonials' => [
                    ['name' => 'Nitin Shah', 'rating' => 4.9, 'text' => 'Our Bali itinerary had the right mix of activity and downtime.', 'location' => 'Ahmedabad', 'image' => 'https://i.pravatar.cc/100?img=54'],
                    ['name' => 'Pooja Menon', 'rating' => 4.8, 'text' => 'Villa recommendations and local tours were absolutely top quality.', 'location' => 'Kochi', 'image' => 'https://i.pravatar.cc/100?img=41'],
                    ['name' => 'Ishita Jain', 'rating' => 5, 'text' => 'Smooth transfers, beautiful stays, and excellent support throughout.', 'location' => 'Delhi', 'image' => 'https://i.pravatar.cc/100?img=58'],
                ],
                'faqs' => [
                    ['q' => 'How many days are enough for Bali?', 'a' => 'A 6 to 7 day plan is ideal for Ubud, beaches, and one island day trip.'],
                    ['q' => 'Is Bali good for honeymoon?', 'a' => 'Yes, Bali is highly popular for honeymoon due to villas, sunsets, and curated experiences.'],
                    ['q' => 'What is the best time to visit Bali?', 'a' => 'April to October is best for dry weather and outdoor activities.'],
                    ['q' => 'Can Bali suit family travel?', 'a' => 'Yes, Bali offers family-friendly resorts, cultural activities, and easy sightseeing options.'],
                ],
            ],
            'maldives' => [
                'primary_color' => '#06b6d4',
                'ideal_days' => '4-5 Days',
                'best_season' => 'Nov-Apr',
                'popular_for' => ['Water Villas', 'Snorkeling', 'Couple Trips'],
                'overview' => 'The Maldives is built for slow, premium island time, where the ocean is the center of every experience. Travelers choose it for private villas, clear lagoons, and seamless resort hospitality that makes the entire trip feel easy from arrival to departure. It is especially loved by honeymooners and couples, but families and luxury seekers also enjoy the calm environment and curated activity options like snorkeling safaris, sandbank lunches, and sunset cruises. Even short stays feel complete because each day offers a mix of relaxation and memorable water experiences, all surrounded by one of the most beautiful marine landscapes in the world.',
                'city_packages' => ['Male', 'Maafushi', 'Baa Atoll', 'North Male Atoll'],
                'places' => [
                    ['name' => 'North Male Atoll', 'description' => 'Top resort zone with easy transfers and iconic water-villa experiences.', 'attractions' => ['Private Islands', 'Reef Snorkeling', 'Sunset Cruises'], 'duration' => '3 Days', 'tags' => ['Luxury', 'Water']],
                    ['name' => 'Baa Atoll', 'description' => 'UNESCO biosphere reserve known for rich marine life and diving spots.', 'attractions' => ['Hanifaru Bay', 'Manta Rays', 'Coral Gardens'], 'duration' => '2 Days', 'tags' => ['Nature', 'Diving']],
                    ['name' => 'Maafushi', 'description' => 'Popular local island for budget-friendly stays and water sports.', 'attractions' => ['Sandbanks', 'Shark Point', 'Dolphin Tours'], 'duration' => '1-2 Days', 'tags' => ['Budget', 'Adventure']],
                ],
                'packages' => [
                    ['name' => 'Maldives Water Villa Escape', 'duration' => '4D/3N', 'rating' => 4.9, 'price' => '₹1,54,999', 'discounted price' => '₹1,29,999'],
                    ['name' => 'Maldives Couple Retreat', 'duration' => '5D/4N', 'rating' => 5.0, 'price' => '₹1,89,999', 'discounted price' => '₹1,59,999'],
                    ['name' => 'Maldives Family Resort Plan', 'duration' => '5D/4N', 'rating' => 4.8, 'price' => '₹1,74,999', 'discounted price' => '₹1,49,999'],
                ],
                'features' => [
                    ['icon' => 'bi bi-house-fill', 'title' => 'Overwater Villas', 'desc' => 'Iconic private stays with direct lagoon access.'],
                    ['icon' => 'bi bi-water', 'title' => 'Crystal Lagoons', 'desc' => 'Turquoise waters and pristine island scenery.'],
                    ['icon' => 'bi bi-life-preserver', 'title' => 'Marine Activities', 'desc' => 'Snorkeling, diving, and reef discovery experiences.'],
                    ['icon' => 'bi bi-heart-fill', 'title' => 'Honeymoon Favorite', 'desc' => 'Private dining, sunset moments, and exclusive services.'],
                    ['icon' => 'bi bi-cloud-sun-fill', 'title' => 'Relaxed Pace', 'desc' => 'Slow travel rhythm for complete mental reset.'],
                    ['icon' => 'bi bi-shield-check', 'title' => 'Resort Comfort', 'desc' => 'Well-managed hospitality and seamless transfers.'],
                ],
                'seasons' => [
                    ['name' => 'November to February', 'weather' => 'Dry and breezy (25°C to 30°C)', 'activities' => ['Water villas', 'Snorkeling', 'Couple dinners'], 'recommendation' => 'Peak season with the clearest conditions.', 'icon' => 'bi bi-sun-fill'],
                    ['name' => 'March to April', 'weather' => 'Warm and sunny (27°C to 32°C)', 'activities' => ['Diving', 'Cruises', 'Island hopping'], 'recommendation' => 'Excellent time for marine activities.', 'icon' => 'bi bi-brightness-high-fill'],
                    ['name' => 'May to October', 'weather' => 'Monsoon windows (25°C to 31°C)', 'activities' => ['Resort relaxation', 'Spa', 'Flexible tours'], 'recommendation' => 'Good for value-focused luxury stays.', 'icon' => 'bi bi-cloud-rain-heavy-fill'],
                ],
                'blogs' => [
                    ['title' => 'Maldives Resort Guide For First Timers', 'excerpt' => 'Choose the right island, transfer type, and stay style.', 'date' => '2026-03-09'],
                    ['title' => 'Maldives 4-Day Itinerary', 'excerpt' => 'How to enjoy luxury and marine activities in a short trip.', 'date' => '2026-02-08'],
                    ['title' => 'Water Villa Vs Beach Villa', 'excerpt' => 'Compare the two popular Maldives stay options before booking.', 'date' => '2026-01-17'],
                ],
                'testimonials' => [
                    ['name' => 'Aditi Verma', 'rating' => 5, 'text' => 'Every day felt dreamy, and our water-villa experience was flawless.', 'location' => 'Hyderabad', 'image' => 'https://i.pravatar.cc/100?img=8'],
                    ['name' => 'Manav Khurana', 'rating' => 4.9, 'text' => 'Perfect planning for a short luxury trip with zero hassle.', 'location' => 'Delhi', 'image' => 'https://i.pravatar.cc/100?img=19'],
                    ['name' => 'Sakshi Bhat', 'rating' => 4.8, 'text' => 'Great resort choice and amazing support from start to finish.', 'location' => 'Jaipur', 'image' => 'https://i.pravatar.cc/100?img=33'],
                ],
                'faqs' => [
                    ['q' => 'How many days are ideal for Maldives?', 'a' => 'A 4 to 5 day stay works very well for relaxation and water activities.'],
                    ['q' => 'When is the best time to visit Maldives?', 'a' => 'November to April is the most preferred season for clear skies and calm water.'],
                    ['q' => 'Is Maldives only for honeymooners?', 'a' => 'No, it is also a great destination for families and luxury leisure travelers.'],
                    ['q' => 'Is a short Maldives trip worth it?', 'a' => 'Yes, even short trips feel complete because resort experiences are highly curated.'],
                ],
            ],
            'kashmir' => [
                'primary_color' => '#2563eb',
                'ideal_days' => '5-7 Days',
                'best_season' => 'Mar-Jun, Oct-Feb',
                'popular_for' => ['Snow', 'Scenic Valleys', 'Family Trips'],
                'overview' => 'Kashmir combines grand mountain scenery with immersive local culture, making it one of India\'s most complete all-season destinations. In spring and summer, the valleys bloom with fresh landscapes and comfortable weather for sightseeing, while winter transforms Gulmarg and nearby regions into a snow lover\'s paradise. Travelers enjoy a wide range of experiences, from houseboat stays on Dal Lake to gondola rides, pine forest drives, and handcrafted local cuisine. Kashmir works well for families, couples, and adventure groups because each region brings a different vibe, and a properly sequenced itinerary helps cover both iconic landmarks and peaceful hidden spots in the same journey.',
                'city_packages' => ['Srinagar', 'Gulmarg', 'Pahalgam', 'Sonamarg', 'Doodhpathri'],
                'places' => [
                    ['name' => 'Srinagar', 'description' => 'Lakeside city famous for houseboats, gardens, and heritage bazaars.', 'attractions' => ['Dal Lake', 'Mughal Gardens', 'Old City Walk'], 'duration' => '2 Days', 'tags' => ['Culture', 'Family']],
                    ['name' => 'Gulmarg', 'description' => 'Snow destination known for skiing, gondola rides, and alpine meadows.', 'attractions' => ['Gondola', 'Apharwat', 'Snow Activities'], 'duration' => '2 Days', 'tags' => ['Snow', 'Adventure']],
                    ['name' => 'Pahalgam', 'description' => 'Scenic valleys and riverfront landscapes perfect for relaxed travel.', 'attractions' => ['Betaab Valley', 'Aru Valley', 'Lidder River'], 'duration' => '1-2 Days', 'tags' => ['Nature', 'Leisure']],
                ],
                'packages' => [
                    ['name' => 'Kashmir Scenic Escape', 'duration' => '6D/5N', 'rating' => 4.7, 'price' => '₹44,999', 'discounted price' => '₹37,999'],
                    ['name' => 'Kashmir Snow Adventure', 'duration' => '5D/4N', 'rating' => 4.8, 'price' => '₹41,999', 'discounted price' => '₹36,999'],
                    ['name' => 'Kashmir Family Comfort Tour', 'duration' => '6D/5N', 'rating' => 4.6, 'price' => '₹46,999', 'discounted price' => '₹39,999'],
                ],
                'features' => [
                    ['icon' => 'bi bi-snow2', 'title' => 'Winter Snow', 'desc' => 'Snow experiences, ski zones, and scenic winter routes.'],
                    ['icon' => 'bi bi-water', 'title' => 'Lake Stays', 'desc' => 'Houseboat and lakeside experiences with local charm.'],
                    ['icon' => 'bi bi-image-fill', 'title' => 'Valley Views', 'desc' => 'Wide mountain vistas and evergreen landscapes.'],
                    ['icon' => 'bi bi-bag-heart-fill', 'title' => 'Couple Friendly', 'desc' => 'Romantic stays and easy scenic day plans.'],
                    ['icon' => 'bi bi-people-fill', 'title' => 'Family Safe', 'desc' => 'Comfort-focused routes with flexible sightseeing.'],
                    ['icon' => 'bi bi-flower2', 'title' => 'Culture & Craft', 'desc' => 'Local food, handmade crafts, and traditional markets.'],
                ],
                'seasons' => [
                    ['name' => 'March to June', 'weather' => 'Pleasant spring-summer (12°C to 28°C)', 'activities' => ['Valley tours', 'Houseboats', 'Family travel'], 'recommendation' => 'Best for relaxed sightseeing.', 'icon' => 'bi bi-sun-fill'],
                    ['name' => 'July to September', 'weather' => 'Green monsoon phase (14°C to 24°C)', 'activities' => ['Offbeat routes', 'Nature walks', 'Budget trips'], 'recommendation' => 'Great for quieter landscapes.', 'icon' => 'bi bi-cloud-rain-fill'],
                    ['name' => 'October to February', 'weather' => 'Cold snowy winter (-2°C to 12°C)', 'activities' => ['Snow fun', 'Gondola', 'Winter stays'], 'recommendation' => 'Ideal for snowfall lovers.', 'icon' => 'bi bi-cloud-snow-fill'],
                ],
                'blogs' => [
                    ['title' => 'Kashmir 6-Day Family Itinerary', 'excerpt' => 'Plan Srinagar, Gulmarg, and Pahalgam in one smooth route.', 'date' => '2026-03-13'],
                    ['title' => 'Best Time To Visit Kashmir', 'excerpt' => 'Choose spring blooms or winter snow based on your travel style.', 'date' => '2026-02-14'],
                    ['title' => 'Kashmir Packing Guide', 'excerpt' => 'What to carry for changing temperatures across regions.', 'date' => '2026-01-23'],
                ],
                'testimonials' => [
                    ['name' => 'Neha Sethi', 'rating' => 4.9, 'text' => 'Great balance of comfort and sightseeing for our family group.', 'location' => 'Chandigarh', 'image' => 'https://i.pravatar.cc/100?img=39'],
                    ['name' => 'Kabir Arora', 'rating' => 4.8, 'text' => 'Snow planning in Gulmarg was excellent and totally stress-free.', 'location' => 'Noida', 'image' => 'https://i.pravatar.cc/100?img=44'],
                    ['name' => 'Shreya Paul', 'rating' => 4.7, 'text' => 'Loved the stays and route planning across valleys and lakes.', 'location' => 'Kolkata', 'image' => 'https://i.pravatar.cc/100?img=52'],
                ],
                'faqs' => [
                    ['q' => 'How many days are enough for Kashmir?', 'a' => 'A 5 to 7 day itinerary covers Srinagar, Gulmarg, and Pahalgam comfortably.'],
                    ['q' => 'Is Kashmir good for family travel?', 'a' => 'Yes, it is very suitable for families with scenic routes and flexible stays.'],
                    ['q' => 'When can I see snowfall in Kashmir?', 'a' => 'December to February is generally the best period for snowfall experiences.'],
                    ['q' => 'Is Kashmir expensive to travel?', 'a' => 'It can be planned for multiple budgets depending on stay category and season.'],
                ],
            ],
            'switzerland' => [
                'primary_color' => '#0ea5e9',
                'ideal_days' => '7-9 Days',
                'best_season' => 'May-Oct, Dec-Feb',
                'popular_for' => ['Alps', 'Scenic Trains', 'Premium Holidays'],
                'overview' => 'Switzerland is a destination where transport, scenery, and hospitality work together effortlessly, making it ideal for premium and first-time Europe travel. Mountain rail routes connect postcard towns, glacier valleys, and elegant cities, so you can enjoy dramatic views without complex logistics. Whether you prefer alpine adventures, lakeside relaxation, or cultural city breaks, Switzerland offers consistent quality and smooth on-ground travel. It is especially popular for honeymooners and families who want a polished itinerary with minimal stress and maximum scenic value, from Interlaken to Zermatt and Lucerne. With thoughtful planning, every day feels distinct while still maintaining a comfortable pace.',
                'city_packages' => ['Interlaken', 'Lucerne', 'Zermatt', 'Zurich', 'Geneva'],
                'places' => [
                    ['name' => 'Interlaken', 'description' => 'Adventure gateway with alpine views and access to Jungfrau region.', 'attractions' => ['Harder Kulm', 'Jungfraujoch', 'Lake Thun'], 'duration' => '2 Days', 'tags' => ['Adventure', 'Scenic']],
                    ['name' => 'Lucerne', 'description' => 'Lakeside town blending classic Swiss charm with mountain excursions.', 'attractions' => ['Chapel Bridge', 'Mt. Pilatus', 'Lake Cruise'], 'duration' => '2 Days', 'tags' => ['Culture', 'Leisure']],
                    ['name' => 'Zermatt', 'description' => 'Car-free alpine village known for Matterhorn views and winter sports.', 'attractions' => ['Matterhorn Glacier', 'Gornergrat', 'Ski Slopes'], 'duration' => '2 Days', 'tags' => ['Snow', 'Luxury']],
                ],
                'packages' => [
                    ['name' => 'Swiss Scenic Rail Tour', 'duration' => '8D/7N', 'rating' => 4.9, 'price' => '₹2,29,999', 'discounted price' => '₹1,99,999'],
                    ['name' => 'Switzerland Honeymoon Plan', 'duration' => '7D/6N', 'rating' => 4.9, 'price' => '₹2,14,999', 'discounted price' => '₹1,89,999'],
                    ['name' => 'Swiss Family Premium Tour', 'duration' => '9D/8N', 'rating' => 4.8, 'price' => '₹2,39,999', 'discounted price' => '₹2,09,999'],
                ],
                'features' => [
                    ['icon' => 'bi bi-train-front-fill', 'title' => 'Scenic Rail Network', 'desc' => 'Iconic train journeys through mountains, tunnels, and valleys.'],
                    ['icon' => 'bi bi-mountain', 'title' => 'Alpine Landscapes', 'desc' => 'High peaks, lakes, and glacier-backed viewpoints.'],
                    ['icon' => 'bi bi-house-check-fill', 'title' => 'Reliable Stays', 'desc' => 'Consistently high hospitality quality across regions.'],
                    ['icon' => 'bi bi-snow', 'title' => 'All-Season Appeal', 'desc' => 'Summer meadows and winter snow activities in one destination.'],
                    ['icon' => 'bi bi-heart-fill', 'title' => 'Honeymoon Friendly', 'desc' => 'Romantic stays with effortless transport planning.'],
                    ['icon' => 'bi bi-briefcase-fill', 'title' => 'Premium Comfort', 'desc' => 'Smooth travel systems ideal for stress-free holidays.'],
                ],
                'seasons' => [
                    ['name' => 'May to September', 'weather' => 'Mild summer (12°C to 26°C)', 'activities' => ['Rail journeys', 'Lake tours', 'Hiking'], 'recommendation' => 'Best for scenic exploration and active days.', 'icon' => 'bi bi-sun-fill'],
                    ['name' => 'October to November', 'weather' => 'Cool shoulder season (6°C to 16°C)', 'activities' => ['City breaks', 'Autumn landscapes', 'Budget luxury'], 'recommendation' => 'Good for quieter travel windows.', 'icon' => 'bi bi-cloud-sun-fill'],
                    ['name' => 'December to February', 'weather' => 'Cold snowy winter (-5°C to 8°C)', 'activities' => ['Ski trips', 'Christmas markets', 'Snow views'], 'recommendation' => 'Perfect for winter magic and alpine stays.', 'icon' => 'bi bi-cloud-snow-fill'],
                ],
                'blogs' => [
                    ['title' => 'Switzerland In 8 Days', 'excerpt' => 'A practical route covering Interlaken, Lucerne, and Zermatt.', 'date' => '2026-03-06'],
                    ['title' => 'Swiss Passes Explained', 'excerpt' => 'Understand rail passes and city transfers before booking.', 'date' => '2026-02-01'],
                    ['title' => 'Best Swiss Months By Travel Style', 'excerpt' => 'Pick summer, shoulder, or winter based on your itinerary goals.', 'date' => '2026-01-20'],
                ],
                'testimonials' => [
                    ['name' => 'Rahul Saini', 'rating' => 4.9, 'text' => 'The train routes and hotel flow were perfectly arranged.', 'location' => 'Gurugram', 'image' => 'https://i.pravatar.cc/100?img=61'],
                    ['name' => 'Megha Iyer', 'rating' => 4.8, 'text' => 'Our honeymoon felt seamless and every day had a wow moment.', 'location' => 'Chennai', 'image' => 'https://i.pravatar.cc/100?img=42'],
                    ['name' => 'Pranav Das', 'rating' => 4.9, 'text' => 'Loved the balance of alpine adventure and city comfort.', 'location' => 'Bhubaneswar', 'image' => 'https://i.pravatar.cc/100?img=66'],
                ],
                'faqs' => [
                    ['q' => 'How many days should I plan for Switzerland?', 'a' => 'A 7 to 9 day route is recommended for major alpine and city highlights.'],
                    ['q' => 'Is Switzerland good for honeymoon travel?', 'a' => 'Yes, it is one of the top premium honeymoon destinations worldwide.'],
                    ['q' => 'When should I visit Switzerland for snow?', 'a' => 'December to February is best for winter snow experiences.'],
                    ['q' => 'Can Switzerland be done without rushed travel?', 'a' => 'Yes, a well-planned rail itinerary keeps travel smooth and comfortable.'],
                ],
            ],
            'thailand' => [
                'primary_color' => '#ef4444',
                'ideal_days' => '6-8 Days',
                'best_season' => 'Nov-Mar',
                'popular_for' => ['Island Hopping', 'Nightlife', 'Value Travel'],
                'overview' => 'Thailand is one of the easiest and most rewarding international destinations for Indian travelers, thanks to its great value, strong tourism infrastructure, and wide mix of experiences. In one trip you can combine city life in Bangkok, island adventures in Phuket or Krabi, and relaxed beach days with vibrant nightlife. The destination works for friends, couples, and families because activities can be fully customized around pace and budget. From temple circuits and floating markets to speedboat tours and sunset dinners, Thailand gives travelers a high experience-to-cost ratio. It is especially popular for first-time international trips where convenience and variety are equally important.',
                'city_packages' => ['Bangkok', 'Phuket', 'Krabi', 'Pattaya', 'Chiang Mai'],
                'places' => [
                    ['name' => 'Bangkok', 'description' => 'Energetic capital blending temples, shopping, and nightlife.', 'attractions' => ['Grand Palace', 'Chao Phraya Cruise', 'Floating Market'], 'duration' => '2 Days', 'tags' => ['City', 'Culture']],
                    ['name' => 'Phuket', 'description' => 'Beach destination with island tours, cafes, and lively entertainment.', 'attractions' => ['Patong', 'Phi Phi Tour', 'Big Buddha'], 'duration' => '2-3 Days', 'tags' => ['Beach', 'Nightlife']],
                    ['name' => 'Krabi', 'description' => 'Known for limestone cliffs, clear waters, and calm island life.', 'attractions' => ['Four Island Tour', 'Railay Beach', 'Ao Nang'], 'duration' => '2 Days', 'tags' => ['Nature', 'Leisure']],
                ],
                'packages' => [
                    ['name' => 'Thailand Island Combo', 'duration' => '7D/6N', 'rating' => 4.7, 'price' => '₹74,999', 'discounted price' => '₹64,999'],
                    ['name' => 'Thailand Friends Special', 'duration' => '6D/5N', 'rating' => 4.6, 'price' => '₹66,999', 'discounted price' => '₹56,999'],
                    ['name' => 'Thailand Family Fun Plan', 'duration' => '7D/6N', 'rating' => 4.5, 'price' => '₹79,999', 'discounted price' => '₹69,999'],
                ],
                'features' => [
                    ['icon' => 'bi bi-water', 'title' => 'Island Routes', 'desc' => 'World-famous beaches and island-hopping experiences.'],
                    ['icon' => 'bi bi-lightning-charge-fill', 'title' => 'Vibrant Nightlife', 'desc' => 'From beach clubs to city entertainment zones.'],
                    ['icon' => 'bi bi-cash-stack', 'title' => 'High Value', 'desc' => 'Excellent balance of price, quality, and activities.'],
                    ['icon' => 'bi bi-basket-fill', 'title' => 'Shopping & Food', 'desc' => 'Street markets, malls, and strong culinary variety.'],
                    ['icon' => 'bi bi-emoji-smile-fill', 'title' => 'Easy First Trip', 'desc' => 'Friendly destination with smooth tourist support.'],
                    ['icon' => 'bi bi-people-fill', 'title' => 'Group Friendly', 'desc' => 'Works for couples, friends, and family travelers alike.'],
                ],
                'seasons' => [
                    ['name' => 'November to February', 'weather' => 'Pleasant high season (23°C to 31°C)', 'activities' => ['Island tours', 'Nightlife', 'City sightseeing'], 'recommendation' => 'Best overall season for first-time visitors.', 'icon' => 'bi bi-sun-fill'],
                    ['name' => 'March to May', 'weather' => 'Warm summer (27°C to 35°C)', 'activities' => ['Beach breaks', 'Spa stays', 'Water activities'], 'recommendation' => 'Great for beach-centric holidays.', 'icon' => 'bi bi-brightness-high-fill'],
                    ['name' => 'June to October', 'weather' => 'Monsoon phase (25°C to 32°C)', 'activities' => ['Budget trips', 'Flexible itineraries', 'Urban experiences'], 'recommendation' => 'Useful for value-focused travel planning.', 'icon' => 'bi bi-cloud-rain-fill'],
                ],
                'blogs' => [
                    ['title' => 'Thailand 7-Day Plan For First Timers', 'excerpt' => 'Combine Bangkok and islands with the right travel flow.', 'date' => '2026-03-01'],
                    ['title' => 'Phuket Vs Krabi: Which One To Choose?', 'excerpt' => 'Pick the island style that fits your travel mood.', 'date' => '2026-02-10'],
                    ['title' => 'Thailand Trip Cost Breakdown', 'excerpt' => 'Understand flights, stays, and activity budgets in advance.', 'date' => '2026-01-14'],
                ],
                'testimonials' => [
                    ['name' => 'Harshit Bansal', 'rating' => 4.7, 'text' => 'Great coordination and perfect pace for our Thailand friend trip.', 'location' => 'Indore', 'image' => 'https://i.pravatar.cc/100?img=11'],
                    ['name' => 'Rachita Bose', 'rating' => 4.8, 'text' => 'Every transfer and island tour was smoothly managed.', 'location' => 'Kolkata', 'image' => 'https://i.pravatar.cc/100?img=37'],
                    ['name' => 'Aman Srivastava', 'rating' => 4.6, 'text' => 'Value for money was excellent and hotels were very good.', 'location' => 'Lucknow', 'image' => 'https://i.pravatar.cc/100?img=22'],
                ],
                'faqs' => [
                    ['q' => 'How many days are enough for Thailand?', 'a' => 'A 6 to 8 day itinerary works well for Bangkok and one or two islands.'],
                    ['q' => 'Is Thailand suitable for family trips?', 'a' => 'Yes, it has family-friendly resorts, island tours, and easy local transport.'],
                    ['q' => 'When should I plan a Thailand trip?', 'a' => 'November to February is the most recommended season for weather and activities.'],
                    ['q' => 'Is Thailand expensive?', 'a' => 'Thailand offers strong value and can be planned for multiple budgets.'],
                ],
            ],
            'dubai' => [
                'primary_color' => '#f59e0b',
                'ideal_days' => '4-5 Days',
                'best_season' => 'Nov-Mar',
                'popular_for' => ['Luxury', 'Desert Safari', 'Family Attractions'],
                'overview' => 'Dubai is a high-energy destination where futuristic architecture, premium shopping, and desert experiences come together in a compact, easy-to-navigate city. It is ideal for travelers who want polished infrastructure and a mix of indoor and outdoor attractions in a short duration trip. From Burj Khalifa and Marina evenings to desert safaris and theme parks, Dubai offers activities for couples, families, and corporate groups alike. The city is especially popular because it delivers luxury at multiple price levels, with dependable transport and excellent hospitality standards. Even a four or five day itinerary can feel complete when planned around neighborhood clusters and timed experiences.',
                'city_packages' => ['Downtown Dubai', 'Dubai Marina', 'Palm Jumeirah', 'Deira', 'Jumeirah'],
                'places' => [
                    ['name' => 'Downtown Dubai', 'description' => 'Home to iconic skyscrapers, premium malls, and fountain shows.', 'attractions' => ['Burj Khalifa', 'Dubai Mall', 'Dubai Fountain'], 'duration' => '1-2 Days', 'tags' => ['Luxury', 'City']],
                    ['name' => 'Dubai Marina', 'description' => 'Modern waterfront district with cruises, dining, and skyline views.', 'attractions' => ['Marina Walk', 'Dhow Cruise', 'JBR Beach'], 'duration' => '1 Day', 'tags' => ['Nightlife', 'Scenic']],
                    ['name' => 'Dubai Desert Zone', 'description' => 'Adventure region for dune drives, camps, and cultural performances.', 'attractions' => ['Desert Safari', 'Dune Bashing', 'BBQ Camp'], 'duration' => '1 Day', 'tags' => ['Adventure', 'Culture']],
                ],
                'packages' => [
                    ['name' => 'Dubai Luxury Highlights', 'duration' => '5D/4N', 'rating' => 4.8, 'price' => '₹1,24,999', 'discounted price' => '₹1,09,999'],
                    ['name' => 'Dubai Family Explorer', 'duration' => '5D/4N', 'rating' => 4.7, 'price' => '₹1,18,999', 'discounted price' => '₹1,04,999'],
                    ['name' => 'Dubai Short Break', 'duration' => '4D/3N', 'rating' => 4.6, 'price' => '₹99,999', 'discounted price' => '₹89,999'],
                ],
                'features' => [
                    ['icon' => 'bi bi-buildings-fill', 'title' => 'Skyline Landmarks', 'desc' => 'World-famous architecture and observation decks.'],
                    ['icon' => 'bi bi-bag-check-fill', 'title' => 'Luxury Shopping', 'desc' => 'From designer malls to traditional souk experiences.'],
                    ['icon' => 'bi bi-truck-front-fill', 'title' => 'Desert Adventures', 'desc' => 'Dune bashing and camp nights with cultural programs.'],
                    ['icon' => 'bi bi-controller', 'title' => 'Family Attractions', 'desc' => 'Theme parks, aquariums, and kid-friendly entertainment.'],
                    ['icon' => 'bi bi-shield-check', 'title' => 'Travel Ease', 'desc' => 'Safe, clean, and tourist-friendly city infrastructure.'],
                    ['icon' => 'bi bi-cup-straw', 'title' => 'Global Dining', 'desc' => 'Strong international food scene and luxury hospitality.'],
                ],
                'seasons' => [
                    ['name' => 'November to February', 'weather' => 'Pleasant winter (17°C to 29°C)', 'activities' => ['City tours', 'Desert safari', 'Beach evenings'], 'recommendation' => 'Top season for outdoor experiences.', 'icon' => 'bi bi-sun-fill'],
                    ['name' => 'March to April', 'weather' => 'Warm shoulder season (22°C to 34°C)', 'activities' => ['Attractions', 'Cruises', 'Shopping'], 'recommendation' => 'Good mix of weather and crowd comfort.', 'icon' => 'bi bi-cloud-sun-fill'],
                    ['name' => 'May to October', 'weather' => 'Hot summer (30°C to 42°C)', 'activities' => ['Indoor attractions', 'Luxury stays', 'Shopping festivals'], 'recommendation' => 'Works for summer deals and indoor plans.', 'icon' => 'bi bi-brightness-high-fill'],
                ],
                'blogs' => [
                    ['title' => 'Dubai 5-Day Itinerary', 'excerpt' => 'Cover all iconic attractions without packing too much in one day.', 'date' => '2026-03-10'],
                    ['title' => 'Best Areas To Stay In Dubai', 'excerpt' => 'Compare Downtown, Marina, and Palm for your travel style.', 'date' => '2026-02-19'],
                    ['title' => 'Dubai Trip Budget Guide', 'excerpt' => 'Smart planning tips for stays, food, and attraction passes.', 'date' => '2026-01-29'],
                ],
                'testimonials' => [
                    ['name' => 'Komal Arora', 'rating' => 4.8, 'text' => 'The city tour and desert safari combination was perfectly curated.', 'location' => 'Delhi', 'image' => 'https://i.pravatar.cc/100?img=68'],
                    ['name' => 'Pratik Naidu', 'rating' => 4.7, 'text' => 'Great hotel location and smooth sightseeing logistics.', 'location' => 'Nagpur', 'image' => 'https://i.pravatar.cc/100?img=28'],
                    ['name' => 'Sonal Deshpande', 'rating' => 4.8, 'text' => 'Very family-friendly itinerary with premium comfort throughout.', 'location' => 'Pune', 'image' => 'https://i.pravatar.cc/100?img=57'],
                ],
                'faqs' => [
                    ['q' => 'How many days are ideal for Dubai?', 'a' => 'A 4 to 5 day itinerary is enough for major highlights and leisure time.'],
                    ['q' => 'Is Dubai good for family trips?', 'a' => 'Yes, Dubai is excellent for families with world-class attractions and safety.'],
                    ['q' => 'What is the best season for Dubai?', 'a' => 'November to March is the best period for outdoor activities.'],
                    ['q' => 'Can Dubai be done on a moderate budget?', 'a' => 'Yes, with smart hotel and attraction planning, multiple budget levels are possible.'],
                ],
            ],
            'goa' => [
                'primary_color' => '#14b8a6',
                'ideal_days' => '3-5 Days',
                'best_season' => 'Oct-Mar',
                'popular_for' => ['Beaches', 'Nightlife', 'Weekend Trips'],
                'overview' => 'Goa remains one of the most flexible domestic getaways because it can be shaped into a quick weekend break, a slow beach holiday, or an activity-focused friend trip. North Goa offers high-energy nightlife, cafes, and water sports, while South Goa brings quieter beaches, boutique stays, and laid-back coastal drives. Travelers return to Goa repeatedly because every trip can feel different based on where you stay and how you pace your itinerary. Beyond beaches, Goa also offers heritage churches, spice farms, river cruises, and local seafood trails, making it an easy destination for couples, families, and groups looking for both comfort and fun.',
                'city_packages' => ['North Goa', 'South Goa', 'Panaji', 'Candolim', 'Palolem'],
                'places' => [
                    ['name' => 'North Goa', 'description' => 'Lively beach belt with cafes, nightlife, and activity zones.', 'attractions' => ['Baga Beach', 'Anjuna', 'Fort Aguada'], 'duration' => '2 Days', 'tags' => ['Friends', 'Nightlife']],
                    ['name' => 'South Goa', 'description' => 'Peaceful coast known for scenic beaches and relaxed stays.', 'attractions' => ['Palolem', 'Colva', 'Cabo de Rama'], 'duration' => '1-2 Days', 'tags' => ['Leisure', 'Couples']],
                    ['name' => 'Panaji & Old Goa', 'description' => 'Colonial history, riverside views, and local food culture.', 'attractions' => ['Fontainhas', 'Basilica', 'Mandovi Cruise'], 'duration' => '1 Day', 'tags' => ['Culture', 'Family']],
                ],
                'packages' => [
                    ['name' => 'Goa Weekend Escape', 'duration' => '4D/3N', 'rating' => 4.5, 'price' => '₹18,999', 'discounted price' => '₹16,999'],
                    ['name' => 'Goa Friends Party Trip', 'duration' => '5D/4N', 'rating' => 4.6, 'price' => '₹24,999', 'discounted price' => '₹21,999'],
                    ['name' => 'Goa Relaxed Family Stay', 'duration' => '4D/3N', 'rating' => 4.4, 'price' => '₹21,499', 'discounted price' => '₹19,499'],
                ],
                'features' => [
                    ['icon' => 'bi bi-sunset-fill', 'title' => 'Beach Sunsets', 'desc' => 'Golden-hour coastal spots and sea-facing cafe evenings.'],
                    ['icon' => 'bi bi-music-note-beamed', 'title' => 'Nightlife Scene', 'desc' => 'Clubs, shacks, and live music in popular beach zones.'],
                    ['icon' => 'bi bi-tropical-storm', 'title' => 'Water Sports', 'desc' => 'Parasailing, jet ski, and coastal adventure options.'],
                    ['icon' => 'bi bi-car-front-fill', 'title' => 'Easy Road Travel', 'desc' => 'Simple self-drive and short-distance sightseeing routes.'],
                    ['icon' => 'bi bi-egg-fried', 'title' => 'Seafood Trails', 'desc' => 'Strong local and global food choices across regions.'],
                    ['icon' => 'bi bi-house-heart-fill', 'title' => 'Flexible Stays', 'desc' => 'Resorts, villas, and boutique stays for every budget.'],
                ],
                'seasons' => [
                    ['name' => 'October to February', 'weather' => 'Best beach weather (22°C to 31°C)', 'activities' => ['Beach time', 'Water sports', 'Nightlife'], 'recommendation' => 'Most popular and event-friendly season.', 'icon' => 'bi bi-sun-fill'],
                    ['name' => 'March to May', 'weather' => 'Warm summer (25°C to 34°C)', 'activities' => ['Resort stays', 'Leisure travel', 'Early morning tours'], 'recommendation' => 'Good for short summer breaks.', 'icon' => 'bi bi-brightness-high-fill'],
                    ['name' => 'June to September', 'weather' => 'Monsoon green season (23°C to 30°C)', 'activities' => ['Scenic drives', 'Cafes', 'Rainy-day relaxation'], 'recommendation' => 'Great for offbeat monsoon charm.', 'icon' => 'bi bi-cloud-rain-fill'],
                ],
                'blogs' => [
                    ['title' => 'Goa 4-Day Plan For First Timers', 'excerpt' => 'Balance North Goa energy with South Goa relaxation.', 'date' => '2026-03-08'],
                    ['title' => 'Where To Stay In Goa', 'excerpt' => 'Choose the right area for nightlife, family comfort, or peace.', 'date' => '2026-02-13'],
                    ['title' => 'Goa Monsoon Vs Winter Travel', 'excerpt' => 'Pick the season that matches your travel mood and budget.', 'date' => '2026-01-21'],
                ],
                'testimonials' => [
                    ['name' => 'Dev Malhotra', 'rating' => 4.6, 'text' => 'Our Goa plan had the perfect mix of beach fun and downtime.', 'location' => 'Delhi', 'image' => 'https://i.pravatar.cc/100?img=17'],
                    ['name' => 'Ankita More', 'rating' => 4.5, 'text' => 'Loved the stay recommendations and smooth local coordination.', 'location' => 'Mumbai', 'image' => 'https://i.pravatar.cc/100?img=63'],
                    ['name' => 'Yash Patil', 'rating' => 4.4, 'text' => 'Great value package with very good planning support.', 'location' => 'Nashik', 'image' => 'https://i.pravatar.cc/100?img=36'],
                ],
                'faqs' => [
                    ['q' => 'How many days are enough for Goa?', 'a' => 'A 3 to 5 day itinerary is ideal for beaches, nightlife, and local sightseeing.'],
                    ['q' => 'Is Goa good for family and couples?', 'a' => 'Yes, North and South Goa both offer stay styles for different travel needs.'],
                    ['q' => 'What is the best season for Goa?', 'a' => 'October to March is most preferred for pleasant beach weather.'],
                    ['q' => 'Can Goa be done on a budget?', 'a' => 'Yes, Goa has strong choices from budget stays to premium resorts.'],
                ],
            ],
        ];
    }

    private function genericProfile(Destination $destination): array
    {
        $name = $destination->name;
        $tags = collect($destination->tags ?? [])->filter()->take(3)->values()->all();
        $highlights = collect($destination->highlights ?? [])->filter()->take(3)->values()->all();

        return [
            'primary_color' => '#2563eb',
            'ideal_days' => $destination->ideal_days ?: '5-7 Days',
            'best_season' => $destination->best_season ?: 'Best in shoulder seasons',
            'popular_for' => $tags ?: ['Culture', 'Scenic Views', 'Local Experiences'],
            'overview' => $name . ' offers a strong mix of iconic sightseeing and local culture, making it suitable for couples, families, and group travelers alike. With the right route planning, you can combine signature landmarks, regional food, and hidden neighborhoods without feeling rushed. This destination works well for both first-time and repeat travelers because each area offers a different mood, from energetic city stretches to slower scenic pockets. Our curated planning approach helps you maximize each day with smooth transfers, practical pacing, and flexible activity choices that match your travel style and budget. Whether you are looking for comfort, adventure, or premium experiences, a thoughtfully built ' . $name . ' itinerary can deliver a complete and memorable holiday.',
            'city_packages' => [$name . ' Central', $name . ' Waterfront', $name . ' Old Town', $name . ' Scenic Region'],
            'places' => [
                ['name' => $name . ' City Highlights', 'description' => 'Top landmarks and signature experiences in the main city zone.', 'attractions' => array_slice(array_merge($highlights, ['Main Square', 'Local Market', 'Heritage Street']), 0, 3), 'duration' => '2 Days', 'tags' => ['City', 'Culture']],
                ['name' => $name . ' Nature Belt', 'description' => 'Scenic pockets around the destination with a slower travel pace.', 'attractions' => ['Viewpoint Trail', 'Riverfront Zone', 'Sunset Point'], 'duration' => '1-2 Days', 'tags' => ['Nature', 'Leisure']],
                ['name' => $name . ' Local Experiences', 'description' => 'Food, neighborhood walks, and authentic regional activities.', 'attractions' => ['Food Walk', 'Craft Market', 'Local Museum'], 'duration' => '1 Day', 'tags' => ['Local', 'Family']],
            ],
            'packages' => [
                ['name' => $name . ' Explorer Package', 'duration' => '5D/4N', 'rating' => 4.6, 'price' => $destination->formatted_price ?? '₹39,999'],
                ['name' => $name . ' Family Comfort Package', 'duration' => '6D/5N', 'rating' => 4.5, 'price' => $destination->formatted_price ?? '₹44,999'],
                ['name' => $name . ' Premium Package', 'duration' => '7D/6N', 'rating' => 4.8, 'price' => $destination->formatted_price ?? '₹59,999'],
            ],
            'features' => [
                ['icon' => 'bi bi-stars', 'title' => 'Signature Sightseeing', 'desc' => 'Well-planned routes across top attractions and hidden gems.'],
                ['icon' => 'bi bi-heart-fill', 'title' => 'Couple Friendly', 'desc' => 'Balanced pace with romantic and leisure-oriented experiences.'],
                ['icon' => 'bi bi-people-fill', 'title' => 'Family Friendly', 'desc' => 'Comfort-focused options suitable for all age groups.'],
                ['icon' => 'bi bi-compass-fill', 'title' => 'Flexible Itineraries', 'desc' => 'Customizable activities based on your travel goals.'],
                ['icon' => 'bi bi-camera2', 'title' => 'Scenic Locations', 'desc' => 'Photo-worthy viewpoints and memorable local landscapes.'],
                ['icon' => 'bi bi-shield-check', 'title' => 'Smooth Planning', 'desc' => 'Reliable stays, transfers, and on-trip support.'],
            ],
            'seasons' => [
                ['name' => 'Peak Season', 'weather' => 'Most preferred travel window', 'activities' => ['Sightseeing', 'Outdoor tours', 'Local exploration'], 'recommendation' => 'Great for first-time travelers.', 'icon' => 'bi bi-sun-fill'],
                ['name' => 'Shoulder Season', 'weather' => 'Comfortable with moderate crowds', 'activities' => ['Balanced itineraries', 'Value stays', 'Flexible plans'], 'recommendation' => 'Best balance of pace and pricing.', 'icon' => 'bi bi-cloud-sun-fill'],
                ['name' => 'Off Season', 'weather' => 'Lower crowds and seasonal value', 'activities' => ['Relaxed travel', 'Indoor experiences', 'Slow itineraries'], 'recommendation' => 'Ideal for budget-aware travelers.', 'icon' => 'bi bi-cloud-rain-fill'],
            ],
            'blogs' => [
                ['title' => 'Best Time To Visit ' . $name, 'excerpt' => 'Understand seasons, weather, and travel style matches.', 'date' => '2026-03-02'],
                ['title' => $name . ' Itinerary Guide', 'excerpt' => 'A practical route plan to cover major highlights smoothly.', 'date' => '2026-02-11'],
                ['title' => $name . ' Travel Budget Planner', 'excerpt' => 'How to estimate stays, activities, and local transport costs.', 'date' => '2026-01-19'],
            ],
            'testimonials' => [
                ['name' => 'Aarav Sharma', 'rating' => 4.8, 'text' => 'The destination planning was smooth, clear, and very well paced.', 'location' => 'Delhi', 'image' => 'https://i.pravatar.cc/100?img=23'],
                ['name' => 'Mitali Joshi', 'rating' => 4.7, 'text' => 'Great support and excellent recommendations for stays and routes.', 'location' => 'Pune', 'image' => 'https://i.pravatar.cc/100?img=45'],
                ['name' => 'Karan Mehta', 'rating' => 4.8, 'text' => 'Loved the balance of comfort, sightseeing, and local experiences.', 'location' => 'Ahmedabad', 'image' => 'https://i.pravatar.cc/100?img=34'],
            ],
            'faqs' => [
                ['q' => 'How many days should I plan for ' . $name . '?', 'a' => 'Most travelers enjoy ' . $name . ' in a 5 to 7 day itinerary.'],
                ['q' => 'Is ' . $name . ' suitable for family travel?', 'a' => 'Yes, family-friendly routes and stay categories are available.'],
                ['q' => 'What is the best season to visit ' . $name . '?', 'a' => 'The best season depends on weather preference and activity goals.'],
                ['q' => 'Can this trip be customized?', 'a' => 'Yes, the itinerary can be tailored to your budget and travel style.'],
            ],
        ];
    }

    public function packagePdf(Destination $destination, string $packageSlug)
    {
        abort_unless($destination->is_active, 404);

        $destinationProfile = $this->buildDestinationProfile($destination);
        $destinationPackages = $this->resolvePackageCollection($destination, $destinationProfile);
        $selectedPackage = collect($destinationPackages)->firstWhere('package_slug', $packageSlug);

        abort_if($selectedPackage === null, 404);

        $packagePageData = $this->buildPackagePageData(
            $destination,
            $destinationProfile,
            $selectedPackage,
            $destinationPackages
        );

        $html = view('destination.package-pdf', compact(
            'destination',
            'destinationProfile',
            'selectedPackage',
            'packagePageData'
        ))->render();

        $pdf = Pdf::loadHTML($html);
        $filename = Str::slug($selectedPackage['name']) . '-' . now()->format('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }

    private function getLocationOptions(Destination $destination): array
    {
        $slug = Str::lower($destination->slug);

        $cityMap = [
            'himachal' => ['Himachal', 'Shimla', 'Manali', 'Dharamshala', 'Kullu'],
            'kashmir' => ['Kashmir', 'Srinagar', 'Gulmarg', 'Pahalgam', 'Sonamarg'],
            'goa' => ['Goa', 'North Goa', 'South Goa', 'Panaji', 'Candolim'],
            'dubai' => ['Dubai', 'Downtown', 'Marina', 'Palm Jumeirah', 'Deira'],
            'bali' => ['Bali', 'Ubud', 'Seminyak', 'Uluwatu', 'Nusa Penida'],
            'maldives' => ['Maldives', 'Male', 'Baa Atoll', 'North Male Atoll'],
            'switzerland' => ['Switzerland', 'Interlaken', 'Lucerne', 'Zermatt', 'Zurich'],
            'thailand' => ['Thailand', 'Bangkok', 'Phuket', 'Krabi', 'Pattaya'],
            'santorini' => ['Santorini', 'Oia', 'Fira', 'Imerovigli', 'Kamari'],
        ];

        foreach ($cityMap as $keyword => $cities) {
            if (Str::contains($slug, $keyword)) {
                return $cities;
            }
        }

        return [$destination->name];
    }
}

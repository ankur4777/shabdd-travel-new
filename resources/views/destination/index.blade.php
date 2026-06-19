@extends('layouts.app')

@php
    $selectedDestination = $destinationOptions->firstWhere('slug', request('destination'));
    $selectedCategory = request('category');
    $heroDestination = $destinationCards->first();
    $heroImage = $heroDestination['image'] ?? asset('images/couple-bg.jpg');
    $heroDestinationNames = $destinationCards->pluck('name')->filter()->unique()->take(4)->values();
    $heroStartingPrice = $destinationCards->min('min_price');
    $heroTravelStyleCount = $destinationCards->pluck('travel_styles')->flatten()->filter()->unique()->count();
    $heroPackageCount = $destinationCards->sum('package_count');
    $ratingLabels = [
        '5' => '5 Star',
        '4' => '4+ Rating',
        '3' => '3+ Rating',
    ];
    $durationLabels = [
        '1-3' => '1-3 Days',
        '4-6' => '4-6 Days',
        '7-plus' => '7+ Days',
    ];
    $sortLabels = [
        'low_to_high' => 'Price Low to High',
        'high_to_low' => 'Price High to Low',
        'highest_rated' => 'Highest Rated',
        'most_popular' => 'Most Popular',
        'newest' => 'Newest First',
    ];
    $activeFilters = [];
    $priceIsFiltered = (int) $selectedMinPrice > (int) ($priceBounds['min'] ?? 0)
        || (int) $selectedMaxPrice < (int) ($priceBounds['max'] ?? 0);

    if ($selectedDestination) {
        $activeFilters[] = ['label' => 'Destination', 'value' => $selectedDestination['name']];
    }

    if ($selectedCategory && isset($categoryOptions[$selectedCategory])) {
        $activeFilters[] = ['label' => 'Category', 'value' => $categoryOptions[$selectedCategory]];
    }

    if (request('travel_style') && isset($travelStyleOptions[request('travel_style')])) {
        $activeFilters[] = ['label' => 'Travel Style', 'value' => $travelStyleOptions[request('travel_style')]];
    }

    if ($priceIsFiltered) {
        $activeFilters[] = [
            'label' => 'Price',
            'value' => '₹' . number_format($selectedMinPrice) . ' - ₹' . number_format($selectedMaxPrice),
        ];
    }

    if (request('rating') && isset($ratingLabels[request('rating')])) {
        $activeFilters[] = ['label' => 'Rating', 'value' => $ratingLabels[request('rating')]];
    }

    if (request('duration') && isset($durationLabels[request('duration')])) {
        $activeFilters[] = ['label' => 'Duration', 'value' => $durationLabels[request('duration')]];
    }

    if (request('sort') && request('sort') !== 'newest' && isset($sortLabels[request('sort')])) {
        $activeFilters[] = ['label' => 'Sort', 'value' => $sortLabels[request('sort')]];
    }

    $hasActiveFilters = count($activeFilters) > 0;
@endphp

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/package-filters.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/package-filters.js') }}" defer></script>
@endpush

@section('content')
    <section class="pkg-listing-section dst-page-section">
        <div class="container">
            <section class="dst-hero-section" style="--dst-hero-image: url('{{ $heroImage }}');">
                <div class="dst-hero-shell">
                    <div class="dst-hero-copy">
                        <nav class="dst-hero-breadcrumb" aria-label="Breadcrumb">
                            <a href="{{ url('/') }}">Home</a>
                            <span aria-hidden="true">/</span>
                            <span>Destinations</span>
                        </nav>

                        <span class="dst-hero-kicker">All Destination Pages</span>
                        <h1>Explore destinations that match your next travel mood</h1>
                        <p>
                            Browse admin-managed destination pages with real package counts, starting prices,
                            travel styles, and quick filters to narrow down the right escape faster.
                        </p>

                        <div class="dst-hero-actions">
                            <a href="#destinationResults" class="dst-hero-btn dst-hero-btn-primary">
                                Explore Destinations
                                <i class="bi bi-arrow-down-right"></i>
                            </a>
                            <a
                                href="{{ $hasActiveFilters ? route('destinations.index') : route('contact') }}"
                                class="dst-hero-btn dst-hero-btn-secondary"
                            >
                                {{ $hasActiveFilters ? 'Clear Filters' : 'Plan With Us' }}
                            </a>
                        </div>

                        @if($heroDestinationNames->isNotEmpty())
                            <div class="dst-hero-tags" aria-label="Featured destinations">
                                @foreach($heroDestinationNames as $heroName)
                                    <span>{{ $heroName }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="dst-hero-panel">
                        <div class="dst-hero-stat-grid">
                            <article class="dst-hero-stat">
                                <strong>{{ $destinationCount }}</strong>
                                <span>{{ \Illuminate\Support\Str::plural('destination', $destinationCount) }} live</span>
                            </article>
                            <article class="dst-hero-stat">
                                <strong>{{ $heroStartingPrice ? '₹' . number_format($heroStartingPrice) : 'Custom' }}</strong>
                                <span>starting budget</span>
                            </article>
                            <article class="dst-hero-stat">
                                <strong>{{ $heroTravelStyleCount ?: 1 }}</strong>
                                <span>{{ \Illuminate\Support\Str::plural('travel style', max($heroTravelStyleCount, 1)) }}</span>
                            </article>
                        </div>

                        <article class="dst-hero-spotlight">
                            <span class="dst-hero-spotlight-label">Quick Snapshot</span>
                            <h2>{{ $heroDestination['name'] ?? 'Curated India & beyond' }}</h2>
                            <p>
                                {{ $heroPackageCount ?: 0 }} {{ \Illuminate\Support\Str::plural('package', $heroPackageCount ?: 0) }}
                                across destination pages curated from your admin panel.
                            </p>
                            <div class="dst-hero-spotlight-meta">
                                <span>
                                    <i class="bi bi-geo-alt-fill"></i>
                                    {{ $heroDestination['country'] ?? 'Travel-ready collection' }}
                                </span>
                                <span>
                                    <i class="bi bi-star-fill"></i>
                                    {{ $heroDestination['rating'] ?: 'Freshly added' }}
                                </span>
                            </div>
                        </article>
                    </div>
                </div>
            </section>

            <div class="pkg-listing-top">
                <div class="section-heading text-start pkg-section-heading">
                    <span>{{ $hasActiveFilters ? 'Filtered Results' : 'Destination Collection' }}</span>
                    <h2 id="destinationResults">{{ $hasActiveFilters ? 'Destinations Matching Your Filters' : 'Explore Destination Pages' }}</h2>
                    <p class="pkg-section-description">
                        {{ $hasActiveFilters
                            ? 'Fine-tune your filters or clear them to widen your destination choices.'
                            : 'Compare destinations by category, style, duration, rating, and starting budget.' }}
                    </p>
                </div>

                <div class="pkg-count-card">
                    <strong>{{ $destinationCount }}</strong>
                    <span>{{ \Illuminate\Support\Str::plural('destination', $destinationCount) }} found</span>
                </div>
            </div>

            <div class="pkg-mobile-filter-bar d-lg-none">
                <div>
                    <strong>{{ $destinationCount }}</strong>
                    <span>{{ \Illuminate\Support\Str::plural('destination', $destinationCount) }} available</span>
                </div>
                <button
                    class="pkg-mobile-filter-btn"
                    type="button"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#destinationFilterOffcanvas"
                    aria-controls="destinationFilterOffcanvas"
                >
                    <i class="bi bi-sliders"></i>
                    Filters
                </button>
            </div>

            @if(count($activeFilters))
                <div class="pkg-active-filters">
                    <span class="pkg-active-title">Active filters</span>
                    @foreach($activeFilters as $filter)
                        <span class="pkg-filter-chip">
                            {{ $filter['label'] }}: {{ $filter['value'] }}
                        </span>
                    @endforeach
                    <a href="{{ route('destinations.index') }}">Clear all</a>
                </div>
            @endif

            <div class="row g-4 align-items-start">
                <aside class="col-lg-3 d-none d-lg-block">
                    <form method="GET" action="{{ route('destinations.index') }}" class="pkg-filter-panel" data-package-filter-form>
                        @include('partials.destination-filter-fields', ['fieldPrefix' => 'destinationDesktop'])
                    </form>
                </aside>

                <div class="col-lg-9">
                    @if($destinationCards->isEmpty())
                        <div class="pkg-empty-state">
                            <span><i class="bi bi-search-heart"></i></span>
                            <h3>No destinations found</h3>
                            <p>Create active destinations from admin or clear filters to see destination cards here.</p>
                            <a href="{{ route('destinations.index') }}">Clear Filters</a>
                        </div>
                    @else
                        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4 dst-card-grid">
                            @foreach($destinationCards as $destination)
                                <div class="col">
                                    <article class="dst-card">
                                        <a
                                            href="{{ route('destinations.show', $destination['slug']) }}"
                                            class="dst-card-detail-link"
                                            aria-label="View details for {{ $destination['name'] }}"
                                        ></a>
                                        <div class="dst-card-media">
                                            <img src="{{ $destination['image'] }}" alt="{{ $destination['name'] }}" loading="lazy">
                                            <span class="dst-card-count">
                                                {{ $destination['package_count'] }}
                                                {{ \Illuminate\Support\Str::plural('Package', $destination['package_count']) }}
                                            </span>
                                            <span class="dst-card-rating">
                                                <i class="bi bi-star-fill"></i>
                                                {{ $destination['rating'] ?: 'New' }}
                                            </span>
                                        </div>

                                        <div class="dst-card-body">
                                            <div>
                                                <p class="dst-card-location">
                                                    <i class="bi bi-geo-alt-fill"></i>
                                                    {{ $destination['country'] ?: 'Curated destination' }}
                                                </p>
                                                <h3>{{ $destination['name'] }}</h3>
                                            </div>

                                            <div class="dst-card-tags">
                                                @foreach($destination['travel_styles'] as $style)
                                                    <span>{{ $travelStyleOptions[$style] ?? ucfirst($style) }}</span>
                                                @endforeach

                                                @if($destination['min_days'] && $destination['max_days'])
                                                    <span>
                                                        {{ $destination['min_days'] === $destination['max_days']
                                                            ? $destination['min_days'] . ' Days'
                                                            : $destination['min_days'] . '-' . $destination['max_days'] . ' Days' }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="dst-card-price">
                                                <span>Starting from</span>
                                                <strong>
                                                    ₹{{ number_format($destination['min_price']) }}
                                                    @if($destination['min_price'] !== $destination['max_price'])
                                                        to ₹{{ number_format($destination['max_price']) }}
                                                    @endif
                                                </strong>
                                            </div>

                                            <a href="{{ $destination['detail_url'] }}" class="dst-card-link">
                                                View Packages
                                                <i class="bi bi-arrow-right"></i>
                                            </a>
                                        </div>
                                    </article>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div
            class="offcanvas offcanvas-end pkg-filter-offcanvas d-lg-none"
            tabindex="-1"
            id="destinationFilterOffcanvas"
            aria-labelledby="destinationFilterOffcanvasLabel"
        >
            <div class="offcanvas-header">
                <div>
                    <span class="pkg-offcanvas-kicker">Travel filters</span>
                    <h5 id="destinationFilterOffcanvasLabel">Refine destinations</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <div class="offcanvas-body">
                <form method="GET" action="{{ route('destinations.index') }}" class="pkg-filter-panel pkg-filter-panel-mobile" data-package-filter-form>
                    @include('partials.destination-filter-fields', ['fieldPrefix' => 'destinationMobile'])
                </form>
            </div>
        </div>
    </section>
@endsection

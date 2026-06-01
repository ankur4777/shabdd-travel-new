@extends('layouts.app')

@php
    $selectedDestination = $destinationOptions->firstWhere('slug', request('destination'));
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
            <div class="pkg-listing-top">
                <div class="section-heading text-start pkg-section-heading">
                    <span>All Destinations</span>
                    <h2>Explore Package Destinations</h2>
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
                            <p>Upload packages from admin or clear filters to see destination cards here.</p>
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

                                            <a href="{{ route('packages.show', $destination['featured_package_slug']) }}" class="dst-card-link">
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

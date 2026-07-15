@php
    $selectedDestination = $destinations->firstWhere('slug', request('destination'));
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
        $activeFilters[] = ['label' => 'Destination', 'value' => $selectedDestination->name];
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

<section class="pkg-listing-section">
    <div class="container">
        <div class="pkg-listing-top">
            <div class="section-heading text-start pkg-section-heading">
                <span>{{ $sectionKicker }}</span>
                <h2>{{ $sectionTitle }}</h2>
            </div>

            <div class="pkg-count-card">

                <span><strong>{{ $packageCount }}</strong>{{ \Illuminate\Support\Str::plural('package', $packageCount) }}
                    found</span>
            </div>
        </div>

        <div class="pkg-mobile-filter-bar d-lg-none">
            <div>
                <strong>{{ $packageCount }}</strong>
                <span>{{ \Illuminate\Support\Str::plural('package', $packageCount) }} available</span>
            </div>
            <button class="pkg-mobile-filter-btn" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#{{ $listingKey }}FilterOffcanvas" aria-controls="{{ $listingKey }}FilterOffcanvas">
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
                <a href="{{ $listingRoute }}">Clear all</a>
            </div>
        @endif

        <div class="row g-4 align-items-start">
            <aside class="col-lg-3 d-none d-lg-block">
                <form method="GET" action="{{ $listingRoute }}" class="pkg-filter-panel" data-package-filter-form>
                    @include('partials.package-filter-fields', ['fieldPrefix' => $listingKey . 'Desktop'])
                </form>
            </aside>

            <div class="col-lg-9">
                @if($packages->isEmpty())
                    <div class="pkg-empty-state">
                        <span><i class="bi bi-search-heart"></i></span>
                        <h3>No packages found</h3>
                        <p>Try a wider price range or clear filters to see more handpicked trips.</p>
                        <a href="{{ $listingRoute }}">Clear Filters</a>
                    </div>
                @else
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4 pkg-package-grid">
                        @foreach($packages as $package)
                            @php
                                $packageImage = $package->image
                                    ? asset('storage/' . $package->image)
                                    : asset('images/couple-bg.jpg');
                            @endphp

                            <div class="col">
                                <div class="honeymoon-package-card pkg-tour-card">
                                    <a href="{{ route('packages.show', $package->slug) }}">
                                        <div class="package-image">
                                            <img src="{{ $packageImage }}" alt="{{ $package->title }}"
                                                width="360"
                                                height="240"
                                                loading="{{ $loop->iteration <= 3 ? 'eager' : 'lazy' }}"
                                                fetchpriority="{{ $loop->first ? 'high' : 'auto' }}"
                                                decoding="async">

                                            <span class="package-tag">
                                                {{ $package->category ?? $defaultTag }}
                                            </span>

                                            <span class="package-duration">
                                                <i class="bi bi-star-fill"></i>
                                                {{ $package->rating ? number_format((float) $package->rating, 1) : 'New' }}
                                            </span>
                                        </div>
                                    </a>

                                    <div class="package-content">
                                        <a href="{{ route('packages.show', $package->slug) }}" style="text-decoration: none;">
                                            <h3>{{ $package->title }}</h3>
                                        </a>

                                        <div class="package-badges">
                                            @if($package->duration_text)
                                                <span>{{ $package->duration_text }}</span>
                                            @elseif($package->days)
                                                <span>{{ $package->days }} Days</span>
                                            @endif

                                            @if($package->country)
                                                <span>{{ $package->country }}</span>
                                            @endif

                                            @if($package->theme)
                                                <span>{{ $package->theme }}</span>
                                            @endif
                                        </div>

                                        <ul class="package-features">
                                            @if($package->feature_1)
                                                <li>{{ $package->feature_1 }}</li>
                                            @endif

                                            @if($package->feature_2)
                                                <li>{{ $package->feature_2 }}</li>
                                            @endif

                                            @if($package->feature_3)
                                                <li>{{ $package->feature_3 }}</li>
                                            @endif
                                        </ul>

                                        <div class="package-footer">
                                            <div class="package-price">
                                                @if($package->old_price)
                                                    <del>₹{{ number_format($package->old_price) }}</del>
                                                @endif

                                                <h4>₹{{ number_format($package->price) }}</h4>
                                                <p>Per couple</p>
                                            </div>

                                            <a href="{{ route('packages.show', $package->slug) }}" class="package-btn">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end pkg-filter-offcanvas d-lg-none" tabindex="-1"
        id="{{ $listingKey }}FilterOffcanvas" aria-labelledby="{{ $listingKey }}FilterOffcanvasLabel">
        <div class="offcanvas-header">
            <div>
                <span class="pkg-offcanvas-kicker">Travel filters</span>
                <h5 id="{{ $listingKey }}FilterOffcanvasLabel">Refine packages</h5>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">
            <form method="GET" action="{{ $listingRoute }}" class="pkg-filter-panel pkg-filter-panel-mobile"
                data-package-filter-form>
                @include('partials.package-filter-fields', ['fieldPrefix' => $listingKey . 'Mobile'])
            </form>
        </div>
    </div>
</section>

@once
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/package-filters.css') }}">
    @endpush

    @push('scripts')
        <script src="{{ asset('js/package-filters.js') }}" defer></script>
    @endpush
@endonce

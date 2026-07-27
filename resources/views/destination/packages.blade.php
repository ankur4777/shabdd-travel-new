@extends('layouts.app')

@section('content')
    {{-- Mobile Filter Trigger (sticky) --}}
    <div class="df-mobile-filter-bar d-lg-none">
        <button class="df-mobile-filter-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#dfFilterOffcanvas"
            aria-controls="dfFilterOffcanvas">
            <i class="bi bi-sliders2"></i>
            <span>Filters</span>
            <span class="df-filter-badge" id="dfMobileFilterBadge" style="display:none;">0</span>
        </button>
        <div class="df-mobile-sort-wrap">
            <select class="df-mobile-sort-select" id="dfMobileSortSelect" aria-label="Sort by">
                <option value="popular">Most Popular</option>
                <option value="budget">Budget Friendly</option>
                <option value="luxury">Luxury</option>
                <option value="trending">Trending</option>
                <option value="duration">Duration</option>
            </select>
            <i class="bi bi-chevron-down df-mobile-sort-chevron"></i>
        </div>
    </div>

    {{-- Mobile Offcanvas Sidebar --}}
    <div class="offcanvas offcanvas-start df-offcanvas" tabindex="-1" id="dfFilterOffcanvas"
        aria-labelledby="dfFilterOffcanvasLabel">
        <div class="offcanvas-header df-offcanvas-header">
            <div>
                <h5 class="offcanvas-title df-sidebar-title" id="dfFilterOffcanvasLabel">Find Your Perfect Journey</h5>
                <p class="df-sidebar-subtitle">Filter curated travel experiences.</p>
            </div>
            <button type="button" class="df-offcanvas-close" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="offcanvas-body df-offcanvas-body">
            <div id="dfOffcanvasContent"></div>
        </div>
    </div>

    <section class="df-section" id="dfSection">
        <div class="df-wrapper">
            {{-- LEFT SIDEBAR --}}
            <aside class="df-sidebar d-none d-lg-flex" id="dfSidebar" aria-label="Filter destinations">
                <div class="df-sidebar-inner">
                    <div class="df-sidebar-head">
                        <div class="df-sidebar-head-icon">
                            <i class="bi bi-compass"></i>
                        </div>
                        <div>
                            <h2 class="df-sidebar-title">Find Your Perfect Journey</h2>
                            <p class="df-sidebar-subtitle">Filter curated travel experiences based on your travel style.</p>
                        </div>
                    </div>

                    <div class="df-filter-group" id="dfDesktopDestGroup">
                        <label class="df-filter-label" for="dfDestination">
                            <i class="bi bi-geo-alt"></i> Destination
                        </label>
                        <div class="df-select-wrap">
                            <select class="df-select" id="dfDestination" aria-label="Select destination">
                                <option value="">All Destinations</option>
                                <option value="bali">Bali</option>
                                <option value="goa">Goa</option>
                                <option value="dubai">Dubai</option>
                                <option value="thailand">Thailand</option>
                                <option value="maldives">Maldives</option>
                                <option value="kashmir">Kashmir</option>
                                <option value="kerala">Kerala</option>
                                <option value="switzerland">Switzerland</option>
                            </select>
                            <i class="bi bi-chevron-down df-select-chevron"></i>
                        </div>
                    </div>

                    <div class="df-filter-group" id="dfDesktopBudgetGroup">
                        <label class="df-filter-label">
                            <i class="bi bi-currency-rupee"></i> Budget
                        </label>
                        <div class="df-budget-options" id="dfBudgetOptions" role="radiogroup" aria-label="Budget range">
                        </div>
                    </div>

                    <div class="df-filter-group">
                        <label class="df-filter-label">
                            <i class="bi bi-clock"></i> Duration
                        </label>
                        <div class="df-chip-group" id="dfDurationGroup" role="group" aria-label="Duration">
                            <button class="df-chip" data-filter="duration" data-value="weekend">Weekend</button>
                            <button class="df-chip" data-filter="duration" data-value="3-5">3–5 Days</button>
                            <button class="df-chip" data-filter="duration" data-value="5-7">5–7 Days</button>
                            <button class="df-chip" data-filter="duration" data-value="7+">7+ Days</button>
                        </div>
                    </div>

                    <div class="df-filter-group">
                        <label class="df-filter-label">
                            <i class="bi bi-heart"></i> Travel Style
                        </label>
                        <div class="df-chip-group df-chip-group--wrap" id="dfStyleGroup" role="group"
                            aria-label="Travel style">
                            <button class="df-chip" data-filter="style" data-value="honeymoon">💑 Honeymoon</button>
                            <button class="df-chip" data-filter="style" data-value="adventure">🧗 Adventure</button>
                            <button class="df-chip" data-filter="style" data-value="family">👨👩👧 Family</button>
                            <button class="df-chip" data-filter="style" data-value="solo">🎒 Solo</button>
                            <button class="df-chip" data-filter="style" data-value="friends">🎉 Friends</button>
                            <button class="df-chip" data-filter="style" data-value="luxury">✨ Luxury</button>
                            <button class="df-chip" data-filter="style" data-value="corporate-tour">🏢 Corporate Tour</button>
                        </div>
                    </div>

                    <div class="df-filter-group">
                        <label class="df-filter-label">
                            <i class="bi bi-globe2"></i> Trip Type
                        </label>
                        <div class="df-toggle-pill" id="dfTripToggle" role="radiogroup" aria-label="Trip type">
                            <button class="df-toggle-btn df-toggle-btn--active" data-value="all"
                                aria-pressed="true">All</button>
                            <button class="df-toggle-btn" data-value="domestic" aria-pressed="false">Domestic</button>
                            <button class="df-toggle-btn" data-value="international"
                                aria-pressed="false">International</button>
                        </div>
                    </div>

                    <div class="df-filter-group">
                        <label class="df-filter-label">
                            <i class="bi bi-sun"></i> Season
                        </label>
                        <div class="df-chip-group df-chip-group--wrap" id="dfSeasonGroup" role="group" aria-label="Season">
                            <button class="df-chip" data-filter="season" data-value="summer">☀️ Summer</button>
                            <button class="df-chip" data-filter="season" data-value="winter">❄️ Winter</button>
                            <button class="df-chip" data-filter="season" data-value="monsoon">🌧️ Monsoon</button>
                            <button class="df-chip" data-filter="season" data-value="december">🎄 December</button>
                        </div>
                    </div>

                    <div class="df-filter-group">
                        <label class="df-filter-label">
                            <i class="bi bi-star"></i> Minimum Rating
                        </label>
                        <div class="df-chip-group" id="dfRatingGroup" role="radiogroup" aria-label="Minimum rating">
                            <button class="df-chip" data-filter="rating" data-value="4">4★ & above</button>
                            <button class="df-chip" data-filter="rating" data-value="4.5">4.5★ & above</button>
                        </div>
                    </div>

                    <div class="df-filter-group">
                        <label class="df-filter-label" for="dfSort">
                            <i class="bi bi-sort-down"></i> Sort By
                        </label>
                        <div class="df-select-wrap">
                            <select class="df-select" id="dfSort" aria-label="Sort results">
                                <option value="popular">Most Popular</option>
                                <option value="budget">Budget Friendly</option>
                                <option value="luxury">Luxury</option>
                                <option value="trending">Trending</option>
                                <option value="duration">Duration</option>
                            </select>
                            <i class="bi bi-chevron-down df-select-chevron"></i>
                        </div>
                    </div>

                    <div class="df-sidebar-actions">
                        <button class="df-btn-clear" id="dfClearFilters" type="button" aria-label="Clear all filters">
                            <i class="bi bi-x-circle"></i> Clear Filters
                        </button>
                        <button class="df-btn-search" id="dfExploreBtn" type="button">
                            <i class="bi bi-search"></i> Explore Packages
                        </button>
                    </div>
                </div>
            </aside>

            {{-- RIGHT CONTENT --}}
            <div class="df-results" id="dfResults">
                <div class="df-results-topbar">
                    <div class="df-results-meta">
                        <h2 class="df-results-title">Explore Travel Packages</h2>
                        <p class="df-results-subtitle">Handpicked journeys curated based on your travel preferences.</p>
                    </div>
                    <div class="df-results-controls">
                        <span class="df-results-count" id="dfResultsCount">{{ count($allPackages) }} packages found</span>
                        <div class="df-active-filters" id="dfActiveFilters" aria-live="polite"></div>
                        <a href="{{ route('home') }}" class="btn btn-outline-dark btn-sm">Back to Home</a>
                    </div>
                </div>

                <div class="df-cards-grid df-cards2" id="dfCardsGrid" aria-live="polite" aria-label="Package results">

                    @forelse ($allPackages as $package)
                        <article class="df-card" data-destination="{{ strtolower($package['destination_name'] ?? 'other') }}"
                            data-type="{{ $package['type'] ?? 'domestic' }}"
                            data-style="{{ $package['style'] ?? 'family,friends' }}"
                            data-season="{{ $package['season'] ?? 'summer,winter' }}"
                            data-duration="{{ $package['duration_code'] ?? '5-7' }}"
                            data-rating="{{ $package['rating'] ?? 4.5 }}"
                            data-price="{{ $package['price_numeric'] ?? (is_numeric($package['discounted_price'] ?? null) ? (float) $package['discounted_price'] : ($package['price_numeric'] ?? 25000)) }}"
                            data-category="{{ $package['category_key'] ?? \Illuminate\Support\Str::slug($package['category'] ?? $package['tag'] ?? '') }}"
                            data-tag="{{ $package['tag'] ?? '' }}">
                            <div class="df-card-img-wrap">
                                <img src="{{ $package['image'] }}" alt="{{ $package['name'] }}" class="df-card-img"
                                    loading="lazy">
                                <div class="df-card-overlay"></div>
                                @if (!empty($package['tag']))
                                    <div class="df-card-badges">
                                        <span class="df-badge df-badge--{{ $package['tag'] }}">{{ ucfirst($package['tag']) }}</span>
                                    </div>
                                @endif
                                <button class="df-wishlist-btn" aria-label="Add to wishlist" data-wishlisted="false">
                                    <i class="bi bi-heart"></i>
                                </button>
                                <div class="df-card-rating">
                                    <i class="bi bi-star-fill"></i>
                                    {{ $package['rating'] ?? number_format($package['destination']->rating ?? 4.6, 1) }}
                                </div>
                            </div>
                            <div class="df-card-body">
                                <div class="df-card-header">
                                    <div>
                                        <h3 class="df-card-name">{{ $package['name'] }}</h3>
                                        <p class="df-card-location"><i class="bi bi-geo-alt-fill"></i>
                                            {{ $package['destination_country'] ?? $package['destination_name'] }}</p>
                                    </div>
                                    <div class="df-card-price-block">
                                        <span class="df-price-from">From</span>
                                        <span class="df-price">{{ $package['discounted_price'] ?? $package['price'] }}</span>
                                    </div>
                                </div>
                                <div class="df-card-highlights">
                                    <span><i class="bi bi-clock"></i> {{ $package['duration'] }}</span>
                                    <span><i class="bi bi-check-circle"></i> Hotel Included</span>
                                    <span><i class="bi bi-camera"></i> Sightseeing</span>
                                </div>
                                <div class="df-card-tags">
                                    @foreach(explode(',', $package['style_labels'] ?? 'Family,Friends') as $style)
                                        <span class="df-tag">{{ trim($style) }}</span>
                                    @endforeach
                                </div>
                                <a href="{{ $package['detail_url'] }}" class="df-card-btn">View Details <i
                                        class="bi bi-arrow-right"></i></a>
                            </div>
                        </article>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-secondary mb-0">No packages found yet.</div>
                        </div>
                    @endforelse
                </div>

                <div class="df-no-results" id="dfNoResults" style="display:none;" aria-live="assertive">
                    <div class="df-no-results-inner">
                        <div class="df-no-results-icon"><i class="bi bi-search-heart"></i></div>
                        <h3>No packages found</h3>
                        <p>Try adjusting your filters or clearing them to discover more destinations.</p>
                        <button class="df-btn-search" id="dfClearFiltersAlt" type="button">
                            <i class="bi bi-arrow-counterclockwise"></i> Reset Filters
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

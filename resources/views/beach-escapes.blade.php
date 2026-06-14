@extends('layouts.app')

@section('meta')
    <title>Beach Escapes | SHABDD TRAVEL</title>
    <meta name="description"
        content="Discover Beach Escapes across Goa, Andaman, Gokarna, Pondicherry, Kovalam, and Lakshadweep with curated beach packages, smart filters, and premium travel experiences.">
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/beach-escapes.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
@endpush

@php
    $whyChoose = [
        ['icon' => 'bi bi-water', 'title' => 'Coastline-first planning', 'text' => 'We focus on beach-friendly timings, scenic stays, and routes that keep you close to the shore.'],
        ['icon' => 'bi bi-stars', 'title' => 'Premium stays', 'text' => 'Handpicked resorts and boutique hotels that bring more comfort, privacy, and sea-facing value.'],
        ['icon' => 'bi bi-truck', 'title' => 'Smooth transfers', 'text' => 'Airport pickups, island transfers, and local movement planned so the trip feels easy from day one.'],
        ['icon' => 'bi bi-shield-check', 'title' => 'Trusted booking support', 'text' => 'A clean booking process with responsive guidance before, during, and after travel.'],
    ];

    $travelTips = [
        ['title' => 'Choose the right season', 'text' => 'Goa and Pondicherry are great across shoulder seasons, while Andaman and Lakshadweep reward clear-weather planning.'],
        ['title' => 'Pack light and smart', 'text' => 'Quick-dry clothes, reef-safe sunscreen, sandals, and a light layer for breezy evenings work best.'],
        ['title' => 'Book early for islands', 'text' => 'Island stays and ferry-linked trips can sell fast during long weekends and holiday windows.'],
        ['title' => 'Balance beach and experience', 'text' => 'Mix relaxation with one or two activities, like water sports, sunset cruises, or local food trails.'],
    ];

    $testimonials = [
        ['name' => 'Aarav & Meera', 'rating' => 5, 'text' => 'Our Goa package felt polished and easy. Great hotel choice, smooth transfers, and exactly the right pace for a beach holiday.'],
        ['name' => 'Nisha R.', 'rating' => 5, 'text' => 'We booked Andaman for our family and the itinerary made sense from start to finish. The island days were memorable and stress-free.'],
        ['name' => 'Karan S.', 'rating' => 5, 'text' => 'The team helped us compare beach options and find a honeymoon-style escape that felt premium without being overcomplicated.'],
    ];

    $faqs = [
        ['question' => 'Which beach destination is best for first-time travelers?', 'answer' => 'Goa is usually the easiest first choice because it has a strong mix of beaches, food, stays, and transport convenience.'],
        ['question' => 'Which destination is best for honeymoon trips?', 'answer' => 'Andaman, Lakshadweep, and Kovalam are popular for couples who want quieter beaches, beautiful stays, and more privacy.'],
        ['question' => 'Can I find family-friendly beach packages here?', 'answer' => 'Yes. Use the Family filter to find packages that suit relaxed sightseeing, comfortable stays, and easy transfers.'],
        ['question' => 'Are adventure activities available on beach trips?', 'answer' => 'Yes. Adventure beach trips can include snorkeling, scuba, kayaking, parasailing, or island exploration depending on the destination.'],
    ];
@endphp

@section('content')
    <div class="beach-page">
        <section class="beach-hero" aria-label="Beach Escapes Hero"
            style="--beach-hero-image: url('{{ asset('images/kerala.avif') }}');">
            <div class="beach-hero__overlay"></div>
            <div class="container beach-shell">
                <div class="beach-hero__grid">
                    <div class="beach-hero__copy">
                        <span class="beach-eyebrow"><i class="bi bi-sunrise-fill" aria-hidden="true"></i> Coastal escapes
                            across India</span>
                        <h1>Beach Escapes</h1>
                        <p class="beach-hero__subheading">
                            Discover Sun, Sand &amp; Sea Across India's Most Beautiful Coastlines
                        </p>
                        <p class="beach-hero__description">
                            From Goa's lively shores to the calm waters of Andaman and Lakshadweep, this page brings
                            together beach-ready itineraries and premium packages designed to increase bookings.
                        </p>

                        <div class="beach-hero__actions">
                            <a href="#beach-destinations" class="beach-btn beach-btn--primary">
                                Explore Destinations <i class="bi bi-arrow-right" aria-hidden="true"></i>
                            </a>
                            <a href="#beach-packages" class="beach-btn beach-btn--ghost">
                                View Popular Packages
                            </a>
                        </div>
                    </div>

                    <aside class="beach-hero__panel">
                        <div class="beach-panel__badge">Top coastal picks</div>
                        <h2>Book the beach vibe that fits your trip</h2>
                        <div class="beach-panel__stats">
                            <div>
                                <strong>{{ $beachDestinationCount }}</strong>
                                <span>Beach destinations</span>
                            </div>
                            <div>
                                <strong>{{ $beachPackageCount }}</strong>
                                <span>Popular packages</span>
                            </div>
                            <div>
                                <strong>5★</strong>
                                <span>Premium booking feel</span>
                            </div>
                        </div>
                        <a href="#beach-packages" class="beach-panel__link">
                            Go straight to packages <i class="bi bi-arrow-right" aria-hidden="true"></i>
                        </a>
                    </aside>
                </div>
            </div>
        </section>

        <section class="beach-destinations" id="beach-destinations" aria-label="Beach destinations">
            <div class="container">
                <div class="beach-section-head beach-section-head--split">
                    <div>
                        <span class="beach-eyebrow beach-eyebrow--dark">Beach theme destinations</span>
                        <h2>Filter beach destinations</h2>
                        <p>Use price, travel style, trip type, rating, and sorting to narrow the beach destination slider.</p>
                    </div>

                    <a href="#beach-packages" class="beach-text-link">Skip to packages</a>
                </div>

                <form method="GET" action="{{ route('beach-escapes') }}" class="beach-destination-filter-panel"
                    data-beach-destination-filter-form>
                    <div class="beach-filter-card beach-filter-card--wide">
                        <div class="beach-filter-card__head">
                            <div>
                                <span>Price Range</span>
                                <h3>Choose a budget window</h3>
                            </div>
                            <strong>
                                <span data-beach-price-min-label>{{ '₹' . number_format($selectedMinPrice) }}</span>
                                -
                                <span data-beach-price-max-label>{{ '₹' . number_format($selectedMaxPrice) }}</span>
                            </strong>
                        </div>

                        <div class="beach-range-slider" data-beach-range data-min="{{ $priceBounds['min'] ?? 0 }}"
                            data-max="{{ $priceBounds['max'] ?? 0 }}">
                            <div class="beach-range-track">
                                <span data-beach-range-progress></span>
                            </div>
                            <input type="range" name="min_price" min="{{ $priceBounds['min'] ?? 0 }}"
                                max="{{ $priceBounds['max'] ?? 0 }}" step="1000" value="{{ $selectedMinPrice }}"
                                aria-label="Minimum beach destination price" data-beach-range-min>
                            <input type="range" name="max_price" min="{{ $priceBounds['min'] ?? 0 }}"
                                max="{{ $priceBounds['max'] ?? 0 }}" step="1000" value="{{ $selectedMaxPrice }}"
                                aria-label="Maximum beach destination price" data-beach-range-max>
                        </div>

                        <div class="beach-price-boundaries">
                            <span>{{ '₹' . number_format($priceBounds['min'] ?? 0) }}</span>
                            <span>{{ '₹' . number_format($priceBounds['max'] ?? 0) }}</span>
                        </div>
                    </div>

                    <div class="beach-filter-card">
                        <div class="beach-filter-card__head">
                            <div>
                                <span>Travel Styles</span>
                                <h3>Match the trip mood</h3>
                            </div>
                        </div>

                        <div class="beach-chip-grid">
                            @forelse($beachTravelStyleOptions as $travelStyle)
                                <label class="beach-chip-option">
                                    <input type="checkbox" name="travel_styles[]" value="{{ $travelStyle }}"
                                        {{ in_array($travelStyle, $selectedTravelStyles, true) ? 'checked' : '' }}
                                        data-beach-auto-submit>
                                    <span>{{ $travelStyle }}</span>
                                </label>
                            @empty
                                <div class="beach-filter-note">No travel styles found in admin yet.</div>
                            @endforelse
                        </div>
                    </div>

                    <div class="beach-filter-card">
                        <label for="beachTripType" class="beach-filter-label">Trip Type</label>
                        <select id="beachTripType" name="trip_type" class="form-select beach-filter-select"
                            data-beach-auto-submit>
                            <option value="all" {{ $selectedTripType === 'all' ? 'selected' : '' }}>All Trips</option>
                            <option value="domestic" {{ $selectedTripType === 'domestic' ? 'selected' : '' }}>Domestic</option>
                            <option value="international" {{ $selectedTripType === 'international' ? 'selected' : '' }}>International</option>
                        </select>
                    </div>

                    <div class="beach-filter-card">
                        <div class="beach-filter-card__head">
                            <div>
                                <span>Ratings</span>
                                <h3>Minimum rating</h3>
                            </div>
                        </div>

                        <div class="beach-segment-list">
                            @foreach([5, 4.5, 4, 3] as $rating)
                                <label class="beach-segment-option">
                                    <input type="radio" name="rating" value="{{ $rating }}"
                                        {{ $selectedRating !== null && (float) $selectedRating === (float) $rating ? 'checked' : '' }}
                                        data-beach-auto-submit>
                                    <span>{{ $rating }}+ Rating</span>
                                </label>
                            @endforeach
                            <label class="beach-segment-option">
                                <input type="radio" name="rating" value=""
                                    {{ $selectedRating === null ? 'checked' : '' }} data-beach-auto-submit>
                                <span>Any Rating</span>
                            </label>
                        </div>
                    </div>

                    <div class="beach-filter-card">
                        <label for="beachSort" class="beach-filter-label">Sort By</label>
                        <select id="beachSort" name="sort" class="form-select beach-filter-select"
                            data-beach-auto-submit>
                            <option value="newest" {{ $selectedSort === 'newest' ? 'selected' : '' }}>Newest First</option>
                            <option value="low_to_high" {{ $selectedSort === 'low_to_high' ? 'selected' : '' }}>Price Low to High</option>
                            <option value="high_to_low" {{ $selectedSort === 'high_to_low' ? 'selected' : '' }}>Price High to Low</option>
                            <option value="highest_rated" {{ $selectedSort === 'highest_rated' ? 'selected' : '' }}>Highest Rated</option>
                            <option value="most_popular" {{ $selectedSort === 'most_popular' ? 'selected' : '' }}>Most Popular</option>
                        </select>
                    </div>

                    <div class="beach-filter-actions">
                        <button type="submit" class="beach-filter-actions__apply">Apply Filters</button>
                        <a href="{{ route('beach-escapes') }}" class="beach-filter-actions__clear">Clear All</a>
                    </div>
                </form>

                @if($beachDestinations->isEmpty())
                    <div class="beach-empty beach-empty--slider">
                        <h3>No beach destinations match your filters</h3>
                        <p>Try a wider price range, fewer travel styles, or switch the trip type to see more beach options.</p>
                    </div>
                @else
                    <div class="swiper beach-destination-swiper" data-beach-destination-swiper>
                        <div class="swiper-wrapper">
                            @foreach($beachDestinations as $destination)
                                @php
                                    $destinationTripType = \Illuminate\Support\Str::lower(trim((string) ($destination['country'] ?? ''))) !== 'india'
                                        ? 'International'
                                        : 'Domestic';
                                    $destinationStyles = collect($destination['travel_styles'] ?? [])->take(3)->values();
                                @endphp
                                <div class="swiper-slide">
                                    <article class="beach-destination-card beach-destination-card--slider">
                                        <div class="beach-destination-card__media"
                                            style="background-image: linear-gradient(180deg, rgba(8, 47, 73, 0.10), rgba(8, 47, 73, 0.68)), url('{{ $destination['image'] }}');">
                                            <span class="beach-destination-card__badge">{{ $destinationTripType }}</span>
                                        </div>
                                        <div class="beach-destination-card__body">
                                            <div class="beach-destination-card__top">
                                                <div>
                                                    <p>{{ $destination['country'] ?? 'India' }}</p>
                                                    <h3>{{ $destination['name'] }}</h3>
                                                </div>
                                                <strong>{{ $destination['price_from'] ? 'From ₹' . number_format((int) $destination['price_from']) : '' }}</strong>
                                            </div>
                                            <p>{{ $destination['description'] }}</p>
                                            <div class="beach-destination-card__meta">
                                                <span><i class="bi bi-calendar3" aria-hidden="true"></i> {{ $destination['duration'] }}</span>
                                                <span><i class="bi bi-star-fill" aria-hidden="true"></i> {{ $destination['rating'] ? number_format((float) $destination['rating'], 1) : 'New' }}</span>
                                            </div>
                                            @if($destinationStyles->isNotEmpty())
                                                <div class="beach-destination-card__styles">
                                                    @foreach($destinationStyles as $style)
                                                        <span>{{ $style }}</span>
                                                    @endforeach
                                                </div>
                                            @endif
                                            <a href="{{ $destination['url'] }}" class="beach-destination-card__cta">
                                                View {{ $destination['name'] }} <i class="bi bi-arrow-right" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </article>
                                </div>
                            @endforeach
                        </div>
                        <div class="beach-destination-swiper__controls">
                            <button type="button" class="beach-destination-swiper__btn beach-destination-swiper__btn--prev" aria-label="Previous beach destination">
                                <i class="bi bi-arrow-left"></i>
                            </button>
                            <div class="beach-destination-swiper__pagination"></div>
                            <button type="button" class="beach-destination-swiper__btn beach-destination-swiper__btn--next" aria-label="Next beach destination">
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <section class="beach-featured" id="beach-packages" aria-label="Popular beach theme packages">
            <div class="container">
                <div class="beach-section-head beach-section-head--split">
                    <div>
                        <span class="beach-eyebrow beach-eyebrow--dark">Popular beach theme packages</span>
                        <h2>Popular beach packages in a slider</h2>
                        <p>Only popular beach packages selected in admin appear here, arranged in a scrollable card slider.</p>
                    </div>
                </div>

                @if($beachPackages->isEmpty())
                    <div class="beach-empty">
                        <h3>No popular beach packages yet</h3>
                        <p>Upload packages in the admin panel, set the theme to Beach, and mark the category as Popular to populate this slider.</p>
                    </div>
                @else
                    <div class="swiper beach-package-swiper" data-beach-package-swiper>
                        <div class="swiper-wrapper">
                            @foreach($beachPackages as $package)
                                @php
                                    $packageImage = $package->image ? asset('storage/' . $package->image) : asset('images/couple-bg.jpg');
                                    $packageDuration = $package->duration_text ?: (($package->days ?? null) ? $package->days . ' Days' : 'Flexible duration');
                                @endphp
                                <div class="swiper-slide">
                                    <article class="beach-package-card">
                                        <a href="{{ route('packages.show', $package->slug) }}" class="beach-package-card__media">
                                            <img src="{{ $packageImage }}" alt="{{ $package->title }}" loading="lazy">
                                            <span class="beach-package-card__tag">{{ $package->theme ?: 'Beach' }}</span>
                                        </a>
                                        <div class="beach-package-card__body">
                                            <div class="beach-package-card__rating">
                                                <i class="bi bi-star-fill" aria-hidden="true"></i>
                                                <span>{{ $package->rating ? number_format((float) $package->rating, 1) : 'New' }}</span>
                                            </div>
                                            <h3>{{ $package->title }}</h3>
                                            <p>{{ $package->feature_1 ?: 'Premium beach holiday with comfortable stays and a relaxed pace.' }}</p>
                                            <div class="beach-package-card__meta">
                                                <span><i class="bi bi-calendar3"></i> {{ $packageDuration }}</span>
                                                <span><i class="bi bi-geo-alt-fill"></i> {{ $package->city ?: $package->state ?: $package->country ?: 'India' }}</span>
                                            </div>
                                            <div class="beach-package-card__footer">
                                                <strong>₹{{ number_format((int) $package->price) }}</strong>
                                                <a href="{{ route('packages.show', $package->slug) }}">View details</a>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            @endforeach
                        </div>
                        <div class="beach-package-swiper__controls">
                            <button type="button" class="beach-package-swiper__btn beach-package-swiper__btn--prev" aria-label="Previous beach package">
                                <i class="bi bi-arrow-left"></i>
                            </button>
                            <div class="beach-package-swiper__pagination"></div>
                            <button type="button" class="beach-package-swiper__btn beach-package-swiper__btn--next" aria-label="Next beach package">
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <section class="beach-benefits" aria-label="Why choose beach holidays">
            <div class="container">
                <div class="beach-section-head">
                    <span class="beach-eyebrow beach-eyebrow--dark">Why choose beach holidays</span>
                    <h2>Built for easy booking and better conversions</h2>
                    <p>These benefits help visitors feel confident about booking a coastal trip with you.</p>
                </div>

                <div class="beach-benefits-grid">
                    @foreach($whyChoose as $item)
                        <article class="beach-benefit-card">
                            <span><i class="{{ $item['icon'] }}" aria-hidden="true"></i></span>
                            <h3>{{ $item['title'] }}</h3>
                            <p>{{ $item['text'] }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="beach-testimonials" aria-label="Customer testimonials">
            <div class="container">
                <div class="beach-section-head">
                    <span class="beach-eyebrow beach-eyebrow--dark">Customer testimonials</span>
                    <h2>Travelers love the beach booking experience</h2>
                    <p>Social proof that supports trust, comfort, and booking confidence.</p>
                </div>

                <div class="beach-testimonial-grid">
                    @foreach($testimonials as $testimonial)
                        <blockquote class="beach-testimonial-card">
                            <div class="beach-testimonial-card__stars" aria-hidden="true">
                                @for($i = 0; $i < $testimonial['rating']; $i++)
                                    <i class="bi bi-star-fill"></i>
                                @endfor
                            </div>
                            <p>{{ $testimonial['text'] }}</p>
                            <footer>{{ $testimonial['name'] }}</footer>
                        </blockquote>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="beach-tips" aria-label="Travel tips">
            <div class="container">
                <div class="beach-section-head">
                    <span class="beach-eyebrow beach-eyebrow--dark">Travel tips</span>
                    <h2>Simple advice for better beach vacations</h2>
                    <p>Use these practical tips to help customers choose the right trip and travel season.</p>
                </div>

                <div class="beach-tips-grid">
                    @foreach($travelTips as $tip)
                        <article class="beach-tip-card">
                            <span class="beach-tip-card__index">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            <h3>{{ $tip['title'] }}</h3>
                            <p>{{ $tip['text'] }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="beach-faq" aria-label="Frequently asked questions">
            <div class="container">
                <div class="beach-section-head">
                    <span class="beach-eyebrow beach-eyebrow--dark">FAQs</span>
                    <h2>Quick answers before you book</h2>
                    <p>Clear, search-friendly answers that help travelers move toward the booking step.</p>
                </div>

                <div class="beach-faq-list">
                    @foreach($faqs as $faq)
                        <details class="beach-faq-item" {{ $loop->first ? 'open' : '' }}>
                            <summary>{{ $faq['question'] }}</summary>
                            <p>{{ $faq['answer'] }}</p>
                        </details>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="beach-cta" aria-label="Final call to action">
            <div class="beach-cta__overlay"></div>
            <div class="container beach-cta__inner">
                <div class="beach-cta__copy">
                    <span>Coastal planning made easy</span>
                    <h2>Plan Your Perfect Beach Getaway Today</h2>
                    <p>Tell us your dates, budget, and travel style. We’ll match you with the best beach package for Goa, Andaman, Gokarna, Pondicherry, Kovalam, or Lakshadweep.</p>
                    <div class="beach-cta__actions">
                        <a href="{{ route('contact') }}" class="beach-btn beach-btn--primary">
                            Enquire Now <i class="bi bi-arrow-right" aria-hidden="true"></i>
                        </a>
                        <a href="{{ route('packages.index') }}" class="beach-btn beach-btn--ghost">
                            Browse All Packages
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const beachFilterForm = document.querySelector('[data-beach-destination-filter-form]');
            const packageSwiperElement = document.querySelector('[data-beach-package-swiper]');
            const destinationSwiperElement = document.querySelector('[data-beach-destination-swiper]');
            let filterTimer = null;

            function submitBeachFilters() {
                if (!beachFilterForm) {
                    return;
                }

                window.clearTimeout(filterTimer);
                filterTimer = window.setTimeout(function () {
                    if (beachFilterForm.requestSubmit) {
                        beachFilterForm.requestSubmit();
                        return;
                    }

                    beachFilterForm.submit();
                }, 80);
            }

            function initBeachRange(range) {
                if (!range || range.dataset.beachRangeReady === '1') {
                    return;
                }

                range.dataset.beachRangeReady = '1';

                const minInput = range.querySelector('[data-beach-range-min]');
                const maxInput = range.querySelector('[data-beach-range-max]');
                const progress = range.querySelector('[data-beach-range-progress]');
                const minLabel = document.querySelector('[data-beach-price-min-label]');
                const maxLabel = document.querySelector('[data-beach-price-max-label]');
                const boundMin = Number(range.dataset.min || 0);
                const boundMax = Number(range.dataset.max || boundMin);

                if (!minInput || !maxInput || !progress) {
                    return;
                }

                const formatMoney = value => new Intl.NumberFormat('en-IN', {
                    style: 'currency',
                    currency: 'INR',
                    maximumFractionDigits: 0,
                }).format(Number(value || 0));

                const valueOf = input => Number(input.value || 0);

                const syncProgress = () => {
                    const minValue = valueOf(minInput);
                    const maxValue = valueOf(maxInput);
                    const span = Math.max(1, boundMax - boundMin);
                    const left = ((minValue - boundMin) / span) * 100;
                    const right = 100 - (((maxValue - boundMin) / span) * 100);

                    progress.style.left = `${Math.max(0, Math.min(left, 100))}%`;
                    progress.style.right = `${Math.max(0, Math.min(right, 100))}%`;

                    if (minLabel) {
                        minLabel.textContent = formatMoney(minValue);
                    }

                    if (maxLabel) {
                        maxLabel.textContent = formatMoney(maxValue);
                    }
                };

                minInput.addEventListener('input', function () {
                    if (valueOf(minInput) > valueOf(maxInput)) {
                        maxInput.value = minInput.value;
                    }

                    syncProgress();
                });

                maxInput.addEventListener('input', function () {
                    if (valueOf(maxInput) < valueOf(minInput)) {
                        minInput.value = maxInput.value;
                    }

                    syncProgress();
                });

                minInput.addEventListener('change', submitBeachFilters);
                maxInput.addEventListener('change', submitBeachFilters);

                syncProgress();
            }

            if (beachFilterForm) {
                beachFilterForm.querySelectorAll('[data-beach-auto-submit]').forEach(function (control) {
                    control.addEventListener('change', submitBeachFilters);
                });

                const range = beachFilterForm.querySelector('[data-beach-range]');
                initBeachRange(range);
            }

            if (typeof Swiper !== 'undefined') {
                if (destinationSwiperElement) {
                    new Swiper(destinationSwiperElement, {
                        slidesPerView: 1.08,
                        spaceBetween: 18,
                        speed: 600,
                        navigation: {
                            nextEl: '.beach-destination-swiper__btn--next',
                            prevEl: '.beach-destination-swiper__btn--prev',
                        },
                        pagination: {
                            el: '.beach-destination-swiper__pagination',
                            clickable: true,
                        },
                        breakpoints: {
                            576: {
                                slidesPerView: 1.4,
                            },
                            768: {
                                slidesPerView: 2,
                            },
                            1200: {
                                slidesPerView: 3,
                            },
                        },
                    });
                }

                if (packageSwiperElement) {
                    new Swiper(packageSwiperElement, {
                        slidesPerView: 1.08,
                        spaceBetween: 18,
                        speed: 600,
                        navigation: {
                            nextEl: '.beach-package-swiper__btn--next',
                            prevEl: '.beach-package-swiper__btn--prev',
                        },
                        pagination: {
                            el: '.beach-package-swiper__pagination',
                            clickable: true,
                        },
                        breakpoints: {
                            576: {
                                slidesPerView: 1.5,
                            },
                            768: {
                                slidesPerView: 2,
                            },
                            1200: {
                                slidesPerView: 3,
                            },
                        },
                    });
                }
            }
        });
    </script>
@endpush

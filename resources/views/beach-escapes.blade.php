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
    <div class="beach-page beach-page--beach">
        <section class="beach-hero" aria-label="Beach Escapes Hero"
            style="--beach-hero-image: url('{{ asset('images/kerala.avif') }}');">
            <div class="beach-hero__overlay"></div>
            <div class="container beach-shell">
                <div class="beach-hero__grid">
                    <div class="beach-hero__copy">
                        <span class="beach-eyebrow"><i class="bi bi-sunrise-fill" aria-hidden="true"></i> Coastal escapes
                            across India</span>
                        <h1 class="beach_hero_heading">Beach Escapes</h1>
                        
                        <p class="beach-hero__description">
                            From Goa's lively shores to the calm waters of Andaman and Lakshadweep, this page brings
                            together beach-ready itineraries and premium packages designed to increase bookings.
                        </p>

                        <div class="beach-hero__actions">
                            <a href="#beach-destinations" class="beach-btn beach-btn--primary">
                                Explore Packages
                            </a>
                            <a href="#beach-packages" class="beach-btn beach-btn--ghost">
                                View Popular Packages
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="beach-destinations" id="beach-destinations" aria-label="Beach destinations">
            <div class="container">
                <div class="beach-section-head beach-section-head--split">
                    <div>
                        <span class="beach-eyebrow beach-eyebrow--dark">Beach theme destinations</span>
                        <h2>Filter beach destinations</h2>
                        <p>Use destination, budget, duration, and travel style to narrow the beach destination grid.</p>
                    </div>
                </div>

                <div class="beach-destination-layout">
                    <aside class="beach-destination-sidebar" aria-label="Beach destination filters">
                        <form method="GET" action="{{ route('beach-escapes') }}" class="df-sidebar-inner beach-destination-filter-panel"
                            data-beach-destination-filter-form>
                            <div class="df-sidebar-head">
                                <div class="df-sidebar-head-icon">
                                    <i class="bi bi-compass"></i>
                                </div>
                                <div>
                                    <h2 class="df-sidebar-title">Find Your Perfect Journey</h2>
                                    <p class="df-sidebar-subtitle">Filter curated travel experiences based on your travel style.</p>
                                </div>
                            </div>

                            <div class="df-filter-group">
                                <label class="df-filter-label" for="beachDestination">
                                    <i class="bi bi-geo-alt"></i> Destination
                                </label>
                                <div class="df-select-wrap">
                                    <select class="df-select" id="beachDestination" name="destination" aria-label="Select destination"
                                        data-beach-auto-submit>
                                        <option value="">All Destinations</option>
                                        @foreach($destinationOptions as $destinationOption)
                                            <option value="{{ $destinationOption['value'] }}"
                                                {{ $selectedDestination === $destinationOption['value'] ? 'selected' : '' }}>
                                                {{ $destinationOption['label'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <i class="bi bi-chevron-down df-select-chevron"></i>
                                </div>
                            </div>

                            <div class="df-filter-group">
                                <label class="df-filter-label">
                                    <i class="bi bi-currency-rupee"></i> Budget
                                </label>
                                <div class="df-budget-options" role="radiogroup" aria-label="Budget range">
                                    @foreach($budgetOptions as $budgetOption)
                                        <label class="df-budget-radio">
                                            <input type="radio" name="budget" value="{{ $budgetOption['value'] }}"
                                                {{ $selectedBudget === $budgetOption['value'] ? 'checked' : '' }}
                                                data-beach-auto-submit>
                                            <span class="df-budget-radio-label">{{ $budgetOption['label'] }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="df-filter-group">
                                <label class="df-filter-label">
                                    <i class="bi bi-clock"></i> Duration
                                </label>
                                <div class="df-chip-group" id="beachDurationGroup" role="group" aria-label="Duration">
                                    <label class="df-chip">
                                        <input type="radio" name="duration" value="weekend" {{ $selectedDuration === 'weekend' ? 'checked' : '' }} data-beach-auto-submit>
                                        <span>Weekend</span>
                                    </label>
                                    <label class="df-chip">
                                        <input type="radio" name="duration" value="3-5" {{ $selectedDuration === '3-5' ? 'checked' : '' }} data-beach-auto-submit>
                                        <span>3–5 Days</span>
                                    </label>
                                    <label class="df-chip">
                                        <input type="radio" name="duration" value="5-7" {{ $selectedDuration === '5-7' ? 'checked' : '' }} data-beach-auto-submit>
                                        <span>5–7 Days</span>
                                    </label>
                                    <label class="df-chip">
                                        <input type="radio" name="duration" value="7+" {{ $selectedDuration === '7+' ? 'checked' : '' }} data-beach-auto-submit>
                                        <span>7+ Days</span>
                                    </label>
                                </div>
                            </div>

                            <div class="df-filter-group">
                                <label class="df-filter-label">
                                    <i class="bi bi-heart"></i> Travel Style
                                </label>
                                <div class="df-chip-group df-chip-group--wrap" id="beachStyleGroup" role="group"
                                    aria-label="Travel style">
                                    @forelse($beachTravelStyleOptions as $travelStyle)
                                        <label class="df-chip">
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

                            <div class="df-sidebar-actions">
                                <button class="df-btn-clear" id="beachClearFilters" type="button" aria-label="Clear all filters">
                                    <i class="bi bi-x-circle"></i> Clear Filters
                                </button>
                                <button class="df-btn-search" id="beachExploreBtn" type="submit">
                                    <i class="bi bi-search"></i> Apply Filters
                                </button>
                            </div>
                        </form>
                    </aside>

                    <div class="beach-destination-results" data-beach-destination-results>
                        @include('partials.beach-destination-results')
                    </div>
                </div>
            </div>
        </section>

        <section class="beach-banner-slider" aria-label="Featured beach banner">
            <div class="container">
                <div class="beach-banner-frame">
                    <div class="swiper beach-banner-swiper" data-beach-banner-swiper>
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <article class="beach-banner-slide"
                                    style="--beach-banner-image: url('{{ asset('images/kerala.avif') }}');">
                                    <div class="beach-banner-slide__overlay"></div>
                                    <div class="beach-banner-slide__content">
                                        <span class="beach-banner-slide__eyebrow">
                                            <i class="bi bi-sunrise-fill" aria-hidden="true"></i> Coastal spotlight
                                        </span>
                                        <h2>Beach breaks with a premium holiday feel</h2>
                                        <p>Use this space to highlight your strongest beach offer before visitors move into the package slider.</p>
                                    </div>
                                </article>
                            </div>
                            <div class="swiper-slide">
                                <article class="beach-banner-slide"
                                    style="--beach-banner-image: url('{{ asset('images/contact-us-bg.jpg') }}');">
                                    <div class="beach-banner-slide__overlay"></div>
                                    <div class="beach-banner-slide__content">
                                        <span class="beach-banner-slide__eyebrow">
                                            <i class="bi bi-geo-alt-fill" aria-hidden="true"></i> Island favorite
                                        </span>
                                        <h2>Go from planning to sea breeze in one click</h2>
                                        <p>Feature Andaman, Lakshadweep, or Goa in a large visual banner that breaks up the page and keeps momentum high.</p>
                                    </div>
                                </article>
                            </div>
                            <div class="swiper-slide">
                                <article class="beach-banner-slide"
                                    style="--beach-banner-image: url('{{ asset('images/world-map.avif') }}');">
                                    <div class="beach-banner-slide__overlay"></div>
                                    <div class="beach-banner-slide__content">
                                        <span class="beach-banner-slide__eyebrow">
                                            <i class="bi bi-stars" aria-hidden="true"></i> Curated highlights
                                        </span>
                                        <h2>Use a bold transition section to keep the page moving</h2>
                                        <p>This banner works as a visual bridge between your filter results and the package cards below.</p>
                                    </div>
                                </article>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="beach-banner-swiper__btn beach-banner-swiper__btn--prev" aria-label="Previous beach banner">
                        <i class="bi bi-arrow-left"></i>
                    </button>
                    <button type="button" class="beach-banner-swiper__btn beach-banner-swiper__btn--next" aria-label="Next beach banner">
                        <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
                <div class="beach-banner-swiper__pagination"></div>
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
                    <div class="beach-package-frame">
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
                            <div class="beach-package-swiper__pagination"></div>
                        </div>
                        <div class="beach-package-swiper__controls">
                            <button type="button" class="beach-package-swiper__btn beach-package-swiper__btn--prev" aria-label="Previous beach package">
                                <i class="bi bi-arrow-left"></i>
                            </button>
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

        <section id="faq" class="beach-faq" aria-label="Frequently asked questions">
            <div class="container">
                <div class="beach-faq-shell">
                    <div class="beach-faq-copy">
                        <h2>General Questions asked by customers.</h2>
                        <div class="beach-faq-support">
                            <p>Our friendly team is always here to help you with quick, clear, and reliable answers whenever needed.</p>
                            <a href="{{ route('contact') }}" class="beach-faq-cta">Contact Sales</a>
                        </div>
                    </div>

                    <div class="beach-faq-list">
                        @foreach($faqs as $faq)
                            <details class="beach-faq-item">
                                <summary>
                                    <span>{{ $faq['question'] }}</span>
                                    <span class="beach-faq-icon" aria-hidden="true"></span>
                                </summary>
                                <div class="beach-faq-answer">
                                    <p>{{ $faq['answer'] }}</p>
                                </div>
                            </details>
                        @endforeach
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
            const bannerSwiperElement = document.querySelector('[data-beach-banner-swiper]');
            const packageSwiperElement = document.querySelector('[data-beach-package-swiper]');
            const beachResultsElement = document.querySelector('[data-beach-destination-results]');
            const beachClearButton = document.getElementById('beachClearFilters');
            let filterTimer = null;

            async function submitBeachFilters() {
                if (!beachFilterForm) {
                    return;
                }

                window.clearTimeout(filterTimer);
                filterTimer = window.setTimeout(async function () {
                    const requestUrl = new URL(beachFilterForm.action, window.location.origin);
                    const formData = new FormData(beachFilterForm);

                    formData.forEach((value, key) => {
                        if (value === '') {
                            return;
                        }

                        requestUrl.searchParams.append(key, value);
                    });

                    try {
                        const response = await fetch(requestUrl.toString(), {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-Beach-Ajax': '1',
                                'Accept': 'application/json',
                            },
                            credentials: 'same-origin',
                        });

                        if (!response.ok) {
                            window.location.href = requestUrl.toString();
                            return;
                        }

                        const payload = await response.json();

                        if (beachResultsElement && typeof payload.html === 'string') {
                            beachResultsElement.innerHTML = payload.html;
                        }

                        window.history.replaceState({}, '', requestUrl.toString());
                    } catch (error) {
                        window.location.href = requestUrl.toString();
                    }
                }, 80);
            }

            if (beachFilterForm) {
                beachFilterForm.querySelectorAll('[data-beach-auto-submit]').forEach(function (control) {
                    control.addEventListener('change', submitBeachFilters);
                });

                beachFilterForm.addEventListener('submit', function (event) {
                    event.preventDefault();
                    submitBeachFilters();
                });
            }

            if (beachClearButton && beachFilterForm) {
                beachClearButton.addEventListener('click', function () {
                    beachFilterForm.reset();
                    submitBeachFilters();
                });
            }

            if (typeof Swiper !== 'undefined') {
                if (bannerSwiperElement) {
                    new Swiper(bannerSwiperElement, {
                        slidesPerView: 1,
                        spaceBetween: 18,
                        speed: 700,
                        loop: true,
                        autoplay: {
                            delay: 5500,
                            disableOnInteraction: false,
                        },
                        navigation: {
                            nextEl: '.beach-banner-swiper__btn--next',
                            prevEl: '.beach-banner-swiper__btn--prev',
                        },
                        pagination: {
                            el: '.beach-banner-swiper__pagination',
                            clickable: true,
                        },
                    });
                }

                if (packageSwiperElement) {
                    new Swiper(packageSwiperElement, {
                        slidesPerView: 1.08,
                        spaceBetween: 18,
                        speed: 600,
                        loop: true,
                        autoplay: {
                            delay: 4500,
                            disableOnInteraction: false,
                            pauseOnMouseEnter: true,
                        },
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

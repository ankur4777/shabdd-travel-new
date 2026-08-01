@extends('layouts.app')

@section('meta')
    <title>{{ $page_title ?? ($themeName ?? 'Travel Theme') }}</title>
    <meta name="description" content="{{ $meta_description ?? '' }}">
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/beach-escapes.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
@endpush

@php
    $heroImage = asset($hero['image'] ?? 'images/himachal.jpg');
    $ctaImage = asset($hero['image'] ?? 'images/himachal.jpg');
    $palette = $palette ?? [];
    $durationFilterIcons = [
        'weekend' => 'bi bi-calendar-week',
        '3-5' => 'bi bi-calendar3',
        '5-7' => 'bi bi-calendar-range',
        '7+' => 'bi bi-calendar2-plus',
    ];
    $travelStyleFilterIcons = [
        'honeymoon' => 'bi bi-heart',
        'adventure' => 'bi bi-compass',
        'family' => 'bi bi-people',
        'solo' => 'bi bi-backpack',
        'friends' => 'bi bi-stars',
        'luxury' => 'bi bi-gem',
        'corporate-tour' => 'bi bi-buildings',
        'nature' => 'bi bi-tree',
        'wildlife' => 'bi bi-binoculars',
        'water-activities' => 'bi bi-water',
        'religious' => 'bi bi-bank',
    ];
@endphp

@section('content')
    <div class="beach-page beach-page--{{ $themeKey }}"
        style="--beach-ink: {{ $palette['ink'] ?? '#082f49' }};
            --beach-muted: {{ $palette['muted'] ?? 'rgba(8, 47, 73, 0.72)' }};
            --beach-sand: {{ $palette['sand'] ?? '#f4ebd0' }};
            --beach-mint: {{ $palette['mint'] ?? '#bff5e8' }};
            --beach-aqua: {{ $palette['aqua'] ?? '#12b8c7' }};
            --beach-coral: {{ $palette['coral'] ?? '#ff7b66' }};
            --beach-border: {{ $palette['border'] ?? 'rgba(8, 47, 73, 0.12)' }};
            --beach-hero-image: url('{{ $heroImage }}');">
        <section class="beach-hero" aria-label="{{ $hero['title'] ?? $themeName ?? 'Travel Theme' }} Hero">
            <div class="beach-hero__overlay"></div>
            <div class="container beach-shell">
                <div class="beach-hero__grid">
                    <div class="beach-hero__copy">
                        <span class="beach-eyebrow">
                            <i class="{{ $hero['icon'] ?? 'bi bi-compass' }}" aria-hidden="true"></i>
                            {{ $hero['eyebrow'] ?? 'Travel theme' }}
                        </span>
                        <h1 class="beach_hero_heading">{{ $hero['title'] ?? $themeName ?? 'Travel Theme' }}</h1>

                        <p class="beach-hero__description">
                            {{ $hero['description'] ?? '' }}
                        </p>

                        <div class="beach-hero__actions">
                            <a href="#travel-destinations" class="beach-btn beach-btn--primary">
                                {{ $hero['primary_action'] ?? 'Explore Destinations' }}
                                <i class="bi bi-arrow-right" aria-hidden="true"></i>
                            </a>
                            <a href="#travel-packages" class="beach-btn beach-btn--ghost">
                                {{ $hero['secondary_action'] ?? 'View Packages' }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="beach-destinations" id="travel-destinations" aria-label="{{ $destination_section['title'] ?? 'Destinations' }}">
            <div class="container">
                <div class="beach-section-head beach-section-head--split">
                    <div>
                        <span class="beach-eyebrow beach-eyebrow--dark">{{ $destination_section['eyebrow'] ?? 'Destinations' }}</span>
                        <h2>{{ $destination_section['title'] ?? 'Filter destinations' }}</h2>
                        <p>{{ $destination_section['description'] ?? '' }}</p>
                    </div>
                </div>

                <div class="beach-destination-layout">
                    <aside class="beach-destination-sidebar" aria-label="{{ $destination_section['title'] ?? 'Destination filters' }}">
                        <form method="GET" action="{{ $listingRoute }}" class="df-sidebar-inner beach-destination-filter-panel"
                            data-theme-destination-filter-form>
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
                                <label class="df-filter-label" for="themeDestination">
                                    <i class="bi bi-geo-alt"></i> Destination
                                </label>
                                <div class="df-select-wrap">
                                    <select class="df-select" id="themeDestination" name="destination" aria-label="Select destination"
                                        data-theme-auto-submit>
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
                                                data-theme-auto-submit>
                                            <span class="df-budget-radio-label">{{ $budgetOption['label'] }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="df-filter-group">
                                <label class="df-filter-label">
                                    <i class="bi bi-clock"></i> Duration
                                </label>
                                <div class="df-chip-group" id="themeDurationGroup" role="group" aria-label="Duration">
                                    <label class="df-chip">
                                        <input type="radio" name="duration" value="weekend" {{ $selectedDuration === 'weekend' ? 'checked' : '' }} data-theme-auto-submit>
                                        <span><i class="{{ $durationFilterIcons['weekend'] }} df-chip-option-icon df-chip-option-icon--duration-weekend" aria-hidden="true"></i> Weekend</span>
                                    </label>
                                    <label class="df-chip">
                                        <input type="radio" name="duration" value="3-5" {{ $selectedDuration === '3-5' ? 'checked' : '' }} data-theme-auto-submit>
                                        <span><i class="{{ $durationFilterIcons['3-5'] }} df-chip-option-icon df-chip-option-icon--duration-3-5" aria-hidden="true"></i> 3-5 Days</span>
                                    </label>
                                    <label class="df-chip">
                                        <input type="radio" name="duration" value="5-7" {{ $selectedDuration === '5-7' ? 'checked' : '' }} data-theme-auto-submit>
                                        <span><i class="{{ $durationFilterIcons['5-7'] }} df-chip-option-icon df-chip-option-icon--duration-5-7" aria-hidden="true"></i> 5-7 Days</span>
                                    </label>
                                    <label class="df-chip">
                                        <input type="radio" name="duration" value="7+" {{ $selectedDuration === '7+' ? 'checked' : '' }} data-theme-auto-submit>
                                        <span><i class="{{ $durationFilterIcons['7+'] }} df-chip-option-icon df-chip-option-icon--duration-7-plus" aria-hidden="true"></i> 7+ Days</span>
                                    </label>
                                </div>
                            </div>

                            <div class="df-filter-group">
                                <label class="df-filter-label">
                                    <i class="bi bi-heart"></i> Travel Style
                                </label>
                                <div class="df-chip-group df-chip-group--wrap" id="themeStyleGroup" role="group"
                                    aria-label="Travel style">
                                    @forelse($beachTravelStyleOptions as $travelStyle)
                                        <label class="df-chip">
                                            <input type="checkbox" name="travel_styles[]" value="{{ $travelStyle }}"
                                                {{ in_array($travelStyle, $selectedTravelStyles, true) ? 'checked' : '' }}
                                                data-theme-auto-submit>
                                            @php
                                                $travelStyleSlug = \Illuminate\Support\Str::slug($travelStyle);
                                                $travelStyleIcon = $travelStyleFilterIcons[$travelStyleSlug] ?? 'bi bi-stars';
                                            @endphp
                                            <span><i class="{{ $travelStyleIcon }} df-chip-option-icon df-chip-option-icon--style-{{ $travelStyleSlug }}" aria-hidden="true"></i> {{ $travelStyle }}</span>
                                        </label>
                                    @empty
                                        <div class="beach-filter-note">No travel styles found yet.</div>
                                    @endforelse
                                </div>
                            </div>

                            <div class="df-filter-group">
                                <label class="df-filter-label">
                                    <i class="bi bi-sun"></i> Season
                                </label>
                                <div class="df-chip-group df-chip-group--wrap" id="themeSeasonGroup" role="group"
                                    aria-label="Season">
                                    @foreach(($seasonOptions ?? []) as $seasonOption)
                                        <label class="df-chip">
                                            <input type="checkbox" name="seasons[]" value="{{ $seasonOption['value'] }}"
                                                {{ in_array($seasonOption['value'], $selectedSeasons ?? [], true) ? 'checked' : '' }}
                                                data-theme-auto-submit>
                                            <span><i class="{{ $seasonOption['icon'] }} df-chip-option-icon df-chip-option-icon--season-{{ $seasonOption['value'] }}" aria-hidden="true"></i> {{ $seasonOption['label'] }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="df-sidebar-actions">
                                <button class="df-btn-clear" id="themeClearFilters" type="button" aria-label="Clear all filters">
                                    <i class="bi bi-x-circle"></i> Clear Filters
                                </button>
                                <button class="df-btn-search" id="themeExploreBtn" type="submit">
                                    <i class="bi bi-search"></i> Apply Filters
                                </button>
                            </div>
                        </form>
                    </aside>

                    <div class="beach-destination-results" data-theme-destination-re Is upside UV hub four US.sults>
                        @include('partials.travel-theme-destination-results')
                    </div>
                </div>
            </div>
        </section>

        <section class="beach-banner-slider" aria-label="{{ $themeName ?? 'Travel theme' }} highlights">
            <div class="container">
                <div class="beach-banner-frame">
                    <div class="swiper beach-banner-swiper" data-theme-banner-swiper>
                        <div class="swiper-wrapper">
                            @foreach($banner_slides ?? [] as $slide)
                                <div class="swiper-slide">
                                    <article class="beach-banner-slide"
                                        style="--beach-banner-image: url('{{ asset($slide['image'] ?? $hero['image'] ?? 'images/himachal.jpg') }}');">
                                        <div class="beach-banner-slide__overlay"></div>
                                        <div class="beach-banner-slide__content">
                                            <span class="beach-banner-slide__eyebrow">
                                                <i class="{{ $slide['icon'] ?? 'bi bi-stars' }}" aria-hidden="true"></i>
                                                {{ $slide['eyebrow'] ?? 'Theme spotlight' }}
                                            </span>
                                            <h2>{{ $slide['title'] ?? 'Curated travel highlight' }}</h2>
                                            <p>{{ $slide['description'] ?? '' }}</p>
                                        </div>
                                    </article>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <button type="button" class="beach-banner-swiper__btn beach-banner-swiper__btn--prev" aria-label="Previous highlight">
                        <i class="bi bi-arrow-left"></i>
                    </button>
                    <button type="button" class="beach-banner-swiper__btn beach-banner-swiper__btn--next" aria-label="Next highlight">
                        <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
                <div class="beach-banner-swiper__pagination"></div>
            </div>
        </section>

        <section class="beach-featured" id="travel-packages" aria-label="{{ $package_section['title'] ?? 'Featured packages' }}">
            <div class="container">
                <div class="beach-section-head beach-section-head--split">
                    <div>
                        <span class="beach-eyebrow beach-eyebrow--dark">{{ $package_section['eyebrow'] ?? 'Featured packages' }}</span>
                        <h2>{{ $package_section['title'] ?? 'Featured packages' }}</h2>
                        <p>{{ $package_section['description'] ?? '' }}</p>
                    </div>
                </div>

                @if($beachPackages->isEmpty())
                    <div class="beach-empty">
                        <h3>{{ $package_section['empty_title'] ?? 'No packages yet' }}</h3>
                        <p>{{ $package_section['empty_description'] ?? 'Add packages in the admin panel to populate this slider.' }}</p>
                    </div>
                @else
                    <div class="beach-package-frame">
                        <div class="swiper beach-package-swiper" data-theme-package-swiper>
                            <div class="swiper-wrapper">
                                @foreach($beachPackages as $package)
                                    @php
                                        $packageImage = $package['image'] ?? asset('images/couple-bg.jpg');
                                        $packageDuration = $package['duration'] ?? 'Flexible duration';
                                        $packageUrl = $package['url'] ?? $listingRoute;
                                    @endphp
                                    <div class="swiper-slide">
                                        <article class="beach-package-card">
                                            <a href="{{ $packageUrl }}" class="beach-package-card__media">
                                                <img src="{{ $packageImage }}" alt="{{ $package['title'] }}" loading="lazy">
                                              
                                            </a>
                                            <div class="beach-package-card__body">
                                                <div class="beach-package-card__rating">
                                                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                                                    <span>{{ $package['rating'] ? number_format((float) $package['rating'], 1) : 'New' }}</span>
                                                </div>
                                                <h3>{{ $package['title'] }}</h3>
                                                <p>{{ $package['description'] ?? 'Premium travel experience with curated stays and smooth transfers.' }}</p>
                                                <div class="beach-package-card__meta">
                                                    <span><i class="bi bi-calendar3"></i> {{ $packageDuration }}</span>
                                                    <span><i class="bi bi-geo-alt-fill"></i> {{ $package['location'] ?? $package['country'] ?? 'India' }}</span>
                                                </div>
                                                <div class="beach-package-card__footer">
                                                    <strong class="price"><span>₹{{ number_format((int) ($package['price'] ?? 0)) }}</span></strong>
                                                    <a href="{{ $packageUrl }}">View details</a>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                @endforeach
                            </div>
                            <div class="beach-package-swiper__pagination"></div>
                        </div>
                        <div class="beach-package-swiper__controls">
                            <button type="button" class="beach-package-swiper__btn beach-package-swiper__btn--prev" aria-label="Previous package">
                                <i class="bi bi-arrow-left"></i>
                            </button>
                            <button type="button" class="beach-package-swiper__btn beach-package-swiper__btn--next" aria-label="Next package">
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <section class="beach-benefits" aria-label="{{ $benefits_section['title'] ?? 'Why choose this theme' }}">
            <div class="container">
                <div class="beach-section-head">
                    <span class="beach-eyebrow beach-eyebrow--dark">{{ $benefits_section['eyebrow'] ?? 'Why choose this theme' }}</span>
                    <h2>{{ $benefits_section['title'] ?? 'Built for better travel planning' }}</h2>
                    <p>{{ $benefits_section['description'] ?? '' }}</p>
                </div>

                <div class="beach-benefits-grid">
                    @foreach($why_choose ?? [] as $item)
                        <article class="beach-benefit-card">
                            <span><i class="{{ $item['icon'] }}" aria-hidden="true"></i></span>
                            <h3>{{ $item['title'] }}</h3>
                            <p>{{ $item['text'] }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="beach-testimonials" aria-label="{{ $testimonial_section['title'] ?? 'Customer testimonials' }}">
            <div class="container">
                <div class="beach-section-head">
                    <span class="beach-eyebrow beach-eyebrow--dark">{{ $testimonial_section['eyebrow'] ?? 'Customer testimonials' }}</span>
                    <h2>{{ $testimonial_section['title'] ?? 'Travelers love this experience' }}</h2>
                    <p>{{ $testimonial_section['description'] ?? '' }}</p>
                </div>

                <div class="beach-testimonial-grid">
                    @foreach($testimonials ?? [] as $testimonial)
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
            <div class="beach-cta__overlay" style="background: linear-gradient(135deg, rgba(8, 47, 73, 0.74), rgba(8, 47, 73, 0.42)), url('{{ $ctaImage }}') center/cover no-repeat;"></div>
            <div class="container beach-cta__inner">
                <div class="beach-cta__copy">
                    <span>{{ $cta['kicker'] ?? 'Travel planning made easy' }}</span>
                    <h2>{{ $cta['title'] ?? 'Plan your next getaway today' }}</h2>
                    <p>{{ $cta['description'] ?? '' }}</p>
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

        <section id="faq" class="beach-faq" aria-label="General questions asked by customers">
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
                        @foreach($faqs ?? [] as $faq)
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
            const themeFilterForm = document.querySelector('[data-theme-destination-filter-form]');
            const bannerSwiperElement = document.querySelector('[data-theme-banner-swiper]');
            const packageSwiperElement = document.querySelector('[data-theme-package-swiper]');
            const themeResultsElement = document.querySelector('[data-theme-destination-results]');
            const themeClearButton = document.getElementById('themeClearFilters');
            let filterTimer = null;

            async function submitThemeFilters() {
                if (!themeFilterForm) {
                    return;
                }

                window.clearTimeout(filterTimer);
                filterTimer = window.setTimeout(async function () {
                    const requestUrl = new URL(themeFilterForm.action, window.location.origin);
                    const formData = new FormData(themeFilterForm);

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

                        if (themeResultsElement && typeof payload.html === 'string') {
                            themeResultsElement.innerHTML = payload.html;
                        }

                        window.history.replaceState({}, '', requestUrl.toString());
                    } catch (error) {
                        window.location.href = requestUrl.toString();
                    }
                }, 80);
            }

            if (themeFilterForm) {
                themeFilterForm.querySelectorAll('[data-theme-auto-submit]').forEach(function (control) {
                    control.addEventListener('change', submitThemeFilters);
                });

                themeFilterForm.addEventListener('submit', function (event) {
                    event.preventDefault();
                    submitThemeFilters();
                });
            }

            if (themeClearButton && themeFilterForm) {
                themeClearButton.addEventListener('click', function () {
                    themeFilterForm.reset();
                    submitThemeFilters();
                });
            }

            if (typeof Swiper !== 'undefined') {
                const isHillThemePage = document.querySelector('.beach-page--hill') !== null;

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
                        slidesPerView: isHillThemePage ? 'auto' : 1.08,
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
                                slidesPerView: isHillThemePage ? 'auto' : 1.5,
                            },
                            768: {
                                slidesPerView: isHillThemePage ? 'auto' : 2,
                            },
                            1200: {
                                slidesPerView: isHillThemePage ? 'auto' : 3,
                            },
                        },
                    });
                }
            }
        });
    </script>
@endpush

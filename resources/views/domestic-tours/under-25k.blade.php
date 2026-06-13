@extends('layouts.app')

@section('content')

    {{-- 1. Hero Section --}}
    <section class="destination-st-hero" data-hero-media="image"
        style="--hero-image: url('{{ asset('images/himachal.jpg') }}'); min-height: 55vh; padding-bottom: 0; margin-top: 0;">
        <div class="destination-st-hero-overlay"></div>
        <div class="destination-st-hero-inner container" style="min-height: 55vh; padding-top: 100px;">
            <div class="destination-st-hero-copy" style="text-align: center; margin: 0 auto;">
                <div class="destination-st-hero-eyebrow justify-content-center">
                    <span class="st-eyebrow-dot"></span> Budget Escapes
                </div>
                <h1 class="destination-st-hero-title">Domestic Tours Under <em>₹25K</em></h1>
                <p class="destination-st-hero-text">
                    Incredible journeys across India that fit perfectly within your budget. Handpicked experiences,
                    comfortable stays, and unforgettable memories — all without breaking the bank.
                </p>
            </div>
        </div>
    </section>

    {{-- 2. Relevant Content & Slider --}}
    {{-- Quick Filter Section --}}
    <section class="container mt-5">
        <div class="rd-container">
            <div class="row g-4">
                <div class="col-md-4">
                    <h4 class="mb-3" style="font-weight: 800; font-size: 1.1rem; color: #0f1115;">Budget Range</h4>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="#" class="df-chip text-decoration-none">₹10k–15k</a>
                        <a href="#" class="df-chip text-decoration-none">₹15k–20k</a>
                        <a href="#" class="df-chip text-decoration-none">₹20k–25k</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <h4 class="mb-3" style="font-weight: 800; font-size: 1.1rem; color: #0f1115;">Trip Type</h4>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="#" class="df-chip text-decoration-none">Family Tours</a>
                        <a href="#" class="df-chip text-decoration-none">Honeymoon Tours</a>
                        <a href="#" class="df-chip text-decoration-none">Adventure Trips</a>
                        <a href="#" class="df-chip text-decoration-none">Religious Tours</a>
                        <a href="#" class="df-chip text-decoration-none">Weekend Getaways</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <h4 class="mb-3" style="font-weight: 800; font-size: 1.1rem; color: #0f1115;">Duration</h4>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="#" class="df-chip text-decoration-none">2–3 Days</a>
                        <a href="#" class="df-chip text-decoration-none">4–5 Days</a>
                        <a href="#" class="df-chip text-decoration-none">6–7 Days</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Popular Destinations Under ₹25,000 --}}
    <section class="pd-section mt-5">
        <div class="pd-container">
            <div class="pd-header">
                <div>
                    <p class="pd-eyebrow">Top Spots</p>
                    <h2 class="pd-title">Popular Destinations Under ₹25,000</h2>
                </div>
            </div>
            <div class="row g-4">
                @php
                    $destinations = [
                        ['name' => 'Goa', 'price' => '12,000', 'count' => '45', 'img' => 'goa.jpg'],
                        ['name' => 'Jaipur', 'price' => '10,500', 'count' => '32', 'img' => 'jaipur.jpg'],
                        ['name' => 'Udaipur', 'price' => '14,000', 'count' => '28', 'img' => 'udaipur.jpg'],
                        ['name' => 'Manali', 'price' => '11,500', 'count' => '50', 'img' => 'manali.jpg'],
                        ['name' => 'Shimla', 'price' => '13,000', 'count' => '40', 'img' => 'shimla.jpg'],
                        ['name' => 'Rishikesh', 'price' => '8,500', 'count' => '25', 'img' => 'rishikesh.jpg'],
                        ['name' => 'Varanasi', 'price' => '9,000', 'count' => '18', 'img' => 'varanasi.jpg'],
                        ['name' => 'Kerala', 'price' => '16,000', 'count' => '60', 'img' => 'kerala.avif'],
                    ];
                @endphp
                @foreach($destinations as $dest)
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <a href="#" class="pd-card text-decoration-none h-100">
                            <div class="pd-card-img-wrap">
                                <img src="{{ asset('images/' . $dest['img']) }}" alt="{{ $dest['name'] }}" class="pd-card-img"
                                    onerror="this.src='{{ asset('images/couple-bg.jpg') }}'">
                                <div class="pd-card-img-overlay"></div>
                                <div class="pd-badge pd-badge--hot">{{ $dest['count'] }} Packages</div>
                            </div>
                            <div class="pd-card-body">
                                <h3 class="pd-card-name">{{ $dest['name'] }}</h3>
                                <div class="pd-card-price-wrap align-items-start mt-auto">
                                    <span class="pd-price-per text-muted">Starting from</span>
                                    <div class="pd-price-bottom">
                                        <span class="pd-price-final">₹{{ $dest['price'] }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Dynamic Packages Slider --}}
    <section class="rd-section" style="margin-top: 60px;">
        <div class="rd-container">
            <div class="rd-header">
                <div>
                    <p class="rd-eyebrow">Top Picks</p>
                    <h2 class="rd-title">Affordable Packages</h2>
                    <p class="rd-subtitle">Explore our best value domestic tour packages</p>
                </div>
                <div class="rd-header-right">
                    {{-- Slider Navigation Controls --}}
                    <div class="rd-nav-btns">
                        <button class="rd-nav-btn" id="rdPrev" aria-label="Previous">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <button class="rd-nav-btn" id="rdNext" aria-label="Next">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="rd-slider-outer">
                <div class="rd-track" id="rdTrack">
                    @forelse($packages as $package)
                        <a href="{{ route('packages.show', $package->slug) }}" class="rd-card">
                            <div class="rd-card-img"
                                style="background-image: url('{{ $package->image ? asset('storage/' . $package->image) : asset('images/couple-bg.jpg') }}');">
                            </div>
                            <div class="rd-card-overlay"></div>

                            <div class="rd-card-badge rd-badge--hot">
                                Best Value
                            </div>

                            <div class="rd-card-body">
                                <div class="rd-card-rating">
                                    <i class="bi bi-star-fill"></i> {{ $package->rating ?? '4.5' }}
                                </div>
                                <div class="rd-card-info">
                                    <span class="rd-card-location">
                                        <i class="bi bi-geo-alt-fill"></i> {{ $package->state ?? 'India' }}
                                    </span>
                                    <h3 class="rd-card-name">{{ $package->title }}</h3>

                                    <div class="rd-card-footer">
                                        <div class="rd-price-block">
                                            <span class="rd-price-from">From</span>
                                            <span class="rd-price">₹{{ number_format($package->price) }}</span>
                                            <span class="rd-price-per">/Adult</span>
                                        </div>
                                        <span class="rd-card-btn">View <i class="bi bi-arrow-right"></i></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="col-12 text-center py-5" style="width: 100%;">
                            <h4 class="text-muted">No packages found under ₹25,000 at the moment.</h4>
                            <p>Please check back later or explore our other destinations.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="rd-dots" id="rdDots"></div>
        </div>
    </section>

    {{-- 3. CTA Section --}}
    {{-- Traveler Testimonials --}}
    <section class="container mt-5 mb-5" style="max-width: min(100% - 24px, 1320px);">
        <div class="rd-header mb-4">
            <div>
                <p class="rd-eyebrow">Reviews</p>
                <h2 class="rd-title">Traveler Testimonials</h2>
            </div>
        </div>
        <div class="seo-dd-testimonial-grid">
            <div class="seo-dd-testimonial-card">
                <span class="seo-dd-quote-mark">"</span>
                <div class="seo-dd-stars" style="width: max-content;">
                    <span><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                            class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></span>
                </div>
                <p class="seo-dd-review">"An absolutely amazing experience! The budget package to Kerala was well-organized
                    and we didn't have to worry about a thing. Highly recommend for family trips!"</p>
                <div class="seo-dd-user">
                    <img src="{{ asset('images/user1.jpg') }}"
                        onerror="this.src='https://ui-avatars.com/api/?name=Aarti+S&background=random'" alt="Aarti S.">
                    <div class="seo-dd-user-meta">
                        <h3>Aarti S.</h3>
                        <p class="mb-0 text-success fw-bold mt-1" style="font-size: 0.85rem;"><i
                                class="bi bi-patch-check-fill"></i> Verified Traveler</p>
                    </div>
                </div>
            </div>

            <div class="seo-dd-testimonial-card">
                <span class="seo-dd-quote-mark">"</span>
                <div class="seo-dd-stars" style="width: max-content;">
                    <span><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                            class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></span>
                </div>
                <p class="seo-dd-review">"The Manali trip under 25K was an absolute steal. Beautiful hotel stays, seamless
                    transfers, and unforgettable snow activities. Will definitely book again!"</p>
                <div class="seo-dd-user">
                    <img src="{{ asset('images/user2.jpg') }}"
                        onerror="this.src='https://ui-avatars.com/api/?name=Rohan+M&background=random'" alt="Rohan M.">
                    <div class="seo-dd-user-meta">
                        <h3>Rohan M.</h3>
                        <p class="mb-0 text-success fw-bold mt-1" style="font-size: 0.85rem;"><i
                                class="bi bi-patch-check-fill"></i> Verified Traveler</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="CTA-section-container"
        style="background-image: url('{{ asset('images/kerala.avif') }}'); margin-bottom: 60px;">
        <div class="CTA-section-overlay"></div>
        <div class="container position-relative z-2">
            <div class="row align-items-center">
                <div class="col-lg-7 CTA-section-content">
                    <div class="CTA-section-header">
                        <h2 class="CTA-section-title">Can't find what you're looking for?</h2>
                        <p class="CTA-section-description">
                            Let our travel experts craft a personalized itinerary just for you. Tell us your budget,
                            preferences, and travel dates, and we'll design the perfect trip across India.
                        </p>
                    </div>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="{{ route('contact') }}" class="hb-btn hb-btn--primary">
                            Plan My Trip <i class="bi bi-arrow-right"></i>
                        </a>
                        <a href="tel:+919828065555" class="hb-btn hb-btn--ghost">
                            <i class="bi bi-telephone-fill"></i> Call Us Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
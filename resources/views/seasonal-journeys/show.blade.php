@extends('layouts.app')

@php
    $mediaUrl = function ($path) use ($journey) {
        if (is_array($path)) {
            $path = reset($path);
        }

        return $journey->resolveMediaUrl($path);
    };

    $heroImage = $journey->hero_image_url;
    $displayPrice = $journey->price_text ?: 'Custom seasonal package';
    $displayBestSeason = $journey->best_season ?: 'Best seasonal window';
    $displayDuration = $journey->ideal_duration ?: 'Flexible Duration';
    $displayLocation = $journey->location ?: $journey->title;
    $displayClimate = $journey->climate ?: 'Comfortable seasonal weather';
    $heroSubtitle = $journey->tagline ?: ($journey->excerpt ?: 'A thoughtfully planned seasonal escape with curated stays, routes, and local experiences.');
    $monthOptions = collect(range(0, 11))
        ->map(fn (int $offset) => now()->startOfMonth()->addMonths($offset)->format('F, Y'))
        ->all();

    $popularFor = collect($journey->popular_for ?? [])
        ->map(fn ($item) => is_array($item) ? ($item['value'] ?? $item['label'] ?? '') : $item)
        ->filter(fn ($item) => trim((string) $item) !== '')
        ->values()
        ->all();

    if (empty($popularFor)) {
        $popularFor = ['Seasonal escapes', 'Curated stays', 'Local experiences'];
    }

    $overviewHtml = trim((string) ($journey->overview ?: $journey->content));
    if ($overviewHtml === '') {
        $overviewHtml = '<p>' . e($journey->excerpt ?: ($journey->title . ' is designed for travelers who want a timely seasonal holiday with comfortable stays, curated sightseeing, and simple planning from start to finish.')) . '</p>';
    }
    $hasLongOverview = \Illuminate\Support\Str::length(strip_tags($overviewHtml)) > 420;

    $gallerySpans = [
        ['cols' => 5, 'rows' => 4],
        ['cols' => 4, 'rows' => 4],
        ['cols' => 3, 'rows' => 4],
        ['cols' => 4, 'rows' => 4],
        ['cols' => 5, 'rows' => 4],
        ['cols' => 3, 'rows' => 4],
    ];

    $galleryItems = collect($journey->gallery ?? [])
        ->map(function ($item, int $index) use ($mediaUrl, $gallerySpans, $journey) {
            $image = is_array($item) ? ($item['image'] ?? $item['path'] ?? $item['url'] ?? '') : $item;
            $caption = is_array($item) ? ($item['caption'] ?? $item['title'] ?? $item['label'] ?? '') : '';

            return [
                'image' => trim((string) $image) !== '' ? $mediaUrl($image) : '',
                'caption' => trim((string) $caption) ?: $journey->title . ' seasonal view',
                'cols' => $gallerySpans[$index]['cols'] ?? 4,
                'rows' => $gallerySpans[$index]['rows'] ?? 4,
            ];
        })
        ->filter(fn ($item) => $item['image'] !== '')
        ->values();

    $highlights = collect($journey->highlights ?? [])
        ->map(fn ($item) => [
            'title' => is_array($item) ? ($item['title'] ?? '') : (string) $item,
            'description' => is_array($item) ? ($item['description'] ?? ($item['desc'] ?? '')) : '',
            'icon' => is_array($item) ? ($item['icon'] ?? 'bi bi-stars') : 'bi bi-stars',
        ])
        ->filter(fn ($item) => trim($item['title'] . $item['description']) !== '')
        ->values()
        ->all();

    if (empty($highlights)) {
        $highlights = [
            ['title' => 'Season-ready routes', 'description' => 'Itineraries planned around weather, crowd flow, and the best local experiences.', 'icon' => 'bi bi-map'],
            ['title' => 'Curated stays', 'description' => 'Handpicked hotels and resorts matched to your travel mood and budget.', 'icon' => 'bi bi-house-heart'],
            ['title' => 'Flexible planning', 'description' => 'Trips can be shaped for couples, families, friends, or slow relaxed getaways.', 'icon' => 'bi bi-sliders'],
        ];
    }

    $relatedPackageItems = collect($relatedPackages ?? []);

    $whyChooseItems = collect([
        $journey->why_choose_1,
        $journey->why_choose_2,
        $journey->why_choose_3,
        $journey->why_choose_4,
    ])
        ->filter(fn ($item) => trim((string) $item) !== '')
        ->map(function ($item, int $index) {
            $lines = preg_split('/\r\n|\r|\n/', trim((string) $item));
            $title = trim((string) ($lines[0] ?? ''));
            $description = trim(implode(' ', array_filter(array_slice($lines, 1))));

            return [
                'title' => $title !== '' ? $title : 'Travel Support ' . ($index + 1),
                'description' => $description,
            ];
        })
        ->values()
        ->all();

    if (empty($whyChooseItems)) {
        $whyChooseItems = [
            ['title' => 'Expert Seasonal Advice', 'description' => 'Guidance on when to go, where to stay, and how to pace each day.'],
            ['title' => 'Custom Packages', 'description' => 'Routes, stays, transfers, and activities tailored to your group.'],
            ['title' => 'On-trip Assistance', 'description' => 'Support before and during your journey for smoother travel.'],
        ];
    }

    $seasons = collect($journey->seasons ?? [])
        ->filter(fn ($season) => is_array($season) && trim((string) ($season['name'] ?? '')) !== '')
        ->values()
        ->all();

    if (empty($seasons)) {
        $seasons = [[
            'name' => $displayBestSeason,
            'weather' => $displayClimate,
            'activities' => array_slice($popularFor, 0, 3),
            'recommendation' => 'A balanced time for sightseeing, relaxed stays, and comfortable transfers.',
            'packing_tip' => 'Pack layers, comfortable walking shoes, and essentials for your planned activities.',
            'crowd_level' => 'Moderate',
            'highlight' => 'Seasonal routes with better timing and fewer planning surprises.',
            'icon' => 'bi bi-cloud-sun',
        ]];
    }

    $testimonials = collect($journey->testimonials ?? [])
        ->filter(fn ($item) => is_array($item) && trim((string) ($item['review'] ?? '')) !== '')
        ->values();

    $faqs = collect($journey->faqs ?? [])
        ->filter(fn ($item) => is_array($item) && trim((string) ($item['question'] ?? '')) !== '')
        ->values();

    if ($faqs->isEmpty()) {
        $faqs = collect([
            ['question' => 'Can this seasonal journey be customized?', 'answer' => 'Yes, the route, hotels, duration, transfers, and activities can be adjusted for your travel style.'],
            ['question' => 'What is included in the starting price?', 'answer' => 'Inclusions depend on the final package, but stays, transfers, sightseeing, and support can be added as required.'],
        ]);
    }

    $offerTitle = $journey->offer_title ?: ('Plan Your ' . $journey->title . ' Seasonal Trip');
    $offerDescription = $journey->offer_description ?: 'Share your dates and travel style to get a custom seasonal itinerary with current package options.';
    $offerDiscount = trim((string) ($journey->discount_percentage ?? ''));

    $quickFacts = collect([
        ['label' => 'Starting Price', 'value' => $displayPrice],
        ['label' => 'Best Season', 'value' => $displayBestSeason],
        ['label' => 'Ideal Duration', 'value' => $displayDuration],
        ['label' => 'Location', 'value' => $displayLocation],
        ['label' => 'Popular For', 'value' => implode(', ', array_slice($popularFor, 0, 3))],
    ])->filter(fn ($fact) => trim((string) $fact['value']) !== '')->values()->all();
@endphp

@section('meta')
    <title>{{ $journey->meta_title ?: ($journey->title . ' Seasonal Journey | SHABDD TRAVEL') }}</title>
    @if($journey->meta_description)
        <meta name="description" content="{{ $journey->meta_description }}">
    @elseif($journey->excerpt)
        <meta name="description" content="{{ $journey->excerpt }}">
    @endif
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
@endpush

@section('content')
    <section class="destination-st-hero seasonal-destination-hero" data-hero-media="image">
        <div class="hero-3d" style="background-image:url('{{ $heroImage }}')" aria-hidden="true">
            <div class="hero-layer hero-layer--back"></div>
            <div class="hero-layer hero-layer--mid"></div>
            <div class="hero-layer hero-layer--front"></div>
            <div class="destination-st-hero-overlay" aria-hidden="true"></div>

            <div class="container destination-st-hero-inner">
                <div class="destination-st-hero-copy">
                    <h1 class="destination-hero-word">{{ $journey->title }}</h1>
                    <p class="destination-hero-subtitle">{{ $heroSubtitle }}</p>
                </div>
            </div>
        </div>

        <div class="destination-st-hero-searchbar-wrap">
            <div class="container">
                <form class="st-searchbar" id="heroSearchbar" action="{{ route('seasonal-journeys.show', $journey->slug) }}" method="get">
                    <div class="st-sb-field" id="sbLocField" role="button" tabindex="0" aria-expanded="false">
                        <svg class="st-sb-icon" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" stroke="currentColor" stroke-width="1.7" />
                            <circle cx="12" cy="9.5" r="2.8" stroke="currentColor" stroke-width="1.7" />
                        </svg>
                        <div class="st-sb-field-inner">
                            <label class="st-sb-label" for="sbLocInput">Location</label>
                            <input id="sbLocInput" name="city" class="st-sb-input" value="{{ request('city', $displayLocation) }}" placeholder="Select location" readonly />
                        </div>
                        <svg class="st-sb-chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="st-sb-dropdown" id="sbLocDropdown">
                            <div class="st-sb-dropdown-search">
                                <input type="text" id="sbLocSearch" placeholder="Search city" />
                            </div>
                            <div class="st-sb-dropdown-list" id="sbLocList"></div>
                        </div>
                    </div>

                    <div class="st-sb-divider"></div>

                    <div class="st-sb-field" id="sbMonthField" role="button" tabindex="0" aria-expanded="false">
                        <svg class="st-sb-icon" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <rect x="3.5" y="5" width="17" height="15" rx="2.5" stroke="currentColor" stroke-width="1.6" />
                            <path d="M3.5 9.5h17M8 3.5v3M16 3.5v3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
                        </svg>
                        <div class="st-sb-field-inner">
                            <label class="st-sb-label" for="sbMonthInput">Month</label>
                            <input id="sbMonthInput" name="month" class="st-sb-input" value="{{ request('month', '') }}" placeholder="Select month" readonly />
                        </div>
                        <svg class="st-sb-chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="st-sb-dropdown" id="sbMonthDropdown"></div>
                    </div>

                    <button class="st-sb-search-btn" type="submit">Explore</button>
                </form>
            </div>
        </div>
    </section>

    <script>
        window.ST_PAGE_SEARCH_DATA = {
            locations: @json([$displayLocation]),
            months: @json($monthOptions),
        };
    </script>

    <section class="seo-dd seasonal-detail-page" style="--dd-primary: #0f67da;">
        <div class="container seo-dd-container">
            <section class="seo-dd-quick-strip" aria-label="Quick seasonal journey information">
                @foreach($quickFacts as $fact)
                    <article class="seo-dd-quick-card">
                        <p>{{ $fact['label'] }}</p>
                        <strong>{{ $fact['value'] }}</strong>
                    </article>
                @endforeach
            </section>

            <div class="seo-dd-grid">
                <main class="seo-dd-main" itemscope itemtype="https://schema.org/Trip">
                    <meta itemprop="name" content="{{ $journey->title }}">

                    <section id="overview" class="seo-dd-section seo-dd-glass">
                        <div class="seo-dd-title-wrap">
                            <p class="seo-dd-kicker">Journey Overview</p>
                            <h2 class="seo-dd-title">{{ $journey->title }} Seasonal Travel Detail</h2>
                        </div>
                        <div class="seo-dd-copy {{ $hasLongOverview ? 'is-collapsed' : '' }}" data-seasonal-readmore itemprop="description">
                            {!! $overviewHtml !!}
                        </div>
                        @if($hasLongOverview)
                            <button type="button" class="seo-dd-link" data-seasonal-toggle aria-expanded="false">Read More</button>
                        @endif
                    </section>

                    @if($galleryItems->isNotEmpty())
                        <section id="gallery" class="seo-dd-section seo-dd-gallery-section">
                            <div class="seo-dd-gallery-head">
                                <div class="seo-dd-title-wrap">
                                    <p class="seo-dd-kicker">Visual Journey</p>
                                    <h2 class="seo-dd-title">{{ $journey->title }} Gallery</h2>
                                    <p class="seo-dd-lead">Images uploaded from the admin panel for this seasonal journey.</p>
                                </div>
                            </div>
                            <div class="seo-dd-gallery-grid">
                                @foreach($galleryItems as $item)
                                    <button
                                        type="button"
                                        class="seo-dd-gallery-card"
                                        style="--gallery-cols: {{ $item['cols'] }}; --gallery-rows: {{ $item['rows'] }};"
                                        data-gallery-index="{{ $loop->index }}"
                                        aria-label="Open gallery image {{ $loop->iteration }}: {{ $item['caption'] }}"
                                    >
                                        <img src="{{ $item['image'] }}" alt="{{ $item['caption'] }}" loading="lazy">
                                        <div class="seo-dd-gallery-overlay"></div>
                                        <span class="seo-dd-gallery-chip">{{ $item['caption'] }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    <section id="highlights" class="seo-dd-section">
                        <div class="seo-dd-title-wrap">
                            <p class="seo-dd-kicker">Journey Highlights</p>
                            <h2 class="seo-dd-title">What To Expect</h2>
                        </div>
                        <div class="seo-dd-card-grid seo-dd-feature-grid">
                            @foreach($highlights as $item)
                                <article class="seo-dd-card seo-dd-feature-card">
                                    <span class="seo-dd-icon"><i class="{{ $item['icon'] }}"></i></span>
                                    <h3>{{ $item['title'] }}</h3>
                                    @if($item['description'])
                                        <p>{{ $item['description'] }}</p>
                                    @endif
                                </article>
                            @endforeach
                        </div>
                    </section>

                    <section id="packages" class="seo-dd-section">
                        <div class="seo-dd-title-wrap">
                            <p class="seo-dd-kicker">Related Packages</p>
                            <h2 class="seo-dd-title">{{ $journey->title }} Packages</h2>
                            <p class="seo-dd-lead">Packages uploaded from the admin panel for this destination.</p>
                        </div>

                        @if($relatedPackageItems->isEmpty())
                            <article class="seo-dd-card seo-dd-empty-card">
                                <h3>No related packages found</h3>
                                <p>Packages with {{ $journey->title }} in the title, city, state, or country will appear here after they are uploaded from admin.</p>
                            </article>
                        @else
                            <div class="swiper seo-dd-swiper" data-swiper-packages>
                                <div class="swiper-wrapper">
                                @foreach($relatedPackageItems as $package)
                                    @php
                                        $packageDuration = $package['duration'] ?? '4D/3N';
                                        $packageRating = number_format((float) ($package['rating'] ?? 4.5), 1);
                                        $packageOldPrice = $package['old_price'] ?? '';
                                        $packageNewPrice = $package['price'] ?? '';
                                        $packageType = $package['travel_style'] ?? ($popularFor[0] ?? 'Leisure');
                                        $packageMeta = collect([
                                            $package['category'] ?? null,
                                            $package['travel_style'] ?? null,
                                            $packageDuration,
                                        ])->filter()->implode(' • ');
                                    @endphp
                                    <article class="swiper-slide seo-dd-card seo-dd-package-card">
                                        <img src="{{ $mediaUrl($package['image'] ?? $heroImage) }}" alt="{{ $package['name'] }}" loading="lazy">
                                        <div class="seo-dd-package-media-bar">
                                            <span class="seo-dd-package-chip">{{ $packageType }}</span>
                                            <span class="seo-dd-package-chip seo-dd-package-chip-muted">{{ $packageDuration }}</span>
                                        </div>
                                        <div class="seo-dd-card-body">
                                            <h3>{{ $package['name'] }}</h3>
                                            <div class="seo-dd-package-meta">
                                                <span>{{ $packageDuration }}</span>
                                                <span>★ {{ $packageRating }} Rating</span>
                                            </div>
                                            @if($packageMeta !== '')
                                                <ul class="seo-dd-package-points">
                                                    <li>{{ $packageMeta }}</li>
                                                    <li>Customizable seasonal itinerary</li>
                                                    <li>Hotel stay and transfer support</li>
                                                </ul>
                                            @endif
                                            <div class="seo-dd-package-footer">
                                                <div class="seo-dd-package-price-wrap">
                                                    @if($packageOldPrice !== '')
                                                        <p class="seo-dd-price normal-price">{{ $packageOldPrice }}</p>
                                                    @endif
                                                    @if($packageNewPrice !== '')
                                                        <p class="seo-dd-price discounted-price">{{ $packageNewPrice }}</p>
                                                    @endif
                                                    <span class="seo-dd-price-note">Per person on twin sharing</span>
                                                </div>
                                                <a href="{{ $package['url'] ?? '#' }}" class="seo-dd-btn View-package-btn seo-dd-btn-primary">View Details</a>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                                </div>
                                <div class="seo-dd-swiper-nav">
                                    <button class="seo-dd-swiper-btn prev" type="button" aria-label="Previous package"><i class="bi bi-arrow-left"></i></button>
                                    <button class="seo-dd-swiper-btn next" type="button" aria-label="Next package"><i class="bi bi-arrow-right"></i></button>
                                </div>
                            </div>
                        @endif
                    </section>

                    <section id="besttime" class="seo-dd-section">
                        <div class="seo-dd-title-wrap">
                            <p class="seo-dd-kicker">Season Guide</p>
                            <h2 class="seo-dd-title">Best Time For {{ $journey->title }}</h2>
                        </div>
                        <div class="seo-dd-card-grid seo-dd-season-grid">
                            @foreach($seasons as $season)
                                @php
                                    $seasonActivities = collect($season['activities'] ?? [])
                                        ->map(fn ($activity) => is_array($activity) ? ($activity['value'] ?? $activity['label'] ?? '') : $activity)
                                        ->filter(fn ($activity) => trim((string) $activity) !== '')
                                        ->values()
                                        ->all();
                                    $activityLine = !empty($seasonActivities) ? implode(', ', $seasonActivities) : 'Sightseeing, local exploration';
                                @endphp
                                <article class="seo-dd-card seo-dd-season-card">
                                    <span class="seo-dd-season-icon"><i class="{{ $season['icon'] ?? 'bi bi-cloud-sun' }}"></i></span>
                                    <h3>{{ $season['name'] ?? 'Best Season' }}</h3>
                                    <p class="seo-dd-weather">{{ $season['weather'] ?? $displayClimate }}</p>
                                    <div class="seo-dd-badges">
                                        @foreach($seasonActivities as $activity)
                                            <span class="seo-dd-badge">{{ $activity }}</span>
                                        @endforeach
                                    </div>
                                    <p class="seo-dd-reco">{{ $season['recommendation'] ?? 'Great for balanced travel plans.' }}</p>
                                    <div class="seo-dd-season-details">
                                        <p><strong>Best activities:</strong> {{ $activityLine }}</p>
                                        <p><strong>Packing tip:</strong> {{ $season['packing_tip'] ?? 'Carry comfortable clothes and walking shoes.' }}</p>
                                        <p><strong>Crowd level:</strong> {{ $season['crowd_level'] ?? 'Moderate' }}</p>
                                        <p><strong>Highlight:</strong> {{ $season['highlight'] ?? 'A comfortable travel window for seasonal experiences.' }}</p>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </section>

                    <section id="why" class="seo-dd-section">
                        <div class="seo-dd-title-wrap">
                            <p class="seo-dd-kicker">Why Choose Us</p>
                            <h2 class="seo-dd-title">Planning Support For This Journey</h2>
                        </div>
                        <div class="seo-dd-card-grid seo-dd-feature-grid">
                            @foreach($whyChooseItems as $item)
                                <article class="seo-dd-card seo-dd-feature-card">
                                    <h3>{{ $item['title'] }}</h3>
                                    @if($item['description'] !== '')
                                        <p>{{ $item['description'] }}</p>
                                    @endif
                                </article>
                            @endforeach
                        </div>
                    </section>

                    @if($testimonials->isNotEmpty())
                        <section id="testimonials" class="seo-dd-section">
                            <div class="seo-dd-title-wrap seo-dd-testimonial-head">
                                <div>
                                    <p class="seo-dd-kicker">Traveler Stories</p>
                                    <h2 class="seo-dd-title">What Guests Say</h2>
                                </div>
                            </div>
                            <div class="seasonal-detail-testimonial-grid">
                                @foreach($testimonials as $testimonial)
                                    <article class="seo-dd-card seo-dd-testimonial-card">
                                        <span class="seo-dd-quote-mark">“</span>
                                        <p class="seo-dd-review">{{ $testimonial['review'] ?? '' }}</p>
                                        @if(!empty($testimonial['images']) && is_array($testimonial['images']))
                                            <div class="seo-dd-review-gallery">
                                                @foreach(array_slice($testimonial['images'], 0, 5) as $imageIndex => $image)
                                                    <a href="{{ $journey->resolveMediaUrl($image) }}" target="_blank" rel="noopener">
                                                        <img src="{{ $journey->resolveMediaUrl($image) }}"
                                                            alt="Travel photo {{ $imageIndex + 1 }} shared by {{ $testimonial['name'] ?? 'Traveler' }}"
                                                            loading="lazy">
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                        <div class="seo-dd-user">
                                            <div class="seo-dd-user-meta">
                                                <h3>{{ $testimonial['name'] ?? 'Traveler' }}</h3>
                                                <p>{{ $testimonial['location'] ?? '' }}</p>
                                            </div>
                                            <p class="seo-dd-stars"><span>★</span> {{ number_format((float) ($testimonial['rating'] ?? 5), 1) }}</p>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    <section id="faq" class="seo-dd-section seo-dd-faq-section" itemscope itemtype="https://schema.org/FAQPage">
                        <div class="seo-dd-faq-copy">
                            <h2>General Questions asked by customers.</h2>
                            <div class="seo-dd-faq-support">
                                <p>Our friendly team is always here to help you with quick, clear, and reliable answers whenever needed.</p>
                                <a href="{{ route('contact') }}" class="seo-dd-faq-cta">Contact Sales</a>
                            </div>
                        </div>
                        <div class="seo-dd-faq-list">
                            @foreach($faqs as $faq)
                                <article class="seo-dd-faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                                    <button type="button" class="seo-dd-faq-btn {{ $loop->first ? 'is-open' : '' }}" data-seasonal-faq-toggle aria-expanded="{{ $loop->first ? 'true' : 'false' }}">
                                        <span itemprop="name">{{ $faq['question'] }}</span>
                                        <span class="seo-dd-faq-icon" aria-hidden="true"></span>
                                    </button>
                                    <div class="seo-dd-faq-panel {{ $loop->first ? 'is-open' : '' }}" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                                        <p itemprop="text">{{ $faq['answer'] ?? '' }}</p>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </section>
                </main>

                <aside class="seo-dd-sidebar">
                    <div class="seo-dd-sidebar-sticky">
                        <article class="seo-dd-card seo-dd-booking-card">
                            <p class="seo-dd-kicker">Book Your Trip</p>
                            <h3>Plan {{ $journey->title }}</h3>
                            <p class="seo-dd-sidebar-price">{{ $displayPrice }}</p>
                            <form action="#" method="POST" class="seo-dd-form">
                                @csrf
                                <label>
                                    Travel Month
                                    <select name="month">
                                        <option value="">Select month</option>
                                        @foreach(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month)
                                            <option value="{{ $month }}">{{ $month }}</option>
                                        @endforeach
                                    </select>
                                </label>
                                <label>
                                    Guests
                                    <select name="guests">
                                        @for($guest = 1; $guest <= 10; $guest++)
                                            <option value="{{ $guest }}">{{ $guest }} {{ $guest === 1 ? 'Guest' : 'Guests' }}</option>
                                        @endfor
                                    </select>
                                </label>
                                <button type="submit" class="seo-dd-btn seo-dd-btn-primary seo-dd-btn-enquiry seo-dd-btn-block">Send Enquiry</button>
                                <a href="https://wa.me/" target="_blank" rel="noopener" class="seo-dd-btn seo-dd-btn-whatsapp seo-dd-btn-block">WhatsApp Expert</a>
                            </form>
                        </article>

                        <article class="seo-dd-card seo-dd-quick-facts">
                            <h4>Quick Facts</h4>
                            <ul>
                                @foreach($quickFacts as $fact)
                                    <li><span>{{ $fact['label'] }}</span><strong>{{ $fact['value'] }}</strong></li>
                                @endforeach
                                <li><span>Climate</span><strong>{{ $displayClimate }}</strong></li>
                            </ul>
                        </article>

                        <article class="seo-dd-card seo-dd-sticky-nav">
                            <h4>On This Page</h4>
                            <nav>
                                <a href="#overview" class="seo-dd-anchor is-active">Overview</a>
                                @if($galleryItems->isNotEmpty())
                                    <a href="#gallery" class="seo-dd-anchor">Gallery</a>
                                @endif
                                <a href="#highlights" class="seo-dd-anchor">Highlights</a>
                                <a href="#packages" class="seo-dd-anchor">Packages</a>
                                <a href="#besttime" class="seo-dd-anchor">Best Time</a>
                                <a href="#why" class="seo-dd-anchor">Why Choose Us</a>
                                @if($testimonials->isNotEmpty())
                                    <a href="#testimonials" class="seo-dd-anchor">Testimonials</a>
                                @endif
                                <a href="#faq" class="seo-dd-anchor">FAQs</a>
                            </nav>
                        </article>

                        <article class="seo-dd-card seo-dd-cta-card">
                            <p class="seo-dd-kicker">Limited Offer</p>
                            <h4>{{ $offerTitle }}</h4>
                            <p>{{ $offerDescription }}</p>
                            @if($offerDiscount !== '')
                                <span class="seo-dd-badge">{{ $offerDiscount }} Off</span>
                            @endif
                            <a href="#" class="seo-dd-btn seo-dd-btn-primary seo-dd-btn-block">Claim Offer</a>
                        </article>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    @if($galleryItems->isNotEmpty())
        <div class="seo-dd-gallery-modal" id="seoGalleryModal" aria-hidden="true">
            <div class="seo-dd-gallery-modal-backdrop" data-gallery-close></div>

            <div class="seo-dd-gallery-modal-panel" role="dialog" aria-modal="true" aria-label="{{ $journey->title }} gallery viewer">
                <div class="seo-dd-gallery-modal-top">
                    <div>
                        <p class="seo-dd-kicker">Gallery Viewer</p>
                        <h3>{{ $journey->title }}</h3>
                    </div>

                    <button type="button" class="seo-dd-gallery-modal-close" data-gallery-close aria-label="Close gallery">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>

                <div class="seo-dd-gallery-modal-shell">
                    <button type="button" class="seo-dd-gallery-nav seo-dd-gallery-nav-prev" aria-label="Previous image">
                        <i class="bi bi-arrow-left"></i>
                    </button>

                    <div class="swiper seo-dd-gallery-swiper" data-swiper-gallery>
                        <div class="swiper-wrapper">
                            @foreach($galleryItems as $item)
                                <div class="swiper-slide seo-dd-gallery-slide">
                                    <img src="{{ $item['image'] }}" alt="{{ $journey->title }} gallery image {{ $loop->iteration }}" loading="lazy">
                                    <div class="seo-dd-gallery-slide-caption">
                                        <span>{{ $item['caption'] }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <button type="button" class="seo-dd-gallery-nav seo-dd-gallery-nav-next" aria-label="Next image">
                        <i class="bi bi-arrow-right"></i>
                    </button>
                </div>

                <div class="seo-dd-gallery-modal-footer">
                    <span>Swipe or use arrows to explore all {{ $galleryItems->count() }} images</span>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const readMoreContent = document.querySelector('[data-seasonal-readmore]');
            const readMoreToggle = document.querySelector('[data-seasonal-toggle]');

            if (readMoreContent && readMoreToggle) {
                readMoreToggle.addEventListener('click', function () {
                    const isExpanded = readMoreContent.classList.toggle('is-expanded');
                    readMoreContent.classList.toggle('is-collapsed', !isExpanded);
                    readMoreToggle.textContent = isExpanded ? 'Read Less' : 'Read More';
                    readMoreToggle.setAttribute('aria-expanded', isExpanded ? 'true' : 'false');
                });
            }

            document.querySelectorAll('.seasonal-detail-page .seo-dd-anchor').forEach(function (anchor) {
                anchor.addEventListener('click', function (event) {
                    const target = document.querySelector(anchor.getAttribute('href'));
                    if (!target) {
                        return;
                    }

                    event.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                });
            });

            document.querySelectorAll('[data-seasonal-faq-toggle]').forEach(function (toggle) {
                toggle.addEventListener('click', function () {
                    const panel = toggle.nextElementSibling;
                    const faqSection = toggle.closest('.seo-dd-faq-section') || document;
                    if (!panel) {
                        return;
                    }
                    const isOpen = panel.classList.contains('is-open');

                    faqSection.querySelectorAll('[data-seasonal-faq-toggle]').forEach(function (btn) {
                        btn.classList.remove('is-open');
                        btn.setAttribute('aria-expanded', 'false');
                    });
                    faqSection.querySelectorAll('.seo-dd-faq-panel').forEach(function (item) {
                        item.classList.remove('is-open');
                    });

                    if (!isOpen) {
                        toggle.classList.add('is-open');
                        toggle.setAttribute('aria-expanded', 'true');
                        panel.classList.add('is-open');
                    }
                });
            });

            const galleryModal = document.getElementById('seoGalleryModal');
            const galleryTriggers = Array.from(document.querySelectorAll('[data-gallery-index]'));
            const galleryCloseButtons = Array.from(document.querySelectorAll('[data-gallery-close]'));
            const gallerySwiperElement = document.querySelector('[data-swiper-gallery]');
            let gallerySwiper = null;

            const openGalleryModal = function (index) {
                if (!galleryModal || !gallerySwiperElement) {
                    return;
                }

                galleryModal.classList.add('is-open');
                galleryModal.setAttribute('aria-hidden', 'false');
                document.body.classList.add('seo-dd-gallery-modal-open');

                if (!gallerySwiper && typeof Swiper !== 'undefined') {
                    gallerySwiper = new Swiper(gallerySwiperElement, {
                        slidesPerView: 1,
                        spaceBetween: 0,
                        speed: 550,
                        navigation: {
                            nextEl: '.seo-dd-gallery-nav-next',
                            prevEl: '.seo-dd-gallery-nav-prev',
                        },
                        keyboard: {
                            enabled: true,
                        },
                    });
                }

                if (gallerySwiper) {
                    gallerySwiper.slideTo(index, 0);
                }
            };

            const closeGalleryModal = function () {
                if (!galleryModal) {
                    return;
                }

                galleryModal.classList.remove('is-open');
                galleryModal.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('seo-dd-gallery-modal-open');
            };

            galleryTriggers.forEach(function (trigger) {
                trigger.addEventListener('click', function () {
                    openGalleryModal(Number(trigger.dataset.galleryIndex || 0));
                });
            });

            galleryCloseButtons.forEach(function (button) {
                button.addEventListener('click', closeGalleryModal);
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    closeGalleryModal();
                }
            });

            if (typeof Swiper !== 'undefined') {
                const packageSwiperElement = document.querySelector('[data-swiper-packages]');
                if (packageSwiperElement) {
                    new Swiper(packageSwiperElement, {
                        slidesPerView: 1.15,
                        spaceBetween: 16,
                        navigation: {
                            nextEl: '.seo-dd-swiper-btn.next',
                            prevEl: '.seo-dd-swiper-btn.prev',
                        },
                        breakpoints: {
                            640: { slidesPerView: 2.1 },
                            992: { slidesPerView: 2.4 },
                            1200: { slidesPerView: 2.8 }
                        }
                    });
                }
            }
        });
    </script>

    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $faqs->map(fn ($faq) => [
                '@type' => 'Question',
                'name' => $faq['question'] ?? '',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $faq['answer'] ?? '',
                ],
            ])->values()->all(),
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
@endpush

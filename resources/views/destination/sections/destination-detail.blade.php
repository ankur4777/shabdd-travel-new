@php
    $profile = $destinationProfile ?? [];
    // Destination is expected from parent view/controller.
    // Guard to prevent IDE/static warnings when the section is included in isolation.
    $primaryColor = isset($destination) && $destination ? ($destination->theme_color ?: ($profile['primary_color'] ?? '#2563eb')) : ($profile['primary_color'] ?? '#2563eb');

    $mediaUrl = function ($path) {
        $path = trim((string) $path);

        if ($path === '') {
            return asset('images/couple-bg.jpg');
        }

        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '//', 'data:'])) {
            return $path;
        }

        if (\Illuminate\Support\Str::startsWith($path, ['/storage/', 'storage/', '/images/', 'images/'])) {
            return asset(ltrim($path, '/'));
        }

        return asset('storage/' . ltrim($path, '/'));
    };

    $destinationImage = $mediaUrl($destination->image_url);

    $displayPrice = $destination->formatted_price ?: '₹18,999';
    $displayIdealDays = $destination->ideal_duration ?: ($destination->ideal_days ?: ($profile['ideal_days'] ?? '5-7 Days'));
    $displayBestSeason = $destination->best_season ?: ($profile['best_season'] ?? 'All year');

    $hasAdminOverview = trim(strip_tags((string) ($destination->overview ?? ''))) !== '';
    $overviewText = trim((string) ($destination->overview ?: ($destination->about ?? '')));
    if (!$hasAdminOverview && \Illuminate\Support\Str::length(strip_tags($overviewText)) < 380 && !empty($profile['overview'])) {
        $overviewText = trim((string) $profile['overview']);
    }
    if ($overviewText === '') {
        $overviewText = e($destination->name) . ' is a well-rounded destination for sightseeing, local culture, and memorable experiences planned around your travel style.';
    }
    $hasLongOverview = \Illuminate\Support\Str::length(strip_tags($overviewText)) > 420;

    $cityPackages = !empty($destination->city_packages) ? $destination->city_packages : ($profile['city_packages'] ?? []);
    if (empty($cityPackages)) {
        $cityPackages = [
            ['city_name' => $destination->name, 'url' => route('destinations.index', ['city' => \Illuminate\Support\Str::slug($destination->name)])],
        ];
    }

    $places = !empty($destination->places) ? $destination->places : ($profile['places'] ?? []);
    $packages = $destinationPackages ?? (!empty($destination->packages) ? $destination->packages : ($profile['packages'] ?? []));
    $features = !empty($destination->features) ? $destination->features : ($profile['features'] ?? []);
    $seasons = !empty($destination->seasons) ? $destination->seasons : ($profile['seasons'] ?? []);
    $blogs = !empty($destination->blogs) ? $destination->blogs : ($profile['blogs'] ?? []);
    $testimonials = !empty($destination->testimonials) ? $destination->testimonials : ($profile['testimonials'] ?? []);
    $faqs = !empty($destination->faqs) ? $destination->faqs : ($profile['faqs'] ?? []);
    $popularFor = collect(!empty($destination->popular_for) ? $destination->popular_for : ($profile['popular_for'] ?? ['Culture', 'Sightseeing']))
        ->map(fn ($item) => is_array($item) ? ($item['value'] ?? $item['label'] ?? '') : $item)
        ->filter(fn ($item) => trim((string) $item) !== '')
        ->values()
        ->all();

    $quickFacts = collect([
        ['label' => 'Location', 'value' => $destination->location ?: $destination->country],
        ['label' => 'Language', 'value' => $destination->language],
        ['label' => 'Currency', 'value' => $destination->currency],
        ['label' => 'Ideal Duration', 'value' => $displayIdealDays],
        ['label' => 'Best Season', 'value' => $displayBestSeason],
        ['label' => 'Popular For', 'value' => implode(', ', array_slice($popularFor, 0, 3))],
    ])->filter(fn ($fact) => trim((string) $fact['value']) !== '')->values()->all();

    $whyChooseItems = collect([
        $destination->why_choose_1,
        $destination->why_choose_2,
        $destination->why_choose_3,
        $destination->why_choose_4,
    ])
        ->filter(fn ($item) => trim((string) $item) !== '')
        ->map(function ($item, int $index) {
            $lines = preg_split('/\r\n|\r|\n/', trim((string) $item));
            $title = trim((string) ($lines[0] ?? ''));
            $description = trim(implode(' ', array_filter(array_slice($lines, 1))));

            return [
                'title' => $title !== '' ? $title : 'Why Choose ' . ($index + 1),
                'description' => $description,
            ];
        })
        ->values()
        ->all();

    if (empty($whyChooseItems)) {
        $whyChooseItems = [
            [
                'title' => 'Handpicked Destinations',
                'description' => 'Thoughtfully selected destinations for every traveler.',
            ],
            [
                'title' => 'Customized Tour Packages',
                'description' => 'Personalized journeys matched to your travel needs.',
            ],
            [
                'title' => '24/7 Travel Assistance',
                'description' => 'Support before, during, and after your trip.',
            ],
            [
                'title' => 'Experienced Travel Experts',
                'description' => 'Destination guidance from travel specialists.',
            ],
            [
                'title' => 'Safe & Comfortable Travel',
                'description' => 'Trusted stays, reliable transport, and verified services.',
            ],
        ];
    }

    if (empty($seasons) && trim((string) $displayBestSeason) !== '') {
        $seasons = [[
            'name' => $displayBestSeason,
            'weather' => $destination->weather ?: 'Recommended travel season',
            'activities' => array_slice($popularFor, 0, 3),
            'recommendation' => 'Best suited for a comfortable ' . $destination->name . ' trip.',
            'icon' => 'bi bi-cloud-sun',
        ]];
    }

    $offerTitle = $destination->offer_title ?: ('Get Free Expert ' . $destination->name . ' Itinerary');
    $offerDescription = $destination->offer_description ?: ('Unlock seasonal deals and custom routes for your next ' . $destination->name . ' holiday.');
    $offerDiscount = trim((string) ($destination->discount_percentage ?? ''));

    $relatedPackageItems = $relatedPackages ?? [];

    $gallerySpans = [
        ['cols' => 3, 'rows' => 4],
        ['cols' => 5, 'rows' => 4],
        ['cols' => 4, 'rows' => 4],
        ['cols' => 4, 'rows' => 4],
        ['cols' => 3, 'rows' => 4],
        ['cols' => 5, 'rows' => 4],
        ['cols' => 4, 'rows' => 4],
        ['cols' => 3, 'rows' => 4],
        ['cols' => 4, 'rows' => 4],
        ['cols' => 5, 'rows' => 4],
        ['cols' => 3, 'rows' => 4],
        ['cols' => 4, 'rows' => 4],
    ];

    $galleryItems = collect($destination->gallery ?? [])
        ->map(function ($item, int $index) use ($mediaUrl, $gallerySpans) {
            $image = '';
            $label = '';

            if (is_array($item)) {
                $image = $item['image'] ?? $item['path'] ?? $item['url'] ?? '';
                $label = $item['caption'] ?? $item['text'] ?? $item['title'] ?? $item['label'] ?? '';
            } else {
                $image = (string) $item;
            }

            return [
                'image' => trim((string) $image) !== '' ? $mediaUrl($image) : '',
                'label' => trim((string) $label),
                'cols' => $gallerySpans[$index]['cols'] ?? 4,
                'rows' => $gallerySpans[$index]['rows'] ?? 4,
            ];
        })
        ->filter(fn ($item) => $item['image'] !== '')
        ->values();
@endphp

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
@endpush

<section class="seo-dd" style="--dd-primary: {{ $primaryColor }};">
    <div class="container seo-dd-container">
        <div class="seo-dd-mobile-filter-bar" aria-label="Mobile quick actions">
            <button class="seo-dd-mobile-filter-btn" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#seoTripOffcanvas" aria-controls="seoTripOffcanvas">
                <i class="bi bi-funnel-fill"></i>
                <span>Filter</span>
            </button>
            <button class="seo-dd-mobile-filter-btn" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#seoPageNavOffcanvas" aria-controls="seoPageNavOffcanvas">
                <i class="bi bi-sort-down"></i>
                <span>Sort</span>
            </button>
        </div>

        <div class="offcanvas offcanvas-start seo-dd-offcanvas" tabindex="-1" id="seoTripOffcanvas"
            aria-labelledby="seoTripOffcanvasLabel">
            <div class="offcanvas-header seo-dd-offcanvas-header">
                <h5 class="offcanvas-title" id="seoTripOffcanvasLabel">Plan {{ $destination->name }} Trip</h5>
                <button type="button" class="seo-dd-offcanvas-close" data-bs-dismiss="offcanvas" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="offcanvas-body seo-dd-offcanvas-body">
                <article class="seo-dd-card seo-dd-booking-card">
                    <p class="seo-dd-kicker">Book Your Trip</p>
                    <h3>Plan {{ $destination->name }} Vacation</h3>


                    <form action="#" method="POST" class="seo-dd-form">
                        @csrf
                        <label>
                            Travel Month
                            <select name="month">
                                <option value="">Select month</option>
                                @foreach($monthOptions ?? ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month)
                                    <option value="{{ $month }}">{{ $month }}</option>
                                @endforeach
                            </select>
                        </label>

                        <label>
                            Guests
                            <select name="guests">
                                @for($guest = 1; $guest <= 10; $guest++)
                                    <option value="{{ $guest }}">{{ $guest }} {{ $guest === 1 ? 'Guest' : 'Guests' }}
                                    </option>
                                @endfor
                            </select>
                        </label>

                        <button type="submit"
                            class="seo-dd-btn seo-dd-btn-primary seo-dd-btn-enquiry  seo-dd-btn-block">Send
                            Enquiry</button>
                        <a href="https://wa.me/" target="_blank" rel="noopener"
                            class="seo-dd-btn seo-dd-btn-whatsapp seo-dd-btn-block">WhatsApp Expert</a>
                    </form>
                </article>

                <article class="seo-dd-card seo-dd-quick-facts">
                    <h4>Quick Destination Facts</h4>
                    <ul>
                        @foreach($quickFacts as $fact)
                            <li><span>{{ $fact['label'] }}</span><strong>{{ $fact['value'] }}</strong></li>
                        @endforeach
                        <li><span>Rating</span><strong>{{ number_format((float) $destination->rating, 1) }}/5</strong></li>
                    </ul>
                </article>
            </div>
        </div>

        <div class="offcanvas offcanvas-end seo-dd-offcanvas seo-dd-offcanvas-nav" tabindex="-1"
            id="seoPageNavOffcanvas" aria-labelledby="seoPageNavOffcanvasLabel">
            <div class="offcanvas-header seo-dd-offcanvas-header">
                <h5 class="offcanvas-title" id="seoPageNavOffcanvasLabel">On This Page</h5>
                <button type="button" class="seo-dd-offcanvas-close" data-bs-dismiss="offcanvas" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="offcanvas-body seo-dd-offcanvas-body">
                <article class="seo-dd-card seo-dd-sticky-nav seo-dd-mobile-nav-card">
                    <h4>On This Page</h4>
                    <nav>
                        <a href="#overview" class="seo-dd-anchor is-active" data-seo-offcanvas-anchor>Overview</a>
                        <a href="#gallery" class="seo-dd-anchor" data-seo-offcanvas-anchor>Gallery</a>
                        <a href="#city-packages" class="seo-dd-anchor" data-seo-offcanvas-anchor>City Packages</a>
                        <a href="#packages" class="seo-dd-anchor" data-seo-offcanvas-anchor>Packages</a>
                        <a href="#besttime" class="seo-dd-anchor" data-seo-offcanvas-anchor>Best Time</a>
                        <a href="{{ route('blog.index') }}" class="seo-dd-anchor" data-seo-offcanvas-anchor>Blogs</a>
                        <a href="#faq" class="seo-dd-anchor" data-seo-offcanvas-anchor>FAQs</a>
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
        </div>

        <section class="seo-dd-quick-strip" aria-label="Quick destination information">
            <article class="seo-dd-quick-card">
                <p>Starting Price</p>
                <strong>{{ $displayPrice }}</strong>
            </article>
            <article class="seo-dd-quick-card">
                <p>Location</p>
                <strong>{{ $destination->location ?: $destination->country }}</strong>
            </article>
            <article class="seo-dd-quick-card">
                <p>Best Time To Visit</p>
                <strong>{{ $displayBestSeason }}</strong>
            </article>
            <article class="seo-dd-quick-card">
                <p>Ideal Duration</p>
                <strong>{{ $displayIdealDays }}</strong>
            </article>
            <article class="seo-dd-quick-card">
                <p>{{ $destination->language ? 'Language' : 'Popular For' }}</p>
                <strong>{{ $destination->language ?: implode(', ', $popularFor) }}</strong>
            </article>
        </section>

        <div class="seo-dd-grid">
            <main class="seo-dd-main" itemscope itemtype="https://schema.org/TouristDestination">
                <meta itemprop="name" content="{{ $destination->name }} Tour Packages">

                <section id="overview" class="seo-dd-section seo-dd-glass" id="seo-dd-overview">

                    <div class="seo-dd-title-wrap">
                        <p class="seo-dd-kicker">Destination Overview</p>
                        <h2 class="seo-dd-title">{{ $destination->name }} Tour Packages</h2>
                    </div>
                    <div class="seo-dd-copy {{ $hasLongOverview ? 'is-collapsed' : '' }}" data-seo-readmore
                        itemprop="description">
                        {!! $overviewText !!}
                    </div>
                    @if($hasLongOverview)
                        <button type="button" class="seo-dd-link" data-seo-toggle aria-expanded="false">Read More</button>
                    @endif
                </section>

                @if($galleryItems->isNotEmpty())
                <section id="gallery" class="seo-dd-section seo-dd-gallery-section">
                    <div class="seo-dd-gallery-head">
                        <div class="seo-dd-title-wrap">
                            <p class="seo-dd-kicker">Visual Journey</p>
                            <h2 class="seo-dd-title">{{ $destination->name }} Gallery</h2>
                            <p class="seo-dd-lead">
                                Gallery images uploaded from admin for this destination.
                            </p>
                        </div>
                        <div class="seo-dd-gallery-stats">
                            <strong>{{ count($galleryItems) }} shots</strong>
                            <span>Uploaded destination visuals</span>
                        </div>
                    </div>

                    <div class="seo-dd-gallery-grid">
                        @foreach($galleryItems as $item)
                            <button
                                type="button"
                                class="seo-dd-gallery-card {{ $loop->first ? 'is-featured' : '' }}"
                                style="--gallery-cols: {{ $item['cols'] }}; --gallery-rows: {{ $item['rows'] }};"
                                data-gallery-index="{{ $loop->index }}"
                                aria-label="Open gallery image {{ $loop->iteration }}: {{ $item['label'] }}"
                            >
                                <img src="{{ $item['image'] }}" alt="{{ $destination->name }} gallery image {{ $loop->iteration }}"
                                    loading="lazy">
                                <div class="seo-dd-gallery-overlay"></div>
                                @if($item['label'] !== '')
                                    <span class="seo-dd-gallery-chip">{{ $item['label'] }}</span>
                                @endif
                            </button>
                        @endforeach
                    </div>
                </section>
                @endif



                {{-- <section id="places" class="seo-dd-section">
                    <div class="seo-dd-title-wrap">
                        <p class="seo-dd-kicker">Places To Explore</p>
                        <h2 class="seo-dd-title">Top Places To Explore In {{ $destination->name }}</h2>
                    </div>
                    <div class="seo-dd-card-grid seo-dd-place-grid">
                        @foreach($places as $place)
                        <article class="seo-dd-card seo-dd-place-card">
                            <img src="{{ $place['image'] ?? $destination->image_url }}" alt="{{ $place['name'] }}"
                                loading="lazy">
                            <div class="seo-dd-card-body">
                                <div class="seo-dd-row-between">
                                    <h3>{{ $place['name'] }}</h3>
                                    <span class="seo-dd-duration">{{ $place['duration'] ?? '2-4 Days' }}</span>
                                </div>
                                <p>{{ $place['description'] ?? '' }}</p>
                                <div class="seo-dd-badges">
                                    @foreach(array_slice(($place['attractions'] ?? []), 0, 3) as $attraction)
                                    <span class="seo-dd-badge">{{ $attraction }}</span>
                                    @endforeach
                                </div>
                                <a href="#" class="seo-dd-btn seo-dd-btn-ghost">Explore {{ $place['name'] }}</a>
                            </div>
                        </article>
                        @endforeach
                    </div>
                </section> --}}

                <section id="packages" class="seo-dd-section">
                    <div class="seo-dd-title-wrap">
                        <p class="seo-dd-kicker">Tour Packages</p>
                        <h2 class="seo-dd-title">Explore More {{ $destination->name }} Packages</h2>
                    </div>

                    @if(empty($packages))
                        <article class="seo-dd-card seo-dd-empty-card">
                            <h3>No packages uploaded yet</h3>
                            <p>Packages added from the admin panel with {{ $destination->name }} in the package name will appear here.</p>
                        </article>
                    @else
                    <div class="swiper seo-dd-swiper" data-swiper-packages>
                        <div class="swiper-wrapper">
                            @foreach($packages as $package)
                                @php
                                    $packageDuration = $package['duration'] ?? '4D/3N';
                                    $packageRating = number_format((float) ($package['rating'] ?? 4.5), 1);
                                    $packageOldPrice = $package['price'] ?? $destination->formatted_price;
                                    $packageNewPrice = $package['discounted_price'] ?? ($package['discounted price'] ?? '');
                                    $packageType = $popularFor[0] ?? 'Leisure';
                                    $inclusionOne = $package['inclusion_one'] ?? 'Hotel stay included';
                                    $inclusionTwo = $package['inclusion_two'] ?? 'Local transfers covered';
                                    $inclusionThree = $package['inclusion_three'] ?? 'Top sightseeing spots';
                                    $packageDetailUrl = $package['detail_url'] ?? route('destinations.packages.show', [
                                        'destination' => $destination,
                                        'packageSlug' => $package['package_slug'] ?? \Illuminate\Support\Str::slug(($package['name'] ?? 'package') . '-' . $loop->iteration),
                                    ]);
                                @endphp
                                <article class="swiper-slide seo-dd-card seo-dd-package-card">
                                    <img src="{{ $mediaUrl($package['image'] ?? $destinationImage) }}"
                                        alt="{{ $package['name'] }}" loading="lazy">
                                    <div class="seo-dd-package-media-bar">
                                        <span class="seo-dd-package-chip">{{ $packageType }}</span>
                                        <span
                                            class="seo-dd-package-chip seo-dd-package-chip-muted">{{ $packageDuration }}</span>
                                    </div>
                                    <div class="seo-dd-card-body">
                                        <h3>{{ $package['name'] }}</h3>
                                        <div class="seo-dd-package-meta">
                                            <span>{{ $packageDuration }}</span>
                                            <span>★ {{ $packageRating }} Rating</span>
                                        </div>
                                        <ul class="seo-dd-package-points">
                                            <li>{{ $inclusionOne }}</li>
                                            <li>{{ $inclusionTwo }}</li>
                                            <li>{{ $inclusionThree }}</li>
                                        </ul>
                                        <div class="seo-dd-package-footer">
                                            <div class="seo-dd-package-price-wrap">
                                                <p class="seo-dd-price normal-price">{{ $packageOldPrice }}</p>
                                                <p class="seo-dd-price discounted-price">{{ $packageNewPrice }}</p>
                                                <span class="seo-dd-price-note">Per person on twin sharing</span>
                                            </div>
                                            <a href="{{ $packageDetailUrl }}"
                                                class="seo-dd-btn View-package-btn seo-dd-btn-primary">View Details</a>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                        <div class="seo-dd-swiper-nav">
                            <button class="seo-dd-swiper-btn prev" type="button" aria-label="Previous package"><i
                                    class="bi bi-arrow-left"></i></button>
                            <button class="seo-dd-swiper-btn next" type="button" aria-label="Next package"><i
                                    class="bi bi-arrow-right"></i></button>
                        </div>
                    </div>
                    @endif
                </section>

                <section id="why" class="seo-dd-section">
                    <div class="seo-dd-title-wrap">
                        <p class="seo-dd-kicker">Why Choose Us</p>
                        <h2 class="seo-dd-title">What Makes Us Special</h2>
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

                <section id="besttime" class="seo-dd-section">
                    <div class="seo-dd-title-wrap">
                        <p class="seo-dd-kicker">Season Guide</p>
                        <h2 class="seo-dd-title">Best Time To Visit {{ $destination->name }}</h2>
                    </div>
                    <div class="seo-dd-card-grid seo-dd-season-grid">
                        @foreach($seasons as $season)
                            @php
                                $seasonName = $season['name'] ?? 'Best Season';
                                $seasonWeather = $season['weather'] ?? 'Comfortable weather';
                                $seasonActivities = collect($season['activities'] ?? [])
                                    ->map(fn ($activity) => is_array($activity) ? ($activity['value'] ?? $activity['label'] ?? '') : $activity)
                                    ->filter(fn ($activity) => trim((string) $activity) !== '')
                                    ->values()
                                    ->all();
                                $activityLine = !empty($seasonActivities) ? implode(', ', $seasonActivities) : 'Sightseeing, local exploration';
                                $seasonRecommendation = $season['recommendation'] ?? 'Great for balanced travel plans.';
                                $seasonNameLower = strtolower($seasonName . ' ' . $seasonWeather);
                                $crowdLevel = $season['crowd_level'] ?? (str_contains($seasonNameLower, 'peak') || str_contains($seasonNameLower, 'july') || str_contains($seasonNameLower, 'november') || str_contains($seasonNameLower, 'december') ? 'High - book ahead' : (str_contains($seasonNameLower, 'off') || str_contains($seasonNameLower, 'monsoon') ? 'Low to medium' : 'Moderate'));
                                $packingTip = $season['packing_tip'] ?? (str_contains($seasonNameLower, 'winter') || str_contains($seasonNameLower, 'snow') || str_contains($seasonNameLower, '-') ? 'Carry warm layers and comfortable boots' : (str_contains($seasonNameLower, 'summer') || str_contains($seasonNameLower, 'warm') ? 'Light cottons, sunscreen, and sunglasses' : 'Layered clothing and comfortable walking shoes'));
                                $seasonHighlight = $season['highlight'] ?? (!empty($seasonActivities) ? ($seasonActivities[0] . ' and scenic local experiences') : 'Balanced weather and flexible sightseeing plans');
                            @endphp
                            <article class="seo-dd-card seo-dd-season-card">
                                <span class="seo-dd-season-icon"><i
                                        class="{{ $season['icon'] ?? 'bi bi-cloud-sun' }}"></i></span>
                                <h3>{{ $seasonName }}</h3>
                                <p class="seo-dd-weather">{{ $seasonWeather }}</p>
                                <div class="seo-dd-badges">
                                    @foreach($seasonActivities as $activity)
                                        <span class="seo-dd-badge">{{ $activity }}</span>
                                    @endforeach
                                </div>
                                <p class="seo-dd-reco">{{ $seasonRecommendation }}</p>
                                <div class="seo-dd-season-details">
                                    <p><strong>Best activities:</strong> {{ $activityLine }}</p>
                                    <p><strong>Packing tip:</strong> {{ $packingTip }}</p>
                                    <p><strong>Crowd level:</strong> {{ $crowdLevel }}</p>
                                    <p><strong>Highlight:</strong> {{ $seasonHighlight }}</p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>

                <section id="blogs" class="seo-dd-section">
                    <div class="seo-dd-title-wrap">
                        <p class="seo-dd-kicker">Content Hub</p>
                        <h2 class="seo-dd-title">Travel Guides & Blogs</h2>
                    </div>
                    @php
                        $blogCards = collect($blogs)->values();
                        if ($blogCards->isNotEmpty() && $blogCards->count() < 5) {
                            $seedBlogs = $blogCards->all();
                            $fillIndex = 1;
                            while ($blogCards->count() < 5) {
                                $clone = $seedBlogs[($fillIndex - 1) % count($seedBlogs)];
                                $clone['title'] = ($clone['title'] ?? 'Travel Guide') . ' ' . $fillIndex;
                                $blogCards->push($clone);
                                $fillIndex++;
                            }
                        }
                    @endphp
                    <div class="seo-dd-card-grid seo-dd-blog-grid">
                        @foreach($blogCards as $index => $blog)
                            @php
                                $isFeaturedBlog = $index < 2;
                                $blogTitle = $blog['title'] ?? 'Travel Guide';
                                $blogDate = !empty($blog['date']) ? \Carbon\Carbon::parse($blog['date'])->format('d M') : '02 May';
                                $blogAuthor = $blog['author'] ?? 'Travel Team';
                                $blogRole = $blog['role'] ?? 'Verified writer';
                                $blogSlug = \Illuminate\Support\Str::slug($blog['slug'] ?? $blogTitle) ?: 'travel-guide';
                                $blogUrl = $blog['url'] ?? route('blog.show', [
                                    'destination' => $destination,
                                    'blog' => $blogSlug,
                                ]);
                            @endphp
                            <a href="{{ $blogUrl }}"
                                class="seo-dd-card seo-dd-blog-card {{ $isFeaturedBlog ? 'is-featured' : 'is-compact' }}">
                                <img src="{{ $mediaUrl($blog['image'] ?? $destinationImage) }}" alt="{{ $blogTitle }}"
                                    loading="lazy">
                                <div class="seo-dd-blog-overlay"></div>
                                <div class="seo-dd-blog-content">
                                    @if($isFeaturedBlog)
                                        <span class="seo-dd-blog-pill">Featured</span>
                                    @endif
                                    <h3>{{ $blogTitle }}</h3>
                                    <p>{{ $blog['excerpt'] ?? '' }}</p>
                                    <div class="seo-dd-blog-meta">
                                        <div class="seo-dd-blog-author">
                                            <span
                                                class="seo-dd-blog-avatar">{{ strtoupper(substr($blogAuthor, 0, 1)) }}</span>
                                            <div>
                                                <strong>{{ $blogAuthor }}</strong>
                                                <small>{{ $blogRole }}</small>
                                            </div>
                                        </div>
                                        <time datetime="{{ $blog['date'] ?? '' }}">{{ $blogDate }}</time>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>

                <section id="testimonials" class="seo-dd-section">
                    <div class="seo-dd-title-wrap seo-dd-testimonial-head">
                        <div>
                            <p class="seo-dd-kicker">Social Proof</p>
                            <h2 class="seo-dd-title">Traveler Testimonials</h2>
                        </div>
                        <div class="seo-dd-testimonial-stats">
                            <span>4.9 Avg Rating</span>
                            <span>2k+ Happy Travelers</span>
                        </div>
                    </div>

                    <div class="swiper seo-dd-swiper" data-swiper-testimonials>
                        <div class="swiper-wrapper">
                            @foreach($testimonials as $testimonial)
                                <article class="swiper-slide seo-dd-card seo-dd-testimonial-card">
                                    <span class="seo-dd-quote-mark">“</span>
                                    <p class="seo-dd-review">{{ $testimonial['review'] ?? ($testimonial['text'] ?? '') }}</p>
                                    <div class="seo-dd-user">
                                        @if(!empty($testimonial['image']))
                                            <img src="{{ $mediaUrl($testimonial['image']) }}" alt="{{ $testimonial['name'] ?? 'Traveler' }}">
                                        @endif
                                        <div class="seo-dd-user-meta">
                                            <h3>{{ $testimonial['name'] ?? 'Traveler' }}</h3>
                                            <p>{{ $testimonial['location'] ?? '' }}</p>
                                        </div>
                                        <p class="seo-dd-stars">★ {{ number_format((float) ($testimonial['rating'] ?? 5), 1) }}</p>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                        <div class="seo-dd-testimonial-controls">
                            <button class="seo-dd-swiper-btn seo-dd-testimonial-prev" type="button"
                                aria-label="Previous testimonial"><i class="bi bi-arrow-left"></i></button>
                            <div class="seo-dd-testimonial-pagination"></div>
                            <button class="seo-dd-swiper-btn seo-dd-testimonial-next" type="button"
                                aria-label="Next testimonial"><i class="bi bi-arrow-right"></i></button>
                        </div>
                    </div>
                </section>

                <section id="faq" class="seo-dd-section" itemscope itemtype="https://schema.org/FAQPage">
                    <div class="seo-dd-title-wrap">
                        <p class="seo-dd-kicker">FAQs</p>
                        <h2 class="seo-dd-title">Frequently Asked Questions</h2>
                    </div>

                    <div class="seo-dd-faq-list">
                        @foreach($faqs as $index => $faq)
                            <article class="seo-dd-faq-item" itemscope itemprop="mainEntity"
                                itemtype="https://schema.org/Question">
                                <button class="seo-dd-faq-btn {{ $index === 0 ? 'is-open' : '' }}" type="button"
                                    data-faq-toggle>
                                    <span itemprop="name">{{ $faq['question'] ?? ($faq['q'] ?? '') }}</span>
                                    <i class="bi bi-plus-lg"></i>
                                </button>
                                <div class="seo-dd-faq-panel {{ $index === 0 ? 'is-open' : '' }}" itemscope
                                    itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                                    <p itemprop="text">{{ $faq['answer'] ?? ($faq['a'] ?? '') }}</p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>

                <section id="related" class="seo-dd-section">
                    <div class="seo-dd-title-wrap">
                        <p class="seo-dd-kicker">Related Packages</p>
                        <h2 class="seo-dd-title">Explore Packages With Similar Travel Style</h2>
                    </div>
                    @if(empty($relatedPackageItems))
                        <article class="seo-dd-card seo-dd-empty-card">
                            <h3>No related packages found</h3>
                            <p>Packages with the same category or travel style will appear here after they are uploaded from admin.</p>
                        </article>
                    @else
                        <div class="seo-dd-card-grid seo-dd-related-grid">
                            @foreach($relatedPackageItems as $related)
                                <a href="{{ $related['url'] ?? '#' }}" class="seo-dd-card seo-dd-related-card">
                                    <img src="{{ $mediaUrl($related['image'] ?? $destinationImage) }}" alt="{{ $related['name'] }}">
                                <div class="seo-dd-card-body">
                                    <h3>{{ $related['name'] }}</h3>
                                    <p>
                                        {{ collect([$related['category'] ?? null, $related['travel_style'] ?? null, $related['duration'] ?? null])->filter()->implode(' • ') }}
                                    </p>
                                    @if(!empty($related['price']))
                                        <strong>{{ $related['price'] }}</strong>
                                    @endif
                                </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </section>
            </main>

            <aside class="seo-dd-sidebar">
                <div class="seo-dd-sidebar-sticky">
                    <article class="seo-dd-card seo-dd-booking-card">
                        <p class="seo-dd-kicker">Book Your Trip</p>
                        <h3>Plan {{ $destination->name }} Vacation</h3>

                        <form action="#" method="POST" class="seo-dd-form">
                            @csrf
                            <label>
                                Travel Month
                                <select name="month">
                                    <option value="">Select month</option>
                                    @foreach($monthOptions ?? ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month)
                                        <option value="{{ $month }}">{{ $month }}</option>
                                    @endforeach
                                </select>
                            </label>

                            <label>
                                Guests
                                <select name="guests">
                                    @for($guest = 1; $guest <= 10; $guest++)
                                        <option value="{{ $guest }}">{{ $guest }} {{ $guest === 1 ? 'Guest' : 'Guests' }}
                                        </option>
                                    @endfor
                                </select>
                            </label>

                            <button type="submit"
                                class="seo-dd-btn seo-dd-btn-primary seo-dd-btn-enquiry seo-dd-btn-block">Send
                                Enquiry</button>
                            <a href="https://wa.me/" target="_blank" rel="noopener"
                                class="seo-dd-btn seo-dd-btn-whatsapp seo-dd-btn-block">WhatsApp Expert</a>
                        </form>
                    </article>

                    <article class="seo-dd-card seo-dd-quick-facts">
                        <h4>Quick Destination Facts</h4>
                        <ul>
                            @foreach($quickFacts as $fact)
                                <li><span>{{ $fact['label'] }}</span><strong>{{ $fact['value'] }}</strong></li>
                            @endforeach
                            <li><span>Rating</span><strong>{{ number_format((float) $destination->rating, 1) }}/5</strong></li>
                        </ul>
                    </article>

                    <article class="seo-dd-card seo-dd-sticky-nav">
                        <h4>On This Page</h4>
                        <nav>
                            <a href="#overview" class="seo-dd-anchor is-active">Overview</a>
                            <a href="#gallery" class="seo-dd-anchor">Gallery</a>
                            <a href="#city-packages" class="seo-dd-anchor">City Packages</a>
                            <a href="#packages" class="seo-dd-anchor">Packages</a>
                            <a href="#besttime" class="seo-dd-anchor">Best Time</a>
                            <a href="#blogs" class="seo-dd-anchor">Blogs</a>
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

    <div class="seo-dd-gallery-modal-panel" role="dialog" aria-modal="true"
        aria-label="{{ $destination->name }} gallery viewer">
        <div class="seo-dd-gallery-modal-top">
            <div>
                <p class="seo-dd-kicker">Gallery Viewer</p>
                <h3>{{ $destination->name }}</h3>
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
                            <img src="{{ $item['image'] }}" alt="{{ $destination->name }} gallery image {{ $loop->iteration }}"
                                loading="lazy">
                            @if($item['label'] !== '')
                                <div class="seo-dd-gallery-slide-caption">
                                    <span>{{ $item['label'] }}</span>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <button type="button" class="seo-dd-gallery-nav seo-dd-gallery-nav-next" aria-label="Next image">
                <i class="bi bi-arrow-right"></i>
            </button>
        </div>

        <div class="seo-dd-gallery-modal-footer">
            <span>Swipe or use arrows to explore all {{ count($galleryItems) }} images</span>
        </div>
    </div>
</div>
@endif

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const readMoreContent = document.querySelector('[data-seo-readmore]');
            const readMoreToggle = document.querySelector('[data-seo-toggle]');

            if (readMoreContent && readMoreToggle) {
                readMoreToggle.addEventListener('click', function () {
                    const isExpanded = readMoreContent.classList.toggle('is-expanded');
                    readMoreContent.classList.toggle('is-collapsed', !isExpanded);
                    readMoreToggle.textContent = isExpanded ? 'Read Less' : 'Read More';
                    readMoreToggle.setAttribute('aria-expanded', isExpanded ? 'true' : 'false');
                });
            }

            document.querySelectorAll('.seo-dd-anchor').forEach(function (anchor) {
                anchor.addEventListener('click', function (event) {
                    const target = document.querySelector(anchor.getAttribute('href'));
                    if (!target) {
                        return;
                    }
                    event.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                });
            });

            document.querySelectorAll('[data-seo-offcanvas-anchor]').forEach(function (anchor) {
                anchor.addEventListener('click', function () {
                    const offcanvasElement = anchor.closest('.offcanvas');
                    if (!offcanvasElement || typeof bootstrap === 'undefined' || !bootstrap.Offcanvas) {
                        return;
                    }
                    const offcanvasInstance = bootstrap.Offcanvas.getOrCreateInstance(offcanvasElement);
                    offcanvasInstance.hide();
                });
            });

            const sections = Array.from(document.querySelectorAll('#overview, #gallery, #city-packages, #packages, #besttime, #blogs, #faq'));
            const anchors = Array.from(document.querySelectorAll('.seo-dd-anchor'));

            if (sections.length && anchors.length && 'IntersectionObserver' in window) {
                const observer = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (!entry.isIntersecting) {
                            return;
                        }
                        const activeId = '#' + entry.target.id;
                        anchors.forEach(function (anchor) {
                            anchor.classList.toggle('is-active', anchor.getAttribute('href') === activeId);
                        });
                    });
                }, {
                    rootMargin: '-35% 0px -55% 0px',
                    threshold: 0.1,
                });

                sections.forEach(function (section) {
                    observer.observe(section);
                });
            }

            document.querySelectorAll('[data-faq-toggle]').forEach(function (toggle) {
                toggle.addEventListener('click', function () {
                    const panel = toggle.nextElementSibling;
                    const isOpen = panel.classList.contains('is-open');

                    document.querySelectorAll('.seo-dd-faq-btn').forEach(function (btn) {
                        btn.classList.remove('is-open');
                    });
                    document.querySelectorAll('.seo-dd-faq-panel').forEach(function (item) {
                        item.classList.remove('is-open');
                    });

                    if (!isOpen) {
                        toggle.classList.add('is-open');
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

                const testimonialSwiperElement = document.querySelector('[data-swiper-testimonials]');
                if (testimonialSwiperElement) {
                    new Swiper(testimonialSwiperElement, {
                        slidesPerView: 1.08,
                        centeredSlides: true,
                        spaceBetween: 18,
                        loop: true,
                        speed: 700,
                        autoplay: {
                            delay: 3200,
                            disableOnInteraction: false,
                        },
                        navigation: {
                            nextEl: '.seo-dd-testimonial-next',
                            prevEl: '.seo-dd-testimonial-prev',
                        },
                        pagination: {
                            el: '.seo-dd-testimonial-pagination',
                            clickable: true,
                        },
                        breakpoints: {
                            768: { slidesPerView: 1.8, centeredSlides: false },
                            1200: { slidesPerView: 2.35, centeredSlides: false }
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
        'mainEntity' => array_map(function ($faq) {
            return [
                '@type' => 'Question',
                'name' => $faq['question'] ?? ($faq['q'] ?? ''),

'acceptedAnswer' => [
    '@type' => 'Answer',
    'text' => $faq['answer'] ?? ($faq['a'] ?? ''),
],
            ];
        }, $faqs),
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
                        </script>
@endpush
